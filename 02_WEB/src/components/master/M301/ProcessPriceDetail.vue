<script setup lang="ts">
import { computed } from 'vue'
import type { IProcessPrice, ISearchConditionProps } from '@/types/master/m301'
import { ItemClassDiv } from '@/utils/nameDiv'
const props = withDefaults(defineProps<ISearchConditionProps>(), {})
</script>

<template>
  <div class="row form-group">
    <div class="col-md-3">
      <AnsInput
        label="商品コード"
        id="item_cd"
        type="text"
        :maxLength="30"
        v-model="condition.item_cd"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="商品名"
        id="item_nm"
        type="text"
        :maxLength="50"
        v-model="condition.item_nm"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect
        label="カテゴリー"
        id="category_div"
        v-model="condition.category_div"
        :options="category_div"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="素材"
        id="material_div"
        v-model="condition.material_div"
        :options="material_div"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="加工箇所"
        id="processing_place_div"
        v-model="condition.processing_location_div"
        :options="processing_location_div"
      />
    </div>
  </div>
</template>
