<template>
  <section id="blog" class="blog-section section-pad section-dark">
    <div class="container">
      <div class="section-head text-center">
        <span class="section-tag">Latest Insights</span>
        <h2 class="section-title">From Our <span class="gradient-text">Blog</span></h2>
        <p class="section-sub">Thoughts on software, technology, and building great products.</p>
      </div>

      <div class="blog-grid">
        <!-- Featured post (first) -->
        <article v-if="items[0]" class="blog-card blog-card--featured">
          <div class="blog-card__thumb">
            <img v-if="items[0].thumbnail" :src="items[0].thumbnail" :alt="items[0].title" class="blog-card__img" />
            <div v-else class="blog-card__no-img blog-card__no-img--lg">
              <i class="fas fa-newspaper"></i>
            </div>
            <span class="blog-cat">{{ items[0].status === 'published' ? 'Published' : (items[0].status || 'Article') }}</span>
          </div>
          <div class="blog-card__body">
            <div class="blog-meta">
              <span><i class="fas fa-calendar me-1"></i>{{ formatDate(items[0].published_at || items[0].created_at) }}</span>
            </div>
            <h3 class="blog-title blog-title--lg">{{ items[0].title }}</h3>
            <p class="blog-excerpt">{{ truncate(items[0].excerpt || items[0].body, 180) }}</p>
            <a v-if="items[0].slug" :href="'/blog/' + items[0].slug" class="blog-read-more">
              Read Article <i class="fas fa-arrow-right ms-2"></i>
            </a>
          </div>
        </article>

        <!-- Side posts -->
        <div class="blog-side">
          <article v-for="post in items.slice(1)" :key="post.id" class="blog-card blog-card--sm">
            <div class="blog-card__thumb blog-card__thumb--sm">
              <img v-if="post.thumbnail" :src="post.thumbnail" :alt="post.title" class="blog-card__img" />
              <div v-else class="blog-card__no-img">
                <i class="fas fa-newspaper"></i>
              </div>
              <span class="blog-cat">{{ post.status === 'published' ? 'Published' : (post.status || 'Article') }}</span>
            </div>
            <div class="blog-card__body">
              <div class="blog-meta">
                <span><i class="fas fa-calendar me-1"></i>{{ formatDate(post.published_at || post.created_at) }}</span>
              </div>
              <h4 class="blog-title">{{ post.title }}</h4>
              <p class="blog-excerpt">{{ truncate(post.excerpt || post.body, 100) }}</p>
              <a v-if="post.slug" :href="'/blog/' + post.slug" class="blog-read-more">
                Read more <i class="fas fa-arrow-right ms-1"></i>
              </a>
            </div>
          </article>
        </div>
      </div>

    </div>
  </section>
</template>

<script>
const FALLBACK = [
  { id:1, title:'How We Build Scalable Laravel APIs', excerpt:'A deep dive into our API architecture — rate limiting, versioning, and response caching strategies that power our SaaS products.', slug:'how-we-build-scalable-laravel-apis', status:'published', published_at:'2025-05-10' },
  { id:2, title:'Vue 3 Composition API: Lessons from Production', excerpt:'After migrating three enterprise apps to Vue 3, here are the patterns we rely on and the pitfalls we learned the hard way.', slug:'vue3-composition-api-lessons', status:'published', published_at:'2025-04-22' },
  { id:3, title:'Designing for Non-English Users: Our UX Journey', excerpt:'Building software for Bangladesh taught us that local date formats, RTL considerations, and font choices matter more than you think.', slug:'designing-for-non-english-users', status:'published', published_at:'2025-03-18' },
];

export default {
  name: 'BlogSection',
  props: { data: { type: Array, default: () => [] } },
  computed: {
    items() { return this.data.length ? this.data.slice(0, 3) : FALLBACK; },
  },
  methods: {
    truncate(str, n) {
      if (!str) return '';
      const plain = str.replace(/<[^>]*>/g, '');
      return plain.length > n ? plain.slice(0, n) + '…' : plain;
    },
    formatDate(d) {
      if (!d) return '';
      try { return new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }); }
      catch { return d; }
    },
  },
};
</script>

<style scoped>
.blog-section { background: var(--ps-bg-1); }

/* Layout grid */
.blog-grid {
  display: grid;
  grid-template-columns: 1fr 400px;
  gap: 1.75rem;
  align-items: start;
}

/* Side column */
.blog-side {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

/* Base card */
.blog-card {
  background: var(--ps-card-bg);
  border: 1px solid var(--ps-card-border);
  border-radius: 20px;
  overflow: hidden;
  transition: transform .3s, box-shadow .3s, border-color .3s;
  display: flex;
  flex-direction: column;
}
.blog-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 50px rgba(99,102,241,.15);
  border-color: rgba(99,102,241,.3);
}

/* Featured card */
.blog-card--featured { height: 100%; }
.blog-card--featured .blog-card__thumb { height: 280px; }

/* Small side card */
.blog-card--sm { flex-direction: row; border-radius: 16px; }
.blog-card--sm .blog-card__thumb--sm {
  width: 130px;
  min-width: 130px;
  height: auto;
}
.blog-card--sm .blog-card__body { padding: 1.25rem; }

/* Thumb */
.blog-card__thumb {
  position: relative;
  background: linear-gradient(135deg, rgba(99,102,241,.12), rgba(139,92,246,.08));
  overflow: hidden;
  flex-shrink: 0;
}
.blog-card__img { width:100%;height:100%;object-fit:cover;transition:transform .4s; }
.blog-card:hover .blog-card__img { transform: scale(1.04); }
.blog-card__no-img {
  width:100%; height: 100%; min-height: 120px;
  display:flex; align-items:center; justify-content:center;
  font-size: 3rem; color: rgba(99,102,241,.35);
}
.blog-card__no-img--lg { min-height: 280px; font-size: 5rem; }

/* Category tag */
.blog-cat {
  position: absolute; top: 1rem; left: 1rem;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  color: #fff; font-size: .68rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1px;
  padding: .3rem .9rem; border-radius: 50px;
}

/* Body */
.blog-card__body {
  padding: 1.75rem;
  display: flex; flex-direction: column; flex: 1;
}

.blog-meta {
  font-size: .78rem; color: #475569;
  margin-bottom: .65rem;
  display: flex; gap: 1rem;
}

.blog-title {
  font-weight: 800; font-size: 1.05rem;
  color: var(--ps-text-h); margin-bottom: .65rem;
  line-height: 1.45;
}
.blog-title--lg { font-size: 1.35rem; }

.blog-excerpt {
  font-size: .875rem; color: var(--ps-text-faint);
  line-height: 1.75; flex: 1;
  margin-bottom: 1.25rem;
}

.blog-read-more {
  color: #818cf8; font-weight: 700; font-size: .85rem;
  text-decoration: none; display: inline-flex; align-items: center;
  transition: color .2s, gap .2s; gap: .3rem; margin-top: auto;
}
.blog-read-more:hover { color: #a5b4fc; gap: .6rem; }

@media (max-width: 991px) {
  .blog-grid { grid-template-columns: 1fr; }
  .blog-card--featured .blog-card__thumb { height: 220px; }
}
@media (max-width: 576px) {
  .blog-card--sm { flex-direction: column; }
  .blog-card--sm .blog-card__thumb--sm { width: 100%; height: 160px; }
}
</style>
