<script setup lang="ts">
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'
import { useAppStore } from '@/stores/app'
import { ansCommon } from '@/utils'

import Menu from './Menu.vue'

const appStore = useAppStore()
const router = useRouter()
const { header } = storeToRefs(appStore)
const titleStyle = computed(() => {
  return ansCommon.isEmpty(header.value.titleColor)
    ? {
        color: '#000'
      }
    : {
        backgroundColor: header.value.titleColor,
        color: '#fff',
        width: '240px'
      }
})

const back = (e: MouseEvent) => {
  router.back()
}
</script>
<template>
  <section id="header">
    <Menu />
    <section id="main-header">
      <table class="header-table-top navbar-expand-md">
        <tbody>
          <tr>
            <td :style="titleStyle">
              <span class="screen-name">{{ header.title }}</span>
            </td>
            <td>
              <ul class="navbar-nav nav-btn">
                <template v-for="(btn, idx) in header.buttons">
                  <li class="nav-item icon-text">
                    <router-link
                      :id="btn.id"
                      class="btn btn-link"
                      :to="btn.href ?? '#'"
                      v-if="btn.href"
                    >
                      <div class="icon-container">
                        <i :class="btn.icon"></i>
                      </div>
                      <div class="text-container">
                        <span>{{ btn.title }}</span>
                      </div>
                    </router-link>
                    <a
                      type="button"
                      :id="btn.id"
                      class="btn btn-link"
                      v-else
                      href="javascript:void(0);"
                      @click="btn.onClickEvent"
                    >
                      <div class="icon-container">
                        <i :class="btn.icon"></i>
                      </div>
                      <div class="text-container">
                        <span>{{ btn.title }}</span>
                      </div>
                    </a>
                  </li>
                </template>
                <li class="nav-item icon-text">
                  <a
                    type="button"
                    id="btn-back"
                    class="btn btn-link"
                    href="javascript:void(0);"
                    @click="back"
                  >
                    <div class="icon-container">
                      <i class="fa fa-mail-reply"></i>
                    </div>
                    <div class="text-container">
                      <span>戻る</span>
                    </div>
                  </a>
                </li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </section>
</template>
