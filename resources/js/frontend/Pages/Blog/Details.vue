<template>
  <div class="bd-page">

    <!-- Loading -->
    <div v-if="loading" class="bd-loading">
      <div class="bd-spinner"></div>
    </div>

    <!-- Not found -->
    <div v-else-if="!post" class="bd-notfound">
      <div class="bd-notfound__inner">
        <span class="bd-notfound__code">404</span>
        <h2>Article Not Found</h2>
        <p>The article you're looking for doesn't exist or has been removed.</p>
        <a href="/blog" class="bd-btn bd-btn--primary">← Back to Blog</a>
      </div>
    </div>

    <!-- Post -->
    <template v-else>

      <!-- ── Hero ── -->
      <section class="bd-hero">
        <div class="bd-hero__bg">
          <img :src="thumbSrc(post.thumbnail)" :alt="post.title" class="bd-hero__bg-img" />
          <div class="bd-hero__mask"></div>
        </div>
        <div class="container bd-hero__inner">
          <nav class="bd-breadcrumb">
            <a href="/" class="bd-bc-link">Home</a>
            <i class="fas fa-chevron-right bd-bc-sep"></i>
            <a href="/blog" class="bd-bc-link">Blog</a>
            <i class="fas fa-chevron-right bd-bc-sep"></i>
            <span class="bd-bc-cur">{{ post.title }}</span>
          </nav>

          <span class="bd-cat">Article</span>

          <h1 class="bd-hero__title">{{ post.title }}</h1>

          <div class="bd-hero__meta">
            <span v-if="post.authorId" class="bd-meta-item">
              <i class="fas fa-user-circle"></i> {{ post.authorId.name }}
            </span>
            <span class="bd-meta-item">
              <i class="fas fa-calendar-alt"></i> {{ fmtDate(post.published_at || post.created_at) }}
            </span>
            <span v-if="readTime" class="bd-meta-item">
              <i class="fas fa-clock"></i> {{ readTime }} min read
            </span>
          </div>
        </div>
      </section>

      <!-- ── Content ── -->
      <section class="bd-content-wrap">
        <div class="container bd-layout">

          <!-- Article -->
          <article class="bd-article">

            <!-- Excerpt -->
            <p v-if="post.excerpt" class="bd-excerpt">{{ post.excerpt }}</p>

            <!-- Body -->
            <div class="bd-prose" v-html="post.body"></div>

            <!-- Product link -->
            <div v-if="post.productId" class="bd-product-link">
              <div class="bd-product-link__inner">
                <div>
                  <p class="bd-product-link__label">Related Product</p>
                  <p class="bd-product-link__name">{{ post.productId.name }}</p>
                </div>
                <a :href="'/products/' + post.productId.slug" class="bd-product-link__btn">
                  View Product <i class="fas fa-arrow-right ms-1"></i>
                </a>
              </div>
            </div>

            <!-- Back -->
            <div class="bd-back-wrap">
              <a href="/blog" class="bd-back-btn">
                <i class="fas fa-arrow-left me-2"></i> Back to Blog
              </a>
            </div>

          </article>

          <!-- Sidebar -->
          <aside class="bd-sidebar">

            <!-- About author -->
            <div v-if="post.authorId" class="bd-widget">
              <h5 class="bd-widget__title">About the Author</h5>
              <div class="bd-author">
                <img :src="post.authorId.avatar || post.authorId.image || '/avatar.png'"
                     :alt="post.authorId.name" class="bd-author__img" />
                <div>
                  <p class="bd-author__name">{{ post.authorId.name }}</p>
                  <p class="bd-author__role">{{ post.authorId.designation || 'Author' }}</p>
                </div>
              </div>
            </div>

            <!-- Related posts -->
            <div v-if="related.length" class="bd-widget">
              <h5 class="bd-widget__title">Related Articles</h5>
              <div class="bd-related">
                <a v-for="r in related" :key="r.id"
                   :href="'/blog/' + r.slug" class="bd-related-card">
                  <img :src="thumbSrc(r.thumbnail)" :alt="r.title" class="bd-related-card__img" />
                  <div class="bd-related-card__info">
                    <p class="bd-related-card__title">{{ r.title }}</p>
                    <p class="bd-related-card__date">{{ fmtDate(r.published_at || r.created_at) }}</p>
                  </div>
                </a>
              </div>
            </div>

            <!-- Share -->
            <div class="bd-widget">
              <h5 class="bd-widget__title">Share Article</h5>
              <div class="bd-share">
                <a :href="fbShare" target="_blank" rel="noopener" class="bd-share-btn bd-share-btn--fb">
                  <i class="fab fa-facebook-f"></i>
                </a>
                <a :href="twShare" target="_blank" rel="noopener" class="bd-share-btn bd-share-btn--tw">
                  <i class="fab fa-twitter"></i>
                </a>
                <a :href="waShare" target="_blank" rel="noopener" class="bd-share-btn bd-share-btn--wa">
                  <i class="fab fa-whatsapp"></i>
                </a>
                <button class="bd-share-btn bd-share-btn--copy" @click="copyLink" :title="copied ? 'Copied!' : 'Copy link'">
                  <i :class="copied ? 'fas fa-check' : 'fas fa-link'"></i>
                </button>
              </div>
            </div>

          </aside>

        </div>
      </section>

    </template>
  </div>
