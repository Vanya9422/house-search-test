export default {
    // Геттеры для доступа к данным о домах, например:
    houses: state => state.houses,
    loading: state => state.loading,
    currentPage: state => state.currentPage, // Геттер для текущей страницы
    total: state => state.total
};
