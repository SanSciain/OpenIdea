<template>
    <div>
        <div class="container">
            <form action="">
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold"
                        >Title *:</label
                    >
                    <input
                        type="text"
                        class="form-control"
                        name="title"
                        id="title"
                        v-model="title"
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
                        v-model="text"
                        @keyup="checkField"
                    ></textarea>
                </div>

                <div class="mb-3">
                    <div id="tagsSelected"></div>
                    <div id="tagAlreadyAdded" class="d-none">
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
                            @change="tagSearched = tagSelected"
                        >
                            <option
                                value=""
                                v-if="!matchFlag"
                                selected
                                disabled
                            >
                                No tag found
                            </option>
                            <option
                                v-else
                                v-for="tag in tagsMatching"
                                :value="tag.name"
                            >
                                {{ tag.name }}
                            </option>
                        </select>
                    </div>

                    <button
                        type="button"
                        id="add-tag-btn"
                        class="btn btn-success"
                        disabled
                        @click=""
                    >
                        Add +
                    </button>
                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                    disabled
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
export default {
    name: "Create",
    data() {
        return {
            title: "",
            text: "",
            tagSearched: "",
            tagSelected: "",
            submitDisable: true,
            matchFlag: false,
            tagsMatching: [],
        };
    },
    methods: {
        checkField() {
            if (this.title.length && this.text.length) {
                this.submitDisable = false;
            }
        },

        // tagSearch() {
        //     if (this.tagSearched.length) {
        //         store
        //             .dispatch("getMatchingTags", {
        //                 tagSearched: this.tagSearched,
        //             })
        //             .then((resp) => {
        //                 if (resp.data[0].length) {
        //                     this.tagsMatching = resp.data[0];
        //                     this.matchFlag = true;
        //                 } else {
        //                     this.matchFlag = false;
        //                 }
        //             });
        //     }
        // },

        tagSearch() {
            store
                .dispatch("getMatchingTags", {
                    tagSearched: this.tagSearched,
                })
                .then((resp) => {
                    if (resp.data[0].length) {
                        this.tagsMatching = resp.data[0];
                        this.matchFlag = true;
                    } else {
                        this.matchFlag = false;
                    }
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
