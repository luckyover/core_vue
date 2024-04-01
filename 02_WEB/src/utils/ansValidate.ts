import _ from 'lodash'
import { useAppStore } from '@/stores/app'
import SysMsg from '@/utils/messages'
import ansCommon from '@/utils/ansCommon'
import ansNumber from '@/utils/ansNumber'
import { ansDateTime } from '.'
const ansValidate = {
  getInputError: (name?: string): IInputError => {
    const error: IInputError = {
      errors: []
    }
    if (!ansCommon.isEmpty(name)) {
      const appStore = useAppStore()
      const errorsCode: Array<string> = appStore.itemErrors[name ?? ''] ?? []
      const length = errorsCode.length
      for (let i = 0; i < length; i++) {
        const errorCodePatterns = errorsCode[i].split('|')
        let message = _.get(SysMsg, errorCodePatterns[0], errorCodePatterns[0])
        if (errorCodePatterns.length > 1) {
          for (let j = 0; j < errorCodePatterns.length - 1; j++) {
            message = message.replace(`{${j}}`, errorCodePatterns[j + 1])
          }
        }
        if (!ansCommon.isEmpty(message)) {
          if (ansCommon.isEmpty(error.error)) {
            error.error = message
          }
          error.errors?.push(message)
        }
        error.isError = true
      }
    }
    return error
  },
  removeInputError: (name?: string): void => {
    const appStore = useAppStore()
    appStore.removeItemError(name ?? '')
  },
  isEmail: (str?: string | null) => {
    if (ansCommon.isEmpty(str)) {
      return true
    }
    return str
      ?.toLowerCase()
      .match(
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      )
  },
  isPhone: (str?: string | null) => {
    if (ansCommon.isEmpty(str)) {
      return true
    }
    return str?.toLowerCase().match(/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})$/)
  },
  isZipCode: (str?: string | null) => {
    if (ansCommon.isEmpty(str)) {
      return true
    }
    return str?.toLowerCase().match(/^\d{3}-\d{4}$/)
  },
  isKatakana: (str?: string | null) => {
    if (ansCommon.isEmpty(str)) {
      return true
    }
    return str?.toLowerCase().match(/[ァ-ンｧ-ﾝﾞﾟー]$/)
  },
  isValidData: (data: IAnsDynamic, rules: IAnsValidateRule) => {
    try {
      const appStore = useAppStore()
      appStore.removeErrors()
      for (const key in rules) {
        if (Object.prototype.hasOwnProperty.call(rules, key)) {
          const value = _.get(rules, key, '')
          const values = value.split('|')
          const length = values.length
          for (let i = 0; i < length; i++) {
            const rule = values[i]
            const checks = rule.split(':')
            let checkVal = _.get(data, key, '')
            if (typeof checkVal === 'string') {
              checkVal = checkVal.trim().replace(/　/g, '')
            }
            if (typeof checkVal === 'number' && isNaN(checkVal)) {
              checkVal = ''
            }
            if (
              checks[0] === 'required' &&
              (ansCommon.isEmpty(checkVal) ||
                (typeof checkVal === 'object' && Object.keys(checkVal).length === 0))
            ) {
              appStore.addItemError(key, 'E001')
            }
            if (
              checks[0] === 'required' &&
              checks.length > 1 &&
              checks[1] === 'checkZero' &&
              checkVal.toString() === '0'
            ) {
              appStore.addItemError(key, 'E001')
            }
            if (checks[0] === 'email' && !ansValidate.isEmail(checkVal)) {
              appStore.addItemError(key, 'E002')
            }
            if (checks[0] === 'phone' && !ansValidate.isPhone(checkVal)) {
              appStore.addItemError(key, 'E003')
            }
            if (checks[0] === 'zipCode' && !ansValidate.isZipCode(checkVal)) {
              appStore.addItemError(key, 'E004')
            }
            if (checks[0] === 'katakana' && !ansValidate.isKatakana(checkVal)) {
              appStore.addItemError(key, 'E005')
            }
            if (checks[0] === 'gt' && checks.length > 1) {
              const configVal = ansNumber.toNumber(checks[1])
              if (ansNumber.toNumber(checkVal) < configVal) {
                appStore.addItemError(key, `E006|${configVal}`)
              }
            }
            if (checks[0] === 'lt' && checks.length > 1) {
              const configVal = ansNumber.toNumber(checks[1])
              if (ansNumber.toNumber(checkVal) > configVal) {
                appStore.addItemError(key, `E007|${configVal}`)
              }
            }
            if (checks[0] === 'date-lt' && checks.length > 1) {
              const configKey = checks[1]
              const configVal = _.get(data, configKey, '')
              if (ansDateTime.compareDate(checkVal, configVal) < 0) {
                appStore.addItemError(key, 'E014')
                appStore.addItemError(configKey, 'E014')
              }
            }
          }
        }
      }
      if (Object.keys(appStore.itemErrors).length === 0) {
        return true
      }
      setTimeout(() => {
        ansValidate.focusFirstError()
      }, 100)
      return false
    } catch (e: any) {
      console.log('validData: ' + e.message)
      return false
    }
  },
  removeAllErrors: () => {
    const appStore = useAppStore()
    appStore.removeErrors()
  },
  focusFirstError: () => {
    const itemErrors = document.querySelectorAll('.item-error')
    if (itemErrors.length > 0) {
      ;(itemErrors[0] as HTMLElement).focus()
    }
  },
  removeError: (item: string) => {
    const appStore = useAppStore()
    appStore.removeItemError(item)
  },
  addItemError: (item: string, errors?: string | string[]) => {
    const appStore = useAppStore()
    appStore.addItemError(item, errors)
  }
}
export default ansValidate
