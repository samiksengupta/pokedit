<template>
    <n-grid item-responsive>
        <n-gi v-if="total" span="24">
            {{ stored }} / {{ total }}
        </n-gi>
        <n-gi span="24">
            <n-progress
                v-if="showProgress"
                :percentage="progressPercentage"
                :show-indicator="false"
                type="line"
            ></n-progress>
        </n-gi>
        <n-gi span="24">
            <n-p :italic="true" :depth="3">{{ progressMessage }}</n-p>
        </n-gi>
    </n-grid>
</template>
<script setup>
import { NGi, NGrid, NP, NProgress } from 'naive-ui';
import { computed } from 'vue';

const props = defineProps({
    stored: {
        type: Number,
        default: 0,
    },
    total: {
        type: Number,
        default: 0,
    },
    message: {
        type: String,
        default: null,
    },
});

const progressMessage = computed(() => {
    if (props.message) {
        return props.message;
    }

    if (showProgress.value) {
        return 'Ready to download';
    }

    return 'Discovery pending';
});

const showProgress = computed(() => {
    return props.total > 0;
});

const progressPercentage = computed(() => {
    return props.stored / props.total * 100;
});
</script>