import { defineStore } from "pinia";
import {
    BriefcaseIcon,
    ClipboardIcon,
    HomeIcon,
    UsersIcon,
    MapPinIcon,
    UserIcon,
    Square3Stack3DIcon,
} from "@heroicons/vue/24/outline/index.js";

const useRouteStore = defineStore("route-store", () => {
    const list = [
        {
            icon: HomeIcon,
            label: "Dashboard",
            href: route("dashboard"),
            name: "dashboard",
        },
        {
            icon: BriefcaseIcon,
            label: "Unit Kerja",
            href: "/",
            name: "work-unit.*",
            children: [
                {
                    icon: ClipboardIcon,
                    label: "Test",
                    href: "#",
                },
            ],
        },
        {
            icon: UsersIcon,
            label: "Pegawai",
            href: "/",
            name: "work-unit.*",
            children: [
                {
                    icon: MapPinIcon,
                    label: "Alamat Pegawai",
                    href: route("alamat.index"),
                },
                {
                    icon: UserIcon,
                    label: "Data Pegawai",
                    href: route("profil_pegawai.index"),
                },
                {
                    icon: Square3Stack3DIcon,
                    label: "Riwayat Jabatan Pegawai",
                    href: route("riwayat_jabatan_pegawai.index"),
                },
            ],
        },
    ];

    const isHasAccess = (item) => {
        if (!item.hasOwnProperty("showIf")) {
            return true;
        }

        return item.showIf();
    };

    return { list, isHasAccess };
});

export default useRouteStore;
