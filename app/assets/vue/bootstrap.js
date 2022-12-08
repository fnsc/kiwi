import { createApp } from "vue";
import mitt from "mitt";
const Vue = createApp({})
const eventHandler = mitt()

import Container from "./components/Cointainer"
import SearchBar from "./components/SearchBar"
import List from "./components/table/List"
import TableHead from "./components/table/TableHead"
import TableRow from "./components/table/TableRow"

Vue.component('container-component', Container)
Vue.component('search-bar-component', SearchBar)
Vue.component('list-component', List)
Vue.component('table-head-component', TableHead)
Vue.component('table-row-component', TableRow)

Vue.provide('eventHandler', eventHandler)
Vue.mount('#app')