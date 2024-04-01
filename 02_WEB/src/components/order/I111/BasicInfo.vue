<script setup lang="ts">
import type { IBasicInfoProps } from '@/types/order/i111'
import { ref } from 'vue'

const props = withDefaults(defineProps<IBasicInfoProps>(), {})
const date = ref('')
</script>

<template>
  <AnsDatePicker v-model="date" />
</template>
