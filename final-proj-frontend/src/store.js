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
    newItemIntoCart: null
})

// Recupero i dati dal localStorage al caricamento della pagina
const savedCartDishes = localStorage.getItem('cartDishes')
const savedCartCompany = localStorage.getItem('cartCompany')

if (savedCartDishes) {
store.cartDishes = JSON.parse(savedCartDishes)
}

if (savedCartCompany) {
store.cartCompany = JSON.parse(savedCartCompany)
}
  
// Funzione per inizializzare i watcher
export function initializeStore(watch) {
    // Watch per salvare i dati quando cambiano
    watch(
    () => store.cartDishes,
    (newCartDishes) => {
        localStorage.setItem('cartDishes', JSON.stringify(newCartDishes))
    },
    { deep: true }
    )

    watch(
    () => store.cartCompany,
    (newCartCompany) => {
        localStorage.setItem('cartCompany', JSON.stringify(newCartCompany))
    }
    )
}