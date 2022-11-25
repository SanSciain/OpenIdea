<template>
    <div>
        <div v-if="!noFoundFlag">
            <div class="card m-5">
                <div class="card-body">
                    <h5 class="card-title">{{ idea.title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        {{ idea.slug }}
                    </h6>
                    <div class="d-flex" v-if="tags.length">
                        <span
                            v-for="tag in tags"
                            class="badge rounded-pill bg-success pt-1 pb-2 px-3"
                            :class="tags[0] === tag ? '' : 'ms-2'"
                            >{{ tag.name }}</span
                        >
                    </div>
                    <div class="d-flex my-3" v-if="roles.length">
                        <span
                            v-for="role in roles"
                            class="badge rounded-pill bg-warning pt-1 pb-2 px-3 text-body"
                            :class="roles[0] === role ? '' : 'ms-2'"
                            >{{ role.name }}</span
                        >
                    </div>
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
            tags: [],
            roles: [],
            noFoundFlag: false,
        };
    },
    created() {
        this.getIdeaShow();
    },
    methods: {
        getIdeaShow() {
            this.noFoundFlag = false;
            const slug = this.$route.params.slug;
            store
                .dispatch("getIdeaShow", slug)
                .then((resp) => {
                    if (resp.data) {
                        this.idea = resp.data[0];
                        this.tags = resp.data[1];
                        this.roles = resp.data[2];
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
