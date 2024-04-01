<script setup lang="ts">
import { computed } from 'vue'
import { ansValidate } from '@/utils'
import type { IProcessPrice, ITableProcessPriceProps } from '@/types/master/m301'
const props = withDefaults(defineProps<ITableProcessPriceProps>(), {})
import { ansNumber } from '@/utils'
import _ from 'lodash'
import { ItemClassDiv } from '@/utils/nameDiv'

const changeItem = (
  newValue?: IAnsDynamic | null,
  oldValue?: IAnsDynamic | null,
  index?: string | number
) => {
  const idx = ansNumber.toNumber(`${index ?? '-1'}`)
  props.processPrices[idx].item_cd = newValue?.item_cd ?? ''
  props.processPrices[idx].item_nm = newValue?.item_nm ?? ''

  removeError(idx)
}

const initSearchItem = {
  inq_item_class_div: ItemClassDiv.PROCESS,
  disable_item_class_div: true
}

const addRow = () => {
  props.processPrices.push({
    item_cd: '',
    item_nm: '',
    category_div: 0,
    material_div: 0,
    processing_place_div: 0,
    number_sheet_fr: undefined,
    number_sheet_to: undefined,
    color_div: 0,
    sales_amt: undefined,
    is_new: true,
    idx: -1
  } as IProcessPrice)
}

const removeRow = (i: number) => {
  const tmpPrice = _.cloneDeep(props.processPrices[i])

  if (!tmpPrice.is_new) {
    props.addToDeletePrice(tmpPrice)
  } else {
    ansValidate.removeAllErrors()
  }
  props.processPrices.splice(i, 1)
}

const removeError = (idx: number | string) => {
  if (props.duplicates.hasOwnProperty(idx)) {
    ansValidate.removeError(`process_prices.${idx}.item_cd`)
    ansValidate.removeError(`process_prices.${idx}.category_div`)
    ansValidate.removeError(`process_prices.${idx}.material_div`)
    ansValidate.removeError(`process_prices.${idx}.processing_place_div`)
    ansValidate.removeError(`process_prices.${idx}.number_sheet_fr`)
    ansValidate.removeError(`process_prices.${idx}.number_sheet_to`)
    ansValidate.removeError(`process_prices.${idx}.color_div`)
  }
}
</script>

<template>
  <div class="row">
    <div class="table-size-area">
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
              <th class="col-item_nm">商品名</th>
              <th class="col-category_div">カテゴリー</th>
              <th class="col-material_div">素材</th>
              <th class="col-processing_place_div">加工箇所</th>
              <th :colspan="props.processPrices.length === 0 ? '0' : '3'" class="col-number_sheet">
                枚数
              </th>
              <th class="col-color_div">色数</th>
              <th class="col-sales_amt">販売単価</th>
              <th class="col-remove"></th>
            </tr>
          </thead>
          <tbody>
            <template v-for="(processPrice, idx) in processPrices" :key="idx">
              <tr>
                <td class="col-add text-center">{{ idx + 1 }}</td>
                <td class="col-item_cd txt-start have-input">
                  <AnsInputSearch
                    :id="`process_prices.${idx}.item_cd`"
                    :maxLength="30"
                    :isDisabled="processPrice.is_new !== true"
                    propertyForId="item_cd"
                    propertyForName="item_nm"
                    :value="processPrice"
                    :index="idx"
                    pageSearch="M101L"
                    :initData="initSearchItem"
                    :onChangeEvent="changeItem"
                  />
                </td>
                <td class="col-item_nm txt-start have-input">
                  <AnsInput
                    :id="`process_prices.${idx}.item_nm`"
                    type="text"
                    :isDisabled="true"
                    v-model="processPrice.item_nm"
                    :onChangeEvent="() => removeError(idx)"
                  />
                </td>
                <td class="col-category_div have-input">
                  <AnsSelect
                    :id="`process_prices.${idx}.category_div`"
                    :options="category_div"
                    v-model="processPrice.category_div"
                    :isDisabled="processPrice.is_new !== true"
                    :onChangeEvent="() => removeError(idx)"
                  />
                </td>
                <td class="col-material_div have-input">
                  <AnsSelect
                    :id="`process_prices.${idx}.material_div`"
                    :options="material_div"
                    v-model="processPrice.material_div"
                    :isDisabled="processPrice.is_new !== true"
                    :onChangeEvent="() => removeError(idx)"
                  />
                </td>
                <td class="col-processing_place_div have-input">
                  <AnsSelect
                    :id="`process_prices.${idx}.processing_place_div`"
                    :options="processing_location_div"
                    :isDisabled="processPrice.is_new !== true"
                    v-model="processPrice.processing_place_div"
                    :onChangeEvent="() => removeError(idx)"
                  />
                </td>
                <td class="col-number_sheet_fr txt-end have-input">
                  <AnsInput
                    :id="`process_prices.${idx}.number_sheet_fr`"
                    :maxLength="6"
                    :value="processPrice.number_sheet_fr"
                    v-model="processPrice.number_sheet_fr"
                    type="money"
                    :isDisabled="processPrice.is_new !== true"
                    :onChangeEvent="() => removeError(idx)"
                  />
                </td>
                <td class="col-number_sheet_icon text-center have-input">
                  <span> ~ </span>
                </td>
                <td class="col-number_sheet_to txt-end have-input">
                  <AnsInput
                    type="money"
                    :maxLength="6"
                    :id="`process_prices.${idx}.number_sheet_to`"
                    :isDisabled="processPrice.is_new !== true"
                    :value="processPrice.number_sheet_to"
                    v-model="processPrice.number_sheet_to"
                    :onChangeEvent="() => removeError(idx)"
                  />
                </td>
                <td class="col-color_div have-input">
                  <AnsSelect
                    :id="`process_prices.${idx}.color_div`"
                    :isDisabled="processPrice.is_new !== true"
                    :options="number_of_color_div"
                    v-model="processPrice.color_div"
                    :onChangeEvent="() => removeError(idx)"
                  />
                </td>
                <td class="col-sales_amt txt-end have-input">
                  <AnsInput
                    :id="`process_prices.${idx}.sales_amt`"
                    :maxLength="10"
                    type="money"
                    :value="processPrice.sales_amt"
                    v-model="processPrice.sales_amt"
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
