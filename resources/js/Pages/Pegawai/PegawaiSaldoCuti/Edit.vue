<script setup>

import MainCard from "@/Components/MainCard.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import vSelect from "vue-select";
import Swal from "sweetalert2";
const props = defineProps({
    title:'',
    pegawai:'',
    pegawaiSaldoCutiDetail:''

})
const form = useForm({
    pegawai_id:props.pegawaiSaldoCutiDetail.pegawai_id,
    saldo_n:props.pegawaiSaldoCutiDetail.saldo_n,
    saldo_n_1:props.pegawaiSaldoCutiDetail.saldo_n_1,
    saldo_n_2:props.pegawaiSaldoCutiDetail.saldo_n_2,
})
const saveSaldoCuti = ()=>{
    form.put(route('saldo-cuti.update',props.pegawaiSaldoCutiDetail.id),{
        onSuccess:(response)=>{
            Swal.fire({
                title: 'Tersimpan!',
                text: response.props.success,
                icon: 'success',
                confirmButtonText: 'OK'
            })
            router.get(route('saldo-cuti.index'))
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
</script>

<template>
<MainCard :title="title">
    <div class="w-full p-6 m-auto lg:max-w-xl">
        <h2 class="text-2xl font-semibold text-center text-gray-700">{{title}}</h2>
        <form class="space-y-4" @submit.prevent="saveSaldoCuti">
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
            <div class="flex justify-center">
                <div class="form-control mr-2">
                    <label class="label">
                        <span class="label-text">Saldo N</span>
                    </label>
                    <input v-model="form.saldo_n" onkeypress="if(this.value.length==2) return false;"  type="number" placeholder="Saldo Cuti Sekarang" class="input input-bordered" :class="{'select-error':form.errors.saldo_n}" />
                    <label class="label">
                        <span v-if="form.errors.saldo_n" class="label-text-alt text-error">{{form.errors.saldo_n}}</span>
                    </label>
                </div>
                <div class="form-control mr-2">
                    <label class="label">
                        <span class="label-text">Saldo N-1</span>
                    </label>
                    <input v-model="form.saldo_n_1" onkeypress="if(this.value.length==1) return false;"  type="number" placeholder="Saldo Cuti N-1" class="input input-bordered" :class="{'select-error':form.errors.saldo_n_1}" />
                    <label class="label">
                        <span v-if="form.errors.saldo_n_1" class="label-text-alt text-error">{{form.errors.saldo_n_1}}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Saldo N-2</span>
                    </label>
                    <input v-model="form.saldo_n_2" onkeypress="if(this.value.length==1) return false;"  type="number" placeholder="Saldo Cuti N-2" class="input input-bordered" :class="{'select-error':form.errors.saldo_n_2}" />
                    <label class="label">
                        <span v-if="form.errors.saldo_n_2" class="label-text-alt text-error">{{form.errors.saldo_n_2}}</span>
                    </label>
                </div>
            </div>
            <div class="flex justify-end">
                <a class="btn btn-error mx-2" @click="()=>{router.get(route('saldo-cuti.index'))}">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</MainCard>
</template>

<style scoped>

</style>
