<script setup lang="ts">
import type { ISearchConditionProps } from '@/types/master/m006'

const props = withDefaults(defineProps<ISearchConditionProps>(), {})
</script>

<template>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="仕入先コード"
        id="inq_supplier_cd"
        type="number"
        :maxLength="5"
        v-model="condition.inq_supplier_cd"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="仕入先名"
        id="inq_supplier_nm"
        type="text"
        :maxLength="50"
        v-model="condition.inq_supplier_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="仕入先名カナ"
        id="inq_supplier_kn_nm"
        type="katakana"
        :maxLength="50"
        v-model="condition.inq_supplier_kn_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="仕入先名略称"
        id="inq_supplier_ab_nm"
        type="text"
        :maxLength="30"
        v-model="condition.inq_supplier_ab_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="TEL"
        id="inq_supplier_tel"
        iconBefore="fa fa-phone"
        type="tel"
        :maxLength="20"
        v-model="condition.inq_supplier_tel"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect
        label="仕入先区分"
        id="inq_supplier_div"
        v-model="condition.inq_supplier_div"
        :isDisabled="condition.disable_supplier_div"
        :options="supplier_div"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="分類区分1"
        id="inq_supplier_class_div1"
        v-model="condition.inq_supplier_class_div1"
        :options="supplier_class_div1"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="分類区分2"
        id="inq_supplier_class_div2"
        v-model="condition.inq_supplier_class_div2"
        :options="supplier_class_div2"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="分類区分3"
        id="inq_supplier_class_div3"
        v-model="condition.inq_supplier_class_div3"
        :options="supplier_class_div3"
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
