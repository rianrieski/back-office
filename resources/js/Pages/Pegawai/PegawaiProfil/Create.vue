<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

import MainCard from "@/Components/MainCard.vue";

defineProps({
    agama: Array,
    statusNikah: Array,
    jenisPegawai: Array,
    statusPegawai: Array,
});

const form = useForm({
    nik: "",
    nip: "",
    nama_depan: "",
    nama_belakang: "",
    jenis_kelamin: "",
    agama_id: "",
    golongan_darah: "",
    jenis_kawin_id: "",
    tempat_lahir: "",
    tanggal_lahir: "",
    email_kantor: "",
    email_pribadi: "",
    no_telp: "",
    jenis_pegawai_id: "",
    status_pegawai_id: "",
    status_dinas: "",
    no_kartu_pegawai: "",
    tanggal_berhenti: "",
    tanggal_wafat: "",
    no_bpjs: "",
    no_taspen: "",
    npwp: "",
    no_enroll: "",
    media_foto_pegawai: "",
    media_kartu_pegawai: "",
});

const isLoading = ref(false);

const simpanPegawai = () => {
    form.post(route("profil_pegawai.store"), {
        preserveScroll: true,
        preserveState: true,
        replace: true,
        onBefore: () => {
            isLoading.value = true;
        },
        onSuccess: (response) => {
            Toast.fire({
                icon: "success",
                text: response.props.flash.success,
            });
        },
        onError: () => {
            isLoading.value = false;
        },
    });
};
</script>

