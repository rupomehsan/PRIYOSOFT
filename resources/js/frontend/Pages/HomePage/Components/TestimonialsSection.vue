<template>
  <section id="testimonials" class="testimonials-section section-pad section-dark">
    <div class="t-glow t-glow--1"></div>
    <div class="t-glow t-glow--2"></div>
    <div class="container position-relative">
      <!-- ── Skeleton ── -->
      <template v-if="loading">
        <div class="section-head text-center" style="margin-bottom:3rem">
          <span class="skel skel-pill" style="height:26px;width:100px;display:inline-block;margin-bottom:1rem"></span>
          <div class="skel" style="height:36px;max-width:320px;margin:0 auto .75rem;border-radius:10px"></div>
          <div class="skel" style="height:13px;max-width:360px;margin:0 auto;border-radius:6px"></div>
        </div>
        <div class="t-grid">
          <div v-for="n in 3" :key="n" class="t-card skel-card" style="border-radius:20px;padding:2rem 1.75rem">
            <div style="display:flex;justify-content:space-between;margin-bottom:1rem">
              <div style="display:flex;gap:4px">
                <span v-for="s in 5" :key="s" class="skel" style="width:16px;height:14px;border-radius:3px"></span>
              </div>
            </div>
            <span class="skel" style="height:30px;width:30px;border-radius:6px;display:block;margin-bottom:.75rem"></span>
            <span class="skel" style="height:13px;width:100%;display:block;margin-bottom:.4rem;border-radius:6px"></span>
            <span class="skel" style="height:13px;width:92%;display:block;margin-bottom:.4rem;border-radius:6px"></span>
            <span class="skel" style="height:13px;width:78%;display:block;margin-bottom:1.5rem;border-radius:6px"></span>
            <div style="display:flex;align-items:center;gap:.875rem;margin-top:auto">
              <span class="skel skel-circle" style="width:46px;height:46px;flex-shrink:0"></span>
              <div style="flex:1">
                <span class="skel" style="height:14px;width:60%;display:block;margin-bottom:.3rem;border-radius:6px"></span>
                <span class="skel" style="height:11px;width:80%;display:block;border-radius:6px"></span>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- ── Real content ── -->
      <template v-else>
      <div class="section-head text-center animate from-bottom section-content-in">
        <span class="section-tag">Social Proof</span>
        <h2 class="section-title">What Our <span class="gradient-text shimmer-text">Clients</span> Say</h2>
        <div class="ps-divider">
          <span class="ps-divider__bar"></span>
          <i class="fas fa-circle ps-divider__dot"></i>
          <span class="ps-divider__bar"></span>
        </div>
        <p class="section-sub">Real words from real people who trusted us with their vision.</p>
      </div>

      <div class="t-grid section-content-in">
        <div v-for="(t, i) in items" :key="t.id"
             class="t-card animate"
             :class="[i % 3 === 0 ? 'flip-left' : i % 3 === 1 ? 'from-bottom' : 'flip-right', 'delay-' + (i + 1)]">
          <div class="t-card__top">
            <div class="t-card__stars">
              <i v-for="n in 5" :key="n"
                 class="fas fa-star"
                 :class="n <= (t.rating || 5) ? 'filled' : 'empty'"></i>
            </div>
            <div v-if="t.is_featured" class="t-card__featured">
              <i class="fas fa-medal"></i> Featured
            </div>
          </div>

          <div class="t-card__quote-icon"><i class="fas fa-quote-left"></i></div>
          <p class="t-card__message">{{ t.message }}</p>

          <div v-if="t.media_type === 'video' && t.video_url" class="t-card__video-link">
            <a :href="t.video_url" target="_blank" class="t-play">
              <i class="fab fa-youtube me-2"></i>Watch video
            </a>
          </div>

          <div class="t-card__client">
            <div class="t-card__avatar">
              <img
                :src="t.client_photo || '/default.png'"
                :alt="t.client_name"
                @error="$event.target.src='/default.png'"
              />
            </div>
            <div class="t-card__info">
              <div class="t-card__name">{{ t.client_name }}</div>
              <div class="t-card__company">{{ t.client_company }}</div>
            </div>
          </div>
        </div>
      </div>
      </template><!-- /v-else -->
    </div>
  </section>
