<script>
import axios from 'axios';
import BentoBox from '../components/single-components/general/BentoBox.vue';
import { store } from '../store';

export default {
    components: {
        BentoBox
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
        }
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
                <div v-if="companies.length !== 0" class="row row-gap-5">
                    <div class="col-3" v-for="company in companies" :key="company.id">
                        <div class="card h-100">
                            <div class="card-header">
                                <div class="card-top-img">
                                    <img v-if="company.image_fullpath" :src="company.image_fullpath" class="my-img-card"
                                        alt="">
                                    <img v-else src="http://127.0.0.1:8000/storage/image/default-company.jpg"
                                        class="my-img-card" alt="">
                                </div>
                            </div>
                            <div class="card-body">
                                <p>{{ company.name }}</p>
                                <p>{{ company.address }}</p>
                                <p>{{ company.phone_number }}</p>
                                <p>{{ company.email }}</p>
                                <span class="me-2 text-danger" v-for="type in company.types" :key="type.id">{{ type.name
                                    }}</span>
                            </div>
                            <RouterLink :to="{ name: 'menu', params: { slug: company.slug } }">
                                Vai al menù
                            </RouterLink>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <img src="/imgs/fooder.gif" class="my-gif" alt="">
                    <h2 class="sub-title">Nessuna compagnia rispetta i parametri della Ricerca</h2>
                </div>
            </div>
        </div>
    </div>
</template>



<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;

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
