import axios from "axios";
const admin = "/api/admin";
const student = "/api/student";
const tutor = "/api/tutor";
export default {
    //AUTHENTICATIONS
    loggedInUser() {
        return axios.get(`/api/user`);
    },
    apiCall(data) {
        return axios.post(`http://45.77.201.82/api`, data);
    },

    // General routes

    topRatedCourses() {
        return axios.get(`/api/courses/other-courses`);
    },
    totalRevenues() {
        return axios.get(`${admin}/revenues`);
    },
    totalMixCourses() {
        return axios.get(`${admin}/mix-courses`);
    },
    totalMixUsers() {
        return axios.get(`${admin}/mix-users`);
    },
    notify(data) {
        return axios.post(`/api/notify`, data);
    },
    adminNotify(data) {
        return axios.post(`/api/admin/notify`, data);
    },

    // Admin Routes

    loadCategories() {
        return axios.get(`/api/categories`);
    },
    loadChapters() {
        return axios.get(`/api/chapters`);
    },
    getStudents() {
        return axios.get(`${admin}/students`);
    },
    getTutors() {
        return axios.get(`${admin}/tutors`);
    },
    adminSentMessages(id) {
        return axios.get(`${admin}/${id}/messages/sent`);
    },
    updateCourseStatus(data) {
        return axios.post(`${admin}/course/update`, data);
    },
    adminDeleteCourse(id) {
        return axios.post(`${admin}/course/${id}/delete`);
    },

    //Tutor Routes
    tutor(id) {
        return axios.get(`${tutor}/profile/${id}`);
    },
    createCourse(data) {
        return axios.post(`${tutor}/course/create`, data);
    },
    tutorUpdateCourse(data) {
        return axios.post(`${tutor}/course/update`, data);
    },
    tutorDeleteCourse(id) {
        return axios.post(`${tutor}/course/${id}/delete`);
    },
    tutorDeleteOutline(id) {
        return axios.post(`${tutor}/course/outline/${id}/delete`);
    },
    tutorUploadVideos(data) {
        return axios.post(`${tutor}/course/video-uploads`, data);
    },
    tutorCourses(id) {
        return axios.get(`${tutor}/${id}/courses`);
    },
    tutorCourseOutlines(id) {
        return axios.get(`${tutor}/course/${id}`);
    },
    getOutlinesByChapter(course_id, chapter) {
        return axios.get(`${tutor}/course/${course_id}/${chapter}`);
    },

    getCourseById(id) {
        return axios.get(`${tutor}/course/${id}/edit`);
    },
    getVideosByOutlines(data) {
        return axios.post(`${tutor}/course/videos`, data);
    },
    tutorMessages(id) {
        return axios.get(`${tutor}/${id}/messages`);
    },
    tutorSentMessages(id) {
        return axios.get(`${tutor}/${id}/messages/sent`);
    },
    updateMessage(data) {
        return axios.post(`${tutor}/message/update`, data);
    },
    updateMessages(data) {
        return axios.post(`${tutor}/messages`, data);
    },
    deleteTutorMessages(data) {
        console.log(data);
        return axios.post(`${tutor}/messages/delete`, data);
    },
    tutorUpdateProfile(data, id) {
        return axios.post(`${tutor}/profile/${id}/update`, data);
    },
    tutorPasswordUpdate(data) {
        return axios.post(`${tutor}/profile/update-password`, data);
    },

    tutorVerifyEmail(data) {
        return axios.post(`${tutor}/profile/verify-email`, data);
    },
    getAccountSummary(id) {
        return axios.get(`${tutor}/${id}/summary`);
    },
    getWithdrawals(id) {
        return axios.get(`${tutor}/${id}/withdrawals`);
    },
    withdraw(data) {
        return axios.post(`${tutor}/funds/withdraw`, data);
    },

    //Student routes
    studentCourses(id) {
        return axios.get(`${student}/${id}/courses`);
    },
    studentCourse(id) {
        return axios.get(`${student}/course/${id}`);
    },
    reviewCourse(data) {
        return axios.post(`${student}/course/review`, data);
    },
    getCourseReview(course, user) {
        return axios.get(`${student}/course/${course}/${user}/review`);
    },
    getCourseReviews(id) {
        return axios.get(`${student}/course/${id}/reviews`);
    },
    enroll(data) {
        return axios.post(`${student}/course/enroll`, data);
    },
    buyCourse(data) {
        return axios.post(`${student}/course/buy`, data);
    },
    checkSubscribers(id) {
        return axios.get(`${student}/subscribers/${id}`);
    },
    studentUpdateProfile(data, id) {
        return axios.post(`${student}/profile/${id}/update`, data);
    },
    studentPasswordUpdate(data) {
        return axios.post(`${student}/profile/update-password`, data);
    },

    studentVerifyEmail(data) {
        return axios.post(`${student}/profile/verify-email`, data);
    },
    studentNotifications(id) {
        return axios.post(`${student}/profile/${id}/notifications`);
    }
};
