<script setup lang="ts">
import { ref, watch, computed, onMounted } from 'vue'
import { v4 } from 'uuid'
import { SortType } from '@/utils/constants'
import ansAxios from '@/repositories/ansAxios'
import { ansCommon } from '@/utils'

const props = withDefaults(defineProps<IAnsSortColumnProps>(), {
  sortType: SortType.NONE
})

const isAsc = computed(() => {
  return props.currentColumn !== props.columnName || sortType.value !== SortType.DESC
})

const isDesc = computed(() => {
  return props.currentColumn !== props.columnName || sortType.value !== SortType.ASC
})

const sortType = ref(props.currentColumn !== props.columnName ? SortType.NONE : props.sortType)

const changeSort = () => {
  let sortColumn = props.columnName
  let sort = SortType.NONE
  if (sortType.value === SortType.ASC) {
    sort = SortType.DESC
  }
  if (sortType.value === SortType.DESC) {
    sort = SortType.NONE
    sortColumn = ''
  }
  if (sortType.value === SortType.NONE) {
    sort = SortType.ASC
  }
  sortType.value = sort
  if (props.onSort) {
    props.onSort(sortColumn, sort)
  }
}

watch(
  () => props.currentColumn,
  () => {
    if (props.currentColumn !== props.columnName) {
      sortType.value = SortType.NONE
    }
  }
)
</script>

<template>
  <th class="col-can-order" :class="class" @click="changeSort">
    <span class="title-have-sort">
      {{ title ?? '' }}
      <img class="img-sort arrow-up" src="/img/sort_asc.png" v-if="isAsc" />
      <img class="img-sort arrow-down" src="/img/sort_desc.png" v-if="isDesc" />
    </span>
  </th>
</template>
