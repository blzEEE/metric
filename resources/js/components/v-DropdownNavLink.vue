<template>
    <router-link :to="{name: routeName}" :class="classes">
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
    },
    computed: {
        classes() {
            return this.$props.active
                ? 'block w-full px-4 py-2 text-left text-sm border-l-2 border-indigo-400 focus:outline-none focus:text-indigo-800 hover:bg-gray-100 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out'
                : 'block w-full px-4 py-2 text-left text-sm border-l-2 border-white hover:border-gray-100 leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out'
        }
    }
}
</script>
