<script>
</script>

<template>
    <section>
        <div class="container">
            <div class="d-flex">
                <div class="page-title">
                    <h1 class="text-center my-4 fs-1 fw-bold text-blue">Il nostro Team</h1>
                    
                </div>
                <div class="duck-container">
                    <img src="/imgs/papera.png" class="title-img" alt="">
                </div>
            </div>
            <div class="row w-100 justify-content-center g-0 row-gap-4 row-cols-1 row-cols-md-2 row-cols-lg-3 my-4">
                
                <div class="col d-flex justify-content-center">
                    <div class="our-card">
                        <img src="/imgs/francesca.png" class="member-img" alt="">
                        <div class="member-name text-center">
                            <h3>Francesca</h3>
                            <h3>Barletta</h3>
                        </div>
                        <div class="our-card-text  w-100  rounded-3 py-2 text-center">
                            <p class="m-0">Frontend Web Developer</p>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="our-card">
                        <img src="/imgs/gianni.png" class="member-img" alt="">
                        <div class="member-name text-center">
                            <h3>Gianni</h3>
                            <h3>Saladino</h3>
                        </div>
                        <div class="our-card-text w-100 rounded-3 py-2 w-100 text-center">
                            <p class="m-0">Backend Web Developer</p>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="our-card">
                        <img src="/imgs/marco.png" class="member-img" alt="">
                        <div class="member-name text-center">
                            <h3>Marco</h3>
                            <h3>Colloca</h3>
                        </div>
                        <div class="our-card-text  w-100  rounded-3 py-2 text-center">
                            <p class="m-0">Full Stack Web Developer</p>
                        </div>

                    </div>
                </div>
                <div class="col d-flex justify-content-center">
                    <div class="our-card">
                        <img src="/imgs/moustafa.png" class="member-img" alt="">
                        <div class="member-name text-center">
                            <h3>Moustafa</h3>
                            <h3>Ibrahim</h3>
                        </div>
                        <div class="our-card-text  w-100 rounded-3 py-2 text-center">
                            <p class="m-0">Backend Web Developer</p>
                        </div>

                    </div>
                </div>
                <div class="col d-flex justify-content-center">
                    <div class="our-card">
                        <img src="/imgs/paolo.png" class="member-img" alt="">
                        <div class="member-name text-center">
                            <h3>Paolo</h3>
                            <h3>Calcagni</h3>
                        </div>
                        <div class="our-card-text  w-100 rounded-3 py-2 text-center">
                            <p class="m-0">Frontend Web Developer</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

</template>

<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;

section {
    background-image: url(/imgs/sfondo-down.png);
    background-size: cover;
    padding: 30px 0;
}

.our-card {
    width: 300px;
    height: 500px;
    background-color: white;
    color: $app-brand-blue;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border-radius: 15px;
    box-shadow: 0 2px 10px black;

    .member-img {
        width: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .our-card-text {
        color: white;
        background-color: $app-brand-blue;
        display: flex;
        justify-content: center;
        align-items: center;
    }

}

.page-title {
    width: 300px;
    margin: 70px 0;
    
}
.duck-container{
    flex-grow: 1;
    position: relative;
    .title-img {
        width: 100px;
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%) rotate(0deg);
        animation: duck 5s infinite linear;
    }

    @keyframes duck {
        0% {
            transform: translateY(-50%) translateX(0) rotate(0deg);
        }

        49.99% {
            transform: translateY(-50%) translateX(700px) rotate(0deg);
        }

        50% {
            transform: translateY(-50%) translateX(700px) rotateY(180deg);
        }

        99.99% {
            transform: translateY(-50%) translateX(0) rotateY(180deg);
        }

        100% {
            transform: translateY(-50%) translateX(0) rotateY(0deg);
        }
    }
}
</style>