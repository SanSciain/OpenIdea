<template>
    <div>
        <div v-if="!noFoundFlag">
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
            <h3 class="text-center text-danger">Idea not found</h3>
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
            noFoundFlag: false,
        };
    },
    created() {
        this.getIdeaShow();
    },
    methods: {
        // we have to pass the id of the idea we wanna show

        getIdeaShow() {
            this.noFoundFlag = false;
            const slug = this.$route.params.slug;
            store
                .dispatch("getIdeaShow", slug)
                .then((resp) => {
                    if (resp.data) {
                        this.idea = resp.data;
                    }
                })
                .catch((er) => {
                    this.noFoundFlag = true;
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
