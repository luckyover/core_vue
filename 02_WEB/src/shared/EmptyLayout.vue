<script setup lang="ts">
import { RouterView } from 'vue-router'
import Loading from '@/components/Loading.vue'
import AnsMessage from '@/components/ans/AnsMessage.vue'
</script>

<template>
  <div id="body" class="body">
    <RouterView />
    <Loading />
    <AnsMessage />
  </div>
</template>
