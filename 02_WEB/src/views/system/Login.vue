<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import moment from 'moment'
import type { IAccount, ICheckAccountResponse } from '@/types/system/login'
import api from '@/repositories/system/login'
import { ansValidate } from '@/utils'
import { useAppStore } from '@/stores/app'

const router = useRouter()
const appStore = useAppStore()
appStore.setHeader({
  id: 'Login',
  title: 'ログイン',
  buttons: []
})
const redirecting = ref(false)
const account = ref<IAccount>({})
const validRules: IAnsValidateRule = {
  username: 'required',
  password: 'required'
}

const login = () => {
  if (!ansValidate.isValidData(account.value, validRules)) {
    return
  }
  api.login(account.value).then(({ data: response }: { data: ICheckAccountResponse }) => {
    localStorage.setItem('token', response.data?.token ?? '')
    localStorage.setItem(
      'tokenTimeout',
      moment()
        .add(response.data?.timeout ?? '', 'minute')
        .format('YYYY-MM-DD HH:mm:ss')
    )
    redirecting.value = true
    router.push({
      name: 'Home'
    })
  })
}
</script>
<style lang="scss">
@import url('@/assets/scss/system/login.scss');
</style>
<template>
  <div class="form-signin justify-content-center text-center" v-if="!redirecting">
    <AnsInput
      :maxLength="20"
      placeholder="ユーザーコード"
      id="username"
      v-model="account.username"
    />
    <AnsInput
      type="password"
      placeholder="パスワード"
      :maxLength="20"
      id="password"
      v-model="account.password"
    />
    <button class="btn btn-primary btn-login" type="button" @click="login">ログイン</button>
  </div>
</template>
