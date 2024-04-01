/**
 * ****************************************************************************
 * @description     :   Router for master module
 * @created at      :   2024/02/16
 * @created by      :   ANS809 – quypn@ans-asia.com
 * @package         :   Sparkle/master
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */

/**
 * Import component of view
 */

const M005 = () => import('@/views/master/M005.vue')
const M004 = () => import('@/views/master/M004.vue')
const M006 = () => import('@/views/master/M006.vue')
const M101 = () => import('@/views/master/M101.vue')
const M202 = () => import('@/views/master/M202.vue')
const M301 = () => import('@/views/master/M301.vue')
const M302 = () => import('@/views/master/M302.vue')
const M201 = () => import('@/views/master/M201.vue')
/**
 * Defined Router
 */
const resource = 'master'
export default [
  {
    path: `/${resource}/m005`,
    name: 'M005',
    component: M005,
    meta: {
      title: '納品先マスタ'
    }
  },
  {
    path: `/${resource}/m004`,
    name: 'M004',
    component: M004,
    meta: {
      title: '得意先マスタ'
    }
  },
  {
    path: `/${resource}/m006`,
    name: 'M006',
    component: M006,
    meta: {
      title: '仕入先マスタ'
    }
  },
  {
    path: `/${resource}/m101`,
    name: 'M101',
    component: M101,
    meta: {
      title: '商品マスタ'
    }
  },
  {
    path: `/${resource}/m202`,
    name: 'M202',
    component: M202,
    meta: {
      title: '商品原価マスタ'
    }
  },
  {
    path: `/${resource}/m301`,
    name: 'M301',
    component: M301,
    meta: {
      title: '商品マスタ'
    }
  },
  {
    path: `/${resource}/m302`,
    name: 'M302',
    component: M302,
    meta: {
      title: '加工原価'
    }
  },
  {
    path: `/${resource}/m201`,
    name: 'M201',
    component: M201,
    meta: {
      title: '商品売価マスタ'
    }
  }
]
