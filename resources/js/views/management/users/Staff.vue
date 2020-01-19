<template>
  <div class="content bg-white-op-90">
    <div v-if="!toggled">
      <div class="container row py-30">
        <span class="mr-2" v-if="role == 'dean'">
          <button class="btn btn-sm btn-primary" @click.prevent="newStaff">New Staff</button>
        </span>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <form action="be_pages_generic_search.html" method="post">
            <div class="input-group">
              <input
                type="text"
                class="form-control text-primary bg-primary-lighter"
                placeholder="Enter email, name or role"
                id="page-header-search-input"
                v-model="search"
              />
            </div>
          </form>
        </div>
      </div>
      <div class="push">
        <div class="content">
          <button
            v-if="role == 'dean'"
            type="button"
            class="btn btn-rounded btn-alt-secondary float-right"
          >
            <i class="fa fa-trash text-danger mx-5"></i>
            <span class="d-none d-sm-inline" @click.prevent="deleteStaff">Delete</span>
          </button>
          <button v-if="role == 'admin'" type="button" class="btn btn-sm btn-danger float-right">
            <span class="d-none d-sm-inline" @click.prevent="banUser">Deactivate</span>
          </button>
          <button
            v-if="role == 'admin'"
            type="button"
            class="btn btn-sm btn-success float-right mr-2"
          >
            <span class="d-none d-sm-inline" @click.prevent="activateUser">Activate</span>
          </button>
        </div>
      </div>
      <div class="block-content">
        <div class="table-responsive">
          <table class="table table-striped table-vcenter">
            <thead>
              <tr>
                <th>
                  <label class="css-control css-control-primary css-checkbox">
                    <input
                      type="checkbox"
                      :value="checkedStudents"
                      v-model="checkedStudents"
                      class="css-control-input"
                    />
                    <span class="css-control-indicator"></span>
                  </label>
                </th>
                <th>Name</th>
                <th>Email</th>
                <th>Staff ID</th>
                <th>Roles</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(staff, index) in filteredStaffs" :key="staff.id">
                <td class="text-center" style="width: 40px;">
                  <label class="css-control css-control-primary css-checkbox">
                    <input
                      type="checkbox"
                      :value="staff.id"
                      v-model="checkedStudents"
                      class="css-control-input"
                    />
                    <span class="css-control-indicator"></span>
                  </label>
                </td>
                <td>{{staff.name}}</td>
                <td>{{staff.email}}</td>
                <td>{{ staff.staff_id }}</td>
                <td>
                  <span v-for="role in staff.role">
                    {{ role.slug }}
                    <br />
                  </span>
                </td>
                <td>
                  <span v-if="staff.status == 0" class="text-success">
                    <b>Active</b>
                  </span>
                  <span v-else class="text-danger">
                    <b>Banned</b>
                  </span>
                </td>

                <td>
                  <button
                    @click.prevent="viewStaff(staff)"
                    type="button"
                    class="btn btn-sm btn-primary js-tooltip-enabled"
                  >
                    <i class="fa fa-eye"></i>
                  </button>
                  <button
                    v-if="role == 'dean'"
                    @click.prevent="editStaff(staff)"
                    type="button"
                    class="btn btn-sm btn-success js-tooltip-enabled"
                  >
                    <i class="fa fa-edit"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Staff Information -->
    <div v-else>
      <!-- //staff info modal -->
      <div class="push">
        <div class="content">
          <a @click.prevent="back" class="float-right pointer">
            <i class="fa fa-backward text-danger mx-5"></i>
            <span class="d-none d-sm-inline">Back to staffs</span>
          </a>
        </div>
      </div>
      <div class="block-content bg-white-op-90 block-content-full bg-body">
        <div class="mb-30" v-if="currentStaffRole == 'teacher'">
          <h5 class="text-primary">Staff Enrolled Classes</h5>
          <div class="container row py-30">
            <span class="mr-2">
              <button class="btn btn-sm btn-primary" @click.prevent="showClasses">Enroll in class</button>
            </span>
          </div>
          <span class="text-danger">You can enroll up to 3 classes</span>

          <div class="table-responsive">
            <table class="table table-striped table-vcenter">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th v-if="role == 'dean'">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(aClass, index) in selectedClasses" :key="aClass.id">
                  <td class="text-center" style="width: 40px;">{{ index + 1 }}</td>
                  <td>{{aClass.name}}</td>

                  <td v-if="role == 'dean'">
                    <button
                      @click.prevent="removeFromClass(currentStaff.staff, aClass.id)"
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
        <div>
          <h5 class="text-muted">More Staff Information</h5>
        </div>
      </div>
    </div>

    <!-- classes modal -->
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
                    <tr v-for="(aClass, index) in classes" :key="aClass.id">
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

    <!-- classes modal ends -->

    <!-- new staff modal -->

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
              <h3 class="block-title">{{ edit ? 'Edit Staff' : 'New Staff' }}</h3>
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
                      placeholder="fullname"
                    />
                    <label for="material-text">Name</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-material">
                    <input
                      type="text"
                      class="form-control"
                      v-model="form.email"
                      placeholder="Email"
                    />
                    <label for="material-text">Email</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-material">
                    <select class="form-control" id="material-select2" v-model="form.role">
                      <!-- Empty value for demostrating material select box -->
                      <option
                        v-for="role in roles"
                        :key="role.id"
                        :value="role.slug"
                      >{{ role.slug }}</option>
                    </select>
                    <label for="material-select2">Assign Role</label>
                  </div>
                </div>
                <div class="col-md-12 pt-30">
                  <button
                    v-if="!edit"
                    class="btn btn-primary"
                    @click.prevent="createStaff"
                  >{{ processing ? `creating...` : 'create staff' }}</button>
                  <button
                    v-else
                    class="btn btn-primary"
                    @click.prevent="updateStaff"
                  >{{ processing ? `updating...` : 'update staff' }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- new staff model ends -->
  </div>
</template>
<script>
import { RepositoryFactory as Repo } from "../../../repository/RepositoryFactory";
const AR = Repo.get("academy");
export default {
  data() {
    return {
      search: "",
      currentId: "",
      processing: false,
      toggled: false,
      edit: false,
      currentStaff: {},
      roles: [],
      role: "",
      staffs: [],
      classes: [],
      currentStaffRole: "",
      checkedStudents: [],
      selectedClasses: [],
      form: new Form({
        name: "",
        email: "",
        role: "",
        id: ""
      })
    };
  },
  methods: {
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
            let data = {
              ids: classIds,
              staff: this.currentStaff.staff
            };
            AR.enrollStaffClass(data)
              .then(response => {
                Fire.$emit("Refresh");
                Fire.$emit("Ref");
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
    removeClass(id) {
      let myNewClasses = [];
      //   remove the class using the id from the array of the selected classes
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
      //   get all the ids of the selected classes
      currentClasses.map(myClass => {
        ids.push(myClass.id);
      });
      //   check if the class exists and add to the array of false
      let value = ids.includes(newClass.id);
      if (!value && this.selectedClasses.length < 3) {
        this.selectedClasses.push(newClass);
      }
    },
    // returns all the classes in the school
    getClasses() {
      AR.getClasses().then(res => {
        this.classes = res.data;
      });
    },
    showClasses() {
      this.form.reset();
      $("#modal-popin1").modal("show");
    },
    banUser() {
      let data = {
        ids: this.checkedStudents
      };
      AR.banStaffs(data).then(res => {
        Fire.$emit("Refresh");
        toast.fire({
          type: "success",
          title: "Users Deactivated"
        });
      });
    },
    activateUser() {
      let data = {
        ids: this.checkedStudents
      };
      AR.activateStaffs(data).then(res => {
        Fire.$emit("Refresh");
        toast.fire({
          type: "success",
          title: "Users Deactivated"
        });
      });
    },
    back() {
      this.toggled = false;
    },
    // remove a teacher from a class
    removeFromClass(sId, id) {
      let data = {
        staff: sId,
        class: id
      };
      AR.removeStaffFromClass(data).then(() => {
        Fire.$emit("Ref");
        toast.fire({
          type: "success",
          title: "Updated Successfully"
        });
      });
    },
    viewStaff(staff) {
      //   $("#modal-popin").modal("show");
      this.toggled = true;
      //   this.currentStudent = student;
      this.currentId = staff.id;
      this.currentStaffRole = staff.role[0].slug;
      Fire.$emit("Ref");
    },
    deleteStaff() {
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
            AR.staffDelete(this.checkedStudents[0])
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
    updateStaff() {
      this.processing = true;
      AR.updateStaff(this.form, this.form.id)
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
    editStaff(staff) {
      this.edit = true;
      this.form.reset();
      $("#modal-popin1").modal("show");
      this.form.fill(staff);
    },
    createStaff() {
      this.processing = true;
      AR.createStaff(this.form)
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
    newStaff() {
      this.form.reset();
      $("#modal-popin1").modal("show");
    },
    getRoles() {
      AR.getRoles().then(res => {
        this.roles = res.data;
      });
    },
    getStaffs() {
      AR.getStaffs().then(res => {
        this.staffs = res.data;
      });
    },
    getStaffClasses() {
      AR.getAdminStaffClasses(this.currentId).then(res => {
        this.selectedClasses = res.data.classes;
        this.currentStaff = res.data;
      });
    },
    getRole() {
      this.role = this.$store.getters.getRole;
    }
  },
  created() {
    this.getRoles();
    this.getStaffs();
    this.getRole();
    this.getClasses();
    Fire.$on("Refresh", () => {
      this.getStaffs();
    });
    Fire.$on("Ref", () => {
      this.getStaffClasses();
      this.getClasses();
    });
  },
  computed: {
    filteredStaffs() {
      return this.staffs.filter(staff => {
        return (
          staff.staff_id.toLowerCase().includes(this.search.toLowerCase()) ||
          staff.email.toLowerCase().includes(this.search.toLowerCase()) ||
          staff.role[0].slug
            .toLowerCase()
            .includes(this.search.toLowerCase()) ||
          staff.name.toLowerCase().includes(this.search.toLowerCase())
        );
      });
    }
  }
};
</script>
