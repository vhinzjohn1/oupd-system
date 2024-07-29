// vite.config.js
import { defineConfig } from "file:///C:/Users/Vhinz/Documents/GitHub/oupd-system/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/Users/Vhinz/Documents/GitHub/oupd-system/node_modules/laravel-vite-plugin/dist/index.js";
import { build } from "file:///C:/Users/Vhinz/Documents/GitHub/oupd-system/node_modules/vite/dist/node/index.js";
import path from "path";
var __vite_injected_original_dirname = "C:\\Users\\Vhinz\\Documents\\GitHub\\oupd-system";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/sass/app.scss",
        "resources/js/app.js",
        "public/css/adminlte.min.css",
        "public/css/fontawesome.min.css"
      ],
      refresh: true
    })
  ],
  resolve: {
    alias: {
      "~bootstrap": path.resolve(__vite_injected_original_dirname, "node_modules/bootstrap")
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxVc2Vyc1xcXFxWaGluelxcXFxEb2N1bWVudHNcXFxcR2l0SHViXFxcXG91cGQtc3lzdGVtXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJDOlxcXFxVc2Vyc1xcXFxWaGluelxcXFxEb2N1bWVudHNcXFxcR2l0SHViXFxcXG91cGQtc3lzdGVtXFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9DOi9Vc2Vycy9WaGluei9Eb2N1bWVudHMvR2l0SHViL291cGQtc3lzdGVtL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSBcInZpdGVcIjtcbmltcG9ydCBsYXJhdmVsIGZyb20gXCJsYXJhdmVsLXZpdGUtcGx1Z2luXCI7XG5pbXBvcnQgeyBidWlsZCB9IGZyb20gXCJ2aXRlXCI7XG5pbXBvcnQgcGF0aCBmcm9tIFwicGF0aFwiO1xuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogW1xuICAgICAgICAgICAgICAgIFwicmVzb3VyY2VzL3Nhc3MvYXBwLnNjc3NcIixcbiAgICAgICAgICAgICAgICBcInJlc291cmNlcy9qcy9hcHAuanNcIixcbiAgICAgICAgICAgICAgICBcInB1YmxpYy9jc3MvYWRtaW5sdGUubWluLmNzc1wiLFxuICAgICAgICAgICAgICAgIFwicHVibGljL2Nzcy9mb250YXdlc29tZS5taW4uY3NzXCIsXG4gICAgICAgICAgICBdLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG4gICAgXSxcbiAgICByZXNvbHZlOiB7XG4gICAgICAgIGFsaWFzOiB7XG4gICAgICAgICAgICBcIn5ib290c3RyYXBcIjogcGF0aC5yZXNvbHZlKF9fZGlybmFtZSwgXCJub2RlX21vZHVsZXMvYm9vdHN0cmFwXCIpLFxuICAgICAgICB9LFxuICAgIH0sXG59KTtcbiJdLAogICJtYXBwaW5ncyI6ICI7QUFBK1QsU0FBUyxvQkFBb0I7QUFDNVYsT0FBTyxhQUFhO0FBQ3BCLFNBQVMsYUFBYTtBQUN0QixPQUFPLFVBQVU7QUFIakIsSUFBTSxtQ0FBbUM7QUFLekMsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsU0FBUztBQUFBLElBQ0wsUUFBUTtBQUFBLE1BQ0osT0FBTztBQUFBLFFBQ0g7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxNQUNKO0FBQUEsTUFDQSxTQUFTO0FBQUEsSUFDYixDQUFDO0FBQUEsRUFDTDtBQUFBLEVBQ0EsU0FBUztBQUFBLElBQ0wsT0FBTztBQUFBLE1BQ0gsY0FBYyxLQUFLLFFBQVEsa0NBQVcsd0JBQXdCO0FBQUEsSUFDbEU7QUFBQSxFQUNKO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
