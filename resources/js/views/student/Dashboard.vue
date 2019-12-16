<template>
  <div>
    <student-header />
    <div class="bg-white-op-90 py-30">
      <div class="content">
        <div class="row">
          <div class="col-lg-6 col-md-12 py-20">
            <h4 class="font-s22 font-w900 mb-5">Start and finish a course anywhere from any device</h4>
            <p
              class="font-s16 text-primary-light"
            >Lorem ipsum dolor sit amet consectetur adipisicing elit.Dolore porro aliquam soluta aolore porro aliquam soluta enim.</p>
            <div class="container row">
              <span class="mr-2">
                <a href class="btn btn-primary">Explore Categories</a>
              </span>
              <span>
                <a href class="btn btn-outline-primary">Recomendations</a>
              </span>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 text-center">
            <img style="width: 100%" :src="image1" alt />
          </div>
        </div>
        <div class="mt-15">
          <h5 class="font-s16 font-w900 text-muted">Hello, Rachel Okorie</h5>
          <hr />
        </div>
        <div>
          <p class="font-s16 font-w300 text-dark">Your stats this month</p>
          <div class="row">
            <div class="col-md-6 col-xl-4">
              <a class="block block-link-shadow bg-gray-light" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">5</div>
                  <div class="font-size-sm font-w600 text-uppercase">Courses Studying</div>
                </div>
              </a>
            </div>
            <div class="col-md-6 col-xl-4">
              <a class="block block-link-shadow ac-bg-danger-lighter" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">12</div>
                  <div class="font-size-sm font-w600 text-uppercase">Study Hours</div>
                </div>
              </a>
            </div>
            <div class="col-md-6 col-xl-4">
              <a class="block block-link-shadow bg-earth-lighter" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">35%</div>
                  <div class="font-size-sm font-w600 text-uppercase">Course Completion</div>
                </div>
              </a>
            </div>
          </div>
        </div>
        <div>
          <p class="font-s16 font-w300 text-dark pl-15">Pick up from where you left off...</p>
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
                :courseTitle="course.title.slice(0,30) + '...'"
                :courseStudentNumber="course.studentNUmber"
                :bgImage="course.image"
                :courseRating="course.rating"
                :courseTotalLesson="course.totalLesson"
                :myCourse="true"
                :max="100"
                :value="course.now"
                @myClick="playCourse(course.id, course.slug)"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="py-30">
      <div class="content">
        <p class="font-s16 font-w300 text-dark pl-15">Top Rated Courses</p>
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
              :courseTitle="course.title.slice(0,30) + '...'"
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
      image1: "/images/luser1.webp",
      courses: [
        {
          image: "/images/luser1.webp",
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
          image: "/images/luser1.webp",
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
          image: "/images/luser1.webp",
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
    previewCourse(id, slug) {
      this.$router.push({
        name: "StudentCoursePreview",
        params: { id: id, slug: slug }
      });
    },
    playCourse(id, slug) {
      this.$router.push({
        name: "StudentVideoCourse",
        params: { id: id, slug: slug }
      });
    }
  }
};
</script>
