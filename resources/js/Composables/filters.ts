export function useLocaleDateTime(date: Date): string {
    return date.toLocaleString("id", {
        timeZone: "Asia/Jakarta",
        timeStyle: "long",
        dateStyle: "medium",
    });
}
