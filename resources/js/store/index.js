import Vue from 'vue';
import Vuex from 'vuex';
import * as posts from './modules/posts'

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        posts
    },
})

export default store;
