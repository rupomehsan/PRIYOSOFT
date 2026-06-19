<template>
  <header class="ps-header" :class="{ scrolled, 'menu-open': menuOpen }">
    <div class="container ps-nav">

      <!-- Brand -->
      <a href="/" class="ps-brand">
        <img v-if="logoUrl" :src="logoUrl" :alt="siteName" class="ps-brand-logo-img"
             fetchpriority="high" loading="eager" />
        <template v-else>
          <span class="ps-brand-icon">{{ siteName.charAt(0) }}</span>
          <span class="ps-brand-name">{{ siteName }}</span>
        </template>
      </a>

      <!-- Desktop nav -->
      <nav class="ps-links" aria-label="Main navigation">
        <a v-for="l in links" :key="l.id" :href="l.href"
           class="ps-link" @click.prevent="goto(l.href)">{{ l.label }}</a>
      </nav>

      <!-- Right actions -->
      <div class="ps-actions">

        <!-- Authenticated user dropdown -->
     

     
        <!-- Theme toggle -->
        <button class="ps-theme-toggle" @click="toggle_theme"
                :title="is_dark ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
          <i :class="is_dark ? 'fas fa-sun' : 'fas fa-moon'"></i>
        </button>

        <!-- Hamburger button -->
        <button class="ps-hamburger" :class="{ open: menuOpen }"
                @click="menuOpen = !menuOpen" aria-label="Toggle navigation">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>

    <!-- Mobile drawer -->
    <div class="ps-mobile" :class="{ open: menuOpen }">
      <div class="container">
        <a v-for="l in links" :key="l.id" :href="l.href" class="ps-mobile-link"
           @click.prevent="goto(l.href); menuOpen = false">{{ l.label }}</a>
        <a href="#newsletter" class="ps-mobile-cta"
           @click.prevent="goto('#newsletter'); menuOpen = false">Get In Touch</a>
      </div>
    </div>
  </header>
</template>

<script>
import { mapActions, mapState } from 'pinia';
import { auth_store } from '../GlobalStore/auth_store';
import { theme_store } from '../GlobalStore/theme_store';
import { site_settings_store } from '../GlobalStore/site_settings_store';

export default {
  name: 'PsHeader',
  data: () => ({
    scrolled: false,
    menuOpen: false,
    showDropdown: false,
    links: [
      { id: 'home',         href: '#',               label: 'Home' },
      { id: 'products',     href: '#products',       label: 'Products' },
      { id: 'about',        href: '#about',          label: 'About Us' },
      { id: 'objectives',   href: '#objectives',     label: 'Objectives' },
      { id: 'testimonials', href: '#testimonials',   label: 'Testimonials' },
      { id: 'blog',         href: '#blog',           label: 'Blog' },
      { id: 'faq',          href: '#faq',            label: 'FAQ' },
    ],
  }),
  computed: {
    ...mapState(auth_store, { auth_info: 'auth_info', is_auth: 'is_auth' }),
    ...mapState(theme_store, { is_dark: 'dark' }),
    ...mapState(site_settings_store, { website_settings_data: 'website_settings_data' }),

    siteName() {
      const s = this.website_settings_data?.find?.(i => i.title === 'site_name');
      return s?.setting_values?.[0]?.value || 'PriyoSoft';
    },
    logoUrl() {
      const s = this.website_settings_data?.find?.(i => i.title === 'header_logo');
      const val = s?.setting_values?.[0]?.value;
      return val && val !== 'avatar.png' ? '/' + val : null;
    },
  },
  methods: {
    ...mapActions(auth_store, { check_is_auth: 'check_is_auth', log_out: 'log_out' }),
    ...mapActions(theme_store, { toggle_theme: 'toggle' }),
    ...mapActions(site_settings_store, { get_all_website_settings: 'get_all_website_settings' }),

    goto(href) {
      this.menuOpen = false;
      if (href === '#') {
        if (window.location.pathname !== '/') { window.location.href = '/'; return; }
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
      }
      const el = document.querySelector(href);
      if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
      } else {
        window.location.href = '/' + href;
      }
    },

    toggleDropdown() { this.showDropdown = !this.showDropdown; },
    closeDropdown()  { this.showDropdown = false; },
    handleLogout()   { this.closeDropdown(); this.log_out(); },

    onScroll() { this.scrolled = true; },

    onClickOutside(e) {
      if (!this.showDropdown) return;
      const wrap = this.$refs.userWrap;
      if (wrap && !wrap.contains(e.target)) this.showDropdown = false;
    },
  },
  async mounted() {
    window.addEventListener('scroll', this.onScroll, { passive: true });
    document.addEventListener('click', this.onClickOutside);
    this.scrolled = true;
    this.get_all_website_settings();
    const token = localStorage.getItem('auth_token');
    if (token) { try { await this.check_is_auth(); } catch (_) {} }
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.onScroll);
    document.removeEventListener('click', this.onClickOutside);
  },
};
</script>

