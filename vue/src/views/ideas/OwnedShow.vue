<template>
    <div class="position-realtive">
        <div
            v-if="!notOwnedFlag && !noFoundFlag"
            :class="deleteAlertFlag ? 'pe-none opacity-50' : ''"
        >
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
                            v-for="(role, index) in roles"
                            :class="roles[0] === role ? '' : 'ms-2'"
                        >
                            <span
                                class="badge rounded-pill bg-warning pt-1 pb-2 px-3 text-body ms-badge"
                                @click="
                                    rolesMenuFlag[role.id] =
                                        !rolesMenuFlag[role.id]
                                "
                                >{{ role.name }}:
                                <span class="fst-italic">
                                    {{
                                        usersSelected[role.id]
                                            ? usersSelected[role.id]
                                            : "vacant"
                                    }}</span
                                >
                            </span>
                            <div v-if="rolesMenuFlag[role.id]">
                                <select
                                    class="form-select"
                                    size="3"
                                    v-model="usersSelected[role.id]"
                                    @click="rolesMenuFlag[role.id] = false"
                                >
                                    <option value="">None</option>
                                    <option
                                        v-for="applier in applingUsers[index]"
                                    >
                                        {{ applier.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <p class="card-text">
                        {{ idea.text }}
                    </p>
                    <router-link :to="{ name: 'IdeaEdit' }"
                        ><span class="btn btn-info">Edit</span></router-link
                    >
                    <button
                        class="btn btn-danger ms-2"
                        type="button"
                        @click="deleteAlertFlag = true"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
        <div v-else-if="notOwnedFlag && !noFoundFlag">
            <h3 class="text-center text-danger">You don't own this idea</h3>
        </div>
        <div v-else>
            <h3 class="text-center text-danger">Idea not found</h3>
        </div>
        <div
            v-if="deleteAlertFlag"
            class="position-absolute top-50 start-50 translate-middle bg-secondary p-5 rounded-3 pe-auto opacity-100"
        >
            <p>Are you sure to delete this idea?</p>
            <div class="d-flex justify-content-around">
                <button
                    class="btn btn-danger"
                    type="button"
                    @click="deleteIdea"
                >
                    Yes
                </button>
                <button
                    class="btn btn-primary"
                    type="button"
                    @click="deleteAlertFlag = false"
                >
                    No
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import store from "../../store";
import router from "../../router";
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
            tags: [],
            roles: [],
            applingUsers: [],
            deleteAlertFlag: false,
            rolesMenuFlag: {},
            usersSelected: {},
        };
    },
    created() {
        this.getIdeaShowOwned();
    },
    methods: {
        getIdeaShowOwned() {
            this.notOwnedFlag = false;
            this.noFoundFlag = false;
            const slug = this.$route.params.slug;
            store
                .dispatch("getIdeaShowOwned", slug)
                .then((resp) => {
                    if (resp.data) {
                        this.idea = resp.data[0];
                        this.tags = resp.data[1];
                        this.roles = resp.data[2];
                        this.applingUsers = resp.data[3];
                        this.setRolesMenuFlag();
                    } else {
                        this.notOwnedFlag = true;
                    }
                })
                .catch((er) => {
                    this.noFoundFlag = true;
                });
        },

        deleteIdea() {
            const slug = this.$route.params.slug;
            store
                .dispatch("deleteIdea", slug)
                .then((resp) => {
                    if (resp.data) {
                        router.push({ name: "IdeaOwnedIndex" });
                    } else {
                        this.notOwnedFlag = true;
                    }
                })
                .catch((er) => {
                    this.noFoundFlag = true;
                });
        },
        setRolesMenuFlag() {
            this.roles.forEach((role) => {
                this.rolesMenuFlag[role.id] = false;
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.form-select {
    overflow-y: auto;
}

.ms-badge {
    cursor: pointer;
}
</style>
