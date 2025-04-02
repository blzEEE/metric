<template>
    <div class="min-h-screen min-w-[350px] bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <router-link :to="'/'" title="Мониторинг показателей качества и безопасности медицинской деятельности">
                                <v-application-logo class="block h-9 w-auto" />
                            </router-link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-6 sm:-my-px sm:ml-10 sm:flex">
                            <v-nav-link :routeName="'my-metrics'" :active="this.$route.path.startsWith('/my-metrics')">
                                Мои показатели
                            </v-nav-link>

                            <v-dropdown-nav :active="this.$route.path.startsWith('/analytics')">
                                <template #trigger>
                                    Аналитика
                                </template>

                                <template #content>
                                    <v-dropdown-nav-link :routeName="'analytics.raiting'" :active="this.$route.path.startsWith('/analytics/raiting')">
                                        Рейтинг организации
                                    </v-dropdown-nav-link>
                                    <v-dropdown-nav-link :routeName="'analytics.indicator'" :active="this.$route.path.startsWith('/analytics/indicator')">
                                        Динамика показателей
                                    </v-dropdown-nav-link>
                                </template>
                            </v-dropdown-nav>

                            <v-dropdown-nav :active="this.$route.path.startsWith('/settings')">
                                <template #trigger>
                                    Параметры
                                </template>

                                <template #content>
                                    <v-dropdown-nav-link :routeName="'settings.company'" :active="this.$route.path.startsWith('/settings/company')">
                                        Моя организация
                                    </v-dropdown-nav-link>
                                    <v-dropdown-nav-link :routeName="'settings.users'" :active="this.$route.path.startsWith('/settings/users')">
                                        Пользователи
                                    </v-dropdown-nav-link>
                                </template>
                            </v-dropdown-nav>

                            <v-dropdown-nav :active="this.$route.path.startsWith('/admin')" v-if="user.user_role_id === 1">
                                <template #trigger>
                                    Администрирование
                                </template>

                                <template #content>
                                    <v-dropdown-nav-link :routeName="'admin.companies'" :active="this.$route.path.startsWith('/admin/companies')">
                                        Организации
                                    </v-dropdown-nav-link>
                                    <v-dropdown-nav-link :routeName="'admin.metrics'" :active="this.$route.path.startsWith('/admin/metrics')">
                                        Показатели
                                    </v-dropdown-nav-link>
                                </template>
                            </v-dropdown-nav>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <!-- Settings Dropdown -->
                        <div class="ml-3 relative">
                            <v-dropdown align="right" width="48">
                                <template #trigger>
                                    <span>
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            <div class="text-left">
                                                <div class="font-medium text-sm text-gray-800">{{ user.surname }} {{ user.name }}</div>
                                                <div class="font-medium text-sm text-gray-500">{{ user.email }}</div>
                                            </div>
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <v-dropdown-link @click="logout" as="button">
                                        Выйти из системы
                                    </v-dropdown-link>
                                </template>
                            </v-dropdown>
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        Мониторинг показателей
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                class="sm:hidden" >
                <div class="pt-2 pb-3 space-y-1">
                    <v-responsive-nav-link :routeName="'my-metrics'" :active="this.$route.name == 'my-metrics'" @itemClick="showingNavigationDropdown = false">
                        Мои показатели
                    </v-responsive-nav-link>

                    <v-responsive-dropdown-nav :active="this.$route.path.startsWith('/analytics')">
                        <template #trigger>
                            Аналитика
                        </template>

                        <template #content>
                            <v-responsive-dropdown-nav-link :routeName="'analytics.raiting'" :active="this.$route.path.startsWith('/analytics/raiting')" @itemClick="showingNavigationDropdown = false">
                                Рейтинг организаций
                            </v-responsive-dropdown-nav-link>
                            <v-responsive-dropdown-nav-link :routeName="'analytics.indicator'" :active="this.$route.path.startsWith('/analytics/indicator')" @itemClick="showingNavigationDropdown = false">
                                Динамика показателей
                            </v-responsive-dropdown-nav-link>
                        </template>
                    </v-responsive-dropdown-nav>

                    <v-responsive-dropdown-nav :active="this.$route.path.startsWith('/settings')">
                        <template #trigger>
                            Параметры
                        </template>

                        <template #content>
                            <v-responsive-dropdown-nav-link :routeName="'settings.company'" :active="this.$route.path.startsWith('/settings/company')" @itemClick="showingNavigationDropdown = false">
                                Моя организация
                            </v-responsive-dropdown-nav-link>
                            <v-responsive-dropdown-nav-link :routeName="'settings.users'" :active="this.$route.path.startsWith('/settings/users')" @itemClick="showingNavigationDropdown = false">
                                Пользователи
                            </v-responsive-dropdown-nav-link>
                        </template>
                    </v-responsive-dropdown-nav>

                    <v-responsive-dropdown-nav :active="this.$route.path.startsWith('/admin')" v-if="user.user_role_id === 1">
                        <template #trigger>
                            Администрирование
                        </template>

                        <template #content>
                            <v-responsive-dropdown-nav-link :routeName="'admin.companies'" :active="this.$route.path.startsWith('/admin/companies')" @itemClick="showingNavigationDropdown = false">
                                Организации
                            </v-responsive-dropdown-nav-link>
                            <v-responsive-dropdown-nav-link :routeName="'admin.metrics'" :active="this.$route.path.startsWith('/admin/metrics')" @itemClick="showingNavigationDropdown = false">
                                Показатели
                            </v-responsive-dropdown-nav-link>
                        </template>
                    </v-responsive-dropdown-nav>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ user.surname }} {{ user.name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ user.email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <v-responsive-nav-link @click="logout" as="button">
                            Выйти из системы
                        </v-responsive-nav-link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Breadcrumbs-->
        <v-breadcrumbs />

        <!-- Page Content-->
        <main>
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                       <div class="p-6 bg-white border-b border-gray-200">
                           <slot />
                       </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import VApplicationLogo from '@/components/v-ApplicationLogoAlter.vue'
import VNavLink from '@/components/v-NavLink.vue'
import VDropdownNav from '@/components/v-DropdownNav.vue'
import VDropdownNavLink from '@/components/v-DropdownNavLink.vue'
import VDropdown from '@/components/v-Dropdown.vue'
import VDropdownLink from '@/components/v-DropdownLink.vue'
import VResponsiveNavLink from "@/components/v-ResponsiveNavLink.vue"
import VResponsiveDropdownNav from "@/components/v-ResponsiveDropdownNav.vue"
import VResponsiveDropdownNavLink from "@/components/v-ResponsiveDropdownNavLink.vue"
import VBreadcrumbs from "@//components/v-Breadcrumbs.vue";

export default {
    name: "authenticated-layout",
    components: {
        VBreadcrumbs,
        VResponsiveDropdownNavLink,
        VResponsiveDropdownNav,
        VResponsiveNavLink,
        VApplicationLogo,
        VNavLink,
        VDropdownNav,
        VDropdownNavLink,
        VDropdown,
        VDropdownLink
    },
    data() {
        return {
            showingNavigationDropdown: false,
        }
    },
    methods:{
        ...mapActions({
            userLogout: "auth/userLogout"
        }),
        async logout(){
            await this.userLogout()
            location.reload()
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
        })
    }
}
</script>
