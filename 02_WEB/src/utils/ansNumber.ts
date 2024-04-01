import ansCommon from '@/utils/ansCommon'
const ansNumber = {
  toNumber: (str: string | undefined | null, isDefaultIsMax: boolean = false): number => {
    const defaultVal = isDefaultIsMax ? 4294967295 : 0
    if (str === undefined || str === null || str === '') {
      return defaultVal
    }
    let result = parseInt(str ?? '0')
    if (isNaN(result)) {
      result = parseFloat(str ?? '0')
    }
    if (isNaN(result)) {
      return defaultVal
    }
    return result
  },
  toNumberString: (
    str?: string | number,
    options: {
      isDecimal?: boolean
      decimal: number
      isNegative?: boolean
      isMoney: boolean
      maxLength?: number
    } = { decimal: 2, isMoney: true }
  ) => {
    if (ansCommon.isEmpty(str)) {
      return ''
    }
    let value = str + ''
    let values = []
    let negative = ''
    let dot = ''
    let afterDot = ''
    if (options.isNegative && value.startsWith('-')) {
      negative = '-'
      value = value.substring(1, value.length)
    }
    values = value.split('.')
    values[0] = values[0].replace(/\D/g, '')
    if (values.length > 1) {
      afterDot = values[1].replace(/\D/g, '')
      if (afterDot.length > options.decimal) {
        afterDot = afterDot.substring(0, options.decimal)
      }
      dot = '.'
    }
    if (ansCommon.isEmpty(values[0]) && (values.length === 1 || ansCommon.isEmpty(afterDot))) {
      return ''
    }
    if (
      options.isDecimal &&
      options.maxLength &&
      options.decimal > 0 &&
      afterDot === '' &&
      value.length > options.maxLength - options.decimal
    ) {
      dot = '.'
      afterDot = values[0].substring(options.maxLength - options.decimal, value.length)
      values[0] = values[0].substring(0, options.maxLength - options.decimal)
    }
    if (ansCommon.isEmpty(values[0])) {
      values[0] = '0'
    }
    if (options.isMoney) {
      values[0] = values[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',')
    }
    options.isDecimal
      ? (value = negative + values[0] + dot + afterDot)
      : (value = negative + values[0])
    return value
  }
}

export default ansNumber
