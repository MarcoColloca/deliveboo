<script>
    import axios from 'axios';
    import BentoBox from '../components/single-components/general/BentoBox.vue';

    export default {
        components:{
            BentoBox
        },

        data(){
            return {

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
            }
        }
    }
</script>



<template>
    <section>
        <div class="hero">

            <div class="container title-container">    
                <div class="row gap-4 justify-content-center">
                    <div class="col-10 col-lg-5 p-3">
                        <img src="/imgs/logo.png" class="logo-big" alt="">
                    </div>
                    <div class="col-10 col-lg-5 d-flex flex-column justify-content-center p-3">
                        <h1 class="title">Ordina tutto il cibo che vuoi da casa tua!</h1>
                   
                    </div>
                </div>        
            </div>
        </div>
        <div class="container container-btn">
            
            <ul class="row g-2 food-types__container">
                <li v-for="type in types" class="btn btn-outline-blue col-6 col-md-2">
                    <RouterLink :to="{name: 'type', params: { slug:type.slug }}">{{ type.name }}</RouterLink> 
                </li>
            </ul>
            
        </div>

    </section>
</template>


<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;
   
    .hero{
        background-image: url(/imgs/sfondo.png);
        background-size: cover;
        height:700px;
    }

    .container-btn{
       padding-top: 100px;
    }
    
    .logo-big{
        width:100%;
    }

    .title-container{
        min-height:500px;
        text-align: center;
        color: $app-brand-blue;
     
        .title{
            font-size: 70px;
        }
      
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