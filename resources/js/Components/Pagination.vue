<script setup>
import {
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
} from "@heroicons/vue/24/outline/index.js";

defineProps({
    links: Array,
});

defineEmits(["goToPage"]);
</script>

<template>
    <div class="join">
        <button
            class="btn join-item btn-sm"
            :class="link.active ? 'btn-primary' : ''"
            v-for="link in links"
            :key="link.label"
            @click.prevent="$emit('goToPage', link.label)"
        >
            <template v-if="link.label.includes('previous')">
                <ChevronDoubleLeftIcon class="w-4" />
            </template>
            <template v-else-if="link.label.includes('next')">
                <ChevronDoubleRightIcon class="w-4" />
            </template>
            <template v-else>
                {{ link.label }}
            </template>
        </button>
    </div>
</template>
