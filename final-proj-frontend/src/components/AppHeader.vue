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
        <nav class="d-flex gap-5 justify-content-center align-items-center">
            <RouterLink :to="{name: 'home'}">Home</RouterLink>
            <RouterLink :to="{name: 'search'}">Ricerca Avanzata</RouterLink>           
        </nav>
    </header>
</template>



<style lang="scss" scoped>
    header{
        height: 100px;
        background-color: coral;
    }
</style>