<template>
    <n-menu 
        :options="menuItems"
        :default-value="defaultMenuItem"
        :collapsed="false"
        :collapsed-width="80"
        :width="200"
        :icon-size="20"
        :show-icon="true"
        mode="horizontal"
        @update:value="handleMenuClick">
    </n-menu>
</template>
<script setup>

import { h, ref } from 'vue';
import { useRouter } from 'vue-router';
import { NIcon, NMenu } from 'naive-ui';
import { HomeOutlined, DownloadOutlined, EditOutlined } from '@vicons/material'

const defaultMenuItem = 'home';

const router = useRouter();

const menuItems = [
    {
        label: 'Home',
        key: 'home',
        icon: renderIcon(HomeOutlined),
        to: '/',
    },
    { 
        label: 'Downloader',
        key: 'downloader',
        icon: renderIcon(DownloadOutlined),
        to: '/downloader',
    },
    { 
        label: 'Editor',
        key: 'editor',
        icon: renderIcon(EditOutlined),
        to: '/editor',
    },
];

const currentTitle = ref(menuItems.find(item => item.key === defaultMenuItem).label);

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}

function handleMenuClick(key) {
    const selectedItem = menuItems.find(item => item.key === key);
    if (selectedItem) {
        currentTitle.value = selectedItem.label;
        router.push(selectedItem.to);
    }
}
</script>