<template>
  <div>
    <div class="content">

      <div class="mt-3">
        <div>
          <!-- tab content navigation -->
          <div class="row align-items-center">
            <div class="col">
              <ul class="nav nav-tabs nav-tabs-alt js-tabs-enabled" role="tablist">

                <li class="nav-item">
                  <a
                    class="nav-link active"
                    id="security-tab"
                    data-toggle="tab"
                    href="#security"
                    role="tab"
                    aria-controls="security"
                    aria-selected="false"
                  >Security</a>
                </li>

              </ul>
            </div>
          </div>
          <!-- end of tab content navigation -->
          <!-- tab content  -->
          <div class="tab-content" id="myTabContent">
            <div
              class="tab-pane fade show active"
              id="security"
              role="tabpanel"
              aria-labelledby="personal-tab"
            >
              <security-component />
            </div>

          </div>
          <!-- end of tab content -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SecurityComponent from "../../components/security";

import { RepositoryFactory as Repo } from "../../repository/RepositoryFactory";

const AR = Repo.get("academy");

export default {
  components: {
    SecurityComponent
  },
  data() {
    return {
      avatar: "/images/avatar9.jpg",
      user: {},
      image: "",
      identity: "",
      processing: false
    };
  },
  methods: {

    getUser() {
      AR.loggedInUser().then(response => {
        this.user = response.data;
        AR.tutor(response.data.id).then(res => {
          this.image = res.data.image;
          this.identity = res.data.identity_status;
        });
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
