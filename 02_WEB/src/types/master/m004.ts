import type { IAnsLibrary } from '../app'

export interface ICustomer {
  customer_cd?: number
  billing_source_cd?: number
  customer_nm?: string | null
  customer_kn_nm?: string | null
  customer_ab_nm?: string | null
  customer_address1?: string | null
  customer_address2?: string | null
  customer_address3?: string | null
  customer_tel?: string | null
  customer_fax?: string | null
  customer_zip?: string | null
  customer_department_nm?: string | null
  customer_manager_nm?: string | null
  customer_mail_address?: string | null
  customer_class_div1?: number
  customer_class_div2?: number
  customer_class_div3?: number
  billing_nm?: string | null
  billing_zip?: string | null
  billing_address1?: string | null
  billing_address2?: string | null
  billing_address3?: string | null
  billing_tel?: string | null
  billing_fax?: string | null
  billing_department_nm?: string | null
  billing_manager_nm?: string | null
  billing_mail_address?: string | null
  billing_closing_div?: number
  transfer_date1?: number
  transfer_date2?: number
  sales_employee_cd?: string | null
  sales_employee_nm?: string | null
  price_list?: number
  reason_for_closure?: string | null
  remarks?: string | null
}

export interface ICustomerForList {
  customer_cd?: number
  billing_source_nm?: string | null
  customer_nm?: string | null
  customer_kn_nm?: string | null
  customer_ab_nm?: string | null
  customer_tel?: string | null
  customer_mail_address?: string | null
  customer_class_div1_nm?: string | null
  customer_class_div2_nm?: string | null
  customer_class_div3_nm?: string | null
  billing_closing_div_nm?: string | null
  transfer_date1_nm?: string | null
  transfer_date2_nm?: string | null
  sales_employee_nm?: string | null
}

export interface ISearchCondition {
  inq_customer_cd?: number
  inq_billing_source_cd?: number
  inq_customer_nm?: string | null
  inq_customer_kn_nm?: string | null
  inq_customer_ab_nm?: string | null
  inq_customer_tel?: string | null
  inq_customer_class_div1?: number
  inq_customer_class_div2?: number
  inq_customer_class_div3?: number
  inq_billing_closing_div?: number
  sales_employee_cd?: string | null
  sales_employee_nm?: string | null
  page_size?: number
  page?: number
  sort_column?: string | null
  sort_type?: string | null
  has_search?: boolean
}

export interface IListOfCustomers {
  customers: Array<ICustomerForList>
  paging: IAnsPaging
}

export interface IInitData {
  billing_source_cd: Array<ICompany>
  customer_class_div1: Array<IAnsLibrary>
  customer_class_div2: Array<IAnsLibrary>
  customer_class_div3: Array<IAnsLibrary>
  billing_closing_div: Array<IAnsLibrary>
  transfer_date1: Array<IAnsLibrary>
  transfer_date2: Array<IAnsLibrary>
  price_list: Array<IAnsLibrary>
}

export interface IGetCustomerDetailResponse extends IAnsResponse {
  data: ICustomer
}

export interface ICustomerStoreResource extends IAnsResponse {
  data: number
}

export interface ISearchCustomerResponse extends IAnsResponse {
  data: IListOfCustomers
}

export interface ICompany {
  company_cd?: number
  company_nm?: string | null
}

export interface IGetInitDataResponse extends IAnsResponse {
  data: IInitData
}
export interface ICustomerInformationProps {
  customer: ICustomer
  billing_source_cd: Array<IOption>
  customer_class_div1: Array<IOption>
  customer_class_div2: Array<IOption>
  customer_class_div3: Array<IOption>
  changeCustomerCd: (newValue?: IAnsDynamic | null) => void
}

export interface IBillingInformationProps {
  billing: ICustomer
  billing_closing_div: Array<IOption>
  transfer_date1: Array<IOption>
  transfer_date2: Array<IOption>
  price_list: Array<IOption>
}

export interface ISearchConditionProps {
  condition: ISearchCondition
  billing_source_cd: Array<IOption>
  customer_class_div1: Array<IOption>
  customer_class_div2: Array<IOption>
  customer_class_div3: Array<IOption>
  billing_closing_div: Array<IOption>
  onSearch: () => void
  onClear: () => void
}

export interface ITableSupplierProps {
  condition: ISearchCondition
  customers: Array<ICustomerForList>
  paging?: IAnsPaging
  onSearch: () => void
  onSelected: (item: ICustomerForList) => void
}
