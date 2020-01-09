<template>
  <div class="content">
    <div class="block-content bg-white-op-90">
      <div class="table-responsive">
        <table class="table table-striped table-vcenter">
          <thead>
            <tr>
              <th>#</th>
              <th></th>
              <th>Amount</th>
              <th>Gateway</th>
              <th>Address</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(withdrawal, index) in withdrawals" :key="withdrawal.id">
              <td>{{index + 1}}</td>
              <td>Revenue Withdrawal</td>
              <td class="text-danger">{{currency}}{{withdrawal.amount}}</td>
              <td>{{withdrawal.currency}}</td>
              <td>{{withdrawal.address}}</td>
              <td>
                <span class="text-success" v-if="withdrawal.status == 1">Approved</span>
                <span class="text-primary" v-else>Pending</span>
              </td>
              <td>{{withdrawal.time}}</td>
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
      withdrawals: [],
      currency: ""
    };
  },
  methods: {
    getInfo() {
      AR.loggedInUser().then(res => {
        this.currency = this.$store.state.currency;
        let user = res.data;
        AR.getWithdrawals(user.id).then(response => {
          this.withdrawals = response.data;
        });
      });
    }
  },
  created() {
    this.getInfo();
  }
};
</script>
