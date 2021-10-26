<template>
  <div>
    <v-card-title>
      <h3>
        Situatie facturi / incasari (<a
          href="#"
          @click.prevent="$inertia.get(`/debts/${parent.id}`)"
          >{{ parent.name }}</a
        >)
      </h3>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="8">
          <v-btn color="primary" @click="$inertia.get(`${url}/create`)">
            <v-icon left>mdi-plus</v-icon>
            Adauga
          </v-btn>

          <v-btn color="info" @click="modal.showFilters = true">
            <v-icon left>mdi-filter</v-icon>
            Filtre {{ appliedFiltersNo ? `(${appliedFiltersNo})` : "" }}
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
        <template v-slot:item.date="{ item }">
          {{ item.date | fullDate }}
        </template>

        <template v-slot:item.amount="{ item }">
          {{ item.amount | float }}
        </template>

        <template v-slot:item.type="{ item }">
          <v-chip
            text-color="white"
            :color="item.type === 'Factura' ? 'red' : 'info'"
          >
            {{ item.type }}
          </v-chip>
        </template>

        <template v-slot:footer>
          <span>Total: {{ parent.balance | float }}</span>
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

    <delete-modal
      @delete-action="deleteAction"
      v-model="modal.showDelete"
      :model-id="modal.selectedId"
    />

    <v-dialog v-model="modal.showFilters" max-width="600">
      <v-card>
        <v-toolbar color="primary" dark>
          Filtre
          <v-spacer />
          <v-btn icon @click="modal.showFilters = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>

        <v-card-text>
          <div class="pt-6">
            <v-autocomplete
              v-model="queryParams.filters.type"
              :items="options.types"
              dense
              multiple
              clearable
              label="Tip"
            ></v-autocomplete>

            <range-date-picker
              v-model="queryParams.filters.date"
              label="Data"
            ></range-date-picker>
          </div>
        </v-card-text>
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
    parent: { type: Object },
    items: { type: Object },
    options: { type: Object },
  },

  layout: Layout,

  mixins: [handlesQueryParam, deleteAction],

  data() {
    return {
      url: `/debts/${this.parent.id}/details`,
      headers: [
        { value: "number", text: "Numar" },
        { value: "date", text: "Data" },
        { value: "amount", text: "Suma" },
        { value: "notes", text: "Detalii document" },
        { value: "type", text: "Tip" },
        { value: "paidFromBank", text: "Platit din banca" },
        { value: "secondNote", text: "Observatii" },
        { value: "actions", text: "Actiuni" },
      ],
      modal: {
        showFilters: false,
      },
    };
  },
};
</script>
