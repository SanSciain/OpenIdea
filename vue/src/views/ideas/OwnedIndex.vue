<template>
    <div>
        <h1>Owned ideas</h1>
        <div class="container" v-if="ideaFlag">
            <div class="row justify-content-start">
                <div v-for="idea in ideas" class="col col-3">
                    <div class="card" style="width: 18rem">
                        <div class="card-body">
                            <h5 class="card-title">{{ idea.title }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                {{ idea.slug }}
                            </h6>
                            <p class="card-text">{{ idea.text }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" v-else>
            <p>Seems you haven't any ideas</p>
        </div>
    </div>
</template>

<script>
import store from "../../store";
export default {
    name: "OwnedIndex",
    data() {
        return {
            ideas: [],
            ideaFlag: true,
        };
    },
    created() {
        this.getIdeas();
    },
    methods: {
        getIdeas() {
            store.dispatch("getIdeasOwned").then((resp) => {
                if (resp.data) {
                    this.ideaFlag = true;
                    this.ideas = resp.data[0];
                } else {
                    this.ideaFlag = false;
                }
            });
        },
    },
};
</script>

<style lang="scss" scoped></style>
