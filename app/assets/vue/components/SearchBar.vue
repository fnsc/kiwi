<template>
  <div class="row mt-5 mb-5">
    <div class="offset-md-3 col-md-6 col-sm-12">
      <form class="d-flex" role="search" @submit.prevent="fetch">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" v-model="state.searchTerm">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</template>
<script>
import {reactive} from "vue";
import {inject} from "vue";

export default {
  setup() {
    const eventHandler = inject('eventHandler')
    const state = reactive({
      searchTerm: ''
    })

    function fetch() {
      eventHandler.emit('search', state.searchTerm)

      state.searchTerm = ''
    }

    return {
      state,
      fetch
    }
  }
}
</script>