<template>
  <div>
    <div class="py-30">
      <div class="content">
        <div class="row">
          <div class="col-lg-2"></div>
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
                  placeholder="Search course"
                  id="page-header-search-input"
                  v-model="search"
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
            v-if="courses.length > 0"
            class="col-md-12 col-lg-12 col-xl-12 mb-10"
            v-for="course in filteredCourses"
            :key="course.id"
          >
            <a class="block block-link-shadow" href="javascript:void(0)">
              <div class="block-content primary-border clearfix">
                <div class="text-right tcourse tc1 float-right">
                  <div class="font-w600 mb-5">
                    Course Rating:
                    <span class="js-rating" v-if="course.rating > 0">
                      <i
                        v-for="index in course.rating"
                        data-alt="1"
                        class="fa fa-fw fa-star text-warning"
                      ></i>
                      <i
                        v-for="index in ( 5 - course.rating)"
                        data-alt="1"
                        class="fa fa-fw fa-star text-muted"
                      ></i>
                    </span>
                    <span class="js-rating" v-else>
                      <i v-for="index in 5" data-alt="1" class="fa fa-fw fa-star text-muted"></i>
                    </span>
                  </div>
                  <div class="font-size-sm tc1 text-muted">
                    Total Earnings:
                    <span class="w700 text-dark">${{ course.total_earned }}</span>
                  </div>
                  <div class="mt-30">
                    <div class="row float-right">
                      <span class="mr-2">
                        <a
                          @click.prevent="editCourse(course.id, course.slug)"
                          href="#"
                          class="btn btn-primary"
                        >Edit</a>
                      </span>
                      <span>
                        <a
                          href
                          class="btn btn-danger"
                          @click.prevent="deleteCourse(course.id)"
                        >Delete</a>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="text-left dragx">
                  <div class="row">
                    <div class="font-w600 img-cont ml-10 mb-10 col-md-12 col-lg-3">
                      <img
                        class="img-avatarx img-avatar-square ac-img-av"
                        :src="`/`+course.cover_image"
                        alt
                      />
                    </div>
                    <div class="text-left nm tcourse float-left col-lg-6">
                      <div class="font-w700 tc1 font-s16 mb-5 text-dark">
                        {{ course.title }}
                        <span
                          v-if="course.status == 0"
                          class="text-warning"
                        >(PENDING)</span>
                        <span v-else-if="course.status == 1" class="text-success">(APPROVED)</span>
                        <span v-else class="text-danger">(REJECTED)</span>
                      </div>
                      <div class="font-size-sm tc1 text-dark">{{ course.total_outlines }} Lessons</div>
                      <br />
                      <div
                        class="font-size-sm tc1 tn text-dark mt-30"
                      >{{ course.total_student}} Students</div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="container" v-else>
            <h5 class="text-center text-muted">There are no courses</h5>
          </div>
        </div>
      </div>
      <!-- continue -->
    </div>
  </div>
</template>
<script>
import { RepositoryFactory as Repo } from "../../../repository/RepositoryFactory";
const AR = Repo.get("academy");
// export default {
//   data() {
//     return {
//       students: [],
//       student: {}
//     };
//   },
//   methods: {
//     deleteUser(id) {},
//     ban(id) {
//       AR.banUser(),
//         then(() => {
//           Fire.$emit("Refresh");
//           toast.fire({
//             type: "success",
//             title: "Banned"
//           });
//         });
//     },
//     unban(id) {
//       AR.unBanUser(),
//         then(() => {
//           Fire.$emit("Refresh");
//           toast.fire({
//             type: "success",
//             title: "Banned"
//           });
//         });
//     },
//     showStudentModal(student) {
//       this.student = student;
//       $("#modal-popin").modal("show");
//     },
//     getStudents() {
//       AR.getStudents().then(res => {
//         this.students = res.data.students;
//       });
//     }
//   },
//   created() {
//     this.getStudents();
//     Fire.$on("Refresh", () => {
//       this.getStudents();
//     });
//   }
// };
export default {
  data() {
    return {
      fetching: true,
      balance: "",
      total_earned: "",
      cover_location: "/images/cover/",
      search: "",
      messages: "",
      user: {},
      tutor: {},
      image1: "/images/ltutor.png",
      userImage: "/images/bg.jpg",
      image2: "/images/bg.jpg",
      courses: [],
      currency: ""
    };
  },
  methods: {
    editCourse(id, slug) {
      this.$router.push({
        name: "EditCourse",
        params: { course: id, slug: slug }
      });
    },
    playCourse(id, slug) {
      this.$router.push({
        name: "StudentVideoCourse",
        params: { id: id, slug: slug }
      });
    },
    getCoursesByTutor() {
      AR.adminTutorCourses().then(response => {
        let courses = response.data.courses;
        if (courses) {
          this.courses = courses;
          let outlines = response.data.outlines;
          courses.map(course => {
            let totalOutlines = [];
            outlines.map(outline => {
              if (outline.course_id == course.id) {
                totalOutlines.push(outline);
              }
            });
          });
          this.courses = courses;
          //   this.fetching = false;
        }
      });
    },
    deleteCourse(id, user) {
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
          // Send request to the server
          if (result.value) {
            AR.tutorDeleteCourse(id)
              .then(response => {
                Fire.$emit("refresh");
                toast.fire({
                  type: "success",
                  title: "Course Deleted"
                });
                location.reload();
              })
              .catch(error => {
                if (error.response.status == 403) {
                  toast.fire({
                    type: "error",
                    title: "Action Unauthorized"
                  });
                }
                swal("Failed!", "There was something wrong.", "warning");
              });
          }
        });
    }
  },
  created() {
    this.getCoursesByTutor();
    Fire.$on("Refresh", () => {
      this.getCoursesByTutor();
    });
  },
  mounted() {
    AR.loggedInUser().then(res => {
      let user = res.data;
      this.currency = this.$store.state.currency;
      this.user = user;
      AR.tutor(user.id).then(res => {
        this.tutor = res.data;
        if (res.data.identity_status == 0) {
          setTimeout(function() {
            $("#modal-popC").modal("show");
          }, 3000);
        }
      });
    });
  },
  computed: {
    filteredCourses() {
      return this.courses.filter(course => {
        return course.title;
      });
    },
    activeCourses() {
      let totalActive = [];
      this.courses.filter(course => {
        if (course.status == 1) {
          totalActive.push(course);
        }
      });
      return totalActive;
    },
    totalEarned() {
      let elements = [];
      this.courses.filter(course => {
        elements.push(course.total_earned);
      });
      return elements.reduce(function(acc, val) {
        return acc + val;
      }, 0);
    },
    averageRating() {
      let elements = [];
      this.courses.filter(course => {
        if (course.status == 1) {
          elements.push(course.rating);
        }
      });

      let sum =
        elements.reduce(function(acc, val) {
          return acc + val;
        }, 0) / elements.length;

      return Math.round(sum);
    },
    totalStudent() {
      let elements = [];
      this.courses.filter(course => {
        elements.push(course.total_student);
      });
      return elements.reduce(function(acc, val) {
        return acc + val;
      }, 0);
    }
    // totalUnreadMessages() {
    //   let messages = [];
    //   this.messages.filter(message => {
    //     if (message.status == 0) {
    //       messages.push(message);
    //     }
    //   });
    //   return messages.length;
    // }
  }
};
</script>
