<script setup>
import Modal from "@/Components/Modal.vue";
import MainCard from "@/Components/MainCard.vue";
import BaseForm from "@/Pages/Tukin/components/BaseForm.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "@/Composables/sweetalert.ts";

defineProps(["show"]);
const emit = defineEmits(["update:show"]);

const form = useForm({
    grade: null,
    nominal: null,
    keterangan: null,
});

const submit = () => {
    form.post(route("tukin.store"), {
        onError: (errors) =>
            useToast({ icon: "error", text: Object.values(errors)[0] }),
        onSuccess: () => {
            emit("update:show", false);
            form.reset();
        },
    });
};
</script>

<template>
    <Modal :show="show" @close="$emit('update:show', false)">
        <MainCard title="Buat Data Tunjangan Kinerja Baru">
            <form class="mt-4" @submit.prevent="submit">
                <BaseForm
                    v-model:keterangan="form.keterangan"
                    v-model:nominal="form.nominal"
                    v-model:grade="form.grade"
                />
                <div class="mt-4 flex justify-end gap-2">
                    <button
                        type="reset"
                        class="btn btn-neutral btn-outline"
                        @click="$emit('update:show', false)"
                    >
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </MainCard>
    </Modal>
</template>
