<script setup>
import MainCard from "@/Components/MainCard.vue";
import { Link, useForm } from "@inertiajs/vue3";
import Swal from 'sweetalert2';

const props = defineProps({
    jabatanUnitKerja: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({});

function destroy(id) {
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Hapus data Jabatan Unit Kerja",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya",
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route("jabatan-unit-kerja.destroy", id), {
                onSuccess: (response) => {
                    Swal.fire(
                        "Berhasil!",
                        "Data Jabatan Unit Kerja berhasil dihapus.",
                        "success",
                    );
                    // form.reset(); // ini untuk reset inputan tanpa merefresh halaman atau tanpa balik ke index
                    router.get(route("jabatan-unit-kerja.index"));
                },
                onError: (errors) => {
                    if (errors.query) {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Hapus Jabatan Unit Kerja gagal",
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                },
            });
        }
    });
}

</script>

<template>


    <MainCard>

        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="/">Beranda</a></li>
                <li><a href="/jabatan-unit-kerja">Jabatan Unit Kerja</a></li>

            </ul>
        </div>

        <div class="overflow-x-auto">

            <div class="py-4">
                <Link :href="route('jabatan-unit-kerja.create')">
                    <button class="btn btn-primary">Tambah</button>
                </Link>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Jabatan</th>
                    <th>Nama Jabatan</th>
                    <th>Nama Unit Kerja</th>
                    <th style="min-width: 150px;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <tr  v-for="(mdata,index) in jabatanUnitKerja" :key="mdata.id" class="hover">
                    <th>{{ index + 1 }}</th>
                    <td>{{ mdata.jenis_jabatan }}</td>
                    <td>{{ mdata.nama_jabatan }}</td>
                    <td>{{ mdata.nama_unit_kerja }}</td>
                    <td>
                        <Link :href="route('jabatan-unit-kerja.edit', mdata.id)
                            " class="btn btn-primary btn-xs mr-2">Edit</Link>
                            <button class="btn btn-error btn-xs"  @click="destroy(mdata.id)">Hapus</button>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </MainCard>
</template>
