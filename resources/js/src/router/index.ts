import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    //http://taskapp.test
    history: createWebHistory('/app'),
    routes: [
        {

            path: '/register',
            name: "register",
            component: () => import('../pages/auth/AuthPage.vue'),


            children: [
                {
                    path: '/register',
                    name: "register",
                    component: () => import('../pages/auth/RegisterPage.vue')
                }]
        }

    ]
})

export default router