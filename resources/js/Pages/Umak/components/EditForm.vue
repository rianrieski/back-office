<script setup>
import Modal from "@/Components/Modal.vue";
import MainCard from "@/Components/MainCard.vue";
import BaseForm from "@/Pages/Umak/components/BaseForm.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "@/Composables/sweetalert.ts";

const props = defineProps(["show", "umak"]);
const emit = defineEmits(["update:show"]);

const form = useForm({
    golongan_id: props.umak.golongan_id,
    nominal: props.umak.nominal,
});

const submit = () => {
    form.put(route("umak.update", props.umak), {
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
        <MainCard title="Edit Data Uang Makan">
            <form class="mt-4" @submit.prevent="submit">
                <BaseForm
                    v-model:nominal="form.nominal"
                    v-model:golongan_id="form.golongan_id"
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
