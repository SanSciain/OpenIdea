<template>
    <div class="container w-50 p-4">
        <h1>Login</h1>
        <form action="">
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <input
                        type="text"
                        class="form-control"
                        id="email"
                        placeholder="Email"
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
                    />
                </div>
            </div>
            <button type="submit">Login</button>
        </form>
        <router-link :to="{ name: 'Register' }">Register now</router-link>
    </div>
</template>

<script>
export default {
    name: "Login",
};
</script>

<style lang="scss" scoped></style>
