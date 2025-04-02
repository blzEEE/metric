<template>
    <v-modal :showing="true" @close="close">
        <template #header>
            {{ id ? 'Изменить данные категории' : 'Добавить категорию' }}
        </template>
        <template #body>
            <v-loading v-if="loading"/>

            <v-validation-errors :errors="validationErrors" />
            <form v-if="!loading" id="metric-category-edit-form" @submit.prevent="submit">

                <div class="grid grid-cols-10 gap-4">
                    <div class="col-span-10">
                        <v-input
                            id="name"
                            type="text"
                            v-model="form.name"
                            label="Наименование"
                            :required="true"
                            :error="validationErrors['name']"
                        />
                    </div>
                </div>

            </form>

        </template>
        <template #footer>
            <v-button type="submit" form="metric-category-edit-form" :color="'info'" :disabled="loading" :processing="processing">
                <template #icon>
                    <ArrowDownTrayIcon class="h-4" />
                </template>
                {{ id ? 'Сохранить изменения' : 'Добавить категорию' }}
            </v-button>
            <v-button type="button" @click="close" :color="'light'" class="ml-2">Отмена</v-button>
        </template>
    </v-modal>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import VModal from '@/components/v-Modal.vue'
import VValidationErrors from '@/components/v-ValidationErrors.vue'
import VButton from '@/components/v-Button.vue'
import VInput from '@/components/v-Input.vue'
import VLoading from '@/components/v-Loading.vue'
import { ArrowDownTrayIcon } from '@heroicons/vue/24/outline'


export default {
    name: "MetricCategoryEdit",
    components: {
        VModal,
        VValidationErrors,
        VButton,
        VInput,
        VLoading,
        ArrowDownTrayIcon
    },
    data: () => {
        return{
            loading: false,
            form: {
                id: null,
                name: null
            },
            validationErrors: {},
            processing: false,
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
    created(){
        if (this.$props.id) {
            this.loading = true

            this.getMetricCategory(this.$props.id)
                .then(() => {
                    this.form = this.metricCategory
                })
                .catch((error) => {
                    this.setAlert({type: 'danger', message: 'Ошибка получения данных категории: ' + error.message})
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    methods: {
        ...mapActions({
            setAlert: 'alerts/setAlert',
            getMetricCategory: 'metricCategory/getMetricCategory',
            updateMetricCategory: 'metricCategory/updateMetricCategory',
            storeMetricCategory: 'metricCategory/storeMetricCategory',
        }),
        close() {
            this.$router.push({
                path: '/admin/metrics',
                query: this.$props.callbackQuery
            })
        },

        submit() {
            if (this.form.id) {
                this.update()
            } else {
                this.store()
            }
        },

        store(){
            this.processing = true

            this.storeMetricCategory(this.form)
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

            this.updateMetricCategory(this.form)
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
    },
    computed: {
        ...mapGetters({
            metricCategory: 'metricCategory/metricCategory',
        })
    }
}

</script>
