import type { IAnsLibrary } from '../app'

export interface IUser {
  user_cd?: string | null
  password?: string | null
  user_nm?: string | null
  user_kn_nm?: string | null
  user_ab_nm?: string | null
  tel?: string | null
  fax?: string | null
  mailaddress?: string | null
  belong_department_div?: number
  authority_div?: number
  cre_user_cd?: string | null
  cre_user_nm?: string | null
  cre_tm?: string | null
  upd_user_cd?: string | null
  upd_user_nm?: string | null
  upd_tm?: string | null
}

export interface IUserForList {
  user_cd?: string | null
  user_nm?: string | null
  user_kn_nm?: string | null
  user_ab_nm?: string | null
  tel?: string | null
  fax?: string | null
  mailaddress?: string | null
  belong_department_div_nm?: string | null
}

export interface IInitData {
  belong_department_div: Array<IAnsLibrary>
  authority_div: Array<IAnsLibrary>
}

export interface ISearchCondition {
  inq_user_cd?: string | null
  inq_user_nm?: string | null
  inq_user_kn_nm?: string | null
  inq_user_ab_nm?: string | null
  inq_tel?: string | null
  inq_fax?: string | null
  inq_mailaddress?: string | null
  inq_belong_department_div?: number | null
  page_size?: number
  page?: number
  sort_column?: string | null
  sort_type?: string | null
  has_search?: boolean
}

export interface IListOfUsers {
  users: Array<IUserForList>
  paging: IAnsPaging
}

export interface IGetUserDetailResponse extends IAnsResponse {
  data: IUser
}

export interface IGetInitDataResponse extends IAnsResponse {
  data: IInitData
}

export interface ISearchUserResponse extends IAnsResponse {
  data: IListOfUsers
}

export interface IUserInformationProps {
  user: IUser
  belong_department_div: Array<IOption>
  authority_div: Array<IOption>
  changeUserCd: (newValue?: IAnsDynamic | null) => void
}

export interface ISearchConditionProps {
  condition: ISearchCondition
  belong_department_div: Array<IOption>
  onSearch: () => void
  onClear: () => void
}

export interface ITableUsersProps {
  condition: ISearchCondition
  users: Array<IUserForList>
  paging?: IAnsPaging
  onSearch: () => void
  onSelected: (item: IUserForList) => void
}
