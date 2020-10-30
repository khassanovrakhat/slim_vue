import Vue from 'vue'
import Router from 'vue-router'
// import Resource from 'vue-resource'
import Index from '@/components/Index'
import Signup from '@/components/Signup'
import Signin from '@/components/Signin'
import CV from '@/components/CV'

// Vue.use(Resource)
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'index',
      component: Index
    },
    {
      path: '/signup',
      name: 'Signup',
      component: Signup
    },
    {
      path: '/signin',
      name: 'Signin',
      component: Signin
    },
    {
      path: '/getCV',
      name: 'CV',
      component: CV
    },
  ]
})
