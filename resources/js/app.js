import "./bootstrap";
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

import Masonry from "masonry-layout";
window.Masonry = Masonry;

document.addEventListener("DOMContentLoaded", function () {
    const grid = document.querySelector("#grid-masonry");
    if (grid) {
        new Masonry(grid, {
            itemSelector: ".grid-item",
            columnWidth: ".grid-item",
            percentPosition: true,
            gutter: 16,
        });
    }
});
