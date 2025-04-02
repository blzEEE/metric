<template>
    <component :is="layout">
        <router-view />
        <v-alerts-list />
    </component>
</template>

<script>
import VAlertsList from "@/components/v-AlertsList.vue"

export default {
    name: "App",
    components: {
        VAlertsList
    },
    computed: {
        layout() {
            return this.$route.meta.layout || 'authenticated-layout'
        }
    }
}
</script>
