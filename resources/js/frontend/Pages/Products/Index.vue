<template>
  <div class="pl-page">

    <!-- Hero -->
    <section class="pl-hero">
      <div class="container pl-hero__inner">
        <nav class="pl-breadcrumb">
          <a href="/">Home</a>
          <i class="fas fa-chevron-right"></i>
          <span>Products</span>
        </nav>
        <h1 class="pl-hero__title">Our <span class="pl-grad">Products</span> &amp; Solutions</h1>
        <p class="pl-hero__sub">Production-ready software products built with Laravel &amp; Vue.js for businesses across Bangladesh and beyond.</p>

        <!-- Filters -->
        <div class="pl-filters">
          <button
            v-for="f in filters" :key="f.key"
            class="pl-filter-btn"
            :class="{ active: activeFilter === f.key }"
            @click="activeFilter = f.key"
          >
            {{ f.label }}
            <span class="pl-filter-btn__count">{{ countFor(f.key) }}</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Grid -->
    <section class="pl-body">
      <div class="container">

        <div v-if="loading" class="pl-loading">
          <div v-for="n in 6" :key="n" class="pl-skeleton"></div>
        </div>

        <div v-else-if="!filtered.length" class="pl-empty">
          <i class="fas fa-box-open"></i>
          <p>No products found.</p>
        </div>

        <div v-else class="pl-grid">
          <a
            v-for="p in filtered" :key="p.id"
            :href="'/products/' + p.slug"
            class="pl-card"
          >
            <!-- Thumbnail banner -->
            <div class="pl-card__banner" :style="{ background: accentFor(p.project_status) }">
              <img v-if="imgSrc(p)" :src="imgSrc(p)" :alt="p.name" class="pl-card__banner-img" />
              <div class="pl-card__banner-overlay"></div>
              <span class="pl-card__status" :class="'st--' + (p.project_status || 'active')">
                <span class="pl-dot"></span>{{ statusLabel(p.project_status) }}
              </span>
            </div>

            <div class="pl-card__body">
              <h3 class="pl-card__name">{{ p.name }}</h3>
              <p class="pl-card__desc">{{ trunc(p.description, 110) }}</p>
              <div v-if="feats(p.features).length" class="pl-card__tags">
                <span v-for="(f, i) in feats(p.features)" :key="i" class="pl-tag">{{ f }}</span>
              </div>
            </div>

            <div class="pl-card__foot">
              <div class="pl-card__price" v-if="p.sales_price || p.regular_price">
                <span v-if="p.sales_price" class="pl-price-sale">৳{{ fmt(p.sales_price) }}</span>
                <span v-else class="pl-price-reg">৳{{ fmt(p.regular_price) }}</span>
                <span v-if="p.sales_price && p.regular_price" class="pl-price-original">৳{{ fmt(p.regular_price) }}</span>
              </div>
              <span v-else class="pl-price-tbd">Custom Pricing</span>
              <span class="pl-card__arrow"><i class="fas fa-arrow-right"></i></span>
            </div>
          </a>
        </div>

      </div>
    </section>

  </div>
</template>

<script>
const ACCENT = {
  active:      'linear-gradient(135deg,#0f766e,#0891b2)',
  development: 'linear-gradient(135deg,#4f46e5,#7c3aed)',
  planning:    'linear-gradient(135deg,#d97706,#ea580c)',
  paused:      'linear-gradient(135deg,#475569,#64748b)',
};
const STATUS_LABELS = { active:'Live', development:'In Dev', planning:'Upcoming', paused:'Paused' };
const FILTERS = [
  { key: 'all',         label: 'All Products' },
  { key: 'active',      label: 'Live'         },
  { key: 'development', label: 'In Dev'       },
  { key: 'planning',    label: 'Upcoming'     },
];

export default {
  name: 'ProductsPage',
  data: () => ({ products: [], loading: true, activeFilter: 'all' }),

  computed: {
    filters() { return FILTERS; },
    filtered() {
      if (this.activeFilter === 'all') return this.products;
      return this.products.filter(p => p.project_status === this.activeFilter);
    },
  },

  methods: {
    countFor(key) {
      if (key === 'all') return this.products.length;
      return this.products.filter(p => p.project_status === key).length;
    },
    statusLabel: s => STATUS_LABELS[s] || s || 'Active',
    accentFor:   s => ACCENT[s]  || ACCENT.active,
    trunc(str, n) { return str && str.length > n ? str.slice(0, n) + '…' : str || ''; },
    fmt: n => n ? new Intl.NumberFormat('en-BD').format(n) : '0',
    feats(f) {
      if (!f) return [];
      try { const a = typeof f === 'string' ? JSON.parse(f) : f; return Array.isArray(a) ? a.slice(0, 3) : []; }
      catch { return []; }
    },
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

    async fetchProducts() {
      this.loading = true;
      try {
        const res = await window.axios.get('public/products', {
          params: {
            get_all: 1,
            limit: 100,
            status: 'active',
            fields: ['id','name','slug','status','project_status','description','features','regular_price','sales_price','thumbnail','screenshots','product_group_id'],
          }
        });
        const raw = res?.data?.data ?? [];
        this.products = Array.isArray(raw) ? raw : [];
      } catch { this.products = []; }
      finally { this.loading = false; }
    },
  },

  mounted() { this.fetchProducts(); },
};
</script>

