<script setup>
import MainCard from "@/Components/MainCard.vue";
import Table from "@/Pages/Pegawai/PegawaiSuamiIstri/Table.vue";
defineProps({
    'title':''
})
</script>

<template>
    <MainCard :title="title">
        <Table/>
    </MainCard>
</template>

