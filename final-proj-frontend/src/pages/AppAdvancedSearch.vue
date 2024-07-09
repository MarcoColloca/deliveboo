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

        if (this.store.advancedSearchVisibility && this.store.storedSlug !== '') {
            this.addSlugToSelectedTypes(this.store.storedSlug)
        }

        if (this.slug) {
            this.addSlugToSelectedTypes(this.slug);
        }

        if (!this.slug) {
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
    <div class="search-container d-flex flex-column">
       
        <div class="my-container my-4">

            <div
                class="scrollmenu">
                <div v-for="type in types" :key="type.slug" class="col type-col">
                    <div class="type-card">
                        <img :src="`/imgs/${type.slug}.png`" class="type-img" alt="">
                        <p @click="toggleTypeSelection(type.slug)"
                        :class="{ selected: selectedTypeSlugs.includes(type.slug) }">
                        {{ type.name }}
                    </p>
                    </div>
                </div>
            </div>

        </div>



      
      
        <div class="content mt-3">

            <div class="container">
                <div v-if="companies.length !== 0"
                    class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 company-row">
                    <div class="col my-col" v-for="company in companies" :key="company.id">
                        <div class="company-card">
                            <div class="company-link-card">
                                <RouterLink :to="{ name: 'menu', params: { slug: company.slug } }" class="company-link">
                                    Vai al menù
                                </RouterLink>
                            </div>
                            <div class="img-company">
                                <img v-if="company.image_fullpath" :src="company.image_fullpath" alt="">

                                <img v-else src="http://127.0.0.1:8000/storage/image/default-company.jpg" alt="">
                                <div class="company-text d-flex h-100 flex-column py-4 justify-content-between">
                                    <ul class="d-flex flex-wrap px-1 mb-0 justify-content-start">
                                        <li class="company-type bg-warning rounded-2 px-1 mb-2 mx-1"
                                            v-for="type in company.types" :key="type.id">{{ type.name }}</li>
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
                    <Cart :company="this.store.cartCompany" :cartDishes="this.store.cartDishes"
                        @remove="removeDishFromCart" @increase="increaseQty" @decrease="decreaseQty" class="card-cart">
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
    background-image: url(/imgs/sfondo-down.png);
    background-size: cover;
    margin-top: 30px;

    .sidebar {
        width: 150px;
        flex-shrink: 0;
        background-color: transparent;
        text-align: center;
        padding-top: 30px;
        margin-left: 30px;

        ul {
            padding: 0;

            li {
                // display: flex;
                width: 120px;
                flex-shrink: 0;
                // justify-content: center;

                p {
                    display: block;
                    width: 100%;
                    border-radius: 10px;
                    cursor: pointer;
                    color: white;
                    padding: 6px 0;
                    border-radius: 15px;
                    background-color: $app-brand-blue;
                }

                p.selected {
                    font-weight: bold;
                    color: $app-brand-blue;
                    background-color: $app-brand-yellow;
                    border: 1px solid white;
                    border-radius: 15px;
                    padding: 6px 0;
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
        background-color: $app-brand-yellow;
        padding-top:30px;
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

    .card-cart {
        position: fixed;
        top:50%;
        transform: translate(0, -50%);
        right:80px;
    }
}

.type-col {
    width: 210px;
    display:inline-block;

    .type-card {
        background-color: white;
        width: 189px;
        height: 160px;
        position: relative;
        //    border:1px solid grey;
        box-shadow: 0 0 0.5rem grey;
        //    border-radius: 15px 22px 22px;
        border-radius: 15px 32px 15px;
        margin-bottom: 6px;
        

        .type-img {
            width: 100%;
            position: absolute;
            border-radius: 15px 32px 0 2px;
        }

        .type-link {
            width: 100%;
            height: 100%;
            color: #18475D;
            position: absolute;
            display: flex;
            flex-direction: column-reverse;
            padding-bottom: 10px;
            padding-left: 10px;
            
        }
        p {
                    display: flex;
                    width: 100%;
                    height: 100%;
                    position: absolute;
                    width: 100%;
                    flex-direction: column-reverse;
                    cursor: pointer;
                    color: #18475D;
                    padding-bottom: 10px;
                    padding-left: 10px;
                  
                   
                }

                p.selected {
                    font-weight: bold;
                    color: $app-brand-red;
                    border-radius: 15px 32px 15px;
                   border:8px solid $app-brand-red;
                   
                }

        &:hover {
            width: 196px;
            height: 166px;
            margin-bottom: 0;
            transition: 250ms;
           
        }
    }
}
::-webkit-scrollbar {
    height: 10px;
    border-radius: 50%;
}
::-webkit-scrollbar-track {
    background: transparent;
}
::-webkit-scrollbar-thumb {
    background: $app-brand-blue;
    border-radius:10px;
}
::-webkit-scrollbar-thumb:hover {
    background: #076c9b;
}
.my-container{
    width:90%;
    margin: auto;
}
.scrollmenu{
    overflow: auto;
    white-space: nowrap;
}
</style>
