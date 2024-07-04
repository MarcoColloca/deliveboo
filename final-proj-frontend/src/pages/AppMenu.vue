<script>
import axios from 'axios';
import Cart from '../components/single-components/general/Cart.vue'

export default {
    components: {
        Cart,
    },
    props: {
        slug: {
            type: String,
            required: true
        }
    },
    computed: {
        companySlug() {
            return this.slug;
        }
    },
    data() {
        return {
            dishes: [],
            company: {},
            cartDishes: []
        };
    },
    created() {
        this.fetchDishes(this.slug);
    },
    methods: {
        fetchDishes(slug) {
            axios.get(`http://127.0.0.1:8000/api/companies/${slug}`)
                .then(res => {

                    this.dishes = res.data.results.dishes;
                    this.company = res.data.results;
                    console.log(res);
                })
                .catch(error => {
                    this.$router.replace({
                        name: 'NotFound',
                        params: { patchMatch: this.$route.path.substring(1).split('/') },
                    });
                });
        },

        addDishToCart(item) {
            const newItem = {
                ...item,
                qty: 1
            }
            this.cartDishes.push(newItem)
        },

        isVisible(id) {
            let visible = false

            this.cartDishes.forEach(element => {
                if (element.id == id) {
                    visible = true
                }
            });

            return visible
        },

        removeDishFromCart(index) {
            // console.log(id)
            
            this.cartDishes.splice(index,1)
            

        }
    },
}
</script>




<template>
    <div class="menu-page">
        <h1>{{ company.name }}</h1>
        <ul class="d-flex gap-5">
            <li v-for="type in company.types">{{ type.name }}</li>
        </ul>
        <div class="container my-5">
            <div class="row row-gap-5">
                <div class="col-3" v-for="dish in dishes" :key="dish.id">
                    <div class="card" v-if="dish.visible === 1">
                        <div class="card-header">
                            <div class="card-top-img">
                                <img v-if="dish.image_fullpath" :src="dish.image_fullpath" alt="">
                                <img v-else src="http://127.0.0.1:8000/storage/image/default-image.jpg" alt="">
                            </div>
                        </div>
                        <div class="card-body">
                            <p><strong>Nome:</strong> {{ dish.name }}</p>
                            <p><strong>Ingredienti:</strong> {{ dish.ingredients }}</p>
                            <p><strong>Descrizione:</strong> {{ dish.description ? dish.description : 'Nessuna Descrizione per questo piatto.' }}</p>
                            <p><strong>Prezzo:</strong> {{ dish.price }} €</p>
                            <h5 class="btn btn-outline-coral" v-if="isVisible(dish.id)" @click="console.log('click')">aumenta quantità</h5>
                            <h5 class="btn btn-outline-coral" v-else @click="addDishToCart(dish)">Aggiungi al carrello</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <Cart
                     :company="this.company"
                     :cartDishes="this.cartDishes"
                     @remove="removeDishFromCart"
                    ></Cart>
                </div>
            </div>
        </div>
    </div>

</template>





<style lang="scss" scoped>
.menu-page {
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 30px 0;

    .container {
        margin-top: 15px;

        .row {
            .card {
                margin-bottom: 20px;

                .card-header {
                    .card-top-img {
                        img {
                            max-width: 100%;
                            height: 200px;
                        }
                    }
                }
            }
        }
    }
}
</style>
