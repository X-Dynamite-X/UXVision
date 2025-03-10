<script setup lang="ts">
defineProps<{
    nameFeild: string;
}>();
</script>

<template>
    <!-- <thead>
        <tr class="border-b border-border/50 bg-muted/50 transition-colors hover:bg-muted/80">
            <th v-for="column in columnsName" :key="column.id" class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                {{ column.name }}
            </th>
        </tr>
    </thead> -->
    <th
    class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"    >
        {{ nameFeild }}
    </th>
</template>
