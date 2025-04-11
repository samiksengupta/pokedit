<template>
    <n-card title="POKEDIT">
        <n-menu 
            :options="menuItems"
            :default-value="['home']"
            :collapsed="false"
            :collapsed-width="80"
            :width="200"
            :icon-size="20"
            :show-icon="true"
            mode="horizontal">
        </n-menu>
        <n-card>
            <router-view></router-view>
        </n-card>
    </n-card>
</template>
<script setup>

import { NCard, NIcon, NMenu } from 'naive-ui';
import { h } from 'vue';
import { RouterLink } from 'vue-router';
import { HomeOutlined, DownloadOutlined, EditOutlined } from '@vicons/material'

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}

const menuItems = [
    { 
        label: () => h(RouterLink, {
                to: '/'
            }, {
               default: () => 'Home' 
            }),
        key: 'home',
        icon: renderIcon(HomeOutlined),
    },
    { 
        label: () => h(RouterLink, {
                to: '/downloader'
            }, {
               default: () => 'Downloader' 
            }),
        key: 'home',
        icon: renderIcon(DownloadOutlined),
    },
    { 
        label: () => h(RouterLink, {
                to: '/editor'
            }, {
               default: () => 'Editor' 
            }),
        key: 'home',
        icon: renderIcon(EditOutlined),
    },
];
</script>