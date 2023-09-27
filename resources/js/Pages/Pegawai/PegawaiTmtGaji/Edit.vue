<script setup>
import MainCard from "@/Components/MainCard.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import vSelect from "vue-select";
import Swal from "sweetalert2";
const props = defineProps({
    title:'',
    pegawai:'',
    gaji:'',
    tmtGajiPegawai:''
})
const form = useForm({
    pegawai_id:props.tmtGajiPegawai.pegawai_id,
    gaji_id:props.tmtGajiPegawai.gaji_id,
    tmt_gaji:props.tmtGajiPegawai.tmt_gaji
})
const selectedPegawai = computed({
    get(){
        return props.pegawai.find(peg => peg.id === form.pegawai_id)
    },
    set(pegawai){
        form.pegawai_id = pegawai.id
    }
})
const selectedGaji = computed({
    get(){
        return props.gaji.find(gaj => gaj.id === form.gaji_id)
    },
    set(gaji){
        form.gaji_id = gaji.id
    }
})
const saveTmtGaji = ()=>{
    form.put(route('tmt-gaji.update',props.tmtGajiPegawai.id),{
        onSuccess:(response)=>{
            Swal.fire({
                title: 'Tersimpan!',
                text: response.props.success,
                icon: 'success',
                confirmButtonText: 'OK'
            })
            router.get(route('tmt-gaji.index'))
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
        <form class="space-y-4" @submit.prevent="saveTmtGaji">
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
                    <span class="label-text">Gaji</span>
                </label>
                <vSelect v-model="selectedGaji" :options="gaji" label="nominal_gaji" class="w-full">
                </vSelect>
                <label class="label">
                    <span v-if="form.errors.gaji_id" class="label-text-alt text-error">{{form.errors.gaji_id}}</span>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Tmt Gaji</span>
                </label>
                <input v-model="form.tmt_gaji"  type="date" placeholder="Masukkan Tmt Gaji" class="input input-bordered" />
                <label class="label">
                    <span v-if="form.errors.tmt_gaji" class="label-text-alt text-error">{{form.errors.tmt_gaji}}</span>
                </label>
            </div>
            <div class="flex justify-end">
                <a class="btn btn-error mx-2" @click="()=>{router.get(route('tmt-gaji.index'))}">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</MainCard>
</template>
<style scoped>
    @import "vue-select/dist/vue-select.css";
</style>
