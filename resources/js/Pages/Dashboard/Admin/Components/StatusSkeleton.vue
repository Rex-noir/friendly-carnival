<script setup lang="ts">
import Skeleton from "primevue/skeleton";
import Card from "primevue/card";
</script>
<template>
    <div
        class="p-1 pb-20 flex flex-col gap-3 sm:grid sm:grid-cols-3 w-[95%] mx-auto"
    >
        <Card class="border dark:border-slate-700">
            <template #title><span class="font-black"> Uptime </span></template>
            <template #content> <Skeleton></Skeleton> </template>
        </Card>
        <Card class="border dark:border-slate-700">
            <template #title
                ><span class="font-black">CPU Status</span></template
            >
            <template #content>
                <Skeleton></Skeleton>
            </template>
        </Card>
        <Card class="border dark:border-slate-700">
            <template #title
                ><span class="font-black">Memory RAM</span></template
            >
            <template #content
                ><div class="flex flex-col gap-3">
                    <Skeleton></Skeleton>
                    <Skeleton></Skeleton>
                    <Skeleton></Skeleton>
                </div>
            </template>
        </Card>
        <Card class="border dark:border-slate-700">
            <template #title
                ><span class="font-black">Disk Status</span></template
            >
            <template #content
                ><div class="flex flex-col gap-3">
                    <Skeleton></Skeleton>
                    <Skeleton></Skeleton>
                    <Skeleton></Skeleton>
                </div>
            </template>
        </Card>
        <Card class="border dark:border-slate-700">
            <template #title><span class="font-black">Database</span></template>
            <template #content>
                <Skeleton></Skeleton>
            </template>
        </Card>
    </div>
</template>
