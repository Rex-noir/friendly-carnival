<script setup lang="ts">
import { Pagination, User } from "@/types/users.interface";
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

let usersData = ref<Pagination<User[]> | null>(null);
const searchModel = ref();

onMounted(async () => {
    debounceFetch();
});
const fetchData = async (url?: string) => {
    try {
        let data;
        data = await UserUtils.index(url);
        usersData.value = { ...data }; // Create a new object
    } catch (error) {
        throw error;
    }
};
const debounceFetch = debounce(fetchData, 500);

const loading = ref<boolean>();
const result = ref<User[] | []>();

const search = async () => {
    try {
        const data = await UserUtils.searchUser(searchModel.value);
        loading.value = false;
        result.value = data;
    } catch (error) {
        throw error;
    }
};

const handleUpdateTable = () => {
    if (
        usersData.value &&
        usersData.value.links &&
        usersData.value.current_page
    ) {
        fetchData(
            usersData.value.links[usersData.value.current_page].url as string
        );
    }
};

const debounceSearch = debounce(search, 600);
</script>
<template>
    <ConfirmDialog>
        <template #container="{ message, acceptCallback, rejectCallback }">
            <div
                class="flex flex-col items-center p-5 bg-surface-0 dark:bg-surface-900 rounded-md"
            >
                <div
                    class="rounded-full bg-slate-200 dark:bg-slate-800 text-white dark:text-surface-950 inline-flex justify-center items-center h-[6rem] w-[6rem] -mt-8"
                >
                    <i class="pi pi-trash text-5xl text-red-700"></i>
                </div>
                <span
                    >Delete
                    <span class="font-bold text-lg mb-2 mt-4">{{
                        message.header
                    }}</span>
                    from Database?
                </span>
                <Message :closable="false" severity="warn">
                    {{ message.message }}
                </Message>

                <div class="flex items-center gap-2 mt-4">
                    <Button
                        label="Cancel"
                        @click="rejectCallback"
                        class="w-[8rem]"
                        outlined
                    ></Button>
                    <Button
                        label="Delete"
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
    <div class="relative card p-2 mx-auto md:w-[50%]">
        <div class="mb-2 relative z-10">
            <IconField>
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
            <div
                v-if="result && result.length > 0"
                class="absolute w-full rounded-lg overflow-auto max-h-[400px] z-10 mt-2"
            >
                <UsersDataTable
                    :key="result.length"
                    :users="result"
                    @update-table="() => handleUpdateTable()"
                ></UsersDataTable>
            </div>
        </div>
        <UsersDataTable
            :key="usersData.current_page"
            v-if="usersData"
            :users="usersData.data"
        ></UsersDataTable>
        <TableSkeleton v-if="!usersData"></TableSkeleton>
    </div>
    <div class="w-full justify-center flex overflow-auto" v-if="usersData">
        <PaginationT
            :key="usersData.current_page"
            @paginate="(url:string)=>fetchData(url)"
            :paginator="usersData"
        ></PaginationT>
    </div>
</template>
<style scoped>
.overlay {
    position: absolute;
    z-index: 10;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.7);
}
</style>
