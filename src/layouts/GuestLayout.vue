<template>
    <div>
        <Header />
        <h1>Not Auth</h1>
        <router-view></router-view>
    </div>
</template>

<script>
import Header from "../components/Header.vue";
export default {
    name: "GuestLayout",
    components: {
        Header,
    },
};
</script>

<style lang="scss" scoped></style>
