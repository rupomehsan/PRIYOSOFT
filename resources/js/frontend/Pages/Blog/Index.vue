<template>
  <div class="bl-page">

    <!-- Hero -->
    <section class="bl-hero">
      <div class="container bl-hero__inner">
        <nav class="bl-breadcrumb">
          <a href="/">Home</a>
          <i class="fas fa-chevron-right"></i>
          <span>Blog</span>
        </nav>
        <h1 class="bl-hero__title">From Our <span class="bl-grad">Blog</span></h1>
        <p class="bl-hero__sub">Thoughts on software, technology, and building great products in Bangladesh and beyond.</p>
      </div>
    </section>

    <!-- Grid -->
    <section class="bl-body">
      <div class="container">

        <div v-if="loading" class="bl-grid">
          <div v-for="n in 6" :key="n" class="bl-skeleton"></div>
        </div>

        <div v-else-if="!posts.length" class="bl-empty">
          <i class="fas fa-newspaper"></i>
          <p>No articles yet. Check back soon!</p>
        </div>

        <div v-else class="bl-grid">
          <a v-for="post in posts" :key="post.id"
             :href="'/blog/' + post.slug"
             class="bl-card">

            <!-- Thumbnail -->
            <div class="bl-card__thumb">
              <img :src="thumbSrc(post.thumbnail)" :alt="post.title" class="bl-card__img" />
              <div class="bl-card__overlay"></div>
              <span class="bl-cat">Article</span>
            </div>

            <!-- Body -->
            <div class="bl-card__body">
              <div class="bl-meta">
                <span><i class="fas fa-calendar-alt me-1"></i>{{ fmtDate(post.published_at || post.created_at) }}</span>
                <span v-if="post.authorId"><i class="fas fa-user me-1"></i>{{ post.authorId.name }}</span>
              </div>
              <h3 class="bl-card__title">{{ post.title }}</h3>
              <p class="bl-card__excerpt">{{ truncate(post.excerpt || post.body, 120) }}</p>
            </div>

            <!-- Footer -->
            <div class="bl-card__foot">
              <span class="bl-read-more">Read Article <i class="fas fa-arrow-right ms-1"></i></span>
            </div>

          </a>
        </div>

      </div>
    </section>

  </div>
</template>

<script>
export default {
  name: 'BlogIndexPage',
  data: () => ({ posts: [], loading: true }),

  methods: {
    truncate(str, n) {
      if (!str) return '';
      const plain = str.replace(/<[^>]*>/g, '');
      return plain.length > n ? plain.slice(0, n) + '…' : plain;
    },
    fmtDate(d) {
      if (!d) return '';
      try { return new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }); }
      catch { return d; }
    },
    thumbSrc(t) {
      if (!t || t === 'default.png') return '/default.png';
      return t.startsWith('http') ? t : '/' + t;
    },

    async fetchPosts() {
      this.loading = true;
      try {
        const res = await window.axios.get('public/blogs', {
          params: { get_all: 1, status: 'active', limit: 50,
            fields: ['id','title','slug','thumbnail','excerpt','body','published_at','created_at','author_id'] }
        });
        this.posts = res?.data?.data ?? [];
      } catch { this.posts = []; }
      finally { this.loading = false; }
    },
  },

  mounted() { this.fetchPosts(); },
};
</script>

<style scoped>
.bl-page { min-height: 100vh; background: #f4f6fb; }

/* ── Hero ── */
.bl-hero {
  background: linear-gradient(140deg,#0f0c29,#302b63,#24243e);
  padding: 5rem 0 3.5rem;
}
.bl-hero__inner { position: relative; }
.bl-breadcrumb {
  display: flex; align-items: center; gap: .5rem;
  font-size: .8rem; margin-bottom: 2rem;
}
.bl-breadcrumb a { color: rgba(255,255,255,.5); text-decoration: none; }
.bl-breadcrumb a:hover { color: #fff; }
.bl-breadcrumb i { color: rgba(255,255,255,.25); font-size: .6rem; }
.bl-breadcrumb span { color: rgba(255,255,255,.7); }
.bl-hero__title {
  font-size: clamp(2rem,4vw,3rem); font-weight: 900; color: #fff;
  margin-bottom: 1rem; letter-spacing: -.5px;
}
.bl-grad {
  background: linear-gradient(90deg,#818cf8,#c4b5fd);
  -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
}
.bl-hero__sub { font-size: 1rem; color: rgba(255,255,255,.65); max-width: 560px; line-height: 1.7; }

/* ── Body ── */
.bl-body { padding: 3rem 0 5rem; }

/* ── Grid ── */
.bl-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.75rem; }

/* Skeleton */
.bl-skeleton {
  height: 380px; border-radius: 20px;
  background: linear-gradient(90deg,#e5e7eb 25%,#f3f4f6 50%,#e5e7eb 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

/* Empty */
.bl-empty { text-align: center; padding: 4rem 0; color: #9ca3af; }
.bl-empty i { font-size: 3.5rem; margin-bottom: 1rem; display: block; color: #d1d5db; }

/* ── Card ── */
.bl-card {
  background: #fff; border-radius: 20px; border: 1px solid #e8eeff;
  display: flex; flex-direction: column; overflow: hidden;
  text-decoration: none;
  transition: transform .25s, box-shadow .25s, border-color .25s;
}
.bl-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 50px rgba(99,102,241,.14);
  border-color: #c7d2fe;
}

/* Thumb */
.bl-card__thumb {
  width: 100%; height: 200px;
  position: relative; overflow: hidden; flex-shrink: 0;
}
.bl-card__img {
  width: 100%; height: 100%; object-fit: cover; display: block;
  transition: transform .4s;
}
.bl-card:hover .bl-card__img { transform: scale(1.05); }
.bl-card__overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to bottom, transparent 45%, rgba(0,0,0,.35));
  pointer-events: none;
}
.bl-cat {
  position: absolute; top: .75rem; left: .75rem;
  background: linear-gradient(135deg,#6366f1,#8b5cf6);
  color: #fff; font-size: .65rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1px;
  padding: .28rem .85rem; border-radius: 50px;
}

/* Body */
.bl-card__body { padding: 1.25rem 1.4rem .75rem; flex: 1; }
.bl-meta {
  display: flex; gap: 1rem; flex-wrap: wrap;
  font-size: .76rem; color: #9ca3af; margin-bottom: .6rem;
}
.bl-card__title {
  font-size: 1.05rem; font-weight: 800; color: #111827;
  margin-bottom: .5rem; line-height: 1.45;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.bl-card__excerpt {
  font-size: .855rem; color: #6b7280; line-height: 1.65;
}

/* Foot */
.bl-card__foot {
  padding: .85rem 1.4rem 1.3rem;
  border-top: 1px solid #f1f5f9;
}
.bl-read-more {
  font-size: .84rem; font-weight: 700; color: #6366f1;
  display: inline-flex; align-items: center; gap: .3rem;
  transition: color .2s, gap .2s;
}
.bl-card:hover .bl-read-more { color: #4f46e5; gap: .55rem; }

@media (max-width:991px) { .bl-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width:576px)  { .bl-grid { grid-template-columns: 1fr; } }
</style>
