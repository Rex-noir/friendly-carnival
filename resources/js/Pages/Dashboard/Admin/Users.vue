<script setup lang="ts">
import TabMenu from "primevue/tabmenu";
import { ref } from "vue";

const active = ref(0);

const items = ref([
    { label: "Users", icon: "pi pi-home" },
    { label: "Authors", icon: "pi pi-chart-line" },
    { label: "Admin", icon: "pi pi-list" },
]);
</script>
<template>
    <div>
        <TabMenu v-model:activeIndex="active" :model="items">
            <template #item="{ item, props }">
                <a
                    v-ripple
                    v-bind="props.action"
                    class="flex items-center gap-2"
                >
                    <span class="font-bold">{{ item.label }}</span>
                </a>
            </template>
        </TabMenu>
    </div>
</template>
