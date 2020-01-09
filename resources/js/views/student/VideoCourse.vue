<template>
  <div>
    <div class="content" v-if="fetchingCourse">
      <div id="page-loader" class="show"></div>
    </div>
    <div v-else>
      <div class="bg-white-op-90 mt-60 py-30">
        <div class="col-lg-10 pt-20">
          <div class="container">
            <div class="row">
              <div class="col-lg-1"></div>
              <div class="col-lg-6">
                <span class="font-s16 font-w900">
                  {{ course.title }}
                  <span class="text-muted">by {{ course.tutor }}</span>
                </span>
                <hr />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-7 col-md-12 pb-20">
              <div class="ac-img text-center">
                <i class="fa fa-play-circle-o fa-4x text-white"></i>
                <img class="watchVideo" :src="`/`+course.cover_image" />
              </div>
              <div class="container">
                <div class="row">
                  <!-- <div class="col-lg-1"></div> -->
                  <div class="col-lg-10 text-center" v-if="currentChapter && currentOutline.title">
                    <h5 class="font-s16 font-w900 py-10">
                      Chapter {{ currentChapter }} -
                      <span
                        class="text-muted"
                      >{{ currentOutline.title }}</span>
                    </h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 pb-10">
              <div class="container">
                <div class="col-md-12 col-lg-12 py-20">
                  <select class="form-control" @change="selectChapter" required>
                    <option value selected>Select Chapter</option>
                    <option
                      v-for="chapter in chapters"
                      :key="chapter"
                      :value="chapter"
                    >Chapter {{ chapter }}</option>
                  </select>
                </div>
                <div class="col-md-12 col-lg-12 py-10">
                  <!-- <ul style="padding-inline-start: 10px;">
                  <li >-->
                  <div class="mb-2" v-for="(outline, index) in currentOutlines" :key="outline.id">
                    <div class="bg-primary-lighter pl-10 py-10">
                      <em class="text-primary fa fa-play-circle-o fa-2x"></em>&nbsp;
                      <span
                        @click="getOutline(outline)"
                        class="text-dark playerx xfont font-small font-w300 pointer"
                      >Lesson {{ index + 1 }} - {{ outline.title.slice(0,28) }}</span>
                    </div>
                  </div>
                  <!-- </li>
                  </ul>-->
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-7 col-md-12 pb-20">
              <div class="container">
                <div class="col-12">
                  <h5 class="text-muted">Leave a review</h5>
                </div>
                <form @submit.prevent="reviewCourse">
                  <div class="py-10 col-4">
                    <select v-model="rating" class="form-control" required>
                      <option value="1">1 star</option>
                      <option value="2">2 stars</option>
                      <option value="3">3 stars</option>
                      <option value="4">4 stars</option>
                      <option value="5">5 stars</option>
                    </select>
                  </div>
                  <div class="col-12">
                    <textarea
                      required
                      class="form-control"
                      v-model="body"
                      rows="6"
                      placeholder="Enter your review here.."
                    ></textarea>
                    <div class="py-10">
                      <button
                        type="submit"
                        class="btn btn-primary"
                      >{{ !currentRating ? `Review` : `Update Review` }}</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- <tutor-ad /> -->
    </div>
  </div>
</template>

<script>
import { RepositoryFactory as Repo } from "../../repository/RepositoryFactory";

const AR = Repo.get("academy");
export default {
  data() {
    return {
      rating: 5,
      body: "",
      user: "",
      showHidden: false,
      currentChapter: "",
      currentOutline: {},
      showReviews: false,
      fetchingCourse: true,
      course: {},
      outlines: [],
      currentOutlines: [],
      currentRating: {},
      chapters: [],
      course_id: this.$route.params.id,
      courses: []
    };
  },
  methods: {
    reviewCourse() {
      let data = {
        rating: this.rating,
        body: this.body,
        course: this.course_id,
        user: this.user
      };
      AR.reviewCourse(data)
        .then(res => {
          Fire.$emit("Refresh");
          toast.fire({
            type: res.data.status,
            title: res.data.message
          });
        })
        .catch(() => {
          toast.fire({
            type: "error",
            title: "Rating Failed"
          });
        });
    },
    getOutline(outline) {
      this.currentOutline = outline;
    },
    selectChapter(event) {
      let id = event.target.value;
      this.currentChapter = id;
      this.currentOutline = {};
      let outlines = [];
      this.outlines.map(outline => {
        if (outline.chapter == id) {
          outlines.push(outline);
        }
      });
      //   console.log(this.outlines);
      this.currentOutlines = outlines;
    },
    previewCourse(slug) {
      this.$router.push({
        name: "StudentCoursePreview",
        params: { slug: slug }
      });
    },
    loadCourse() {
      // call the api and pass the course id to fetch the matching course
      this.courses.map(course => {
        if (this.course_id && course.id === this.course_id) {
          this.course = course;
          this.fetchingCourse = false;
        }
      });
    },
    seeMore() {
      this.showHidden = !this.showHidden;
    },
    moreReviews() {
      this.showReviews = !this.showReviews;
    },

    getCourse() {
      let course = this.$route.params.id;
      AR.studentCourse(course).then(res => {
        this.course = res.data.course;
        let outlines = res.data.outlines;
        this.outlines = outlines;
        this.fetchingCourse = false;
        let chapters = [];
        outlines.map(outline => {
          chapters.push(outline.chapter);
        });
        this.chapters = new Set(chapters);
      });
    },
    getUser() {
      AR.loggedInUser().then(res => {
        this.user = res.data.id;
        AR.getCourseReview(this.course_id, res.data.id).then(res => {
          this.currentRating = res.data;
        });
      });
    }
  },
  created() {
    this.loadCourse();
    this.getCourse();
    this.getUser();
    Fire.$on("Refresh", () => {
      this.loadCourse();
      this.getCourse();
      this.getUser();
    });
  }
};
</script>

