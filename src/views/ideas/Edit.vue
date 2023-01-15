<template>
    <div>
        <div class="container" v-if="!notOwnedFlag && !noFoundFlag">
            <form @submit="updateIdea">
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold"
                        >Title *:</label
                    >
                    <input
                        type="text"
                        class="form-control"
                        name="title"
                        id="title"
                        v-model="requesto.title"
                        @keyup="checkField"
                    />
                </div>

                <div class="mb-3">
                    <label for="text" class="form-label fw-bold">Text *:</label>
                    <textarea
                        type="text"
                        class="form-control"
                        name="text"
                        id="text"
                        v-model="requesto.text"
                        @keyup="checkField"
                    ></textarea>
                </div>

                <!-- Tags Form -->
                <div class="mb-3">
                    <div id="tagsSelected" class="d-flex">
                        <span
                            v-for="(el, index) in tagsSelected"
                            class="badge rounded-pill bg-success py-2 ps-4 pe-3 d-flex align-items-center ms-badge"
                            :class="index === 0 ? '' : 'ms-2'"
                            >{{ el.name
                            }}<button
                                type="button"
                                class="btn-close btn-close-white ms-2"
                                aria-label="Close"
                                @click="removeTag(el)"
                            ></button
                        ></span>
                    </div>

                    <div id="tagAlreadyAdded" v-if="tagAlreadyAddedFlag">
                        <p class="text-center text-danger">Tag already added</p>
                    </div>
                    <label for="tagSearchbar" class="form-label fw-bold"
                        >Tags :</label
                    >
                    <input
                        type="text"
                        class="form-control"
                        name="tagSearchbar"
                        id="tagSearchbar"
                        v-model="tagSearched"
                        @keyup="tagSearch"
                    />
                    <div
                        id="containerSearchedTag"
                        v-if="
                            tagSearched.length > 0 &&
                            tagSearched !== tagSelected
                        "
                    >
                        <select
                            name="tagList"
                            id="tagList"
                            class="form-select w-100"
                            size="3"
                            v-model="tagSelected"
                            @click="selectMatchingTag"
                        >
                            <option
                                value=""
                                v-if="!tagsMatching.length"
                                selected
                                disabled
                            >
                                No tag found
                            </option>
                            <option
                                v-else
                                v-for="tag in tagsMatching"
                                :value="{ id: tag.id, name: tag.name }"
                            >
                                {{ tag.name }}
                            </option>
                        </select>
                    </div>

                    <button
                        type="button"
                        id="add-tag-btn"
                        class="btn btn-success"
                        :disabled="!selectedTagFlag"
                        @click="addTag"
                    >
                        Add +
                    </button>
                </div>
                <!-- /Tags Form -->

                <!-- Roles Form -->
                <div class="mb-3">
                    <div id="rolesSelected" class="d-flex">
                        <span
                            v-for="(el, index) in rolesSelected"
                            class="badge rounded-pill bg-warning text-body py-2 ps-4 pe-3 d-flex align-items-center ms-badge"
                            :class="index === 0 ? '' : 'ms-2'"
                            >{{ el.name
                            }}<button
                                type="button"
                                class="btn-close ms-2"
                                aria-label="Close"
                                @click="removeRole(el)"
                            ></button
                        ></span>
                    </div>

                    <div id="roleAlreadyAdded" v-if="roleAlreadyAddedFlag">
                        <p class="text-center text-danger">
                            role already added
                        </p>
                    </div>
                    <label for="roleSearchbar" class="form-label fw-bold"
                        >Roles :</label
                    >
                    <input
                        type="text"
                        class="form-control"
                        name="roleSearchbar"
                        id="roleSearchbar"
                        v-model="roleSearched"
                        @keyup="roleSearch"
                    />
                    <div
                        id="containerSearchedrole"
                        v-if="
                            roleSearched.length > 0 &&
                            roleSearched !== roleSelected
                        "
                    >
                        <select
                            name="roleList"
                            id="roleList"
                            class="form-select w-100"
                            size="3"
                            v-model="roleSelected"
                            @click="selectMatchingRole"
                        >
                            <option
                                value=""
                                v-if="!rolesMatching.length"
                                selected
                                disabled
                            >
                                No role found
                            </option>
                            <option
                                v-else
                                v-for="role in rolesMatching"
                                :value="{ id: role.id, name: role.name }"
                            >
                                {{ role.name }}
                            </option>
                        </select>
                    </div>

                    <button
                        type="button"
                        id="add-role-btn"
                        class="btn btn-success"
                        :disabled="!selectedRoleFlag"
                        @click="addRole"
                    >
                        Add +
                    </button>
                </div>
                <!-- /Roles Form -->

                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="submitDisable"
                    id="submitButton"
                >
                    Submit
                </button>
            </form>
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
import router from "../../router";
export default {
    name: "Edit",
    data() {
        return {
            submitDisable: false,
            notOwnedFlag: false,
            noFoundFlag: false,
            // Tags Data
            tagSearched: "",
            tagSelected: "",
            tagsMatching: [],
            tagsSelected: [],
            selectedTagFlag: false,
            tagAlreadyAddedFlag: false,
            tagSelectedId: null,
            // Roles Data
            roleSearched: "",
            roleSelected: "",
            rolesMatching: [],
            rolesSelected: [],
            selectedRoleFlag: false,
            roleAlreadyAddedFlag: false,
            roleSelectedId: null,

            requesto: {
                title: "",
                text: "",
                tags: [],
                roles: [],
            },
        };
    },
    created() {
        this.getIdeaShowOwned();
    },
    methods: {
        checkField() {
            this.submitDisable = true;
            if (this.requesto.title.length && this.requesto.text.length) {
                this.submitDisable = false;
            }
        },

        // Tags Function
        tagSearch() {
            this.selectedTagFlag = false;
            this.tagAlreadyAddedFlag = false;
            if (this.tagSearched.length) {
                store
                    .dispatch("getMatchingTags", {
                        tagSearched: this.tagSearched,
                    })
                    .then((resp) => {
                        if (resp.data[0].length) {
                            this.tagsMatching = resp.data[0];
                        }
                    });
            } else {
                this.tagsMatching = [];
            }
        },

        selectMatchingTag() {
            this.tagSearched = this.tagSelected.name;
            this.selectedTagFlag = true;
            this.tagSelectedId = this.tagSelected.id;
        },

        addTag() {
            if (
                this.selectedTagFlag &&
                !this.requesto.tags.includes(this.tagSelectedId)
            ) {
                this.tagsSelected.push(this.tagSelected);
                this.requesto.tags.push(this.tagSelectedId);
                this.tagSearched = "";
                this.tagAlreadyAddedFlag = false;
            } else if (this.requesto.tags.includes(this.tagSelectedId)) {
                this.tagAlreadyAddedFlag = true;
            }
            this.selectedTagFlag = false;
        },

        removeTag(tag) {
            let positionN = this.tagsSelected.indexOf(tag.name);
            this.tagsSelected.splice(positionN - 1, 1);
            let positionI = this.tagsSelected.indexOf(tag.id);
            this.requesto.tags.splice(positionI - 1, 1);
        },

        // Roles Functions
        roleSearch() {
            this.selectedRoleFlag = false;
            this.roleAlreadyAddedFlag = false;
            if (this.roleSearched.length) {
                store
                    .dispatch("getMatchingRoles", {
                        roleSearched: this.roleSearched,
                    })
                    .then((resp) => {
                        if (resp.data[0].length) {
                            this.rolesMatching = resp.data[0];
                        }
                    });
            } else {
                this.rolesMatching = [];
            }
        },

        selectMatchingRole() {
            this.roleSearched = this.roleSelected.name;
            this.selectedRoleFlag = true;
            this.roleSelectedId = this.roleSelected.id;
        },

        addRole() {
            if (
                this.selectedRoleFlag &&
                !this.requesto.roles.includes(this.roleSelectedId)
            ) {
                this.rolesSelected.push(this.roleSelected);
                this.requesto.roles.push(this.roleSelectedId);
                this.roleSearched = "";
                this.roleAlreadyAddedFlag = false;
            } else if (this.requesto.roles.includes(this.roleSelectedId)) {
                this.roleAlreadyAddedFlag = true;
            }
            this.selectedRoleFlag = false;
        },

        removeRole(role) {
            console.log("in edit remove role", role);
            let positionN = this.rolesSelected.indexOf(role.name);
            this.rolesSelected.splice(positionN - 1, 1);
            let positionI = this.rolesSelected.indexOf(role.id);
            this.requesto.roles.splice(positionI - 1, 1);
        },

        updateIdea(ev) {
            ev.preventDefault();
            const slug = this.$route.params.slug;
            const req = _.cloneDeep(this.requesto);
            store.dispatch("updateIdea", [slug, req]).then((res) => {
                router.push({
                    name: "IdeaOwnedShow",
                    params: {
                        slug: res.data.slug,
                    },
                });
            });
        },

        getIdeaShowOwned() {
            this.notOwnedFlag = false;
            this.noFoundFlag = false;
            const slug = this.$route.params.slug;
            store
                .dispatch("getIdeaShowOwned", slug)
                .then((resp) => {
                    if (resp.data) {
                        this.requesto.title = resp.data[0].title;
                        this.requesto.slug = resp.data[0].slug;
                        this.requesto.text = resp.data[0].text;
                        resp.data[1].forEach((element) => {
                            this.requesto.tags.push(element.id);
                        });
                        resp.data[2].forEach((element) => {
                            this.requesto.roles.push(element.id);
                        });
                        this.tagsSelected = resp.data[1];
                        this.rolesSelected = resp.data[2];
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

<style lang="scss" scoped>
.ms-badge {
    max-width: fit-content;
}
</style>
