import { reactive } from 'vue'

export const store = reactive({
    test: 'test',
    advancedSearchVisibility: false,
    storedSlug: '',
    cartDishes: [],
    showCart: false,
    cartCompany: null,
    currentCompany: null,
    showClearCart: false,
})

