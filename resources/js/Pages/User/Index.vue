<template>
  <v-app>
    <v-main>
      <v-data-table :items="items.data" :headers="columns"></v-data-table>
    </v-main>
  </v-app>
</template>

<script>
export default {
  props: {
    items: { type: Object },
    query: { type: Object },
  },

  data() {
    return {
      columns: [
        { text: "Id", value: "id" },
        { text: "Name", value: "name" },
        { text: "Email", value: "Email" },
        { text: "Updated At", value: "updated_at" },
        { text: "Actions", value: "actions" },
      ],
      filters: {
        search: null,
      },
    };
  },
};
</script>
