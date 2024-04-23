import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/register",
        component: () => import("./Pages/RegistrationRoute.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
