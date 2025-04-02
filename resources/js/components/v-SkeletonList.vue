<template>

    <div v-for="headerRow in headerCount" class="mb-4">
        <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-64 mb-2.5"></div>
        <div class="w-full h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
    </div>

    <div role="status" class="w-full p-4 space-y-4 border border-gray-200 divide-y divide-gray-200 rounded shadow animate-pulse dark:divide-gray-700 md:p-6 dark:border-gray-700">
        <div v-for="row in rowCount" class="flex items-center justify-between pt-4">
            <div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-48 mb-2.5"></div>
                <div class="w-64 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
            </div>
            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
        </div>
    </div>

</template>

<script>
export default {
    name: "v-skeleton-list",
    props: {
        rowCount: {
            type: Number,
            default: 5
        },
        headerCount: {
            type: Number,
            default: 0
        }
    }
}
</script>

<style scoped>

</style>
