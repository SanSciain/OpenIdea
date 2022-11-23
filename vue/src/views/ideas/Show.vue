<template>
    <div>
        <div v-if="!nullFlag">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ idea.title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        {{ idea.slug }}
                    </h6>
                    <p class="card-text">
                        {{ idea.text }}
                    </p>
                </div>
            </div>
        </div>
        <div v-else>
            <h3 class="text-center text-danger">This idea no longer exist</h3>
        </div>
    </div>
</template>

<script>
import store from "../../store";
export default {
    name: "Show",
    data() {
        return {
            idea: {
                title: "",
                slug: "",
                text: "",
            },
            nullFlag: false,
        };
    },
    created() {
        this.getIdeaShow();
    },
    methods: {
        getIdeaShow() {
            store.dispatch("getIdeaShow").then((resp) => {
                if (resp.isNull) {
                    this.nullFlag = true;
                } else {
                    this.idea = resp.data;
                    return resp;
                }
            });
        },
    },
};
</script>

<style lang="scss" scoped></style>
