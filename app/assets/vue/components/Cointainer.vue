<template>
  <div class="container custom-container d-flex flex-column">
    <search-bar-component></search-bar-component>
    <div class="row">
      <country-filter-component :filters="filters"></country-filter-component>
      <list-component></list-component>
    </div>
  </div>
</template>
<script>
export default {
  props: ['filters']
}
</script>