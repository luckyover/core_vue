import type { IItem, IItemKey, ISize } from '@/types/master/m101'
import type { IProcessPrice, ISearchCondition } from '@/types/master/m301'
import ansAxios from '../ansAxios'
const resource: string = 'master/m301'
import _ from 'lodash'
export default {
  getInitData: () => {
    return ansAxios.get(`${resource}/data/init`)
  },
  getDetail: (params: IItemKey) => {
    return []
  },
  search: (params: ISearchCondition) => {
    return ansAxios.get(`${resource}`, {
      params: params
    })
  },
  save: (processPrice: Array<IProcessPrice>, deletePrices: Array<IProcessPrice>) => {
    return ansAxios.post(`${resource}`, {
      process_prices: _.filter(processPrice, (x: IProcessPrice) => {
        return x.is_new
      }),
      update_process_prices: _.filter(processPrice, (x: IProcessPrice) => {
        return !x.is_new
      }),
      delete_process_price: deletePrices
    })
  },
  delete: (processPrice: Array<IProcessPrice>) => {
    return ansAxios.delete(`${resource}/0`, {
      params: {
        process_prices: _.filter(processPrice, (x: IProcessPrice) => {
          return !x.is_new
        })
      }
    })
  }
}
