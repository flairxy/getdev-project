<template>
  <div>
    <div class="bg-white-op-90">
      <div class="content">
        <div class="mt-15">
          <h5 class="font-s22 font-w900 text-muted">Welcome, Admin</h5>
          <hr />
        </div>
        <div>
          <div class="row">
            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow bg-gray-light" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">500</div>
                  <div class="font-size-sm font-w600 text-uppercase">Students</div>
                </div>
              </a>
            </div>
            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow ac-bg-danger-lighter" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">20</div>
                  <div class="font-size-sm font-w600 text-uppercase">Tutors</div>
                </div>
              </a>
            </div>
            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow bg-earth-lighter" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">50</div>
                  <div class="font-size-sm font-w600 text-uppercase">Courses</div>
                </div>
              </a>
            </div>

            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow bg-warning-light" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">$6,000</div>
                  <div class="font-size-sm font-w600 text-uppercase">Revenue</div>
                </div>
              </a>
            </div>

            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow bg-warning-light" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">50</div>
                  <div class="font-size-sm font-w600 text-uppercase">Pending Courses</div>
                </div>
              </a>
            </div>

            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow bg-danger-light" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">34</div>
                  <div class="font-size-sm font-w600 text-uppercase">Pending Messages</div>
                </div>
              </a>
            </div>
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
