<template>
  <div class="variant-image d-block" >
    <img :src="editingVariation.image_url" />
  </div>
  <div class="flex-grow-1 pl-5 py-0">
    <v-container fluid class="d-flex align-center pa-1">
      {{ variantDescription }}
    </v-container>
    <v-container fluid class="d-flex align-center pa-1">
      <v-text-field v-model="editingVariation.sale_price" hide-details label="Precio de venta"/>
    </v-container>
    <v-container fluid class="d-flex align-center pa-1">
      <v-text-field v-model="editingVariation.regular_price" hide-details label="Precio regular"/>
    </v-container>
    <v-container fluid>
      <v-checkbox v-model="editingVariation.manage_stock" hide-details label="Manejar inventario"/>
    </v-container>
    <v-container fluid class="d-flex align-center pa-1" v-if="editingVariation.manage_stock == true">
      <v-text-field v-model="editingVariation.stock_quantity" hide-details label="Stock"/>
    </v-container>
    <v-container fluid class="d-flex align-center pa-1" v-if="editingVariation.manage_stock != true">
      <v-switch v-model="editingVariation.stock_status" true-value="instock" false-value="outofstock" label="Disponible"/>
    </v-container>
  </div>
</template>

<script>
export default{
  data() {
    return {
      editingVariation: Object.assign({}, {
        ...this.variation,
        manage_stock: this.variation.manage_stock == 'parent' ? false : this.variation.manage_stock,
      })
    }
  },
  props: ['variation', 'product'],
  watch: {
    editingVariation: {
      handler() {
        this.$emit('update', this.editingVariation)
      },
      deep: true,
    }
  },
  computed: {
    variantDescription() {
      return this.variation.attributes.reduce((description, attribute) => {
        if(description === ''){
          return `${description} ${attribute.name}: ${attribute.option}`;
        } else {
          return `${description} | ${attribute.name}: ${attribute.option}`
        }
      }, '')
    }
  },
  emits: [
    'update'
  ]
}
</script>

<style>
.variant-image{
  width: 20%;
  height: max-content;
  min-width: 200px;
  max-width: 300px;
  border: solid 3px rgba(0,0,0,0.3);
}
.variant-image img{
  width: 100%;
  height: auto;
}
.product-editor-field label{
  text-align: right;
}
</style>