<template>
    <div class="container w-50 p-4">
        <h1>Register</h1>
        <form @submit="register">
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        placeholder="Username"
                        v-model="user.name"
                    />
                </div>
            </div>

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
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <input
                        type="password"
                        class="form-control"
                        id="password-confirmation"
                        placeholder="Confirm Password"
                        v-model="user.password_confirmation"
                    />
                </div>
            </div>
            <button type="submit">Register</button>
        </form>
        <router-link :to="{ name: 'Login' }">Log to your account</router-link>
    </div>
</template>

<script setup>
import store from "../store/index";
import { useRouter } from "vue-router";
const router = useRouter();
const user = {
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
};
function register(ev) {
    ev.preventDefault();
    store.dispatch("register", user).then(() => {
        router.push({
            name: "Dashboard",
        });
    });
    // .catch((error) => {
    //     if (error.response.status === 422) {
    //         errors.value = error.response.data.errors;
    //     }
    // });
}
</script>

<style lang="scss" scoped></style>
