<script setup>

import MainCard from "@/Components/MainCard.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import vSelect from "vue-select";
import Swal from "sweetalert2";
const props = defineProps({
    title:'',
    pegawai:'',
    pendidikan:'',
    pegawaiAnakDetail:''
})
const form = useForm({
    pegawai_id:props.pegawaiAnakDetail.pegawai_id,
    anak_ke:props.pegawaiAnakDetail.anak_ke,
    tanggal_lahir:props.pegawaiAnakDetail.tanggal_lahir,
    nama:props.pegawaiAnakDetail.nama,
    nik:props.pegawaiAnakDetail.nik,
    tempat_lahir:props.pegawaiAnakDetail.tempat_lahir,
    status_anak:props.pegawaiAnakDetail.status_anak,
    status_tunjangan:props.pegawaiAnakDetail.status_tunjangan,
    bidang_studi:props.pegawaiAnakDetail.bidang_studi,
    pendidikan_id:props.pegawaiAnakDetail.pendidikan_id,
})
const selectedPegawai = computed({
    get(){
        return props.pegawai.find(peg => peg.id === form.pegawai_id)
    },
    set(pegawai){
        form.pegawai_id = pegawai.id
    }
})
const selectedPendidikan = computed({
    get(){
        return props.pendidikan.find(gaj => gaj.id === form.pendidikan_id)
    },
    set(pendidikan){
        form.pendidikan_id = pendidikan.id
    }
})
const saveAnak = ()=>{
    form.put(route('anak.update',props.pegawaiAnakDetail.id),{
        onSuccess:(response)=>{
            Swal.fire({
                title: 'Tersimpan!',
                text: response.props.success,
                icon: 'success',
                confirmButtonText: 'OK'
            })
            router.get(route('anak.index'))
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
        <form class="space-y-4" @submit.prevent="saveAnak">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Pegawai</span>
                </label>
                <vSelect v-model="selectedPegawai" :options="pegawai" label="nama_lengkap" class="w-full">
                </vSelect>
                <label class="label">
                    <span v-if="form.errors.pegawai_id" class="label-text-alt text-error">{{form.errors.pegawai_id}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input v-model="form.nama"  type="text" placeholder="Masukkan Nama" class="input input-bordered" :class="{'select-error':form.errors.nama}" />
                <label class="label">
                    <span v-if="form.errors.nama" class="label-text-alt text-error">{{form.errors.nama}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">NIK</span>
                </label>
                <input v-model="form.nik"  onkeypress="if(this.value.length==16) return false;"  type="number" placeholder="Masukkan Nik" class="input input-bordered" :class="{'select-error':form.errors.nik}" />
                <label class="label">
                    <span v-if="form.errors.nik" class="label-text-alt text-error">{{form.errors.nik}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Anak Ke</span>
                </label>
                <input v-model="form.anak_ke" onkeypress="if(this.value.length==2) return false;"  type="number" placeholder="Masukkan Anak ke" class="input input-bordered" :class="{'select-error':form.errors.anak_ke}" />
                <label class="label">
                    <span v-if="form.errors.anak_ke" class="label-text-alt text-error">{{form.errors.anak_ke}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Tempat Lahir</span>
                </label>
                <input v-model="form.tempat_lahir"  type="text" placeholder="Masukkan Tempat Lahir" class="input input-bordered" :class="{'select-error':form.errors.tempat_lahir}" />
                <label class="label">
                    <span v-if="form.errors.tempat_lahir" class="label-text-alt text-error">{{form.errors.tempat_lahir}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Tanggal Lahir</span>
                </label>
                <input v-model="form.tanggal_lahir"  type="date" placeholder="Masukkan Tanggal Lahir" class="input input-bordered" :class="{'select-error':form.errors.tanggal_lahir}"/>
                <label class="label">
                    <span v-if="form.errors.tanggal_lahir" class="label-text-alt text-error">{{form.errors.tanggal_lahir}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Status Anak</span>
                </label>
                <select v-model="form.status_anak" class="select select-bordered" :class="{'select-error':form.errors.status_anak}">
                    <option disabled selected>Pilih tipe</option>
                    <option value="Kandung">Kandung</option>
                    <option value="Angkat">Angkat</option>
                </select>
                <label class="label">
                    <span v-if="form.errors.status_anak" class="label-text-alt text-error">{{form.errors.status_anak}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Status Tunjangan</span>
                </label>
                <select v-model="form.status_tunjangan" class="select select-bordered" :class="{'select-error':form.errors.status_tunjangan}">
                    <option disabled selected>Pilih tipe</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
                <label class="label">
                    <span v-if="form.errors.status_tunjangan" class="label-text-alt text-error">{{form.errors.status_tunjangan}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Pendidikan</span>
                </label>
                <vSelect v-model="selectedPendidikan" :options="pendidikan" label="nama" class="w-full">
                </vSelect>
                <label class="label">
                    <span v-if="form.errors.pendidikan_id" class="label-text-alt text-error">{{form.errors.pendidikan_id}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Bidang Studi</span>
                </label>
                <input v-model="form.bidang_studi"  type="text" placeholder="Masukkan Bidang Studi" class="input input-bordered" :class="{'select-error':form.errors.bidang_studi}" />
                <label class="label">
                    <span v-if="form.errors.bidang_studi" class="label-text-alt text-error">{{form.errors.bidang_studi}}</span>
                </label>
            </div>

            <div class="flex justify-end">
                <a class="btn btn-error mx-2" @click="()=>{router.get(route('anak.index'))}">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</MainCard>
</template>

<style scoped>

</style>
