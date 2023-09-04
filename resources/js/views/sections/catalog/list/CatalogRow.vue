<template>
  <div fluid class="catalog-row pa-1">
    <div><slot name="product-image"></slot></div>
    <div><slot name="product-name"></slot></div>
    <div class="d-none d-sm-block"><slot name="product-price"></slot></div>
    <div class="d-none d-lg-block"><slot name="product-regular-price"></slot></div>
    <div class="d-none d-sm-block"><slot name="product-stock"></slot></div>
    <div class="d-none d-lg-block"><slot name="product-availability"></slot></div>
    <div class="d-none d-sm-block"><slot name="product-edit"></slot></div>
  </div>
</template>

<style>
  .catalog-row{
    display: grid;
    grid-template-columns: 60px 1fr;
    align-items: center;
    grid-gap: 1rem;
  }
  @media (min-width: 600px) {
    .catalog-row{
      grid-template-columns: 60px 3fr 1fr 1fr 1fr;
    }
  }
  @media (min-width: 1280px) {
    .catalog-row{
      display: grid;
      grid-template-columns: 60px 3fr 1fr 1fr 1fr 1fr 1fr;
      align-items: center;
      grid-gap: 1rem;
    }
  }
</style>