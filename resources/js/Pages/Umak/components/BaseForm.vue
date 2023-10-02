<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import ErrorText from "@/Components/ErrorText.vue";

defineProps({
    golongan_id: { type: Number, required: true },
    nominal: { type: Number, required: true },
});

defineEmits(["update:golongan_id", "update:nominal"]);

const errors = computed(() => usePage().props.errors);
const golongan = computed(() => usePage().props.golongan);
</script>

<template>
    <div class="grid gap-2">
        <div class="flex items-start">
            <label class="w-1/3">
                Golongan
                <span class="align-super text-xs text-error">*)</span>
            </label>
            <div class="w-2/3">
                <select
                    :value="golongan_id"
                    @change="$emit('update:golongan_id', $event.target.value)"
                    class="select select-bordered w-full text-sm"
                    :class="{ 'select-error': errors.golongan_id }"
                >
                    <option :value="null" disabled>Pilih Golongan</option>
                    <option
                        v-for="gol in golongan"
                        :key="gol.id"
                        :value="gol.id"
                    >
                        {{ gol.nama }}
                    </option>
                </select>
                <ErrorText :text="errors.golongan_id" />
            </div>
        </div>
        <div class="flex items-start">
            <label class="w-1/3">
                Nominal Uang Makan
                <span class="align-super text-xs text-error">*)</span>
            </label>
            <div class="w-2/3">
                <input
                    class="input input-bordered w-full text-sm"
                    :class="{ 'input-error': errors.nominal }"
                    type="number"
                    :value="nominal"
                    @input="$emit('update:nominal', $event.target.value)"
                />
                <ErrorText :text="errors.nominal" />
            </div>
        </div>
    </div>
</template>
