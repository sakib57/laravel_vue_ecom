import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Home from '../components/public/Home'
import Shop from '../components/public/shop/Shop'
import About from '../components/public/shop/About'
import Contact from '../components/public/shop/Contact'
import Cart from '../components/public/shop/Cart'
import Checkout from '../components/public/shop/Checkout'
import Wishlist from '../components/public/shop/Wishlist'


// User Component
import UserLogin from '../components/public/auth/UserLogin'
import UserRegister from '../components/public/auth/UserRegister'
import UserDashboard from '../components/public/user/UserDashboard'


const router = new VueRouter({
    mode: 'history',
    routes:[
        { path:'/', component: Home, name: 'Home'},
        { path:'/shop', component: Shop, name: 'Shop'},
        { path:'/about', component: About, name: 'About'},
        { path:'/contact', component: Contact, name: 'Contact'},
        { path:'/cart', component: Cart, name: 'Cart'},

        { 
            path:'/checkout', component: Checkout, name: 'Checkout',
            beforeEnter: (to, from, next) => {
                const isAuthenticated = localStorage.getItem('userLoggedIn') ? true : false;
                if (to.name !== 'UserLogin' && !isAuthenticated) next({ name: 'UserLogin' })
                else next()
            }
        },
        { 

            path:'/wishlist', component: Wishlist, name: 'Wishlist',
            beforeEnter: (to, from, next) => {
                const isAuthenticated = localStorage.getItem('userLoggedIn') ? true : false;
                if (to.name !== 'UserLogin' && !isAuthenticated) next({ name: 'UserLogin' })
                else next()
            }
            
        },
        // User Component
        { 
            path:'/user-login', component: UserLogin, name: 'UserLogin',
            beforeEnter: (to, from, next) => {
                const isAuthenticated = localStorage.getItem('userLoggedIn') ? true : false;
                if (to.name == 'UserLogin' && isAuthenticated) next({ name: 'UserDashboard' })
                else next();
              }
        },
        { path:'/user-register', component: UserRegister, name: 'UserRegister'},

        { 
            path:'/user/user-dashboard', component: UserDashboard, name: 'UserDashboard',
            beforeEnter: (to, from, next) => {
                const isAuthenticated = localStorage.getItem('userLoggedIn') ? true : false;
                if (to.name !== 'UserLogin' && !isAuthenticated) next({ name: 'UserLogin' })
                else next()
              }
        },
    ]

  })

  export default router;