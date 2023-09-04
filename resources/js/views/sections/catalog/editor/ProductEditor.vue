<template>
  <v-container fluid class="fill-height bg-white d-flex justify-center overflow-auto">
    <v-container class="border rounded-lg pa-0">
      <BaseProductEditor
        :baseProduct="editingProduct"
        v-on:update-base-product="updateBaseProduct"
      />
    </v-container>
    <v-container v-if="editingProduct.variations" class="border rounded-lg mt-5">
      <v-container class="py-8">
        <span>Variantes</span>
        <v-container v-for="variation in editingProduct.variations" class="d-flex align-top flex-wrap">
          <VariationEditor
            :variation="variation"
            :product="editingProduct"
            v-on:update="updateVariation"
          />
        </v-container>
      </v-container>
    </v-container>
    <v-container class="d-flex justify-end">
      <v-btn variant="outlined" class="mx-2" @click="$emit('close')">Cerrar</v-btn>
      <v-btn 
        variant="outlined"
        class="mx-2"
        @click="$emit('save', {product: editingProduct, modifiedVariations: [...modifiedVariations]})"
        :disabled="!thereIsChanges">
          <span v-if="!updating">Guardar</span>
          <span v-if="updating"><v-progress-circular indeterminate model-value="15"/></span>
      </v-btn>
    </v-container>
  </v-container>
</template>

<script>
import BaseProductEditor from './BaseProductEditor.vue';
import VariationEditor from './VariationEditor.vue';

export default{
    data() {
        return {
            thereIsChanges: false,
            editingProduct: Object.assign({}, this.product),
            modifiedVariations: new Set()
        };
    },
    props: ['product', 'updating'],
    methods: {
      updateBaseProduct: function(baseProduct) {
        this.thereIsChanges = true;
        this.editingProduct = {
          ...this.editingProduct,
          name: baseProduct.name,
          image_url: baseProduct.image_url,
          sale_price: baseProduct.sale_price,
          regular_price: baseProduct.regular_price,
          manage_stock: baseProduct.manage_stock,
          stock_quantity: baseProduct.stock_quantity,
          stock_status: baseProduct.stock_status,
        }
      },
      updateVariation: function(updatedVariation) {
        this.thereIsChanges = true;
        this.modifiedVariations.add(updatedVariation.id);
        const variationIndex = this.product.variations.findIndex((variation) => variation.id === updatedVariation.id);
        this.editingProduct.variations[variationIndex] = updatedVariation;
      }
    },
    emits: ['close', 'save'],
    components: { VariationEditor, BaseProductEditor }
}
</script>

<style>
.product-editor-field{
  display: grid;
  grid-template-columns: 140px 1fr;
  grid-gap: 0.5rem;
  align-items: center;
}
.product-editor-field label{
  text-align: right;
}
</style>

