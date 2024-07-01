<script>
    import axios from 'axios';

    export default {
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
                axios.get('http://127.0.0.1:8000/api/types',{

                    perPage: this.perPage,
                    currentPage: this.currentPage

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
            <h1>Benvenuto in FoodLan!</h1>
    
            <p>Piccola Descrizione di cos'è FoodLan.</p>
        </div>
        <div class="container">
            <div class="food-types__container">
                <ul>
                    <li v-for="type in types">
                        {{ type.name }}
                    </li>
                </ul>
            </div>
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
</style>