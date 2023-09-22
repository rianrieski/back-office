<script setup>
import MainCard from "@/Components/MainCard.vue";
import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { useLocaleDateTime } from "@/Composables/filters.ts";

const props = defineProps(["siasn", "siap", "unorInduk", "unor"]);

const rows = computed(() => {
    return [
        {
            label: "Nama Lengkap",
            siasn: props.siasn.nama,
            siap: props.siap?.Nama,
        },
        {
            label: "NIP",
            siasn: props.siasn.nipBaru,
            siap: props.siap?.NIPBaru,
        },
        {
            label: "NIK",
            siasn: props.siasn.nik,
            siap: props.siap?.NIK,
        },
        {
            label: "Kedudukan Hukum",
            siasn: props.siasn.kedudukanPnsNama,
            siap: props.siap?.kedudukan.Kedudukan,
        },
        {
            label: "Jenis Pegawai",
            siasn: props.siasn.jenisPegawaiNama,
            siap: props.siap?.jenis_pegawai.JenisPegawai,
        },
        {
            label: "Status Pegawai",
            siasn: props.siasn.statusPegawai,
            siap: props.siap?.status_pegawai.StatusPegawai,
        },
        {
            label: "Gelar Depan",
            siasn: props.siasn.gelarDepan,
            siap: props.siap?.GelarDepan,
        },
        {
            label: "Gelar Belakang",
            siasn: props.siasn.gelarBelakang,
            siap: props.siap?.GelarBelakang,
        },
        {
            label: "Jenis Kelamin",
            siasn: props.siasn.jenisKelamin === "M" ? "Laki-laki" : "Perempuan",
            siap: props.siap?.JenisKelamin === "L" ? "Laki-laki" : "Perempuan",
        },
        {
            label: "Tempat Lahir",
            siasn: props.siasn.tempatLahir,
            siap: props.siap?.TempatLahir,
        },
        {
            label: "Tanggal Lahir",
            siasn: props.siasn.tglLahir,
            siap: props.siap?.TglLahir,
        },
        {
            label: "Agama",
            siasn: props.siasn.agama,
            siap: props.siap?.agama.Agama,
        },
        {
            label: "Alamat",
            siasn: props.siasn.alamat,
            siap: props.siap?.Alamat,
        },
        {
            label: "Nomor Handphone",
            siasn: props.siasn.noHp,
            siap: props.siap?.hp,
        },
        {
            label: "Email",
            siasn: props.siasn.email,
            siap: props.siap?.Email,
        },
        {
            label: "Status Pernikahan",
            siasn: props.siasn.statusPerkawinan,
            siap: props.siap?.StatusKawin,
        },
        {
            label: "Golongan - Pangkat Terakhir",
            siasn: `${props.siasn.golRuangAkhir} - ${props.siasn.pangkatAkhir}`,
            siap: `${props.siap?.pangkat_terakhir.KodePangkat} - ${props.siap?.pangkat_terakhir.Pangkat}`,
        },
        {
            label: "TMT Pangkat",
            siasn: props.siasn.tmtGolAkhir,
            siap: props.siap?.riwayat_pangkat_terakhir.TMTPangkat,
        },
        {
            label: "TMT Pensiun",
            siasn: props.siasn.tmtPensiun,
            siap: props.siap?.TglPensiun,
        },
        {
            label: "Nama Unor Induk",
            siasn: props.siasn.unorIndukNama,
            siap: props.unorInduk?.Satker,
        },
        {
            label: "Nama Unor",
            siasn: props.siasn.unorNama,
            siap: props.unor?.Satker,
        },
        {
            label: "Nama Jabatan",
            siasn: props.siasn.jabatanNama,
            siap: props.siap?.riwayat_jabatan_terakhir.NamaJabatan,
        },
        {
            label: "Jenis Jabatan",
            siasn: props.siasn.jenisJabatan,
            siap: props.siap?.tipe_pegawai.Deskripsi,
        },
        {
            label: "TMT Jabatan",
            siasn: props.siasn.tmtJabatan,
            siap: props.siap?.riwayat_jabatan_terakhir.TMTJabatan,
        },
        {
            label: "Nomor Taspen",
            siasn: props.siasn.noTaspen,
            siap: props.siap?.Taspen,
        },
        {
            label: "Nomor BPJS",
            siasn: props.siasn.bpjs,
            siap: props.siap?.bpjs,
        },
        {
            label: "Kartu ASN",
            siasn: props.siasn.kartuAsn,
            siap: props.siap?.kartuAsn,
        },
    ];
});

const loading = ref(false);
const updatedAt = computed(() =>
    useLocaleDateTime(new Date(props.siasn.updated_at)),
);

const updateSiasn = () => {
    router.post(
        route("fetch-pns-data-utama"),
        { nip: props.siasn.nipBaru },
        {
            replace: true,
            preserveScroll: true,
            onStart: () => (loading.value = true),
            onFinish: () => (loading.value = false),
        },
    );
};
</script>

<template>
    <Head title="SIASN - Data ASN" />

    <MainCard title="Data ASN">
        <div class="mt-8">
            <div>
                <button
                    class="btn btn-primary btn-outline btn-sm"
                    @click="updateSiasn"
                    :disabled="loading"
                >
                    Update Data SIASN
                    <span class="loading loading-spinner" v-if="loading" />
                </button>
                <div class="mt-1 text-xs italic text-gray-800">
                    Terakhir diupdate: {{ updatedAt }}
                </div>
            </div>
            <table class="table mt-4 w-full">
                <tr class="bg-base-300">
                    <th class="w-1/5"></th>
                    <th class="w-2/5">Data SIASN</th>
                    <th class="w-2/5">Data Simpeg/SIAP BSN</th>
                </tr>
                <tbody>
                    <tr v-for="(row, i) in rows" :key="i" class="hover">
                        <th>{{ row.label }}</th>
                        <td>{{ row.siasn }}</td>
                        <td>{{ row.siap }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </MainCard>
</template>
