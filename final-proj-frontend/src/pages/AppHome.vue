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
        <div class="my-container mt-4" v-if="!this.store.advancedSearchVisibility">
    
            <div class="scrollmenu">
                <div v-for="type in types" :key="type.slug" class="col type-col">
                    <div class="type-card">
                        <img :src="`/imgs/${type.slug}.png`" class="type-img" alt="">
                        <RouterLink :to="{ name: 'homeSearch', params: { slug: type.slug } }"
                            @click="enableSearch(), storeSlug(type.slug)" class="type-link">{{ type.name }}</RouterLink>
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

.hero {
    background-image: url(/imgs/sfondo.png);
    background-size: cover;

}


ul {
    height: 250px;
    align-items: center;
}
.my-container{
    width:90%;
    margin: auto;
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
        
        //    border-radius: 15px 22px 22px;
        border-radius: 15px 32px 15px;
        margin-bottom: 6px;

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