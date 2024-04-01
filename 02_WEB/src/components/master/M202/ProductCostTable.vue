<script setup lang="ts">
import { computed } from 'vue'
import type { IProductCost, IDataTableCostProps } from '@/types/master/m202'
import { ansCommon, ansValidate } from '@/utils'
import _ from 'lodash'
const props = withDefaults(defineProps<IDataTableCostProps>(), {})
import { ansNumber } from '@/utils'
import { SupplierDiv } from '@/utils/nameDiv'

const initSearchItem = {
  inq_item_class_div: -1,
  remove_process: true
}

const initSearchSupplier = {
  inq_supplier_div: SupplierDiv.BODY,
  disable_supplier_div: true
}

const addRow = () => {
  props.costs.push({
    idx: -1,
    item_cd: '',
    color_cd: '',
    item_nm: '',
    size_cd: '',
    supplier_cd: null,
    supplier_nm: '',
    retail_upr: '',
    is_new: true
  } as IProductCost)
}

const removeRow = (i: number) => {
  const tmpCost = _.cloneDeep(props.costs[i])
  if (!tmpCost.is_new) {
    props.addToDeleteCost(tmpCost)
  }
  props.costs.splice(i, 1)
}

const changeSupplier = (
  newValue?: IAnsDynamic | null,
  oldValue?: IAnsDynamic | null,
  index?: string | number
) => {
  const idx = ansNumber.toNumber(`${index ?? '-1'}`)
  props.costs[idx].idx = idx
  props.costs[idx].supplier_cd = newValue?.supplier_cd ?? 0
  props.costs[idx].supplier_nm = newValue?.supplier_nm ?? ''
}

const changeColor = (idx: number) => {
  props.getDetailItem(
    {
      item_cd: props.costs[idx].item_cd,
      color_cd: props.costs[idx].color_cd
    },
    `costs.${idx}.color_cd`,
    idx
  )
}

const changeItem = (
  newValue?: IAnsDynamic | null,
  oldValue?: IAnsDynamic | null,
  index?: string | number
) => {
  const idx = ansNumber.toNumber(`${index ?? '-1'}`)
  props.costs[idx].item_cd = newValue?.item_cd ?? ''
  props.costs[idx].color_cd = newValue?.color_cd ?? ''
  props.getDetailItem(
    {
      item_cd: props.costs[idx].item_cd,
      color_cd: props.costs[idx].color_cd
    },
    `costs.${idx}.item_cd`,
    idx
  )
}

const clearError = (idx: number) => {
  ansValidate.removeError(`costs.${idx}.item_cd`)
  ansValidate.removeError(`costs.${idx}.color_cd`)
  ansValidate.removeError(`costs.${idx}.size_cd`)
  ansValidate.removeError(`costs.${idx}.supplier_cd`)
}
</script>

<template>
  <div class="row">
    <div class="col-md-4 table-size-area">
      <div class="table-response">
        <table class="table ans-table table-size">
          <thead>
            <tr>
              <th class="col-add">
                <button type="button" class="btn btn-primary btn-add" @click="addRow">
                  <i class="fas fa-plus"></i>
                </button>
              </th>
              <th class="col-item_cd">商品コード</th>
              <th class="col-color_cd">色コード</th>
              <th class="col-item_nm">商品名-色名</th>
              <th class="col-size_cd">サイズ</th>
              <th class="col-supplier_cd" colspan="2">仕入先</th>
              <th class="col-retail_upr">仕入単価</th>
              <th class="col-remove"></th>
            </tr>
          </thead>
          <tbody>
            <template v-for="(cost, idx) in costs" :key="idx">
              <tr>
                <td class="col-add text-center">{{ idx + 1 }}</td>
                <td class="col-item_cd have-input">
                  <AnsInputSearch
                    :id="`costs.${idx}.item_cd`"
                    :isDisabled="cost.is_new !== true"
                    propertyForId="item_cd"
                    :maxLength="30"
                    :value="cost"
                    :index="idx"
                    pageSearch="M101L"
                    :initData="{
                      ...initSearchItem,
                      inq_supplier_cd: cost.supplier_cd
                    }"
                    :onChangeEvent="changeItem"
                  />
                </td>
                <td class="col-color_cd have-input">
                  <AnsInput
                    :id="`costs.${idx}.color_cd`"
                    :isDisabled="cost.is_new !== true"
                    :maxLength="10"
                    v-model="cost.color_cd"
                    :onChangeEvent="() => changeColor(idx)"
                  />
                </td>
                <td class="col-item_nm have-input">
                  <AnsInput
                    type="text"
                    :id="`costs.${idx}.item_nm`"
                    :maxLength="50"
                    :value="`${cost.item_nm ?? ''}${ansCommon.isEmpty(cost.color_nm) ? '' : '-'}${
                      cost.color_nm ?? ''
                    }`"
                    :isDisabled="true"
                  />
                </td>
                <td class="col-size_cd have-input">
                  <AnsSelect
                    v-if="cost.is_new === true"
                    :id="`costs.${idx}.size_cd`"
                    :options="cost.sizes"
                    v-model="cost.size_cd"
                    :onChangeEvent="() => clearError(idx)"
                  />
                  <AnsInput
                    v-else
                    :id="`costs.${idx}.size_cd`"
                    :maxLength="10"
                    v-model="cost.size_cd"
                    :isDisabled="true"
                  />
                </td>
                <td class="col-supplier_cd have-input">
                  <AnsInputSearch
                    :id="`costs.${idx}.supplier_cd`"
                    :maxLength="5"
                    :isDisabled="cost.is_new !== true"
                    :index="idx"
                    :value="cost"
                    propertyForId="supplier_cd"
                    propertyForName="supplier_nm"
                    pageSearch="M006L"
                    :initData="initSearchSupplier"
                    :onChangeEvent="changeSupplier"
                  />
                </td>
                <td class="col-supplier_nm have-input">
                  <AnsInput
                    type="text"
                    :id="`costs.${idx}.supplier_nm`"
                    :maxLength="50"
                    v-model="cost.supplier_nm"
                    :isDisabled="true"
                  />
                </td>
                <td class="col-retail_upr have-input">
                  <AnsInput
                    type="money"
                    :id="`costs.${idx}.retail_upr`"
                    :maxLength="6"
                    v-model="cost.retail_upr"
                  />
                </td>
                <td class="col-remove">
                  <button
                    type="button"
                    class="btn btn-danger btn-remove"
                    @click="
                      () => {
                        removeRow(idx)
                      }
                    "
                  >
                    <i class="fas fa-times"></i>
                  </button>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
