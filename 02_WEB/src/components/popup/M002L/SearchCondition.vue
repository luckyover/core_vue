<script setup lang="ts">
import type { ISearchConditionProps } from '@/types/system/m002'

const props = withDefaults(defineProps<ISearchConditionProps>(), {})
</script>

<template>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="ユーザーコード"
        id="inq_user_cd"
        :maxLength="5"
        v-model="condition.inq_user_cd"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="ユーザー名"
        id="inq_user_nm"
        type="text"
        :maxLength="50"
        v-model="condition.inq_user_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="ユーザー名カナ"
        id="inq_user_kn_nm"
        type="katakana"
        :maxLength="50"
        v-model="condition.inq_user_kn_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="ユーザー名略称"
        id="inq_user_ab_nm"
        type="text"
        :maxLength="30"
        v-model="condition.inq_user_ab_nm"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="TEL"
        id="inq_tel"
        iconBefore="fa fa-phone"
        type="tel"
        :maxLength="20"
        v-model="condition.inq_tel"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="FAX"
        id="inq_fax"
        iconBefore="fa fa-fax"
        type="tel"
        :maxLength="20"
        v-model="condition.inq_fax"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="メールアドレス"
        id="inq_mailaddress"
        type="email"
        :maxLength="255"
        v-model="condition.inq_mailaddress"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="所属部門区分"
        id="inq_belong_department_div"
        v-model="condition.inq_belong_department_div"
        :options="belong_department_div"
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
