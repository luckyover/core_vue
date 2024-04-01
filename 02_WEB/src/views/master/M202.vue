<script setup lang="ts">
/**
 * ****************************************************************************
 * @description     :   Main component for page M202 商品原価マスタ
 * @created at      :   2024/02/22
 * @created by      :   ANS901 – hainn@ans-asia.com
 * @package         :   sparkle/master
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '@/stores/app'
import _ from 'lodash'
import api from '@/repositories/master/m202'
import apiM101 from '@/repositories/master/m101'
import SearchProductCost from '@/components/master/M202/SearchProductCostDetail.vue'
import ProductCostTable from '@/components/master/M202/ProductCostTable.vue'
import type { IProductCost, IProductCostSearch, ISearchResponse } from '@/types/master/m202'
import { MsgType, SysMsg, ansCommon, ansSecurity, ansValidate, ansNumber } from '@/utils'
import type { IGetItemDetailResponse, IItemKey, ISize } from '@/types/master/m101'

const route = useRoute()
const router = useRouter()
const appStore = useAppStore()

const costs = ref<Array<IProductCost>>([])
const condition = ref<IProductCostSearch>({})
const dataDelCost = ref<Array<IProductCost>>([])

// defined method
// ------------------------------------------------------------------------------------------------
const focusFirstItem = () => {
  document.getElementById('item_cd')?.focus()
}

const checkDuplicate = () => {
  let isValid = true
  for (let i = 0; i < costs.value.length; i++) {
    for (let j = i + 1; j < costs.value.length; j++) {
      if (i !== j && isSameCost(costs.value[i], costs.value[j])) {
        if (costs.value[i].is_new) {
          appStore.addItemError(`costs.${i}.item_cd`, 'E011')
          appStore.addItemError(`costs.${i}.color_cd`, 'E011')
          appStore.addItemError(`costs.${i}.size_cd`, 'E011')
          appStore.addItemError(`costs.${i}.supplier_cd`, 'E011')
        }
        if (costs.value[j].is_new) {
          appStore.addItemError(`costs.${j}.item_cd`, 'E011')
          appStore.addItemError(`costs.${j}.color_cd`, 'E011')
          appStore.addItemError(`costs.${j}.size_cd`, 'E011')
          appStore.addItemError(`costs.${j}.supplier_cd`, 'E011')
        }
        isValid = false
      }
    }
  }
  return isValid
}

const isSameCost = (cost1: IProductCost, cost2: IProductCost) => {
  return (
    !ansCommon.isEmpty(cost1.item_cd) &&
    !ansCommon.isEmpty(cost1.size_cd) &&
    !ansCommon.isEmpty(cost1.supplier_cd) &&
    !ansCommon.isEmpty(cost2.item_cd) &&
    !ansCommon.isEmpty(cost2.size_cd) &&
    !ansCommon.isEmpty(cost2.supplier_cd) &&
    cost1.item_cd === cost2.item_cd &&
    `${cost1.color_cd ?? ''}` === `${cost2.color_cd ?? ''}` &&
    ansNumber.toNumber(`${cost1.supplier_cd ?? ''}`) === ansNumber.toNumber(`${cost2.supplier_cd ?? ''}`) &&
    cost1.size_cd === cost2.size_cd
  )
}

const checkTableCost = () => {
  const rules: IAnsDynamic = {}
  for (let i = 0; i < costs.value.length; i++) {
    if (costs.value[i].is_new) {
      if (costs.value[i].item_cd === '' && costs.value[i].color_cd === '') {
        // rules[`costs.${i}.color_cd`] = 'required'
        rules[`costs.${i}.item_cd`] = 'required'
      }
      rules[`costs.${i}.size_cd`] = 'required'
      rules[`costs.${i}.supplier_cd`] = 'required'
      rules[`costs.${i}.retail_upr`] = 'required'
    }
  }

  return ansValidate.isValidData(
    {
      //   costs: _.filter(costs.value, (x: ICost) => {
      //     return x.is_new
      //   })

      costs: _.cloneDeep(costs.value)
    },
    rules
  )
}

const getDetailItem = (params: IItemKey, itemFocus: string = 'color_cd', idx: number) => {
  if (idx < 0) {
    return
  }

  if (ansCommon.isEmpty(params?.item_cd)) {
    costs.value[idx].item_cd = ''
    costs.value[idx].item_nm = ''
    costs.value[idx].color_cd = ''
    costs.value[idx].color_nm = ''
    costs.value[idx].size_cd = ''
    costs.value[idx].sizes = []
  } else {
    apiM101.getDetail(params ?? {}).then(({ data: response }: { data: IGetItemDetailResponse }) => {
      costs.value[idx].item_cd = response.data?.item?.item_cd ?? ''
      costs.value[idx].item_nm = response.data?.item?.item_nm ?? ''
      costs.value[idx].color_cd = response.data?.item?.color_cd ?? ''
      costs.value[idx].color_nm = response.data?.item?.color_nm ?? ''
      costs.value[idx].size_cd = ''
      costs.value[idx].sizes = _.map(response.data?.sizes ?? [], (x: ISize) => {
        return {
          code: x.size_cd ?? '',
          name: x.size_cd ?? ''
        }
      })
    })
  }
}

const search = () => {
  ansValidate.removeAllErrors()
  api.search(condition.value).then(({ data: response }: { data: ISearchResponse }) => {
    costs.value = response.data
    dataDelCost.value = []
    focusFirstItem()
  })
}

const addToDeleteCost = (item: IProductCost) => {
  dataDelCost.value.push(item)
}

const save = () => {
  const isValid = checkTableCost()
  const isNotDuplicate = checkDuplicate()
  if (isNotDuplicate && isValid) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C001,
      callback: (ok) => {
        if (ok) {
          api.save(costs.value, dataDelCost.value).then(() => {
            appStore.showMessage({
              type: MsgType.SUCCESS,
              content: SysMsg.S001,
              callback: () => {
                search()
              }
            } as IAnsMessage)
          })
        }
      }
    } as IAnsMessage)
  } else {
    ansValidate.focusFirstError()
  }
}

const del = () => {
  appStore.showMessage({
    type: MsgType.CONFIRM,
    content: SysMsg.C002,
    callback: (ok) => {
      if (ok) {
        api.delete(costs.value).then(() => {
          appStore.showMessage({
            type: MsgType.SUCCESS,
            content: SysMsg.S002,
            callback: () => {
              search()
            }
          } as IAnsMessage)
        })
      }
    }
  } as IAnsMessage)
}
// ------------------------------------------------------------------------------------------------

// onCreated

// ------------------------------------------------------------------------------------------------
appStore.setHeader({
  id: 'M202',
  title: '商品原価マスタ',
  buttons: [
    {
      id: 'M202-view',
      title: '検索',
      icon: 'fa-regular fas fa-search',
      onClickEvent: () => {
        search()
      }
    },
    {
      id: 'M202-save',
      title: '保存',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {
        save()
      }
    },
    {
      id: 'M202-delete',
      title: '削除',
      icon: 'fa-regular fa-trash-can',
      onClickEvent: () => {
        del()
      }
    }
  ]
})

// get data on created
onMounted(() => {
  setTimeout(() => {
    focusFirstItem()
  }, 300)
})
// ------------------------------------------------------------------------------------------------
</script>
<style lang="scss">
@import url('@/assets/scss/master/m202.scss');
</style>
<template>
  <Panel title="検索条件">
    <SearchProductCost :condition="condition" />
  </Panel>
  <Panel title="商品原価">
    <ProductCostTable
      :costs="costs"
      :addToDeleteCost="addToDeleteCost"
      :getDetailItem="getDetailItem"
    />
  </Panel>
</template>
