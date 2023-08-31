<script setup>
import { Link, router } from "@inertiajs/vue3";
import MainCard from "@/Components/MainCard.vue";
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import "datatables.net-responsive";

DataTable.use(DataTablesCore);

defineProps({
    pegawai: Array,
});

const showAlert = () => {
    Toast.fire({
        icon: "success",
        text: "Hello Ridhal!!",
    });
};
</script>

<template>
    <div>
        <Head title="Pegawai" />
        <MainCard>
            <div class="flex justify-between">
                <h1 class="text-xl font-bold">Data Pegawai</h1>
                <Link
                    :href="route('pegawai.create')"
                    class="btn-primary rounded-md p-2"
                >
                    + Pegawai
                </Link>
            </div>
            <div class="table-responsive">
                <DataTable
                    class="table-bordered table display"
                    id="dataTable"
                    width="100%"
                    cellspacing="0"
                >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in pegawai">
                            <td>{{ index + 1 }}</td>
                            <td>
                                {{ item.nama_depan }} {{ item.nama_belakang }}
                            </td>
                            <td>{{ item.nip }}</td>
                            <td class="flex justify-evenly">
                                <Link
                                    class="rounded-md bg-yellow-600 p-2 text-white hover:bg-yellow-500"
                                    :href="
                                        route('pegawai.edit', {
                                            pegawai: item.id,
                                        })
                                    "
                                >
                                    Edit
                                </Link>
                                <button
                                    class="rounded-md bg-red-700 p-2 text-white hover:bg-red-600"
                                    @click="showAlert"
                                >
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </DataTable>
            </div>
        </MainCard>
    </div>
</template>

<style scoped>
@import "datatables.net-dt";
</style>
