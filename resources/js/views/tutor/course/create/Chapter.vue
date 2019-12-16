<template>
  <div>
    <div class="bg-white-op-90 py-30">
      <div class="content">
        <ul class="list list-timeline list-timeline-modern pull-t">
          <li v-for="chapter in chapters">
            <div
              class="list-timeline-time font-w900 text-primary pointer"
              @click.prevent="chapterDelete(chapter.id)"
            >Chapter {{ chapter.id}}</div>
            <i class="list-timeline-icon fa fa-plus bg-primary"></i>
            <div class="list-timeline-content">
              <div class="row">
                <ol class="font-w700">
                  <li
                    class="mb-3"
                    v-for="outline in outlines"
                    v-if="chapter.id === outline.chapter"
                  >
                    <span class="ac-list" href="#">
                      <span class="text-dark font-w700">
                        &nbsp; {{ outline.title }} &nbsp; &nbsp;
                        <span>
                          <div class="btn-group">
                            <button
                              @click.prevent="deleteOutline(outline)"
                              type="button"
                              class="btn btn-sm btn-danger js-tooltip-enabled"
                              data-toggle="tooltip"
                              title
                              data-original-title="Delete"
                            >
                              <i class="fa fa-trash"></i>
                            </button>
                          </div>
                        </span>
                      </span>
                    </span>
                  </li>

                  <span class="ac-list" href="#">
                    <span class="text-dark font-w700" @click.prevent="showAddCourse(chapter.id)">
                      &nbsp;
                      <span class="text-primary pointer">
                        <i class="fa fa-plus text-primary"></i>
                        Add Course
                      </span>
                    </span>
                  </span>
                </ol>
              </div>
            </div>
          </li>
          <li @click.prevent="showAddChapter">
            <i class="list-timeline-icon fa fa-plus bg-primary"></i>
            <div class="list-timeline-content">
              <a href="#" class="font-w700 text-primary">Add Chapter</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <!-- add outline -->
    <div
      class="modal fade"
      id="modal-popin"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modal-popin"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-popin modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary">
              <h3 class="block-title">Add Course Outline</h3>
              <div class="block-options">
                <button
                  type="button"
                  class="btn-block-option"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <i class="si si-close"></i>
                </button>
              </div>
            </div>
            <div class="block-content">
              <form @submit.prevent="createOutline(chapter_id)">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-material">
                      <input type="text" class="form-control" v-model="form.course_title" />
                      <label class="text-white" for="amount">Title</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="form-material">
                      <div v-if="processing" class="col-6 col-md-3">
                        <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
                      </div>
                      <button v-else type="submit" class="btn btn-outline-primary mb-10">Add</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- add chapter -->

    <div
      class="modal fade"
      id="modal-popinX"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modal-popin"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-popin modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary">
              <h3 class="block-title">Add New Chapter</h3>
              <div class="block-options">
                <button
                  type="button"
                  class="btn-block-option"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <i class="si si-close"></i>
                </button>
              </div>
            </div>
            <div class="block-content">
              <form @submit.prevent="createChapter">
                <label class="col-12" for="chapter name">Number of chapters to be added</label>
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="number" class="form-control" v-model="form.chapters" />
                  </div>

                  <div class="form-group">
                    <div v-if="processing" class="col-6 col-md-3">
                      <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
                    </div>
                    <button v-else type="submit" class="btn btn-primary">Add</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    chapters: Array
  },
  data() {
    return {
      totalChapter: this.$props.chapters.id,
      processing: false,
      seeMore: false,
      outlines: [],
      course_id: "",
      form: new Form({
        course_title: "",
        chapters: ""
      })
    };
  },
  methods: {
    openMore() {
      this.seeMore = !this.seeMore;
    },
    showAddCourse(id) {
      $("#modal-popin").modal("show");
      this.chapter_id = id;
    },

    showAddChapter() {
      $("#modal-popinX").modal("show");
    },
    createChapter() {
      this.processing = true;
      this.$store.dispatch("storeNewChapter", {
        chapters: this.form.chapters
      });
      Fire.$emit("Refresh");
      this.processing = false;
      $("#modal-popinX").modal("hide");
      this.form.reset();
      toast.fire({
        type: "success",
        title: "Added! continue"
      });
    },
    createOutline(id) {
      this.$store.dispatch("storeNewOutline", {
        id: this.makeid(7),
        title: this.form.course_title,
        chapter: id
      });
      Fire.$emit("Refresh");
      $("#modal-popin").modal("hide");
      this.form.reset();
      toast.fire({
        type: "success",
        title: "Added!"
      });
    },
    loadOutlines() {
      this.outlines = this.$store.getters.getOutlines;
    },

    loadChapters() {
      let newChapters = this.chapters;
      newChapters = this.$store.getters.getChapters;
      this.$emit("update-chapters", newChapters);
    },
    deleteOutline(outline) {
      this.$store.dispatch("deleteOutline", {
        chapters: outline.chapter,
        id: outline.id
      });
      Fire.$emit("Refresh");
    },
    // a function to generate id
    makeid(length) {
      var result = "";
      var characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      var charactersLength = characters.length;
      for (var i = 0; i < length; i++) {
        result += characters.charAt(
          Math.floor(Math.random() * charactersLength)
        );
      }
      return result;
    },
    chapterDelete(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          if (result.value) {
            this.$store.dispatch("deleteChapter", {
              chapter: id
            });
            Fire.$emit("Refresh");
          }
        });
    }
  },
  created() {
    Fire.$on("Refresh", () => {
      this.loadOutlines();
      this.loadChapters();
    });
  }
};
</script>
