<script setup lang="ts">
/**
 * ****************************************************************************
 * @description     :   Main component for page M302 商品マスタ
 * @created at      :   2024/02/21
 * @created by      :   ANS809 – quypn@ans-asia.com
 * @package         :   sparkle/master
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '@/stores/app'
import SearchCondition from '@/components/master/M302/SearchCondition.vue'
import TableCost from '@/components/master/M302/TableCost.vue'
import type {
  ICost,
  IGetInitDataResponse,
  ISearchCondition,
  ISearchResponse
} from '@/types/master/m302'
import _ from 'lodash'
import api from '@/repositories/master/m302'
import { MsgType, SysMsg, ansCommon, ansValidate } from '@/utils'

const initCondition = {
  category_div: 0,
  material_div: 0,
  processing_place_div: 0
}

const appStore = useAppStore()
const condition = ref<ISearchCondition>({ ...initCondition })
const costs = ref<Array<ICost>>([])
const deleteCosts = ref<Array<ICost>>([])
const category_div = ref<Array<IOption>>([])
const material_div = ref<Array<IOption>>([])
const processing_place_div = ref<Array<IOption>>([])
const color_div = ref<Array<IOption>>([])

// defined method
// ------------------------------------------------------------------------------------------------
const getInitData = () => {
  api.getInitData().then(({ data: response }: { data: IGetInitDataResponse }) => {
    category_div.value = ansCommon.convertToOption(response.data?.category_div)
    material_div.value = ansCommon.convertToOption(response.data?.material_div)
    processing_place_div.value = ansCommon.convertToOption(response.data?.processing_place_div)
    color_div.value = ansCommon.convertToOption(response.data?.color_div)
    focusFirstItem()
  })
}

const focusFirstItem = () => {
  document.getElementById('supplier_cd')?.focus()
}

const search = () => {
  ansValidate.removeAllErrors()
  api.search(condition.value).then(({ data: response }: { data: ISearchResponse }) => {
    costs.value = response.data
    deleteCosts.value = []
  })
  focusFirstItem()
}

const addToDeleteCost = (item: ICost) => {
  deleteCosts.value.push(item)
}

const checkTableCost = () => {
  const rules: IAnsDynamic = {}
  for (let i = 0; i < costs.value.length; i++) {
    if (costs.value[i].is_new) {
      rules[`costs.${i}.supplier_cd`] = 'required'
      rules[`costs.${i}.item_cd`] = 'required'
      rules[`costs.${i}.category_div`] = 'required:checkZero'
      rules[`costs.${i}.material_div`] = 'required:checkZero'
      rules[`costs.${i}.processing_place_div`] = 'required:checkZero'
      rules[`costs.${i}.number_sheet_fr`] = 'required'
      rules[`costs.${i}.number_sheet_to`] = 'required'
      rules[`costs.${i}.color_div`] = 'required'
      rules[`costs.${i}.sales_amt`] = 'required'
    } else {
      rules[`costs.${i}.sales_amt`] = 'required'
    }
  }

  return ansValidate.isValidData(
    {
      costs: _.cloneDeep(costs.value)
    },
    rules
  )
}

const isSameCost = (cost1: ICost, cost2: ICost) => {
  return (
    !ansCommon.isEmpty(cost1.supplier_cd) &&
    !ansCommon.isEmpty(cost1.item_cd) &&
    !ansCommon.isEmpty(cost1.category_div) &&
    !ansCommon.isEmpty(cost1.material_div) &&
    !ansCommon.isEmpty(cost1.processing_place_div) &&
    !ansCommon.isEmpty(cost1.number_sheet_fr) &&
    !ansCommon.isEmpty(cost1.number_sheet_to) &&
    !ansCommon.isEmpty(cost1.color_div) &&
    !ansCommon.isEmpty(cost2.supplier_cd) &&
    !ansCommon.isEmpty(cost2.item_cd) &&
    !ansCommon.isEmpty(cost2.category_div) &&
    !ansCommon.isEmpty(cost2.material_div) &&
    !ansCommon.isEmpty(cost2.processing_place_div) &&
    !ansCommon.isEmpty(cost2.number_sheet_fr) &&
    !ansCommon.isEmpty(cost2.number_sheet_to) &&
    !ansCommon.isEmpty(cost2.color_div) &&
    cost1.supplier_cd === cost2.supplier_cd &&
    cost1.item_cd === cost2.item_cd &&
    cost1.category_div === cost2.category_div &&
    cost1.material_div === cost2.material_div &&
    cost1.processing_place_div === cost2.processing_place_div &&
    cost1.number_sheet_fr === cost2.number_sheet_fr &&
    cost1.number_sheet_to === cost2.number_sheet_to &&
    cost1.color_div === cost2.color_div
  )
}

const checkDuplicate = () => {
  let isValid = true
  for (let i = 0; i < costs.value.length; i++) {
    for (let j = i + 1; j < costs.value.length; j++) {
      if (i !== j && isSameCost(costs.value[i], costs.value[j])) {
        if (costs.value[i].is_new) {
          appStore.addItemError(`costs.${i}.supplier_cd`, 'E011')
          appStore.addItemError(`costs.${i}.item_cd`, 'E011')
          appStore.addItemError(`costs.${i}.category_div`, 'E011')
          appStore.addItemError(`costs.${i}.material_div`, 'E011')
          appStore.addItemError(`costs.${i}.processing_place_div`, 'E011')
          appStore.addItemError(`costs.${i}.number_sheet_fr`, 'E011')
          appStore.addItemError(`costs.${i}.number_sheet_to`, 'E011')
          appStore.addItemError(`costs.${i}.color_div`, 'E011')
        }
        if (costs.value[j].is_new) {
          appStore.addItemError(`costs.${j}.supplier_cd`, 'E011')
          appStore.addItemError(`costs.${j}.item_cd`, 'E011')
          appStore.addItemError(`costs.${j}.category_div`, 'E011')
          appStore.addItemError(`costs.${j}.material_div`, 'E011')
          appStore.addItemError(`costs.${j}.processing_place_div`, 'E011')
          appStore.addItemError(`costs.${j}.number_sheet_fr`, 'E011')
          appStore.addItemError(`costs.${j}.number_sheet_to`, 'E011')
          appStore.addItemError(`costs.${j}.color_div`, 'E011')
        }
        isValid = false
      }
    }
  }
  return isValid
}

const formatTypeProcessCost = () => {
  let count = 0
  for (let i = 0; i < costs.value.length; i++) {
    costs.value[i].number_sheet_fr = String(costs.value[i].number_sheet_fr)
    costs.value[i].number_sheet_to = String(costs.value[i].number_sheet_to)
    costs.value[i].sales_amt = String(costs.value[i].sales_amt)
    costs.value[i].supplier_cd = String(costs.value[i].supplier_cd)
    costs.value[i].idx = count++
  }
}

const checkData = () => {
  return costs.value.length === 0 && deleteCosts.value.length === 0
}

const saveCost = () => {
  if (checkData()) {
    appStore.showMessage({
      type: MsgType.ERROR,
      content: SysMsg.E012
    } as IAnsMessage)
  } else {
    formatTypeProcessCost()
    const isValid = checkTableCost()
    const isNotDuplicate = checkDuplicate()
    if (isValid && isNotDuplicate) {
      appStore.showMessage({
        type: MsgType.CONFIRM,
        content: SysMsg.C001,
        callback: (ok) => {
          if (ok) {
            api.save(costs.value, deleteCosts.value).then(() => {
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
}

const deleteCost = () => {
  if (checkData()) {
    appStore.showMessage({
      type: MsgType.ERROR,
      content: SysMsg.E012
    } as IAnsMessage)
  } else {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C002,
      callback: (ok) => {
        if (ok) {
          api.delete([...costs.value, ...deleteCosts.value]).then(() => {
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
  }
}

// // onCreated
// // ------------------------------------------------------------------------------------------------
appStore.setHeader({
  id: 'M302',
  title: '加工原価マスタ',
  buttons: [
    {
      id: 'M302-view',
      title: '検索',
      icon: 'fas fa-search ',
      onClickEvent: () => {
        search()
      }
    },
    {
      id: 'M302-save',
      title: '保存',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {
        saveCost()
      }
    },
    {
      id: 'M302-delete',
      title: '削除',
      icon: 'fa-regular fa-trash-can',
      onClickEvent: () => {
        deleteCost()
      }
    }
  ]
})
// get data on created
getInitData()
// ------------------------------------------------------------------------------------------------
</script>
<style lang="scss">
@import url('@/assets/scss/master/m302.scss');
</style>
<template>
  <Panel title="検索条件">
    <SearchCondition
      :condition="condition"
      :category_div="category_div"
      :material_div="material_div"
      :processing_place_div="processing_place_div"
    />
  </Panel>
  <Panel title="加工原価">
    <TableCost
      :costs="costs"
      :category_div="category_div"
      :material_div="material_div"
      :processing_place_div="processing_place_div"
      :color_div="color_div"
      :addToDeleteCost="addToDeleteCost"
    />
  </Panel>
</template>
