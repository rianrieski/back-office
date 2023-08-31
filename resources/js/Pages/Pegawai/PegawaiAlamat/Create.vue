<script setup>
import MainCard from "@/Components/MainCard.vue";
import { router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
const props = defineProps({
    propinsi:'',
    desa:'',
    success : false
})
const kota = ref([]);
const kecamatan = ref([]);
const desa = ref([]);
const form = useForm('createAlamat',{
    tipe_alamat:'',
    propinsi_id:'',
    kota_id:'',
    kecamatan_id:'',
    desa_id:'',
    kode_pos:'',
    alamat:''
});
const simpanAlamat = ()=>{
    form.post('/pegawai/alamat',{
        preserveScroll:true,
        preserveState:true,
        replace:true,
        onSuccess:(response)=>{
            router.get(route('alamat.index'));
            console.log('SUKSES');
        },
        onError:(errors)=>{
            console.log(errors.query);
        }
    })
}

const getKota = (propinsi_id)=>{
    form.clearErrors()
     router.get(route('alamat.create'),{
        propinsi_id: propinsi_id
    }, {
            only:['kota'],
            onSuccess:(response)=>{
                kota.value = response.props.kota
            },
            preserveState:true,
            preserveScroll:true,
            replace:true
        })
}
const getKecamatan = (kota_id)=>{
    router.get(route('alamat.create'),{
        kota_id:kota_id
    },{
        only:['kecamatan'],
        onSuccess:(response)=>{
            kecamatan.value = response.props.kecamatan
        },
        preserveState:true,
        preserveScroll:true,
        replace:true
    })
}
const getDesa = (kecamatan_id)=>{
    router.get(route('alamat.create'),{
        kecamatan_id:kecamatan_id
    },{
        only:['desa'],
        onSuccess:(response)=>{
            desa.value = response.props.desa
        },
        preserveScroll:true,
        preserveState:true,
        replace:true
    })
}
</script>

<template>
    <div class="text-sm breadcrumbs">
        <ul>
            <li><a>Beranda</a></li>
            <li><a>Pegawai</a></li>
            <li><a>Alamat</a></li>
            <li>Tambah</li>
        </ul>
    </div>
<MainCard>
            <div class="w-full p-6 m-auto lg:max-w-xl">
                <h2 class="text-2xl font-semibold text-center text-gray-700">Tambah Alamat</h2>
                <form class="space-y-4" @submit.prevent="simpanAlamat">

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tipe</span>
                        </label>
                        <select v-model="form.tipe_alamat" class="select select-bordered" :class="{'select-error':form.errors.tipe_alamat}">
                            <option disabled selected>Pilih tipe</option>
                            <option value="D">Domisili</option>
                            <option value="K">Asal</option>
                        </select>
                        <label class="label">
                            <span v-if="form.errors.tipe_alamat" class="label-text-alt text-error">{{form.errors.tipe_alamat}}</span>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Propinsi</span>
                        </label>
                        <select v-model="form.propinsi_id" @change.prevent="getKota(form.propinsi_id)" class="select select-bordered" :class="{'select-error':form.errors.propinsi_id}">
                            <option disabled selected>Pilih propinsi</option>
                            <option v-for="prop in propinsi" :value="prop.id">{{prop.nama}}</option>
                        </select>
                        <label class="label">
                            <span v-if="form.errors.propinsi_id" class="label-text-alt text-error">{{form.errors.propinsi_id}}</span>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Kota/Kabupaten</span>
                        </label>
                        <select v-model="form.kota_id" @change="getKecamatan(form.kota_id)" class="select select-bordered" :class="{'select-error':form.errors.kota_id}">
                            <option disabled selected>Pilih kota/kabupaten</option>
                            <option v-for="kot in kota" :value="kot.id">{{kot.nama}}</option>
                        </select>
                        <label class="label">
                            <span v-if="form.errors.kota_id" class="label-text-alt text-error">{{form.errors.kota_id}}</span>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Kecamatan</span>
                        </label>
                        <select v-model="form.kecamatan_id" @change="getDesa(form.kecamatan_id)" class="select select-bordered" :class="{'select-error':form.errors.kecamatan_id}">
                            <option disabled selected>Pilih kecamatan</option>
                            <option v-for="kec in kecamatan" :value="kec.id">{{kec.nama}}</option>
                        </select>
                        <label class="label">
                            <span v-if="form.errors.kecamatan_id" class="label-text-alt text-error">{{form.errors.kecamatan_id}}</span>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Desa</span>
                        </label>
                        <select v-model="form.desa_id" class="select select-bordered" :class="{'select-error':form.errors.desa_id}">
                            <option disabled selected>Pilih desa</option>
                            <option v-for="des in desa" :value="des.id">{{des.nama}}</option>
                        </select>
                        <label class="label">
                            <span v-if="form.errors.desa_id" class="label-text-alt text-error">{{form.errors.desa_id}}</span>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Kode Pos</span>
                        </label>
                        <input v-model="form.kode_pos" type="number" placeholder="Masukkan kode pos" class="input input-bordered" :class="{'input-error':form.errors.kode_pos}" />
                        <label class="label">
                            <span v-if="form.errors.kode_pos" class="label-text-alt text-error">{{form.errors.kode_pos}}</span>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Alamat Lengkap</span>
                        </label>
                        <textarea v-model="form.alamat" class="textarea textarea-bordered h-24" :class="{'textarea-error':form.errors.alamat}" placeholder="Masukkan alamat lengkap"></textarea>
                        <label class="label">
                            <span v-if="form.errors.alamat" class="label-text-alt text-error">{{form.errors.alamat}}</span>
                        </label>
                    </div>
                    <div class="flex justify-end">
                        <button class="btn btn-error mx-2">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
</MainCard>
</template>
