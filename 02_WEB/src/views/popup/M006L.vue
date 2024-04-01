<script setup lang="ts">
import api from '@/repositories/master/m006'
import SearchCondition from '@/components/popup/M006L/SearchCondition.vue'
import TableSupplier from '@/components/popup/M006L/TableSupplier.vue'
import { ref } from 'vue'
import type {
  IGetInitDataResponse,
  ISearchCondition,
  ISearchSupplierResponse,
  ISupplierForList
} from '@/types/master/m006'
import { ansCommon } from '@/utils'
import { Constants, SortType } from '@/utils/constants'

const props = withDefaults(defineProps<IAnsPopupSearch>(), {})

const initSearchCondition: ISearchCondition = {
  inq_supplier_cd: 0,
  inq_supplier_div: 0,
  inq_supplier_class_div1: 0,
  inq_supplier_class_div2: 0,
  inq_supplier_class_div3: 0,
  page: 1,
  page_size: Constants.DEFAULT_PAGE_SIZE
}

const closeCondition = ref<() => void>(() => {})
const condition = ref<ISearchCondition>({
  ...(props.initData ?? {})
})
const suppliers = ref<Array<ISupplierForList>>([])
const paging = ref<IAnsPaging | undefined>(undefined)
const supplier_div = ref<Array<IOption>>([])
const supplier_class_div1 = ref<Array<IOption>>([])
const supplier_class_div2 = ref<Array<IOption>>([])
const supplier_class_div3 = ref<Array<IOption>>([])

const getInitData = () => {
  api.getInitData().then(({ data: response }: { data: IGetInitDataResponse }) => {
    supplier_div.value = ansCommon.convertToOption(response.data?.supplier_div)
    supplier_class_div1.value = ansCommon.convertToOption(response.data?.supplier_class_div1)
    supplier_class_div2.value = ansCommon.convertToOption(response.data?.supplier_class_div2)
    supplier_class_div3.value = ansCommon.convertToOption(response.data?.supplier_class_div3)
    document.getElementById('inq_supplier_cd')?.focus()
  })
}

const onSearch = () => {
  api
    .search({
      ...initSearchCondition,
      ...condition.value
    })
    .then(({ data: response }: { data: ISearchSupplierResponse }) => {
      suppliers.value = response.data.suppliers
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
  suppliers.value = []
  document.getElementById('inq_supplier_cd')?.focus()
}

const onSelected = (item: ISupplierForList) => {
  props.onSelected(item)
  props.onClose()
}

const triggerClose = (fnc: () => void) => {
  closeCondition.value = fnc
}

getInitData()
</script>
<style lang="scss">
@import url('@/assets/scss/popup/m006l.scss');
</style>
<template>
  <Panel title="検索条件" :canCollapse="true" :triggerClose="triggerClose">
    <SearchCondition
      :condition="condition"
      :supplier_div="supplier_div"
      :supplier_class_div1="supplier_class_div1"
      :supplier_class_div2="supplier_class_div2"
      :supplier_class_div3="supplier_class_div3"
      :onSearch="onSearch"
      :onClear="onClear"
    />
  </Panel>
  <Panel title="検索結果">
    <TableSupplier
      :onSearch="onSearch"
      :condition="condition"
      :suppliers="suppliers"
      :paging="paging"
      :onSelected="onSelected"
    />
  </Panel>
</template>
