import { mount } from '@vue/test-utils';
import Register from './Register.vue';
import { describe, it, expect, vi } from 'vitest';

const user = {
  email: 'test@test.com',
  password: '123456',
  name: 'Test user',
};

vi.mock('../../services/authService.js', () => ({
  registerService: vi.fn(({email, password, name}) => {
    if (!email) {
      throw new Error('Email is a required field.');
    }
    if (!password) {
      throw new Error('Password is a required field.');
    }
    if (!name) {
      throw new Error('Name is a required field.');
    }
    return true;
  })
}))


describe('Register component', () => {
  
  it('Should render four text fields', () => {
    const wrapper = mount(Register);
    const textFieldsCount = wrapper.findAll('v-text-field').length;
    expect(textFieldsCount).toBe(4);
  });
  
  it('Should display an alert if login fails', async () => {
    const wrapper = mount(Register);
    await wrapper.setData({email: 'test@test.com'})
    await wrapper.find('v-btn').trigger('click');
    expect(wrapper.text()).toContain('Password is a required field.');
  })
  
  it('Should redirect to "/login" if login succeed', async () => {
    let routerMock = {
      push: vi.fn(),
    }
    
    const wrapper = mount(Register, {
      global: {
        mocks: {
          $router: routerMock
        }
      }
    });

    await wrapper.setData(user);

    await wrapper.find('v-btn').trigger('click');

    expect(routerMock.push).toHaveBeenCalledWith('/login');
  })

  describe('Loader spinner', () => {
    const wrapper = mount(Register);
    it('Should be hidden by default', () => {
      expect(wrapper.find('v-progress-circular').exists()).toBe(false);
    })
    it('Should be displayed while loading', async () => {
      await wrapper.setData({attemptingToRegister: true});
      expect(wrapper.find('v-progress-circular').exists()).toBe(true);
    })
  })
})