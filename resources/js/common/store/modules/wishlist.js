import Axios from "axios"

export const wishlist = {
    namespaced: true,
    state:{
      wishlists: [],
    },
    getters:{
        wishList(state){
          return state.wishlists;
      }
    },
    actions: {
        wishList(context, payload) {
            Axios.get('/user/wishlist/?page='+payload)
            .then(res=>{
                context.commit('wishList', res.data.wishlists)
            })
        },
        deleteWishList(context, payload){
            Axios.delete('/user/wishlist/'+payload)
            .then(res=>{
                context.commit('wishList', res.data.wishlists)
            })
        },
        // wishListAll(context){
        //     Axios.get('/admin/all-wishList')
        //     .then(res=>{
        //         context.commit('wishList', res.data.wishlists)
        //     })
        // }
    },
    mutations: {
        wishList(state, payload) {
            return state.wishlists = payload;
        }
    }
      
}