<template>
  <div>
    <b-form @submit.prevent="saveUser">
      <b-form-group label="Name" label-for="name">
        <b-form-input
          id="name"
          v-model="form.name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group label="Email" label-for="email">
        <b-form-input
          id="email"
          v-model="form.email"
          type="text"
          required
        ></b-form-input>
      </b-form-group>

      <b-button variant="primary" type="submit">
        Save
        <b-icon-check v-if="showAlert" />
      </b-button>
      <b-button variant="info" @click="goBack()">Back</b-button>
    </b-form>
  </div>
</template>

<script>
export default {
  props: {
    user: { type: Object, default: () => ({ id: 0 }) },
  },

  data: () => ({
    form: {},
    showAlert: false,
  }),

  methods: {
    goBack() {
      window.history.back();
    },
    saveUser() {
      this.$inertia.patch(`/users/${this.user.id}`, this.form);

      this.showAlert = true;

      setTimeout(() => (this.showAlert = false), 1000);
    },
  },

  mounted() {
    this.form = this.user;
  },
};
</script>
