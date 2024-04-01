import type { ICost, ISearchCondition } from '@/types/master/m302'
import ansAxios from '../ansAxios'
import _ from 'lodash'
const resource: string = 'master/m302'
export default {
  getInitData: () => {
    return ansAxios.get(`${resource}/data/init`)
  },
  search: (params?: ISearchCondition) => {
    return ansAxios.get(`${resource}`, {
      params: params
    })
  },
  save: (costs: Array<ICost>, deleteCost: Array<ICost>) => {
    return ansAxios.post(`${resource}`, {
      costs: _.filter(costs, (x: ICost) => {
        return x.is_new
      }),
      update_costs: _.filter(costs, (x: ICost) => {
        return !x.is_new
      }),
      delete_costs: deleteCost
    })
  },
  delete: (costs: Array<ICost>) => {
    return ansAxios.delete(`${resource}/0`, {
      params: {
        costs: _.filter(costs, (x: ICost) => {
          return !x.is_new
        })
      }
    })
  }
}
