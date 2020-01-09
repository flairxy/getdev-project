<template>
  <div>
    <div class="row">
      <div class="col-md-8 col-xl-5">
        <a class="block block-link-shadow" href="javascript:void(0)">
          <div class="block-content block-content-full clearfix">
            <div class="text-right float-right mt-10">
              <div class="font-w600 mb-5 text-danger">
                <a
                  v-if="user.email_verified_at == null"
                  class="badge badge-warning"
                  href="javascript:void(0)"
                >Email Not Verified</a>
                <a v-else class="badge badge-success" href="javascript:void(0)">Email Verified</a>
              </div>
              <div class="font-size-sm text-muted">joined: {{user.created_at}}</div>
              <div class="form-group" v-if="user.email_verified_at == null">
                <br />
                <div v-if="processing" class="col-6 col-md-3">
                  <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
                </div>
                <button
                  v-else
                  @click.prevent="sendCode(user.id)"
                  class="btn btn-md btn-outline-primary"
                >Send verification email</button>
              </div>
            </div>
            <div class="float-left">
              <img class="img-avatar" :src="avatar" />
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-4"></div>
    </div>
    <div class="mt-3">
      <div>
        <!-- tab content navigation -->
        <div class="row align-items-center">
          <div class="col">
            <ul class="nav nav-tabs nav-tabs-alt js-tabs-enabled" role="tablist">
              <li class="nav-item">
                <a
                  class="nav-link active"
                  id="personal-tab"
                  data-toggle="tab"
                  href="#personal"
                  role="tab"
                  aria-controls="personal"
                  aria-selected="true"
                >Personal Data</a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  id="security-tab"
                  data-toggle="tab"
                  href="#security"
                  role="tab"
                  aria-controls="security"
                  aria-selected="false"
                >Security</a>
              </li>
              <!--                            <li class="nav-item">-->
              <!--                                <a class="nav-link" id="wallet-tab" data-toggle="tab" href="#wallet"-->
              <!--                                   role="tab"-->
              <!--                                   aria-controls="wallet" aria-selected="false">Wallet</a>-->
              <!--                            </li>-->
            </ul>
          </div>
        </div>
        <!-- end of tab content navigation -->
        <!-- tab content  -->
        <div class="tab-content" id="myTabContent">
          <div
            class="tab-pane fade show active"
            id="personal"
            role="tabpanel"
            aria-labelledby="personal-tab"
          >
            <personal-component
              :email="user.email"
              :username="user.username"
              :name="user.name"
              :country="user.country"
              :state="user.state"
              :zip="user.zip"
            />
          </div>
          <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
            <security-component />
          </div>
          <!--                    <div class="tab-pane fade" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">-->
          <!--                        <wallet-component/>-->
          <!--                    </div>-->
        </div>
        <!-- end of tab content -->

        <!-- 2fa begins -->
        <div class="container mt-3">
          <div class="row">
            <div class="col-md-8">
              <div class="block block-bordered">
                <div class="block-header">
                  <span class="col-md-8">
                    <strong>
                      <h2 class="block-title">Two-Factor Authentication</h2>
                    </strong>
                  </span>
                  <span class="col-md-4">
                    <b class="text-danger" v-if="user.enable_2fa == '0'">Disabled</b>
                    <b class="text-earth" v-else>Enabled</b>
                  </span>
                </div>
                <div class="block-content">
                  <span>
                    Two-factor authentication is a method for protecting your account.
                    When it is activated you need to enter not only your password, but also a special code.
                    This code will be sent to your email address.
                  </span>
                  <div class="mb-2 mt-2">
                    <form @submit.prevent="toggle2fa(user.id, user)">
                      <button
                        v-if="user.enable_2fa == '0'"
                        type="submit"
                        class="btn btn-info"
                      >Enable</button>
                      <button v-else type="submit" class="btn btn-danger">Disable</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- 2fa ends -->
      </div>
    </div>
  </div>
</template>

<script>
import SecurityComponent from "../../components/studentSecurity";
import PersonalComponent from "../../components/studentPersonal";

import { RepositoryFactory as Repo } from "../../repository/RepositoryFactory";

const AR = Repo.get("academy");

export default {
  components: {
    SecurityComponent,
    PersonalComponent
  },
  data() {
    return {
      avatar: "/images/avatar9.jpg",
      user: "",
      processing: false
    };
  },
  methods: {
    sendCode(id) {
      this.processing = true;
      let data = {
        user: id
      };
      AR.verifyEmail(data)
        .then(response => {
          this.processing = false;
          toast.fire({
            type: "success",
            title: "Verification email sent"
          });
        })
        .catch(() => {
          toast({
            type: "warning",
            title: "Failed to sent verification email"
          });
        });
    },
    getUser() {
      AR.loggedInUser().then(response => {
        this.user = response.data;
      });
    }
  },
  created() {
    this.getUser();
    Fire.$on("Refresh", () => {
      this.getUser();
    });
  }
};
</script>

