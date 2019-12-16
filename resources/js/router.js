import VueRouter from "vue-router";
import Student from "./views/student/Index";
import Tutor from "./views/tutor/Index";
import Management from "./views/management/Index";
import StudentDashboard from "./views/student/Dashboard";
import AdminDashboard from "./views/management/Dashboard";
import StudentCoursePreview from "./views/student/CoursePreview";
import StudentVideoCourse from "./views/student/VideoCourse";
import TutorDashboard from "./views/tutor/Dashboard";
import EditCourse from "./views/tutor/EditCourse";
import CreateCourse from "./views/tutor/CreateCourse";
import Error_404 from "./components/404.vue";

export let routes = [
    // student routes
    {
        path: "/_ds",
        component: Student,
        // component: () => import("./views/student/Index"),
        children: [
            {
                path: "dashboard",
                name: "StudentDashboard",
                component: StudentDashboard
                // component: () => import("./views/student/Dashboard")
            },
            {
                path: ":slug/preview",
                name: "StudentCoursePreview",
                component: StudentCoursePreview
                // component: () => import("./views/student/CoursePreview")
            },
            {
                path: ":id",
                name: "StudentVideoCourse",
                component: StudentVideoCourse
                // component: () => import("./views/student/VideoCourse.vue")
            }
        ]
    },

    // tutor routes
    {
        path: "/_dt",
        component: Tutor,
        // component: () => import("./views/tutor/Index"),
        children: [
            {
                path: "dashboard",
                name: "TutorDashboard",
                component: TutorDashboard
                // component: () => import("./views/tutor/Dashboard.vue")
            },
            {
                path: "course/create",
                name: "CreateCourse",
                component: CreateCourse
                // component: () => import("./views/tutor/CreateCourse.vue")
            },
            {
                path: ":course/edit",
                name: "EditCourse",
                component: EditCourse
                // component: () => import("./views/tutor/EditCourse.vue")
            }
        ]
    },

    // management routes
    {
        path: "/_dmgt",
        component: Management,
        // component: () => import("./views/tutor/Index"),
        children: [
            {
                path: "dashboard",
                name: "AdminDashboard",
                component: AdminDashboard
                // component: () => import("./views/tutor/Dashboard.vue")
            }
        ]
    },

    //general route
    { path: "*", name: "Error_404", component: Error_404 }
];
