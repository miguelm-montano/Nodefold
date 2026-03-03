import "./bootstrap";
import Masonry from "masonry-layout";
import imagesLoaded from "imagesloaded";
import { dashboardData } from "./dashboard";
import { folderCreator } from "./folder-creator";

// Livewire 3 ya incluye Alpine internamente.
// Registramos nuestras funciones en window para que Alpine las encuentre.
window.dashboardData = dashboardData;
window.folderCreator = folderCreator;
window.Masonry = Masonry;

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
