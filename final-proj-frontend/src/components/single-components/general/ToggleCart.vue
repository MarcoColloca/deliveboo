<script>
    import { store } from '../../../store';


    export default {
        data() {
            return {
                store,
            }
        },


        methods: {
            
            toggleCart(){
                this.store.showCart = !this.store.showCart
            },

        }
    }
</script>



<template>
    <div>
        <div class="show-cart" @click="toggleCart">
            <span >
                <font-awesome-icon :icon="['fas', 'cart-shopping']"/>
            </span>
        </div>
    </div>
</template>



<style lang="scss" scoped>
    @use '../../../assets/style/partials/variables' as *;

    .show-cart{
        width: 40px;
        height: 40px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: $app-brand-blue;
        background-color: $app-brand-yellow;
        font-size: 15px;
        border: 1px solid $app-brand-blue;
        border-radius: 18px;       
        cursor: pointer;
        &:hover{
            color: $app-brand-yellow;
            background-color: $app-brand-blue;

        }
    }
</style>