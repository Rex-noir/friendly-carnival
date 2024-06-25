<template>
    <div class="card">
        <Dock :model="items" position="bottom">
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
                    <span class="material-symbols-outlined">{{
                        item.icon
                    }}</span>
                    <span>{{ item.label }}</span>
                </div>
            </template>
        </Dock>
        <div class="pb-32">
            <component :is="components"></component>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, shallowRef } from "vue";
import Status from "./Admin/Status.vue";
import Users from "./Admin/Users.vue";
import Dock from "primevue/dock";

const components = shallowRef(Status);

const items = shallowRef([
    {
        label: "Users",
        icon: "people_alt",
        component: Users,
    },
    {
        label: "Status",
        icon: "insights",
        component: Status,
    },
]);
</script>
