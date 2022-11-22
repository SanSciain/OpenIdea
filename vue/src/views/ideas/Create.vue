<template>
    <div>
        <div class="container">
            <form @submit="postIdeaStore">
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

                <div class="mb-3">
                    <div id="tagsSelected" class="d-flex">
                        <span
                            v-for="el in tagsSelected"
                            class="badge rounded-pill bg-success py-2 ps-4 pe-3 d-flex align-items-center ms-badge"
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
                        >Tags* :</label
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
                        :disabled="!selectedFlag"
                        @click="addTag"
                    >
                        Add +
                    </button>
                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="submitDisable"
                    id="submitButton"
                >
                    Submit
                </button>
            </form>

            <p class="text-center">* These fields are required</p>
        </div>
    </div>
</template>

<script>
import store from "../../store";
import router from "../../router";
export default {
    name: "Create",
    data() {
        return {
            // title: "",
            // text: "",
            tagSearched: "",
            tagSelected: "",
            submitDisable: true,
            tagsMatching: [],
            tagsSelected: [],
            // requesto.tags: [],
            selectedFlag: false,
            tagAlreadyAddedFlag: false,
            tagSelectedId: null,
            requesto: {
                title: "",
                text: "",
                tags: [],
            },
        };
    },
    methods: {
        checkField() {
            if (this.requesto.title.length && this.requesto.text.length) {
                this.submitDisable = false;
            }
        },

        tagSearch() {
            this.selectedFlag = false;
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

        // tagSearch() {
        //     store
        //         .dispatch("getMatchingTags", {
        //             tagSearched: this.tagSearched,
        //         })
        //         .then((resp) => {
        //             if (resp.data[0].length) {
        //                 this.tagsMatching = resp.data[0];
        //                 this.matchFlag = true;
        //             } else {
        //                 this.matchFlag = false;
        //             }
        //         });
        // },

        selectMatchingTag() {
            this.tagSearched = this.tagSelected.name;
            this.selectedFlag = true;
            this.tagSelectedId = this.tagSelected.id;
        },

        addTag() {
            if (
                this.selectedFlag &&
                !this.requesto.tags.includes(this.tagSelectedId)
            ) {
                this.tagsSelected.push(this.tagSelected);
                this.requesto.tags.push(this.tagSelectedId);
                this.tagSearched = "";
            } else if (this.requesto.tags.includes(this.tagSelectedId)) {
                this.tagAlreadyAddedFlag = true;
            }
        },

        removeTag(tag) {
            let positionN = this.tagsSelected.indexOf(tag.name);
            this.tagsSelected.splice(positionN, 1);
            let positionI = this.tagsSelected.indexOf(tag.id);
            this.requesto.tags.splice(positionI, 1);
        },

        // Add removing tag

        // Add controll if tag is already added

        postIdeaStore(ev) {
            ev.preventDefault();
            const req = _.cloneDeep(this.requesto);
            store.dispatch("postIdeaStore", req).then((res) => {
                router.push({
                    name: "Dashboard",
                });
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
