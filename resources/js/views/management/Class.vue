<template>
  <div class="content bg-white-op-90">
    <div class="container row py-30">
      <span class="mr-2" v-if="role == 'dean'">
        <button class="btn btn-sm btn-primary" @click.prevent="newClass">New Class</button>
      </span>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <form action="be_pages_generic_search.html" method="post">
          <div class="input-group">
            <input
              type="text"
              class="form-control text-primary bg-primary-lighter"
              placeholder="Enter  name"
              id="page-header-search-input"
              v-model="search"
            />
          </div>
        </form>
      </div>
    </div>

    <div class="block-content">
      <div class="table-responsive">
        <table class="table table-striped table-vcenter">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Level</th>
              <th>Total Students</th>
              <th v-if="role == 'dean'">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(aClass, index) in filteredClasses" :key="aClass.id">
              <td class="text-center" style="width: 40px;">{{ index + 1 }}</td>
              <td>{{aClass.name}}</td>
              <td>{{aClass.level}}</td>
              <td>{{aClass.tStudents}}</td>

              <td v-if="role == 'dean'">
                <button
                  @click.prevent="editClass(aClass)"
                  type="button"
                  class="btn btn-sm btn-success js-tooltip-enabled"
                >
                  <i class="fa fa-edit"></i>
                </button>
                <button
                  @click.prevent="deleteClass(aClass.id)"
                  type="button"
                  class="btn btn-sm btn-danger js-tooltip-enabled"
                >
                  <i class="fa fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div
      v-if="role == 'dean'"
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
              <h3 class="block-title">{{ edit ? 'Edit Class' : 'New Class' }}</h3>
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
              <div class="form-group row">
                <div class="col-md-12">
                  <div class="form-material">
                    <input
                      type="text"
                      class="form-control"
                      id="material-text"
                      v-model="form.name"
                      placeholder="class name"
                    />
                    <label for="material-text">Name</label>
                  </div>
                </div>
                <!-- <div class="form-group row"> -->
                <div class="col-md-12">
                  <div class="form-material">
                    <input
                      type="text"
                      class="form-control"
                      id="material-text"
                      v-model="form.level"
                      placeholder="class level"
                    />
                    <label for="material-text">Level (example 100, 200...)</label>
                  </div>
                </div>
                <!-- </div> -->
                <div class="col-md-12 pt-30">
                  <button
                    v-if="!edit"
                    class="btn btn-primary"
                    @click.prevent="createClass"
                  >{{ processing ? `creating...` : 'create class' }}</button>
                  <button
                    v-else
                    class="btn btn-primary"
                    @click.prevent="updateClass"
                  >{{ processing ? `updating...` : 'update class' }}</button>
                </div>
              </div>
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
      edit: false,
      role: "",
      classes: [],
      checkedMessages: [],
      form: new Form({
        name: "",
        level: "",
        id: ""
      })
    };
  },
  methods: {
    deleteClass(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          // Send request to the server
          if (result.value) {
            AR.classDelete(id)
              .then(response => {
                Fire.$emit("Refresh");
                swal.fire(
                  "Deleted!",
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
    updateClass() {
      this.processing = true;
      AR.updateClass(this.form, this.form.id)
        .then(res => {
          $("#modal-popin1").modal("hide");
          Fire.$emit("Refresh");
          this.processing = false;
          this.edit = false;
          toast.fire({
            type: "success",
            title: "Updated Successfully"
          });
        })
        .catch(err => {
          this.processing = false;
          if (err.response.status == 422) {
            let infos = err.response.data.errors.name;
            toast.fire({
              type: "error",
              title: infos.toString()
            });
          } else {
            toast.fire({
              type: "error",
              title: "Failed! Ensure fields are properly filled"
            });
          }
        });
    },
    editClass(myClass) {
      this.edit = true;
      this.form.reset();
      $("#modal-popin1").modal("show");
      this.form.fill(myClass);
    },
    createClass() {
      this.processing = true;
      AR.createClass(this.form)
        .then(res => {
          $("#modal-popin1").modal("hide");
          Fire.$emit("Refresh");
          this.processing = false;
          toast.fire({
            type: "success",
            title: "Created Successfully"
          });
        })
        .catch(err => {
          this.processing = false;
          if (err.response.status == 422) {
            let infos = err.response.data.errors.email;
            toast.fire({
              type: "error",
              title: infos.toString()
            });
          } else {
            toast.fire({
              type: "error",
              title: "Failed! Ensure fields are properly filled"
            });
          }
        });
    },
    newClass() {
      this.form.reset();
      $("#modal-popin1").modal("show");
    },
    getClasses() {
      AR.getClasses().then(res => {
        this.classes = res.data;
      });
    },
    getRole() {
      this.role = this.$store.getters.getRole;
    }
  },
  created() {
    this.getClasses();
    this.getRole();
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
