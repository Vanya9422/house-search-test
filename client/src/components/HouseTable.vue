<template>
    <div>
        <el-table :data="houses" style="width: 100%" v-loading="loading">
            <el-table-column prop="name" label="Name"></el-table-column>
            <el-table-column prop="bedrooms" label="Bedrooms"></el-table-column>
            <el-table-column prop="bathrooms" label="Bathrooms"></el-table-column>
            <el-table-column prop="storeys" label="Storeys"></el-table-column>
            <el-table-column prop="garages" label="Garages"></el-table-column>
            <el-table-column prop="price" label="Price"></el-table-column>
        </el-table>
        <el-pagination @current-change="handlePageChange" :current-page="currentPage" :page-size="per_page" :total="total"/>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
    data() {
        return {
            page: 1,
            per_page: 40,
        };
    },
    computed: {
        ...mapGetters('house', ['houses', 'loading', 'currentPage', 'total']),
    },
    methods: {
        ...mapActions('house', ['fetchHouses']),
        handlePageChange(page) {
            // Вызывайте метод для загрузки данных с новой страницей
            this.fetchHouses(`?page=${page}&per_page=40`);
        },
    },
    created() {
        // Вызываем поиск домов при инициализации компонента
        this.fetchHouses('?page=1&per_page=40');
    },
};
</script>
