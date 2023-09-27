<script setup>
import MainCard from "@/Components/MainCard.vue";
import Table from "@/Pages/Pegawai/PegawaiRiwayatPendidikan/Table.vue";

const props = defineProps({
    title:''
})
</script>

<template>
    <div class="text-sm breadcrumbs">
        <ul>
            <li><a>Beranda</a></li>
            <li>Pegawai</li>
            <li><span class="text-info">{{title}}</span></li>
        </ul>
    </div>
    <MainCard :title="title">
        <Table/>
    </MainCard>
</template>
