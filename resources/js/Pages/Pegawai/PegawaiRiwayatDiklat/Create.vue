<script setup>
import MainCard from "@/Components/MainCard.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import vSelect from "vue-select";
import Swal from "sweetalert2";
const props = defineProps({
    title:'',
    pegawai:'',
    jenis_diklat:''
})
const form = useForm({
    pegawai_id:'',
    jenis_diklat_id:'',
    tanggal_mulai:'',
    tanggal_akhir:'',
    jam_pelajaran:'',
    lokasi:'',
    penyelenggaran:'',
    no_sertifikat:'',
    tanggal_sertifikat:'',
    media_sertifikat:''
})
const saveRiwayatDiklat = ()=>{
    form.post(route('riwayat-diklat.store'),{
        onSuccess:(response)=>{
            Swal.fire({
                title: 'Tersimpan!',
                text: response.props.success,
                icon: 'success',
                confirmButtonText: 'OK'
            })
            router.get(route('riwayat-diklat.index'))
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
const selectedPegawai = computed({
    get(){
        return props.pegawai.find(peg => peg.id === form.pegawai_id)
    },
    set(pegawai){
        form.pegawai_id = pegawai.id
    }
})
const selectedJenisDiklat = computed({
    get(){
        return props.jenis_diklat.find(peg => peg.id === form.jenis_diklat_id)
    },
    set(jenis_diklat){
        form.jenis_diklat_id = jenis_diklat.id
    }
})
const compareTanggal = ()=>{
    if(form.tanggal_akhir !== ''){
        if (form.tanggal_mulai > form.tanggal_akhir){
            form.tanggal_mulai = form.tanggal_akhir
            form.tanggal_akhir = null
            form.errors.tanggal_akhir = 'tanggal akhir tidak boleh lebih kecil dari tanggal mulai'
            form.errors.tanggal_mulai = 'tanggal mulai tidak boleh lebih besar dari tanggal akhir'
        }else{
            form.errors.tanggal_akhir = null
            form.errors.tanggal_mulai = null
        }
    }else{
        form.errors.tanggal_akhir = null
        form.errors.tanggal_mulai = null
    }
}
const minDate = ()=>{
    return new Date(form.tanggal_akhir)
};
</script>

<template>
    <div class="text-sm breadcrumbs">
        <ul>
            <li><a>Beranda</a></li>
            <li>Pegawai</li>
            <li><a @click="()=>{router.get(route('riwayat-diklat.index'))}">Riwayat Diklat</a></li>
            <li><span class="text-info">{{title}}</span></li>
        </ul>
    </div>
    <MainCard :title="title">
        <div class="w-full p-6 m-auto lg:max-w-xl">
            <h2 class="text-2xl font-semibold text-center text-gray-700">{{title}}</h2>
            <form class="space-y-4" @submit.prevent="saveRiwayatDiklat">
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
                        <span class="label-text">Jenis Diklat</span>
                    </label>
                    <vSelect v-model="selectedJenisDiklat" :options="jenis_diklat" label="nama" class="w-full">
                    </vSelect>
                    <label class="label">
                        <span v-if="form.errors.jenis_diklat_id" class="label-text-alt text-error">{{form.errors.jenis_diklat_id}}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanggal Mulai</span>
                    </label>
                    <input v-model="form.tanggal_mulai"  type="date" placeholder="Masukkan tanggal akhir" @change="compareTanggal" class="input input-bordered" />
                    <label class="label">
                        <span v-if="form.errors.tanggal_mulai" class="label-text-alt text-error">{{form.errors.tanggal_mulai}}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanggal Akhir</span>
                    </label>
                    <input v-model="form.tanggal_akhir"  type="date" placeholder="Masukkan tanggal akhir" :min="minDate" class="input input-bordered" @change="compareTanggal"/>
                    <label class="label">
                        <span v-if="form.errors.tanggal_akhir" class="label-text-alt text-error">{{form.errors.tanggal_akhir}}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Jam Pelajaran</span>
                    </label>
                    <input v-model="form.jam_pelajaran"  type="number" placeholder="Masukkan jam pelajaran" class="input input-bordered"/>
                    <label class="label">
                        <span v-if="form.errors.jam_pelajaran" class="label-text-alt text-error">{{form.errors.jam_pelajaran}}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Lokasi</span>
                    </label>
                    <input v-model="form.lokasi"  type="text" placeholder="Masukkan lokasi" class="input input-bordered"/>
                    <label class="label">
                        <span v-if="form.errors.lokasi" class="label-text-alt text-error">{{form.errors.lokasi}}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Penyelenggaran</span>
                    </label>
                    <input v-model="form.penyelenggaran"  type="text" placeholder="Masukkan penyelenggaran" class="input input-bordered"/>
                    <label class="label">
                        <span v-if="form.errors.penyelenggaran" class="label-text-alt text-error">{{form.errors.penyelenggaran}}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nomor Sertifikat</span>
                    </label>
                    <input v-model="form.no_sertifikat"  type="text" placeholder="Masukkan nomor sertifikat" class="input input-bordered"/>
                    <label class="label">
                        <span v-if="form.errors.no_sertifikat" class="label-text-alt text-error">{{form.errors.no_sertifikat}}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanggal Sertifikat</span>
                    </label>
                    <input v-model="form.tanggal_sertifikat"  type="date" placeholder="Masukkan tanggal sertifikat"  class="input input-bordered" @change="compareTanggal"/>
                    <label class="label">
                        <span v-if="form.errors.tanggal_sertifikat" class="label-text-alt text-error">{{form.errors.tanggal_sertifikat}}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">File Sertifikat</span>
                    </label>
                    <input accept=".pdf,.jpg,.png,.jpeg" @input="form.media_sertifikat = $event.target.files[0]"   type="file" placeholder="Masukkan file sertifikat"  class="file-input file-input-bordered" />
                    <label class="label">
                        <span v-if="form.errors.media_sertifikat" class="label-text-alt text-error">{{form.errors.media_sertifikat}}</span>
                    </label>
                </div>

                <div class="flex justify-end">
                    <a class="btn btn-error mx-2" @click="()=>{router.get(route('riwayat-diklat.index'))}">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </MainCard>
</template>

