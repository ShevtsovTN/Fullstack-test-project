<template>
  <div class="container">
    <b-card
      :title="post.heading"
    >
      <b-card-text>
        {{ post.content }}
      </b-card-text>
      <input-form
        :updatebleComment="updatebleComment"
        class="mb-3"
      >
      </input-form>
      <Comment
        v-for="comment in post.comments"
        :key="comment.id"
        class="mb-3 mt-3 pl-4"
      >
        <template v-slot:content>
          <div class="d-flex align-items-center justify-content-start">
            <div>{{ comment.content }}</div>
            <b-dropdown
              size="sm"
              variant="link"
              toggle-class="text-decoration-none"
              no-caret
            >
              <template #button-content>
                <b-icon
                  icon="caret-down"
                  class="text-dark"
                ></b-icon>
              </template>
              <b-dropdown-item-button @click="updateComment(comment)">Edit</b-dropdown-item-button>
              <b-dropdown-item-button @click="deleteComment(comment.id)">Delete</b-dropdown-item-button>
            </b-dropdown>
          </div>
        </template>
        <template
          v-slot:author
        >
          <div
            class="d-flex align-items-center"
          >
            <b-icon
              icon="person-circle"
            ></b-icon>
            <div
              class="ml-2"
            >{{ comment.author }}</div>
            <div
              class="ml-2"
            >{{ comment.updated_at }}</div>
          </div>
        </template>
      </Comment>
    </b-card>
  </div>
</template>

<script>
  import Comment from './Comment.vue'
  import InputForm from './InputForm.vue'
  export default {
    name: 'Post',
    components: {Comment, InputForm},
    data() {
      return {
        options: {
          size: 'sm',
          buttonSize: 'sm',
          okVariant: 'danger',
          okTitle: 'YES',
          cancelTitle: 'NO',
          footerClass: 'p-2',
          hideHeaderClose: true,
        },
        updatebleComment: {}
      }
    },
    methods: {
      deleteComment: function (id) {
        this.$bvModal.msgBoxConfirm('Are you sure?', this.options)
          .then(value => {
            if (value) {
              this.$store.dispatch('deleteComment', id)
            }
          })
          .catch(err => {
            console.log(err)
          })
      },
      updateComment: function (comment) {
        this.updatebleComment = comment
      },
    },
    computed: {
      post() {
        return this.$store.getters.post
      },
    },
    mounted () {
      this.$store.dispatch('getPost', this.$route.params.id)
    },
  }
</script>
