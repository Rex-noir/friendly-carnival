<script setup lang="ts">
import DataTable, { DataTableRowClickEvent } from "primevue/datatable";
import Column from "primevue/column";
import { computed, onMounted, reactive, ref, watch } from "vue";
import Card from "primevue/card";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import UserUtils from "@/utils/user";
import Spinner from "@/Pages/Components/Spinner.vue";
import { debounce } from "lodash";
import axios from "axios";
import { useConfirm } from "primevue/useconfirm";
import { UserActions, UserStatus } from "@/types/actions.types";
import Tag from "primevue/tag";

const confirm = useConfirm();
const emit = defineEmits<{ (e: "updateTable"): void }>();
const props = defineProps<{
    users: User[] | User[][];
}>();

const expandedRows = ref<User[]>([]);
const editEmail = reactive<boolean[]>([]);
const emailModel = reactive<string[]>([]);
const loading = reactive<boolean[]>([]);
const updateStatus = reactive<string[]>([]);

const rowClicked = (e: DataTableRowClickEvent) => {
    const id = e.data.id;
    const index = expandedRows.value.findIndex((row) => row.id === id);

    if (index !== -1) {
        expandedRows.value.splice(index, 1);
    } else {
        expandedRows.value.push(e.data);
    }
};

const updateEmail = (id: number) => {
    editEmail[id] = !editEmail[id];
    if (!editEmail[id] && emailModel[id]) {
        handleTableActions(id, UserActions.UPDATE);
    }
};
const handleTableActions = async (id: number, action: UserActions) => {
    try {
        loading[id] = true;
        updateStatus[id] = "";

        if (action === UserActions.UPDATE) {
            await UserUtils.update({ id: id, email: emailModel[id] });
            updateStatus[id] = "Updated!";
        } else if (action === UserActions.DELETE) {
            await UserUtils.delete(id);
            updateStatus[id] = "Deleted!";
            createRefsForTable();
            updateTableOnActions(id, UserActions.DELETE);
        } else {
            await UserUtils.ban(id);
            updateStatus[id] = "Updated!";
            updateTableOnActions(id, UserActions.BAN);
        }
        emit("updateTable");
        loading[id] = false;
        debounce(() => (updateStatus[id] = ""), 2000)();
    } catch (error) {
        loading[id] = false;
        updateStatus[id] = "Failed!";
        debounce(() => (updateStatus[id] = ""), 2000)();

        if (axios.isAxiosError(error)) {
            if (error.response?.data.email) {
                emailModel[id] = error.response.data.email;
            }
        }
        throw error;
    }
};

const updateTableOnActions = (id: number, action: UserActions) => {
    const userIndex = (props.users as User[]).findIndex(
        (user) => user.id === id
    );
    if (userIndex !== -1) {
        switch (action) {
            case UserActions.DELETE:
                props.users.splice(userIndex, 1);
                expandedRows.value = expandedRows.value.filter(
                    (user) => user.id !== id
                );
                break;
            case UserActions.BAN:
                (props.users[userIndex] as User).status =
                    (props.users[userIndex] as User).status ===
                    UserStatus.BANNED
                        ? UserStatus.ACTIVE
                        : UserStatus.BANNED;
                break;
            default:
                break;
        }
    }
};

//dialog configuration
const deleteConfirm = (user: User) => {
    confirm.require({
        message: `This action can't be undone.`,
        header: `Delete ${user.name} from Database?`,
        icon: "pi pi-trash",
        accept: () => {
            handleTableActions(user.id, UserActions.DELETE);
        },
    });
};

const banConfirm = (user: User) => {
    confirm.require({
        header: `Are you sure to ${
            user.status === UserStatus.BANNED ? "restore" : "Ban"
        } ${user.name} ?`,
        icon: "pi pi-ban",
        accept: () => {
            handleTableActions(user.id, UserActions.BAN);
        },
    });
};

const createRefsForTable = () => {
    props.users.forEach((user) => {
        if (!Array.isArray(user)) {
            emailModel[user.id] = user.email;
            editEmail[user.id] = false;
            loading[user.id] = false;
            updateStatus[user.id] = "";
        }
    });
};

