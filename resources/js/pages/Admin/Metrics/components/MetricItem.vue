<template>
    <div @click="$emit('onMetricEdit', {metric_id: metricItem.id, metric_category_id: metricItem.metric_category_id})" class="flex justify-between items-center py-1 px-2 rounded-md gap-4"
        :class="[isExpired ? 'bg-rose-200' : '']">
        <div class="flex justify-between items-center grow gap-4">       
            
            <div class="whitespace-nowrap flex justify-end text-xs">
                <span class="rounded-full w-6 py-0.5 text-center" :class="periodClasses">
                    {{ metricItem.metric_period.name[0] }}
                </span>
            </div>    

            <div class="grow">
                {{ metricItem.name }} {{ isExpired ? '(Истек срок показателя)' : '' }}
            </div>
            
            <div class="whitespace-nowrap flex justify-end gap-2 text-xs rounded-md bg-gray-200/75 border border-gray-300 py-0.5 px-1.5">
                <span class="w-14 text-center">
                    {{ dateBegin }}
                </span>
                &ndash;
                <span class="w-14 text-center" v-html="dateEnd" /> 
            </div>  

        </div>

        <div class="whitespace-nowrap">
            <v-button @click.stop="$emit('onMetricEdit', {metric_id: metricItem.id, metric_category_id: metricItem.metric_category_id})" :color="'success'" title="Изменить показатель" class="mr-2">
                <template #icon>
                    <PencilSquareIcon class="h-4" />
                </template>
            </v-button>

            <v-button @click.stop="$emit('onMetricDelete', metricItem.id)" :color="'danger'" title="Удалить показатель" :disabled="false">
                <template #icon>
                    <TrashIcon class="h-4" />
                </template>
            </v-button>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
import VButton from "@/components/v-Button.vue"
import { PencilSquareIcon, TrashIcon } from "@heroicons/vue/24/outline"
export default {
    name: 'metric-item',
    components: {
        VButton,
        PencilSquareIcon,
        TrashIcon,
    },
    props: {
        metricItem: {
            type: Object
        }
    },
    methods: {
        getQuarterNames() {
            return ["I кв.", "II кв.", "III кв.", "IV кв."];
        },
        getMonthNames(){
            return ["янв.", "фев.", "мар.", "апр.", "май.", "июн.", "июл.", "авг.", "сен.", "окт.", "ноя.", "дек."];
        },
        getPeriodView(period_system_name, date) {
            const quarterNames = this.getQuarterNames()
            const monthNames = this.getMonthNames()

            let periodView = ''
            if(!date){
                return '&infin;'
            }
            switch(period_system_name) {
                case 'year': periodView = moment(date).format("YYYY") + ' год'
                    break
                case 'quarter': periodView = quarterNames[Math.ceil(((new Date(date)).getMonth() + 1) / 3) - 1] + ' ' + moment(date).format("YYYY")
                    break
                case 'month': periodView = monthNames[(new Date(moment(date).format("MM"))).getMonth()] + ' ' + moment(date).format("YYYY")
                    break
            }

            return periodView

        },
    },
    computed:{
        dateBegin() {
            let period = this.getPeriodView(this.metricItem.metric_period.system_name, this.metricItem.date_begin)
            return period
            // return moment(this.metricItem.date_begin).format("DD.MM.YYYY")
        },
        dateEnd() {
            let period = this.getPeriodView(this.metricItem.metric_period.system_name, this.metricItem.date_end)
            return period
            // return this.metricItem.date_end ? moment(this.metricItem.date_end).format("DD.MM.YYYY") : '&infin;'
        },
        isExpired(){
            if(!this.metricItem.date_end){
                return false
            }
            let date_end = new Date(this.metricItem.date_end)
            let year = date_end.getFullYear()
            let month = date_end.getMonth()
            if(this.metricItem.metric_period_id === 1){
                year = year + 1
            } else if(this.metricItem.metric_period_id === 2){
                month = month + 3
            } else if(this.metricItem.metric_period_id === 3){
                month = month + 1
            }
            return moment(new Date(year, month)) <= moment(new Date())
        },
        periodClasses() {

            let periodClasses = ''

            switch(this.metricItem.metric_period.system_name) {
                case 'year': periodClasses = 'bg-lime-300 border border-lime-600/50'
                    break
                case 'quarter': periodClasses = 'bg-amber-300 border border-amber-600/50'
                    break
                case 'month': periodClasses = 'bg-orange-300 border border-orange-600/50'
                    break
            }

            return periodClasses
        },
    }
}
</script>
