import Swal, { SweetAlertIcon, SweetAlertResult } from "sweetalert2";

export async function useConfirm(params?: {
    title?: string;
    text?: string;
    confirmButtonText?: string;
}): Promise<boolean> {
    const { isConfirmed } = await Swal.fire({
        title: params?.title || "Konfirmasi",
        text: params?.text,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: params?.confirmButtonText || "OK",
        cancelButtonText: "Batal",
        buttonsStyling: false,
        focusConfirm: false,
        customClass: {
            title: "text-xl",
            popup: "max-w-sm text-sm rounded",
            cancelButton: "btn btn-error btn-outline btn-sm ml-2",
            confirmButton: "btn btn-primary btn-sm px-4",
        },
    });

    return isConfirmed;
}

export function useToast({
    text,
    icon,
}: {
    text: string;
    icon?: SweetAlertIcon;
}): Promise<SweetAlertResult> {
    let textClass: string = icon === "error" ? "text-error" : "";

    const popupClass: string = `${textClass} text-sm`;

    return Swal.fire({
        toast: true,
        text,
        icon,
        position: "top-end",
        timer: 2500,
        timerProgressBar: true,
        showCloseButton: true,
        showConfirmButton: false,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
        customClass: {
            popup: popupClass,
        },
    });
}
