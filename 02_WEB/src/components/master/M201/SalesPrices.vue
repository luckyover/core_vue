<script setup lang="ts">
import { computed } from 'vue'
import { ansCommon, ansValidate } from '@/utils'
import type { ISizesPrice, ITableSizesPriceProps } from '@/types/master/m201'
const props = withDefaults(defineProps<ITableSizesPriceProps>(), {})
import { ansNumber } from '@/utils'
import _ from 'lodash'

const initSearchItem = {
  inq_item_class_div: -1,
  remove_process: true
}

const addRow = () => {
  props.sizePrices.push({
    idx: -1,
    item_cd: '',
    color_cd: '',
    item_nm: '',
    size_cd: '',
    price_list: 0,
    retail_upr: undefined,
    is_new: true
  } as ISizesPrice)
}

const removeRow = (i: number) => {
  const tmpPrice = _.cloneDeep(props.sizePrices[i])

  if (!tmpPrice.is_new) {
    props.addToDeletePrice(tmpPrice)
  } else {
    ansValidate.removeAllErrors()
  }
  props.sizePrices.splice(i, 1)
}

const changeColor = (idx: number) => {
  props.getProduct(
    {
      item_cd: props.sizePrices[idx].item_cd,
      color_cd: props.sizePrices[idx].color_cd
    },
    `sizesPrice.${idx}.color_cd`,
    idx
  )
}

const changeItem = (
  newValue?: IAnsDynamic | null,
  oldValue?: IAnsDynamic | null,
  index?: string | number
) => {
  const idx = ansNumber.toNumber(`${index ?? '-1'}`)
  props.sizePrices[idx].idx = idx
  props.sizePrices[idx].item_cd = newValue?.item_cd ?? ''
  props.sizePrices[idx].color_cd = newValue?.color_cd ?? ''
  props.getProduct(
    {
      item_cd: props.sizePrices[idx].item_cd,
      color_cd: props.sizePrices[idx].color_cd
    },
    `sizePrices.${idx}.item_cd`,
    idx
  )
}

const clearError = (idx: number) => {
  ansValidate.removeError(`sizePrices.${idx}.item_cd`)
  ansValidate.removeError(`sizePrices.${idx}.color_cd`)
  ansValidate.removeError(`sizePrices.${idx}.size_cd`)
  ansValidate.removeError(`sizePrices.${idx}.price_list`)
  ansValidate.removeError(`sizePrices.${idx}.retail_upr`)
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
              <th class="col-item">商品コード</th>
              <th class="col-color">色コード</th>
              <th class="col-item-nm">商品名-色名</th>
              <th class="col-size">サイズ</th>
              <th class="col-price-list">価格表区分</th>
              <th class="col-retail-upr">販売単価</th>
              <th class="col-remove"></th>
            </tr>
          </thead>
          <tbody>
            <template v-for="(sizePrice, idx) in sizePrices" :key="idx">
              <tr>
                <td class="col-add text-center">{{ idx + 1 }}</td>
                <td class="col-item have-input">
                  <AnsInputSearch
                    :id="`sizePrices.${idx}.item_cd`"
                    :maxLength="30"
                    :isDisabled="sizePrice.is_new !== true"
                    propertyForId="item_cd"
                    propertyForName="item_nm"
                    :value="sizePrice"
                    :index="idx"
                    :initData="initSearchItem"
                    pageSearch="M101L"
                    :onChangeEvent="changeItem"
                  />
                </td>
                <td class="col-color have-input">
                  <AnsInput
                    :id="`sizePrices.${idx}.color_cd`"
                    type="text"
                    :maxLength="10"
                    :isDisabled="sizePrice.is_new !== true"
                    v-model="sizePrice.color_cd"
                    :onChangeEvent="() => changeColor(idx)"
                  />
                </td>
                <td class="col-item-nm have-input">
                  <AnsInput
                    :id="`sizePrices.${idx}.item_nm`"
                    type="text"
                    :isDisabled="true"
                    :value="`${sizePrice.item_nm ?? ''}${
                      ansCommon.isEmpty(sizePrice.color_nm) ? '' : '-'
                    }${sizePrice.color_nm ?? ''}`"
                  />
                </td>
                <td class="col-size text-center have-input">
                  <AnsSelect
                    v-if="sizePrice.is_new === true"
                    :id="`sizePrices.${idx}.size_cd`"
                    :options="sizePrice.sizes"
                    :isDisabled="false"
                    v-model="sizePrice.size_cd"
                    :onChangeEvent="() => clearError(idx)"
                  />
                  <AnsInput
                    v-else
                    :id="`sizePrices.${idx}.size_cd`"
                    :isDisabled="true"
                    v-model="sizePrice.size_cd"
                  />
                </td>
                <td class="col-price-list have-input">
                  <AnsSelect
                    :id="`sizePrices.${idx}.price_list`"
                    :options="price_list"
                    v-model="sizePrice.price_list"
                    :isDisabled="sizePrice.is_new !== true"
                    :onChangeEvent="() => clearError(idx)"
                  />
                </td>
                <td class="col-retail-upr have-input">
                  <AnsInput
                    type="money"
                    :id="`sizePrices.${idx}.retail_upr`"
                    v-model="sizePrice.retail_upr"
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
