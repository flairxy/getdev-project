<template>
  <div class="content bg-white-op-90">
    <div class="block-content">
      <div class="table-responsive">
        <table class="table table-striped table-vcenter">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Status</th>
              <th>Email Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(student, index) in students" :key="student.id">
              <td>{{ index + 1 }}</td>
              <td>{{ student.name }}</td>
              <td>
                <span v-if="student.ban == '0'" class="text-success">
                  <b>Active</b>
                </span>
                <span v-else class="text-warning">
                  <b>Banned</b>
                </span>
              </td>
              <td>
                <span v-if="student.email_verified_at !== null" class="text-success">
                  <b>Verified</b>
                </span>
                <span v-else class="text-danger">
                  <b>Unverified</b>
                </span>
              </td>
              <td>
                <button
                  type="button"
                  @click.prevent="showStudentModal(student)"
                  class="btn btn-sm btn-primary js-tooltip-enabled"
                >
                  <i class="fa fa-eye"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-sm btn-danger js-tooltip-enabled"
                  @click.prevent="deleteUser(student.user_id)"
                >
                  <i class="fa fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div
      class="modal fade"
      id="modal-popin"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modal-popin"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-popin modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary">
              <h3 class="block-title">Student Information</h3>
              <div class="block-options">
                <button
                  type="button"
                  class="btn-block-option js-tooltip-enabled"
                  data-toggle="tooltip"
                  data-placement="left"
                  title
                  data-original-title="Reply"
                >
                  <i class="fa fa-reply"></i>
                </button>
                <button
                  type="button"
                  class="btn-block-option"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <i class="si si-close"></i>
                </button>
              </div>
            </div>

            <div
              class="block-content bg-white-op-90 block-content-full block-content-sm bg-body font-size-sm"
            >
              <div class="text-primary">
                <b>Email:</b>
                {{ student.email }}
              </div>
              <div class="text-primary py-5">
                <b>Joined:</b>
                {{ student.joined }}
              </div>
              <div class="float-right py-10">
                <span class="font-w700">STATUS:</span>
                <span v-if="student.ban != '0'" class="text-danger font-w400">BANNED</span>
                <span v-else class="text-success font-w400">ACTIVE</span>
              </div>
              <div class="mt-10">
                <button
                  v-if="student.ban == '0'"
                  @click.prevent="ban(student.id)"
                  class="btn btn-sm btn-danger"
                >Ban Account</button>
                <button
                  @click.prevent="unban(student.id)"
                  v-else
                  class="btn btn-sm btn-success"
                >Activate Account</button>
              </div>
            </div>

            <div class="block-content bg-white-op-90 block-content-full block-content-sm bg-body">
              <div class="col-12">
                <h6>Courses Enrolled</h6>
              </div>
              <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                  <tbody>
                    <tr v-for="course in student.courses" :key="course.id">
                      <td>{{ course.title }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
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
      students: [],
      student: {}
    };
  },
  methods: {
    deleteUser(id) {},
    ban(id) {
      AR.banUser(),
        then(() => {
          Fire.$emit("Refresh");
          toast.fire({
            type: "success",
            title: "Banned"
          });
        });
    },
    unban(id) {
      AR.unBanUser(),
        then(() => {
          Fire.$emit("Refresh");
          toast.fire({
            type: "success",
            title: "Banned"
          });
        });
    },
    showStudentModal(student) {
      this.student = student;
      $("#modal-popin").modal("show");
    },
    getStudents() {
      AR.getStudents().then(res => {
        this.students = res.data.students;
      });
    }
  },
  created() {
    this.getStudents();
    Fire.$on("Refresh", () => {
      this.getStudents();
    });
  }
};
</script>
