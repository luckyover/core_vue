<script setup lang="ts">
import { ref, onUpdated, onMounted } from 'vue'

const showSecondScroll = ref(false)
const divNeedScroll = ref<HTMLDivElement>()
const divContainer = ref<HTMLDivElement>()
const divSecondScrollContent = ref<HTMLDivElement>()
const divSecondScroll = ref<HTMLDivElement>()

const scrollContainer = () => {
  if (divSecondScroll.value) {
    divSecondScroll.value.scrollLeft = divContainer.value?.scrollLeft ?? 0
  }
}

const scrollSecondDiv = () => {
  if (divContainer.value) {
    divContainer.value.scrollLeft = divSecondScroll.value?.scrollLeft ?? 0
  }
}

const addEventScroll = () => {
  if (divContainer.value) {
    divContainer.value?.removeEventListener('scroll', scrollContainer)
    divContainer.value?.addEventListener('scroll', scrollContainer)
  }
  if (divSecondScroll.value) {
    divSecondScroll.value?.removeEventListener('scroll', scrollSecondDiv)
    divSecondScroll.value?.addEventListener('scroll', scrollSecondDiv)
  }
}
const checkShowTwoScroll = () => {
  if (divContainer.value && divContainer.value.scrollWidth > divContainer.value.clientWidth) {
    showSecondScroll.value = true
    if (divSecondScrollContent.value) {
      divSecondScrollContent.value.style.width = `${divNeedScroll.value?.scrollWidth ?? 0}px`
    }
    const scrollBarWidth = divContainer.value.offsetWidth - divContainer.value.clientWidth
    if (divSecondScroll.value && scrollBarWidth > 0) {
      divSecondScroll.value.style.width = `calc(100% - ${scrollBarWidth}px)`
    }
    addEventScroll()
  } else {
    showSecondScroll.value = false
  }
}

const addEvent = () => {
  divNeedScroll.value?.removeEventListener('resize', checkShowTwoScroll)
  divNeedScroll.value?.addEventListener('resize', checkShowTwoScroll)
  checkShowTwoScroll()
}

onUpdated(() => {
  addEvent()
})

onMounted(() => {
  setTimeout(() => {
    addEvent()
  }, 100)
})
</script>

<template>
  <div class="two-scroll-div">
    <div class="second-scroll" ref="divSecondScroll" v-if="showSecondScroll">
      <div class="second-scroll-content" style="height: 1px" ref="divSecondScrollContent"></div>
    </div>
    <div class="table-responsive" ref="divContainer">
      <div ref="divNeedScroll">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
