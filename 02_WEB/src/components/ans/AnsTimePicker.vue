<script setup lang="ts">
import { computed, ref } from 'vue'
import moment from 'moment'
import { v4 } from 'uuid'
import _ from 'lodash'
import type { DatePickerInstance } from '@vuepic/vue-datepicker'
import { ansCommon, ansDateTime, ansValidate } from '@/utils'

// Define props
// ------------------------------------------------------------------------------------------------
const props = withDefaults(defineProps<IAnsTimePickerProps>(), {
  buttonIcon: 'fa-regular fa-clock',
  calendarPosition: 'center'
})
const emit = defineEmits(['update:modelValue'])
// ------------------------------------------------------------------------------------------------

// Define data
// ------------------------------------------------------------------------------------------------
const uuid = v4()
const timePicker = ref<DatePickerInstance>(null)
const inputTime = ref<HTMLInputElement | null>(null)
const realMaxLength = ref(5)
const count = ref(0)
// ------------------------------------------------------------------------------------------------

// Define computed
// ------------------------------------------------------------------------------------------------
const viewValue = computed({
  get() {
    const val = props.modelValue !== undefined ? props.modelValue : props.value
    return ansDateTime.toTimeString(val)
  },
  set() {}
})
const calendarValue = computed({
  get() {
    const val = ansDateTime.toTimeString(
      props.modelValue !== undefined ? props.modelValue : props.value
    )
    const tmpDate = ansCommon.isEmpty(val)
      ? moment()
      : moment(`${moment().format('YYYY/MM/DD')} ${val}:00`, 'YYYY/MM/DD HH:mm:ss')
    return {
      hours: tmpDate.hours(),
      minutes: tmpDate.minutes()
    } as IAnsTimePickerTime
  },
  set() {}
})
const isShowLabel = computed(() => {
  return !ansCommon.isEmpty(props.label)
})
const inputId = computed(() => {
  return ansCommon.isEmpty(props.id) ? uuid : props.id
})
const pickerId = computed(() => {
  return `${inputId.value}_picker`
})
const pickerInputId = computed(() => {
  return `${inputId.value}_picker-input`
})
const buttonId = computed(() => {
  return `${inputId.value}_btn`
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
const limitInput = (e: KeyboardEvent) => {
  if (
    !(
      (e.key >= '0' && e.key <= '9') ||
      e.key === 'F5' ||
      e.key === 'Delete' ||
      e.key === 'ArrowRight' ||
      e.key === 'ArrowLeft' ||
      e.key === 'End' ||
      e.key === 'Home' ||
      e.key === 'Backspace' ||
      e.key === 'Tab' ||
      e.key === 'Enter' ||
      e.key === ':' ||
      (e.ctrlKey && (e.key === 'c' || e.key === 'v' || e.key === 'a'))
    )
  ) {
    e.preventDefault()
    return false
  }
  return true
}

const inputKeyup = (e: KeyboardEvent | FocusEvent) => {
  let maxLength = 4
  const target = e.target as HTMLInputElement
  const countSplash = _.countBy(target?.value ?? '')[':'] || 0
  if (countSplash > 0) {
    maxLength += 1
  }
  document.getElementById(`${inputId.value}`)?.setAttribute('maxlength', `${maxLength}`)
  return true
}
const updateValue = (e: Event) => {
  const val = (e.target as HTMLInputElement)?.value
  changeModel(ansDateTime.toTimeString(val))
}
const changeModel = (val: string | undefined | null) => {
  const oldValue = viewValue.value
  if ((oldValue ?? '') != (val ?? '')) {
    emit('update:modelValue', val)
    ansValidate.removeInputError(inputName.value)
    if (props.onChangeEvent) {
      props.onChangeEvent(val, oldValue)
    }
  }
  count.value++
}
const clickShowCalendar = () => {
  timePicker?.value?.openMenu()
}
const handleTime = (time: IAnsTimePickerTime) => {
  changeModel(
    `${time.hours < 10 ? '0' : ''}${time.hours}:${time.minutes < 10 ? '0' : ''}${time.minutes}`
  )
}
// ------------------------------------------------------------------------------------------------
</script>

<template>
  <div
    class="row ans-item ans-time-picker"
    :class="`${itemClass ?? ''} ${error.isError ? 'have-error' : ''}`"
  >
    <div class="col-sm-4 ans-item-label" :class="labelClass ?? ''" v-if="isShowLabel">
      <span>{{ label }}</span>
    </div>
    <div
      class="ans-item-control"
      :class="`${isShowLabel ? 'col-sm-8' : 'col-sm-12'} ${inputClass ?? ''}`"
    >
      <div class="input-group time input-group-sm">
        <input
          type="tel"
          :id="inputId"
          :name="inputName"
          class="form-control form-control-sm show-time"
          :class="{ required: isRequired, 'item-error': error.isError }"
          :value="viewValue"
          :placeholder="placeholder"
          :maxlength="realMaxLength"
          @keydown="limitInput"
          @keyup="inputKeyup"
          @change="updateValue"
          :key="count"
          :readonly="isReadonly"
          :disabled="isDisabled"
          ref="inputTime"
        />
        <VueDatePicker
          v-model="calendarValue"
          :id="pickerId"
          ref="timePicker"
          class="hide-time"
          :position="calendarPosition"
          :readonly="isReadonly"
          :disabled="isDisabled"
          :timePicker="true"
          locale="ja"
          :cancelText="'キャンセル'"
          :selectText="'選択'"
          autocomplete="off"
          @update:model-value="handleTime"
        >
          <template #dp-input="{ value }">
            <input type="text" :value="value" :tabindex="-1" :readonly="true" :id="pickerInputId" />
          </template>
        </VueDatePicker>
        <button
          class="btn btn-primary btn-date"
          :class="buttonClass"
          :id="buttonId"
          type="button"
          @click="clickShowCalendar"
          :disabled="isDisabled"
        >
          <span :class="buttonIcon"></span>
        </button>
      </div>
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
