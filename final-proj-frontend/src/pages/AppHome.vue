<script>
import axios from 'axios';
import BentoBox from '../components/single-components/general/BentoBox.vue';
import AppAdvancedSearch from './AppAdvancedSearch.vue';
import { store } from '../store';

export default {
    components: {
        BentoBox,
        AppAdvancedSearch
    },

    props: {
        slug: String,
    },

    data() {
        return {
            store,
            types: [],
            currentPage: 1,
            perPage: 18,
        }
    },

    created() {
        this.fetchTypes()
    },

    methods: {
        fetchTypes() {
            axios.get('http://127.0.0.1:8000/api/types',
                {
                    params: {
                        perPage: this.perPage,
                        currentPage: this.currentPage
                    }
                })
                .then(res => {
                    this.types = res.data.results.data
                })
        },
        enableSearch() {
            this.store.advancedSearchVisibility = true;
        },
        storeSlug(givenSlug) {
            this.store.storedSlug = givenSlug;
        }
    }
}
</script>



<template>
    <section>
        <div class="hero mb-3">

            <div class="container-fluid title-container">
                <div class="row gap-1 justify-content-center align-items-center">
                    <div class="col-10 col-lg-5 mt-4 pt-4">
                        <img src="/imgs/logo.png" class="logo-big" alt="">
                    </div>
                    <div class="col-10 col-lg-5 px-3">
                        <h1 class="title">Ordina tutto il cibo che vuoi<br> da casa tua!</h1>

                    </div>
                </div>
            </div>
        </div>
        <div class="my-container" v-if="!this.store.advancedSearchVisibility">
            <div class="scroll-container py-4">

            <div class="scrollmenu mx-3">
                <div v-for="type in types" :key="type.slug" class="col type-col">
                    <div class="type-card">
                        <img :src="`/imgs/${type.slug}.png`" class="type-img" alt="">
                        <RouterLink :to="{ name: 'homeSearch', params: { slug: type.slug } }"
                            @click="enableSearch(), storeSlug(type.slug)" class="type-link">{{ type.name }}</RouterLink>
                    </div>
                </div>
            </div>
            </div>
           
            
            <div class="customer-ex mt-4">
                <div class="row row-gap-3 justify-content-center row-cols-1 row-cols-md-2 row-cols-lg-3">
                    <div class="col d-flex justify-content-center">
                        <div class="ex-card">
    
                            <img src="/imgs/choose.png" class="home-card-imgs" alt="">
                            <p class="customer-text">Scegli cosa vuoi mangiare</p>
                        </div>
                
                    </div>
                    <div class="col d-flex justify-content-center">
                        <div class="ex-card">
    
                            <img src="/imgs/pay.png" class="home-card-imgs" alt="">
                            <p class="customer-text">Completa il pagamento</p>
                        </div>
                    </div>
                    
                    <div class="col d-flex justify-content-center">
                        <div class="ex-card">
    
                            <img src="/imgs/rider.png" class="home-card-imgs" alt="">
                            <p class="customer-text">Ricevi dove vuoi<br>il tuo cibo preferito!</p>
                        </div>
                     </div>
    
                </div>
            </div>
            <div class="rider-map mt-4">
                <div class="container">

                    <div class="row row-gap-3 justify-content-center row-cols-1 row-cols-md-2">
                        <div class="col d-flex justify-content-center">
                            <div class="text-box h-100 d-flex flex-column justify-content-center">
        
                                <p class="text-white text-center fs-1 ">Segui i tuoi ordini</p>
                                <p class="text-white text-center fs-4 " >Con la nostra App puoi vedere il tuo ordine dal momento del ritiro per essere aggiornato sulla consegna.</p>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-center">
                            <div class="rider-card">
                                 <img src="/imgs/rider.gif" class="" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="became-partner">
                <div class="container">
    
                    <div class="row row-gap-3 justify-content-between row-cols-1 row-cols-md-2">
                        <div class="col">
                            <div class="partner-card px-3">
                                <img src="/imgs/partner.png" class="home-card-imgs" alt="">
                            </div>
                            
                        </div>
                        <div class="col">
                            <div class="text-box px-3 h-100 d-flex flex-column align-items-between justify-content-around">
                                <h3 class="customer-text">Diventa partner <br>di Fooder</h3>
                                <p class="customer-sub-text">Diventa nostro partner e cresci con Fooder! <br> Grazie alla nostra applicazione raggiungi più clienti e gestiamo noi la consegna, così puoi dedicarti solo alla cura dei tuoi piatti. </p>
                               <p class="text-center mt-3">
        
                                   <a class="btn-partner mt-2" href="http://127.0.0.1:8000/register">Diventa Partner</a>
                               </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div v-else>
            <AppAdvancedSearch :slug="slug"></AppAdvancedSearch>
        </div>
       

       

    </section>
</template>


<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;


.scroll-container{
    width: 95%;
    margin: 50px auto;
}
.hero {
    background-image: url(/imgs/sfondo.png);
    background-size: cover;

}
.became-partner{
    padding: 50px;
    background-color: $app-brand-yellow;
}
.customer-sub-text{
    font-size:22px;
    text-align: center;
    color: $app-brand-blue;
    justify-self: flex-end;
}
.customer-text{
        margin-top: 20px;
        color: $app-brand-blue;
        text-align: center;
        font-size:32px;
    }
    .rider-map{
     width:100%;
    background-color: $app-brand-blue;
    padding: 30px 15px;
   
  
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    .rider-col{
        width: 100%;
        display: flex;
        justify-content: center;
       
    }
    }
    .home-card-imgs{
        width:100%;
        border-radius:15px;
        box-shadow: 0 1px 10px rgb(94, 53, 0)
    }
.customer-ex{
    width:90%;
    margin:auto;
    padding: 30px 15px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    height: 100%;
    background-color: $app-brand-yellow;
    -webkit-backdrop-filter: blur(5px);
    backdrop-filter: blur(5px);

    .ex-card{
        width:90%;
        display:flex;
        flex-direction:column;
        align-items: center;
        justify-content: space-between;
        
    }
}
.btn-partner {
        margin-top:50px;
        color: $app-brand-yellow;
        background-color: $app-brand-blue;
        padding: 10px 20px;
        width:200px;
        border-radius: 10px;
        border: 3px solid $app-brand-blue;
        box-shadow:1px 1px 4px $app-brand-blue;
        &:hover {
            cursor: pointer;
            color: $app-brand-blue;
            background-color: $app-brand-yellow;
            padding: 10px 20px;
            border-radius: 10px;
            // border: 3px solid $app-brand-yellow;
        }
        &:active{
            background-color: #123647;
        }
    }
ul {
    height: 250px;
    align-items: center;
}
.my-container{
    width:100%;
    margin-top:50px;
   
}
.scrollmenu{
    overflow: auto;
    white-space: nowrap;
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
        margin-bottom: 20px;

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

        &:hover {
            width: 196px;
            height: 166px;
            margin-bottom: 0;
            transition: 250ms;
        }
    }
}

.logo-big {
    width: 75%;
}

.title-container {
    min-height: 450px;
    text-align: center;
    color: $app-brand-blue;

    // .title{
    //     font-size: 10vw;
    // }

}

.food-types__container {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin: 10px 0;

    .btn {
        margin: 0;
    }
}
// .rider-box{
//  background-color: white;
//  width: 90%;
// //  padding: 20px;
//  border-radius: 24px;
//  box-shadow: 0 0 1.5rem black;
// }
.partner-card{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
}
.rider-card{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    background-color: white;
    border-radius: 22px;
    box-shadow: 0 0 1.5rem black;
    width: 90%;
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

</style>