<template>
  <v-card>
    <v-card-title
      >{{ isEdit ? "Editeaza alimentare" : "Adauga alimentare" }} ({{
        parent.licenseNo
      }})
    </v-card-title>
    <v-card-text>
      <v-form>
        <v-row>
          <v-col cols="6">
            <date-picker
              v-model="model.date"
              label="Data"
              :error-messages="errors.date"
            />
          </v-col>
          <v-col cols="6">
            <v-autocomplete
              :items="options.agent"
              v-model="model.agent"
              :error-messages="errors.date"
              label="Agent"
              item-text="name"
              item-value="id"
            ></v-autocomplete>
          </v-col>
        </v-row>

        <v-text-field
          v-model="model.mileage"
          label="KM"
          :error-messages="errors.mileage"
        ></v-text-field>

        <v-row>
          <v-col cols="6">
            <v-text-field
              v-model="model.amount"
              :error-messages="errors.amount"
              label="Suma"
            ></v-text-field>
          </v-col>
          <v-col cols="6">
            <v-text-field
              v-model="model.liters"
              :error-messages="errors.liters"
              label="Litri"
            ></v-text-field>
          </v-col>
        </v-row>
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
      default: () => ({}),
    },
    options: { type: Object },
    errors: { type: Object, default: () => ({}) },
  },

  data() {
    return {
      url: `/cars/${this.parent.id}/fuel`,
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
  },

  watch: {},

  beforeMount() {},
};
</script>
