<script setup>
import MainCard from "@/Components/MainCard.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import DropDown from "@/Components/Dropdown.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import Swal from 'sweetalert2';

const props = defineProps({
    jabatanUnitKerja: {
        type: Object,
        default: () => ({}),
    },
    jabatanTukin: {
        type: Object,
        default: () => ({}),
    },
    hirarkiUnitKerja:{
        type: Object,
        default: () => ({}),
    }
});

const nominal = computed({
    get() {
        return new Intl.NumberFormat('id-ID', {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits:0,
        }).format(form.nominal);
    },
    set(value){
        // console.log(value)
        form.nominal = Number(value.replaceAll(".","").replaceAll("Rp",""));
    }
});

const form = useForm({
    id: props.jabatanUnitKerja.id,
    jabatan_tukin_id: props.jabatanUnitKerja.jabatan_tukin_id,
    hirarki_unit_kerja_id: props.jabatanUnitKerja.hirarki_unit_kerja_id,
});

const goBack = () => {
    window.history.back();
};


const submit = ()=>{
    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Simpan perubahan data Jabatan Unit Kerja",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.isConfirmed) {
            form.put(route("jabatan-unit-kerja.update", props.jabatanUnitKerja.id),{
                onSuccess:(response)=>{
                    Swal.fire(
                        'Tersimpan!',
                        'Data Jabatan Unit Kerja berhasil disimpan.',
                        'success'
                    )
                    // form.reset(); // ini untuk reset inputan tanpa merefresh halaman atau tanpa balik ke index
                    router.get(route('jabatan-unit-kerja.index'));
                },
                onError:(errors)=>{
                    if(errors.query){
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Simpan Jabatan Unit Kerja gagal',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                    }
                }
            })
        }
    })
}


</script>

<template>

    <MainCard>

        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="/">Beranda</a></li>
                <li><a href="/jabatan-unit-kerja">Jabatan Unit Kerja</a></li>

            </ul>
        </div>

        <div class="py-12">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-xl font-semibold leading-tight text-gray-800">
                            Ubah Jabatan Unit Kerja
                        </h2>
                        <form @submit.prevent="submit">
                            <div class="my-6">
                                <InputLabel
                                    for="jabatan_tukin_id"
                                    value="Jabatan"
                                />
                                <select
                                    v-model="form.jabatan_tukin_id"
                                    id="jabatan_tukin_id"
                                    name="jabatan_tukin_id"
                                    required
                                >
                                    <option value="-1" disabled selected>
                                        Pilih  Jabatan
                                    </option>
                                    <option
                                        v-for="data in jabatanTukin"
                                        :key="data.id"
                                        :value="data.id"
                                        :selected="data.id === form.jabatan_tukin_id"
                                    >
                                        {{ data.nama_jabatan }}
                                    </option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.jabatan_tukin_id"
                                />
                            </div>

                            <div class="my-6">
                                <InputLabel
                                    for="hirarki_unit_kerja_id"
                                    value="Pilih Unit Kerja"
                                />

                                <select
                                    v-model="form.hirarki_unit_kerja_id"
                                    id="hirarki_unit_kerja_id"
                                    name="hirarki_unit_kerja_id"
                                    required
                                >
                                    <option value="-1" disabled selected>
                                        Pilih Unit Kerja
                                    </option>
                                    <option
                                        v-for="data in hirarkiUnitKerja"
                                        :key="data.id"
                                        :value="data.id"
                                        :selected="data.id === form.hirarki_unit_kerja_id"
                                    >
                                        {{ data.nama_unit_kerja }}
                                    </option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.hirarki_unit_kerja_id"
                                />
                            </div>

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
                                    Update
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MainCard>
</template>
