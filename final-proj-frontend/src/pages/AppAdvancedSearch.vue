<script>
import axios from 'axios';
import BentoBox from '../components/single-components/general/BentoBox.vue';

export default {
    components: {
        BentoBox
    },

    props: {
        slug: String
    },

    data() {
        return {
            types: [],
            currentPage: 1,
            perPage: 99,
            selectedTypeSlugs: [], 
            companies: [],
        }
    },

    created() {
        this.fetchTypes();
        if (this.slug) {
            this.addSlugToSelectedTypes(this.slug);
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
    <div class="search-container">
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
                <h1>Ricerca Avanzata</h1>
            </div>
            <div class="container">
                <div class="row row-gap-5">
                    <div class="col-3" v-for="company in companies" :key="company.id">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-top-img">
                                    <img v-if="company.image_fullpath" :src="company.image_fullpath" alt="">
                                    <img v-else src="http://127.0.0.1:8000/storage/image/default-company.jpg" alt="">
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
            </div>
        </div>
    </div>
</template>



<style lang="scss" scoped>
.search-container {
    height: 100%;
    display: flex;

    .sidebar {
        width: 300px;
        flex-shrink: 0;
        background-color: rgb(168, 194, 185);
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
                    color: coral;
                    background-color: white;
                    border: 1px solid white;
                    border-radius: 18px;
                    padding: 0 3px;
                }
            }
        }
    }

    .content {
        text-align: center;
        flex-grow: 1;
        background-color: rgb(184, 196, 206);
        color: black;

        img {
            max-height: 181px;
        }
    }
}
</style>
