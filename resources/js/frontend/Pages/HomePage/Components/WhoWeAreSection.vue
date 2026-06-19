<template>
  <section id="about" class="wwa-section section-pad">
    <div class="wwa-bg-glow wwa-bg-glow--a"></div>
    <div class="wwa-bg-glow wwa-bg-glow--b"></div>

    <div class="container position-relative">

      <!-- ── Skeleton ── -->
      <template v-if="loading">
        <div class="text-center" style="margin-bottom:4rem">
          <span class="skel skel-pill" style="height:28px;width:110px;display:inline-block;margin-bottom:1rem"></span>
          <div class="skel" style="height:38px;max-width:360px;margin:0 auto .75rem;border-radius:10px"></div>
          <div class="skel" style="height:3px;max-width:160px;margin:.75rem auto 1rem;border-radius:3px"></div>
          <div class="skel" style="height:14px;max-width:420px;margin:0 auto;border-radius:6px"></div>
        </div>
        <div class="row align-items-center g-5">
          <div class="col-lg-5">
            <span class="skel skel-card" style="display:block;aspect-ratio:4/3;border-radius:24px"></span>
          </div>
          <div class="col-lg-7" style="padding-left:.5rem">
            <span class="skel" style="height:14px;width:95%;display:block;margin-bottom:.7rem;border-radius:6px"></span>
            <span class="skel" style="height:14px;width:88%;display:block;margin-bottom:.7rem;border-radius:6px"></span>
            <span class="skel" style="height:14px;width:70%;display:block;margin-bottom:2rem;border-radius:6px"></span>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:2rem">
              <span v-for="n in 4" :key="n" class="skel skel-card" style="height:80px;border-radius:14px"></span>
            </div>
            <div style="display:flex;gap:2.5rem;padding-top:1.5rem;border-top:1px solid rgba(255,255,255,.07)">
              <div v-for="n in 2" :key="n">
                <span class="skel" style="height:32px;width:70px;display:block;margin-bottom:.4rem;border-radius:8px"></span>
                <span class="skel" style="height:12px;width:100px;display:block;border-radius:6px"></span>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- ── Real content ── -->
      <template v-else>

      <!-- Section heading -->
      <div class="wwa-heading text-center animate from-bottom section-content-in">
        <span class="wwa-badge">
          <i class="fas fa-users me-2"></i>{{ badge }}
        </span>
        <h2 class="wwa-title">{{ title }}</h2>
        <div class="ps-divider">
          <span class="ps-divider__bar"></span>
          <i class="fas fa-circle ps-divider__dot"></i>
          <span class="ps-divider__bar"></span>
        </div>
        <p class="wwa-subtitle">{{ subtitle }}</p>
      </div>

      <!-- Body: image + content -->
      <div class="row align-items-center g-5">

        <!-- Image col -->
        <div class="col-lg-5">
          <div class="wwa-visual animate from-left dur-slow">
            <div class="wwa-img-wrap">
              <img
                v-if="data && data.image"
                :src="data.image"
                :alt="title"
                class="wwa-img"
              />
              <div v-else class="wwa-img-placeholder">
                <div class="wwa-placeholder-lines">
                  <span v-for="l in placeholderLines" :key="l.id" class="wwa-pline" :style="{ width: l.w, background: l.c }"></span>
                </div>
                <div class="wwa-placeholder-icon">
                  <i class="fas fa-building"></i>
                </div>
              </div>
            </div>

            <!-- Floating stat cards -->
            <div v-if="stat0" class="wwa-stat-card wwa-stat-card--tl">
              <span class="wwa-stat-card__num">{{ stat0.stat_value }}</span>
              <span class="wwa-stat-card__label">{{ stat0.stat_label }}</span>
            </div>
            <div v-if="stat1" class="wwa-stat-card wwa-stat-card--br">
              <i class="fas fa-award wwa-stat-card__icon"></i>
              <div>
                <span class="wwa-stat-card__num">{{ stat1.stat_value }}</span>
                <span class="wwa-stat-card__label">{{ stat1.stat_label }}</span>
              </div>
            </div>

            <!-- Decorative ring -->
            <div class="wwa-ring wwa-ring--1"></div>
            <div class="wwa-ring wwa-ring--2"></div>
          </div>
        </div>

        <!-- Content col -->
        <div class="col-lg-7">
          <div class="wwa-content animate from-right dur-slow">

            <p class="wwa-desc">{{ description }}</p>

            <!-- Features -->
            <div v-if="features.length" class="wwa-features">
              <div v-for="(f, i) in features" :key="i"
                   class="wwa-feature animate from-bottom"
                   :class="'delay-' + (i + 1)">
                <div class="wwa-feature__icon" :class="'wwa-feature__icon--' + (i % 4)">
                  <i :class="f.icon || 'fas fa-check-circle'"></i>
                </div>
                <div class="wwa-feature__body">
                  <div class="wwa-feature__title">{{ f.title }}</div>
                  <div class="wwa-feature__desc">{{ f.description || f.desc }}</div>
                </div>
              </div>
            </div>

            <!-- Stats row -->
            <div v-if="statsArr.length" class="wwa-stats-row">
              <div v-for="(s, i) in statsArr" :key="i" class="wwa-stat">
                <span class="wwa-stat__num">{{ s.stat_value }}</span>
                <span class="wwa-stat__label">{{ s.stat_label }}</span>
              </div>
            </div>

          </div>
        </div>

      </div>

      </template><!-- /v-else -->

    </div>
  </section>
