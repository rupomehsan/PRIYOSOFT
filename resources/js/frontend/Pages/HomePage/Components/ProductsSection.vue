<template>
  <section id="products" class="products-section section-pad section-dark">
    <div class="container">

      <div class="section-head text-center">
        <span class="section-tag">What We Build</span>
        <h2 class="section-title">Our <span class="gradient-text">Products</span> &amp; Solutions</h2>
        <p class="section-sub">Innovative software products engineered to solve real business challenges at any scale.</p>
      </div>

      <div class="products-grid">
        <a v-for="product in items" :key="product.id"
           :href="'/products/' + product.slug"
           class="product-card">

          <!-- Thumbnail banner -->
          <div class="product-card__banner" :style="{ background: accentColor(product.project_status) }">
            <img v-if="imgSrc(product)" :src="imgSrc(product)" :alt="product.name" class="product-card__banner-img" />
            <div class="product-card__banner-overlay"></div>
            <span class="product-card__status" :class="'status--' + (product.project_status || 'active')">
              <span class="status-dot"></span>{{ statusLabel(product.project_status) }}
            </span>
          </div>

          <div class="product-card__body">
            <h4 class="product-card__name">{{ product.name }}</h4>
            <p class="product-card__desc">{{ truncate(product.description, 100) }}</p>
            <div v-if="product.features" class="product-card__features">
              <span v-for="(f, i) in parseFeatures(product.features)" :key="i" class="feature-tag">
                <i class="fas fa-check me-1"></i>{{ f }}
              </span>
            </div>
          </div>

          <div class="product-card__footer">
            <span class="product-card__more">
              Learn more <i class="fas fa-arrow-right ms-1"></i>
            </span>
          </div>
        </a>
      </div>

      <div class="products-footer">
        <a href="/products" class="see-more-btn">
          View All Products <i class="fas fa-arrow-right ms-2"></i>
        </a>
      </div>

    </div>
  </section>
</template>

<script>
const FALLBACK = [
  { id:1, name:'PriyoERP',       slug:'priyoerp',       description:'Full-featured ERP for SMEs — inventory, HR, accounting, and CRM unified in one powerful platform.',      project_status:'active',       features:'["Multi-branch","Real-time reports","Role-based access"]' },
  { id:2, name:'PriyoPOS',       slug:'priyopos',       description:'Modern point-of-sale with cloud sync, offline mode, and integrated payment gateways for retail.',          project_status:'active',       features:'["Offline mode","Cloud sync","Barcode scanner"]' },
  { id:3, name:'PriyoHRM',       slug:'priyohrm',       description:'Human resource management — payroll, leave, attendance, and employee self-service in one system.',          project_status:'active',       features:'["Payroll","Leave management","Attendance"]' },
  { id:4, name:'PriyoShop',      slug:'priyoshop',      description:'Headless e-commerce platform built for speed — PWA storefront, multi-vendor, and smart inventory.',        project_status:'development',  features:'["Multi-vendor","PWA","Smart inventory"]' },
  { id:5, name:'PriyoCMS',       slug:'priyocms',       description:'Developer-first CMS with visual editor, REST & GraphQL APIs, and multi-site publishing workflows.',         project_status:'development',  features:'["Visual editor","REST API","GraphQL"]' },
  { id:6, name:'PriyoAnalytics', slug:'priyoanalytics', description:'Business intelligence dashboard — real-time KPIs, custom reports, and data visualisation for leaders.',     project_status:'planning',     features:'["Real-time KPIs","Custom reports","Data viz"]' },
];

const ACCENT = {
  active:      'linear-gradient(135deg, #0f766e, #0891b2)',
  development: 'linear-gradient(135deg, #4f46e5, #7c3aed)',
  planning:    'linear-gradient(135deg, #d97706, #ea580c)',
  paused:      'linear-gradient(135deg, #475569, #64748b)',
};

