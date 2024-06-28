<script setup lang="ts">
import DataTable, { DataTableRowClickEvent } from "primevue/datatable";
import Column from "primevue/column";
import { User } from "@/types/users.interface";
import { onMounted, reactive, ref } from "vue";
import Card from "primevue/card";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import UserUtils from "@/utils/user";
import Spinner from "@/Pages/Components/Spinner.vue";
import { debounce, reject } from "lodash";
import axios from "axios";
import ConfirmDialog from "primevue/confirmdialog";
import { useConfirm } from "primevue/useconfirm";
import Message from "primevue/message";

const confirm = useConfirm();
const props = defineProps<{
    users: User[] | User[][];
}>();

const expandedRows = ref<User[]>([]);
const editEmail = reactive<boolean[]>([]);
const emailModel = reactive<string[]>([]);
const loading = reactive<boolean[]>([]);
const updateStatus = reactive<string[]>([]);
const deleteLoading = ref<boolean>();

const rowClicked = (e: DataTableRowClickEvent) => {
    const id = e.data.id;
    const index = expandedRows.value.findIndex((row) => row.id === id);

    if (index !== -1) {
        expandedRows.value.splice(index, 1);
    } else {
        expandedRows.value.push(e.data);
    }
};

const toggleClicked = (id: number) => {
    editEmail[id] = !editEmail[id];
    updateEmail(id);
};

const updateEmail = async (id: number) => {
    if (!editEmail[id] && emailModel[id]) {
        try {
            loading[id] = true;
            updateStatus[id] = "";
            const data = await UserUtils.update({
                id: id,
                email: emailModel[id],
            });
            loading[id] = false;
            updateStatus[id] = "Updated!";
            debounce(() => (updateStatus[id] = ""), 2000)();
        } catch (error) {
            if (axios.isAxiosError(error)) {
                emailModel[id] = error.response?.data.email;
                loading[id] = false;
                updateStatus[id] = "Invalid Email";
                debounce(() => (updateStatus[id] = ""), 2000)();
            }
        }
    }
};

const deleteUser = async (id: number) => {
    try {
        loading[id] = true;
        await UserUtils.delete(id);
        loading[id] = false;
        updateStatus[id] = "Deleted!";
        debounce(() => (updateStatus[id] = ""), 2000)();
        debounce(() => updateTable(id), 2000)();
    } catch (error) {
        loading[id] = false;
        updateStatus[id] = "Failed!";
        debounce(() => (updateStatus[id] = ""), 2000)();
    }
};

const updateTable = (id: number) => {
    const userIndex = (props.users as User[]).findIndex(
        (user) => user.id === id
    );
    if (userIndex !== -1) {
        props.users.splice(userIndex, 1);
        expandedRows.value = expandedRows.value.filter(
            (user) => user.id !== id
        );
    }
    editEmail.splice(id, 1);
    emailModel.splice(id, 1);
    loading.splice(id, 1);
    updateStatus.splice(id, 1);
};

const deleteConfirm = (user: User) => {
    confirm.require({
        message: `This action can't be undone.`,
        header: `${user.name}`,
        icon: "pi pi-exclamation-triangle",
        accept: () => {
            deleteUser(user.id);
        },
    });
};

onMounted(() => {
    props.users.forEach((user) => {
        if (!Array.isArray(user)) {
            emailModel[user.id] = user.email;
            editEmail[user.id] = false;
            loading[user.id] = false;
            updateStatus[user.id] = "";
        }
    });
});
</script>
<template>
    <ConfirmDialog>
        <template #container="{ message, acceptCallback, rejectCallback }">
            <div
                class="flex flex-col items-center p-5 bg-surface-0 dark:bg-surface-900 rounded-md"
            >
                <div
                    class="rounded-full bg-slate-200 dark:bg-slate-800 text-white dark:text-surface-950 inline-flex justify-center items-center h-[6rem] w-[6rem] -mt-8"
                >
                    <i class="pi pi-trash text-5xl text-red-700"></i>
                </div>
                <span
                    >Delete
                    <span class="font-bold text-lg mb-2 mt-4">{{
                        message.header
                    }}</span>
                    from Database?
                </span>
                <Message :closable="false" severity="warn">
                    {{ message.message }}
                </Message>

                <div class="flex items-center gap-2 mt-4">
                    <Button
                        label="Cancel"
                        @click="rejectCallback"
                        class="w-[8rem]"
                        outlined
                    ></Button>
                    <Button
                        label="Delete"
                        :loading="deleteLoading"
                        severity="danger"
                        @click="acceptCallback"
                        class="w-[8rem]"
                    >
                        <template #loadingicon>
                            <Spinner
                                class="flex items-center justify-center"
                            ></Spinner>
                        </template>
                    </Button>
                </div>
            </div> </template
    ></ConfirmDialog>
    <div>
        <DataTable
            showGridLines
            v-model:expandedRows="expandedRows"
            :value="props.users"
            ripple
            @row-click="rowClicked"
            tableStyle="min-width: fit-content"
        >
            <Column field="id" header="Id" style="width: 3%">
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
            <Column
                field="name"
                header="Name"
                style="width: fit-content"
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
                            class="grid grid-cols-2 place-content-center items-center"
                        >
                            <span>{{ user.data.name }}</span>
                            <div class="justify-self-end">
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
                                    @click="toggleClicked(user.data.id)"
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
                                :label="`Ban`"
                                severity="warning"
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
