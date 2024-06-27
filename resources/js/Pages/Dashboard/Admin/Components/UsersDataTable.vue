<script setup lang="ts">
import DataTable, { DataTableRowClickEvent } from "primevue/datatable";
import Column from "primevue/column";
import { User } from "@/types/users.interface";
import { onMounted, reactive, ref } from "vue";
import Card from "primevue/card";
import Button from "primevue/button";
import ToggleButton from "primevue/togglebutton";
import InputText from "primevue/inputtext";
import UserUtils from "@/utils/user";
import Spinner from "@/Pages/Components/Spinner.vue";
import { debounce } from "lodash";

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
            loading[id] = false;
            updateStatus[id] = "Failed!";
            debounce(() => (updateStatus[id] = ""), 2000)();
            throw error;
        }
    }
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
                <Card>
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
                                        'Updated!'
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
                                    type="text"
                                    size="small"
                                    class="col-span-11 col-start-1 w-full"
                                    :disabled="!editEmail[user.data.id]"
                                    placeholder="Small"
                                />
                                <ToggleButton
                                    v-model="editEmail[user.data.id]"
                                    v-on:change="
                                        (e) => updateEmail(user.data.id)
                                    "
                                    offIcon="pi pi-pencil"
                                    onIcon="pi pi-check"
                                    on-label=" "
                                    off-label=" "
                                    class="rounded-full col-start-12 self-start"
                                />
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
                                severity="danger"
                            />
                        </div>
                    </template>
                </Card>
            </template>
        </DataTable>
    </div>
</template>
