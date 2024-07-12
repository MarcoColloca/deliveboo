<script>
 import SocialIcons from '../components/single-components/general/SocialIcons.vue';
 import BackTop from '../components/single-components/general/BackTop.vue';

    export default {
        components:{
            SocialIcons,
            BackTop,
        },

        data(){            
            return {
            }
        }
        
    }
</script>





<template>
    <!-- Page Footer -->
    <footer>
        <div class="container py-4 footer-container">
           <div class="row g-0 row-cols-1 row-cols-md-2 row-cols-lg-3 w-100 justify-content-around">
            <div class="col gap-2 d-flex flex-column justify-content-center align-items-center">
                <BackTop></BackTop>
                <p><a href="http://127.0.0.1:8000/register">Fooder Business</a></p>
                <p><a href="http://127.0.0.1:8000/login">Fooder Partner</a></p>
            </div>
            <div class="col gap-2 d-flex flex-column justify-content-center align-items-center">
             
                <p><a href="#">Chi siamo</a></p>
                <p><a href="#">Faq</a></p>
                <p><a href="#">Contattaci</a></p>
            </div>

            <div class="col gap-2 d-flex flex-column justify-content-center align-items-center">

                <p><a href="#">Termini e condizioni</a></p>
                <p><a href="#">Privacy</a></p>
                
                <SocialIcons></SocialIcons>

            </div>
           </div>
        </div>
    </footer>
</template>




<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*;


footer{

        background-color: $app-brand-blue;
       

}
</style>