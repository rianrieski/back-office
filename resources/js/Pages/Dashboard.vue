<script setup>
import { defineOptions } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MainCard from "@/Components/MainCard.vue";

defineOptions({ layout: AuthenticatedLayout });
</script>

<template>
    <Head title="Dashboard" />

    <MainCard title="Dashboard">
        <div>You're logged in!</div>
    </MainCard>
</template>
