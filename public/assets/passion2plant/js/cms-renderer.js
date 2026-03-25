document.addEventListener("DOMContentLoaded", function () {
    const containers = document.querySelectorAll(".cms-html");

    containers.forEach((container) => {
        const styledNodes = container.querySelectorAll("[style]");

        styledNodes.forEach((node) => {
            const style = node.getAttribute("style");
            if (!style) return;

            const colorMatch = style.match(/color\s*:\s*([^;]+)/i);
            const sizeMatch = style.match(/font-size\s*:\s*([^;]+)/i);
            const fontMatch = style.match(/font-family\s*:\s*([^;]+)/i);
            const alignMatch = style.match(/text-align\s*:\s*([^;]+)/i);

            if (colorMatch) {
                const color = colorMatch[1].trim();

                node.style.setProperty("color", color, "important");
                node.style.setProperty(
                    "-webkit-text-fill-color",
                    color,
                    "important",
                );
            }

            if (sizeMatch) {
                const size = sizeMatch[1].trim();

                node.style.setProperty("font-size", size, "important");
            }

            if (fontMatch) {
                const font = fontMatch[1].trim();

                node.style.setProperty("font-family", font, "important");
            }

            if (alignMatch) {
                const align = alignMatch[1].trim();

                node.style.setProperty("text-align", align, "important");
            }
        });
    });
});
