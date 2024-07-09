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
            if (this.store.cartCompany === null) {
                this.store.cartCompany = this.store.currentCompany

                const newItem = {
                    ...item,
                    qty: 1
                }
                this.store.cartDishes.push(newItem)
            }
            // Se sono nella pagina della compagnia del carrello, aggiungo l'item
            else if (this.store.currentCompany.id === this.store.cartCompany.id) {
                const newItem = {
                    ...item,
                    qty: 1
                }
                this.store.cartDishes.push(newItem);
            }
            // Se il carrello contiene piatti di un'altra compagnia, faccio altro.
            else {
                this.store.showClearCart = true;
            }
        },

        newPurchase() {
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
    <section class="menu-box">

        <div class="menu-page">
            <div class="company-name-container">
                <img class="company-hero" :src="company.image_fullpath" alt="">
                <h1 class="menu-title">{{ company.name }}</h1>
                <ul class="d-flex flex-wrap type-list">
                    <li class="sub-title" v-for="type in company.types">
                        <h3>{{ type.name }}</h3>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <div class="container my-5">
                    <div
                        class="row row-gap-3">
                        <div class="col-12 px-4" v-for="dish in dishes" :key="dish.id">
                            <div class="dish-card row g-0 row-cols-1 row-cols-sm-2" v-if="dish.visible === 1">

                                <div class="dish-img col">
                                    <img v-if="dish.image_fullpath" :src="dish.image_fullpath" class="my-dish-img"
                                        alt="">
                                    <img v-else src="http://127.0.0.1:8000/storage/image/default-image.jpg"
                                        class="my-dish-img" alt="">
                                </div>

                                <div class="card-dish-body">
                                    <h3 class="text-center">{{ dish.name }}</h3>
                                    <p class="m-0 text-start">Ingredienti:<br>{{ dish.ingredients }}</p>
                                    <p class="m-0 text-start">Descrizione:<br>{{ dish.description ? dish.description :
                                        '' }}</p>
                                    <h4 class="m-0 text-danger">Prezzo:{{ dish.price }} €</h4>
                                    <h5 class="btn dish-btn btn-outline-coral" v-if="isVisible(dish.id)"
                                        @click="increaseQty(dish.id)">
                                        aumenta quantità</h5>
                                    <h5 class="btn dish-btn btn-outline-blue cart-link" v-else
                                        @click="addDishToCart(dish)">Aggiungi al
                                        carrello
                                    </h5>
                                </div>

                            </div>
                            <div class="dish-card row g-0 row-cols-1 row-cols-sm-2" v-else>

                                <div class="dish-img col">
                                    <img v-if="dish.image_fullpath" :src="dish.image_fullpath" class="my-dish-img"
                                        alt="">
                                    <img v-else src="http://127.0.0.1:8000/storage/image/default-image.jpg"
                                        class="my-dish-img" alt="">

                                </div>
                                <div class="card-dish-body">
                                    <h3 class="text-center">{{ dish.name }}</h3>
                                    <p class="m-0 text-start">Ingredienti:{{ dish.ingredients }}</p>
                                    <p class="m-0 text-start">Descrizione:{{ dish.description ? dish.description :
                                        '' }}</p>
                                    <h4 class="m-0 text-danger">Prezzo:{{ dish.price }} €</h4>
                                    <h5 class="btn dish-btn btn-outline-danger not-available">Piatto non disponibile
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar">
                        <Cart class="card-cart" :company="this.store.cartCompany" :cartDishes="this.store.cartDishes"
                            @remove="removeDishFromCart" @increase="increaseQty" @decrease="decreaseQty"
                            @newPurchase="newPurchase">
                        </Cart>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>




<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;

.company-name-container {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 250px;
    width: 100%;
    box-shadow: 0 13px 25px grey;

    .company-hero {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .type-list {
        position: absolute;
        top: 50%;
        text-shadow: 1px 4px 2px black;

        .sub-title {
            margin: 0 10px;
        }
    }

    .menu-title {
        position: absolute;
        top: 30px;
        text-shadow: 1px 4px 2px black
    }

}

.menu-page {
    text-align: center;
    position: relative;

    .not-available {
        pointer-events: none;
        cursor: default;
    }

    .container {
        margin-top: 15px;

        .dish-card {
            background-color: white;
            // width: 310px;
            // height: 550px;
            box-shadow: 0 0 1.75rem grey;
            border-radius: 20px;
            // margin-bottom: 6px;
            // display: flex;
            // flex-direction: column;
            // justify-content: space-between;
            margin-bottom: 30px;
            border: 12px solid $app-brand-yellow;

            // &:hover {
            //     width: 320px;
            //     height: 560px;
            //     margin-bottom: 0;
            // }

            .dish-img {
                // width: 100%;
                // height: 40%;
                // flex-shrink: 0;
                // border-radius: 15px 32px 0 2px;

                .my-dish-img {
                    height: 100%;
                    width: 100%;
                    object-fit: cover;
                    object-position: center;
                    border-radius: 10px;

                }
            }

            .cart-link {
                width: 100%;
                justify-self: flex-end;

            }

            .card-dish-body {
                height: 60%;
                padding: 10px;
                display:flex;
                flex-direction: column;
                justify-content: space-between;
                justify-content: space-between;
                color: $app-brand-blue;

                h3,
                p {
                    pointer-events: none;
                }

                h4 {
                    pointer-events: none;
                    cursor: default;
                }

            }

            .dish-btn {
                width: 150px;
                align-self: center;
                padding: 0 10px;
                margin: 10px;
            }

        }
    }

    // .row {
    //     width: 70%;
    // }

    .sidebar {
        // margin-left: 12px;
   
        
    }
}

// MEDIA QUERY

@media (min-width: 576px) {

    .menu-page {
        .container {
            display: block;
        }
    }
    .row {
        width: 100%;
        display: flex;
        margin: auto;
    }
    .row-cols-sm-2 .col{
        width: 45%;
    }
    .sidebar{
        // margin: auto;
    }
}

@media (min-width: 768px) {

    .menu-page {
        .container {
            display: flex;
        }
    }
    .row {
        width: 70%;
    }
    .sidebar {
        width: 30%;
        

        .card-cart {
            
            position: sticky;
            top: 30%;
            
        }
    }
    
}

@media (min-width: 992px) {
    .row {
        width: 70%;
        
    }
    .sidebar {
        width: 30%;

        .card-cart {
            
            position: sticky;
            top: 30%;
            
        }
    }
    
} 

</style>
