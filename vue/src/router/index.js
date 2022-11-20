import { createRouter, createWebHistory } from "vue-router";

import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import AuthLayout from "../layouts/AuthLayout.vue";
import MainLayout from "../layouts/MainLayout.vue";
import store from "../store/index.js";

const routes = [
    {
        path: "/homepage",
        name: "MainLayout",
        component: MainLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: "/",
                name: "Dashboard",
                component: Dashboard,
            },
        ],
    },
    {
        path: "/auth",
        name: "Auth",
        component: AuthLayout,
        redirect: "/login",
        meta: { isGuest: true },
        children: [
            {
                path: "/login",
                name: "Login",
                component: Login,
            },
            {
                path: "/register",
                name: "Register",
                component: Register,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: "Login" });
    } else if (store.state.user.token && to.meta.isGuest) {
        next({ name: "Dashboard" });
    } else {
        next();
    }
});

export default router;
