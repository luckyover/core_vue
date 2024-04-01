<script setup lang="ts">
import { ref, computed, onUnmounted } from 'vue'
import { v4 } from 'uuid'
import _ from 'lodash'
import ansAxios from '@/repositories/ansAxios'
import { ansCommon, ansValidate } from '@/utils'
import { useAppStore } from '@/stores/app'

// import popup
import M002L from '@/views/popup/M002L.vue'
import M004L from '@/views/popup/M004L.vue'
import M005L from '@/views/popup/M005L.vue'
import M006L from '@/views/popup/M006L.vue'
import M101L from '@/views/popup/M101L.vue'

// Define props
// ------------------------------------------------------------------------------------------------
const props = withDefaults(defineProps<IAnsInputSearchProps>(), {
  popupSize: 'lg',
  propertyForId: 'code',
  propertyForName: 'name',
  buttonClass: 'btn-search',
  buttonIcon: 'fas fa-search',
  buttonClearClass: 'btn-clear',
  buttonClearIcon: 'fas fa-times',
  popupLevel: 1,
  popupClass: '',
  isReferName: true,
  isShowSuggestSearch: true
})
const emit = defineEmits(['update:modelValue'])
const appStore = useAppStore()
// ------------------------------------------------------------------------------------------------

// Define data
// ------------------------------------------------------------------------------------------------
const uuid = v4()
const showPopup = ref(false)
const noRefer = ref(false)
const count = ref(0)
const selectedIndex = ref(-1)
const dropdown = ref(null)
const suggestSearch = ref<Array<IAnsSuggestSearch>>([])
// ------------------------------------------------------------------------------------------------

// Define computed
// ------------------------------------------------------------------------------------------------
const data = computed({
  get() {
    const val = props.modelValue ? props.modelValue : props.value
    return val ?? {}
  },
  set() {}
})
const showName = computed(() => {
  return _.get(data.value, props.propertyForName, '')
})
const showId = computed(() => {
  return _.get(data.value, props.propertyForId, '')
})
const viewValue = computed({
  get() {
    return props.isShowNameInInput ? showName.value : showId.value
  },
  set() {}
})
const isShowLabel = computed(() => {
  return !ansCommon.isEmpty(props.label)
})
const inputId = computed(() => {
  return ansCommon.isEmpty(props.id) ? uuid : props.id
})
const buttonId = computed(() => {
  return `${inputId.value}_btn-search`
})
const buttonClearId = computed(() => {
  return `${inputId.value}_btn-clear`
})
const popupId = computed(() => {
  return `${inputId.value}_popup`
})
const inputName = computed(() => {
  return ansCommon.isEmpty(props.name) ? inputId.value : props.name
})
const error = computed(() => {
  return ansValidate.getInputError(inputName.value)
})
const popup = computed((): typeof M006L | undefined => {
  switch (props.pageSearch) {
    case 'M002L':
      return M002L
    case 'M004L':
      return M004L
    case 'M005L':
      return M005L
    case 'M006L':
      return M006L
    case 'M101L':
      return M101L
    default:
      return undefined
  }
})
const title = computed((): string => {
  if (props.popupTitle) {
    return props.popupTitle
  }
  switch (props.pageSearch) {
    case 'M002L':
      return 'ユーザー選択'
    case 'M004L':
      return '得意先選択'
    case 'M005L':
      return '納品先選択'
    case 'M006L':
      return '仕入先選択'
    case 'M101L':
      return '商品選択'
    default:
      return ''
  }
})
const urlForReferName = computed((): string => {
  if (props.urlReferName) {
    return props.urlReferName
  }
  switch (props.pageSearch) {
    case 'M002L':
      return '/system/m002'
    case 'M004L':
      return '/master/m004'
    case 'M005L':
      return '/master/m005'
    case 'M006L':
      return '/master/m006'
    case 'M101L':
      return '/master/m101/data/refer'
    default:
      return ''
  }
})
const urlForSuggestSearch = computed((): string => {
  if (props.urlSuggestSearch) {
    return props.urlSuggestSearch
  }
  switch (props.pageSearch) {
    case 'M002L':
      return '/system/m002/data/suggest'
    case 'M004L':
      return '/master/m004/data/suggest'
    case 'M005L':
      return '/master/m005/data/suggest'
    case 'M006L':
      return '/master/m006/data/suggest'
    case 'M101L':
      return '/master/m101/data/suggest'
    default:
      return ''
  }
})
// ------------------------------------------------------------------------------------------------

