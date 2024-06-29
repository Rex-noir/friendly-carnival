<script setup lang="ts">
import DataTable, { DataTableRowClickEvent } from "primevue/datatable";
import Column from "primevue/column";
import { User } from "@/types/users.interface";
import { onMounted, reactive, ref, watch } from "vue";
import Card from "primevue/card";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import UserUtils from "@/utils/user";
import Spinner from "@/Pages/Components/Spinner.vue";
import { debounce } from "lodash";
import axios from "axios";
import { useConfirm } from "primevue/useconfirm";

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
        handleTableActions(id, "update");
    }
};
const handleTableActions = async (id: number, action: "update" | "delete") => {
    try {
        loading[id] = true;
        updateStatus[id] = "";

        if (action === "update") {
            await UserUtils.update({ id: id, email: emailModel[id] });
            updateStatus[id] = "Updated!";
        } else {
            await UserUtils.delete(id);
            updateStatus[id] = "Deleted!";
            createRefsForTable();
            updateTableOnDelete(id);
            emit("updateTable");
        }
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

const updateTableOnDelete = (id: number) => {
    const userIndex = (props.users as User[]).findIndex(
        (user) => user.id === id
    );
    if (userIndex !== -1) {
        props.users.splice(userIndex, 1);
        expandedRows.value = expandedRows.value.filter(
            (user) => user.id !== id
        );
    }
};

const deleteConfirm = (user: User) => {
    confirm.require({
        message: `This action can't be undone.`,
        header: `${user.name}`,
        icon: "pi pi-exclamation-triangle",
        accept: () => {
            handleTableActions(user.id, "delete");
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
