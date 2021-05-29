<template>
  <div class="content-wrapper">
     <div class="content">
        <div class="container-fluid">
          <div class="row">
              <div class="col-12">
                  <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Product List</h3>
                            <router-link :to="{name: 'AddOrUpdateProduct'}" type="primary">Add New <i class="el-icon-plus"></i> </router-link>
                        </div>
                         <el-button @click="multipleDelete" v-if="multipleSelection.length>0" type='danger' size="small">Multuple Delete</el-button>
                    </div>
                    
                      <el-table
                        ref="multipleTable"
                        :data="products.data"
                        style="width: 100%"
                        @selection-change="handleSelectionChange">

                        <el-table-column
                        type="selection"
                        width="55">
                        </el-table-column>

                        <el-table-column
                        label="Date"
                        width="120">
                        <template slot-scope="scope">{{ scope.row.created_at | timeFormat}}</template>
                        </el-table-column>

                        <el-table-column
                        property="name"
                        label="Name"
                        width="120">
                        </el-table-column>

                        <el-table-column
                        property="price"
                        label="Price"
                        width="120">
                        </el-table-column>

                        <el-table-column
                        property="quantity"
                        label="Quantity"
                        width="120">
                        </el-table-column>

                        <el-table-column
                        property="category_id"
                        label="Category"
                        width="120">
                        <template slot-scope="scope">{{ scope.row.category.name}}</template>
                        </el-table-column>

                         <el-table-column
                        label="Brand"
                        width="120">
                        <template slot-scope="scope">{{ scope.row.brand.name}}</template>
                        </el-table-column>

                        <el-table-column 
                          label="Actions"
                             fixed="right"
                        >
                            <template slot-scope="scope">
                                <el-button type="text" size="small" @click.prevent="productDetails(scope.row)">Details</el-button>
                                <router-link :to="{name: 'editProduct', params: { productId: scope.row.id }}">Edit</router-link>
                                <el-button @click="deleteProduct(scope.row.id)" type="text" size="small">Delete</el-button>
                            </template>
                        </el-table-column>

                    </el-table>

                    <el-pagination
                    class="text-center"
                    background
                      @current-change="handleCurrentChange"
                      :current-page.sync="currentPage"
                      :page-size="products.per_page"
                    layout="prev, pager, next"
                    :total="products.total">
                    </el-pagination>
                  </div>
              </div>
          </div>
        </div>
      </div>
      <!-- Product Details -->
      <el-dialog
  :title="product.name"
  :visible.sync="centerDialogVisible"
  width="50%"
  center>
  <span>
    <h5 v-if="product.category">Category: {{product.category.name}}</h5>
    <h5 v-if="product.brand">Brand: {{product.brand.name}}</h5>
    <p>Description: {{product.description}}</p>
    <b>Price: {{product.price}}</b> <br>
    <b>Discount Price: {{product.discount_price}}</b> <br>
    <b>Qty: {{product.quantity}}</b> <br>
    Image: <img  :src="`/uploads/${product.image}`" width="100px"/> <br>
    Size: <b v-for="(size,index) in product.size" :key="index">
      {{size}},
    </b> <br>
     Color: <b v-for="(color,index) in product.color" :key="color">
      <input type="color" :value="color"/> ,
    </b>

  </span>
</el-dialog>
<!-- Produce Details -->
  </div>
</template>

<script>
export default {
    name: 'ProductList',
    data(){
      return {
        centerDialogVisible: false,
        product: {},
        multipleSelection: [],
        currentPage: 1
      }
    },
    methods: {
      productDetails(row){
        this.product  = row;
        this.centerDialogVisible = true
      },
       productList(){
          this.$store.dispatch('product/productList', this.currentPage);
      },
       handleCurrentChange(){
          this.$store.dispatch('product/productList', this.currentPage)
      },
      toggleSelection(rows) {
        if (rows) {
          rows.forEach(row => {
            this.$refs.multipleTable.toggleRowSelection(row);
          });
        } else {
          this.$refs.multipleTable.clearSelection();
        }
      },
      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
       deleteProduct(id) {
        this.$store.dispatch('product/deleteProduct', id)
         this.$message({
          message: 'Product Deleted Successfully...',
          type: 'success'
        });
      },
      multipleDelete(){
        axios.post('/admin/multiple-product-delete', this.multipleSelection)
        .then(res=>{
            this.$message({
              message: 'Product Deleted Successfully...',
              type: 'success'
            });
            this.productList();
        })
      },
    },

    created(){
      this.productList();
    },

    computed:{
      products(){
        return this.$store.getters['product/productList'];
      }
    }
}
</script>

<style>

</style>