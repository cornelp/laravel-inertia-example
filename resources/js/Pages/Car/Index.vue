<template>
  <div>
    <v-card>
      <v-card-title>
        <h3>Parc auto</h3>
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
          <template v-slot:item.insuranceTillDate="{ item }">
            <v-chip
              :color="getColorForDate(item.insuranceTillDate)"
              text-color="white"
            >
              {{ item.insuranceTillDate | fullDate }}
            </v-chip>
          </template>

          <template v-slot:item.tehnicalInspectionTillDate="{ item }">
            <v-chip
              :color="getColorForDate(item.tehnicalInspectionTillDate)"
              text-color="white"
            >
              {{ item.tehnicalInspectionTillDate | fullDate }}
            </v-chip>
          </template>

          <template v-slot:item.roadTaxTillDate="{ item }">
            <v-chip
              :color="getColorForDate(item.roadTaxTillDate)"
              text-color="white"
            >
              {{ item.roadTaxTillDate | fullDate }}
            </v-chip>
          </template>

          <template v-slot:item.consumption="{ item }">
            {{ (item.consumption || 0) | float }}
          </template>

          <template v-slot:item.actions="{ item }">
            <v-row>
              <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn color="primary" dark icon v-bind="attrs" v-on="on">
                    <v-icon>mdi-dots-horizontal</v-icon>
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item
                    :key="index"
                    v-for="(option, index) in optionLinks"
                  >
                    <v-list-item-title small>
                      <v-btn
                        text
                        @click.prevent="
                          $inertia.get(`${url}/${item.id}${option.link}`)
                        "
                      >
                        <v-icon left>mdi-{{ option.icon }}</v-icon>
                        {{ option.text }}
                      </v-btn>
                    </v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </v-row>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>

    <delete-modal
      v-model="modal.showDelete"
      @delete-action="deleteAction"
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
              v-for="(item, name) in options"
              :key="name"
              :items="options[name]"
              v-model="queryParams.filters[name]"
              :label="filterLabels[name]"
              multiple
              dense
            ></v-autocomplete>
            <range-date-picker
              v-model="queryParams.filters.insuranceTillDate"
              label="Asigurare expira in"
            />
            <range-date-picker
              v-model="queryParams.filters.roadTaxTillDate"
              label="Rovinieta expira in"
            />
            <range-date-picker
              v-model="queryParams.filters.tehnicalInspectionTillDate"
              label="ITP expira in"
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
      url: "/cars",
      headers: [
        { value: "area", text: "Zona" },
        { value: "city", text: "Oras" },
        { value: "licenseNo", text: "Nr inmatriculare" },
        { value: "model", text: "Model" },
        { value: "agent", text: "Agent" },
        { value: "fuel", text: "Combustibil" },
        /* { value: "productionYear", text: "An productie" }, */
        /* { value: "purchaseYear", text: "An achizitie" }, */
        { value: "type", text: "Tip" },
        /* { value: "engineCapacity", text: "Capacitate" }, */
        /* { value: "revisionInKm", text: "Revizie in (km)" }, */
        /* { value: "horsePower", text: "Cai putere" }, */
        /* { value: "chassis", text: "Serie sasiu" }, */
        { value: "insuranceTillDate", text: "RCA pana" },
        { value: "roadTaxTillDate", text: "Rovinieta pana" },
        { value: "tehnicalInspectionTillDate", text: "ITP pana" },
        /* { value: "fuelCard", text: "Card" }, */
        /* { value: "fuelPin", text: "Pin" }, */
        { value: "consumption", text: "Consum" },
        /* { value: "needsRoadTax", text: "Are nevoie de rovinieta" }, */
        /* { value: "distributionInYears", text: "Distributie in (ani)" }, */
        /* { value: "distributionInKm", text: "Distributie in (km)" }, */
        { value: "actions", text: "Actiuni" },
      ],
      filterLabels: {
        area: "Zona",
        city: "Oras",
        model: "Model",
        fuel: "Combustibil",
        type: "Tip",
      },
      optionLinks: [
        { text: "Modifica", icon: "pencil", link: "" },
        { text: "Combustibil", icon: "fuel", link: "/fuel" },
        { text: "Revizii", icon: "wrench", link: "/review" },
      ],
      modal: {
        selectedId: null,
        showDelete: false,
        showFilters: false,
      },
    };
  },

  methods: {
    deleteAction() {
      this.$inertia.delete(`${this.url}/${this.modal.selectedId}`);
    },
    showDeleteModal(id) {
      this.modal.selectedId = id;
      this.modal.showDelete = true;
    },
    getColorForDate(dateString) {
      let dateInstance = this.$date(dateString);
      let alertDate = this.$date().subtract(30, "days");

      return dateInstance.isAfter(alertDate) ? "red" : "light-blue";
    },
  },

  watch: {},

  created() {},
};
</script>
