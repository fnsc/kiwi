<template>
  <tr>
    <th scope="row" v-text="user.id"></th>
    <td v-text="user.name"></td>
    <td><a :href="`mailto: + ${user.email}`" v-text="user.email"></a></td>
  </tr>
</template>
<script>
export default {
  props: ['user']
}
</script>