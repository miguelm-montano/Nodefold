import "./bootstrap";
import Alpine from "alpinejs";
import Masonry from "masonry-layout";

import { dashboardData } from "./dashboard";
import { folderCreator } from "./folder-creator";

window.Alpine = Alpine;
window.dashboardData = dashboardData;
window.folderCreator = folderCreator;
window.Masonry = Masonry;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    const grid = document.querySelector("#grid-masonry");
    if (grid) {
        const msnry = new Masonry(grid, {
            itemSelector: ".grid-item",
            columnWidth: ".grid-item",
            percentPosition: true,
            gutter: 16,
        });

        const observer = new MutationObserver(() => msnry.layout());
        observer.observe(grid, {
            attributes: true,
            subtree: true,
            attributeFilter: ["style"],
        });
    }
});
