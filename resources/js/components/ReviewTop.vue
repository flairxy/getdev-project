<template>
  <div>
    <div class="row">
      <div class="col-lg-4 col-md-12 text-center py-20">
        <thumbnail :height="height" :width="width" :image="image" />
      </div>
      <div class="col-lg-6 col-md-12 py-20">
        <div>
          <h4 class="font-s22 font-w900 mb-5">{{ courseTitle }}</h4>
          <p class="font-s16 text-muted mb-3">
            by
            <span class="font-w700 text-dark">{{ courseAuthor }}</span>
          </p>
        </div>
        <p class="font-s16 mb-3 text-primary-light">{{ courseDescription }}</p>

        <div class="row mb-3">
          <div class="col-4 text-muted">{{ courseStudentNumber }} Students</div>
          <div class="col-4">
            <span class="js-rating">
              <i v-for="index in courseRating" data-alt="2" class="fa fa-fw fa-star text-warning"></i>
            </span>
            {{ courseRating }}
          </div>
        </div>
        <div class="container row">
          <span class="mr-2 text-muted font-s16 font-w400">
            Buy: &nbsp;
            <a href class="btn btn-primary">${{ courseAmount }}</a> or
          </span>
          <span>
            <a href class="btn btn-outline-primary">Add to Cart</a>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// $route.params.slug = 'utlimate-vue-course',
export default {
  props: {
    image: String,
    courseTitle: String,
    courseAuthor: String,
    courseDescription: String,
    courseStudentNumber: String,
    courseRating: Number,
    courseAmount: String,
    height: String,
    width: String
  }
};
</script>
