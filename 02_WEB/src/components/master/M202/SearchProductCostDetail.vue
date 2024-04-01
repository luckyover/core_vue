<script setup lang="ts">
import { computed } from 'vue'
import { SupplierDiv } from '@/utils/nameDiv'
import type { IProductCostSearchProps } from '@/types/master/m202'
const props = withDefaults(defineProps<IProductCostSearchProps>(), {})

const changeSupplierCd = (newValue?: IAnsDynamic) => {
  props.condition.supplier_cd = newValue?.supplier_cd ?? ''
  props.condition.supplier_nm_rf = newValue?.supplier_nm ?? ''
  props.condition.supplier_nm = newValue?.supplier_nm ?? ''
}

const inputSearchSupplier = computed(() => {
  return {
    supplier_cd: props.condition.supplier_cd,
    supplier_nm: props.condition.supplier_nm_rf
  }
})

const intSearchSupplier = {
  inq_supplier_div: SupplierDiv.BODY,
  disable_supplier_div: true
}
</script>

<template>
  <div class="row form-group">
    <div class="col-md-3">
      <AnsInput
        label="商品コード"
        id="item_cd"
        :maxLength="30"
        :required="true"
        v-model="condition.item_cd"
      />
    </div>
    <div class="col-md-2">
      <AnsInput label="色コード" id="color_cd" :maxLength="10" v-model="condition.color_cd" />
    </div>
    <div class="col-md-3">
      <AnsInput label="商品名" id="item_nm" type="text" :maxLength="50" />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-3">
      <AnsInputSearch
        label="仕入先"
        id="supplier_cd"
        :maxLength="10"
        propertyForId="supplier_cd"
        propertyForName="supplier_nm"
        pageSearch="M006L"
        :initData="intSearchSupplier"
        :onChangeEvent="changeSupplierCd"
        v-model="inputSearchSupplier"
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
</template>