export default {
  name: 'ProductsSection',
  props: { data: { type: Array, default: () => [] } },
  computed: {
    items() { return this.data.length ? this.data.slice(0, 6) : FALLBACK; },
  },
  methods: {
    truncate(str, n) {
      if (!str) return '';
      return str.length > n ? str.slice(0, n) + '…' : str;
    },
    statusLabel(s) {
      return { active:'Live', development:'In Dev', planning:'Planned', paused:'Paused' }[s] || 'Active';
    },
    accentColor(s) { return ACCENT[s] || ACCENT.active; },
    imgSrc(p) {
      const img = p.thumbnail || p.screenshots;
      if (!img) return '/default.png';
      let src = img;
      if (typeof img === 'string' && img.startsWith('[')) {
        try { const arr = JSON.parse(img); src = Array.isArray(arr) ? arr[0] : img; }
        catch { src = img; }
      }
      if (!src || src === 'default.png') return '/default.png';
      return src.startsWith('http') ? src : '/' + src;
    },
    parseFeatures(f) {
      if (!f) return [];
      try {
        const arr = typeof f === 'string' ? JSON.parse(f) : f;
        return Array.isArray(arr) ? arr.slice(0, 3) : [];
      } catch { return []; }
    },
  },
};
</script>

<style scoped>
.products-section { background: var(--ps-bg-3); }

.products-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.75rem;
}

/* Card */
.product-card {
  background: var(--ps-card-bg);
  border-radius: 20px;
  border: 1px solid var(--ps-card-border);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  text-decoration: none;
  transition: transform .3s, box-shadow .3s, border-color .3s;
}
.product-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 24px 60px rgba(99,102,241,.18);
  border-color: var(--ps-card-hover-border);
}

/* Banner */
.product-card__banner {
  width: 100%;
  height: 190px;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
}
.product-card__banner-img {
  width: 100%; height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .4s;
}
.product-card:hover .product-card__banner-img { transform: scale(1.05); }
.product-card__banner-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,.45));
  pointer-events: none;
}

/* Status pill */
.product-card__status {
  position: absolute;
  top: .75rem; right: .75rem;
  display: inline-flex; align-items: center; gap: .35rem;
  font-size: .68rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .7px;
  padding: .28rem .8rem; border-radius: 50px;
  backdrop-filter: blur(6px);
}
.status-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
.status--active      { background: rgba(16,185,129,.2);  color: #6ee7b7; }
.status--active .status-dot { background: #10b981; }
.status--development { background: rgba(139,92,246,.2);  color: #c4b5fd; }
.status--development .status-dot { background: #8b5cf6; }
.status--planning    { background: rgba(245,158,11,.2);  color: #fcd34d; }
.status--planning .status-dot { background: #f59e0b; }
.status--paused      { background: rgba(148,163,184,.15); color: #94a3b8; }
.status--paused .status-dot { background: #64748b; }

/* Body */
.product-card__body { padding: 1.1rem 1.5rem .75rem; flex: 1; }
.product-card__name {
  font-weight: 800; font-size: 1.1rem;
  color: var(--ps-text-h); margin-bottom: .4rem;
}
.product-card__desc {
  font-size: .855rem; color: var(--ps-text-faint);
  line-height: 1.65; margin-bottom: .85rem;
}
.product-card__features { display: flex; flex-wrap: wrap; gap: .4rem; }
.feature-tag {
  font-size: .72rem; font-weight: 600;
  background: var(--ps-feat-tag-bg); color: var(--ps-feat-tag-color);
  padding: .22rem .7rem; border-radius: 50px;
  border: 1px solid var(--ps-feat-tag-border);
}

/* Footer */
.product-card__footer {
  padding: .9rem 1.5rem 1.3rem;
  border-top: 1px solid var(--ps-card-border);
}
.product-card__more {
  font-size: .85rem; font-weight: 700;
  color: #818cf8;
  display: inline-flex; align-items: center; gap: .35rem;
  transition: gap .2s, color .2s;
}
.product-card:hover .product-card__more { gap: .65rem; color: var(--ps-feat-tag-color); }

/* See more */
.products-footer { text-align: center; margin-top: 3rem; }
.see-more-btn {
  display: inline-flex; align-items: center;
  background: linear-gradient(135deg,#4f46e5,#7c3aed);
  color: #fff !important; font-weight: 700; font-size: 1rem;
  padding: .9rem 2.5rem; border-radius: 50px; text-decoration: none;
  box-shadow: 0 4px 20px rgba(79,70,229,.3);
  transition: transform .2s, box-shadow .2s;
}
.see-more-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 32px rgba(79,70,229,.4);
}

@media (max-width: 991px) { .products-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 576px)  { .products-grid { grid-template-columns: 1fr; } }
</style>
