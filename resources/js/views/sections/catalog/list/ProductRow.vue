<template>
  <CatalogRow>
    <template v-slot:product-image>
      <ProductThumbnail :image_src="product.image_url" />
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
        <v-btn
          variant="tonal"
          class="ma-2"
          icon="$edit"
          @click="$emit('clickOnEdit', product.id)">
        </v-btn>
      </span>
    </template>
  </CatalogRow>
  <v-divider></v-divider>
</template>

<script>
import CatalogRow from './CatalogRow.vue';
import ProductThumbnail from '../../../../components/ProductThumbnail.vue';
import { getCurrency } from '../../../../helpers/getCurrency';

export default {
  props: ['product'],
  methods: {
    getStockMessage: (status) => {
      if (status === 'instock') {
        return 'Sí';
      }
      return 'No';
    },
    getCurrency,
  },
  components: { CatalogRow, ProductThumbnail },
  emits: ['clickOnEdit'],
};

</script>

<style>
.thumbnail {
  max-width: 60px;
}

.product-name:hover {
  font-weight: bold;
  cursor: pointer;
}
</style>
