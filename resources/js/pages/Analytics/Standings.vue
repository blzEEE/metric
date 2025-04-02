<template>

    <p class="text-xl font-semibold mb-6">Рейтинг организаций</p>

    <div class="flex items-end justify-between mb-4">
        <div class="flex items-center justify-start mr-4">
            <v-button @click="loadRaiting({year: --filter.year})" :size="'md'" :color="'light'" title="Предыдущий год">
                <template #icon>
                    <ChevronLeftIcon class="h-4" />
                </template>
            </v-button>
            <p class="mx-4 font-semibold w-10 text-center">{{ filter.year }}</p>
            <v-button @click="loadRaiting({year: ++filter.year})" :size="'md'" :color="'light'" title="Следующий год">
                <template #icon>
                    <ChevronRightIcon class="h-4" />
                </template>
            </v-button>
        </div>

        <v-select
            id="category_id"
            v-model="filter.category_id"
            @change="loadRaiting({category: filter.category_id})"
            :required="true"
            :options="metricCategoryOptions"
        />

    </div>

    <v-processing v-if="loading" class="text-indigo-600 h-5 ml-4 mb-1.5"/>

    <div class="grid grid-cols-4 gap-6">
        <div class="col-span-4 bg-gray-100 text-center font-medium">
            Годовые показатели
        </div>

        <table class="w-full">
            <thead>
                <tr>
                    <th colspan="3" class="bg-gray-100 border border-gray-200 font-semibold">Частота катетер-ассоциированных инфекций кровотока</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-amber-300 border border-gray-200">
                    <td class="px-2 font-semibold">1</td>
                    <td class="px-2 font-semibold">КГБУЗ ККБ
                        <v-popover>
                            Многопрофильная клиника, государственная, краевая, коечная мощность > 800 коек, оказывает экстренную помощь
                        </v-popover>
                    </td>
                    <td class="px-2 font-semibold">1%</td>
                </tr>
                <tr class="bg-gray-200 border border-gray-200">
                    <td class="px-2">2</td>
                    <td class="px-2">КГБУЗ КМКБ</td>
                    <td class="px-2">3%</td>
                </tr>
                <tr class="bg-orange-200 border border-gray-200">
                    <td class="px-2" >3</td>
                    <td class="px-2">БСМП</td>
                    <td class="px-2">4%</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="px-2" >4</td>
                    <td class="px-2">Больница #1</td>
                    <td class="px-2">7%</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="px-2" >5</td>
                    <td class="px-2">Больница #2</td>
                    <td class="px-2">9%</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="px-2" >6</td>
                    <td class="px-2">Больница #3</td>
                    <td class="px-2">15%</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="px-2" >7</td>
                    <td class="px-2">Больница #4</td>
                    <td class="px-2">23%</td>
                </tr>
                <tr class="border border-gray-200">
                    <td colspan="3" class="text-center">...</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="px-2" >137</td>
                    <td class="px-2">Больница #5</td>
                    <td class="px-2">57%</td>
                </tr>
            </tbody>
        </table>


        <table class="w-full">
            <thead>
                <tr>
                    <th colspan="3" class="bg-gray-100 border border-gray-200 font-semibold">Частота вентилятор-ассоциированных пневмоний</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-amber-300 border border-gray-200">
                    <td class="px-2">1</td>
                    <td class="px-2">Больница #4</td>
                    <td class="px-2">2%</td>
                </tr>
                <tr class="bg-gray-200 border border-gray-200">
                    <td class="px-2">2</td>
                    <td class="px-2">КГБУЗ КМКБ</td>
                    <td class="px-2">4%</td>
                </tr>
                <tr class="bg-orange-200 border border-gray-200">
                    <td class="px-2" >3</td>
                    <td class="px-2">БСМП</td>
                    <td class="px-2">6%</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="px-2" >4</td>
                    <td class="px-2">Больница #1</td>
                    <td class="px-2">7%</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="px-2" >5</td>
                    <td class="px-2">Больница #2</td>
                    <td class="px-2">8%</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="px-2" >6</td>
                    <td class="px-2">Больница #3</td>
                    <td class="px-2">12%</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="px-2" >7</td>
                    <td class="px-2">Больница #4</td>
                    <td class="px-2">19%</td>
                </tr>
                <tr class="border border-gray-200">
                    <td colspan="3" class="text-center">...</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="px-2 font-semibold">15</td>
                    <td class="px-2 font-semibold">КГБУЗ ККБ</td>
                    <td class="px-2 font-semibold">25%</td>
                </tr>
                <tr class="border border-gray-200">
                    <td colspan="3" class="text-center">...</td>
                </tr>
                <tr class="border border-gray-200">
                    <td class="px-2" >137</td>
                    <td class="px-2">Больница #5</td>
                    <td class="px-2">48%</td>
                </tr>
            </tbody>
        </table>

        <table class="w-full">
            <thead>
            <tr>
                <th colspan="3" class="bg-gray-100 border border-gray-200 font-semibold">Показатель использования антибиотиков</th>
            </tr>
            </thead>
            <tbody>
            <tr class="bg-amber-300 border border-gray-200">
                <td class="px-2 font-semibold">1</td>
                <td class="px-2 font-semibold">КГБУЗ ККБ</td>
                <td class="px-2 font-semibold">98%</td>
            </tr>
            <tr class="bg-gray-200 border border-gray-200">
                <td class="px-2">2</td>
                <td class="px-2">КГБУЗ КМКБ</td>
                <td class="px-2">95%</td>
            </tr>
            <tr class="bg-orange-200 border border-gray-200">
                <td class="px-2" >3</td>
                <td class="px-2">БСМП</td>
                <td class="px-2">92%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >4</td>
                <td class="px-2">Больница #1</td>
                <td class="px-2">88%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >5</td>
                <td class="px-2">Больница #2</td>
                <td class="px-2">73%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >6</td>
                <td class="px-2">Больница #3</td>
                <td class="px-2">62%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >7</td>
                <td class="px-2">Больница #4</td>
                <td class="px-2">15%</td>
            </tr>
            <tr class="border border-gray-200">
                <td colspan="3" class="text-center">...</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >137</td>
                <td class="px-2">Больница #5</td>
                <td class="px-2">10%</td>
            </tr>
            </tbody>
        </table>

        <table class="w-full">
            <thead>
            <tr>
                <th colspan="3" class="bg-gray-100 border border-gray-200 font-semibold">Частота инфекций послеоперационных ран  ИОХВ</th>
            </tr>
            </thead>
            <tbody>
            <tr class="bg-amber-300 border border-gray-200">
                <td class="px-2">1</td>
                <td class="px-2">Больница #4</td>
                <td class="px-2">2%</td>
            </tr>
            <tr class="bg-gray-200 border border-gray-200">
                <td class="px-2">2</td>
                <td class="px-2">КГБУЗ КМКБ</td>
                <td class="px-2">4%</td>
            </tr>
            <tr class="bg-orange-200 border border-gray-200">
                <td class="px-2" >3</td>
                <td class="px-2">БСМП</td>
                <td class="px-2">6%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2 font-semibold">10</td>
                <td class="px-2 font-semibold">КГБУЗ ККБ</td>
                <td class="px-2 font-semibold">25%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >5</td>
                <td class="px-2">Больница #2</td>
                <td class="px-2">8%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >6</td>
                <td class="px-2">Больница #3</td>
                <td class="px-2">12%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >7</td>
                <td class="px-2">Больница #4</td>
                <td class="px-2">19%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >137</td>
                <td class="px-2">Больница #5</td>
                <td class="px-2">48%</td>
            </tr>
            </tbody>
        </table>


        <div class="col-span-4 bg-gray-100 text-center font-medium py-1.5">
            Квартальные показатели
        </div>

        <div class="col-span-4 bg-gray-100 text-center py-1.5">
            <span class="px-8 text-indigo-700">I квартал&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <span class="px-8 text-indigo-700">II квартал&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <span class="px-8 font-medium">III квартал&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <span class="px-8 text-indigo-700">IV квартал</span>
        </div>


        <table class="w-full">
            <thead>
            <tr>
                <th colspan="3" class="bg-gray-100 border border-gray-200 font-semibold">Частота катетер-ассоциированных инфекций кровотока</th>
            </tr>
            </thead>
            <tbody>
            <tr class="bg-amber-300 border border-gray-200">
                <td class="px-2 font-semibold">1</td>
                <td class="px-2 font-semibold">КГБУЗ ККБ
                    <v-popover>
                        Многопрофильная клиника, государственная, краевая, коечная мощность > 800 коек, оказывает экстренную помощь
                    </v-popover>
                </td>
                <td class="px-2 font-semibold">1%</td>
            </tr>
            <tr class="bg-gray-200 border border-gray-200">
                <td class="px-2">2</td>
                <td class="px-2">КГБУЗ КМКБ</td>
                <td class="px-2">3%</td>
            </tr>
            <tr class="bg-orange-200 border border-gray-200">
                <td class="px-2" >3</td>
                <td class="px-2">БСМП</td>
                <td class="px-2">4%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >4</td>
                <td class="px-2">Больница #1</td>
                <td class="px-2">7%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >5</td>
                <td class="px-2">Больница #2</td>
                <td class="px-2">9%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >6</td>
                <td class="px-2">Больница #3</td>
                <td class="px-2">15%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >7</td>
                <td class="px-2">Больница #4</td>
                <td class="px-2">23%</td>
            </tr>
            <tr class="border border-gray-200">
                <td colspan="3" class="text-center">...</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >137</td>
                <td class="px-2">Больница #5</td>
                <td class="px-2">57%</td>
            </tr>
            </tbody>
        </table>


        <table class="w-full">
            <thead>
            <tr>
                <th colspan="3" class="bg-gray-100 border border-gray-200 font-semibold">Частота вентилятор-ассоциированных пневмоний</th>
            </tr>
            </thead>
            <tbody>
            <tr class="bg-amber-300 border border-gray-200">
                <td class="px-2">1</td>
                <td class="px-2">Больница #4</td>
                <td class="px-2">2%</td>
            </tr>
            <tr class="bg-gray-200 border border-gray-200">
                <td class="px-2">2</td>
                <td class="px-2">КГБУЗ КМКБ</td>
                <td class="px-2">4%</td>
            </tr>
            <tr class="bg-orange-200 border border-gray-200">
                <td class="px-2" >3</td>
                <td class="px-2">БСМП</td>
                <td class="px-2">6%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >4</td>
                <td class="px-2">Больница #1</td>
                <td class="px-2">7%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >5</td>
                <td class="px-2">Больница #2</td>
                <td class="px-2">8%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >6</td>
                <td class="px-2">Больница #3</td>
                <td class="px-2">12%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >7</td>
                <td class="px-2">Больница #4</td>
                <td class="px-2">19%</td>
            </tr>
            <tr class="border border-gray-200">
                <td colspan="3" class="text-center">...</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2 font-semibold">15</td>
                <td class="px-2 font-semibold">КГБУЗ ККБ</td>
                <td class="px-2 font-semibold">25%</td>
            </tr>
            <tr class="border border-gray-200">
                <td colspan="3" class="text-center">...</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >137</td>
                <td class="px-2">Больница #5</td>
                <td class="px-2">48%</td>
            </tr>
            </tbody>
        </table>

        <table class="w-full">
            <thead>
            <tr>
                <th colspan="3" class="bg-gray-100 border border-gray-200 font-semibold">Показатель использования антибиотиков</th>
            </tr>
            </thead>
            <tbody>
            <tr class="bg-amber-300 border border-gray-200">
                <td class="px-2 font-semibold">1</td>
                <td class="px-2 font-semibold">КГБУЗ ККБ</td>
                <td class="px-2 font-semibold">98%</td>
            </tr>
            <tr class="bg-gray-200 border border-gray-200">
                <td class="px-2">2</td>
                <td class="px-2">КГБУЗ КМКБ</td>
                <td class="px-2">95%</td>
            </tr>
            <tr class="bg-orange-200 border border-gray-200">
                <td class="px-2" >3</td>
                <td class="px-2">БСМП</td>
                <td class="px-2">92%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >4</td>
                <td class="px-2">Больница #1</td>
                <td class="px-2">88%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >5</td>
                <td class="px-2">Больница #2</td>
                <td class="px-2">73%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >6</td>
                <td class="px-2">Больница #3</td>
                <td class="px-2">62%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >7</td>
                <td class="px-2">Больница #4</td>
                <td class="px-2">15%</td>
            </tr>
            <tr class="border border-gray-200">
                <td colspan="3" class="text-center">...</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >137</td>
                <td class="px-2">Больница #5</td>
                <td class="px-2">10%</td>
            </tr>
            </tbody>
        </table>

        <table class="w-full">
            <thead>
            <tr>
                <th colspan="3" class="bg-gray-100 border border-gray-200 font-semibold">Частота инфекций послеоперационных ран  ИОХВ</th>
            </tr>
            </thead>
            <tbody>
            <tr class="bg-amber-300 border border-gray-200">
                <td class="px-2">1</td>
                <td class="px-2">Больница #4</td>
                <td class="px-2">2%</td>
            </tr>
            <tr class="bg-gray-200 border border-gray-200">
                <td class="px-2">2</td>
                <td class="px-2">КГБУЗ КМКБ</td>
                <td class="px-2">4%</td>
            </tr>
            <tr class="bg-orange-200 border border-gray-200">
                <td class="px-2" >3</td>
                <td class="px-2">БСМП</td>
                <td class="px-2">6%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2 font-semibold">10</td>
                <td class="px-2 font-semibold">КГБУЗ ККБ</td>
                <td class="px-2 font-semibold">25%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >5</td>
                <td class="px-2">Больница #2</td>
                <td class="px-2">8%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >6</td>
                <td class="px-2">Больница #3</td>
                <td class="px-2">12%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >7</td>
                <td class="px-2">Больница #4</td>
                <td class="px-2">19%</td>
            </tr>
            <tr class="border border-gray-200">
                <td class="px-2" >137</td>
                <td class="px-2">Больница #5</td>
                <td class="px-2">48%</td>
            </tr>
            </tbody>
        </table>

