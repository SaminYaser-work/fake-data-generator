/** @format */

import { defineConfig } from "npm:vite";

export default defineConfig({
    esbuild: {
        loader: "ts",
        target: "esnext",
    },
    resolve: {
        extensions: [".ts", ".tsx"],
        // alias: {
        //     "@": path.resolve(__dirname, "js"), // Optional: Set up alias for src
        // },
    },
    build: {
        outDir: "build",
        emptyOutDir: true, // Clears the dist folder before building
        rollupOptions: {
            input: "src/index.ts",
            output: {
                entryFileNames: "[name].js", // Output filename format for JS
            },
        },
    },
});
