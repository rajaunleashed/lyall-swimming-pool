<template>
    <ValidationObserver ref="form">
        <form name="contactFrm" @submit.prevent="submit">
            <div class="row">
                <div class="col-md-12">

                <ValidationProvider v-slot="{ errors }" :rules="{ required: true }">
                        <label class="control-label" for="name">Customer</label>
                        <select class="form-control customer" v-model="customer_id" @change="getCustomer()">
                            <option value="">Select Customer</option>
                            <option v-for="customer of customers" v-bind:value="customer.id">{{ customer.name }}
                            </option>
                        </select>
                        <div v-if="errors[0]" class="error">{{ errors[0] }}</div>
                </ValidationProvider>

                </div>
                <div class="form-group col-md-3 ">
                    <label class="control-label" for="name">Product</label>
                    <select class="form-control product" v-model="item.product_id" @change="getProduct()">
                        <option value="">Select Product</option>
                        <option v-for="product of products" v-bind:value="product.id">{{ product.name }}</option>
                    </select>
                </div>

                <div class="form-group col-md-3 ">
                    <label class="control-label" for="name">Quantity</label>
                    <input type="number" class="form-control quantity" min="1" placeholder="Quantity" v-model="item.quantity" v-on:change="getProduct()">
                    <span class="error" v-if="out_of_stock">Quantity Exceeded, out of stock</span>
                </div>

                <div class="form-group col-md-3 ">
                    <label class="control-label" for="name">Discount</label>
                    <input type="number" class="form-control discount" min="0" placeholder="discount" v-model="item.discount" v-on:change="getProduct()">
                </div>

                <div class="form-group col-md-3 ">
                    <label class="control-label" for="name">Price</label>
                    <input type="number" class="form-control price" placeholder="Price" v-model="item.total" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" @click="addItem()" v-bind:disabled="!item.product_id || out_of_stock" >Save Item</button>
                    <button type="button" class="btn btn-danger" @click="resetItem()">Reset</button>
                </div>
            </div>
            <div class="row" v-if="customer">
                <div class="col-md-12">
                    <h3>Customer: {{customer}}</h3>
                </div>
            </div>
            <div class="row" v-if="items.length">
                <div class="col-md-12">
                    <table class="table table-bordered table-responsive table-striped table-hover" v-if="items.length">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Discount</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item of items">
                            <td>{{ item.product }} <br/>
