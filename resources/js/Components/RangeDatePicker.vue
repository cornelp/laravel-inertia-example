<template>
  <v-flex>
    <v-menu
      :close-on-content-click="false"
      v-model="showDatePicker"
      offset-y
      max-width="290px"
      min-width="290px"
    >
      <template v-slot:activator="{ on }">
        <v-text-field
          v-on="on"
          :label="label"
          :value="dateShow"
          readonly
          clearable
          @input="resetDate"
        >
        </v-text-field>
      </template>
      <v-date-picker
        color="primary"
        first-day-of-week="1"
        locale="ro"
        v-model="date"
        no-title
        @input="setDate"
        type="date"
        range
        @change="announceChange()"
      ></v-date-picker>
    </v-menu>
  </v-flex>
</template>

<script>
import dayjs from "dayjs";

export default {
  props: {
    label: { type: String, default: "Data" },
    value: {
      type: Array,
      default: () => [null, null],
    },
  },

  data() {
    return {
      date: [null, null],
      showDatePicker: false,
    };
  },

  computed: {
    dateShow() {
      const start = this.date[0]
        ? dayjs(this.date[0]).format("DD.MM.YYYY")
        : "";
      const end = this.date[1] ? dayjs(this.date[1]).format("DD.MM.YYYY") : "";

      return `${start} - ${end}`;
    },
  },

  methods: {
    resetDate() {
      this.date = [null, null];
      this.$emit("input", []);
    },
    setDate(dates) {
      this.date = dates;
    },
    setDateFromValue() {
      if (!this.value[0] || !this.value[1]) {
        this.date = [null, null];
        return;
      }

      this.date = this.value.map((item) => dayjs(item).toISOString());
    },
    announceChange() {
      this.$emit("input", this.date);
    },
  },

  watch: {
    value() {
      this.setDateFromValue();
    },
  },

  created() {
    this.setDateFromValue();
  },
};
</script>
