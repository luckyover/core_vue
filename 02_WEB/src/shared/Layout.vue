<script setup lang="ts">
import { watch, onMounted } from 'vue'
import { RouterView, useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'
import { useAppStore } from '@/stores/app'

import Loading from '@/components/Loading.vue'
import AnsMessage from '@/components/ans/AnsMessage.vue'

import Header from './Header.vue'
import Footer from './Footer.vue'
import _ from 'lodash'
import type { IAnsFunction } from '@/types/app'
import { ansCommon, ansIdentity } from '@/utils'

const appStore = useAppStore()
const router = useRouter()
const { menus, functions } = storeToRefs(appStore)

const paddingContent = () => {
  const wrapper = document.getElementById('wrapper')
  const header = document.getElementById('header')
  if (wrapper && header) {
    wrapper.style.paddingTop = `${header.clientHeight}px`
  }
}

watch(menus, () => {
  setTimeout(() => {
    paddingContent()
  }, 50)
})

watch(functions, () => {
  const fnc = _.find(functions.value, (x: IAnsFunction) => {
    return x.prg_url === window.location.pathname && ansIdentity.isViewFnc(x)
  })
  if (fnc && fnc.fnc_use_div !== true) {
    localStorage.setItem('beforeUrl', window.location.pathname)
    router.push('/403')
  }
})

onMounted(() => {
  window.removeEventListener('resize', paddingContent)
  window.addEventListener('resize', paddingContent)
  paddingContent()
})
</script>

<template>
  <div id="body" class="body">
    <Header />
    <div id="wrapper">
      <div class="page-content-wrapper container-fluid">
        <RouterView />
      </div>
    </div>
    <AnsMessage />
    <Loading />
    <Footer />
  </div>
</template>
