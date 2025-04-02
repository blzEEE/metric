<template>
    <div class="w-full">
        <label v-if="label" class="block mb-1 text-sm font-medium text-gray-900 dark:text-gray-300" :for="id">{{ label }}<span v-if="required" class="text-red-500" title="Поле обязательно для заполнения"> *</span></label>

        <tiptap v-if="useWYSIWYG" :modelValue="modelValue" @update:modelValue="$emit('update:modelValue', $event)" />

        <textarea v-if="!useWYSIWYG"
            :id="id"
            class="w-full px-2 py-1.5 focus:ring focus:ring-opacity-50 rounded-md shadow-sm placeholder-gray-300"
            :class="[
                error ? 'border-red-500 focus:ring-red-200 focus:border-red-300' : 'border-gray-300 focus:ring-indigo-200 focus:border-indigo-300',
                disabled ? 'bg-gray-200/50 cursor-not-allowed text-gray-500' : '',
            ]"
            :placeholder="placeholder"
            :autofocus="autofocus"
            :disabled="disabled"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        ></textarea>

        <div v-if="error && showErrorText" class="text-xs text-red-600">{{error[0]}}</div>
    </div>
</template>

<script>
import Tiptap from '@/components/Tiptap.vue'

export default {
    name: "v-textarea",
    components: {
        Tiptap
    },
    props: {
        id: {
            type: String,
            required: true,
        },
        label: {
            type: String
        },
        required: {
            type: Boolean,
            default: false
        },
        placeholder: {
            type: String
        },
        modelValue: {
            type: [Number, String]
        },
        autofocus: {
            type: Boolean
        },
        disabled: {
            type: Boolean,
            default: false
        },
        error: {
            type: Array
        },
        showErrorText: {
            type: Boolean,
            default: true
        },
        useWYSIWYG: {
            type: Boolean,
            default: false
        }
    }
}
</script>