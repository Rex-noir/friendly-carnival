<script setup lang="ts">
import { Pagination, User } from "@/types/users.interface";
import Button from "primevue/button";
import { ref } from "vue";

const props = defineProps<{ paginator: Pagination<User[]> }>();

const totalPages = props.paginator.last_page;
const currentPage = props.paginator.current_page;
const numLinksAround = 3;

const startPage = Math.max(1, currentPage - numLinksAround);
const endPage = Math.min(totalPages, currentPage + numLinksAround);
const displayedLinks = ref(
    props.paginator.links
        .filter((link, index) => Number(link.label) === index)
        .slice(startPage - 1, endPage)
);
</script>
<template>
    <nav aria-label="Page navigation">
        <ul class="flex gap-1 items-center -space-x-px h-8 text-sm">
            <li>
                <Button
                    @click="$emit('paginate', paginator.prev_page_url)"
                    class="flex items-center focus:!ring-0 justify-center px-3 h-8 leading-tight text-gray-800 !bg-gray-200 border !border-gray-300 hover:!bg-gray-100 hover:!text-gray-700 dark:!bg-gray-800 dark:!border-gray-700 dark:!text-gray-400 dark:hover:!bg-gray-700 dark:!hover:text-white"
                >
                    <span class="sr-only">Previous</span>
                    <svg
                        class="w-2.5 h-2.5 rtl:rotate-180"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 6 10"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 1 1 5l4 4"
                        />
                    </svg>
                </Button>
            </li>
            <li class="flex items-center gap-1 justify-center">
                <Button
                    v-for="link in displayedLinks"
                    @click="$emit('paginate', link.url)"
                    :class="
                        Number(link.label) === paginator.current_page
                            ? ' !text-red-500'
                            : ''
                    "
                    class="flex items-center focus:!ring-0 justify-center px-3 h-8 leading-tight text-gray-800 !bg-gray-200 border !border-gray-300 hover:!bg-gray-100 hover:!text-gray-700 dark:!bg-gray-800 dark:!border-gray-700 dark:!text-gray-400 dark:hover:!bg-gray-700 dark:!hover:text-white"
                >
                    {{ link.label }}
                </Button>
            </li>
            <li>
                <Button
                    @click="$emit('paginate', paginator.next_page_url)"
                    class="flex items-center focus:!ring-0 justify-center px-3 h-8 leading-tight text-gray-800 !bg-gray-200 border !border-gray-300 hover:!bg-gray-100 hover:!text-gray-700 dark:!bg-gray-800 dark:!border-gray-700 dark:!text-gray-400 dark:hover:!bg-gray-700 dark:!hover:text-white"
                >
                    <span class="sr-only">Next</span>
                    <svg
                        class="w-2.5 h-2.5 rtl:rotate-180"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 6 10"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m1 9 4-4-4-4"
                        />
                    </svg>
                </Button>
            </li>
        </ul>
    </nav>
</template>
