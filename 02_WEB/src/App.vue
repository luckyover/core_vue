<script setup lang="ts">
import { useRoute } from 'vue-router'
import { shallowRef, watch } from 'vue'
import { useAppStore } from '@/stores/app'
import Layout from '@/shared/Layout.vue'

const layout = shallowRef(Layout)
const route = useRoute()
const appStore = useAppStore()

watch(route, (to) => {
  let _layout = Layout
  if (to.meta.layout) {
    _layout = to.meta.layout as typeof Layout
  }
  if (_layout != layout.value) {
    layout.value = _layout
  }
  if (!to.meta.noAppState) {
    appStore.getAppState()
  }
  appStore.hideMessage()
  appStore.removeErrors()
  appStore.setHeader({
    id: '',
    title: ''
  } as IAnsHeader)
})

const addEventForItem = (e: Node) => {
  const elm = e as HTMLElement
}

const removeEventForItem = (e: Node) => {
  const elm = e as HTMLElement
}
const observer = new MutationObserver((mutationList) =>
  mutationList
    .filter((m) => m.type === 'childList')
    .forEach((m) => {
      m.addedNodes.forEach(addEventForItem)
      m.removedNodes.forEach(removeEventForItem)
    })
)
observer.observe(document, { childList: true, subtree: true })
</script>

<template>
  <Suspense>
    <component :is="layout" />
  </Suspense>
</template>

<style lang="scss">
@import '@assets/scss/common.scss';
</style>
