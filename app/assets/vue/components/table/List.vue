<template>
  <div class="row">
    <div class="offset-3 col-6">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
          </tr>
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