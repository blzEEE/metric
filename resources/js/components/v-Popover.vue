<template>
    <div class="relative inline">
        <button type="button" @mouseenter="visible=true" @mouseleave="visible=false" :disabled="disabled">
            <svg class="w-4 h-4" :class="[disabled ? 'text-gray-400' : 'text-indigo-400 hover:text-indigo-500']" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
            </svg>
        </button>
        <transition
            enter-active-class="duration-300 ease-out"
            enter-from-class="transform opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="transform opacity-0">
            <div v-if="visible" id="popover-description"
                 class="absolute z-30 inline-block text-sm font-normal text-gray-900 bg-white border border-gray-300 rounded-lg shadow-lg w-72">
                <div class="p-3 space-y-2">
                    <slot />
                </div>
            </div>
        </transition>
    </div>

</template>

<script>
export default {
    name: "v-Popover",
    data(){
        return {
            visible: false,
        }
    },
    props: {
        disabled: {
            type: Boolean,
            default: false
        }
    },
}
</script>

<style scoped>

</style>
