<script setup>
import MainCard from "@/Components/MainCard.vue";

defineProps({
    pegawai: Object,
    media_foto_pegawai: String,
    media_kartu_pegawai: String,
});

const tanggalFormat = (dateString) => {
    const date = new Date(dateString);

    return date.toLocaleDateString("ID");
};
</script>

<template>
    <div>
        <Head title="Lihat Pegawai" />

        <MainCard>
            <h2
                class="mb-4 text-center text-2xl font-semibold text-gray-700 dark:text-gray-500"
            >
                Data Pegawai
            </h2>
            <div class="grid grid-cols-6 gap-4">
                <table class="col-span-4 text-left">
                    <tr>
                        <th class="align-top">Nomor Induk Kependudukan</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">{{ pegawai.nik }}</td>
                    </tr>
                    <tr>
                        <th class="align-top">Nomor Induk Pegawai</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">{{ pegawai.nip }}</td>
                    </tr>
                    <tr>
                        <th class="align-top">Nama Lengkap</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">
                            {{ pegawai.nama_depan }} {{ pegawai.nama_belakang }}
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">Jenis Kelamin</th>
                        <td class="px-2 align-top">:</td>
                        <td
                            class="align-top"
                            v-if="pegawai.jenis_kelamin == 'L'"
                        >
                            Laki-laki
                        </td>
                        <td
                            class="align-top"
                            v-if="pegawai.jenis_kelamin == 'P'"
                        >
                            Perempuan
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">Agama</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">{{ pegawai.agama.nama }}</td>
                    </tr>
                    <tr>
                        <th class="align-top">Golongan Darah</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">{{ pegawai.golongan_darah }}</td>
                    </tr>
                    <tr>
                        <th class="align-top">Status Nikah</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">
                            {{ pegawai.jenis_kawin.nama }}
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">Tempat, Tanggal Lahir</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">
                            {{ pegawai.tempat_lahir }},
                            {{ tanggalFormat(pegawai.tanggal_lahir) }}
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">Email Kantor</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">{{ pegawai.email_kantor }}</td>
                    </tr>
                    <tr>
                        <th class="align-top">Email Pribadi</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">{{ pegawai.email_pribadi }}</td>
                    </tr>
                    <tr>
                        <th class="align-top">No Telepon</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">{{ pegawai.no_telp }}</td>
                    </tr>
                    <tr>
                        <th class="align-top">Jenis Pegawai</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">
                            {{ pegawai.jenis_pegawai.nama }}
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">Status Pegawai</th>
                        <td class="px-2 align-top">:</td>
                        <td class="align-top">
                            {{ pegawai.status_pegawai.nama }}
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">Status Dinas</th>
                        <td class="px-2 align-top">:</td>
                        <td v-if="pegawai.status_dinas == 0" class="align-top">
                            Aktif
                        </td>
                        <td v-if="pegawai.status_dinas == 1" class="align-top">
                            Tidak Aktif
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">Tanggal Berhenti</th>
                        <td class="px-2 align-top">:</td>
                        <td
                            v-if="pegawai.tanggal_berhenti != null"
                            class="align-top"
                        >
                            {{ tanggalFormat(pegawai.tanggal_berhenti) }}
                        </td>
                        <td
                            v-if="pegawai.tanggal_berhenti == null"
                            class="align-top"
                        >
                            -
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">Tanggal Wafat</th>
                        <td class="px-2 align-top">:</td>
                        <td
                            v-if="pegawai.tanggal_wafat != null"
                            class="align-top"
                        >
                            {{ tanggalFormat(pegawai.tanggal_wafat) }}
                        </td>
                        <td
                            v-if="pegawai.tanggal_wafat == null"
                            class="align-top"
                        >
                            -
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">No BPJS</th>
                        <td class="px-2 align-top">:</td>
                        <td v-if="pegawai.no_bpjs != null" class="align-top">
                            {{ pegawai.no_bpjs }}
                        </td>
                        <td v-if="pegawai.no_bpjs == null" class="align-top">
                            -
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">No Taspen</th>
                        <td class="px-2 align-top">:</td>
                        <td v-if="pegawai.no_taspen != null" class="align-top">
                            {{ pegawai.no_taspen }}
                        </td>
                        <td v-if="pegawai.no_taspen == null" class="align-top">
                            -
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">NPWP</th>
                        <td class="px-2 align-top">:</td>
                        <td v-if="pegawai.npwp != null" class="align-top">
                            {{ pegawai.npwp }}
                        </td>
                        <td v-if="pegawai.npwp == null" class="align-top">-</td>
                    </tr>
                    <tr>
                        <th class="align-top">No Fingerprint</th>
                        <td class="px-2 align-top">:</td>
                        <td v-if="pegawai.no_enroll != null" class="align-top">
                            {{ pegawai.no_enroll }}
                        </td>
                        <td v-if="pegawai.no_enroll == null" class="align-top">
                            -
                        </td>
                    </tr>
                    <tr>
                        <th class="align-top">Kartu Pegawai</th>
                        <td class="px-2 align-top">:</td>
                        <td
                            v-if="pegawai.no_kartu_pegawai != null"
                            class="align-top"
                        >
                            {{ pegawai.no_kartu_pegawai }}
                        </td>
                        <td
                            v-if="pegawai.no_kartu_pegawai == null"
                            class="align-top"
                        >
                            -
                        </td>
                    </tr>
                </table>
                <div class="col-span-2">
                    <img
                        :src="media_foto_pegawai"
                        class="mb-4 rounded-md border-2"
                        alt=""
                    />
                    <img
                        :src="media_kartu_pegawai"
                        class="rounded-md border-2"
                        alt=""
                    />
                </div>
            </div>
        </MainCard>
    </div>
</template>
