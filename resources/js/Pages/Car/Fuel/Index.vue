<template>
  <div>
    <v-card-title>
      <h3>
        Situatie combustibil (<a
          href="#"
          @click.prevent="$inertia.get(`/cars/${parent.id}`)"
          >{{ parent.licenseNo }}</a
        >)
        <v-btn color="primary" dark icon>
          <v-icon>mdi-dots-horizontal</v-icon>
        </v-btn>
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
        :sort-by="['date']"
        :sort-desc="[true]"
      >
        <template v-slot:item.date="{ item }">
          {{ item.date | fullDate }}
        </template>

        <template v-slot:item.amount="{ item }">
          {{ item.amount | float }}
        </template>

        <template v-slot:item.liters="{ item }">
          {{ item.liters | float }}
        </template>

        <template v-slot:item.mileage="{ item }">
          {{ item.mileage | integer }}
        </template>

        <template v-slot:item.consumption="{ item }">
          {{ item.consumption | float }}
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
      :model-id="modal.selectedId"
      v-model="modal.showDelete"
      type="alimentare"
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
            <range-date-picker
              v-model="queryParams.filters.date"
              label="Data"
            />
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
      url: `/cars/${this.parent.id}/fuel`,
      headers: [
        { value: "date", text: "Data" },
        { value: "agent", text: "Agent" },
        { value: "mileage", text: "KM" },
        { value: "amount", text: "Suma" },
        { value: "liters", text: "Litri" },
        { value: "consumption", text: "Consum" },
        { value: "actions", text: "Actiuni" },
      ],
      modal: {
        showFilters: false,
      },
    };
  },
};
</script>
