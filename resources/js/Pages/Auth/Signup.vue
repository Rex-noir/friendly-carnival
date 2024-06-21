<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import FloatLabel from "primevue/floatlabel";
import Password from "primevue/password";
import password from "@/presets/aura/password";
import Button from "primevue/button";
import Checkbox from "primevue/checkbox";

const form = useForm({
    username: null,
    password: null,
    email: null,
    author: false,
    remember: false,
});
</script>
<template>
    <form @submit.prevent="form.post('/auth/signup/submit')">
        <div class="grid place-content-center mt-4 gap-6">
            <FloatLabel>
                <InputText
                    class="w-full"
                    id="username"
                    v-model="form.username"
                />
                <label for="username">Username</label>
            </FloatLabel>
            <FloatLabel>
                <InputText class="w-full" id="email" v-model="form.email" />
                <label for="username">Email</label>
            </FloatLabel>
            <FloatLabel>
                <Password id="password" v-model="form.password" toggleMask />
                <label for="password">Password</label>
            </FloatLabel>
            <div class="mx-auto">
                <Checkbox
                    v-model="form.author"
                    inputId="author"
                    name="author"
                    value="author"
                />
                <label for="ingredient1" class="ml-2">
                    Create author account.
                </label>
            </div>
            <Button
                type="submit"
                label="Log In"
                class="w-fit mx-auto"
                v-ripple
            />
        </div>
    </form>
</template>
