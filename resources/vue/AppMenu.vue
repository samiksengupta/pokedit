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
import { HomeOutlined, DownloadOutlined, EditOutlined, SettingsOutlined, StorageOutlined } from '@vicons/material'

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
        label: 'Importer',
        key: 'pokeapi-importer',
        icon: renderIcon(DownloadOutlined),
        to: '/importer/pokeapi',
    },
    { 
        label: 'Editor',
        key: 'editor',
        icon: renderIcon(EditOutlined),
        to: '/editor',
    },
    { 
        label: 'Data Manager',
        key: 'data-manager',
        icon: renderIcon(StorageOutlined),
        to: '/data-manager',
    },
    { 
        label: 'Settings',
        key: 'settings',
        icon: renderIcon(SettingsOutlined),
        to: '/settings',
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