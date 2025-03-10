<script setup lang="ts">
import Tbody from './Tbody.vue';
import Thedar from './Thedar.vue';

defineProps<{
    data: array[];
    columnsName: array[];
}>();
</script>

<template>
    <table class="w-full border-collapse text-sm">
        <Thedar :columnsName="columnsName" />
        <Tbody :dataRow="data" />
    </table>
</template>
