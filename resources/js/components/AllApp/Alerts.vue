<script setup lang="ts">
interface AlertProps {
    title: 'success' | 'error' | 'warning' | 'info';
    message: string;
}

defineProps<AlertProps>();
</script>

<template>
    <div class="rounded-md p-4" :class="{
        'bg-green-50 dark:bg-green-900/10': title === 'success',
        'bg-red-50 dark:bg-red-900/10': title === 'error',
        'bg-yellow-50 dark:bg-yellow-900/10': title === 'warning',
        'bg-blue-50 dark:bg-blue-900/10': title === 'info'
    }">
        <div class="flex">
            <div class="flex-shrink-0">
                <!-- Success Icon -->
                <span v-if="title === 'success'" class="text-green-400">✓</span>
                <!-- Error Icon -->
                <span v-if="title === 'error'" class="text-red-400">✕</span>
                <!-- Warning Icon -->
                <span v-if="title === 'warning'" class="text-yellow-400">⚠</span>
                <!-- Info Icon -->
                <span v-if="title === 'info'" class="text-blue-400">ℹ</span>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium" :class="{
                    'text-green-800 dark:text-green-200': title === 'success',
                    'text-red-800 dark:text-red-200': title === 'error',
                    'text-yellow-800 dark:text-yellow-200': title === 'warning',
                    'text-blue-800 dark:text-blue-200': title === 'info'
                }">
                    {{ message }}
                </p>
            </div>
        </div>
    </div>
</template>