onMounted(() => {
    createRefsForTable();
});
</script>
<template>
    <div>
        <DataTable
            showGridLines
            v-model:expandedRows="expandedRows"
            :value="props.users"
            ripple
            @row-click="rowClicked"
            tableStyle="min-width: fit-content"
        >
            <Column field="id" header="Id" style="width: 1%">
                <template #body="row">
                    <span
                        class="font-bold"
                        :class="
                            expandedRows.findIndex(
                                (r) => r.id === row.data.id
                            ) !== -1
                                ? 'text-red-500'
                                : ''
                        "
                        >{{ row.data.id }}</span
                    >
                </template>
            </Column>
            <Column field="name" header="Name" class="w-fit"> </Column>
            <Column
                class="hidden sm:table-cell"
                header="Role"
                ripple
                style="width: 1rem"
            >
                <template #body="row"
                    ><div class="hidden justify-start sm:flex gap-2 w-full">
                        <Tag
                            :severity="
                                row.data.role === 'admin' ? 'warning' : 'info'
                            "
                            class="w-full"
                            :value="row.data.role"
                        ></Tag></div></template
            ></Column>
            <Column
                ripple
                header="Status"
                class="hidden sm:table-cell"
                style="width: 2rem"
            >
                <template #body="row"
                    ><div class="hidden sm:flex gap-2 w-full">
                        <Tag
                            :value="row.data.status"
                            class="w-full"
                            :severity="
                                row.data.status === 'banned'
                                    ? 'danger'
                                    : 'success'
                            "
                        ></Tag></div></template
            ></Column>

            <Column ripple expander style="width: 5rem">
                <template #body="row">
                    <span class="material-symbols-outlined">{{
                        expandedRows.findIndex((r) => r.id === row.data.id) !==
                        -1
                            ? "keyboard_arrow_down"
                            : "chevron_right"
                    }}</span>
                </template></Column
            >
            <template #expansion="user">
                <Card class="!border-none !shadow-none">
                    <template #title
                        ><div
                            class="grid grid-cols-2 gap-2 place-content-center items-center"
                        >
                            <span class="col-span-1 row-start-1">
                                {{ user.data.name }}</span
                            >
                            <div
                                class="sm:hidden flex row-start-2 gap-2 col-start-1"
                            >
                                <Tag
                                    :severity="
                                        user.data.role === 'admin'
                                            ? 'warning'
                                            : 'info'
                                    "
                                    :value="user.data.role"
                                ></Tag>
                                <Tag
                                    :value="user.data.status"
                                    :severity="
                                        user.data.status === UserStatus.BANNED
                                            ? 'danger'
                                            : 'success'
                                    "
                                ></Tag>
                            </div>
                            <div
                                class="justify-self-end row-start-2 sm:row-start-1 col-start-2"
                            >
                                <span
                                    v-if="updateStatus[user.data.id]"
                                    :class="
                                        updateStatus[user.data.id] ===
                                            'Updated!' ||
                                        updateStatus[user.data.id] ===
                                            'Deleted!'
                                            ? 'text-green-500'
                                            : 'text-red-500'
                                    "
                                    >{{ updateStatus[user.data.id] }}</span
                                >
                                <Spinner v-if="loading[user.data.id]"></Spinner>
                            </div></div
                    ></template>
                    <template #content
                        ><div class="grid gap-3 w-full grid-cols-2">
                            <div
                                class="grid grid-cols-11 col-span-2 w-full gap-1"
                            >
                                <InputText
                                    v-model="emailModel[user.data.id]"
                                    type="email"
                                    size="small"
                                    class="col-span-11 col-start-1 w-full"
                                    :disabled="!editEmail[user.data.id]"
                                    placeholder="Small"
                                />
                                <Button
                                    :loading="loading[user.data.id]"
                                    outlined
                                    @click="updateEmail(user.data.id)"
                                    :icon="
                                        editEmail[user.data.id]
                                            ? 'pi pi-check'
                                            : 'pi pi-pencil'
                                    "
                                    :aria-label="
                                        editEmail[user.data.id]
                                            ? 'Save'
                                            : 'Edit'
                                    "
                                    class="col-start-12 focus:!ring-0 !border-gray-500 dark:!border-slate-400"
                                    ><template #loadingicon>
                                        <Spinner
                                            class="flex items-center justify-center"
                                        ></Spinner>
                                    </template>
                                </Button>
                            </div>

                            <Button
                                rounded
                                class="!p-2 col-start-1"
                                :label="
                                    user.data.status === UserStatus.BANNED
                                        ? 'Restore'
                                        : 'Ban'
                                "
                                severity="warning"
                                @click="banConfirm(user.data)"
                            />
                            <Button
                                rounded
                                class="!p-2 col-start-2"
                                :label="`Delete`"
                                @click="deleteConfirm(user.data)"
                                severity="danger"
                            />
                        </div>
                    </template>
                </Card>
            </template>
        </DataTable>
    </div>
</template>
