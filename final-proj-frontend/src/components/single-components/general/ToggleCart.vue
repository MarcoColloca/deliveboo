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
                .
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
    border-radius: 18px;
    cursor: pointer;

    &:hover {
        color: $app-brand-yellow;
        background-color: $app-brand-blue;

    }

    .red-point {
        position: fixed;
        top: 10px;
        transform: translate(0, -50%);
        right: 5px;
        color: red;
        font-size: 60px;
    }

}
</style>