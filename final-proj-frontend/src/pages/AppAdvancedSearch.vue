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
                perPage: 99,
                typeSlug: '',
            }
        },

        created(){
            this.fetchTypes()
        },

        methods:{
            changeType(slug){
                this.typeSlug = slug;
                console.log(this.typeSlug)
            },

            fetchTypes(){
                axios.get('http://127.0.0.1:8000/api/types',
                {
                    params:{
                        page: this.currentPage,
                        perPage: this.perPage,
                    }
                })
                .then(res => {
                    this.types = res.data.results.data
                })
            },

            fetchType(){
                axios.get(`http://127.0.0.1:8000/api/types/${this.typeSlug}`)
                .then(res => {

                })
            }
        }
    }
</script>


<template>
    <div class="search-container">
        <div class="sidebar">
            <ul>
                <li v-for="type in types">
                    <p @click="changeType(type.slug)">{{ type.name }}</p>
                </li>
            </ul>
        </div>
        <div class="content">

            <h1>Ricerca Avanzata</h1>
        </div>
    </div>
</template>



<style lang="scss" scoped>

    .search-container{
        height: 100%;
        display: flex;
        .sidebar{
            width: 300px;
            flex-shrink: 0;
            background-color: rgb(168, 194, 185);
            text-align: center;
            padding-top: 30px;
            ul{
                padding: 0;
                li{
                    display: flex;
                    width: 100%;
                    justify-content: center;
                    p{
                        cursor: pointer;
                        width: max-content;
                    }
                }
            }
        }
        .content{
            text-align: center;
            flex-grow: 1;
            background-color: rgb(184, 196, 206);
            color: black;
        }
    }

</style>