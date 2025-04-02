<template>
    <router-view :callbackQuery="currentQuery" @onSubmit="loadMetrics" />

    <div class="flex items-center justify-between mb-4">
        <v-input id="metric-category-search" v-model="searchText" @keyup.enter="search" type="text" placeholder="Найти категорию" class="mr-4 max-w-xl">
            <template #prefix>
                <MagnifyingGlassIcon class="h-6" />
            </template>
            <template #suffix>
                <XMarkIcon v-if="searchText" @click="clearSearch" class="h-6 cursor-pointer" title="Сбросить поиск" />
            </template>
        </v-input>

        <router-link :to="{ name: 'admin.metricCategory.add' }">
            <v-button :size="'md'" :color="'info'" title="Добавить категорию">
                <template #icon>
                    <PlusIcon class="h-4" />
                </template>
                Добавить категорию
            </v-button>
        </router-link>
    </div>


    <MetricCategoryList
        :metricCategories="metricCategories"
        @onEditCategory="editCategory"
        class="relative overflow-x-auto"
        @onMetricEdit="MetricEdit"
        @onMetricAdd="MetricAdd"
        @onMetricDelete="MetricDelete"
        @onDeleteCategory="categoryDelete"
    />

    <v-confirm-dialog ref="confirmDialog" />
</template>

<script>
    import {queryParamsMixin} from '@/helpers'
    import {mapActions, mapGetters} from 'vuex'
    import VInput from '@/components/v-Input.vue'
    import VTable from '@/components/v-Table.vue'
    import VButton from '@/components/v-Button.vue'
    import VConfirmDialog from '@/components/v-ConfirmDialog.vue'
    import MetricCategoryList from './components/MetricCategoryList.vue'
    import { PlusIcon, MagnifyingGlassIcon, XMarkIcon } from '@heroicons/vue/24/outline'

    export default {
        name: "Metrics",
        components: {
            VInput,
            VTable,
            VButton,
            VConfirmDialog,
            PlusIcon,
            MagnifyingGlassIcon,
            XMarkIcon,
            MetricCategoryList
       },
       data: () => {
            return{
                loading: false,
                searchText: '',
               currentQuery: {}
            }
       },
       created(){
            this.setBreadcrumbs(['Администрирование', 'Показатели'])
            this.searchText = this.$route.query?.search
            this.loadMetrics()
       },
       mixins: [queryParamsMixin],
        methods:{
            ...mapActions({
                getMetricCategories: 'metricCategories/getMetricCategories',
                deleteMetricCategory: 'metricCategory/deleteMetricCategory',
                getMetrics: 'metrics/getMetrics',
                setBreadcrumbs: 'breadcrumbs/setBreadcrumbs',
                setAlert: 'alerts/setAlert',
                deleteMetric: 'metric/deleteMetric'
           }),
            categoryDelete(categoryId){
                this.$refs.confirmDialog.show({
                    title: 'Удалить категорию показателей?',
                    message: 'При удалении категории будут удалены все показатели этой категории. Действие удаления необратимо. <br />Вы уверены, что хотите удалить категорию показателей?',
                    okButton: 'Удалить'
                }).then((result) => {
                    if (result) {
                        this.deleteMetricCategory(categoryId)
                        .then(() => {
                            this.setAlert({type: 'success', message: "Категория успешно удалена"})
                        })
                        .catch(({response}) => {
                            this.setAlert({type: 'warning', message: response.data.message})
                        })
                        .finally(() => {
                            this.loadMetrics()
                        })
                    }
                })
            },
            editCategory(id){
                this.currentQuery = this.$route.query

                this.$router.push({
                    name: 'admin.metricCategory.edit',
                    params: {id: id},
                    query: {}
                })
            },

            clearSearch() {
               this.searchText = ''
               this.search()
           },

           search() {
               let newParams = {}
               if (this.searchText) {
                   newParams.search = this.searchText
               }
               this.loadMetrics(newParams, {})
           },

           loadMetrics(newParams = {}, currentParams = this.$route.query) {
                this.loading = true
                let resultParams = this.setQueryParams(currentParams, newParams)
                this.getMetricCategories(resultParams)
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
            MetricDelete(id) {
                this.$refs.confirmDialog.show({
                    title: 'Удалить показатель?',
                    message: 'Действие удаления необратимо. Вы уверены, что хотите удалить показатель?',
                    okButton: 'Удалить'
                }).then((result) => {
                    if (result) {
                        this.deleteMetric(id)
                            .then(() => {
                                this.setAlert({type: 'success', message: "Показатель успешно удален"})
                            })
                            .catch(({response}) => {
                                this.setAlert({type: 'warning', message: response.data.message})
                            })
                            .finally(() => {
                                this.loadMetrics()
                            })
                    }
                })
            },
            MetricAdd(categoryId){
                this.$router.push({
                    name: 'admin.metric.add',
                    params: {metric_category_id: categoryId},
                    query: {}
                })
            },
            MetricEdit({metric_id, metric_category_id}){
                this.$router.push({
                    name: 'admin.metric.edit',
                    params: {metric_id: metric_id, metric_category_id: metric_category_id},
                    query: {}
                })
            }
        },
        computed: {
            ...mapGetters({
                metricCategories: 'metricCategories/metricCategories',
                metrics: 'metrics/metrics',
            }),
        },
    }
</script>
