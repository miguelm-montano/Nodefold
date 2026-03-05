import "./bootstrap";
import Masonry from "masonry-layout";
import imagesLoaded from "imagesloaded";
import { dashboardData } from "./dashboard";
import { folderCreator } from "./folder-creator";

window.dashboardData = dashboardData;
window.folderCreator = folderCreator;
window.Masonry = Masonry;

let msnryInstance = null;
let observerInstance = null;

function initMasonry() {
    const grid = document.querySelector("#grid-masonry");
    if (!grid) return;

    if (observerInstance) observerInstance.disconnect();
    if (msnryInstance) msnryInstance.destroy();

    msnryInstance = new Masonry(grid, {
        itemSelector: ".grid-item",
        columnWidth: ".grid-item",
        percentPosition: true,
        gutter: 16,
    });
    window.msnryInstance = msnryInstance;

    imagesLoaded(grid, () => msnryInstance.layout());

    observerInstance = new MutationObserver(() => {
        msnryInstance?.layout();
    });

    observerInstance.observe(grid, {
        attributes: true,
        subtree: true,
        attributeFilter: ["style"],
    });
}

document.addEventListener("DOMContentLoaded", () => initMasonry());
document.addEventListener("livewire:navigated", () =>
    setTimeout(() => initMasonry(), 100),
);
document.addEventListener("livewire:navigate", () =>
    setTimeout(() => initMasonry(), 100),
);

document.addEventListener("livewire:initialized", () => {
    Livewire.hook("commit", ({ component, succeed }) => {
        if (component.name !== "resource-grid") return;
        succeed(() => {
            requestAnimationFrame(() => initMasonry());
        });
    });
});
