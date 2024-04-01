<script setup lang="ts">
/**
 * ****************************************************************************
 * @description     :   Main component for page M201 商品マスタ
 * @created at      :   2024/02/22
 * @created by      :   ANS902 – quanlh@ans-asia.com
 * @package         :   sparkle/master
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '@/stores/app'
import SearchConditions from '@/components/master/M201/SearchConditions.vue'
import SalesPrices from '@/components/master/M201/SalesPrices.vue'
import type {
  IGetInitDataResponse,
  ISizesPrice,
  ISizesPriceKey,
  ISearchCondition,
  ISearchResponse
} from '@/types/master/m201'
import _ from 'lodash'
import api from '@/repositories/master/m201'
import apiM101 from '@/repositories/master/m101'
import { MsgType, SysMsg, ansCommon, ansSecurity, ansValidate } from '@/utils'
import type { IGetItemDetailResponse, IItemKey, ISize } from '@/types/master/m101'

const intSearch = {
  price_list: 0
}
const route = useRoute()
const router = useRouter()
const appStore = useAppStore()
const sizePrices = ref<Array<ISizesPrice>>([])
const footerButtons = ref<Array<IAnsFooterButton>>([])

//init data
const price_list = ref<Array<IOption>>([])
//search
const condition = ref(<ISearchCondition>{ ...intSearch })

const deletePrices = ref<Array<ISizesPrice>>([])
const duplicates = ref<Object>({})
// defined method
// ------------------------------------------------------------------------------------------------
const focusFirstItem = () => {
  document.getElementById('item_cd')?.focus()
}
const getInitData = () => {
  api.getInitData().then(({ data: response }: { data: IGetInitDataResponse }) => {
    price_list.value = ansCommon.convertToOption(response.data?.price_list)
    focusFirstItem()
  })
}

const search = () => {
  ansValidate.removeAllErrors()
  api.search(condition.value).then(({ data: response }: { data: ISearchResponse }) => {
    sizePrices.value = response.data ?? []
    deletePrices.value = []
  })
}

const addToDeletePrice = (item: ISizesPrice) => {
  deletePrices.value.push(item)
}

const checkTablePrice = () => {
  const rules: IAnsDynamic = {}
  for (let i = 0; i < sizePrices.value.length; i++) {
    if (sizePrices.value[i].is_new) {
      rules[`sizePrices.${i}.item_cd`] = 'required'
      rules[`sizePrices.${i}.retail_upr`] = 'required'
      rules[`sizePrices.${i}.size_cd`] = 'required'
      rules[`sizePrices.${i}.price_list`] = 'required:checkZero'
    }
  }

  return ansValidate.isValidData(
    {
      sizePrices: _.cloneDeep(sizePrices.value)
    },
    rules
  )
}

const isSameSizesPrice = (price1: ISizesPrice, price2: ISizesPrice) => {
  return (
    !ansCommon.isEmpty(price1.item_cd) &&
    !ansCommon.isEmpty(price1.size_cd) &&
    !ansCommon.isEmpty(price1.price_list) &&
    !ansCommon.isEmpty(price2.item_cd) &&
    !ansCommon.isEmpty(price2.size_cd) &&
    !ansCommon.isEmpty(price2.price_list) &&
    price1.item_cd === price2.item_cd &&
    `${price1.color_cd ?? ''}` === `${price2.color_cd ?? ''}` &&
    price1.size_cd === price2.size_cd &&
    price1.price_list === price2.price_list
  )
}

const addErrorDuplicate = (index: Number) => {
  appStore.addItemError(`sizePrices.${index}.item_cd`, 'E011')
  appStore.addItemError(`sizePrices.${index}.color_cd`, 'E011')
  appStore.addItemError(`sizePrices.${index}.size_cd`, 'E011')
  appStore.addItemError(`sizePrices.${index}.price_list`, 'E011')
  appStore.addItemError(`sizePrices.${index}.retail_upr`, 'E011')
}

const checkDuplicate = () => {
  let isValid = true
  let map = new Map()
  for (let i = 0; i < sizePrices.value.length; i++) {
    if (!map.get(i)) {
      for (let j = i + 1; j < sizePrices.value.length; j++) {
        if (!map.get(j) && isSameSizesPrice(sizePrices.value[i], sizePrices.value[j])) {
          map.set(i, true)
          map.set(j, true)
          if (sizePrices.value[i].is_new) {
            addErrorDuplicate(i)
          }
          if (sizePrices.value[j].is_new) {
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

const getProduct = (params?: IItemKey, itemFocus: string = 'color_cd', idx: number = -1) => {
  if (idx < 0) {
    return
  }
  if (ansCommon.isEmpty(params?.item_cd)) {
    sizePrices.value[idx].item_cd = ''
    sizePrices.value[idx].item_nm = ''
    sizePrices.value[idx].color_cd = ''
    sizePrices.value[idx].color_nm = ''
    sizePrices.value[idx].sizes = []
  } else {
    apiM101.getDetail(params ?? {}).then(({ data: response }: { data: IGetItemDetailResponse }) => {
      sizePrices.value[idx].item_cd = response.data?.item?.item_cd ?? ''
      sizePrices.value[idx].item_nm = response.data?.item?.item_nm ?? ''
      sizePrices.value[idx].color_cd = response.data?.item?.color_cd ?? ''
      sizePrices.value[idx].color_nm = response.data?.item?.color_nm ?? ''
      sizePrices.value[idx].sizes = _.map(response.data?.sizes ?? [], (x: ISize) => {
        return {
          code: x.size_cd ?? '',
          name: x.size_cd ?? ''
        }
      })
    })
  }
}

const formatTypeSizesPrice = () => {
  if (sizePrices.value.length > 0) {
    for (let i = 0; i < sizePrices.value.length; i++) {
      sizePrices.value[i].retail_upr = Number(sizePrices.value[i].retail_upr)
    }
  }

  if (deletePrices.value.length > 0) {
    for (let i = 0; i < deletePrices.value.length; i++) {
      deletePrices.value[i].retail_upr = Number(deletePrices.value[i].retail_upr)
    }
  }
}
const checkData = () => {
  return sizePrices.value.length === 0 && deletePrices.value.length === 0
}

const saveSizesPrice = () => {
  let isCheckPrice = true
  if (checkData()) {
    appStore.showMessage({
      type: MsgType.ERROR,
      content: SysMsg.E012
    } as IAnsMessage)
    isCheckPrice = false
  } else {
    formatTypeSizesPrice()

    const isValid = checkTablePrice()
    const isNotDuplicate = checkDuplicate()
    if (isValid && isNotDuplicate && isCheckPrice) {
      appStore.showMessage({
        type: MsgType.CONFIRM,
        content: SysMsg.C001,
        callback: (ok) => {
          if (ok) {
            api.save(sizePrices.value, deletePrices.value).then(() => {
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

const deleteSizesPrice = () => {
  let isCheck = true
  if (checkData()) {
    appStore.showMessage({
      type: MsgType.ERROR,
      content: SysMsg.E012
    } as IAnsMessage)

    isCheck = false
  }

  if (isCheck) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C002,
      callback: (ok) => {
        if (ok) {
          api.delete([...sizePrices.value, ...deletePrices.value]).then(() => {
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
const changeRoute = (params?: ISizesPriceKey) => {}
// onCreated
// ------------------------------------------------------------------------------------------------
appStore.setHeader({
  id: 'M201',
  title: '商品売価マスタ',
  buttons: [
    {
      id: 'M201-search',
      title: '検索',
      icon: 'fas fa-search',
      onClickEvent: () => {
        search()
      }
    },
    {
      id: 'M201-save',
      title: '保存',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {
        saveSizesPrice()
      }
    },
    {
      id: 'M201-delete',
      title: '削除',
      icon: 'fa-regular fa-trash-can',
      onClickEvent: () => {
        deleteSizesPrice()
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
@import url('@/assets/scss/master/m201.scss');
</style>
<template>
  <Panel title="検索条件">
    <SearchConditions :condition="condition" :price_list="price_list" />
  </Panel>
  <Panel title="商品売価">
    <SalesPrices
      :price_list="price_list"
      :sizePrices="sizePrices"
      :addToDeletePrice="addToDeletePrice"
      :getProduct="getProduct"
      :duplicates="duplicates"
    />
  </Panel>
</template>
