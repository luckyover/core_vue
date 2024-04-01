<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { v4 } from 'uuid'
import { ansCommon, ansNumber, ansValidate } from '@/utils'
import { Loader } from '@googlemaps/js-api-loader'
import type { google } from 'google-maps'
import _ from 'lodash'

// Define props
// ------------------------------------------------------------------------------------------------
const props = withDefaults(defineProps<IAnsInputProps>(), {
  type: 'text',
  decimal: 2,
  autofocus: false
})
const emit = defineEmits(['update:modelValue'])
// ------------------------------------------------------------------------------------------------

// Define helper function
// ------------------------------------------------------------------------------------------------
const getRealMaxLength = () => {
  if (props.maxLength) {
    let maxLength = props.maxLength
    if (props.isNegative) {
      maxLength += 1
    }
    if (props.type === 'zipcode') {
      maxLength += 1
    }
    if (props.isDecimal) {
      maxLength += 1
    }
    if (props.type === 'money') {
      const length = props.maxLength - (props.isDecimal ? props.decimal : 0)
      maxLength += Math.floor(length / 3) + (length % 3 > 0 ? 0 : -1)
    }
    return maxLength
  }
  return undefined
}

const convertNumber = (str?: string | number) => {
  if (ansCommon.isEmpty(str)) {
    return ''
  }
  let value = str + ''
  if (props.type === 'number' || props.type === 'money') {
    value = ansNumber.toNumberString(value, {
      isDecimal: props.isDecimal,
      decimal: props.decimal,
      isNegative: props.isNegative,
      isMoney: props.type === 'money',
      maxLength: props.maxLength
    })
  }
  return value
}

const limitInputFollowType = (e: KeyboardEvent) => {
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
      (e.ctrlKey && (e.key === 'c' || e.key === 'v' || e.key === 'a')) ||
      ((props.isNegative || props.type === 'zipcode') && e.key === '-') ||
      (props.isDecimal && e.key === '.') ||
      (props.type === 'tel' &&
        (e.key === '+' || e.key === '(' || e.key === ')' || e.key === '-' || e.key === ' ')) ||
      (props.type === 'alphabet' &&
        ((e.key >= 'a' && e.key <= 'z') || (e.key >= 'A' && e.key <= 'Z')))
    )
  ) {
    e.preventDefault()
    return false
  }
  return true
}
// ------------------------------------------------------------------------------------------------

// Define data
// ------------------------------------------------------------------------------------------------
const uuid = v4()
const buttonUuid = v4()
const isFocus = ref(false)
const realMaxLength = ref(getRealMaxLength())
const key = ref(0)
let geocoder: any = null
// ------------------------------------------------------------------------------------------------

// Define computed
// ------------------------------------------------------------------------------------------------
const viewValue = computed({
  get() {
    const val = convertNumber(!ansCommon.isEmpty(props.modelValue) ? props.modelValue : props.value)
    if (isFocus.value && !props.isDisabled && !props.isReadonly) {
      return props.type === 'money' ? val.replace(/,/g, '') : val
    }
    return val
  },
  set() {}
})
const isShowLabel = computed(() => {
  return !ansCommon.isEmpty(props.label)
})
const isShowLabelBefore = computed(() => {
  return !ansCommon.isEmpty(props.labelBefore)
})
const isShowLabelAfter = computed(() => {
  return !ansCommon.isEmpty(props.labelAfter)
})
const isShowIconBefore = computed(() => {
  return !ansCommon.isEmpty(props.iconBefore)
})
const inputId = computed(() => {
  return ansCommon.isEmpty(props.id) ? uuid : props.id
})
const inputName = computed(() => {
  return ansCommon.isEmpty(props.name) ? inputId.value : props.name
})
const buttonLocalId = computed(() => {
  return ansCommon.isEmpty(props.buttonId) ? buttonUuid : props.buttonId
})
const error = computed(() => {
  return ansValidate.getInputError(inputName.value)
})
// ------------------------------------------------------------------------------------------------

// Define mounted
// ------------------------------------------------------------------------------------------------
onMounted(() => {
  realMaxLength.value = getRealMaxLength()
  if (props.type === 'zipcode') {
    const loader = new Loader({
      apiKey: import.meta.env.VITE_GOOGLE_API_KEY
    })
    loader.importLibrary('maps').then(() => {
      geocoder = new google.maps.Geocoder()
      return ''
    })
  }
})
// ------------------------------------------------------------------------------------------------

