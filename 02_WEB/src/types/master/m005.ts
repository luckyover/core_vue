export interface IDelivery {
  delivery_cd?: number | null
  delivery_nm?: string | null
  delivery_kn_nm?: string | null
  delivery_ab_nm?: string | null
  delivery_zip?: string | null
  delivery_address1?: string | null
  delivery_address2?: string | null
  delivery_address3?: string | null
  delivery_tel?: string | null
  delivery_fax?: string | null
  delivery_department_nm?: string | null
  delivery_manager_nm?: string | null
  delivery_mail_address?: string | null
  remarks?: string | null
  cre_user_cd?: string | null
  cre_user_nm?: string | null
  cre_tm?: string | null
  upd_user_cd?: string | null
  upd_user_nm?: string | null
  upd_tm?: string | null
}

export interface IDeliveryForList {
  delivery_cd?: number | null
  delivery_nm?: string | null
  delivery_kn_nm?: string | null
  delivery_ab_nm?: string | null
  delivery_zip?: string | null
  delivery_address1?: string | null
  delivery_address2?: string | null
  delivery_address3?: string | null
  delivery_tel?: string | null
  delivery_department_nm?: string | null
  delivery_manager_nm?: string | null
  delivery_mail_address?: string | null
}

export interface ISearchCondition {
  inq_delivery_cd?: number | null
  inq_delivery_nm?: string | null
  inq_delivery_kn_nm?: string | null
  inq_delivery_ab_nm?: string | null
  inq_delivery_tel?: string | null
  page_size?: number
  page?: number
  sort_column?: string | null
  sort_type?: string | null
  has_search?: boolean
}

export interface IListOfDelivery {
  delivery: Array<IDeliveryForList>
  paging: IAnsPaging
}

export interface IGetDeliveryDetailResponse extends IAnsResponse {
  data: IDelivery
}

export interface IDeliveryStoreResponse extends IAnsResponse {
  data: string
}

export interface ISearchDeliveryResponse extends IAnsResponse {
  data: IListOfDelivery
}

export interface IDeliveryInformationProps {
  delivery: IDelivery
  changeDeliveryCd: (newValue?: IAnsDynamic | null) => void
}

export interface ISearchConditionProps {
  condition: ISearchCondition
  onSearch: () => void
  onClear: () => void
}

export interface ITableDeliveryProps {
  condition: ISearchCondition
  delivery: Array<IDeliveryForList>
  paging?: IAnsPaging
  onSearch: () => void
  onSelected: (item: IDeliveryForList) => void
}
