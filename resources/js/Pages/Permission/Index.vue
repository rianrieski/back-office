<script setup>
import MainCard from "@/Components/MainCard.vue";
import { Head, Link, useForm, router, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
// const page = usePage()
// const userAkses = computed(() => page.props.auth.akses)

const props = defineProps({
    permissions: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({});
function destroy(id) {
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Hapus data Hak Akses",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya",
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route("permission.destroy", id), {
                onSuccess: (response) => {
                    Swal.fire(
                        "Berhasil!",
                        "Data Hak Akses berhasil dihapus.",
                        "success",
                    );
                    // form.reset(); // ini untuk reset inputan tanpa merefresh halaman atau tanpa balik ke index
                    router.get(route("permission.index"));
                },
                onError: (errors) => {
                    if (errors.query) {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Hapus Hak Akses gagal",
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                },
            });
        }
    });
}
</script>
<template>
    <MainCard>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Hak Akses
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto mb-5 max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div
                        class="items=center flex justify-between bg-gray-800 p-5"
                    >
                        <div class="flex items-center space-x-2 text-white">
                            Master Hak Akses
                        </div>
                        <div
                            class="flex items-center space-x-2"
                            v-if="can.create"
                        >
                            <Link :href="route('permission.create')">
                                <button
                                    class="flex items-center rounded bg-green-500 px-4 py-2 uppercase text-white focus:outline-none"

                                >
                                    <span
                                        class="iconify mr-1"
                                        data-icon="gridicons:create"
                                        data-inline="false"
                                    ></span>
                                    Tambah Hak Akses
                                </button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-auto mb-2 max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Hak Akses</th>
                                <th>Jenis Akses</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(permission, index) in permissions.data"
                                :key="permission.id"
                                class="hover"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ permission.name }}</td>
                                <td>{{ permission.guard_name }}</td>
                                <td
                                    v-if="can.edit || can.delete"
                                    class="px-6 py-4"
                                >
                                    <div
                                        type="justify-start lg:justify-end"
                                        no-wrap
                                    >
                                        <Link
                                            v-if="can.edit"
                                            :href="
                                                route(
                                                    'permission.edit',
                                                    permission.id,
                                                )
                                            "
                                        >
                                            <button
                                                class="ml-4 cursor-pointer rounded bg-green-500 px-2 py-1 text-white"
                                            >
                                                <span
                                                    class="iconify mr-1"
                                                    data-icon="gridicons:create"
                                                    data-inline="false"
                                                ></span>
                                                Ubah
                                            </button>
                                        </Link>

                                        <Link
                                            v-if="can.edit"
                                            :href="
                                                route(
                                                    'permission.destroy',
                                                    permission.id,
                                                )
                                            "
                                            @click="destroy(permission.id)"
                                        >
                                            <button
                                                class="ml-4 cursor-pointer rounded bg-red-500 px-2 py-1 text-white"
                                            >
                                                <span
                                                    class="iconify mr-1"
                                                    data-icon="gridicons:create"
                                                    data-inline="false"
                                                ></span>
                                                Hapus
                                            </button>
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </MainCard>
</template>
