<script setup lang="ts">
import { useRoute } from 'vue-router'
import { useAppStore } from '@/stores/app'

import BasicInfo from '@/components/sales/I031/BasicInfo.vue'
import ProductsInfo from '@/components/sales/I031/ProductsInfo.vue'

const route = useRoute()
const appStore = useAppStore()

appStore.setHeader({
  id: 'I031',
  title: '売上確定入力',
  buttons: [
    {
      id: 'I111-confirm',
      title: '売上確定',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {}
    },
    {
      id: 'I111-cancel',
      title: '保存',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {}
    },
    {
      id: 'I111-export',
      title: '納品書',
      icon: 'fa-regular fa-file-lines',
      onClickEvent: () => {}
    }
  ]
})
</script>

<template>
  <Panel title="基本情報">
    <BasicInfo />
  </Panel>
  <Panel title="商品情報">
    <ProductsInfo />
  </Panel>
</template>
