import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import { useAuth } from '@/store/authContext'
import HomeView from '../views/HomeView.vue'
import RegisterView from "../views/RegisterView.vue"
import LoginView from "../views/LoginView.vue"
import LogoutView from "../views/LogoutView.vue"

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: {
      auth: true
    }
  },
  {
    path: "/register",
    name: "register",
    component: RegisterView,
    meta: {
      auth: false
    }
  },
  {
    path: "/login",
    name: "login",
    component: LoginView,
    meta:{
      auth: false
    }
  },
  {
    path: "/logout",
    name: "logut",
    component: LogoutView,
    meta:{
      auth: true
    }
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  const auth = useAuth()
  if(!auth.isAuth){
    auth.verifyAuth()
  }
  if (to.meta.auth && !auth.isAuth) {
    next("/login")
  }else{
    next()
  }
})

export default router
