<template>
    <div class="w-full">
        <label v-if="label" class="block mb-1 text-sm font-medium text-gray-900 dark:text-gray-300" :for="id">{{ label }}<span v-if="required" class="text-red-500" title="Поле обязательно для заполнения"> *</span></label>
        <div class="flex relative">

            <div v-if="hasPrefixSlot" class="text-gray-500 flex absolute inset-y-0 left-0 items-center pl-2 pointer-events-none overflow-hidden">
                <slot name="prefix"></slot>
            </div>

            <input
                :id="id"
                :type="type"
                :step="[type === 'number' ? '.01' : null]"
                lang="ru-RU"
                class="w-full px-2 py-1 focus:ring focus:ring-opacity-50 rounded-md shadow-sm placeholder-gray-300"
                :class="[
                  hasPrefixSlot ? 'pl-10' : '',
                  hasSuffixSlot ? 'pr-10' : '',
                  error ? 'border-red-500 focus:ring-red-200 focus:border-red-300' : 'border-gray-300 focus:ring-indigo-200 focus:border-indigo-300',
                  disabled ? 'bg-gray-200/50 cursor-not-allowed text-gray-500' : '',
                  type === 'number' ? 'text-right' : '',
                ]"
                :placeholder="placeholder"
                :autofocus="autofocus"
                :autocomplete="autocomplete"
                :title="type == 'text' ? modelValue : null"
                :disabled="disabled"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                @keypress="type === 'number' ? NumbersOnly($event) : null"
                @change="type === 'number' ? NumberFormat($event.target.value) : null"
                @focusin="type === 'number' && $event.target.value == 0 ? $event.target.select() : null"
                ref="input"
            />

            <div v-if="hasSuffixSlot" class="text-gray-500 flex absolute inset-y-0 right-0 items-center pr-2 overflow-hidden">
                <slot name="suffix"></slot>
            </div>

        </div>
        <div v-if="error && showErrorText" class="text-xs text-red-600">{{error[0]}}</div>
    </div>
</template>

<script>


export default {
    name: "v-input",
    props: {
        id: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            default: "text",
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
            type: Boolean,
            default: false
        },
        autocomplete: {
            type: String
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
        }
    },
    created() {
        if (this.$props.type === 'number') {
            this.NumberFormat(this.$props.modelValue)
        }
    },
    mounted() {
        if (this.$props.autofocus) {
            this.$refs.input.focus()
        }
    },
    methods: {
        NumbersOnly(event) {
            event = event ?? Window.event
            let charCode = event.which ?? event.keyCode
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 44) {
                event.preventDefault()
            } else {
                return true
            }
        },
        NumberFormat(value) {
            if (value !== null) {
                value = parseFloat(Number(value)).toFixed(2)
                this.$emit('update:modelValue', value)
            }
        }
    },
    computed: {
        hasPrefixSlot() {
            return this.$slots.prefix ? !!this.$slots.prefix() : false;
        },
        hasSuffixSlot() {
            return this.$slots.suffix ? !!this.$slots.suffix() : false;
        }
    }
}
</script>

<style scoped>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
