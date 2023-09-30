export function useLocaleDateTime(date: Date): string {
    return date.toLocaleString("id", {
        timeZone: "Asia/Jakarta",
        timeStyle: "long",
        dateStyle: "medium",
    });
}

export function useLocaleDate(date: Date): string {
    return date.toLocaleDateString("id", {
        day: "numeric",
        month: "short",
        year: "numeric",
    });
}
