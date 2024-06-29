<script setup lang="ts">
import { SystemInfo } from "@/types/dashboard.types";
import { usePage } from "@inertiajs/vue3";
import Card from "primevue/card";

import { ref } from "vue";
const systemInfo = ref<SystemInfo>(usePage().props.systemStatus as SystemInfo);
const { database, host, client, server } = systemInfo.value;
const { hardware, software, uptime } = server;
</script>
<template>
    <div class="card p-2 flex flex-col gap-2">
        <Card class="flex-1 border">
            <template #title>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined">database</span
                    >{{ database.driver }}
                </div>
            </template>
            <template #content>
                Using {{ database.driver }} version {{ database.version }}
            </template>
        </Card>
        <Card class="flex-1 border">
            <template #title>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined">dns</span>Host
                </div>
            </template>
            <template #content>
                <p>Host Country : {{ host.country }}</p>
                <p>Host Region : {{ host.region }}</p>
                <p>Host City : {{ host.city }}</p>
                <p>IP Address : {{ host.ip }}</p>
                <p>Location : {{ host.location }}</p>
                <p>Timezone : {{ host.timezone }}</p>
                <p>Org : {{ host.org }}</p>
                <p>Postal Code : {{ host.postal }}</p>
            </template>
        </Card>
        <Card class="flex-1 border">
            <template #title>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined"
                        >developer_board</span
                    >Hardware
                </div>
            </template>
            <template #content>
                <p>CPU : {{ hardware.cpu }}</p>
                <p>CPU Count : {{ hardware.cpu_count }}</p>
                <p>Model : {{ hardware.model }}</p>
                <p>Virtualization : {{ hardware.virtualization }}</p>
            </template>
        </Card>
        <Card class="flex-1 border">
            <template #title>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined">OS</span>
                </div>
            </template>
            <template #content>
                <p>OS : {{ software.os }}</p>
                <p>Distro : {{ software.distro }}</p>
                <p>Kernel : {{ software.kernel }}</p>
                <p>Architecture : {{ software.arc }}</p>
                <p>Web Server : {{ software.webserver }}</p>
                <p>PHP : {{ software.php }}</p>
            </template>
        </Card>
        <Card class="flex-1 border">
            <template #title>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined">timer</span>
                    Uptime
                </div>
            </template>
            <template #content>
                <p>Uptime : {{ uptime.uptime }}</p>
                <p>Booted at : {{ uptime.booted_at }}</p>
            </template>
        </Card>
    </div>
</template>