</template>

<script>
const FALLBACK = [
  { id:1, client_name:'Karim Uddin',     client_company:'RetailPro BD',   rating:5, message:'PriyoSoft delivered our ERP in record time. The system is rock-solid and the team was incredibly responsive throughout.' },
  { id:2, client_name:'Sumaiya Haque',   client_company:'HealthLink Ltd',  rating:5, message:'We chose PriyoSoft for our hospital management system and could not be happier. Excellent code quality and great post-launch support.' },
  { id:3, client_name:'Imran Chowdhury', client_company:'LogiFlow Inc',    rating:5, message:'Their supply-chain dashboard transformed how we track inventory. Clean UI, fast performance, and very reasonable pricing.' },
];

export default {
  name: 'TestimonialsSection',
  props: {
    data:    { type: Array,   default: () => [] },
    loading: { type: Boolean, default: false },
  },
  computed: {
    items() {
      const list = this.data.filter(t => t.is_visible !== false).slice(0, 6);
      return list.length ? list : FALLBACK;
    },
  },
  methods: {
    initial(name) { return name ? name[0].toUpperCase() : '?'; },
  },
};
</script>

<style scoped>
.testimonials-section {
  background: var(--ps-bg-2);
  position: relative;
  overflow: hidden;
}

/* Glows */
.t-glow {
  position: absolute; border-radius: 50%;
  filter: blur(100px); pointer-events: none;
}
.t-glow--1 { width:500px;height:500px;background:rgba(99,102,241,.1);top:-100px;right:-100px; }
.t-glow--2 { width:400px;height:400px;background:rgba(168,85,247,.08);bottom:-100px;left:-80px; }

/* Grid */
.t-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.75rem;
}

/* Card */
.t-card {
  background: var(--ps-card-bg);
  border: 1px solid var(--ps-card-border);
  border-radius: 20px;
  padding: 2rem 1.75rem;
  display: flex;
  flex-direction: column;
  transition: border-color .3s, transform .3s, box-shadow .3s;
  position: relative;
}
.t-card:hover {
  border-color: rgba(99,102,241,.4);
  transform: translateY(-6px);
  box-shadow: 0 24px 60px rgba(99,102,241,.12);
}

/* Top row */
.t-card__top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}
.t-card__stars { display: flex; gap: 2px; }
.filled { color: #f59e0b; font-size: .85rem; }
.empty  { color: #334155; font-size: .85rem; }

.t-card__featured {
  font-size: .7rem; font-weight: 700;
  color: #fbbf24;
  display: flex; align-items: center; gap: .3rem;
}

/* Big quote */
.t-card__quote-icon {
  font-size: 2.5rem;
  color: rgba(99,102,241,.25);
  margin-bottom: .75rem;
  line-height: 1;
}

/* Message */
.t-card__message {
  font-size: .92rem;
  color: var(--ps-text-body);
  line-height: 1.85;
  flex: 1;
  margin-bottom: 1.5rem;
}

/* Video */
.t-play {
  display: inline-flex; align-items: center;
  color: #f87171; font-weight: 600; font-size: .8rem;
  text-decoration: none; padding: .35rem .85rem;
  border: 1.5px solid rgba(248,113,113,.3);
  border-radius: 50px; margin-bottom: 1.25rem;
  transition: all .25s;
}
.t-play:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

/* Client */
.t-card__client { display: flex; align-items: center; gap: .875rem; }
.t-card__avatar {
  width: 46px; height: 46px; border-radius: 50%;
  overflow: hidden; flex-shrink: 0;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-weight: 800; font-size: 1.1rem;
  border: 2px solid rgba(99,102,241,.3);
}
.t-card__avatar img { width:100%;height:100%;object-fit:cover; }
.t-card__name    { font-weight: 700; font-size: .9rem; color: var(--ps-text-h); }
.t-card__company { font-size: .77rem; color: var(--ps-text-faint); margin-top: .1rem; }

@media (max-width: 991px) { .t-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 576px)  { .t-grid { grid-template-columns: 1fr; } }
</style>
