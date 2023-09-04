<template>
  <h1>Catalog</h1>
  <HeaderRow />
  <v-divider></v-divider>
  <v-container fluid class="pa-0 ma-0" v-if="fetchingState === 'success'">
    <v-list class="pa-0 bg-transparent overflow-hidden">
      <ProductRow
      :product="product"
      v-on:clickOnEdit="editProduct"
      v-for="product in products"
      />
    </v-list>
  </v-container>
  <v-container fluid class="pa-0 ma-0" v-if="fetchingState === 'loading'">
    <VSkeletonLoader type="table"></VSkeletonLoader>
  </v-container>
  <v-pagination :length="pages" v-model="page"></v-pagination>
  <v-dialog fullscreen v-model="displayEditor">
    <ProductEditor
      v-on:close="handleEditorClose"
      v-on:save="handleEditorSave"
      :product="editedProduct"
      :updating="updatingProduct"
    />
  </v-dialog>
</template>

<script>
import { getProductsService, updateProductService } from '../../services/productsService';
import { VSkeletonLoader } from 'vuetify/labs/VSkeletonLoader';
import HeaderRow from './catalog/list/HeaderRow.vue';
import ProductRow from './catalog/list/ProductRow.vue';
import ProductEditor from './catalog/editor/ProductEditor.vue';
import { toRaw } from 'vue';

export default{
  data() {
    return {
      products: [],
      page: 1,
      size: 10,
      pages: 3,
      fetchingState: 'loading',
      displayEditor: false,
      editedProduct: {},
      updatingProduct: false,
    }
  },
  components: {
    VSkeletonLoader,
    HeaderRow,
    ProductRow,
    ProductEditor
},
  methods: {
    getProducts: function (){
      this.fetchingState = 'loading';
      getProductsService({page: this.page, size: this.size})
      .then((data) => {
        this.products = data.products;
        this.pages = data.pages;
        this.fetchingState = 'success';
      })
      .catch(() => {
        this.fetchingState = 'error';
      })
    },
    editProduct: function(id) {
      this.editedProduct = this.products.find((product) => product.id === id);
      this.displayEditor = true;
    },
    handleEditorClose: function() {
      this.displayEditor = false;
    },
    handleEditorSave: async function({product, modifiedVariations}) {
      try {
        await this.updateProduct({product, modified_variations: modifiedVariations});
        this.displayEditor = false;
      } catch (error) {
        console.error(error);
      }
    },
    updateProduct: async function(product) {
      try {
        this.updatingProduct = true;
        const updatedProduct = await updateProductService(product)
        const updatedProductIndex = this.products.findIndex((product) => product.id === updatedProduct.id);
        this.products[updatedProductIndex] = updatedProduct; 
        this.updatingProduct = false;
        return;
      } catch (error) {
        this.updatingProduct = false;
        console.error(error)
        throw new Error("There was an error trying to update the product");
      }
    }
  },
  mounted() {
    this.getProducts();
  },
  watch: {
    page() {
      this.getProducts();
    }
  }
}
</script>