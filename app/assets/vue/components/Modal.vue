<template>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" v-text="state.user.name"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-4">
              <label>Email: </label>
              <span>
                <a :href="`mailto:${state.user.email}`" v-text="state.user.email"></a>
              </span>
            </div>
            <div class="col-md-12 col-lg-4" v-if="state.user.phone_numbers.length" v-for="phone_number in state.user.phone_numbers">
              <label v-text="`${phone_number.name}: `"></label>
              <span>
                <a :href="`tel:${phone_number.value}`" v-text="phone_number.value"></a>
              </span>
            </div>
            <hr class="my-3">
            <div class="row" v-if="state.user.address.hasOwnProperty('city')">
              <div class="col-md-12 col-lg-6">
                <label class="text-bold">Address Line 1: </label>
                <span v-text="state.user.address.address_line_1"></span>
              </div>
              <div class="col-md-12 col-lg-6">
                <label class="text-bold">Address Line 2: </label>
                <span v-text="state.user.address.address_line_2"></span>
              </div>
              <div class="col-md-12 col-lg-6">
                <label class="text-bold">City: </label>
                <span v-text="state.user.address.city"></span>
              </div>
              <div class="col-md-12 col-lg-6">
                <label class="text-bold">Province: </label>
                <span v-text="state.user.address.province"></span>
              </div>
              <div class="col-md-12 col-lg-6">
                <label class="text-bold">Country: </label>
                <span v-text="state.user.address.country"></span>
              </div>
              <div class="col-md-12 col-lg-6">
                <label class="text-bold">Zip Code: </label>
                <span v-text="state.user.address.zip_code"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {inject, reactive} from "vue";

export default {
  setup() {
    const eventHandler = inject('eventHandler')
    const state = reactive({
      user: {
        name: '',
        email: '',
        phone_numbers: [],
        address: {
          address_line_1: '',
          address_line_2: '',
          city: '',
          province: '',
          country: '',
          zip_code: '',
        }
      }
    })

    eventHandler.on('openModal', (user) => {
      state.user = user
    })

    return {
      state
    }
  }
}
</script>