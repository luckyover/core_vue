/**
 * ****************************************************************************
 * @description     :   Router for order module
 * @created at      :   2024/02/29
 * @created by      :   ANS809 – quypn@ans-asia.com
 * @package         :   Sparkle/order
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */

/**
 * Import component of view
 */
const I111 = () => import('@/views/order/I111.vue')

/**
 * Defined Router
 */
const resource = 'order'
export default [
  {
    path: `/${resource}/i111`,
    name: 'I111',
    component: I111,
    meta: {
      title: '商品発注入力'
    }
  }
]
