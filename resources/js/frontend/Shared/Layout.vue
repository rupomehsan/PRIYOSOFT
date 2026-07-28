<template>
  <div id="app">
    <Header />
    <main class="main-wrapper">
      <slot />
    </main>
    <Footer />

    <!-- Fixed floating actions ── always over the app, bottom-right -->
    <div class="ps-float-actions">
      <a v-if="whatsapp" :href="'https://wa.me/' + whatsapp" target="_blank" rel="noopener"
         aria-label="Chat on WhatsApp" class="ps-float-btn ps-float-whatsapp">
        <i class="fab fa-whatsapp"></i>
      </a>
      <button v-if="showScrollTop" class="ps-float-btn ps-float-scrolltop"
              @click="scrollToTop" aria-label="Scroll to top">
        <i class="fas fa-arrow-up"></i>
      </button>
    </div>
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
  data: () => ({
    showScrollTop: false,
  }),
  computed: {
    ...mapState(site_settings_store, { _settings: 'website_settings_data' }),
    faviconUrl() {
      const val = this._settings?.find?.(i => i.title === 'fabicon')?.setting_values?.[0]?.value;
      return val && val !== 'default.png' ? '/' + val : null;
    },
    whatsapp() {
      return this._settings?.find?.(i => i.title === 'whatsapp')?.setting_values?.[0]?.value || '';
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
    onScroll() {
      this.showScrollTop = window.scrollY > 400;
    },
    scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    },
  },
  async mounted() {
    theme_store().init();
    await this.get_all_website_settings();
    if (this.faviconUrl) this._applyFavicon(this.faviconUrl);
    window.addEventListener('scroll', this.onScroll, { passive: true });
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.onScroll);
  },
};
</script>

<style>
body {
  /* Bootstrap's gutter classes (g-5, etc.) put negative margins on .row
     which, on narrow/mobile widths, can push slightly past the container
     edge. Rather than chase every occurrence, clip it site-wide — nothing
     on this site intentionally needs horizontal page scroll.
     IMPORTANT: this must stay on <body>, not <html>. Setting overflow-x
     on the root <html> element breaks its content-based height entirely
     (it collapses to the viewport height), which silently kills ALL page
     scrolling — that was the cause of "Home" (and everything else) not
     scrolling. Body-only relies on the standard html/body overflow
     propagation to the viewport and doesn't have that problem.
     Use `clip`, not `hidden`: any non-visible overflow value (hidden/
     auto/scroll) turns body into a scroll container, which breaks
     `position: sticky` for every descendant on the site (e.g. the
     product page's sticky sidebar) since sticky then resolves against
     body instead of the viewport. `clip` visually clips the same way
     without creating that scroll container. */
  overflow-x: clip;
  max-width: 100%;
}
html {
  scroll-behavior: smooth;
  scroll-padding-top: 72px;
}

.ps-float-actions {
  position: fixed;
  right: 1.5rem;
  bottom: 1.5rem;
  z-index: 2000;
  display: flex;
  flex-direction: column;
  gap: .75rem;
}
.ps-float-btn {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.15rem;
  color: #fff;
  border: none;
  cursor: pointer;
  text-decoration: none;
  box-shadow: 0 8px 24px rgba(0,0,0,.25);
  transition: transform .2s ease, box-shadow .2s ease;
}
.ps-float-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(0,0,0,.32);
  color: #fff;
}
.ps-float-whatsapp { background: #25d366; }
.ps-float-scrolltop { background: linear-gradient(135deg, #667eea, #764ba2); }

@media (max-width: 575px) {
  .ps-float-actions { right: 1rem; bottom: 1rem; }
  .ps-float-btn { width: 44px; height: 44px; font-size: 1.05rem; }
}
</style>