<!--
        <div class="col-span-4 bg-gray-100 text-center font-medium py-1.5">
            Ежемесячные показатели
        </div>

        <div class="col-span-4 bg-gray-100 text-center py-1.5">
            <span class="px-8 text-indigo-700">янв&nbsp;</span>
            <span class="px-8 text-indigo-700">фев&nbsp;</span>
            <span class="px-8 font-medium">мар&nbsp;</span>
            <span class="px-8 text-indigo-700">апр&nbsp;</span>
            <span class="px-8 text-indigo-700">май&nbsp;</span>
            <span class="px-8 text-indigo-700">июн&nbsp;</span>
            <span class="px-8 text-indigo-700">июл&nbsp;</span>
            <span class="px-8 text-indigo-700">авг&nbsp;</span>
            <span class="px-8 text-indigo-700">сен&nbsp;</span>
            <span class="px-8 text-indigo-700">окт&nbsp;</span>
            <span class="px-8 text-indigo-700">ноя&nbsp;</span>
            <span class="px-8 text-indigo-700">дек&nbsp;</span>
        </div>
-->
    </div>

</template>

<script>
import VInput from "@/components/v-Input.vue"
import VSelect from "@/components/v-Select.vue"
import VButton from '@/components/v-Button.vue'
import VProcessing from '@/components/v-Processing.vue'
import VPopover from '@/components/v-Popover.vue'
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/24/outline"
import {queryParamsMixin} from '@/helpers'
import { mapActions, mapGetters } from "vuex"

