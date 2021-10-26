<template>
  <v-card>
    <v-card-title
      >{{
        isEdit
          ? `Editeaza ${isPayment ? "plata" : "factura"}`
          : "Adauga inregistrare"
      }}
      (client '{{ parent.name }}')
    </v-card-title>
    <v-card-text>
      <v-form>
        <v-row>
          <v-col cols="6">
            <v-text-field
              v-model="model.number"
              label="Numar"
              :error-messages="errors.area"
            ></v-text-field>
          </v-col>
          <v-col cols="6">
            <date-picker
              v-model="model.date"
              :error-messages="errors.date"
              label="Data"
            ></date-picker>
          </v-col>
        </v-row>

        <v-text-field
          v-model="model.notes"
          label="Detalii document"
          :error-messages="errors.notes"
        ></v-text-field>

        <v-row>
          <v-col cols="4">
            <v-text-field
              type="number"
              v-model="model.amount"
              :error-messages="errors.amount"
              label="Suma"
            ></v-text-field>
          </v-col>
          <v-col cols="4">
            <v-autocomplete
              v-model="model.type"
              :items="options.types"
              label="Tip"
              :error-messages="errors.type"
            ></v-autocomplete>
          </v-col>
          <v-col cols="4">
            <v-autocomplete
              v-if="isPayment"
              v-model="model.paidFromBank"
              :error-messages="errors.paidFromBank"
              :items="options.banks"
              label="Platit din banca"
            ></v-autocomplete>
          </v-col>
        </v-row>

        <v-text-field
          v-model="model.secondNote"
          label="Observatii"
          :error-messages="errors.secondNote"
        ></v-text-field>
      </v-form>
    </v-card-text>

    <v-card-actions>
      <v-btn @click="saveData" color="primary">
        Salveaza
        <v-icon right>mdi-send</v-icon>
      </v-btn>
      <v-spacer />
      <v-btn @click="goBack">
        <v-icon left>mdi-undo</v-icon>
        Inapoi
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import Layout from "Pages/Layout.vue";

export default {
  props: {
    parent: { type: Object },
    model: {
      type: Object,
      default: () => ({ type: 1 }),
    },
    options: { type: Object },
    errors: { type: Object, default: () => ({}) },
  },

  data() {
    return {
      url: `/debts/${this.parent.id}/details`,
    };
  },

  layout: Layout,

  methods: {
    goBack() {
      window.history.back();
    },
    saveData() {
      this.model.hasOwnProperty("id")
        ? this.$inertia.patch(`${this.url}/${this.model.id}`, this.model)
        : this.$inertia.post(this.url, this.model);
    },
  },

  computed: {
    isEdit() {
      return this.model && this.model.hasOwnProperty("id");
    },
    isPayment() {
      let paymentType = this.options.types.find(
        (item) => item.text === "Plata"
      );

      return (
        this.model.hasOwnProperty("type") &&
        Number(this.model.type) === Number(paymentType.value)
      );
    },
  },

  watch: {
    isPayment(value) {
      !value && delete this.model.paidFromBank;
    },
  },

  beforeMount() {},
};
</script>
