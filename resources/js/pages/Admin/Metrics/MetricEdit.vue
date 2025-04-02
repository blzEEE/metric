<template>
    <v-modal :showing="true" @close="close" size="md">
        <template #header>
            {{ metric_id ? 'Редактировать показатель' : 'Добавить показатель' }}
        </template>
        <template #body>
            <v-loading v-if="loading"/>

            <v-validation-errors :errors="validationErrors" />
            <div v-if="hasDocuments" class="border-l-4 rounded-md px-4 py-2 mb-4 bg-indigo-100 text-indigo-900 border-indigo-500">
                <div class="font-medium">Показатель нельзя редактировать, так как существуют документы с данным показателем</div>
            </div>
            <form v-if="!loading" id="metric-edit-form" @submit.prevent="submit">
                <div class="grid grid-cols-10 gap-4">
                    <div class="col-span-10">
                        <v-input
                            id="metric.name"
                            type="text"
                            v-model="formMetric.name"
                            label="Наименование"
                            :required="true"
                            :error="validationErrors['name']"
                            :disabled="hasDocuments"
                        />
                    </div> 

                    <div class="col-span-10">
                        <v-textarea
                            id="description"
                            v-model="formMetric.description"
                            label="Описание"
                            :required="false"
                            :error="validationErrors['description']"
                            :useWYSIWYG="true"
                        />
                    </div>

                    <div class="col-span-5">
                        <v-select
                            id="metric_target_order_id"
                            v-model="formMetric.metric_target_order_id"
                            label="Целевое значение"
                            :required="true"
                            :error="validationErrors['metric_target_order_id']"
                            :options = "metricTargetOrders"
                            :disabled="hasDocuments"
                        />
                    </div>

                    <div class="col-span-5">
                        <v-input
                            id="metric_unit_name"
                            type="text"
                            v-model="formMetric.metric_unit.name"
                            label="Единица измерения"
                            :required="true"
                            :error="validationErrors['metric_unit.name']"
                            :disabled="hasDocuments"
                        />
                    </div>

                    <div class="col-span-10">
                        <v-select
                            id="metric_period_id"
                            v-model="formMetric.metric_period_id"
                            label="Периодичность"
                            :required="true"
                            :error="validationErrors['metric_period_id']"
                            :options = "metricPeriods"
                            :disabled="hasDocuments"
                        />
                    </div>

                    <div class="col-span-5 my-auto">
                        <p class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                            Дата начала сбора показателя
                            <span class="text-red-500" title="Поле обязательно для заполнения"> *</span>
                        </p>
                    </div>

                    <div class="col-span-10">
                        <div class="flex gap-4">
                            <v-select
                                id="dateBegin.partYear"
                                v-model="dateBegin.partYear"
                                label="Год"
                                :error="validationErrors['date_begin']"
                                :showErrorText="false"
                                :options="yearsList"
                                :hasEmptyValue="true"
                                :disabled="hasDocuments"
                            />
                            <v-select
                                id="dateBegin.partQuarter"
                                v-model="dateBegin.partQuarter"
                                v-show="formMetric.metric_period_id >= 2"
                                @change="dateBegin.partMonth = NaN"
                                label="Квартал"
                                :error="validationErrors['date_begin']"
                                :showErrorText="false"
                                :options="quartersList"
                                :hasEmptyValue="true"
                                :disabled="hasDocuments"
                            />
                            <v-select
                                id="dateBegin.partMonth"
                                v-model="dateBegin.partMonth"
                                v-show="formMetric.metric_period_id == 3"
                                label="Месяц"
                                :error="validationErrors['date_begin']"
                                :showErrorText="false"
                                :options="monthsList(dateBegin.partQuarter)"
                                :hasEmptyValue="true"
                                :disabled="hasDocuments"
                            />
                        </div>



                        <div v-if="validationErrors['date_begin']" class="text-xs text-red-600">
                            {{ validationErrors['date_begin'][0] }}
                        </div>
                    </div>

                    <div class="col-span-10 my-auto">
                        <p class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                            Дата окончания сбора показателя (по указанный период)
                        </p>
                    </div>

                    <div class="col-span-10">
                        <div class="flex gap-4">
                            <v-select
                                id="dateEnd.partYear"
                                v-model="dateEnd.partYear"
                                label="Год"
                                :error="validationErrors['date_end']"
                                :showErrorText="false"
                                :options="yearsList"
                                :hasEmptyValue="true"
                            />
                            <v-select
                                id="dateEnd.partQuarter"
                                v-model="dateEnd.partQuarter"
                                @change="dateEnd.partMonth = NaN"
                                v-show="formMetric.metric_period_id >= 2"
                                label="Квартал"
                                :error="validationErrors['date_end']"
                                :showErrorText="false"
                                :options="quartersList"
                                :hasEmptyValue="true"
                            />
                            <v-select
                                id="dateEnd.partMonth"
                                v-model="dateEnd.partMonth"
                                v-show="formMetric.metric_period_id == 3"
                                label="Месяц"
                                :error="validationErrors['date_end']"
                                :showErrorText="false"
                                :options="monthsList(dateEnd.partQuarter)"
                                :hasEmptyValue="true"
                            />
                        </div>

                        <div v-if="validationErrors['date_end']" class="text-xs text-red-600">
                            {{ validationErrors['date_end'][0] }}
                        </div>
                    </div>

                    <div class="col-span-10 border border-gray-300 rounded-mdm run ">
                        <div class="flex justify-between items-center py-1 px-2.5 text-sm font-medium bg-gray-200 rounded-t-md">
                            Данные для расчета
                            <v-button :disabled="hasDocuments || formMetric.metric_calc_data.length >= 5" type="button" @click="addField" :color="'info'" title="Добавить">
                                <template #icon>
                                    <PlusIcon class="h-4" />
                                </template>
                            </v-button>
                        </div>
                        <div v-for="(metricCalcData, index) in formMetric.metric_calc_data" :key="index" class="flex flex-col col-span-10 py-1 px-2.5">
                            <div class="flex gap-4 items-end">


                                <div class="w-4">
                                    {{ metricCalcData.var_name }}.
                                </div>

                                <v-input
                                    id="metric_calc_data.name"
                                    type="text"
                                    v-model="metricCalcData.name"
                                    label="Наименование"
                                    :required="true"
                                    :error="validationErrors[`metric_calc_data.${index}.name`]"
                                    :showErrorText="false"
                                    :disabled="hasDocuments"
                                />

                                <div>
                                    <v-button :disabled="hasDocuments" type="button" @click="deleteField(index)" :color="'danger'" class="w-fit" title="Удалить">
                                        <template #icon>
                                            <TrashIcon class="h-4" />
                                        </template>
                                    </v-button>
                                </div>

                            </div>
                        </div>

                        <div class="col-span-10 py-1 px-2.5">
                            <v-input
                                id="formula"
                                type="text"
                                v-model="formMetric.formula"
                                label="Формула для расчета"
                                :required="false"
                                :error="validationErrors['formula']"
                                :disabled="hasDocuments"
                            />
                        </div>
                    </div>

                </div>
            </form>

        </template>
        <template #footer>
            <v-button type="submit" form="metric-edit-form" :color="'info'" :disabled="loading" :processing="processing" title="Сохранить изменения">
                <template #icon>
                    <ArrowDownTrayIcon class="h-4" />
                </template>
                {{ metric_id ? 'Сохранить изменения' : 'Добавить показатель' }}
            </v-button>
            <v-button type="button" @click="close" :color="'light'" class="ml-2" title="Отмена">Отмена</v-button>
        </template>
    </v-modal>
