<template>
  <v-app>
    <v-navigation-drawer app expand-on-hover>
      <v-list nav dense>
        <v-list-item-group>
          <v-list-item
            @click.prevent="goTo(item.link)"
            v-for="(item, index) in navigationItems"
            :key="index"
          >
            <v-list-item-icon>
              <v-icon>mdi-{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-title>{{ item.name }}</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app color="primary" dark>
      <v-toolbar-title>
        <history-links
          :navigationItems="navigationItems"
          :url="$inertia.page.url"
        />
      </v-toolbar-title>
      <v-spacer />
    </v-app-bar>

    <!-- Sizes your content based upon application components -->
    <v-main>
      <v-container fluid>
        <slot />

        <v-snackbar
          v-if="flash"
          v-model="showSnackbar"
          absolute
          right
          top
          elevation="24"
          color="blue-grey"
        >
          {{ flash }}
        </v-snackbar>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import HistoryLinks from "Components/HistoryLinks";

export default {
  props: {
    flash: { type: String },
  },

  components: { HistoryLinks },

  data: () => ({
    showDrawer: false,
    showSnackbar: false,
    navigationItems: [
      { icon: "car", name: "Parc auto", link: "/cars" },
      { icon: "account", name: "Agenti", link: "/agents" },
      { icon: "phone", name: "Sim-uri", link: "/phones" },
      { icon: "bag-suitcase", name: "Datorii", link: "/debts" },
    ],
  }),

  methods: {
    toggleDrawer() {
      this.showDrawer = !this.showDrawer;
    },
    goTo(link) {
      this.$inertia.get(link);
      this.toggleDrawer();
    },
  },

  watch: {},

  created() {
    if (this.flash && this.flash.length > 0) {
      this.showSnackbar = true;
    }
  },
};
</script>
