<template>
  <div class="container">
      <b-form @submit.prevent="onSubmit" @reset="onReset">
        <b-form-input
          v-model.trim="text"
          @blur="isBlurInput"
          type="text"
          @focus="isFocusedInput"
          id="commentForm"
          class="mb-2"
          :class="{'is-invalid': $v.text.$error}"
        ></b-form-input>
        <div class="invalid-feedback mb-3" v-if="!$v.text.required || !$v.text.alphaNum">Field is invalid</div>
        <div
          v-if="isFocused"
          class="d-flex align-items-center mt-3"
        >
          <b-button
            type="submit"
            variant="btn btn-primary"
            :disabled="$v.$invalid"
          >Submit</b-button>
          <b-button type="reset" variant="btn btn-outline-dark ml-3">Cancel</b-button>
        </div>
      </b-form>
  </div>
</template>

<script>
  import { alphaNum, required } from 'vuelidate/lib/validators'

  export default {
    name: 'InputForm',
    data() {
      return {
        isFocused: false,
        text: '',
        modalMessage: '',
        modalAction: {},
        comment_id: null,
        placeholder: 'Enter your comment'
      }
    },
    props: ['updatebleComment'],
    validations: {
      text: {
        alphaNum,
        required
      }
    },
    methods: {
      isFocusedInput: function () {
        document.querySelector('#commentForm').removeAttribute('placeholder')
        this.isFocused = true
      },
      isBlurInput: function () {
        this.$v.text.$touch()
        document.querySelector('#commentForm').setAttribute('placeholder', this.placeholder)
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
    mounted() {
      document.querySelector('#commentForm').setAttribute('placeholder', this.placeholder)
    },
    watch: {
      updatebleComment: function (val, oldVal) {
        this.text = val.content
        this.comment_id = val.id
        this.isFocused = true
      },
    },
  }
</script>
