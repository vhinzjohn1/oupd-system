import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { build } from "vite";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/js/app.js",
                "public/css/adminlte.min.css",
                "public/css/fontawesome.min.css",
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
        },
    },
});
