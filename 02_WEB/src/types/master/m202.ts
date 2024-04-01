import type { IItemKey } from './m101'
export interface IProductCost {
  item_cd?: string | null
  color_cd?: string | null
  color_nm?: string | null
  item_nm?: string | null
  size_cd?: string | null
  supplier_cd?: number | null
  supplier_nm?: string | null
  retail_upr?: string | null
  is_new?: boolean
  sizes: Array<IOption>
  idx?: number | -1
}

export interface IProductCostKey {
  item_cd?: string | null
  color_cd?: string | null
  size_cd?: string | null
  supplier_cd?: number
}

export interface IProductCostSearch {
  item_cd?: string | null
  item_nm?: string | null
  color_cd?: string | null
  size_cd?: string | null
  supplier_cd?: number | null
  supplier_nm?: string | null
  supplier_nm_rf?: string | null
  retail_upr?: string | null
}

export interface IProductCostProps {
  productCost: IProductCost
}

export interface ISearchResponse {
  data: Array<IProductCost>
}

export interface IProductCostSearchProps {
  condition: IProductCostSearch
}

export interface IDataTableCostProps {
  costs: Array<IProductCost>
  addToDeleteCost: (cost: IProductCost) => void
  getDetailItem: (params: IItemKey, itemFocus: string, idx: number) => void
}
