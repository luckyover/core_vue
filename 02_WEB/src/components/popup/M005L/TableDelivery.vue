<script setup lang="ts">
import type { ITableDeliveryProps } from '@/types/master/m005'

const props = withDefaults(defineProps<ITableDeliveryProps>(), {})
const columns: Array<IAnsColumn> = [
  {
    name: 'delivery_cd',
    title: '納品先コード',
    class: 'can-click text-end',
    isFixColumn: true
  },
  {
    name: 'delivery_nm',
    title: '納品先名',
    class: 'can-click',
    isFixColumn: true,
    hasTooltip: true
  },
  {
    name: 'delivery_kn_nm',
    title: '納品先名カナ',
    hasTooltip: true
  },
  {
    name: 'delivery_ab_nm',
    title: '納品先名略称',
    hasTooltip: true
  },
  {
    name: 'delivery_zip',
    title: '郵便番号'
  },
  {
    name: 'delivery_address1',
    title: '都道府県・市区町村',
    hasTooltip: true
  },
  {
    name: 'delivery_address2',
    title: '丁目・番地',
    hasTooltip: true
  },
  {
    name: 'delivery_address3',
    title: 'マンション・ビル名',
    hasTooltip: true
  },
  {
    name: 'delivery_tel',
    title: 'TEL'
  },
  {
    name: 'delivery_mail_address',
    title: 'メールアドレス',
    hasTooltip: true
  },
  {
    name: 'delivery_department_nm',
    title: '部署名'
  },
  {
    name: 'delivery_manager_nm',
    title: '担当者名'
  }
]
</script>
<template>
  <AnsTable
    class="table-delivery"
    :condition="condition"
    :columns="columns"
    :list="delivery"
    :paging="paging"
    :onSearch="onSearch"
    :onSelected="onSelected"
  />
</template>
