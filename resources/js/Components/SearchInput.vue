<script setup>
import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline/index.js";
import { debounce } from "lodash";
import { computed, onMounted } from "vue";

const props = defineProps({
    placeholder: {
        type: String,
        default: "Cari",
    },
    modelValue: String,
    search: {
        type: Function,
        required: true,
    },
});

onMounted(() => {
    const params = route().params;
    if (params?.filter) {
        emit("update:modelValue", Object.values(params.filter)[0]);
    }
});

const emit = defineEmits(["update:modelValue"]);

const keyword = computed({
    get: () => props.modelValue,
    set: debounce((val) => {
        emit("update:modelValue", val);
        props.search();
    }, 300),
});
</script>

<template>
    <div class="relative">
        <div
            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
        >
            <MagnifyingGlassIcon class="w-4" />
        </div>
        <input
            v-model="keyword"
            type="text"
            class="input input-bordered input-md w-full pl-10"
            :placeholder="placeholder"
        />
    </div>
</template>
