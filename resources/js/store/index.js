import { createStore } from 'vuex'
import date from '@/store/modules/_utils/date'
import alerts from '@/store/modules/_utils/alerts'
import breadcrumbs from '@/store/modules/_utils/breadcrumbs'
import auth from '@/store/modules/auth/auth'
import companies from '@/store/modules/settings/companies'
import company from '@/store/modules/settings/company'
import metricCategories from './modules/settings/metricCategories'
import metricCategory from './modules/settings/metricCategory'
import metrics from '@/store/modules/settings/metrics'
import metric from '@/store/modules/settings/metric'
import summary from '@/store/modules/my_metrics/summary'
import document from '@/store/modules/my_metrics/document'
import raiting from '@/store/modules/analytics/raiting'

const store = createStore({
    modules: {
        date,
        alerts,
        breadcrumbs,
        auth,
        companies,
        company,
        metricCategories,
        metricCategory,
        metrics,
        metric,
        summary,
        document,
        raiting
    }
})

export default store
