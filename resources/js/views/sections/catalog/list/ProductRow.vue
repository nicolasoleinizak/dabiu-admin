<template>
  <CatalogRow>
    <template v-slot:product-image class="centered">
      <ProductThumbnail :image_src="product.image_url"/>
    </template>
    <template v-slot:product-name>
      <span class="product-name" @click="$emit('clickOnEdit', product.id)">{{ product.name }}</span>
    </template>
    <template v-slot:product-price>
      <span>{{ getCurrency(product.sale_price) }}</span>
    </template>
    <template v-slot:product-regular-price>
      <span>{{ getCurrency(product.regular_price) }}</span>
    </template>
    <template v-slot:product-stock>
      <span>{{ product.stock_quantity ?? '-' }}</span>
    </template>
    <template v-slot:product-availability>
      <span>{{ getStockMessage(product.stock_status) }}</span>
    </template>
    <template v-slot:product-edit>
      <span>
        <v-btn icon="mdi-square-edit-outline" variant="tonal" @click="$emit('clickOnEdit', product.id)"></v-btn>
      </span>
    </template>
  </CatalogRow>
  <v-divider></v-divider>
</template>

<script>
import VariationsList from './VariationsList.vue';
import CatalogRow from './CatalogRow.vue';
import ProductThumbnail from '../../../../components/ProductThumbnail.vue';
import { getCurrency } from '../../../../helpers/getCurrency';

export default{
    props: ['product'],
    methods: {
        getStockMessage: function (status) {
            if (status === 'instock') {
                return "Sí";
            }
            return "No";
        },
        getCurrency
    },
    components: { VariationsList, CatalogRow, ProductThumbnail },
    emits: ['clickOnEdit']
}
</script>

<style>
  .thumbnail{
    max-width: 60px;
  }
  .product-name:hover{
    font-weight: bold;
    cursor: pointer;
  }
</style>