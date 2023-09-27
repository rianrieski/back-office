<script setup>
import MainCard from "@/Components/MainCard.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm, router, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import Swal from "sweetalert2";

const form = useForm({
    name: "",
    guard_name: "",
});

const goBack = () => {
    window.history.back();
};

const submit = () => {
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Simpan Hak Akses Baru?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya",
    }).then((result) => {
        if (result.isConfirmed) {
            form.post(route("permission.store"), {
                onSuccess: (response) => {
                    Swal.fire(
                        "Tersimpan!",
                        "Hak Akses baru berhasil disimpan.",
                        "success",
                    );
                    // form.reset(); // ini untuk reset inputan tanpa merefresh halaman atau tanpa balik ke index
                    router.get(route("permission.index"));
                },
                onError: (errors) => {
                    if (errors.query) {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Simpan Hak Akses gagal",
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
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah Hak Akses Baru
                {{ userAkses.gaji_list }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-white p-6">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel
                                    for="guard_name"
                                    value="Pilih Jenis Hak Akses :"
                                />

                                <select
                                    v-model="form.guard_name"
                                    id="guard_name"
                                    name="guard_name"
                                    required
                                >
                                    <option value="" disabled selected>
                                        Pilih Jenis Hak Akses
                                    </option>
                                    <option value="web">Akses Web</option>
                                    <option value="api">Akses API</option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.guard_name"
                                />
                            </div>

                            <div class="my-6">
                                <InputLabel
                                    for="name"
                                    value="Nama Hak Akses :"
                                />

                                <TextInput
                                    id="name"
                                    name="name"
                                    type="text"
                                    maxlength="50"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete=""
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>

                            <div class="flex justify-end">
                                <button
                                    class="btn btn-error mx-2"
                                    @click="goBack"
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
