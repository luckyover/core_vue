import { createRouter, createWebHistory, type RouteLocationNormalized } from 'vue-router'
import moment from 'moment'
import { ansCommon, ansIdentity } from '@/utils'
import EmptyLayout from '@/shared/EmptyLayout.vue'

const NotAccess = () => import('@/views/error/NotAccess.vue')
const NotFound = () => import('@/views/error/NotFound.vue')
const ServerError = () => import('@/views/error/ServerError.vue')
const Home = () => import('@/views/Home.vue')

import SystemRouters from '@/router/system'
import EstimateRouters from '@/router/estimate'
import MasterRouters from '@/router/master'
import OrderRouters from '@/router/order'
import SalesRouters from '@/router/sales'
import type { IAnsFunction } from '@/types/app'
import _ from 'lodash'

const baseRoutes: any = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      layout: EmptyLayout,
      noAppState: true
    }
  },
  {
    path: '/404',
    name: 'NotFound',
    component: NotFound,
    meta: {
      title: 'エラー 404',
      layout: EmptyLayout,
      forAll: true,
      noAppState: true
    }
  },
  {
    path: '/403',
    name: 'NotAccess',
    component: NotAccess,
    meta: {
      title: 'エラー 403',
      layout: EmptyLayout,
      forAll: true,
      noAppState: true
    }
  },
  {
    path: '/500',
    name: 'ServerError',
    component: ServerError,
    meta: {
      title: 'エラー 500',
      layout: EmptyLayout,
      forAll: true,
      noAppState: true
    }
  },
  {
    path: '/:catchAll(.*)', // Unrecognized path automatically matches 404
    redirect: '/404'
  }
]

const routes = baseRoutes
  .concat(SystemRouters)
  .concat(EstimateRouters)
  .concat(MasterRouters)
  .concat(OrderRouters)
  .concat(SalesRouters)

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior() {
    return { top: 0 }
  }
})

router.beforeEach(async (to, from, next) => {
  const checkPermission = (to: RouteLocationNormalized) => {
    const listFnc = JSON.parse(localStorage.getItem('functions') ?? '[]')
    const fnc = _.find(listFnc, (x: IAnsFunction) => {
      return x.prg_cd === to.name && ansIdentity.isViewFnc(x)
    })
    if (fnc && fnc.fnc_use_div !== true) {
      return false
    }
    return true
  }
  if (!to.meta.forAll) {
    const token = localStorage.getItem('token')
    const tokenTimeout = localStorage.getItem('tokenTimeout')
    let loggedIn = false
    if (token && tokenTimeout && moment(tokenTimeout) >= moment()) {
      loggedIn = true
    } else {
      localStorage.removeItem('token')
      localStorage.removeItem('tokenTimeout')
    }
    if (!to.meta.notAuthRequired && !loggedIn) {
      localStorage.setItem('beforeUrl', to.path)
      return next('/login')
    }
    if (!to.meta.notAuthRequired && from.name !== 'Home' && !checkPermission(to)) {
      localStorage.setItem('beforeUrl', to.path)
      return next('/403')
    }
    if (to.meta.notAuthRequired && loggedIn) {
      return next('/')
    }
  }
  document.title = (to.meta.title ? to.meta.title + ' | ' : '') + 'スパークル'
  const fromClass = (from?.name?.toString() ?? '').toLowerCase()
  if (!ansCommon.isEmpty(fromClass)) {
    document.body?.classList?.remove(fromClass)
  }
  const toClass = (to?.name?.toString() ?? '').toLowerCase()
  if (!ansCommon.isEmpty(toClass)) {
    document.body?.classList?.add(toClass)
  }
  next()
})

export default router
