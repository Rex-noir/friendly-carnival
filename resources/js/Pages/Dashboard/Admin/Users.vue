<script setup lang="ts">
import { Pagination } from "@/types/page.types";
import { onMounted, ref } from "vue";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";
import UserUtils from "@/utils/user";
import { debounce } from "lodash";
import UsersDataTable from "./Components/UsersDataTable.vue";
import TableSkeleton from "./Components/TableSkeleton.vue";
import Spinner from "@/Pages/Components/Spinner.vue";
import PaginationT from "@/Pages/Components/PaginationT.vue";
import ConfirmDialog from "primevue/confirmdialog";
import Button from "primevue/button";
import Message from "primevue/message";
import RoleFilter, { filterConfig } from "@/Pages/Components/RoleFilter.vue";

let usersData = ref<Pagination<User[]> | null>(null);
const searchModel = ref();

onMounted(async () => {
    fetchData();
});
const fetchData = async (url?: string) => {
    try {
        let data;
        data = await UserUtils.fetchUsers(url);
        usersData.value = { ...data };
    } catch (error) {
        throw error;
    }
};
const loading = ref<boolean>();
const result = ref<User[] | []>();
const shouldResetExpandedRows = ref(true);

const search = async () => {
    try {
        const data = await UserUtils.searchUser(searchModel.value);
        loading.value = false;
        result.value = data;
    } catch (error) {
        throw error;
    }
};

const handleUpdateTable = async () => {
    if (
        usersData.value &&
        usersData.value.links &&
        usersData.value.current_page
    ) {
        await fetchData(
            usersData.value.links[usersData.value.current_page].url as string,
        );
        shouldResetExpandedRows.value = !shouldResetExpandedRows.value;
    }
};

const debounceSearch = debounce(search, 600);

const filter = async (config: filterConfig) => {
    try {
        const data = await UserUtils.fetchUsers(undefined, config);
        usersData.value = data;
    } catch (error) {
        throw error;
    }
};
</script>
<template>
    <ConfirmDialog>
        <template #container="{ message, acceptCallback, rejectCallback }">
            <div
                class="flex flex-col items-center gap-1 rounded-md bg-surface-0 p-5 dark:bg-surface-900"
            >
                <div
                    class="-mt-8 inline-flex h-[6rem] w-[6rem] items-center justify-center rounded-full bg-slate-200 text-white dark:bg-slate-800 dark:text-surface-950"
                >
                    <i :class="message.icon" class="text-5xl text-red-700"></i>
                </div>
                <span class="text-xl">
                    {{ message.header }}
                </span>
                <Message
                    v-if="message.message"
                    :closable="false"
                    icon="pi pi-exclamation-triangle "
                    severity="warn"
                >
                    {{ message.message }}
                </Message>

                <div class="mt-4 flex items-center gap-2">
                    <Button
                        label="Cancel"
                        @click="rejectCallback"
                        class="w-[8rem]"
                        outlined
                    ></Button>
                    <Button
                        label="Proceed"
                        severity="danger"
                        @click="acceptCallback"
                        class="w-[8rem]"
                    >
                        <template #loadingicon>
                            <Spinner
                                class="flex items-center justify-center"
                            ></Spinner>
                        </template>
                    </Button>
                </div>
            </div> </template
    ></ConfirmDialog>
    <div
        class="overlay"
        v-if="searchModel && result"
        @click="result = undefined"
    ></div>
    <div class="card relative p-1">
        <div class="relative z-10 mb-2 w-full">
            <div class="flex w-full items-center gap-2">
                <IconField class="w-full">
                    <InputIcon>
                        <Spinner v-if="loading" />
                    </InputIcon>
                    <InputText
                        placeholder="Search with ID or Name"
                        v-model="searchModel"
                        @input="
                            loading = true;
                            debounceSearch();
                        "
                    />
                </IconField>
                <RoleFilter
                    @on-filter="(toFilter) => filter(toFilter)"
                    class="hidden sm:block"
                    v-show="!(searchModel && result)"
                ></RoleFilter>
            </div>
            <RoleFilter
                @on-filter="(toFilter) => filter(toFilter)"
                class="mt-2 sm:hidden"
                v-show="!(searchModel && result)"
            ></RoleFilter>
            <div
                v-if="result && result.length > 0"
                class="absolute z-10 mt-2 max-h-[400px] w-full overflow-auto rounded-lg"
            >
                <UsersDataTable
                    :key="result.length"
                    :users="result"
                    @update-table="() => handleUpdateTable()"
                ></UsersDataTable>
            </div>
        </div>
        <UsersDataTable
            :key="shouldResetExpandedRows ? 'pulung' : 'malung'"
            v-if="usersData"
            :users="usersData.data"
        ></UsersDataTable>
        <TableSkeleton v-if="!usersData"></TableSkeleton>
    </div>
    <div class="flex w-full justify-center overflow-auto" v-if="usersData">
        <PaginationT
            :key="usersData.total"
            @paginate="(url: string) => fetchData(url)"
            :paginator="usersData"
        ></PaginationT>
    </div>
</template>
<style scoped>
.overlay {
    position: fixed; /* Changed from absolute to fixed */
    top: 0;
    left: 0;
    z-index: 10;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.7);
}
</style>
