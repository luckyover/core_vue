<script setup lang="ts">
import api from '@/repositories/master/m004'
import SearchCondition from '@/components/popup/M004L/SearchCondition.vue'
import TableCustomers from '@/components/popup/M004L/TableCustomers.vue'
import { ref } from 'vue'
import type {
  IGetInitDataResponse,
  ISearchCondition,
  ISearchCustomerResponse,
  ICustomerForList,
  ICompany
} from '@/types/master/m004'
import { ansCommon } from '@/utils'
import { Constants, SortType } from '@/utils/constants'
import _ from 'lodash'

const props = withDefaults(defineProps<IAnsPopupSearch>(), {})

const initSearchCondition: ISearchCondition = {
  inq_customer_cd: 0,
  inq_billing_source_cd: 0,
  inq_customer_class_div1: 0,
  inq_customer_class_div2: 0,
  inq_customer_class_div3: 0,
  inq_billing_closing_div: 0,
  page: 1,
  page_size: Constants.DEFAULT_PAGE_SIZE
}

const closeCondition = ref<() => void>(() => {})
const condition = ref<ISearchCondition>({})
const customers = ref<Array<ICustomerForList>>([])
const paging = ref<IAnsPaging | undefined>(undefined)
const billing_source_cd = ref<Array<IOption>>([])
const customer_class_div1 = ref<Array<IOption>>([])
const customer_class_div2 = ref<Array<IOption>>([])
const customer_class_div3 = ref<Array<IOption>>([])
const billing_closing_div = ref<Array<IOption>>([])

const getInitData = () => {
  api.getInitData().then(({ data: response }: { data: IGetInitDataResponse }) => {
    billing_source_cd.value = _.map(
      response.data?.billing_source_cd ?? [],
      (item: ICompany): IOption => {
        return {
          code: `${item.company_cd}`,
          name: `${item.company_cd}:${item.company_nm}`
        }
      }
    )
    customer_class_div1.value = ansCommon.convertToOption(response.data?.customer_class_div1)
    customer_class_div2.value = ansCommon.convertToOption(response.data?.customer_class_div2)
    customer_class_div3.value = ansCommon.convertToOption(response.data?.customer_class_div3)
    billing_closing_div.value = ansCommon.convertToOption(response.data?.billing_closing_div)
    document.getElementById('inq_customer_cd')?.focus()
  })
}

const onSearch = () => {
  api
    .search({
      ...initSearchCondition,
      ...condition.value
    })
    .then(({ data: response }: { data: ISearchCustomerResponse }) => {
      customers.value = response.data.customers
      paging.value = response.data.paging
      condition.value.has_search = true
      closeCondition.value()
    })
}

const onClear = () => {
  condition.value = {}
  paging.value = undefined
  customers.value = []
  document.getElementById('inq_customer_cd')?.focus()
}

const onSelected = (item: ICustomerForList) => {
  props.onSelected(item)
  props.onClose()
}

const triggerClose = (fnc: () => void) => {
  closeCondition.value = fnc
}

getInitData()
</script>
<style lang="scss">
@import url('@/assets/scss/popup/m004l.scss');
</style>
<template>
  <Panel title="検索条件" :canCollapse="true" :triggerClose="triggerClose">
    <SearchCondition
      :condition="condition"
      :billing_source_cd="billing_source_cd"
      :customer_class_div1="customer_class_div1"
      :customer_class_div2="customer_class_div2"
      :customer_class_div3="customer_class_div3"
      :billing_closing_div="billing_closing_div"
      :onSearch="onSearch"
      :onClear="onClear"
    />
  </Panel>
  <Panel title="検索結果">
    <TableCustomers
      :onSearch="onSearch"
      :condition="condition"
      :customers="customers"
      :paging="paging"
      :onSelected="onSelected"
    />
  </Panel>
</template>
