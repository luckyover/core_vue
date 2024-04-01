<script setup lang="ts">
import { computed } from 'vue'
import type { ISizesPrice, ISearchConditionProps } from '@/types/master/m201'
const props = withDefaults(defineProps<ISearchConditionProps>(), {})
</script>

<template>
  <div class="row form-group">
    <div class="col-md-3">
      <AnsInput
        label="商品コード"
        id="item_cd"
        type="text"
        propertyForId="item_cd"
        v-model="condition.item_cd"
        :maxLength="30"
        :isShowNameInLabel="true"
        pageSearch="M101L"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="色コード"
        id="color_cd"
        type="text"
        :maxLength="10"
        v-model="condition.color_cd"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="商品名"
        id="item_nm"
        type="text"
        :maxLength="255"
        v-model="condition.item_nm"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect
        label="価格表区分"
        id="price_list"
        v-model="condition.price_list"
        :options="price_list"
      />
    </div>
  </div>
</template>
