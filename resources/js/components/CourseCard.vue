<template>
  <div class="block block-themed text-center ac-box pointer">
    <a
      class="block block-link-pop bg-white-op-90 text-center"
      v-if="myCourse"
      href="javascript:void(0)"
      @click.prevent="handleClick"
    >
      <div class="block mb-2 ac-sm-box-img">
        <img height="180" class="ac-img" :src="`/`+bgImage" alt />
      </div>
      <div class="ac-title-pad">
        <div class="ac-course-title text-primary">{{ courseTitle }}</div>
        <div class="font-w300 ac-author">{{ courseAuthor }}</div>
      </div>

      <div class="ac-title-pad">
        <span class="font-w400 ac-time">{{ courseTotalLesson }} Lessons</span>
      </div>

      <div class="ac-title-pad ac-author text-muted">
        <span class="js-rating">
          <i v-for="index in courseRating" data-alt="2" class="fa fa-fw fa-star text-warning"></i>
          <i v-for="index in (5-courseRating)" data-alt="2" class="fa fa-fw fa-star text-muted"></i>
        </span>
        {{ courseRating }} ({{ courseStudentNumber }})
      </div>
    </a>

    <a class="block block-link-pop bg-white-op-90 text-center" v-else @click.prevent="handleClick">
      <div class="block mb-2 ac-sm-box-img">
        <img height="180" class="ac-img" :src="`/`+bgImage" alt />
      </div>
      <div class="ac-title-pad">
        <div class="ac-course-title text-primary">{{ courseTitle }}</div>
        <div class="font-w300 ac-author">{{ courseAuthor }}</div>
      </div>

      <div class="ac-title-pad">
        <span class="font-w400 ac-time">{{ courseTotalLesson }} Lessons</span>
      </div>

      <div class="ac-title-pad ac-author text-muted">
        <span class="js-rating">
          <i v-for="index in courseRating" data-alt="2" class="fa fa-fw fa-star text-warning"></i>
          <i v-for="index in (5-courseRating)" data-alt="2" class="fa fa-fw fa-star text-muted"></i>
        </span>
        {{ courseRating }} ({{ courseStudentNumber }})
      </div>

      <div class="ac-title-pad text-right">
        <span v-if="premium == 0" class="h5 font-w700 text-primary pr-20">Free</span>
        <span v-else class="h5 font-w700 text-primary pr-20">{{ currency + courseAmount }}</span>
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
    courseAmount: String,
    courseTotalLesson: String,
    myCourse: Boolean,
    premium: Number
  },
  data() {
    return {
      currency: this.$store.state.currency
    };
  },
  methods: {
    handleClick() {
      this.$emit("myClick");
    }
  }
};
</script>
