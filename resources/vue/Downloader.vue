<template>
    <n-grid item-responsive>
        <n-gi span="24">
            <n-data-table
                :columns="columns"
                :data="data"
                :bordered="true"
                :loading="isTableDownloading"
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
const isTableDownloading = ref(false);

const columns = ref([
    {
        title: 'Resource',
        key: 'resource',
    },
    {
        title: 'URL',
        key: 'url',
    },
    {
        title: 'Progress',
        key: 'progress',
        align: 'center',
        render: (row) => h(DownloaderProgress, { stored: row.stored, records: row.records, message: null }),
    },
    {
        title: 'Actions',
        key: 'actions',
        align: 'right',
        render: (row) => {
            return h(NSpace,
                { align: 'center', justify: 'end', size: 'small' },
                { default: () => 
                    [
                        h(NButton, 
                            { type: 'info', loading: row.discovering, disabled: row.discovered, onClick: fetchAllResources.bind(null, row) }, 
                            { default: () => h('span', null, 'Discover'), icon: renderIcon(SearchFilled) }
                        ),
                        h(NButton, 
                            { type: 'success', loading: row.downloading, disabled: !row.discovered }, 
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

async function fetchAllResources(row = null) {
    isTableDownloading.value = true;
    if (row) {
        row.discovering = true;
    }
    try {
        const url = row ? `/api/pokeapi/resources?type=${row.resource}` : '/api/pokeapi/resources';
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
        isTableDownloading.value = false;
    }
}

function handleAllResources(result) {
    data.value = result.map(item => ({
        resource: item.key,
        url: item.url,
        records: 0,
        stored: 0,
        resources: [],
        discovering: false,
        discovered: false,
        downloading: false,
        downloaded: false,
    }));
};

function handleSpecificResources(result, row) {
   row.records = result.count;
   row.resources = result.resources;
   row.discovered = true;
};

onMounted(fetchAllResources);
</script>