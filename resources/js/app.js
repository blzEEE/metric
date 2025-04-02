import { createApp, h } from 'vue'
import App from '@/App.vue'
import router from '@/router'
import store from '@/store'


import AuthenticatedLayout from '@/layouts/Authenticated.vue'
import GuestLayout from '@/layouts/Guest.vue'

import '../css/app.css'

store.dispatch("auth/userLoad")
    .catch((error) => {})
    .finally(() => {
    const app = createApp({
        render: () => h(App),
    })

    app.use(router)
    app.use(store)
    app.mount('#app')

    app.component('authenticated-layout', AuthenticatedLayout)
    app.component('guest-layout', GuestLayout)
})
