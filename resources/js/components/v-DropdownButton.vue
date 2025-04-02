<template>
    <div class="inline relative">
        <v-button @click.prevent="open = !open" :color="'light'" :size="'sm'" :class="btnClasses">
            <slot name="trigger" />
        </v-button>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="open" class="fixed inset-0 z-40" @click.prevent="open = false"></div>

        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95">
            <div v-show="open"
                 class="absolute z-50 mt-1 rounded-md shadow-lg"
                 :class="[alignmentClasses]"
                 style="display: none;"
                 @click.prevent="open = false">
                <div class="rounded-md ring-1 ring-black ring-opacity-5 cursor-pointer px-1.5 py-0.5 text-sm" :class="contentClasses">
                    <slot name="content" />
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import VButton from '@/components/v-Button.vue'

const props = defineProps({
    align: {
        default: 'right'
    },
    btnClasses: {
        default: ''
    },
    contentClasses: {
        default: () => ['py-1', 'bg-white']
    }
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'origin-top-left left-0';
    } else if (props.align === 'right') {
        return 'origin-top-right right-0';
    } else {
        return 'origin-top';
    }
});

const open = ref(false);
</script>


