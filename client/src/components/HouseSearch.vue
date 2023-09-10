<!-- src/components/HouseSearch.vue -->

<template>
    <div>
        <el-form inline>
            <el-row>
                <el-form-item label="Name">
                    <el-input v-model="searchForm.name" type="text"></el-input>
                </el-form-item>
                <el-form-item label="Bedrooms">
                    <el-input v-model="searchForm.bedrooms" type="number"></el-input>
                </el-form-item>
                <el-form-item label="Bathrooms">
                    <el-input v-model="searchForm.bathrooms" type="number"></el-input>
                </el-form-item>
            </el-row>
            <el-row>
                <el-form-item label="Storeys">
                    <el-input v-model="searchForm.storeys" type="number"></el-input>
                </el-form-item>
                <el-form-item label="Garages">
                    <el-input v-model="searchForm.garages" type="number"></el-input>
                </el-form-item>
                <el-form-item label="Price Range">
                    <el-input v-model="searchForm.minPrice" type="number" placeholder="Min Price"></el-input>
                    <span>-</span>
                    <el-input v-model="searchForm.maxPrice" type="number" placeholder="Max Price"></el-input>
                </el-form-item>
            </el-row>
            <el-row>
                <el-form-item>
                    <el-button type="primary" class="right" @click="onSubmit" :disabled="Disabled">Search</el-button>
                    <el-button type="info" class="right" @click="reset" :disabled="Disabled">Reset</el-button>
                </el-form-item>
            </el-row>
        </el-form>
    </div>
</template>

<script>
import {mapState, mapActions} from 'vuex';

export default {
    data() {
        return {
            searchForm: {
                name: null,
                bedrooms: null,
                bathrooms: null,
                storeys: null,
                garages: null,
                minPrice: null,
                maxPrice: null,
            },
            page: 1,
            per_page: 40,
            params: null
        };
    },
    computed: {
        ...mapState('house', ['houses']),
        Disabled() {
            for (let key in this.searchForm)
                if (this.searchForm[key] !== null && this.searchForm[key] !== '') return false;

            return true;
        }
    },
    watch: {
        searchForm: {
            handler(formData) {
                let url = '';

                for (let key in formData) {
                    if (formData[key] && key !== 'minPrice') {

                        if (key === 'maxPrice') {
                            if (!formData.minPrice && formData.maxPrice) {
                                url += `price:0,${formData.maxPrice};`
                            }

                            if (formData.minPrice && formData.maxPrice) {
                                url += `price:${formData.minPrice + ',' + formData.maxPrice};`
                            }

                        } else {
                            url += `${key}:${formData[key]};`
                        }
                    }

                    if (key === 'maxPrice' && !formData.maxPrice && formData.minPrice) {
                        url += `price:${formData.minPrice}&searchFields=price:>;`
                    }
                }

                url = url.slice(0, -1) + ''

                this.params = `?page=${this.page}&per_page=${this.per_page}&searchJoin=and&search=${url}`
            },
            deep: true,
        },
    },
    methods: {
        ...mapActions('house', ['fetchHouses']),
        onSubmit() {
            this.fetchHouses(this.params).then(res => {
                console.log(res)
            })
        },
        reset() {
            for (let key in this.searchForm) {
                this.searchForm[key] = null
            }

            this.fetchHouses('?page=1&per_page=40')
        }
    },
};
</script>
<style>
.demo-form-inline .el-input {
    --el-input-width: 220px;
}
</style>
