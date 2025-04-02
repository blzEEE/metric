<template>
    <div
        class="inline-flex items-center pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out"
        :class="[
            this.$props.active
                ? 'border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300'
        ]">
        <div class="relative">

            <div @click="open = !open">
                <span class="inline-flex rounded-md">
                    <button type="link" class="inline-flex items-center px-3 border border-transparent text-sm leading-4 font-medium rounded-md bg-white focus:outline-none transition ease-in-out duration-150 whitespace-nowrap">
                        <slot name="trigger" />
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </span>
            </div>

            <!-- Full Screen Dropdown Overlay -->
            <div v-show="open" class="fixed inset-0 z-40" @click="open = false"></div>

            <transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95">
                <div v-show="open"
                     class="absolute z-50 mt-6 rounded-md shadow-lg"
                     :class="[widthClass, alignmentClasses]"
                     style="display: none;"
                     @click="open = false">
                    <div class="rounded-md ring-1 ring-black ring-opacity-5" :class="contentClasses">
                        <slot name="content" />
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            open: false
        }
    },
    props: {
        align: {
            default: 'left'
        },
        width: {
            default: '48'
        },
        contentClasses: {
            default: () => ['py-1', 'bg-white']
        },
        active: {
            default: false
        }
    },
    methods: {
        closeOnEscape(e) {
            if (this.open && e.key === 'Escape') {
                this.open = false
            }
        }
    },
    mounted() {
        document.addEventListener('keydown', this.closeOnEscape)
    },
    destroyed() {
        document.removeEventListener('keydown', this.closeOnEscape)
    },
    computed: {
        widthClass() {
            return {
                '48': 'w-48',
            }[this.$props.width.toString()];
        },
        alignmentClasses() {
            if (this.$props.align === 'left') {
                return 'origin-top-left left-0';
            } else if (this.$props.align === 'right') {
                return 'origin-top-right right-0';
            } else {
                return 'origin-top';
            }
        },
    }
}

</script>
