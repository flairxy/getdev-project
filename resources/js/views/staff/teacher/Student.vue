<template>
  <div class="content bg-white-op-90">
    <div v-if="!toggled">
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
          <button type="button" class="btn btn-rounded btn-alt-secondary float-right">
            <i class="fa fa-trash text-danger mx-5"></i>
            <span class="d-none d-sm-inline" @click.prevent="deleteStudent">Delete</span>
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
                      :value="checkedMessages"
                      v-model="checkedMessages"
                      class="css-control-input"
                    />
                    <span class="css-control-indicator"></span>
                  </label>
                </th>
                <th>Name</th>
                <th>Email</th>
                <th>Student ID</th>
                <th>Level</th>
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
                      v-model="checkedMessages"
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
                  <button
                    type="button"
                    @click.prevent="viewStudent(student)"
                    class="btn btn-sm btn-primary js-tooltip-enabled"
                  >
                    <i class="fa fa-eye"></i> view classes
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
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
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(aClass, index) in currentStudent.classes" :key="aClass.id">
                <td class="text-center" style="width: 40px;">{{ index + 1 }}</td>
                <td>{{aClass.name}}</td>
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
      currentId: "",
      currentStudent: {},
      checkedMessages: [],
      form: new Form({
        name: "",
        email: "",
        level: "",
        id: ""
      })
    };
  },
  methods: {
    back() {
      this.toggled = false;
    },
    viewStudent(student) {
      //   $("#modal-popin").modal("show");
      this.toggled = true;
      //   this.currentStudent = student;
      this.currentId = student.id;
      Fire.$emit("Ref");
    },
    getTeacherStudents() {
      let user = JSON.parse(this.$localStorage.get("user"));
      AR.getTeacherStudents(user.id).then(res => {
        this.students = res.data;
      });
    },
    getStudentClasses() {
      AR.getAdminStudentClasses(this.currentId).then(res => {
        this.currentStudent = res.data;
      });
    }
  },
  created() {
    this.getTeacherStudents();
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
          student.email.toLowerCase().includes(this.search.toLowerCase()) ||
          student.name.toLowerCase().includes(this.search.toLowerCase())
        );
      });
    }
  }
};
</script>
