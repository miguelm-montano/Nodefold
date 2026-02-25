export function folderCreator() {
    return {
        open: false,
        name: "",
        error: "",

        openForm() {
            this.open = true;
            this.$nextTick(() => this.$refs.input.focus());
        },

        closeForm() {
            this.open = false;
            this.name = "";
            this.error = "";
        },

        async createFolder() {
            if (!this.name.trim()) {
                this.error = "Folder name is required";
                return;
            }
            try {
                const response = await fetch(`/folders`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({ name: this.name }),
                });

                if (!response.ok) {
                    const data = await response.json();
                    this.error =
                        data.errors?.name?.[0] ?? "Something went wrong";
                    return;
                }

                window.location.reload();
            } catch (e) {
                console.error(e);
            }
        },
    };
}
