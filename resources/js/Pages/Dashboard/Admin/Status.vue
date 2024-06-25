<script setup lang="ts">
import { SystemInfo, RealTimeSystemInfo } from "@/types/dashboard.interface";
import { usePage } from "@inertiajs/vue3";
import Card from "primevue/card";
import ProgressSpinner from "primevue/progressspinner";

import { onBeforeUnmount, onMounted, ref } from "vue";

const systemInfo = ref<SystemInfo>(usePage().props.systemStatus as SystemInfo);
const { database, host, client, server } = systemInfo.value;
const { hardware, software, uptime } = server;

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
    <div
        class="p-1 pb-20 flex flex-col gap-3 items-center sm:grid sm:grid-cols-3 w-[95%] place-items-center mx-auto"
    >
        <Card
            v-if="realTimeInfo"
            class="border text-center dark:border-slate-700 h-fit md:w-fit"
        >
            <template #title
                ><span class="font-black"
                    >Uptime : {{ realTimeInfo.uptime }}</span
                >
            </template>
        </Card>
        <Card v-if="realTimeInfo" class="border dark:border-slate-700 md:w-fit">
            <template #title
                ><span class="font-black">CPU Status</span></template
            >
            <template #content>
                <p>
                    <span class="font-bold">CPU Usage : </span>
                    {{ realTimeInfo.cpu_load["15m"] }}%
                </p>
                <p><span class="font-bold">CPU : </span> {{ hardware.cpu }}</p>
                <p>
                    <span class="font-bold">CPU Cores : </span>
                    {{ hardware.cpu_count }}
                </p>
                <p>
                    <span class="font-bold">Virtualization : </span
                    >{{ hardware.virtualization }}
                </p>
            </template>
        </Card>
        <Card v-if="realTimeInfo" class="border dark:border-slate-700 md:w-fit">
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
        <ProgressSpinner
            v-if="!realTimeInfo"
            style="width: 50px; height: 50px"
            strokeWidth="3"
            class="absolute fill-surface-0 col-start-2 dark:fill-surface-800"
            animationDuration=".5s"
            aria-label="Progressing"
        />
        <Card v-if="realTimeInfo" class="border dark:border-slate-700 md:w-fit">
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
        <Card v-if="realTimeInfo" class="border dark:border-slate-700 md:w-fit">
            <template #title><span class="font-black">Host</span></template>
            <template #content>
                <p>
                    <span class="font-bold"> Hostname : </span>
                    {{ host.hostname }}
                </p>
                <p>
                    <span class="font-bold">IP : </span>
                    {{ host.ip }}
                </p>
                <p>
                    <span class="font-bold">Private IP : </span>
                    {{ host.ip_private }}
                </p>
                <p>
                    <span class="font-bold">Country : </span>
                    {{ host.country }}
                </p>
                <p>
                    <span class="font-bold">City : </span>
                    {{ host.city }}
                </p>
                <p>
                    <span class="font-bold">Location : </span>
                    {{ host.location }}
                </p>
                <p>
                    <span class="font-bold">Time Zone : </span>
                    {{ host.timezone }}
                </p>
                <p>
                    <span class="font-bold">Region : </span>
                    {{ host.region }}
                </p>
                <p>
                    <span class="font-bold">Postal : </span>
                    {{ host.postal }}
                </p>
                <p>
                    <span class="font-bold">Phone : </span>
                    {{ host.phone }}
                </p>
            </template>
        </Card>
        <Card
            v-if="realTimeInfo"
            class="border dark:border-slate-700 md:w-fit h-fit"
        >
            <template #title><span class="font-black">Database</span></template>
            <template #content>
                <p>
                    <span class="font-bold"> Driver : </span>
                    {{ database.driver }}
                </p>
                <p>
                    <span class="font-bold">Version : </span>
                    {{ database.version }}
                </p>
                <p>
                    <span class="font-bold">Size : </span>
                    {{ realTimeInfo.database }}
                </p>
            </template>
        </Card>
        <Card
            v-if="realTimeInfo"
            class="border dark:border-slate-700 md:w-fit h-fit sm:col-start-2"
        >
            <template #title><span class="font-black">OS</span></template>
            <template #content>
                <p>
                    <span class="font-bold">Name : </span>
                    {{ software.os }}
                </p>
                <p>
                    <span class="font-bold">Distro : </span>
                    {{ software.distro }}
                </p>
                <p>
                    <span class="font-bold">Kernel : </span>
                    {{ software.kernel }}
                </p>
                <p><span class="font-bold">Arch : </span>{{ software.arc }}</p>
            </template>
        </Card>
    </div>
</template>
