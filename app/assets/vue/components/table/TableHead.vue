<template>
  <tr>
    <th scope="col" @click="orderById"><label class="table-header-clickable">id</label></th>
    <th scope="col" @click="orderByName"><label class="table-header-clickable">Name</label></th>
    <th scope="col" @click="orderByEmail"><label class="table-header-clickable">Email</label></th>
  </tr>
</template>
<script>
import {inject, reactive} from "vue";

export default {
  setup() {
    const eventHandler = inject('eventHandler')
    const state = reactive({
      id: 0,
      name: 0,
      email: 0
    })

    function orderById () {
      state.name = 0
      state.email = 0

      state.id++
      if (state.id > 2) {
        state.id = 0
        eventHandler.emit('order-by', {
          field: 'id',
          orientation: state.id
        })

        return
      }

      eventHandler.emit('order-by', {
        field: 'id',
        orientation: state.id
      })
    }

    function orderByName () {
      state.id = 0
      state.email = 0

      state.name++
      if (state.name > 2) {
        state.name = 0
        eventHandler.emit('order-by', {
          field: 'name',
          orientation: state.name
        })

        return
      }

      eventHandler.emit('order-by', {
        field: 'name',
        orientation: state.name
      })
    }

    function orderByEmail () {
      state.name = 0
      state.id = 0

      state.email++
      if (state.email > 2) {
        state.email = 0
        eventHandler.emit('order-by', {
          field: 'email',
          orientation: state.email
        })

        return
      }

      eventHandler.emit('order-by', {
        field: 'email',
        orientation: state.email
      })
    }

    return {
      state,
      orderById,
      orderByName,
      orderByEmail
    }
  }
}
</script>