# Frontend modernization

This branch starts a deliberately incremental migration from the unsupported
Webpack 3 / Laravel Mix 2 toolchain to Vite.

## What this change covers

- The three active Vue entry points use Vite and the Laravel Vite plugin.
- Vue is updated only to the final Vue 2.7 release in this phase. Vue 3 is a
  separate application migration because the current code uses Vue 2 global
  APIs, Vue Router 3, Vuex 3, BootstrapVue, and legacy jQuery plugins.
- `node-sass`, `sharp`, Gulp, Grunt, Browserify, Vueify, and the legacy
  Webpack test runner are removed from the install graph. Their old compiled
  output remains in `public/` until each corresponding screen is migrated.

## Required local verification

Use Node 22 and npm 10, then regenerate and commit `package-lock.json`:

```sh
rm -rf node_modules package-lock.json
npm install
npm run build
```

Exercise `/dev/setup`, the new grading screen, and public feedback in both
development and production builds before merging.

## Follow-up phases

1. Replace the old Mocha/Webpack test runner with Vitest.
2. Migrate Vue 2.7, Vue Router 3, Vuex 3, and BootstrapVue to Vue 3,
   Vue Router 4, Vuex 4/Pinia, and a maintained Bootstrap integration.
3. Migrate the remaining Gulp/Browserify-produced screens one entry point at
   a time, then remove their committed generated assets.
