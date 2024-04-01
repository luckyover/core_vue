<script setup lang="ts">
import type { ISearchConditionProps } from '@/types/master/m101'
import { computed } from 'vue'
const props = withDefaults(defineProps<ISearchConditionProps>(), {})
const supplier = computed(() => {
  return {
    supplier_cd: props.condition.inq_supplier_cd,
    supplier_nm: props.condition.inq_supplier_nm
  }
})
const changeSupplierCd = (newValue?: IAnsDynamic) => {
  props.condition.inq_supplier_cd = newValue?.supplier_cd ?? ''
  props.condition.inq_supplier_nm = newValue?.supplier_nm ?? ''
}
</script>

<template>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="商品コード"
        id="inq_item_cd"
        :maxLength="50"
        v-model="condition.inq_item_cd"
      />
    </div>
    <div class="col-md-3">
      <AnsInput label="商品名" id="inq_item_nm" :maxLength="50" v-model="condition.inq_item_nm" />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="色コード"
        id="inq_color_cd"
        :maxLength="10"
        v-model="condition.inq_color_cd"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="色名"
        id="inq_supplier_ab_nm"
        :maxLength="30"
        v-model="condition.inq_color_nm"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect
        label="商品分類"
        id="inq_item_class_div"
        v-model="condition.inq_item_class_div"
        :isDisabled="condition.disable_item_class_div"
        :options="item_class_div"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="加工種別"
        id="inq_process_div"
        v-model="condition.inq_process_div"
        :options="process_div"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="カテゴリー"
        id="inq_category_div"
        v-model="condition.inq_category_div"
        :options="category_div"
      />
    </div>
    <div class="col-md-3">
      <AnsInputSearch
        label="仕入先"
        id="inq_supplier_cd"
        :value="supplier"
        propertyForId="supplier_cd"
        propertyForName="supplier_nm"
        :maxLength="50"
        :isShowNameInLabel="true"
        pageSearch="M006L"
        :onChangeEvent="changeSupplierCd"
      />
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <button type="button" class="btn btn-primary btn-search ml-3" @click="onSearch">
        <i class="fas fa-search"></i>検索
      </button>
      <button type="button" class="btn btn-primary btn-clear-search" @click="onClear">
        <i class="fa-solid fa-eraser"></i>クリア
      </button>
    </div>
  </div>
</template>
