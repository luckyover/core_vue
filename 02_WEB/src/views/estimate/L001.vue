<script setup lang="ts">
import { useAppStore } from '@/stores/app'

const appStore = useAppStore()
appStore.setHeader({
  id: 'L001',
  title: '案件一覧',
  titleColor: '#3333CC',
  buttons: [
    {
      id: 'btn-add',
      title: '新規',
      icon: 'fa fa-plus',
      href: '/estimate/i001'
    },
    {
      id: 'btn-search',
      title: '検索',
      icon: 'fa fa-search',
      onClickEvent: () => {}
    },
    {
      id: 'btn-export-csv',
      title: 'CSV出力',
      icon: 'fa-regular fa-file-lines',
      onClickEvent: () => {}
    }
  ]
})
</script>

<template>
  <section id="l001" class="container"></section>
</template>
