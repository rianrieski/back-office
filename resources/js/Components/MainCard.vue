<script setup>
defineProps(["title"]);
</script>

<template>
    <div class="card shadow-xl">
        <div class="card-body">
            <h2 class="card-title">{{ title }}</h2>
            <slot></slot>
        </div>
    </div>
</template>
