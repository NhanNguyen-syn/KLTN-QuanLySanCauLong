import { createRouter, createWebHashHistory, RouteRecordRaw } from 'vue-router'
import Dashboard from '../pages/Dashboard'

const routes: RouteRecordRaw[] = [
  { path: '/', name: 'dashboard', component: Dashboard },
]

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes,
})

export default router

