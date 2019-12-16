<template>
  <div>
    <div class="content" v-if="fetchingCourse">
      <div id="page-loader" class="show"></div>
    </div>
    <div v-else>
      <student-header />
      <div class="bg-white-op-90">
        <div class="col-lg-10 pt-20">
          <div class="container">
            <div class="row">
              <div class="col-lg-1"></div>
              <div class="col-lg-6">
                <span class="font-s16 font-w900">
                  {{ course.title }}
                  <span class="text-muted">by {{ course.author }}</span>
                </span>
                <hr />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-7 col-md-12 pb-20">
              <div class="ac-img text-center">
                <i class="fa fa-play-circle-o fa-4x text-primary"></i>
                <img class="watchVideo" :src="course.image" />
              </div>
              <div class="container">
                <div class="row">
                  <!-- <div class="col-lg-1"></div> -->
                  <div class="col-lg-10 text-center">
                    <h5 class="font-s16 font-w900 py-10">
                      chapter 1 - creating your first app
                      <span
                        class="text-muted"
                      >Introduction to course</span>
                    </h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 pb-10">
              <div class="container">
                <div id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="block block-bordered block-rounded mb-2" v-for="index in 5">
                    <div class="block-header" role="tab" :id="'accordion_h' + index">
                      <a
                        class="font-w700 text-muted collapsed"
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
                      <div class>
                        <div class="col-md-12 mb-2" v-for="index in 5">
                          <div class="bg-primary-lighter pl-10 py-10">
                            <em class="text-primary fa fa-play-circle-o fa-2x"></em>&nbsp;
                            <span
                              class="text-dark playerx xfont font-s16 font-w300"
                            >{{ chapter.slice(0,30) }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-lg-1"></div>
              <div class="col-lg-6">
                <span class="font-s16 font-w900">
                  <span class="text-muted">Lecture Summary</span>
                </span>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum officiis veniam possimus quis nihil? Amet magnam aut in culpa aperiam? Minima nemo, provident maxime quo dolore minus! Libero, voluptatem praesentium!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <tutor-ad />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      chapter: "Introduction to the course",
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
    }
  },
  created() {
    this.loadCourse();
  }
};
</script>

