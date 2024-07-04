<script>
import { RouterLink } from 'vue-router';

export default {
    props: {
        company: Object,
        cartDishes: Array,
    },

    data(){
        return{

        }
    },


    methods:{
        getPrice(qty, price){

            const total = (qty * price).toFixed(2);

            return total
        },

        getTotal(){

            let sum = 0;

            this.cartDishes.forEach(element => {



                const dishPrice = element.price * element.qty


                sum += dishPrice
                
            });

            return sum
        }
    }
}
</script>

<template>
    <div class="card">
        <div class="card-header">Stai acquistando persso: {{ company.name }}</div>
        <div class="card-body">
            <div class="row mb-2" v-for="(dish, i) in cartDishes">
                <div class="col-2 d-flex gap-2">
                    <span class="btn btn-outline-coral px-3" @click="$emit('decrease', dish.id)">-</span>
                    <input type="hidden" class="w-25 ps-2" :value="dish.qty">
                    <span class="btn btn-outline-dark px-3">{{ dish.qty }}</span>
                    <span class="btn btn-outline-coral px-3" @click="$emit('increase', dish.id)">+</span>
                </div>
                <div class="col-6 text-start">
                    <h5>{{ dish.name }}</h5>                   
                </div>
                <div class="col-3">
                    <h5>{{ getPrice(dish.qty, dish.price) }} €</h5>
                </div>
                <div class="col-1">
                    <span @click="$emit('remove', i)" ><font-awesome-icon :icon="['far', 'trash-can']" /></span>
                </div>
                
            </div>
            <div class="row mb-2 text-center">
                <h4>Totale Ordine: {{ getTotal() }} €</h4>
            </div>
        </div>
        <div class="card-fooder d-flex justify-content-end pe-2 pb-2 gap-3">
            <input type="submit " class="btn btn-outline-coral" value="Aggiungi nota all'ordine">
            <RouterLink class="btn btn-outline-coral" :to="{ name: 'payment' }">
                Procedi al Pagamento
            </RouterLink>

        </div>
    </div>
</template>

<style lang="scss" scoped>
@use '../../../assets/style/partials/variables.scss' as *;
</style>