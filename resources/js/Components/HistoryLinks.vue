<template>
  <div>
    <span v-for="(item, index) in links" :key="index">
      <v-btn text @click.prevent="$inertia.get(item.url)">
        {{ item.name }}
      </v-btn>

      <span v-if="index < links.length - 1"> > </span>
    </span>
  </div>
</template>

<script>
import { debounce } from "lodash";

export default {
  props: {
    navigationItems: { type: Array },
    url: { type: String },
  },

  data: () => ({
    links: [],
    translate: [
      { regex: "/agents/create", name: "Agent nou" },
      { regex: "/debts/create", name: "Datorie noua" },
      { regex: "/phones/create", name: "Sim nou" },
      { regex: "/phones/([0-9]+)", name: "Editeaza sim #0" },
      { regex: "/debts/create", name: "Adauga datorie #0" },
      { regex: "/debts/([0-9]{1,})$", name: "Editeaza datorie #0" },
    ],
  }),

  methods: {
    fetchLinks() {
      const links = JSON.parse(localStorage.getItem("history-links"));

      if (!links) {
        return;
      }

      this.links = links || [];
    },
    saveLinks() {
      localStorage.setItem("history-links", JSON.stringify(this.links));
    },
    addToLinks(item) {
      let url = item.split("?")[0];

      let existingIndex = this.links.findIndex((item) => item.shortUrl === url);

      const navigationItem = this.getNavigationName(url);

      if (!navigationItem) {
        return;
      }

      if (existingIndex > -1) {
        // remove from position
        this.links.splice(existingIndex, 1);
      }

      this.links.push({
        shortUrl: url,
        url: item,
        name: navigationItem ? navigationItem.name : url,
      });

      /* this.links = this.links.slice(this.links.length - 5, 5); */
      this.links = this.links.slice(-5);

      this.saveLinks();
    },
    getNavigationName(url) {
      let navigationItem = [...this.translate].find((item) => {
        const found = url.match(item.regex);

        // whenever we have placeholders
        if (found && found.length > 1) {
          // remove first element
          found.shift();

          // make the necessary modifications
          found.forEach((i) => {
            let replaced = item.name.replace(/#[0-9]+/, `#${i}`);

            item.name = replaced;
          });
        }

        return found && found.length;
      });

      if (navigationItem && navigationItem.hasOwnProperty("name")) {
        return navigationItem;
      }

      navigationItem = this.navigationItems.find((item) => item.link === url);

      if (navigationItem) {
        return navigationItem;
      }
    },
  },

  watch: {
    url: debounce(function (value) {
      this.addToLinks(value);
    }, 200),
  },

  beforeMount() {
    this.fetchLinks();
  },

  created() {},
};
</script>
