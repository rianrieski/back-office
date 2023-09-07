<script setup>
import { Link, router } from "@inertiajs/vue3";
import MainCard from "@/Components/MainCard.vue";
</script>

<template>
    <div>
        <Head title="Riwayat Jabatan" />
        <div class="breadcrumbs text-sm">
            <ul>
                <li><a>Beranda</a></li>
                <li>Pegawai</li>
                <li><span class="text-info">Riwayat Jabatan Pegawai</span></li>
            </ul>
        </div>
        <MainCard> Halaman Index </MainCard>
    </div>
</template>
