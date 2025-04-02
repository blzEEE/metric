<template>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8 text-sm text-gray-500">
            <span v-for="(item, index) in breadcrumbs">
                <span>{{item}}</span>
                <span v-if="index !== breadcrumbs.length - 1" class="mx-2">/</span>
            </span>
        </div>
    </header>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    name: "v-Breadcrumbs",
    computed: {
        ...mapGetters({
            breadcrumbs: 'breadcrumbs/breadcrumbs'
        })
    }
}
</script>

<style scoped>

</style>
