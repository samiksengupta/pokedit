<template>
    <n-grid item-responsive>
        <n-gi span="24">
            <n-data-table
                :columns="columns"
                :data="data"
                :bordered="true"
            ></n-data-table>
        </n-gi>
    </n-grid>
</template>
<script setup>
import { h } from 'vue';
import { NGi, NGrid } from 'naive-ui';
import { DownloadOutlined } from '@vicons/material';
import { NDataTable, NButton, NIcon } from 'naive-ui';

const columns = [
    {
        title: 'Name',
        key: 'name',
    },
    {
        title: 'Type',
        key: 'type',
    },
    {
        title: 'Actions',
        key: 'actions',
        align: 'right',
        render: (row) => h(
            NButton, 
            { type: 'success', loading: row.loading }, 
            { default: () => "Download", icon: renderIcon(DownloadOutlined) }
        ),
    },
];

const data = [
    { name: 'Species A', type: 'species', loading: false },
    { name: 'Species B', type: 'species', loading: false },
    { name: 'Species C', type: 'species', loading: false },
    { name: 'Species D', type: 'species', loading: false },
    { name: 'Species E', type: 'species', loading: false },
];

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}
</script>