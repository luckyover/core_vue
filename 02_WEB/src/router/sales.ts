/**
 * ****************************************************************************
 * @description     :   Router for order module
 * @created at      :   2024/02/29
 * @created by      :   ANS809 – quypn@ans-asia.com
 * @package         :   Sparkle/sales
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */

/**
 * Import component of view
 */

const I031 = () => import('@/views/sales/I031.vue')

/**
 * Defined Router
 */
const resource = 'sales'
export default [
  {
    path: `/${resource}/i031`,
    name: 'I031',
    component: I031,
    meta: {
      title: '売上入力・確定'
    }
  }
]
