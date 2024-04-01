import type { IProductCost, IProductCostSearch } from '@/types/master/m202'
import ansAxios from '../ansAxios'
import _ from 'lodash'
const resource: string = 'master/m202'
export default {
  search: (params?: IProductCostSearch) => {
    return ansAxios.get(`${resource}`, {
      params: params
    })
  },
  save: (costs: Array<IProductCost>, deleteCost: Array<IProductCost>) => {
    return ansAxios.post(`${resource}`, {
      costs: _.filter(costs, (x: IProductCost) => {
        return x.is_new
      }),
      updCost: _.filter(costs, (x: IProductCost) => {
        return !x.is_new
      }),
      delCost: deleteCost
    })
  },
  delete: (costs: Array<IProductCost>) => {
    return ansAxios.delete(`${resource}/0`, {
      params: {
        costs: _.filter(costs, (x: IProductCost) => {
          return !x.is_new
        })
      }
    })
  }
}
