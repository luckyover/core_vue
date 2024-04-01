<script setup lang="ts">
import { computed } from 'vue'
import _ from 'lodash'
import { ansCommon, ansDateTime, ansValidate } from '@/utils'

// Define props
// ------------------------------------------------------------------------------------------------
const props = withDefaults(defineProps<IAnsDateRangerProps>(), {
  buttonIcon: 'fa-solid fa-calendar-days',
  calendarPosition: 'center',
  propertyDateFrom: 'date_fr',
  propertyDateTo: 'date_to',
  isFullWidth: true
})
const emit = defineEmits(['update:modelValue'])
// ------------------------------------------------------------------------------------------------

// Define computed
// ------------------------------------------------------------------------------------------------
const viewValue = computed({
  get() {
    const val = props.modelValue !== undefined ? props.modelValue : props.value
    return val ?? {}
  },
  set() {}
})

const dateFrom = computed({
  get() {
    return _.get(viewValue.value, props.propertyDateFrom, '')
  },
  set(value) {
    const old = _.cloneDeep(viewValue.value)
    _.set(viewValue.value, props.propertyDateFrom, value ?? '')
    updateValue(viewValue.value, old)
  }
})

const dateTo = computed({
  get() {
    return _.get(viewValue.value, props.propertyDateTo, '')
  },
  set(value) {
    const old = _.cloneDeep(viewValue.value)
    _.set(viewValue.value, props.propertyDateTo, value ?? '')
    updateValue(viewValue.value, old)
  }
})

const isShowLabel = computed(() => {
  return !ansCommon.isEmpty(props.label)
})
// ------------------------------------------------------------------------------------------------

// Define method
// ------------------------------------------------------------------------------------------------
const updateValue = (newValue: IAnsDynamic, oldValue: IAnsDynamic) => {
  const newDateFrom = _.get(newValue, props.propertyDateFrom, '')
  const newDateTo = _.get(newValue, props.propertyDateTo, '')
  const oldDateFrom = _.get(oldValue, props.propertyDateFrom, '')
  const oldDateTo = _.get(oldValue, props.propertyDateTo, '')
  if (newDateFrom != oldDateFrom || newDateTo != oldDateTo) {
    emit('update:modelValue', newValue)
    ansValidate.removeInputError(props.propertyDateFrom)
    ansValidate.removeInputError(props.propertyDateTo)
    if (props.onChangeEvent) {
      props.onChangeEvent(newValue, oldValue)
    }
    if (
      !ansCommon.isEmpty(newDateFrom) &&
      !ansCommon.isEmpty(newDateTo) &&
      ansDateTime.compareDate(newDateFrom, newDateTo) < 0
    ) {
      ansValidate.addItemError(props.propertyDateFrom, 'E014')
      setTimeout(() => {
        ansValidate.addItemError(props.propertyDateTo, 'E014')
      }, 100)
    }
  }
}
// ------------------------------------------------------------------------------------------------
</script>

<template>
  <div class="row ans-item ans-date-ranger">
    <div class="col-sm-4 ans-item-label" :class="labelClass ?? ''" v-if="isShowLabel">
      <span>{{ label }}</span>
    </div>
    <div class="ans-item-control" :class="`${isShowLabel ? 'col-sm-8' : 'col-sm-12'}`">
      <div class="date-ranger-container">
        <AnsDatePicker
          :id="propertyDateFrom"
          v-model="dateFrom"
          :itemClass="itemClass"
          :inputClass="inputClass"
          :labelClass="labelClass"
          :isReadonly="isReadonly"
          :isDisabled="isDisabled"
          :isRequired="isRequired"
          :buttonClass="buttonClass"
          :buttonIcon="buttonIcon"
          :isMonthPicker="isMonthPicker"
          :isFullWidth="isFullWidth"
          :calendarPosition="calendarPosition"
        />
        <div class="split">〜</div>
        <AnsDatePicker
          :id="propertyDateTo"
          v-model="dateTo"
          :itemClass="itemClass"
          :inputClass="inputClass"
          :labelClass="labelClass"
          :isReadonly="isReadonly"
          :isDisabled="isDisabled"
          :isRequired="isRequired"
          :buttonClass="buttonClass"
          :buttonIcon="buttonIcon"
          :isMonthPicker="isMonthPicker"
          :isFullWidth="isFullWidth"
          :calendarPosition="calendarPosition"
        />
      </div>
    </div>
  </div>
</template>
