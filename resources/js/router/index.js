import {createRouter, createWebHistory} from "vue-router";
import layout from "../Pages/layout.vue";

const routes = [
    {
        path: '/',
        component: layout,
        children: [
            {
                path: "/category",
                component: () => import("../Pages/CategoryRoute.vue"),
            },
            {
                path: "/products",
                component: ()=> import("../Pages/ProductRoute.vue"),
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
                path: "/carts",
                component: () => import("../Pages/CartRoute.vue")
            },
            {
                path: "/update_product",
                component: () => import("../Pages/EditProduct.vue")
            }
        ]
    },

];

export default createRouter({
    history: createWebHistory(),
    routes,
});
