<script setup>
import MainCard from "@/Components/MainCard.vue";
import Table from "@/Pages/HirarkiUnitKerja/Table.vue";
defineProps({
    title:String,
})
</script>

<template>
    <div class="text-sm breadcrumbs">
        <ul>
            <li><a>Beranda</a></li>
            <li>Master Data</li>
            <li><span class="text-info">Hirarki Unit Kerja</span></li>
        </ul>
    </div>
<MainCard :title="title">
    <Table/>
</MainCard>
</template>

<style scoped>

</style>
