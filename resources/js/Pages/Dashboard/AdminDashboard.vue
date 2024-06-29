<template>
    <div class="card md:grid md:grid-cols-[20%,1%,79%]">
        <Dock :model="items" class="md:hidden" position="bottom">
            <template #icon="{ item }">
                <div
                    class="hover:text-green-500 flex flex-col items-center cursor-pointer"
                    @click="components = item.component"
                    :class="
                        components === item.component
                            ? 'text-red-500 hover:text-red-500'
                            : ''
                    "
                >
                    <i :class="item.icon"></i>
                    <span>{{ item.label }}</span>
                </div>
            </template>
        </Dock>
        <div class="hidden h-screen p-5 md:block">
            <div class="flex flex-col gap-2">
                <span class="font-bold">Main menu</span>
                <ul class="flex flex-col gap-3">
                    <li
                        ripple
                        @click="components = item.component"
                        :class="
                            item.component === components
                                ? 'bg-amber-400 hover:bg-amber-300 dark:hover:bg-amber-300 text-zinc-800'
                                : ''
                        "
                        class="p-3 transition-all flex gap-2 rounded-lg duration-300 hover:bg-surface-200 dark:hover:bg-surface-800 cursor-pointer"
                        v-for="item in items"
                    >
                        <span><i :class="item.icon"></i></span>
                        <span>{{ item.label }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="hidden md:block">
            <Divider
                layout="vertical"
                class="before:!border-surface-300 shadow-lg shadow-slate-700 dark:before:!border-surface-600"
            ></Divider>
        </div>
        <div class="pb-32 md:p-10 h-full">
            <component :is="components"></component>
        </div>
    </div>
</template>

<script setup lang="ts">
import { shallowRef } from "vue";
import Status from "./Admin/Status.vue";
import Users from "./Admin/Users.vue";
import Dock from "primevue/dock";
import Divider from "primevue/divider";

const components = shallowRef(Users);

const items = shallowRef([
    {
        label: "Users",
        icon: "pi pi-users",
        component: Users,
    },
    {
        label: "Status",
        icon: "pi pi-chart-bar",
        component: Status,
    },
]);
</script>
