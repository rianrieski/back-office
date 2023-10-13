<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    pegawai_id: { type: Number, required: true },
    penghargaan_id: { type: Number, required: true },
    no_sk: { type: String, required: true },
    tanggal_sk: { type: [Date, String], required: true },
    tahun: { type: Number, required: true },
    media_sk: { type: String, required: true },
});

const emit = defineEmits([
    "update:pegawai_id",
    "update:penghargaan_id",
    "update:no_sk",
    "update:tanggal_sk",
    "update:tahun",
    "update:media_sk",
]);

const pegawai = computed(() => usePage().props.pegawai);
const penghargaan = computed(() => usePage().props.penghargaan);
</script>

<template>
    <div class="grid gap-2 md:grid-cols-2">
        <div class="form-control">
            <label class="label">Pegawai</label>
            <!--            -->
        </div>
        <div class="form-control">
            <label class="label">Penghargaan</label>
            <select
                class="select select-bordered"
                :value="penghargaan_id"
                @change="$emit('update:penghargaan_id', $event.target.value)"
            >
                <option v-for="harga in penghargaan" :value="harga.id">
                    {{ harga.nama }}
                </option>
            </select>
        </div>
        <div class="form-control">
            <label class="label">Nomor SK</label>
            <input
                class="input input-bordered"
                type="text"
                :value="no_sk"
                @input="$emit('update:no_sk', $event.target.value)"
            />
        </div>
        <div class="form-control">
            <label class="label">Tanggal SK</label>
            <input
                class="input input-bordered"
                type="date"
                :value="tanggal_sk"
                @change="$emit('update:tanggal_sk', $event.target.value)"
            />
        </div>
        <div class="form-control">
            <label class="label">Tahun</label>
            <input
                class="input input-bordered"
                type="number"
                :value="tahun"
                @input="$emit('update:tahun', $event.target.value)"
            />
        </div>
        <div class="form-control">
            <label class="label">SK Penghargaan</label>
            <input type="file" class="file-input file-input-bordered" />
        </div>
    </div>
</template>
