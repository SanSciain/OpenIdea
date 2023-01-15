<template>
    <div>
        <div v-if="!noFoundFlag && !noIdeaOrNoRoleFlag">
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
                        <div
                            v-for="role in roles"
                            class="rounded-pill bg-warning px-3 py-2 text-body d-flex align-items-center"
                            :class="roles[0] === role ? '' : 'ms-2'"
                        >
                            <span>
                                {{ role.name }}
                            </span>
                            <div
                                class="ms-apply"
                                title="click to apply"
                                @click="applytoggle(role.id)"
                            >
                                <span>+</span>
                            </div>
                        </div>
                    </div>
                    <p class="card-text">
                        {{ idea.text }}
                    </p>
                </div>
            </div>
        </div>
        <div v-else-if="noFoundFlag">
            <h3 class="text-center text-danger">Idea not found</h3>
        </div>
        <div v-else>
            <h3 class="text-center text-danger">
                Idea not found or Role not found
            </h3>
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
            //Fix differenziare il controllo
            noIdeaOrNoRoleFlag: false,
            roleAssignedFlag: {},
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
                        this.setAssignedFlagToFalse();
                    }
                })
                .catch((er) => {
                    this.noFoundFlag = true;
                });
        },

        setAssignedFlagToFalse() {
            for (let i = 0; i < this.roles.length; i++) {
                this.roleAssignedFlag[i] = false;
            }
        },
        checkIfRoleAssigned() {},

        // apply(role_id) {
        //     this.noIdeaOrNoRoleFlag = false;
        //     const slug = this.$route.params.slug;
        //     store
        //         .dispatch("apply", [slug, role_id])
        //         .then((resp) => {
        //             alert(resp.data);
        //         })
        //         .catch((er) => {
        //             this.noIdeaOrNoRoleFlag = true;
        //         });
        // },
        // unapply(role_id) {
        //     this.noIdeaOrNoRoleFlag = false;
        //     const slug = this.$route.params.slug;
        //     store
        //         .dispatch("unapply", [slug, role_id])
        //         .then((resp) => {
        //             alert(resp.data);
        //         })
        //         .catch((er) => {
        //             this.noIdeaOrNoRoleFlag = true;
        //         });
        // },
        applytoggle(role_id) {
            this.noIdeaOrNoRoleFlag = false;
            const slug = this.$route.params.slug;
            store
                .dispatch("applytoggle", [slug, role_id])
                .then((resp) => {
                    alert(resp.data);
                })
                .catch((er) => {
                    this.noIdeaOrNoRoleFlag = true;
                });
        },
    },
};
</script>

<style lang="scss" scoped>
.ms-apply {
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
</style>
