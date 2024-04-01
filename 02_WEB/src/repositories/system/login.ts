import type { IAccount } from '@/types/system/login'
import ansAxios from '../ansAxios'
const resource: string = 'system/login'
export default {
  login: (body: IAccount) => {
    return ansAxios.post(`${resource}`, body)
  }
}
