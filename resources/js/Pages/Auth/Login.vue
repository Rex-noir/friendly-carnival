<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import FloatLabel from "primevue/floatlabel";
import Password from "primevue/password";
import Button from "primevue/button";
import Checkbox from "primevue/checkbox";
import InlineMessage from "primevue/inlinemessage";

const form = useForm({
    email: null,
    password: null,
    remember: false,
});
</script>
<template>
    <form @submit.prevent="form.post('/auth/login/submit')">
        <div class="grid place-content-center mt-4 gap-7">
            <InlineMessage v-show="form.errors.email" severity="error">{{
                form.errors.email
            }}</InlineMessage>
            <FloatLabel>
                <InputText class="w-full" id="username" v-model="form.email" />
                <label for="username">Email</label>
            </FloatLabel>
            <FloatLabel>
                <Password id="password" v-model="form.password" toggleMask />
                <label for="password">Password</label>
            </FloatLabel>
            <div class="flex items-center justify-center">
                <Checkbox
                    v-model="form.remember"
                    inputId="remember"
                    name="remember"
                    value="remember"
                />
                <label for="ingredient1" class="ml-2"> Remember me. </label>
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
