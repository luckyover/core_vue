<script setup lang="ts">
import type { ITableSupplierProps } from '@/types/master/m004'

const props = withDefaults(defineProps<ITableSupplierProps>(), {})
const columns: Array<IAnsColumn> = [
  {
    name: 'customer_cd',
    title: '得意先コード',
    class: 'can-click text-end',
    isFixColumn: true
  },
  {
    name: 'customer_nm',
    title: '得意先名',
    class: 'can-click',
    isFixColumn: true,
    hasTooltip: true
  },
  {
    name: 'customer_kn_nm',
    title: '得意先名カナ',
    hasTooltip: true
  },
  {
    name: 'customer_ab_nm',
    title: '得意先名略称',
    hasTooltip: true
  },
  {
    name: 'billing_source_cd_nm',
    title: '請求元'
  },
  {
    name: 'tel',
    title: 'TEL'
  },
  {
    name: 'customer_mail_address',
    title: 'メールアドレス',
    hasTooltip: true
  },
  {
    name: 'customer_class_div1_nm',
    title: '分類区分1'
  },
  {
    name: 'customer_class_div2_nm',
    title: '分類区分2'
  },
  {
    name: 'customer_class_div3_nm',
    title: '分類区分3'
  },
  {
    name: 'transfer_date1_nm',
    title: '振込日1'
  },
  {
    name: 'transfer_date2_nm',
    title: '振込日2'
  },
  {
    name: 'sales_employee_nm',
    title: '営業担当者',
    hasTooltip: true
  }
]
</script>
<template>
  <AnsTable
    class="table-customer"
    :condition="condition"
    :columns="columns"
    :list="customers"
    :paging="paging"
    :onSearch="onSearch"
    :onSelected="onSelected"
  />
</template>
