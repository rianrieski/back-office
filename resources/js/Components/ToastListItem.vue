<script setup>
import { computed, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import {
    CheckCircleIcon,
    InformationCircleIcon,
    XCircleIcon,
} from "@heroicons/vue/24/outline/index.js";

const props = defineProps({
    type: {
        type: String,
        default: "success",
    },
    key: Symbol,
    message: String,
    duration: Number,
    onDismiss: Function,
});

const icon = computed(() => {
    switch (props.type) {
        case "success":
            return CheckCircleIcon;
        case "danger":
            return XCircleIcon;
        case "info":
            return InformationCircleIcon;
    }
});

const emit = defineEmits(["dismiss"]);

onMounted(() => {
    setTimeout(() => dismiss(), props.duration);
});

function dismiss() {
    if (props.onDismiss) {
        props.onDismiss();
        usePage().props.toast = null;
    }
}
</script>

<template>
    <div :class="`alert z-[2] alert-${type}`">
        <div class="flex items-center gap-2">
            <component :is="icon" :class="`w-8 text-${type}`" />
            <div>{{ message }}</div>
        </div>
    </div>
</template>
