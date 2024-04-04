<template>
  <div class="row">
    <Seat
      v-for="seat in seats"
      :key="seat.number"
      :seat="seat"
      :occupiedSeats="occupiedSeats" 
      @toggle-select="toggleSelect"
    />
  </div>
</template>

<script>
import Seat from '~/components/Seat.vue';

export default {
  components: { Seat },
  props: ['seats', 'occupiedSeats'],
  methods: {
    toggleSelect(seat) {
      this.$emit('toggle-select', seat);
    },
  },
};
</script>

<style scoped>
.row {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr;

}
</style>
