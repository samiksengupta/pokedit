<template>
    <n-config-provider :theme="darkTheme">
        <n-dialog-provider>
            <n-message-provider>
                <n-card class="fullscreen-card">
                    <app-menu></app-menu>
                    <n-card>
                        <router-view></router-view>
                    </n-card>
                </n-card>
            </n-message-provider>
        </n-dialog-provider>
    </n-config-provider>
</template>
<script setup>
import { darkTheme, NCard, NConfigProvider, NDialogProvider, NMessageProvider } from 'naive-ui';
import AppMenu from './AppMenu.vue';
</script>
<style>
.fullscreen-card {
    height: 100vh; /* Full viewport height */
    width: 100vw;  /* Full viewport width */
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
</style>