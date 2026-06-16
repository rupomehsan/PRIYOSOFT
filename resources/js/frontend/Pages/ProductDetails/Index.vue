<template>
  <div class="pd-page">

    <!-- Loading -->
    <div v-if="loading" class="pd-loading">
      <div class="pd-spinner"></div>
      <p>Loading product…</p>
    </div>

    <!-- Not found -->
    <div v-else-if="!product" class="pd-notfound">
      <i class="fas fa-box-open pd-notfound__icon"></i>
      <h2>Product not found</h2>
      <a href="/#products" class="pd-btn-back">← Back to Products</a>
    </div>

    <!-- Product detail -->
    <template v-else>

      <!-- Hero banner -->
      <section class="pd-hero" :style="heroBg">
        <div class="pd-hero__overlay"></div>
        <div class="container pd-hero__inner">
          <a href="/#products" class="pd-back-link">
            <i class="fas fa-arrow-left me-2"></i>All Products
          </a>
          <div class="pd-hero__meta">
            <span class="pd-status-pill" :class="'s--' + (product.status || 'active')">
              <span class="pd-status-dot"></span>{{ statusLabel(product.status) }}
            </span>
            <span v-if="product.productGroupId" class="pd-group-pill">
              {{ product.productGroupId.name }}
            </span>
          </div>
          <h1 class="pd-hero__title">{{ product.name }}</h1>
          <p class="pd-hero__sub">{{ product.description }}</p>
          <div class="pd-hero__actions">
            <a href="#contact" class="pd-btn-primary" @click.prevent="scrollTo('#newsletter')">
              Get a Demo <i class="fas fa-arrow-right ms-2"></i>
            </a>
            <a href="/#products" class="pd-btn-outline">View All Products</a>
          </div>
        </div>
      </section>

      <!-- Details body -->
      <section class="pd-body">
        <div class="container">
          <div class="pd-grid">

            <!-- Left: main info -->
            <div class="pd-main">

              <!-- Features -->
              <div v-if="features.length" class="pd-card">
                <h3 class="pd-card__title">
                  <i class="fas fa-check-circle me-2 text-success"></i>Key Features
                </h3>
                <ul class="pd-features">
                  <li v-for="(f, i) in features" :key="i" class="pd-feature-item">
                    <i class="fas fa-check pd-feature-icon"></i>
                    <span>{{ f }}</span>
                  </li>
                </ul>
              </div>

              <!-- Screenshots / media -->
              <div v-if="product.screenshots" class="pd-card">
                <h3 class="pd-card__title">
                  <i class="fas fa-images me-2" style="color:#6366f1"></i>Screenshots
                </h3>
                <img :src="product.screenshots" :alt="product.name" class="pd-screenshot" />
              </div>

              <!-- Full description -->
              <div class="pd-card">
                <h3 class="pd-card__title">
                  <i class="fas fa-info-circle me-2" style="color:#0ea5e9"></i>About this Product
                </h3>
                <p class="pd-desc-full">{{ product.description }}</p>
              </div>

            </div>

            <!-- Right: sidebar -->
            <aside class="pd-sidebar">

              <!-- Quick stats -->
              <div class="pd-card pd-stats">
                <div class="pd-stat">
                  <span class="pd-stat__label">Status</span>
                  <span class="pd-status-pill" :class="'s--' + (product.status || 'active')">
                    <span class="pd-status-dot"></span>{{ statusLabel(product.status) }}
                  </span>
                </div>
                <div v-if="product.launch_date" class="pd-stat">
                  <span class="pd-stat__label">Launch Date</span>
                  <span class="pd-stat__value">{{ formatDate(product.launch_date) }}</span>
                </div>
                <div v-if="product.monthly_target_revenue" class="pd-stat">
                  <span class="pd-stat__label">Monthly Target</span>
                  <span class="pd-stat__value pd-stat__value--highlight">
                    {{ formatCurrency(product.monthly_target_revenue) }}
                  </span>
                </div>
                <div v-if="product.productGroupId" class="pd-stat">
                  <span class="pd-stat__label">Category</span>
                  <span class="pd-stat__value">{{ product.productGroupId.name }}</span>
                </div>
              </div>

              <!-- Feature badges -->
              <div v-if="features.length" class="pd-card">
                <h4 class="pd-card__title" style="font-size:.95rem">Features at a Glance</h4>
                <div class="pd-badge-list">
                  <span v-for="(f, i) in features" :key="i" class="pd-badge">
                    <i class="fas fa-check me-1"></i>{{ f }}
                  </span>
                </div>
              </div>

              <!-- CTA card -->
              <div class="pd-cta-card">
                <h4>Ready to get started?</h4>
                <p>Contact us for pricing, a live demo, or a custom quote.</p>
                <a href="/#newsletter" class="pd-btn-primary w-100 text-center">
                  Contact Us <i class="fas fa-arrow-right ms-2"></i>
                </a>
              </div>

            </aside>
          </div>
        </div>
      </section>

    </template>
  </div>
