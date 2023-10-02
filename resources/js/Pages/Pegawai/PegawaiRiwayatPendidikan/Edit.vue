<script setup>
import MainCard from "@/Components/MainCard.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "@/Composables/sweetalert.ts";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import FormBody from "@/Pages/Pegawai/PegawaiRiwayatPendidikan/components/FormBody.vue";

const props = defineProps([
    "title",
    "pegawai",
    "pendidikan",
    "propinsi",
    "riwayatPendidikan",
    "kota",
]);

const form = useForm({
    pegawai_id: props.riwayatPendidikan.pegawai_id,
    pendidikan_id: props.riwayatPendidikan.pendidikan_id,
    nama_instansi: props.riwayatPendidikan.nama_instansi,
    propinsi_id: props.riwayatPendidikan.propinsi_id,
    kota_id: props.riwayatPendidikan.kota_id,
    alamat: props.riwayatPendidikan.alamat,
    no_ijazah: props.riwayatPendidikan.no_ijazah,
    tanggal_ijazah: props.riwayatPendidikan.tanggal_ijazah,
    kode_gelar_depan: props.riwayatPendidikan.kode_gelar_depan,
    kode_gelar_belakang: props.riwayatPendidikan.kode_gelar_belakang,
    media_ijazah: null,
});
const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: "put",
    })).post(route("riwayat-pendidikan.update", props.riwayatPendidikan), {
        onError: (errors) =>
            useToast({ icon: "error", text: Object.values(errors)[0] }),
    });
};
</script>

<template>
    <Head :title="title" />

    <Breadcrumb
        :lists="[
            { label: 'Beranda', url: route('dashboard') },
            { label: 'Pegawai', url: route('pegawai.index') },
            {
                label: 'Riwayat Pendidikan',
                url: route('riwayat-pendidikan.index'),
            },
            { label: title },
        ]"
    />

    <MainCard :title="title">
        <form class="mx-auto mt-8 lg:max-w-7xl" @submit.prevent="submit">
            <FormBody
                v-model:pegawai_id="form.pegawai_id"
                v-model:pendidikan_id="form.pendidikan_id"
                v-model:nama_instansi="form.nama_instansi"
                v-model:propinsi_id="form.propinsi_id"
                v-model:kota_id="form.kota_id"
                v-model:alamat="form.alamat"
                v-model:no_ijazah="form.no_ijazah"
                v-model:tanggal_ijazah="form.tanggal_ijazah"
                v-model:kode_gelar_belakang="form.kode_gelar_belakang"
                v-model:kode_gelar_depan="form.kode_gelar_depan"
                v-model:media_ijazah="form.media_ijazah"
            />

            <div class="mt-4 flex justify-end gap-2">
                <Link
                    class="btn btn-neutral btn-outline"
                    :href="route('riwayat-pendidikan.index')"
                    >Batal
                </Link>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </MainCard>
</template>
