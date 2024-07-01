<template>
    <div class="card md:grid md:grid-cols-[20%,1%,79%]">
        <Dock :model="items" class="md:hidden" position="bottom">
            <template #icon="{ item }">
                <div
                    class="flex cursor-pointer flex-col items-center hover:text-green-500"
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
                        v-ripple
                        @click="components = item.component"
                        :class="
                            item.component === components
                                ? 'bg-surface-300 hover:bg-amber-300 dark:bg-surface-800 dark:hover:bg-amber-300'
                                : ''
                        "
                        class="flex cursor-pointer gap-2 rounded-lg p-3 transition-all duration-300 hover:bg-surface-200 dark:hover:bg-surface-700"
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
                class="shadow-lg shadow-slate-700 before:!border-surface-300 dark:before:!border-surface-600"
            ></Divider>
        </div>
        <div class="h-full pb-32 md:p-10">
            <component :is="components"></component>
        </div>
    </div>
</template>

<script setup lang="ts">
import { shallowRef } from "vue";
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
]);
</script>
<style>
::-webkit-scrollbar {
    display: none;
}
.html {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none;
}
</style>
