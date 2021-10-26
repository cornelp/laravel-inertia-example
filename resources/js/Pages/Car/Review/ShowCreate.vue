<template>
  <v-card>
    <v-card-title
      >{{ isEdit ? "Editeaza" : "Adauga" }} revizie (<a
        href="#"
        @click.prevent="$inertia.get(`/cars/${parent.id}`)"
        >{{ parent.licenseNo }}</a
      >)
    </v-card-title>
    <v-card-text>
      <v-form>
        <v-row>
          <v-col>
            <date-picker
              v-model="model.date"
              label="Data service"
              :error-messages="errors.date"
            />
          </v-col>
          <v-col>
            <date-picker
              v-model="model.invoiceDate"
              label="Data factura"
              :error-messages="errors.invoiceDate"
            />
          </v-col>
          <v-col>
            <v-autocomplete
              :items="options.type"
              v-model="model.type"
              label="Tip"
              :error-messages="errors.type"
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col>
            <v-autocomplete
              :items="options.agent"
              v-model="model.agent"
              :error-messages="errors.date"
              label="Agent"
              item-text="name"
              item-value="id"
            />
          </v-col>
          <v-col>
            <v-text-field
              v-model="model.mileage"
              label="KM"
              :error-messages="errors.mileage"
            ></v-text-field>
          </v-col>

          <v-col>
            <v-text-field
              v-model="model.amount"
              :error-messages="errors.amount"
              label="Suma"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-text-field
          v-model="model.observations"
          label="Detalii"
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
import Layout from "Pages/Layout";

export default {
  props: {
    parent: { type: Object },
    model: { type: Object, default: () => ({}) },
    errors: { type: Object, default: () => ({}) },
    options: { type: Object },
  },

  layout: Layout,

  data() {
    return {
      url: `/cars/${this.parent.id}/review`,
    };
  },

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
};
</script>
