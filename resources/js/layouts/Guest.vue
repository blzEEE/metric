<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-3 bg-gray-100">
        <v-application-logo class="w-20 h-20 fill-current text-gray-500" />
        <h1 class="text-center mt-4 text-lg sm:max-w-md">Мониторинг показателей качества и безопасности медицинской деятельности</h1>
        <div class="w-full sm:max-w-md mt-4 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>

<script>
import VApplicationLogo from '@/components/v-ApplicationLogoAlter.vue'

export default {
    name: 'guest-layout',
    components: {
        VApplicationLogo
    }
}
</script>
