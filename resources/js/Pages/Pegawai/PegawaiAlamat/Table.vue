<script setup>
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { onMounted, ref, watch } from "vue";
import { debounce } from "lodash";

const tambahAlamat = ()=>{
    router.get(route('alamat.create'));
}
const toEdit = (id)=>{
    router.get(route('alamat.edit',id),{},{
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
        text: "hapus data pegawai",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('alamat.destroy',id),{
                onSuccess:(response)=>{
                    Swal.fire(
                        {
                            title: 'Berhasil!',
                            text: response.props.success,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }
                    )
                    getDataPegawaiAlamat(route('alamat.getdata'));
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
const pegawaiAlamat = ref([])
const getDataPegawaiAlamat = async (value)=>{
    const result = await axios.get(value);
    pegawaiAlamat.value = result.data
}
onMounted(()=>{
    getDataPegawaiAlamat(route('alamat.getdata'))
})
const cari = ref('')
const paginate = ref(10)
watch(cari,debounce (value =>{
    getDataPegawaiAlamat(route('alamat.getdata')+'?cari='+value+'&paginate='+paginate.value)
},500));
watch(paginate,value =>{
    getDataPegawaiAlamat(route('alamat.getdata')+'?cari='+cari.value+'&paginate='+value)
});

const getDataAlamatPegawaiDetail = async (value)=>{
    const result = await axios.get(value);
    pegawaiAlamatDetail.value = result.data
}
const pegawaiAlamatDetail = ref([])
const showDetail=(id)=>{
    getDataAlamatPegawaiDetail(route('alamat.show',id))
    modal_alamat.showModal()
}
const resetAlamatDetail = ()=>{
    pegawaiAlamatDetail.value = []
}
</script>

<template>
    <div class="overflow-x-auto">
        <div class="py-4 flex justify-between">
            <div class="justify-start">
                <button class="btn btn-primary" @click="tambahAlamat">Tambah</button>
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
                <th scope="col">Nama</th>
                <th scope="col">Tipe</th>
                <th scope="col">Propinsi</th>
                <th scope="col">Kota/Kabupaten</th>
                <th scope="col">Kecamatan</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover" v-for="(alamat,index) in pegawaiAlamat.data">
                <th scope="col">{{index+1}}</th>
                <th scope="col">{{alamat.nama_lengkap}}</th>
                <th scope="col">{{alamat.tipe_alamat}}</th>
                <td>{{alamat.nama_propinsi}}</td>
                <td>{{alamat.nama_kota}}</td>
                <td>{{alamat.nama_kecamatan}}</td>
                <td>
                    <div class="dropdown dropdown-left">
                        <div class="join">
                            <button class="join-item btn-xs btn-outline btn-primary tooltip tooltip-bottom" data-tip="Edit" @click="toEdit(alamat.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>
                            <button class="join-item btn-xs btn-outline btn-info tooltip tooltip-bottom" data-tip="Detail" @click="showDetail(alamat.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                            <button class="join-item btn-xs btn-outline btn-error tooltip tooltip-bottom" data-tip="Hapus" @click="toDelete(alamat.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="join flex justify-end">
            <Component
                :is="link.url?'a':'span'"
                v-for="link in pegawaiAlamat.links"
                @click="getDataPegawaiAlamat(link.url + '&paginate=' + paginate +'&cari='+cari)"
                v-html="link.label"
                class="join-item btn btn-xs"
                :class="{'btn-disabled': !link.url, 'btn-active':link.active}"
            />
        </div>
    </div>
    <dialog id="modal_alamat" class="modal">
        <form method="dialog" class="modal-box">
            <div class="overflow-x-auto">
                <table class="w-11/12">
                    <caption class="font-bold text-lg mb-4">Detail Pegawai</caption>
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tr>
                        <td class="">Nama Pegawai</td>
                        <td v-if="pegawaiAlamatDetail"  v-html="pegawaiAlamatDetail.nama_lengkap"></td>
                    </tr>
                    <tr>
                        <td>Tipe Alamat</td>
                        <td v-html="pegawaiAlamatDetail.tipe_alamat"></td>
                    </tr>
                    <tr>
                        <td>Propinsi</td>
                        <td v-html="pegawaiAlamatDetail.nama_propinsi"></td>
                    </tr>
                    <tr>
                        <td>Kota/Kabupaten</td>
                        <td v-html="pegawaiAlamatDetail.nama_kota"></td>
                    </tr>
                    <tr>
                        <td>Kecamatan</td>
                        <td v-html="pegawaiAlamatDetail.nama_kecamatan"></td>
                    </tr>
                    <tr>
                        <td>Desa</td>
                        <td v-html="pegawaiAlamatDetail.nama_desa"></td>
                    </tr>
                    <tr>
                        <td>Kode Pos</td>
                        <td v-html="pegawaiAlamatDetail.kode_pos"></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td v-html="pegawaiAlamatDetail.alamat"></td>
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
