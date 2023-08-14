import { mount } from '@vue/test-utils';
import AuthForm from './AuthForm.vue';
import { describe, it, expect } from 'vitest';


describe('AuthForm component', () => {
  it('Should display the title property', () => {
    const title = 'Test title';
    const wrapper = mount(AuthForm, {
      props: {
        title
      }
    });
    expect(wrapper.text()).toContain(title);
  })

  it('Should render a children', () => {
    const children = '<p>This is a children</p>';
    const layout = {
      template: children,
    };
    const wrapper = mount(AuthForm, {
      slots: {
        default: layout
      }
    });
    expect(wrapper.html()).toContain(children);
  })
})