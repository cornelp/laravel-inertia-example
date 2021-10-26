<template>
  <layout>
    <v-card>
      <v-card-title>{{
        isEdit ? "Agent #" + agent.id : "Adauga agent"
      }}</v-card-title>
      <v-card-text>
        <v-form>
          <v-row>
            <v-col cols="4">
              <v-select
                v-model="agent.area"
                :items="areas"
                label="Zona"
                :error-messages="errors.area"
              ></v-select>
            </v-col>
            <v-col cols="4">
              <v-text-field
                v-model="agent.contractNo"
                label="Nr contract"
                :error-messages="errors.contractNo"
                type="number"
              ></v-text-field>
            </v-col>
            <v-col cols="4">
              <date-picker
                v-model="agent.hireDate"
                label="Data angajare"
                :error-messages="errors.hireDate"
              ></date-picker>
            </v-col>
          </v-row>

          <v-text-field
            v-model="agent.name"
            :error-messages="errors.name"
            label="Nume"
          ></v-text-field>
          <v-row>
            <v-col cols="6">
              <v-text-field
                v-model="agent.cnp"
                label="CNP"
                :error-messages="errors.cnp"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <date-picker
                v-model="agent.birthDate"
                label="Data nastere"
                :error-messages="errors.birthDate"
              ></date-picker>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="4">
              <v-text-field
                v-model="agent.icSerial"
                label="Serie CI"
                :error-messages="errors.icSerial"
              ></v-text-field>
            </v-col>
            <v-col cols="4">
              <v-text-field
                v-model="agent.icNumber"
                :error-messages="errors.icNumber"
                label="Numar CI"
              ></v-text-field>
            </v-col>
            <v-col cols="4">
              <v-text-field
                v-model="agent.icCity"
                label="Oras CI"
                :error-messages="errors.icCity"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-text-field
            v-model="agent.address"
            :error-messages="errors.address"
            label="Adresa"
          ></v-text-field>
          <v-row>
            <v-col cols="4">
              <v-select
                v-model="agent.position"
                :items="positions"
                label="Functie"
                :error-messages="errors.position"
              ></v-select>
            </v-col>
            <v-col cols="4">
              <v-select
                v-model="agent.cor"
                :items="cors"
                :error-messages="errors.cor"
                label="Cod COR"
              ></v-select>
            </v-col>
            <v-col cols="4">
              <v-autocomplete
                v-model="agent.phone"
                :items="phoneNumbers"
                :error-messages="errors.phone"
                label="Telefon"
                clearable
                item-text="number"
                item-value="id"
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="4">
              <v-switch
                v-model="isAgentActive"
                :label="'Este ' + (isAgentActive ? 'activ' : 'inactiv') + '.'"
              ></v-switch>
            </v-col>
            <v-col cols="4">
              <date-picker
                v-if="!isAgentActive"
                label="Data demisie"
                v-model="agent.resignationDate"
              ></date-picker>
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
  </layout>
</template>

<script>
import Layout from "Pages/Layout.vue";
import dayjs from "dayjs";

export default {
  props: {
    agent: {
      type: Object,
      default: () => ({}),
    },
    areas: { type: Array },
    positions: { type: Array },
    cors: { type: Array },
    phoneNumbers: { type: Array },
    errors: { type: Object, default: () => ({}) },
  },

  components: {
    Layout,
  },

  methods: {
    goBack() {
      window.history.back();
    },
    saveData() {
      this.agent.hasOwnProperty("id")
        ? this.$inertia.patch(`/agents/${this.agent.id}`, this.agent)
        : this.$inertia.post("/agents", this.agent);
    },
    setPhoneInstance() {
      if (!this.isEdit) {
        return;
      }

      const phoneInstance = this.phoneNumbers.find((phoneNumber) => {
        return Number(phoneNumber.id) === Number(this.agent.phoneId);
      }, this);

      if (!phoneInstance) {
        return;
      }

      this.agent.phone = phoneInstance;
      delete this.agent.phoneId;
    },
  },

  computed: {
    isAgentActive: {
      get() {
        return this.agent.resignationDate == null;
      },
      set(value) {
        this.agent.resignationDate = value ? null : dayjs().toISOString();
      },
    },
    isEdit() {
      return this.agent && this.agent.hasOwnProperty("id");
    },
  },

  watch: {},

  beforeMount() {
    this.setPhoneInstance();
  },
};
</script>
