<script>
import axios from 'axios';
import Cart from '../components/single-components/general/Cart.vue';
import { store } from '../store';
import ToggleCart from '../components/single-components/general/ToggleCart.vue';

export default {
    components: {
        Cart,
        ToggleCart,
    },

    props: {
        slug: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            store,
            dishes: [],
            company: {},
           
        };
    },

    computed: {
        companySlug() {
            return this.slug;
        }
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
                    this.store.currentCompany = this.company;
                })
                .catch(error => {
                    this.$router.replace({
                        name: 'NotFound',
                        params: { patchMatch: this.$route.path.substring(1).split('/') },
                    });
                });
        },

        addDishToCart(item) {            
            // Se il carrello è vuoto aggiunto l'item al carrello ed aggiorno la compagnia
            if(this.store.cartCompany === null)
            {
                this.store.cartCompany = this.store.currentCompany

                const newItem = {
                    ...item,
                    qty: 1
                }
                this.store.cartDishes.push(newItem)
            }
            // Se sono nella pagina della compagnia del carrello, aggiungo l'item
            else if(this.store.currentCompany.id === this.store.cartCompany.id)
            {
                const newItem = {
                    ...item,
                    qty: 1
                }
                this.store.cartDishes.push(newItem);
            }
            // Se il carrello contiene piatti di un'altra compagnia, faccio altro.
            else
            {
                this.store.showClearCart = true;
            }
        },

        newPurchase()
        {
            this.store.cartCompany = null;
            this.store.cartDishes = [];
            this.store.showClearCart = false;
        },

        isVisible(id) {
            let visible = false

            this.store.cartDishes.forEach(element => {
                if (element.id == id) {
                    visible = true
                }
            });

            return visible
        },

        removeDishFromCart(index) {
            this.store.cartDishes.splice(index, 1)
        },

        increaseQty(id) {

            this.store.cartDishes.forEach(element => {
                if (element.id == id) {
                    element.qty++
                }
            });
        },

        decreaseQty(id) {
            this.store.cartDishes.forEach(element => {
                if (element.id == id && element.qty > 1) {
                    element.qty--
                }
            });

        },
    }
}
</script>




<template>
    <div class="menu-page">
        <h1 class="title">{{ company.name }}</h1>
        <ul class="d-flex gap-5">
            <li class="sub-title" v-for="type in company.types">{{ type.name }}</li>
        </ul>
        <div class="d-flex">
            <div class="container my-5">
                <div class="row row-gap-5">
                    <div class="col-4" v-for="dish in dishes" :key="dish.id">
                        <div class="card h-100" v-if="dish.visible === 1">
                            <div class="card-header">
                                <div class="card-top-img">
                                    <img v-if="dish.image_fullpath" :src="dish.image_fullpath" class="my-img-card"
                                        alt="">
                                    <img v-else src="http://127.0.0.1:8000/storage/image/default-image.jpg"
                                        class="my-img-card" alt="">
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <p><span class="fw-bold">Nome:</span> {{ dish.name }}</p>
                                <p><span class="fw-bold">Ingredienti:</span> {{ dish.ingredients }}</p>
                                <p><span class="fw-bold">Descrizione:</span> {{ dish.description ? dish.description : 'Nessuna Descrizione per questo piatto.' }}</p>
                                <p><span class="fw-bold">Prezzo:</span> {{ dish.price }} €</p>
                                <h5 class="btn btn-outline-coral" v-if="isVisible(dish.id)"
                                    @click="increaseQty(dish.id)">
                                    aumenta quantità</h5>
                                <h5 class="btn btn-outline-coral" v-else @click="addDishToCart(dish)">Aggiungi al
                                    carrello
                                </h5>
                            </div>
                        </div>
                        <div class="card h-100" v-else>
                            <div class="card-header">
                                <div class="card-top-img">
                                    <img v-if="dish.image_fullpath" :src="dish.image_fullpath" class="my-img-card"
                                        alt="">
                                    <img v-else src="http://127.0.0.1:8000/storage/image/default-image.jpg"
                                        class="my-img-card" alt="">
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <p><span class="fw-bold">Nome:</span> {{ dish.name }}</p>
                                <p><span class="fw-bold">Ingredienti:</span> {{ dish.ingredients }}</p>
                                <p><span class="fw-bold">Descrizione:</span> {{ dish.description ? dish.description :
                                    'Nessuna Descrizione per questo piatto.' }}</p>
                                <p><span class="fw-bold">Prezzo:</span> {{ dish.price }} €</p>
                                <p class="btn btn-outline-danger not-available">Piatto non disponibile</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container cart-container">
                
                <!-- Bottone per il carrello -->
                <div>
                    <ToggleCart></ToggleCart>
                </div>
                <div v-show="store.showCart">
                    <Cart :company="this.store.cartCompany" :cartDishes="this.store.cartDishes" @remove="removeDishFromCart"
                        @increase="increaseQty" @decrease="decreaseQty" @newPurchase="newPurchase">
                    </Cart>
                </div>
            </div>
        </div>




    </div>

</template>




<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;

.menu-page {
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 30px 0;
    background-image: url(/imgs/sfondo-down.png);
    background-size: cover;

    .title {
        color: $app-brand-blue;
        margin-top: 50px;
    }

    .sub-title {
        color: $app-brand-blue;
    }

    .container {
        margin-top: 15px;

        .row {
            .card {
                margin-bottom: 20px;

                .card-header {
                    .card-top-img {
                        .my-img-card {
                            height: 180px;
                            object-fit: cover;
                        }
                    }
                }

                .card-body {
                    p {
                        font-weight: lighter;
                    }

                    .not-available {
                        pointer-events: none;
                        cursor: default;
                    }
                }
            }
        }
    }
}
</style>
