<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { v4 } from 'uuid'
import { ansCommon } from '@/utils'

const props = withDefaults(defineProps<IPanelProps>(), {})
const uuid = v4()
const visible = ref<boolean>(props.isDefaultHide ? false : true)
const inputId = computed(() => {
  return ansCommon.isEmpty(props.id) ? uuid : props.id
})

onMounted(() => {
  if (props.triggerClose) {
    props.triggerClose(() => {
      visible.value = false
    })
  }
})
</script>

<template>
  <div class="card ans-card">
    <div class="card-body">
      <div class="row" v-if="!ansCommon.isEmpty(props.title)">
        <div
          class="line-border-bottom"
          :class="{ pointer: props.canCollapse }"
          v-b-toggle="props.canCollapse ? inputId : ''"
        >
          <label>{{ props.title }} </label>
          <ul v-if="props.canCollapse">
            <li>
              <i class="fa fa-angle-down" v-if="visible"></i>
              <i class="fa fa-angle-up" v-else></i>
            </li>
          </ul>
        </div>
      </div>
      <b-collapse v-model="visible" :id="inputId">
        <slot></slot>
      </b-collapse>
    </div>
  </div>
</template>
