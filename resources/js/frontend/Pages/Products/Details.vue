<template>
  <div class="pd-page">

    <!-- Loading -->
    <div v-if="loading" class="pd-loading">
      <div class="pd-spinner"></div>
    </div>

    <!-- Not found -->
    <div v-else-if="!product" class="pd-notfound">
      <div class="pd-notfound__inner">
        <span class="pd-notfound__code">404</span>
        <h2>Product Not Found</h2>
        <p>The product you're looking for doesn't exist or has been removed.</p>
        <a href="/#products" class="pd-btn pd-btn--primary">← Back to Products</a>
      </div>
    </div>

    <!-- Product -->
    <template v-else>

      <!-- ── Hero ── -->
      <section class="pd-hero" :style="heroBg">
        <div class="pd-hero__noise"></div>
        <div class="pd-hero__glow"></div>
        <div class="container pd-hero__container">

          <nav class="pd-breadcrumb">
            <a href="/" class="pd-breadcrumb__link">Home</a>
            <i class="fas fa-chevron-right pd-breadcrumb__sep"></i>
            <a href="/#products" class="pd-breadcrumb__link">Products</a>
            <i class="fas fa-chevron-right pd-breadcrumb__sep"></i>
            <span class="pd-breadcrumb__current">{{ product.name }}</span>
          </nav>

          <div class="pd-hero__body">
            <div class="pd-hero__content">
              <div class="pd-hero__tags">
                <span class="pd-tag pd-tag--status" :class="'tag--' + product.status">
                  <span class="pd-tag__dot"></span>{{ statusLabel(product.status) }}
                </span>
                <span v-if="product.productGroupId" class="pd-tag pd-tag--group">
                  <i class="fas fa-layer-group me-1"></i>{{ product.productGroupId.name }}
                </span>
              </div>

              <h1 class="pd-hero__title">{{ product.name }}</h1>
              <p class="pd-hero__desc">{{ shortDesc }}</p>

              <div class="pd-hero__cta">
                <a :href="'/products/' + product.slug + '/payment'" class="pd-btn pd-btn--cta">
                  Get Started <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <a v-if="product.promo_link" :href="product.promo_link" target="_blank" rel="noopener" class="pd-btn pd-btn--ghost">
                  <i class="fas fa-desktop me-2"></i>View Demo
                </a>
                <a v-else :href="whatsappUrl" target="_blank" rel="noopener" class="pd-btn pd-btn--ghost">
                  <i class="fab fa-whatsapp me-2"></i>Chat on WhatsApp
                </a>
              </div>
            </div>

            <!-- Hero right: promo embed or price card -->
            <div v-if="promoEmbed" class="pd-hero__video-wrap">

              <!-- Badge -->
              <div class="pd-hero__video-badge">
                <template v-if="promoEmbed.type === 'youtube'">
                  <i class="fab fa-youtube me-1"></i> Product Demo
                </template>
                <template v-else>
                  <i class="fas fa-desktop me-1"></i> Live Preview
                </template>
              </div>

              <!-- YouTube embed -->
              <iframe
                v-if="promoEmbed.type === 'youtube'"
                :src="promoEmbed.src"
                class="pd-hero__video"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
              ></iframe>

              <!-- Website live preview -->
              <div v-else class="pd-hero__site-preview">
                <div class="pd-hero__browser-bar">
                  <span class="pd-browser__dots">
                    <span></span><span></span><span></span>
                  </span>
                  <span class="pd-browser__url">{{ promoEmbed.src }}</span>
                  <a :href="promoEmbed.src" target="_blank" rel="noopener" class="pd-browser__open" title="Open in new tab">
                    <i class="fas fa-external-link-alt"></i>
                  </a>
                </div>
                <iframe
                  :src="promoEmbed.src"
                  class="pd-hero__site-frame"
                  frameborder="0"
                  scrolling="no"
                ></iframe>
                <a :href="promoEmbed.src" target="_blank" rel="noopener" class="pd-hero__site-overlay">
                  <span><i class="fas fa-external-link-alt me-2"></i>Open Live Demo</span>
                </a>
              </div>

              <!-- Price strip below embed -->
          
            </div>

            <!-- Price card fallback (no promo_link) -->
            <div v-else class="pd-hero__price-card">
              <p class="pd-hero__price-label">Starting from</p>
              <div class="pd-hero__price-row">
                <template v-if="product.sales_price">
                  <span class="pd-hero__price">৳{{ fmt(product.sales_price) }}</span>
                  <span class="pd-hero__price-strike">৳{{ fmt(product.regular_price) }}</span>
                </template>
                <template v-else-if="product.regular_price">
                  <span class="pd-hero__price">৳{{ fmt(product.regular_price) }}</span>
                </template>
                <template v-else>
                  <span class="pd-hero__price-tbd">Custom Pricing</span>
                </template>
              </div>
              <div v-if="discountPct" class="pd-hero__discount">
                <i class="fas fa-tag me-1"></i>Save {{ discountPct }}%
              </div>
            </div>
          </div>

        </div>
      </section>

      <!-- ── Body ── -->
      <section class="pd-body">
        <div class="container">
          <div class="pd-layout">

            <!-- ── Main ── -->
            <main class="pd-main">

              <!-- Features -->
              <div v-if="features.length" class="pd-section">
                <div class="pd-section__header">
                  <span class="pd-section__eyebrow">Included</span>
                  <h2 class="pd-section__title">Everything You Get</h2>
                </div>
                <div class="pd-feat-grid">
                  <div v-for="(f, i) in features" :key="i" class="pd-feat-card">
                    <span class="pd-feat-card__icon">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="pd-feat-card__text">{{ f }}</span>
                  </div>
                </div>
              </div>

              <!-- Overview -->
              <div class="pd-section">
                <div class="pd-section__header">
                  <span class="pd-section__eyebrow">Details</span>
                  <h2 class="pd-section__title">Product Overview</h2>
                </div>
                <div class="pd-prose" v-html="product.description"></div>
              </div>

            </main>

            <!-- ── Sidebar ── -->
            <aside class="pd-sidebar">
              <div class="pd-sidebar__sticky">

                <!-- Pricing card -->
                <div class="pd-price-card">
                  <div class="pd-price-card__head" :style="heroBg">
                    <img v-if="productImage" :src="productImage" :alt="product.name" class="pd-price-card__img" />
                    <div v-else class="pd-price-card__img-placeholder">
                      <i class="fas fa-cube"></i>
                    </div>
                  </div>

                  <div class="pd-price-card__body">

                    <div class="pd-price-card__amount">
                      <template v-if="product.sales_price">
                        <span class="pd-amount">৳{{ fmt(product.sales_price) }}</span>
                        <span class="pd-amount-original">৳{{ fmt(product.regular_price) }}</span>
                      </template>
                      <template v-else-if="product.regular_price">
                        <span class="pd-amount">৳{{ fmt(product.regular_price) }}</span>
                      </template>
                      <template v-else>
                        <span class="pd-amount-tbd">Contact Us</span>
                      </template>
                    </div>

                    <div v-if="discountPct" class="pd-price-card__discount">
                      🎉 You save {{ discountPct }}% on this product
                    </div>

                    <div class="pd-price-card__actions">
                      <a :href="'/products/' + product.slug + '/payment'" class="pd-action-btn pd-action-btn--primary">
                        <i class="fas fa-rocket"></i> Get Started Now
                      </a>
                      <a :href="whatsappUrl" target="_blank" rel="noopener" class="pd-action-btn pd-action-btn--whatsapp">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                      </a>
                      <a :href="'tel:' + contactPhone" class="pd-action-btn pd-action-btn--call">
                        <i class="fas fa-phone"></i> Call Us
                      </a>
                    </div>

                    <ul class="pd-price-card__meta">
                      <li v-if="product.launch_date">
                        <i class="fas fa-calendar-check"></i>
                        <span>Launch: <strong>{{ fmtDate(product.launch_date) }}</strong></span>
                      </li>
                      <li v-if="product.productGroupId">
                        <i class="fas fa-tag"></i>
                        <span>Category: <strong>{{ product.productGroupId.name }}</strong></span>
                      </li>
                      <li>
                        <i class="fas fa-circle" :class="'dot--' + product.status"></i>
                        <span>Status: <strong>{{ statusLabel(product.status) }}</strong></span>
                      </li>
                      <li>
                        <i class="fas fa-shield-alt"></i>
                        <span>Built with Laravel + Vue.js</span>
                      </li>
                      <li v-if="product.version">
                        <i class="fas fa-code-branch"></i>
                        <span>Version: <strong>{{ product.version }}</strong></span>
                      </li>
                    </ul>

                  </div>
                </div>

                <!-- Trust badges -->
                <div class="pd-trust">
                  <div class="pd-trust__item">
                    <i class="fas fa-headset pd-trust__icon"></i>
                    <div>
                      <p class="pd-trust__title">Dedicated Support</p>
                      <p class="pd-trust__sub">We're here after launch</p>
                    </div>
                  </div>
                  <div class="pd-trust__item">
                    <i class="fas fa-code pd-trust__icon"></i>
                    <div>
                      <p class="pd-trust__title">Clean Codebase</p>
                      <p class="pd-trust__sub">Maintainable & scalable</p>
                    </div>
                  </div>
                  <div class="pd-trust__item">
                    <i class="fas fa-sync-alt pd-trust__icon"></i>
                    <div>
                      <p class="pd-trust__title">Regular Updates</p>
                      <p class="pd-trust__sub">Continuously improved</p>
                    </div>
                  </div>
                </div>

                <!-- Screenshot gallery — inside sticky, below trust badges -->
                <div v-if="screenshots.length" class="pd-gallery">
                  <div class="pd-gallery__header">
                    <span class="pd-gallery__label"><i class="fas fa-images me-1"></i> Screenshots</span>
                    <span class="pd-gallery__count">{{ screenshots.length }} image{{ screenshots.length > 1 ? 's' : '' }}</span>
                  </div>
                  <div class="pd-gallery__grid">
                    <button
                      v-for="(img, i) in screenshots"
                      :key="i"
                      class="pd-gallery__thumb"
                      @click="openLightbox(i)"
                    >
                      <img :src="imgSrc(img)" :alt="product.name + ' ' + (i + 1)" loading="lazy" />
                      <span class="pd-gallery__zoom"><i class="fas fa-expand-alt"></i></span>
                    </button>
                  </div>
                </div>

              </div>
            </aside>

          </div>
        </div>
      </section>

    </template>

    <!-- ── Lightbox ── -->
    <div v-if="lightboxIndex !== null" class="pd-lightbox" @click.self="closeLightbox">
      <button class="pd-lightbox__close" @click="closeLightbox" aria-label="Close">
        <i class="fas fa-times"></i>
      </button>
      <button v-if="screenshots.length > 1" class="pd-lightbox__nav pd-lightbox__nav--prev" @click="prevImage" aria-label="Previous">
        <i class="fas fa-chevron-left"></i>
      </button>
      <div class="pd-lightbox__stage">
        <img :src="imgSrc(screenshots[lightboxIndex])" :alt="product.name" class="pd-lightbox__img" />
        <p class="pd-lightbox__caption">{{ lightboxIndex + 1 }} / {{ screenshots.length }}</p>
      </div>
      <button v-if="screenshots.length > 1" class="pd-lightbox__nav pd-lightbox__nav--next" @click="nextImage" aria-label="Next">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

  </div>
