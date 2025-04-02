<template>
    <div class="mb-4 border border-gray-300 rounded-md">
        <div class="flex justify-between bg-gray-200/75 py-1.5"
            :class="[isMetricsShown ? 'rounded-t-md' : 'rounded-md']">
            <div @click="isMetricsShown = !isMetricsShown" class="flex items-center cursor-pointer">
                <div class="px-2">
                    <ChevronDownIcon v-if="!isMetricsShown" class="h-6 w-6 text-gray-500" />
                    <ChevronUpIcon v-if="isMetricsShown" class="h-6 w-6 text-gray-500" />
                </div>
                <div>
                    {{ categoryItem.name }}
                </div>
            </div>
            <div class="px-2 whitespace-nowrap">
                <v-button @click="$emit('onMetricAdd', categoryItem.id)" :color="'info'" title="Добавить показатель" class="mr-2">
                    <template #icon>
                        <PlusIcon class="h-4" />
                    </template>
                </v-button>

                <v-button @click.stop="$emit('onEditCategory', categoryItem.id)" :color="'success'" title="Изменить данные категории" class="mr-2">
                    <template #icon>
                        <PencilSquareIcon class="h-4" />
                    </template>
                </v-button>

                <v-button @click.stop="$emit('onDeleteCategory', categoryItem.id)" :color="'danger'" title="Удалить категорию" :disabled="false">
                    <template #icon>
                        <TrashIcon class="h-4" />
                    </template>
                </v-button>

            </div>
        </div>
        <MetricList v-if="isMetricsShown" :metrics="categoryItem.metrics" @onMetricDelete="$emit('onMetricDelete', $event)"  @onMetricEdit="$emit('onMetricEdit', $event)"/>
    </div>
</template>

<script>
import MetricList from './MetricList.vue'
import { PencilSquareIcon, TrashIcon, ChevronDownIcon, ChevronUpIcon, PlusIcon } from "@heroicons/vue/24/outline"
import VButton from "@/components/v-Button.vue"

export default {
    name: "metric-category-item",
    components: {
        MetricList,
        VButton,
        PencilSquareIcon,
        TrashIcon,
        ChevronDownIcon,
        ChevronUpIcon,
        PlusIcon
    },
    data: () => {
        return {
            isMetricsShown: false
        }
    },
    props: {
        categoryItem: {
            type: Object
        }
    }
}
</script>
