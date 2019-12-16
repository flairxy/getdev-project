<template>
  <div class="block block-themed text-center ac-box">
    <a
      class="block block-link-pop bg-white-op-90 text-center"
      v-if="myCourse"
      href="javascript:void(0)"
      @click.prevent="handleClick"
    >
      <div class="block mb-2 ac-sm-box-img">
        <img class="ac-img" :src="bgImage" alt />
      </div>
      <div class="ac-title-pad">
        <div class="ac-course-title text-primary">{{ courseTitle }}</div>
        <div class="font-w300 ac-author">{{ courseAuthor }}</div>
      </div>

      <div class="ac-title-pad">
        <span class="font-w400 ac-time">{{ courseTotalLesson }} Lessons ({{ courseDuration }})</span>
      </div>

      <div class="ac-title-pad ac-author text-muted">
        <span class="js-rating">
          <i v-for="index in courseRating" data-alt="2" class="fa fa-fw fa-star text-warning"></i>
        </span>
        {{ courseRating }} ({{ courseStudentNumber }})
      </div>

      <div>
        <b-progress height="0.5rem" :value="value" :max="max" class="mb-3" animated></b-progress>
      </div>
    </a>

    <a class="block block-link-pop bg-white-op-90 text-center" v-else @click.prevent="handleClick">
      <div class="block mb-2 ac-sm-box-img">
        <img class="ac-img" :src="bgImage" alt />
      </div>
      <div class="ac-title-pad">
        <div class="ac-course-title text-primary">{{ courseTitle }}</div>
        <div class="font-w300 ac-author">{{ courseAuthor }}</div>
      </div>

      <div class="ac-title-pad">
        <span class="font-w400 ac-time">{{ courseTotalLesson }} Lessons ({{ courseDuration }})</span>
      </div>

      <div class="ac-title-pad ac-author text-muted">
        <span class="js-rating">
          <i v-for="index in courseRating" data-alt="2" class="fa fa-fw fa-star text-warning"></i>
        </span>
        {{ courseRating }} ({{ courseStudentNumber }})
      </div>

      <div class="ac-title-pad text-right">
        <span class="h5 font-w700 text-primary pr-20">${{ courseAmount }}</span>
      </div>
    </a>
  </div>
</template>
<script>
export default {
  props: {
    bgImage: String,
    courseStudentNumber: String,
    courseRating: Number,
    courseTitle: String,
    courseAuthor: String,
    courseDuration: String,
    courseAmount: String,
    courseTotalLesson: String,
    myCourse: Boolean,
    max: Number,
    value: Number
  },
  methods: {
    handleClick() {
      this.$emit("myClick");
    }
  }
};
</script>
