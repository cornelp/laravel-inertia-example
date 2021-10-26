<template>
  <div>
    <v-card>
      <v-card-title>
        <h3>Datorii</h3>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="8">
            <v-btn color="primary" @click="$inertia.get(`${url}/create`)">
              <v-icon left>mdi-plus</v-icon>
              Adauga
            </v-btn>

            <v-btn color="primary" @click="modal.showFilters = true">
              <v-icon>mdi-filter</v-icon>
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
          <template v-slot:item.balance="{ item }">
            <v-chip
              text-color="white"
              :color="
                item.balance == 0
                  ? 'green'
                  : item.balance > 0
                  ? 'red'
                  : 'primary'
              "
            >
              {{ item.balance | float }}
            </v-chip>
          </template>

          <template v-slot:item.name="{ item }">
            <a @click.prevent="$inertia.get(`${url}/${item.id}`)" href="#">
              {{ item.name }}
            </a>
          </template>

          <template v-slot:item.paidAmount="{ item }">
            {{ item.paidAmount | float }}
          </template>

          <template v-slot:item.invoicedAmount="{ item }">
            {{ item.invoicedAmount | float }}
          </template>

          <template v-slot:item.isActive="{ item }">
            <v-chip :color="item.isActive ? 'green' : 'red'" text-color="white">
              {{ item.isActive | status }}
            </v-chip>
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

              <v-btn
                color="primary"
                @click="$inertia.get(`${url}/${item.id}/details`)"
                icon
                small
              >
                <v-icon>mdi-calendar-blank</v-icon>
              </v-btn>
            </v-row>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>

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
              v-for="(filter, name) in options"
              :key="name"
              :label="filterLabels[name]"
              v-model="queryParams.filters[name]"
              :items="options[name]"
              dense
              multiple
              clearable
            />
          </div>
        </v-card-text>
        <v-card-actions v-if="appliedFiltersNo">
          <v-spacer></v-spacer>
          <v-btn rounded color="error" dark @click="resetFilters()">
            Elimina filtre
            <v-icon right>mdi-close</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import Layout from "Pages/Layout";
import handlesQueryParam from "@/Mixins/handlesQueryParam";

export default {
  props: {
    items: { type: Object },
    options: { type: Object },
  },

  layout: Layout,

  mixins: [handlesQueryParam],

  data() {
    return {
      url: "/debts",
      headers: [
        { value: "area", text: "Zona" },
        { value: "city", text: "Oras" },
        { value: "name", text: "Nume" },
        { value: "balance", text: "Sold" },
        { value: "invoicedAmount", text: "Suma facturata" },
        { value: "paidAmount", text: "Suma platita" },
        { value: "notes", text: "Observatii" },
        { value: "taxCode", text: "Cod fiscal" },
        { value: "bankAccount", text: "Cod bancar" },
        { value: "bank", text: "Banca" },
        { value: "isActive", text: "Activ" },
        { value: "type", text: "Tip" },
        { value: "actions", text: "Actiuni" },
      ],
      filterLabels: {
        type: "Tip",
        area: "Zona",
        city: "Oras",
      },
      modal: { showFilters: false },
    };
  },

  methods: {},

  computed: {},

  watch: {},

  created() {},
};
</script>
