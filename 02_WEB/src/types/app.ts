export interface IProfile {
  loginid: number
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

export interface IAppState {
  isLoading: boolean
  isForceLoading: boolean
  isNoLoading: boolean
  countLoading: number
  isShowMessage: boolean
  message: IAnsMessage
  itemErrors: IAnsInvalidData
  profile?: IProfile
  menus: Array<IAnsMenu>
  functions: Array<IAnsFunction>
  sys_msgs: IAnsDynamic
  msg_title: IAnsDynamic
  msg_type: IAnsDynamic
  screenId: string
  header: IAnsHeader
}

export interface IAppSateData {
  profile: IProfile
  menus: Array<IAnsDataMenu>
  functions: Array<IAnsFunction>
  sys_msgs: Array<IAnsSysMessage>
}

export interface IAppSateResponse extends IAnsResponse {
  data: IAppSateData | null
}

export interface IAnsDataMenu {
  prg_cd: string
  prg_nm?: string | null
  prg_url?: string | null
  prg_group_div?: number | null
  prg_group_nm?: string | null
}

export interface IAnsMenu {
  id: string
  title: string
  url?: string
  isActive?: boolean
  items?: Array<IAnsMenu>
}

export interface IAnsFunction {
  prg_cd: string
  prg_url?: string | null
  fnc_cd: string
  fnc_nm?: string | null
  fnc_use_div?: boolean
}

export interface IAnsSysMessage {
  message_cd: string
  type?: string | null
  message_nm?: string | null
  message?: string | null
}

export interface IAnsLibrary {
  name_div: string
  name_cd: number
  name: string
  kn_name: string | null
  ab_name: string | null
  char_remakrs_ex1: string | null
  char_remakrs1: string | null
  char_remakrs_ex2: string | null
  char_remakrs2: string | null
  num_remakrs_ex1: number | null
  num_remakrs1: number | null
  num_remakrs_ex2: number | null
  num_remakrs2: number | null
  default_flg: number
  sort: number
}
