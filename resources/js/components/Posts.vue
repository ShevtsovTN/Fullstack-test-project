<template>
  <div class="container">
    <b-table
      :items="posts"
      :fields="table.fields"
    >
      <template #cell(action)="data">
        <router-link
          :to="`/` + data.item.id"
          class="btn btn-primary"
        >Show</router-link>
      </template>
    </b-table>
  </div>
</template>

<script>
  export default {
    name: 'Posts',
    data() {
      return {
        table: {
          fields: [
            {
              key: 'id',
              label: 'ID',
              sortable: true
            },
            {
              key: 'heading',
              label: 'Heading',
              sortable: false
            },
            {
              key: 'description',
              label: 'Description',
              sortable: false
            },
            'action'
          ]
        }
      }
    },
    computed: {
      posts() {
        return this.$store.getters.allPosts
      }
    },
    mounted () {
      this.$store.dispatch('getPosts')
    }
  }
</script>

<style scoped>

</style>
