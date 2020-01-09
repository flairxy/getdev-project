<template>
  <div class="content">
    <div class="container py-30">
      <div>
        <span class="text-success">
          Account Balance:
          <span class="font-w700">{{ currency }}{{ tutor.balance }}</span>
        </span>
      </div>
      <span class="mr-2">
        <button class="btn btn-primary" @click.prevent="iWithdraw">Withdraw Fund</button>
      </span>
    </div>
    <div class="block-content bg-white-op-90">
      <div class="table-responsive">
        <table class="table table-striped table-vcenter">
          <thead>
            <tr>
              <th>#</th>
              <th></th>
              <th>Course</th>
              <th>Amount</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="account in accounts" :key="account.id">
              <td>1</td>
              <td>New student enrollment</td>
              <td>{{ account.course }}</td>
              <td class="text-success">${{ account.amount }}</td>
              <td>{{ account.time }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- withdrawal modal -->
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
              <h3 class="block-title">Withdraw Funds</h3>
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
              <form @submit.prevent="withdrawFund()">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-material">
                      <select class="form-control" v-model="form.currency">
                        <option value selected disabled>Choose gateway</option>
                        <option value="BTC">Bitcoin</option>
                        <option value="ETH">Ethereum</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-material">
                      <input type="text" class="form-control" v-model="form.amount" />
                      <label>Amount (dollars)</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-material">
                      <input type="text" class="form-control" v-model="form.address" />
                      <label>Wallet Address</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <div v-if="processing" class="col-6 col-md-3">
                      <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
                    </div>
                    <button type="submit" v-else class="btn btn-outline-primary mb-10">withdraw</button>
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
import { RepositoryFactory as Repo } from "../../../repository/RepositoryFactory";
const AR = Repo.get("academy");
export default {
  data() {
    return {
      accounts: [],
      currency: "",
      tutor: {},
      form: new Form({
        currency: "",
        amount: "",
        address: ""
      }),
      user: "",
      processing: false
    };
  },
  methods: {
    iWithdraw() {
      this.form.reset();
      $("#modal-popin").modal("show");
    },
    withdrawFund() {
      this.processing = true;
      let data = {
        user: this.user,
        currency: this.form.currency,
        amount: this.form.amount,
        address: this.form.address
      };
      AR.withdraw(data)
        .then(res => {
          this.processing = false;
          Fire.$emit("Refresh");
          $("#modal-popin").modal("hide");
          toast.fire({
            type: res.data.status,
            title: res.data.message
          });
        })
        .catch(() => {
          this.processing = false;
          toast.fire({
            type: "error",
            title: "Check provided information"
          });
        });
    },
    getInfo() {
      AR.loggedInUser().then(res => {
        this.currency = this.$store.state.currency;
        this.user = res.data.id;
        let user = res.data;
        AR.getAccountSummary(user.id).then(response => {
          this.accounts = response.data;
        });
        AR.tutor(user.id).then(res => {
          this.tutor = res.data;
        });
      });
    }
  },
  created() {
    this.getInfo();
    Fire.$on("Refresh", () => {
      this.getInfo();
    });
  }
};
</script>
