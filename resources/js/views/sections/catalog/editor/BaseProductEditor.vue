<template>
  <v-container fluid class="pa-2 pa-sm-4">
    <h3 class="bg-grey-lighten-3 pa-2 mb-2 rounded">{{ editingBaseProduct.name }}</h3>
    <v-container class="d-flex align-top flex-wrap">
      <div class="product-image d-block" >
        <img :src="editingBaseProduct.image_url" />
      </div>
      <div class="flex-grow-1 pa-sm-5 pa-0">
        <v-container fluid class="py-1 px-0 product-editor-field">
          <label class="mr-5">Precio de venta</label>
          <v-text-field v-model="editingBaseProduct.sale_price" hide-details/>
        </v-container>
        <v-container fluid class="py-1 px-0 product-editor-field">
          <label class="mr-5">Precio regular</label>
          <v-text-field v-model="editingBaseProduct.regular_price" hide-details/>
        </v-container>
        <v-container fluid class="py-1 px-0 product-editor-field">
          <label class="mr-5">Manejar inventario?</label>
          <v-checkbox v-model="editingBaseProduct.manage_stock" hide-details/>
        </v-container>
        <v-container fluid class="py-1 px-0 product-editor-field" v-if="editingBaseProduct.manage_stock">
          <label class="mr-5">Stock</label>
          <v-text-field v-model="editingBaseProduct.stock_quantity" hide-details/>
        </v-container>
        <v-container fluid class="py-1 px-0 product-editor-field" v-if="!editingBaseProduct.manage_stock">
          <label class="mr-5">Disponible</label>
          <v-switch v-model="editingBaseProduct.stock_status" true-value="instock" false-value="outofstock" hide-details/>
        </v-container>
      </div>
    </v-container>
  </v-container>
</template>

<script>
export default{
  data() {
    return {
      editingBaseProduct: Object.assign({}, this.baseProduct)
    }
  },
  props: ['baseProduct'],
  watch: {
    editingBaseProduct: {
      handler() {
        this.$emit('updateBaseProduct', this.editingBaseProduct)
      },
      deep: true,
    }
  },
  emits: [
    'updateBaseProduct'
  ]
}
</script>


<style>
.product-image{
  width: 30%;
  height: max-content;
  min-width: 200px;
  max-width: 300px;
  border: solid 3px rgba(0,0,0,0.3);
}
.product-image img{
  width: 100%;
  height: auto;
}

</style>