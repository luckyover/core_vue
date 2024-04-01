import type { IAnsLibrary } from '../app'

export interface ISupplier {
  supplier_cd?: number | null
  supplier_div?: number
  supplier_nm?: string | null
  supplier_kn_nm?: string | null
  supplier_ab_nm?: string | null
  supplier_zip?: string | null
  supplier_address1?: string | null
  supplier_address2?: string | null
  supplier_address3?: string | null
  supplier_tel?: string | null
  supplier_fax?: string | null
  supplier_department_nm?: string | null
  supplier_manager_nm?: string | null
  supplier_mail_address?: string | null
  supplier_class_div1?: number
  supplier_class_div2?: number
  supplier_class_div3?: number
  supplier_closing_div?: number
  transfer_date1?: number
  transfer_date2?: number
  remarks?: string | null
}

export interface ISupplierForList {
  supplier_cd?: number | null
  supplier_nm?: string | null
  supplier_kn_nm?: string | null
  supplier_ab_nm?: string | null
  supplier_div_nm?: number
  supplier_tel?: string | null
  supplier_mail_address?: string | null
  supplier_class_div1_nm?: number
  supplier_class_div2_nm?: number
  supplier_class_div3_nm?: number
}

export interface ISearchCondition {
  inq_supplier_cd?: number | null
  inq_supplier_div?: number
  inq_supplier_nm?: string | null
  inq_supplier_kn_nm?: string | null
  inq_supplier_tel?: string | null
  inq_supplier_ab_nm?: string | null
  inq_supplier_class_div1?: number
  inq_supplier_class_div2?: number
  inq_supplier_class_div3?: number
  page_size?: number
  page?: number
  sort_column?: string | null
  sort_type?: string | null
  has_search?: boolean
  disable_supplier_div?: boolean
}

export interface IListOfSuppliers {
  suppliers: Array<ISupplierForList>
  paging: IAnsPaging
}

export interface IInitData {
  supplier_div: Array<IAnsLibrary>
  supplier_class_div1: Array<IAnsLibrary>
  supplier_class_div2: Array<IAnsLibrary>
  supplier_class_div3: Array<IAnsLibrary>
  supplier_closing_div: Array<IAnsLibrary>
  transfer_date1: Array<IAnsLibrary>
  transfer_date2: Array<IAnsLibrary>
}

export interface IGetSupplierDetailResponse extends IAnsResponse {
  data: ISupplier
}

export interface IGetInitDataResponse extends IAnsResponse {
  data: IInitData
}

export interface ISupplierStoreResponse extends IAnsResponse {
  data: number
}

export interface ISearchSupplierResponse extends IAnsResponse {
  data: IListOfSuppliers
}

export interface ISupplierInformationProps {
  supplier: ISupplier
  supplier_div: Array<IOption>
  supplier_class_div1: Array<IOption>
  supplier_class_div2: Array<IOption>
  supplier_class_div3: Array<IOption>
  supplier_closing_div: Array<IOption>
  transfer_date1: Array<IOption>
  transfer_date2: Array<IOption>
  changeSupplierCd: (newValue?: IAnsDynamic | null) => void
}

export interface ISearchConditionProps {
  condition: ISearchCondition
  supplier_div: Array<IOption>
  supplier_class_div1: Array<IOption>
  supplier_class_div2: Array<IOption>
  supplier_class_div3: Array<IOption>
  onSearch: () => void
  onClear: () => void
}

export interface ITableSupplierProps {
  condition: ISearchCondition
  suppliers: Array<ISupplierForList>
  paging?: IAnsPaging
  onSearch: () => void
  onSelected: (item: ISupplierForList) => void
}
