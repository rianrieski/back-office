<script setup>
import MainCard from "@/Components/MainCard.vue";
import { DocumentMagnifyingGlassIcon } from "@heroicons/vue/24/outline/index.js";
import Pagination from "@/Components/Pagination.vue";
import ShowingResultTable from "@/Components/ShowingResultTable.vue";
import SearchInput from "@/Components/SearchInput.vue";
import { ref, watch } from "vue";
import PerPageOption from "@/Components/PerPageOption.vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";

defineProps(["asn"]);

const keyword = ref("");
const per_page = ref(15);

watch(
    keyword,
    debounce(() => {
        fetchData();
    }, 200),
);

watch(per_page, () => fetchData());

const fetchData = () => {
    router.get(
        route("siasn.asn.index", {
            _query: {
                filter: {
                    nama: keyword.value,
                },
                per_page: per_page.value,
            },
        }),
        {},
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
};

const goToPage = (page) => {};
</script>

<template>
    <Head title="SIASN - Data ASN" />

    <MainCard>
        <div>
            <div class="flex justify-between">
                <button class="btn btn-primary">Sinkronisasi</button>
                <div class="flex gap-2">
                    <SearchInput class="w-64" v-model="keyword" />
                    <PerPageOption v-model="per_page" />
                </div>
            </div>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama ASN</th>
                        <th>NIP</th>
                        <th>Golongan</th>
                        <th>Jabatan</th>
                        <th>Unit Kerja</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, i) in asn.data" :key="row.id">
                        <td>{{ asn.from + i }}</td>
                        <td>{{ row.nama }}</td>
                        <td>{{ row.nipBaru }}</td>
                        <td>{{ row.golRuangAkhir }}</td>
                        <td>{{ row.jabatanNama }}</td>
                        <td>{{ row.unorNama }}</td>
                        <td>
                            <Link :href="route('siasn.asn.show', row.id)">
                                <div class="tooltip" data-tip="Lihat detil">
                                    <DocumentMagnifyingGlassIcon
                                        class="w-5 text-primary"
                                    />
                                </div>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4 flex justify-between">
                <ShowingResultTable
                    :from="asn.from"
                    :to="asn.to"
                    :total="asn.total"
                />

                <Pagination :links="asn.links" v-model="" />
            </div>
        </div>
    </MainCard>
</template>
