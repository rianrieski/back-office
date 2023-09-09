<script setup>

import MainCard from "@/Components/MainCard.vue";
import Table from "@/Pages/Pegawai/PegawaiSaldoCuti/Table.vue";
const props = defineProps({
    title : ''
})
</script>

<template>
    <MainCard :title="title">
        <Table/>
    </MainCard>
</template>
