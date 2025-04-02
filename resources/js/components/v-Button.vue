<template>
    <button
        class="relative inline-flex items-center justify-between font-semibold border border-transparent rounded-md focus:outline-none uppercase tracking-widest focus:ring focus:ring-inset focus:ring-1"
        :class="[
            sizeClasses,
            colorClasses,
            disabled || processing ? 'cursor-not-allowed' : ''
        ]"
        :disabled="disabled || processing">

        <svg v-if="processing" aria-hidden="true" role="status" class="mr-2 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"></path>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></path>
        </svg>

        <span v-if="hasIconSlot && !processing" :class="hasIconSlot && hasDefaultSlot ? 'mr-2' : ''">
            <slot name="icon" />
        </span>

        <span v-if="hasDefaultSlot" class="whitespace-nowrap">
            <slot />
        </span>
    </button>
</template>
<script>
export default {
    props: {
        size: {
            type: String,
            default: 'md',
            validator: (value) => ['sm', 'md', 'lg'].indexOf(value) !== -1,
        },
        color: {
            type: String,
            default: 'dark',
            validator: (value) => ['info', 'warning', 'success', 'danger', 'light', 'dark', 'default'].indexOf(value) !== -1,
        },
        processing: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        sizeClasses() {
            switch(this.$props.size) {
                case 'sm': return 'px-1.5 py-1 text-xs'
                case 'md': return 'px-2.5 py-2 text-xs'
                case 'lg': return 'px-6 py-2.5 text'
            }
        },
        colorClasses() {
            switch (this.color) {
                case 'info':
                    return this.disabled || this.processing ? 'bg-indigo-600/40 text-white' : 'bg-indigo-600/75 hover:bg-indigo-600/60 text-white ring-indigo-800'
                case 'warning':
                    return this.disabled || this.processing ? 'bg-amber-600/40 text-white' : 'bg-amber-600/75 hover:bg-amber-600/60 text-white ring-amber-800'
                case 'success':
                    return this.disabled || this.processing ? 'bg-lime-600/40 text-white' : 'bg-lime-600/75 hover:bg-lime-600/60 text-white ring-lime-800'
                case 'danger':
                    return this.disabled || this.processing ? 'bg-orange-600/40 text-white' : 'bg-orange-600/75 hover:bg-orange-600/60 text-white ring-orange-800'
                case 'light':
                    return this.disabled || this.processing ? 'bg-gray-200/50 text-gray-500' : 'bg-gray-200/75 hover:bg-gray-200 text-gray-800 ring-gray-300'
                case 'dark':
                    return this.disabled || this.processing ? 'bg-gray-500 text-white' : 'bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900 text-white ring-gray-900'
                default:
                    return this.disabled || this.processing ? 'bg-gray-100 text-gray-600' : 'bg-gray-200 hover:bg-gray-300 text-gray-800 ring-gray-200'
            }
        },
        hasIconSlot() {
            return this.$slots.icon ? !!this.$slots.icon() : false;
        },
        hasDefaultSlot() {
            return this.$slots.default ? !!this.$slots.default() : false;
        }
    }
}
</script>
