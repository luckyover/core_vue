<script setup lang="ts">
/**
 * ****************************************************************************
 * @description     :   Main component for page M002 ユーザーマスタ
 * @created at      :   2024/02/17
 * @created by      :   ANS809 – quypn@ans-asia.com
 * @package         :   sparkle/system
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */

import type {
  IGetInitDataResponse,
  IGetSupplierDetailResponse,
  ISupplier,
  ISupplierStoreResponse
} from '@/types/master/m006'
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '@/stores/app'
import api from '@/repositories/master/m006'
import _ from 'lodash'
import { MsgType, SysMsg, ansCommon, ansSecurity, ansValidate } from '@/utils'
import SupplierInformation from '@/components/master/M006/SupplierInformation.vue'

// Declare variable
// ------------------------------------------------------------------------------------------------
const route = useRoute()
const router = useRouter()
const appStore = useAppStore()
const initSupplier: ISupplier = {
  supplier_div: 0,
  supplier_class_div1: 0,
  supplier_class_div2: 0,
  supplier_class_div3: 0,
  supplier_closing_div: 0,
  transfer_date1: 0,
  transfer_date2: 0
}
const supplier = ref<ISupplier>({ ...initSupplier })
const supplier_div = ref<Array<IOption>>([])
const supplier_class_div1 = ref<Array<IOption>>([])
const supplier_class_div2 = ref<Array<IOption>>([])
const supplier_class_div3 = ref<Array<IOption>>([])
const supplier_closing_div = ref<Array<IOption>>([])
const transfer_date1 = ref<Array<IOption>>([])
const transfer_date2 = ref<Array<IOption>>([])
// ------------------------------------------------------------------------------------------------

// defined method
// ------------------------------------------------------------------------------------------------
const focusFirstItem = () => {
  document.getElementById('supplier_cd')?.focus()
}
const getInitData = () => {
  api.getInitData().then(({ data: response }: { data: IGetInitDataResponse }) => {
    supplier_div.value = ansCommon.convertToOption(response.data?.supplier_div)
    supplier_class_div1.value = ansCommon.convertToOption(response.data?.supplier_class_div1)
    supplier_class_div2.value = ansCommon.convertToOption(response.data?.supplier_class_div2)
    supplier_class_div3.value = ansCommon.convertToOption(response.data?.supplier_class_div3)
    supplier_closing_div.value = ansCommon.convertToOption(response.data?.supplier_closing_div)
    transfer_date1.value = ansCommon.convertToOption(response.data?.transfer_date1)
    transfer_date2.value = ansCommon.convertToOption(response.data?.transfer_date2)
    focusFirstItem()
  })
}

const getSupplier = (supplier_cd?: number) => {
  ansValidate.removeAllErrors()
  const id = supplier_cd ?? ansSecurity.decodeParams((route.query.p ?? '') as string)?.supplier_cd
  if (ansCommon.isEmpty(id)) {
    supplier.value = { ...initSupplier }
    focusFirstItem()
    return
  }
  api.getDetail(id).then(({ data: response }: { data: IGetSupplierDetailResponse }) => {
    supplier.value = response.data ?? ({ ...initSupplier } as ISupplier)
    if (supplier.value.supplier_cd === 0) {
      supplier.value.supplier_cd = undefined
    }
    focusFirstItem()
  })
}

const checkData = (isDelete: boolean = false) => {
  return ansValidate.isValidData(
    supplier.value,
    isDelete
      ? {
          supplier_cd: 'required'
        }
      : {
          supplier_div: 'required:checkZero',
          supplier_nm: 'required',
          supplier_kn_nm: 'katakana',
          supplier_mail_address: 'email'
        }
  )
}

const changeRoute = (id: number) => {
  router.push({
    name: 'M006',
    query: ansCommon.isEmpty(id)
      ? undefined
      : {
          p: ansSecurity.encodeParams({ supplier_cd: id })
        }
  })
}

const saveSupplier = () => {
  if (checkData()) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C001,
      callback: (ok) => {
        if (ok) {
          api.save(supplier.value).then(({ data: response }: { data: ISupplierStoreResponse }) => {
            appStore.showMessage({
              type: MsgType.SUCCESS,
              content: SysMsg.S001,
              callback: () => {
                getSupplier(response.data ?? 0)
              }
            } as IAnsMessage)
          })
        }
      }
    } as IAnsMessage)
  }
}

const deleteSupplier = () => {
  if (checkData(true)) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C002,
      callback: (ok) => {
        if (ok) {
          api.delete(supplier.value.supplier_cd).then(() => {
            appStore.showMessage({
              type: MsgType.SUCCESS,
              content: SysMsg.S002,
              callback: () => {
                getSupplier(0)
              }
            } as IAnsMessage)
          })
        }
      }
    } as IAnsMessage)
  }
}

const changeSupplierCd = (newValue?: IAnsDynamic | null) => {
  supplier.value.supplier_cd = newValue?.supplier_cd ?? 0
  getSupplier(supplier.value.supplier_cd ?? 0)
}
// ------------------------------------------------------------------------------------------------

// watch change data
// ------------------------------------------------------------------------------------------------
watch(
  () => route.query.p,
  () => {
    getSupplier()
  }
)
// ------------------------------------------------------------------------------------------------

// onCreated
// ------------------------------------------------------------------------------------------------
appStore.setHeader({
  id: 'M006',
  title: '仕入先マスタ',
  buttons: [
    {
      id: 'M006-save',
      title: '保存',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {
        saveSupplier()
      }
    },
    {
      id: 'M006-delete',
      title: '削除',
      icon: 'fa-regular fa-trash-can',
      onClickEvent: () => {
        deleteSupplier()
      }
    }
  ]
})

// get data on created
getInitData()
getSupplier()
// ------------------------------------------------------------------------------------------------
</script>

<template>
  <Panel title="仕入先情報">
    <SupplierInformation
      :supplier="supplier"
      :supplier_div="supplier_div"
      :supplier_class_div1="supplier_class_div1"
      :supplier_class_div2="supplier_class_div2"
      :supplier_class_div3="supplier_class_div3"
      :supplier_closing_div="supplier_closing_div"
      :transfer_date1="transfer_date1"
      :transfer_date2="transfer_date2"
      :changeSupplierCd="changeSupplierCd"
    />
  </Panel>
  <ActionHistory :actionHistory="supplier" />
</template>
