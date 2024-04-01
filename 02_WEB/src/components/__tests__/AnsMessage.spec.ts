import { describe, it, expect } from 'vitest'

import { mount } from '@vue/test-utils'
import AnsMessage from '../ans/AnsMessage.vue'

describe('AnsMessage', () => {
  it('renders properly', () => {
    const wrapper = mount(AnsMessage)
    expect(wrapper.text()).toContain('Hello Vitest')
  })
})
