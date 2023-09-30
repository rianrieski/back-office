<script setup>
import MainCard from "@/Components/MainCard.vue";
import Table from "@/Pages/HirarkiUnitKerja/Table.vue";
import SearchInput from "@/Components/SearchInput.vue";
import { ref } from "vue";
import PerPageOption from "@/Components/PerPageOption.vue";

defineProps({
    unitkerja: Object,
});

const keyword = ref(null);
const perPage = ref(15);

const fetchData = (params = {}) => {
    //
};
</script>

<template>
    <Head title="Daftar Unit Kerja" />

    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Beranda</a></li>
            <li>Master Data</li>
            <li><span class="text-info">Hirarki Unit Kerja</span></li>
        </ul>
    </div>
    <MainCard title="Daftar Unit Kerja">
        <div class="mt-8 flex justify-between">
            <button class="btn btn-primary btn-outline">
                Rekam Unit Kerja Baru
            </button>
            <div class="flex gap-2">
                <SearchInput :search="() => fetchData()" v-model="keyword" />
                <PerPageOption v-model="perPage" @change="() => fetchData()" />
            </div>
        </div>
        <div>
            <table class="table"></table>
        </div>
    </MainCard>
</template>
