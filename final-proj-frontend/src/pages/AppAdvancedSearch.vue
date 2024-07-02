<script>
    import axios from 'axios';
    import BentoBox from '../components/single-components/general/BentoBox.vue';

    export default {
        components:{
            BentoBox
        },

        props:{
            slug: String
        },

        data(){
            return {

                types: [],                
                currentPage: 1,
                perPage: 99,
                typeSlug: this.slug,


                companies: [],
            }
        },

        created(){
            this.fetchTypes()

            
        },

        methods:{
            changeType(mySlug){
                this.typeSlug = mySlug;
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

            fetchCompanies(){
                axios.get(`http://127.0.0.1:8000/api/types/${this.typeSlug}`)
                .then(res => {
                    console.log(res.data.results.companies)

                    this.companies = res.data.results.companies
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
                    <p @click="changeType(type.slug), this.fetchCompanies()">{{ type.name }}</p>
                </li>
            </ul>
        </div>
        <div class="content">
            <div class="container">
                <h1>Ricerca Avanzata</h1>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-3" v-for="company in companies">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-top-img">
                                    <img :src="company.image_fullpath" alt="">
                                </div>
                            </div>
                            <div class="card-body">
                                <p>{{ company.name }}</p>
                                <p>{{ company.address }}</p>
                                <span class="me-1 text-danger" v-for="type in company.types">{{ type.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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