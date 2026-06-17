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
              <p class="pd-hero__desc">{{ product.description }}</p>

              <div class="pd-hero__cta">
                <a :href="'/products/' + product.slug + '/payment'" class="pd-btn pd-btn--cta">
                  Get Started <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <a :href="whatsappUrl" target="_blank" rel="noopener" class="pd-btn pd-btn--ghost">
                  <i class="fab fa-whatsapp me-2"></i>Chat on WhatsApp
                </a>
              </div>
            </div>

            <!-- Hero price card -->
            <div class="pd-hero__price-card">
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
                <div class="pd-prose">
                  <p>{{ product.description }}</p>
                </div>
              </div>

              <!-- Screenshot -->
              <div v-if="product.screenshots" class="pd-section">
                <div class="pd-section__header">
                  <span class="pd-section__eyebrow">Preview</span>
                  <h2 class="pd-section__title">Screenshots</h2>
                </div>
                <div class="pd-screenshot-wrap">
                  <img :src="product.screenshots" :alt="product.name" class="pd-screenshot" />
                </div>
              </div>

            </main>

            <!-- ── Sidebar ── -->
            <aside class="pd-sidebar">
              <div class="pd-sidebar__sticky">

                <!-- Pricing card -->
                <div class="pd-price-card">
                  <div class="pd-price-card__head" :style="heroBg">
                    <img v-if="product.screenshots" :src="product.screenshots" :alt="product.name" class="pd-price-card__img" />
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

              </div>
            </aside>

          </div>
        </div>
      </section>

    </template>
  </div>
</template>

<script>
const CONTACT_PHONE   = '01700000000';
const WHATSAPP_NUMBER = '8801700000000';

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
    contactPhone: CONTACT_PHONE,
  }),

  computed: {
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
      return `https://wa.me/${WHATSAPP_NUMBER}?text=${msg}`;
    },
    discountPct() {
      const r = +this.product?.regular_price, s = +this.product?.sales_price;
      if (!r || !s || s >= r) return 0;
      return Math.round((r - s) / r * 100);
    },
  },

  methods: {
    statusLabel: s => STATUS_LABEL[s] || s || 'Active',
    fmt: n => n ? new Intl.NumberFormat('en-BD').format(n) : '—',
    fmtDate: d => d ? new Date(d).toLocaleDateString('en-US', { year:'numeric', month:'short', day:'numeric' }) : '—',

    async fetchProduct() {
      this.loading = true;
      try {
        const res = await window.axios.get(`public/products/${this.slug}`);
        this.product = res?.data?.data ?? res?.data ?? null;
      } catch { this.product = null; }
      finally { this.loading = false; }
    },
  },

  mounted() { this.fetchProduct(); },
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
  display: flex; align-items: flex-start; gap: 3rem; flex-wrap: wrap;
}
.pd-hero__content { flex: 1; min-width: 280px; }

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
.pd-prose p { font-size: .97rem; color: #4b5563; line-height: 1.85; margin: 0; }

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

/* ─── Responsive ────────────────────────────────── */
@media (max-width: 1024px) {
  .pd-layout { grid-template-columns: 1fr; }
  .pd-sidebar__sticky { position: static; }
  .pd-feat-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 640px) {
  .pd-hero { padding: 4rem 0 3.5rem; }
  .pd-hero__body { gap: 2rem; }
  .pd-feat-grid { grid-template-columns: 1fr; }
  .pd-hero__price-card { width: 100%; }
}
</style>
