<template>
  <div>
    <div class="py-30">
      <div class="content">
        <h2 class="content-heading">
          <create-message />
          Sent ({{ messages.length }})
        </h2>
        <div class="block-content bg-white-op-90">
          <!-- END Messages Options -->

          <!-- Messages -->
          <!-- Checkable Table (.js-table-checkable class is initialized in Helpers.tableToolsCheckable()) -->
          <table
            class="js-table-checkable table table-hover table-vcenter js-table-checkable-enabled"
          >
            <tbody>
              <tr v-for="message in messages" :key="message.id">
                <td class="text-center" style="width: 40px;">
                  <label class="css-control css-control-primary css-checkbox">
                    <input
                      type="checkbox"
                      :value="message.id"
                      v-model="checkedMessages"
                      class="css-control-input"
                    />
                    <span class="css-control-indicator"></span>
                  </label>
                </td>
                <td>
                  <a
                    class="font-w600 h6"
                    href="#"
                    @click.prevent="showMessageModal(message)"
                  >{{ message.data.subject }}</a>
                  <div class="text-muted mt-5">{{ message.data.body }}</div>
                </td>
                <td
                  class="d-none d-xl-table-cell font-w600 font-size-sm text-muted"
                  style="width: 120px;"
                >{{ message.time }}</td>
              </tr>
            </tbody>
          </table>
          <!-- END Messages -->
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="modal-message"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modal-message"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-dialog-popout" role="document">
        <div class="modal-content">
          <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary">
              <h3 class="block-title">{{ currentMessage.subject }}</h3>
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

            <div class="block-content py-30">{{ currentMessage.body }}</div>
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
      checkedMessages: [],
      messages: [],
      currentMessage: {},
      messageComponent: ""
    };
  },
  methods: {
    deleteMesages() {
      let data = {
        id: this.checkedMessages
      };
      AR.deleteTutorMessages(data).then(res => {
        Fire.$emit("Refresh");
        toast.fire({
          type: "success",
          title: "Messages Deleted"
        });
        location.reload();
      });
    },

    getMessages() {
      AR.loggedInUser().then(res => {
        let user = res.data.id;
        AR.tutorSentMessages(user).then(response => {
          this.messages = response.data;
        });
      });
    },
    showMessageModal(message) {
      this.currentMessage = message.data;
      $("#modal-message").modal("show");
    }
  },
  created() {
    this.getMessages();
    Fire.$on("Refresh", () => {
      this.getMessages();
    });
  }
};
</script>

