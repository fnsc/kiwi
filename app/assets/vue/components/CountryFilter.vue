<template>
  <div class="col-md-3 col-sm-12">
    <select class="form-select" aria-label="Filter by Country" v-model="state.selectedCountry" @change="dispatchCountryFilter">
      <option selected value="">Open country filter</option>
      <option v-for="country in state.countries" :key="Math.random()" :value="country.name" v-text="country.name"></option>
    </select>
  </div>
</template>
<script>
  import {reactive} from "vue";
  import {inject} from "vue";

  export default {
    props: ['filters'],
    setup(props) {
      const eventHandler = inject('eventHandler')
      const state = reactive({
        countries: props.filters.countries,
        selectedCountry: ''
      })

      function dispatchCountryFilter () {
        eventHandler.emit('filter-by-country', state.selectedCountry)
      }

      return {
        state,
        dispatchCountryFilter,
      }
    }
  }
</script>