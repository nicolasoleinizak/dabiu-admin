import http from "./http";

export const loginService = async (authData) => {
  try {
    const response = await http.post('/login', authData);
    localStorage.setItem('token', response.data.authorization.token);
    return true;
  } catch (error) {
    if(error.response?.data?.errors){
      const errorsString = Object.values(error.response.data.errors).join('');
      console.error(errorsString)
      throw new Error(errorsString);
    } else {
      throw new Error('Invalid credentials');
    }
  }
};

export const registerService = async (userData) => {
  try {
    await http.post('/register', userData);
    return true;
  } catch (error) {
    if(error.response?.data?.errors){
      const errorsString = Object.values(error.response.data.errors).join('');
      throw new Error(errorsString);
    } else {
      throw new Error('There was an error trying to register');
    }
  }
};