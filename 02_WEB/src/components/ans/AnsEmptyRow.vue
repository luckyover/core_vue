<script setup lang="ts">
import { ansCommon } from '@/utils'
const props = withDefaults(defineProps<IEmptyRowProps>(), {})
</script>

<template v-if="!list || list.length === 0">
  <tr v-if="ansCommon.isEmpty(condition) || !condition?.has_search">
    <td class="text-center" :colspan="colspan ?? 1">検索条件を設定してください。</td>
  </tr>
  <tr v-else-if="!list || list.length === 0">
    <td class="text-center" :colspan="colspan ?? 1">該当データが存在しません。</td>
  </tr>
</template>
