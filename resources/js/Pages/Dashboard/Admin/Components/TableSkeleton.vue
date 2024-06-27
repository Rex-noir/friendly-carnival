<script setup lang="ts">
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { ref } from "vue";
import Skeleton from "primevue/skeleton";
import { fill } from "lodash";

const products = ref(fill(Array(11), undefined));
</script>
<template>
    <div class="card">
        <DataTable :value="products">
            <Column field="ID" header="ID">
                <template #body>
                    <Skeleton></Skeleton>
                </template>
            </Column>
            <Column field="name" header="Name">
                <template #body>
                    <Skeleton></Skeleton>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
