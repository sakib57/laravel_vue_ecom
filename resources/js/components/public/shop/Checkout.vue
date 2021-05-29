<template>
    <div>
        <!-- Checkout content section start -->
		<section class="pages checkout section-padding">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="main-input single-cart-form padding60">
							<div class="log-title">
								<h3><strong>billing details</strong></h3>
							</div>
							<div class="custom-input">
								<form action="mail.php" method="post">
									<input readonly type="text" v-model="form.name" placeholder="Name here..">
                                    <span class="text-danger" v-if="errors['name']">{{errors['name'][0]}}</span>
									<input readonly type="email" v-model="form.email" placeholder="Email Address..">
                                      <span class="text-danger" v-if="errors['email']">{{errors['email'][0]}}</span>
									<input readonly type="text" v-model="form.phone" placeholder="Phone Number..">
									<input readonly type="text" v-model="form.address" placeholder="Address..">
                                    Ship to Different Address: <input type="checkbox" v-model="shippingDisplay" >
								</form>
							</div>
						</div>
					</div>
					<div class="col-sm-6" v-if="shippingDisplay">
						<div class="main-input single-cart-form padding60">
							<div class="log-title">
								<h3><strong>ship to different address</strong></h3>
							</div>
							<div class="custom-input">
								<form action="mail.php" method="post">
									<input type="text" v-model="shipping.name" placeholder="Name here..">
                                    <span class="text-danger" v-if="errors['name']">{{errors['name'][0]}}</span>
									<input type="email" v-model="shipping.email" placeholder="Email Address..">
                                      <span class="text-danger" v-if="errors['email']">{{errors['email'][0]}}</span>
									<input type="text" v-model="shipping.phone" placeholder="Phone Number..">
									<input type="text" v-model="shipping.address" placeholder="Address..">
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="row margin-top">
					<div class="col-xs-12 col-sm-6">
						<div class="padding60">
							<div class="log-title">
								<h3><strong>Our order</strong></h3>
							</div>
							<div class="cart-form-text pay-details table-responsive">
								<table>
									<thead>
										<tr>
											<th>Product</th>
											<td>Total</td>
										</tr>
									</thead>
									<tbody>

										<tr v-for="product in products.products" :key="product.id"> 
											<th>{{product.name}} x {{product.quantity}}</th>
											<td>${{product.price * product.quantity}}</td>
										</tr>
									
										<!-- <tr>
											<th>Cart Subtotal</th>
											<td>$155.00</td>
										</tr>
										<tr>
											<th>Shipping and Handing</th>
											<td>$15.00</td>
										</tr>
										<tr>
											<th>Vat</th>
											<td>$00.00</td>
										</tr> -->
									</tbody>
									<tfoot>
										<tr>
											<th>Order total</th>
											<td>${{products.total}}</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6">
						<div class="padding60">
							<div class="log-title">
								<h3><strong>Payment method</strong></h3>
							</div>
							<div class="categories">
								<ul id="accordion" class="panel-group clearfix">
									<li class="panel">
                                        <select name="" id="" v-model="payment_type">
                                            <option value="cash_on_delivery">Cash On Delivery</option>
                                            <option value="card_payment">Card Paymtny</option>
                                        </select>
                                    </li>
									<div v-if="payment_type === 'card_payment'">
										<input type="number" placeholder="Card Number" v-model="cardPayment.cardNumber" required>
										<input type="number" placeholder="Exp Month" size="2" v-model="cardPayment.expMonth" required>
										<input type="number" placeholder="Exp Year" size="2" v-model="cardPayment.expYear" required>
										<input type="number" placeholder="Card CVC" size="3" v-model="cardPayment.cvc" required>
									</div>
									<!-- <li class="panel">
										<div data-toggle="collapse" data-parent="#accordion" data-target="#collapse2">
											<div class="medium-a">
												cheque payment
											</div>
										</div>
										<div class="paypal-dsc panel-collapse collapse" id="collapse2">
											<div class="normal-a">
												<p>Lorem Ipsum is simply in dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.</p>
											</div>
										</div>
									</li>
									<li class="panel">
										<div data-toggle="collapse" data-parent="#accordion" data-target="#collapse3">
											<div class="medium-a">
												paypal
											</div>
										</div>
										<div class="paypal-dsc panel-collapse collapse" id="collapse3">
											<div class="normal-a">
												<p>Lorem Ipsum is simply in dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry.</p>
											</div>
										</div>
									</li> -->
								</ul>
								<div class="submit-text" v-if="products.total > 0">
									<a href="#" @click.prevent="placeOrder">place order</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Checkout content section end -->
    </div>
</template>

<script>
export default {
    name: 'Checkout',
    data() {
        return {
            shippingDisplay: false,
            errors: [],
            form: {

            },
            shipping: {
				
			},
			payment_type: 'cash_on_delivery',
			cardPayment: {
				cardNumber: '',
				cvc: '',
				expMonth: '',
				expYear: '',
			}
        }
    },
    methods: {
		getUser() {
           this.$store.dispatch('user/getUser');
		},
		placeOrder() {
			axios.post('checkout', {
				shipping: this.shipping,
				shipping_address: this.shippingDisplay,
				payment_type: this.payment_type,
				cardInfo: this.cardPayment
			})
			.then(res => {
				
			})
			.catch(err => {

			})
		},
        productList(){
          this.$store.dispatch('cart/productList');
        }
    },
    computed: {
        products(){
            return this.$store.getters['cart/productList'];
		},
		user() {
          return this.$store.getters['user/getAuthUser']
		},
    },
    created() {
		this.productList();
		this.getUser();
	},
	watch: {
		user: {
			handler: function(newVal, oldVal) {
				this.form = newVal;
			},
			deep: true
		}
	}
}
</script>

<style>

</style>