import { createWebHistory, createRouter } from 'vue-router'
import store from '@/store'

/* Guest Component */
const Login = () => import('@/pages/Auth/Login.vue')
const ForgotPassword = () => import('@/pages/Auth/ForgotPassword.vue')
const ResetPassword = () => import('@/pages/Auth/ResetPassword.vue')
/* Guest Component */

/* Authenticated Component */
//My metrics
const MetricsSummary = () => import('@/pages/MyMetrics/MetricsSummary.vue')
const InputDocument = () => import('@/pages/MyMetrics/InputDocument.vue')

// Analytics
const Standings = () => import('@/pages/Analytics/Standings.vue')

// Settings
const Companies = () => import('@/pages/Admin/Companies/Companies.vue')
const CompanyEdit = () => import('@/pages/Admin/Companies/CompanyEdit.vue')
const Metrics = () => import('@/pages/Admin/Metrics/Metrics.vue')
const MetricCategoryEdit = () => import('@/pages/Admin/Metrics/MetricCategoryEdit.vue')
const MetricEdit = () => import('@/pages/Admin/Metrics/MetricEdit.vue')


const Dummy = () => import('@/pages/Dummy.vue')
/* Authenticated Component */


const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login,
        props: route => ({
            email: route.query.email
        }),
        meta: {
            layout: 'guest-layout',
            middleware: 'guest',
            title: `Войти в систему`
        }
    },
    {
        name: 'forgot-password',
        path: '/forgot-password',
        component: ForgotPassword,
        props: route => ({
            email: route.query.email
        }),
        meta: {
            layout: 'guest-layout',
            middleware: 'guest',
            title: `Забыли пароль`
        }
    },
    {
        name: 'reset-password',
        path: '/reset-password/:token',
        component: ResetPassword,
        props: route => ({
            email: route.query.email,
            token: route.params.token
        }),
        meta: {
            layout: 'guest-layout',
            middleware: 'guest',
            title: `Изменить пароль`
        }
    },
    {
        name: 'my-metrics',
        path: '/my-metrics',
        component: MetricsSummary,
        props: route => ({
            year: Number(route.query.year),
            company_id: route.query.company_id ? Number(route.query.company_id) : null
        }),
        meta: {
            layout: 'authenticated-layout',
            middleware: 'auth',
            title: `Мои показатели`
        },
        children: [
            {
                name: 'my-metrics.add',
                path: 'add',
                component: InputDocument,
                props: route => ({
                    metric_category_id: Number(route.query.metric_category_id),
                    metric_period_id: Number(route.query.metric_period_id),
                    year: Number(route.query.year),
                    quarter: route.query.quarter ? Number(route.query.quarter) : null,
                    month: route.query.month ? Number(route.query.month) : null,
                    company_id: route.query.company_id ? Number(route.query.company_id) : null,
                }),
                meta: {
                    title: `Редактирование показателей`
                }
            },
            {
                name: 'my-metrics.edit',
                path: ':id/edit',
                component: InputDocument,
                props: route => ({
                    id: Number(route.params.id)
                }),
                meta: {
                    title: `Редактирование показателей`
                }
            },
        ]
    },
    {
        name: 'analytics',
        path: '/analytics',
        meta: {
            layout: 'authenticated-layout',
            middleware: 'auth',
            title: `Аналитика`
        },
        children: [
            {
                name: 'analytics.raiting',
                path: 'raiting',
                component: Standings,
                props: route => ({

                }),
                meta: {
                    title: `Рейтинг организации`
                }
            },
            {
                name: 'analytics.indicator',
                path: 'indicator',
                component: Standings,
               /*  props: route => ({
                    id: Number(route.params.id)
                }), */
                meta: {
                    title: `Динамика показателей`
                }
            },
        ]
    },
    {
        name: 'admin',
        path: '/admin',
        meta: {
            layout: 'authenticated-layout',
            middleware: 'auth'
        },
        children: [
            {
                name: 'admin.companies',
                path: 'companies',
                component: Companies,
                meta: {
                    title: `Организации`
                },
                children: [
                    {
                        name: 'admin.companies.add',
                        path: 'add',
                        component: CompanyEdit,
                        meta: {
                            title: `Добавление организации`
                        }
                    },
                    {
                        name: 'admin.companies.edit',
                        path: ':id/edit',
                        component: CompanyEdit,
                        props: route => ({
                            id: Number(route.params.id)
                        }),
                        meta: {
                            title: `Редактирование организации`
                        }
                    },
                ],

            },
            {
                name: 'admin.metrics',
                path: '/admin/metrics',
                component: Metrics,
                meta: {
                    title: `Показатели`
                },
                children: [
                    {
                        name: 'admin.metricCategory.add',
                        path: 'metric-categories/add',
                        component: MetricCategoryEdit,
                        meta: {
                            title: `Добавление категории`
                        }
                    },
                    {
                        name: 'admin.metricCategory.edit',
                        path: 'metric-categories/:id/edit',
                        component: MetricCategoryEdit,
                        props: route => ({
                            id: Number(route.params.id)
                        }),
                        meta: {
                            title: `Редактирование категории`
                        }
                    },
                    {
                        name: 'admin.metric.add',
                        path: 'metric-categories/:metric_category_id/metrics/add',
                        component: MetricEdit,
                        props: route => ({
                            metric_category_id: Number(route.params.metric_category_id)
                        }),
                        meta: {
                            title: `Добавление показателя`
                        }
                    },
                    {
                        name: 'admin.metric.edit',
                        path: 'metric-categories/:metric_category_id/metrics/:metric_id/edit',
                        component: MetricEdit,
                        props: route => ({
                            metric_category_id: Number(route.params.metric_category_id),
                            metric_id: Number(route.params.metric_id)
                        }),
                        meta: {
                            title: `Редактирование показателя`
                        }

                    }
                ],
            }
        ]
    },
    {
        name: 'settings',
        path: '/settings',
        meta: {
            layout: 'authenticated-layout',
            middleware: 'auth'
        },
        children: [
            {
                name: 'settings.company',
                path: 'company',
                component: Dummy,
                meta: {
                    title: `Моя организация`
                },
            },
            {
                name: 'settings.users',
                path: '/settings/users',
                component: Dummy,
                meta: {
                    title: `Пользователи`
                },
                children: [
                    {
                        name: 'settings.users.add',
                        path: 'users/add',
                        component: Dummy,
                        meta: {
                            title: `Пригласить пользователя`
                        }
                    },
                    {
                        name: 'settings.users.edit',
                        path: 'users/:id/edit',
                        component: Dummy,
                        props: route => ({
                            id: Number(route.params.id)
                        }),
                        meta: {
                            title: `Изменить данные пользователя`
                        }
                    }
                ],
            }
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: Dummy,
        meta: {
            layout: 'authenticated-layout',
            middleware: 'auth',
            title: `Страница не найдена`
        }
    }
]

const router = createRouter({
    history: createWebHistory('/'),
    routes,
})

router.beforeEach((to, from, next) => {

    if (store.state.auth.authenticated && to.path === '/') {
        next({ name: 'my-metrics' })
    } else {
        document.title = to.meta.title

        if (to.meta.middleware == 'guest') {
            if (store.state.auth.authenticated) {
                next({ name: 'my-metrics' })
            }
            next()
        } else {
            if (store.state.auth.authenticated) {
                next()
            } else {
                next({ name: 'login' })
            }
        }
    }
})

export default router
