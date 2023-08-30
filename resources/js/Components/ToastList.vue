<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { onUnmounted, ref } from "vue";
import ToastListItem from "@/Components/ToastListItem.vue";

const page = usePage();
const toast = ref([]);

const addToast = (value) => {
    toast.value.unshift({
        ...value,
        key: Symbol(),
    });
};

const removeToast = (key) => {
    toast.value = toast.value.filter((item) => item.key !== key);
    usePage().props.toast = null;
};

let removeFinishEventListener = router.on("finish", () => {
    if (page.props.toast) {
        addToast({ ...page.props.toast });
    }
});

onUnmounted(() => {
    removeFinishEventListener();
});
</script>

<template>
    <TransitionGroup
        class="toast toast-end toast-top"
        enter-active-class="duration-500"
        enter-from-class="translate-x-full opacity-0"
        leave-active-class="duration-500"
        leave-to-class="translate-x-full opacity-0"
        tag="div"
    >
        <ToastListItem
            v-for="item in toast"
            :key="item.key"
            :duration="2000"
            :type="item.type"
            :message="item.message"
            :on-dismiss="() => removeToast(item.key)"
        />
    </TransitionGroup>
</template>
