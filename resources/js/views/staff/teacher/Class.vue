<template>
  <div class="content bg-white-op-90">
    <div class="block-content">
      <span class="text-danger h5">Staff Enrolled Classes</span>
      <div class="table-responsive py-30">
        <table class="table table-striped table-vcenter">
          <thead>
            <tr>
              <th>#</th>
              <th>Class</th>
              <th>Number of students</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(myClass, index) in classes" :key="myClass.id">
              <td class="text-center" style="width: 40px;">{{ index + 1 }}</td>
              <td>{{myClass.name}}</td>
              <td>{{ myClass.tStudents }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import { RepositoryFactory as Repo } from "../../../repository/RepositoryFactory";
const AR = Repo.get("academy");
export default {
  data() {
    return {
      search: "",
      processing: false,
      selecting: false,
      edit: false,
      classes: []
    };
  },
  methods: {
    getClasses() {
      let user = JSON.parse(this.$localStorage.get("user"));
      AR.getStaffClasses(user.id).then(res => {
        this.classes = res.data;
      });
    }
  },
  created() {
    this.getClasses();
    Fire.$on("Refresh", () => {
      this.getClasses();
    });
  }
};
</script>
