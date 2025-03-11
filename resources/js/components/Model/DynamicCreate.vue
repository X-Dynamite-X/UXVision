<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { defineEmits, defineProps } from 'vue';
// Props
interface Props {
    show: boolean;
    title: string;
    columns: Column[];
    data: Record<string, any> | null;

    errors: Record<string, string> | null;
}
const props = defineProps<Props>();

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'create', data: Record<string, any>): void;
}>();

const closeModal = () => {
    emit('close');
};

const createModal = () => {
    console.log( props.data);

    emit('create',  props.data);
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
                                    <div v-for="column in columns" :key="column.key">
                                        <Label v-if="column.key !== 'id' && column.showInCreate">{{ column.label }}</Label>
                                        <Input
                                            v-if="column.key !== 'id' && column.showInCreate"
                                            :defaultValue="data[column.key]"
                                            :modelValue="data[column.key] "
                                            :placeholder="column.placeholder"
                                            :required="column.required"
                                            :autocomplete="column.autocomplete"
                                            :disabled="column.disabled"
                                            :type="column.type"
                                            @update:modelValue="(value) => (data[column.key] = value)"

                                        />
                                        <InputError :message="errors?.[column.name]" v-if="errors?.[column.name]" />
                                    </div>
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
                            Cancel
                        </button>
                        <button
                            type="button"
                            class="mx-1 mt-3 inline-flex w-full justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-green-700 dark:text-gray-100 sm:mt-0 sm:w-auto"
                            @click="createModal()"
                        >
                            Create
                        </button>
                    </CardFooter>
                </Card>
            </div>
        </div>
    </div>
</template>
