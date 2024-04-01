<script setup lang="ts">
import { Constants } from '@/utils/constants'
import { ref, computed } from 'vue'

// Define props
// ------------------------------------------------------------------------------------------------
const props = withDefaults(defineProps<IAnsPagingProps>(), {
  isShowPageSize: true,
  paging: () =>
    ({
      pageSize: Constants.DEFAULT_PAGE_SIZE,
      page: 1,
      totalRecord: 0
    }) as IAnsPaging
})
const emit = defineEmits(['update:modelValue'])
// ------------------------------------------------------------------------------------------------

const pageSizes = ref<Array<IOption>>([
  {
    code: 50,
    name: '50件'
  },
  {
    code: 100,
    name: '100件'
  },
  {
    code: 200,
    name: '200件'
  }
])

// Define computed
// ------------------------------------------------------------------------------------------------
const viewValue = computed({
  get() {
    const val = props.modelValue ? props.modelValue : props.value
    return val ?? 1
  },
  set(value) {
    const oldValue = viewValue.value
    if (`${oldValue ?? ''}` !== `${value ?? ''}`) {
      emit('update:modelValue', value)
      if (props.onChangeEvent) {
        props.onChangeEvent(value, oldValue)
      }
    }
  }
})

const pageInfo = computed(() => {
  const from = (props.paging.page - 1) * props.paging.pageSize + 1
  const to = from + props.paging.pageSize - 1
  return props.paging.totalRecord === 0
    ? ''
    : `${props.paging.totalRecord}件の結果から${from}～${
        to < props.paging.totalRecord ? to : props.paging.totalRecord
      }件を表示する`
})
// ------------------------------------------------------------------------------------------------

const changePageSize = () => {
  if (props.onChangePageSizeEvent) {
    props.onChangePageSizeEvent(props.paging.pageSize)
  }
}
</script>

<template>
  <div class="row ans-item ans-paging" :class="`${itemClass ?? ''}`">
    <div class="ans-item-control col-sm-6" v-if="isShowPageSize">
      <select
        v-model="paging.pageSize"
        class="form-select -from-select-sm select-page-size"
        @change="changePageSize"
      >
        <option v-for="pageSize in pageSizes" :value="pageSize.code">{{ pageSize.name }}</option>
      </select>
      <span class="page-info">{{ pageInfo }}</span>
    </div>
    <div
      class="ans-item-control"
      :class="{ 'col-sm-12': !isShowPageSize, 'col-sm-6': isShowPageSize }"
      v-if="isShowWhenNoPage || paging.totalRecord > 0"
    >
      <b-pagination
        v-model="viewValue"
        :total-rows="paging.totalRecord"
        :per-page="paging.pageSize"
        size="sm"
        align="end"
      ></b-pagination>
    </div>
  </div>
</template>
