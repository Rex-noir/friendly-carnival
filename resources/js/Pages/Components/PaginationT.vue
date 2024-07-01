<script setup lang="ts">
import { Pagination } from "@/types/page.types";
import { computed, reactive, watch } from "vue";
const props = defineProps<{ paginator: Pagination<User[]> }>();
let paginator = reactive(props.paginator);

function isFirstOrLastOrDots(
    index: number,
    links_length: number,
    label: string,
) {
    return index === 0 || index === links_length - 1 || label.includes("...");
}

const onFirstPage = computed(() => paginator.current_page === 1);

const hasMorePages = computed(
    () => paginator.current_page < paginator.last_page,
);

const displayLinks = computed(() =>
    props.paginator.links.filter((link, index) => Number(link.label) === index),
);
watch(
    () => props.paginator,
    (newPaginator) => {
        paginator = newPaginator;
    },
);
</script>

<template>
    <div class="flex flex-col items-center justify-center gap-2">
        <div>
            <p>
                Showing
                <span class="font-medium">{{
                    paginator.from ? paginator.from : "0"
                }}</span>
                to
                <span class="font-medium">{{
                    paginator.to ? paginator.to : "0"
                }}</span>
                of
                <span class="font-medium">{{ paginator.total }}</span> results
            </p>
        </div>
        <nav
            v-if="paginator !== undefined"
            class="flex items-center justify-between"
            role="navigation"
        >
            <div class="flex flex-1 justify-between sm:hidden">
                <span
                    v-if="onFirstPage"
                    class="relative inline-flex cursor-pointer items-center rounded-md border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-medium leading-5 text-gray-500"
                >
                    <svg
                        class="h-5 w-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            clip-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            fill-rule="evenodd"
                        />
                    </svg>
                </span>
                <span
                    @click="$emit('paginate', paginator.prev_page_url)"
                    v-else
                    class="relative inline-flex cursor-pointer items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700"
                >
                    <svg
                        class="h-5 w-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            clip-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            fill-rule="evenodd"
                        />
                    </svg>
                </span>
                <span
                    @click="$emit('paginate', paginator.next_page_url)"
                    v-if="hasMorePages"
                    class="relative ml-3 inline-flex cursor-pointer items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700"
                >
                    <svg
                        class="h-5 w-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            clip-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            fill-rule="evenodd"
                        />
                    </svg>
                </span>
                <span
                    v-else
                    class="relative ml-3 inline-flex cursor-pointer items-center rounded-md border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-medium leading-5 text-gray-500"
                >
                    <svg
                        class="h-5 w-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            clip-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            fill-rule="evenodd"
                        />
                    </svg>
                </span>
            </div>
            <div
                class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between"
            >
                <div class="flex gap-2">
                    <span
                        class="relative z-0 inline-flex gap-2 rounded-md shadow-sm"
                    >
                        <span
                            v-if="onFirstPage"
                            aria-disabled="true"
                            aria-hidden="true"
                            class="relative inline-flex cursor-default items-center rounded-l-md border border-gray-300 bg-gray-100 px-2 py-2 text-sm font-medium leading-5 text-gray-500"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    clip-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    fill-rule="evenodd"
                                />
                            </svg>
                        </span>
                        <span
                            v-else
                            @click="$emit('paginate', paginator.prev_page_url)"
                            class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-500"
                            rel="prev"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    clip-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    fill-rule="evenodd"
                                />
                            </svg>
                        </span>
                        <div class="flex gap-2">
                            <div v-for="link in displayLinks">
                                <span
                                    v-if="
                                        !isFirstOrLastOrDots(
                                            paginator.current_page,
                                            paginator.links.length,
                                            link.label,
                                        )
                                    "
                                    :class="{
                                        '!bg-lime-200': link.active === true,
                                    }"
                                    @click="$emit('paginate', link.url)"
                                    class="relative -ml-px inline-flex cursor-pointer items-center rounded-sm border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-800 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700"
                                >
                                    {{ link.label }}
                                </span>
                                <span
                                    v-else-if="link.label === '...'"
                                    aria-disabled="true"
                                    class="relative -ml-px inline-flex cursor-default items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700"
                                >
                                    {{ link.label }}
                                </span>
                            </div>
                        </div>
                        <span
                            v-if="hasMorePages"
                            @click="$emit('paginate', paginator.next_page_url)"
                            class="relative -ml-px inline-flex cursor-pointer items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-500"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    clip-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    fill-rule="evenodd"
                                />
                            </svg>
                        </span>
                        <span
                            v-else
                            aria-disabled="true"
                            aria-hidden="true"
                            class="relative -ml-px inline-flex cursor-pointer items-center rounded-r-md border border-gray-300 bg-gray-100 px-2 py-2 text-sm font-medium leading-5 text-gray-500"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    clip-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    fill-rule="evenodd"
                                />
                            </svg>
                        </span>
                    </span>
                </div>
            </div>
        </nav>
    </div>
</template>
