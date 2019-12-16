<template>
  <div>
    <student-header />
    <div class="bg-white-op-90 mt-60 py-30">
      <div class="content">
        <div v-if="fetchingCourse">fetching course....</div>
        <div v-else>
          <h5 class="font-s16 font-w900 text-muted">
            Category:
            <span class="text-dark">Digital Design</span>
          </h5>
          <hr />
          <review-top
            :image="course.image"
            :courseTitle="course.title"
            :courseAuthor="course.author"
            :courseDescription="course.description"
            :courseRating="course.rating"
            :courseStudentNumber="course.studentNUmber"
            :courseAmount="course.amount"
            height="180"
            width="320"
          />
        </div>
      </div>
      <div class="content">
        <div class="row">
          <div class="col-lg-5 col-md-12 pull-right">
            <h4 class="font-s22 font-w900 mb-5 text-center">Course Content</h4>
            <div class="bg-gray-light mb-20">
              <div class="container">
                <div class="py-20">
                  <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="block block-bordered block-rounded mb-2" v-for="index in 10">
                      <div class="block-header" role="tab" :id="'accordion_h' + index">
                        <a
                          class="font-w600 collapsed"
                          data-toggle="collapse"
                          data-parent="#accordion"
                          :href="'#accordion_q' + index"
                          aria-expanded="false"
                          :aria-controls="'accordion_q' + index"
                        >Chapter {{ index }}</a>
                      </div>
                      <div
                        :id="'accordion_q' + index"
                        class="collapse"
                        role="tabpanel"
                        :aria-labelledby="'accordion_h' + index"
                        data-parent="#accordion"
                        style
                      >
                        <div class="block-content">
                          <ol>
                            <li>Introduction</li>
                            <li>Clearing out some make rumours</li>
                          </ol>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-7 col-md-12 pull-left">
            <h4 class="font-s22 font-w900 mb-5 text-center">What you will learn</h4>
            <div class="bg-gray-light mb-20">
              <div class="container">
                <div class="py-20">
                  <h4 class="h5 text-muted mb-10">Course Aims</h4>
                  <ul>
                    <li
                      v-for="index in 10"
                      v-if="index <= 5 && !showHidden"
                      class="font-s16"
                    >Lorem ipsum dolor sit amet consectetur adipisicing elit.</li>

                    <div v-if="showHidden" style="height: 300px; overflow: auto;">
                      <li
                        v-for="index in 30"
                        class="font-s16"
                      >Lorem ipsum dolor sit amet consectetur adipisicing elit.</li>
                    </div>
                  </ul>
                  <i class="text-primary fa fa-plus"></i>
                  <a href="#" @click.prevent="seeMore">see more</a>
                </div>
              </div>
            </div>
            <!-- <div class="col-lg-7 col-md-12"> -->
            <div class="bg-gray-light mb-20">
              <div class="container">
                <div class="py-20">
                  <h4 class="h5 text-muted mb-10">Student Reviews</h4>

                  <student-review
                    v-for="index in 3"
                    v-if="!showReviews"
                    class="font-s16"
                    :studentName="'Flair Buchi'"
                    :courseRating="5"
                    :studentReview="review"
                  />
                  <div v-if="showReviews" style="height: 300px; overflow: auto;">
                    <student-review
                      v-for="index in 10"
                      class="font-s16"
                      :studentName="'Flair Buchi'"
                      :courseRating="5"
                      :studentReview="review"
                    />
                  </div>

                  <i class="text-primary fa fa-plus"></i>
                  <a href="#" @click.prevent="moreReviews">see more</a>
                </div>
              </div>
            </div>
            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
    <div class="py-30">
      <div class="content">
        <p class="font-s16 font-w700 text-dark pl-15">Similar Courses</p>
        <div class="ac-card">
          <div
            v-for="course in courses"
            :key="course.id"
            class="ac-card--content col-md-6 col-lg-3"
          >
            <course-card
              :courseAmount="course.amount"
              :courseAuthor="course.author"
              :courseDuration="course.duration"
              :courseTitle="course.title.slice(0, 30) + `...`"
              :courseStudentNumber="course.studentNUmber"
              :bgImage="course.image"
              :courseRating="course.rating"
              :courseTotalLesson="course.totalLesson"
              :myCourse="false"
              @myClick="previewCourse(course.id, course.slug)"
            />
          </div>
        </div>
      </div>
    </div>

    <div class="bg-white-op-90 py-30">
      <div class="content">
        <p class="font-s16 font-w700 text-dark pl-15">
          Other courses by
          <span class="font-w700">{{ course.author }}</span>
        </p>
        <div class="ac-card">
          <div
            v-for="course in courses"
            :key="course.id"
            class="ac-card--content col-md-6 col-lg-3"
          >
            <course-card
              :courseAmount="course.amount"
              :courseAuthor="course.author"
              :courseDuration="course.duration"
              :courseTitle="course.title"
              :courseStudentNumber="course.studentNUmber"
              :bgImage="course.image"
              :courseRating="course.rating"
              :courseTotalLesson="course.totalLesson"
              :myCourse="false"
              @myClick="previewCourse(course.id, course.slug)"
            />
          </div>
        </div>
      </div>
    </div>
    <tutor-ad />
  </div>
</template>

<script>
export default {
  data() {
    return {
      showHidden: false,
      showReviews: false,
      fetchingCourse: true,
      course: {},
      course_id: this.$route.params.id,
      review:
        "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta dolorum obcaecati quia nemo ad facilis voluptatum, consequatur.",
      courses: [
        {
          image: "/images/luser1.png",
          author: "Nicholas Cage",
          amount: "9.99",
          duration: "4:24:00",
          title: "How to be the perfect player",
          studentNUmber: "253,000",
          image: "/images/bg.jpg",
          rating: 5,
          totalLesson: "18",
          now: 22,
          id: "ds-zwedsd-23ter23-sda90ps-32382zd-zxz2x",
          slug: "become-the-perfect-assasin",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium nostrum accusamus, blanditiis libero facere."
        },

        {
          image: "/images/luser1.png",
          author: "Rachel Okorie",
          amount: "9.99",
          duration: "4:24:00",
          title: "Public Speaking Masterclass",
          studentNUmber: "23,000",
          image: "/images/bg.jpg",
          rating: 5,
          totalLesson: "18",
          now: 45,
          id: "ds-zxs23sd-2723-sdas-3212zd-zxzx",
          slug: "public-speaking-masterclass",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium nostrum accusamus, blanditiis libero facere."
        },

        {
          image: "/images/luser1.png",
          author: "Jane Doe",
          amount: "19.79",
          duration: "7:24:00",
          title: "Vuejs 2.0 - The ultimate Vue Guide",
          studentNUmber: "43,000",
          image: "/images/bg.jpg",
          rating: 4,
          totalLesson: "23",
          now: 82,
          id: "ds-zxsdsd-2323-sdas-3232zd-zxzx",
          slug: "ultimate-vue-guide",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium nostrum accusamus, blanditiis libero facere quisquam."
        }
      ]
    };
  },
  methods: {
    previewCourse(slug) {
      this.$router.push({
        name: "StudentCoursePreview",
        params: { slug: slug }
      });
    },
    loadCourse() {
      // call the api and pass the course id to fetch the matching course
      this.courses.map(course => {
        if (course.id === this.course_id) {
          this.course = course;
        }
      });
      this.fetchingCourse = false;
    },
    seeMore() {
      this.showHidden = !this.showHidden;
    },
    moreReviews() {
      this.showReviews = !this.showReviews;
    }
  },
  created() {
    this.loadCourse();
  }
};
</script>