<style scoped>
.pl-page { min-height: 100vh; background: #f4f6fb; }

/* ── Hero ── */
.pl-hero {
  background: linear-gradient(140deg,#0f0c29,#302b63,#24243e);
  padding: 5rem 0 3.5rem;
}
.pl-hero__inner { position: relative; }
.pl-breadcrumb {
  display: flex; align-items: center; gap: .5rem;
  font-size: .8rem; margin-bottom: 2rem;
}
.pl-breadcrumb a { color: rgba(255,255,255,.5); text-decoration: none; }
.pl-breadcrumb a:hover { color: #fff; }
.pl-breadcrumb i { color: rgba(255,255,255,.25); font-size: .6rem; }
.pl-breadcrumb span { color: rgba(255,255,255,.7); }
.pl-hero__title {
  font-size: clamp(2rem,4vw,3rem); font-weight: 900; color: #fff;
  margin-bottom: 1rem; letter-spacing: -.5px;
}
.pl-grad {
  background: linear-gradient(90deg,#818cf8,#c4b5fd);
  -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
}
.pl-hero__sub { font-size: 1rem; color: rgba(255,255,255,.65); max-width: 580px; line-height: 1.7; margin-bottom: 2.25rem; }

/* Filters */
.pl-filters { display: flex; flex-wrap: wrap; gap: .6rem; }
.pl-filter-btn {
  display: inline-flex; align-items: center; gap: .5rem;
  background: rgba(255,255,255,.1); color: rgba(255,255,255,.7);
  border: 1.5px solid rgba(255,255,255,.15); border-radius: 50px;
  padding: .45rem 1.1rem; font-size: .82rem; font-weight: 600;
  cursor: pointer; transition: all .2s;
}
.pl-filter-btn:hover { background: rgba(255,255,255,.18); color: #fff; }
.pl-filter-btn.active { background: #fff; color: #4f46e5; border-color: #fff; }
.pl-filter-btn__count {
  background: rgba(255,255,255,.2); color: inherit;
  border-radius: 50px; font-size: .7rem; padding: .1rem .5rem; min-width: 20px; text-align: center;
}
.pl-filter-btn.active .pl-filter-btn__count { background: #eef2ff; color: #4f46e5; }

/* ── Body ── */
.pl-body { padding: 3rem 0 5rem; }

/* Loading skeletons */
.pl-loading { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.75rem; }
.pl-skeleton {
  height: 360px; border-radius: 20px;
  background: linear-gradient(90deg,#e5e7eb 25%,#f3f4f6 50%,#e5e7eb 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

/* Empty */
.pl-empty { text-align: center; padding: 4rem 0; color: #9ca3af; }
.pl-empty i { font-size: 3.5rem; margin-bottom: 1rem; display: block; color: #d1d5db; }

/* ── Grid ── */
.pl-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.75rem; }

/* ── Card ── */
.pl-card {
  background: #fff; border-radius: 20px; border: 1px solid #e8eeff;
  display: flex; flex-direction: column; overflow: hidden;
  text-decoration: none;
  transition: transform .25s, box-shadow .25s, border-color .25s;
}
.pl-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 50px rgba(99,102,241,.14);
  border-color: #c7d2fe;
}

/* Banner */
.pl-card__banner {
  width: 100%; height: 190px;
  position: relative; overflow: hidden; flex-shrink: 0;
}
.pl-card__banner-img {
  width: 100%; height: 100%; object-fit: cover; display: block;
  transition: transform .4s;
}
.pl-card:hover .pl-card__banner-img { transform: scale(1.05); }
.pl-card__banner-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,.4));
  pointer-events: none;
}

/* Status pill */
.pl-card__status {
  position: absolute; top: .75rem; right: .75rem;
  display: inline-flex; align-items: center; gap: .35rem;
  font-size: .68rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: .7px; padding: .28rem .8rem; border-radius: 50px;
  backdrop-filter: blur(6px);
}
.pl-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; opacity: .9; }
.st--active      { background: rgba(16,185,129,.2);  color: #6ee7b7; }
.st--development { background: rgba(139,92,246,.2);  color: #c4b5fd; }
.st--planning    { background: rgba(245,158,11,.2);  color: #fcd34d; }
.st--paused      { background: rgba(148,163,184,.15); color: #94a3b8; }

/* Card body */
.pl-card__body { padding: 1.1rem 1.5rem .75rem; flex: 1; }
.pl-card__name { font-size: 1.1rem; font-weight: 800; color: #111827; margin-bottom: .4rem; }
.pl-card__desc { font-size: .855rem; color: #6b7280; line-height: 1.65; margin-bottom: .85rem; }
.pl-card__tags { display: flex; flex-wrap: wrap; gap: .35rem; }
.pl-tag {
  font-size: .7rem; font-weight: 600;
  background: #f5f3ff; color: #6d28d9;
  padding: .22rem .7rem; border-radius: 50px; border: 1px solid #ede9fe;
}

/* Card footer */
.pl-card__foot {
  display: flex; align-items: center; justify-content: space-between;
  padding: .9rem 1.5rem 1.4rem; border-top: 1px solid #f1f5f9;
}
.pl-price-sale { font-size: 1.05rem; font-weight: 900; color: #111827; }
.pl-price-reg  { font-size: 1.05rem; font-weight: 900; color: #111827; }
.pl-price-original { font-size: .8rem; color: #d1d5db; text-decoration: line-through; margin-left: .35rem; }
.pl-price-tbd { font-size: .82rem; font-weight: 600; color: #9ca3af; }
.pl-card__arrow {
  width: 30px; height: 30px; border-radius: 50%;
  background: #eef2ff; color: #4f46e5;
  display: flex; align-items: center; justify-content: center;
  font-size: .75rem;
  transition: background .2s, color .2s, transform .2s;
}
.pl-card:hover .pl-card__arrow { background: #4f46e5; color: #fff; transform: translateX(3px); }

@media (max-width:991px) { .pl-grid,.pl-loading { grid-template-columns: repeat(2,1fr); } }
@media (max-width:576px)  { .pl-grid,.pl-loading { grid-template-columns: 1fr; } }
</style>
