<template>
    <n-space vertical>
        <n-button
            type="warning"
            :loading="isClearingCache"
            :disabled="isClearingCache"
            @click="clearCache()"
        >
            <template #icon>
                <n-icon><delete-sweep-outlined /></n-icon>
            </template>
            Clear PokeAPI Cache
        </n-button>
        <n-button
            type="error"
            :loading="isDeleting"
            :disabled="isDeleting"
            @click="deleteDatabase()"
        >
            <template #icon>
                <n-icon><delete-forever-outlined /></n-icon>
            </template>
            Reset Database
        </n-button>
    </n-space>
</template>

<script setup>
import { DeleteSweepOutlined, DeleteForeverOutlined } from '@vicons/material';
import { NButton, NIcon, NSpace, useDialog, useMessage } from 'naive-ui';
import { ref } from 'vue';

const isClearingCache = ref(false);
const isDeleting = ref(false);
const dialog = useDialog();
const message = useMessage();

function clearCache() {
    // TODO: Implement cache clearing logic
}

function deleteDatabase() {
    dialog.warning({
        title: 'Confirm Database Reset',
        content: 'Are you sure you want to reset the database? This will delete all imported Pokémon data and cannot be undone.',
        positiveText: 'Yes, Reset It',
        negativeText: 'Cancel',
        onPositiveClick: async () => {
            isDeleting.value = true;
            try {
                const response = await fetch('/api/database/reset', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Failed to reset database.');
                }

                const result = await response.json();
                message.success(result.message);
            } catch (error) {
                console.error('Error resetting database:', error);
                message.error(error.message || 'Failed to reset the database.');
            } finally {
                isDeleting.value = false;
            }
        },
        onNegativeClick: () => {
            message.info('Database reset cancelled.');
        }
    });
}
</script>