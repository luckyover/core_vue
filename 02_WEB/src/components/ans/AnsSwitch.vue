<script setup lang="ts">
import { computed } from 'vue'
import { v4 } from 'uuid'
import _ from 'lodash'
import { ansCommon, ansValidate } from '@/utils'

// Define props
// ------------------------------------------------------------------------------------------------
const props = withDefaults(defineProps<IAnsSwitchProps>(), {})
const emit = defineEmits(['update:modelValue'])
// ------------------------------------------------------------------------------------------------

// Define data
// ------------------------------------------------------------------------------------------------
const uuid = v4()
// ------------------------------------------------------------------------------------------------

// Define computed
// ------------------------------------------------------------------------------------------------
const viewValue = computed({
  get() {
    const val = props.modelValue !== undefined ? props.modelValue : props.value
    return val === 1 || val === '1' || val === true
  },
  set() {}
})
const isShowLabel = computed(() => {
  return !ansCommon.isEmpty(props.label)
})
const isShowLabelAfter = computed(() => {
  return !ansCommon.isEmpty(props.labelAfter)
})
const inputId = computed(() => {
  return ansCommon.isEmpty(props.id) ? uuid : props.id
})
const inputName = computed(() => {
  return ansCommon.isEmpty(props.name) ? inputId.value : props.name
})
const error = computed(() => {
  return ansValidate.getInputError(inputName.value)
})
// ------------------------------------------------------------------------------------------------

// Define method
// ------------------------------------------------------------------------------------------------
const updateInput = (e: Event) => {
  const oldValue = props.modelValue !== undefined ? props.modelValue : props.value
  const val = !viewValue.value
  const newValue =
    typeof oldValue === 'string'
      ? val
        ? '1'
        : '0'
      : typeof oldValue === 'number'
        ? val
          ? 1
          : 0
        : val
  emit('update:modelValue', newValue)
  ansValidate.removeInputError(inputName.value)
  if (props.onChangeEvent) {
    props.onChangeEvent(newValue, oldValue, e)
  }
}
// ------------------------------------------------------------------------------------------------
</script>

<template>
  <div
    class="row ans-item ans-switch"
    :class="`${itemClass ?? ''} ${error.isError ? 'have-error' : ''}`"
  >
    <div class="col-sm-4 ans-item-label" :class="labelClass ?? ''" v-if="isShowLabel">
      <span>{{ label }}</span>
    </div>
    <div
      class="ans-item-control"
      :class="`${isShowLabel ? 'col-sm-8' : 'col-sm-12'} ${inputClass ?? ''}`"
    >
      <div class="form-check" :class="{ 'form-switch': !isCheckbox }">
        <input
          type="checkbox"
          class="form-check-input"
          :class="{ required: isRequired, 'item-error': error.isError }"
          :id="inputId"
          :name="inputName"
          :disabled="isDisabled"
          :checked="viewValue"
          @click="updateInput"
        />
        <label
          class="form-check-label"
          :class="{ required: isRequired }"
          :for="inputId"
          v-if="isShowLabelAfter"
          >{{ labelAfter }}</label
        >
        <b-tooltip
          :target="inputId"
          class="custom-error"
          placement="top-start"
          :delay="0"
          :no-fade="true"
          v-if="error.isError"
        >
          {{ error.error }}
        </b-tooltip>
      </div>
    </div>
  </div>
</template>
