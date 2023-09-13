<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MainCard from "@/Components/MainCard.vue";

defineOptions({ layout: AuthenticatedLayout });
</script>

<template>
    <Head title="Welcome" />

    <MainCard title="Test Judul">
        <div>test halaman</div>
        <Link href="/toast">Toast</Link>
    </MainCard>
</template>
