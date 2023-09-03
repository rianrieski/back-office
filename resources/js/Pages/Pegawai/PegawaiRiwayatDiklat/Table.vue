<script setup>
import { router } from "@inertiajs/vue3";

const addRiwayatDiklat = ()=>{
    router.get(route('riwayat-diklat.create'));
}
</script>

<template>
    <div class="overflow-x-auto">
        <div class="py-4 flex justify-between">
            <div class="justify-start">
                <button class="btn btn-primary" @click="addRiwayatDiklat">Tambah</button>
            </div>
            <div class="justify-end">
                <input type="text" placeholder="Cari" class="input input-bordered w-auto max-w-xs mr-2" />
                <select  class="select select-bordered w-auto max-w-xs">
                    <option value="5">5</option>
                    <option value="10" >10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
