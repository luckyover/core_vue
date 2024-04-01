import type { ISizesPrice, ISearchCondition } from '@/types/master/m201'
import ansAxios from '../ansAxios'
import _ from 'lodash'
const resource: string = 'master/m201'
export default {
  getInitData: () => {
    return ansAxios.get(`${resource}/data/init`)
  },
  search: (params: ISearchCondition) => {
    return ansAxios.get(`${resource}`, {
      params: params
    })
  },
  save: (sizePrices: Array<ISizesPrice>, deletePrices: Array<ISizesPrice>) => {
    return ansAxios.post(`${resource}`, {
      sizes_prices: _.filter(sizePrices, (x: ISizesPrice) => {
        return x.is_new
      }),
      update_sizes_prices: _.filter(sizePrices, (x: ISizesPrice) => {
        return !x.is_new
      }),
      delete_sizes_price: deletePrices
    })
  },
  delete: (sizePrices: Array<ISizesPrice>) => {
    return ansAxios.delete(`${resource}/0`, {
      params: {
        sizes_prices: _.filter(sizePrices, (x: ISizesPrice) => {
          return !x.is_new
        })
      }
    })
  }
}
