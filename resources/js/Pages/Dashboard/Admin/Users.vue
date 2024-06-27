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

let usersData = ref<Pagination<User[]>>();
const users = ref<User[][]>([]);
const searchModel = ref();

onMounted(async () => {
    debounceFetch();
});
const fetchData = async (url?: string) => {
    try {
        let data;
        if (url) {
            data = await UserUtils.index(url);
        } else {
            data = await UserUtils.index();
        }
        usersData.value = data;
        users.value = data.data;
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

const debounceSearch = debounce(search, 600);
</script>
<template>
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
                    class="z-10 rounded-lg"
                    :users="result"
                ></UsersDataTable>
            </div>
            <!-- Form -->
        </div>
        <UsersDataTable
            :key="usersData.current_page"
            v-if="usersData"
            :users="users"
        ></UsersDataTable>
        <TableSkeleton v-if="!usersData"></TableSkeleton>
    </div>
    <div class="w-[994] justify-center flex overflow-auto" v-if="usersData">
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
