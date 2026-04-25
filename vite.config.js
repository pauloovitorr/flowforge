import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/pages/select2.css",
                "resources/js/app.js",
                "resources/js/pages/project.js",
                "resources/js/pages/workflow.js",
                "resources/js/pages/workflow_action.js",
                "resources/js/pages/email-create.js",
                "resources/js/pages/email-index.js",
            ],
            refresh: true,
        }),
    ],
});
