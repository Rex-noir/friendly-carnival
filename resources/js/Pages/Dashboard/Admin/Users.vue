<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { Pagination, User } from "@/types/users.interface";
import { onMounted, ref } from "vue";

const usersData = usePage().props.users as Pagination<User>;
const users = ref();
onMounted(() => {
    users.value = usersData.data as User[];
});
</script>
<template>
    <div class="card mt-4">
        <DataTable :value="users" tableStyle="min-width: fit-content">
            <Column field="id" header="Id" style="width: 3%"></Column>
            <Column
                field="name"
                header="Name"
                style="width: fit-content"
            ></Column>
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
