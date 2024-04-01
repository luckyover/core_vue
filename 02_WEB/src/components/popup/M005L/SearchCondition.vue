<script setup lang="ts">
import type { ISearchConditionProps } from '@/types/master/m005'
import { computed } from 'vue'

const props = withDefaults(defineProps<ISearchConditionProps>(), {})
</script>

<template>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="納品先コード"
        id="inq_delivery_cd"
        type="number"
        :maxLength="5"
        v-model="condition.inq_delivery_cd"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="納品先名"
        id="inq_delivery_nm"
        type="text"
        :maxLength="50"
        v-model="condition.inq_delivery_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="納品先名カナ"
        id="inq_delivery_kn_nm"
        type="katakana"
        :maxLength="50"
        v-model="condition.inq_delivery_kn_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="納品先名略称"
        id="inq_delivery_ab_nm"
        type="text"
        :maxLength="30"
        v-model="condition.inq_delivery_ab_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="TEL"
        id="inq_delivery_tel"
        iconBefore="fa fa-phone"
        type="tel"
        :maxLength="20"
        v-model="condition.inq_delivery_tel"
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
