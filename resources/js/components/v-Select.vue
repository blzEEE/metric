<template>
    <div class="w-full">
        <label v-if="label" class="block mb-1 text-sm font-medium text-gray-900 dark:text-gray-300" :for="id">{{ label }}<span v-if="required" class="text-red-500" title="Поле обязательно для заполнения"> *</span></label>
        <select
            :id="id"
            class="w-full pl-2 pr-8 py-1 focus:ring focus:ring-opacity-50 rounded-md shadow-sm placeholder-gray-300"
            :class="[
                error ? 'border-red-500 focus:ring-red-200 focus:border-red-300' : 'border-gray-300 focus:ring-indigo-200 focus:border-indigo-300',
                disabled ? 'bg-gray-200/50 cursor-not-allowed text-gray-900' : '',
            ]"
            :disabled="disabled"
            :value="modelValue"
            @change="$emit('update:modelValue', Number($event.target.value))">
            <option v-for="option in showingOptions" :key="option?.id" :value="option?.id">
                {{ option?.name }}
            </option>
        </select>
        <div v-if="error && showErrorText" class="text-xs text-red-600">{{error[0]}}</div>
    </div>
</template>

<script>

export default {
    name: "v-select",
    props: {
        id: {
            type: String,
            required: true,
        },
        options: {
            type: Array,
        },
        label: {
            type: String
        },
        required: {
            type: Boolean,
            default: false
        },
        modelValue: {
            type: Number
        },
        disabled: {
            type: Boolean,
            default: false
        },
        hasEmptyValue: {
            type: Boolean,
            default: false
        },
        error: {
            type: Array
        },
        showErrorText: {
            type: Boolean,
            default: true
        }
    },
    computed: {
        showingOptions() {
            return this.$props.hasEmptyValue ? [{id: 'null', name: null}, ...this.$props.options] : this.$props.options
        }
    }
}
</script>
