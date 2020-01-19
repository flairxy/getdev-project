<template>
  <div>
    <div class="bg-white-op-90">
      <div class="content">
        <div v-if="role == 'teacher'">
          <profile />
        </div>
        <div v-if="role == 'contractor'">
          <profile />
        </div>
        <div v-if="role == 'finance'">
          <profile />
        </div>
        <div v-if="role == 'general'">
          <profile />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { RepositoryFactory as Repo } from "../../repository/RepositoryFactory";
import Profile from "./Profile";
const AR = Repo.get("academy");
export default {
  components: {
    Profile
  },
  data() {
    return {
      role: ""
    };
  },
  methods: {
    getRole() {
      this.role = this.$store.getters.getRole;
    }
  },
  created() {
    this.getRole();
  }
};
</script>
