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
                            <h3 class="card-title">Category List</h3>
                            <el-button type="primary" round>Add New <i class="el-icon-plus"></i> </el-button>
                        </div>
                    </div>
                      <el-table
                        ref="multipleTable"
                        :data="tableData"
                        style="width: 100%"
                        @selection-change="handleSelectionChange">
                        <el-table-column
                        type="selection"
                        width="55">
                        </el-table-column>
                        <el-table-column
                        label="Date"
                        width="120">
                        <template slot-scope="scope">{{ scope.row.date }}</template>
                        </el-table-column>
                        <el-table-column
                        property="name"
                        label="Name"
                        width="120">
                        </el-table-column>
                        <el-table-column
                        property="address"
                        label="Address"
                        show-overflow-tooltip>
                        </el-table-column>
                        <el-table-column 
                             fixed="right"
                        >
                            <template slot-scope="scope">
                                <el-button @click="handleClick" type="text" size="small">Detail</el-button>
                                <el-button type="text" size="small">Edit</el-button>
                                <el-button type="text" size="small">Delete</el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                    <el-pagination
                    class="text-center"
                    background
                    layout="prev, pager, next"
                    :total="1000">
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
    name: 'CategoryList',
     data() {
      return {
        tableData: [{
          date: '2016-05-03',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-02',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-04',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-01',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-08',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-06',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-07',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }],
        multipleSelection: []
      }
    },

    methods: {
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
      }
    }
}
</script>

<style>

</style>