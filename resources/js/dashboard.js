export function dashboardData() {
    return {
        // STATE
        selectedResource: null,
        showDeleteModal: false,
        deleteTarget: null,
        selectedFolder: null,
        editing: false,
        editResource: {},
        errors: {},
        search: "",
        resources: [],

        get filteredResources() {
            if (!this.search.trim()) return this.resources;
            const term = this.search.toLowerCase();
            return this.resources.filter(
                (r) =>
                    r.title.toLowerCase().includes(term) ||
                    r.tags.some((t) => t.toLowerCase().includes(term)),
            );
        },

        openDeleteModal(type, id) {
            this.deleteTarget = { type, id };
            this.showDeleteModal = true;
        },

        startEditing() {
            if (!this.selectedResource) return;
            this.editing = true;
            this.editResource = {
                ...this.selectedResource,
                tags: this.selectedResource?.tags?.join(", ") ?? "",
            };
        },

        cancelEditing() {
            this.editing = false;
            this.editResource = {};
        },

        async saveResource() {
            if (!this.editResource?.id) return;
            try {
                const payload = {
                    title: this.editResource.title,
                    type: this.editResource.type,
                    description: this.editResource.description || null,
                    url: this.editResource.url || null,
                    folder_id: this.editResource.folder_id || null,
                    tags: this.editResource.tags || "",
                };

                const response = await fetch(
                    `/resources/${this.editResource.id}`,
                    {
                        method: "PATCH",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]',
                            ).content,
                            Accept: "application/json",
                        },
                        credentials: "same-origin",
                        body: JSON.stringify(payload),
                    },
                );

                if (!response.ok) {
                    const errorData = await response.json();
                    if (errorData.errors) this.errors = errorData.errors;
                    return;
                }

                const updated = await response.json();
                this.selectedResource.title = updated.title;
                this.selectedResource.description = updated.description;
                this.selectedResource.url = updated.url;
                this.selectedResource.folder = updated.folder?.name ?? null;
                this.selectedResource.folder_id = updated.folder_id;
                this.selectedResource.tags = updated.tags.map((t) => t.name);
                this.editing = false;
            } catch (error) {
                console.error("Save error:", error);
            }
        },
    };
}