// Define method
// ------------------------------------------------------------------------------------------------
const focusInput = (e: FocusEvent) => {
  // (e.target as HTMLInputElement | HTMLTextAreaElement)?.select();
  isFocus.value = true
  inputKeyup(e)
  if (props.onFocusEvent) {
    props.onFocusEvent(e)
  }
}
const blurInput = (e: FocusEvent) => {
  isFocus.value = false
  realMaxLength.value = getRealMaxLength()
  if (props.onBlurEvent) {
    props.onBlurEvent(e)
  }
}
const inputKeydown = (e: KeyboardEvent) => {
  if (['number', 'money', 'tel'].includes(props.type)) {
    return limitInputFollowType(e)
  }
  return true
}
const inputKeyup = (e: KeyboardEvent | FocusEvent) => {
  if (!props.maxLength || !(props.type === 'number' || props.type === 'money')) {
    return true
  }
  let maxLength = props.maxLength
  const target = e.target as HTMLInputElement
  if (target?.value.indexOf('-') >= 0) {
    maxLength += 1
  }
  if (target?.value.indexOf('.') >= 0) {
    maxLength += 1
  }
  target?.setAttribute('maxlength', `${maxLength}`)
  return true
}
const updateInput = (e: Event) => {
  const oldValue = viewValue.value
  const val = convertNumber((e.target as HTMLInputElement | HTMLTextAreaElement)?.value)
  let value: string | number =
    props.type === 'money'
      ? val.replace(/,/g, '')
      : props.type === 'katakana'
        ? val.replace(/[^ァ-ンーｧ-ﾝﾞﾟ0-9]/gi, '')
        : props.type === 'alphabet'
          ? val.replace(/[^a-zA-Z0-9]/gi, '')
          : val
  if ((props.type === 'money' || props.type === 'number') && !ansCommon.isEmpty(value)) {
    value = ansNumber.toNumber(value)
  }
  if (props.type === 'zipcode') {
    value = ansCommon.toZipCode(`${value}`)
  }
  if (oldValue !== value) {
    emit('update:modelValue', value)
    ansValidate.removeInputError(inputName.value)
    if (props.onChangeEvent) {
      props.onChangeEvent(value, oldValue, e)
    }
    if (props.type === 'zipcode' && props.onGetAddress) {
      ;(geocoder as any).geocode({ address: value, language: 'jp' }, (result: any) => {
        let addressStr = ''
        if (result.length > 0) {
          const address = result[0].address_components
          if (address) {
            const prefecture = _.find(address, (x) => {
              return x.types.indexOf('administrative_area_level_1') > -1
            })
            if (prefecture) {
              const locality = _.find(address, (x) => {
                return x.types.indexOf('locality') > -1
              })
              const sublocality_level_1 = _.find(address, (x) => {
                return x.types.indexOf('sublocality_level_1') > -1
              })
              const sublocality_level_2 = _.find(address, (x) => {
                return x.types.indexOf('sublocality_level_2') > -1
              })
              addressStr = `${prefecture?.long_name ?? ''}${locality?.long_name ?? ''}${
                sublocality_level_1?.long_name ?? ''
              }${sublocality_level_2?.long_name ?? ''}`
            }
          }
        }
        if (props.onGetAddress) {
          props.onGetAddress(addressStr)
        }
      })
    }
  }
  key.value++
}
// ------------------------------------------------------------------------------------------------
</script>

<template>
  <div
    class="row ans-item ans-input"
    :class="`${itemClass ?? ''} ${error.isError ? 'have-error' : ''}`"
  >
    <div class="col-sm-4 ans-item-label" :class="labelClass ?? ''" v-if="isShowLabel">
      <span>{{ label }}</span>
    </div>
    <div
      class="ans-item-control"
      :class="`${isShowLabel ? 'col-sm-8' : 'col-sm-12'} ${inputClass ?? ''}`"
    >
      <div :class="{ 'group-label': isShowLabelBefore || isShowLabelAfter }">
        <span class="label-before" v-if="isShowLabelBefore">{{ labelBefore }}</span>
        <div :class="{ 'input-group': isInputGroup, 'have-icon-before': isShowIconBefore }">
          <textarea
            v-if="type === 'textarea'"
            v-model="viewValue"
            :placeholder="placeholder ?? ''"
            :id="inputId"
            :name="inputName"
            class="form-control form-control-sm"
            :class="{ required: isRequired, 'item-error': error.isError }"
            :rows="rows ?? 1"
            :cols="cols ?? 1"
            :maxlength="realMaxLength"
            :required="isRequired"
            :disabled="isDisabled"
            :readonly="isReadonly"
            :renderCount="key"
            autocomplete="off"
            @focus="focusInput"
            @blur="blurInput"
            @change="updateInput"
          ></textarea>
          <input
            v-else
            v-model="viewValue"
            :type="
              ['money', 'number', 'zipcode'].includes(type)
                ? 'tel'
                : type != 'katakana' && type != 'alphabet'
                  ? type
                  : 'text'
            "
            :placeholder="placeholder ?? ''"
            :id="inputId"
            :name="inputName"
            class="form-control form-control-sm"
            :class="{
              required: isRequired,
              money: type === 'money',
              number: type === 'number',
              'icon-before': isShowIconBefore,
              'item-error': error.isError
            }"
            :required="isRequired"
            :disabled="isDisabled"
            :readonly="isReadonly"
            :maxlength="realMaxLength"
            :renderCount="key"
            :autofocus="autofocus"
            autocomplete="off"
            @focus="focusInput"
            @blur="blurInput"
            @change="updateInput"
            @keydown="inputKeydown"
            @keyup="inputKeyup"
          />
          <b-tooltip
            ref="tooltip"
            :target="inputId"
            class="custom-error"
            placement="top-start"
            :delay="0"
            :no-fade="true"
            v-if="error.isError"
          >
            {{ error.error }}
          </b-tooltip>
          <button
            :id="buttonLocalId"
            type="button"
            class="btn"
            :class="buttonClass ? buttonClass : 'btn-primary'"
            :disabled="isDisabledButton"
            @click="onClickEvent"
            v-if="isInputGroup"
          >
            <span :class="icon"></span>
          </button>
          <i
            class="input-icon"
            :class="iconBefore"
            v-if="isShowIconBefore && !iconBeforeIsText"
          ></i>
          <i class="input-icon with-text" v-if="isShowIconBefore && iconBeforeIsText">{{
            iconBefore
          }}</i>
        </div>
        <span class="label-after" v-if="isShowLabelAfter">{{ labelAfter }}</span>
      </div>
    </div>
  </div>
</template>
