<script setup lang="ts">
defineProps<{
    item: object;
    columns: array[]; // تعريف الأعمدة
}>();
</script>

<template>


    <tr class="border-b border-border/50 transition-colors hover:bg-muted/50">
        <td
            class="p-4 align-middle text-muted-foreground"
            v-for="column in columns.filter((col) => col.showInTabel)"
            :key="column.key"
            :id="column.key"
        >
            <slot :name="`column-${column.key}`" :item="item" :field="column.key">
                <!-- العرض الافتراضي إذا لم يكن هناك slot -->
                {{ item[column.key] }}
            </slot>
        </td>
        <td   class="p-4 align-middle text-muted-foreground">
            <slot name="column-actions" :item="item"></slot>
        </td>
    </tr>
</template>
