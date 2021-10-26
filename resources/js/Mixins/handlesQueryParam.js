import { debounce, pickBy } from "lodash";
export default {
    props: {
        query: { type: Object, default: () => ({ filters: {} }) }
    },

    data() {
        return {
            queryParams: {
                search: this.query.search,
                page: Number(this.query.page),
                itemsPerPage: Number(this.query.itemsPerPage),
                sortBy: this.query.sortBy,
                sortDesc: this.query.sortDesc,
                filters: Object.keys(this.query.filters || {}).reduce(
                    (acc, key) => {
                        acc[key] = this.query.filters[key].map(item =>
                            isNaN(item) ? item : Number(item)
                        );

                        return acc;
                    },
                    {}
                )
            },
            url: "/no-url"
        };
    },

    methods: {
        sanitizeQueryParam() {
            // make sure we reset page no when search param has changed
            const queryPage = Number(this.query.page);
            const queryParamsPage = Number(this.queryParams.page);

            if (queryParamsPage === queryPage && queryParamsPage > 1) {
                this.queryParams.page = 1;
            }

            return pickBy(this.queryParams, (item, index) => {
                if (!item) {
                    return false;
                }

                // check if is primitive, let it slide
                if (!isNaN(item)) {
                    return true;
                }

                const firstKey = Object.keys(item)[0];

                if (!firstKey || !item[firstKey]) {
                    return false;
                }

                return true;
            });
        },
        resetFilters() {
            this.queryParams.filters = {};
        }
    },

    computed: {
        appliedFiltersNo() {
            return Object.keys(this.queryParams.filters).reduce((acc, key) => {
                const item = this.queryParams.filters[key];

                acc += item && item.length ? 1 : 0;

                return acc;
            }, 0);
        }
    },

    watch: {
        queryParams: {
            deep: true,
            handler: debounce(function() {
                const params = this.sanitizeQueryParam();

                this.$inertia.get(this.url, params, {
                    preserveState: true,
                    replace: true
                });
            }, 200)
        }
    }
};
