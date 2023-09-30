<script setup>
import MainCard from "@/Components/MainCard.vue";
import SearchInputColumn from "@/Components/SearchInputColumn.vue";
import { ref } from "vue";
import PerPageOption from "@/Components/PerPageOption.vue";
import HeadColumn from "@/Components/HeadColumn.vue";
import { useQuery } from "@/Composables/tablequery.ts";
import { router } from "@inertiajs/vue3";
import ShowingResultTable from "@/Components/ShowingResultTable.vue";
import { useLocaleDate } from "@/Composables/filters.ts";
import Pagination from "@/Components/Pagination.vue";

defineProps(["title", "diklat"]);

const columns = [
    { label: "Pegawai", column: "pegawai" },
    { label: "Jenis Diklat", column: "jenis_diklat" },
    { label: "Tanggal Mulai", column: "tanggal_mulai" },
    { label: "Penyelenggara", column: "penyelenggara" },
    { label: "No Sertifikat", column: "no_sertifikat" },
];
const filterBy = ref({ label: "Pegawai", column: "pegawai" });
const keyword = ref("");
const perPage = ref(15);
const sortBy = ref("");
const query = useQuery({ keyword, filterBy, sortBy, perPage });
const fetchData = (params = {}) => {
    router.get(
        route("riwayat-diklat.index", {
            _query: { ...query.value, ...params },
        }),
        {},
        {
            only: ["diklat"],
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
};
</script>

<template>
    <Head :title="title" />

    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Beranda</a></li>
            <li>Pegawai</li>
            <li>
                <span class="text-info">{{ title }}</span>
            </li>
        </ul>
    </div>

    <MainCard :title="title">
        <div class="mt-8 grid gap-2 md:flex md:justify-between">
            <div>
                <button
                    class="btn btn-primary btn-outline"
                    @click="router.get(route('riwayat-diklat.create'))"
                >
                    Rekam Diklat Baru
                </button>
            </div>
            <div class="flex justify-between gap-2 md:justify-end">
                <SearchInputColumn
                    :options="columns"
                    :search="() => fetchData()"
                    v-model:keyword="keyword"
                    v-model:selected="filterBy"
                />
                <PerPageOption v-model="perPage" @change="() => fetchData()" />
            </div>
        </div>
        <div class="mt-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <HeadColumn
                            v-for="col in columns"
                            :key="col.label"
                            v-model="sortBy"
                            :content="col"
                            @click="() => fetchData()"
                        />
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="diklat.data.length < 0">
                        <td colspan="7" class="text-center">
                            Data tidak ditemukan
                        </td>
                    </tr>
                    <tr
                        v-else
                        class="hover"
                        v-for="(row, i) in diklat.data"
                        :key="row.id"
                    >
                        <td>{{ diklat.from + i }}</td>
                        <td>{{ row.pegawai.nama }}</td>
                        <td>{{ row.jenis_diklat.nama }}</td>
                        <td>
                            {{ useLocaleDate(new Date(row.tanggal_mulai)) }}
                        </td>
                        <td>{{ row.penyelenggara }}</td>
                        <td>{{ row.no_sertifikat }}</td>
                        <td>Aksi</td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4 grid gap-2 md:flex md:justify-between">
                <ShowingResultTable
                    :total="diklat.total"
                    :to="diklat.to"
                    :from="diklat.from"
                />
                <Pagination
                    :links="diklat.links"
                    @goToPage="(page) => fetchData({ page })"
                />
            </div>
        </div>
    </MainCard>
</template>
