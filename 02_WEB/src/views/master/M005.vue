<script setup lang="ts">
/**
 * ****************************************************************************
 * @description     :   Main component for page M005 納品先マスタ
 * @created at      :   2024/02/19
 * @created by      :   ANS902 – quanlh@ans-asia.com
 * @package         :   sparkle/master
 * @copyright       :   Copyright (c) A.N.S Asia
 * @version         :   1.0.0
 * ****************************************************************************
 */

import type {
  IGetDeliveryDetailResponse,
  IDelivery,
  IDeliveryStoreResponse
} from '@/types/master/m005'
import { ref, watch, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '@/stores/app'
import api from '@/repositories/master/m005'
import _ from 'lodash'
import { MsgType, SysMsg, ansCommon, ansNumber, ansSecurity, ansValidate } from '@/utils'
import DeliveryInformation from '@/components/master/M005/DeliveryInformation.vue'

// Declare variable
// ------------------------------------------------------------------------------------------------
const route = useRoute()
const router = useRouter()
const appStore = useAppStore()
const initDelivery: IDelivery = {}
const delivery = ref<IDelivery>({ ...initDelivery })
// ------------------------------------------------------------------------------------------------
// defined method
// ------------------------------------------------------------------------------------------------
const focusFirstItem = () => {
  document.getElementById('delivery_cd')?.focus()
}
const getDelivery = (delivery_cd?: number) => {
  ansValidate.removeAllErrors()
  const id = delivery_cd ?? ansSecurity.decodeParams((route.query.p ?? '') as string)?.delivery_cd
  if (ansCommon.isEmpty(id)) {
    delivery.value = { ...initDelivery }
    focusFirstItem()
    return
  }
  api.getDetail(id).then(({ data: response }: { data: IGetDeliveryDetailResponse }) => {
    delivery.value = response.data ?? ({ ...initDelivery } as IDelivery)
    if (delivery.value.delivery_cd === 0) {
      delivery.value.delivery_cd = undefined
    }
    focusFirstItem()
  })
}

const checkData = (isDelete: boolean = false) => {
  return ansValidate.isValidData(
    delivery.value,
    isDelete
      ? {
          delivery_cd: 'required'
        }
      : {
          delivery_nm: 'required',
          delivery_kn_nm: 'katakana',
          delivery_mail_address: 'email'
        }
  )
}

const changeRoute = (id: number) => {
  router.push({
    name: 'M005',
    query: ansCommon.isEmpty(id)
      ? undefined
      : {
          p: ansSecurity.encodeParams({ delivery_cd: id })
        }
  })
}

const saveDelivery = () => {
  if (checkData()) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C001,
      callback: (ok) => {
        if (ok) {
          api.save(delivery.value).then(({ data: response }: { data: IDeliveryStoreResponse }) => {
            appStore.showMessage({
              type: MsgType.SUCCESS,
              content: SysMsg.S001,
              callback: () => {
                getDelivery(ansNumber.toNumber(response.data))
              }
            } as IAnsMessage)
          })
        }
      }
    } as IAnsMessage)
  }
}

const deleteDelivery = () => {
  if (checkData(true)) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C002,
      callback: (ok) => {
        if (ok) {
          api.delete(delivery.value.delivery_cd).then(() => {
            appStore.showMessage({
              type: MsgType.SUCCESS,
              content: SysMsg.S002,
              callback: () => {
                getDelivery(0)
              }
            } as IAnsMessage)
          })
        }
      }
    } as IAnsMessage)
  }
}

const changeDeliveryCd = (newValue?: IAnsDynamic | null) => {
  delivery.value.delivery_cd = newValue?.delivery_cd ?? ''
  getDelivery(delivery.value.delivery_cd ?? 0)
}
// ------------------------------------------------------------------------------------------------

// watch change data
// ------------------------------------------------------------------------------------------------
watch(
  () => route.query.p,
  () => {
    getDelivery()
  }
)
// ------------------------------------------------------------------------------------------------

// onCreated
// ------------------------------------------------------------------------------------------------
appStore.setHeader({
  id: 'M005',
  title: '納品先マスタ',
  buttons: [
    {
      id: 'M005-save',
      title: '保存',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {
        saveDelivery()
      }
    },
    {
      id: 'M005-delete',
      title: '削除',
      icon: 'fa-regular fa-trash-can',
      onClickEvent: () => {
        deleteDelivery()
      }
    }
  ]
})

onMounted(() => {
  setTimeout(() => {
    focusFirstItem()
  }, 300)
})
// ------------------------------------------------------------------------------------------------
</script>

<template>
  <Panel title="納品先情報">
    <DeliveryInformation :delivery="delivery" :changeDeliveryCd="changeDeliveryCd" />
  </Panel>
  <ActionHistory :actionHistory="delivery" />
</template>
