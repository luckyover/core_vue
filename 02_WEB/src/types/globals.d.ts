import type { AxiosInstance } from 'axios'
import { MsgType, MsgTitle } from '@/utils/messages'
declare global {
  interface IAnsDynamic {
    [key: string]: any
  }

  interface IAnsInvalidData {
    [key: string]: Array<string> | undefined
  }

  interface IAnsValidateRule {
    [key: string]: string | undefined
  }

  interface IAnsAxiosHandleConfig {
    onSuccess?: (res: IAnsDynamic) => void
    onError?: (res: IAnsDynamic) => void
    onValidate?: (res: IAnsDynamic) => void
  }

  interface IAnsAxios extends AxiosInstance {
    settingHandle?: (config?: IAnsAxiosHandleConfig) => void
    onSuccess?: (res: IAnsDynamic) => void
    onError?: (res: IAnsDynamic) => void
    onValidate?: (res: IAnsDynamic) => void
  }

  interface IInputError {
    isError?: boolean
    error?: string
    errors?: Array<string>
  }

  interface IAnsMessage {
    type: MsgType | number | string
    title?: MsgTitle | string
    content?: string
    okText?: string
    cancelText?: string
    callback: (ok?: boolean) => void
  }

  interface IAnsResponse {
    code: number
    message: string
    messageNo: string
  }

  interface IAnsPaging {
    page: number
    pageSize: number
    totalRecord: number
  }

  interface IAnsSuggestSearch {
    code: number | string
    name: number | string
    subTitle: number | string
    value1?: number | string | null
    value2?: number | string | null
    value3?: number | string | null
  }

  interface IAnsFormControlProps {
    value?: string | number
    modelValue?: string | number

    id?: string
    name?: string
    label?: string
    placeholder?: string

    itemClass?: string
    inputClass?: string
    labelClass?: string

    isRequired?: boolean
    isDisabled?: boolean
    autofocus?: boolean

    onChangeEvent?: (newValue?: string | number, oldValue?: string | number, e?: Event) => void
  }

  interface IAnsInputProps extends IAnsFormControlProps {
    labelBefore?: string
    labelAfter?: string
    buttonClass?: string
    iconBefore?: string
    iconBeforeIsText?: boolean

    isReadonly?: boolean
    isDisabledButton?: boolean

    type?:
      | 'textarea'
      | 'number'
      | 'money'
      | 'text'
      | 'tel'
      | 'email'
      | 'katakana'
      | 'alphabet'
      | 'zipcode'
    isDecimal?: boolean
    decimal?: number
    isNegative?: boolean
    maxLength?: number

    cols?: number
    rows?: number

    isInputGroup?: boolean
    icon?: string
    buttonId?: string

    onFocusEvent?: (e: FocusEvent) => void
    onBlurEvent?: (e: FocusEvent) => void
    onClickEvent?: (e: MouseEvent) => void
    onGetAddress?: (address?: string) => void
  }

  interface IOption {
    code: string | number
    name: string | number
  }

  interface IAnsSelectProps extends IAnsFormControlProps {
    isReadonly?: boolean
    isRemoveEmpty?: boolean
    emptyText?: string

    options?: IOption[]

    onFocusEvent?: (e: FocusEvent) => void
    onBlurEvent?: (e: FocusEvent) => void
  }

  interface IAnsCheckboxProps
    extends Omit<IAnsFormControlProps, 'value' | 'modelValue' | 'onChangeEvent'> {
    value?: (string | number)[]
    modelValue?: (string | number)[]

    isSwitch?: boolean
    isInline?: boolean

    options?: IOption[]
    disabledOptions?: IOption[]

    onChangeEvent?: (
      newValue?: (string | number)[],
      oldValue?: (string | number)[],
      e?: Event
    ) => void
  }

  interface IAnsRadioButtonProps extends IAnsFormControlProps {
    isInline?: boolean

    options?: IOption[]
    disabledOptions?: IOption[]
  }

  interface IAnsSwitchProps
    extends Omit<IAnsFormControlProps, 'value' | 'modelValue' | 'onChangeEvent'> {
    value?: 1 | '1' | true | 0 | '0' | false
    modelValue?: 1 | '1' | true | 0 | '0' | false

    labelAfter?: string
    isCheckbox?: boolean

    onChangeEvent?: (
      newValue?: 1 | '1' | true | 0 | '0' | false,
      oldValue?: 1 | '1' | true | 0 | '0' | false,
      e?: Event
    ) => void
  }

  interface IAnsInputSearchProps
    extends Omit<IAnsFormControlProps, 'value' | 'modelValue' | 'onChangeEvent'> {
    value?: IAnsDynamic
    modelValue?: IAnsDynamic

    buttonClass?: string
    buttonIcon?: string
    buttonClearClass?: string
    buttonClearIcon?: string
    maxLength?: number

    index?: string | number
    initData?: IAnsDynamic
    pageSearch?: string
    popupSize?: 'xl' | 'lg' | 'md' | 'sm'
    popupLevel?: 1 | 2 | 3
    popupClass?: string
    popupTitle?: string

    isDisabledInput?: boolean
    isShowClearButton?: boolean

    propertyForId?: string
    propertyForName?: string
    isShowNameInInput?: boolean
    isShowNameInLabel?: boolean
    urlReferName?: string
    isReferName?: boolean
    urlSuggestSearch?: string
    isShowSuggestSearch?: boolean

    onChangeEvent?: (
      newValue?: IAnsDynamic | null,
      oldValue?: IAnsDynamic | null,
      index?: string | number
    ) => void
  }

  interface IAnsDatePickerProps
    extends Omit<IAnsFormControlProps, 'value' | 'modelValue' | 'onChangeEvent'> {
    value?: string | null
    modelValue?: string | null

    isReadonly?: boolean
    buttonClass?: string
    buttonIcon?: string
    isMonthPicker?: boolean
    isFullWidth?: boolean

    calendarPosition?: 'center' | 'left' | 'right'

    onChangeEvent?: (newValue?: string | null, oldValue?: string | null) => void
  }

  interface IAnsDateRangerProps
    extends Omit<IAnsFormControlProps, 'value' | 'modelValue' | 'onChangeEvent'> {
    value?: IAnsDynamic | null
    modelValue?: IAnsDynamic | null

    isReadonly?: boolean
    buttonClass?: string
    buttonIcon?: string
    isMonthPicker?: boolean
    isFullWidth?: boolean

    calendarPosition?: 'center' | 'left' | 'right'
    propertyDateFrom?: string
    propertyDateTo?: string

    onChangeEvent?: (newValue?: IAnsDynamic | null, oldValue?: IAnsDynamic | null) => void
  }

  interface IAnsPagingProps {
    value?: number | null
    modelValue?: number | null
    paging?: IAnsPaging
    itemClass?: string
    isShowWhenNoPage?: boolean
    isShowPageSize?: boolean

    onChangeEvent?: (newValue?: number | null, oldValue?: number | null) => void
    onChangePageSizeEvent?: (newValue?: number | null) => void
  }

  interface IAnsDatePickerYearMonth {
    year: number
    month: number
  }

  interface IAnsTimePickerProps extends Omit<IAnsDatePickerProps, 'isMonthPicker'> {
    isOnly24h?: boolean
  }

  interface IAnsTimePickerTime {
    hours: number
    minutes: number
  }

  interface IAnsPopupSearch {
    initData?: IAnsDynamic
    onSelected: (item?: IAnsDynamic) => void
    onClose: () => void
  }

  interface IPanelProps {
    id?: string
    title?: string
    canCollapse?: boolean
    isDefaultHide?: boolean
    triggerClose?: (fncClose?: () => void) => void
  }

  interface IAnsHeaderButton {
    id: string
    title: string
    icon: string
    href?: string
    onClickEvent?: (e: MouseEvent) => void
  }

  interface IAnsFooterButton {
    id: string
    title: string
    href?: string
    onClickEvent?: (e: MouseEvent) => void
  }

  interface IAnsHeader {
    id: string
    title: string
    titleColor?: string
    buttons: Array<IAnsHeaderButton>
  }

  interface IActionHistory {
    cre_user_cd?: string | null
    cre_user_nm?: string | null
    cre_tm?: string | null
    upd_user_cd?: string | null
    upd_user_nm?: string | null
    upd_tm?: string | null
  }

  interface IActionHistoryProps {
    actionHistory: IActionHistory
    buttons?: Array<IAnsFooterButton>
  }

  interface IEmptyRowProps {
    condition?: IAnsDynamic
    list?: Array<IAnsDynamic>
    colspan?: number
  }

  interface IAnsTooltipSpanProps {
    value?: string | number | null
    inFixColumn?: boolean
  }

  interface IAnsSortColumnProps {
    currentColumn?: string | null
    columnName?: string | null
    sortType?: string | null
    class?: string | null
    title?: string | null
    onSort?: (column?: string | null, sortType?: string | null) => void
  }

  interface IAnsColumn {
    name: string
    title: string
    class?: string
    hasTooltip?: boolean
    isFixColumn?: boolean
  }

  interface IAnsTableProps {
    columns?: Array<IAnsColumn>
    list?: Array<IAnsDynamic>
    condition?: IAnsDynamic
    paging?: IAnsPaging
    class?: string
    onSelected?: (item?: IAnsDynamic) => void
    onSearch?: () => void
  }
}
