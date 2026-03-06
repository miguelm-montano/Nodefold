import "./bootstrap";
import Alpine from "alpinejs";
import Masonry from "masonry-layout";
import imagesLoaded from "imagesloaded";

import { dashboardData } from "./dashboard";
import { folderCreator } from "./folder-creator";

window.Alpine = Alpine;
window.dashboardData = dashboardData;
window.folderCreator = folderCreator;
window.Masonry = Masonry;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    const grid = document.querySelector("#grid-masonry");
    if (!grid) return;

    const msnry = new Masonry(grid, {
        itemSelector: ".grid-item",
        columnWidth: ".grid-item",
        percentPosition: true,
        gutter: 16,
    });

    imagesLoaded(grid, function () {
        msnry.layout();
    });

    const observer = new MutationObserver(() => {
        imagesLoaded(grid, function () {
            msnry.layout();
        });
    });

    observer.observe(grid, {
        attributes: true,
        subtree: true,
        attributeFilter: ["style"],
    });
});
