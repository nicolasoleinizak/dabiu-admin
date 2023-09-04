<template>
  <CatalogRow class="pa-5 header-row">
    <template v-slot:product-image>
      <span>IMAGEN</span>
    </template>
    <template v-slot:product-name>
      <span>PRODUCTO</span>
    </template>
    <template v-slot:product-price>
      <span>PRECIO</span>
    </template>
    <template v-slot:product-regular-price>
      <span>PRECIO REGULAR</span>
    </template>
    <template v-slot:product-stock>
      <span>STOCK</span>
    </template>
    <template v-slot:product-availability>
      <span>DISPONIBLE</span>
    </template>
    <template v-slot:product-edit>
      <span></span>
    </template>
  </CatalogRow>
</template>

<script>
import CatalogRow from './CatalogRow.vue';

export default{
  components: {
    CatalogRow
  }
}
</script>

<style>
.header-row{
  color: rgba(0,0,0,0.6);
}
</style>