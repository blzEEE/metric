<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    active: {
        default: false
    }
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const open = ref(false);

const classes = computed(() => props.active
    ? 'block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out'
    : 'block pl-3 pr-4 py-2 border-l-4 border-gray-300 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out'
);

</script>

<template>
    <div>
        <div class="relative">

            <div @click="open = !open" :class="classes">
                <span class="inline-flex rounded-md">
                    <slot name="trigger" />
                    <svg class="ml-2 mt-1 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </span>
            </div>

            <div v-show="open"
                    style="display: none;">
                <slot name="content" />
            </div>

        </div>
    </div>
</template>