</template>

<script>
export default {
  name: 'WhoWeAreSection',
  props: {
    data:    { type: Object,  default: () => null },
    loading: { type: Boolean, default: false },
  },
  computed: {
    badge()       { return this.data?.badge_label || 'Who We Are'; },
    title()       { return this.data?.title       || 'Built by Passionate People'; },
    subtitle()    { return 'A team dedicated to crafting software that delivers real-world impact.'; },
    description() { return this.data?.description || 'We are a passionate team of developers, designers, and strategists. From startup MVPs to enterprise platforms — we build with precision, care, and a relentless focus on quality.'; },
    statsArr() {
      const s = this.data?.stats;
      if (!s) return [];
      return Array.isArray(s) ? s : (typeof s === 'string' ? JSON.parse(s) : []);
    },
    stat0() { return this.statsArr[0] || null; },
    stat1() { return this.statsArr[1] || null; },
    features() {
      const f = this.data?.features;
      if (!f) return this.defaultFeatures;
      const arr = Array.isArray(f) ? f : (typeof f === 'string' ? JSON.parse(f) : []);
      return arr.length ? arr : this.defaultFeatures;
    },
    defaultFeatures() {
      return [
        { icon: 'fas fa-rocket',      title: 'Fast Delivery',    description: 'On-time, every time — no excuses.' },
        { icon: 'fas fa-shield-alt',  title: 'Reliable Code',    description: 'Clean, tested, production-ready.' },
        { icon: 'fas fa-users',       title: 'Client-Focused',   description: 'Your success is our only metric.' },
        { icon: 'fas fa-lightbulb',   title: 'Innovation-First', description: 'We evolve our stack so you stay ahead.' },
      ];
    },
    placeholderLines() {
      return [
        { id:1, w:'60%', c:'#6366f1' }, { id:2, w:'85%', c:'#8b5cf6' },
        { id:3, w:'45%', c:'#06b6d4' }, { id:4, w:'72%', c:'rgba(255,255,255,.12)' },
        { id:5, w:'90%', c:'#6366f1' }, { id:6, w:'55%', c:'#8b5cf6' },
        { id:7, w:'38%', c:'#06b6d4' }, { id:8, w:'78%', c:'rgba(255,255,255,.1)' },
      ];
    },
  },
};
</script>

<style scoped>
/* ── Section wrapper ───────────────────────────────────── */
.wwa-section {
  background: var(--ps-bg-1);
  position: relative;
  overflow: hidden;
}

/* Glows */
.wwa-bg-glow {
  position: absolute;
  border-radius: 50%;
  filter: blur(120px);
  pointer-events: none;
  z-index: 0;
}
.wwa-bg-glow--a { width: 700px; height: 700px; background: rgba(99,102,241,.08); top: -200px; right: -200px; }
.wwa-bg-glow--b { width: 500px; height: 500px; background: rgba(6,182,212,.07); bottom: -150px; left: -150px; }

