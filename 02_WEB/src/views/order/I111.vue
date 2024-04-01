<script setup lang="ts">
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useAppStore } from '@/stores/app'

import BasicInfo from '@/components/order/I111/BasicInfo.vue'
import CustomerInfo from '@/components/order/I111/CustomerInfo.vue'
import OrderInfo from '@/components/order/I111/OrderInfo.vue'
import DeliveryInfo from '@/components/order/I111/DeliveryInfo.vue'
import ProcessInstructions from '@/components/order/I111/ProcessInstructions.vue'
import ProductOrder from '@/components/order/I111/ProductOrder.vue'
import ProcessOrder from '@/components/order/I111/ProcessOrder.vue'
import ProcessDetail from '@/components/order/I111/ProcessDetail.vue'
import BodyDetail from '@/components/order/I111/BodyDetail.vue'
import OrderStatus from '@/components/order/I111/OrderStatus.vue'

const route = useRoute()
const appStore = useAppStore()

appStore.setHeader({
  id: 'I111',
  title: '加工発注入力',
  titleColor: '#008000',
  buttons: [
    {
      id: 'I111-clear',
      title: 'クリア',
      icon: 'fa-solid fa-arrows-rotate',
      onClickEvent: () => {}
    },
    {
      id: 'I111-save',
      title: '保存',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {}
    },
    {
      id: 'I111-issue',
      title: '発行',
      icon: 'fa-regular fa-file-lines',
      onClickEvent: () => {}
    }
  ]
})
</script>

<template>
  <Panel title="基本情報" :canCollapse="true">
    <BasicInfo />
  </Panel>
  <Panel title="得意先情報" :canCollapse="true">
    <CustomerInfo />
  </Panel>
  <Panel title="受注情報" :canCollapse="true">
    <OrderInfo />
  </Panel>
  <Panel title="納品先情報" :canCollapse="true">
    <DeliveryInfo />
  </Panel>
  <Panel title="加工指示情報" :canCollapse="true">
    <ProcessInstructions />
  </Panel>
  <Panel title="商品発注情報" :canCollapse="true">
    <ProductOrder />
  </Panel>
  <Panel title="加工発注情報" :canCollapse="true">
    <ProcessOrder />
  </Panel>
  <Panel title="加工詳細情報" :canCollapse="true">
    <ProcessDetail />
  </Panel>
  <Panel title="ボディ詳細情報" :canCollapse="true">
    <BodyDetail />
  </Panel>
  <Panel title="進捗状況" :canCollapse="true">
    <OrderStatus />
  </Panel>
</template>
