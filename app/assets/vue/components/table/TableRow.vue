<template>
  <tr>
    <th scope="row" v-text="user.id"></th>
    <td>
      <span v-text="user.name" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="table-header-clickable" @click.prevent="openModal"></span>
    </td>
    <td><a :href="`mailto:${user.email}`" v-text="user.email"></a></td>
  </tr>
</template>
<script>
import {inject} from "vue";

export default {
  props: ['user'],
  setup(props) {
    const eventHandler = inject('eventHandler')

    function openModal() {
      eventHandler.emit('openModal', props.user)
    }

    return {
      openModal
    }
  }
}
</script>