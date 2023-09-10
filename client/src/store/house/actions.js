import HTTP from "../../plugins/axiosConfig"

export default {
    // Действия для загрузки данных о домах, например:
    async fetchHouses({ commit }, searchParams) {
        commit('setLoading', true);
        try {
            const response = await HTTP.get(`houses${searchParams}`);

            commit('setHouses', response.data.data);
            commit('setCurrentPage', response.data.meta.current_page);
            commit('setTotal', response.data.meta.total);
        } catch (error) {
            console.error('Error:', error);
        } finally {
            commit('setLoading', false);
        }
    }
};
