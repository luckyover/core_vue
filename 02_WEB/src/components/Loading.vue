<script setup lang="ts">
import { storeToRefs } from 'pinia'
import { useAppStore } from '@/stores/app'
const store = useAppStore()
const { isNoLoading, isLoading, isForceLoading } = storeToRefs(store)
</script>

<template>
  <div class="loading" v-if="!isNoLoading && (isLoading || isForceLoading)">
    <div class="loading-bg"></div>
    <img :src="'/img/loading.gif'" alt="Loading..." />
  </div>
</template>