<!--                                <a href="javascript:void(0)" @click="editItem(item.product_id)" style="text-decoration: none" class="text-decoration-none mt-1">Edit</a> |-->
                                <a href="javascript:void(0)" @click="removeItem(item.product_id)" style="text-decoration: none" class="text-decoration-none mt-1 badge badge-danger">Remove</a>
                            </td>
                            <td>{{ item.price | currency }}</td>
                            <td>{{ item.quantity }}</td>
                            <td>{{ item.discount }}</td>
                            <td>{{ item.total | currency }}</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr v-if="items.length">
                            <th colspan="4" style="font-weight: bold">Total</th>
                            <td style="font-weight: bold">{{ getTotal() | currency }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

<!--                <div class="col-md-12">-->
<!--                    <div class="form-check-inline">-->
<!--                        <label class="form-check-label">-->
<!--                            <input type="radio" class="form-check-input" v-model="paid_status" v-bind:value="1" v-bind:checked="paid_status"  name="paid_status"> Paid-->
<!--                        </label>-->
<!--                    </div>-->
<!--                    <div class="form-check-inline">-->
<!--                        <label class="form-check-label">-->
<!--                            <input type="radio" class="form-check-input" v-model="paid_status" v-bind:value="0" v-bind:checked="paid_status"  name="paid_status"> Unpaid-->
<!--                        </label>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" v-bind:disabled="isSubmitting">
                        {{ isSubmitting ? 'Please Wait...' : 'Submit'}}
                    </button>
                </div>

            </div>

        </form>
    </ValidationObserver>
</template>

<script>
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import { getAvailableStock, getTotalPrice } from '../helpers';
    export default {
        name: "SalesComponent",
        components: {
            ValidationProvider,
            ValidationObserver
        },
        props: ['id'],
        data() {
            return {
                products: [],
                customers: [],
                customer: '',
                item: {
                    product: null,
                    product_id: '',
                    quantity: 1,
                    price: null,
                    discount: null,
                },
                items: [],
                existingItems: [],
                customer_id: '',
                out_of_stock: false,
                isSubmitting: false
            }
        },
        mounted() {
            this.allProducts();
            this.getSales();
        },
        methods: {
            addProduct() {
                this.items.push(this.item)
                this.resetItem();
            },
            resetItem() {
                this.item = {
                    product: null,
                    product_id: null,
                    quantity: null,
                    price: null
                }
            },
            removeItem(id) {
                const index = this.items.findIndex(x => x.product_id === id)
                if(index !== -1) {
                    this.items.splice(index, 1);
                }
            },
            editItem(id) {
                this.item = this.items.find(x => x.product_id === id)
            },
            allProducts() {
                axios.get('/admin/load-relations').then((response) => {
                    this.products = response.data.products
                    this.customers = response.data.customers
                });
            },
            getAvailableStock,
            getTotalPrice,
            getProduct() {
                const product = this.products.find(x => x.id === this.item.product_id)
                this.out_of_stock = this.getAvailableStock(product, this.item, this.existingItems)
                this.item.product = product.name
                this.item.price = product.trade_price;
                this.item.total = (Number(this.item.price) * Number(this.item.quantity)) - Number(this.item.discount)
            },
            getCustomer() {
                this.customer = this.customers.find(x => x.id === this.customer_id).name
            },
            addItem() {
                let item = this.items.find(x => x.product_id === this.item.product_id)
                if (item) {
                    item.quantity = this.item.quantity;
                    item.price = this.item.price;
                    item.discount = this.item.discount;
                    item.total = Number(item.quantity) * Number(item.price) - Number(item.discount)
                } else {
                    item = {
                        product: this.item.product,
                        product_id: this.item.product_id,
                        price: this.item.price,
                        quantity: this.item.quantity,
                        discount: this.item.discount,
                        total: (Number(this.item.quantity) * Number(this.item.price)) - Number(this.item.discount)
                    }
                    this.items.push(item)
                }
            },
            getTotal() {
               return this.getTotalPrice(this.items)
            },
            getSales(){
                if(this.id !== 0) {
                    axios.get('/admin/sales/' + this.id + '/get')
                    .then((response) => {
                        if(response.data.status) {
                            this.customer_id = response.data.data.customer_id;
                            this.customer = response.data.data.customer_name;
                            this.items = [];
                            response.data.data.sale_products.forEach(item => {
                                this.items.push({
                                    id: item.id,
                                    product_id: item.product_id,
                                    product: item.product.name,
                                    price: item.price,
                                    quantity: item.quantity,
                                    discount: item.discount,
                                    total: item.total_price
                                })
                            })
                            this.existingItems = this.items
                        }
                    })

                }
            },
            async submit() {
                try {
                    this.$refs.form.validate().then((success) => {
                        if (!success) {
                            return
                        }
                        this.isSubmitting = true;

                        const params = {
                            customer_id: this.customer_id,
                            id: this.id,
                            items: this.items
                        }
                        let url = '/admin/sales/create';
                        if(this.id && this.id !== 0) {
                            url = '/admin/sales/edit/' + this.id;
                        }
                        axios
                            .post(url, params)
                            .then((res) => {
                                this.isSubmitting = false;
                                if (res.data.status) {
                                    this.$swal({
                                        title: 'Success',
                                        text: res.data.message,
                                        type: 'success'
                                    }).then(() => {
                                        window.location.href = '/admin/sales'
                                    });
                                } else {
                                    this.$swal({
                                        title: 'Error',
                                        text: res.data.message,
                                        type: 'error'
                                    });
                                }

                            })
                            .catch((err) => {
                                console.log('err', err)
                                toastr.error("Something went wrong");
                            })
                    })
                } catch (error) {
                }
            }

        }
    }
</script>

<style scoped>

</style>
