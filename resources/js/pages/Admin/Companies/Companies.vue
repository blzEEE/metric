<template>
    <router-view :callbackQuery="currentQuery" @onSubmit="loadCompanies" />

    <div class="flex items-center justify-between mb-4">
        <v-input id="companies-search" v-model="searchText" @keyup.enter="search" type="text" placeholder="Найти организацию" class="mr-4 max-w-xl">
            <template #prefix>
                <MagnifyingGlassIcon class="h-6" />
            </template>
            <template #suffix>
                <XMarkIcon v-if="searchText" @click="clearSearch" class="h-6 cursor-pointer" title="Сбросить поиск" />
            </template>
        </v-input>

        <router-link :to="{name: 'admin.companies.add', params: {id: null}}">
            <v-button :size="'md'" :color="'info'" title="Добавить организацию">
                <template #icon>
                    <PlusIcon class="h-4" />
                </template>
                Добавить организацию
            </v-button>
        </router-link>
    </div>

    <v-table :header="tableHeader" :data="companies" @rowClick="editCompany">

        <template v-slot:actions="rowItem">

            <v-button @click.stop="editCompany(rowItem)" :color="'success'" title="Изменить данные организации" class="mr-2">
                <template #icon>
                    <PencilSquareIcon class="h-4" />
                </template>
            </v-button>

           <v-button @click.stop="deleteCompany(rowItem)" :color="'danger'" title="Удалить организацию" :disabled="true">
               <template #icon>
                   <TrashIcon class="h-4" />
               </template>
           </v-button>

        </template>

    </v-table>

    <v-pagination @paginate="loadCompanies" :links="links" class="justify-end" />

</template>

<script>
   import {queryParamsMixin} from '@/helpers'
   import {mapActions, mapGetters} from 'vuex'
   import VInput from "@/components/v-Input.vue"
   import VTable from '@/components/v-Table.vue'
   import VPagination from "@/components/v-Pagination.vue"
   import VButton from "@/components/v-Button.vue"
   import { PlusIcon, PencilSquareIcon, TrashIcon, MagnifyingGlassIcon, XMarkIcon } from "@heroicons/vue/24/outline"

   export default {
       name: "Companies",
       components: {
           VInput,
           VTable,
           VPagination,
           VButton,
           PlusIcon,
           PencilSquareIcon,
           TrashIcon,
           MagnifyingGlassIcon,
           XMarkIcon
       },
       data: () => {
           return {
               loading: false,
               searchText: '',
               tableHeader: {
                   "id": {
                       title: "#",
                       dataClasses: "whitespace-nowrap"
                   },
                   "region.name": "Регион",
                   "city": {
                       title: "Город",
                       dataClasses: "whitespace-nowrap"
                   },
                   "name": "Наименование",
                   "address": "Адрес",
                   "users_count": {
                       title: "Пользователи",
                       dataClasses: "whitespace-nowrap text-center"
                   }
               },
               currentQuery: {}
           }
       },
       created() {
           this.setBreadcrumbs(['Администрировние', 'Организации'])
           this.searchText = this.$route.query?.search
           this.loadCompanies()
       },
       mixins: [queryParamsMixin],
       methods: {
           ...mapActions({
               getCompanies: 'companies/getCompanies',
               setBreadcrumbs: 'breadcrumbs/setBreadcrumbs',
               setAlert: 'alerts/setAlert'
           }),
           clearSearch() {
               this.searchText = ''
               this.search()
           },
           search() {
               let newParams = {}
               if (this.searchText) {
                   newParams.search = this.searchText
               }
               this.loadCompanies(newParams, {})
           },
           loadCompanies(newParams = {}, currentParams = this.$route.query) {

               this.loading = true

               let resultParams = this.setQueryParams(currentParams, newParams)

               this.getCompanies(resultParams)
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
           editCompany(item) {
               this.currentQuery = this.$route.query

               this.$router.push({
                   name: 'admin.companies.edit',
                   params: {id: item?.data?.id},
                   query: {}
               })
           },
           deleteCompany(item) {
               console.log('delete', item)
           },
       },
       computed: {
           ...mapGetters({
               companies: 'companies/companies',
               links: 'companies/links',
           }),
       },
   }
</script>
