<script setup lang="ts">
import type { ITableSupplierProps } from '@/types/master/m006'

const props = withDefaults(defineProps<ITableSupplierProps>(), {})
const columns: Array<IAnsColumn> = [
  {
    name: 'supplier_cd',
    title: '仕入先コード',
    class: 'can-click text-end',
    isFixColumn: true
  },
  {
    name: 'supplier_nm',
    title: '仕入先名',
    class: 'can-click',
    isFixColumn: true,
    hasTooltip: true
  },
  {
    name: 'supplier_kn_nm',
    title: '仕入先名カナ',
    hasTooltip: true
  },
  {
    name: 'supplier_ab_nm',
    title: '仕入先名略称',
    hasTooltip: true
  },
  {
    name: 'supplier_div_nm',
    title: '仕入先区分'
  },
  {
    name: 'supplier_tel',
    title: 'TEL'
  },
  {
    name: 'supplier_mail_address',
    title: 'メールアドレス',
    hasTooltip: true
  },
  {
    name: 'supplier_class_div1_nm',
    title: '分類区分1'
  },
  {
    name: 'supplier_class_div2_nm',
    title: '分類区分2'
  },
  {
    name: 'supplier_class_div3_nm',
    title: '分類区分4'
  }
]
</script>
<template>
  <AnsTable
    class="table-supplier"
    :condition="condition"
    :columns="columns"
    :list="suppliers"
    :paging="paging"
    :onSearch="onSearch"
    :onSelected="onSelected"
  />
</template>
