<script setup>
import MainCard from "@/Components/MainCard.vue";
import { Link, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const props = defineProps({
    jabatanTukin: {
        type: Object,
        default: () => ({}),
    },
});

function rupiah(nominal) {
    return nominal.toLocaleString("id-ID", {
        style: "currency",
        minimumFractionDigits: 0,
        currency: "IDR",
    });
}

const form = useForm({});

function destroy(id) {
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Hapus data Tunjangan Kinerja Berdasarkan Jabatan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya",
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route("jabatan-tukin.destroy", id), {
                onSuccess: (response) => {
                    Swal.fire(
                        "Berhasil!",
                        "Data gaji berhasil dihapus.",
                        "success",
                    );
                    // form.reset(); // ini untuk reset inputan tanpa merefresh halaman atau tanpa balik ke index
                    router.get(route("jabatan-tukin.index"));
                },
                onError: (errors) => {
                    if (errors.query) {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Hapus data Tunjangan Kinerja Berdasarkan Jabatan gagal",
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
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a href="/">Beranda</a></li>
            <li><a href="/jabatan-tukin">Tunjangan Kinerja Jabatan</a></li>
        </ul>
    </div>

    <MainCard>
        <div class="overflow-x-auto">
            <div class="py-4">
                <Link :href="route('jabatan-tukin.create')">
                    <button class="btn btn-primary">Tambah</button>
                </Link>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Jabatan</th>
                        <th>Nama Jabatan</th>
                        <th>Grade Tukin</th>
                        <th>Nominal Tukin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(mdata, index) in jabatanTukin"
                        :key="mdata.id"
                        class="hover"
                    >
                        <td>{{ index + 1 }}</td>
                        <td>{{ mdata.jenis_jabatan }}</td>
                        <td>{{ mdata.nama_jabatan }}</td>
                        <td>{{ mdata.grade }}</td>
                        <td>{{ rupiah(mdata.nominal) }}</td>
                        <td>
                            <Link
                                :href="route('jabatan-tukin.edit', mdata.id)"
                                class="btn btn-primary btn-xs mr-2"
                                >Edit</Link
                            >
                            <button
                                class="btn btn-error btn-xs"
                                @click="destroy(mdata.id)"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </MainCard>
</template>
