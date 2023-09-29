<script setup>
import MainCard from "@/Components/MainCard.vue";
import { useForm } from "@inertiajs/vue3";
import FormBody from "@/Pages/Pegawai/PegawaiAlamat/components/FormBody.vue";
import { useToast } from "@/Composables/sweetalert.ts";

const props = defineProps({
    title: String,
    pegawaiAlamat: "",
    pegawai: "",
    propinsi: "",
    kota: Object,
    kecamatan: Object,
    desa: Object,
});
const form = useForm({
    tipe_alamat: props.pegawaiAlamat.tipe_alamat,
    propinsi_id: props.pegawaiAlamat.propinsi_id,
    kota_id: props.pegawaiAlamat.kota_id,
    kecamatan_id: props.pegawaiAlamat.kecamatan_id,
    desa_id: props.pegawaiAlamat.desa_id,
    kode_pos: props.pegawaiAlamat.kode_pos,
    row: props.pegawaiAlamat.row,
    pegawai_id: props.pegawaiAlamat.pegawai_id,
    alamat: props.pegawaiAlamat.alamat,
});
const submit = () => {
    form.put(route("alamat.update", props.pegawaiAlamat.id), {
        preserveScroll: true,
        preserveState: true,
        replace: true,
        onError: (errors) =>
            useToast({ icon: "error", text: Object.values(errors)[0] }),
    });
};
</script>

<template>
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Beranda</a></li>
            <li>Pegawai</li>
            <li>
                <Link href="/pegawai/row">Alamat</Link>
            </li>
            <li>
                <span class="text-info">{{ title }}</span>
            </li>
        </ul>
    </div>
    <MainCard>
        <div class="m-auto w-full p-6 lg:max-w-xl">
            <h2 class="text-center text-2xl font-semibold text-gray-700">
                {{ title }}
            </h2>
            <form class="space-y-4" @submit.prevent="submit">
                <FormBody
                    v-model:pegawai_id="form.pegawai_id"
                    v-model:tipe_alamat="form.tipe_alamat"
                    v-model:propinsi_id="form.propinsi_id"
                    v-model:kota_id="form.kota_id"
                    v-model:kecamatan_id="form.kecamatan_id"
                    v-model:desa_id="form.desa_id"
                    v-model:kode_pos="form.kode_pos"
                    v-model:alamat="form.alamat"
                />
                <div class="flex justify-end gap-2">
                    <button
                        class="btn btn-neutral btn-outline"
                        onclick="window.history.back()"
                    >
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </MainCard>
</template>

<style scoped></style>
