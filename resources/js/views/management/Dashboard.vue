<template>
  <div>
    <div class="bg-white-op-90">
      <div class="content">
        <div class="mt-15">
          <h5 class="font-s22 font-w900 text-muted">Welcome</h5>
          <hr />
        </div>
        <div>
          <div class="row">
            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow bg-gray-light" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">{{ totalStudents }}</div>
                  <div class="font-size-sm font-w600 text-uppercase">Students</div>
                </div>
              </a>
            </div>
            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow ac-bg-danger-lighter" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">{{ totalTeachers }}</div>
                  <div class="font-size-sm font-w600 text-uppercase">Teachers</div>
                </div>
              </a>
            </div>
            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow ac-bg-danger-lighter" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">{{ totalStaffs }}</div>
                  <div class="font-size-sm font-w600 text-uppercase">Staffs</div>
                </div>
              </a>
            </div>
            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow bg-earth-lighter" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">{{ totalClasses }}</div>
                  <div class="font-size-sm font-w600 text-uppercase">Classes</div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { RepositoryFactory as Repo } from "../../repository/RepositoryFactory";
const AR = Repo.get("academy");
export default {
  data() {
    return {
      classes: [],
      staffs: [],
      students: []
    };
  },
  computed: {
    totalClasses() {
      return this.classes.length;
    },
    totalStaffs() {
      return this.staffs.length;
    },
    totalStudents() {
      return this.students.length;
    },
    totalTeachers() {
      let x = [];
      this.staffs.map(staff => {
        if (staff.role[0].slug == "teacher") {
          x.push(staff);
        }
      });
      return x.length;
    }
  },
  created() {
    AR.getClasses().then(res => {
      this.classes = res.data;
    });
    AR.getStaffs().then(res => {
      this.staffs = res.data;
    });
    AR.getStudents().then(res => {
      this.students = res.data;
    });
  }
};
</script>
