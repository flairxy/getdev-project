<template>
  <div class="content bg-white-op-90">
    <div class="block-content">
      <div class="table-responsive">
        <table class="table table-striped table-vcenter">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Total Earned</th>
              <th>Balance</th>
              <th>Status</th>
              <th>Email Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(tutor, index) in tutors" :key="tutor.id">
              <td>{{ index + 1 }}</td>
              <td>{{ tutor.name }}</td>
              <td>${{ tutor.total_earned }}</td>
              <td>${{ tutor.balance }}</td>
              <td>
                <span v-if="tutor.ban == '0'" class="text-success">
                  <b>Active</b>
                </span>
                <span v-else class="text-warning">
                  <b>Banned</b>
                </span>
              </td>
              <td>
                <span v-if="tutor.email_verified_at !== null" class="text-success">
                  <b>Verified</b>
                </span>
                <span v-else class="text-danger">
                  <b>Unverified</b>
                </span>
              </td>
              <td>
                <button
                  type="button"
                  @click.prevent="showTutorModal(tutor)"
                  class="btn btn-sm btn-primary js-tooltip-enabled"
                >
                  <i class="fa fa-eye"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-sm btn-danger js-tooltip-enabled"
                  @click.prevent="deleteUser(tutor.user_id)"
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
              <h3 class="block-title">Tutor Information</h3>
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
              class="block-content block-content-full block-content-sm bg-body bg-white-op-90 font-size-sm"
            >
              <div class="col-md-6 col-xl-6">
                <div class="block-content block-content-full clearfix">
                  <div class="float-left">
                    <img class="img-avatar img-avatar96" :src="'/images/avatar9.jpg'" alt />
                  </div>
                </div>
              </div>
              <div class="text-primary">
                <b>Email:</b>
                {{ tutor.email }}
              </div>
              <div class="text-primary py-5">
                <b>Joined:</b>
                {{ tutor.joined }}
              </div>
              <div class="float-right py-10">
                <span class="font-w700">STATUS:</span>
                <span v-if="tutor.ban != '0'" class="text-danger font-w400">BANNED</span>
                <span v-else class="text-success font-w400">ACTIVE</span>
              </div>
              <div class="mt-10">
                <button
                  v-if="tutor.ban == '0'"
                  @click.prevent="ban(tutor.id)"
                  class="btn btn-sm btn-danger"
                >Ban Account</button>
                <button
                  @click.prevent="unban(tutor.id)"
                  v-else
                  class="btn btn-sm btn-success"
                >Activate Account</button>
              </div>
            </div>

            <div class="block-content bg-white-op-90 block-content-full bg-body">
              <div class="col-12">
                <h6>Tutor Courses</h6>
              </div>
              <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                  <tbody>
                    <tr v-for="(course, index) in tutor.courses" :key="course.id">
                      <td>{{ index + 1 }}</td>
                      <td>{{ course.title }}</td>
                      <td>${{ course.price }}</td>
                      <td>{{ course.total_chapters }} Chapters</td>
                      <td>{{ course.total_outlines }} Lessons</td>
                      <td>
                        <span v-if="course.status == '1'" class="text-success">
                          <b>Approved</b>
                        </span>
                        <span v-else class="text-warning">
                          <b>Pending</b>
                        </span>
                      </td>
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
      tutors: [],
      tutor: {}
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
    showTutorModal(tutor) {
      this.tutor = tutor;
      $("#modal-popin").modal("show");
    },
    getTutors() {
      AR.getTutors().then(res => {
        this.tutors = res.data.tutors;
      });
    }
  },
  created() {
    this.getTutors();
    Fire.$on("Refresh", () => {
      this.getStudents();
    });
  }
};
</script>
