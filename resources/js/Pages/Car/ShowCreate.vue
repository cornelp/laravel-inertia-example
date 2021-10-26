<template>
  <v-card>
    <v-card-title>{{
      isEdit ? `Auto #${model.id}` : "Adauga auto"
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
          v-model="model.licenseNo"
          label="Nr inmatriculare"
          :error-messages="errors.licenseNo"
        ></v-text-field>

        <v-autocomplete
          v-model="model.model"
          label="Model"
          :error-messages="errors.model"
          :items="options.model"
        ></v-autocomplete>

        <v-row>
          <v-col cols="4">
            <v-autocomplete
              v-model="model.agent"
              :error-messages="errors.agent"
              label="Agent"
              :items="options.agent"
              item-text="name"
              item-value="id"
            ></v-autocomplete>
          </v-col>
          <v-col cols="4">
            <v-autocomplete
              v-model="model.fuel"
              :error-messages="errors.fuel"
              label="Combustibil"
              :items="options.fuel"
            ></v-autocomplete>
          </v-col>
          <v-col cols="4">
            <v-autocomplete
              v-model="model.type"
              :error-messages="errors.type"
              label="Tip masina"
              :items="options.type"
            ></v-autocomplete>
          </v-col>
        </v-row>

        <v-text-field
          v-model="model.chassis"
          label="Serie sasiu"
          :error-messages="errors.chassis"
        ></v-text-field>

        <v-row>
          <v-col cols="3">
            <v-text-field
              v-model="model.productionYear"
              :error-messages="errors.productionYear"
              label="An productie"
            ></v-text-field>
          </v-col>
          <v-col cols="3">
            <v-text-field
              v-model="model.purchaseYear"
              :error-messages="errors.purchaseYear"
              label="An achizitie"
            ></v-text-field>
          </v-col>
          <v-col cols="3">
            <v-text-field
              v-model="model.engineCapacity"
              :error-messages="errors.engineCapacity"
              label="Capacitate motor"
            ></v-text-field>
          </v-col>
          <v-col cols="3">
            <v-text-field
              v-model="model.horsePower"
              :error-messages="errors.horsePower"
              label="Cai putere"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="4">
            <v-switch
              v-model="model.needsRoadTax"
              :error-messages="errors.needsRoadTax"
              label="Are nevoie de rovinieta"
            ></v-switch>
          </v-col>
          <v-col cols="4">
            <v-text-field
              type="numeric"
              v-model="model.distributionInKm"
              :error-messages="errors.distributionInKm"
              label="Distributie in (km)"
            ></v-text-field>
          </v-col>
          <v-col cols="4">
            <v-text-field
              v-model="model.distributionInYears"
              :error-messages="errors.distributionInYears"
              label="Distributie in (ani)"
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

      <v-menu offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn color="primary" dark icon v-bind="attrs" v-on="on">
            <v-icon>mdi-dots-horizontal</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item v-for="(link, item) in links" :key="item">
            <v-list-item-title>
              <v-btn
                text
                @click.prevent="$inertia.get(`${url}/${model.id}/${link.type}`)"
              >
                <v-icon left>mdi-{{ link.icon }}</v-icon>
                {{ link.name }}
              </v-btn>
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>

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
    url: "/cars",
    links: [
      { name: "Combustibil", icon: "fuel", type: "fuel" },
      { name: "Revizii", icon: "wrench", type: "review" },
    ],
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
