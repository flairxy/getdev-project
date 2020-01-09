import VueRouter from "vue-router";

// Management routes
import Management from "./views/management/Index";
import MGT_Dashboard from "./views/management/Dashboard";
import MGT_Earning from "./views/management/earnings/Index";
import MGT_EarningSummary from "./views/management/earnings/Summary";
import MGT_Withdrawals from "./views/management/earnings/Withdrawals";
import MGT_Messages from "./views/management/messages/Index";
import MGT_UnreadMessages from "./views/management/messages/Unread";
import MGT_AllMessages from "./views/management/messages/Inbox";
import MGT_SentMessages from "./views/management/messages/Sent";
import MGT_Users from "./views/management/users/Index";
import MGT_Tutors from "./views/management/users/Tutor";
import MGT_Students from "./views/management/users/Student";
import MGT_Courses from "./views/management/courses/Index";
import MGT_PendingCourses from "./views/management/courses/Pending";
import MGT_ApprovedCourses from "./views/management/courses/Approved";

// Tutor routes
import Tutor from "./views/tutor/Index";
import Tutor_Dashboard from "./views/tutor/Dashboard";
import Tutor_Messages from "./views/tutor/messages/Index";
import Tutor_AllMessages from "./views/tutor/messages/Inbox";
import Tutor_SentMessages from "./views/tutor/messages/Sent";
import Tutor_UnreadMessages from "./views/tutor/messages/Unread";
import Tutor_Earning from "./views/tutor/earnings/Index";
import Tutor_EarningSummary from "./views/tutor/earnings/Summary";
import Tutor_EditCourse from "./views/tutor/EditCourse";
import Tutor_Withdrawals from "./views/tutor/earnings/Withdrawals";
import Tutor_CreateCourse from "./views/tutor/CreateCourse";
import Tutor_Profile from "./views/tutor/Profile";

// Student routes
import Student from "./views/student/Index";
import StudentDashboard from "./views/student/Dashboard";
import StudentCoursePreview from "./views/student/CoursePreview";
import StudentVideoCourse from "./views/student/VideoCourse";
import StudentProfile from "./views/student/Profile";
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
            },
            {
                path: "profile",
                name: "StudentProfile",
                component: StudentProfile
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
                component: Tutor_Dashboard
                // component: () => import("./views/tutor/Dashboard.vue")
            },
            {
                path: "course/create",
                name: "CreateCourse",
                component: Tutor_CreateCourse
                // component: () => import("./views/tutor/CreateCourse.vue")
            },
            {
                path: ":course/:slug/edit",
                name: "EditCourse",
                component: Tutor_EditCourse
                // component: () => import("./views/tutor/EditCourse.vue")
            },
            {
                path: "messages",
                component: Tutor_Messages,
                children: [
                    {
                        path: "inbox",
                        name: "Tutor_AllMessages",
                        component: Tutor_AllMessages
                    },
                    // {
                    //     path: "unread",
                    //     name: "Tutor_UnreadMessages",
                    //     component: Tutor_UnreadMessages
                    // },
                    {
                        path: "sent",
                        name: "Tutor_SentMessages",
                        component: Tutor_SentMessages
                    }
                ]
            },
            {
                path: "earnings",
                component: Tutor_Earning,
                children: [
                    {
                        path: "summary",
                        name: "tutor_earningSummary",
                        component: Tutor_EarningSummary
                    },
                    {
                        path: "withdrawals",
                        name: "Tutor_withdrawals",
                        component: Tutor_Withdrawals
                    }
                ]
            },
            ,
            {
                path: "profile",
                name: "Tutor_Profile",
                component: Tutor_Profile
            }
        ]
    },

    // management routes
    {
        path: "/_dmgt",
        component: Management,
        children: [
            {
                path: "dashboard",
                name: "AdminDashboard",
                component: MGT_Dashboard
            },
            {
                path: "notifications",
                component: MGT_Messages,
                children: [
                    {
                        path: "sent",
                        name: "sentMessages",
                        component: MGT_SentMessages
                    }
                ]
            },
            {
                path: "earnings",
                component: MGT_Earning,
                children: [
                    {
                        path: "summary",
                        name: "earningSummary",
                        component: MGT_EarningSummary
                    },
                    {
                        path: "withdrawals",
                        name: "withdrawals",
                        component: MGT_Withdrawals
                    }
                ]
            },
            {
                path: "courses",
                component: MGT_Courses,
                children: [
                    {
                        path: "approved",
                        name: "approvedCourses",
                        component: MGT_ApprovedCourses
                    },
                    {
                        path: "pending",
                        name: "pendingCourses",
                        component: MGT_PendingCourses
                    }
                ]
            },
            {
                path: "users",
                component: MGT_Users,
                children: [
                    {
                        path: "tutors",
                        name: "mgt_tutors",
                        component: MGT_Tutors
                    },
                    {
                        path: "students",
                        name: "mgt_students",
                        component: MGT_Students
                    }
                ]
            }
        ]
    },

    //general route
    { path: "*", name: "Error_404", component: Error_404 }
];
