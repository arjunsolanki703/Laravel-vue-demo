import Vue from 'vue'
import Router from 'vue-router'
// import routers from './routers'
import store from './store'

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
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    name: 'Account',
                    path: '/account',
                    component: () =>
                        import ('@/views/Account'),
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: "/projects",
                    name: "Projects",
                    component: () =>
                        import ("@/views/Projects"),
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: "/CreateProjects",
                    name: "Create Projects",
                    component: () =>
                        import ("@/views/CreateProjects"),
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: "/updateProject/:id",
                    name: "Update Projects",
                    component: () =>
                        import ("@/views/CreateProjects"),
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: "/projectOverview/:id",
                    name: "Project Overview",
                    component: () =>
                        import ("@/views/ProjectOverview"),
                    meta: {
                        requiresAuth: true
                    }
                },
            ],
        },
    ],
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next()
            return
        }
        next('/login')
    } else {
        next()
    }
});
export default router
/* const guest = (to, from, next) => {
    if (!localStorage.getItem("authToken")) {
        return next();
    } else {
        return next("/");
    }
};
const auth = (to, from, next) => {
    if (localStorage.getItem("authToken")) {
        return next();
    } else {
        return next("/login");
    }
}; */