/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_WP_USERNAME: string
  readonly VITE_WP_PASSWORD: string
  readonly VITE_WP_BASE_URL: string
}

interface ImportMeta {
  readonly env: ImportMetaEnv
}
