/**
 * ****************************************************************************
 * @description     :   Router for system module
 * @created at      :   2024/02/16
 * @created by      :   ANS809 – quypn@ans-asia.com
 * @package         :   Sparkle/system
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */

import EmptyLayout from '@/shared/EmptyLayout.vue'

/**
 * Import component of view
 */
const Login = () => import('@/views/system/Login.vue')
const Logout = () => import('@/views/system/Logout.vue')
const M002 = () => import('@/views/system/M002.vue')

/**
 * Defined Router
 */
const resource = 'system'
export default [
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {
      title: 'ログイン',
      layout: EmptyLayout,
      notAuthRequired: true,
      noAppState: true
    }
  },
  {
    path: '/logout',
    name: 'Logout',
    component: Logout,
    meta: {
      title: '',
      layout: EmptyLayout,
      forAll: true,
      noAppState: true
    }
  },
  {
    path: `/${resource}/m002`,
    name: 'M002',
    component: M002,
    meta: {
      title: 'ユーザーマスタ'
    }
  }
]
