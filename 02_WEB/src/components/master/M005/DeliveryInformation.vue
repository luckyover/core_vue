<script setup lang="ts">
import { computed } from 'vue'
import type { IDeliveryInformationProps } from '@/types/master/m005'
const props = withDefaults(defineProps<IDeliveryInformationProps>(), {})
const inputSearchDelivery = computed(() => {
  return {
    delivery_cd: props.delivery.delivery_cd,
    delivery_nm: props.delivery.delivery_nm
  }
})
const onGetAddress = (address?: string) => {
  props.delivery.delivery_address1 = address ?? ''
}
</script>

<template>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInputSearch
        label="納品先コード"
        inputClass="code-width"
        id="delivery_cd"
        :maxLength="5"
        v-model="inputSearchDelivery"
        propertyForId="delivery_cd"
        propertyForName="delivery_nm"
        :isReferName="false"
        pageSearch="M005L"
        :onChangeEvent="changeDeliveryCd"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-3">
      <AnsInput
        label="納品先名"
        id="delivery_nm"
        type="text"
        :maxLength="50"
        v-model="delivery.delivery_nm"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="納品先名カナ"
        id="delivery_kn_nm"
        type="katakana"
        :maxLength="50"
        v-model="delivery.delivery_kn_nm"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="納品先名略称"
        id="delivery_ab_nm"
        type="text"
        :maxLength="30"
        v-model="delivery.delivery_ab_nm"
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
        id="delivery_zip"
        :maxLength="7"
        type="zipcode"
        v-model="delivery.delivery_zip"
        :onGetAddress="onGetAddress"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="都道府県・市区町村"
        id="delivery_address1"
        type="text"
        :maxLength="50"
        v-model="delivery.delivery_address1"
      />
    </div>
    <div class="col-md-3">
      <AnsInput
        label="丁目・番地"
        id="delivery_address2"
        type="text"
        :maxLength="50"
        v-model="delivery.delivery_address2"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2"></div>
    <div class="col-md-6">
      <AnsInput
        label="マンション・ビル名"
        id="delivery_address3"
        type="text"
        :maxLength="100"
        v-model="delivery.delivery_address3"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="TEL"
        iconBefore="fa fa-phone"
        id="delivery_tel"
        type="tel"
        :maxLength="20"
        v-model="delivery.delivery_tel"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="FAX"
        iconBefore="fa fa-fax"
        id="delivery_fax"
        type="tel"
        :maxLength="20"
        v-model="delivery.delivery_fax"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="部署名"
        id="delivery_department_nm"
        type="text"
        :maxLength="30"
        v-model="delivery.delivery_department_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="担当者名"
        id="delivery_manager_nm"
        type="text"
        :maxLength="30"
        v-model="delivery.delivery_manager_nm"
      />
    </div>
    <div class="col-md-4">
      <AnsInput
        label="メールアドレス"
        id="delivery_mail_address"
        type="email"
        :maxLength="255"
        v-model="delivery.delivery_mail_address"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-8">
      <AnsInput label="備考" id="remarks" type="text" :maxLength="100" v-model="delivery.remarks" />
    </div>
  </div>
</template>
