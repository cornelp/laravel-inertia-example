<template>
  <div>
    <v-card>
      <v-card-title>
        <h3>Sim-uri</h3>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="8">
            <v-btn color="primary" @click="$inertia.get(`${url}/create`)">
              <v-icon left>mdi-plus</v-icon>
              Adauga
            </v-btn>
          </v-col>
          <v-col cols="4" class="text-right">
            <v-text-field
              type="search"
              v-model="queryParams.search"
              label="Filtru rapid"
              prepend-inner-icon="mdi-table-search"
              clearable
            ></v-text-field>
          </v-col>
        </v-row>

        <v-data-table
          :items="items.data"
          :headers="headers"
          :options.sync="queryParams"
          :server-items-length="items.meta.total"
          multi-sort
        >
          <template v-slot:item.isActive="{ item }">
            {{ item.isActive | status }}
          </template>
          <template v-slot:item.actions="{ item }">
            <v-row>
              <v-btn
                color="primary"
                @click="$inertia.get(`${url}/${item.id}`)"
                icon
                small
              >
                <v-icon>mdi-pencil</v-icon>
              </v-btn>

              <v-btn color="error" @click="showDeleteModal(item.id)" icon small>
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </v-row>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>

    <v-dialog v-model="modal.showDelete" max-width="290">
      <v-card v-if="modal.showDelete">
        <v-card-title>Stergi sim #{{ modal.selectedId }}?</v-card-title>
        <v-divider />
        <v-card-actions>
          <v-btn color="red darken-1" text @click="deleteAction()">OK</v-btn>
          <v-btn text @click="modal.showDelete = false">Renunta</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import Layout from "Pages/Layout";
import handlesQueryParam from "@/Mixins/handlesQueryParam";
import deleteAction from "@/Mixins/deleteAction";

export default {
  props: {
    items: { type: Object },
    options: { type: Object },
  },

  layout: Layout,

  mixins: [handlesQueryParam, deleteAction],

  data() {
    return {
      url: "/phones",
      headers: [
        { value: "serial", text: "Serie" },
        { value: "number", text: "Numar telefon" },
        { value: "isActive", text: "Activ" },
        { value: "agent", text: "Nume Agent" },
        { value: "notes", text: "Observatii" },
        { value: "actions", text: "Actiuni", sortable: false },
      ],
      modal: {
        showFilters: false,
      },
    };
  },

  methods: {},

  computed: {},

  watch: {},

  created() {},
};
</script>
