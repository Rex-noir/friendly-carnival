<script setup lang="ts">
import { RealTimeSystemInfo } from "@/types/dashboard.types";
import Card from "primevue/card";
import StatusSkeleton from "./Components/StatusSkeleton.vue";

import { onBeforeUnmount, onMounted, ref } from "vue";

let realTimeInfo = ref<RealTimeSystemInfo | null>(null);

onMounted(() => {
    window.Echo.private("system-info").listen("UpdateSystemInfo", (e) => {
        realTimeInfo.value = e.systemInfo as RealTimeSystemInfo;
    });
});
onBeforeUnmount(() => {
    window.Echo.leaveChannel("private-system-info");
});
</script>
<template>
    <StatusSkeleton v-if="!realTimeInfo"></StatusSkeleton>
    <div
        v-if="realTimeInfo"
        class="p-1 flex flex-col gap-3 sm:grid sm:grid-cols-3 mx-auto"
    >
        <Card class="border dark:border-slate-700">
            <template #title><span class="font-black">Uptime </span> </template>
            <template #content> {{ realTimeInfo.uptime }}</template>
        </Card>
        <Card class="border dark:border-slate-700">
            <template #title
                ><span class="font-black">CPU Status</span></template
            >
            <template #content>
                <p>
                    <span class="font-bold">CPU Usage : </span>
                    {{ realTimeInfo.cpu_load["1m"] }}%
                </p>
            </template>
        </Card>
        <Card class="border dark:border-slate-700">
            <template #title
                ><span class="font-black">Memory RAM</span></template
            >
            <template #content>
                <p>
                    <span class="font-bold"> Memory Usage : </span>
                    {{ realTimeInfo.memory_usage.memory_usage }}
                </p>
                <p>
                    <span class="font-bold">Memory Used : </span>
                    {{ realTimeInfo.memory_usage.memory_used }}
                </p>
                <p>
                    <span class="font-bold">Total Memory : </span>
                    {{ realTimeInfo.memory_usage.memory_total }}
                </p>
            </template>
        </Card>
        <Card class="border dark:border-slate-700">
            <template #title
                ><span class="font-black">Disk Status</span></template
            >
            <template #content>
                <p>
                    <span class="font-bold"> Disk Used : </span>
                    {{ realTimeInfo.storage_usage.disk_used }}
                </p>
                <p>
                    <span class="font-bold">Disk Total : </span>
                    {{ realTimeInfo.storage_usage.disk_total }}
                </p>
                <p>
                    <span class="font-bold">Disk Free : </span>
                    {{ realTimeInfo.storage_usage.disk_free }}
                </p>
            </template>
        </Card>
        <Card class="border dark:border-slate-700">
            <template #title><span class="font-black">Database</span></template>
            <template #content>
                <p>
                    <span class="font-bold">Size : </span>
                    {{ realTimeInfo.database }}
                </p>
            </template>
        </Card>
    </div>
</template>