</template>

<script>
const STATUS_LABEL = { active: 'Live', development: 'In Development', planning: 'Upcoming', paused: 'Paused' };
const ACCENT = {
  active:      'linear-gradient(135deg,#0f2027,#203a43,#2c5364)',
  development: 'linear-gradient(135deg,#1a0533,#2d0b5e,#4a1572)',
  planning:    'linear-gradient(135deg,#1a1000,#3d2800,#78350f)',
  paused:      'linear-gradient(135deg,#1a1a1a,#2d2d2d,#374151)',
};

export default {
  name: 'ProductDetailsPage',

  props: {
    slug: { type: String, required: true },
  },

  data() {
    return {
      product: null,
      loading: true,
    };
  },

  computed: {
    features() {
      const f = this.product?.features;
      if (!f) return [];
      try { return Array.isArray(f) ? f : JSON.parse(f); }
      catch { return []; }
    },
    heroBg() {
      const bg = ACCENT[this.product?.status] || ACCENT.active;
      return { background: bg };
    },
  },

  methods: {
    statusLabel(s) { return STATUS_LABEL[s] || s || 'Active'; },

    formatDate(d) {
      if (!d) return '—';
      return new Date(d).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    },

    formatCurrency(n) {
      if (!n) return '—';
      return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', maximumFractionDigits: 0 }).format(n);
    },

    scrollTo(selector) {
      const el = document.querySelector(selector);
      if (el) el.scrollIntoView({ behavior: 'smooth' });
      else window.location.href = '/' + selector;
    },

    async fetchProduct() {
      this.loading = true;
      try {
        const res = await window.axios.get(`public/products/${this.slug}`);
        this.product = res?.data?.data ?? res?.data ?? null;
      } catch {
        this.product = null;
      } finally {
        this.loading = false;
      }
    },
  },

  mounted() {
    this.fetchProduct();
  },
};
</script>

