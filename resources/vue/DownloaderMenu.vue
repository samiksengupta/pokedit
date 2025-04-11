<template>
    <n-menu 
        :options="menuItems"
        :default-value="defaultMenuItem"
        @update:value="handleMenuClick">
    </n-menu>
</template>
<script setup>
import { NMenu } from 'naive-ui';
import { useRouter } from 'vue-router';

const router = useRouter();

const defaultMenuItem = 'species';

const menuItems = [
    { label: 'Species', key: 'species' },
    { label: 'Items', key: 'items' },
    { label: 'Abilities', key: 'abilities' },
];

// Handle menu click to update the query parameter
function handleMenuClick(key) {
    router.push({ path: '/downloader', query: { type: key } });
}
</script>