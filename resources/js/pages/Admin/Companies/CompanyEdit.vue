<template>
    <v-modal :showing="true" @close="close">
        <template #header>
            {{ id ? 'Изменить данные организации' : 'Добавить организацию' }}
        </template>
        <template #body>

            <v-loading v-if="loading"/>

            <v-validation-errors :errors="validationErrors" />
            <form v-if="!loading" id="company-edit-form" @submit.prevent="submit">

                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-7">
                        <v-select
                            id="region_id"
                            v-model="form.region_id"
                            label="Регион"
                            :required="true"
                            :error="validationErrors['region_id']"
                            :options = "regions"
                        />
                    </div>

                    <div class="col-span-5">
                        <v-input
                            id="city"
                            type="text"
                            v-model="form.city"
                            label="Город"
                            :required="true"
                            :error="validationErrors['city']"
                        />
                    </div>

                    <div class="col-span-12">
                        <v-input
                            id="name"
                            type="text"
                            v-model="form.name"
                            label="Наименование"
                            :required="true"
                            :error="validationErrors['name']"
                        />
                    </div>

                    <div class="col-span-12">
                        <v-input
                            id="short_name"
                            type="text"
                            v-model="form.short_name"
                            label="Сокращенное наименование"
                            :required="true"
                            :error="validationErrors['short_name']"
                        />
                    </div>

                    <div class="col-span-12">
                        <v-input
                            id="address"
                            type="text"
                            v-model="form.address"
                            label="Адрес"
                            :error="validationErrors['address']"
                        />
                    </div>

                    <div class="col-span-5">
                        <v-input
                            id="director_position"
                            type="text"
                            v-model="form.director_position"
                            label="Должность руководителя"
                            :error="validationErrors['director_position']"
                            :showErrorText="false"
                        />
                    </div>

                    <div class="col-span-7">
                        <v-input
                            id="director_name"
                            type="text"
                            v-model="form.director_name"
                            label="Ф.И.О. руководителя"
                            :error="validationErrors['director_name']"
                        />
                    </div>

                    <div class="col-span-12">
                        <v-select
                            id="company_type_id"
                            v-model="form.company_type_id"
                            label="Вид организации"
                            :required="id ? true : false"
                            :error="validationErrors['company_type_id']"
                            :options = "companyTypes"
                            :hasEmptyValue="true"
                        />
                    </div>

                    <div class="col-span-6">
                        <v-select
                            id="company_ownership_id"
                            v-model="form.company_ownership_id"
                            label="Форма юридического лица"
                            :required="id ? true : false"
                            :error="validationErrors['company_ownership_id']"
                            :options = "companyOwnerships"
                            :hasEmptyValue="true"
                        />
                    </div>

                    <div class="col-span-6">
                        <v-select
                            id="company_level_id"
                            v-model="form.company_level_id"
                            label="Территориальный признак"
                            :required="form.company_ownership_id === 1"
                            :error="validationErrors['company_level_id']"
                            :options = "companyLevels"
                            :disabled="form.company_ownership_id !== 1"
                            :hasEmptyValue="true"
                        />
                    </div>

                    <div class="col-span-6">
                        <v-select
                            id="company_bed_capacity_id"
                            v-model="form.company_bed_capacity_id"
                            label="Число коек"
                            :required="id ? true : false"
                            :error="validationErrors['company_bed_capacity_id']"
                            :options = "companyBedCapacities"
                            :hasEmptyValue="true"
                        />
                    </div>

                    <div class="col-span-6">
                        <v-select
                            id="is_emergency"
                            v-model="form.is_emergency"
                            label="Оказывает экстренную помощь"
                            :required="id ? true : false"
                            :error="validationErrors['is_emergency']"
                            :options = "[{id: 1, name: 'Да'}, {id: 0, name: 'Нет'}]"
                            :hasEmptyValue="true"
                        />
                    </div>

                    <div class="col-span-12">
                        <p class="block mb-1 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Начальные отчетные периоды сбора показателей:
                        </p>
                    </div>

                    <div class="col-span-3 my-auto">
                        <p class="block mb-1 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Годовые
                            <span class="text-red-500" title="Поле обязательно для заполнения"> *</span>
                        </p>
                    </div>

                    <div class="col-span-9">
                        <v-select
                            id="datesBegin.years"
                            v-model="datesBegin.years"
                            :required="true"
                            :error="validationErrors['date_begin_year']"
                            :options="yearsList"
                            :hasEmptyValue="true"
                        />
                    </div>

                    <div class="col-span-3 my-auto">
                        <p class="block mb-1 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Квартальные
                            <span class="text-red-500" title="Поле обязательно для заполнения"> *</span>
                        </p>
                    </div>

                    <div class="col-span-9">
                        <div class="grid grid-cols-2 gap-4">
                            <v-select
                                id="datesBegin.quarters.partYear"
                                v-model="datesBegin.quarters.partYear"
                                :required="true"
                                :error="validationErrors['date_begin_quarter']"
                                :showErrorText="false"
                                :options="yearsList"
                                :hasEmptyValue="true"
                            />
                            <v-select
                                id="datesBegin.quarters.partQuarter"
                                v-model="datesBegin.quarters.partQuarter"
                                :required="true"
                                :error="validationErrors['date_begin_quarter']"
                                :showErrorText="false"
                                :options = "quartersList"
                                :hasEmptyValue="true"
                            />
                        </div>

                        <div v-if="validationErrors['date_begin_quarter']" class="text-xs text-red-600">
                            {{ validationErrors['date_begin_quarter'][0] }}
                        </div>
                    </div>

                    <div class="col-span-3 my-auto">
                        <p class="block mb-1 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Ежемесячные
                            <span class="text-red-500" title="Поле обязательно для заполнения"> *</span>
                        </p>
                    </div>

                    <div class="col-span-9">
                        <div class="grid grid-cols-3 gap-4">
                            <v-select
                                id="datesBegin.months.partYear"
                                v-model="datesBegin.months.partYear"
                                :required="true"
                                :error="validationErrors['date_begin_month']"
                                :showErrorText="false"
                                :options="yearsList"
                                :hasEmptyValue="true"
                            />
                            <v-select
                                id="datesBegin.months.partQuarter"
                                v-model="datesBegin.months.partQuarter"
                                @change="datesBegin.months.partMonth = NaN"
                                :required="true"
                                :error="validationErrors['date_begin_month']"
                                :showErrorText="false"
                                :options="quartersList"
                                :hasEmptyValue="true"
                            />
                            <v-select
                                id="datesBegin.months.partMonth"
                                v-model="datesBegin.months.partMonth"
                                :required="true"
                                :error="validationErrors['date_begin_month']"
                                :showErrorText="false"
                                :options="monthsList"
                                :hasEmptyValue="true"
                            />
                        </div>

                        <div v-if="validationErrors['date_begin_month']" class="text-xs text-red-600">
                            {{ validationErrors['date_begin_month'][0] }}
                        </div>
                    </div>
                </div>
            </form>
        </template>

        <template #footer>
            <v-button type="submit" form="company-edit-form" :color="'info'" :disabled="loading" :processing="processing">
                <template #icon>
                    <ArrowDownTrayIcon class="h-4" />
                </template>
                {{ id ? 'Сохранить изменения' : 'Добавить организацию' }}
            </v-button>
            <v-button type="button" @click="close" :color="'light'" class="ml-2">Закрыть</v-button>
        </template>

    </v-modal>
