<template>
<div class="menu-page">
    <h1>{{ company.name }}</h1>
    <p v-for="type in company.types">{{ type.name }}</p>
    <div class="container">
        <div class="row row-gap-5">
            <div class="col-3" v-for="dish in dishes" :key="dish.id">
                <div class="card" v-if="dish.visible === 1">
                    <div class="card-header">
                        <div class="card-top-img">
                            <img :src="dish.image_fullpath" alt="">
                        </div>
                    </div>
                    <div class="card-body">
                        <p><strong>Nome:</strong> {{ dish.name }}</p>
                        <p><strong>Ingredienti:</strong> {{ dish.ingredients }}</p>
                        <p><strong>Descrizione:</strong> {{ dish.description }}</p>
                        <p><strong>Prezzo:</strong> {{ dish.price }} €</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        slug: {
            type: String,
            required: true
        }
    },
    computed: {
        companySlug() {
            return this.slug;
        }
    },
    data() {
        return {
            dishes: [],
            company: {}
        };
    },
    created() {
        this.fetchDishes(this.slug);
    },
    methods: {
        fetchDishes(slug) {
            axios.get(`http://127.0.0.1:8000/api/companies/${slug}`)
                .then(res => {
                    this.dishes = res.data.results.dishes;
                    this.company = res.data.results;
                    console.log(res);
                })
        }
    },
}
</script>

<style lang="scss" scoped>
.menu-page {
    text-align: center;

    .container {
        .row {
            .card {
                margin-bottom: 20px;

                .card-header {
                    .card-top-img {
                        img {
                            max-width: 100%;
                        }
                    }
                }
            }
        }
    }
}
</style>
