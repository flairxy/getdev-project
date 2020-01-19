<template>
  <div class="content bg-white-op-90">
    <div class="container row py-30">
      <span class="mr-2">
        <button class="btn btn-sm btn-primary" @click.prevent="showClasses">Enroll in class</button>
      </span>
    </div>

    <div class="block-content">
      <span class="text-danger">You can enroll up to 6 classes</span>
      <div class="table-responsive">
        <table class="table table-striped table-vcenter">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th v-if="selecting">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(myClass, index) in selectedClasses" :key="myClass.id">
              <td class="text-center" style="width: 40px;">{{ index + 1 }}</td>
              <td>{{myClass.name}}</td>

              <td>
                <button
                  v-if="selecting"
                  @click.prevent="removeClass(myClass.id)"
                  type="button"
                  class="btn btn-sm btn-danger js-tooltip-enabled"
                >
                  <i class="fa fa-trash"></i> Remove
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="py-10" v-if="selectedClasses.length > 0">
          <button class="btn btn-sm btn-primary" @click.prevent="enrollClasses">Enroll Now</button>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="modal-popin1"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modal-popin"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-popin modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary">
              <h3 class="block-title">Enroll in classes</h3>
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

            <div class="block-content bg-white-op-90 block-content-full bg-body">
              <!-- <div class="block-content"> -->
              <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(aClass, index) in filteredClasses" :key="aClass.id">
                      <td class="text-center" style="width: 40px;">{{ index + 1 }}</td>
                      <td>{{aClass.name}}</td>

                      <td>
                        <button
                          @click.prevent="moveToSelected(aClass)"
                          type="button"
                          class="btn btn-sm btn-success js-tooltip-enabled"
                        >
                          <i class="fa fa-edit"></i> Enroll
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <button type="button" data-dismiss="modal" class="btn btn-primary">Done</button>
              <!-- </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { RepositoryFactory as Repo } from "../../repository/RepositoryFactory";
const AR = Repo.get("academy");
export default {
  data() {
    return {
      search: "",
      processing: false,
      selecting: false,
      edit: false,
      classes: [],
      selectedClasses: [],
      checkedMessages: [],
      form: new Form({
        name: "",
        id: ""
      })
    };
  },
  methods: {
    removeClass(id) {
      let myNewClasses = [];
      this.selectedClasses.map(myClass => {
        if (myClass.id != id) {
          myNewClasses.push(myClass);
        }
      });
      this.selectedClasses = myNewClasses;
    },
    moveToSelected(newClass) {
      this.selecting = true;
      let currentClasses = this.selectedClasses;
      let ids = [];
      currentClasses.map(myClass => {
        ids.push(myClass.id);
      });
      let value = ids.includes(newClass.id);
      if (!value && this.selectedClasses.length < 6) {
        this.selectedClasses.push(newClass);
      }
    },
    enrollClasses() {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, continue!"
        })
        .then(result => {
          // Send request to the server
          if (result.value) {
            let classIds = [];
            this.selectedClasses.map(myClass => {
              classIds.push(myClass.id);
            });
            let user = JSON.parse(this.$localStorage.get("user"));
            let data = {
              ids: classIds,
              student: user.id
            };
            AR.enrollStudentClass(data)
              .then(response => {
                Fire.$emit("Refresh");
                swal.fire(
                  response.data.info,
                  response.data.message,
                  response.data.status
                );
              })
              .catch(error => {
                swal("Failed!", "There was something wrong.", "warning");
              });
          }
        });
    },

    showClasses() {
      this.form.reset();
      $("#modal-popin1").modal("show");
    },
    getClasses() {
      let user = JSON.parse(this.$localStorage.get("user"));
      AR.getClassByLevel(user.id).then(res => {
        this.classes = res.data;
      });
      AR.getStudentClasses(user.id).then(res => {
        this.selectedClasses = res.data;
      });
    }
  },
  created() {
    this.getClasses();
    Fire.$on("Refresh", () => {
      this.getClasses();
    });
  },
  computed: {
    filteredClasses() {
      return this.classes.filter(x => {
        return x.name.toLowerCase().includes(this.search.toLowerCase());
      });
    }
  }
};
</script>
