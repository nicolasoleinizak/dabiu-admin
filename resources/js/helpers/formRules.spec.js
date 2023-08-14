import { formRules } from "./formRules";
import { describe, expect, it } from 'vitest';

describe('Form validation rules', () => {
  describe('Email validation rules', () => {
    it('Should return an error message if value is empty', () => {
      const result = formRules.email();
      expect(result).toBe('You must enter an email.');
    });
    it('Should return an error message if the value is not a valid email', () => {
      const result = formRules.email('test@email');
      expect(result).toBe('The value must be a valid email.');
    })
    it('Should return true if the email value is correct', () => {
      const result = formRules.email('test@test.com');
      expect(result).toBe(true);
    })
  });
  describe('Password validation', () => {
    it('Should return an error message if the password has less than 6 characters', () => {
      const result = formRules.password('12345');
      expect(result).toBe('The password must have at least 6 characters.');
    });
    it('Should return true if the password is correct', () => {
      const result = formRules.password('123456');
      expect(result).toBe(true);
    });
  })
})