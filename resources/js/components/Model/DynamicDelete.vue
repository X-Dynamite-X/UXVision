<script setup lang="ts">
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { defineEmits, defineProps } from 'vue';

interface Props {
    show: boolean;
    title: string;
    data?: object;
}

const props = defineProps<Props>();

const emit = defineEmits<{ (e: 'delete', id: number): void; (e: 'close'): void }>();

// Functions
const closeModal = () => {
    emit('close');
};
const deleteUser = (id) => {
    emit('delete', id);
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg shadow-xl transition-all">
                <Card class="rounded-xl">
                    <CardHeader class="px-10 pb-0 pt-8 text-center">
                        <CardTitle class="text-xl">{{ title }}</CardTitle>
                        <CardDescription v-if="description">
                            {{ description }}
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="px-10 py-8">
                        <div class="flex flex-col gap-6">
                            <div class="grid gap-6">
                                <div class="grid gap-2">
                                    <slot name="message" :data="data"></slot>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                    <CardFooter class="border-t-2 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button
                            type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-gray-600 dark:text-gray-100 dark:hover:bg-gray-500 sm:mt-0 sm:w-auto"
                            @click="closeModal()"
                        >
                            No, cancel
                        </button>
                        <button
                            type="button"
                            class="mx-1 mt-3 inline-flex w-full justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-red-700 dark:text-gray-100 sm:mt-0 sm:w-auto"
                            @click="deleteUser(data.id)"
                        >
                            Yes, I'm sure
                        </button>
                    </CardFooter>
                </Card>
            </div>
        </div>
    </div>
</template>
