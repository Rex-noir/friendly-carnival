<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Pagination, User } from "@/types/users.interface";
import { onMounted, ref } from "vue";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";
import UserUtils from "@/utils/user";
import { debounce } from "lodash";
import UsersDataTable from "./Components/UsersDataTable.vue";
import Button from "primevue/button";

let usersData = ref<Pagination<User[]>>();
const users = ref<User[][]>([]);
const searchModel = ref();

onMounted(async () => {
    fetchData();
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
                    <svg
                        class="animate-spin h-5 w-5 mr-3 text-red-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        v-if="loading"
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
        <UsersDataTable v-if="usersData" :users="users"></UsersDataTable>
    </div>
    <div class="w-full" v-if="usersData">
        <div class="flex justify-center p-3 text-lg gap-3">
            <Button
                outlined
                v-for="link in usersData.links"
                v-html="link.label"
                @click="fetchData(link.url as string)"
                class="border-none !text-black active:!ring-0 focus-within:!ring-0 !p-1 hover:bg-slate-200 dark:hover:bg-slate-900 dark:!text-white"
                :class="link.active ? '!text-red-500' : ''"
            ></Button>
        </div>
    </div>
</template>
<style scoped>
.overlay {
    position: absolute;
    z-index: 10;
    width: 100vw;
    height: 100vh;
    background-color: rgba(
        0,
        0,
        0,
        0.5
    ); /* Adjust the last value for transparency */
}
</style>
