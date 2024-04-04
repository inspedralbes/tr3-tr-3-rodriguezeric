<template>
    <div class="row">
      <Seat
        v-for="seat in seats"
        :key="seat.number"
        :seat="seat"
        @toggle-select="toggleSelect"
      />
    </div>
  </template>
  
  <script>
  import Seat from './Seat.vue';
  
  export default {
    components: { Seat },
    props: ['seats'],
    methods: {
      toggleSelect(seat) {
        this.$emit('toggle-select', seat);
      },
    },
  };
  </script>
  
  <style scoped>
  .row {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
  }
  </style>
  