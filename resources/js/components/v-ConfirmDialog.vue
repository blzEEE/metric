<template>
    <transition name="fade">
        <!--modal-->
        <div v-if="showing"
             class="z-50 fixed inset-0 w-full h-screen flex justify-center bg-gray-500/50 overflow-auto py-4">
            <div class="relative m-auto w-full max-w-lg">
                <!--content-->
                <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-center justify-between px-4 py-2 border-b border-solid border-slate-200 rounded-t text-gray-900">
                        <h3 class="text-lg font-semibold">
                            {{ title }}
                        </h3>
                    </div>
                    <!--body-->
                    <div class="relative px-4 py-3 flex-auto">
                        <div class="flex gap-2 text-sm">
                            <div>
                                <svg class="h-10 text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div v-html="message" />
                        </div>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end px-4 py-2 border-t border-solid border-slate-200 rounded-b gap-2">
                        <v-button :color="'dark'" @click="_confirm">{{ okButton }}</v-button>
                        <v-button :color="'light'" @click="_cancel">{{ cancelButton }}</v-button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import VModal from '@/components/v-Modal.vue'
import VButton from '@/components/v-Button.vue'

export default {
    name: "v-confirm-dialog",
    components: {
        VModal,
        VButton
    },
    data: () => ({
        showing: false,
        bodyAlreadyBlocked: false,

        title: undefined,
        message: undefined,
        okButton: 'Подтвердить',
        cancelButton: 'Отмена',

        resolvePromise: undefined,
        rejectPromise: undefined,
    }),
    methods: {
        show(opts = {}) {
            this.title = opts.title
            this.message = opts.message
            if (opts.okButton) {
                this.okButton = opts.okButton
            }
            if (opts.cancelButton) {
                this.cancelButton = opts.cancelButton
            }

            this.showing = true

            this.bodyAlreadyBlocked = document.querySelector('body').classList.contains('overflow-hidden')

            if (!this.bodyAlreadyBlocked) {
                document.querySelector('body').classList.add('overflow-hidden')
            }

            return new Promise((resolve, reject) => {
                this.resolvePromise = resolve
                this.rejectPromise = reject
            })
        },
        _confirm() {
            this.close()
            this.resolvePromise(true)
        },
        _cancel() {
            this.close()
            this.resolvePromise(false)
        },
        close() {
            this.showing = false
            if (!this.bodyAlreadyBlocked) {
                document.querySelector('body').classList.remove('overflow-hidden')
            }

        }
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
