// stores/purchase.js
import { defineStore } from 'pinia';

export const usePurchaseStore = defineStore('purchase', {
  state: () => ({
    entryData: null, // Aquí guardaremos los datos de la compra
  }),
  actions: {
    saveEntryData(data) {
      this.entryData = data;
    }
  }
});