<style scoped>
/* ── Shell ─────────────────────────────────────── */
.ps-header {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 1000;
  transition: background .3s ease, box-shadow .3s ease, backdrop-filter .3s ease;
}
.ps-header.scrolled,
.ps-header.menu-open {
  background: var(--ps-header-scrolled-bg);
  backdrop-filter: blur(18px);
  -webkit-backdrop-filter: blur(18px);
  box-shadow: var(--ps-header-scrolled-shadow);
}

/* ── Nav row ───────────────────────────────────── */
.ps-nav {
  display: flex;
  align-items: center;
  height: 72px;
  gap: 1.5rem;
}

/* ── Brand ─────────────────────────────────────── */
.ps-brand {
  display: flex;
  align-items: center;
  gap: .55rem;
  text-decoration: none;
  flex-shrink: 0;
}
.ps-brand-logo-img {
  height: 42px;
  width: auto;
  max-width: 180px;
  object-fit: contain;
  display: block;
}
.ps-brand-icon {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-weight: 900;
  font-size: 1.2rem;
  font-style: normal;
}
.ps-brand-name {
  font-size: 1.25rem;
  font-weight: 800;
  color: #fff;
  font-style: normal;
  transition: color .3s;
}
.ps-brand-name em {
  font-style: normal;
  color: #c4b5fd;
  transition: color .3s;
}
.ps-header.scrolled .ps-brand-name    { color: var(--ps-header-brand-scrolled); }
.ps-header.scrolled .ps-brand-name em { color: var(--ps-header-brand-em-scrolled); }

/* ── Desktop links ─────────────────────────────── */
.ps-links {
  display: flex;
  align-items: center;
  gap: .1rem;
  margin-left: auto;
}
.ps-link {
  color: rgba(255, 255, 255, .82);
  font-weight: 600;
  font-size: .88rem;
  text-decoration: none;
  padding: .42rem 1rem;
  border-radius: 8px;
  transition: color .2s, background .2s;
}
.ps-link:hover { color: #fff; background: rgba(255,255,255,.12); }
.ps-header.scrolled .ps-link       { color: var(--ps-header-link-scrolled); }
.ps-header.scrolled .ps-link:hover { color: var(--ps-header-link-hover-scrolled); background: var(--ps-header-link-hover-bg); }

/* ── Actions ───────────────────────────────────── */
.ps-actions {
  display: flex;
  align-items: center;
  gap: .85rem;
}

/* CTA button */
.ps-cta {
  display: inline-flex;
  align-items: center;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff !important;
  font-weight: 700;
  font-size: .85rem;
  text-decoration: none;
  padding: .5rem 1.4rem;
  border-radius: 50px;
  white-space: nowrap;
  transition: transform .2s, box-shadow .2s;
}
.ps-cta:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 22px rgba(102,126,234,.45);
}

/* Theme toggle */
.ps-theme-toggle {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: .9rem;
  background: var(--ps-toggle-bg);
  color: var(--ps-toggle-color);
  transition: background .2s, color .2s, transform .2s;
  flex-shrink: 0;
}
.ps-theme-toggle:hover {
  background: var(--ps-toggle-hover);
  transform: rotate(20deg);
}

/* Hamburger */
.ps-hamburger {
  display: none;
  flex-direction: column;
  justify-content: center;
  gap: 5px;
  width: 30px;
  height: 30px;
  padding: 0;
  background: none;
  border: none;
  cursor: pointer;
}
.ps-hamburger span {
  display: block;
  height: 2px;
  width: 100%;
  border-radius: 2px;
  background: #fff;
  transition: transform .3s ease, opacity .3s ease;
}
.ps-header.scrolled .ps-hamburger span,
.ps-header.menu-open .ps-hamburger span { background: var(--ps-header-hamburger-scrolled); }
.ps-hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
.ps-hamburger.open span:nth-child(2) { opacity: 0; }
.ps-hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

