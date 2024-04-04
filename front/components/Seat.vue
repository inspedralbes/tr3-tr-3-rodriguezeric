<template>
    <div
      :class="['seat', { 'seat--occupied': seat.occupied, 'seat--selected': seat.selected }]"
      @click="toggleSelect"
    >
    </div>
  </template>
  
  <script>
  export default {
    props: ['seat'],
    methods: {
      toggleSelect() {
        if (!this.seat.occupied) {
          this.$emit('toggle-select', this.seat);
        }
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
    background-color: #ccc;
    cursor: not-allowed;
  }
  .seat--selected {
    background-color: #4CAF50;
    transform: scale(1.1);
  }
  .seat__number {
    pointer-events: none;
  }
  </style>
  