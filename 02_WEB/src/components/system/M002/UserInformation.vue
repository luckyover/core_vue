<script setup lang="ts">
import { computed } from 'vue'
import type { IUserInformationProps } from '@/types/system/m002'
const props = withDefaults(defineProps<IUserInformationProps>(), {})
const inputSearchUser = computed(() => {
  return {
    user_cd: props.user.user_cd,
    user_nm: props.user.user_nm
  }
})
</script>

<template>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInputSearch
        label="ユーザーコード"
        inputClass="code-width"
        id="user_cd"
        :maxLength="50"
        v-model="inputSearchUser"
        propertyForId="user_cd"
        pageSearch="M002L"
        :isReferName="false"
        :onChangeEvent="changeUserCd"
      />
    </div>
    <div class="col-md-4">
      <AnsInput
        label="パスワード"
        id="password"
        type="password"
        :maxLength="20"
        v-model="user.password"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="ユーザー名"
        id="user_nm"
        type="text"
        :maxLength="50"
        v-model="user.user_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="ユーザー名カナ"
        id="user_kn_nm"
        type="katakana"
        :maxLength="50"
        v-model="user.user_kn_nm"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="ユーザー名略称"
        id="user_ab_nm"
        type="text"
        :maxLength="30"
        v-model="user.user_ab_nm"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsInput
        label="TEL"
        iconBefore="fa fa-phone"
        id="tel"
        type="tel"
        :maxLength="20"
        v-model="user.tel"
      />
    </div>
    <div class="col-md-2">
      <AnsInput
        label="FAX"
        iconBefore="fa fa-fax"
        id="fax"
        type="tel"
        :maxLength="20"
        v-model="user.fax"
      />
    </div>
    <div class="col-md-4">
      <AnsInput
        label="メールアドレス"
        id="mailaddress"
        type="email"
        :maxLength="255"
        v-model="user.mailaddress"
      />
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-2">
      <AnsSelect
        label="所属部門区分"
        id="belong_department_div"
        v-model="user.belong_department_div"
        :options="belong_department_div"
      />
    </div>
    <div class="col-md-2">
      <AnsSelect
        label="権限区分"
        id="authority_div"
        v-model="user.authority_div"
        :options="authority_div"
      />
    </div>
  </div>
</template>
