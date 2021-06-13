<template>
  <div class="container">
      <b-form @submit.prevent="onSubmit" @reset="onReset">
        <b-form-input
          v-model="text"
          type="text"
          placeholder="Enter your comment"
          @focus="isFocusedInput"
          id="commentForm"
          class="mb-3"
        ></b-form-input>
        <div
          v-if="isFocused"
          class="d-flex align-items-center"
        >
          <b-button type="submit" variant="btn btn-primary">Submit</b-button>
          <b-button type="reset" variant="btn btn-outline-dark ml-3">Cancel</b-button>
        </div>
      </b-form>
  </div>
</template>

<script>
  export default {
    name: 'InputForm',
    data() {
      return {
        isFocused: false,
        text: '',
        modalMessage: '',
        modalAction: {},
        comment_id: null
      }
    },
    props: ['updatebleComment'],
    methods: {
      isFocusedInput: function () {
        this.isFocused = true
      },
      onSubmit: function () {
        const options = {
          okVariant: this.text ? 'success' : 'danger',
          headerClass: 'text-center',
          size: 'sm',
          buttonSize: 'sm',
        }
        if (this.text) {
          if (this.comment_id) {
            this.$store.dispatch('updateComment', {
              text: this.text,
              id: this.comment_id,
            })
            this.$bvModal.msgBoxOk('Comment has been updated', options)
          } else {
            this.$store.dispatch('createComment', this.text)
            this.$bvModal.msgBoxOk('Comment has been added', options)
          }
          this.onReset()
        } else {
          this.$bvModal.msgBoxOk('Comment must be not empty', options)
        }
      },
      onReset: function () {
        this.comment_id = null,
        this.text = ''
        this.isFocused = false
      }
    },
    watch: {
      updatebleComment: function (val, oldVal) {
        this.text = val.content
        this.comment_id = val.id
        this.isFocused = true
      }
    },
  }
</script>
