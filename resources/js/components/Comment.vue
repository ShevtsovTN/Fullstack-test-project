<template>
  <div class="container">
    <slot
      name="content"
    ></slot>
    <slot
      name="author"
    ></slot>
  </div>
</template>

<script>
  export default {
    name: 'Comment',
    computed: {
      comment() {
        return 'test'
      }
    },
  }
</script>

<style scoped>

</style>
