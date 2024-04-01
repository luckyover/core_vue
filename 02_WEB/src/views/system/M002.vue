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

import type { IGetInitDataResponse, IGetUserDetailResponse, IUser } from '@/types/system/m002'
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '@/stores/app'
import api from '@/repositories/system/m002'
import _ from 'lodash'
import { MsgType, SysMsg, ansCommon, ansSecurity, ansValidate } from '@/utils'
import UserInformation from '@/components/system/M002/UserInformation.vue'

// Declare variable
// ------------------------------------------------------------------------------------------------
const route = useRoute()
const router = useRouter()
const appStore = useAppStore()
const initUser: IUser = {
  belong_department_div: 0,
  authority_div: 0
}
const user = ref<IUser>({ ...initUser })
const belong_department_div = ref<Array<IOption>>([])
const authority_div = ref<Array<IOption>>([])
// ------------------------------------------------------------------------------------------------

// defined method
// ------------------------------------------------------------------------------------------------
const focusFirstItem = () => {
  document.getElementById('user_cd')?.focus()
}
const getInitData = () => {
  api.getInitData().then(({ data: response }: { data: IGetInitDataResponse }) => {
    belong_department_div.value = ansCommon.convertToOption(response.data?.belong_department_div)
    authority_div.value = ansCommon.convertToOption(response.data?.authority_div)
    focusFirstItem()
  })
}

const getUser = (user_cd?: string) => {
  ansValidate.removeAllErrors()
  const id = user_cd ?? ansSecurity.decodeParams((route.query.p ?? '') as string)?.user_cd
  if (ansCommon.isEmpty(id)) {
    user.value = { ...initUser }
    focusFirstItem()
    return
  }
  api.getDetail(id).then(({ data: response }: { data: IGetUserDetailResponse }) => {
    user.value = response.data ?? ({ ...initUser } as IUser)
    user.value.user_cd = id
    focusFirstItem()
  })
}

const checkData = (isDelete: boolean = false) => {
  return ansValidate.isValidData(
    user.value,
    isDelete
      ? {
          user_cd: 'required'
        }
      : {
          user_cd: 'required',
          password: 'required',
          user_nm: 'required',
          user_kn_nm: 'katakana',
          mailaddress: 'email'
        }
  )
}

const changeRoute = (id: string) => {
  router.push({
    name: 'M002',
    query: ansCommon.isEmpty(id)
      ? undefined
      : {
          p: ansSecurity.encodeParams({ user_cd: id })
        }
  })
}

const saveUser = () => {
  if (checkData()) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C001,
      callback: (ok) => {
        if (ok) {
          api.save(user.value).then(() => {
            appStore.showMessage({
              type: MsgType.SUCCESS,
              content: SysMsg.S001,
              callback: () => {
                getUser(user.value.user_cd ?? '')
                if (appStore.profile?.user_cd === user.value.user_cd) {
                  appStore.getAppState()
                }
              }
            } as IAnsMessage)
          })
        }
      }
    } as IAnsMessage)
  }
}

const deleteUser = () => {
  if (checkData(true)) {
    appStore.showMessage({
      type: MsgType.CONFIRM,
      content: SysMsg.C002,
      callback: (ok) => {
        if (ok) {
          api.delete(user.value.user_cd).then(() => {
            appStore.showMessage({
              type: MsgType.SUCCESS,
              content: SysMsg.S002,
              callback: () => {
                getUser('')
              }
            } as IAnsMessage)
          })
        }
      }
    } as IAnsMessage)
  }
}

const changeUserCd = (newValue?: IAnsDynamic | null) => {
  user.value.user_cd = newValue?.user_cd ?? ''
  getUser(user.value.user_cd ?? '')
}
// ------------------------------------------------------------------------------------------------

// watch change data
// ------------------------------------------------------------------------------------------------
watch(
  () => route.query.p,
  () => {
    getUser()
  }
)
// ------------------------------------------------------------------------------------------------

// onCreated
// ------------------------------------------------------------------------------------------------
appStore.setHeader({
  id: 'M002',
  title: 'ユーザーマスタ',
  buttons: [
    {
      id: 'M002-save',
      title: '保存',
      icon: 'fa-regular fa-floppy-disk',
      onClickEvent: () => {
        saveUser()
      }
    },
    {
      id: 'M002-delete',
      title: '削除',
      icon: 'fa-regular fa-trash-can',
      onClickEvent: () => {
        deleteUser()
      }
    }
  ]
})

// get data on created
getInitData()
getUser()
// ------------------------------------------------------------------------------------------------
</script>

<template>
  <Panel title="ユーザー情報">
    <UserInformation
      :user="user"
      :belong_department_div="belong_department_div"
      :authority_div="authority_div"
      :changeUserCd="changeUserCd"
    />
  </Panel>
  <ActionHistory :actionHistory="user" />
</template>
