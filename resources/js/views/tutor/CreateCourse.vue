<template>
  <div>
    <student-header />

    <div class="py-30">
      <div class="content">
        <form-wizard
          title="Create Course"
          subtitle
          color="#453DA0"
          finishButtonText="Submit for Review"
          @on-complete="createCourse"
        >
          <tab-content title="Title & Category" icon="fa fa-check" :before-change="getChapters">
            <course-title />
          </tab-content>
          <tab-content title="Chaper & Outline" icon="fa fa-check" :before-change="storeOutline">
            <course-chapter :chapters="courseChapters" @update-chapters="updateChapters" />
            <!-- <course-chapter /> -->
          </tab-content>
          <tab-content title="Cover Image" icon="fa fa-check" :before-change="storeCover">
            <course-image />
          </tab-content>
          <tab-content title="Pricing" icon="fa fa-check">
            <course-pricing />
          </tab-content>
        </form-wizard>
      </div>
    </div>
  </div>
</template>

<script>
import CourseChapter from "./course/create/Chapter";
import CourseImage from "./course/create/Image";
import CoursePricing from "./course/create/Pricing";
import CourseTitle from "./course/create/Title";
export default {
  components: {
    CourseChapter,
    CourseImage,
    CoursePricing,
    CourseTitle
  },
  data() {
    return {
      courseChapters: [],
      message:
        "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorum vel aliquam, facere qui facilis dignissimos quisquam necessitatibus.",
      image1: "/images/ltutor.png",
      userImage: "/images/bg.jpg",
      form: new Form({
        title: "",
        chapters: ""
      })
    };
  },
  methods: {
    createCourse() {
      console.log("You are done!");
    },

    getChapters() {
      this.courseChapters = this.$store.getters.getChapters;

      return true;
    },
    storeOutline() {
      console.log("outline saved");
      return true;
    },
    storeCover() {
      console.log("cover image saved");
      return true;
    },
    updateChapters(chapters) {
      this.courseChapters = chapters;
    }
  }
};
</script>
