<template>
    <n-grid item-responsive>
        <n-gi v-if="totalCount" span="6">
            {{ importCount }} / {{ totalCount }}
        </n-gi>
        <n-gi span="18">
            <n-p :italic="true" :depth="3">{{ progressMessage }}</n-p>
        </n-gi>
        <n-gi span="24">
            <n-progress
                v-if="showProgress"
                :percentage="progressPercentage"
                :show-indicator="false"
                type="line"
            ></n-progress>
        </n-gi>
    </n-grid>
</template>
<script setup>
import { NGi, NGrid, NP, NProgress } from 'naive-ui';
import { computed } from 'vue';

const props = defineProps({
    importCount: {
        type: Number,
        default: 0,
    },
    totalCount: {
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
    return props.totalCount > 0;
});

const progressPercentage = computed(() => {
    return props.importCount / props.totalCount * 100;
});
</script>