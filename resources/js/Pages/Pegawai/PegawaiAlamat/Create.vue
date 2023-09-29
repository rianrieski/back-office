<script setup>
import MainCard from "@/Components/MainCard.vue";
import { router, useForm } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed } from "vue";
import SelectOption from "@/Components/SelectOption.vue";
import ErrorText from "@/Components/ErrorText.vue";
import { useToast } from "@/Composables/sweetalert.ts";

const props = defineProps([
    "pegawai",
    "propinsi",
    "kota",
    "kecamatan",
    "desa",
    "errors",
]);

const form = useForm({
    pegawai_id: null,
    tipe_alamat: null,
    propinsi_id: null,
    kota_id: null,
    kecamatan_id: null,
    desa_id: null,
    kode_pos: null,
    alamat: null,
});

const getOptions = (label) => {
    return !props[label]
        ? JSON.parse(localStorage.getItem(label))
        : props[label];
};

const selectedPegawai = computed({
    get() {
        if (!form.pegawai_id) {
            return {};
        }
        return props.pegawai.find((peg) => peg.id === form.pegawai_id);
    },
    set(pegawai) {
        form.pegawai_id = pegawai.id;
    },
});

// onMounted(() => {
//     if (form.propinsi_id) {
//         fetchData("kota", { propinsi_id: form.propinsi_id });
//     }
//
//     if (form.kota_id) {
//         fetchData("kecamatan", { kota_id: form.kota_id });
//     }
//
//     if (form.kecamatan_id) {
//         fetchData("desa", { kecamatan_id: form.kecamatan_id });
//     }
// });

const simpanAlamat = () => {
    form.post(route("alamat.store"), {
        preserveScroll: true,
        preserveState: true,
        replace: true,
        onError: (errors) =>
            useToast({ icon: "error", text: Object.values(errors)[0] }),
    });
};

const fetchData = (label, params) => {
    router.get(route("alamat.create"), params, {
        only: [label],
        preserveScroll: true,
        preserveState: true,
        replace: true,
        onFinish: () => {
            localStorage.setItem(label, JSON.stringify(props[label]));
            if (label === "kota") {
                form.reset("kota_id", "kecamatan_id", "desa_id");
            } else if (label === "kecamatan") {
                form.reset("kecamatan_id", "desa_id");
            } else if (label === "desa") {
                form.reset("desa_id");
            }
        },
    });
};
</script>

<template>
    <Head title="Rekam Alamat Baru" />
    <Breadcrumb
        :lists="[
            { label: 'Beranda', url: route('dashboard') },
            { label: 'Pegawai', url: route('pegawai.index') },
            { label: 'Alamat', url: route('alamat.index') },
            { label: 'Tambah Data' },
        ]"
    />
    <MainCard title="Rekam Alamat Baru">
        <div class="m-auto w-full p-6 lg:max-w-xl">
            <form class="space-y-4" @submit.prevent="simpanAlamat">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Pegawai</span>
                    </label>
                    <SelectOption
                        :error="Boolean(errors.pegawai_id)"
                        :options="pegawai"
                        v-model="selectedPegawai"
                        label="nama"
                        placeholder="Pilih Pegawai"
                    />
                    <ErrorText :text="errors.pegawai_id" />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tipe</span>
                    </label>
                    <select
                        v-model="form.tipe_alamat"
                        class="select select-bordered"
                        :class="{ 'select-error': form.errors.tipe_alamat }"
                    >
                        <option disabled :value="null">Pilih tipe</option>
                        <option value="Domisili">Domisili</option>
                        <option value="Asal">Asal</option>
                    </select>
                    <ErrorText :text="errors.tipe_alamat" />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Propinsi</span>
                    </label>
                    <select
                        v-model="form.propinsi_id"
                        @change.prevent="
                            fetchData('kota', { propinsi_id: form.propinsi_id })
                        "
                        class="select select-bordered"
                        :class="{ 'select-error': form.errors.propinsi_id }"
                    >
                        <option disabled :value="null">Pilih propinsi</option>
                        <option v-for="prop in propinsi" :value="prop.id">
                            {{ prop.nama }}
                        </option>
                    </select>
                    <ErrorText :text="errors.propinsi_id" />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Kota/Kabupaten</span>
                    </label>
                    <select
                        v-model="form.kota_id"
                        @change.prevent="
                            fetchData('kecamatan', { kota_id: form.kota_id })
                        "
                        class="select select-bordered"
                        :class="{ 'select-error': form.errors.kota_id }"
                    >
                        <option disabled :value="null">
                            Pilih kota/kabupaten
                        </option>
                        <option
                            v-for="kot in getOptions('kota')"
                            :value="kot.id"
                        >
                            {{ kot.nama }}
                        </option>
                    </select>
                    <ErrorText :text="errors.kota_id" />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Kecamatan</span>
                    </label>
                    <select
                        v-model="form.kecamatan_id"
                        @change.prevent="
                            fetchData('desa', {
                                kecamatan_id: form.kecamatan_id,
                            })
                        "
                        class="select select-bordered"
                        :class="{ 'select-error': form.errors.kecamatan_id }"
                    >
                        <option disabled :value="null">Pilih kecamatan</option>
                        <option
                            v-for="kec in getOptions('kecamatan')"
                            :value="kec.id"
                        >
                            {{ kec.nama }}
                        </option>
                    </select>
                    <ErrorText :text="errors.kecamatan_id" />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Desa/Kelurahan</span>
                    </label>
                    <select
                        v-model="form.desa_id"
                        class="select select-bordered"
                        :class="{ 'select-error': form.errors.desa_id }"
                    >
                        <option disabled :value="null">Pilih desa</option>
                        <option
                            v-for="des in getOptions('desa')"
                            :value="des.id"
                        >
                            {{ des.nama }}
                        </option>
                    </select>
                    <ErrorText :text="errors.desa_id" />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Kode Pos</span>
                    </label>
                    <input
                        v-model="form.kode_pos"
                        type="number"
                        placeholder="Masukkan kode pos"
                        class="input input-bordered"
                        :class="{ 'input-error': form.errors.kode_pos }"
                    />
                    <ErrorText :text="errors.kode_pos" />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Alamat Lengkap</span>
                    </label>
                    <textarea
                        v-model="form.alamat"
                        class="textarea textarea-bordered h-24"
                        :class="{ 'textarea-error': form.errors.alamat }"
                        placeholder="Masukkan alamat lengkap"
                    ></textarea>
                    <ErrorText :text="errors.alamat" />
                </div>
                <div class="flex justify-end">
                    <button class="btn btn-error mx-2">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </MainCard>
</template>
