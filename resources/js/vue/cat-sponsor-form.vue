<template>
  <div>Korak {{ step }}/[TOTAL_STEPS]</div>

  <div v-if="step === 1">
    <div>STEP 1 - Namen</div>
    <div>Botrstvo je zame/darilo</div>
  </div>

  <div v-if="step === 2">
    <div>STEP 2 - Finance</div>
    <div>Znesek</div>
    <div>Trajnik ja/ne</div>
  </div>

  <div v-if="step === 3">
    <div>STEP 3 - Moji podatki</div>
    <div>Email</div>
    <div>Ime <input type="text" v-model="input.payer_first_name" /></div>
    <div>Priimek</div>
    <div>Spol</div>
    <div>Ulica in hišna številka</div>
    <div>Poštna št.</div>
    <div>Kraj</div>
    <div>Država</div>
  </div>

  <div v-if="step === 4">
    <div>STEP 4 - Podatki obvarovanca</div>
    <div>Email</div>
    <div>Ime</div>
    <div>Priimek</div>
    <div>Spol</div>
    <div>Ulica in hišna številka</div>
    <div>Poštna št.</div>
    <div>Kraj</div>
    <div>Država</div>
  </div>

  <div v-if="step === 5">
    <div>STEP 5 - Druge značilnosti</div>
    <div>Trajanje (če je gift)</div>
    <div>Anonimno ja/ne</div>
  </div>

  <div v-if="step === 6">
    <div>STEP 6 - Zaključek</div>
    <div>Povzetek</div>
    <div>Strinjam se ja/ne</div>
  </div>

  <div>
    <button v-if="isAfterFirstStep" @click="goToPrevStep" class="bg-blue-500 text-white">Nazaj!</button>
    <button v-if="isBeforeLastStep" @click="goToNextStep" class="bg-yellow-500 text-black">Naprej!</button>
  </div>
  <hr />
</template>

<script>
export default {
  data() {
    return {
      step: 1,
      input: {
        payer_first_name: '',
      },
    };
  },
  computed: {
    isAfterFirstStep() {
      return this.step > 1
    },
    isBeforeLastStep() {
      return this.step < 6
    }
  },
  methods: {
    goToNextStep() {
      if (this.step === 6) {
        return;
      }
      this.step++;
    },
    goToPrevStep() {
      if (this.step === 1) {
        return;
      }
      this.step--;
    },
  },
};
</script>
