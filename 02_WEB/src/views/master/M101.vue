<script setup lang="ts">
/**
 * ****************************************************************************
 * @description     :   Main component for page M101 商品マスタ
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
import ItemDetail from '@/components/master/M101/ItemDetail.vue'
import SizeTable from '@/components/master/M101/SizeTable.vue'
import type {
  IGetInitDataResponse,
  IGetItemDetailResponse,
  IItem,
  IItemKey,
  ISize
} from '@/types/master/m101'
import _ from 'lodash'
import api from '@/repositories/master/m101'
import { MsgType, SysMsg, ansCommon, ansSecurity, ansValidate } from '@/utils'
import { ItemClassDiv } from '@/utils/nameDiv'

const initProduct = {
  item_cd: '',
  color_cd: '',
  item_class_div: 0,
  process_div: 0,
  category_div: 0,
  material_div: 0,
  tax_div: 0
}
const initSize = {
  discontinued_div: 0,
  discontinued_display_div: 0
}
const route = useRoute()
const router = useRouter()
const appStore = useAppStore()
const product = ref<IItem>({ ...initProduct })
const sizes = ref<Array<ISize>>([{ ...initSize }])
const footerButtons = ref<Array<IAnsFooterButton>>([])
const item_class_div = ref<Array<IOption>>([])
const process_div = ref<Array<IOption>>([])
const category_div = ref<Array<IOption>>([])
const material_div = ref<Array<IOption>>([])
const tax_div = ref<Array<IOption>>([])
const discontinued_div = ref<Array<IOption>>([])
const discontinued_display_div = ref<Array<IOption>>([])
const isBody = computed(() => {
  return product.value.item_class_div !== ItemClassDiv.PROCESS
})

// defined method
// ------------------------------------------------------------------------------------------------
const focusFirstItem = () => {
  document.getElementById('item_cd')?.focus()
}
const focusColor = () => {
  document.getElementById('color_cd')?.focus()
}
const getInitData = () => {
  api.getInitData().then(({ data: response }: { data: IGetInitDataResponse }) => {
    item_class_div.value = ansCommon.convertToOption(response.data?.item_class_div)
    process_div.value = ansCommon.convertToOption(response.data?.process_div)
    category_div.value = ansCommon.convertToOption(response.data?.category_div)
    material_div.value = ansCommon.convertToOption(response.data?.material_div)
    tax_div.value = ansCommon.convertToOption(response.data?.tax_div)
    discontinued_div.value = ansCommon.convertToOption(response.data?.discontinued_div)
    discontinued_display_div.value = ansCommon.convertToOption(
      response.data?.discontinued_display_div
    )
    focusFirstItem()
  })
}
const getProduct = (params?: IItemKey, itemFocus: string = 'color_cd') => {
  ansValidate.removeAllErrors()
  const query = params ?? (ansSecurity.decodeParams((route.query.p ?? '') as string) as IItemKey)
  if (ansCommon.isEmpty(query?.item_cd)) {
    product.value = { ...initProduct }
    sizes.value = [{ ...initSize }]
    itemFocus === 'color_cd' ? focusColor : focusFirstItem()
    return
  }
  api.getDetail(query).then(({ data: response }: { data: IGetItemDetailResponse }) => {
    product.value = response.data.item ?? ({ ...initProduct } as IItem)
    product.value.item_cd = query.item_cd
    product.value.color_cd = query.color_cd
    if (product.value.supplier_cd === 0) {
      product.value.supplier_cd = undefined
    }
    sizes.value =
      response.data.sizes && response.data.sizes.length > 0
        ? response.data.sizes
        : [{ ...initSize }]
    itemFocus === 'color_cd' ? focusColor() : focusFirstItem()
  })
}
const updateSizes = (_sizes: Array<ISize>) => {
  sizes.value = _.map(_sizes, (x, idx) => {
    return {
      ...x,
      item_cd: product.value.item_cd,
      color_cd: product.value.color_cd,
      sort_div: idx + 1
    }
  })
}
const checkData = (isDelete: boolean = false) => {
  const rules: IAnsDynamic = {
    item_cd: 'required',
    item_nm: 'required',
    item_kn_nm: 'katakana',
    color_kn_nm: 'katakana'
  }
  if (isBody.value) {
    for (let i = 0; i < sizes.value.length; i++) {
      rules[`sizes.${i}.size_cd`] = 'required'
    }
  }
  return ansValidate.isValidData(
    {
      ...product.value,
      sizes: [...sizes.value]
    },
    isDelete
      ? {
          item_cd: 'required'
        }
      : rules
  )
}
const checkDuplicate = () => {
  let isValid = true
  for (let i = 0; i < sizes.value.length; i++) {
    for (let j = 0; j < sizes.value.length; j++) {
      if (
        i !== j &&
        !ansCommon.isEmpty(sizes.value[i].size_cd) &&
        !ansCommon.isEmpty(sizes.value[j].size_cd) &&
        sizes.value[i].size_cd === sizes.value[j].size_cd
      ) {
        appStore.addItemError(`sizes.${i}.size_cd`, 'E011')
        appStore.addItemError(`sizes.${j}.size_cd`, 'E011')
        isValid = false
      }
    }
  }
  return isValid
}
const saveProduct = () => {
  const isValid = checkData()
  const notDuplicate = isBody.value ? checkDuplicate() : true
  if (isValid && notDuplicate) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C001,
      callback: (ok) => {
        if (ok) {
          api
            .save({
              item: { ...product.value },
              sizes: isBody.value ? [...sizes.value] : []
            })
            .then(() => {
              appStore.showMessage({
                type: MsgType.SUCCESS,
                content: SysMsg.S001,
                callback: () => {
                  getProduct(product.value as IItemKey, 'item_cd')
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

const deleteProduct = () => {
  if (checkData(true)) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C002,
      callback: (ok) => {
        if (ok) {
          api.delete(product.value as IItemKey).then(() => {
            appStore.showMessage({
              type: MsgType.SUCCESS,
              content: SysMsg.S002,
              callback: () => {
                getProduct(undefined, 'item_cd')
              }
            } as IAnsMessage)
          })
        }
      }
    } as IAnsMessage)
  }
}
// ------------------------------------------------------------------------------------------------

const changeRoute = (params?: IItemKey) => {
  router.push({
    name: 'M101',
    query: ansCommon.isEmpty(params)
      ? undefined
      : {
          p: ansSecurity.encodeParams(params)
        }
  })
}

// onCreated
// ------------------------------------------------------------------------------------------------
appStore.setHeader({
  id: 'M101',
  title: '商品マスタ',
  buttons: [
    {
      id: 'M006-save',
      title: '保存',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {
        saveProduct()
      }
    },
    {
      id: 'M006-delete',
      title: '削除',
      icon: 'fa-regular fa-trash-can',
      onClickEvent: () => {
        deleteProduct()
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
getProduct()
// ------------------------------------------------------------------------------------------------
</script>
<style lang="scss">
@import url('@/assets/scss/master/m101.scss');
</style>
<template>
  <Panel title="商品情報">
    <ItemDetail
      :product="product"
      :item_class_div="item_class_div"
      :process_div="process_div"
      :category_div="category_div"
      :material_div="material_div"
      :tax_div="tax_div"
      :getProduct="getProduct"
    />
  </Panel>
  <Panel title="サイズ情報" :class="{ hidden: !isBody }">
    <SizeTable
      :product="product"
      :sizes="sizes"
      :discontinued_div="discontinued_div"
      :discontinued_display_div="discontinued_display_div"
      :updateSizes="updateSizes"
    />
  </Panel>
  <ActionHistory :actionHistory="product" :buttons="footerButtons" />
</template>
