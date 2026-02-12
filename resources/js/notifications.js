// Notification helper functions untuk SweetAlert2

export const notify = {
    // Notifikasi Success
    success: (title = "Berhasil", message = "") => {
        return Swal.fire({
            icon: "success",
            title: title,
            text: message,
            confirmButtonColor: "#10b981",
            confirmButtonText: "OK",
            timer: 3000,
            timerProgressBar: true,
        });
    },

    // Notifikasi Error
    error: (title = "Error", message = "") => {
        return Swal.fire({
            icon: "error",
            title: title,
            text: message,
            confirmButtonColor: "#ef4444",
            confirmButtonText: "OK",
        });
    },

    // Notifikasi Warning
    warning: (title = "Peringatan", message = "") => {
        return Swal.fire({
            icon: "warning",
            title: title,
            text: message,
            confirmButtonColor: "#f59e0b",
            confirmButtonText: "OK",
        });
    },

    // Notifikasi Info
    info: (title = "Informasi", message = "") => {
        return Swal.fire({
            icon: "info",
            title: title,
            text: message,
            confirmButtonColor: "#3b82f6",
            confirmButtonText: "OK",
        });
    },

    // Konfirmasi dengan Yes/No
    confirm: (title = "Konfirmasi", message = "") => {
        return Swal.fire({
            icon: "question",
            title: title,
            text: message,
            showCancelButton: true,
            confirmButtonColor: "#10b981",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
        });
    },

    // Loading/Processing
    loading: (title = "Memproses...", message = "Mohon tunggu") => {
        return Swal.fire({
            title: title,
            text: message,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    },

    // Close loading
    closeLoading: () => {
        Swal.close();
    },
};

// Export ke global window
window.notify = notify;
