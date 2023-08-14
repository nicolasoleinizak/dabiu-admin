import { mount } from '@vue/test-utils';
import Login from './Login.vue';
import { describe, it, expect, vi } from 'vitest';

const user = {
  email: 'test@test.com',
  password: '123456'
};

vi.mock('../../services/authService.js', () => ({
  loginService: vi.fn(({email, password}) => {
    if (!email) {
      throw new Error('Email is a required field.');
    }
    if (!password) {
      throw new Error('Password is a required field.');
    }
    if(email === user.email, password === user.password){
      return true;
    }
  })
}))


describe('Login component', () => {
  
  it('Should render two text fields', () => {
    const wrapper = mount(Login);
    const textFieldsCount = wrapper.findAll('v-text-field').length;
    expect(textFieldsCount).toBe(2);
  });
  
  it('Should display an alert if login fails', async () => {
    const wrapper = mount(Login);
    await wrapper.setData({email: 'test@test.com'})
    await wrapper.find('v-btn').trigger('click');
    expect(wrapper.text()).toContain('Password is a required field.');
  })
  
  it('Should redirect to "/" if login succeed', async () => {
    let routerMock = {
      push: vi.fn(),
    }
    
    const wrapper = mount(Login, {
      global: {
        mocks: {
          $router: routerMock
        }
      }
    });

    await wrapper.setData(user);

    await wrapper.find('v-btn').trigger('click');

    expect(routerMock.push).toHaveBeenCalledWith('/');
  })

  describe('Loader spinner', () => {
    const wrapper = mount(Login);
    it('Should be hidden by default', () => {
      expect(wrapper.find('v-progress-circular').exists()).toBe(false);
    })
    it('Should be displayed while loading', async () => {
      await wrapper.setData({attemptingToLog: true});
      expect(wrapper.find('v-progress-circular').exists()).toBe(true);
    })
  })
})