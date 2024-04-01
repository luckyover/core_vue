import type { IDelivery, ISearchCondition } from '@/types/master/m005'
import ansAxios from '../ansAxios'
const resource: string = 'master/m005'
export default {
  getDetail: (delivery_cd?: number | null) => {
    return ansAxios.get(`${resource}/${isNaN(delivery_cd ?? 0) ? 0 : delivery_cd ?? 0}`)
  },
  search: (params?: ISearchCondition) => {
    return ansAxios.get(`${resource}`, {
      params: params
    })
  },
  save: (delivery: IDelivery) => {
    return ansAxios.post(`${resource}`, {
      ...delivery,
      delivery_cd: isNaN(delivery.delivery_cd ?? 0) ? 0 : delivery.delivery_cd ?? 0
    })
  },
  delete: (delivery_cd?: number | null) => {
    return ansAxios.delete(`${resource}/${isNaN(delivery_cd ?? 0) ? 0 : delivery_cd ?? 0}`)
  }
}
