<template>
  <div class="row">
    <div class="offset-md-3 col-md-6 col-sm-12">
      <table class="table table-striped">
        <thead>
          <table-head-component></table-head-component>
        </thead>
        <tbody>
          <table-row-component
              v-for="user in state.users"
              :key="user.id"
              :user="user"
          ></table-row-component>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import {reactive} from "vue";
import {inject} from "vue";
import axios from "axios";

export default {
  setup() {
    const eventHandler = inject('eventHandler')
    const state = reactive({
      users: [],
      error: {
        status: false,
        messages: []
      },
    })

    eventHandler.on('search', (term) => {
      fetch(term)
    })

    eventHandler.on('order-by', (order) => {
      orderUsers(order)
    })

    function fetch(term = '') {
      axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
      axios.get(`/api/v1/users?term=${term}`)
      .then((response) => {
        state.users = response.data.users
      })
      .catch((response) => {
        state.error.status = true
        state.error.messages = response.data.errors
      })
    }

    function orderUsers(order = 0) {
      if (order.orientation === 0) {
        state.users.sort((a, b) => {
            if (a.name > b.name) {
              return 1
            }

            if (a.name < b.name) {
              return -1
            }

            return 0
        })

        return
      }

      if (order.orientation === 1) {
        state.users.sort((a, b) => {
            if (a[order.field] > b[order.field]) {
              return 1
            }

            if (a[order.field] < b[order.field]) {
              return -1
            }

            return 0
        })

        return
      }

      state.users.sort((a, b) => {
          if (a[order.field] < b[order.field]) {
            return 1
          }

          if (a[order.field] > b[order.field]) {
            return -1
          }

          return 0
        })
    }

    fetch()

    return {
      state,
    }
  }
}
</script>