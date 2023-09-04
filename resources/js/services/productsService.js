import { authenticatedHttp as http } from "./http";

export const getProductsService = async (params) => {
  const response = await http.get('/products', {params});
  return {
    pages: response.data.pages,
    products: response.data.products,
  }
};

export const updateProductService = async (body) => {
  const response = await http.put(`/products/${body.product.id}`, body);
  return response.data;
}