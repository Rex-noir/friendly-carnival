<script setup lang="ts">
import { UserRoles, UserStatus } from "@/types/enums.types";
import Tag from "primevue/tag";
import Divider from "primevue/divider";
import { ref } from "vue";

export interface filterConfig {
    role: UserRoles | null;
    status: UserStatus | null;
}

const emit = defineEmits<{
    (e: "onFilter", filterConfig: filterConfig): void;
}>();

const filterData = ref<filterConfig>({ role: null, status: null });

const filter = (role: UserRoles | null, status: UserStatus | null) => {
    if (role !== null) {
        filterData.value.role = filterData.value.role === role ? null : role;
    }
    if (status !== null) {
        filterData.value.status =
            filterData.value.status === status ? null : status;
    }
    emit("onFilter", filterData.value);
};

function getSeverity(filter: UserRoles | UserStatus) {
    switch (filter) {
        case UserRoles.ADMIN:
            return "warning";
        case UserRoles.AUTHOR:
            return "info";
        case UserRoles.USER:
            return "info";
        case UserStatus.ACTIVE:
            return "success";
        case UserStatus.BANNED:
            return "danger";
        default:
            return "secondary";
    }
}
</script>
<template>
    <div class="rounded-lg bg-slate-100 px-2 dark:bg-surface-800">
        <div class="grid grid-cols-[2fr,3px,1fr] items-center gap-3">
            <div class="flex gap-2">
                <Tag
                    v-ripple
                    class="h-full w-full cursor-pointer transition-all duration-300 hover:bg-surface-900 hover:text-white dark:hover:bg-surface-100 dark:hover:text-surface-950"
                    v-for="role in UserRoles"
                    :value="role"
                    :class="
                        role === filterData.role
                            ? 'bg-surface-900 text-white dark:bg-surface-100 dark:text-surface-950'
                            : ''
                    "
                    @click="filter(role, null)"
                    :severity="getSeverity(role)"
                ></Tag>
            </div>
            <Divider
                class="!ml-1 before:border-surface-900"
                layout="vertical"
            ></Divider>
            <div class="flex gap-2">
                <Tag
                    v-ripple
                    class="h-full w-full cursor-pointer transition-all duration-300 hover:bg-surface-900 hover:text-white dark:hover:bg-surface-100 dark:hover:text-surface-950"
                    v-for="status in UserStatus"
                    :value="status"
                    :class="
                        status === filterData.status
                            ? 'bg-surface-900 text-white dark:bg-surface-100 dark:text-surface-950'
                            : ''
                    "
                    :severity="getSeverity(status)"
                    @click="filter(null, status)"
                ></Tag>
            </div>
        </div>
    </div>
</template>
