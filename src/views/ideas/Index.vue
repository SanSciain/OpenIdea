<template>
    <div>
        <h1>All ideas</h1>
        <div class="container" v-if="ideaFlag">
            <div class="row justify-content-start g-5">
                <div
                    v-for="(idea, index) in ideas"
                    :key="index"
                    class="col col-3"
                >
                    <div class="card h-100">
                        <router-link
                            :to="{
                                name: 'IdeaShow',
                                params: { slug: idea.slug },
                            }"
                        >
                            <div class="card-body">
                                <h5 class="card-title">{{ idea.title }}</h5>

                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ idea.slug }}
                                </h6>
                                <p class="card-text">{{ idea.text }}</p>
                            </div>
                        </router-link>
                        <p>
                            Number of people interested in the idea:
                            <span>{{ idea.interested }}</span>
                        </p>
                        <span
                            :id="idea.id"
                            class="ms-badge"
                            @click="interestedToggle(idea.id, index)"
                            >+</span
                        >
                    </div>
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
        interestedToggle(id, index) {
            store
                .dispatch("interestedtoggle", id)
                .then((resp) => {
                    let text = null;
                    switch (resp.data) {
                        case 1:
                            text = "You are no longer interested by the idea";
                            this.ideas[index].interested--;
                            break;
                        case 2:
                            text = "You are now interested by the idea";
                            this.ideas[index].interested++;
                            break;
                        default:
                            text = "You can't get interested in your own idea";
                    }
                    alert(text);
                })
                .catch((e) => {
                    //create an error message
                });
        },
    },
};
</script>

<style lang="scss" scoped>
.ms-badge {
    width: 50px;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    border: 2px solid black;
    border-radius: 50%;
    margin-left: 10px;
    cursor: pointer;
}

.card-body {
    border-bottom: 2px dotted black;
}
.card {
    border: 2px solid black;
    padding: 1rem;
    margin: 2rem;
}
</style>
