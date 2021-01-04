import VueRouter from 'vue-router';
import Laundries from './pages/Laundries'
import ExampleComponent from './components/ExampleComponent'

const routes = [
    {
        path: '/',
        component: ExampleComponent,
    },
    {
        path: '/laundries',
        component: Laundries,
    }
]

export default new VueRouter({
    routes
})