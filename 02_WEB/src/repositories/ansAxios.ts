import axios from 'axios'
import { v4 as uuid } from 'uuid'
import { useAppStore } from '@/stores/app'
import Router from '@/router'
import { SysMsg, MsgType, ansValidate } from '@/utils'

const baseUrl = `${import.meta.env.VITE_API_URI ?? ''}${import.meta.env.VITE_API_PATH ?? '/api'}`
const apiKey = import.meta.env.VITE_API_KEY
const timeout = parseInt(import.meta.env.VITE_API_TIMEOUT ?? '60000')

const showLoading = () => {
  const appStore = useAppStore()
  if (!appStore.isNoLoading) {
    appStore.showLoading()
    appStore.increaseCountLoading()
  }
}

const hideLoading = () => {
  const appStore = useAppStore()
  if (!appStore.isNoLoading) {
    if (appStore.countLoading - 1 <= 0) {
      appStore.hideLoading()
      if (appStore.isForceLoading) {
        appStore.hideForceLoading()
      }
    }
    appStore.decreaseCountLoading()
  }
}

const logError = (error: any) => {
  if (import.meta.env.DEV) {
    console.log('ApiError', error)
    document.dispatchEvent(
      new CustomEvent('ApiError', {
        detail: {
          error,
          type: 'error'
        }
      })
    )
  }
}

const ansAxios = axios.create({
  baseURL: baseUrl,
  timeout: timeout,
  headers: {
    'x-api-key': apiKey
  }
}) as IAnsAxios

ansAxios.interceptors.request.use(
  function (config) {
    config.headers['X-Request-Id'] = uuid()
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    const appStore = useAppStore()
    config.headers['X-Screen-Id'] = appStore.screenId
    if (config.url !== '/app/app-state') {
      showLoading()
    }
    return config
  },
  function (error) {
    logError(error)
    return Promise.reject(error)
  }
)

ansAxios.interceptors.response.use(
  function (response) {
    if (response.config?.url !== '/app/app-state') {
      hideLoading()
    }
    if (typeof ansAxios.onSuccess === 'function') {
      ansAxios.onSuccess(response.data)
      ansAxios.onSuccess = undefined
    }
    return response
  },
  function (error) {
    const appStore = useAppStore()
    if (error.config?.url === '/app/app-state') {
      if (typeof ansAxios.onError === 'function') {
        ansAxios.onError(error)
        ansAxios.onError = undefined
      }
      logError(error)
      return Promise.reject(error)
    } else {
      hideLoading()
    }
    const { response } = error
    if (response && [400, 401, 403, 406].includes(response.status)) {
      if (response.status === 400 && response.data?.invalidData) {
        if (typeof ansAxios.onValidate === 'function') {
          ansAxios.onValidate(error)
          ansAxios.onValidate = undefined
        } else {
          appStore.setErrors(response.data?.invalidData)
          setTimeout(() => {
            ansValidate.focusFirstError()
          }, 100)
        }
      } else {
        if (response.status === 401) {
          localStorage.setItem('beforeUrl', window.location.pathname)
          localStorage.removeItem('token')
          localStorage.removeItem('tokenTimeout')
          Router.push('/login')
        } else {
          appStore.showMessage({
            type: MsgType.ERROR,
            content:
              response.status === 400
                ? SysMsg.E400
                : response.status === 403
                  ? SysMsg.E403
                  : response.status === 406
                    ? response.data?.message ?? SysMsg.E500
                    : SysMsg.E500,
            callback: () => {
              if (response.status === 406) {
                const errors = response.data?.data ?? []
                for (let i = 0; i < errors.length; i++) {
                  if (errors[i].error_typ && errors[i].error_typ === '1') {
                    const items = errors[i].item.split(',')
                    for (let j = 0; j < items.length; j++) {
                      appStore.addItemError(items[j], errors[i].message_cd)
                    }
                  }
                }
                setTimeout(() => {
                  ansValidate.focusFirstError()
                }, 100)
              }
              if (typeof ansAxios.onError === 'function') {
                ansAxios.onError(error)
                ansAxios.onError = undefined
              }
            }
          } as IAnsMessage)
        }
      }
    } else {
      appStore.showMessage({
        type: MsgType.ERROR,
        content: SysMsg.E500
      } as IAnsMessage)
      if (typeof ansAxios.onError === 'function') {
        ansAxios.onError(error)
        ansAxios.onError = undefined
      }
    }
    logError(error)
    return Promise.reject(error)
  }
)

ansAxios.settingHandle = (config?: IAnsAxiosHandleConfig) => {
  ansAxios.onSuccess = config?.onSuccess
  ansAxios.onError = config?.onError
  ansAxios.onValidate = config?.onValidate
}

export default ansAxios
