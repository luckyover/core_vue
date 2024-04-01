<script setup lang="ts">
/**
 * ****************************************************************************
 * @description     :   Main component for page M004 得意先マスタ
 * @created at      :   2024/02/19
 * @created by      :   ANS901 – Hainn@ans-asia.com
 * @package         :   sparkle/master
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */

import type {
  ICustomer,
  ICompany,
  IGetCustomerDetailResponse,
  IGetInitDataResponse,
  ICustomerStoreResource
} from '@/types/master/m004'
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '@/stores/app'
import api from '@/repositories/master/m004'
import _ from 'lodash'
import { MsgType, SysMsg, ansCommon, ansSecurity, ansValidate } from '@/utils'
import CustomerInformation from '@/components/master/M004/CustomerInformation.vue'
import BillingInformation from '@/components/master/M004/BillingInformation.vue'

// Declare variable
// ------------------------------------------------------------------------------------------------
const route = useRoute()
const router = useRouter()
const appStore = useAppStore()
const initCustomer: ICustomer = {
  billing_source_cd: 1,
  customer_class_div1: 0,
  customer_class_div2: 0,
  customer_class_div3: 0,
  billing_closing_div: 0,
  transfer_date1: 0,
  transfer_date2: 0,
  price_list: 0
}

const customer = ref<ICustomer>({ ...initCustomer })
const billing_source_cd = ref<Array<IOption>>([])
const customer_class_div1 = ref<Array<IOption>>([])
const customer_class_div2 = ref<Array<IOption>>([])
const customer_class_div3 = ref<Array<IOption>>([])
const billing_closing_div = ref<Array<IOption>>([])
const transfer_date1 = ref<Array<IOption>>([])
const transfer_date2 = ref<Array<IOption>>([])
const price_list = ref<Array<IOption>>([])
// ------------------------------------------------------------------------------------------------

// defined method
// ------------------------------------------------------------------------------------------------
const focusFirstItem = () => {
  document.getElementById('customer_cd')?.focus()
}
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
    transfer_date1.value = ansCommon.convertToOption(response.data?.transfer_date1)
    transfer_date2.value = ansCommon.convertToOption(response.data?.transfer_date2)
    price_list.value = ansCommon.convertToOption(response.data?.price_list)
    focusFirstItem()
  })
}

const getCustomer = (customer_cd?: number) => {
  ansValidate.removeAllErrors()
  const id = customer_cd ?? ansSecurity.decodeParams((route.query.p ?? '') as string)?.customer_cd
  if (ansCommon.isEmpty(id)) {
    customer.value = { ...initCustomer }
    focusFirstItem()
    return
  }
  api.getDetail(id).then(({ data: response }: { data: IGetCustomerDetailResponse }) => {
    customer.value = response.data ?? ({ ...initCustomer } as ICustomer)
    customer.value.customer_cd =
      customer.value.customer_cd === 0 ? undefined : customer.value.customer_cd
    focusFirstItem()
  })
}

const checkData = (isDelete: boolean = false) => {
  return ansValidate.isValidData(
    customer.value,
    isDelete
      ? {
          customer_cd: 'required'
        }
      : {
          billing_source_cd: 'required:checkZero',
          customer_nm: 'required',
          customer_kn_nm: 'katakana',
          customer_mail_address: 'email',
          billing_mail_address: 'email'
        }
  )
}

const changeRoute = (id: number) => {
  router.push({
    name: 'M004',
    query: ansCommon.isEmpty(id)
      ? undefined
      : {
          p: ansSecurity.encodeParams({ customer_cd: id })
        }
  })
}

const saveCustomer = () => {
  if (checkData()) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C001,
      callback: (ok) => {
        if (ok) {
          api.save(customer.value).then(({ data: response }: { data: ICustomerStoreResource }) => {
            appStore.showMessage({
              type: MsgType.SUCCESS,
              content: SysMsg.S001,
              callback: () => {
                getCustomer(response.data)
              }
            } as IAnsMessage)
          })
        }
      }
    } as IAnsMessage)
  }
}

const deleteCustomer = () => {
  if (checkData(true)) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C002,
      callback: (ok) => {
        if (ok) {
          api.delete(customer.value.customer_cd).then(() => {
            appStore.showMessage({
              type: MsgType.SUCCESS,
              content: SysMsg.S002,
              callback: () => {
                getCustomer()
              }
            } as IAnsMessage)
          })
        }
      }
    } as IAnsMessage)
  }
}

const changeCustomerCd = (newValue?: IAnsDynamic | null) => {
  customer.value.customer_cd = newValue?.customer_cd ?? 0
  getCustomer(customer.value.customer_cd ?? 0)
}

// ------------------------------------------------------------------------------------------------

// watch change data
// ------------------------------------------------------------------------------------------------
watch(
  () => route.query.p,
  () => {
    getCustomer()
  }
)
// ------------------------------------------------------------------------------------------------

// onCreated
// ------------------------------------------------------------------------------------------------
appStore.setHeader({
  id: 'M004',
  title: '得意先マスタ',
  buttons: [
    {
      id: 'M004-save',
      title: '保存',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {
        saveCustomer()
      }
    },
    {
      id: 'M004-delete',
      title: '削除',
      icon: 'fa-regular fa-trash-can',
      onClickEvent: () => {
        deleteCustomer()
      }
    }
  ]
})

// get data on created
getInitData()
getCustomer()
// ------------------------------------------------------------------------------------------------
</script>

<template>
  <Panel title="得意先情報">
    <CustomerInformation
      :customer="customer"
      :billing_source_cd="billing_source_cd"
      :customer_class_div1="customer_class_div1"
      :customer_class_div2="customer_class_div2"
      :customer_class_div3="customer_class_div3"
      :changeCustomerCd="changeCustomerCd"
    />
    <BillingInformation
      :billing="customer"
      :billing_closing_div="billing_closing_div"
      :transfer_date1="transfer_date1"
      :transfer_date2="transfer_date2"
      :price_list="price_list"
    />
  </Panel>
  <ActionHistory :actionHistory="customer" />
</template>
