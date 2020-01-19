import axios from "axios";
const admin = "/api/admin";
const student = "/api/student";
const staff = "/api/staff";
export default {
    //AUTHENTICATIONS
    loggedInUser() {
        return axios.get(`/api/user`);
    },
    getClasses() {
        return axios.get(`${admin}/classes`);
    },
    banStudents(data) {
        return axios.post(`${admin}/students/ban`, data);
    },
    banStaffs(data) {
        return axios.post(`${admin}/staffs/ban`, data);
    },
    activateStudents(data) {
        return axios.post(`${admin}/students/activate`, data);
    },
    activateStaffs(data) {
        return axios.post(`${admin}/staffs/activate`, data);
    },

    //Admin Staff routes
    createStaff(data) {
        return axios.post(`${admin}/staffs`, data);
    },
    staffDelete(id) {
        return axios.delete(`${admin}/staffs/${id}`);
    },
    updateStaff(data, id) {
        return axios.put(`${admin}/staffs/${id}`, data);
    },
    getStaffs() {
        return axios.get(`${admin}/staffs`);
    },
    getRoles() {
        return axios.get(`${admin}/roles`);
    },
    getAdminStaffClasses(id) {
        return axios.get(`${admin}/staff/class/${id}`);
    },
    removeStaffFromClass(data) {
        return axios.post(`${admin}/staff/class`, data);
    },

    //Admin Student Routes
    createStudent(data) {
        return axios.post(`${admin}/students`, data);
    },
    studentDelete(id) {
        return axios.delete(`${admin}/students/${id}`);
    },
    removeStudentFromClass(data) {
        return axios.post(`${admin}/student/class`, data);
    },
    getAdminStudentClasses(id) {
        return axios.get(`${admin}/student/class/${id}`);
    },

    updateStudent(data, id) {
        return axios.put(`${admin}/students/${id}`, data);
    },
    getStudents() {
        return axios.get(`${admin}/students`);
    },
    createClass(data) {
        return axios.post(`${admin}/classes`, data);
    },
    classDelete(id) {
        return axios.delete(`${admin}/classes/${id}`);
    },
    updateClass(data, id) {
        return axios.put(`${admin}/classes/${id}`, data);
    },

    // Student Routes
    student(id) {
        return axios.get(`${student}/students/${id}`);
    },
    studentUpdate(data, id) {
        return axios.put(`${student}/students/${id}`, data);
    },
    getClassByLevel(id) {
        return axios.get(`${student}/students/${id}/class`);
    },
    getStudentClasses(id) {
        return axios.get(`${student}/students/class/${id}`);
    },
    enrollStudentClass(data) {
        return axios.post(`${student}/students/enroll`, data);
    },

    //Staff Routes
    getRole(id) {
        return axios.get(`${staff}/${id}/role`);
    },
    staff(id) {
        return axios.get(`${staff}/staffs/${id}`);
    },

    staffUpdate(data, id) {
        return axios.put(`${staff}/staffs/${id}`, data);
    },
    enrollStaffClass(data) {
        return axios.post(`${staff}/staffs/enroll`, data);
    },
    getStaffClasses(id) {
        return axios.get(`${staff}/staffs/class/${id}`);
    },
    getTeacherStudents(id) {
        return axios.get(`${staff}/staffs/${id}/students`);
    }
};