</template>

<script>
export default {
  name: 'BlogDetailsPage',
  props: { slug: { type: String, required: true } },

  data: () => ({ post: null, related: [], loading: true, copied: false }),

  computed: {
    readTime() {
      const body = this.post?.body || '';
      const words = body.replace(/<[^>]*>/g, '').split(/\s+/).filter(Boolean).length;
      return words > 0 ? Math.max(1, Math.round(words / 200)) : null;
    },
    pageUrl() { return typeof window !== 'undefined' ? window.location.href : ''; },
    fbShare() { return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(this.pageUrl)}`; },
    twShare() { return `https://twitter.com/intent/tweet?url=${encodeURIComponent(this.pageUrl)}&text=${encodeURIComponent(this.post?.title || '')}`; },
    waShare() { return `https://wa.me/?text=${encodeURIComponent((this.post?.title || '') + ' ' + this.pageUrl)}`; },
  },

  methods: {
    fmtDate(d) {
      if (!d) return '';
      try { return new Date(d).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }); }
      catch { return d; }
    },
    thumbSrc(t) {
      if (!t || t === 'default.png') return '/default.png';
      return t.startsWith('http') ? t : '/' + t;
    },
    async copyLink() {
      try {
        await navigator.clipboard.writeText(this.pageUrl);
        this.copied = true;
        setTimeout(() => { this.copied = false; }, 2000);
      } catch { /* ignore */ }
    },

    async fetchPost() {
      this.loading = true;
      try {
        const res = await window.axios.get(`public/blogs/${this.slug}`);
        this.post = res?.data?.data ?? null;
        if (this.post) this.fetchRelated();
      } catch { this.post = null; }
      finally { this.loading = false; }
    },

    async fetchRelated() {
      try {
        const res = await window.axios.get('public/blogs', {
          params: { get_all: 1, status: 'active', limit: 4,
            fields: ['id','title','slug','thumbnail','published_at','created_at'] }
        });
        const all = res?.data?.data ?? [];
        this.related = all.filter(p => p.id !== this.post?.id).slice(0, 3);
      } catch { this.related = []; }
    },
  },

  mounted() { this.fetchPost(); },
};
</script>

