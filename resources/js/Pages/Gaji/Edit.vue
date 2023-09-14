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
    gaji: {
        type: Object,
        default: () => ({}),
    },
    golongan:{
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
    id: props.gaji.id,
    golongan_id: props.gaji.golongan_id,
    masa_kerja: props.gaji.masa_kerja,
    nominal: props.gaji.nominal,
});

const goBack = () => {
    window.history.back();
}

const submit = ()=>{
    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Simpan perubahan data gaji",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.isConfirmed) {
            form.put(route("gaji.update", props.gaji.id),{
                onSuccess:(response)=>{
                    Swal.fire(
                        'Tersimpan!',
                        'Data gaji berhasil disimpan.',
                        'success'
                    )
                    // form.reset(); // ini untuk reset inputan tanpa merefresh halaman atau tanpa balik ke index
                    router.get(route('gaji.index'));
                },
                onError:(errors)=>{
                    if(errors.query){
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Simpan gaji gagal',
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
                <li><a href="/Gaji">Gaji</a></li>

            </ul>
        </div>


        <div class="py-12">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <h2 class="text-xl font-semibold leading-tight text-gray-800">
                            Ubah Gaji
                        </h2>

                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="golongan_id" value="Golongan" />

                                <select v-model="form.golongan_id" @change="getGolongan" id="golongan_id" name="golongan_id">
                                    <option value="" disabled>Pilih Golongan</option>
                                    <option v-for="data in props.golongan" :key="data.id" :value="data.id">{{ data.nama }}</option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.golongan_id"
                                />
                            </div>

                            <div class="my-6">
                                <InputLabel for="masa_kerja" value="Masa Kerja" v-model="form.masa_kerja" />

                                <TextInput
                                    id="masa_kerja"
                                    name="masa_kerja"
                                    type="number"
                                    maxlength="3"
                                    class="mt-1 block w-full"
                                    v-model="form.masa_kerja"
                                    required
                                    autofocus
                                    autocomplete=""
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.masa_kerja"
                                />
                            </div>

                            <div class="my-6">
                                <InputLabel for="nominal" value="Nominal"  v-model="form.nominal"/>

                                <TextInput
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

                            </div>

                            <div class="flex justify-end">
                                <button class="btn btn-error mx-2" @click.prevent="goBack" >Batal</button>
                                <button type="submit" class="btn btn-primary mx-2" :class="{ 'form.processing': isProcessing }">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MainCard>
</template>
