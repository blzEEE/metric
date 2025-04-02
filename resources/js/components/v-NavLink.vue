<template>
    <router-link
        class="inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap"
        :class="[
            this.$props.active
                ? 'border-indigo-400 text-gray-900 focus:outline-none'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300'
        ]"
        :to="{name: routeName}" >
        <slot />
    </router-link>
</template>
<script>
export default {
    props: {
        routeName: {
            type: String
        },
        active: {
            type: Boolean
        }
    }
}
</script>
