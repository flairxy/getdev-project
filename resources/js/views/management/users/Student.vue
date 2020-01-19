<template>
  <div class="content bg-white-op-90">
    <div v-if="!toggled">
      <div class="container row py-30">
        <span class="mr-2" v-if="role == 'dean'">
          <button class="btn btn-sm btn-primary" @click.prevent="newStudent">New student</button>
        </span>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <form action="be_pages_generic_search.html" method="post">
            <div class="input-group">
              <input
                type="text"
                class="form-control text-primary bg-primary-lighter"
                placeholder="Enter email or name"
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
            <span class="d-none d-sm-inline" @click.prevent="deleteStudent">Delete</span>
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
                <th>Student ID</th>
                <th>Level</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(student, index) in filteredStudents" :key="student.id">
                <td class="text-center" style="width: 40px;">
                  <label class="css-control css-control-primary css-checkbox">
                    <input
                      type="checkbox"
                      :value="student.id"
                      v-model="checkedStudents"
                      class="css-control-input"
                    />
                    <span class="css-control-indicator"></span>
                  </label>
                </td>
                <td>{{student.name}}</td>
                <td>{{student.email}}</td>
                <td>{{ student.student_id }}</td>
                <td>{{ student.level }}</td>

                <td>
                  <span v-if="student.status == 0" class="text-success">
                    <b>Active</b>
                  </span>
                  <span v-else class="text-danger">
                    <b>Banned</b>
                  </span>
                </td>

                <td>
                  <button
                    type="button"
                    @click.prevent="viewStudent(student)"
                    class="btn btn-sm btn-primary js-tooltip-enabled"
                  >
                    <i class="fa fa-eye"></i>
                  </button>
                  <button
                    v-if="role == 'dean'"
                    @click.prevent="editStudent(student)"
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
                <h3 class="block-title">{{ edit ? 'Edit Student' : 'New Student' }}</h3>
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
                      <input
                        type="text"
                        class="form-control"
                        id="material-text"
                        v-model="form.level"
                        placeholder="student level"
                      />
                      <label for="material-text">Level (example 100, 200...)</label>
                    </div>
                  </div>

                  <div class="col-md-12 pt-30">
                    <button
                      v-if="!edit"
                      class="btn btn-primary"
                      @click.prevent="createStudent"
                    >{{ processing ? `creating...` : 'create student' }}</button>
                    <button
                      v-else
                      class="btn btn-primary"
                      @click.prevent="updateStudent"
                    >{{ processing ? `updating...` : 'update student' }}</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <!-- //student info modal -->
      <div class="block-content bg-white-op-90 block-content-full bg-body">
        <h5 class="text-primary">Student Enrolled Classes</h5>
        <div class="push">
          <div class="content">
            <button
              type="button"
              @click.prevent="back"
              class="btn btn-rounded btn-alt-secondary float-right"
            >
              <i class="fa fa-backward text-danger mx-5"></i>
              <span class="d-none d-sm-inline">Back to students</span>
            </button>
          </div>
        </div>
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
              <tr v-for="(aClass, index) in currentStudent.classes" :key="aClass.id">
                <td class="text-center" style="width: 40px;">{{ index + 1 }}</td>
                <td>{{aClass.name}}</td>

                <td>
                  <button
                    v-if="role == 'dean'"
                    @click.prevent="removeFromClass(currentStudent.student, aClass.id)"
                    type="button"
                    class="btn btn-sm btn-danger js-tooltip-enabled"
                  >
                    <i class="fa fa-trash"></i> Remove
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
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
      search: "",
      processing: false,
      edit: false,
      toggled: false,
      students: [],
      role: "",
      currentId: "",
      currentStudent: {},
      checkedStudents: [],
      form: new Form({
        name: "",
        email: "",
        level: "",
        id: ""
      })
    };
  },
  methods: {
    banUser() {
      let data = {
        ids: this.checkedStudents
      };
      AR.banStudents(data).then(res => {
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
      AR.activateStudents(data).then(res => {
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
    removeFromClass(sId, id) {
      let data = {
        student: sId,
        class: id
      };
      AR.removeStudentFromClass(data).then(() => {
        Fire.$emit("Ref");
        toast.fire({
          type: "success",
          title: "Updated Successfully"
        });
      });
    },
    viewStudent(student) {
      //   $("#modal-popin").modal("show");
      this.toggled = true;
      //   this.currentStudent = student;
      this.currentId = student.id;
      Fire.$emit("Ref");
    },
    deleteStudent() {
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
            AR.studentDelete(this.checkedStudents[0])
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
    updateStudent() {
      this.processing = true;
      AR.updateStudent(this.form, this.form.id)
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
          toast.fire({
            type: "error",
            title: "Failed! Ensure fields are properly filled"
          });
        });
    },
    editStudent(student) {
      this.edit = true;
      this.form.reset();
      $("#modal-popin1").modal("show");
      this.form.fill(student);
    },
    createStudent() {
      this.processing = true;
      AR.createStudent(this.form)
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
    newStudent() {
      this.form.reset();
      $("#modal-popin1").modal("show");
    },
    getStudents() {
      AR.getStudents().then(res => {
        this.students = res.data;
      });
    },
    getStudentClasses() {
      AR.getAdminStudentClasses(this.currentId).then(res => {
        this.currentStudent = res.data;
      });
    },
    getRole() {
      this.role = this.$store.getters.getRole;
    }
  },
  created() {
    this.getStudents();
    this.getRole();
    Fire.$on("Refresh", () => {
      this.getStudents();
    });
    Fire.$on("Ref", () => {
      this.getStudentClasses();
    });
  },
  computed: {
    filteredStudents() {
      return this.students.filter(student => {
        return (
          student.student_id
            .toLowerCase()
            .includes(this.search.toLowerCase()) ||
          student.email.toLowerCase().includes(this.search.toLowerCase()) ||
          student.name.toLowerCase().includes(this.search.toLowerCase())
        );
      });
    }
  }
};
</script>
