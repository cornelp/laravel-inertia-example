<template>
  <v-card>
    <v-card-title>{{
      isEdit ? `Client '${model.name}'` : "Adauga client"
    }}</v-card-title>
    <v-card-text>
      <v-form>
        <v-row>
          <v-col cols="6">
            <v-autocomplete
              v-model="model.area"
              :items="options.area"
              label="Zona"
              :error-messages="errors.area"
            ></v-autocomplete>
          </v-col>
          <v-col cols="6">
            <v-autocomplete
              v-model="model.city"
              :items="options.city"
              label="Oras"
              :error-messages="errors.city"
            ></v-autocomplete>
          </v-col>
        </v-row>

        <v-text-field
          v-model="model.name"
          label="Nume client"
          :error-messages="errors.name"
        ></v-text-field>

        <v-text-field
          v-model="model.notes"
          label="Observatii"
          :error-messages="errors.notes"
        ></v-text-field>

        <v-row>
          <v-col cols="4">
            <v-text-field
              v-model="model.taxCode"
              :error-messages="errors.taxCode"
              label="Cod fiscal"
            ></v-text-field>
          </v-col>
          <v-col cols="4">
            <v-text-field
              v-model="model.bankAccount"
              :error-messages="errors.bankAccount"
              label="Cont bancar"
            ></v-text-field>
          </v-col>
          <v-col cols="4">
            <v-text-field
              v-model="model.bank"
              :error-messages="errors.bank"
              label="Banca"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-switch v-model="model.isActive" label="E activ."></v-switch>
      </v-form>
    </v-card-text>

    <v-card-actions>
      <v-btn @click="saveData" color="primary">
        Salveaza
        <v-icon right>mdi-send</v-icon>
      </v-btn>

      <v-spacer />

      <v-btn
        dark
        v-if="isEdit"
        @click="$inertia.get(`/debts/${model.id}/details`)"
        color="green"
      >
        Situatie facturi / plati
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
    model: {
      type: Object,
      default: () => ({}),
    },
    options: { type: Object },
    errors: { type: Object, default: () => ({}) },
  },

  data: () => ({
    url: "/debts",
  }),

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
  },

  watch: {},

  beforeMount() {},
};
</script>
