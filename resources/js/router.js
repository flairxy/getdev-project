import VueRouter from "vue-router";

// Management routes
import Management from "./views/management/Index";
import MGT_Dashboard from "./views/management/Dashboard";
import MGT_Users from "./views/management/users/Index";
import MGT_Staffs from "./views/management/users/Staff";
import MGT_Students from "./views/management/users/Student";
import MGT_Profile from "./views/management/Profile";
import MGT_Class from "./views/management/Class";

import STD_Class from "./views/student/Class";
import STD_Dashboard from "./views/student/Dashboard";
import STD from "./views/student/Index";

import STAFF_Dashboard from "./views/staff/Dashboard";
// import STAFF_TDashboard from "./views/staff/teacher/Dashboard";
import STAFF_TClass from "./views/staff/teacher/Class";
import staff_TStudents from "./views/staff/teacher/Student";
import STAFF from "./views/staff/Index";
import STAFF_Staffs from "./views/management/users/Staff";

import Error_404 from "./components/404.vue";

import { RepositoryFactory as Repo } from "./repository/RepositoryFactory";
const AR = Repo.get("academy");
import { store } from "./store/Store";

export let routes = [
    // management routes
    {
        path: "/_management",
        component: Management,
        beforeEnter(to, from, next) {
            const user = JSON.parse(localStorage.getItem("user"));
            if (user) {
                AR.getRole(user.id).then(res => {
                    let role = res.data;
                    store.commit("storeRole", role);
                    next();
                });
            } else {
                AR.loggedInUser().then(res => {
                    AR.getRole(res.data.id).then(response => {
                        let role = response.data;
                        store.commit("storeRole", role);
                        next();
                    });
                });
            }
        },
        children: [
            {
                path: "profile",
                name: "MGTProfile",
                component: MGT_Profile
            },
            {
                path: "dashboard",
                name: "AdminDashboard",
                component: MGT_Dashboard
            },
            {
                path: "classes",
                name: "AdminClass",
                component: MGT_Class
            },
            {
                path: "users",
                component: MGT_Users,
                children: [
                    {
                        path: "staffs",
                        name: "mgt_staffs",
                        component: MGT_Staffs
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

    {
        path: "/_student",
        component: STD,
        children: [
            {
                path: "dashboard",
                name: "std_dashboard",
                component: STD_Dashboard
            },
            {
                path: "classes",
                name: "std_class",
                component: STD_Class
            }
        ]
    },

    //Staff Routes

    {
        path: "/_staff",
        component: STAFF,
        beforeEnter(to, from, next) {
            const user = JSON.parse(localStorage.getItem("user"));
            if (user) {
                AR.getRole(user.id).then(res => {
                    let role = res.data;
                    store.commit("storeRole", role);
                    next();
                });
            } else {
                AR.loggedInUser().then(res => {
                    AR.getRole(res.data.id).then(response => {
                        let role = response.data;
                        store.commit("storeRole", role);
                        next();
                    });
                });
            }
        },
        children: [
            {
                path: "dashboard",
                name: "staff_dashboard",
                component: STAFF_Dashboard
            },

            {
                path: "my/classes",
                name: "staff_TClass",
                component: STAFF_TClass,
                beforeEnter(to, from, next) {
                    const role = store.getters.getRole;
                    if (role == "teacher") {
                        next();
                    } else {
                        next("/404");
                    }
                }
            },
            {
                path: "my/students",
                name: "staff_TStudents",
                component: staff_TStudents,
                beforeEnter(to, from, next) {
                    const role = store.getters.getRole;
                    if (role == "teacher") {
                        next();
                    } else {
                        next("/404");
                    }
                }
            },
            {
                path: "index",
                name: "staff_staffs",
                component: STAFF_Staffs
            }
        ]
    },

    //general route
    { path: "*", name: "Error_404", component: Error_404 }
];
