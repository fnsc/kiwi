import { createApp } from "vue";
const Vue = createApp({})

import Container from "./components/Cointainer"

Vue.component('container-component', Container)

Vue.mount('#app')