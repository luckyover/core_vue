<script setup lang="ts">
import { computed } from 'vue'
import type { ISupplierInformationProps } from '@/types/master/m006'
const props = withDefaults(defineProps<ISupplierInformationProps>(), {})
const inputSearchSupplier = computed(() => {
  return {
    supplier_cd: props.supplier.supplier_cd,
    supplier_nm: props.supplier.supplier_nm
  }
})
const onGetAddress = (address?: string) => {
  props.supplier.supplier_address1 = address ?? ''
}
</script>

<template>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInputSearch
        label="仕入先コード"
        inputClass="code-width"
        id="supplier_cd"
        :maxLength="50"
        v-model="inputSearchSupplier"
        propertyForId="supplier_cd"
        propertyForName="supplier_nm"
        :isReferName="false"
        pageSearch="M006L"
        :onChangeEvent="changeSupplierCd"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="仕入先区分"
        id="supplier_div"
        v-model="supplier.supplier_div"
        :options="supplier_div"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-3">
      <AnsInput
        label="仕入先名"
        id="supplier_nm"
        type="text"
        :maxLength="50"
        v-model="supplier.supplier_nm"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="仕入先名カナ"
        id="supplier_kn_nm"
        type="katakana"
        :maxLength="50"
        v-model="supplier.supplier_kn_nm"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="仕入先名略称"
        id="supplier_ab_nm"
        type="text"
        :maxLength="30"
        v-model="supplier.supplier_ab_nm"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="郵便番号"
        inputClass="code-width"
        iconBefore="〒"
        :iconBeforeIsText="true"
        id="supplier_zip"
        type="zipcode"
        :maxLength="7"
        v-model="supplier.supplier_zip"
        :onGetAddress="onGetAddress"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="都道府県・市区町村"
        id="supplier_address1"
        type="text"
        :maxLength="50"
        v-model="supplier.supplier_address1"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="丁目・番地"
        id="supplier_address2"
        type="text"
        :maxLength="50"
        v-model="supplier.supplier_address2"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2"></div>
    <div class="col-md-6">
      <AnsInput
        label="マンション・ビル名"
        id="supplier_address3"
        type="text"
        :maxLength="100"
        v-model="supplier.supplier_address3"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="TEL"
        iconBefore="fa fa-phone"
        id="supplier_tel"
        type="tel"
        :maxLength="20"
        v-model="supplier.supplier_tel"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="FAX"
        iconBefore="fa fa-fax"
        id="supplier_fax"
        type="tel"
        :maxLength="20"
        v-model="supplier.supplier_fax"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="部署名"
        id="supplier_department_nm"
        type="text"
        :maxLength="30"
        v-model="supplier.supplier_department_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="担当者名"
        id="supplier_manager_nm"
        type="text"
        :maxLength="30"
        v-model="supplier.supplier_manager_nm"
      />
    </div>
    <div class="col-md-4">
      <AnsInput
        label="メールアドレス"
        id="supplier_mail_address"
        type="email"
        :maxLength="255"
        v-model="supplier.supplier_mail_address"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect
        label="分類区分1"
        id="supplier_class_div1"
        v-model="supplier.supplier_class_div1"
        :options="supplier_class_div1"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="分類区分2"
        id="supplier_class_div2"
        v-model="supplier.supplier_class_div2"
        :options="supplier_class_div2"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="分類区分3"
        id="supplier_class_div3"
        v-model="supplier.supplier_class_div3"
        :options="supplier_class_div3"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect
        label="請求締日区分"
        id="supplier_closing_div"
        v-model="supplier.supplier_closing_div"
        :options="supplier_closing_div"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="振込日1"
        id="transfer_date1"
        v-model="supplier.transfer_date1"
        :options="transfer_date1"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="振込日2"
        id="transfer_date2"
        v-model="supplier.transfer_date2"
        :options="transfer_date2"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-8">
      <AnsInput label="備考" id="remarks" type="text" :maxLength="100" v-model="supplier.remarks" />
    </div>
  </div>
</template>
