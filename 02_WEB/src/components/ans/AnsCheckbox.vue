<script setup lang="ts">
import { computed } from 'vue'
import { v4 } from 'uuid'
import _ from 'lodash'
import { ansCommon, ansValidate } from '@/utils'

// Define props
// ------------------------------------------------------------------------------------------------
const props = withDefaults(defineProps<IAnsCheckboxProps>(), {
  isInline: true
})
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
    const val = props.modelValue ? props.modelValue : props.value
    return val
  },
  set() {}
})
const isShowLabel = computed(() => {
  return !ansCommon.isEmpty(props.label)
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
const disabledOption = (id: string | number) => {
  if (props.isDisabled) {
    return true
  }
  const idx = _.findIndex(props.disabledOptions ?? [], (x: IOption) => {
    return `${x.code ?? ''}` === `${id ?? ''}`
  })
  if (idx > -1) {
    return true
  }
  return false
}
const selectedOption = (id: string | number) => {
  const idx = _.findIndex(viewValue.value ?? [], function (o: string | number) {
    return `${o ?? ''}` === `${id ?? ''}`
  })
  if (idx < 0) {
    return false
  } else {
    return true
  }
}
const updateInput = (e: Event) => {
  const oldValue = [...(viewValue.value ?? [])]
  const tmpValue = [...oldValue]
  const option = _.find(props.options, (x: IOption) => {
    return `${x.code ?? ''}` === `${(e.target as HTMLInputElement)?.value ?? ''}`
  })
  const idx = _.findIndex(tmpValue, function (o: string | number) {
    return `${o ?? ''}` === `${option?.code ?? ''}`
  })
  if (idx < 0) {
    tmpValue.push(option?.code ?? '')
  } else {
    tmpValue.splice(idx, 1)
  }
  emit('update:modelValue', tmpValue)
  ansValidate.removeInputError(inputName.value)
  if (props.onChangeEvent) {
    props.onChangeEvent(tmpValue, oldValue, e)
  }
}
const isShowLabelOption = (str: string | number) => {
  return !ansCommon.isEmpty(str)
}
// ------------------------------------------------------------------------------------------------
</script>

<template>
  <div
    class="row ans-item ans-checkbox"
    :class="`${itemClass ?? ''} ${error.isError ? 'have-error' : ''}`"
  >
    <div class="col-sm-4 ans-item-label" :class="labelClass ?? ''" v-if="isShowLabel">
      <span>{{ label }}</span>
    </div>
    <div
      class="ans-item-control"
      :class="`${isShowLabel ? 'col-sm-8' : 'col-sm-12'} ${inputClass ?? ''}`"
    >
      <div
        class="form-check"
        :class="{ 'form-switch': isSwitch, inline: isInline }"
        v-for="(option, i) in options"
        :key="i"
      >
        <input
          type="checkbox"
          class="form-check-input"
          :class="{ required: isRequired, 'item-error': error.isError }"
          :id="`${inputId}_${i}`"
          :name="inputName"
          :value="option.code"
          :disabled="disabledOption(option.code)"
          :checked="selectedOption(option.code)"
          @change="updateInput"
        />
        <label
          class="form-check-label"
          :class="{ required: isRequired }"
          :for="`${inputId}_${i}`"
          v-if="isShowLabelOption(option.name)"
          >{{ option.name }}</label
        >
        <b-tooltip
          :target="`${inputId}_${i}`"
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
