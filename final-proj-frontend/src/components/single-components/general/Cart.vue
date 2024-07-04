<script>
export default {
    props: {
        company: Object,
        cartDishes: Array,
    },
}
</script>

<template>
    <div class="card">
        <div class="card-header">Stai acquistando persso: {{ company.name }}</div>
        <div class="card-body">
            <div class="row" v-for="(dish, i) in cartDishes">
                <div class="col-1">
                    <input type="number" class="w-100 ps-2" :value="dish.qty">
                </div>
                <div class="col-7 text-start">
                    <h5>{{ dish.name }}</h5>                   
                </div>
                <div class="col-3">
                    <h5>{{ dish.price }}</h5>
                </div>
                <div class="col-1">
                    <span @click="$emit('remove', i)" ><font-awesome-icon :icon="['far', 'trash-can']" /></span>
                </div>
            </div>
        </div>
        <div class="card-fooder d-flex justify-content-end pe-2 pb-2 gap-3">
            <input type="submit " class="btn btn-outline-coral" value="Aggiungi nota all'ordine">
            <input type="submit " class="btn btn-outline-coral" value="Completa ordine">

        </div>
    </div>

    <!-- <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-black" id="noteModalLabel">Aggiungi una nota al tuo piatto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="dish-note" class="col-form-label text-black">Aggiungi la tua nota</label>
                    <textarea id="dish-note" cols="50" rows="5" class="frm-control" placeholder="Aggiungi nota..."
                        value=""></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-coral" @click="addNote">Aggiungi nota</button>
                </div>
            </div>
        </div>
    </div> -->
</template>

<style lang="scss" scoped>
@use '../../../assets/style/partials/variables.scss' as *;
</style>