export const formRules = {
  email: (value) => {
    {
      if(!value) return 'You must enter an email.';
      if(!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(value)) return "The value must be a valid email."
      return true;
    }
  },
  password: (value) => {
    if(value.length < 6) return 'The password must have at least 6 characters.'
    return true;
  }
}