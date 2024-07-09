<script>
    import {store} from '../store'

    export default {
        components: {
        },

        data() {
            return {
                store,
            }
        },
        methods:{
            enableSearch()
            {
                this.store.advancedSearchVisibility = true;
            },

            disableSearch()
            {
                this.store.advancedSearchVisibility = false;
                this.store.storedSlug = '';
            }
        }
    }
</script>



<template>

    <!-- Page Header -->
    <header>
        <nav class="navbar navbar-dark navbar-expand-lg  h-100 w-100">
            <div class="container d-flex w-100 h-100 align-items-center justify-content-between">
                <div class="logo-box">
                    <RouterLink :to="{ name: 'home' }"><img src="/imgs/logo.png" class="logo navbar-brand" alt="logo" @click="disableSearch()">
                    </RouterLink>
                </div>
                <div class="down-menu pt-1">

                    <button class="navbar-toggler navbar-burger pt-4" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="burger"><font-awesome-icon :icon="['fas', 'burger']" /></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav pt-4 d-flex">
                            <li class="nav-item my-nav-link text-end">
                                <RouterLink :to="{ name: 'home' }" @click="enableSearch()" class="btn btn-outline-blue" aria-current="page">
                                    Ricerca Avanzata</RouterLink>
                            </li>
                            <li class="nav-item my-nav-link text-end">
                                <a class="btn btn-outline-blue" aria-current="page"
                                    href="http://127.0.0.1:8000/register">Diventa Partner</a>
                            </li>
                            <li class="nav-item my-nav-link text-end">
                                <a class="btn btn-outline-blue" aria-current="page"
                                    href="http://127.0.0.1:8000/login">Sei già Partner?</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>



<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;

header {
    // min-height: 170px;
    width: 100%;
    display: flex;
    justify-content: space-between;
    background-color: #FDB721;
}

.logo-box {
    // flex-shrink: 1;
    max-width:120px;
}

.logo {
    width: 100%;
}

.burger {
    font-size: 40px;
    color: $app-brand-blue;
}

.navbar-burger {
    border: none;
    background-color: #FDB721;
    background-size: 100%;
    background-position: center;
    vertical-align: middle;
}

.navbar-toggler:focus {
    box-shadow: none;
}

.down-menu {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    
}
.my-nav-link{
    background-color: #FDB721;
}
</style>