<script setup lang="ts">
import api from '@/repositories/system/m002'
import SearchCondition from '@/components/popup/M002L/SearchCondition.vue'
import TableUsers from '@/components/popup/M002L/TableUsers.vue'
import { ref } from 'vue'
import type {
  IGetInitDataResponse,
  IUserForList,
  ISearchCondition,
  ISearchUserResponse
} from '@/types/system/m002'
import { ansCommon, ansValidate } from '@/utils'
import { Constants, SortType } from '@/utils/constants'

const props = withDefaults(defineProps<IAnsPopupSearch>(), {})

const initSearchCondition: ISearchCondition = {
  inq_belong_department_div: 0,
  page: 1,
  page_size: Constants.DEFAULT_PAGE_SIZE
}

const closeCondition = ref<() => void>(() => {})
const condition = ref<ISearchCondition>({})
const users = ref<Array<IUserForList>>([])
const paging = ref<IAnsPaging | undefined>(undefined)
const belong_department_div = ref<Array<IOption>>([])

const getInitData = () => {
  api.getInitData().then(({ data: response }: { data: IGetInitDataResponse }) => {
    belong_department_div.value = ansCommon.convertToOption(response.data?.belong_department_div)
    document.getElementById('inq_user_cd')?.focus()
  })
}

const onSearch = () => {
  if (
    ansValidate.isValidData(condition, {
      inq_mailaddress: 'email'
    })
  ) {
    api
      .search({
        ...initSearchCondition,
        ...condition.value
      })
      .then(({ data: response }: { data: ISearchUserResponse }) => {
        users.value = response.data.users
        paging.value = response.data.paging
        condition.value.has_search = true
        closeCondition.value()
      })
  }
}

const onClear = () => {
  condition.value = {}
  paging.value = undefined
  users.value = []
  document.getElementById('inq_user_cd')?.focus()
}

const onSelected = (item: IUserForList) => {
  props.onSelected(item)
  props.onClose()
}

const triggerClose = (fnc: () => void) => {
  closeCondition.value = fnc
}

getInitData()
</script>
<style lang="scss">
@import url('@/assets/scss/popup/m002l.scss');
</style>
<template>
  <Panel title="検索条件" :canCollapse="true" :triggerClose="triggerClose">
    <SearchCondition
      :condition="condition"
      :belong_department_div="belong_department_div"
      :onSearch="onSearch"
      :onClear="onClear"
    />
  </Panel>
  <Panel title="検索結果">
    <TableUsers
      :onSearch="onSearch"
      :condition="condition"
      :users="users"
      :paging="paging"
      :onSelected="onSelected"
    />
  </Panel>
</template>
