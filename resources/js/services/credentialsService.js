import {authenticatedHttp as http} from "./http";

export const createCredentialsService = async (body) => {
  const response = await http.post('/credentials/wc', body);
  return response.data;
};

export const checkCredentialsService = async () => {
  const response = await http.get('/credentials/wc/check');
  return response.data;
}

export const deleteCredentialsService = async () => {
  const response = await http.delete('/credentials/wc');
  return response.data;
}