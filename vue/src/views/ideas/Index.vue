<template>
    <div>
        <h1>All ideas</h1>
        <div class="container" v-if="ideaFlag">
            <div class="row justify-content-start g-5">
                <div v-for="idea in ideas" class="col col-3">
                    <router-link
                        :to="{
                            name: 'IdeaShow',
                            params: { slug: idea.slug },
                        }"
                    >
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ idea.title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ idea.slug }}
                                </h6>
                                <p class="card-text">{{ idea.text }}</p>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="container" v-else>
            <p>Seems there aren't any ideas :c</p>
        </div>
    </div>
</template>

<script>
import store from "../../store";
export default {
    name: "Index",
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
            store.dispatch("getIdeas").then((resp) => {
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
