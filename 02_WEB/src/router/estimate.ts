/**
 * ****************************************************************************
 * @description     :   Router for estimate module
 * @created at      :   2024/02/16
 * @created by      :   ANS809 – quypn@ans-asia.com
 * @package         :   Sparkle/estimate
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */

/**
 * Import component of view
 */
const L001 = () => import('@/views/estimate/L001.vue')

/**
 * Defined Router
 */
const resource = 'estimate'
export default [
  {
    path: `/${resource}/l001`,
    name: 'L001',
    component: L001,
    meta: {
      title: '案件一覧'
    }
  }
]
