import { createRouter, createWebHistory } from "vue-router";

import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Dashboard from "../views/Dashboard.vue";
import AuthLayout from "../layouts/AuthLayout.vue";
import MainLayout from "../layouts/MainLayout.vue";
import GuestLayout from "../layouts/GuestLayout.vue";
import IdeaIndex from "../views/ideas/Index.vue";
import IdeaShow from "../views/ideas/Show.vue";
import IdeaOwnedIndex from "../views/ideas/OwnedIndex.vue";
import IdeaOwnedShow from "../views/ideas/OwnedShow.vue";
import IdeaCreate from "../views/ideas/Create.vue";
import IdeaEdit from "../views/ideas/Edit.vue";
import store from "../store/index.js";

const routes = [
    {
        path: "/homepage",
        name: "MainLayout",
        component: MainLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: "/dashboard",
                name: "Dashboard",
                component: Dashboard,
            },
            {
                path: "/ideaindexowned",
                name: "IdeaOwnedIndex",
                component: IdeaOwnedIndex,
            },
            {
                path: "/ideacreate",
                name: "IdeaCreate",
                component: IdeaCreate,
            },
            {
                path: `/ideaownedshow/:slug`,
                name: "IdeaOwnedShow",
                component: IdeaOwnedShow,
            },
            {
                path: `/ideaedit/:slug`,
                name: "IdeaEdit",
                component: IdeaEdit,
            },
        ],
    },
    {
        path: "/guest",
        name: "GuestLayout",
        component: GuestLayout,
        children: [
            {
                path: "/ideaindex",
                name: "IdeaIndex",
                component: IdeaIndex,
            },
            {
                path: `/ideashow/:slug`,
                name: "IdeaShow",
                component: IdeaShow,
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
        next({ name: "IdeaIndex" });
    } else {
        next();
    }
});

export default router;
