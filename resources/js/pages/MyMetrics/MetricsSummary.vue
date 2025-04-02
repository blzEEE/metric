<template>
    <router-view :callbackQuery="currentQuery" @onCloseDocument="closeDocument" />

    <div class="flex justify-start items-center mb-6">
        <p class="text-xl font-semibold">Мои показатели</p>
        <v-processing v-if="loading" class="text-indigo-500 h-5 ml-4"/>
    </div>

    <div class="flex items-end justify-start mb-4">
        <div class="flex items-center justify-start">
            <v-button @click="loadSummary({year: --filter.years.current}, $route.query)"
                      :disabled="filter?.years?.current <= filter?.years?.min"
                      :size="'md'"
                      :color="'light'"
                      :title="filter?.years?.current > filter?.years?.min ? 'Предыдущий год' : ''">
                <template #icon>
                    <ChevronLeftIcon class="h-4" />
                </template>
            </v-button>
            <p class="mx-4 font-semibold w-10 text-center">{{ filter?.years?.current ?? '...' }}</p>
            <v-button @click="loadSummary({year: ++filter.years.current}, $route.query)"
                      :disabled="filter?.years?.current >= filter?.years?.max"
                      :size="'md'"
                      :color="'light'"
                      :title="filter?.years?.current < filter?.years?.max ? 'Следующий год' : ''">
                <template #icon>
                    <ChevronRightIcon class="h-4" />
                </template>
            </v-button>

        </div>

        <div v-if="user.company_id === null && filter?.company_id !== null" class="ml-4 grow">
            <v-select
                id="company_id"
                v-model="filter.company_id"
                :options = "filter?.companies ?? []"
                @change="loadSummary({ company_id: filter.company_id }, $route.query)"
            />
        </div>

    </div>

    <v-skeleton-list v-if="!Object.keys(summary ?? {}).length" />

    <div v-if="Object.keys(summary ?? {}).length">
        <div class="relative overflow-x-auto w-full w-full border border-gray-300/75 rounded shadow-sm">
            <table class="min-w-full text-left text-sm">
                <thead class="border-collapse px-2 py-0.5 text-center font-normal">
                    <tr class="border-collapse">
                        <th :rowspan="Object.keys(summary.available_periods ?? {}).length + (!(summary?.available_periods ?? []).includes('year') ? 1 : 0)" class="border-collapse py-0.5 min-w-[300px] font-semibold">
                            Категория показателей
                        </th>
                        <th colspan="12" class="border-collapse py-0.5 w-[60%] h-6 border-l border-b border-gray-300/75 font-semibold">
                            {{ summary.year }}
                        </th>
                    </tr>
                    <tr v-if="(summary?.available_periods ?? []).includes('quarter')" class="border-collapse">
                        <th v-for="quarterNum in 4"
                            colspan="3"
                            class="border-collapse px-2 py-0.5 w-[15%] border-l border-b border-gray-300/75 font-semibold whitespace-nowrap">
                            {{ getQuarterNames()[quarterNum - 1] }}
                        </th>
                    </tr>
                    <tr v-if="(summary?.available_periods ?? []).includes('month')" class="border-collapse">
                        <th v-for="monthNum in 12"
                            class="border-collapse px-2 py-0.5 w-[5%] border-l border-b border-gray-300/75 font-semibold">
                            {{ (new Date(1, monthNum - 1, 1)).toLocaleString('ru', { month: 'long' }).substr(0, 3) }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="metric_category in summary.metric_categories">
                        <tr class="border border-gray-400/75">
                            <td :rowspan="Object.keys(metric_category.documents).length + 1"
                                class="border-collapse px-2 py-0.5 text-left border-t border-gray-400/75">
                                {{ metric_category.name }}
                            </td>
                        </tr>
                        <tr v-if="'year' in metric_category.documents" class="border-b border-gray-300/75">
                            <td colspan="12"
                                class="border-collapse py-0.5 h-7 border-l border-gray-300/75"
                                :class="getBackgroundClasses(metric_category.documents.year)"
                                :title="getTitle(metric_category.documents.year, summary.year, null, null)"
                                @click="metric_category.documents.year ? (metric_category.documents.year?.id ? edit(metric_category.documents.year?.id) : (metric_category.documents.year?.ready ? add(metric_category.id, 1, summary.year, null, null) : null)) : null">
                                <component :is="getIconComponent(metric_category.documents.year)" class="h-6 m-auto" :class="getIconClasses(metric_category.documents.year)" />
                            </td>
                        </tr>
                        <tr v-if="'quarter' in metric_category.documents" class="border-b border-gray-300/75">
                            <td v-for="quarterNum in 4"
                                colspan="3"
                                class="border-collapse py-0.5 h-7 border-l border-gray-300/75"
                                :class="getBackgroundClasses(metric_category.documents.quarter[quarterNum])"
                                :title="getTitle(metric_category.documents.quarter[quarterNum], summary.year, quarterNum, null)"
                                @click="metric_category.documents.quarter[quarterNum] ? (metric_category.documents.quarter[quarterNum]?.id ? edit(metric_category.documents.quarter[quarterNum]?.id) : (metric_category.documents.quarter[quarterNum]?.ready ? add(metric_category.id, 2, summary.year, quarterNum, null) : null)) : null">
                                <component :is="getIconComponent(metric_category.documents.quarter[quarterNum])" class="h-6 m-auto" :class="getIconClasses(metric_category.documents.quarter[quarterNum])" />
                            </td>
                        </tr>
                        <tr v-if="'month' in metric_category.documents">
                            <td v-for="monthNum in 12"
                                class="border-collapse py-0.5 h-7 border-l border-gray-300/75"
                                :class="getBackgroundClasses(metric_category.documents.month[monthNum])"
                                :title="getTitle(metric_category.documents.month[monthNum], summary.year, Math.ceil(monthNum / 3), monthNum)"
                                @click="metric_category.documents.month[monthNum] ? (metric_category.documents.month[monthNum]?.id ? edit(metric_category.documents.month[monthNum]?.id) : (metric_category.documents.month[monthNum]?.ready ? add(metric_category.id, 3, summary.year, Math.ceil(monthNum / 3), monthNum) : null)) : null">
                                <component :is="getIconComponent(metric_category.documents.month[monthNum])" class="h-6 m-auto" :class="getIconClasses(metric_category.documents.month[monthNum])" />
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="flex mt-4">
            <div class="flex flex-col mr-4">
                <div class="flex justify-start text-sm mb-2">
                    <DocumentCheckIcon class="h-6 text-lime-600/75" />&nbsp;&ndash;&nbsp;показатели утверждены
                </div>
                <div class="flex justify-start mb-0.5 text-sm">
                    <DocumentTextIcon class="h-6 text-amber-500/75" />&nbsp;&ndash;&nbsp;заполнен черновик
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex justify-start text-sm mb-2">
                    <DocumentPlusIcon class="h-6 text-orange-600/75" />&nbsp;&ndash;&nbsp;показатели еще не заполнены
                </div>
                <div class="flex justify-start text-sm">
                    <ClockIcon class="h-6 text-gray-400/50" />&nbsp;&ndash;&nbsp;ввод будет доступен позже
                </div>
            </div>
        </div>

    </div>

</template>

<script>
import {queryParamsMixin} from '@/helpers'
import { mapActions, mapGetters } from "vuex"
import VInput from "@/components/v-Input.vue"
import VButton from '@/components/v-Button.vue'
import VSelect from '@/components/v-Select.vue'
import VProcessing from '@/components/v-Processing.vue'
import VSkeletonList from '@/components/v-SkeletonList.vue'
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/24/outline"
import { DocumentCheckIcon, DocumentTextIcon, DocumentPlusIcon, ClockIcon } from "@heroicons/vue/24/solid"

export default {
    name: "MetricsSummary",
    components: {
        VInput,
        VButton,
        VSelect,
        VProcessing,
        VSkeletonList,
        ChevronLeftIcon,
        ChevronRightIcon,
        DocumentCheckIcon,
        DocumentTextIcon,
        DocumentPlusIcon,
        ClockIcon
    },
    data: () => {
        return {
            loading: false,
            currentQuery: {}
        }
    },
    props: {
        year: {
            type: Number
        },
        company_id: {
            type: Number
        }
    },
    created() {
        this.setBreadcrumbs(['Мои показатели'])
        this.loading = true

        this.initFilter()
            .then(() => {
                let newParams = {
                    year: this.filter.years.current
                }

                if (this.filter.company_id && this.user.company_id === null) {
                    newParams.company_id = this.filter.company_id
                }

                if (this.$route.name === 'my-metrics') {
                    this.currentQuery = this.$route.query
                }

                this.loadSummary(newParams)
            })
    },
    mixins: [queryParamsMixin],
    methods: {
        ...mapActions({
            getFilter: 'summary/getFilter',
            getSummary: 'summary/getSummary',
            setCurrentYear: 'summary/setCurrentYear',
            setBreadcrumbs: 'breadcrumbs/setBreadcrumbs',
            setAlert: 'alerts/setAlert'
        }),
        initFilter() {
            if (!Object.keys(this.filter).length) {

                let filterParams = {}

                if (this.$props.year) {
                    filterParams.year = this.$props.year
                }

                if (this.$props.company_id && this.user.company_id === null) {
                    filterParams.company_id = this.$props.company_id
                }

                return this.getFilter(filterParams)
                    .catch(({response}) => {
                        this.setAlert({type: 'danger', message: response.data.message})
                        this.loading = false
                    })
            } else {
                return new Promise((resolve, reject) => { resolve() });
            }
        },
        loadSummary(newParams = {}, currentParams = {}) {

            this.loading = true

            let queryParams = this.setQueryParams(currentParams, newParams)

            if (this.$route.name === 'my-metrics') {
                this.$router.push({
                    path: window.location.pathname,
                    query: queryParams,
                })
            }

            return this.getSummary(queryParams)
                .catch(({response}) => {
                    this.setAlert({type: 'danger', message: response.data.message})
                })
                .finally(() => {
                    this.loading = false
                })
        },
        closeDocument({year, company_id}) {
            this.filter.years.current = Number(year)

            if (company_id && this.user.company_id === null) {
                this.filter.company_id = Number(company_id)
            }

           this.loadSummary({year, company_id})
        },
        getBackgroundClasses(document) {
            let backgroundClasses = null

            if (!document) {
                backgroundClasses = 'bg-gray-100'
            } else {
                if (document?.id) {
                    backgroundClasses = document?.input_document_status_id === 1 ? 'cursor-pointer hover:bg-amber-100/75' : 'cursor-pointer hover:bg-lime-300/25'
                } else {
                    backgroundClasses = document?.ready ? 'cursor-pointer hover:bg-orange-400/25' : 'bg-gray-100'
                }
            }

            return backgroundClasses
        },
        getIconComponent(document) {
            if (!document) {
                return null
            }

            let icon = null

            if (document?.id) {
                icon = document?.input_document_status_id === 1 ? DocumentTextIcon : DocumentCheckIcon
            } else {
                icon = document?.ready ? DocumentPlusIcon : ClockIcon
            }

            return icon
        },
        getIconClasses(document) {
            if (!document) {
                return null
            }

            let iconClasses = null

            if (document?.id) {
                iconClasses = document?.input_document_status_id === 1 ? 'text-amber-500/75' : 'text-lime-600/75'
            } else {
                iconClasses = document?.ready ? 'text-orange-600/75' : 'text-gray-400/50'
            }

            return iconClasses
        },
        getQuarterNames() {
            return ["I квартал", "II квартал", "III квартал", "IV квартал"];
        },
        getTitle(document, year, quarter = null, month = null) {
            const quarterNames = this.getQuarterNames();

            let period = ''
            if (month !== null) {
                period = (new Date(year, month - 1, 1)).toLocaleString('ru', { month: 'long' }) + ' ' + year + ' года'
            } else if (quarter !== null) {
                period = quarterNames[quarter - 1] + ' ' + year + ' года'
            } else {
                period = year + ' год'
            }

            let title = null

            if (!document) {
                title = 'Ввод показателей за ' + period + ' недоступен'
            } else {
                if (document?.id) {
                    title = document?.input_document_status_id === 1 ? 'Открыть черновик за ' + period : 'Открыть показатели за ' + period
                } else {
                    title = document?.ready ? 'Ввести показатели за ' + period : 'Ввод показателей за ' + period + ' будет доступен c ' + document?.date_ready
                }
            }

            return title
        },
        edit(id) {
            this.currentQuery = this.$route.query

            this.$router.push({
                name: 'my-metrics.edit',
                params: {
                    id: id
                },
                query: {}
            })
        },
        add(metric_category_id, metric_period_id, year, quarter, month) {
            this.currentQuery = this.$route.query

            let addQuery = {
                metric_category_id: metric_category_id,
                metric_period_id: metric_period_id,
                year: year
            }

            if (quarter) {
                addQuery.quarter = quarter
            }

            if (month) {
                addQuery.month = month
            }

            if (!this.user.company_id) {
                addQuery.company_id = this.filter.company_id
            }

            this.$router.push({
                name: 'my-metrics.add',
                params: {},
                query: addQuery
            })
        },
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
            filter: 'summary/filter',
            summary: 'summary/summary',
        }),
    }
}
</script>
