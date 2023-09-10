export default {
    setHouses(state, houses) {
        state.houses = houses;
    },
    setLoading(state, loading) {
        state.loading = loading;
    },
    setCurrentPage(state, page) {
        state.currentPage = page;
    },
    setTotal(state, payload) {
        state.total = payload;
    },
};
