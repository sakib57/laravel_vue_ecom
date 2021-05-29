<template>
    <div class="content-wrapper">
        <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
              <div class="col-12">
                  <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Order List</h3>
                            <!-- <el-button type="primary" round>Add New <i class="el-icon-plus"></i> </el-button> -->
                        </div>
                    </div>
                      <el-table
                        ref="multipleTable"
                        :data="orders.data"
                        style="width: 100%"
                        @selection-change="handleSelectionChange">
                        <el-table-column
                        type="selection"
                        width="55">
                        </el-table-column>
                        <el-table-column
                        label="Date"
                        width="120">
                        <template slot-scope="scope">{{ scope.row.created_at | timeFormat }}</template>
                        </el-table-column>
                        <el-table-column
                        property="payment_type"
                        label="Payment Type"
                        width="120">
                        </el-table-column>
                        <el-table-column
                        property="total"
                        label="Total"
                        show-overflow-tooltip>
                        </el-table-column>
                         <el-table-column
                        property="status"
                        label="Status"
                        show-overflow-tooltip>
                        </el-table-column>
                        <el-table-column 
                          label="Action"
                          fixed="right"
                        >
                            <template slot-scope="scope">
                                <el-button @click="orderDetails(scope.row.id)" type="text" size="small">Detail</el-button>
                                <!-- <el-button type="text" size="small">Edit</el-button> -->
                                <!-- <el-button type="text" size="small">Delete</el-button> -->
                            </template>
                        </el-table-column>
                    </el-table>
                    <el-pagination
                    class="text-center"
                    background
                      @current-change="handleCurrentChange"
                      :current-page.sync="currentPage"
                      :page-size="orders.per_page"
                    layout="prev, pager, next"
                    :total="orders.total">
                    </el-pagination>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    name: 'UserDashboard',
      data() {
        return {
            currentPage: 1, 
            multipleSelection: []
        }
    },
    methods: {
        getUser() {
            this.$store.dispatch('user/getUser');
        },
      orderDetails(id){
        this.$router.push({name:'OrderDetails', params: {orderId: id}});
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
      orderList(){
        this.$store.dispatch('order/userOrderList', this.currentPage);
      },
      handleCurrentChange(){
          this.$store.dispatch('order/userOrderList', this.currentPage)
      },
    },
    created(){
        this.getUser();
        this.orderList();
    },
    computed:{
      orders(){
        return this.$store.getters['order/orderList'];
      },
        user() {
            return this.$store.getters['user/getAuthUser']
        }
    }
}
</script>

<style>

</style>