<script setup lang="ts">
import { ref, watch, computed, onMounted } from 'vue'
import { v4 } from 'uuid'

const props = withDefaults(defineProps<IAnsTooltipSpanProps>(), {
  value: ''
})

const uuid = v4()
const showTooltip = ref(false)
const itemId = computed(() => {
  return uuid
})

const checkShowTooltip = () => {
  const item = document.getElementById(itemId.value)
  if (item && item.scrollWidth > item.clientWidth) {
    showTooltip.value = true
  } else {
    showTooltip.value = false
  }
}

watch(
  () => props.value,
  () => {
    setTimeout(() => {
      checkShowTooltip()
    }, 100)
  }
)

onMounted(() => {
  setTimeout(() => {
    checkShowTooltip()
  }, 300)
})
</script>

<template>
  <span class="tooltip-container" :id="itemId">
    {{ value }}
  </span>
  <b-tooltip
    :target="itemId"
    :delay="0"
    :no-fade="true"
    v-if="showTooltip"
    boundary="document"
    container="body"
  >
    {{ value }}
  </b-tooltip>
</template>
