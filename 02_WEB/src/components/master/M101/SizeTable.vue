<script setup lang="ts">
import { computed } from 'vue'
import draggable from 'vuedraggable'
import type { ISize, ITableSizeProps } from '@/types/master/m101'
import _ from 'lodash'
const props = withDefaults(defineProps<ITableSizeProps>(), {})

const sizesData = computed({
  get() {
    return [...props.sizes]
  },
  set(value) {
    props.updateSizes(value)
  }
})

const addRow = () => {
  props.sizes.push({
    item_cd: props.product.item_cd,
    color_cd: props.product.color_cd,
    size_cd: '',
    discontinued_div: 0,
    discontinued_display_div: 0,
    sort_div: 0
  } as ISize)
}

const removeRow = (i: number) => {
  props.sizes.splice(i, 1)
}

const changeDiscontinuedDiv = (idx: number) => {
  props.sizes[idx].discontinued_display_div = 0
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
              <th class="col-size">サイズ</th>
              <th class="col-discontinued_div">廃番</th>
              <th class="col-discontinued_display_div">廃番表示</th>
              <th class="col-remove"></th>
            </tr>
          </thead>
          <draggable v-model="sizesData" tag="tbody" item-key="sort_div" handle=".draggable">
            <template #item="{ element, index }: { element: ISize; index: number }">
              <tr>
                <td class="col-add text-center draggable">{{ index + 1 }}</td>
                <td class="col-size have-input">
                  <AnsInput
                    type="text"
                    :id="`sizes.${index}.size_cd`"
                    :maxLength="10"
                    :required="true"
                    v-model="element.size_cd"
                  />
                </td>
                <td class="col-discontinued_div have-input">
                  <AnsSelect
                    :id="`sizes.${index}.discontinued_div`"
                    :options="discontinued_div"
                    v-model="element.discontinued_div"
                    :onChangeEvent="() => changeDiscontinuedDiv(index)"
                  />
                </td>
                <td class="col-discontinued_display_div have-input">
                  <AnsSelect
                    :id="`sizes.${index}.discontinued_display_div`"
                    :options="discontinued_display_div"
                    :isDisabled="element.discontinued_div !== 1"
                    v-model="element.discontinued_display_div"
                  />
                </td>
                <td class="col-remove">
                  <button
                    type="button"
                    class="btn btn-danger btn-remove"
                    @click="
                      () => {
                        removeRow(index)
                      }
                    "
                  >
                    <i class="fas fa-times"></i>
                  </button>
                </td>
              </tr>
            </template>
          </draggable>
        </table>
      </div>
    </div>
  </div>
</template>
