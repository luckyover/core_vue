<script setup lang="ts">
/**
 * ****************************************************************************
 * @description     :   Main component for page M301 商品マスタ
 * @created at      :   2024/02/22
 * @created by      :   ANS909 – thuannv@ans-asia.com
 * @package         :   sparkle/master
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '@/stores/app'
import ProcessPriceDetail from '@cpn/master/M301/ProcessPriceDetail.vue'
import ProcessPriceTable from '@cpn/master/M301/ProcessPriceTable.vue'
import type {
  IGetInitDataResponse,
  IProcessPrice,
  IProcessPriceKey,
  ISearchCondition,
  ISearchResponse
} from '@/types/master/m301'
import _ from 'lodash'
import api from '@/repositories/master/m301'
import { MsgType, SysMsg, ansCommon, ansSecurity, ansValidate } from '@/utils'

const intSearch = {
  item_cd: '',
  item_nm: '',
  category_div: 0,
  material_div: 0,
  processing_location_div: 0
}
const router = useRouter()
const appStore = useAppStore()
const processPrices = ref<Array<IProcessPrice>>([])
const footerButtons = ref<Array<IAnsFooterButton>>([])

//init data
const category_div = ref<Array<IOption>>([])
const material_div = ref<Array<IOption>>([])
const processing_location_div = ref<Array<IOption>>([])
const number_of_color_div = ref<Array<IOption>>([])

// searchResults
const condition = ref(<ISearchCondition>{ ...intSearch })

const deletePrices = ref<Array<IProcessPrice>>([])

const duplicates = ref<Object>({})

// defined method
// ------------------------------------------------------------------------------------------------
const getInitData = () => {
  api.getInitData().then(({ data: response }: { data: IGetInitDataResponse }) => {
    category_div.value = ansCommon.convertToOption(response.data?.category_div)
    material_div.value = ansCommon.convertToOption(response.data?.material_div)
    material_div.value = ansCommon.convertToOption(response.data?.material_div)
    processing_location_div.value = ansCommon.convertToOption(
      response.data?.processing_location_div
    )
    number_of_color_div.value = ansCommon.convertToOption(response.data?.number_of_color_div)
  })
}

onMounted(() => {
  setTimeout(() => {
    focusFirstItem()
  }, 300)
})

const focusFirstItem = () => {
  document.getElementById('item_cd')?.focus()
}

const search = () => {
  ansValidate.removeAllErrors()
  api.search(condition.value).then(({ data: response }: { data: ISearchResponse }) => {
    processPrices.value = response.data ?? []
    deletePrices.value = []
    focusFirstItem()
  })
}

const addToDeletePrice = (item: IProcessPrice) => {
  deletePrices.value.push(item)
}
const checkTablePrice = () => {
  const rules: IAnsDynamic = {}
  for (let i = 0; i < processPrices.value.length; i++) {
    rules[`process_prices.${i}.item_cd`] = 'required'
    rules[`process_prices.${i}.category_div`] = 'required:checkZero'
    rules[`process_prices.${i}.material_div`] = 'required:checkZero'
    rules[`process_prices.${i}.processing_place_div`] = 'required:checkZero'
    rules[`process_prices.${i}.number_sheet_fr`] = 'required'
    rules[`process_prices.${i}.number_sheet_to`] = 'required'
    rules[`process_prices.${i}.color_div`] = 'required'
    rules[`process_prices.${i}.sales_amt`] = 'required'
  }

  return ansValidate.isValidData(
    {
      process_prices: _.cloneDeep(processPrices.value)
    },
    rules
  )
}
const isSameProcessPrice = (price1: IProcessPrice, price2: IProcessPrice) => {
  return (
    !ansCommon.isEmpty(price1.item_cd) &&
    !ansCommon.isEmpty(price1.category_div) &&
    !ansCommon.isEmpty(price1.material_div) &&
    !ansCommon.isEmpty(price1.processing_place_div) &&
    !ansCommon.isEmpty(price1.number_sheet_fr) &&
    !ansCommon.isEmpty(price1.number_sheet_to) &&
    !ansCommon.isEmpty(price1.color_div) &&
    !ansCommon.isEmpty(price2.item_cd) &&
    !ansCommon.isEmpty(price2.category_div) &&
    !ansCommon.isEmpty(price2.material_div) &&
    !ansCommon.isEmpty(price2.processing_place_div) &&
    !ansCommon.isEmpty(price2.number_sheet_fr) &&
    !ansCommon.isEmpty(price2.number_sheet_to) &&
    !ansCommon.isEmpty(price2.color_div) &&
    price1.item_cd === price2.item_cd &&
    price1.category_div === price2.category_div &&
    price1.material_div === price2.material_div &&
    price1.processing_place_div === price2.processing_place_div &&
    price1.number_sheet_fr === price2.number_sheet_fr &&
    price1.number_sheet_to === price2.number_sheet_to &&
    price1.color_div === price2.color_div
  )
}

const addErrorDuplicate = (index: Number) => {
  appStore.addItemError(`process_prices.${index}.item_cd`, 'E011')
  appStore.addItemError(`process_prices.${index}.category_div`, 'E011')
  appStore.addItemError(`process_prices.${index}.material_div`, 'E011')
  appStore.addItemError(`process_prices.${index}.processing_place_div`, 'E011')
  appStore.addItemError(`process_prices.${index}.number_sheet_fr`, 'E011')
  appStore.addItemError(`process_prices.${index}.number_sheet_to`, 'E011')
  appStore.addItemError(`process_prices.${index}.color_div`, 'E011')
}

const checkDuplicate = () => {
  let isValid = true
  let map = new Map()
  for (let i = 0; i < processPrices.value.length; i++) {
    if (!map.get(i)) {
      for (let j = i + 1; j < processPrices.value.length; j++) {
        if (!map.get(j) && isSameProcessPrice(processPrices.value[i], processPrices.value[j])) {
          map.set(i, true)
          map.set(j, true)
          if (processPrices.value[i].is_new) {
            addErrorDuplicate(i)
          }
          if (processPrices.value[j].is_new) {
            addErrorDuplicate(j)
          }
          isValid = false
        }
      }
    }
    duplicates.value = Object.fromEntries(map)
  }
  return isValid
}

const convertPriceToMoney = (value: undefined | null | Number | '') => {
  if (value === '' || value === undefined || value === null || _.isNaN(value)) return undefined
  return Number(value)
}

const dtoProcessPrices = () => {
  if (processPrices.value.length > 0) {
    let count = 0
    for (let price of processPrices.value) {
      price.number_sheet_fr = convertPriceToMoney(price.number_sheet_fr)
      price.number_sheet_to = convertPriceToMoney(price.number_sheet_to)
      price.sales_amt = convertPriceToMoney(price.sales_amt)
      price.idx = count++
    }
  }
  if (deletePrices.value.length > 0) {
    for (let price of deletePrices.value) {
      price.number_sheet_fr = convertPriceToMoney(price.number_sheet_fr)
      price.number_sheet_to = convertPriceToMoney(price.number_sheet_to)
      price.sales_amt = convertPriceToMoney(price.sales_amt)
    }
  }
}

const checkData = () => {
  return processPrices.value.length === 0 && deletePrices.value.length === 0
}

const saveProcessPrices = () => {
  if (checkData()) {
    appStore.showMessage({
      type: MsgType.ERROR,
      content: SysMsg.E012
    } as IAnsMessage)
  } else {
    dtoProcessPrices()

    const isValid = checkTablePrice()
    const isNotDuplicate = checkDuplicate()
    if (isValid && isNotDuplicate) {
      appStore.showMessage({
        type: MsgType.CONFIRM,
        content: SysMsg.C001,
        callback: (ok) => {
          if (ok) {
            api.save(processPrices.value, deletePrices.value).then(() => {
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

const deleteProcessPrice = () => {
  if (checkData()) {
    appStore.showMessage({
      type: MsgType.ERROR,
      content: SysMsg.E012
    } as IAnsMessage)
  } else {
    dtoProcessPrices()

    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C002,
      callback: (ok) => {
        if (ok) {
          api.delete([...processPrices.value, ...deletePrices.value]).then(() => {
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
// ------------------------------------------------------------------------------------------------

const changeRoute = (params?: IProcessPriceKey) => {}

// onCreated
// ------------------------------------------------------------------------------------------------
appStore.setHeader({
  id: 'M301',
  title: '加工売価マスタ',
  buttons: [
    {
      id: 'M301-view',
      title: '検索',
      icon: 'fas fa-search',
      onClickEvent: () => {
        search()
      }
    },
    {
      id: 'M301-save',
      title: '保存',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {
        saveProcessPrices()
      }
    },
    {
      id: 'M301-delete',
      title: '削除',
      icon: 'fa-regular fa-trash-can',
      onClickEvent: () => {
        deleteProcessPrice()
      }
    }
  ]
})

footerButtons.value = [
  {
    id: 'btn-m201',
    title: '商品売価',
    href: '/master/m201'
  },
  {
    id: 'btn-m202',
    title: '商品原価',
    href: '/master/m202'
  },
  {
    id: 'btn-m301',
    title: '加工売価',
    href: '/master/m301'
  },
  {
    id: 'btn-m302',
    title: '加工原価',
    href: '/master/m302'
  }
]
// get data on created
getInitData()
// ------------------------------------------------------------------------------------------------
</script>
<style lang="scss">
@import url('@/assets/scss/master/m301.scss');
</style>
<template>
  <Panel title="検索条件">
    <ProcessPriceDetail
      :condition="condition"
      :category_div="category_div"
      :material_div="material_div"
      :processing_location_div="processing_location_div"
    />
  </Panel>
  <Panel title="加工売価">
    <ProcessPriceTable
      :processPrices="processPrices"
      :category_div="category_div"
      :material_div="material_div"
      :processing_location_div="processing_location_div"
      :number_of_color_div="number_of_color_div"
      :addToDeletePrice="addToDeletePrice"
      :duplicates="duplicates"
    />
  </Panel>
</template>
