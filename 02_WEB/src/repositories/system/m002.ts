import type { ISearchCondition, IUser } from '@/types/system/m002'
import ansAxios from '../ansAxios'
const resource: string = 'system/m002'
export default {
  getInitData: () => {
    return ansAxios.get(`${resource}/data/init`)
  },
  getDetail: (user_cd?: string | null) => {
    return ansAxios.get(`${resource}/${encodeURIComponent(user_cd ?? 0)}`)
  },
  search: (params?: ISearchCondition) => {
    return ansAxios.get(`${resource}`, {
      params: params
    })
  },
  save: (user: IUser) => {
    return ansAxios.post(`${resource}`, user)
  },
  delete: (user_cd?: string | null) => {
    return ansAxios.delete(`${resource}/${encodeURIComponent(user_cd ?? 0)}`)
  }
}
