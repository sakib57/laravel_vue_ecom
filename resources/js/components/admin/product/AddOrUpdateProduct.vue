<template>
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">

                                    <h3 class="card-title" v-if="form.id">Update Product</h3>
                                    <h3 class="card-title" v-else>Add New Product</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                  <el-form   @submit.prevent="saveOrUpdateProduct">
                                    <el-form-item label="Product Name">
                                        <el-input v-model="form.name" placeholder="Product Name"></el-input>
                                        <span class="text-danger" v-if="errors['name']">
                                            {{errors['name'][0]}}
                                        </span>
                                    </el-form-item>
                                      <el-form-item label="Select Category">
                                        <el-select v-model="form.category_id" placeholder="Please select a category">
                                            <el-option v-for="category in categories" :key="category.id" :label="category.name" :value="category.id"></el-option>
                                        </el-select>
                                        <span class="text-danger" v-if="errors['category_id']">
                                            {{errors['category_id'][0]}}
                                        </span>
                                    </el-form-item>
                                      <el-form-item label="Select Brand">
                                        <el-select v-model="form.brand_id" placeholder="Please select a brand">
                                            <el-option v-for="brand in brands" :key="brand.id" :label="brand.name" :value="brand.id"></el-option>
                                        </el-select>
                                        <span class="text-danger" v-if="errors['brand_id']">
                                            {{errors['brand_id'][0]}}
                                        </span>
                                    </el-form-item>
                                     <el-form-item label="Product Price">
                                        <el-input type="number" v-model="form.price" placeholder="Product Price"></el-input>
                                        <span class="text-danger" v-if="errors['price']">
                                            {{errors['price'][0]}}
                                        </span>
                                    </el-form-item>
                                      <el-form-item label="Discount Price">
                                        <el-input type="number" v-model="form.discount_price" placeholder="Discount Price"></el-input>
                                        <span class="text-danger" v-if="errors['discount_price']">
                                            {{errors['discount_price'][0]}}
                                        </span>
                                    </el-form-item>
                                    <el-form-item label="Product Description">
                                        <el-input v-model="form.description" placeholder="Product Description"></el-input>
                                        <span class="text-danger" v-if="errors['description']">
                                            {{errors['description'][0]}}
                                        </span>
                                    </el-form-item>
                                     <el-form-item label="Product Size">
                                        <el-checkbox-group v-model="form.size">

                                            <el-checkbox v-for="size in options.options.size" :key="size.value" :label="size.value" name="type">
                                               {{size.label}}
                                            </el-checkbox>
                                           
                                        </el-checkbox-group>
                                         <span class="text-danger" v-if="errors['size']">
                                            {{errors['size'][0]}}
                                        </span>
                                    </el-form-item>
                                     <el-form-item label="Product Color">
                                        <el-checkbox-group v-model="form.color">

                                             <el-checkbox v-for="color in options.options.color" :key="color.value" :label="color.value" name="type">
                                                 {{color.label}}
                                             </el-checkbox>
                                           
                                        </el-checkbox-group>
                                         <span class="text-danger" v-if="errors['color']">
                                            {{errors['color'][0]}}
                                        </span>
                                    </el-form-item>
                                     <el-form-item label="Product Image">
                                        <input type="file" @change="handleImage"  placeholder="Product Image"/>
                                        <img :src="`/uploads/${product.image}`" alt="" width="80px" v-if="form.image">
                                        <span class="text-danger" v-if="errors['image']">
                                            {{errors['image'][0]}}
                                        </span>
                                    </el-form-item>

                                    <el-form-item label="Product Quantity">
                                        <el-input type="number" v-model="form.quantity" placeholder="Product Quantity"></el-input>
                                        <span class="text-danger" v-if="errors['quantity']">
                                            {{errors['quantity'][0]}}
                                        </span>
                                    </el-form-item>
                             
                                     <el-button @click.prevent="saveOrUpdateProduct" type="primary" style="float:right">Submit</el-button>

                                </el-form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import jsonOptions from '../../../common/helper/form'
export default {
    name: 'AddOrUpdateProduct',
    data(){
        return {
            options: jsonOptions,
            errors: {},
            form: {
               image: '',
               size: [],
               color: [],
               category_id: '',
               brand_id: '',
               name: '',
               price: '',
               discount_price: '',
               description: '',
               quantity: '',
            }
        }
    },
    methods: {
        handleImage(e) {
            // console.log(e.target.files[0])
            this.form.image = e.target.files[0];
        },
        categoryList(){
          this.$store.dispatch('category/categoryListAll');
      },
      brandList(){
          this.$store.dispatch('brand/brandListAll');
      },
      saveProduct(formData){
         
            // console.log(formData)
          axios.post('/admin/product', formData)
          .then(res=>{
            this.$message({
                message: 'Product Added Successfully...',
                type: 'success'
          });
              this.$router.push({name: 'ProductList'});
          })
          .catch(err=>{
              this.errors = err.response.data.errors
          })
      },
      updateProduct(formData){
        
          axios.post(`/admin/product-update/${this.$route.params.productId}`, formData)
           .then(res=>{
               console.log(res.data)
            this.$message({
                message: 'Product Updated Successfully...',
                type: 'success'
          });
              this.$router.push({name: 'ProductList'});
          })
          .catch(err=>{
              this.errors = err.response.data.errors
          })
      },
      saveOrUpdateProduct(){
           let formData = new FormData();
            formData.append('category_id', this.form.category_id);
            formData.append('brand_id', this.form.brand_id);
            formData.append('name', this.form.name);
            formData.append('price', this.form.price);
            formData.append('discount_price', this.form.discount_price);
            formData.append('description', this.form.description);
            formData.append('image', this.form.image);
            formData.append('color', this.form.color);
            formData.append('size', this.form.size);
            formData.append('quantity', this.form.quantity);
          if (this.form.id) {
             this.updateProduct(formData); 
          }else{
              this.saveProduct(formData);
          }
      },
      editProductById(){
          this.$store.dispatch('product/editProduct', this.$route.params.productId)
      }
    },
    created(){
        this.categoryList();
        this.brandList();
        if ( this.$route.params.productId) {
             this.editProductById();
        }
    },
    computed: {
        categories(){
            return this.$store.getters['category/categoryList'];
        },
        brands(){
            return this.$store.getters['brand/brandList'];
        },
        product(){
             return this.$store.getters['product/singleProduct'];
        }
    },
    watch:{
       product(){
           this.form = this.product
       } 
    }
}
</script>

<style>

</style>