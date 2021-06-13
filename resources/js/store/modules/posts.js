import axios from 'axios'

export const state = () => ({
  allPosts: [],
  post: {},
  comment: {
    id: null,
    text: ''
  }
})

export const getters = {
  allPosts: (state) => state.allPosts,
  post: (state) => state.post,
  comment: (state) => state.comment,
}

export const mutations = {
  SET_POSTS (state, newValue) {
    state.allPosts = newValue
  },
  
  SET_POST (state, newValue) {
    state.post = newValue[0]
    state.post.comments.sort((a, b) => {
      return b.id - a.id;
    })
    state.post.comments.forEach(element => dateNormalize(element))
  },
  
  ADD_COMMENT (state, newValue) {
    state.post.comments.unshift(dateNormalize(newValue))
  },
  
  UPDATE_COMMENT (state, newValue) {
    state.post.comments.forEach(element => {
      if (element.id === newValue.id) {
        element.content = newValue.content
      }
    })
  },
  
  DELETE_COMMENT (state, id) {
    state.post.comments = state.post.comments.filter((item) => item.id !== id)
  },
}

export const actions = {
  getPosts ({ commit }) {
    axios.get('api/posts')
      .then(response => {
        commit('SET_POSTS', response.data)
      })
      .catch( error => {
        console.log(error)
      })
  },
  
  getPost ({ commit }, id) {
    axios.get('api/post/' + id)
      .then(response => {
        commit('SET_POST', response.data)
      })
      .catch( error => {
        console.log(error)
      })
  },
  
  createComment ({ commit, state }, comment) {
    axios.post('api/comments', {
        id: state.post.id,
        text: comment
      })
      .then(response => {
        commit('ADD_COMMENT', response.data)
      })
      .catch( error => {
        console.log(error)
      })
  },
  
  updateComment ({ commit }, comment) {
    axios.put('api/comments/' + comment.id, comment)
      .then(response => {
        commit('UPDATE_COMMENT', response.data)
      })
      .catch( error => {
        console.log(error)
      })
  },
  
  deleteComment ({ commit }, id) {
    axios.delete('api/comments/' + id)
      .then(response => {
        commit('DELETE_COMMENT', id)
      })
      .catch( error => {
        console.log(error)
      })
  },
}

function dateNormalize (element) {
  let created_at = new Date(element.updated_at)
  let updated_at = new Date(element.updated_at)
  element.created_at = created_at.getDate() + ' ' + created_at.toLocaleString('en', {month: 'long'})
  element.updated_at = updated_at.getDate() + ' ' + updated_at.toLocaleString('en', {month: 'long'})
  return element
}
