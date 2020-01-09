<template>
  <div>
    <button
      @click.prevent="modal"
      type="button"
      class="btn btn-sm btn-rounded btn-success float-right"
      data-toggle="modal"
      data-target="#modal-compose"
    >New Message</button>
    <div
      class="modal fade"
      id="modal-popin"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modal-popin"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-dialog-popin" role="document">
        <div class="modal-content">
          <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary">
              <h3 class="block-title">Compose Message</h3>
              <div class="block-options">
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
            <div class="block-content">
              <form @submit.prevent="sendMessage()">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-material">
                      <select class="form-control" v-model="form.receiver" required>
                        <option value selected disabled>Receiver</option>
                        <option value="1">All Students</option>
                        <option v-if="admin" value="2">All Tutors</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-material">
                      <textarea
                        class="form-control text-primary"
                        v-model="form.subject"
                        id
                        cols="30"
                        rows="1"
                        required
                      ></textarea>
                      <label>Subject</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-material">
                      <textarea
                        class="form-control text-primary"
                        v-model="form.body"
                        cols="30"
                        rows="6"
                        required
                      ></textarea>
                      <label>Body</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <div v-if="processing" class="col-6 col-md-3">
                      <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
                    </div>
                    <button type="submit" v-else class="btn btn-outline-primary mb-10">send</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { RepositoryFactory as Repo } from "../repository/RepositoryFactory";
const AR = Repo.get("academy");
export default {
  props: {
    admin: Boolean
  },
  data() {
    return {
      accounts: [],
      currency: "",
      user: "",
      tutor: {},
      form: new Form({
        receiver: "",
        subject: "",
        body: ""
      }),
      user: "",
      processing: false
    };
  },
  methods: {
    modal() {
      this.form.reset();
      $("#modal-popin").modal("show");
    },
    sendMessage() {
      this.processing = true;
      let data = {
        sender: this.user.id,
        receiver: this.form.receiver,
        subject: this.form.subject,
        body: this.form.body
      };
      let admin = this.$props.admin;
      if (admin) {
        AR.adminNotify(data).then(res => {
          $("#modal-popin").modal("hide");
          this.processing = false;
        });
      } else {
        AR.notify(data).then(res => {
          $("#modal-popin").modal("hide");
          this.processing = false;
        });
      }
    }
  },
  mounted() {
    AR.loggedInUser().then(res => {
      this.user = res.data;
    });
  }
};
</script>
