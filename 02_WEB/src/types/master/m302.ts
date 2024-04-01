import type { IAnsLibrary } from '../app'

export interface ICost {
  supplier_cd?: string | null
  supplier_nm?: string | null
  item_cd?: string | null
  item_nm?: string | null
  category_div?: number | null
  material_div?: number | null
  processing_place_div?: number | null
  number_sheet_fr?: string | null
  number_sheet_to?: string | null
  color_div?: number | null
  sales_amt?: string | null
  is_new?: boolean
  idx?: number | -1
}

export interface ISearchCondition {
  supplier_cd?: string | null
  supplier_nm?: string | null
  supplier_nm_rf?: string | null
  item_cd?: string | null
  item_nm?: string | null
  category_div?: number | null
  material_div?: number | null
  processing_place_div?: number | null
}

export interface IInitData {
  category_div: Array<IAnsLibrary>
  material_div: Array<IAnsLibrary>
  processing_place_div: Array<IAnsLibrary>
  color_div: Array<IAnsLibrary>
}

export interface IGetInitDataResponse {
  data: IInitData
}

export interface ISearchResponse {
  data: Array<ICost>
}

export interface ISearchConditionProps {
  condition: ISearchCondition
  category_div: Array<IOption>
  material_div: Array<IOption>
  processing_place_div: Array<IOption>
}

export interface ITableCostProps {
  costs: Array<ICost>
  category_div?: Array<IOption>
  material_div?: Array<IOption>
  processing_place_div?: Array<IOption>
  color_div?: Array<IOption>
  addToDeleteCost: (cost: ICost) => void
}
