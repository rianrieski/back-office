<script setup>
import MainCard from "@/Components/MainCard.vue";
import { Link, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const props = defineProps({
    gaji: {
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
        text: "Hapus data gaji",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya",
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route("gaji.destroy", id), {
                onSuccess: (response) => {
                    Swal.fire(
                        "Berhasil!",
                        "Data gaji berhasil dihapus.",
                        "success",
                    );
                    // form.reset(); // ini untuk reset inputan tanpa merefresh halaman atau tanpa balik ke index
                    router.get(route("gaji.index"));
                },
                onError: (errors) => {
                    if (errors.query) {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Hapus gaji gagal",
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
            <li><a href="/gaji">Gaji</a></li>
        </ul>
    </div>

    <MainCard>
        <div class="overflow-x-auto">
            <div class="py-4">
                <Link :href="route('gaji.create')">
                    <button class="btn btn-primary">Tambah</button>
                </Link>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Golongan</th>
                        <th>Masa Kerja</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(mdata, index) in gaji"
                        :key="mdata.id"
                        class="hover"
                    >
                        <th>{{ index + 1 }}</th>
                        <td>{{ mdata.golongan }}</td>
                        <td>{{ mdata.masa_kerja }}</td>
                        <td>{{ rupiah(mdata.nominal) }}</td>
                        <td>
                            <Link
                                :href="route('gaji.edit', mdata.id)"
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
