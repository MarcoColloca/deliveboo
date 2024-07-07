import { createApp } from 'vue'
import './assets/style/general.scss'
import App from './App.vue'
import * as bootstrap from 'bootstrap'


/*importazione vue router*/
import router from './router'



/* Importazione della libreria di font awesome*/
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'


// Icone Regular Font Awesome
import { 
    faClock as faClockSolid,
    faChevronDown as faChevronDownSolid,
    faArrowUpLong as faArrowUpLongSolid,
    faArrowRightLong as faArrowRightLongSolid,
    faCircle as faCircleSolid,
    faEye as faEyeSolid,
    faLocationDot as faLocationDotSolid,
    faBurger as faBurgerSolid,
    faSpinner as faSpinnerSolid,
    faCartShopping as faCartShoppingSolid,
} from '@fortawesome/free-solid-svg-icons'

// Icone Solid Font Awesome
import { 
    faClock as faClockRegular,    
    faUser as faUserRegular,
    faFileLines as faFileLinesRegular,
    faCalendar as faCalendarRegular,
    faTrashCan as faTrashCanRegular,
} from '@fortawesome/free-regular-svg-icons'

// Icone Brands Font Awesome
import{
    faTwitter,
    faFacebookF,
    faInstagram,
    faLinkedin,
} from '@fortawesome/free-brands-svg-icons'

library.add(faClockSolid, faClockRegular, faBurgerSolid, faChevronDownSolid, faTwitter, faFacebookF, faInstagram, faLinkedin, faArrowUpLongSolid, faCircleSolid, faArrowRightLongSolid, faUserRegular, faFileLinesRegular, faEyeSolid, faCalendarRegular, faLocationDotSolid, faTrashCanRegular, faSpinnerSolid, faCartShoppingSolid)




const app = createApp(App)

app.use(router)

app.component('font-awesome-icon', FontAwesomeIcon)

app.mount('#app')
