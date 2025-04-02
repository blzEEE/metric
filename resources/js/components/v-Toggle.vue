<template>
    <label class="relative flex items-center" :class="[!disabled ? 'cursor-pointer' : '']">
        <input type="checkbox" v-model="proxyChecked" :disabled="disabled" class="sr-only peer">
        <div
            class="w-8 h-4 peer-focus:outline-none peer-focus:ring-0 rounded-full peer peer-checked:after:translate-x-4 peer-checked:after:border-gray-300/75 after:content-[''] after:absolute after:my-auto after:bg-white after:border-gray-300/75 after:border after:rounded-full after:h-4 after:w-4 after:transition-all"
            :class="[disabled ? 'bg-amber-600/40 peer-checked:bg-lime-600/40' : 'bg-amber-500 peer-checked:bg-lime-500']"
        />
        <span class="ml-2 text-sm text-gray-600"><slot /></span>
    </label>
</template>
<script>
export default {
    props: {
        checked: {
            type: Boolean,
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
