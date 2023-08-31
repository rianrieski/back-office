<script setup>
import MainCard from "@/Components/MainCard.vue";
import { router } from "@inertiajs/vue3";
const tambahAlamat = ()=>{
    router.get('/pegawai/alamat/create');
}
</script>
<template>
    <div class="text-sm breadcrumbs">
        <ul>
            <li><a>Beranda</a></li>
            <li><a>Pegawai</a></li>
            <li>Alamat</li>
        </ul>
    </div>
    <MainCard>
        <div class="overflow-x-auto">
            <div class="py-4">
                <button class="btn btn-primary" @click="tambahAlamat">Tambah</button>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Propinsi</th>
                    <th>Kota/Kabupaten</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <tr class="hover">
                    <th>2</th>
                    <td>Ridhal Fajri</td>
                    <td>Domisili</td>
                    <td>Sumatera Barat</td>
                    <td>Tanah Datar</td>
                    <td>
                            <button class="btn btn-primary btn-xs mr-2">Edit</button>
                            <button class="btn btn-error btn-xs">Hapus</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </MainCard>
</template>
