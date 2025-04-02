<template>
    <label class="flex items-center">
        <input type="checkbox" v-model="proxyChecked"
               :disabled="disabled"
               class="rounded ring-offset-0 focus:ring-0"
               :class="[disabled ? 'text-gray-300 border-gray-300 bg-gray-200/75' : 'text-indigo-500/75 border-indigo-500/75']" />
        <span class="ml-2 text-sm text-gray-600"><slot /></span>
    </label>
</template>
<script>
export default {
    props: {
        checked: {
            type: [Array, Boolean],
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        proxyChecked: {
            get() {
                return this.$props.checked;
            },
            set(val) {
                this.$emit("update:checked", val);
            },
        }
    }
}
</script>
