<template>
  <v-card>
    <v-card-title>{{
      isEdit ? "Sim #" + model.id : "Adauga sim"
    }}</v-card-title>
    <v-card-text>
      <v-form>
        <v-row>
          <v-col cols="6">
            <v-text-field
              v-model="model.serial"
              label="Serie"
              :error-messages="errors.serial"
            ></v-text-field>
          </v-col>
          <v-col cols="6">
            <v-text-field
              v-model="model.number"
              label="Numar telefon"
              :error-messages="errors.number"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-text-field
          v-model="model.notes"
          label="Observatii"
          :error-messages="errors.notes"
        ></v-text-field>

        <v-row>
          <v-col cols="6">
            <v-switch
              v-model="model.isActive"
              :label="`E ${model.isActive ? 'activ' : 'inactiv'}.`"
            />
          </v-col>
          <v-col cols="6">
            <v-autocomplete
              v-model="model.agent"
              :items="agents"
              label="Agent"
              v-if="hasAgent"
              item-text="name"
              item-value="id"
              clearable
            ></v-autocomplete>
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
    model: {
      type: Object,
      default: () => ({}),
    },
    agents: { type: Array },
    errors: { type: Object, default: () => ({}) },
  },

  data: () => ({
    url: "/phones",
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
    handleAgentInstance() {
      if (!this.model.agent) {
        return;
      }

      // find agent
      let agentInstance = this.agents.find((item) => {
        return item.phoneId == this.model.agent.phoneId;
      }, this);

      // select if found
      if (!agentInstance) {
        return;
      }

      console.log(agentInstance);
    },
  },

  computed: {
    isEdit() {
      return this.model && this.model.hasOwnProperty("id");
    },
    hasAgent() {
      return this.model.isActive;
    },
  },

  watch: {
    "model.isActive"(value) {
      if (!value) {
        delete this.model.agent;
      }
    },
  },

  beforeMount() {
    /* this.handleAgentInstance(); */
  },
};
</script>
