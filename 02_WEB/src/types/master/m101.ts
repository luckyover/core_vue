import type { IAnsLibrary } from '../app'

export interface IItem {
  item_cd?: string | null
  color_cd?: string | null
  item_nm?: string | null
  item_kn_nm?: string | null
  item_ab_nm?: string | null
  color_nm?: string | null
  color_kn_nm?: string | null
  color_ab_nm?: string | null
  item_class_div?: number | null
  process_div?: number | null
  category_div?: number | null
  material_div?: number | null
  supplier_cd?: number | null
  supplier_nm?: string | null
  supplier_item_cd?: string | null
  tax_div?: number | null
  remarks?: string | null
  cre_user_cd?: string | null
  cre_user_nm?: string | null
  cre_tm?: string | null
  upd_user_cd?: string | null
  upd_user_nm?: string | null
  upd_tm?: string | null
}

export interface IItemForList {
  item_cd?: string | null
  color_cd?: string | null
  item_nm?: string | null
  item_kn_nm?: string | null
  item_ab_nm?: string | null
  color_nm?: string | null
  color_kn_nm?: string | null
  color_ab_nm?: string | null
  item_class_div_nm?: string | null
  process_div_nm?: string | null
  category_div_nm?: string | null
  supplier_item_cd?: string | null
  supplier_cd?: string | null
  supplier_nm?: string | null
}

export interface IItemKey {
  item_cd?: string | null
  color_cd?: string | null
}

export interface ISize {
  item_cd?: string | null
  color_cd?: string | null
  size_cd?: string | null
  sort_div?: number | null
  discontinued_div?: number | null
  discontinued_display_div?: number | null
}

export interface IInitData {
  item_class_div: Array<IAnsLibrary>
  process_div: Array<IAnsLibrary>
  category_div: Array<IAnsLibrary>
  material_div: Array<IAnsLibrary>
  tax_div: Array<IAnsLibrary>
  discontinued_div: Array<IAnsLibrary>
  discontinued_display_div: Array<IAnsLibrary>
}

export interface IM101Data {
  item: IItem
  sizes: Array<ISize>
}

export interface ISearchCondition {
  inq_item_cd?: string | null
  inq_color_nm?: string | null
  inq_color_cd?: string | null
  inq_item_nm?: string | null
  inq_item_class_div?: number | null
  inq_process_div?: number | null
  inq_category_div?: number | null
  inq_supplier_cd?: string | null
  inq_supplier_nm?: string | null
  page_size?: number
  page?: number
  sort_column?: string | null
  sort_type?: string | null
  has_search?: boolean
  disable_item_class_div?: boolean
  remove_process?: boolean
}

export interface IListOfItems {
  items: Array<IItemForList>
  paging: IAnsPaging
}

export interface IGetInitDataResponse extends IAnsResponse {
  data: IInitData
}

export interface IGetItemDetailResponse extends IAnsResponse {
  data: IM101Data
}

export interface ISearchItemResponse extends IAnsResponse {
  data: IListOfItems
}

export interface IItemDetailProps {
  product: IItem
  item_class_div: Array<IOption>
  process_div: Array<IOption>
  category_div: Array<IOption>
  material_div: Array<IOption>
  tax_div: Array<IOption>
  getProduct: (params?: IItemKey, itemFocus?: string) => void
}

export interface ITableSizeProps {
  product: IItem
  sizes: Array<ISize>
  discontinued_div: Array<IOption>
  discontinued_display_div: Array<IOption>
  updateSizes: (_sizes: Array<ISize>) => void
}

export interface ISearchConditionProps {
  condition: ISearchCondition
  item_class_div: Array<IOption>
  process_div: Array<IOption>
  category_div: Array<IOption>
  onSearch: () => void
  onClear: () => void
}

export interface ITableProductProps {
  condition: ISearchCondition
  items: Array<IItemForList>
  paging?: IAnsPaging
  onSearch: () => void
  onSelected: (item: IItemForList) => void
}