<style scoped>
.bd-page { min-height: 100vh; background: #f4f6fb; }

/* ── Loading ── */
.bd-loading { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
.bd-spinner {
  width: 48px; height: 48px; border-radius: 50%;
  border: 4px solid #e8eeff; border-top-color: #6366f1;
  animation: spin .8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Not found ── */
.bd-notfound { min-height: 80vh; display: flex; align-items: center; justify-content: center; }
.bd-notfound__inner { text-align: center; }
.bd-notfound__code { font-size: 6rem; font-weight: 900; color: #e8eeff; display: block; line-height: 1; }

/* ── Hero ── */
.bd-hero {
  position: relative; min-height: 420px;
  display: flex; align-items: flex-end;
  padding-bottom: 3.5rem;
}
.bd-hero__bg { position: absolute; inset: 0; overflow: hidden; }
.bd-hero__bg-img { width: 100%; height: 100%; object-fit: cover; }
.bd-hero__mask {
  position: absolute; inset: 0;
  background: linear-gradient(to bottom, rgba(10,8,30,.55) 0%, rgba(10,8,30,.85) 100%);
}
.bd-hero__inner { position: relative; z-index: 2; }

/* breadcrumb */
.bd-breadcrumb { display: flex; align-items: center; gap: .45rem; font-size: .78rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
.bd-bc-link { color: rgba(255,255,255,.55); text-decoration: none; }
.bd-bc-link:hover { color: #fff; }
.bd-bc-sep { color: rgba(255,255,255,.25); font-size: .55rem; }
.bd-bc-cur { color: rgba(255,255,255,.7); }

.bd-cat {
  display: inline-block;
  background: linear-gradient(135deg,#6366f1,#8b5cf6);
  color: #fff; font-size: .68rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1px;
  padding: .3rem .9rem; border-radius: 50px;
  margin-bottom: 1rem;
}

.bd-hero__title {
  font-size: clamp(1.6rem,3.5vw,2.5rem); font-weight: 900;
  color: #fff; line-height: 1.3; margin-bottom: 1.25rem;
  max-width: 800px;
}

.bd-hero__meta { display: flex; gap: 1.5rem; flex-wrap: wrap; }
.bd-meta-item {
  font-size: .84rem; color: rgba(255,255,255,.7);
  display: inline-flex; align-items: center; gap: .4rem;
}
.bd-meta-item i { color: #818cf8; }

/* ── Layout ── */
.bd-content-wrap { padding: 3rem 0 5rem; }
.bd-layout {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 2.5rem;
  align-items: start;
}

/* ── Article ── */
.bd-article {
  background: #fff; border-radius: 20px;
  border: 1px solid #e8eeff; padding: 2.5rem;
}

.bd-excerpt {
  font-size: 1.1rem; color: #374151; line-height: 1.75;
  font-style: italic; border-left: 4px solid #6366f1;
  padding-left: 1.25rem; margin-bottom: 2rem;
}

/* Prose (v-html) styles */
.bd-prose { color: #374151; line-height: 1.85; font-size: .975rem; }
.bd-prose :deep(h1),
.bd-prose :deep(h2),
.bd-prose :deep(h3),
.bd-prose :deep(h4) { color: #111827; font-weight: 800; margin: 1.75rem 0 .75rem; line-height: 1.35; }
.bd-prose :deep(h2) { font-size: 1.45rem; }
.bd-prose :deep(h3) { font-size: 1.2rem; }
.bd-prose :deep(p)  { margin-bottom: 1.25rem; }
.bd-prose :deep(a)  { color: #6366f1; text-decoration: underline; }
.bd-prose :deep(ul),
.bd-prose :deep(ol) { padding-left: 1.5rem; margin-bottom: 1.25rem; }
.bd-prose :deep(li) { margin-bottom: .4rem; }
.bd-prose :deep(blockquote) {
  border-left: 4px solid #6366f1; padding: .75rem 1.25rem;
  background: #f5f3ff; border-radius: 0 10px 10px 0;
  margin: 1.5rem 0; color: #4b5563; font-style: italic;
}
.bd-prose :deep(pre) {
  background: #1e1b4b; color: #e2e8f0; border-radius: 12px;
  padding: 1.25rem 1.5rem; overflow-x: auto; margin-bottom: 1.5rem;
  font-size: .875rem; line-height: 1.7;
}
.bd-prose :deep(code) {
  background: #f5f3ff; color: #6d28d9;
  padding: .15rem .4rem; border-radius: 5px; font-size: .875em;
}
.bd-prose :deep(pre code) { background: none; color: inherit; padding: 0; }
.bd-prose :deep(img) { max-width: 100%; border-radius: 12px; margin: 1rem 0; }
.bd-prose :deep(table) { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
.bd-prose :deep(th),
.bd-prose :deep(td) { border: 1px solid #e5e7eb; padding: .6rem .9rem; font-size: .9rem; }
.bd-prose :deep(th) { background: #f5f3ff; font-weight: 700; color: #4c1d95; }

/* Related product block */
.bd-product-link { margin: 2.5rem 0; border-radius: 14px; overflow: hidden; border: 1px solid #e8eeff; }
.bd-product-link__inner {
  display: flex; align-items: center; justify-content: space-between; gap: 1rem;
  padding: 1.1rem 1.5rem;
  background: linear-gradient(135deg,#eef2ff,#f5f3ff);
}
.bd-product-link__label { font-size: .72rem; font-weight: 600; color: #6366f1; text-transform: uppercase; letter-spacing: .8px; margin: 0 0 .2rem; }
.bd-product-link__name  { font-size: 1rem; font-weight: 800; color: #111827; margin: 0; }
.bd-product-link__btn {
  display: inline-flex; align-items: center; gap: .4rem;
  background: linear-gradient(135deg,#6366f1,#8b5cf6);
  color: #fff !important; font-weight: 700; font-size: .84rem;
  text-decoration: none; padding: .55rem 1.25rem; border-radius: 50px;
  white-space: nowrap; transition: transform .2s, box-shadow .2s;
}
.bd-product-link__btn:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(99,102,241,.35); }

/* Back button */
.bd-back-wrap { margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; }
.bd-back-btn {
  display: inline-flex; align-items: center;
  color: #6b7280; font-weight: 600; font-size: .9rem;
  text-decoration: none; gap: .35rem;
  transition: color .2s;
}
.bd-back-btn:hover { color: #6366f1; }

/* ── Sidebar widgets ── */
.bd-sidebar { display: flex; flex-direction: column; gap: 1.5rem; }
.bd-widget {
  background: #fff; border-radius: 18px;
  border: 1px solid #e8eeff; padding: 1.5rem;
}
.bd-widget__title {
  font-size: .8rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 1px; color: #9ca3af; margin-bottom: 1.1rem;
}

/* Author */
.bd-author { display: flex; align-items: center; gap: .85rem; }
.bd-author__img { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; border: 2px solid #e8eeff; flex-shrink: 0; }
.bd-author__name { font-weight: 700; font-size: .95rem; color: #111827; margin: 0 0 .1rem; }
.bd-author__role { font-size: .8rem; color: #9ca3af; margin: 0; }

/* Related */
.bd-related { display: flex; flex-direction: column; gap: .9rem; }
.bd-related-card { display: flex; gap: .85rem; text-decoration: none; align-items: center; }
.bd-related-card:hover .bd-related-card__title { color: #6366f1; }
.bd-related-card__img { width: 68px; height: 52px; border-radius: 10px; object-fit: cover; flex-shrink: 0; }
.bd-related-card__title { font-size: .875rem; font-weight: 600; color: #111827; margin: 0 0 .25rem; line-height: 1.35; transition: color .2s; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.bd-related-card__date  { font-size: .75rem; color: #9ca3af; margin: 0; }

/* Share */
.bd-share { display: flex; gap: .65rem; flex-wrap: wrap; }
.bd-share-btn {
  width: 40px; height: 40px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: .9rem; border: none; cursor: pointer; text-decoration: none;
  transition: transform .2s, box-shadow .2s;
}
.bd-share-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.15); }
.bd-share-btn--fb   { background: #1877f2; color: #fff; }
.bd-share-btn--tw   { background: #1da1f2; color: #fff; }
.bd-share-btn--wa   { background: #25d366; color: #fff; }
.bd-share-btn--copy { background: #f5f3ff; color: #6366f1; }

/* ── Buttons ── */
.bd-btn {
  display: inline-flex; align-items: center; gap: .5rem;
  font-weight: 700; font-size: .9rem; text-decoration: none;
  padding: .65rem 1.5rem; border-radius: 50px; transition: transform .2s, box-shadow .2s;
}
.bd-btn--primary {
  background: linear-gradient(135deg,#6366f1,#8b5cf6); color: #fff;
  margin-top: 1.5rem; display: inline-flex;
}
.bd-btn--primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99,102,241,.35); }

/* ── Responsive ── */
@media (max-width: 991px) {
  .bd-layout { grid-template-columns: 1fr; }
  .bd-sidebar { order: -1; }
}
@media (max-width: 576px) {
  .bd-article { padding: 1.5rem; }
  .bd-hero { min-height: 320px; }
}
</style>