/* ── Heading block ─────────────────────────────────────── */
.wwa-heading { margin-bottom: 4rem; }

.wwa-badge {
  display: inline-flex;
  align-items: center;
  padding: .45rem 1.25rem;
  border-radius: 999px;
  background: var(--ps-badge-bg);
  border: 1px solid var(--ps-badge-border);
  font-size: .8rem;
  font-weight: 700;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--ps-badge-color);
  margin-bottom: 1.25rem;
}

.wwa-title {
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 900;
  color: var(--ps-text-h);
  line-height: 1.15;
  margin-bottom: 1rem;
}

/* Decorative divider */
.wwa-title-line {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .75rem;
  margin-bottom: 1.25rem;
}
.wwa-title-line__bar {
  width: 60px;
  height: 2px;
  background: linear-gradient(90deg, transparent, #6366f1);
  border-radius: 2px;
}
.wwa-title-line__bar:last-child {
  background: linear-gradient(90deg, #6366f1, transparent);
}
.wwa-title-line__dot {
  font-size: .4rem;
  color: #6366f1;
}

.wwa-subtitle {
  max-width: 560px;
  margin: 0 auto;
  color: var(--ps-text-faint);
  font-size: 1rem;
  line-height: 1.8;
}

/* ── Visual ────────────────────────────────────────────── */
.wwa-visual { position: relative; }

.wwa-img-wrap {
  border-radius: 24px;
  overflow: hidden;
  border: 1px solid rgba(139,92,246,.25);
  background: #0d0d26;
  aspect-ratio: 4/3;
  box-shadow:
    0 0 0 4px rgba(99,102,241,.08),
    0 20px 60px rgba(0,0,0,.5),
    inset 0 0 30px rgba(99,102,241,.06);
}
html[data-theme="light"] .wwa-img-wrap {
  background: #ffffff;
  border-color: rgba(99,102,241,.15);
  box-shadow: 0 8px 40px rgba(99,102,241,.1);
}

.wwa-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.wwa-img-placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 1.5rem;
  padding: 2.5rem;
}

.wwa-placeholder-lines {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: .6rem;
}

.wwa-pline {
  height: 9px;
  border-radius: 6px;
  display: block;
  opacity: .7;
}

.wwa-placeholder-icon {
  width: 72px;
  height: 72px;
  border-radius: 20px;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.8rem;
  color: #fff;
  box-shadow: 0 12px 32px rgba(99,102,241,.35);
}

/* Stat cards */
.wwa-stat-card {
  position: absolute;
  border-radius: 18px;
  display: flex;
  align-items: center;
  gap: .7rem;
  z-index: 2;
  /* solid dark-glass — readable over any background */
  background: linear-gradient(135deg, #1a1a3e 0%, #0f0f2e 100%);
  border: 1px solid rgba(139,92,246,.35);
  box-shadow:
    0 0 0 1px rgba(0,0,0,.5),
    0 12px 40px rgba(0,0,0,.55),
    0 0 20px rgba(99,102,241,.2);
}

.wwa-stat-card--tl {
  top: -1.2rem;
  left: -1.4rem;
  padding: 1rem 1.4rem;
  flex-direction: column;
  align-items: flex-start;
}

.wwa-stat-card--br {
  bottom: -1.2rem;
  right: -1.4rem;
  padding: 1rem 1.4rem;
  background: linear-gradient(135deg, #0c1a2e 0%, #071525 100%);
  border-color: rgba(6,182,212,.35);
  box-shadow:
    0 0 0 1px rgba(0,0,0,.5),
    0 12px 40px rgba(0,0,0,.55),
    0 0 20px rgba(6,182,212,.18);
}

.wwa-stat-card__num {
  font-size: 1.9rem;
  font-weight: 900;
  color: #ffffff;
  line-height: 1;
  letter-spacing: -.02em;
}
.wwa-stat-card__label {
  font-size: .72rem;
  font-weight: 700;
  color: #c4b5fd;
  line-height: 1.35;
  text-transform: uppercase;
  letter-spacing: .05em;
}
.wwa-stat-card--br .wwa-stat-card__label { color: #67e8f9; }
.wwa-stat-card__icon { font-size: 1.4rem; color: #38bdf8; }

/* Light-mode overrides for stat cards */
html[data-theme="light"] .wwa-stat-card {
  background: #ffffff;
  border-color: rgba(99,102,241,.2);
  box-shadow: 0 8px 28px rgba(99,102,241,.14), 0 2px 8px rgba(0,0,0,.06);
}
html[data-theme="light"] .wwa-stat-card--br {
  background: #f0fdff;
  border-color: rgba(6,182,212,.25);
  box-shadow: 0 8px 28px rgba(6,182,212,.14), 0 2px 8px rgba(0,0,0,.06);
}
html[data-theme="light"] .wwa-stat-card__num   { color: #1e1b4b; }
html[data-theme="light"] .wwa-stat-card__label { color: #6366f1; }
html[data-theme="light"] .wwa-stat-card--br .wwa-stat-card__label { color: #0891b2; }
html[data-theme="light"] .wwa-stat-card__icon  { color: #0891b2; }

/* Decorative rings */
.wwa-ring {
  position: absolute;
  border-radius: 50%;
  border: 1px solid rgba(99,102,241,.15);
  pointer-events: none;
  z-index: 0;
}
.wwa-ring--1 { width: 120px; height: 120px; bottom: -30px; left: 30px; }
.wwa-ring--2 { width: 60px;  height: 60px;  top: 20px;     right: 10px; border-color: rgba(6,182,212,.2); }

/* ── Content ───────────────────────────────────────────── */
.wwa-content { padding-left: .5rem; }

.wwa-desc {
  font-size: 1.05rem;
  color: var(--ps-text-body);
  line-height: 1.9;
  margin-bottom: 2rem;
}

/* Features grid */
.wwa-features {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
  margin-bottom: 2.5rem;
}

.wwa-feature {
  display: flex;
  gap: .85rem;
  align-items: flex-start;
  padding: 1.1rem 1.2rem;
  border-radius: 14px;
  background: var(--ps-card-bg);
  border: 1px solid var(--ps-card-border);
  transition: border-color .3s, background .3s, transform .3s;
}
.wwa-feature:hover {
  border-color: rgba(99,102,241,.3);
  background: rgba(99,102,241,.05);
  transform: translateY(-3px);
}

.wwa-feature__icon {
  width: 40px;
  height: 40px;
  border-radius: 11px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: .95rem;
  color: #fff;
  flex-shrink: 0;
}
.wwa-feature__icon--0 { background: linear-gradient(135deg,#6366f1,#8b5cf6); }
.wwa-feature__icon--1 { background: linear-gradient(135deg,#06b6d4,#3b82f6); }
.wwa-feature__icon--2 { background: linear-gradient(135deg,#10b981,#06b6d4); }
.wwa-feature__icon--3 { background: linear-gradient(135deg,#f59e0b,#ef4444); }

.wwa-feature__title { font-weight: 700; font-size: .88rem; color: var(--ps-text-h); margin-bottom: .2rem; }
.wwa-feature__desc  { font-size: .77rem; color: var(--ps-text-faint); line-height: 1.5; }

/* Stats row */
.wwa-stats-row {
  display: flex;
  gap: 2.5rem;
  padding-top: 1.5rem;
  border-top: 1px solid var(--ps-card-border);
}

.wwa-stat {
  display: flex;
  flex-direction: column;
}

.wwa-stat__num {
  font-size: 2rem;
  font-weight: 900;
  background: linear-gradient(135deg, #6366f1, #06b6d4);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  line-height: 1.1;
}
.wwa-stat__label {
  font-size: .75rem;
  color: var(--ps-stat-label);
  font-weight: 600;
  margin-top: .2rem;
  text-transform: uppercase;
  letter-spacing: .06em;
}

/* ── Responsive ────────────────────────────────────────── */
@media (max-width: 991px) {
  .wwa-stat-card { display: none; }
  .wwa-content   { padding-left: 0; }
}

@media (max-width: 576px) {
  .wwa-features   { grid-template-columns: 1fr; }
  .wwa-stats-row  { gap: 1.5rem; flex-wrap: wrap; }
  .wwa-stat__num  { font-size: 1.6rem; }
}
</style>
