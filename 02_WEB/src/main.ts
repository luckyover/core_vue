import { createApp } from 'vue'
import { createPinia } from 'pinia'
import BootstrapVue from 'bootstrap-vue-next'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@/assets/css/bootstrap.min.css'
import '@/assets/css/fontawesome.min.css'
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css'
import '@vuepic/vue-datepicker/dist/main.css'

import App from './App.vue'
import router from './router'

import AnsInput from '@/components/ans/AnsInput.vue'
import AnsSelect from '@/components/ans/AnsSelect.vue'
import AnsCheckbox from '@/components/ans/AnsCheckbox.vue'
import AnsRadioButton from '@/components/ans/AnsRadioButton.vue'
import AnsSwitch from '@/components/ans/AnsSwitch.vue'
import AnsInputSearch from '@/components/ans/AnsInputSearch.vue'
import AnsDatePicker from '@/components/ans/AnsDatePicker.vue'
import AnsTimePicker from '@/components/ans/AnsTimePicker.vue'
import AnsPaging from '@/components/ans/AnsPaging.vue'
import Panel from '@/components/Panel.vue'
import ActionHistory from '@/components/ActionHistory.vue'
import AnsEmptyRow from '@/components/ans/AnsEmptyRow.vue'
import AnsTooltipSpan from '@/components/ans/AnsTooltipSpan.vue'
import AnsTwoScrollDiv from '@/components/ans/AnsTwoScrollDiv.vue'
import AnsSortColumn from '@/components/ans/AnsSortColumn.vue'
import AnsTable from '@/components/ans/AnsTable.vue'
import AnsDateRanger from '@/components/ans/AnsDateRanger.vue'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(BootstrapVue)

app.component('VueDatePicker', VueDatePicker)
app.component('AnsInput', AnsInput)
app.component('AnsSelect', AnsSelect)
app.component('AnsCheckbox', AnsCheckbox)
app.component('AnsRadioButton', AnsRadioButton)
app.component('AnsSwitch', AnsSwitch)
app.component('AnsInputSearch', AnsInputSearch)
app.component('AnsDatePicker', AnsDatePicker)
app.component('AnsTimePicker', AnsTimePicker)
app.component('AnsPaging', AnsPaging)
app.component('Panel', Panel)
app.component('ActionHistory', ActionHistory)
app.component('AnsEmptyRow', AnsEmptyRow)
app.component('AnsTooltipSpan', AnsTooltipSpan)
app.component('AnsTwoScrollDiv', AnsTwoScrollDiv)
app.component('AnsSortColumn', AnsSortColumn)
app.component('AnsTable', AnsTable)
app.component('AnsDateRanger', AnsDateRanger)

app.mount('#app')
