<script setup lang="ts">
import { computed } from 'vue'
import { ansCommon } from '@/utils'

const props = withDefaults(defineProps<IActionHistoryProps>(), {})
const isShow = computed(() => {
  return (
    !ansCommon.isEmpty(props.actionHistory.cre_user_cd) ||
    !ansCommon.isEmpty(props.actionHistory.cre_tm) ||
    !ansCommon.isEmpty(props.actionHistory.upd_user_cd) ||
    !ansCommon.isEmpty(props.actionHistory.upd_tm) ||
    (props.buttons && props.buttons.length > 0)
  )
})
</script>

<template>
  <div class="action-history" v-if="isShow">
    <div class="row">
      <div class="col-sm-6">
        <div class="footer-buttons text-start" v-if="props.buttons && props.buttons.length > 0">
          <template v-for="(btn, idx) in buttons" :key="idx">
            <router-link class="btn btn-primary" v-if="btn.href" :to="btn.href">{{
              btn.title
            }}</router-link>
            <button class="btn btn-primary" type="button" v-else @click="btn.onClickEvent">
              {{ btn.title }}
            </button>
          </template>
        </div>
      </div>
      <div class="col-sm-6" :class="{ 'have-btn': props.buttons && props.buttons.length > 0 }">
        <div class="text-end">
          <span class="show-info" v-if="!ansCommon.isEmpty(actionHistory.cre_user_cd)">
            <span class="info-label">登録者：</span>
            <span class="info-value"
              >{{ actionHistory.cre_user_cd
              }}<span v-if="!ansCommon.isEmpty(actionHistory.cre_user_nm)"
                >:{{ actionHistory.cre_user_nm }}</span
              ></span
            >
          </span>
          <span class="show-info" v-if="!ansCommon.isEmpty(actionHistory.cre_tm)">
            <span class="info-label">登録日時：</span>
            <span class="info-value">{{ actionHistory.cre_tm }}</span>
          </span>
          <span class="show-info" v-if="!ansCommon.isEmpty(actionHistory.upd_user_cd)">
            <span class="info-label">更新者：</span>
            <span class="info-value"
              >{{ actionHistory.upd_user_cd
              }}<span v-if="!ansCommon.isEmpty(actionHistory.upd_user_nm)"
                >:{{ actionHistory.upd_user_nm }}</span
              ></span
            >
          </span>
          <span class="show-info" v-if="!ansCommon.isEmpty(actionHistory.upd_tm)">
            <span class="info-label">更新日時：</span>
            <span class="info-value">{{ actionHistory.upd_tm }}</span>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
