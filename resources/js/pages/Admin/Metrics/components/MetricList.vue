<template>
    <div class="flex flex-col rounded-md">
        <div v-for="metricItem in metricList" :key="metricItem.id" class="flex flex-col bg-white hover:bg-gray-100 rounded-md">
            <MetricItem
                :metricItem="metricItem"
                @onMetricDelete="$emit('onMetricDelete', $event)"
                @onMetricEdit="$emit('onMetricEdit', $event)"
                />
        </div>
    </div>
</template>

<script>
import MetricItem from './MetricItem.vue'
import { PlusIcon, PencilSquareIcon, TrashIcon, MagnifyingGlassIcon, XMarkIcon } from "@heroicons/vue/24/outline"
import VButton from "@/components/v-Button.vue"
export default {
    name: "metric-list",
    components: {
        PlusIcon,
        PencilSquareIcon,
        TrashIcon,
        MagnifyingGlassIcon,
        XMarkIcon,
        VButton,
        MetricItem
    },
    data: () => {
        return {
            isShow: false
        }
    },
    props: {
        metrics: {
            type: Object
        }
    },
    computed:{
        metricList(){
            let metrics = this.metrics.sort((a, b) => {
                return a.metric_period_id - b.metric_period_id
            })
            return metrics
        }
    }
}
</script>
