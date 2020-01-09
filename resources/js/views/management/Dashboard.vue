<template>
  <div>
    <div class="bg-white-op-90">
      <div class="content">
        <div class="mt-15">
          <h5 class="font-s22 font-w900 text-muted">Welcome, Admin</h5>
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
                  <div class="h1 font-w700">{{ totalTutors }}</div>
                  <div class="font-size-sm font-w600 text-uppercase">Tutors</div>
                </div>
              </a>
            </div>
            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow bg-earth-lighter" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">{{ approvedCourses }}</div>
                  <div class="font-size-sm font-w600 text-uppercase">Approved Courses</div>
                </div>
              </a>
            </div>

            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow bg-warning-light" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">${{ revenues }}</div>
                  <div class="font-size-sm font-w600 text-uppercase">Revenue</div>
                </div>
              </a>
            </div>

            <div class="col-md-6 col-xl-3">
              <a class="block block-link-shadow bg-warning-light" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <div class="h1 font-w700">{{ pendingCourses }}</div>
                  <div class="font-size-sm font-w600 text-uppercase">Pending Courses</div>
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
      revenues: "",
      pendingCourses: "",
      approvedCourses: "",
      totalTutors: "",
      totalStudents: ""
    };
  },
  methods: {
    getInfos() {
      AR.totalRevenues().then(res => {
        this.revenues = res.data.revenues;
      });
      AR.totalMixCourses().then(res => {
        (this.pendingCourses = res.data.total_pending),
          (this.approvedCourses = res.data.total_approved);
      });
      AR.totalMixUsers().then(res => {
        (this.totalTutors = res.data.total_tutors),
          (this.totalStudents = res.data.total_students);
      });
    }
  },
  created() {
    this.getInfos();
  }
};
</script>
