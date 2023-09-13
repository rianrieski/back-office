<script setup>
import MainCard from "@/Components/MainCard.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import Swal from 'sweetalert2';

defineProps(['golongan']);

const nominal = computed({
    get() {
        return new Intl.NumberFormat('id-ID', {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits:0,
        }).format(form.nominal);
    },
    set(value){
        console.log(value)
        form.nominal = Number(value.replaceAll(".","").replaceAll("Rp",""));
    }
});

const form = useForm({
    golongan_id: "",
    masa_kerja: "",
    nominal:0,
});


const goBack = () => {
    window.history.back();
}

const submit = ()=>{
    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Simpan data gaji",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.isConfirmed) {
            form.post(route('gaji.store'),{
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
                <li><a href="/gaji">Gaji</a></li>

            </ul>
        </div>

        <div class="py-12">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-white p-6">
                        <h2 class="text-xl font-semibold leading-tight text-gray-800">
                            Tambah Gaji
                        </h2>

                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="golongan_id" value="Golongan" />

                                <select v-model="form.golongan_id" @change="getGolongan" id="golongan_id" name="golongan_id" required>
                                    <option value="" disabled>Pilih Golongan</option>
                                    <option v-for="data in golongan" :key="data.id" :value="data.id">{{ data.nama }}</option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.golongan_id"
                                />
                            </div>

                            <div class="my-6">
                                <InputLabel for="masa_kerja" value="Masa Kerja" />

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
                                <InputLabel for="nominal" value="Nominal" />

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
                                <button type="submit" class="btn btn-primary mx-2" :class="{ 'form.processing': isProcessing }">Simpan</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MainCard>
</template>
