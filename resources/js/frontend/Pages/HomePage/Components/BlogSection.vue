<template>
  <section id="blog" class="blog-section section-pad">
    <div class="container">
      <div class="section-head text-center">
        <span class="section-tag">Latest Insights</span>
        <h2 class="section-title">From Our Blog</h2>
        <p class="section-sub">Thoughts on software, technology, and building great products.</p>
      </div>

      <div class="row g-4">
        <div v-for="post in items" :key="post.id" class="col-md-6 col-lg-4">
          <article class="blog-card">
            <div class="blog-card__thumb">
              <img v-if="post.thumbnail" :src="post.thumbnail" :alt="post.title" class="blog-card__img" />
              <div v-else class="blog-card__no-img"><i class="fas fa-newspaper"></i></div>
              <span class="blog-card__cat">{{ post.status === 'published' ? 'Published' : post.status }}</span>
            </div>
            <div class="blog-card__body">
              <div class="blog-card__meta">
                <span><i class="fas fa-calendar me-1"></i>{{ formatDate(post.published_at || post.created_at) }}</span>
              </div>
              <h4 class="blog-card__title">{{ post.title }}</h4>
              <p class="blog-card__excerpt">{{ truncate(post.excerpt || post.body, 120) }}</p>
              <div class="blog-card__footer">
                <a v-if="post.slug" :href="'/blog/' + post.slug" class="blog-read-more">
                  Read More <i class="fas fa-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
const FALLBACK = [
  {
    id:1, title:'How We Build Scalable Laravel APIs',
    excerpt:'A deep dive into our API architecture — rate limiting, versioning, and response caching strategies that power our SaaS products.',
    slug:'how-we-build-scalable-laravel-apis', status:'published', published_at:'2025-05-10',
  },
  {
    id:2, title:'Vue 3 Composition API: Lessons from Production',
    excerpt:'After migrating three enterprise apps to Vue 3, here are the patterns we rely on and the pitfalls we learned the hard way.',
    slug:'vue3-composition-api-lessons', status:'published', published_at:'2025-04-22',
  },
  {
    id:3, title:'Designing for Non-English Users: Our UX Journey',
    excerpt:'Building software for Bangladesh taught us that RTL support, local date formats, and font choices matter more than you think.',
    slug:'designing-for-non-english-users', status:'published', published_at:'2025-03-18',
  },
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
.blog-section { background: #f8f9ff; }

.blog-card {
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(102,126,234,.08);
  border: 1px solid rgba(102,126,234,.1);
  transition: all .35s;
  height: 100%;
  display: flex; flex-direction: column;
}
.blog-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(102,126,234,.2); border-color: #667eea; }

.blog-card__thumb {
  position: relative; height: 200px;
  background: linear-gradient(135deg, #eef2ff, #f5f3ff);
  overflow: hidden;
}
.blog-card__img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.blog-card:hover .blog-card__img { transform: scale(1.05); }
.blog-card__no-img { height: 100%; display: flex; align-items: center; justify-content: center; font-size: 4rem; color: #c7d2fe; }
.blog-card__cat {
  position: absolute; top: 1rem; left: 1rem;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff; font-size: .7rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1px;
  padding: .3rem .9rem; border-radius: 50px;
}
.blog-card__body { padding: 1.5rem; display: flex; flex-direction: column; flex: 1; }
.blog-card__meta { font-size: .8rem; color: #9ca3af; margin-bottom: .75rem; }
.blog-card__title { font-weight: 700; font-size: 1rem; color: #1a1a3e; margin-bottom: .6rem; line-height: 1.5; }
.blog-card__excerpt { font-size: .875rem; color: #6b7280; line-height: 1.7; flex: 1; margin-bottom: 1rem; }
.blog-card__footer { margin-top: auto; }
.blog-read-more {
  color: #667eea; font-weight: 700; font-size: .875rem;
  text-decoration: none; display: inline-flex; align-items: center;
  transition: gap .25s;
}
.blog-read-more:hover { color: #764ba2; gap: .5rem; }

.blog-skeleton {
  height: 360px; border-radius: 20px;
  background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
</style>
