<template>
  <a href>
    <div class="ac-img">
      <i class="fa fa-play-circle-o fa-4x"></i>
      <img :class="myClass" :height="height" :width="width" :src="image" alt />
    </div>
  </a>
</template>
<script>
export default {
  props: {
    image: String,
    height: String,
    width: String,
    myClass: String
  }
};
</script>
