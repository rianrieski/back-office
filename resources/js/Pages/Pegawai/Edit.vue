<script setup>
import { Link, router, useForm } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";
import MainCard from "@/Components/MainCard.vue";

const props = defineProps({
    errors: Object,
    pegawai: Object,
    agama: Array,
    statusNikah: Array,
    jenisPegawai: Array,
    statusPegawai: Array,
    media_foto_pegawai: String,
    media_kartu_pegawai: String,
});

const form = useForm({
    nik: props.pegawai.nik,
    nip: props.pegawai.nip,
    nama_depan: props.pegawai.nama_depan,
    nama_belakang: props.pegawai.nama_belakang,
    jenis_kelamin: props.pegawai.jenis_kelamin,
    agama_id: props.pegawai.agama_id,
    golongan_darah: props.pegawai.golongan_darah,
    jenis_kawin_id: props.pegawai.jenis_kawin_id,
    tempat_lahir: props.pegawai.tempat_lahir,
    tanggal_lahir: props.pegawai.tanggal_lahir,
    email_kantor: props.pegawai.email_kantor,
    email_pribadi: props.pegawai.email_pribadi,
    no_telp: props.pegawai.no_telp,
    jenis_pegawai_id: props.pegawai.jenis_pegawai_id,
    status_pegawai_id: props.pegawai.status_pegawai_id,
    status_dinas: props.pegawai.status_dinas,
    no_kartu_pegawai: props.pegawai.no_kartu_pegawai,
    tanggal_berhenti: props.pegawai.tanggal_berhenti,
    tanggal_wafat: props.pegawai.tanggal_wafat,
    no_bpjs: props.pegawai.no_bpjs,
    no_taspen: props.pegawai.no_taspen,
    npwp: props.pegawai.npwp,
    no_enroll: props.pegawai.no_enroll,
    media_foto_pegawai: "",
    media_kartu_pegawai: "",
});

const isLoading = ref(false);

const updatePegawai = () => {
    const buttonSubmit = document.getElementById("buttonSubmit");
    isLoading.value = true;
    buttonSubmit.disabled = true;

    router.post(
        route("pegawai.update", { pegawai: props.pegawai.id }),
        {
            _method: "put",
            nik: form.nik,
            nip: form.nip,
            nama_depan: form.nama_depan,
            nama_belakang: form.nama_belakang,
            jenis_kelamin: form.jenis_kelamin,
            agama_id: form.agama_id,
            golongan_darah: form.golongan_darah,
            jenis_kawin_id: form.jenis_kawin_id,
            tempat_lahir: form.tempat_lahir,
            tanggal_lahir: form.tanggal_lahir,
            email_kantor: form.email_kantor,
            email_pribadi: form.email_pribadi,
            no_telp: form.no_telp,
            jenis_pegawai_id: form.jenis_pegawai_id,
            status_pegawai_id: form.status_pegawai_id,
            status_dinas: form.status_dinas,
            no_kartu_pegawai: form.no_kartu_pegawai,
            tanggal_berhenti: form.tanggal_berhenti,
            tanggal_wafat: form.tanggal_wafat,
            no_bpjs: form.no_bpjs,
            no_taspen: form.no_taspen,
            npwp: form.npwp,
            no_enroll: form.no_enroll,
            media_foto_pegawai: form.media_foto_pegawai,
            media_kartu_pegawai: form.media_kartu_pegawai,
            prevalidate: true,
        },
        {
            preserveScroll: true,
            preserveState: true,
            replace: true,
            onSuccess: (response) => {
                Toast.fire({
                    icon: "success",
                    text: response.props.flash.success,
                });
            },
            onError: (response) => {
                isLoading.value = false;
                buttonSubmit.disabled = false;
            },
        },
    );
};
</script>

