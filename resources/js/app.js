import "./bootstrap";

// Auto-show flash messages dari Laravel
const showFlashMessages = () => {
    const messagesScript = document.querySelector("#flash-messages");

    if (messagesScript) {
        try {
            const data = JSON.parse(messagesScript.textContent);

            if (data.success && data.success !== null) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: data.success,
                    confirmButtonColor: "#10b981",
                    timer: 3000,
                    timerProgressBar: true,
                });
            } else if (data.error && data.error !== null) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.error,
                    confirmButtonColor: "#ef4444",
                });
            } else if (data.warning && data.warning !== null) {
                Swal.fire({
                    icon: "warning",
                    title: "Peringatan",
                    text: data.warning,
                    confirmButtonColor: "#f59e0b",
                });
            } else if (data.info && data.info !== null) {
                Swal.fire({
                    icon: "info",
                    title: "Informasi",
                    text: data.info,
                    confirmButtonColor: "#3b82f6",
                });
            }
        } catch (e) {
            console.error("Error parsing flash messages:", e);
        }
    }
};

// Jalankan saat DOM ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", showFlashMessages);
} else {
    showFlashMessages();
}
