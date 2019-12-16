<template>
  <div>
    <div class="bg-white-op-90">
      <div class="content">
        <div class="row">
          <div class="col-lg-6 col-md-12 py-20">
            <h4 class="font-s22 font-w900 mb-5">Welcome to D'academi Tutor Program</h4>
            <p
              class="font-s16 text-primary-light"
            >Share your knowledge and earn money while at it with the Diacademi tutor program</p>
            <div class="container row">
              <span class="mr-2">
                <a href class="btn btn-primary">Create Course</a>
              </span>
              <span>
                <a href class="btn btn-outline-primary">My Courses</a>
              </span>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 text-center">
            <img style="width: 60%" :src="image1" alt />
          </div>
        </div>
        <div class="mt-15">
          <h5 class="font-s16 font-w900 text-muted">Hello, Rachel Okorie</h5>
          <hr />
        </div>
        <div>
          <p class="font-s16 font-w300 text-dark">Your stats</p>
          <div class="row">
            <div class="col-md-6 col-xl-4">
              <a class="block block-link-shadow bg-gray-light" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">5</div>
                  <div class="font-size-sm font-w600 text-uppercase">Active Courses</div>
                </div>
              </a>
            </div>
            <div class="col-md-6 col-xl-4">
              <a class="block block-link-shadow ac-bg-danger-lighter" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">$12,000</div>
                  <div class="font-size-sm font-w600 text-uppercase">Total Earnings</div>
                </div>
              </a>
            </div>
            <div class="col-md-6 col-xl-4">
              <a class="block block-link-shadow bg-earth-lighter" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">35%</div>
                  <div class="font-size-sm font-w600 text-uppercase">Average Course Rating</div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="py-30">
      <div class="content">
        <div class="row">
          <div class="col-lg-2">
            <p class="font-s16 font-w700 text-dark pl-15">Your Courses</p>
          </div>
          <div class="col-lg-2"></div>
          <div class="col-lg-2"></div>
          <div class="col-lg-2"></div>
          <!-- <div class="col-lg-2"></div> -->
          <div class="col-lg-4">
            <form action="be_pages_generic_search.html" method="post">
              <div class="input-group">
                <input
                  type="text"
                  class="form-control text-primary bg-primary-lighter"
                  placeholder="Search my course"
                  id="page-header-search-input"
                  name="page-header-search-input"
                />
                <div class="input-group-append">
                  <button type="submit" class="btn text-white bg-primary-light">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>

          <div
            class="col-md-12 col-lg-12 col-xl-12 mb-10"
            v-for="course in courses"
            :key="course.id"
          >
            <a class="block block-link-shadow" href="javascript:void(0)">
              <div class="block-content primary-border clearfix">
                <div class="text-right tcourse tc1 float-right">
                  <div class="font-w600 mb-5">
                    Course Rating:
                    <span class="js-rating">
                      <i
                        v-for="index in course.rating"
                        data-alt="2"
                        class="fa fa-fw fa-star text-warning"
                      ></i>
                    </span>
                  </div>
                  <div class="font-size-sm tc1 text-muted">
                    Total Earnings:
                    <span class="w700 text-dark">$23,000</span>
                  </div>
                  <div class="mt-30">
                    <a href class="btn btn-sm btn-primary editx">Edit Course</a>
                  </div>
                </div>
                <div class="text-left dragx">
                  <div class="row">
                    <div class="font-w600 img-cont ml-10 mb-10 col-md-12 col-lg-3">
                      <img class="img-avatarx img-avatar-square ac-img-av" :src="course.image" alt />
                    </div>
                    <div class="text-left nm tcourse float-left col-lg-6">
                      <div class="font-w700 tc1 font-s16 mb-5 text-dark">{{ course.title }}</div>
                      <div
                        class="font-size-sm tc1 text-dark"
                      >{{ course.totalLesson }} Lessons - {{ course.duration }}</div>
                      <br />
                      <div
                        class="font-size-sm tc1 tn text-dark mt-30"
                      >{{ course.studentNUmber }} Students</div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="row text-center">
          <div class="col-12">
            <router-link :to="{ name: 'CreateCourse'}" class="btn btn-primary min-width-125">
              Create Course
              <i class="fa fa-angle-right font-w300"></i>
            </router-link>
          </div>
        </div>
      </div>
      <!-- continue -->
    </div>
    <div class="py-30">
      <div class="content">
        <p class="font-s16 font-w700 text-dark pl-15">Latest Messages</p>
        <div class="ac-card">
          <div class="col-md-6 col-xl-3" v-for="index in 6">
            <a class="block block-link-shadow" href="javascript:void(0)">
              <div class="block-content block-content-full clearfix">
                <div class="text-left float-right mt-10">
                  <div class="font-w600 mb-5">Jack Greene</div>
                  <div class="font-size-sm text-muted">student</div>
                </div>
                <div class="float-left">
                  <img class="img-avatar" :src="userImage" alt />
                </div>
              </div>
              <div class="block-content bg-body-light">
                <span class="font-size-sm">
                  {{ message.slice(0,80) }}
                  <span class="text-primary">...read more</span>
                </span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      message:
        "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorum vel aliquam, facere qui facilis dignissimos quisquam necessitatibus.",
      image1: "/images/ltutor.png",
      userImage: "/images/bg.jpg",
      image2: "/images/bg.jpg",
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
          id: "22",
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
          id: "17",
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
          id: "12",
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
    playCourse(id, slug) {
      this.$router.push({
        name: "StudentVideoCourse",
        params: { id: id, slug: slug }
      });
    }
  }
};
</script>
