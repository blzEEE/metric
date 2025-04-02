<template>
    <v-modal :showing="true" @close="close" :size="'xl'" :footerJustify="'justify-between'">
        <template #header>
            <div class="inline-flex items-center gap-2">
            <span>
                {{ loading ? 'Загрузка...' : getTitle() }}
            </span>
                <span v-if="!loading" v-html="getStatus()" />
            </div>
        </template>
        <template #body>

            <v-validation-errors :errors="validationErrors" />
            <v-skeleton-list v-if="loading" :rowCount="2" :headerCount="1" />

            <form v-if="!loading" id="input-document-edit-form" @submit.prevent="submit(1)">
                <div class="mb-4">
                    <v-select
                        id="metrics_category_id"
                        v-model="form.metric_category_id"
                        label="Категория показателей"
                        :required="true"
                        :options="[form?.metric_category]"
                        :disabled="true"
                    />
                </div>

                <div class="overflow-auto max-h-[32rem]">
                    <div class="relative overflow-x-auto w-full w-full border border-gray-300/75 rounded">
                        <table class="min-w-full text-left text-sm font-normal">
                            <thead class="border-collapse px-2 py-0.5 text-center">
                                <tr class="border-collapse">
                                    <th colspan="2" class="border-b border-b-gray-400/75 font-semibold whitespace-nowrap py-1.5 px-2.5">Показатель</th>
                                    <th colspan="3" class="border-l border-l-gray-300/75 border-b border-b-gray-400/75 font-semibold whitespace-nowrap py-1.5 px-2.5">Данные для расчета</th>
                                    <th class="border-l border-l-gray-300/75 border-b border-b-gray-400/75 font-semibold whitespace-nowrap py-1.5 px-2.5">Значение</th>
                                </tr>
                            </thead>

                            <tbody>
                                <template v-for="(inputDocumentValue, valueIndex)  in form?.input_document_values" :key="valueIndex">
                                    <tr class="border-t border-gray-400/75" :class="[!inputDocumentValue.is_active ? 'text-gray-400 bg-gray-100' : '']">
                                        <td :rowspan="Object.keys(inputDocumentValue?.input_document_value_calc_data).length + 1" class="px-2">
                                            <v-toggle
                                                v-model:checked="inputDocumentValue.is_active"
                                                @change="toggleValue(inputDocumentValue)"
                                                :disabled="form?.input_document_status_id === 2"
                                                :title="form?.input_document_status_id === 2 ? '' : (inputDocumentValue.is_active ? 'Исключить из заполнения (если показатель неприменим, либо отсутствуют данные)' : 'Включить показатель для заполнения')"
                                            />
                                        </td>
                                        <td :rowspan="Object.keys(inputDocumentValue?.input_document_value_calc_data).length + 1"
                                            class="border-collapse px-2 py-0.5 text-left w-[33%]">
                                                <span class="flex-wrap">
                                                    {{ inputDocumentValue?.metric?.name }}
                                                </span>
                                                <sup>
                                                    <span v-if="inputDocumentValue?.metric?.description" class="ml-1 cursor-pointer" @click="showDescription(inputDocumentValue?.metric?.name, inputDocumentValue?.metric?.description)" title="Посмотреть описание показателя">
                                                        <svg class="h-4 inline text-indigo-400 hover:text-indigo-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                </sup>
                                        </td>
                                        <td v-if="Object.keys(inputDocumentValue?.input_document_value_calc_data).length" class="h-0 p-0"></td>
                                        <td v-if="Object.keys(inputDocumentValue?.input_document_value_calc_data).length" class="h-0 p-0"></td>
                                        <td v-if="Object.keys(inputDocumentValue?.input_document_value_calc_data).length" class="h-0 p-0"></td>

                                        <td v-if="!Object.keys(inputDocumentValue?.input_document_value_calc_data).length" class="border-l border-gray-300/75 px-2.5 bg-red-200" colspan="3">
                                            <span class="text-red-500">Нет данных для расчета</span>
                                        </td>

                                        <td :rowspan="Object.keys(inputDocumentValue?.input_document_value_calc_data).length + 1"
                                            class="border-collapse px-2 py-0.5 text-left border-l border-gray-300/75 w-48">
                                            <div class="flex items-center">
                                                <v-input
                                                    id="input_document_value[]"
                                                    type="number"
                                                    v-model="inputDocumentValue.value"
                                                    :error="validationErrors[`input_document_values.${valueIndex}.value`]"
                                                    :showErrorText="false"
                                                    :disabled="true"
                                                />
                                                <span class="ml-4 w-24 overflow-hidden">
                                                    {{ inputDocumentValue?.metric?.metric_unit?.name }}
                                                </span>
                                            </div>

                                            <div class="text-xs font-semibold mt-1"
                                                 :class="[!inputDocumentValue.is_active ? 'text-gray-400' : 'text-gray-700']"
                                                 title="Формула для расчета показателя на основании исходных данных">
                                                {{ inputDocumentValue?.metric?.formula }}
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-for="(calcData, calcDataIndex) in inputDocumentValue?.input_document_value_calc_data" :key="calcDataIndex" :class="[!inputDocumentValue.is_active ? 'text-gray-400 bg-gray-100' : '']">
                                        <td class="border-collapse px-2 py-0.5 text-left border-l border-gray-300/75" :class="[calcDataIndex < inputDocumentValue?.input_document_value_calc_data.length - 1 ? 'border-b' : '']">
                                            <div>
                                                {{ calcData?.metric_calc_data?.name }}
                                            </div>
                                        </td>
                                        <td class="border-collapse px-2 py-0.5 text-left border-l border-gray-300/75" :class="[calcDataIndex < inputDocumentValue?.input_document_value_calc_data.length - 1 ? 'border-b' : '']">
                                            <div title="Имя переменной для расчета значения показателя по формуле">
                                                {{ calcData?.metric_calc_data?.var_name }}
                                            </div>
                                        </td>
                                        <td class="border-collapse px-2 py-0.5 text-left border-l border-gray-300/75" :class="[calcDataIndex < inputDocumentValue?.input_document_value_calc_data.length - 1 ? 'border-b' : '']">
                                            <v-input
                                                id="input_document_value_calc_data[]"
                                                type="number"
                                                v-model="calcData.value"
                                                :error="validationErrors[`input_document_values.${valueIndex}.input_document_value_calc_data.${calcDataIndex}.value`]"
                                                :showErrorText="false"
                                                :disabled="form?.input_document_status_id === 2 || !inputDocumentValue.is_active"
                                                @input="calcValue(inputDocumentValue)"
                                                :autofocus="!form?.id && valueIndex === 0 && calcDataIndex === 0 ? true : false"
                                                class="w-20"
                                            />
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

        </template>
        <template #footer>

            <div class="flex items-end gap-2">
            <span v-if="form.id" class="text-gray-500  text-xs font-medium ">
                создан: {{ moment(form.created_at).format("DD.MM.YYYY") }}, автор: {{ form.user.surname + ' ' + form.user.name + (form.user.secname ? ' ' + form.user.secname : '') }}
            </span>
            </div>

            <div class="flex items-center gap-2">
                <v-button
                    v-if="form?.id && (user.user_role_id === 1 || form?.input_document_status_id === 1)"
                    @click="destroy"
                    :color="'danger'"
                    :processing="deleteProcessing">
                    <template #icon>
                        <TrashIcon class="h-4" />
                    </template>
                    Удалить
                </v-button>
                <v-button
                    v-if="!loading && form?.input_document_status_id !== 2"
                    @click="approve"
                    :color="'success'"
                    :processing="approveProcessing">
                    <template #icon>
                        <CheckIcon class="h-4" />
                    </template>
                    Утвердить показатели
                </v-button>
                <v-button
                    v-if="!loading && form?.input_document_status_id == 2 && user.user_role_id === 1"
                    @click="disapprove"
                    :color="'warning'"
                    :processing="disapproveProcessing">
                    <template #icon>
                        <ArrowPathIcon class="h-4" />
                    </template>
                    Вернуть в работу
                </v-button>
                <v-button
                    v-if="!loading && form?.input_document_status_id !== 2"
                    @click="store"
                    :color="'info'"
                    :disabled="loading || form?.input_document_status_id === 2"
                    :processing="storeProcessing">
                    <template #icon>
                        <ArrowDownTrayIcon class="h-4" />
                    </template>
                    Сохранить черновик
                </v-button>
                <v-button type="button" @click="close" :color="'light'">
                    Закрыть
                </v-button>
            </div>

        </template>
    </v-modal>
    <v-confirm-dialog ref="confirmDialog" />
    <description-show ref="descriptionShow" />
