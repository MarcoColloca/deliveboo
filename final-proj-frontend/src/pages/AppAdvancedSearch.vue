<script>
import axios from 'axios';
import BentoBox from '../components/single-components/general/BentoBox.vue';
import { store } from '../store';
import Cart from '../components/single-components/general/Cart.vue';
import ToggleCart from '../components/single-components/general/ToggleCart.vue';


export default {
    components: {
        BentoBox,
        Cart,
        ToggleCart,
    },

    props: {
        slug: String,
    },

    data() {
        return {
            store,
            types: [],
            currentPage: 1,
            perPage: 99,
            selectedTypeSlugs: [],
            companies: [],
        }
    },

    created() {
        this.fetchTypes();

        if(this.store.advancedSearchVisibility && this.store.storedSlug !== '')
        {
            this.addSlugToSelectedTypes(this.store.storedSlug)
        }

        if (this.slug) {
            this.addSlugToSelectedTypes(this.slug);
        }
        
        if(!this.slug){
            this.fetchCompanies()
        }
    },

    watch: {
        selectedTypeSlugs() {
            this.fetchCompanies();
        }
    },

    methods: {
        addSlugToSelectedTypes(slug) {
            if (!this.selectedTypeSlugs.includes(slug)) {
                this.selectedTypeSlugs.push(slug);
                this.fetchCompanies();
            }
        },

        toggleTypeSelection(slug) {
            if (this.selectedTypeSlugs.includes(slug)) {
                this.selectedTypeSlugs = this.selectedTypeSlugs.filter(typeSlug => typeSlug !== slug);
            } else {
                this.selectedTypeSlugs.push(slug);
            }
            this.fetchCompanies();
        },

        fetchTypes() {
            axios.get('http://127.0.0.1:8000/api/types', {
                params: {
                    page: this.currentPage,
                    perPage: this.perPage,
                }
            })
                .then(res => {
                    this.types = res.data.results.data;
                });
        },

        fetchCompanies() {
            axios.post('http://127.0.0.1:8000/api/types/select', {
                typeSlugs: this.selectedTypeSlugs
            })
                .then(res => {
                    this.companies = res.data.results.companies;
                })
                .catch(error => {
                    console.error(error);
                });
        },

        // Metodi per il Carrello

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
    <div class="search-container mb-4">
        <div class="sidebar">
            <ul>
                <li v-for="type in types" :key="type.slug">
                    <p @click="toggleTypeSelection(type.slug)"
                        :class="{ selected: selectedTypeSlugs.includes(type.slug) }">
                        {{ type.name }}
                    </p>
                </li>
            </ul>
        </div>
        <div class="content">
         
            <div class="container">
                <div v-if="companies.length !== 0" class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 company-row">
                    <div class="col my-col" v-for="company in companies" :key="company.id">
                        <div class="company-card">
                            <div class="company-link-card">
                                 <RouterLink :to="{ name: 'menu', params: { slug: company.slug } }" class="company-link">
                                Vai al menù
                                </RouterLink>
                            </div>
                            <div class="img-company">
                                <img v-if="company.image_fullpath" :src="company.image_fullpath"  alt="">
                                        
                                <img v-else src="http://127.0.0.1:8000/storage/image/default-company.jpg" alt="">
                                 <div class="company-text d-flex h-100 flex-column py-4 justify-content-between">
                                     <ul class="d-flex flex-wrap px-1 mb-0 justify-content-start">
                                        <li class="company-type bg-warning rounded-2 px-1 mb-2 mx-1" v-for="type in company.types" :key="type.id">{{ type.name}}</li>
                                     </ul>
                                     <h3 class="company-name">{{ company.name }}</h3>
                                     
                                 </div>     
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <img src="/imgs/fooder.gif" class="my-gif" alt="">
                    <h2 class="sub-title">Nessuna compagnia rispetta i parametri della Ricerca</h2>
                </div>
            </div>

            <div class="container cart-container">
                
                <!-- Bottone per il carrello -->
                <div>
                    <ToggleCart></ToggleCart>
                </div>
                <div v-show="store.showCart">
                    <Cart :company="this.store.cartCompany" :cartDishes="this.store.cartDishes" @remove="removeDishFromCart"
                        @increase="increaseQty" @decrease="decreaseQty" >
                    </Cart>
                </div>
                
            </div>
        </div>
    </div>
</template>



<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;
@use '../assets/style/partials/companyCard';

.search-container {
    height: 100%;
    display: flex;

    .sidebar {
        width: 200px;
        flex-shrink: 0;
        background-color: $app-brand-blue;
        text-align: center;
        padding-top: 30px;

        ul {
            padding: 0;

            li {
                display: flex;
                width: 100%;
                justify-content: center;

                p {
                    cursor: pointer;
                    width: max-content;
                }

                p.selected {
                    font-weight: bold;
                    color: $app-brand-yellow;
                    //background-color: white;
                    border: 1px solid white;
                    border-radius: 18px;
                    padding: 0 6px;
                }
            }
        }
    }

    .title {
        color: $app-brand-blue;
        margin-top: 50px;
    }

    .sub-title {
        color: $app-brand-blue;
        margin-top: -30px;
    }

    .content {
        text-align: center;
        flex-grow: 1;
        background-color: white;
        background-image: url(/imgs/sfondo-down.png);
        background-size: cover;
        color: black;
        display: flex;

        .my-img-card {
            height: 180px;
            object-fit: cover;
        }

        .my-gif {
            width: 550px;
            transform: scaleX(-1);
        }
    }
}
</style>
