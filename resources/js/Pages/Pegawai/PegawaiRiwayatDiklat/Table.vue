<script setup>
import { router } from "@inertiajs/vue3";
import Table from "@/Pages/HirarkiUnitKerja/Table.vue";
import { onMounted, ref, watch } from "vue";
import { debounce } from "lodash";
import axios from "axios";
import Swal from "sweetalert2";

const addRiwayatDiklat = ()=>{
    router.get(route('riwayat-diklat.create'));
}
const riwayatDiklat = ref(Object)
onMounted(()=>{
    getDataRiwayatDiklat(route('riwayat-diklat.getdata'));
})
const paginate = ref(10)
const cari = ref('')
watch(cari,debounce (value =>{
    getDataRiwayatDiklat(route('riwayat-diklat.getdata')+'?cari='+value+'&paginate='+paginate.value)
},500));
watch(paginate,value =>{
    getDataRiwayatDiklat(route('riwayat-diklat.getdata')+'?cari='+cari.value+'&paginate='+value)
});
const getDataRiwayatDiklat = async (value)=>{
    const result = await axios.get(value)
    riwayatDiklat.value = result.data
}
const toShow = (id)=>{
    getRiwayatDiklatDetail(id)
    modal_riwayat.showModal()
}
const riwayatDiklatDetail = ref([])
const getRiwayatDiklatDetail = async (value)=>{
    try {
        const result = await axios.get(route('riwayat-diklat.show',value))
        riwayatDiklatDetail.value = result.data.data
    }catch (e){
        Swal.fire({
            title:'Error!',
            icon:"error",
            text:e.response.data.message,
            confirmButtonText:'OK'
        })
    }

}
</script>

<template>
    <div class="overflow-x-auto">
        <div class="py-4 flex justify-between">
            <div class="justify-start">
                <button class="btn btn-primary" @click="addRiwayatDiklat">Tambah</button>
            </div>
            <div class="justify-end">
                <input v-model="cari" type="text" placeholder="Cari" class="input input-bordered w-auto max-w-xs mr-2" />
                <select v-model="paginate"  class="select select-bordered w-auto max-w-xs">
                    <option value="5">5</option>
                    <option value="10" >10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <table class="table" aria-describedby="Tabel Alamat Pegawai">
            <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Pegawai</th>
                <th scope="col">Jenis Diklat</th>
                <th scope="col">Tanggal Mulai</th>
                <th scope="col">Tanggal Akhir</th>
                <th scope="col">Penyelenggaraan</th>
                <th scope="col">No Sertifikat</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover" v-for="(riwayat,index) in riwayatDiklat.data">
                <th scope="col">{{index+1}}</th>
                <td>{{riwayat.pegawai.nama_depan +' '+ riwayat.pegawai.nama_belakang}}</td>
                <td>{{riwayat.jenis_diklat.nama}}</td>
                <td>{{riwayat.tanggal_mulai}}</td>
                <td>{{riwayat.tanggal_akhir}}</td>
                <td>{{riwayat.penyelenggaran}}</td>
                <td>{{riwayat.no_sertifikat}}</td>
                <td>
                    <div class="dropdown dropdown-left">
                        <label tabindex="0" class="btn btn-xs m-1">Aksi</label>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-30">
                            <li><button @click="toEdit(riwayat.id)">Edit</button></li>
                            <li><button @click="toShow(riwayat.id)">Detail</button></li>
                            <li><button  @click="toDelete(riwayat.id)">Hapus</button></li>
                        </ul>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="join flex justify-end">
            <Component
                :is="link.url?'a':'span'"
                v-for="link in riwayatDiklat.links"
                @click="getDataRiwayatDiklat(link.url + '&paginate=' + paginate +'&cari='+cari)"
                v-html="link.label"
                class="join-item btn btn-xs"
                :class="{'btn-disabled': !link.url, 'btn-active':link.active}"
            />
        </div>
    </div>
    <dialog id="modal_riwayat" class="modal">
        <form method="dialog" class="modal-box">
            <div class="overflow-x-auto">
                <table class="w-11/12">
                    <caption class="font-bold text-lg mb-4">Detail Riwayat</caption>
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tr>
                        <td class="">Nama Pegawai</td>
                        <td v-if="riwayatDiklatDetail" v-html="riwayatDiklatDetail.nama_lengkap"></td>
                    </tr>
                    <tr>
                        <td>Jenis Diklat</td>
                        <td v-if="riwayatDiklatDetail"  v-html="riwayatDiklatDetail.nama_diklat"></td>
                    </tr>
                    <tr>
                        <td>Tanggal Mulai</td>
                        <td v-html="riwayatDiklatDetail.tanggal_mulai"></td>
                    </tr>
                    <tr>
                        <td>Tanggal Akhir</td>
                        <td v-html="riwayatDiklatDetail.tanggal_akhir"></td>
                    </tr>
                    <tr>
                        <td>Jam Pelajaran</td>
                        <td v-html="riwayatDiklatDetail.jam_pelajaran"></td>
                    </tr>
                    <tr>
                        <td>Lokasi</td>
                        <td v-html="riwayatDiklatDetail.lokasi"></td>
                    </tr>
                    <tr>
                        <td>Penyelenggaraan</td>
                        <td v-html="riwayatDiklatDetail.penyelenggaran"></td>
                    </tr>
                    <tr>
                        <td>No Sertifikat</td>
                        <td v-html="riwayatDiklatDetail.no_sertifikat"></td>
                    </tr>
                    <tr>
                        <td>Tanggal Sertifikat</td>
                        <td v-html="riwayatDiklatDetail.tanggal_sertifikat"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-action">
                <button class="btn btn-sm btn-primary" @click="resetAlamatDetail">Tutup</button>
            </div>
        </form>
    </dialog>

</template>

<style scoped>

</style>
