<template>
  <div>
    <div class="bg-white-op-90 py-30">
      <div class="content">
        <div class="row">
          <div class="col-lg-6 col-md-12 py-20">
            <h4 class="font-s22 font-w900 mb-5">Start and finish a course anywhere from any device</h4>
            <p
              class="font-s16 text-primary-light"
            >Lorem ipsum dolor sit amet consectetur adipisicing elit.Dolore porro aliquam soluta aolore porro aliquam soluta enim.</p>
            <!-- <div class="container row">
              <span class="mr-2">
                <a href class="btn btn-primary">Explore Categories</a>
              </span>
              <span>
                <a href class="btn btn-outline-primary">Recomendations</a>
              </span>
            </div>-->
          </div>
          <div class="col-lg-6 col-md-12 text-center">
            <img style="width: 100%" :src="image1" alt />
          </div>
        </div>
        <div class="mt-15">
          <h5 class="font-s16 font-w900 text-muted">Hello {{ user.name }}</h5>
          <hr />
        </div>
        <!-- <div>
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
        </div>-->
        <div v-if="courses.length > 0">
          <p class="font-s16 font-w300 text-dark pl-15">Pick up from where you left off...</p>
          <div class="ac-card">
            <div v-for="course in courses" :key="course.id" class="ac-card--content col-6 col-lg-3">
              <course-card
                :courseAmount="course.amount"
                :courseAuthor="course.tutor"
                :courseTitle="course.title.slice(0,30) + '...'"
                :courseStudentNumber="course.total_student"
                :bgImage="course.cover_image"
                :courseRating="course.rating"
                :courseTotalLesson="course.total_outlines"
                :myCourse="true"
                @myClick="playCourse(course.id, course.slug)"
              />
            </div>
          </div>
        </div>
        <div v-else>
          <span class="text-muted h6">You have no course</span>
        </div>
      </div>
    </div>
    <div class="py-30">
      <div class="content">
        <p class="font-s16 font-w300 text-dark pl-15">Other Courses</p>
        <div class="ac-card">
          <div v-for="course in topRated" :key="course.id" class="ac-card--content col-6 col-lg-3">
            <course-card
              :courseAmount="course.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
              :courseAuthor="course.tutor"
              :courseTitle="course.title.slice(0,30) + '...'"
              :courseStudentNumber="course.total_student.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
              :bgImage="course.cover_image"
              :courseRating="course.rating"
              :courseTotalLesson="course.total_outlines"
              :myCourse="false"
              :premium="course.type"
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
import { RepositoryFactory as Repo } from "../../repository/RepositoryFactory";

const AR = Repo.get("academy");
export default {
  data() {
    return {
      user: {},
      image1: "/images/luser1.webp",
      topRated: [],
      courses: []
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
    },
    getTopRatedCourses() {
      AR.topRatedCourses().then(res => {
        this.topRated = res.data;
      });
    },
    getStudentCourses() {
      AR.loggedInUser().then(res => {
        this.user = res.data;
        let user = res.data.id;
        AR.studentCourses(user).then(response => {
          this.courses = response.data.courses;
        });
        AR.studentNotifications(user).then(res => {});
      });
    }
  },
  created() {
    this.getTopRatedCourses();
    this.getStudentCourses();
  }
};
</script>
