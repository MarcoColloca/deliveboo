<script>

    export default {
        components:{            
        },

        data(){
        }
    }
</script>



<template>
    <!-- Page Header -->
    <header>
        <div class="container h-100">
            <nav class="h-100 d-flex gap-5 justify-content-between align-items-center">
                <div>
                    <RouterLink :to="{name: 'home'}">LOGO</RouterLink>
                </div>
                <div class="d-flex gap-4">             
                    <RouterLink :to="{name: 'search'}">Ricerca Avanzata</RouterLink> 
                </div>
                <div class="d-flex gap-4">
                    <a class="btn btn-outline-light" href="http://127.0.0.1:8000/register">Diventa Partner FoodLan!</a>
                    <a class="btn btn-outline-light" href="http://127.0.0.1:8000/login">Sei già Partner?</a>
                </div>
            </nav>
        </div>
    </header>
</template>



<style lang="scss" scoped>
    header{
        height: 100px;
        background-color: coral;
    }
</style>