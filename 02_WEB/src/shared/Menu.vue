<script setup lang="ts">
import { useRoute } from 'vue-router'
import _ from 'lodash'
import { storeToRefs } from 'pinia'
import { useAppStore } from '@/stores/app'
import { watch } from 'vue'
import { ansCommon } from '@/utils'

const route = useRoute()
const appStore = useAppStore()
const { profile, menus } = storeToRefs(appStore)

const activeLink = (path: string) => {
  for (let i = 0; i < menus.value.length; i++) {
    let isActive = false
    if (path === menus.value[i].url) {
      isActive = true
    }
    for (let j = 0; j < (menus.value[i].items?.length ?? 0); j++) {
      if (path === _.get(menus.value[i], `items.${j}.url`, '')) {
        _.set(menus.value[i], `items.${j}.isActive`, true)
        isActive = true
      } else {
        _.set(menus.value[i], `items.${j}.isActive`, false)
      }
    }
    menus.value[i].isActive = isActive
  }
}

watch(route, (to) => {
  activeLink(to.path)
})

watch(menus, () => {
  activeLink(window.location.pathname)
})
</script>
<template>
  <section id="menu" v-if="!ansCommon.isEmpty(profile?.user_cd)">
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav left">
          <template v-for="(item, idx) in menus">
            <li
              class="nav-item"
              :class="{ active: item.isActive }"
              v-if="item.items && item.items.length > 0"
            >
              <b-dropdown :id="`menu-${item.id}`" :text="item.title" :class="`btn-menu`">
                <template v-for="(m, i) in item.items">
                  <b-dropdown-item>
                    <router-link
                      :id="`menu-${m.id}`"
                      :to="m.url ?? '#'"
                      :class="{ active: m.isActive }"
                    >
                      {{ m.title }}
                    </router-link>
                  </b-dropdown-item>
                </template>
              </b-dropdown>
            </li>
            <li class="nav-item" :class="{ active: item.isActive }" v-else>
              <router-link :id="`menu-${item.id}`" :to="item.url ?? '#'" class="nav-link">
                {{ item.title }}
              </router-link>
            </li>
          </template>
        </ul>
        <ul class="navbar-nav nav-right">
          <li class="nav-item">
            <b-dropdown
              :id="`menu-profile`"
              :text="`${profile?.user_cd ?? ''}:${profile?.user_nm ?? ''}`"
              v-if="profile"
            >
              <b-dropdown-item>
                <router-link :id="`menu-change-password`" :to="'#'">
                  <i class="fa fa-key" aria-hidden="true"></i>
                  パスワード変更
                </router-link>
              </b-dropdown-item>
              <b-dropdown-divider></b-dropdown-divider>
              <b-dropdown-item>
                <router-link :id="`menu-change-password`" :to="'/logout'">
                  <i class="fa fa-sign-out" aria-hidden="true"></i>
                  ログアウト
                </router-link>
              </b-dropdown-item>
            </b-dropdown>
          </li>
        </ul>
      </div>
    </nav>
  </section>
</template>
