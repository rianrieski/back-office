<script setup>
import { Bars3Icon } from "@heroicons/vue/24/outline/index.js";
import useRouteStore from "@/Stores/RouteStore.js";
import Sidebar from "@/Layouts/components/Sidebar.vue";
import ToastList from "@/Components/ToastList.vue";

const routes = useRouteStore();
defineProps({
    title: "",
});
</script>

<template>
    <Head :title="title" />
    <div class="drawer min-h-screen">
        <ToastList />
        <Sidebar class="hidden lg:block" />
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar w-full border-b">
                <div class="flex-none lg:hidden">
                    <label for="my-drawer-3" class="btn btn-square btn-ghost">
                        <Bars3Icon class="w-8" />
                    </label>
                </div>
                <div class="mx-2 flex flex-1 justify-between px-2">
                    <div class="text-xl leading-tight tracking-wider">
                        BACKOFFICE
                    </div>
                    <!-- TODO: set proper class -->
                    <!--                    <ul class="menu menu-horizontal px-4">-->
                    <!-- Navbar menu content here -->
                    <!--                        <li><UserCircleIcon /></li>-->
                    <!--                    </ul>-->
                </div>
            </div>

            <!-- Page content here -->
            <div class="m-4">
                <slot />
            </div>
        </div>
        <div class="drawer-side lg:hidden">
            <label for="my-drawer-3" class="drawer-overlay"></label>
            <Sidebar />
        </div>
    </div>
</template>
