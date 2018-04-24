import VueRouter from "vue-router";
import Store from "./utils/Store";
import Helper from "./utils/Helper";
import AccessMiddleware from "./middleware/AccessMiddleware";

let routes = [
    {
        path: '/',
        name: 'home',
        component: require("./components/Welcome.vue")
    },
    {
        path: '/login',
        name: 'login',
        meta: {
            checkAlreadyLoggedIn: true
        },
        component: require("./components/Login.vue")
    },
    {
        path: '/example',
        name: 'example',
        component: require("./components/ExampleComponent.vue"),
        meta: {
            auth: true
        }
    }
];

const router = new VueRouter({
    routes,
    linkActiveClass: 'active'
});

// check for authentication.
router.beforeEach((to, from, next) => AccessMiddleware.auth(to, from, next));

export default router;
