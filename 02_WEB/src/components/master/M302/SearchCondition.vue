<script setup lang="ts">
import { computed } from 'vue'
import type { ISearchConditionProps } from '@/types/master/m302'
import { SupplierDiv } from '@/utils/nameDiv'
const props = withDefaults(defineProps<ISearchConditionProps>(), {})

const inputSearchSupplier = computed(() => {
  return {
    supplier_cd: props.condition.supplier_cd,
    supplier_nm: props.condition.supplier_nm_rf
  }
})
const changeSupplierCd = (newValue?: IAnsDynamic) => {
  props.condition.supplier_cd = newValue?.supplier_cd ?? ''
  props.condition.supplier_nm_rf = newValue?.supplier_nm ?? ''
  props.condition.supplier_nm = newValue?.supplier_nm ?? ''
}

const intSearchSupplier = {
  inq_supplier_div: SupplierDiv.PROCESS,
  disable_supplier_div: true
}
</script>

<template>
  <div class="row form-group">
    <div class="col-md-3">
      <AnsInputSearch
        label="仕入先"
        id="supplier_cd"
        v-model="inputSearchSupplier"
        propertyForId="supplier_cd"
        propertyForName="supplier_nm"
        :maxLength="50"
        pageSearch="M006L"
        :initData="intSearchSupplier"
        :onChangeEvent="changeSupplierCd"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="仕入先名"
        id="supplier_nm"
        type="text"
        :maxLength="50"
        v-model="condition.supplier_nm"
      />
    </div>
  </div>
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
    <div class="col-md-3">
      <AnsSelect
        label="カテゴリ"
        id="category_div"
        v-model="condition.category_div"
        :options="category_div"
      />
    </div>
    <div class="col-md-3">
      <AnsSelect
        label="素材"
        id="material_div"
        v-model="condition.material_div"
        :options="material_div"
      />
    </div>
    <div class="col-md-3">
      <AnsSelect
        label="加工箇所"
        id="processing_place_div"
        v-model="condition.processing_place_div"
        :options="processing_place_div"
      />
    </div>
  </div>
</template>
