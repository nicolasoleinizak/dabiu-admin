import axios from 'axios';
import { NotLoggedException } from './httpErrors';
const { VITE_API_BASE_URL: apiBaseUrl } = import.meta.env;

const commonHttpConfig = {
  baseURL: apiBaseUrl,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
}

const unauthenticatedHttp = axios.create(commonHttpConfig);

const authenticatedHttp = axios.create(commonHttpConfig);

authenticatedHttp.interceptors.request.use(function (config) {
  if(localStorage.token){
    config.headers.Authorization = `Bearer ${localStorage.token}`;
  } else {
    window.location.reload();
  }
  return config;
});

authenticatedHttp.interceptors.response.use((response) => {
  return response;
}, (error) => {
  console.log(error)
  if(error.response.status === 401){
    localStorage.removeItem('token');
    window.location.reload();
  } else {
    Promise.reject(response);
  }
});

export {unauthenticatedHttp, authenticatedHttp};