import {createRouter, createWebHistory} from "vue-router";

const routes = [
    {
    path: "/",
    component: ()=> import("../Pages/HomeRoute.vue"),
    },
    {
        path: "/category",
        component: () => import("../Pages/TestRoute.vue"),
    },
    {
        path: "/create_product",
        component: () => import("../Pages/CreateProductRoute.vue")
    },
    {
        path: "/auth",
        component: () => import("../Pages/AuthRoute.vue")
    },
    {
        path: "/login",
        component: () => import("../Pages/LoginRoute.vue")
    },
    {
        path: "/cart",
        component: () => import("../Pages/CartRoute.vue")
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
