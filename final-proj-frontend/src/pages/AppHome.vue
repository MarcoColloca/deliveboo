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
        <div class="title-container">            
            <h1>Benvenuto in Fooder!</h1>
    
            <p>Piccola Descrizione di cos'è Fooder.</p>
        </div>
        <div class="container">
            
            <ul class="food-types__container">
                <li v-for="type in types" class="btn btn-outline-coral">
                    <RouterLink :to="{name: 'type', params: { slug:type.slug }}">{{ type.name }}</RouterLink> 
                </li>
            </ul>
            
        </div>

    </section>
</template>


<style lang="scss" scoped>

    .title-container{
        height: 300px;
        text-align: center;
        background-color: beige;
        color: black;
        padding: 30px 0;
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