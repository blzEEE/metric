<template>
    <router-link :to="{name: routeName}" :class="classes" @click="$emit('itemClick')">
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
                ? 'block my-1 ml-4 pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out'
                : 'block my-1 ml-4 pl-3 pr-4 py-2 border-l-4 border-gray-300 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out'
        }
    }
}
</script>
