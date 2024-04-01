import { defineStore } from 'pinia'
import type { IAppState, IAppSateResponse, IAnsDataMenu, IAnsMenu } from '@/types/app'
import ansAxios from '@/repositories/ansAxios'
import { SysMsg, MsgType, ansIdentity } from '@/utils'
import _, { cloneDeep } from 'lodash'

const defaultMessage: IAnsMessage = {
  type: MsgType.ERROR,
  title: '',
  content: 'E999',
  okText: 'はい',
  cancelText: 'いいえ',
  callback: () => {}
}

export const useAppStore = defineStore('app', {
  state: (): IAppState => {
    return {
      isLoading: false,
      isForceLoading: false,
      isNoLoading: false,
      countLoading: 0,
      isShowMessage: false,
      message: { ...defaultMessage },
      itemErrors: {} as IAnsInvalidData,
      profile: JSON.parse(localStorage.getItem('profile') ?? '{}'),
      menus: JSON.parse(localStorage.getItem('menus') ?? '[]'),
      functions: JSON.parse(localStorage.getItem('functions') ?? '[]'),
      sys_msgs: {},
      msg_title: {},
      msg_type: {},
      screenId: '',
      header: {
        id: '',
        title: '',
        titleColor: '',
        buttons: []
      }
    }
  },
  actions: {
    showLoading() {
      this.isLoading = true
    },
    hideLoading() {
      this.isLoading = false
    },
    showForceLoading() {
      this.isForceLoading = true
    },
    hideForceLoading() {
      this.isForceLoading = false
    },
    showMessage(message: IAnsMessage) {
      this.message = {
        ...defaultMessage,
        ...message
      }
      this.message.content = _.get(SysMsg, this.message.content ?? '', this.message.content ?? '')
      this.isShowMessage = true
    },
    hideMessage() {
      this.isShowMessage = false
      setTimeout(() => {
        this.message = {
          ...defaultMessage
        }
      }, 300)
    },
    setNoLoading(val: boolean) {
      this.isNoLoading = val
    },
    increaseCountLoading() {
      this.countLoading += 1
    },
    decreaseCountLoading() {
      this.countLoading -= 1
      if (this.countLoading < 0) {
        this.countLoading = 0
      }
    },
    setErrors(errors: IAnsInvalidData | undefined) {
      if (errors) {
        this.itemErrors = errors
      } else {
        this.itemErrors = {} as IAnsInvalidData
      }
    },
    removeErrors() {
      this.itemErrors = {} as IAnsInvalidData
    },
    addItemError(item: string, errors: Array<string> | string | undefined) {
      if (!errors) {
        return
      }
      let tmpErrors: Array<string> = [...(this.itemErrors[item] ?? [])]
      if (typeof errors === 'string') {
        tmpErrors.push(errors)
      } else {
        tmpErrors = [...tmpErrors, ...errors]
      }
      this.itemErrors[item] = _.uniq(tmpErrors)
    },
    removeItemError(item: string) {
      this.itemErrors[item] = undefined
    },
    async getAppState() {
      const vm = this
      await ansAxios
        .get('/app/app-state')
        .then(({ data: response }: { data: IAppSateResponse }) => {
          const { data } = response
          vm.profile = data?.profile
          const menuGroup = _(
            _.filter(data?.menus ?? [], (x) => {
              return x.prg_group_div !== 1
            })
          )
            .groupBy('prg_group_div')
            .map((group) => {
              const firstItem = _.first(group)
              const items = _.map(group, (x) => {
                return {
                  id: x.prg_cd,
                  title: x.prg_nm,
                  url: x.prg_url
                } as IAnsMenu
              })
              return {
                id: `${firstItem?.prg_group_div ?? ''}`,
                title: firstItem?.prg_group_nm ?? '',
                items: items
              } as IAnsMenu
            })
            .valueOf()
          vm.menus = [
            ..._.map(
              _.filter(data?.menus ?? [], (x) => {
                return x.prg_group_div === 1
              }),
              (x: IAnsDataMenu) => {
                return {
                  id: x.prg_cd,
                  title: x.prg_nm,
                  url: x.prg_url
                } as IAnsMenu
              }
            ),
            ...menuGroup
          ]
          vm.functions = data?.functions ?? []
          vm.sys_msgs = {}
          vm.msg_title = {}
          vm.msg_type = {}
          _.map(data?.sys_msgs ?? [], (x) => {
            _.set(vm.sys_msgs, x.message_cd, x.message)
            _.set(vm.msg_title, x.message_cd, x.message_nm)
            _.set(vm.msg_type, x.message_cd, x.type)
            return {}
          })
        })
        .catch(() => {
          vm.resetAppState()
        })
        .finally(() => {
          localStorage.setItem('functions', JSON.stringify(vm.functions))
          localStorage.setItem('menus', JSON.stringify(vm.menus))
          localStorage.setItem('profile', JSON.stringify(vm.profile ?? {}))
        })
    },
    resetAppState() {
      this.profile = undefined
      this.menus = []
      this.functions = []
      this.sys_msgs = {}
      this.msg_title = {}
      this.msg_type = {}
    },
    setHeader(header: IAnsHeader) {
      const buttons = cloneDeep(header.buttons ?? [])
      const allowButtons = []
      for (let i = 0; i < buttons.length; i++) {
        if (ansIdentity.canShowButton(buttons[i].id)) {
          allowButtons.push({
            ...buttons[i]
          })
        }
      }
      this.header = {
        ...header,
        buttons: [...allowButtons]
      }
      this.screenId = header.id ?? ''
    }
  }
})
