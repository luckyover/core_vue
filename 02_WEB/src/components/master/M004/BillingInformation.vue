<script setup lang="ts">
import { computed } from 'vue'
import type { IBillingInformationProps } from '@/types/master/m004'
const props = withDefaults(defineProps<IBillingInformationProps>(), {})
const inputSearchUser = computed(() => {
  return {
    user_cd: props.billing.sales_employee_cd,
    user_nm: props.billing.sales_employee_nm
  }
})
const changeUserCd = (newValue?: IAnsDynamic | null) => {
  props.billing.sales_employee_cd = newValue?.user_cd ?? ''
  props.billing.sales_employee_nm = newValue?.user_nm ?? ''
}
const onGetAddress = (address?: string) => {
  props.billing.billing_address1 = address ?? ''
}
</script>

<template>
  <!-- billing -->
  <div class="row form-group">
    <div class="col-md-3">
      <AnsInput label="請求先名" id="billing_nm" :maxLength="50" v-model="billing.billing_nm" />
    </div>
  </div>

  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="請求先郵便番号"
        type="zipcode"
        id="billing_zip"
        iconBefore="〒"
        inputClass="code-width"
        :iconBeforeIsText="true"
        :maxLength="7"
        v-model="billing.billing_zip"
        :onGetAddress="onGetAddress"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="都道府県・市区町村"
        id="billing_address1"
        :maxLength="50"
        v-model="billing.billing_address1"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="丁目・番地"
        id="billing_address2"
        :maxLength="50"
        v-model="billing.billing_address2"
      />
    </div>
  </div>

  <div class="row form-group">
    <div class="col-md-2"></div>
    <div class="col-md-6">
      <AnsInput
        label="マンション・ビル名"
        id="billing_address3"
        :maxLength="100"
        v-model="billing.billing_address3"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="請求先TEL"
        id="billing_tel"
        type="tel"
        iconBefore="fa fa-phone"
        :maxLength="20"
        v-model="billing.billing_tel"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="請求先FAX"
        iconBefore="fa fa-fax"
        id="billing_fax"
        type="tel"
        :maxLength="20"
        v-model="billing.billing_fax"
      />
    </div>
  </div>

  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="部署名"
        id="billing_department_nm"
        :maxLength="30"
        v-model="billing.billing_department_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="担当者名"
        id="billing_manager_nm"
        type="tel"
        :maxLength="30"
        v-model="billing.billing_manager_nm"
      />
    </div>
    <div class="col-md-4">
      <AnsInput
        label="メールアドレス"
        id="billing_mail_address"
        type="email"
        :maxLength="255"
        v-model="billing.billing_mail_address"
      />
    </div>
  </div>

  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect
        label="請求締日区分"
        id="billing_closing_div"
        v-model="billing.billing_closing_div"
        :options="billing_closing_div"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="振込日1"
        id="transfer_date1"
        v-model="billing.transfer_date1"
        :options="transfer_date1"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="振込日2"
        id="transfer_date2"
        v-model="billing.transfer_date2"
        :options="transfer_date2"
      />
    </div>
  </div>

  <div class="row form-group">
    <div class="col-md-2">
      <AnsInputSearch
        label="営業担当者コード"
        inputClass="code-width"
        id="sales_employee_cd"
        :maxLength="50"
        :value="inputSearchUser"
        propertyForId="user_cd"
        propertyForName="user_nm"
        pageSearch="M002L"
        :isShowNameInLabel="true"
        :onChangeEvent="changeUserCd"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="価格表区分"
        id="price_list"
        v-model="billing.price_list"
        :options="price_list"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="閉鎖理由"
        id="reason_for_closure"
        :maxLength="50"
        v-model="billing.reason_for_closure"
      />
    </div>
  </div>

  <div class="row form-group">
    <div class="col-md-8">
      <AnsInput label="備考" id="remarks" :maxLength="100" v-model="billing.remarks" />
    </div>
  </div>
</template>

<style scoped></style>
