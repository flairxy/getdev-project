import Vue from "vue";
import Vuex from "vuex";
import "es6-promise/auto";
import router from "../router";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        chapters: [],
        title: null,
        outlines: []
    },
    getters: {
        getChapters: state => {
            return state.chapters;
        },
        getOutlines: state => {
            return state.outlines;
        }
    },
    mutations: {
        storeChapter(state, courseData) {
            state.chapters = courseData.chapters;
            state.title = courseData.title;
        },
        storeExtraChapter(state, courseData) {
            state.chapters = [...state.chapters, ...courseData.chapters];
        },
        storeOutline(state, courseData) {
            state.outlines = [...state.outlines, ...courseData.outline];
        },
        deleteOutline(state, data) {
            state.outlines = data.outlines;
        },
        deleteChapter(state, data) {
            state.chapters = data.chapters;
            state.outlines = data.outlines;
        }
    },
    actions: {
        storeCourseData({ commit }, data) {
            let addChapters = [];
            for (let i = 1; i <= data.chapters; i++) {
                addChapters.push({
                    id: i
                });
            }
            commit("storeChapter", {
                title: data.title,
                chapters: addChapters
            });

            // dispatch is used to call another action function
            // dispatch("fetchStudent", user);
        },
        storeNewOutline({ commit }, data) {
            let addChapters = [];
            for (let i = 1; i <= data.chapters; i++) {
                addChapters.push({
                    id: i
                });
            }
            commit("storeOutline", {
                outline: [
                    {
                        title: data.title,
                        chapter: data.chapter,
                        id: data.id
                    }
                ]
            });
        },
        storeNewChapter({ commit }, data) {
            let extraChapters = [];
            let lastChapter = [];
            // get the chapters in state
            lastChapter = this.getters.getChapters;
            // get the last chapter
            let totalChapter = lastChapter[lastChapter.length - 1];
            // add the value of the last chapter with the total number of chapters to be generated
            let x = parseInt(data.chapters) + parseInt(totalChapter.id);

            // the next chapter should start from the value of the last chapter + 1
            for (let i = totalChapter.id + 1; i <= x; i++) {
                extraChapters.push({
                    id: i
                });
            }
            commit("storeExtraChapter", {
                chapters: extraChapters
            });
        },
        deleteOutline({ commit }, data) {
            let newOutlines = [];
            let allOutlines = this.getters.getOutlines;
            allOutlines.map(outline => {
                if (
                    outline.id !== data.id &&
                    outline.chapter !== data.chapter
                ) {
                    newOutlines.push(outline);
                }
            });
            commit("deleteOutline", {
                outlines: newOutlines
            });
        },
        deleteChapter({ commit, dispatch }, data) {
            let newChapters = [];
            let newOutlines = [];
            let outlines = this.getters.getOutlines;
            let allChapters = this.getters.getChapters;
            if (allChapters.length >= 2) {
                allChapters.map(chapter => {
                    if (chapter.id !== data.chapter) {
                        newChapters.push(chapter);
                    }

                    outlines.map(outline => {
                        if (outline.chapter !== chapter.id) {
                            console.log(outlines);
                            // newOutlines.push(outline);
                        }
                    });
                    // delete all outlines with the chapter id
                    // dispatch("deleteOutline", data);
                });
                // commit("deleteChapter", {
                //     chapters: newChapters,
                //     outlines: newOutlines
                // });
            } else {
                swal.fire(
                    "Failed!",
                    "You must have at least one chapter.",
                    "warning"
                );
            }
        }
    }
});
