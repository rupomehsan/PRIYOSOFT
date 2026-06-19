<template>
  <footer class="ps-footer">
    <div class="container">

      <!-- ── Top grid ── -->
      <div class="row g-5 ps-footer-top">

        <!-- Brand column -->
        <div class="col-lg-4 col-md-12">
          <div class="ps-footer-brand">
            <template v-if="footerLogoUrl">
              <img :src="footerLogoUrl" :alt="siteName" class="ps-footer-logo-img" />
            </template>
            <template v-else>
              <span class="ps-footer-icon">{{ siteName.charAt(0) }}</span>
              <span class="ps-footer-bname">{{ siteName.replace(/soft$/i, '') }}<em>Soft</em></span>
            </template>
          </div>
          <p class="ps-footer-desc">
            We craft modern, scalable web &amp; mobile software that empowers
            businesses to grow faster and smarter. From idea to launch — we build it.
          </p>
          <div class="ps-socials">
            <a v-if="social.linkedin" :href="social.linkedin" target="_blank" rel="noopener" aria-label="LinkedIn"  class="ps-social-link"><i class="fab fa-linkedin-in"></i></a>
            <a v-if="social.facebook" :href="social.facebook" target="_blank" rel="noopener" aria-label="Facebook"  class="ps-social-link"><i class="fab fa-facebook-f"></i></a>
            <a v-if="social.twitter"  :href="social.twitter"  target="_blank" rel="noopener" aria-label="Twitter"   class="ps-social-link"><i class="fab fa-twitter"></i></a>
            <a v-if="social.youtube"  :href="social.youtube"  target="_blank" rel="noopener" aria-label="YouTube"   class="ps-social-link"><i class="fab fa-youtube"></i></a>
            <a v-if="social.instagram" :href="social.instagram" target="_blank" rel="noopener" aria-label="Instagram" class="ps-social-link"><i class="fab fa-instagram"></i></a>
            <a v-if="social.github"   :href="social.github"   target="_blank" rel="noopener" aria-label="GitHub"    class="ps-social-link"><i class="fab fa-github"></i></a>
          </div>
        </div>

        <!-- Products column -->
        <div class="col-lg-2 col-sm-6 col-6">
          <h6 class="ps-footer-heading">Products</h6>
          <ul class="ps-footer-links">
            <li><a href="#products">Our Software</a></li>
            <li><a href="#products">SaaS Solutions</a></li>
            <li><a href="#products">Mobile Apps</a></li>
            <li><a href="#products">Open Source</a></li>
          </ul>
        </div>

        <!-- Company column -->
        <div class="col-lg-2 col-sm-6 col-6">
          <h6 class="ps-footer-heading">Company</h6>
          <ul class="ps-footer-links">
            <li><a href="#about">About Us</a></li>
            <li><a href="#team">Our Team</a></li>
            <li><a href="#blog">Blog</a></li>
            <li><a href="#faq">FAQ</a></li>
            <li><a href="#testimonials">Testimonials</a></li>
          </ul>
        </div>

        <!-- Contact column -->
        <div class="col-lg-4 col-md-12">
          <h6 class="ps-footer-heading">Get In Touch</h6>
          <ul class="ps-footer-contact">
            <li v-if="contactEmail">
              <span class="ps-contact-icon"><i class="fas fa-envelope"></i></span>
              <a :href="'mailto:' + contactEmail">{{ contactEmail }}</a>
            </li>
            <li v-if="contactPhone">
              <span class="ps-contact-icon"><i class="fas fa-phone"></i></span>
              <a :href="'tel:' + contactPhone">{{ contactPhone }}</a>
            </li>
            <li v-if="whatsapp">
              <span class="ps-contact-icon"><i class="fab fa-whatsapp"></i></span>
              <a :href="'https://wa.me/' + whatsapp" target="_blank" rel="noopener">+{{ whatsapp }}</a>
            </li>
            <li v-if="address">
              <span class="ps-contact-icon"><i class="fas fa-map-marker-alt"></i></span>
              <span>{{ address }}</span>
            </li>
          </ul>
          <a href="#newsletter" class="ps-footer-cta">
            Send a Message <i class="fas fa-arrow-right ms-2"></i>
          </a>
        </div>
      </div>

      <!-- ── Divider ── -->
      <hr class="ps-footer-hr">

      <!-- ── Bottom bar ── -->
      <div class="ps-footer-bottom">
        <p class="ps-copy">
          &copy; {{ year }} <strong>{{ siteName }}</strong>. {{ copyRight || 'All rights reserved.' }}
        </p>
        <p class="ps-stack">
          Built with <i class="fas fa-heart ps-heart"></i> using
          <span>Laravel</span> &amp; <span>Vue.js</span>
        </p>
      </div>

    </div>
  </footer>
</template>

<script>
import { mapState, mapActions } from 'pinia';
import { site_settings_store } from '../GlobalStore/site_settings_store';

export default {
  name: 'PsFooter',
  computed: {
    ...mapState(site_settings_store, { _settings: 'website_settings_data' }),

    year() { return new Date().getFullYear(); },

    siteName()      { return this._val('site_name')      || 'PriyoSoft'; },
    copyRight()     { return this._val('copy_right')     || ''; },
    contactEmail()  { return this._val('email') || ''; },
    contactPhone()  { return this._val('phone_numbers')  || ''; },
    whatsapp()      { return this._val('whatsapp')       || ''; },
    address()       { return this._val('address')        || ''; },

    footerLogoUrl() {
      const val = this._val('footer_logo');
      return val && val !== 'default.png' && val !== 'logo.png' ? '/' + val : null;
    },

    social() {
      return {
        facebook:  this._val('facebook')  || '',
        instagram: this._val('instagram') || '',
        twitter:   this._val('twitter')   || '',
        linkedin:  this._val('linkedin')  || '',
        youtube:   this._val('youtube')   || '',
        github:    this._val('github')    || '',
      };
    },
  },
  methods: {
    ...mapActions(site_settings_store, ['get_all_website_settings']),
    _val(key) {
      if (!Array.isArray(this._settings)) return '';
      const item = this._settings.find(i => i.title === key);
      return item?.setting_values?.[0]?.value || '';
    },
  },
  mounted() {
    this.get_all_website_settings();
  },
};
</script>

