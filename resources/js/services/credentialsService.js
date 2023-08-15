import http from "./http";

export const createCredentialsService = async (body) => {
  const response = await http.post('/credentials/wc', body);
  return response.data;
};

export const checkCredentialService = async () => {
  const response = await http.get('/credentials/wc/check');
  return response.data;
}