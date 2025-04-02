<template>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 border-collapse border border-slate-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 text-center border-collapse border border-slate 300">
                <tr>
                    <th v-for="(headerValue, headerKey) in header" :key="headerKey" scope="col" class="p-2 border-collapse border border-slate-300">
                        {{ typeof(headerValue) === 'object' ? headerValue?.title : headerValue }}
                    </th>
                    <th v-if="hasActionsSlot" class="px-4 py-2 border-collapse border border-slate-300">
                        Действия
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in data" class="bg-white hover:bg-gray-100 border-collapse border border-slate-200">
                    <td v-for="(headerValue, headerKey) in header" @click="$emit('rowClick', {data: {...row}})" class="p-2 text-gray-700 border-collapse border border-slate-200 cursor-pointer" :class="[typeof(headerValue) === 'object' ? headerValue?.dataClasses : null]">
                        {{ getDeepNestedFieldValue(headerKey, row) }}
                    </td>
                    <td v-if="hasActionsSlot" class="whitespace-nowrap p-2 text-center w-0">
                        <slot name="actions" :data="{...row}" />
                    </td>
                </tr>

            </tbody>

        </table>
    </div>
</template>

<script>
export default {
    name: "v-Table",
    props: {
        header: {
            type: Object
        },
        data: {
            type: Object
        }
    },
    methods: {
        getDeepNestedFieldValue: (path, obj) => path.split('.').reduce((p, c) => (p && p[c]) || null, obj)
    },
    computed: {
        hasActionsSlot() {
            return this.$slots.actions ? !!this.$slots.actions() : false;
        },
    }
}
</script>

<style scoped>

</style>
