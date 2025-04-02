<template>
    <!--modal-->
    <div v-if="showing"
        class="z-40 fixed inset-0 w-full h-screen flex justify-center bg-gray-500/50 overflow-auto py-4">
        <div class="relative m-auto w-full" :class="[size=='xl' ? 'max-w-6xl' :  (size=='md' ? 'max-w-3xl' : 'max-w-lg')]">
            <!--content-->
            <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <!--header-->
                <div class="flex items-center justify-between px-4 py-2 border-b border-solid border-slate-200 rounded-t text-gray-900">
                    <h3 class="text-lg font-semibold">
                        <slot name="header"/>
                    </h3>
                    <button
                        v-if="showingCloseButton"
                        aria-label="close"
                        @click.prevent="$emit('close')">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <!--body-->
                <div class="relative px-4 py-3 flex-auto">
                    <slot name="body"/>
                </div>
                <!--footer-->
                <div class="flex items-center px-4 py-2 border-t border-solid border-slate-200 rounded-b gap-2" :class="footerJustify">
                    <slot name="footer" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "v-modal",
    props: {
        showing: {
            required: true,
            type: Boolean,
            default: false
        },
        showingCloseButton: {
            type: Boolean,
            default: true
        },
        size: {
            type: String,
            default: 'sm'
        },
        footerJustify: {
            type: String,
            default: 'justify-end'
        }
    },
    mounted() {
        document.querySelector('body').classList.add('overflow-hidden')
    },
    unmounted() {
        document.querySelector('body').classList.remove('overflow-hidden')
    }

}
</script>
