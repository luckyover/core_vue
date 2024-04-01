import type { IAnsLibrary } from '../app'
import type { IItemKey } from './m101'

export interface ISizesPrice {
  item_cd?: string | null
  color_cd?: string | null
  color_nm?: string | null
  size_cd?: string | null
  item_nm?: string | null
  price_list?: number | null
  retail_upr?: number | null
  sizes: Array<IOption>

  cre_user_cd?: string | null
  cre_user_nm?: string | null
  cre_tm?: string | null
  upd_user_cd?: string | null
  upd_user_nm?: string | null
  upd_tm?: string | null
  is_new?: boolean
  idx?: number | -1
}

export interface ISizesPriceKey {
  item_cd?: string | null
  color_cd?: string | null
  size_cd?: string | null
  item_nm?: string | null
  price_list?: string | null
}

export interface IInitData {
  price_list: Array<IAnsLibrary>
}

export interface ISearchResponse {
  data: Array<ISizesPrice>
}

export interface ISearchConditionProps {
  condition: ISearchCondition
  price_list: Array<IOption>
}

export interface IGetInitDataResponse extends IAnsResponse {
  data: IInitData
}

export interface ITableSizesPriceProps {
  sizePrices: Array<ISizesPrice>
  price_list: Array<IOption>
  addToDeletePrice: (price: ISizesPrice) => void
  getProduct: (params: IItemKey, itemFocus: string, idx: number) => void
}

export interface ISearchCondition {
  item_cd: string | null
  item_nm: string | null
  item_nm_rf?: string | null
  color_cd?: string | null
  price_list: number | null
}
