<script setup>
import MainCard from "@/Components/MainCard.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm, router, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import Swal from "sweetalert2";

const page = usePage();
const user = computed(() => page.props.auth.user);

defineProps(['permissions']);

const checkAll = ref(false);
// const permissions = ref([
//   // Your list of permissions here
// ]);

const form = ref({
    name: "",
    guard_name: "-",
    hak_akses: [] // This will hold the selected permissions
});

const onChange = () => {
  // Handle checkbox change if needed
};

const checkAllPermissions = () => {
  if (checkAll.value) {
    form.hak_akses = true;
  } else {
    form.hak_akses = [];
  }
};

const goBack = () => {
    window.history.back();
};

const submit = () => {
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Simpan Role Baru?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya",
    }).then((result) => {
        if (result.isConfirmed) {
            form.post(route("permission.store"), {
                onSuccess: (response) => {
                    Swal.fire(
                        "Tersimpan!",
                        "Role baru berhasil disimpan.",
                        "success",
                    );
                    // form.reset(); // ini untuk reset inputan tanpa merefresh halaman atau tanpa balik ke index
                    router.get(route("permission.index"));
                },
                onError: (errors) => {
                    if (errors.query) {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Simpan Role gagal",
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                },
            });
        }
    });
};
</script>

<template>
    <MainCard>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah Role Baru
                {{ userAkses.gaji_list }}
            </h2>
        </template>

        {{ permissions.length }}

        <div class="py-12">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-white p-6">
                        <form @submit.prevent="submit">
                            <div class="my-6">
                                <InputLabel for="name" value="Nama Role :" />

                                <TextInput
                                    id="name"
                                    name="name"
                                    type="text"
                                    maxlength="50"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete=""
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>

                            <div>
                                <label>
                                    <input type="checkbox" v-model="checkAll" @change="checkAllPermissions" />
                                    Check All
                                </label>
                            </div>

                            <div>
                                <InputLabel
                                    for="hak_akses"
                                    value="Hak Akses :"
                                />
                                <div>
                                    <checkbox
                                    >
                                    </checkbox>
                                    Check All
                                </div>

                                <div v-for="data in permissions" :key="data.id">
                                    <checkbox
                                        v-model="form.hak_akses"
                                        :value="data.id"
                                        class="flex-column gap-2"
                                        @change="onChange"
                                    >
                                    </checkbox>
                                    {{ data.name }}
                                </div>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.hak_akses"
                                />
                            </div>

                            <div class="flex justify-end">
                                <button
                                    class="btn btn-error mx-2"
                                    @click="goBack"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="btn btn-primary mx-2"
                                    :class="{ 'form.processing': isProcessing }"
                                >
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MainCard>
</template>
