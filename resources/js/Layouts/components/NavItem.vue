<script setup>
import useRouteStore from "@/Stores/RouteStore.js";

defineProps(["item"]);

const routes = useRouteStore();
</script>

<template>
    <li v-if="routes.isHasAccess(item) && item.children">
        <details :open="false">
            <summary>
                <component :is="item.icon" class="mr-2 w-6" />
                <span class="font-semibold">{{ item.label }}</span>
            </summary>
            <NavItem
                class="pl-4"
                v-for="row in item.children"
                :key="row.label"
                :item="row"
            />
        </details>
    </li>
    <li v-else-if="routes.isHasAccess(item)">
        <Link :href="item.href">
            <component :is="item.icon" class="mr-2 w-6" />
            <span class="font-semibold">{{ item.label }}</span>
        </Link>
    </li>
</template>
