<template>
    <n-grid item-responsive>
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
<script setup>ref
import { h, ref, onMounted } from 'vue';
import { NGi, NGrid, NSpace } from 'naive-ui';
import { DownloadOutlined, SearchFilled } from '@vicons/material';
import { NDataTable, NButton, NIcon } from 'naive-ui';
import DownloaderProgress from './DownloaderProgress.vue';

const data = ref([]);
const isPreparingTable = ref(false);

const columns = ref([
    {
        title: 'Resource',
        key: 'key',
        width: '10%', // Equivalent to col-md-4 (1/3 of the row)
    },
    {
        title: 'URL',
        key: 'url',
        width: '30%', // Equivalent to col-md-4 (1/3 of the row)
    },
    {
        title: 'Progress',
        key: 'progress',
        align: 'center',
        width: '40%',
        render: (row) => h(DownloaderProgress, { stored: row.stored, total: row.total, message: row.message }),
    },
    {
        title: 'Actions',
        key: 'actions',
        align: 'right',
        width: '20%',
        render: (row) => {
            return h(NSpace,
                { align: 'center', justify: 'end', size: 'small' },
                { default: () => 
                    [
                        h(NButton, 
                            { type: 'info', loading: row.discovering, disabled: row.discovering || row.discovered, onClick: async () => await fetchAllResources(row) }, 
                            { default: () => h('span', null, 'Discover'), icon: renderIcon(SearchFilled) }
                        ),
                        h(NButton, 
                            { type: 'success', loading: row.downloading, disabled: !row.discovered || row.downloading || row.downloaded, onClick: async () => await storeResources(row) }, 
                            { default: () => h('span', null, 'Download'), icon: renderIcon(DownloadOutlined) }
                        ),
                    ]
                }
            );
        },
    },
]);

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}

async function fetchAllResources(row = null, offset = 0, limit = 20) {
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

async function storeResources(row) {
    displayRowMessage(row, `Downloading resources for: ${row.key}`, 'info');
    if (!row.key || row.resources.length === 0) {
        displayRowMessage(row, `No resources to download for resource: ${row.key}.`, 'warn');
        return;
    }
    
    row.downloading = true; // Set the downloading state to true

    try {
        while (row.resources.length || row.next) {
            await processResource(row); // Process each resource sequentially
            if (row.resources.length === 0 && row.next) {
                const urlParams = new URLSearchParams(row.next.split('?')[1]);
                const offset = urlParams.get('offset');
                const limit = urlParams.get('limit');
                await fetchAllResources(row, offset, limit); // Fetch the next set of resources
            }
        }
        
        row.downloaded = true; // Mark the row as fully downloaded
        displayRowMessage(row, `Downloads completed for: ${row.key}`, 'info');
    } catch (error) {
        console.error('Error downloading resources:', error);
    } finally {
        row.downloading = false; // Reset the downloading state
    }
}

async function processResource(row) {
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
        // Add logic to store or process the fetched data here
        if (data.processed) {
            row.stored += 1; // Increment the stored count
            displayRowMessage(row, `Resource: ${type} ${id} processed successfully.`, 'info');
        } else {
            row.resources.unshift(resource); // Re-add the resource to the queue if not processed
            displayRowMessage(row, `Resource: ${type} ${id} was not processed and will be re-queued.`, 'warn');
        }
    } catch (error) {
        console.error(`Error processing resource: ${type} ${id}`, error);
        throw error; // Re-throw the error to stop the queue if needed
    }
}

function handleAllResources(result) {
    data.value = result.map(item => ({
        key: item.key,
        url: item.url,
        total: 0,
        stored: 0,
        resources: [],
        next: null,
        discovering: false,
        discovered: false,
        downloading: false,
        downloaded: false,
        message: null
    }));
};

function handleSpecificResources(result, row) {
    row.total = result.count;
    row.resources.push(...result.results);
    row.next = result.next;
    row.discovered = true;
};

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