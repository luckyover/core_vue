import type { ICustomer, ISearchCondition } from '@/types/master/m004'
import ansAxios from '../ansAxios'
const resource: string = 'master/m004'
export default {
  getInitData: () => {
    return ansAxios.get(`${resource}/data/init`)
  },
  getDetail: (customer_cd?: number | null) => {
    return ansAxios.get(`${resource}/${isNaN(customer_cd ?? 0) ? 0 : customer_cd ?? 0}`)
  },
  search: (params?: ISearchCondition) => {
    return ansAxios.get(`${resource}`, {
      params: params
    })
  },
  save: (customer: ICustomer) => {
    return ansAxios.post(`${resource}`, {
      ...customer,
      customer_cd: isNaN(customer.customer_cd ?? 0) ? 0 : customer.customer_cd
    })
  },
  delete: (customer_cd?: number | null) => {
    return ansAxios.delete(`${resource}/${isNaN(customer_cd ?? 0) ? 0 : customer_cd ?? 0}`)
  }
}
