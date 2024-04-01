export interface IAccount {
  username?: string
  password?: string
}

export interface IUser {
  token: string | null
  timeout: number
  urlBefore: string | null
  user_cd: string | null
  user_nm: string | null
  user_kn_nm: string | null
  user_ab_nm: string | null
  tel: string | null
  fax: string | null
  mailaddress: string | null
  belong_department_div: number
  belong_department_nm: string | null
  authority_div: number
  authority_nm: string | null
  remarks: string | null
}

export interface ICheckAccountResponse extends IAnsResponse {
  data: IUser | null
}
