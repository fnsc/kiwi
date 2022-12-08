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
import axios from "axios";

export default {
  setup() {
    const state = reactive({
      users: [],
      error: {
        status: false,
        messages: []
      },
    })

    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.get('/api/v1/users')
      .then((response) => {
        state.users = response.data.users
      })
      .catch((response) => {
        state.error.status = true
        state.error.messages = response.data.errors
      })

    return {
      state,
    }
  }
}
</script>