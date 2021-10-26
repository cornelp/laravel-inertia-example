<template>
  <div>
    <v-card>
      <v-card-title>
        <h3>Agenti</h3>
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
          <template v-slot:item.phone="{ item }">
            {{ item.phone }}
          </template>
          <template v-slot:item.birthDate="{ item }">
            {{ item.birthDate | fullDate }}
          </template>
          <template v-slot:item.hireDate="{ item }">
            {{ item.hireDate | fullDate }}
          </template>
          <template v-slot:item.resignationDate="{ item }">
            {{ item.resignationDate | fullDate }}
          </template>
          <template v-slot:item.address="{ item }">
            {{ item.address.substring(0, 35) }}
            {{ item.address.length > 35 ? "..." : "" }}
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
            <range-date-picker
              v-model="queryParams.filters.hireDate"
              label="Data angajare"
            />
            <range-date-picker
              v-model="queryParams.filters.resignationDate"
              label="Data demisie"
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
      url: "/agents",
      headers: [
        { value: "contractNo", text: "Nr Contract" },
        { value: "name", text: "Nume" },
        { value: "area", text: "Zona" },
        { value: "hireDate", text: "Data angajare" },
        { value: "birthDate", text: "Data nastere" },
        { value: "cnp", text: "CNP" },
        { value: "icSerial", text: "Serie CI" },
        { value: "icNumber", text: "Numar CI" },
        { value: "address", text: "Adresa" },
        { value: "icCity", text: "Oras" },
        { value: "position", text: "Functie" },
        { value: "cor", text: "Cod COR" },
        { value: "phone", text: "Nr telefon" },
        { value: "resignationDate", text: "Data demisie" },
        { value: "actions", text: "Actiuni", sortable: false },
      ],
      filterLabels: {
        area: "Zona",
        icCity: "Oras",
        position: "Functie",
        phoneId: "Nr telefon",
      },
      modal: {
        showFilters: false,
      },
    };
  },

  methods: {},

  watch: {},

  created() {},
};
</script>
