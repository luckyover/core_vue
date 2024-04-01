<script setup lang="ts">
import { computed } from 'vue'
import type { ICost, ITableCostProps } from '@/types/master/m302'
import _ from 'lodash'
import { ansNumber, ansValidate } from '@/utils'
import { ItemClassDiv, SupplierDiv } from '@/utils/nameDiv'
const props = withDefaults(defineProps<ITableCostProps>(), {})

const initSearchItem = {
  inq_item_class_div: ItemClassDiv.PROCESS,
  disable_item_class_div: true
}

const intSearchSupplier = {
  inq_supplier_div: SupplierDiv.PROCESS,
  disable_supplier_div: true
}

const addRow = () => {
  props.costs.push({
    supplier_cd: '',
    item_cd: '',
    supplier_nm: '',
    item_nm: '',
    category_div: 0,
    material_div: 0,
    processing_place_div: 0,
    number_sheet_fr: '',
    number_sheet_to: '',
    color_div: 0,
    sales_amt: '',
    is_new: true,
    idx: -1
  } as ICost)
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
  props.costs[idx].supplier_cd = newValue?.supplier_cd ?? ''
  props.costs[idx].supplier_nm = newValue?.supplier_nm ?? ''
  clearError(idx)
}

const changeItem = (
  newValue?: IAnsDynamic | null,
  oldValue?: IAnsDynamic | null,
  index?: string | number
) => {
  const idx = ansNumber.toNumber(`${index ?? '-1'}`)
  props.costs[idx].idx = idx
  props.costs[idx].item_cd = newValue?.item_cd ?? ''
  props.costs[idx].item_nm = newValue?.item_nm ?? ''
  clearError(idx)
}

const clearError = (idx: number) => {
  ansValidate.removeError(`costs.${idx}.supplier_cd`)
  ansValidate.removeError(`costs.${idx}.supplier_nm`)
  ansValidate.removeError(`costs.${idx}.item_cd`)
  ansValidate.removeError(`costs.${idx}.item_nm`)
  ansValidate.removeError(`costs.${idx}.category_div`)
  ansValidate.removeError(`costs.${idx}.material_div`)
  ansValidate.removeError(`costs.${idx}.processing_place_div`)
  ansValidate.removeError(`costs.${idx}.number_sheet_fr`)
  ansValidate.removeError(`costs.${idx}.number_sheet_to`)
  ansValidate.removeError(`costs.${idx}.color_div`)
  ansValidate.removeError(`costs.${idx}.sales_amt`)
}
</script>

<template>
  <div class="row">
    <div class="col-md-12 table-size-area">
      <div class="table-response">
        <table class="table ans-table table-size">
          <thead>
            <tr>
              <th class="col-add">
                <button type="button" class="btn btn-primary btn-add" @click="addRow">
                  <i class="fas fa-plus"></i>
                </button>
              </th>
              <th colspan="2" class="col-supplier">仕入先</th>
              <th class="col-item_cd">商品コード</th>
              <th class="col-item_nm">商品名</th>
              <th class="col-category_div">カテゴリー</th>
              <th class="col-material_div">素材</th>
              <th class="col-processing_place_div">加工箇所</th>
              <th colspan="3" class="col-number_sheet">枚数</th>
              <th class="col-color_div">色数</th>
              <th class="col-sales_amt">仕入単価</th>
              <th class="col-remove"></th>
            </tr>
          </thead>
          <tbody>
            <template v-for="(cost, idx) in costs">
              <tr>
                <td class="col-add text-center">{{ idx + 1 }}</td>
                <td class="col-supplier_cd text-center have-input col-item-search">
                  <AnsInputSearch
                    :id="`costs.${idx}.supplier_cd`"
                    :maxLength="50"
                    :isDisabled="cost.is_new !== true"
                    propertyForId="supplier_cd"
                    propertyForName="supplier_nm"
                    pageSearch="M006L"
                    :index="idx"
                    :value="cost"
                    :initData="intSearchSupplier"
                    :onChangeEvent="changeSupplier"
                  />
                </td>
                <td class="col-supplier_nm text-center have-input">
                  <AnsInput
                    type="text"
                    :id="`costs.${idx}.supplier_nm`"
                    :maxLength="50"
                    v-model="cost.supplier_nm"
                    :isDisabled="true"
                  />
                </td>
                <td class="col-item_cd text-center have-input col-item-search">
                  <AnsInputSearch
                    :id="`costs.${idx}.item_cd`"
                    :maxLength="30"
                    :isDisabled="cost.is_new !== true"
                    propertyForId="item_cd"
                    propertyForName="item_nm"
                    pageSearch="M101L"
                    :value="cost"
                    :index="idx"
                    :initData="{
                      ...initSearchItem,
                      inq_supplier_cd: cost.supplier_cd
                    }"
                    :onChangeEvent="changeItem"
                  />
                </td>
                <td class="col-item_nm text-center have-input">
                  <AnsInput
                    type="text"
                    :id="`costs.${idx}.item_nm`"
                    :maxLength="50"
                    v-model="cost.item_nm"
                    :isDisabled="true"
                  />
                </td>
                <td class="col-category_div w-20 have-input">
                  <AnsSelect
                    :id="`costs.${idx}.category_div`"
                    :options="category_div"
                    :isDisabled="cost.is_new !== true"
                    v-model="cost.category_div"
                    :onChangeEvent="() => clearError(idx)"
                  />
                </td>
                <td class="col-material_div have-input">
                  <AnsSelect
                    :id="`costs.${idx}.material_div`"
                    :options="material_div"
                    :isDisabled="cost.is_new !== true"
                    v-model="cost.material_div"
                    :onChangeEvent="() => clearError(idx)"
                  />
                </td>
                <td class="col-processing_place_div have-input">
                  <AnsSelect
                    :id="`costs.${idx}.processing_place_div`"
                    :options="processing_place_div"
                    :isDisabled="cost.is_new !== true"
                    v-model="cost.processing_place_div"
                    :onChangeEvent="() => clearError(idx)"
                  />
                </td>
                <td class="col-number_sheet_fr text-center have-input">
                  <AnsInput
                    type="money"
                    :id="`costs.${idx}.number_sheet_fr`"
                    :maxLength="6"
                    :isDisabled="cost.is_new !== true"
                    v-model="cost.number_sheet_fr"
                    :onChangeEvent="() => clearError(idx)"
                  />
                </td>
                <td class="text-center have-input col-icon_text">
                  <div>～</div>
                </td>
                <td class="col-number_sheet_to text-center have-input">
                  <AnsInput
                    type="money"
                    :id="`costs.${idx}.number_sheet_to`"
                    :maxLength="6"
                    :isDisabled="cost.is_new !== true"
                    v-model="cost.number_sheet_to"
                    :onChangeEvent="() => clearError(idx)"
                  />
                </td>
                <td class="col-color_div have-input">
                  <AnsSelect
                    :id="`costs.${idx}.color_div`"
                    :options="color_div"
                    :isDisabled="cost.is_new !== true"
                    v-model="cost.color_div"
                    :onChangeEvent="() => clearError(idx)"
                  />
                </td>
                <td class="col-sales_amt text-center have-input">
                  <AnsInput
                    type="money"
                    :id="`costs.${idx}.sales_amt`"
                    :maxLength="10"
                    v-model="cost.sales_amt"
                    :onChangeEvent="() => clearError(idx)"
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