<style scoped>
/* ── Shell ──────────────────────────────────────── */
.ps-footer {
  background: linear-gradient(180deg, var(--ps-footer-bg-from) 0%, var(--ps-footer-bg-to) 100%);
  color: var(--ps-footer-text);
  padding-top: 4.5rem;
  padding-bottom: 0;
  border-top: 1px solid var(--ps-footer-border);
}

.ps-footer-top { padding-bottom: 3.5rem; }

/* ── Brand ──────────────────────────────────────── */
.ps-footer-brand {
  display: flex;
  align-items: center;
  gap: .6rem;
  margin-bottom: 1.1rem;
}
.ps-footer-logo-img {
  height: 38px;
  width: auto;
  object-fit: contain;
}
.ps-footer-icon {
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
  flex-shrink: 0;
}
.ps-footer-bname {
  font-size: 1.3rem;
  font-weight: 800;
  color: var(--ps-footer-bname-color);
  transition: color .3s;
}
.ps-footer-bname em { font-style: normal; color: var(--ps-footer-bname-em); transition: color .3s; }

.ps-footer-desc {
  font-size: .9rem;
  line-height: 1.75;
  color: var(--ps-footer-desc);
  margin-bottom: 1.5rem;
  max-width: 360px;
}

/* ── Social icons ───────────────────────────────── */
.ps-socials { display: flex; gap: .6rem; flex-wrap: wrap; }
.ps-social-link {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  background: var(--ps-footer-social-bg);
  border: 1px solid var(--ps-footer-social-border);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--ps-footer-social-color);
  font-size: .9rem;
  text-decoration: none;
  transition: background .2s, color .2s, border-color .2s, transform .2s;
}
.ps-social-link:hover {
  background: linear-gradient(135deg, #667eea, #764ba2);
  border-color: transparent;
  color: #fff;
  transform: translateY(-3px);
}

/* ── Heading ────────────────────────────────────── */
.ps-footer-heading {
  color: var(--ps-footer-heading);
  font-weight: 700;
  font-size: .8rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  margin-bottom: 1.25rem;
}

/* ── Link lists ─────────────────────────────────── */
.ps-footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: .65rem;
}
.ps-footer-links a {
  color: var(--ps-footer-link);
  text-decoration: none;
  font-size: .9rem;
  transition: color .2s, padding-left .2s;
  display: inline-flex;
  align-items: center;
}
.ps-footer-links a::before {
  content: '→';
  margin-right: .4rem;
  opacity: 0;
  transition: opacity .2s;
  font-size: .75rem;
  color: #667eea;
}
.ps-footer-links a:hover {
  color: #c4b5fd;
  padding-left: 4px;
}
.ps-footer-links a:hover::before { opacity: 1; }

/* ── Contact list ───────────────────────────────── */
.ps-footer-contact {
  list-style: none;
  padding: 0;
  margin: 0 0 1.5rem;
  display: flex;
  flex-direction: column;
  gap: .8rem;
}
.ps-footer-contact li {
  display: flex;
  align-items: flex-start;
  gap: .75rem;
  font-size: .9rem;
  color: var(--ps-footer-link);
  line-height: 1.5;
}
.ps-footer-contact a {
  color: var(--ps-footer-link);
  text-decoration: none;
  transition: color .2s;
}
.ps-footer-contact a:hover { color: #c4b5fd; }
.ps-contact-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: var(--ps-footer-contact-icon-bg);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #818cf8;
  font-size: .82rem;
  flex-shrink: 0;
}

/* ── Footer CTA ─────────────────────────────────── */
.ps-footer-cta {
  display: inline-flex;
  align-items: center;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff !important;
  font-weight: 700;
  font-size: .875rem;
  text-decoration: none;
  padding: .65rem 1.5rem;
  border-radius: 50px;
  transition: transform .2s, box-shadow .2s;
}
.ps-footer-cta:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(102,126,234,.45);
}

/* ── Divider ────────────────────────────────────── */
.ps-footer-hr {
  border: none;
  border-top: 1px solid var(--ps-footer-hr);
  margin: 0;
}

/* ── Bottom bar ─────────────────────────────────── */
.ps-footer-bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: .5rem;
  padding: 1.25rem 0;
}
.ps-copy {
  margin: 0;
  font-size: .85rem;
  color: var(--ps-footer-copy);
}
.ps-copy strong { color: var(--ps-footer-copy-strong); }
.ps-stack {
  margin: 0;
  font-size: .82rem;
  color: var(--ps-footer-stack);
  display: flex;
  align-items: center;
  gap: .3rem;
}
.ps-stack span { color: #818cf8; font-weight: 600; }
.ps-heart {
  color: #f43f5e;
  font-size: .8rem;
  animation: heartbeat 1.4s infinite;
}
@keyframes heartbeat {
  0%, 100% { transform: scale(1); }
  50%       { transform: scale(1.25); }
}

/* ── Responsive ─────────────────────────────────── */
@media (max-width: 768px) {
  .ps-footer { padding-top: 3rem; }
  .ps-footer-top { padding-bottom: 2.5rem; }
  .ps-footer-bottom { justify-content: center; text-align: center; }
}
</style>
