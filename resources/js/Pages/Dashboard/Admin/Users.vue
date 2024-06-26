<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import DataTable, { DataTableRowClickEvent } from "primevue/datatable";
import Column from "primevue/column";
import { Pagination, User } from "@/types/users.interface";
import { onMounted, ref, watch } from "vue";
import Card from "primevue/card";
import Button from "primevue/button";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";

const usersData = usePage().props.users as Pagination<User>;
const users = ref();
const expandedRows = ref<User[]>([]);
const searchModel = ref();

const rowClicked = (e: DataTableRowClickEvent) => {
    const id = e.data.id;
    const index = expandedRows.value.findIndex((row) => row.id === id);

    if (index !== -1) {
        expandedRows.value.splice(index, 1); // Remove the item if found
    } else {
        expandedRows.value.push(e.data); // Add the item if not found
    }
};

onMounted(() => {
    users.value = usersData.data as User[];
});
</script>
<template>
    <div class="card mt-2 mx-auto md:w-[50%]">
        <div class="mb-2 p-2">
            <IconField>
                <InputIcon>
                    <svg
                        class="animate-spin h-5 w-5 mr-3 text-red-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.963 7.963 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                </InputIcon>
                <InputText
                    placeholder="Search with ID or Name"
                    v-model="searchModel"
                />
            </IconField>
        </div>
        <DataTable
            showGridLines
            v-model:expandedRows="expandedRows"
            :value="users"
            ripple
            @row-click="rowClicked"
            tableStyle="min-width: fit-content"
        >
            <Column field="id" header="Id" style="width: 3%"> </Column>
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
                            Email : {{ user.data.email }}
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
    <div class="w-full">
        <div class="flex justify-center p-3 text-lg gap-3">
            <Link
                v-for="links in usersData.links"
                v-html="links.label"
                :href="
                    links.url
                        ? links.url
                        : 'http://127.0.0.1:8000/dashboard?page=1'
                "
                class="hover:text-green-500"
                :class="links.active ? 'text-red-500' : ''"
            ></Link>
        </div>
    </div>
</template>
