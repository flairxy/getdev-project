<template>
  <div>
    <div class="bg-image" :style="`background-image: url(` + image + ` )`">
      <div class="bg-black-op-75">
        <div class="content content-top text-center">
          <div class="py-100">
            <h1 class="font-w700 text-white mb-10">Become a D'academi Tutor</h1>
            <h2 class="h4 font-w400 text-white-op">
              Join to tutors to impact knowledge and earn while you are
              at it.
            </h2>
            <div class="font-size-md text-muted">
              <a href="#" class="btn btn-lg btn-primary min-width-125">
                Learn More
                <i class="fa fa-angle-right font-w300"></i>
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
      image: "/images/bat.png"
    };
  }
};
</script>