/* ── User dropdown ─────────────────────────────── */
.ps-user-wrap { position: relative; }
.ps-user-btn {
  display: flex;
  align-items: center;
  gap: .5rem;
  padding: .35rem .85rem .35rem .4rem;
  background: rgba(255,255,255,.12);
  border: 1px solid rgba(255,255,255,.22);
  border-radius: 50px;
  cursor: pointer;
  transition: background .2s, border-color .2s;
}
.ps-header.scrolled .ps-user-btn {
  background: var(--ps-header-user-btn-bg);
  border-color: var(--ps-header-user-btn-border);
}
.ps-user-btn:hover { background: rgba(255,255,255,.2); }
.ps-header.scrolled .ps-user-btn:hover { background: var(--ps-header-user-btn-bg); filter: brightness(1.15); }

.ps-user-avatar {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  object-fit: cover;
}
.ps-user-name {
  font-weight: 600;
  font-size: .85rem;
  color: #fff;
  max-width: 110px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.ps-header.scrolled .ps-user-name { color: var(--ps-header-user-name-scrolled); }

.ps-chevron {
  font-size: .68rem;
  color: rgba(255,255,255,.7);
  transition: transform .25s;
}
.ps-header.scrolled .ps-chevron { color: var(--ps-header-chevron-scrolled); }
.ps-chevron.rotated { transform: rotate(180deg); }

/* Dropdown panel */
.ps-drop {
  position: absolute;
  top: calc(100% + 10px);
  right: 0;
  width: 260px;
  background: var(--ps-drop-bg);
  border-radius: 14px;
  box-shadow: 0 12px 40px rgba(0,0,0,.22);
  border: 1px solid var(--ps-card-border);
  overflow: hidden;
  opacity: 0;
  pointer-events: none;
  transform: translateY(-8px);
  transition: opacity .2s, transform .2s;
  z-index: 200;
}
.ps-drop.show {
  opacity: 1;
  pointer-events: auto;
  transform: translateY(0);
}
.ps-drop-head {
  display: flex;
  align-items: center;
  gap: .75rem;
  padding: 1.1rem 1.25rem;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff;
}
.ps-drop-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid rgba(255,255,255,.35);
}
.ps-drop-name  { font-weight: 700; font-size: .95rem; }
.ps-drop-email { font-size: .78rem; opacity: .85; }

.ps-drop-item {
  display: flex;
  align-items: center;
  gap: .65rem;
  padding: .75rem 1.25rem;
  font-size: .875rem;
  font-weight: 500;
  color: var(--ps-drop-item-color);
  text-decoration: none;
  transition: background .15s;
}
.ps-drop-item:hover   { background: var(--ps-drop-item-hover-bg); color: var(--ps-drop-item-hover-color); }
.ps-drop-danger       { color: #ef4444; }
.ps-drop-danger:hover { background: var(--ps-drop-danger-hover-bg); color: #dc2626; }

/* ── Mobile drawer ─────────────────────────────── */
.ps-mobile {
  display: none;
  flex-direction: column;
  background: var(--ps-header-mobile-bg);
  border-top: 1px solid var(--ps-header-mobile-border);
  max-height: 0;
  overflow: hidden;
  transition: max-height .35s cubic-bezier(.4,0,.2,1);
}
.ps-mobile.open { max-height: 520px; }
.ps-mobile .container { padding-top: .5rem; padding-bottom: 1.25rem; }

.ps-mobile-link {
  display: block;
  padding: .78rem 0;
  font-weight: 600;
  font-size: .95rem;
  color: var(--ps-header-mobile-link);
  text-decoration: none;
  border-bottom: 1px solid var(--ps-header-mobile-border);
}
.ps-mobile-link:hover { color: #818cf8; }

.ps-mobile-cta {
  display: block;
  margin-top: 1rem;
  padding: .75rem;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff !important;
  border-radius: 50px;
  font-weight: 700;
  text-align: center;
  text-decoration: none;
}

/* ── Responsive ────────────────────────────────── */
@media (max-width: 991px) {
  .ps-links     { display: none; }
  .ps-hamburger { display: flex; }
  .ps-mobile    { display: flex; }
}
@media (max-width: 575px) {
  .ps-user-name { display: none; }
}
</style>
