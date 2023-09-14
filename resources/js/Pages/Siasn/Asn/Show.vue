<script setup>
import MainCard from "@/Components/MainCard.vue";

defineProps(["asn"]);
</script>

<template>
    <Head title="SIASN - Data ASN" />

    <MainCard>
        {{ asn }}
    </MainCard>
</template>
