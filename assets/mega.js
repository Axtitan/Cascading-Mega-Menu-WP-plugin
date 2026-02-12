/**
 * Cascading Mega Menu – front-end interaction
 *
 * Hover an item in any column → its children appear in the next column.
 * Works for unlimited nesting depth.
 * Compatible with Elementor editor (re-initializes on widget re-render).
 */
(function () {

    function initCascadingMenu(root) {
        /* Prevent double-init on the same DOM node */
        if (root._cmmInit) return;
        root._cmmInit = true;

        var cols = Array.from(root.querySelectorAll(".cmm-col"));

        /* ── Update which columns are visible ── */
        function updateColumnVisibility() {
            cols.forEach(function (c) {
                var d = parseInt(c.dataset.depth, 10);
                if (d === 0) {
                    c.classList.add("cmm-col-visible");
                } else if (c.querySelector(".cmm-group.is-visible")) {
                    c.classList.add("cmm-col-visible");
                } else {
                    c.classList.remove("cmm-col-visible");
                }
            });
        }

        /* ── Activate an item on hover ── */
        function activateItem(item) {
            var itemId = item.dataset.id;
            var col    = item.closest(".cmm-col");
            var depth  = parseInt(col.dataset.depth, 10);

            // 1. Deactivate siblings
            col.querySelectorAll(".cmm-item.is-active").forEach(function (el) {
                el.classList.remove("is-active");
            });
            item.classList.add("is-active");

            // 2. Clear all deeper columns
            cols.forEach(function (c) {
                var d = parseInt(c.dataset.depth, 10);
                if (d > depth) {
                    c.querySelectorAll(".cmm-group.is-visible").forEach(function (g) {
                        g.classList.remove("is-visible");
                    });
                    c.querySelectorAll(".cmm-item.is-active").forEach(function (el) {
                        el.classList.remove("is-active");
                    });
                }
            });

            // 3. Show matching group in next column
            var nextCol = root.querySelector('.cmm-col[data-depth="' + (depth + 1) + '"]');
            if (nextCol) {
                var targetGroup = nextCol.querySelector('.cmm-group[data-parent="' + itemId + '"]');
                if (targetGroup) {
                    targetGroup.classList.add("is-visible");

                    var firstChild = targetGroup.querySelector(".cmm-item");
                    if (firstChild) {
                        firstChild.classList.add("is-active");
                        cascadeFromItem(firstChild);
                    }
                }
            }

            // 4. Update column visibility
            updateColumnVisibility();
        }

        /* ── Cascade first-child chain (no clearing needed) ── */
        function cascadeFromItem(item) {
            var itemId = item.dataset.id;
            var col    = item.closest(".cmm-col");
            var depth  = parseInt(col.dataset.depth, 10);

            var nextCol = root.querySelector('.cmm-col[data-depth="' + (depth + 1) + '"]');
            if (!nextCol) return;

            var targetGroup = nextCol.querySelector('.cmm-group[data-parent="' + itemId + '"]');
            if (!targetGroup) return;

            targetGroup.classList.add("is-visible");

            var firstChild = targetGroup.querySelector(".cmm-item");
            if (firstChild) {
                firstChild.classList.add("is-active");
                cascadeFromItem(firstChild);
            }
        }

        /* ── Attach hover listeners ── */
        root.querySelectorAll(".cmm-item").forEach(function (item) {
            item.addEventListener("mouseenter", function () {
                activateItem(item);
            });
        });

        /* ── Ensure initial column visibility is correct ── */
        updateColumnVisibility();
    }

    /* ── Find and initialize all .cmm-root elements ── */
    function initAll() {
        document.querySelectorAll(".cmm-root").forEach(initCascadingMenu);
    }

    /* ── Standard page load ── */
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initAll);
    } else {
        initAll();
    }

    /* ── Elementor editor compatibility ──
       When Elementor re-renders a widget (settings change, drag, etc.),
       new DOM nodes replace the old ones. We use a MutationObserver to
       detect new .cmm-root elements and initialize them. The _cmmInit
       flag on each root prevents double-initialization. */
    var debounceTimer;
    function debouncedInit() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(initAll, 150);
    }

    if (typeof MutationObserver !== "undefined") {
        var startObserver = function () {
            var observer = new MutationObserver(debouncedInit);
            observer.observe(document.body, { childList: true, subtree: true });
        };

        if (document.body) {
            startObserver();
        } else {
            document.addEventListener("DOMContentLoaded", startObserver);
        }
    }

})();
