<script setup lang="ts">
import { computed } from 'vue'
import type { IItemDetailProps } from '@/types/master/m101'
import { ItemClassDiv, SupplierDiv } from '@/utils/nameDiv'
const props = withDefaults(defineProps<IItemDetailProps>(), {})
const inputSearchSupplier = computed(() => {
  return {
    supplier_cd: props.product.supplier_cd,
    supplier_nm: props.product.supplier_nm
  }
})
const initSearchSupplier = computed(() => {
  return {
    inq_supplier_div:
      props.product.item_class_div == ItemClassDiv.PROCESS
        ? props.product.item_class_div
        : SupplierDiv.BODY,
    disable_supplier_div: true
  }
})
const onGetItem = (itemFocus: string = 'color_cd') => {
  props.getProduct(
    {
      item_cd: props.product.item_cd,
      color_cd: props.product.color_cd
    },
    itemFocus
  )
}
const onChangeItemCd = (newValue?: IAnsDynamic) => {
  props.product.item_cd = newValue?.item_cd ?? ''
  props.product.color_cd = newValue?.color_cd ?? ''
  onGetItem('item_cd')
}
const changeSupplierCd = (newValue?: IAnsDynamic) => {
  props.product.supplier_cd = newValue?.supplier_cd ?? ''
  props.product.supplier_nm = newValue?.supplier_nm ?? ''
}
</script>

<template>
  <div class="row form-group">
    <div class="col-md-3">
      <AnsInputSearch
        label="商品コード"
        inputClass="code-width"
        :maxLength="50"
        id="item_cd"
        :value="product"
        propertyForId="item_cd"
        :isReferName="false"
        pageSearch="M101L"
        :onChangeEvent="onChangeItemCd"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="色コード"
        id="color_cd"
        type="text"
        :maxLength="10"
        v-model="product.color_cd"
        :onChangeEvent="() => onGetItem()"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-3">
      <AnsInput label="商品名" id="item_nm" type="text" :maxLength="50" v-model="product.item_nm" />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="商品名カナ"
        id="item_kn_nm"
        type="katakana"
        :maxLength="50"
        v-model="product.item_kn_nm"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="商品名略称"
        id="item_ab_nm"
        type="text"
        :maxLength="30"
        v-model="product.item_ab_nm"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-3">
      <AnsInput label="色名" id="color_nm" type="text" :maxLength="30" v-model="product.color_nm" />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="色名カナ"
        id="color_kn_nm"
        type="katakana"
        :maxLength="30"
        v-model="product.color_kn_nm"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="色名略称"
        id="color_ab_nm"
        type="text"
        :maxLength="20"
        v-model="product.color_ab_nm"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect
        label="商品分類"
        id="item_class_div"
        v-model="product.item_class_div"
        :options="item_class_div"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="加工種別"
        id="process_div"
        v-model="product.process_div"
        :options="process_div"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="カテゴリー"
        id="category_div"
        v-model="product.category_div"
        :options="category_div"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="素材"
        id="material_div"
        v-model="product.material_div"
        :options="material_div"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2 col-supplier">
      <AnsInputSearch
        label="仕入先"
        id="supplier_cd"
        v-model="inputSearchSupplier"
        propertyForId="supplier_cd"
        propertyForName="supplier_nm"
        :maxLength="50"
        :isShowNameInLabel="true"
        pageSearch="M006L"
        :initData="initSearchSupplier"
        :onChangeEvent="changeSupplierCd"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="仕入先商品コード"
        id="supplier_item_cd"
        type="text"
        :maxLength="30"
        v-model="product.supplier_item_cd"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect label="消費税" id="tax_div" v-model="product.tax_div" :options="tax_div" />
    </div>
  </div>
</template>
