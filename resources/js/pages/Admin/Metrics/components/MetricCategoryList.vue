<template>
    <div class="flex flex-col">
        <div v-for="categoryItem in metricCategories" :key="categoryItem.id" class="flex flex-col">
            <MetricCategoryItem
                :categoryItem="categoryItem"
                @onMetricDelete="$emit('onMetricDelete', $event)"
                @onMetricAdd="$emit('onMetricAdd', $event)"
                @onMetricEdit="$emit('onMetricEdit', $event)"
                @onEditCategory="$emit('onEditCategory', $event)"
                @onDeleteCategory="$emit('onDeleteCategory', $event)"/>

        </div>
    </div>
</template>

<script>
import MetricCategoryItem from './MetricCategoryItem.vue'
import { PlusIcon, PencilSquareIcon, TrashIcon, MagnifyingGlassIcon, XMarkIcon } from "@heroicons/vue/24/outline"
import VButton from "@/components/v-Button.vue"

export default {
    name: "metric-category-list",
    components: {
        PlusIcon,
        PencilSquareIcon,
        TrashIcon,
        MagnifyingGlassIcon,
        XMarkIcon,
        VButton,
        MetricCategoryItem,
    },
    props: {
        header: {
            type: Object
        },
        metricCategories: {
            type: Object
        }
    }
}
</script>
