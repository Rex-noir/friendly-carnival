<script setup lang="ts">
import DataTable, { DataTableRowClickEvent } from "primevue/datatable";
import Column from "primevue/column";
import { User } from "@/types/users.interface";
import { ref } from "vue";
import Card from "primevue/card";
import Button from "primevue/button";

const props = defineProps<{
    users: User[] | User[][];
}>();

const expandedRows = ref<User[]>([]);

const rowClicked = (e: DataTableRowClickEvent) => {
    const id = e.data.id;
    const index = expandedRows.value.findIndex((row) => row.id === id);

    if (index !== -1) {
        expandedRows.value.splice(index, 1);
    } else {
        expandedRows.value.push(e.data);
    }
};
</script>
<template>
    <div>
        <DataTable
            showGridLines
            v-model:expandedRows="expandedRows"
            :value="props.users"
            ripple
            @row-click="rowClicked"
            tableStyle="min-width: fit-content"
        >
            <Column field="id" header="Id" style="width: 3%">
                <template #body="row">
                    <span
                        class="font-bold"
                        :class="
                            expandedRows.findIndex(
                                (r) => r.id === row.data.id
                            ) !== -1
                                ? 'text-red-500'
                                : ''
                        "
                        >{{ row.data.id }}</span
                    >
                </template>
            </Column>
            <Column
                field="name"
                header="Name"
                style="width: fit-content"
            ></Column>
            <Column ripple expander style="width: 5rem">
                <template #body="row">
                    <span class="material-symbols-outlined">{{
                        expandedRows.findIndex((r) => r.id === row.data.id) !==
                        -1
                            ? "keyboard_arrow_down"
                            : "chevron_right"
                    }}</span>
                </template></Column
            >
            <template #expansion="user">
                <Card class="border dark:border-slate-50 p-0">
                    <template #title>{{ user.data.name }}</template>
                    <template #content
                        ><div class="grid gap-3 w-full grid-cols-2">
                            {{ user.data.email }}
                            <Button
                                rounded
                                class="!p-2 col-start-1"
                                :label="`Ban`"
                                severity="warning"
                            />
                            <Button
                                rounded
                                class="!p-2 col-start-2"
                                :label="`Delete`"
                                severity="danger"
                            />
                        </div>
                    </template>
                </Card>
            </template>
        </DataTable>
    </div>
</template>
