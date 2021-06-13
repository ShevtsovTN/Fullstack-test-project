import Posts from '../components/Posts'
import Post from '../components/Post'

const routes = [
  {
    path: '',
    name: 'main',
    component: Posts
  },
  {
    path: '/:id',
    name: 'post',
    component: Post
  },
  {
    path: '*',
    redirect: 'main'
  }
]

export default routes
