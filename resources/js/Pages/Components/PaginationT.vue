<script setup lang="ts">
import { Pagination } from "@/types/page.types";
import { computed } from "vue";
const props = defineProps<{ paginator: Pagination<User[]> }>();
const { paginator } = props;

function isFirstOrLastOrDots(
    index: number,
    links_length: number,
    label: string
) {
    return index === 0 || index === links_length - 1 || label.includes("...");
}

const onFirstPage = computed(() => paginator.current_page === 1);

const hasMorePages = computed(
    () => paginator.current_page < paginator.last_page
);

const displayLinks = computed(() =>
    props.paginator.links.filter((link, index) => Number(link.label) === index)
);
</script>

<template>
    <div class="flex justify-center flex-col items-center gap-2">
        <div>
            <p>
                Showing <span class="font-medium">{{ paginator.from }}</span> to
                <span class="font-medium">{{ paginator.to }}</span> of
                <span class="font-medium">{{ paginator.total }}</span> results
            </p>
        </div>
        <nav
            v-if="paginator !== undefined"
            class="flex items-center justify-between"
            role="navigation"
        >
            <div class="flex justify-between flex-1 sm:hidden">
                <span
                    v-if="onFirstPage"
                    class="relative inline-flex items-center cursor-pointer px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 leading-5 rounded-md"
                >
                    <svg
                        class="w-5 h-5"
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
                    class="relative cursor-pointer inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                >
                    <svg
                        class="w-5 h-5"
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
                    class="relative inline-flex items-center cursor-pointer px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                >
                    <svg
                        class="w-5 h-5"
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
                    class="relative inline-flex items-center px-4 py-2 ml-3 cursor-pointer text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 leading-5 rounded-md"
                >
                    <svg
                        class="w-5 h-5"
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
                class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
            >
                <div class="flex gap-2">
                    <span
                        class="relative z-0 inline-flex gap-2 shadow-sm rounded-md"
                    >
                        <span
                            v-if="onFirstPage"
                            aria-disabled="true"
                            aria-hidden="true"
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-default rounded-l-md leading-5"
                        >
                            <svg
                                class="w-5 h-5"
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
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                            rel="prev"
                        >
                            <svg
                                class="w-5 h-5"
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
                                            link.label
                                        )
                                    "
                                    :class="{
                                        '!bg-lime-200 ': link.active === true,
                                    }"
                                    @click="$emit('paginate', link.url)"
                                    class="relative inline-flex rounded-sm bg-white items-center px-4 py-2 -ml-px text-sm font-medium cursor-pointer text-gray-700 border border-gray-300 leading-5 hover:text-gray-800 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                >
                                    {{ link.label }}
                                </span>
                                <span
                                    v-else-if="link.label === '...'"
                                    aria-disabled="true"
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5"
                                >
                                    {{ link.label }}
                                </span>
                            </div>
                        </div>
                        <span
                            v-if="hasMorePages"
                            @click="$emit('paginate', paginator.next_page_url)"
                            class="relative inline-flex items-center px-2 py-2 -ml-px cursor-pointer text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                        >
                            <svg
                                class="w-5 h-5"
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
                            class="relative inline-flex items-center px-2 py-2 cursor-pointer -ml-px text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 rounded-r-md leading-5"
                        >
                            <svg
                                class="w-5 h-5"
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
