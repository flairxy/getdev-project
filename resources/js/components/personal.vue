<template>
  <div class="row">
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
    <div class="col-md-6">
      <div class="col-lg-10">
        <form enctype="multipart/form-data" @submit.prevent="onUploadID">
          <div class="form-group">
            <label>
              Upload ID Card
              <span class="text-danger">required</span>
            </label>
            <div class="custom-file">
              <input
                type="file"
                ref="file1"
                class="custom-file-input js-custom-file-input-enabled"
                name="example-file-input-custom"
                data-toggle="custom-file-input"
                @change="onFileChanged"
                accept=".jpeg, .jpg, .png"
                required
              />
              <label class="custom-file-label" for="example-file-input-custom">Choose File</label>
            </div>
          </div>
          <!-- <div class="col-lg-4"> -->
          <button
            type="submit"
            class="btn btn-danger btn-sm"
          >{{ processing2 && uploadingID ? `Uploading...` : `Upload ID` }}</button>
          <!-- </div> -->
        </form>
      </div>

      <div class="col-lg-10 mt-30">
        <form enctype="multipart/form-data" @submit.prevent="onUploadAvatar">
          <div class="form-group">
            <label>
              Upload Avatar
              <span class="text-danger">required</span>
            </label>
            <div class="custom-file">
              <input
                type="file"
                ref="file2"
                class="custom-file-input js-custom-file-input-enabled"
                name="example-file-input-custom"
                data-toggle="custom-file-input"
                @change="onFileChanged"
                accept=".jpeg, .jpg, .png"
                required
              />
              <label class="custom-file-label" for="example-file-input-custom">Choose File</label>
            </div>
          </div>
          <!-- <div class="col-lg-4"> -->
          <button
            type="submit"
            class="btn btn-danger btn-sm"
          >{{ processing2 && uploadingAvatar ? `Uploading...` : `Upload Avatar` }}</button>
          <!-- </div> -->
        </form>
      </div>
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
      user: {},
      processing: false,
      processing2: false,
      form: new Form({
        country: "",
        zip: "",
        state: "",
        address: "",
        phone: ""
      }),
      imageUrl: null,
      file: "",
      uploadingID: false,
      uploadingAvatar: false
    };
  },
  methods: {
    onFileChanged(event) {
      let uploadedFile = event.target.files[0];
      this.file = uploadedFile;
    },
    onUploadID() {
      const formData = new FormData();
      formData.append("id_card", this.file);
      this.processing2 = true;
      this.uploadingID = true;
      AR.tutorUpdateProfile(formData, this.user.id)
        .then(response => {
          this.file = "";
          this.processing2 = false;
          this.uploadingID = false;
          toast.fire({
            type: "success",
            title: "ID upload successful"
          });
        })
        .catch(() => {
          this.file = "";
          toast({
            type: "warning",
            title: "Failed to upload ID"
          });
        });
    },
    onUploadAvatar() {
      this.uploadingAvatar = true;
      this.processing2 = true;
      const formData = new FormData();
      formData.append("avatar", this.file);
      AR.tutorUpdateProfile(formData, this.user.id)
        .then(response => {
          this.file = "";
          this.processing2 = false;
          this.uploadingAvatar = false;
          toast.fire({
            type: "success",
            title: "Avatar upload successful"
          });
        })
        .catch(() => {
          this.file = "";
          toast({
            type: "warning",
            title: "Failed to upload avatar"
          });
        });
    },
    updateProfile(id) {
      this.processing = true;
      AR.tutorUpdateProfile(this.form, id)
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
  created() {
    AR.loggedInUser().then(response => {
      this.user = response.data;
      AR.tutor(response.data.id).then(res => {
        this.form.country = res.data.country;
        this.form.state = res.data.state;
        this.form.address = res.data.address;
        this.form.zip = res.data.zip;
        this.form.phone = res.data.phone;
      });
    });
  }
};
</script>

<style scoped>
</style>
