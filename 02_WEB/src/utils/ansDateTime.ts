import moment from 'moment'
import ansCommon from './ansCommon'
import ansNumber from './ansNumber'
const ansDateTime = {
  toDateString: (str: string | undefined | null): string => {
    if (str === undefined || str === null || str === '') {
      return ''
    }
    const tempStr = str.replace(/\D/g, '')
    if (tempStr.length < 5) {
      return ''
    }
    const year = tempStr.substring(0, 4)
    let month = `0${tempStr.substring(4, 5)}`
    let day = '01'
    if (tempStr.length >= 6) {
      month = tempStr.substring(4, 6)
    }
    if (tempStr.length === 7) {
      day = `0${tempStr.substring(6, 7)}`
    }
    if (tempStr.length >= 8) {
      day = tempStr.substring(6, 8)
    }
    const tempDate = moment(`${year}-${month}-${day}`)
    if (!tempDate.isValid()) {
      return ''
    }
    return tempDate.format('YYYY/MM/DD')
  },
  toMonthString: (str: string | undefined | null): string => {
    if (str === undefined || str === null || str === '') {
      return ''
    }
    const tempStr = str.replace(/\D/g, '')
    if (tempStr.length < 4) {
      return ''
    }
    const year = tempStr.substring(0, 4)
    let month = '01'
    if (tempStr.length == 5) {
      month = `0${tempStr.substring(4, 5)}`
    }
    if (tempStr.length >= 6) {
      month = tempStr.substring(4, 6)
    }
    const tempDate = moment(`${year}-${month}-01`)
    if (!tempDate.isValid()) {
      return ''
    }
    return tempDate.format('YYYY/MM')
  },
  toTimeString: (str: string | undefined | null, isOnly24h: boolean = false): string => {
    if (str === undefined || str === '' || str === null) {
      return ''
    }
    const tempStr = str.replace(/\D/g, '')
    if (tempStr.length == 0) {
      return '00:00'
    }
    if (tempStr.length == 1) {
      return '00:0' + tempStr
    }
    if (tempStr.length == 2) {
      return '00:' + tempStr
    }
    let timeStr =
      (tempStr.substring(0, tempStr.length - 2).length == 1
        ? '0' + tempStr.substring(0, tempStr.length - 2)
        : tempStr.substring(0, tempStr.length - 2)) +
      ':' +
      tempStr.substring(tempStr.length - 2, tempStr.length)
    if (isOnly24h) {
      const tempDate = moment(
        `${moment().format('YYYY/MM/DD')} ${timeStr}:00`,
        'YYYY/MM/DD HH:mm:ss'
      )
      if (!tempDate.isValid()) {
        return ''
      }
    }
    return timeStr
  },
  plusTime(time1?: string | null, time2?: string | null): string {
    if (ansCommon.isEmpty(time1) && ansCommon.isEmpty(time2)) {
      return '00:00'
    }
    if (ansCommon.isEmpty(time1)) {
      return ansDateTime.toTimeString(time2)
    }
    if (ansCommon.isEmpty(time2)) {
      return ansDateTime.toTimeString(time1)
    }
    const time1Split = ansDateTime.toTimeString(time1).split(':')
    const time2Split = ansDateTime.toTimeString(time2).split(':')
    const time1Minute =
      parseInt(time1Split[0].replace(/\D/g, '')) * 60 + parseInt(time1Split[1].replace(/\D/g, ''))
    const time2Minute =
      parseInt(time2Split[0].replace(/\D/g, '')) * 60 + parseInt(time2Split[1].replace(/\D/g, ''))
    const sum = time1Minute + time2Minute
    const totalHour = Math.floor(sum / 60)
    const totalMinute = sum % 60
    return `${totalHour < 10 ? '0' : ''}${totalHour}:${totalMinute < 10 ? '0' : ''}${totalMinute}`
  },
  minusTime(time1?: string | null, time2?: string | null): string {
    if (ansCommon.isEmpty(time1) && ansCommon.isEmpty(time2)) {
      return '00:00'
    }
    const time1Split = ansDateTime.toTimeString(time1).split(':')
    const time2Split = ansDateTime.toTimeString(time2).split(':')
    const time1Minute =
      parseInt(time1Split[0].replace(/\D/g, '')) * 60 + parseInt(time1Split[1].replace(/\D/g, ''))
    const time2Minute =
      parseInt(time2Split[0].replace(/\D/g, '')) * 60 + parseInt(time2Split[1].replace(/\D/g, ''))
    const sum = time2Minute - time1Minute
    const negative = sum < 0 ? '-' : ''
    const totalHour = Math.floor(Math.abs(sum) / 60)
    const totalMinute = Math.abs(sum) % 60
    return `${negative}${totalHour < 10 ? '0' : ''}${totalHour}:${
      totalMinute < 10 ? '0' : ''
    }${totalMinute}`
  },
  compareTime(time1?: string | null, time2?: string | null) {
    if (ansCommon.isEmpty(time1) || ansCommon.isEmpty(time2)) {
      return 1
    }
    if (time1 === time2) {
      return 0
    }
    const time1Split = ansDateTime.toTimeString(time1).split(':')
    const time2Split = ansDateTime.toTimeString(time2).split(':')
    const time1Minute =
      parseInt(time1Split[0].replace(/\D/g, '')) * 60 + parseInt(time1Split[1].replace(/\D/g, ''))
    const time2Minute =
      parseInt(time2Split[0].replace(/\D/g, '')) * 60 + parseInt(time2Split[1].replace(/\D/g, ''))
    const minus = time2Minute - time1Minute
    return minus > 0 ? 1 : minus === 0 ? 0 : -1
  },
  compareDate(date1?: string | null, date2?: string | null) {
    if (ansCommon.isEmpty(date1) || ansCommon.isEmpty(date2)) {
      return 1
    }
    if (date1 === date2) {
      return 0
    }
    const from = moment(`${date1?.replace(/\//g, '-')} 00:00:00`)
    const to = moment(`${date2?.replace(/\//g, '-')} 00:00:00`)
    if (from < to) {
      return 1
    }
    if (from === to) {
      return 0
    }
    return -1
  },
  compareMonth(month1?: string | null, month2?: string | null) {
    if (ansCommon.isEmpty(month1) || ansCommon.isEmpty(month2)) {
      return 1
    }
    if (month1 === month2) {
      return 0
    }
    const from = moment(`${month1?.replace(/\//g, '-')}-01 00:00:00`)
    const to = moment(`${month2?.replace(/\//g, '-')}-01 00:00:00`)
    if (from < to) {
      return 1
    }
    if (from === to) {
      return 0
    }
    return -1
  },
  getDayOfWeek(day?: number) {
    try {
      if (!day) {
        day = moment().day()
      }
      return ['日', '月', '火', '水', '木', '金', '土'][day]
    } catch (e) {
      console.log('getDayOfWeek' + (e as Error).message)
    }
    return ''
  },
  getAbsoluteMonths(momentDate?: moment.Moment | string | null) {
    if (ansCommon.isEmpty(momentDate)) {
      momentDate = moment()
    }
    if (typeof momentDate === 'string') {
      momentDate = moment(`${momentDate?.replace(/\//g, '-')} 00:00:00`)
    }
    if (!(momentDate as moment.Moment).isValid()) {
      momentDate = moment()
    }
    const months = ansNumber.toNumber(momentDate?.format('MM'))
    const years = ansNumber.toNumber(momentDate?.format('YYYY'))
    return months + years * 12
  },
  monthDiff(start?: moment.Moment | string | null, end?: moment.Moment | string | null) {
    const startMonths = ansDateTime.getAbsoluteMonths(start)
    const endMonths = ansDateTime.getAbsoluteMonths(end)
    return endMonths - startMonths
  }
}

export default ansDateTime
