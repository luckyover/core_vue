<script setup lang="ts">
import api from '@/repositories/master/m101'
import SearchCondition from '@/components/popup/M101L/SearchCondition.vue'
import TableProduct from '@/components/popup/M101L/TableProduct.vue'
import { ref } from 'vue'
import type {
  IGetInitDataResponse,
  IItem,
  ISearchCondition,
  ISearchItemResponse,
  IItemForList
} from '@/types/master/m101'
import { ansCommon } from '@/utils'
import { Constants, SortType } from '@/utils/constants'
import _ from 'lodash'
import { ItemClassDiv } from '@/utils/nameDiv'

const props = withDefaults(defineProps<IAnsPopupSearch>(), {})

const initSearchCondition: ISearchCondition = {
  inq_item_class_div: 0,
  inq_process_div: 0,
  inq_category_div: 0,
  page: 1,
  page_size: Constants.DEFAULT_PAGE_SIZE
}

const closeCondition = ref<() => void>(() => {})
const condition = ref<ISearchCondition>({
  ...(props.initData ?? {})
})
const items = ref<Array<IItemForList>>([])
const paging = ref<IAnsPaging | undefined>(undefined)
const item_class_div = ref<Array<IOption>>([])
const process_div = ref<Array<IOption>>([])
const category_div = ref<Array<IOption>>([])

const getInitData = () => {
  api.getInitData().then(({ data: response }: { data: IGetInitDataResponse }) => {
    item_class_div.value = ansCommon.convertToOption(response.data?.item_class_div)
    process_div.value = ansCommon.convertToOption(response.data?.process_div)
    category_div.value = ansCommon.convertToOption(response.data?.category_div)
    if (condition.value.inq_item_class_div === -1) {
      _.remove(item_class_div.value, (x) => {
        return x.code === ItemClassDiv.PROCESS
      })
      condition.value.inq_item_class_div = 0
    }

    document.getElementById('inq_item_cd')?.focus()
  })
}

const onSearch = () => {
  api
    .search({
      ...initSearchCondition,
      ...condition.value
    })
    .then(({ data: response }: { data: ISearchItemResponse }) => {
      items.value = response.data.items
      paging.value = response.data.paging
      condition.value.has_search = true
      closeCondition.value()
    })
}

const onClear = () => {
  condition.value = {
    ...(props.initData ?? {})
  }
  paging.value = undefined
  items.value = []
  document.getElementById('inq_item_cd')?.focus()
}

const onSelected = (item: IItemForList) => {
  props.onSelected(item)
  props.onClose()
}

const triggerClose = (fnc: () => void) => {
  closeCondition.value = fnc
}

getInitData()
</script>
<style lang="scss">
@import url('@/assets/scss/popup/m101l.scss');
</style>
<template>
  <Panel title="検索条件" :canCollapse="true" :triggerClose="triggerClose">
    <SearchCondition
      :condition="condition"
      :item_class_div="item_class_div"
      :process_div="process_div"
      :category_div="category_div"
      :onSearch="onSearch"
      :onClear="onClear"
    />
  </Panel>
  <Panel title="検索結果">
    <TableProduct
      :onSearch="onSearch"
      :condition="condition"
      :items="items"
      :paging="paging"
      :onSelected="onSelected"
    />
  </Panel>
</template>
