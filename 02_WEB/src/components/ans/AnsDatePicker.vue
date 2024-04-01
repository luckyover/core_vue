<script setup lang="ts">
import { computed, ref } from 'vue'
// import * as $ from "jquery";
// import "jquery-ui";
import { v4 } from 'uuid'
import _ from 'lodash'
import type { DatePickerInstance } from '@vuepic/vue-datepicker'
import moment from 'moment'
import { ansCommon, ansDateTime, ansValidate } from '@/utils'

// Define props
// ------------------------------------------------------------------------------------------------
const props = withDefaults(defineProps<IAnsDatePickerProps>(), {
  buttonIcon: 'fa-solid fa-calendar-days',
  calendarPosition: 'center'
})
const emit = defineEmits(['update:modelValue'])
// ------------------------------------------------------------------------------------------------

// Define data
// ------------------------------------------------------------------------------------------------
const uuid = v4()
const datePicker = ref<DatePickerInstance>(null)
const inputDate = ref<HTMLInputElement | null>(null)
const realMaxLength = ref(props.isMonthPicker ? 7 : 10)
const count = ref(0)
// ------------------------------------------------------------------------------------------------

// Define computed
// ------------------------------------------------------------------------------------------------
const viewValue = computed({
  get() {
    const val = props.modelValue !== undefined ? props.modelValue : props.value
    return props.isMonthPicker ? ansDateTime.toMonthString(val) : ansDateTime.toDateString(val)
  },
  set() {}
})
const calendarValue = computed({
  get() {
    const val = ansDateTime.toDateString(
      props.modelValue !== undefined ? props.modelValue : props.value
    )
    const tmpDate = ansCommon.isEmpty(val) ? moment() : moment(val, 'YYYY/MM/DD')
    return props.isMonthPicker
      ? ({
          year: tmpDate.year(),
          month: tmpDate.month()
        } as IAnsDatePickerYearMonth)
      : val
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
      e.key === '/' ||
      (e.ctrlKey && (e.key === 'c' || e.key === 'v' || e.key === 'a'))
    )
  ) {
    e.preventDefault()
    return false
  }
  return true
}

const inputKeyup = (e: KeyboardEvent | FocusEvent) => {
  let maxLength = props.isMonthPicker ? 6 : 8
  const target = e.target as HTMLInputElement
  const countSplash = _.countBy(target?.value ?? '')['/'] || 0
  if (countSplash > 2 && !props.isMonthPicker) {
    maxLength += 2
  } else if (countSplash > 1 && props.isMonthPicker) {
    maxLength += 1
  } else {
    maxLength += countSplash
  }
  document.getElementById(`${inputId.value}`)?.setAttribute('maxlength', `${maxLength}`)
  return true
}
const updateValue = (e: Event) => {
  const val = (e.target as HTMLInputElement)?.value
  changeModel(props.isMonthPicker ? ansDateTime.toMonthString(val) : ansDateTime.toDateString(val))
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
  datePicker?.value?.openMenu()
  setTimeout(() => {
    document.getElementById(inputId.value ?? '')?.focus()
  }, 100)
}
const dateClicked = (date: Date) => {
  const tmpDate = moment(date)
  if (tmpDate.isValid()) {
    changeModel(!props.isMonthPicker ? tmpDate.format('YYYY/MM/DD') : tmpDate.format('YYYY/MM'))
  } else {
    changeModel('')
  }
}
const handleMonthYear = (data: IAnsDatePickerYearMonth) => {
  if (!props.isMonthPicker) {
    return
  }
  changeModel(moment(`${data.year}-${data.month + 1}-1`, 'YYYY-M-D').format('YYYY/MM'))
}
// ------------------------------------------------------------------------------------------------
</script>

<template>
  <div
    class="row ans-item ans-date-picker"
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
        class="input-group date input-group-sm"
        :class="{ 'month-picker': isMonthPicker, 'full-width': isFullWidth }"
      >
        <input
          type="tel"
          :id="inputId"
          :name="inputName"
          class="form-control form-control-sm show-date"
          :class="{ required: isRequired, 'item-error': error.isError }"
          :value="viewValue"
          :placeholder="placeholder"
          :maxlength="realMaxLength"
          @keydown="limitInput"
          @keyup="inputKeyup"
          @change="updateValue"
          @focus="clickShowCalendar"
          :key="count"
          :readonly="isReadonly"
          :disabled="isDisabled"
          ref="inputDate"
          autocomplete="off"
        />
        <VueDatePicker
          v-model="calendarValue"
          :id="pickerId"
          ref="datePicker"
          class="hide-date"
          :position="calendarPosition"
          :readonly="isReadonly"
          :disabled="isDisabled"
          :enableTimePicker="false"
          :autoApply="true"
          locale="ja"
          :weekStart="0"
          :monthPicker="isMonthPicker"
          @dateUpdate="dateClicked"
          @updateMonthYear="handleMonthYear"
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
