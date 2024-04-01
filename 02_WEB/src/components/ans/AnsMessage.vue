<script setup lang="ts">
import { ref, computed } from 'vue'
import { storeToRefs } from 'pinia'

import { useAppStore } from '@/stores/app'
import { MsgType } from '@/utils/messages'
import { ansCommon } from '@/utils'
const store = useAppStore()
const btnOk = ref<HTMLButtonElement>()
const { isShowMessage, message } = storeToRefs(store)
const showCancel = computed(() => {
  return message.value?.type === MsgType.CONFIRM || message.value?.type === MsgType.WARNING
})
const icon = computed(() => {
  return message.value.type === MsgType.CONFIRM
    ? 'fas fa-question-circle'
    : message.value.type === MsgType.WARNING
      ? 'fas fa-exclamation-triangle'
      : message.value.type === MsgType.SUCCESS
        ? 'fas fa-check-circle'
        : 'fas fa-exclamation-circle'
})
const headerTitle = computed(() => {
  return !ansCommon.isEmpty(message.value?.title)
    ? message.value?.title
    : message.value.type === MsgType.CONFIRM
      ? '確認'
      : message.value.type === MsgType.WARNING
        ? '警告'
        : message.value.type === MsgType.SUCCESS
          ? '成功'
          : '確認'
})
const onClickOk = (payload: MouseEvent) => {
  const callback = message.value?.callback
  store.hideMessage()
  if (callback) {
    setTimeout(() => {
      callback(true)
    }, 300)
  }
}
const onClickCancel = (payload: MouseEvent) => {
  const callback = message.value?.callback
  store.hideMessage()
  if (callback) {
    setTimeout(() => {
      callback(false)
    }, 300)
  }
}
const onShow = () => {
  setTimeout(() => {
    btnOk.value?.focus()
  }, 300)
}
</script>

<template>
  <b-modal
    v-model="isShowMessage"
    hide-header
    hide-footer
    class="modal-six modal-message"
    :no-close-on-esc="true"
    :no-close-on-backdrop="true"
    centered
    @show="onShow"
  >
    <div class="message-header">
      <i class="header-icon" :class="icon"></i>
      <span class="header-title" v-html="headerTitle"></span>
    </div>
    <div class="content">
      <p class="text-center message-content" v-html="message.content"></p>
    </div>
    <div class="modal-footer flex-nowrap justify-content-end">
      <button
        type="button"
        ref="btnOk"
        class="text-center btn btn-primary btn-sm btn-action btn-ok"
        @click="onClickOk"
        v-html="message.okText"
      ></button>
      <button
        type="button"
        class="text-center btn btn-primary btn-sm btn-action btn-cancel"
        @click="onClickCancel"
        v-if="showCancel"
        v-html="message.cancelText"
      ></button>
    </div>
  </b-modal>
</template>
