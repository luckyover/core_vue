<script setup lang="ts">
import { computed } from 'vue'
import { v4 } from 'uuid'
import _ from 'lodash'
import { ansCommon, ansValidate } from '@/utils'

// Define props
// ------------------------------------------------------------------------------------------------
const props = withDefaults(defineProps<IAnsSelectProps>(), {
  emptyText: '',
  options: () => []
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
const listOptions = computed((): IOption[] => {
  if (!props.options || props.options.length === 0) {
    if (props.isRemoveEmpty) {
      return []
    }
    return [
      {
        code: 0,
        name: props.emptyText
      }
    ]
  }
  const tmpOptions = _.clone(props.options)
  const idx = _.findIndex(tmpOptions, function (o: IOption) {
    return (
      !o.name ||
      o.code === 0 ||
      `${o.name}`.trim() === '' ||
      `${o.name}`.trim() === props.emptyText ||
      `${o.name}`.trim() === 'すべて' ||
      `${o.name}`.trim() === '全て'
    )
  })
  if (idx < 0 && !props.isRemoveEmpty) {
    tmpOptions.unshift({
      code: 0,
      name: props.emptyText
    })
  }
  if (idx >= 0 && props.isRemoveEmpty) {
    tmpOptions.splice(idx, 1)
  }
  return tmpOptions
})
// ------------------------------------------------------------------------------------------------

// Define method
// ------------------------------------------------------------------------------------------------
const focusInput = (e: FocusEvent) => {
  if (props.onFocusEvent) {
    props.onFocusEvent(e)
  }
}
const blurInput = (e: FocusEvent) => {
  if (props.onBlurEvent) {
    props.onBlurEvent(e)
  }
}
const updateInput = (e: Event) => {
  const oldValue = viewValue.value
  const option = _.find(listOptions.value, (x: IOption) => {
    return `${x.code ?? ''}` === `${(e.target as HTMLSelectElement)?.value ?? ''}`
  })
  if (`${oldValue ?? ''}` !== `${option?.code ?? ''}`) {
    emit('update:modelValue', option?.code)
    ansValidate.removeInputError(inputName.value)
    if (props.onChangeEvent) {
      props.onChangeEvent(option?.code, oldValue, e)
    }
  }
}
// ------------------------------------------------------------------------------------------------
</script>

<template>
  <div
    class="row ans-item ans-select"
    :class="`${itemClass ?? ''} ${error.isError ? 'have-error' : ''}`"
  >
    <div class="col-sm-4 ans-item-label" :class="labelClass ?? ''" v-if="isShowLabel">
      <span>{{ label }}</span>
    </div>
    <div
      class="ans-item-control"
      :class="`${isShowLabel ? 'col-sm-8' : 'col-sm-12'} ${inputClass ?? ''}`"
    >
      <select
        :id="inputId"
        :name="inputName"
        class="form-select form-select-sm"
        :class="{ required: isRequired, 'item-error': error.isError }"
        :required="isRequired"
        :disabled="isDisabled"
        :readonly="isReadonly"
        @focus="focusInput"
        @blur="blurInput"
        @change="updateInput"
      >
        <option
          v-for="(option, i) in listOptions"
          :key="i"
          :value="option.code"
          :selected="`${option.code}` === `${viewValue}`"
        >
          {{ option.name }}
        </option>
      </select>
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
</template>
