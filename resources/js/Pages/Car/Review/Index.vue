<template>
  <div>
    <v-card>
      <v-card-title>
        <h3>
          Revizii (<a
            href="#"
            @click.prevent="$inertia.get(url.replace('review', ''))"
            >{{ parent.licenseNo }}</a
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
          <template v-slot:item.type="{ item }">
            {{ item.typeName }}
          </template>

          <template v-slot:item.agent="{ item }">
            {{ item.agent.hasOwnProperty("name") ? item.agent.name : "" }}
          </template>

          <template v-slot:item.amount="{ item }">
            {{ item.amount | float }}
          </template>

          <template v-slot:item.mileage="{ item }">
            {{ item.mileage | integer }}
          </template>

          <template v-slot:item.invoiceDate="{ item }">
            {{ item.invoiceDate | fullDate }}
          </template>

          <template v-slot:item.date="{ item }">
            {{ item.date | fullDate }}
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
          <div class="pt-6"></div>
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
    parent: { type: Object },
    items: { type: Object },
    options: { type: Object },
  },

  layout: Layout,

  mixins: [handlesQueryParam, deleteAction],

  data() {
    return {
      url: `/cars/${this.parent.id}/review`,
      headers: [
        { value: "agent", text: "Agent" },
        { value: "date", text: "Data" },
        { value: "invoiceDate", text: "Data factura" },
        { value: "type", text: "Tip" },
        { value: "mileage", text: "KM" },
        { value: "amount", text: "Suma" },
        { value: "observations", text: "Detalii" },
        { value: "actions", text: "Actiuni" },
      ],
      modal: {
        showFilters: false,
      },
    };
  },
};
</script>
