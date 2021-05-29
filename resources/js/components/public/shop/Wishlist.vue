<template>
       	<!-- wishlist content section start -->
    <section class="pages wishlist-page section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive padding60">
                        <table class="wishlist-table text-center">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <!-- <th>Stock Status </th> -->
                                    <th>Add To Cart</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                             
                                <tr v-for="wishlist in wishlists.data" :key="wishlist.id">
                              
                                    <td class="td-img text-left">
                                        <a href="#">
                                            <img :src="`/uploads/${wishlist.product.image}`" :alt="wishlist.product.name" />
                                        </a>
                                        <div class="items-dsc">
                                            <h5><a href="#">{{wishlist.product.name}}</a></h5>
                                            <p class="itemcolor">Color : 
                                                <span class="color-select clearfix">
                                                    <span  :style="`background: ${color.value}`" v-for="color in wishlist.product.color" :key="color.value"></span>
                                                </span>
                                            </p>
                                            <p class="itemcolor">Size   : 
                                                <span v-for="size in wishlist.product.size" :key="size">
                                                   {{size}},
                                                </span>
                                            </p>
                                        </div>
                                    </td>
                                    <td>{{wishlist.product.price}}</td>
                                    <!-- <td>In Stock</td> -->
                                    <td>
                                        <div class="submit-text">
                                            <a href="#">Add to cart</a>
                                        </div>
                                    </td>
                                    <td @click.prevent="removeToWishlist(wishlist.id)"><i class="mdi mdi-close" title="Remove this product"></i></td>
                                </tr>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
		<!-- wishlist content section end -->
</template>

<script>
export default {
    name: 'Wishlist',
    data(){
        return {
            currentPage: 1,
        }
    },
    methods: {
        wishList() {
            this.$store.dispatch('wishlist/wishList', this.currentPage)
        },
        removeToWishlist(id) {
           this.$store.dispatch('wishlist/deleteWishList', id)
           .then(res =>{
               	this.$message({
					message: 'Product Deleted Successfully from Wishlist...',
					type: 'success'
				});
           })
           
        }
    },
     created() {
        this.wishList();
    },
    computed: {
        wishlists(){
            return this.$store.getters['wishlist/wishList'];
        }
    }
}
</script>

<style>

</style>