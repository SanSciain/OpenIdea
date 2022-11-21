<template>
    <div class="">
        <h1>Dashboard</h1>
        <div class="container-fluid">
            <div class="row">
                <div class="col col-6">
                    <div
                        class="container-fluid border border-5 p-5 rounded ms-color d-flex justify-content-center align-items-center"
                    >
                        <router-link :to="{ name: 'IdeaOwnedIndex' }"
                            >See your ideas</router-link
                        >
                    </div>
                </div>
                <div class="col col-6">
                    <div
                        class="container-fluid border border-5 p-5 rounded ms-color d-flex justify-content-center align-items-center"
                    >
                        <router-link :to="{ name: 'IdeaCreate' }"
                            >Create a brand new idea</router-link
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
};
</script>

<style lang="scss" scoped>
.ms-color {
    background-color: #f8f9fa;
}
</style>
