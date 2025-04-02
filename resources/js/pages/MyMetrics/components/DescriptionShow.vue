<template>
    <transition name="fade">

        <v-modal :showing="showing" @close="close" :size="'md'">

            <template #header>
                {{ title }}
            </template>

            <template #body>
                <div class="text-sm" v-html="message" />
            </template>

            <template #footer>
                <v-button :color="'light'" @click="close">{{ closeButton }}</v-button>
            </template>

        </v-modal>

    </transition>
</template>

<script>
import VModal from '@/components/v-Modal.vue'
import VButton from '@/components/v-Button.vue'

export default {
    name: "description-show",
    components: {
        VModal,
        VButton
    },
    data: () => ({
        showing: false,

        title: undefined,
        message: undefined,
        closeButton: 'Закрыть'
    }),
    methods: {
        show(opts = {}) {
            this.title = opts.title
            this.message = opts.message

            this.showing = true
        },

        close() {
            this.showing = false
        },
    },
    mounted() {
        document.querySelector('body').classList.add('overflow-hidden')
    },
    unmounted() {
        document.querySelector('body').classList.remove('overflow-hidden')
    }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
