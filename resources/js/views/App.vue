<template>
  <div>
    <router-view></router-view>
  </div>
</template>
<script>
import { RepositoryFactory as Repo } from "../repository/RepositoryFactory";
const AR = Repo.get("academy");
export default {
  mounted() {
    AR.loggedInUser().then(res => {
      this.$localStorage.set("user", JSON.stringify(res.data));
    });
  }
};
</script>
<style>
.mt-60 {
  margin-top: 60px !important;
}
</style>
