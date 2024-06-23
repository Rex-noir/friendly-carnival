<template>
    <div class="card">
        <div class="dock-window">
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
                        <span class="material-icons">{{ item.icon }}</span>
                        <span>{{ item.label }}</span>
                    </div>
                </template>
            </Dock>
        </div>
        <component :is="components"></component>
    </div>
</template>

<script setup>
import { ref, shallowRef } from "vue";
import Status from "./Components/Status.vue";
import Users from "./Components/Users.vue";
import Dock from "primevue/dock";

const components = shallowRef(Status);

const items = shallowRef([
    {
        label: "Status",
        icon: "insights",
        component: Status,
    },
    {
        label: "Users",
        icon: "people_alt",
        component: Users,
    },
]);
</script>
