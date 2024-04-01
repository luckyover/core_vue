import type { IItem, IItemKey, ISearchCondition, ISize } from '@/types/master/m101'
import ansAxios from '../ansAxios'
import _ from 'lodash'
const resource: string = 'master/m101'
export default {
  getInitData: () => {
    return ansAxios.get(`${resource}/data/init`)
  },
  search: (params?: ISearchCondition) => {
    return ansAxios.get(`${resource}`, {
      params: params
    })
  },
  getDetail: (params: IItemKey) => {
    return ansAxios.get(
      `${resource}/${encodeURIComponent(params.item_cd ?? '')}?color_cd=${encodeURIComponent(
        params.color_cd ?? ''
      )}`
    )
  },
  save: (body: { item: IItem; sizes: Array<ISize> }) => {
    return ansAxios.post(`${resource}`, {
      ...body.item,
      item_cd: body.item.item_cd ?? '',
      color_cd: body.item.color_cd ?? '',
      supplier_cd: isNaN(body.item.supplier_cd ?? 0) ? 0 : body.item.supplier_cd,
      sizes: _.map(body.sizes ?? [], (x, idx) => {
        return {
          ...x,
          item_cd: body.item.item_cd ?? '',
          color_cd: body.item.color_cd ?? '',
          sort_div: idx + 1
        }
      })
    })
  },
  delete: (params: IItemKey) => {
    return ansAxios.delete(
      `${resource}/${encodeURIComponent(params.item_cd ?? '')}?color_cd=${encodeURIComponent(
        params.color_cd ?? ''
      )}`
    )
  }
}
