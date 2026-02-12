import "./bootstrap";
import "./notifications";
import "./form-handler";

// Auto-show flash messages dari Laravel
const showFlashMessages = () => {
    const messagesScript = document.querySelector("#flash-messages");

    if (messagesScript) {
        try {
            const data = JSON.parse(messagesScript.textContent);

            if (data.success && data.success !== null) {
                notify.success("Berhasil", data.success);
            } else if (data.error && data.error !== null) {
                notify.error("Error", data.error);
            } else if (data.warning && data.warning !== null) {
                notify.warning("Peringatan", data.warning);
            } else if (data.info && data.info !== null) {
                notify.info("Informasi", data.info);
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
