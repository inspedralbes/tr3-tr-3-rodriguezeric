<template>
  <div
    :class="['seat', { 'seat--occupied': isOccupied(seat), 'seat--selected': seat.selected }]"
    @click="toggleSelect"
  >
    <span class="seat__number">{{ seat.number }}</span>
  </div>
</template>

<script>
export default {
  props: ['seat', 'occupiedSeats'],
  methods: {
    toggleSelect() {
      if (!this.isOccupied(this.seat)) {
        this.$emit('toggle-select', this.seat);
      }
    },
    isOccupied(seat) {
      return this.occupiedSeats.includes(seat.id);
    },
  },
};
</script>

<style scoped>
.seat {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  margin: 5px;
  background-color: #f0f0f0;
  cursor: pointer;
  transition: transform 0.2s ease-in-out;
  border-radius: 8px;
}

.seat--occupied {
  background-color: red;
  cursor: not-allowed; /* Hace que el cursor sea de tipo "no permitido" en los asientos ocupados */
}

.seat--selected {
  background-color: #4CAF50;
  transform: scale(1.1);
}

.seat__number {
  pointer-events: none; /* Evita que el número del asiento sea seleccionable */
}
</style>
