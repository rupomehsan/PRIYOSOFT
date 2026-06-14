<template>
  <section id="products" class="products-section section-pad">
    <div class="container">
      <div class="section-head text-center">
        <span class="section-tag">What We Build</span>
        <h2 class="section-title">Our Products & Solutions</h2>
        <p class="section-sub">Innovative software products designed to solve real business challenges.</p>
      </div>

      <div class="row g-4">
        <div v-for="product in items" :key="product.id" class="col-md-6 col-lg-4">
          <div class="product-card">
            <div class="product-card__thumb">
              <img v-if="product.thumbnail || product.image" :src="product.thumbnail || product.image" :alt="product.name" class="product-card__img" />
              <div v-else class="product-card__no-img">
                <i class="fas fa-cubes"></i>
              </div>
              <span class="product-card__status" :class="'status--' + (product.status || 'active')">
                {{ statusLabel(product.status) }}
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
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
const FALLBACK = [
  { id:1, name:'PriyoERP', description:'Full-featured ERP system for SMEs — inventory, HR, accounting, and CRM in one platform.', status:'active',  features:'["Multi-branch","Real-time reports","Role-based access"]' },
  { id:2, name:'PriyoPOS', description:'Modern point-of-sale solution with cloud sync, offline mode, and integrated payment gateways.', status:'active',  features:'["Offline mode","Cloud sync","Barcode scanner"]' },
  { id:3, name:'PriyoHRM', description:'Human resource management system — payroll, leave, attendance, and employee self-service portal.', status:'active',  features:'["Payroll","Leave management","Attendance"]' },
  { id:4, name:'PriyoShop', description:'Headless e-commerce platform built for speed — PWA storefront, multi-vendor, and smart inventory.', status:'development', features:'["Multi-vendor","PWA","Smart inventory"]' },
  { id:5, name:'PriyoCMS', description:'Developer-first content management system with visual editor, REST & GraphQL APIs.', status:'development', features:'["Visual editor","REST API","GraphQL"]' },
  { id:6, name:'PriyoAnalytics', description:'Business intelligence dashboard — real-time KPIs, custom reports, and data visualisation.', status:'planning', features:'["Real-time KPIs","Custom reports","Data viz"]' },
];

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
      const map = { active:'Live', development:'In Dev', planning:'Planned', paused:'Paused' };
      return map[s] || s || 'Active';
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
.products-section { background: #f8f9ff; }

.product-card {
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 24px rgba(102,126,234,.08);
  border: 1px solid rgba(102,126,234,.1);
  transition: all .35s cubic-bezier(.4,0,.2,1);
  height: 100%;
}
.product-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 50px rgba(102,126,234,.2);
  border-color: #667eea;
}
.product-card__thumb {
  position: relative;
  height: 200px;
  background: linear-gradient(135deg, #667eea22, #764ba222);
  overflow: hidden;
}
.product-card__img { width: 100%; height: 100%; object-fit: cover; }
.product-card__no-img {
  height: 100%;
  display: flex; align-items: center; justify-content: center;
  font-size: 4rem; color: #667eea44;
}
.product-card__status {
  position: absolute; top: 1rem; right: 1rem;
  font-size: .7rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 1px; padding: .3rem .8rem; border-radius: 50px;
}
.status--active     { background: #d1fae5; color: #065f46; }
.status--development{ background: #dbeafe; color: #1e40af; }
.status--planning   { background: #fef3c7; color: #92400e; }
.status--paused     { background: #fee2e2; color: #991b1b; }

.product-card__body { padding: 1.5rem; }
.product-card__name { font-weight: 700; font-size: 1.15rem; color: #1a1a3e; margin-bottom: .5rem; }
.product-card__desc { font-size: .9rem; color: #6b7280; margin-bottom: 1rem; line-height: 1.6; }
.product-card__features { display: flex; flex-wrap: wrap; gap: .4rem; }
.feature-tag {
  font-size: .75rem; font-weight: 600;
  background: #eef2ff; color: #4338ca;
  padding: .25rem .7rem; border-radius: 50px;
}

.product-skeleton {
  height: 340px; border-radius: 20px;
  background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
</style>
