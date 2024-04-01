<script setup lang="ts">
import type { ISearchConditionProps } from '@/types/master/m004'
import { computed } from 'vue'

const props = withDefaults(defineProps<ISearchConditionProps>(), {})
const inputSearchUser = computed(() => {
  return {
    user_cd: props.condition.sales_employee_cd,
    user_nm: props.condition.sales_employee_nm
  }
})

const changeUserCd = (newValue: IAnsDynamic) => {
  props.condition.sales_employee_cd = newValue.user_cd
  props.condition.sales_employee_nm = newValue.user_nm
}
</script>

<template>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="得意先コード"
        type="number"
        id="inq_customer_cd"
        :maxLength="5"
        v-model="condition.inq_customer_cd"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="得意先名"
        id="inq_customer_nm"
        type="text"
        :maxLength="50"
        v-model="condition.inq_customer_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="得意先名カナ"
        id="inq_customer_kn_nm"
        type="katakana"
        :maxLength="50"
        v-model="condition.inq_customer_kn_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="得意先名略称"
        id="inq_customer_ab_nm"
        type="text"
        :maxLength="30"
        v-model="condition.inq_customer_ab_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="TEL"
        id="inq_customer_tel"
        iconBefore="fa fa-phone"
        type="tel"
        :maxLength="20"
        v-model="condition.inq_customer_tel"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect
        label="請求元コード"
        id="inq_billing_source_cd"
        v-model="condition.inq_billing_source_cd"
        :options="billing_source_cd"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="分類区分1"
        id="inq_customer_class_div1"
        v-model="condition.inq_customer_class_div1"
        :options="customer_class_div1"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="分類区分2"
        id="inq_customer_class_div2"
        v-model="condition.inq_customer_class_div2"
        :options="customer_class_div3"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="分類区分3"
        id="inq_customer_class_div3"
        v-model="condition.inq_customer_class_div2"
        :options="customer_class_div3"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="請求締日区分"
        id="inq_billing_closing_div"
        v-model="condition.inq_billing_closing_div"
        :options="billing_closing_div"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-4">
      <AnsInputSearch
        label="営業担当者コード"
        id="inq_sales_employee_cd"
        :maxLength="50"
        v-model="inputSearchUser"
        propertyForId="user_cd"
        propertyForName="user_nm"
        pageSearch="M002L"
        :isShowNameInLabel="true"
        :onChangeEvent="changeUserCd"
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
