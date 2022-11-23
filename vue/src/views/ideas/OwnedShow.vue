<template>
    <div>
        <div v-if="!notOwnedFlag && !noFoundFlag">
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
        <div v-else-if="notOwnedFlag && !noFoundFlag">
            <h3 class="text-center text-danger">You don't own this idea</h3>
        </div>
        <div v-else>
            <h3 class="text-center text-danger">Idea not found</h3>
        </div>
    </div>
</template>

<script>
import store from "../../store";
export default {
    name: "OwnedShow",
    data() {
        return {
            idea: {
                title: "",
                slug: "",
                text: "",
            },
            notOwnedFlag: false,
            noFoundFlag: false,
        };
    },
    created() {
        this.getIdeaShowOwned();
    },
    methods: {
        // we have to pass the id of the idea we wanna show

        getIdeaShowOwned() {
            this.notOwnedFlag = false;
            this.noFoundFlag = false;
            const slug = this.$route.params.slug;
            store
                .dispatch("getIdeaShowOwned", slug)
                .then((resp) => {
                    if (resp.data) {
                        this.idea = resp.data;
                    } else {
                        this.notOwnedFlag = true;
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
