<script setup>
import MainCard from "@/Components/MainCard.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm, router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import Swal from "sweetalert2";

const props = defineProps({
    permission: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    id: props.permission.id,
    name: props.permission.name,
    guard_name: props.permission.guard_name,
});

const goBack = () => {
    window.history.back();
};

const submit = () => {
    form.put(route("permission.update", props.permission.id));
};
</script>

<template>
    <MainCard>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Gaji
        </h2>
        <div class="py-12">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-white p-6">
                        <form @submit.prevent="submit">
                            <div>
                                <div>
                                    <InputLabel
                                        for="guard_name"
                                        value="Pilih Jenis Hak Akses :"
                                    />

                                    <select
                                        v-model="form.guard_name"
                                        id="guard_name"
                                        name="guard_name"
                                        required
                                    >
                                        <option value="" disabled selected>
                                            Pilih Jenis Hak Akses
                                        </option>
                                        <option
                                            value="web"
                                            v-if="form.guard_name === 'web'"
                                        >
                                            Akses Web
                                        </option>
                                        <option
                                            value="api"
                                            v-if="form.guard_name === 'api'"
                                        >
                                            Akses API
                                        </option>
                                    </select>

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.guard_name"
                                    />
                                </div>

                                <div class="my-6">
                                    <InputLabel
                                        for="name"
                                        value="Nama Hak Akses :"
                                    />

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
                                        :value="form.name || old('name')"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.name"
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
                                        :class="{
                                            'form.processing': isProcessing,
                                        }"
                                    >
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MainCard>
</template>
