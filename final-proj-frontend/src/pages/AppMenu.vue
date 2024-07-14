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
            this.store.newItemIntoCart = item;
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
                this.store.showCart = true;
                this.store.clearCartMessage = `Stai acquistando dalla compagnia "${this.store.cartCompany.name}". Non puoi aggiungere piatti da questa compagnia. Vuoi svuotare il carrello e comprare da un\'altra compagnia?`;
            }
        },

        newPurchase() {
            if(this.store.clearAllCart === true){
                this.store.cartCompany = null;
                this.store.cartDishes = [];
                this.store.showClearCart = false;
                this.store.clearAllCart = false;
            }else{
                this.store.cartCompany = null;
                this.store.cartDishes = [];
                this.store.showClearCart = false;
                this.addDishToCart(this.store.newItemIntoCart);
            }
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
            <div class="company-name-container bg-warning">
               
                    <img class="company-hero" v-if="company.image_fullpath" :src="company.image_fullpath" alt="">
               
                
                    <img v-else src="http://127.0.0.1:8000/storage/image/default-company.png" class="h-100" alt="">
               
                <h1 class="menu-title">{{ company.name }}</h1>
                <ul class="d-flex flex-wrap type-list">
                    <li class="sub-title" v-for="type in company.types">
                        <h3>{{ type.name }}</h3>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <div class="container my-5">
                    <div class="row row-container row-gap-3">
                        <div class="col-12 px-2" v-for="dish in dishes" :key="dish.id">
                            <div class="dish-card">
                                <div class="row g-0">
                                    <div class="col-12 col-lg-6 col-img">
                                        <div class="dish-img">
                                            <img v-if="dish.image_fullpath" :src="dish.image_fullpath"
                                                class="my-dish-img" alt="">
                                            <img v-else src="http://127.0.0.1:8000/storage/image/default-image.png"
                                                class="default-img" alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">

                                        <div class="card-dish-body">
                                            <h3 class="dish-name">{{ dish.name }}</h3>
                                            <p class="dish-specs m-0" v-if="dish.ingredients != ''">
                                                Ingredienti: {{
                                                    dish.ingredients }}</p>
                                            <p class="dish-specs m-0 pb-2" v-if="dish.description != ''">
                                                Descrizione: {{
                                                    dish.description }}</p>
                                            <h4 class="dish-price m-0">{{ dish.price }} €</h4>

                                            <span v-if="dish.visible === 1">                                         
                                                <h5  class="btn dish-btn btn-outline-yellow" v-if="isVisible(dish.id)" @click="increaseQty(dish.id)">
                                                    Aggiungine un altro
                                                </h5>
                                                <h5  class="btn dish-btn btn-outline-blue" v-else @click="addDishToCart(dish)">
                                                    Aggiungi al carrello
                                                </h5>
                                            </span>
                                            <span v-else>
                                                <h5  class="btn dish-btn not-available btn-outline-danger">
                                                    Piatto non Disponibile
                                                </h5>
                                            </span>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="sidebar d-none d-lg-block">
                        <Cart class="card-cart" :company="this.store.cartCompany" :cartDishes="this.store.cartDishes"
                            @remove="removeDishFromCart" @increase="increaseQty" @decrease="decreaseQty"
                            @newPurchase="newPurchase">
                        </Cart>
                    </div>
                    <div class="cart-end d-lg-none">
                        <Cart class="card-cart" :company="this.store.cartCompany" :cartDishes="this.store.cartDishes"
                            @remove="removeDishFromCart" @increase="increaseQty" @decrease="decreaseQty"
                            @newPurchase="newPurchase">
                        </Cart>
                    </div>
                    <div class="container cart-container">

                        <!-- Bottone per il carrello -->
                        <div class="toggle-cart-float">
                            <ToggleCart :cartDishes="this.store.cartDishes"></ToggleCart>
                        </div>
                        <div v-show="store.showCart">
                            <Cart :company="this.store.cartCompany" :cartDishes="this.store.cartDishes"
                                @remove="removeDishFromCart" @increase="increaseQty" @decrease="decreaseQty"
                                @newPurchase="newPurchase"
                                class="card-cart-float">
                            </Cart>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </section>

</template>




<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;

.menu-box {
    background-image: url(/imgs/sfondo-down.png);
    background-size: cover;

}

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

        .row-container {
            margin-right: 50px;
            margin-left: 5px;
        }

        .dish-card {
            background-color: white;
            width: 100%;
            box-shadow: 0 0 1.75rem grey;
            border-radius: 20px;
            justify-content: space-between;
            margin-bottom: 30px;
            border: 12px solid $app-brand-yellow;

            .dish-img {
                height: 100%;
                height: 100%;

                .my-dish-img {
                    height: 100%;
                    width: 100%;
                    object-fit: cover;
                    object-position: center;
                    border-radius: 10px;

                }
                .default-img{
                    height: 100%;
                    object-fit:cover;
                }

            }

            .cart-link {
                width: 100%;
                justify-self: flex-end;

            }

            .card-dish-body {
                height: 60%;
                // padding: 10px 30px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                color: $app-brand-blue;
                height: 100%;
                height: 100%;

                .dish-name,
                .dish-specs {
                    pointer-events: none;
                }

                .dish-name {
                    font-size: 30px;
                }

                .dish-specs {
                    font-size: 16px;

                }

                .dish-price {
                    pointer-events: none;
                    cursor: default;
                    font-size: 30px;
                    color: $app-brand-red;
                }

            }

            .dish-btn {
                // width: 200px;
                align-self: center;
                padding: 6px;
                margin: 10px 0;
                &.not-available{
                    pointer-events: none;
                }
            }

        }


    }

    .card-cart-float {
        position: fixed;
        top: 50%;
        transform: translate(0, -50%);
        right: 60px;
        margin-left: 10px;
        border: 12px solid $app-brand-blue;
        border-radius: 20px;
    }

    .card-cart {
        display: block;
        background-color: white;
        width: 100%;
        box-shadow: 0 0 1.75rem grey;
        border-radius: 20px;
        justify-content: space-between;
        margin-bottom: 30px;
        border: 12px solid $app-brand-blue;
    }

}

