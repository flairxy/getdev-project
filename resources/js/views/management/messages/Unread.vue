<template>
  <div>
    <div class="py-30">
      <div class="content">
        <h2 class="content-heading">
          <button
            type="button"
            class="btn btn-sm btn-rounded btn-primary d-md-none float-right ml-5"
            data-toggle="class-toggle"
            data-target=".js-inbox-nav"
            data-class="d-none d-md-block"
          >Menu</button>
          <button
            type="button"
            class="btn btn-sm btn-rounded btn-success float-right"
            data-toggle="modal"
            data-target="#modal-compose"
          >New Message</button>
          Unread ({{ messages.length }})
        </h2>
        <div class="block-content bg-white-op-90">
          <!-- Messages Options -->
          <div class="push">
            <button type="button" class="btn btn-rounded btn-alt-secondary float-right">
              <i class="fa fa-times text-danger mx-5"></i>
              <span class="d-none d-sm-inline" @click="deleteMesages">Delete</span>
            </button>
            <button @click="markAsRead" type="button" class="btn btn-rounded btn-alt-secondary">
              <i class="fa fa-archive text-primary mx-5"></i>
              <span class="d-none d-sm-inline">Mark as read</span>
            </button>
          </div>
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
                <td
                  class="d-none d-sm-table-cell font-w600"
                  style="width: 140px;"
                >{{ message.sender }}</td>
                <td>
                  <a
                    v-if="message.status == 0"
                    class="font-w900 h6 text-primary"
                    href="#"
                    @click="showMessageModal(message)"
                  >
                    <b>{{ message.header }}</b>
                  </a>
                  <a
                    v-else
                    class="font-w600 h6"
                    href="#"
                    @click.prevent="showMessageModal(message)"
                  >{{ message.header }}</a>
                  <div class="text-muted mt-5">{{ message.message.slice(0, 50) + `...` }}</div>
                </td>
                <td
                  class="d-none d-xl-table-cell font-w600 font-size-sm text-muted"
                  style="width: 120px;"
                >{{ new Date(message.created_at).getDay() }}</td>
              </tr>=
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
            <div class="block-header bg-primary-dark">
              <h3 class="block-title">{{ currentMessage.header }}</h3>
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

            <div class="block-content py-30">{{ currentMessage.message }}</div>
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
        Fire.$emit("refresh");
        toast.fire({
          type: "success",
          title: "Messages Deleted"
        });
        location.reload();
      });
    },
    markAsRead() {
      let data = {
        id: this.checkedMessages
      };
      AR.updateMessages(data).then(res => {
        Fire.$emit("refresh");
        toast.fire({
          type: "success",
          title: "Marked as read"
        });
        location.reload();
      });
    },
    getMessages() {
      AR.loggedInUser().then(res => {
        let user = res.data.username;
        AR.tutorMessages(user).then(response => {
          let messages = response.data;
          let unread = [];
          messages.map(message => {
            if (message.status == 0) {
              unread.push(message);
            }
          });
          this.messages = unread;
        });
      });
    },
    showMessageModal(message) {
      this.currentMessage = message;
      $("#modal-message").modal("show");
      AR.updateMessage(message.id).then(res => {
        Fire.$emit("refresh");
      });
    }
  },
  created() {
    this.getMessages();
    Fire.$on("Refresh", () => {
      this.getMessages();
    });
  },
  computed: {
    totalUnreadMessages() {
      let messages = [];
      this.messages.filter(message => {
        if (message.status == 0) {
          messages.push(message);
        }
      });
      return messages.length;
    }
  }
};
</script>

