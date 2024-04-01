<script setup lang="ts">
import api from '@/repositories/master/m005'
import SearchCondition from '@/components/popup/M005L/SearchCondition.vue'
import TableDelivery from '@/components/popup/M005L/TableDelivery.vue'
import { ref, onMounted } from 'vue'
import type {
  ISearchCondition,
  ISearchDeliveryResponse,
  IDeliveryForList
} from '@/types/master/m005'
import { Constants, SortType } from '@/utils/constants'
import _ from 'lodash'

const props = withDefaults(defineProps<IAnsPopupSearch>(), {})

const initSearchCondition: ISearchCondition = {
  inq_delivery_cd: 0,
  page: 1,
  page_size: Constants.DEFAULT_PAGE_SIZE
}

const closeCondition = ref<() => void>(() => {})
const condition = ref<ISearchCondition>({})
const delivery = ref<Array<IDeliveryForList>>([])
const paging = ref<IAnsPaging | undefined>(undefined)

const onSearch = () => {
  api
    .search({
      ...initSearchCondition,
      ...condition.value
    })
    .then(({ data: response }: { data: ISearchDeliveryResponse }) => {
      delivery.value = response.data.delivery
      paging.value = response.data.paging
      condition.value.has_search = true
      closeCondition.value()
    })
}

const onClear = () => {
  condition.value = {}
  paging.value = undefined
  delivery.value = []
  document.getElementById('inq_delivery_cd')?.focus()
}

const onSelected = (item: IDeliveryForList) => {
  props.onSelected(item)
  props.onClose()
}

const triggerClose = (fnc: () => void) => {
  closeCondition.value = fnc
}

onMounted(() => {
  setTimeout(() => {
    document.getElementById('inq_delivery_cd')?.focus()
  }, 300)
})
</script>
<style lang="scss">
@import url('@/assets/scss/popup/m005l.scss');
</style>
<template>
  <Panel title="検索条件" :canCollapse="true" :triggerClose="triggerClose">
    <SearchCondition :condition="condition" :onSearch="onSearch" :onClear="onClear" />
  </Panel>
  <Panel title="検索結果">
    <TableDelivery
      :onSearch="onSearch"
      :condition="condition"
      :delivery="delivery"
      :paging="paging"
      :onSelected="onSelected"
    />
  </Panel>
</template>
