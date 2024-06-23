<script setup>
import { modes } from "@/preferences";
import { LayoutUtils } from "@/utils/layout";
import { Link, router } from "@inertiajs/vue3";
import Avatar from "primevue/avatar";
import Button from "primevue/button";
import MegaMenu from "primevue/megamenu";
import { ref } from "vue";

const items = ref([
    {
        label: "Genres",
        root: true,
        items: [
            [
                {
                    items: [
                        {
                            label: "Horror",
                            icon: "material-icons",
                            icon_name: "dangerous",
                        },
                        {
                            label: "Fantasy",
                            icon: "material-icons",
                            icon_name: "stars",
                        },
                        {
                            label: "Romance",
                            icon_name: "favorite",
                            icon: "material-icons",
                        },
                    ],
                },
            ],
        ],
    },
    {
        label: "Top Rated",
        root: true,
    },
    {
        label: "Librairies",
        root: true,
    },
]);
</script>

<template>
    <header>
        <div class="card">
            <MegaMenu
                :model="items"
                class="p-4 bg-surface-0 shadow-md"
                style="border-radius: 3rem"
            >
                <template #start>
                    <Link :href="'/'">
                        <span
                            class="material-icons text-green-600 text-3xl mr-3"
                            >auto_stories</span
                        >
                    </Link>
                </template>
                <template #item="{ item }">
                    <a
                        v-if="item.root"
                        v-ripple
                        class="flex items-center cursor-pointer px-3 py-2 overflow-hidden relative font-semibold text-lg uppercase hover:text-green-800"
                        style="border-radius: 2rem"
                    >
                        <span class="ml-2">{{ item.label }}</span>
                    </a>
                    <a
                        v-else-if="!item.image"
                        class="flex items-center p-3 cursor-pointer mb-2 gap-2"
                    >
                        <span
                            class="inline-flex items-center justify-center rounded-full bg-primary text-primary-inverse w-[2rem] h-[2rem] shrink-0"
                        >
                            <i :class="item.icon" class="text-surface-900">{{
                                item.icon_name
                            }}</i>
                        </span>
                        <span class="inline-flex flex-col gap-1">
                            <span
                                class="font-medium text-lg text-surface-900 dark:text-surface-0"
                                >{{ item.label }}</span
                            >
                        </span>
                    </a>
                    <div v-else class="flex flex-col items-start gap-3">
                        <img
                            alt="megamenu-demo"
                            :src="item.image"
                            class="w-full"
                        />
                        <span>{{ item.subtext }}</span>
                        <Button :label="item.label" outlined />
                    </div>
                </template>
                <template #end>
                    <div class="flex">
                        <span
                            :aria-label="
                                modes.isDarkMode ? 'Light Mode ' : 'Dark Mode'
                            "
                            @click="LayoutUtils.toggleDarkMode()"
                            class="material-icons mr-3 my-auto cursor-pointer transition-all duration-200"
                            >{{
                                modes.isDarkMode ? "light_mode" : "dark_mode"
                            }}</span
                        >
                        <Avatar
                            image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png"
                            shape="circle"
                            class="cursor-pointer"
                            @click="router.visit('/dashboard')"
                        />
                    </div>
                </template>
            </MegaMenu>
        </div>
    </header>
    <main>
        <slot />
    </main>
</template>
<style scoped></style>