</template>

<script>
import moment from "moment";
import {mapActions, mapGetters} from 'vuex'
import {queryParamsMixin} from '@/helpers'
import VModal from '@/components/v-Modal.vue'
import VConfirmDialog from '@/components/v-ConfirmDialog.vue'
import VValidationErrors from '@/components/v-ValidationErrors.vue'
import VButton from '@/components/v-Button.vue'
import VInput from '@/components/v-Input.vue'
import VSelect from '@/components/v-Select.vue'
import VToggle from '@/components/v-Toggle.vue'
import VSkeletonList from '@/components/v-SkeletonList.vue'
import DescriptionShow from '@/pages/MyMetrics/components/DescriptionShow.vue'
import { ArrowDownTrayIcon, CheckIcon, TrashIcon, ArrowPathIcon } from '@heroicons/vue/24/outline'

export default {
    name: "input-document",
    emits: ["onCloseDocument"],
    components: {
        VModal,
        VConfirmDialog,
        VValidationErrors,
        VButton,
        VInput,
        VSelect,
        VToggle,
        VSkeletonList,
        DescriptionShow,
        ArrowDownTrayIcon,
        CheckIcon,
        TrashIcon,
        ArrowPathIcon
    },
    data(){
        return {
            form: {},
            loading: false,
            storeProcessing: false,
            approveProcessing: false,
            disapproveProcessing: false,
            deleteProcessing: false,
            validationErrors: {},
            moment: moment,
        }
    },
    props: {
        id: {
            type: Number,
            default: null
        },
        metric_category_id: {
            type: Number,
            default: null
        },
        metric_period_id: {
            type: Number,
            default: null
        },
        year: {
            type: Number,
            default: null
        },
        quarter: {
            type: Number,
            default: null
        },
        month: {
            type: Number,
            default: null
        },
        company_id: {
            type: Number,
            default: null
        },
        callbackQuery: {
            type: Object,
            default: {}
        }
    },
    created() {
        this.form = {}
        this.load(this.$props.id)
    },
    mixins: [queryParamsMixin],
    methods: {
        ...mapActions({
            setAlert: 'alerts/setAlert',
            getNewDocumentData: 'document/getNewDocumentData',
            getDocument: 'document/getDocument',
            storeDocument: 'document/storeDocument',
            updateDocument: 'document/updateDocument',
            approveDocument: 'document/approveDocument',
            disapproveDocument: 'document/disapproveDocument',
            deleteDocument: 'document/deleteDocument',
        }),
        load(id) {
            this.loading = true

            return Promise.all([
                !id ?
                    this.getNewDocumentData({
                        metric_category_id: this.$props.metric_category_id,
                        metric_period_id: this.$props.metric_period_id,
                        year: this.$props.year,
                        quarter: this.$props.quarter,
                        month: this.$props.month,
                        company_id: this.user?.company_id ?? this.$props.company_id
                    })
                    : this.getDocument(id)
            ])
                .then(() => {
                    this.form = this.document
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors
                    } else {
                        this.setAlert({type: 'danger', message: 'Ошибка получения данных документа: ' + error.response.data.message})
                    }
                })
                .finally(() => {
                    this.loading = false
                })
        },
        showDescription(name, description) {
            this.$refs.descriptionShow.show({
                title: name,
                message: description,
            })
        },
        getQuarterNames() {
            return ["I квартал", "II квартал", "III квартал", "IV квартал"];
        },
        getTitle() {
            const quarterNames = this.getQuarterNames();
            let title = ''

            if (this.form?.metric_period?.system_name === 'year') {
                title = 'Годовые показатели за ' + this.form?.year + ' год'
            }

            if (this.form?.metric_period?.system_name === 'quarter') {
                title = 'Квартальные показатели за ' + quarterNames[this.form?.quarter - 1] + ' ' + this.form?.year + ' года'
            }

            if (this.form?.metric_period?.system_name === 'month') {
                title = 'Ежемесячные показатели за ' + (new Date(this.form?.year, this.form?.month - 1, 1)).toLocaleString('ru', { month: 'long' }) + ' ' + this.form?.year + ' года'
            }

            return title;
        },
        getStatus() {
            let status = ''

            if (!this.form?.id) {
                status = '<span class="bg-gray-100 text-gray-500 border-gray-300 border text-xs font-medium px-2.5 py-1 rounded-full">создание</span>'
            } else if (this.form?.input_document_status_id === 1) {
                status = '<span class="bg-amber-100 text-amber-800 border-amber-500 border text-xs font-medium px-2.5 py-1 rounded-full">черновик</span>'
            } else if (this.form?.input_document_status_id === 2) {
                status = '<span class="bg-lime-100 text-lime-800 border-lime-500 border text-xs font-medium px-2.5 py-1 rounded-full">утвержден</span>'
            }

            return status;
        },
        toggleValue(inputDocumentValue) {
            for (let calcData of inputDocumentValue?.input_document_value_calc_data) {
                calcData.value = inputDocumentValue.is_active ? (0).toFixed(2) : null
            }
            inputDocumentValue.value = inputDocumentValue.is_active ? (0).toFixed(2) : null
        },
        calcValue(inputDocumentValue) {
            //Соберем в объект данные для расчета в виде имя_переменной:значение {a: 1, b: 2}
            let calcDataObject = {}

            for (let calcData of inputDocumentValue?.input_document_value_calc_data) {
                calcDataObject[calcData.metric_calc_data.var_name] = Number(String(calcData.value).replace(',', '.'))
            }

            let formula = String(inputDocumentValue.metric.formula).replaceAll(' ', '')

            for(let var_name in calcDataObject) {
                formula = formula.replaceAll(var_name, calcDataObject[var_name])
            }

            let calcResult = eval(formula)

            inputDocumentValue.value = (isFinite(calcResult) ? Math.trunc(calcResult * 100)/100 : 0).toFixed(2)
        },
        approve() {
            this.$refs.confirmDialog.show({
                title: 'Утвердить показатели?',
                message: 'Изменить значения показателей после утверждения будет невозможно. <br />Вы уверены, что хотите утвердить показатели?',
                okButton: 'Утвердить'
            }).then((result) => {
                if (result) {
                    this.approveProcessing = true

                    this.save()
                        .then(() => {
                            this.approveDocument(this.document.id)
                                .then(() => {
                                    this.close()
                                })
                                .catch(({response}) => {
                                    this.validationErrors = {}
                                    if (response.status === 422) {
                                        this.validationErrors = response.data.errors
                                    } else {
                                        this.setAlert({type: 'danger', message: response.data.message})
                                    }
                                })
                        })
                        .catch((error) => {
                            if (error.response.status === 422) {
                                this.validationErrors = error.response.data.errors
                            } else {
                                this.setAlert({type: 'danger', message: error.response.data.message})
                            }
                        })
                        .finally(() => {
                            this.approveProcessing = false
                        })
                }
            })
        },
        disapprove() {
            this.$refs.confirmDialog.show({
                title: 'Вернуть в работу?',
                message: 'После возврата значения показателей снова станут доступны для редактирования. <br />Вы уверены, что ходите вернуть в работу?',
                okButton: 'Вернуть в работу'
            }).then((result) => {
                if (result) {
                    this.disapproveProcessing = true

                    this.disapproveDocument(this.form.id)
                    .then(() => {
                        this.load(this.form.id)
                    })
                    .catch(({response}) => {
                        this.setAlert({type: 'danger', message: response.data.message})
                    })
                    .finally(() => {
                        this.disapproveProcessing = false
                    })
                }
            })
        },
        save() {
            return (this.form.id ? this.updateDocument(this.form) : this.storeDocument(this.form))
                .catch((error) => {
                    throw error
                })
        },
        store() {
            this.storeProcessing = true

            return this.save()
                .then(() => {
                    this.close()
                })
                .catch((error) => {
                    this.validationErrors = {}
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors
                    } else {
                        this.setAlert({type: 'danger', message: error.response.data.message})
                    }
                })
                .finally(() => {
                    this.storeProcessing = false
                })
        },
        destroy() {
            this.$refs.confirmDialog.show({
                title: 'Удалить показатели?',
                message: 'Отменить удаление будет невозможно. <br />Вы уверены, что хотите удалить введенные показатели?',
                okButton: 'Удалить'
            }).then((result) => {
                if (result) {
                    this.deleteProcessing = true

                    this.deleteDocument(this.form.id)
                        .then(() => {
                            this.validationErrors = {}
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
                            this.deleteProcessing = false
                        })
                }
            })
        },
        close() {
            let resultParams = this.$props.callbackQuery

            if (!Object.keys(resultParams).length) {
                resultParams.year = Number(this.form.year)
                if (this.user.company_id === null) {
                    resultParams.company_id = Number(this.form.company_id)
                }
            }

            this.$emit('onCloseDocument', resultParams)

            return this.$router.push({
                path: '/my-metrics',
                query: resultParams
            })
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
            document: 'document/document'
        })
    },
}
</script>
