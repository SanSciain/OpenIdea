<template>
    <div class="container w-50 p-4">
        <h1>Login</h1>
        <div class="container">
            <ul>
                <li v-for="error in errors">
                    <p class="text-danger">{{ error[0] }}</p>
                </li>
            </ul>
        </div>
        <form @submit="login">
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <input
                        type="text"
                        class="form-control"
                        id="email"
                        placeholder="Email"
                        v-model="user.email"
                    />
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        placeholder="Password"
                        v-model="user.password"
                    />
                </div>
            </div>
            <div class="form-check form-switch">
                <input
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                    id="remember"
                    v-model="user.remember"
                />
                <label class="form-check-label" for="remember"
                    >Remember me</label
                >
            </div>
            <button type="submit">Login</button>
        </form>
        <router-link :to="{ name: 'Register' }">Register now</router-link>
    </div>
</template>

<script setup>
import store from "../store";
import { useRouter } from "vue-router";
import { ref } from "vue";
const router = useRouter();
const user = {
    email: "",
    password: "",
    remember: false,
};
const errors = ref({});
function login(ev) {
    ev.preventDefault();
    store
        .dispatch("login", user)
        .then(() => {
            console.log("giusto");
            router.push({
                name: "Dashboard",
            });
        })
        .catch((err) => {
            errors.value = err.response.data.errors;
        });
}
</script>

<style lang="scss" scoped></style>
