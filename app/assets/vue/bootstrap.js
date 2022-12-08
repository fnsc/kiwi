import { createApp } from "vue";
const Vue = createApp({})

import Container from "./components/Cointainer"
import List from "./components/table/List"
import Row from "./components/table/TableRow"

Vue.component('container-component', Container)
Vue.component('list-component', List)
Vue.component('table-row-component', Row)

Vue.mount('#app')