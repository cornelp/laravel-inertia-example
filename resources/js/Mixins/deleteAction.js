export default {
    data() {
        return {
            modal: {
                selectedId: null,
                showDelete: false
            }
        };
    },

    methods: {
        deleteAction() {
            this.$inertia.delete(`${this.url}/${this.modal.selectedId}`);
        },
        showDeleteModal(id) {
            this.modal.selectedId = id;
            this.modal.showDelete = true;
        }
    }
};