// Define method
// ------------------------------------------------------------------------------------------------
const openSuggestSearch = () => {
  ;(dropdown.value as any)?.open()
}

const closeSuggestSearch = () => {
  ;(dropdown.value as any)?.close()
  selectedIndex.value === -1
  noRefer.value = false
}
const onHidePopup = (focusBack: boolean = true) => {
  showPopup.value = false
  if (focusBack) {
    setTimeout(() => {
      document.getElementById(inputId.value ?? '')?.focus()
    }, 300)
  }
}
const onShowPopup = () => {
  showPopup.value = true
}
const updateInput = (item?: IAnsDynamic) => {
  closeSuggestSearch()
  if (props.onChangeEvent) {
    const oldValue = { ...data.value }
    props.onChangeEvent(item, oldValue, props.index)
  } else {
    emit('update:modelValue', item)
  }
  ansValidate.removeInputError(inputName.value)
  count.value++
}
const changeInput = (e: Event) => {
  if (noRefer.value) {
    return false
  }
  closeSuggestSearch()
  const referUrl = urlForReferName.value
  const value = { ...data.value }
  const elm = e.target as HTMLInputElement
  if (props.isReferName && !ansCommon.isEmpty(referUrl) && !ansCommon.isEmpty(elm?.value)) {
    appStore.setNoLoading(true)
    ansAxios
      .get(`${referUrl}/${elm?.value}`, {
        params: {
          ...(props.initData ?? {})
        }
      })
      .then((res) => {
        const { data } = res
        let item = {}
        if (data.code === 200 && data.data) {
          item = data.data
        }
        updateInput(item)
      })
      .finally(() => {
        appStore.setNoLoading(false)
      })
  } else {
    if (props.isShowNameInInput) {
      _.set(value, props.propertyForName, elm?.value ?? '')
      _.set(value, props.propertyForId, '')
    } else {
      _.set(value, props.propertyForId, elm?.value ?? '')
      _.set(value, props.propertyForName, '')
    }
    updateInput(value)
  }
}

const getSuggestSearch = (e: Event) => {
  const suggestSearchUrl = urlForSuggestSearch.value
  const elm = e.target as HTMLInputElement
  if (
    props.isShowSuggestSearch &&
    !ansCommon.isEmpty(suggestSearchUrl) &&
    !ansCommon.isEmpty(elm?.value)
  ) {
    appStore.setNoLoading(true)
    ansAxios
      .get(`${suggestSearchUrl}`, {
        params: {
          search: elm?.value,
          ...(props.initData ?? {})
        }
      })
      .then((res) => {
        const { data } = res
        suggestSearch.value = data.data ?? []
        suggestSearch.value.length > 0 ? openSuggestSearch() : closeSuggestSearch()
      })
      .finally(() => {
        appStore.setNoLoading(false)
      })
  } else {
    suggestSearch.value = []
    closeSuggestSearch()
  }
  return true
}

const clickItem = (idx: number) => {
  const value = { ...data.value }
  const item = suggestSearch.value[idx]
  if (item) {
    _.set(value, props.propertyForId, item?.code ?? '')
    _.set(value, props.propertyForName, item?.name ?? '')
    if (props.pageSearch === 'M101L') {
      _.set(value, 'color_cd', item?.value1 ?? '')
      _.set(value, 'color_nm', item?.value2 ?? '')
    }
    updateInput(value)
  }
}

