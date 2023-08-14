import { mount } from '@vue/test-utils';
import TitleLogo from './AuthForm.vue';
import { describe, it, expect } from 'vitest';

describe('TitleLogo component', () => {
  it('Should render a Logo', () => {
    const wrapper = mount(TitleLogo);
    expect(wrapper.find('#title-logo').exists()).toBe(true);
  });
})
