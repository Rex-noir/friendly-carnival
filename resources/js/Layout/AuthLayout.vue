<script setup lang="ts">
import Login from "@/Pages/Auth/Login.vue";
import Signup from "@/Pages/Auth/Signup.vue";
import { Link, usePage } from "@inertiajs/vue3";
import Card from "primevue/card";
import { ref, watch } from "vue";

let currentComponent = ref(Login);
let link = ref("/auth/login");
const page = usePage();

watch(
    () => page.url,
    () => {
        if (page.url === "/auth" || page.url === "/auth/login") {
            currentComponent.value = Login;
            link.value = "/auth/signup";
        } else if (page.url === "/auth/signup") {
            currentComponent.value = Signup;
            link.value = "/auth/login";
        }
    },
    { immediate: true }
);
</script>
<template>
    <main
        class="min-h-screen p-3 grid md:grid-cols-12 my-auto bg-mobile md:bg-desktop"
    >
        <div class="hidden md:block">Yo</div>
        <Card
            style="overflow: hidden; height: 98%"
            class="dark:shadow-slate-800 my-auto flex flex-col justify-center sm:col-start-8 sm:col-end-13 w-full"
        >
            <template #header
                ><div class="w-full grid place-content-center">
                    <span class="material-icons text-green-600 text-6xl"
                        >auto_stories</span
                    >
                </div>
            </template>
            <template #title>
                <span class="block text-center">BookStore</span>
            </template>
            <template #subtitle>
                <span class="block text-center">Authentication</span></template
            >
            <template #content>
                <component :is="currentComponent" />
            </template>
            <template #footer>
                <div class="text-center text-sm">
                    <span
                        >Don't have account?
                        <Link
                            :href="link"
                            class="underline underline-offset-2 text-green-500 hover:text-blue-500"
                            >{{
                                link === "/auth/signup" ? "Sign Up" : "Sign In"
                            }}</Link
                        ></span
                    >
                    <p>Copyright &copy; BookSore</p>
                </div>
            </template>
        </Card>
    </main>
</template>
