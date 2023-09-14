<script setup>
import MainCard from "@/Components/MainCard.vue";
import { router, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import vSelect from "vue-select";
import Swal from "sweetalert2";
const props = defineProps({
    title: "",
    pegawai: "",
    pendidikan: "",
    jenis_kawin: "",
});
const form = useForm({
    pegawai_id: "",
    nama: "",
    nik: "",
    tempat_lahir: "",
    tanggal_lahir: "",
    tanggal_kawin: "",
    no_kartu: "",
    is_pns: "",
    pendidikan_id: "",
    pekerjaan: "",
    status_tunjangan: "",
    no_sk_cerai: "",
    tmt_sk_cerai: "",
    jenis_kawin_id: "",
    no_buku_nikah: "",
    media_foto_pasangan: "",
    media_buku_nikah: "",
});
const selectedPegawai = computed({
    get() {
        return props.pegawai.find((peg) => peg.id === form.pegawai_id);
    },
    set(pegawai) {
        form.pegawai_id = pegawai.id;
    },
});
const selectedPendidikan = computed({
    get() {
        return props.pendidikan.find((gaj) => gaj.id === form.pendidikan_id);
    },
    set(pendidikan) {
        form.pendidikan_id = pendidikan.id;
    },
});
const selectedJenisKawin = computed({
    get() {
        return props.jenis_kawin.find(
            (jenis) => jenis.id === form.jenis_kawin_id,
        );
    },
    set(jenis_kawin) {
        form.jenis_kawin_id = jenis_kawin.id;
    },
});
const saveSuamiIstri = () => {
    form.post(route("suami-istri.store"), {
        onSuccess: (response) => {
            Swal.fire({
                title: "Tersimpan!",
                text: response.props.success,
                icon: "success",
                confirmButtonText: "OK",
            });
            router.get(route("suami-istri.index"));
        },
        onError: (errors) => {
            if (errors.query) {
                Swal.fire({
                    title: "Gagal!",
                    text: errors.query,
                    icon: "error",
                    confirmButtonText: "OK",
                });
            }
        },
    });
};
</script>

<template>
    <MainCard :title="title">
        <div class="m-auto w-full p-6 lg:max-w-xl">
            <h2 class="text-center text-2xl font-semibold text-gray-700">
                {{ title }}
            </h2>
            <form class="space-y-4" @submit.prevent="saveSuamiIstri">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Pegawai</span>
                    </label>
                    <vSelect
                        v-model="selectedPegawai"
                        :options="pegawai"
                        label="nama_lengkap"
                        class="w-full"
                    >
                    </vSelect>
                    <label class="label">
                        <span
                            v-if="form.errors.pegawai_id"
                            class="label-text-alt text-error"
                            >{{ form.errors.pegawai_id }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nama</span>
                    </label>
                    <input
                        v-model="form.nama"
                        type="text"
                        placeholder="Masukkan Nama"
                        class="input input-bordered"
                        :class="{ 'select-error': form.errors.nama }"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.nama"
                            class="label-text-alt text-error"
                            >{{ form.errors.nama }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">NIK</span>
                    </label>
                    <input
                        v-model="form.nik"
                        onkeypress="if(this.value.length==16) return false;"
                        type="number"
                        placeholder="Masukkan Nik"
                        class="input input-bordered"
                        :class="{ 'select-error': form.errors.nik }"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.nik"
                            class="label-text-alt text-error"
                            >{{ form.errors.nik }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tempat Lahir</span>
                    </label>
                    <input
                        v-model="form.tempat_lahir"
                        type="text"
                        placeholder="Masukkan Tempat Lahir"
                        class="input input-bordered"
                        :class="{ 'select-error': form.errors.tempat_lahir }"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.tempat_lahir"
                            class="label-text-alt text-error"
                            >{{ form.errors.tempat_lahir }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanggal Lahir</span>
                    </label>
                    <input
                        v-model="form.tanggal_lahir"
                        type="date"
                        placeholder="Masukkan Tanggal Lahir"
                        class="input input-bordered"
                        :class="{ 'select-error': form.errors.tanggal_lahir }"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.tanggal_lahir"
                            class="label-text-alt text-error"
                            >{{ form.errors.tanggal_lahir }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanggal Kawin</span>
                    </label>
                    <input
                        v-model="form.tanggal_kawin"
                        type="date"
                        placeholder="Masukkan Tanggal Kawin"
                        class="input input-bordered"
                        :class="{ 'select-error': form.errors.tanggal_kawin }"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.tanggal_kawin"
                            class="label-text-alt text-error"
                            >{{ form.errors.tanggal_kawin }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">No Kartu</span>
                    </label>
                    <input
                        v-model="form.no_kartu"
                        type="text"
                        placeholder="Masukkan No Kartu Nikah"
                        class="input input-bordered"
                        :class="{ 'select-error': form.errors.no_kartu }"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.no_kartu"
                            class="label-text-alt text-error"
                            >{{ form.errors.no_kartu }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">PNS</span>
                    </label>
                    <select
                        v-model="form.is_pns"
                        class="select select-bordered"
                        :class="{
                            'select-error': form.errors.is_pns,
                        }"
                    >
                        <option disabled selected>Pilih tipe</option>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                    <label class="label">
                        <span
                            v-if="form.errors.is_pns"
                            class="label-text-alt text-error"
                            >{{ form.errors.is_pns }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Pendidikan</span>
                    </label>
                    <vSelect
                        v-model="selectedPendidikan"
                        :options="pendidikan"
                        label="nama"
                        class="w-full"
                    >
                    </vSelect>
                    <label class="label">
                        <span
                            v-if="form.errors.pendidikan_id"
                            class="label-text-alt text-error"
                            >{{ form.errors.pendidikan_id }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Pekerjaan</span>
                    </label>
                    <input
                        v-model="form.pekerjaan"
                        type="text"
                        placeholder="Masukkan Pekerjaan"
                        class="input input-bordered"
                        :class="{ 'select-error': form.errors.pekerjaan }"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.pekerjaan"
                            class="label-text-alt text-error"
                            >{{ form.errors.pekerjaan }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Status Tunjangan</span>
                    </label>
                    <select
                        v-model="form.status_tunjangan"
                        class="select select-bordered"
                        :class="{
                            'select-error': form.errors.status_tunjangan,
                        }"
                    >
                        <option disabled selected>Pilih tipe</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                    <label class="label">
                        <span
                            v-if="form.errors.status_tunjangan"
                            class="label-text-alt text-error"
                            >{{ form.errors.status_tunjangan }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">No SK Cerai</span>
                    </label>
                    <input
                        v-model="form.no_sk_cerai"
                        type="text"
                        placeholder="Masukkan No SK Cerai"
                        class="input input-bordered"
                        :class="{ 'select-error': form.errors.no_sk_cerai }"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.no_sk_cerai"
                            class="label-text-alt text-error"
                            >{{ form.errors.no_sk_cerai }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tmt SK Cerai</span>
                    </label>
                    <input
                        v-model="form.tmt_sk_cerai"
                        type="date"
                        placeholder="Masukkan Tmt SK Cerai"
                        class="input input-bordered"
                        :class="{ 'select-error': form.errors.tmt_sk_cerai }"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.tmt_sk_cerai"
                            class="label-text-alt text-error"
                            >{{ form.errors.tmt_sk_cerai }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Jenis Kawin</span>
                    </label>
                    <vSelect
                        v-model="selectedJenisKawin"
                        :options="jenis_kawin"
                        label="nama"
                        class="w-full"
                    >
                    </vSelect>
                    <label class="label">
                        <span
                            v-if="form.errors.jenis_kawin_id"
                            class="label-text-alt text-error"
                            >{{ form.errors.jenis_kawin_id }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">No Buku Nikah</span>
                    </label>
                    <input
                        v-model="form.no_buku_nikah"
                        type="text"
                        placeholder="Masukkan No Buku Nikah"
                        class="input input-bordered"
                        :class="{ 'select-error': form.errors.no_buku_nikah }"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.no_buku_nikah"
                            class="label-text-alt text-error"
                            >{{ form.errors.no_buku_nikah }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Buku Nikah</span>
                    </label>
                    <input
                        accept=".pdf"
                        @input="form.media_buku_nikah = $event.target.files[0]"
                        type="file"
                        placeholder="Masukkan file sertifikat"
                        class="file-input file-input-bordered"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.media_buku_nikah"
                            class="label-text-alt text-error"
                            >{{ form.errors.media_buku_nikah }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Foto Pasangan</span>
                    </label>
                    <input
                        accept=".jpg,.png,.jpeg"
                        @input="
                            form.media_foto_pasangan = $event.target.files[0]
                        "
                        type="file"
                        placeholder="Masukkan file sertifikat"
                        class="file-input file-input-bordered"
                    />
                    <label class="label">
                        <span
                            v-if="form.errors.media_foto_pasangan"
                            class="label-text-alt text-error"
                            >{{ form.errors.media_foto_pasangan }}</span
                        >
                    </label>
                </div>

                <div class="flex justify-end">
                    <a
                        class="btn btn-error mx-2"
                        @click="
                            () => {
                                router.get(route('suami-istri.index'));
                            }
                        "
                        >Batal</a
                    >
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </MainCard>
</template>

<style scoped></style>
