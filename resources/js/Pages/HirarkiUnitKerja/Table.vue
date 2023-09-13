<script setup>
import {  onMounted, ref, watch } from "vue";
import axios from "axios";
import { debounce } from "lodash";
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
onMounted(()=>{
  getDataHirarkiUnitKerja(route('hirarki-unit-kerja.getdata'));
})
const hirarkiUnitKerja = ref([])
const paginate = ref(10)
const cari = ref('')

const getDataHirarkiUnitKerja = async (value)=>{
    const result = await axios.get(value)
    hirarkiUnitKerja.value = result.data
}
watch(cari,debounce (value =>{
    getDataHirarkiUnitKerja(route('hirarki-unit-kerja.getdata')+'?cari='+value+'&paginate='+paginate.value)
},500));
watch(paginate,value =>{
    getDataHirarkiUnitKerja(route('hirarki-unit-kerja.getdata')+'?cari='+cari.value+'&paginate='+value)
});

const toEdit = (id)=>{
    router.get(route('hirarki-unit-kerja.edit',id),{},{
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
const toDelete = (id)=>{
    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "hapus data hirarki unit kerja",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('hirarki-unit-kerja.destroy',id),{
                onSuccess:(response)=>{
                    Swal.fire(
                        {
                            title: 'Berhasil!',
                            text: response.props.success,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }
                    )
                    getDataHirarkiUnitKerja(route('hirarki-unit-kerja.getdata'))
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
    })

}

</script>

<template>
    <div class="overflow-x-auto">
        <div class="py-4 flex justify-between">
            <div class="justify-start">
                <button class="btn btn-primary" @click="()=>{router.get(route('hirarki-unit-kerja.create'))}">Tambah</button>
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
                <th scope="col">Unit Kerja</th>
                <th scope="col">Atasan Langsung</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover" v-for="(hirarki,index) in hirarkiUnitKerja.data">
                <th scope="col">{{index+1}}</th>
                <td>{{hirarki.nama_child}}</td>
                <td>{{hirarki.nama_parent}}</td>
                <td>
                    <div class="dropdown dropdown-left">
                        <label tabindex="0" class="btn btn-xs m-1">Aksi</label>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-30">
                            <li><button @click="toEdit(hirarki.id)">Edit</button></li>
                            <li><button  @click="toDelete(hirarki.id)">Hapus</button></li>
                        </ul>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
            <div class="join flex justify-end">
                <Component
                    :is="link.url?'a':'span'"
                    v-for="link in hirarkiUnitKerja.links"
                    @click="getDataHirarkiUnitKerja(link.url + '&paginate=' + paginate +'&cari='+cari)"
                    v-html="link.label"
                    class="join-item btn btn-xs"
                    :class="{'btn-disabled': !link.url, 'btn-active':link.active}"
                />
            </div>
    </div>
</template>
