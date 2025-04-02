<template>
    <p class="text-3xl font-semibold">404</p>
    <p class="text-lg text-sky-600">Страница не найдена <b>{{this.$route.path}}</b></p>
    <p class="text-lg text-sky-600">You are logged in as <b>{{user.email}}</b></p>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
    name:"dummy",
    data(){
        return {
            user:this.$store.state.auth.user
        }
    },
    created() {
        this.setBreadcrumbs(['Страница не найдена'])
    },
    methods: {
        ...mapActions({
            setBreadcrumbs: 'breadcrumbs/setBreadcrumbs'
        })
    },
}
</script>
