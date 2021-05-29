<template>
    <div class="sidebar left-sidebar">
        <div class="s-side-text">
            <div class="sidebar-title clearfix">
                <h4 class="floatleft">Categories</h4>
                <h5 class="floatright"><a href="#">All</a></h5>
            </div>
            <div class="categories left-right-p">
                <ul id="accordion" class="panel-group clearfix">
                    <li class="panel">
                        <div class="medium-a" v-for="category in sidebarInfo.categories" :key="category.id">
                               <span @click.prevent="productFilter(category.id, 'category_id')"> {{category.name}}</span>
                        </div>
                        <!-- <div data-toggle="collapse" data-parent="#accordion" data-target="#collapse1">
                            <div class="medium-a">
                                Women
                            </div>
                        </div> -->
                        <!-- <div class="panel-collapse collapse in" id="collapse1">
                            <div class="normal-a">
                                <a href="#">Men Bag</a>
                                <a href="#">Shoes</a>
                                <a href="#">Watch</a>
                                <a href="#">T-shirt</a>
                                <a href="#">shirt</a>
                            </div>
                        </div> -->
                    </li>
                </ul>
            </div>
        </div>
        <div class="s-side-text">
            <div class="sidebar-title">
                <h4>price</h4>
            </div>
            <div class="range-slider clearfix">
                <form action="#" method="get">
                    <label><span>You range </span> 
                    <span v-if="sidebarInfo.price">
                        {{currency}}{{sidebarInfo.price.min}} - {{currency}}{{sidebarInfo.price.max}}
                    </span>
                    <!-- <input type="text" id="amount" readonly /> -->
                    </label>
                    <div class="block" v-if="sidebarInfo.price">
                        <el-slider
                        @change="productFilter('', 'price')"
                        :min="sidebarInfo.price.min"
                        v-model="value"
                        range
                        show-stops
                        :max="sidebarInfo.price.max">
                        </el-slider>
                    </div>
                    <!-- <div id="slider-range"></div> -->
                </form>
            </div>
        </div>
        <div class="s-side-text">
            <div class="sidebar-title clearfix">
                <h4 class="floatleft">size</h4>
                <h5 class="floatright"><a href="#">All</a></h5>
            </div>
            <div class="size-select clearfix">
                <a href="#" v-for="size in jsonData.size" :key="size.value" @click.prevent="productFilter(size.value, 'size')">
                    {{size.label}}
                </a>
              
            </div>
        </div>
        <div class="s-side-text">
            <div class="sidebar-title clearfix">
                <h4 class="floatleft">color</h4>
                <h5 class="floatright"><a href="#">All</a></h5>
            </div>
            <div class="color-select clearfix">
                <span @click.prevent="productFilter(color.value.substring(1), 'color')" :style="`background: ${color.value}`" v-for="color in jsonData.color" :key="color.value"></span>
            </div>
        </div>
        <div class="s-side-text">
            <div class="sidebar-title clearfix">
                <h4 class="floatleft">brands</h4>
                <h5 class="floatright"><a href="#">All</a></h5>
            </div>
            <div class="brands-select clearfix">
                <ul>
                    <li v-for="(chunk,index) in brands" :key="index">
                        <a href="#" v-for="brand in  chunk" :key="brand.id" @click.prevent="productFilter(brand.id, 'brand_id')">
                            {{brand.name}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- <div class="s-side-text">
            <div class="banner clearfix">
                <a href="#"><img src="img/products/banner.jpg" alt="" /></a>
                <div class="banner-text">
                     <h2>best</h2> <br />
                     <h2 class="banner-brand">brand</h2>
                </div>
            </div>
        </div> -->
    </div>
</template>

<script>
import formJson from '../../../common/helper/form'
export default {
    name: 'ProductSidebar',
    data(){
        return {
            jsonData: formJson.options,
            value: [0, 1000],
            currency: process.env.MIX_APP_CURRENCY,
            form:{
                data: '',
                field: ''
            }
        }
    },
    methods: {
        productSidebarInfo(){
            this.$store.dispatch('product/productSidebarInfo')
        },
        productFilter(data, field){
                if (data==='') {
                   this.form.data = this.value; 
                }else{
                    this.form.data = data; 
                }
                this.form.field = field;
            this.$store.dispatch('product/productFilter', JSON.stringify(this.form))
        }
    },
    created(){
        this.productSidebarInfo();
    },
    computed: {
        sidebarInfo(){
            return this.$store.getters['product/productSidebarInfo'];
        },
        brands(){
            return _.chunk(this.sidebarInfo.brands, 2);
        }
    }
}
</script>

<style>

</style>