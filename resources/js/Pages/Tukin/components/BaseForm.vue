<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import ErrorText from "@/Components/ErrorText.vue";

defineProps({
    grade: { type: Number, required: true },
    nominal: { type: Number, required: true },
    keterangan: { type: String, required: true },
});

defineEmits(["update:grade", "update:nominal", "update:keterangan"]);

const errors = computed(() => usePage().props.errors);
</script>

<template>
    <div class="grid gap-2">
        <div class="flex items-start">
            <label class="w-1/3">
                Grade Tukin
                <span class="align-super text-xs text-error">*)</span>
            </label>
            <div class="w-2/3">
                <input
                    class="input input-bordered w-full text-sm"
                    :class="{ 'input-error': errors.grade }"
                    type="number"
                    :value="grade"
                    @input="$emit('update:grade', $event.target.value)"
                />
                <ErrorText :text="errors.grade" />
            </div>
        </div>
        <div class="flex items-start">
            <label class="w-1/3">
                Nominal Tukin
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
        <div class="flex items-start">
            <label class="w-1/3"> Keterangan </label>
            <div class="w-2/3">
                <textarea
                    class="textarea textarea-bordered textarea-sm w-full"
                    :class="{ 'input-error': errors.keterangan }"
                    type="text"
                    :value="keterangan"
                    @input="$emit('update:keterangan', $event.target.value)"
                />
                <ErrorText :text="errors.keterangan" />
            </div>
        </div>
    </div>
</template>
