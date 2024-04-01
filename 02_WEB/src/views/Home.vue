<script setup lang="ts">
import { useAppStore } from '@/stores/app'
import { useRoute, useRouter } from 'vue-router'
import type { IAnsFunction } from '@/types/app'
import _ from 'lodash'
import { ansCommon, ansIdentity } from '@/utils'

const router = useRouter()
const route = useRoute()
const appStore = useAppStore()
appStore.showLoading()
await appStore.getAppState()
appStore.hideLoading()
if (ansCommon.isEmpty(appStore.profile?.user_cd)) {
  localStorage.removeItem('token')
  localStorage.removeItem('tokenTimeout')
  router.push('/login')
}
const beforeUrl = localStorage.getItem('beforeUrl') ?? ''
const canAccess = (fnc: IAnsFunction) => {
  return fnc.fnc_use_div === true && ansIdentity.isViewFnc(fnc)
}
localStorage.removeItem('beforeUrl')
let fnc = _.find(appStore.functions ?? [], (x: IAnsFunction) => {
  return x.prg_url === beforeUrl && canAccess(x)
})
if (!fnc) {
  fnc = _.find(appStore.functions ?? [], (x: IAnsFunction) => {
    return x.prg_url === '/estimate/l001' && canAccess(x)
  })
}
if (!fnc) {
  fnc = _.find(appStore.functions ?? [], (x: IAnsFunction) => {
    return canAccess(x)
  })
}
if (fnc && fnc.prg_url) {
  router.push(fnc.prg_url)
} else {
  if (route.query.redirect === 'login') {
    localStorage.removeItem('token')
    localStorage.removeItem('tokenTimeout')
    router.push('/login')
  } else {
    router.push('/403')
  }
}
</script>

<template></template>
