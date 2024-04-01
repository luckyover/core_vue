<script setup lang="ts">
import { computed } from 'vue'
import type { ICustomerInformationProps } from '@/types/master/m004'
const props = withDefaults(defineProps<ICustomerInformationProps>(), {})

const inputSearchCustomer = computed(() => {
  return {
    customer_cd: props.customer.customer_cd
  }
})
const onGetAddress = (address?: string) => {
  props.customer.customer_address1 = address ?? ''
}
</script>

<template>
  <!-- customer -->
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInputSearch
        label="得意先コード"
        inputClass="code-width"
        id="customer_cd"
        :maxLength="50"
        v-model="inputSearchCustomer"
        propertyForId="customer_cd"
        pageSearch="M004L"
        :isReferName="false"
        :onChangeEvent="changeCustomerCd"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="請求元コード"
        id="billing_source_cd"
        v-model="customer.billing_source_cd"
        :options="billing_source_cd"
      />
    </div>
  </div>

  <div class="row form-group">
    <div class="col-md-3">
      <AnsInput label="得意先名" id="customer_nm" :maxLength="50" v-model="customer.customer_nm" />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="得意先名カナ"
        id="customer_kn_nm"
        :maxLength="50"
        type="katakana"
        v-model="customer.customer_kn_nm"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="得意先名略称"
        id="customer_ab_nm"
        :maxLength="30"
        type="text"
        v-model="customer.customer_ab_nm"
      />
    </div>
  </div>

  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="郵便番号"
        inputClass="code-width"
        id="customer_zip"
        type="zipcode"
        :maxLength="7"
        v-model="customer.customer_zip"
        iconBefore="〒"
        :iconBeforeIsText="true"
        :onGetAddress="onGetAddress"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="都道府県・市区町村"
        id="customer_address1"
        :maxLength="50"
        v-model="customer.customer_address1"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="丁目・番地"
        id="customer_address2"
        :maxLength="50"
        v-model="customer.customer_address2"
      />
    </div>
  </div>

  <div class="row form-group">
    <div class="col-md-2"></div>
    <div class="col-md-6">
      <AnsInput
        label="マンション・ビル名"
        id="customer_address3"
        :maxLength="100"
        v-model="customer.customer_address3"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="TEL"
        id="customer_tel"
        type="tel"
        iconBefore="fa fa-phone"
        :maxLength="20"
        v-model="customer.customer_tel"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="FAX"
        iconBefore="fa fa-fax"
        id="customer_fax"
        type="tel"
        :maxLength="20"
        v-model="customer.customer_fax"
      />
    </div>
  </div>

  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="部署名"
        id="customer_department_nm"
        :maxLength="30"
        v-model="customer.customer_department_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="担当者名"
        id="customer_manager_nm"
        type="tel"
        :maxLength="30"
        v-model="customer.customer_manager_nm"
      />
    </div>
    <div class="col-md-4">
      <AnsInput
        label="メールアドレス"
        id="customer_mail_address"
        type="email"
        :maxLength="255"
        v-model="customer.customer_mail_address"
      />
    </div>
  </div>

  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect
        label="分類区分1"
        id="customer_class_div1"
        v-model="customer.customer_class_div1"
        :options="customer_class_div1"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="分類区分2"
        id="customer_class_div2"
        v-model="customer.customer_class_div2"
        :options="customer_class_div2"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="分類区分3"
        id="customer_class_div3"
        v-model="customer.customer_class_div3"
        :options="customer_class_div3"
      />
    </div>
  </div>
</template>

<style scoped></style>
