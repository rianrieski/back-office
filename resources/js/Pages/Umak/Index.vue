<script setup>
import MainCard from "@/Components/MainCard.vue";
import { router } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { useLocalCurrency } from "@/Composables/filters.ts";
import { useConfirm, useToast } from "@/Composables/sweetalert.ts";
import {
    PencilSquareIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline/index.js";
import { ref } from "vue";
import CreateForm from "@/Pages/Umak/components/CreateForm.vue";
import EditForm from "@/Pages/Umak/components/EditForm.vue";

defineProps(["title", "umak_list"]);

const showModal = ref(false);
const selectedUmak = ref(null);
const modalComponent = ref(null);

const tambahUmak = () => {
    modalComponent.value = CreateForm;
    showModal.value = true;
};

const editUmak = (umak) => {
    selectedUmak.value = umak;
    modalComponent.value = EditForm;
    showModal.value = true;
};

const destroy = async (umak) => {
    const confirmed = await useConfirm({
        text: "Hapus data uang makan untuk golongan " + umak.golongan.nama,
    });

    router.delete(route("umak.destroy", umak), {
        onBefore: () => confirmed,
        onError: (errors) =>
            useToast({ icon: "error", text: Object.values(errors)[0] }),
    });
};
</script>

<template>
    <Head :title="title" />

    <Breadcrumb
        :lists="[
            { label: 'Beranda', url: route('dashboard') },
            { label: 'Tunjangan Kinerja' },
        ]"
    />

    <component
        :is="modalComponent"
        :umak="selectedUmak"
        v-model:show="showModal"
    />

    <MainCard>
        <div class="mt-4 flex justify-between py-4">
            <div class="justify-start">
                <button class="btn btn-primary btn-outline" @click="tambahUmak">
                    Rekam Data Baru
                </button>
            </div>
        </div>
        <table class="table" aria-describedby="Tabel Master Tunjangan Kinerja">
            <thead>
                <tr>
                    <th class="w-1/12">No</th>
                    <th class="w-2/12">Golongan</th>
                    <th class="w-3/12">Nominal Uang Makan / Hari</th>
                    <th class="w-1/12">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="hover"
                    v-for="(row, index) in umak_list"
                    :key="row.id"
                >
                    <td>{{ index + 1 }}</td>
                    <td>{{ row.golongan.nama }}</td>
                    <td>{{ useLocalCurrency(row.nominal) }}</td>
                    <td>
                        <div class="flex gap-1">
                            <PencilSquareIcon
                                class="h-5 w-5 cursor-pointer text-primary"
                                @click="editUmak(row)"
                            />
                            <TrashIcon
                                class="h-5 w-5 cursor-pointer text-error"
                                @click="destroy(row)"
                            />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </MainCard>
</template>
