import type { IAnsFunction, IProfile } from '@/types/app'
import ansCommon from './ansCommon'
import { useAppStore } from '@/stores/app'
import _ from 'lodash'

const ansIdentity = {
  parseJwt(token?: string | null): IAnsDynamic {
    if (!ansCommon.isEmpty(token)) {
      var base64Url = token?.split('.')[1]
      var base64 = base64Url?.replace(/-/g, '+').replace(/_/g, '/')
      var jsonPayload = decodeURIComponent(
        window
          .atob(base64 ?? '')
          .split('')
          .map(function (c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2)
          })
          .join('')
      )
      return JSON.parse(jsonPayload) as IAnsDynamic
    }
    return {} as IAnsDynamic
  },
  getUserFromToken: (): IProfile => {
    try {
      const token = localStorage.getItem('token')
      const data = ansIdentity.parseJwt(token)
      const logindata = JSON.parse(data.logindata ?? '{}')
      return logindata as IProfile
    } catch (e) {
      console.log('getUserFromToken: ' + (e as Error).message)
    }
    return {} as IProfile
  },
  isViewFnc: (fnc: IAnsFunction) => {
    return fnc.fnc_cd === 'view' || fnc.fnc_cd === 'menu_disp'
  },
  canShowButton(id: string) {
    console.log(id)
    const patterns = id.split('-')
    if (patterns.length < 2) {
      return false
    }
    const length = patterns.length
    const appStore = useAppStore()
    const fnc = _.find(appStore.functions ?? [], (x: IAnsFunction) => {
      return x.prg_cd === patterns[length - 2] && x.fnc_cd === patterns[length - 1]
    })
    if (fnc && fnc.fnc_use_div !== true) {
      return false
    }
    return true
  }
}
export default ansIdentity
