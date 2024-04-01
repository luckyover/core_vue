import { ansNumber } from '@/utils'
import type { ISearchCondition, ISupplier } from '@/types/master/m006'
import ansAxios from '../ansAxios'
const resource: string = 'master/m006'
export default {
  getInitData: () => {
    return ansAxios.get(`${resource}/data/init`)
  },
  getDetail: (supplier_cd?: number | null) => {
    return ansAxios.get(`${resource}/${isNaN(supplier_cd ?? 0) ? 0 : supplier_cd}`)
  },
  search: (params?: ISearchCondition) => {
    return ansAxios.get(`${resource}`, {
      params: params
    })
  },
  save: (supplier: ISupplier) => {
    return ansAxios.post(`${resource}`, {
      ...supplier,
      supplier_cd: isNaN(supplier.supplier_cd ?? 0) ? 0 : supplier.supplier_cd ?? 0
    })
  },
  delete: (supplier_cd?: number | null) => {
    return ansAxios.delete(`${resource}/${isNaN(supplier_cd ?? 0) ? 0 : supplier_cd}`)
  }
}
