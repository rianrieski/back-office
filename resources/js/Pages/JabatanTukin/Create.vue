<script setup>
import MainCard from "@/Components/MainCard.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm, router, usePage } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import Swal from "sweetalert2";
import axios from "axios";

const form = useForm({
    jenis_jabatan_id: "",
    jabatan_id: "",
    tukin_id: "",
});

const jenisJabatan = ref([]);
const selectedJenisJabatan = ref(-1);
const getJenisJabatan = () => {
    selectedJabatan.value = "-1" ;
    selectedTukin.value = "-1";
    axios
        .get("/jabatan-tukin/getjenisjabatan")
        .then((response) => (jenisJabatan.value = response.data));
};

onMounted(() => {
    getJenisJabatan();
});

const jabatan = ref([]);
const selectedJabatan = ref(-1);
const getJabatan = () => {
    selectedTukin.value = "-1"   ;
    axios
        .get("/jabatan-tukin/getjabatan/" + selectedJenisJabatan.value)
        .then((response) => (jabatan.value = response.data));
};

const tukin = ref([]);
const selectedTukin = ref(-1);
const getTukin = () => {
    axios
        .get("/jabatan-tukin/gettukin/")
        .then((response) => (tukin.value = response.data));
};

let nominal = ref("");
const getNominalTukin = () => {
    axios.get("/jabatan-tukin/getnominal/" + selectedTukin).then((response) => {
        nominal.value = response.data;
    });
    // .then((response) => (nominal.value = response.data));
};

const goBack = () => {
    window.history.back();
};

const submit = () => {
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Simpan data Jabatan Tukin",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya",
    }).then((result) => {
        if (result.isConfirmed) {
            form.jenis_jabatan_id = selectedJenisJabatan;
            form.jabatan_id = selectedJabatan;
            form.tukin_id = selectedTukin;

            form.post(route("jabatan-tukin.store"), {
                onSuccess: (response) => {
                    Swal.fire(
                        "Tersimpan!",
                        "Data Tunjangan Kinerja Jabatan berhasil disimpan.",
                        "success",
                    );

                    router.get(route("jabatan-tukin.index"));
                },
                onError: (errors) => {
                    if (errors.query) {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Simpan Jabatan Tukin gagal",
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                },
            });
        }
    });
};
</script>

<template>
    <MainCard>
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="/">Beranda</a></li>
                <li><a href="/jabatan-tukin">Tunjangan Kinerja Berdasarkan Jabatan</a></li>

            </ul>
        </div>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                <!-- Tambah Tunjangan Kinerja Jabatan -->
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-white p-6">
                        <h2 class="text-xl font-semibold leading-tight text-gray-800">
                            Tambah Tunjangan Kinerja Jabatan
                        </h2>
                        <form @submit.prevent="submit">
                            <div class="my-6">
                                <InputLabel
                                    for="jenis_jabatan_id"
                                    value="Jenis Jabatan"
                                />
                                <select
                                    v-model="selectedJenisJabatan"
                                    @change="getJabatan()"
                                    id="jenis_jabatan_id"
                                    name="jenis_jabatan_id"
                                    required
                                >
                                    <option value="-1" disabled selected>
                                        Pilih Jenis Jabatan
                                    </option>
                                    <option
                                        v-for="data in jenisJabatan"
                                        :key="data.id"
                                        :value="data.id"
                                    >
                                        {{ data.nama }}
                                    </option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.jenis_jabatan_id"
                                />
                            </div>

                            <div class="my-6">
                                <InputLabel
                                    for="jabatan_id"
                                    value="Pilih Jabatan"
                                />

                                <select
                                    v-model="selectedJabatan"
                                    @change="getTukin()"
                                    id="jabatan_id"
                                    name="jabatan_id"
                                    required
                                >
                                    <option value="-1" disabled selected>
                                        Pilih Jabatan
                                    </option>
                                    <option
                                        v-for="data in jabatan"
                                        :key="data.id"
                                        :value="data.id"
                                    >
                                        {{ data.nama }}
                                    </option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.jabatan_id"
                                />
                            </div>

                            <div class="my-6">
                                <InputLabel
                                    for="tukin_id"
                                    value="Grade Tunjangan Kinerja Jabatan"
                                />

                                <select
                                    v-model="selectedTukin"
                                    @change="getNominalTukin()"
                                    id="tukin_id"
                                    name="jenis_jabatan_id"
                                    required
                                >
                                    <option value="-1" disabled>
                                        Pilih Grade Tunjangan Kinerja Jabatan
                                    </option>
                                    <option
                                        v-for="data in tukin"
                                        :key="data.id"
                                        :value="data.id"
                                    >
                                        {{ "Grade: " + data.grade }} &nbsp&nbsp {{ "Nominal: "+ data.nominal }}
                                    </option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.tukin_id"
                                />
                            </div>

                            <!-- <div class="my-6">
                                <InputLabel for="nominal" value="Nominal" />

                                <TextInput
                                    v-model:model-value="nominal"
                                    id="nominal"
                                    name="nominal"
                                    type="text"
                                    maxlength="15"
                                    class="mt-1 block w-full"
                                    v-model="nominal"
                                    required
                                    autofocus
                                    autocomplete=""
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.nominal"
                                />
                            </div> -->

                            <div class="flex justify-end">
                                <button
                                    class="btn btn-error mx-2"
                                    @click.prevent="goBack"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="btn btn-primary mx-2"
                                    :class="{ 'form.processing': isProcessing }"
                                >
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MainCard>
</template>
