<template>
  <v-dialog v-model="value" max-width="290">
    <v-card v-if="value">
      <v-card-title>Stergi {{ type }} #{{ modelId }}?</v-card-title>
      <v-divider />
      <v-card-actions>
        <v-btn color="red darken-1" text @click="$emit('deleteAction')"
          >OK</v-btn
        >
        <v-btn text @click="$emit('input', false)">Renunta</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    value: { type: Boolean, default: false },
    type: { type: String, default: "rand" },
    modelId: { type: Number },
  },
};
</script>
