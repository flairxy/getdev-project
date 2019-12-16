import Vue from "vue";
import "bootstrap";
import VueRouter from "vue-router";
import App from "./views/App";
import { routes } from "./router";
import { Form, HasError, AlertError } from "vform";
import Vuex from "vuex";
import store from "./store/Store";
import NProgress from "nprogress";
import "../../node_modules/nprogress/nprogress.css";
import VueClipboard from "vue-clipboard2";
// import AddModal from "./components/AddModal";
import VueProgressBar from "vue-progressbar";
import swal from "sweetalert2";
import vueCountryRegionSelect from "vue-country-region-select";
import BootstrapVue from "bootstrap-vue";

import CourseCard from "./components/CourseCard";
import StudentHeader from "./components/StudentHeader";
import ReviewTop from "./components/ReviewTop";
import StudentReview from "./components/StudentReview";
import CourseLessons from "./components/CourseLessons";
import CourseAims from "./components/CourseAims";
import Thumbnail from "./components/Thumbnail";
import TutorAd from "./components/Ad";
import VueFormWizard from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";

Vue.use(VueFormWizard);
Vue.use(BootstrapVue);
Vue.use(vueCountryRegionSelect);

// components
Vue.component("course-card", CourseCard);
Vue.component("student-header", StudentHeader);
Vue.component("review-top", ReviewTop);
Vue.component("student-review", StudentReview);
Vue.component("course-lesson", CourseLessons);
Vue.component("course-aims", CourseAims);
Vue.component("thumbnail", Thumbnail);
Vue.component("tutor-ad", TutorAd);

window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

Vue.use(VueRouter);
Vue.use(VueClipboard);
Vue.use(Vuex);
Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    height: "3px"
});

// Vue.component("add-modal", AddModal);
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

window.Form = Form;
window.Fire = new Vue();

const router = new VueRouter({
    mode: "history",
    routes
});

router.beforeResolve((to, from, next) => {
    if (to.name) {
        NProgress.start();
    }
    next();
});

router.afterEach((to, from) => {
    NProgress.done();
});

const app = new Vue({
    el: "#app",
    components: { App },
    router,
    Fire,
    store
});
