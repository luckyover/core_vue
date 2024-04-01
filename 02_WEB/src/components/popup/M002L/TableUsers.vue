<script setup lang="ts">
import type { ITableUsersProps } from '@/types/system/m002'

const props = withDefaults(defineProps<ITableUsersProps>(), {})
const columns: Array<IAnsColumn> = [
  {
    name: 'user_cd',
    title: 'ユーザーコード',
    class: 'can-click text-end',
    isFixColumn: true
  },
  {
    name: 'user_nm',
    title: 'ユーザー名',
    class: 'can-click',
    isFixColumn: true,
    hasTooltip: true
  },
  {
    name: 'user_kn_nm',
    title: 'ユーザー名カナ',
    hasTooltip: true
  },
  {
    name: 'user_ab_nm',
    title: 'ユーザー名略称',
    hasTooltip: true
  },
  {
    name: 'tel',
    title: 'TEL'
  },
  {
    name: 'fax',
    title: 'FAX'
  },
  {
    name: 'mailaddress',
    title: 'メールアドレス',
    hasTooltip: true
  },
  {
    name: 'belong_department_div_nm',
    title: '所属部門区分'
  }
]
</script>
<template>
  <AnsTable
    class="table-user"
    :condition="condition"
    :columns="columns"
    :list="users"
    :paging="paging"
    :onSearch="onSearch"
    :onSelected="onSelected"
  />
</template>