<template>
    <div>
        <Head title="Tambah Pegawai" />
        <div class="breadcrumbs text-sm">
            <ul>
                <li><a>Beranda</a></li>
                <li>Pegawai</li>
                <li>Profil Pegawai</li>
                <li><span class="text-info">Tambah Pegawai</span></li>
            </ul>
        </div>
        <MainCard>
            <form @submit.prevent="simpanPegawai">
                <div class="grid grid-cols-6 gap-4">
                    <div class="form-control col-span-3">
                        <label class="label justify-start">
                            Nomor Induk Kependudukan
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <input
                            v-model="form.nik"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="form.errors.nik" class="text-error">
                            {{ form.errors.nik }}
                        </div>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label justify-start">
                            Nomor Induk Pegawai
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <input
                            v-model="form.nip"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="form.errors.nip" class="text-error">
                            {{ form.errors.nip }}
                        </div>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label justify-start">
                            Nama Depan
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <input
                            v-model="form.nama_depan"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="form.errors.nama_depan" class="text-error">
                            {{ form.errors.nama_depan }}
                        </div>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label justify-start">
                            Nama Belakang
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <input
                            v-model="form.nama_belakang"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div
                            v-if="form.errors.nama_belakang"
                            class="text-error"
                        >
                            {{ form.errors.nama_belakang }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            Jenis Kelamin
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <select
                            v-model="form.jenis_kelamin"
                            class="rounded-md dark:bg-white"
                        >
                            <option class="dark:text-gray-500" value="L">
                                Laki-laki
                            </option>
                            <option class="dark:text-gray-500" value="P">
                                Perempuan
                            </option>
                        </select>
                        <div
                            v-if="form.errors.jenis_kelamin"
                            class="text-error"
                        >
                            {{ form.errors.jenis_kelamin }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            Agama
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <select
                            v-model="form.agama_id"
                            class="rounded-md dark:bg-white"
                        >
                            <option
                                v-for="item in agama"
                                class="dark:text-gray-500"
                                :value="item.id"
                                :key="item.id"
                            >
                                {{ item.nama }}
                            </option>
                        </select>
                        <div v-if="form.errors.agama_id" class="text-error">
                            {{ form.errors.agama_id }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            Golongan Darah
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <select
                            v-model="form.golongan_darah"
                            class="rounded-md dark:bg-white"
                        >
                            <option class="dark:text-gray-500" value="O-">
                                O-
                            </option>
                            <option class="dark:text-gray-500" value="O+">
                                O+
                            </option>
                            <option class="dark:text-gray-500" value="A-">
                                A-
                            </option>
                            <option class="dark:text-gray-500" value="A+">
                                A+
                            </option>
                            <option class="dark:text-gray-500" value="B-">
                                B-
                            </option>
                            <option class="dark:text-gray-500" value="B+">
                                B+
                            </option>
                            <option class="dark:text-gray-500" value="AB-">
                                AB-
                            </option>
                            <option class="dark:text-gray-500" value="AB+">
                                AB+
                            </option>
                        </select>
                        <div
                            v-if="form.errors.golongan_darah"
                            class="text-error"
                        >
                            {{ form.errors.golongan_darah }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            Status Nikah
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <select
                            v-model="form.jenis_kawin_id"
                            class="rounded-md dark:bg-white"
                        >
                            <option
                                v-for="item in statusNikah"
                                class="dark:text-gray-500"
                                :value="item.id"
                                :key="item.id"
                            >
                                {{ item.nama }}
                            </option>
                        </select>
                        <div
                            v-if="form.errors.jenis_kawin_id"
                            class="text-error"
                        >
                            {{ form.errors.jenis_kawin_id }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            Tempat Lahir
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <input
                            v-model="form.tempat_lahir"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="form.errors.tempat_lahir" class="text-error">
                            {{ form.errors.tempat_lahir }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            Tanggal Lahir
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <input
                            v-model="form.tanggal_lahir"
                            type="date"
                            class="input-date rounded-md dark:text-gray-500"
                        />
                        <div
                            v-if="form.errors.tanggal_lahir"
                            class="text-error"
                        >
                            {{ form.errors.tanggal_lahir }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            Email Kantor
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>

                        <input
                            v-model="form.email_kantor"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="form.errors.email_kantor" class="text-error">
                            {{ form.errors.email_kantor }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            Email Pribadi
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <input
                            v-model="form.email_pribadi"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div
                            v-if="form.errors.email_pribadi"
                            class="text-error"
                        >
                            {{ form.errors.email_pribadi }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            No Telepon
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <input
                            v-model="form.no_telp"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="form.errors.no_telp" class="text-error">
                            {{ form.errors.no_telp }}
                        </div>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label justify-start">
                            Jenis Pegawai
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <select
                            v-model="form.jenis_pegawai_id"
                            class="rounded-md dark:bg-white"
                        >
                            <option
                                v-for="item in jenisPegawai"
                                class="dark:text-gray-500"
                                :value="item.id"
                                :key="item.id"
                            >
                                {{ item.nama }}
                            </option>
                        </select>
                        <div
                            v-if="form.errors.jenis_pegawai_id"
                            class="text-error"
                        >
                            {{ form.errors.jenis_pegawai_id }}
                        </div>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label justify-start">
                            Status Pegawai
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <select
                            v-model="form.status_pegawai_id"
                            class="rounded-md dark:bg-white"
                        >
                            <option
                                v-for="item in statusPegawai"
                                class="dark:text-gray-500"
                                :value="item.id"
                                :key="item.id"
                            >
                                {{ item.nama }}
                            </option>
                        </select>
                        <div
                            v-if="form.errors.status_pegawai_id"
                            class="text-error"
                        >
                            {{ form.errors.status_pegawai_id }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            Status Dinas
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <select
                            v-model="form.status_dinas"
                            class="rounded-md dark:bg-white"
                        >
                            <option class="dark:text-gray-500" value="0">
                                Aktif
                            </option>
                            <option class="dark:text-gray-500" value="1">
                                Tidak Aktif
                            </option>
                        </select>
                        <div v-if="form.errors.status_dinas" class="text-error">
                            {{ form.errors.status_dinas }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            Tanggal Berhenti
                        </label>
                        <input
                            v-model="form.tanggal_berhenti"
                            type="date"
                            class="input-date rounded-md dark:text-gray-500"
                        />
                        <div
                            v-if="form.errors.tanggal_berhenti"
                            class="text-error"
                        >
                            {{ form.errors.tanggal_berhenti }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            Tanggal Wafat
                        </label>
                        <input
                            v-model="form.tanggal_wafat"
                            type="date"
                            class="input-date rounded-md dark:text-gray-500"
                        />
                        <div
                            v-if="form.errors.tanggal_wafat"
                            class="text-error"
                        >
                            {{ form.errors.tanggal_wafat }}
                        </div>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label justify-start">
                            No BPJS
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <input
                            v-model="form.no_bpjs"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="form.errors.no_bpjs" class="text-error">
                            {{ form.errors.no_bpjs }}
                        </div>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label justify-start"> No Taspen </label>
                        <input
                            v-model="form.no_taspen"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="form.errors.no_taspen" class="text-error">
                            {{ form.errors.no_taspen }}
                        </div>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label justify-start"> NPWP </label>
                        <input
                            v-model="form.npwp"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="form.errors.npwp" class="text-error">
                            {{ form.errors.npwp }}
                        </div>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label justify-start">
                            No Urut Fingerprint
                        </label>
                        <input
                            v-model="form.no_enroll"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="form.errors.no_enroll" class="text-error">
                            {{ form.errors.no_enroll }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label justify-start">
                            No Kartu Pegawai
                            <span class="ml-1 text-sm text-red-700">*)</span>
                        </label>
                        <input
                            v-model="form.no_kartu_pegawai"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div
                            v-if="form.errors.no_kartu_pegawai"
                            class="text-error"
                        >
                            {{ form.errors.no_kartu_pegawai }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label"> Kartu Pegawai </label>
                        <input
                            @input="
                                form.media_kartu_pegawai =
                                    $event.target.files[0]
                            "
                            type="file"
                            class="file-input file-input-bordered"
                        />
                        <div
                            v-if="form.errors.media_kartu_pegawai"
                            class="text-error"
                        >
                            {{ form.errors.media_kartu_pegawai }}
                        </div>
                    </div>
                    <div class="form-control col-span-2">
                        <label class="label">Foto Pegawai</label>
                        <input
                            @input="
                                form.media_foto_pegawai = $event.target.files[0]
                            "
                            type="file"
                            class="file-input file-input-bordered"
                        />
                        <div
                            v-if="form.errors.media_foto_pegawai"
                            class="text-error"
                        >
                            {{ form.errors.media_foto_pegawai }}
                        </div>
                    </div>
                </div>
                <div class="flex justify-between pt-4">
                    <Link
                        :href="route('profil_pegawai.index')"
                        class="btn btn-outline hover:btn-error"
                    >
                        Batal
                    </Link>
                    <button
                        :disabled="isLoading"
                        type="submit"
                        class="btn btn-primary"
                    >
                        <div v-if="isLoading">
                            <span class="loading loading-spinner loading-sm">
                            </span>
                        </div>
                        Simpan
                    </button>
                </div>
            </form>
        </MainCard>
    </div>
</template>