</template>

<script>
import { mapActions, mapState } from 'pinia';
import { site_settings_store } from '../../GlobalStore/site_settings_store';

const STATUS_LABEL = {
  active: 'Live Now', development: 'In Development',
  planning: 'Coming Soon', paused: 'Paused',
};
const HERO_BG = {
  active:      'linear-gradient(140deg,#0f0c29,#302b63,#24243e)',
  development: 'linear-gradient(140deg,#200122,#6f0000,#3b0a5a)',
  planning:    'linear-gradient(140deg,#0f2027,#203a43,#2c5364)',
  paused:      'linear-gradient(140deg,#1a1a2e,#16213e,#0f3460)',
};

export default {
  name: 'ProductDetailsPage',
  props: { slug: { type: String, required: true } },

  data: () => ({
    product: null, loading: true,
    lightboxIndex: null,
  }),

  computed: {
    ...mapState(site_settings_store, { _siteSettings: 'website_settings_data' }),

    contactPhone() {
      const s = this._siteSettings?.find?.(i => i.title === 'phone_numbers');
      return s?.setting_values?.[0]?.value || '01931374336';
    },
    whatsappNumber() {
      let num = this.contactPhone.replace(/\D/g, '');
      if (num.startsWith('00'))  num = num.slice(2);
      if (num.startsWith('880')) return num;
      if (num.startsWith('0'))   return '880' + num.slice(1);
      return num;
    },

    shortDesc() {
      const html = this.product?.description || '';
      const plain = html.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
      return plain.length > 220 ? plain.slice(0, 217) + '…' : plain;
    },
    features() {
      const f = this.product?.features;
      if (!f) return [];
      try { return Array.isArray(f) ? f : JSON.parse(f); } catch { return []; }
    },
    heroBg() {
      return { background: HERO_BG[this.product?.status] || HERO_BG.active };
    },
    whatsappUrl() {
      const msg = encodeURIComponent(`Hi PriyoSoft, I'm interested in "${this.product?.name}"`);
      return `https://wa.me/${this.whatsappNumber}?text=${msg}`;
    },
    productImage() {
      const img = this.product?.thumbnail || this.product?.screenshots;
      if (!img) return '/default.png';
      return img.startsWith('http') ? img : '/' + img;
    },
    discountPct() {
      const r = +this.product?.regular_price, s = +this.product?.sales_price;
      if (!r || !s || s >= r) return 0;
      return Math.round((r - s) / r * 100);
    },
    screenshots() {
      const s = this.product?.screenshots;
      if (!s) return [];
      try {
        const p = JSON.parse(s);
        return Array.isArray(p) ? p : [s];
      } catch { return typeof s === 'string' && s.trim() ? [s] : []; }
    },
    promoEmbed() {
      const vidUrl  = this.product?.video_url;
      const demoUrl = this.product?.promo_link;
      if (vidUrl) {
        const yt = vidUrl.match(/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([^&?\s]{11})/);
        if (yt) return { type: 'youtube', src: `https://www.youtube.com/embed/${yt[1]}?rel=0&modestbranding=1&autoplay=1&mute=1` };
      }
      if (demoUrl) return { type: 'website', src: demoUrl };
      return null;
    },
  },

  methods: {
    ...mapActions(site_settings_store, { get_all_website_settings: 'get_all_website_settings' }),
    statusLabel: s => STATUS_LABEL[s] || s || 'Active',
    fmt: n => n ? new Intl.NumberFormat('en-BD').format(n) : '—',
    fmtDate: d => d ? new Date(d).toLocaleDateString('en-US', { year:'numeric', month:'short', day:'numeric' }) : '—',
    imgSrc(src) { return src?.startsWith('http') ? src : '/' + src; },

    openLightbox(i)  { this.lightboxIndex = i; document.body.style.overflow = 'hidden'; },
    closeLightbox()  { this.lightboxIndex = null; document.body.style.overflow = ''; },
    prevImage()      { this.lightboxIndex = (this.lightboxIndex - 1 + this.screenshots.length) % this.screenshots.length; },
    nextImage()      { this.lightboxIndex = (this.lightboxIndex + 1) % this.screenshots.length; },
    onKeyDown(e) {
      if (this.lightboxIndex === null) return;
      if (e.key === 'Escape')     this.closeLightbox();
      if (e.key === 'ArrowLeft')  this.prevImage();
      if (e.key === 'ArrowRight') this.nextImage();
    },

    async fetchProduct() {
      this.loading = true;
      try {
        const res = await window.axios.get(`public/products/${this.slug}`);
        this.product = res?.data?.data ?? res?.data ?? null;
      } catch { this.product = null; }
      finally { this.loading = false; }
    },
  },

  mounted() {
    this.fetchProduct();
    this.get_all_website_settings();
    window.addEventListener('keydown', this.onKeyDown);
  },
  beforeUnmount() {
    window.removeEventListener('keydown', this.onKeyDown);
    document.body.style.overflow = '';
  },
};
</script>

