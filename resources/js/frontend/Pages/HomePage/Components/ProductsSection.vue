<template>
  <section id="products" class="products-section section-pad">
    <div class="container">

      <div class="section-head text-center">
        <span class="section-tag">What We Build</span>
        <h2 class="section-title">Our <span class="gradient-text">Products</span> &amp; Solutions</h2>
        <p class="section-sub">Innovative software products engineered to solve real business challenges at any scale.</p>
      </div>

      <div class="products-grid">
        <div v-for="product in items" :key="product.id" class="product-card">
          <div class="product-card__accent" :style="{ background: accentColor(product.status) }"></div>
          <div class="product-card__head">
            <div class="product-card__icon-wrap">
              <img v-if="product.thumbnail || product.image"
                   :src="product.thumbnail || product.image"
                   :alt="product.name" class="product-card__img" />
              <i v-else class="fas fa-cubes product-card__icon-fallback"></i>
            </div>
            <span class="product-card__status" :class="'status--' + (product.status || 'active')">
              <span class="status-dot"></span>{{ statusLabel(product.status) }}
            </span>
          </div>
          <div class="product-card__body">
            <h4 class="product-card__name">{{ product.name }}</h4>
            <p class="product-card__desc">{{ truncate(product.description, 110) }}</p>
            <div v-if="product.features" class="product-card__features">
              <span v-for="(f, i) in parseFeatures(product.features)" :key="i" class="feature-tag">
                <i class="fas fa-check me-1"></i>{{ f }}
              </span>
            </div>
          </div>
          <div class="product-card__footer">
            <a :href="'/products/' + product.slug" class="product-card__more">
              Learn more <i class="fas fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script>
const FALLBACK = [
  { id:1, name:'PriyoERP',       description:'Full-featured ERP for SMEs — inventory, HR, accounting, and CRM unified in one powerful platform.',      status:'active',       features:'["Multi-branch","Real-time reports","Role-based access"]' },
  { id:2, name:'PriyoPOS',       description:'Modern point-of-sale with cloud sync, offline mode, and integrated payment gateways for retail.',          status:'active',       features:'["Offline mode","Cloud sync","Barcode scanner"]' },
  { id:3, name:'PriyoHRM',       description:'Human resource management — payroll, leave, attendance, and employee self-service in one system.',          status:'active',       features:'["Payroll","Leave management","Attendance"]' },
  { id:4, name:'PriyoShop',      description:'Headless e-commerce platform built for speed — PWA storefront, multi-vendor, and smart inventory.',        status:'development',  features:'["Multi-vendor","PWA","Smart inventory"]' },
  { id:5, name:'PriyoCMS',       description:'Developer-first CMS with visual editor, REST & GraphQL APIs, and multi-site publishing workflows.',         status:'development',  features:'["Visual editor","REST API","GraphQL"]' },
  { id:6, name:'PriyoAnalytics', description:'Business intelligence dashboard — real-time KPIs, custom reports, and data visualisation for leaders.',     status:'planning',     features:'["Real-time KPIs","Custom reports","Data viz"]' },
];

const ACCENT = {
  active:      'linear-gradient(90deg, #10b981, #06b6d4)',
  development: 'linear-gradient(90deg, #6366f1, #8b5cf6)',
  planning:    'linear-gradient(90deg, #f59e0b, #f97316)',
  paused:      'linear-gradient(90deg, #6b7280, #9ca3af)',
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
      return { active:'Live', development:'In Dev', planning:'Planned', paused:'Paused' }[s] || s || 'Active';
    },
    accentColor(s) { return ACCENT[s] || ACCENT.active; },
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
.products-section { background: #fafbff; }

.products-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.75rem;
}

/* Card */
.product-card {
  background: #fff;
  border-radius: 20px;
  border: 1px solid #e8eeff;
  display: flex;
  flex-direction: column;
  position: relative;
  overflow: hidden;
  transition: transform .3s, box-shadow .3s, border-color .3s;
}
.product-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 24px 60px rgba(99,102,241,.14);
  border-color: #c7d2fe;
}

/* Top accent bar */
.product-card__accent {
  height: 4px;
  width: 100%;
}

/* Head */
.product-card__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.5rem 1.5rem .75rem;
}
.product-card__icon-wrap {
  width: 56px; height: 56px;
  border-radius: 14px;
  background: linear-gradient(135deg, #eef2ff, #f5f3ff);
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
  flex-shrink: 0;
}
.product-card__img { width: 100%; height: 100%; object-fit: cover; }
.product-card__icon-fallback { font-size: 1.6rem; color: #8b5cf6; }

/* Status pill */
.product-card__status {
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  font-size: .7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .8px;
  padding: .3rem .85rem;
  border-radius: 50px;
}
.status-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  display: inline-block;
}
.status--active     { background: #ecfdf5; color: #065f46; }
.status--active .status-dot { background: #10b981; }
.status--development{ background: #ede9fe; color: #4c1d95; }
.status--development .status-dot { background: #8b5cf6; }
.status--planning   { background: #fffbeb; color: #78350f; }
.status--planning .status-dot { background: #f59e0b; }
.status--paused     { background: #f9fafb; color: #374151; }
.status--paused .status-dot { background: #9ca3af; }

/* Body */
.product-card__body { padding: .5rem 1.5rem 1rem; flex: 1; }
.product-card__name {
  font-weight: 800; font-size: 1.15rem;
  color: #0f172a; margin-bottom: .5rem;
}
.product-card__desc {
  font-size: .875rem; color: #64748b;
  line-height: 1.65; margin-bottom: 1rem;
}
.product-card__features { display: flex; flex-wrap: wrap; gap: .4rem; }
.feature-tag {
  font-size: .72rem; font-weight: 600;
  background: #f5f3ff; color: #6d28d9;
  padding: .25rem .75rem; border-radius: 50px;
  border: 1px solid #ede9fe;
}

/* Footer */
.product-card__footer {
  padding: 1rem 1.5rem 1.5rem;
  border-top: 1px solid #f1f5f9;
}
.product-card__more {
  font-size: .85rem; font-weight: 700;
  color: #6366f1; cursor: pointer;
  transition: gap .2s;
  display: inline-flex; align-items: center; gap: .35rem;
}
.product-card:hover .product-card__more { gap: .65rem; }

@media (max-width: 991px) { .products-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 576px)  { .products-grid { grid-template-columns: 1fr; } }
</style>
