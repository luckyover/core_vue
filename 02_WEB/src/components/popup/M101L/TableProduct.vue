<script setup lang="ts">
import type { ITableProductProps } from '@/types/master/m101'

const props = withDefaults(defineProps<ITableProductProps>(), {})
const columns: Array<IAnsColumn> = [
  {
    name: 'item_cd',
    title: '商品コード',
    class: 'can-click',
    isFixColumn: true
  },
  {
    name: 'color_cd',
    title: '色コード',
    class: 'can-click',
    isFixColumn: true
  },
  {
    name: 'item_nm',
    title: '商品名',
    hasTooltip: true
  },
  {
    name: 'color_nm',
    title: '色名',
    hasTooltip: true
  },
  {
    name: 'item_class_div_nm',
    title: '商品分類'
  },
  {
    name: 'process_div_nm',
    title: '加工種別'
  },
  {
    name: 'category_div_nm',
    title: 'カテゴリー'
  },
  {
    name: 'supplier_item_cd',
    title: '仕入先商品コード'
  },
  {
    name: 'supplier_cd',
    title: '仕入先コード',
    class: 'text-end'
  },
  {
    name: 'supplier_nm',
    title: '仕入先名',
    hasTooltip: true
  }
]
</script>
<template>
  <AnsTable
    class="table-items"
    :condition="condition"
    :columns="columns"
    :list="items"
    :paging="paging"
    :onSearch="onSearch"
    :onSelected="onSelected"
  />
</template>
