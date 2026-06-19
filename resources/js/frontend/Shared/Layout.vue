<template>
  <div id="app">
    <Header />
    <main class="main-wrapper">
      <slot />
    </main>
    <Footer />
  </div>
</template>

<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import { theme_store } from '../GlobalStore/theme_store';
import { mapState, mapActions } from 'pinia';
import { site_settings_store } from '../GlobalStore/site_settings_store';

export default {
  name: "Layout",
  components: { Header, Footer },
  computed: {
    ...mapState(site_settings_store, { _settings: 'website_settings_data' }),
    faviconUrl() {
      const val = this._settings?.find?.(i => i.title === 'fabicon')?.setting_values?.[0]?.value;
      return val && val !== 'default.png' ? '/' + val : null;
    },
  },
  watch: {
    faviconUrl(url) {
      if (url) this._applyFavicon(url);
    },
  },
  methods: {
    ...mapActions(site_settings_store, ['get_all_website_settings']),
    _applyFavicon(url) {
      let link = document.querySelector("link[rel='icon']") || document.querySelector("link[rel='shortcut icon']");
      if (!link) {
        link = document.createElement('link');
        link.rel = 'icon';
        document.head.appendChild(link);
      }
      link.type = 'image/png';
      link.href = url + '?_=' + Date.now();
    },
  },
  async mounted() {
    theme_store().init();
    await this.get_all_website_settings();
    if (this.faviconUrl) this._applyFavicon(this.faviconUrl);
  },
};
</script>

<style>
html {
  scroll-behavior: smooth;
  scroll-padding-top: 72px;
}
</style>