<style scoped>
/* ─── Base ──────────────────────────────────────── */
.pd-page { min-height: 100vh; background: #f8f9fc; }

/* ─── Loading ───────────────────────────────────── */
.pd-loading {
  min-height: 100vh; display: flex; align-items: center; justify-content: center;
}
.pd-spinner {
  width: 52px; height: 52px; border-radius: 50%;
  border: 4px solid #e0e7ff; border-top-color: #4f46e5;
  animation: spin .7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ─── Not found ─────────────────────────────────── */
.pd-notfound {
  min-height: 100vh; display: flex; align-items: center; justify-content: center;
}
.pd-notfound__inner { text-align: center; }
.pd-notfound__code {
  font-size: 7rem; font-weight: 900; color: #e0e7ff;
  line-height: 1; display: block;
}
.pd-notfound__inner h2 { font-size: 2rem; color: #1e1b4b; margin: .5rem 0; }
.pd-notfound__inner p  { color: #6b7280; margin-bottom: 2rem; }

/* ─── Buttons ───────────────────────────────────── */
.pd-btn {
  display: inline-flex; align-items: center; justify-content: center;
  font-weight: 700; text-decoration: none;
  padding: .8rem 1.75rem; border-radius: 10px;
  transition: transform .2s, box-shadow .2s;
}
.pd-btn--primary {
  background: #4f46e5; color: #fff !important;
}
.pd-btn--primary:hover { background: #4338ca; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(79,70,229,.35); }
.pd-btn--cta {
  background: #fff; color: #1e1b4b !important;
  font-size: 1rem; padding: .9rem 2rem;
  box-shadow: 0 4px 20px rgba(0,0,0,.2);
}
.pd-btn--cta:hover { transform: translateY(-3px); box-shadow: 0 10px 32px rgba(0,0,0,.3); }
.pd-btn--ghost {
  background: rgba(255,255,255,.12); color: #fff !important;
  border: 1.5px solid rgba(255,255,255,.35);
  font-size: 1rem; padding: .9rem 2rem;
}
.pd-btn--ghost:hover { background: rgba(255,255,255,.2); transform: translateY(-2px); }

/* ─── Hero ──────────────────────────────────────── */
.pd-hero { position: relative; padding: 5.5rem 0 5rem; overflow: hidden; }
.pd-hero__noise {
  position: absolute; inset: 0; z-index: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
  background-size: 200px;
}
.pd-hero__glow {
  position: absolute; bottom: -80px; left: 50%; transform: translateX(-50%);
  width: 700px; height: 300px; z-index: 0;
  background: radial-gradient(ellipse at center, rgba(255,255,255,.06) 0%, transparent 70%);
}
.pd-hero__container { position: relative; z-index: 2; }

/* Breadcrumb */
.pd-breadcrumb {
  display: flex; align-items: center; gap: .5rem;
  font-size: .8rem; margin-bottom: 2.5rem; flex-wrap: wrap;
}
.pd-breadcrumb__link { color: rgba(255,255,255,.55); text-decoration: none; font-weight: 500; }
.pd-breadcrumb__link:hover { color: rgba(255,255,255,.9); }
.pd-breadcrumb__sep { color: rgba(255,255,255,.25); font-size: .6rem; }
.pd-breadcrumb__current { color: rgba(255,255,255,.75); font-weight: 600; }

/* Hero body */
.pd-hero__body {
  display: flex; align-items: stretch; gap: 3rem; flex-wrap: wrap;
}
.pd-hero__content { flex: 1; min-width: 280px; display: flex; flex-direction: column; justify-content: center; }

/* Tags */
.pd-hero__tags { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1.25rem; }
.pd-tag {
  display: inline-flex; align-items: center; gap: .4rem;
  font-size: .7rem; font-weight: 700; letter-spacing: .7px; text-transform: uppercase;
  padding: .3rem .9rem; border-radius: 50px;
}
.pd-tag--status.tag--active      { background: #ecfdf5; color: #065f46; }
.pd-tag--status.tag--development { background: #ede9fe; color: #4c1d95; }
.pd-tag--status.tag--planning    { background: #fffbeb; color: #78350f; }
.pd-tag--status.tag--paused      { background: #f9fafb; color: #374151; }
.pd-tag__dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; opacity: .8; }
.pd-tag--group {
  background: rgba(255,255,255,.15); color: #fff;
  border: 1px solid rgba(255,255,255,.25);
}

.pd-hero__title {
  font-size: clamp(2rem, 4.5vw, 3.2rem); font-weight: 900;
  color: #fff; line-height: 1.15; margin-bottom: 1.25rem;
  letter-spacing: -.5px;
}
.pd-hero__desc {
  font-size: 1.05rem; color: rgba(255,255,255,.72);
  line-height: 1.75; max-width: 600px; margin-bottom: 2.25rem;
}
.pd-hero__cta { display: flex; flex-wrap: wrap; gap: .85rem; }

/* Hero video embed */
.pd-hero__video-wrap {
  flex-shrink: 0;
  width: 440px;
  display: flex;
  flex-direction: column;
  gap: .55rem;
}
.pd-hero__video-badge {
  display: inline-flex; align-items: center;
  font-size: .7rem; font-weight: 700; letter-spacing: .6px; text-transform: uppercase;
  color: #fff; background: rgba(220,38,38,.85);
  padding: .25rem .8rem; border-radius: 50px;
  align-self: flex-start; flex-shrink: 0;
}
.pd-hero__video {
  width: 100%;
  flex: 1;
  min-height: 220px;
  border: none;
  border-radius: 14px;
  box-shadow: 0 12px 40px rgba(0,0,0,.45);
  display: block;
}

/* Website live preview */
.pd-hero__site-preview {
  border-radius: 14px; overflow: hidden;
  box-shadow: 0 12px 40px rgba(0,0,0,.45);
  position: relative;
}
.pd-hero__browser-bar {
  display: flex; align-items: center; gap: .6rem;
  background: #1e1e2e; padding: .5rem .85rem;
  border-bottom: 1px solid rgba(255,255,255,.08);
}
.pd-browser__dots {
  display: flex; gap: .3rem; flex-shrink: 0;
}
.pd-browser__dots span {
  width: 10px; height: 10px; border-radius: 50%;
}
.pd-browser__dots span:nth-child(1) { background: #ff5f57; }
.pd-browser__dots span:nth-child(2) { background: #febc2e; }
.pd-browser__dots span:nth-child(3) { background: #28c840; }
.pd-browser__url {
  flex: 1; font-size: .68rem; color: rgba(255,255,255,.45);
  background: rgba(255,255,255,.08); border-radius: 6px;
  padding: .2rem .6rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.pd-browser__open {
  color: rgba(255,255,255,.4); font-size: .7rem; flex-shrink: 0;
  text-decoration: none; transition: color .2s;
}
.pd-browser__open:hover { color: #fff; }
.pd-hero__site-frame {
  width: 100%; height: 300px; display: block; border: none;
  background: #fff;
  pointer-events: none;
}
.pd-hero__site-overlay {
  position: absolute; inset: 30px 0 0 0;
  display: flex; align-items: center; justify-content: center;
  background: rgba(0,0,0,.0); transition: background .25s;
  text-decoration: none;
}
.pd-hero__site-overlay span {
  opacity: 0; transition: opacity .25s;
  background: rgba(79,70,229,.92); color: #fff;
  font-size: .9rem; font-weight: 700;
  padding: .7rem 1.5rem; border-radius: 10px;
  box-shadow: 0 4px 20px rgba(0,0,0,.3);
}
.pd-hero__site-preview:hover .pd-hero__site-overlay { background: rgba(0,0,0,.35); }
.pd-hero__site-preview:hover .pd-hero__site-overlay span { opacity: 1; }

.pd-hero__video-price {
  display: flex; align-items: center; flex-wrap: wrap; gap: .5rem;
  background: rgba(255,255,255,.1); backdrop-filter: blur(14px);
  border: 1px solid rgba(255,255,255,.18);
  border-radius: 12px; padding: .75rem 1.25rem;
}

/* Hero price card */
.pd-hero__price-card {
  background: rgba(255,255,255,.1);
  backdrop-filter: blur(16px);
  border: 1px solid rgba(255,255,255,.2);
  border-radius: 16px; padding: 1.75rem 2rem;
  min-width: 220px; text-align: center;
  flex-shrink: 0;
}
.pd-hero__price-label { font-size: .75rem; color: rgba(255,255,255,.55); text-transform: uppercase; letter-spacing: .8px; margin-bottom: .5rem; }
.pd-hero__price-row { display: flex; align-items: baseline; justify-content: center; gap: .5rem; flex-wrap: wrap; }
.pd-hero__price { font-size: 2.2rem; font-weight: 900; color: #fff; }
.pd-hero__price-strike { font-size: 1rem; color: rgba(255,255,255,.45); text-decoration: line-through; }
.pd-hero__price-tbd { font-size: 1.3rem; font-weight: 700; color: rgba(255,255,255,.8); }
.pd-hero__discount {
  margin-top: .75rem; font-size: .78rem; font-weight: 700;
  background: rgba(16,185,129,.2); color: #6ee7b7;
  padding: .3rem .85rem; border-radius: 50px; display: inline-block;
}

/* ─── Body layout ───────────────────────────────── */
.pd-body { padding: 3rem 0 5rem; }
.pd-layout {
  display: grid;
  grid-template-columns: 1fr 360px;
  gap: 2rem; align-items: start;
}

/* ─── Section ───────────────────────────────────── */
.pd-section { margin-bottom: 2.5rem; }
.pd-section__header { margin-bottom: 1.5rem; }
.pd-section__eyebrow {
  display: inline-block; font-size: .7rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1px; color: #4f46e5;
  background: #eef2ff; padding: .2rem .75rem; border-radius: 50px;
  margin-bottom: .5rem;
}
.pd-section__title {
  font-size: 1.5rem; font-weight: 800; color: #111827; margin: 0;
}

/* ─── Feature grid ──────────────────────────────── */
.pd-feat-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: .85rem;
}
.pd-feat-card {
  display: flex; align-items: flex-start; gap: .85rem;
  background: #fff; border: 1px solid #e9ecf3; border-radius: 12px;
  padding: 1rem 1.25rem;
  box-shadow: 0 1px 4px rgba(0,0,0,.04);
  transition: box-shadow .2s, transform .2s;
}
.pd-feat-card:hover { box-shadow: 0 4px 16px rgba(79,70,229,.1); transform: translateY(-2px); }
.pd-feat-card__icon {
  width: 28px; height: 28px; border-radius: 8px;
  background: #eef2ff; color: #4f46e5;
  display: flex; align-items: center; justify-content: center;
  font-size: .7rem; flex-shrink: 0; margin-top: .1rem;
}
.pd-feat-card__text { font-size: .9rem; color: #374151; line-height: 1.5; }

/* ─── Prose ─────────────────────────────────────── */
.pd-prose {
  background: #fff; border: 1px solid #e9ecf3; border-radius: 16px;
  padding: 2rem; box-shadow: 0 1px 8px rgba(0,0,0,.04);
}
.pd-prose :deep(p)  { font-size: .97rem; color: #4b5563; line-height: 1.85; margin: 0 0 1rem; }
.pd-prose :deep(p:last-child) { margin-bottom: 0; }
.pd-prose :deep(h1),.pd-prose :deep(h2),.pd-prose :deep(h3),
.pd-prose :deep(h4),.pd-prose :deep(h5),.pd-prose :deep(h6) {
  color: #111827; font-weight: 700; line-height: 1.35;
  margin: 1.5rem 0 .6rem;
}
.pd-prose :deep(h2) { font-size: 1.3rem; }
.pd-prose :deep(h3) { font-size: 1.1rem; }
.pd-prose :deep(ul),.pd-prose :deep(ol) {
  padding-left: 1.5rem; margin: .75rem 0 1rem; color: #4b5563;
}
.pd-prose :deep(li) { margin-bottom: .35rem; line-height: 1.7; font-size: .97rem; }
.pd-prose :deep(strong),.pd-prose :deep(b) { color: #111827; font-weight: 700; }
.pd-prose :deep(a) { color: #4f46e5; text-decoration: underline; }
.pd-prose :deep(img) { max-width: 100%; border-radius: 10px; margin: 1rem 0; }
.pd-prose :deep(blockquote) {
  border-left: 4px solid #4f46e5; padding: .75rem 1.25rem;
  margin: 1rem 0; background: #f5f3ff; border-radius: 0 8px 8px 0;
  color: #374151;
}
.pd-prose :deep(pre),.pd-prose :deep(code) {
  background: #f3f4f6; border-radius: 6px; font-size: .88rem;
}
.pd-prose :deep(pre) { padding: 1rem 1.25rem; overflow-x: auto; }
.pd-prose :deep(code) { padding: .15rem .4rem; }

/* ─── Screenshot ────────────────────────────────── */
.pd-screenshot-wrap {
  border-radius: 16px; overflow: hidden;
  border: 1px solid #e0e7ff;
  box-shadow: 0 8px 32px rgba(79,70,229,.12);
}
.pd-screenshot { width: 100%; display: block; }

/* ─── Sidebar sticky ────────────────────────────── */
.pd-sidebar__sticky { position: sticky; top: 90px; }

/* ─── Price card ────────────────────────────────── */
.pd-price-card {
  background: #fff; border-radius: 20px; overflow: hidden;
  border: 1px solid #e9ecf3;
  box-shadow: 0 4px 24px rgba(0,0,0,.08);
  margin-bottom: 1.25rem;
}
.pd-price-card__head {
  height: 180px; position: relative; overflow: hidden;
}
.pd-price-card__img { width: 100%; height: 100%; object-fit: cover; }
.pd-price-card__img-placeholder {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  font-size: 3.5rem; color: rgba(255,255,255,.5);
}
.pd-price-card__body { padding: 1.5rem 1.5rem 1.75rem; }
.pd-price-card__amount {
  display: flex; align-items: baseline; gap: .5rem;
  flex-wrap: wrap; margin-bottom: .35rem;
}
.pd-amount { font-size: 2.1rem; font-weight: 900; color: #111827; }
.pd-amount-original { font-size: 1rem; color: #d1d5db; text-decoration: line-through; }
.pd-amount-tbd { font-size: 1.2rem; font-weight: 700; color: #4f46e5; }
.pd-price-card__discount {
  font-size: .78rem; font-weight: 600; color: #059669;
  background: #ecfdf5; padding: .3rem .75rem; border-radius: 6px;
  display: inline-block; margin-bottom: 1.25rem;
}
.pd-price-card__actions {
  display: flex; flex-direction: column; gap: .6rem; margin-bottom: 1.25rem;
}
.pd-action-btn {
  display: flex; align-items: center; justify-content: center; gap: .6rem;
  font-weight: 700; font-size: .95rem; padding: .85rem 1rem;
  border-radius: 12px; text-decoration: none;
  transition: transform .15s, box-shadow .15s;
}
.pd-action-btn:hover { transform: translateY(-2px); }
.pd-action-btn--primary {
  background: linear-gradient(135deg,#4f46e5,#7c3aed);
  color: #fff !important;
  box-shadow: 0 4px 16px rgba(79,70,229,.3);
}
.pd-action-btn--primary:hover { box-shadow: 0 8px 24px rgba(79,70,229,.4); }
.pd-action-btn--whatsapp { background: #25d366; color: #fff !important; }
.pd-action-btn--whatsapp:hover { background: #1ebe5d; }
.pd-action-btn--call { background: #1e293b; color: #fff !important; }
.pd-action-btn--call:hover { background: #0f172a; }

.pd-price-card__meta {
  list-style: none; padding: 0; margin: 0;
  border-top: 1px solid #f3f4f6; padding-top: 1rem;
  display: flex; flex-direction: column; gap: .65rem;
}
.pd-price-card__meta li {
  display: flex; align-items: center; gap: .65rem;
  font-size: .83rem; color: #374151;
}
.pd-price-card__meta li i { color: #9ca3af; width: 14px; text-align: center; flex-shrink: 0; }
.dot--active      { color: #10b981 !important; }
.dot--development { color: #8b5cf6 !important; }
.dot--planning    { color: #f59e0b !important; }
.dot--paused      { color: #9ca3af !important; }

/* ─── Trust badges ──────────────────────────────── */
.pd-trust {
  background: #fff; border-radius: 16px;
  border: 1px solid #e9ecf3;
  padding: 1.25rem 1.5rem;
  display: flex; flex-direction: column; gap: 1rem;
  box-shadow: 0 1px 6px rgba(0,0,0,.04);
}
.pd-trust__item { display: flex; align-items: center; gap: .85rem; }
.pd-trust__icon { font-size: 1.25rem; color: #4f46e5; flex-shrink: 0; width: 20px; text-align: center; }
.pd-trust__title { font-size: .85rem; font-weight: 700; color: #111827; margin: 0; }
.pd-trust__sub   { font-size: .75rem; color: #9ca3af; margin: 0; }

/* ─── Screenshot Gallery ────────────────────────── */
.pd-gallery {
  margin-top: 1.25rem;
  background: #fff;
  border: 1px solid #e9ecf3;
  border-radius: 16px;
  padding: 1.1rem 1.1rem 1.25rem;
  box-shadow: 0 1px 6px rgba(0,0,0,.04);
}
.pd-gallery__header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: .85rem;
}
.pd-gallery__label {
  font-size: .78rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: .7px; color: #374151;
}
.pd-gallery__count { font-size: .72rem; color: #9ca3af; font-weight: 500; }
.pd-gallery__grid {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: .4rem;
}
.pd-gallery__thumb {
  position: relative; aspect-ratio: 4/3; overflow: hidden;
  border-radius: 8px; border: 1.5px solid #e9ecf3;
  padding: 0; cursor: pointer; background: #f3f4f6;
  transition: border-color .2s, transform .2s;
}
.pd-gallery__thumb:hover { border-color: #4f46e5; transform: scale(1.04); }
.pd-gallery__thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.pd-gallery__zoom {
  position: absolute; inset: 0;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: .9rem; opacity: 0;
  transition: background .2s, opacity .2s;
}
.pd-gallery__thumb:hover .pd-gallery__zoom { background: rgba(79,70,229,.55); opacity: 1; }

/* ─── Lightbox ───────────────────────────────────── */
.pd-lightbox {
  position: fixed; inset: 0; z-index: 9999;
  background: rgba(0,0,0,.92);
  display: flex; align-items: center; justify-content: center; gap: 1rem; padding: 1.5rem;
}
.pd-lightbox__close {
  position: absolute; top: 1rem; right: 1rem;
  width: 44px; height: 44px; border-radius: 50%;
  border: none; background: rgba(255,255,255,.12);
  color: #fff; font-size: 1.1rem; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background .2s, transform .15s; z-index: 1;
}
.pd-lightbox__close:hover { background: rgba(255,255,255,.28); transform: scale(1.1); }
.pd-lightbox__nav {
  flex-shrink: 0; width: 50px; height: 50px; border-radius: 50%;
  border: none; background: rgba(255,255,255,.12);
  color: #fff; font-size: 1.1rem; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background .2s, transform .15s;
}
.pd-lightbox__nav:hover { background: rgba(255,255,255,.28); transform: scale(1.08); }
.pd-lightbox__stage {
  flex: 1; display: flex; flex-direction: column;
  align-items: center; justify-content: center; gap: .75rem;
  max-width: 900px; min-width: 0;
}
.pd-lightbox__img {
  max-width: 100%; max-height: 82vh;
  border-radius: 12px; object-fit: contain;
  box-shadow: 0 20px 60px rgba(0,0,0,.5); display: block;
}
.pd-lightbox__caption { color: rgba(255,255,255,.5); font-size: .85rem; margin: 0; }

/* ─── Responsive ────────────────────────────────── */
@media (max-width: 1024px) {
  .pd-layout { grid-template-columns: 1fr; }
  .pd-sidebar__sticky { position: static; }
  .pd-feat-grid { grid-template-columns: 1fr 1fr; }
  .pd-hero__body { align-items: flex-start; }
  .pd-hero__video-wrap { width: 100%; }
  .pd-hero__video { aspect-ratio: 16/9; flex: none; min-height: unset; }
}
@media (max-width: 640px) {
  .pd-hero { padding: 4rem 0 3.5rem; }
  .pd-hero__body { gap: 2rem; align-items: flex-start; }
  .pd-feat-grid { grid-template-columns: 1fr; }
  .pd-hero__price-card { width: 100%; }
  .pd-hero__video-wrap { width: 100%; }
  .pd-hero__video { aspect-ratio: 16/9; flex: none; min-height: unset; }
}
</style>
