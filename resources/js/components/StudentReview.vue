<template>
  <div>
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <span class="h5 text-dark">{{ studentName }}</span>
        <span class="js-rating">
          <i v-for="index in courseRating" data-alt="2" class="fa fa-fw fa-star text-warning"></i>
        </span>
        <div>
          <p class="text-sm">{{ studentReview }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    studentName: String,
    studentReview: String,
    courseRating: Number
  }
};
</script>

