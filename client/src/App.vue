<template>
    <div id="app">
        <header>
            <h1>House Search App</h1>
        </header>
        <main>
            <HouseSearch />
            <HouseTable />
        </main>
    </div>
</template>

<script>
import HouseSearch from './components/HouseSearch.vue';
import HouseTable from './components/HouseTable.vue';

export default {
    components: {
        HouseSearch,
        HouseTable,
    },
};
</script>

<style>
/* Ваши стили здесь */
</style>