const selectItem = (e: KeyboardEvent) => {
  if (e.key === 'ArrowUp') {
    e.preventDefault()
    const index = selectedIndex.value - 1
    selectedIndex.value = index < 0 ? suggestSearch.value.length : index
    return false
  }
  if (e.key === 'ArrowDown') {
    e.preventDefault()
    const index = selectedIndex.value + 1
    selectedIndex.value = index > suggestSearch.value.length - 1 ? 0 : index
    return false
  }
  if (
    e.key === 'Enter' &&
    selectedIndex.value >= 0 &&
    selectedIndex.value <= suggestSearch.value.length
  ) {
    e.preventDefault()
    clickItem(selectedIndex.value)
    noRefer.value = true
    return false
  }
  return true
}
// ------------------------------------------------------------------------------------------------

// Defined unmounted
// ------------------------------------------------------------------------------------------------
onUnmounted(() => {
  onHidePopup(false)
  suggestSearch.value = []
  closeSuggestSearch()
})

// ------------------------------------------------------------------------------------------------
</script>

<template>
  <div
    class="row ans-item ans-input-search"
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
        class="input-group input-group-sm"
        :class="{
          'show-clear': isShowClearButton,
          'show-label': isShowNameInLabel
        }"
      >
        <input
          type="text"
          class="form-control"
          :readonly="isDisabledInput"
          :class="{
            required: isRequired,
            'item-error': error.isError
          }"
          autocomplete="off"
          :placeholder="placeholder"
          :id="inputId"
          :name="inputName"
          :required="isRequired"
          :value="viewValue"
          :maxlength="maxLength"
          :disabled="isDisabled"
          :key="count"
          @change="changeInput"
          @input="getSuggestSearch"
          @keydown="selectItem"
        />
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
        <button
          type="button"
          :id="buttonId"
          class="btn btn-primary"
          :class="buttonClass"
          :disabled="isDisabled"
          @click="onShowPopup"
        >
          <span :class="buttonIcon"></span>
        </button>
        <button
          v-if="isShowClearButton"
          type="button"
          :id="buttonClearId"
          class="btn"
          :class="buttonClearClass"
          :disabled="isDisabled"
          @click="
            () => {
              updateInput()
            }
          "
        >
          <span :class="buttonClearIcon"></span>
        </button>
      </div>
      <span
        v-if="isShowNameInLabel"
        class="show-text-input-search"
        :class="{
          required: isRequired,
          'show-clear': isShowClearButton
        }"
        :for="inputId"
        ><AnsTooltipSpan :value="showName"
      /></span>
    </div>
    <b-dropdown
      ref="dropdown"
      class="suggest-search"
      :no-caret="true"
      @mouseover="
        () => {
          noRefer = true
        }
      "
      @mouseout="
        () => {
          noRefer = false
        }
      "
    >
      <template v-for="(item, idx) in suggestSearch" :key="idx">
        <b-dropdown-item
          :link-class="{ selected: selectedIndex === idx }"
          @click="
            () => {
              clickItem(idx)
            }
          "
        >
          <span class="line1">
            {{ item.name }}
          </span>
          <span class="line2">
            <span class="name" :class="{ 'no-description': ansCommon.isEmpty(item.subTitle) }">
              {{ item.code }}
            </span>
            <span class="description"> {{ item.subTitle }}</span>
          </span>
        </b-dropdown-item>
      </template>
    </b-dropdown>
  </div>
  <b-modal
    v-model="showPopup"
    hide-header
    hide-footer
    class="ans-popup-search"
    :size="popupSize"
    :no-close-on-backdrop="true"
    :no-close-on-esc="true"
    :id="popupId"
    v-if="pageSearch"
    :class="`${popupClass ?? ''} ${pageSearch ?? ''}`"
  >
    <div class="ans-popup-search-header">
      <h5 class="modal-title">{{ title }}</h5>
      <button
        type="button"
        class="btn-close-popup"
        aria-label="Close"
        @click="
          () => {
            onHidePopup(false)
          }
        "
      >
        ×
      </button>
    </div>
    <div class="custom-modal-body popupSearch-body" v-if="showPopup && popup">
      <component
        :is="popup"
        :initData="initData"
        :onSelected="updateInput"
        :onClose="onHidePopup"
      ></component>
    </div>
  </b-modal>
</template>
