// Helper untuk submit form dengan loading alert
export const submitFormWithLoading = (
    formElement,
    message = "Memproses...",
) => {
    formElement.addEventListener("submit", (e) => {
        // Jangan cancel default behavior, biarkan form submit
        notify.loading(message, "Mohon tunggu");
    });
};

// Submit button dengan loading
export const submitButtonWithLoading = (
    buttonElement,
    message = "Memproses...",
) => {
    buttonElement.addEventListener("click", (e) => {
        if (buttonElement.closest("form")) {
            notify.loading(message, "Mohon tunggu");
        }
    });
};

// Confirm delete dengan sweet alert
export const confirmDelete = (url, message = "Yakin ingin menghapus?") => {
    notify.confirm("Hapus Data?", message).then((result) => {
        if (result.isConfirmed) {
            // Buat form untuk submit DELETE
            const form = document.createElement("form");
            form.method = "POST";
            form.action = url;

            const csrf = document.querySelector('input[name="_token"]');
            if (csrf) {
                form.appendChild(csrf.cloneNode());
            }

            const methodInput = document.createElement("input");
            methodInput.type = "hidden";
            methodInput.name = "_method";
            methodInput.value = "DELETE";
            form.appendChild(methodInput);

            notify.loading("Menghapus...", "Mohon tunggu");
            document.body.appendChild(form);
            form.submit();
        }
    });
};

// Export ke window
window.submitFormWithLoading = submitFormWithLoading;
window.submitButtonWithLoading = submitButtonWithLoading;
window.confirmDelete = confirmDelete;
