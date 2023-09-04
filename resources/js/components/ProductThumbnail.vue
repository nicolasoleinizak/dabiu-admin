<template>
  <div class="product-thumbnail rounded-circle" outlined>
    <img :src="image_src"/>
  </div>
</template>

<script>
export default{
  props: ['image_src']
}
</script>

<style>
.product-thumbnail{
  width: 50px;
  height: 50px;
  overflow: hidden;
  border: solid 3px rgba(0,0,0,0.2);
}
.product-thumbnail img{
  width: 110%;
  margin-left: -5%;
  margin-top: -5%;
  height: auto;
}
</style>