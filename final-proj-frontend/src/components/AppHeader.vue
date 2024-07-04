<script>

export default {
    components: {
    },

    data() {
        return {
        }
    }
}
</script>



<template>

    <!-- Page Header -->
    <header>
        <nav class="navbar navbar-dark navbar-expand-lg  h-100 w-100">
            <div class="container d-flex w-100 h-100 align-items-start justify-content-between mt-3">
                    <div class="logo-box">
                        <RouterLink :to="{ name: 'home' }"><img src="/imgs/logo.png" class="logo navbar-brand" alt="logo">
                        </RouterLink>
                    </div>
                    <div class="down-menu pt-1">

                        <button class="navbar-toggler navbar-burger pt-4" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="burger"><font-awesome-icon :icon="['fas', 'burger']" /></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav pt-4">
                                <li class="nav-item text-end">
                                    <RouterLink :to="{ name: 'search' }" class="btn btn-outline-blue"
                                        aria-current="page">Ricerca Avanzata</RouterLink>
                                </li>
                                <li class="nav-item text-end">
                                    <a class="btn btn-outline-blue" aria-current="page"
                                        href="http://127.0.0.1:8000/register">Diventa Partner</a>
                                </li>
                                <li class="nav-item text-end">
                                    <a class="btn btn-outline-blue" aria-current="page"
                                        href="http://127.0.0.1:8000/login">Sei già Partner?</a>
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
        </nav>

        <!-- <div class="container-fluid h-100">
            <nav class="navbar navbar-expand-md h-100 d-flex gap-5 justify-content-between align-items-center">
                <div>
                    <RouterLink :to="{ name: 'home' }"><img src="/imgs/logo.png" class="logo navbar-brand" alt="logo">
                    </RouterLink>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="d-flex gap-4 collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <RouterLink :to="{ name: 'search' }">Ricerca Avanzata</RouterLink>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light nav-link" href="http://127.0.0.1:8000/register">Diventa Partner Fooder!</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light nav-link" href="http://127.0.0.1:8000/login">Sei già Partner?</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div> -->
    </header>
</template>



<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;

header {
    min-height: 160px;
    width:100%;
    display: flex;
    justify-content: space-between;
    background-color: #FDB721;
}

.logo-box{
    flex-shrink: 0;
}

.logo {
    width: 120px;
}
.burger{
    font-size:40px;
    color: $app-brand-blue;
}
.navbar-burger{
    border:none;
    background-color: #FDB721;
    background-size: 100%;
    background-position: center;
    vertical-align: middle;
}
.navbar-toggler:focus{
 box-shadow:none;
}
.down-menu{
    display:flex;
    flex-direction: column;
    align-items: flex-end;
    flex-shrink: 0;
}
</style>