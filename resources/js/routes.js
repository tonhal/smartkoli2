import VueRouter from 'vue-router';
import Laundries from './pages/Laundries'
import Guests from './pages/Guests'
import ExampleComponent from './components/ExampleComponent'

const routes = [
    {
        path: '/',
        component: ExampleComponent,
    },
    {
        path: '/laundries',
        component: Laundries,
    },
    {
        path: '/guests',
        component: Guests,
    }
]

export default new VueRouter({
    routes
})