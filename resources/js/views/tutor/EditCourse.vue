<template>
  <div>
    <div class="py-30">
      <div class="content">
        <form-wizard
          title="Edit Course"
          subtitle
          color="#453DA0"
          :finishButtonText="processing ? `Updating Course...` : `Submit for Review`"
          @on-complete="completeUpload"
        >
          <tab-content title="Title & Category" icon="fa fa-check" :before-change="getChapters">
            <!-- <course-videos /> -->
            <course-title />
          </tab-content>
          <tab-content title="Chaper & Outline" icon="fa fa-check" :before-change="checkOutlines">
            <course-chapter :chapters="courseChapters" @update-chapters="updateChapters" />
            <!-- <course-chapter /> -->
          </tab-content>
          <tab-content title="Cover Image" icon="fa fa-check" :before-change="checkImage">
            <div class="bg-white-op-90 py-30">
              <div class="content">
                <div class="row">
                  <div class="col-lg-6 col-md-12 py-20">
                    <form enctype="multipart/form-data" @submit.prevent="onUpload">
                      <div class="form-group">
                        <label>Course Background Image</label>
                        <div class="custom-file">
                          <input
                            type="file"
                            ref="file"
                            class="custom-file-input js-custom-file-input-enabled"
                            id="example-file-input-custom"
                            name="example-file-input-custom"
                            data-toggle="custom-file-input"
                            @change="onFileChanged"
                            accept=".jpeg, .jpg, .png, .pdf"
                          />
                          <label
                            class="custom-file-label"
                            for="example-file-input-custom"
                          >Choose File</label>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-lg-6 col-md-12 py-20 text-center">
                    <h5>Image Preview</h5>
                    <img width="60%" v-if="imageUrl" :src="imageUrl" />
                    <img width="60%" v-else :src="`/`+imageCover" />
                    <div></div>
                  </div>
                </div>
              </div>
            </div>
          </tab-content>
          <tab-content title="Pricing" icon="fa fa-check" :before-change="createCourse">
            <div class="bg-white-op-90 py-30">
              <div class="content">
                <form @submit.prevent="setPrice">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 py-20">
                      <div class="form-group">
                        <label class="col-12" for="example-email-input">Regular Price</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="form.price" />
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6 col-md-12 py-20">
                      <div class="form-group">
                        <label class="col-12" for="example-email-input">Promo Price</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="form.promo_price" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary mb-10">Save Price</button>
                  </div>
                </form>
              </div>
            </div>
          </tab-content>
          <tab-content title="Videos" icon="fa fa-check">
            <course-videos :course_id="course_id" v-if="uploadVideo" />
          </tab-content>
        </form-wizard>
      </div>
    </div>
  </div>
</template>

<script>
import CourseChapter from "./course/edit/Chapter";
import CoursePricing from "./course/edit/Pricing";
import CourseTitle from "./course/edit/Title";
import CourseVideos from "./course/edit/Video";
import { RepositoryFactory as Repo } from "../../repository/RepositoryFactory";

const AR = Repo.get("academy");
export default {
  components: {
    CourseChapter,
    CoursePricing,
    CourseTitle,
    CourseVideos
  },
  data() {
    return {
      price: "",
      promo_price: "",
      imageCover: "",
      updateComponent: 1,
      course_id: "",
      user: "",
      processing: false,
      uploadVideo: false,
      error: false,
      imageUrl: null,
      file: "",
      newCourseData: [],
      courseChapters: [],
      form: new Form({
        title: "",
        chapters: "",
        price: "",
        promo_price: ""
      })
    };
  },
  methods: {
    setPrice() {
      this.$store.dispatch("storeCoursePrice", {
        price: this.form.price,
        promo_price: this.form.promo_price
      });
    },
    onFileChanged(event) {
      let uploadedFile = this.$refs.file.files[0];
      //   this.files.push(uploadedFiles[0]);
      this.file = uploadedFile;
      this.imageUrl = URL.createObjectURL(uploadedFile);
    },
    onUpload() {
      const formData = new FormData();
      return formData.append("file", this.file);
    },
    createCourse() {
      const formData = new FormData();
      let courseData = this.$store.getters.getAllData;

      if (!courseData.price) {
        toast.fire({
          type: "error",
          title: "Please set the course price"
        });
        return false;
      }

      formData.append("file", this.file);
      formData.append("user", courseData.user);
      formData.append("category_id", courseData.category_id);
      formData.append("price", courseData.price);
      formData.append("promo_price", courseData.promo_price);
      formData.append("course_id", courseData.course);
      formData.append("type", courseData.type);
      formData.append(
        "total_chapters",
        JSON.stringify(courseData.total_chapters)
      );
      formData.append("title", courseData.title);
      formData.append("outlines", JSON.stringify(courseData.outlines));
      AR.tutorUpdateCourse(formData)
        .then(res => {
          //   console.log(res.data.id);
          this.course_id = res.data.id;
          this.uploadVideo = true;

          //   this.$store.dispatch("storeCourse", res.data.id);
        })
        .catch(err => {
          this.error = true;
        });
      if (this.error) {
        toast.fire({
          type: "error",
          title: "Failed to Create Course. Ensure all fields are filled"
        });
        return false;
      } else {
        toast.fire({
          type: "success",
          title: "Course created"
        });
        return true;
      }
    },

    getChapters() {
      this.courseChapters = this.$store.getters.getChapters;
      let courseData = this.$store.getters.getAllData;
      if (
        courseData.category_id &&
        courseData.title &&
        courseData.total_chapters.length > 0
      ) {
        return true;
      } else {
        toast.fire({
          type: "error",
          title: "Ensure all fields are filled"
        });
        return false;
      }
    },
    checkOutlines() {
      let courseData = this.$store.getters.getAllData;
      this.imageCover = courseData.cover;
      if (courseData.outlines.length > 0) {
        return true;
      } else {
        toast.fire({
          type: "error",
          title: "Minimum of 1 course outline is required"
        });
        return false;
      }
    },
    checkImage() {
      let courseData = this.$store.getters.getAllData;
      this.form.price = courseData.price;
      this.form.promo_price = courseData.promo_price;
      if (this.file || courseData.cover) {
        return true;
      } else {
        toast.fire({
          type: "error",
          title: "Please upload a cover image"
        });
        return false;
      }
    },

    completeUpload() {
      this.processing = true;
      window.location = "/_dt/dashboard";
      toast.fire({
        type: "success",
        title: "Course under review"
      });
      this.processing = false;
    },

    updateChapters(chapters) {
      this.courseChapters = chapters;
    },
    getImage() {
      let courseData = this.$store.getters.getAllData;
      this.imageCover = courseData.cover;
    }
  },
  created() {
    this.getImage();
  }
};
</script>