</template>

<script>
import moment from "moment";
import {mapActions, mapGetters} from 'vuex'
import VModal from '@/components/v-Modal.vue'
import VValidationErrors from '@/components/v-ValidationErrors.vue'
import VButton from '@/components/v-Button.vue'
import VInput from '@/components/v-Input.vue'
import VTextarea from '@/components/v-Textarea.vue'
import VSelect from '@/components/v-Select.vue'
import VLoading from '@/components/v-Loading.vue'
import { ArrowDownTrayIcon, PlusIcon, TrashIcon } from "@heroicons/vue/24/outline"

export default {
    name: 'metric-edit',
    components: {
        VModal,
        VButton,
        ArrowDownTrayIcon,
        VValidationErrors,
        VLoading,
        VInput,
        VSelect,
        VTextarea,
        PlusIcon,
        TrashIcon
    },
    props: {
        metric_id:{
            type: Number,
            default: null
        },
        metric_category_id:{
            type: Number,
            default: null
        },
        callbackQuery: {
            type: Object,
            default: {}
        }
    },
    data: () => {
        return {
            loading: false,
            formMetric: {
                id: null,
                name: null,
                description: null,
                formula: null,
                date_begin: null,
                date_end: null,
                metric_category_id: null,
                metric_unit: {id: null, name: null},
                metric_period_id: null,
                metric_target_order_id: null,
                metric_calc_data: [{
                    id: null,
                    name: null,
                    var_name: 'a',
                    metric_id: null
                }]
            },
            dateBegin: {
                partYear: null,
                partQuarter: null,
                partMonth: null
            },
            dateEnd: {
                partYear: null,
                partQuarter: null,
                partMonth: null
            },
            hide:{},
            hasDocuments: false,
            validationErrors: {},
            processing: false,
            arr_en: ['a', 'b', 'c', 'd', 'e'],
            moment: moment,
        }
    },
    methods: {
        ...mapActions({
            getServerDate: 'date/getServerDate',
            setAlert: 'alerts/setAlert',
            getMetric: 'metric/getMetric',
            getMetricPeriods: 'metric/getMetricPeriods',
            getMetricTargetOrders: 'metric/getMetricTargetOrders',
            getMetricUnit: 'metric/getMetricUnit',
            storeMetric: 'metric/storeMetric',
            updateMetric: 'metric/updateMetric'
        }),
        addField(){
            this.formMetric.metric_calc_data.push({
                    id: null,
                    name: null,
                    var_name: this.arr_en[this.formMetric.metric_calc_data.length],
                    metric_id: this.$props.metric_id ? this.$props.metric_id : null
                })
        },
        deleteField(index){
            this.formMetric.metric_calc_data.splice(index, 1)

            for (let i = 0; i < this.formMetric.metric_calc_data.length; i++) {
                this.formMetric.metric_calc_data[i].var_name = this.arr_en[i]
            }
        } ,
        formulaValidation(formula){
            formula = formula.replaceAll(' ', '')
            formula = formula.replaceAll('+', '')
            formula = formula.replaceAll('-', '')
            formula = formula.replaceAll('*', '')
            formula = formula.replaceAll('/', '')
            formula = formula.replaceAll('(', '')
            formula = formula.replaceAll(')', '')
            formula = formula.replaceAll(/\d/g, '')

            for (let i = 0; i < this.formMetric.metric_calc_data.length; i++) {
                if(!formula.includes(this.formMetric.metric_calc_data[i].var_name)){
                    return false
                }
                formula = formula.replaceAll(this.formMetric.metric_calc_data[i].var_name, '')
            }

            if(formula === ''){
                return true
            }
            return false
        },
        close() {
            this.$router.push({
                path: '/admin/metrics',
                query: this.$props.callbackQuery
            })
        },
        submit(){
            if(this.formMetric.metric_period_id == 1){
                this.formMetric.date_begin = this.dateBegin.partYear ? moment(new Date(this.dateBegin.partYear, 0, 1, 0)).format("YYYY-MM-DD") : null
                this.formMetric.date_end = this.dateEnd.partYear ? moment(new Date(this.dateEnd.partYear, 0, 1, 0)).format("YYYY-MM-DD") : null
            }else if(this.formMetric.metric_period_id == 2){
                this.formMetric.date_begin = this.dateBegin.partYear && this.dateBegin.partQuarter ? moment(new Date(this.dateBegin.partYear, (this.dateBegin.partQuarter - 1) * 3, 1, 0)).format("YYYY-MM-DD") : null
                this.formMetric.date_end = this.dateEnd.partYear && this.dateEnd.partQuarter ? moment(new Date(this.dateEnd.partYear, (this.dateEnd.partQuarter - 1) * 3, 1, 0)).format("YYYY-MM-DD") : null
            }else if(this.formMetric.metric_period_id == 3){
                this.formMetric.date_begin = this.dateBegin.partYear && this.dateBegin.partMonth ? moment(new Date(this.dateBegin.partYear, this.dateBegin.partMonth - 1, 1, 0)).format("YYYY-MM-DD") : null
                this.formMetric.date_end = this.dateEnd.partYear && this.dateEnd.partMonth ? moment(new Date(this.dateEnd.partYear, this.dateEnd.partMonth - 1, 1, 0)).format("YYYY-MM-DD") : null
            }

            if (this.$props.metric_id) {
                this.update()
            } else {
                this.store()
            }

        },
        store(){
            this.processing = true
            this.storeMetric(this.formMetric)
                .then(() => {
                    this.validationErrors = {}
                    this.$emit('onSubmit', this.$props.callbackQuery)
                    this.close()
                })
                .catch(({response}) => {
                    if (response.status === 422) {
                        this.validationErrors = response.data.errors
                    } else {
                        this.setAlert({type: 'danger', message: response.data.message})
                    }
                })
                .finally(() => {
                    this.processing = false
                })
        },
        update(){
            this.processing = true
            this.updateMetric(this.formMetric)
                .then(() => {
                    this.validationErrors = {}
                    this.$emit('onSubmit', this.$props.callbackQuery)
                    this.close()
                })
                .catch(({response}) => {
                    if (response.status === 422) {
                        this.validationErrors = response.data.errors
                    } else {
                        this.setAlert({type: 'danger', message: response.data.message})
                    }
                })
                .finally(() => {
                    this.processing = false
                })
        }
    },
    created(){
        this.loading = true
        Promise.all([
            this.$props.metric_id ? this.getMetric(this.$props.metric_id) : null,
            this.getMetricPeriods(),
            this.getServerDate(),
            this.getMetricTargetOrders(),
            ])
            .then(() => {
                if (this.$props.metric_id) {
                    this.formMetric = this.metric
                    this.hasDocuments = this.metric.input_document_value_count > 0
                    this.dateBegin.partYear = this.metric.date_begin ? (new Date(this.metric.date_begin)).getFullYear() : null
                    if(this.formMetric.metric_period_id >= 2){
                        this.dateBegin.partQuarter = this.formMetric.date_begin ? Math.ceil(((new Date(this.formMetric.date_begin)).getMonth() + 1) / 3) : null
                    }
                    if(this.formMetric.metric_period_id == 3){
                        this.dateBegin.partMonth = this.formMetric.date_begin ? (new Date(this.metric.date_begin)).getMonth() + 1 : null
                    }

                    this.dateEnd.partYear = this.metric.date_end ? (new Date(this.metric.date_end)).getFullYear() : null
                    if(this.formMetric.metric_period_id >= 2){
                        this.dateEnd.partQuarter = this.formMetric.date_end ? Math.ceil(((new Date(this.formMetric.date_end)).getMonth() + 1) / 3) : null
                    }
                    if(this.formMetric.metric_period_id == 3){
                        this.dateEnd.partMonth = this.formMetric.date_end ? (new Date(this.metric.date_end)).getMonth() + 1 : null
                    }

                }
                this.formMetric.metric_category_id = this.$props.metric_category_id

            })
            .catch((error) => {
                this.setAlert({type: 'danger', message: 'Ошибка получения данных: ' + error.message})
            })
            .finally(() => {
                this.loading = false
            })
    },
    computed: {
        ...mapGetters({
            serverDate: 'date/serverDate',
            metric: 'metric/metric',
            metricPeriods: 'metric/metricPeriods',
            metricTargetOrders: 'metric/metricTargetOrders',
            metricUnit: 'metric/metricUnit'
        }),
        yearsList() {
            let years = []

            for(let i = 2021; i <= this.serverDate.getFullYear() + 1; i++) {
                years.push({id: i, name: i})
            }

            return years;
        },
        quartersList() {
            return [
                { id: 1, name: "I квартал" },
                { id: 2, name: "II квартал" },
                { id: 3, name: "III квартал" },
                { id: 4, name: "IV квартал" },
            ]
        },
        monthsList() {
            return (quarter) => {
                let months = []

                for(let i = (quarter - 1) * 3 + 1; i <= quarter * 3; i++) {
                    months.push({id: i, name: (new Date(1, i - 1, 1)).toLocaleString('ru', { month: 'short' })})
                }

                return months
            }
        }
    }
}
</script>