</template>

<script>
import moment from "moment";
import {mapActions, mapGetters} from 'vuex'
import {queryParamsMixin} from '@/helpers'
import VModal from '@/components/v-Modal.vue'
import VValidationErrors from '@/components/v-ValidationErrors.vue'
import VButton from '@/components/v-Button.vue'
import VInput from '@/components/v-Input.vue'
import VSelect from '@/components/v-Select.vue'
import VLoading from '@/components/v-Loading.vue'
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";

export default {
    name: "company-edit",
    components: {
        VModal,
        VValidationErrors,
        VSelect,
        VButton,
        VInput,
        VLoading,
        ArrowDownTrayIcon
    },
    data(){
        return {
            form: {},

            datesBegin: {
                years: null,
                quarters: {
                    partYear: null,
                    partQuarter: null,
                },
                months: {
                    partYear: null,
                    partQuarter: null,
                    partMonth: null
                }
            },
            loading: false,
            processing: false,
            validationErrors: {},
            moment: moment,
        }
    },
    props: {
        id: {
            type: Number,
            default: null
        },
        callbackQuery: {
            type: Object,
            default: {}
        }
    },
    created() {
        this.loading = true

        this.form = {
            id: null,
            region_id: null,
            city: null,
            name: null,
            short_name: null,
            address: null,
            director_position: null,
            director_name: null,
            company_type_id: null,
            company_ownership_id: null,
            company_level_id: null,
            company_bed_capacity_id: null,
            is_emergency: null,
            date_begin_year: null,
            date_begin_quarter: null,
            date_begin_month: null
        }

        Promise.all([
            this.$props.id ? this.getCompany(this.$props.id) : null,
            this.getServerDate(),
            this.getRegions(),
            this.getCompanyTypes(),
            this.getCompanyOwnerships(),
            this.getCompanyLevels(),
            this.getCompanyBedCapacities()])
            .then(() => {
                if (this.$props.id) {
                    this.form = this.company

                    this.datesBegin.years = this.form.date_begin_year ? (new Date(this.form.date_begin_year)).getFullYear() : null

                    this.datesBegin.quarters.partYear = this.form.date_begin_quarter ? (new Date(this.form.date_begin_quarter)).getFullYear() : null
                    this.datesBegin.quarters.partQuarter = this.form.date_begin_quarter ? Math.ceil(((new Date(this.form.date_begin_quarter)).getMonth() + 1) / 3) : null

                    this.datesBegin.months.partYear = this.form.date_begin_month ? (new Date(this.form.date_begin_month)).getFullYear() : null
                    this.datesBegin.months.partQuarter = this.form.date_begin_month ? Math.ceil(((new Date(this.form.date_begin_month)).getMonth() + 1) / 3) : null
                    this.datesBegin.months.partMonth = this.form.date_begin_month ? (new Date(this.form.date_begin_month)).getMonth() + 1 : null
                } else {
                    this.datesBegin.years = this.serverDate.getFullYear()

                    this.datesBegin.quarters.partYear = this.serverDate.getFullYear()
                    this.datesBegin.quarters.partQuarter = 1

                    this.datesBegin.months.partYear = this.serverDate.getFullYear()
                    this.datesBegin.months.partQuarter = 1
                    this.datesBegin.months.partMonth = 1
                }
            })
            .catch((error) => {
                this.setAlert({type: 'danger', message: 'Ошибка получения данных организации: ' + error.message})
            })
            .finally(() => {
                this.loading = false
            })
    },
    mixins: [queryParamsMixin],
    methods: {
        ...mapActions({
            getServerDate: 'date/getServerDate',
            setAlert: 'alerts/setAlert',
            getCompany: 'company/getCompany',
            getRegions: 'company/getRegions',
            getCompanyTypes: 'company/getCompanyTypes',
            getCompanyOwnerships: 'company/getCompanyOwnerships',
            getCompanyLevels: 'company/getCompanyLevels',
            getCompanyBedCapacities: 'company/getCompanyBedCapacities',
            storeCompany: 'company/storeCompany',
            updateCompany: 'company/updateCompany',
        }),
        submit() {

            this.form.date_begin_year = this.datesBegin.years ? moment(new Date(this.datesBegin.years, 0, 1, 0)).format("YYYY-MM-DD") : null
            this.form.date_begin_quarter = this.datesBegin.quarters.partYear && this.datesBegin.quarters.partQuarter ? moment(new Date(this.datesBegin.quarters.partYear, (this.datesBegin.quarters.partQuarter - 1) * 3, 1, 0)).format("YYYY-MM-DD") : null
            this.form.date_begin_month = this.datesBegin.months.partYear && this.datesBegin.months.partMonth ? moment(new Date(this.datesBegin.months.partYear, this.datesBegin.months.partMonth - 1, 1, 0)).format("YYYY-MM-DD") : null

            if (this.form.id) {
                this.update()
            } else {
                this.store()
            }
        },
        store() {
            this.processing = true

            this.storeCompany(this.form)
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
        update() {
            this.processing = true

            this.updateCompany(this.form)
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
        close() {
            this.$router.push({
                path: '/admin/companies',
                query: this.$props.callbackQuery
            })
        }
    },
    computed: {
        ...mapGetters({
            serverDate: 'date/serverDate',
            company: 'company/company',
            regions: 'company/regions',
            companyTypes: 'company/companyTypes',
            companyOwnerships: 'company/companyOwnerships',
            companyLevels: 'company/companyLevels',
            companyBedCapacities: 'company/companyBedCapacities',
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
            let quarter = this.datesBegin.months.partQuarter
            let months = []

            for(let i = (quarter - 1) * 3 + 1; i <= quarter * 3; i++) {
                months.push({id: i, name: (new Date(1, i - 1, 1)).toLocaleString('ru', { month: 'short' })})
            }

            return months
        },
    },
}
</script>
