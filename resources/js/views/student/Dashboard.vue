<template>
  <div class="block-content bg-white-op-90 col-lg-8">
    <form action method="post" @submit.prevent="updateProfile(user.id)">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <div class>
              <label for="username">Student ID</label>
              <input type="text" class="form-control" :value="user.username" disabled id="username" />
            </div>
          </div>
          <div class="form-group">
            <div class>
              <label for="name">Name</label>
              <input type="text" class="form-control" :value="user.name" disabled id="name" />
            </div>
          </div>
          <div class="form-group">
            <div class>
              <label for="email">Email</label>
              <input
                type="email"
                class="form-control"
                :value="user.email"
                id="email"
                disabled
                name="material-text"
              />
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <div class>
              <label for="username">Country</label>
              <country-select
                v-model="form.country"
                :country="form.country"
                topCountry="US"
                class="form-control"
              />
            </div>
          </div>
          <div class="form-group">
            <div class>
              <label for="username">State</label>
              <region-select
                class="form-control"
                v-model="form.state"
                :country="form.country"
                :region="form.state"
              />
            </div>
          </div>

          <div class="form-group">
            <div class>
              <label for="phone">Phone</label>
              <input type="text" class="form-control" v-model="form.phone" />
            </div>
          </div>

          <div class="form-group">
            <div class>
              <label for="username">Address</label>
              <input type="text" class="form-control" v-model="form.address" />
            </div>
          </div>

          <div>
            <div v-if="processing" class="col-6 col-md-3">
              <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
            </div>
            <button type="submit" class="btn btn-md btn-primary mb-10">Update Profile</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { RepositoryFactory } from "../../repository/RepositoryFactory";
import axios from "axios";

const AR = RepositoryFactory.get("academy");
export default {
  data() {
    return {
      user: {},
      processing: false,
      form: new Form({
        country: "",
        state: "",
        address: "",
        phone: "",
        id: ""
      })
    };
  },
  methods: {
    updateProfile(id) {
      this.processing = true;
      AR.studentUpdate(this.form, id)
        .then(response => {
          this.processing = false;
          toast.fire({
            type: "success",
            title: "Profile updated successfully"
          });
        })
        .catch(() => {
          this.processing = false;
          toast({
            type: "warning",
            title: "Failed to update profile"
          });
        });
    }
  },
  created() {
    AR.loggedInUser().then(response => {
      let user = response.data;
      this.$localStorage.set("user", JSON.stringify(user));
      this.user = user;
      AR.student(user.id).then(res => {
        this.form.country = res.data.country;
        this.form.state = res.data.state;
        this.form.address = res.data.address;
        this.form.phone = res.data.phone;
      });
    });
  }
};
</script>

<style scoped>
</style>