<style scoped>
/* ── Page shell ───────────────────────────── */
.pd-page { min-height: 100vh; background: #f8faff; }

/* ── Loading ───────────────────────────────── */
.pd-loading {
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  min-height: 60vh; gap: 1rem; color: #64748b;
}
.pd-spinner {
  width: 48px; height: 48px;
  border: 4px solid #e0e7ff;
  border-top-color: #6366f1;
  border-radius: 50%;
  animation: spin .9s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Not found ─────────────────────────────── */
.pd-notfound {
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  min-height: 60vh; gap: 1rem; text-align: center;
}
.pd-notfound__icon { font-size: 5rem; color: #c7d2fe; }
.pd-notfound h2 { font-size: 1.75rem; color: #1e1b4b; }

/* ── Hero ──────────────────────────────────── */
.pd-hero {
  position: relative;
  padding: 7rem 0 5rem;
  overflow: hidden;
}
.pd-hero__overlay {
  position: absolute; inset: 0;
  background: rgba(0,0,0,.38);
}
.pd-hero__inner {
  position: relative; z-index: 2;
}

.pd-back-link {
  display: inline-flex; align-items: center;
  color: rgba(255,255,255,.75);
  font-size: .875rem; font-weight: 600;
  text-decoration: none;
  margin-bottom: 1.5rem;
  transition: color .2s;
}
.pd-back-link:hover { color: #fff; }

.pd-hero__meta {
  display: flex; flex-wrap: wrap; gap: .6rem;
  margin-bottom: 1.25rem;
}

.pd-hero__title {
  font-size: clamp(2rem, 4.5vw, 3rem);
  font-weight: 800; color: #fff;
  line-height: 1.15; margin-bottom: 1.25rem;
}

.pd-hero__sub {
  font-size: 1.05rem; color: rgba(255,255,255,.8);
  line-height: 1.7; max-width: 680px;
  margin-bottom: 2rem;
}

.pd-hero__actions { display: flex; flex-wrap: wrap; gap: .85rem; }

/* ── Status pill ───────────────────────────── */
.pd-status-pill {
  display: inline-flex; align-items: center; gap: .4rem;
  font-size: .72rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .8px;
  padding: .3rem .9rem; border-radius: 50px;
}
.pd-status-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
.s--active      { background: #ecfdf5; color: #065f46; }
.s--active .pd-status-dot { background: #10b981; }
.s--development { background: #ede9fe; color: #4c1d95; }
.s--development .pd-status-dot { background: #8b5cf6; }
.s--planning    { background: #fffbeb; color: #78350f; }
.s--planning .pd-status-dot { background: #f59e0b; }
.s--paused      { background: #f9fafb; color: #374151; }
.s--paused .pd-status-dot { background: #9ca3af; }

.pd-group-pill {
  display: inline-flex; align-items: center;
  background: rgba(255,255,255,.18);
  color: #fff; font-size: .78rem; font-weight: 600;
  padding: .3rem .9rem; border-radius: 50px;
  border: 1px solid rgba(255,255,255,.3);
}

/* ── Buttons ───────────────────────────────── */
.pd-btn-primary {
  display: inline-flex; align-items: center;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff !important; font-weight: 700; font-size: .95rem;
  padding: .8rem 2rem; border-radius: 50px;
  text-decoration: none;
  transition: transform .25s, box-shadow .25s;
}
.pd-btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(102,126,234,.5);
}
.pd-btn-outline {
  display: inline-flex; align-items: center;
  background: transparent; color: #fff !important;
  font-weight: 600; font-size: .95rem;
  padding: .8rem 2rem; border-radius: 50px;
  border: 2px solid rgba(255,255,255,.45);
  text-decoration: none;
  transition: border-color .25s, background .25s;
}
.pd-btn-outline:hover { border-color: #fff; background: rgba(255,255,255,.1); }

.pd-btn-back {
  display: inline-flex; align-items: center;
  color: #6366f1; font-weight: 600;
  text-decoration: none; gap: .4rem;
}

/* ── Body ──────────────────────────────────── */
.pd-body { padding: 3.5rem 0 5rem; }

.pd-grid {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 2rem;
  align-items: start;
}

/* ── Card ──────────────────────────────────── */
.pd-card {
  background: #fff;
  border-radius: 20px;
  border: 1px solid #e8eeff;
  padding: 2rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 2px 16px rgba(99,102,241,.06);
}
.pd-card__title {
  font-size: 1.1rem; font-weight: 700;
  color: #1e1b4b; margin-bottom: 1.25rem;
  display: flex; align-items: center;
}

/* ── Features list ─────────────────────────── */
.pd-features { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .75rem; }
.pd-feature-item {
  display: flex; align-items: flex-start; gap: .75rem;
  font-size: .95rem; color: #374151; line-height: 1.5;
}
.pd-feature-icon {
  color: #10b981; font-size: .8rem; margin-top: .25rem; flex-shrink: 0;
}

/* ── Screenshot ────────────────────────────── */
.pd-screenshot {
  width: 100%; border-radius: 12px;
  border: 1px solid #e8eeff;
}

/* ── Description ───────────────────────────── */
.pd-desc-full {
  font-size: .95rem; color: #64748b;
  line-height: 1.8; margin: 0;
}

/* ── Sidebar stats ─────────────────────────── */
.pd-stats { display: flex; flex-direction: column; gap: 1rem; }
.pd-stat { display: flex; align-items: center; justify-content: space-between; gap: .5rem; }
.pd-stat__label { font-size: .8rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; }
.pd-stat__value { font-size: .95rem; font-weight: 700; color: #1e1b4b; }
.pd-stat__value--highlight { color: #6366f1; }

/* ── Badge list ────────────────────────────── */
.pd-badge-list { display: flex; flex-wrap: wrap; gap: .4rem; }
.pd-badge {
  font-size: .72rem; font-weight: 600;
  background: #f5f3ff; color: #6d28d9;
  padding: .28rem .75rem; border-radius: 50px;
  border: 1px solid #ede9fe;
}

/* ── CTA card ──────────────────────────────── */
.pd-cta-card {
  background: linear-gradient(135deg, #667eea, #764ba2);
  border-radius: 20px; padding: 2rem;
  color: #fff; text-align: center;
}
.pd-cta-card h4 { font-size: 1.15rem; font-weight: 800; margin-bottom: .5rem; }
.pd-cta-card p  { font-size: .875rem; opacity: .85; margin-bottom: 1.5rem; }
.pd-cta-card .pd-btn-primary {
  background: #fff;
  color: #6366f1 !important;
}
.pd-cta-card .pd-btn-primary:hover {
  box-shadow: 0 8px 24px rgba(0,0,0,.2);
}
.w-100 { width: 100%; }

/* ── Responsive ────────────────────────────── */
@media (max-width: 991px) {
  .pd-grid { grid-template-columns: 1fr; }
  .pd-sidebar { order: -1; }
  .pd-stats { flex-direction: row; flex-wrap: wrap; }
  .pd-stat { flex: 1 1 45%; border: 1px solid #e8eeff; border-radius: 12px; padding: .75rem 1rem; flex-direction: column; align-items: flex-start; }
}
@media (max-width: 576px) {
  .pd-hero { padding: 5.5rem 0 3.5rem; }
  .pd-hero__title { font-size: 1.75rem; }
}
</style>
