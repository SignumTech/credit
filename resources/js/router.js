import Vue from 'vue'
import Router from 'vue-router'

import login from './components/auth/login.vue'
import home from './components/home/home.vue'

Vue.use(Router)
const routes = [
    {
        path: '/login',
        component: login,
        name: 'Login'
    },
    {
        path: '/',
        component: home,
        name: 'Home'
    },
]

export default new  Router({
    mode: 'history',
    routes
})