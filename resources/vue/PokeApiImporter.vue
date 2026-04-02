<template>
    <n-grid item-responsive gutter="16" x-gap="16" y-gap="16">
        <n-gi span="24" >
            <n-card>
                <n-space align="center" justify="end" size="small">
                    <n-button
                        type="info"
                        :loading="isDiscovering"
                        :disabled="isDiscovering || isImporting || isPreparingTable"
                        @click="batchProcessDiscovery()"
                    >
                        <template #icon>
                            <n-icon><search-filled/></n-icon>
                        </template>
                        Discover
                    </n-button>
                    <n-button
                        type="success"
                        :loading="isImporting"
                        :disabled="isImporting || isDiscovering || isPreparingTable"
                        @click="batchProcessImport()"
                    >
                        <template #icon>
                            <n-icon><download-outlined/></n-icon>
                        </template>
                        Import
                    </n-button>
                </n-space>
            </n-card>
        </n-gi>
        <n-gi span="24">
            <n-data-table
                :columns="columns"
                :data="data"
                :bordered="true"
                :loading="isPreparingTable"
            ></n-data-table>
        </n-gi>
    </n-grid>
</template>
<script setup>
import { h, ref, onMounted } from 'vue';
import { NCard, NCheckbox, NGi, NGrid, NSpace } from 'naive-ui';
import { CheckCircleFilled, CircleOutlined, DownloadOutlined, SearchFilled } from '@vicons/material';
import { NDataTable, NButton, NIcon } from 'naive-ui';
import ImporterProgress from './ImporterProgress.vue';

const isPreparingTable = ref(false);
const isDiscovering = ref(false);
const isImporting = ref(false);
const data = ref([]);
const columns = ref([
    {
        title: '',
        type: 'selection',
        key: 'select',
        width: '5%',
        render: (row) => h(NCheckbox, { checked: row.selected, onUpdateChecked: (checked) => { row.selected = checked; } }, {
            
        }),
    },
    {
        title: 'Resource',
        key: 'key',
        width: '15%',
    },
    {
        title: 'URL',
        key: 'url',
        width: '30%',
    },
    {
        title: 'Progress',
        key: 'progress',
        width: '45%',
        render: (row) => h(ImporterProgress, { importCount: row.importCount, totalCount: row.totalCount, message: row.message }),
    },
    {
        title: '',
        key: 'status',
        align: 'center',
        width: '5%',
        render: (row) => {
            return getStatusIcon(row);
        },
    },
]);

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}

async function batchProcessDiscovery() {
    const selectedRows = data.value.filter(row => row.selected);
    if (selectedRows.length === 0) {
        displayRowMessage(null, 'No resources selected for discovery.', 'warn');
        return;
    }
    
    isDiscovering.value = true;
    try {
        for (const row of selectedRows) {
            await fetchAllResources(row); // Fetch resources for each selected row
        }
    } catch (error) {
        console.error('Error during batch discovery:', error);
    } finally {
        isDiscovering.value = false;
    }
}

async function batchProcessImport() {
    const selectedRows = data.value.filter(row => row.selected && row.discovered);
    if (selectedRows.length === 0) {
        displayRowMessage(null, 'No resources ready for import.', 'warn');
        return;
    }
    
    isImporting.value = true;
    try {
        for (const row of selectedRows) {
            await importResources(row); // Import resources for each selected row
        }
    } catch (error) {
        console.error('Error during batch import:', error);
    } finally {
        isImporting.value = false;
    }
}

async function fetchAllResources(row = null, offset = 0, limit = 20, deleteResource = false) {
    if (row) {
        row.discovering = true;
    } else {
        isPreparingTable.value = true;
    }
    try {
        const url = row ? `/api/pokeapi/resources?type=${row.key}&offset=${offset}&limit=${limit}` : '/api/pokeapi/resources';
        const response = await fetch(url);
        const result = await response.json();
        
        if (row) {
            row.discovering = false;
            handleSpecificResources(result, row);
        } else {
            handleAllResources(result);
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    } finally {
        if (!row) {
            isPreparingTable.value = false;
        }
    }
}

async function importResources(row) {
    displayRowMessage(row, `importing resources for: ${row.key}`, 'info');
    if (!row.key || row.resources.length === 0) {
        displayRowMessage(row, `No resources to import for resource: ${row.key}.`, 'warn');
        return;
    }
    
    row.importing = true; // Set the importing state to true

    try {
        while (row.resources.length || row.next) {
            await importResource(row); // import each resource sequentially
            if (row.resources.length === 0 && row.next) {
                const urlParams = new URLSearchParams(row.next.split('?')[1]);
                const offset = urlParams.get('offset');
                const limit = urlParams.get('limit');
                await fetchAllResources(row, offset, limit); // Fetch the next set of resources
            }
        }
        
        row.imported = true; // Mark the row as fully imported
        displayRowMessage(row, `Imports completed for: ${row.key}`, 'info');
    } catch (error) {
        console.error('Error importing resources:', error);
    } finally {
        row.importing = false; // Reset the importing state
    }
}

async function importResource(row) {
    const type = row.key;
    const resource = row.resources.shift();

    try {
        const id = resource.id;
        const url = `/api/pokeapi/resources/${type}/${id}`;
        const response = await fetch(url); // Fetch the resource data
        if (!response.ok) {
            throw new Error(`Failed to fetch resource: ${type} ${id}`);
        }
        const data = await response.json();
        
        // Add logic to store or import the fetched data here
        if (data.imported) {
            row.importCount += 1; // Increment the importCount
            displayRowMessage(row, `Resource: ${type} ${id} imported.`, 'info');
        } else {
            // row.resources.unshift(resource); // Re-add the resource to the queue if not imported
            displayRowMessage(row, `Resource: ${type} ${id} was not imported and will be re-queued.`, 'warn');
        }
    } catch (error) {
        console.error(`Error importing resource: ${type} ${id}`, error);
        throw error; // Re-throw the error to stop the queue if needed
    }
}

async function deleteResource(row) {
    displayRowMessage(row, `Deleting resources for: ${row.key}`, 'info');
    const url = `/api/pokeapi/resources/${row.key}`;
    await fetch(url, {
        method: 'DELETE',
    });
}

function handleAllResources(result) {
    data.value = result.map(item => ({
        key: item.key,
        url: item.url,
        totalCount: 0,
        importCount: 0,
        resources: [],
        next: null,
        selected: true,
        discovering: false,
        discovered: false,
        importing: false,
        imported: false,
        message: null
    }));
};

function handleSpecificResources(result, row) {
    row.totalCount = result.count;
    row.resources.push(...result.results);
    row.next = result.next;
    row.discovered = true;
    displayRowMessage(row, `Import pending`, 'info');
};

function getStatusIcon(row) {
    const color = row.discovered ? 'green' : 'grey';
    const IconComponent = row.totalCount === 0 || row.importCount < row.totalCount ? CircleOutlined : CheckCircleFilled;
    return h(NIcon, { color: color }, { default: () => h(IconComponent) });
}

function displayRowMessage(row, message, logLevel = 'info') {
    if (logLevel === 'info') {
        console.info(message);
    } else if (logLevel === 'warn') {
        console.warn(message);
    } else if (logLevel === 'error') {
        console.error(message);
    }
    row.message = message;
}

onMounted(fetchAllResources);
</script>