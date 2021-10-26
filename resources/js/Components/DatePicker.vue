<template>
  <v-flex>
    <v-menu
      :close-on-content-click="false"
      v-model="showDatePicker"
      offset-y
      max-width="290px"
      min-width="290px"
      :disabled="disabled"
    >
      <template v-slot:activator="{ on }">
        <v-text-field v-on="on" :label="label" :value="dateShow" readonly>
        </v-text-field>
      </template>
      <v-date-picker
        color="primary"
        first-day-of-week="1"
        locale="ro"
        v-model="date"
        no-title
        @input="(d) => (date = d)"
        type="date"
        :range="range"
      ></v-date-picker>
    </v-menu>
  </v-flex>
</template>

<script>
import dayjs from "dayjs";

export default {
  props: {
    label: { type: String, default: "Data" },
    value: { type: String, default: dayjs().toISOString() },
    range: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
  },

  data() {
    return {
      date: dayjs().toISOString(),
      showDatePicker: false,
    };
  },

  computed: {
    dateShow() {
      return dayjs(this.date).format("DD.MM.YYYY");
    },
  },

  methods: {
    setDateFromValue() {
      this.date = dayjs(this.value).toISOString();
    },
  },

  watch: {
    value() {
      this.setDateFromValue();
    },
    date() {
      this.$emit("input", this.date);
    },
  },

  created() {
    this.setDateFromValue();
  },
};
</script>