<template>
    <div>
        <Head title="Edit Pegawai" />

        <MainCard>
            <h2
                class="mb-4 text-center text-2xl font-semibold text-gray-700 dark:text-gray-500"
            >
                Edit Pegawai
            </h2>
            <form @submit.prevent="updatePegawai">
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
                        <div v-if="errors.nik" class="text-error">
                            {{ errors.nik }}
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
                        <div v-if="errors.nip" class="text-error">
                            {{ errors.nip }}
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
                        <div v-if="errors.nama_depan" class="text-error">
                            {{ errors.nama_depan }}
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
                        <div v-if="errors.nama_belakang" class="text-error">
                            {{ errors.nama_belakang }}
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
                        <div v-if="errors.jenis_kelamin" class="text-error">
                            {{ errors.jenis_kelamin }}
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
                        <div v-if="errors.agama_id" class="text-error">
                            {{ errors.agama_id }}
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
                        <div v-if="errors.golongan_darah" class="text-error">
                            {{ errors.golongan_darah }}
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
                        <div v-if="errors.jenis_kawin_id" class="text-error">
                            {{ errors.statusNikah }}
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
                        <div v-if="errors.tempat_lahir" class="text-error">
                            {{ errors.tempat_lahir }}
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
                        <div v-if="errors.tanggal_lahir" class="text-error">
                            {{ errors.tanggal_lahir }}
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
                        <div v-if="errors.email_kantor" class="text-error">
                            {{ errors.email_kantor }}
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
                        <div v-if="errors.email_pribadi" class="text-error">
                            {{ errors.email_pribadi }}
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
                        <div v-if="errors.no_telp" class="text-error">
                            {{ errors.no_telp }}
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
                        <div v-if="errors.jenisPegawai" class="text-error">
                            {{ errors.jenisPegawai }}
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
                        <div v-if="errors.statusPegawai" class="text-error">
                            {{ errors.statusPegawai }}
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
                        <div v-if="errors.status_dinas" class="text-error">
                            {{ errors.status_dinas }}
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
                        <div v-if="errors.tanggal_berhenti" class="text-error">
                            {{ errors.tanggal_berhenti }}
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
                        <div v-if="errors.tanggal_wafat" class="text-error">
                            {{ errors.tanggal_wafat }}
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
                        <div v-if="errors.no_bpjs" class="text-error">
                            {{ errors.no_bpjs }}
                        </div>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label justify-start"> No Taspen </label>
                        <input
                            v-model="form.no_taspen"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="errors.no_taspen" class="text-error">
                            {{ errors.no_taspen }}
                        </div>
                    </div>
                    <div class="form-control col-span-3">
                        <label class="label justify-start"> NPWP </label>
                        <input
                            v-model="form.npwp"
                            type="text"
                            class="input-text rounded-md dark:text-gray-500"
                        />
                        <div v-if="errors.npwp" class="text-error">
                            {{ errors.npwp }}
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
                        <div v-if="errors.no_enroll" class="text-error">
                            {{ errors.no_enroll }}
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
                        <div v-if="errors.no_kartu_pegawai" class="text-error">
                            {{ errors.no_kartu_pegawai }}
                        </div>
                    </div>
                    <div class="form-control col-span-2 flex items-stretch">
                        <label class="label"> Kartu Pegawai </label>
                        <img
                            :src="media_kartu_pegawai"
                            class="mb-2 h-full rounded-md border-2"
                            alt=""
                        />
                        <input
                            @input="
                                form.media_kartu_pegawai =
                                    $event.target.files[0]
                            "
                            type="file"
                            class="file-input file-input-bordered pb-8"
                        />
                        <div
                            v-if="errors.media_kartu_pegawai"
                            class="text-error"
                        >
                            {{ errors.media_kartu_pegawai }}
                        </div>
                    </div>
                    <div class="form-control col-span-2 flex items-stretch">
                        <label class="label">Foto Pegawai</label>
                        <img
                            :src="media_foto_pegawai"
                            class="mb-2 h-full rounded-md border-2"
                            alt=""
                        />
                        <input
                            @input="
                                form.media_foto_pegawai = $event.target.files[0]
                            "
                            type="file"
                            class="file-input file-input-bordered pb-8"
                        />
                        <div
                            v-if="errors.media_foto_pegawai"
                            class="text-error"
                        >
                            {{ errors.media_foto_pegawai }}
                        </div>
                    </div>
                </div>
                <div class="flex justify-between pt-4">
                    <Link
                        :href="route('pegawai.index')"
                        class="btn btn-outline hover:btn-error"
                    >
                        Batal
                    </Link>
                    <button
                        id="buttonSubmit"
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
