<script setup>
import vSelect from "vue-select";
import { computed } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Swal from "sweetalert2";
import MainCard from "@/Components/MainCard.vue";
const props = defineProps({
    unitKerja:Object,
    title:String
})
const form = useForm({
    child_unit_kerja_id:'',
    parent_unit_kerja_id:''
})
const selectedChild = computed({
    get(){
        return props.unitKerja.find(unit => unit.id === form.child_unit_kerja_id)
    },
    set(unit){
        form.child_unit_kerja_id = unit.id
    }
})
const selectedParent = computed({
    get(){
        return props.unitKerja.find(unit => unit.id === form.parent_unit_kerja_id)
    },
    set(unit){
        form.parent_unit_kerja_id = unit.id
    }
})
const saveHirarki= ()=>{
    form.post(route('hirarki-unit-kerja.store'),{
        preserveScroll:true,
        onSuccess:(response)=>{
            Swal.fire({
                title: 'Tersimpan!',
                text: response.props.success,
                icon: 'success',
                confirmButtonText: 'OK'
            })
            router.get(route('hirarki-unit-kerja.index'));
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
const back = ()=>{
    router.get(route('hirarki-unit-kerja.index'))
}
</script>

<template>
    <div class="text-sm breadcrumbs">
        <ul>
            <li><a>Beranda</a></li>
            <li>Pegawai</li>
            <li><Link href="/master/hirarki-unit-kerja">Hirarki Unit Kerja</Link></li>
            <li><span class="text-info">{{title}}</span></li>
        </ul>
    </div>
    <MainCard>
        <div class="w-full p-6 m-auto lg:max-w-xl">
            <h2 class="text-2xl font-semibold text-center text-gray-700">{{title}}</h2>
            <form class="space-y-4" @submit.prevent="saveHirarki">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Unit Kerja</span>
                    </label>
                    <vSelect v-model="selectedChild" :options="unitKerja" label="nama" class="w-full">
                    </vSelect>
                    <label class="label">
                        <span v-if="form.errors.child_unit_kerja_id" class="label-text-alt text-error">{{form.errors.child_unit_kerja_id}}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Atasan Langsung</span>
                    </label>
                    <vSelect v-model="selectedParent" :options="unitKerja" label="nama" class="w-full">
                    </vSelect>
                    <label class="label">
                        <span v-if="form.errors.parent_unit_kerja_id" class="label-text-alt text-error">{{form.errors.parent_unit_kerja_id}}</span>
                    </label>
                </div>
                <div class="flex justify-end">
                    <a class="btn btn-error mx-2" @click="back">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </MainCard>
</template>

<style scoped>

</style>
