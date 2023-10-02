<script setup>
import MainCard from "@/Components/MainCard.vue";
import { router } from "@inertiajs/vue3";
import {
    PencilSquareIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline/index.js";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { useLocalCurrency } from "@/Composables/filters.ts";
import { useConfirm, useToast } from "@/Composables/sweetalert.ts";
import { ref } from "vue";
import CreateForm from "@/Pages/Tukin/components/CreateForm.vue";
import EditForm from "@/Pages/Tukin/components/EditForm.vue";

const props = defineProps(["title", "tukin_list"]);

const showModal = ref(false);
const modalComponent = ref(null);
const selectedTukin = ref(null);

const destroy = async (tukin) => {
    const confirmed = await useConfirm({
        text: "Hapus data tunjangan kinerja untuk grade " + tukin.grade,
    });

    router.delete(route("tukin.destroy", { tukin }), {
        onBefore: () => confirmed,
        onError: (errors) =>
            useToast({ icon: "error", text: Object.values(errors)[0] }),
    });
};

const tambahTukin = () => {
    modalComponent.value = CreateForm;
    showModal.value = true;
};

const editTukin = (tukin) => {
    selectedTukin.value = tukin;
    modalComponent.value = EditForm;
    showModal.value = true;
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
        :tukin="selectedTukin"
        v-model:show="showModal"
    />

    <MainCard :title="title">
        <div class="mt-4 flex justify-between py-4">
            <div class="justify-start">
                <button
                    class="btn btn-primary btn-outline"
                    @click="tambahTukin"
                >
                    Rekam Data Baru
                </button>
            </div>
        </div>
        <table class="table" aria-describedby="Tabel Master Tunjangan Kinerja">
            <thead>
                <tr>
                    <th class="w-1/12">No</th>
                    <th class="w-2/12">Grade Tukin</th>
                    <th class="w-3/12">Nominal Tukin</th>
                    <th class="w-4/12">Keterangan</th>
                    <th class="w-1/12">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="hover"
                    v-for="(row, index) in tukin_list"
                    :key="row.id"
                >
                    <td>{{ index + 1 }}</td>
                    <td>{{ row.grade }}</td>
                    <td>{{ useLocalCurrency(row.nominal) }}</td>
                    <td>{{ row.keterangan || "-" }}</td>
                    <td>
                        <div class="flex gap-1">
                            <PencilSquareIcon
                                class="h-5 w-5 cursor-pointer text-primary"
                                @click="editTukin(row)"
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