// MEDIA QUERY

@media (min-width: 576px) {

    .menu-page {

        .container {
            margin: 0;
            max-width: 100%;
        }
    }

    .col-img {
        max-height: 370px;
    }

    .cart-container {

        .card-cart-float {
            right: 100px;
        }
    }

    .col-img {
        max-height: 370px;
    }

}

@media (min-width: 768px) {
    .menu-page {

        .container {

            .row-container {
                margin-right: 100px;

                .card-dish-body {

                    .dish-name {

                        font-size: 36px;
                    }

                    .dish-specs {

                        font-size: 14px;
                    }

                    .dish-price {

                        font-size: 26px;

                    }
                }
            }
        }
    }
}


@media (min-width: 992px) {

    .menu-page {

        .container {

            display: flex;
            margin: auto;
            max-width: 960px;

            .row-container {
                margin-right: 20px;

            }
        }
    }

    .dish-card {

        .row {
            height: 370px;
        }

        [class^="col"] {
            height: 100%;
        }

    }

    .card-dish-body {

        .dish-name {

            font-size: 60px;
        }

        .dish-specs {

            font-size: 14px;
        }

        .dish-price {

            font-size: 26px;

        }
    }


    .row {
        width: 100%;
        display: flex;
        margin: auto;
    }

    .card-cart-float {
        display: none;
    }

    .toggle-cart-float {
        display: none;
    }

    .menu-page {

        .sidebar {
            display: block;
            width: 50%;

            .card-cart {
                position: sticky;
                top: 12px;
                transform: translate(0, 0);

            }
        }
    }

}

@media (min-width: 1200px) {
    .menu-page {

        .container {
            max-width: 1140px;  
        .card-dish-body{
            padding: 10px 30px;
        }

        }
    }
}
</style>
