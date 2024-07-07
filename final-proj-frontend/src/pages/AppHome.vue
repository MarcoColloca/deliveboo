<script>
    import axios from 'axios';
    import BentoBox from '../components/single-components/general/BentoBox.vue';
    import AppAdvancedSearch from './AppAdvancedSearch.vue';
    import { store } from '../store';

    export default {        
        components:{
            BentoBox,
            AppAdvancedSearch
        },

        props:{
            slug: String,
        },

        data(){
            return {
                store,
                types: [],                
                currentPage: 1,
                perPage: 10,
            }
        },

        created(){
            this.fetchTypes()
        },

        methods:{
            fetchTypes(){
                axios.get('http://127.0.0.1:8000/api/types',
                {
                    params:{
                        perPage: this.perPage,
                        currentPage: this.currentPage
                    }
                })
                .then(res => {
                    this.types = res.data.results.data
                })
            },
            enableSearch()
            {
                this.store.advancedSearchVisibility = true;
            },
            storeSlug(givenSlug)
            {
                this.store.storedSlug = givenSlug;
            }
        }
    }
</script>



<template>
    <section>
        <div class="hero">

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
        <div class="container container-btn" v-if="!this.store.advancedSearchVisibility">
            
            <ul class="row g-2 food-types__container">
                <li v-for="type in types" class="btn btn-outline-blue col-6 col-md-2">
                    <RouterLink :to="{name: 'homeSearch', params: { slug:type.slug }}" @click="enableSearch(), storeSlug(type.slug)" class="type-link" >{{ type.name }}</RouterLink> 
                </li>
            </ul>
            
        </div>
        <div v-else>
            <AppAdvancedSearch
             :slug="slug"
            ></AppAdvancedSearch>
        </div>

    </section>
</template>


<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;
   
    .hero{
        background-image: url(/imgs/sfondo.png);
        background-size: cover;
        // height:700px;
    }

    .container-btn{
       padding-top: 100px;
       .type-link{
        display:inline-block;
        width: 100%;
        height: 100%;
       }
    }
    
    .logo-big{
       width:75%;
    }

    .title-container{
        min-height:450px;
        text-align: center;
        color: $app-brand-blue;
     
        // .title{
        //     font-size: 10vw;
        // }
      
    }

    .food-types__container{
        display: flex;  
        gap: 10px;
        justify-content: center;
        margin: 10px 0; 
        .btn{
            margin: 0;
        }
    }
</style>