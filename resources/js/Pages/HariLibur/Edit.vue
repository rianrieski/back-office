<script setup>

import MainCard from "@/Components/MainCard.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import vSelect from "vue-select";
import Swal from "sweetalert2";
const props = defineProps({
    title:'',
    hariLiburDetail:''
})
const form = useForm({
    tanggal:props.hariLiburDetail.tanggal,
    keterangan:props.hariLiburDetail.keterangan,
    is_libur:props.hariLiburDetail.is_libur,
})
const saveHariLibur = ()=>{
    form.put(route('hari-libur.update',props.hariLiburDetail.id),{
        onSuccess:(response)=>{
            Swal.fire({
                title: 'Tersimpan!',
                text: response.props.success,
                icon: 'success',
                confirmButtonText: 'OK'
            })
            router.get(route('hari-libur.index'))
        },
        onError:(errors)=>{
            if(errors.query){
                Swal.fire({
                    title: 'Gagal!',
                    text: errors.query,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }
        }
    })
}
</script>

<template>
<MainCard :title="title">
    <div class="w-full p-6 m-auto lg:max-w-xl">
        <h2 class="text-2xl font-semibold text-center text-gray-700">{{title}}</h2>
        <form class="space-y-4" @submit.prevent="saveHariLibur">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Tanggal</span>
                </label>
                <input v-model="form.tanggal"  type="date" class="input input-bordered" :class="{'select-error':form.errors.tanggal}" />
                <label class="label">
                    <span v-if="form.errors.tanggal" class="label-text-alt text-error">{{form.errors.tanggal}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Keterangan</span>
                </label>
                <input v-model="form.keterangan"  type="text" placeholder="Masukkan Keterangan" class="input input-bordered" :class="{'select-error':form.errors.keterangan}" />
                <label class="label">
                    <span v-if="form.errors.keterangan" class="label-text-alt text-error">{{form.errors.keterangan}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Status</span>
                </label>
                <select v-model="form.is_libur" class="select select-bordered w-full" :class="{'select-error':form.errors.is_libur}">
                    <option value="1">Libur</option>
                    <option value="0">Tidak Libur</option>
                </select>
                <label class="label">
                    <span v-if="form.errors.is_libur" class="label-text-alt text-error">{{form.errors.is_libur}}</span>
                </label>
            </div>
            <div class="flex justify-end">
                <a class="btn btn-error mx-2" @click="()=>{router.get(route('hari-libur.index'))}">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</MainCard>
</template>

<style scoped>

</style>
