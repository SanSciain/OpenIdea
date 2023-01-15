<template>
    <div>
        <Header />
        <h1>Auth</h1>
        <router-view></router-view>
    </div>
</template>

<script>
import Header from "../components/Header.vue";
export default {
    name: "MainLayout",
    components: {
        Header,
    },
};
</script>

<style lang="scss" scoped></style>
