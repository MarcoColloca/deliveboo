<script>
import { store } from '../../../store';


export default {
    data() {
        return {
            store,


        }
    },

    props: {
        cartDishes: Array,
    },


    methods: {

        toggleCart() {
            this.store.showCart = !this.store.showCart
        },


    }
}
</script>



<template>
    <div>
        <div class="show-cart" @click="toggleCart">
            <span>
                <font-awesome-icon :icon="['fas', 'cart-shopping']" />
            </span>
            <span v-if="this.cartDishes.length > 0" class="red-point">
                <font-awesome-icon :icon="['fas', 'circle']" />
            </span>
        </div>
    </div>
</template>



<style lang="scss" scoped>
@use '../../../assets/style/partials/variables' as *;

.show-cart {
    position: fixed;
    top: 50%;
    transform: translate(0, -50%);
    right: 15px;
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
    border-radius: 50%;
    border-radius: 50%;
    cursor: pointer;

    &:hover {
        color: $app-brand-yellow;
        background-color: $app-brand-blue;

    }

    .red-point {
        position: fixed;
        top: 33px;
        top: 33px;
        transform: translate(0, -50%);
        right: -2px;
        color: $app-brand-red;
        font-size: 16px;
    }

}

// MEDIA QUERY

@media (min-width: 768px) {

    .show-cart {
        right: 30px;
        width: 60px;
        height: 60px;
        font-size: 25px;
        
        .red-point {
            top: 51px;
            right: -4px;
            font-size: 23px;
        }
    }

}
</style>