export default {
    name: "Standings",
    components: {
        VInput,
        VSelect,
        VButton,
        VProcessing,
        VPopover,
        ChevronLeftIcon,
        ChevronRightIcon,
    },
    data: () => {
        return {
            filter: {
                year: null,
                quarter: null,
                category_id: null
            },
            loading: false,            
        }
    },
    created() {
        this.setBreadcrumbs(['Аналитика', 'Рейтинг организации'])

        this.loading = true
        this.initFilter()
            .then(() => {
                this.loadRaiting({
                    year: this.filter.year, 
                    quarter: this.filter.quarter, 
                    category: this.filter.category_id
                })
            })
    },
    mixins: [queryParamsMixin],
    methods: {        
        ...mapActions({
            getServerDate: 'date/getServerDate',
            getMetricCategories: 'metricCategories/getMetricCategories',
            setBreadcrumbs: 'breadcrumbs/setBreadcrumbs',
            setAlert: 'alerts/setAlert',            
        }),
        ...mapActions('raiting', ['getRaitingSummary', 'setYear', 'setCategoryId']),

        initFilter() {
            return this.getServerDate()
                .catch(({response}) => {
                    this.setAlert({type: 'danger', message: response.data.message})
                }) 
                .then(()=>{
                    this.getMetricCategories()
                })               
                .finally(() => {
                    
                    this.filter.category_id = this.metricCategoryOptions[0].id

                    if (this.$props.year && !isNaN(this.$props.year) && Math.abs(this.serverDate.getFullYear() - this.$props.year) < 20) { //потом поищем в props
                        this.filter.year = this.$props.year
                    } else if (this.serverDate) { //затем дату с сервера
                        if (this.serverDate.getMonth() === 0) { //в январе показываем по умолчанию предыдущий год
                            this.filter.year = this.serverDate.getFullYear() - 1
                        } else {
                            this.filter.year = this.serverDate.getFullYear()
                        }
                    } else {
                        this.filter.year = (new Date()).getFullYear()
                    }
                })
        },
        loadRaiting(newParams = {}, currentParams = this.$route.query) {
            this.loading = true

            if ('year' in newParams) {
                this.setYear(newParams.year)
            }
            if ('quarter' in newParams) {
                this.setQuarter(newParams.quarter)
            }
            if ('category' in newParams) {
                this.setCategoryId(newParams.category)
            }

            let resultParams = this.setQueryParams(currentParams, newParams)

            this.getRaitingSummary(resultParams)
                .then(() => {
                    this.$router.push({
                        path: window.location.pathname,
                        query: resultParams,
                    })
                })
                .catch(({response}) => {
                    this.setAlert({type: 'danger', message: response.data.message})
                })
                .finally(() => {
                    this.loading = false
                })
        },


        
        
        getQuarterNames() {
            return ["I квартал", "II квартал", "III квартал", "IV квартал"];
        },
    },
    computed: {
        ...mapGetters({
            serverDate: 'date/serverDate',
            metricCategoryOptions: 'metricCategories/metricCategoryOptions',
            //summaryYear: 'summary/year',
        }),
    }
}
</script>

<style scoped>

</style>
