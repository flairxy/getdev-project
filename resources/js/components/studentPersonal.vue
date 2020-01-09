<template>
  <div class="col-md-6">
    <div class="block-content">
      <form action method="post" @submit.prevent="updateProfile(user.id)">
        <div class="form-group">
          <div class>
            <label for="username">Username</label>
            <input type="text" class="form-control" :value="username" disabled id="username" />
          </div>
        </div>
        <div class="form-group">
          <div class>
            <label for="name">Name</label>
            <input type="text" class="form-control" :value="name" disabled id="name" />
          </div>
        </div>
        <div class="form-group">
          <div class>
            <label for="email">Email</label>
            <input
              type="email"
              class="form-control"
              :value="email"
              id="email"
              disabled
              name="material-text"
            />
          </div>
        </div>
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
            <label for="username">Address</label>
            <input type="text" class="form-control" v-model="form.address" />
          </div>
        </div>

        <div class="form-group">
          <div class>
            <label for="username">Zip</label>
            <input type="text" class="form-control" v-model="form.zip" />
          </div>
        </div>

        <div>
          <div v-if="processing" class="col-6 col-md-3">
            <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
          </div>
          <button type="submit" class="btn btn-md btn-outline-primary mb-10">Update Profile</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { RepositoryFactory } from "../repository/RepositoryFactory";
import axios from "axios";

const AR = RepositoryFactory.get("academy");
export default {
  props: {
    username: String,
    name: String,
    country: String,
    state: String,
    address: String,
    zip: String,
    email: String
  },
  data() {
    return {
      user: "",
      processing: false,
      form: new Form({
        country: "",
        zip: "",
        state: "",
        address: ""
      })
    };
  },
  methods: {
    updateProfile(id) {
      this.processing = true;

      AR.studentUpdateProfile(this.form, id)
        .then(response => {
          this.processing = false;
          toast.fire({
            type: "success",
            title: "Profile updated successfully"
          });
        })
        .catch(() => {
          toast({
            type: "warning",
            title: "Failed to update profile"
          });
        });
    }
  },
  mounted() {
    axios.get("api/user").then(response => {
      this.user = response.data;
      this.form.country = response.data.country;
      this.form.state = response.data.state;
      this.form.address = response.data.address;
      this.form.zip = response.data.zip;
    });
  }
};
</script>

<style scoped>
</style>
