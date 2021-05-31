import Vue from 'vue'
import Router from 'vue-router'
// import router from './router'

Vue.use(Router)

let router = new Router({
    mode: 'hash',
    base: process.env.BASE_URL,
    routes: [{
            path: "/",
            name: "Login",
            // beforeEnter: guest,
            component: () =>
                import ( /* webpackChunkName: "login" */ "./views/Login.vue")
        }, {
            path: "/login",
            name: "Login",
            // beforeEnter: guest,
            component: () =>
                import ( /* webpackChunkName: "login" */ "./views/Login.vue")
        },
        {
            path: '/Dashboard',
            component: () =>
                import ('@/views/Index'),
            children: [{
                    name: 'Dashboard',
                    path: '',
                    component: () =>
                        import ('@/views/Dashboard'),
                },
                {
                    name: 'Account',
                    path: '/account',
                    component: () =>
                        import ('@/views/Account'),
                },
                {
                    path: "/projects",
                    name: "Projects",
                    component: () =>
                        import ("@/views/Projects"),
                },
            ],
        },
    ],
});
export default router