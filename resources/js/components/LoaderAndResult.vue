<template>
  <v-progress-circular v-if="state === 'loading'" indeterminate :size="21"></v-progress-circular>
  <v-icon icon="$warning" v-if="state === 'ready'"></v-icon>
  <v-icon icon="$warning" v-if="state === 'failed'"></v-icon>
</template>

<script>
export default {
  props: ['state'],
};
</script>
