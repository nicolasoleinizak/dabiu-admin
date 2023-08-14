import http from "./http";

export const createCredentialsService = async (body) => {
  const response = await http.post('/credentials/wc', body);
  return response.data;
};