<template>
  <div>
    <router-view></router-view>
  </div>
</template>
<script>
export default {
  mounted() {
    this.$store.dispatch("storeCurrency", {
      //   currency: "₦"
      currency: "$"
    });
  }
};
</script>
<style>
.mt-60 {
  margin-top: 60px !important;
}
</style>
