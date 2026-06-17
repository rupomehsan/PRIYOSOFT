<template>
  <section class="cv-section section-pad">
    <div class="cv-glow cv-glow--a"></div>
    <div class="cv-glow cv-glow--b"></div>

    <div class="container position-relative">

      <!-- Heading -->
      <div class="cv-heading text-center">
        <span class="cv-badge">
          <i class="fas fa-gem me-2"></i>What Drives Us
        </span>
        <h2 class="cv-title">Our Mission, Vision <span class="cv-title--accent">&amp; Values</span></h2>
        <div class="cv-divider">
          <span class="cv-divider__line"></span>
          <span class="cv-divider__icon"><i class="fas fa-star"></i></span>
          <span class="cv-divider__line"></span>
        </div>
        <p class="cv-sub">The principles that shape every line of code we write and every relationship we build.</p>
      </div>

      <!-- Cards grid -->
      <div class="cv-grid">
        <div
          v-for="(card, i) in allCards"
          :key="i"
          class="cv-card"
          :class="'cv-card--' + (i % 4)"
        >
          <div class="cv-card__icon-wrap">
            <div class="cv-card__icon">
              <i :class="card.icon"></i>
            </div>
            <div class="cv-card__icon-glow"></div>
          </div>
          <h4 class="cv-card__title">{{ card.title }}</h4>
          <p class="cv-card__desc">{{ card.description }}</p>
          <div class="cv-card__bottom-bar"></div>
        </div>
      </div>

    </div>
  </section>
</template>

<script>
const PILLAR_ICONS = {
  mission: 'fas fa-bullseye',
  vision:  'fas fa-eye',
  value:   'fas fa-gem',
  story:   'fas fa-book-open',
};
const PILLAR_LABELS = {
  mission: 'Our Mission',
  vision:  'Our Vision',
  value:   'Our Values',
  story:   'Our Story',
};

const DEFAULT_FEATURES = [
  { icon: 'fas fa-rocket',      title: 'Fast Delivery',    description: 'We ship on time, every time — no excuses.' },
  { icon: 'fas fa-shield-alt',  title: 'Reliable Code',    description: 'Clean, tested, and maintainable code you can trust.' },
  { icon: 'fas fa-users',       title: 'Client-Focused',   description: 'Your success is our only metric.' },
  { icon: 'fas fa-lightbulb',   title: 'Innovation',       description: 'Always evolving our stack to keep you ahead.' },
];

export default {
  name: 'CoreValuesSection',
  props: {
    data:     { type: Array,  default: () => [] },
    whoWeAre: { type: Object, default: () => null },
  },
  computed: {
    pillars() {
      return this.data
        .filter(s => ['mission', 'vision', 'value'].includes(s.section))
        .map(s => ({
          icon:        PILLAR_ICONS[s.section]  || 'fas fa-star',
          title:       s.title || PILLAR_LABELS[s.section] || s.section,
          description: s.description,
        }));
    },
    features() {
      const f = this.whoWeAre?.features;
      if (f) {
        const arr = Array.isArray(f) ? f : (typeof f === 'string' ? JSON.parse(f) : []);
        if (arr.length) return arr.map(item => ({
          icon:        item.icon || 'fas fa-check-circle',
          title:       item.title,
          description: item.description || item.desc || '',
        }));
      }
      return DEFAULT_FEATURES;
    },
    allCards() {
      return [...this.pillars, ...this.features];
    },
  },
};
</script>

<style scoped>
/* ── Wrapper ───────────────────────────────────────────── */
.cv-section {
  background: var(--ps-bg-4);
  position: relative;
  overflow: hidden;
}

.cv-glow {
  position: absolute;
  border-radius: 50%;
  filter: blur(130px);
  pointer-events: none;
  z-index: 0;
}
.cv-glow--a { width: 650px; height: 650px; background: rgba(99,102,241,.07); top: -180px; left: -180px; }
.cv-glow--b { width: 500px; height: 500px; background: rgba(6,182,212,.06); bottom: -120px; right: -120px; }

/* ── Heading ───────────────────────────────────────────── */
.cv-heading { margin-bottom: 3.5rem; }

.cv-badge {
  display: inline-flex;
  align-items: center;
  padding: .45rem 1.2rem;
  border-radius: 999px;
  background: rgba(99,102,241,.1);
  border: 1px solid rgba(99,102,241,.25);
  font-size: .78rem;
  font-weight: 700;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: #a5b4fc;
  margin-bottom: 1.1rem;
}

.cv-title {
  font-size: clamp(1.9rem, 3.5vw, 2.8rem);
  font-weight: 900;
  color: var(--ps-text-h);
  line-height: 1.2;
  margin-bottom: .9rem;
}
.cv-title--accent {
  background: linear-gradient(90deg, #6366f1, #06b6d4);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.cv-divider {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .8rem;
  margin-bottom: 1.1rem;
}
.cv-divider__line {
  width: 50px;
  height: 2px;
  background: linear-gradient(90deg, transparent, rgba(99,102,241,.5));
  border-radius: 2px;
}
.cv-divider__line:last-child {
  background: linear-gradient(90deg, rgba(99,102,241,.5), transparent);
}
.cv-divider__icon {
  font-size: .5rem;
  color: #6366f1;
}

.cv-sub {
  max-width: 520px;
  margin: 0 auto;
  color: var(--ps-text-faint);
  font-size: .95rem;
  line-height: 1.8;
}

/* ── Grid ──────────────────────────────────────────────── */
.cv-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}

/* ── Card ──────────────────────────────────────────────── */
.cv-card {
  position: relative;
  padding: 2.25rem 2rem 2rem;
  border-radius: 20px;
  background: var(--ps-card-bg);
  border: 1px solid var(--ps-card-border);
  overflow: hidden;
  transition: transform .35s, border-color .35s, box-shadow .35s;
  cursor: default;
}
.cv-card:hover {
  transform: translateY(-7px);
  border-color: rgba(99,102,241,.3);
  box-shadow: 0 24px 60px rgba(0,0,0,.35), 0 0 0 1px rgba(99,102,241,.1);
}

/* Icon */
.cv-card__icon-wrap {
  position: relative;
  display: inline-block;
  margin-bottom: 1.5rem;
}
.cv-card__icon {
  width: 60px;
  height: 60px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.4rem;
  color: #fff;
  position: relative;
  z-index: 1;
}
.cv-card__icon-glow {
  position: absolute;
  inset: 0;
  border-radius: 16px;
  filter: blur(12px);
  opacity: .5;
  z-index: 0;
}

/* 4 colour schemes cycling */
.cv-card--0 .cv-card__icon      { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.cv-card--0 .cv-card__icon-glow { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.cv-card--0 .cv-card__bottom-bar { background: linear-gradient(90deg, #6366f1, #8b5cf6); }
.cv-card--0:hover { border-color: rgba(99,102,241,.35); }

.cv-card--1 .cv-card__icon      { background: linear-gradient(135deg, #06b6d4, #3b82f6); }
.cv-card--1 .cv-card__icon-glow { background: linear-gradient(135deg, #06b6d4, #3b82f6); }
.cv-card--1 .cv-card__bottom-bar { background: linear-gradient(90deg, #06b6d4, #3b82f6); }
.cv-card--1:hover { border-color: rgba(6,182,212,.35); }

.cv-card--2 .cv-card__icon      { background: linear-gradient(135deg, #10b981, #06b6d4); }
.cv-card--2 .cv-card__icon-glow { background: linear-gradient(135deg, #10b981, #06b6d4); }
.cv-card--2 .cv-card__bottom-bar { background: linear-gradient(90deg, #10b981, #06b6d4); }
.cv-card--2:hover { border-color: rgba(16,185,129,.35); }

.cv-card--3 .cv-card__icon      { background: linear-gradient(135deg, #f59e0b, #ef4444); }
.cv-card--3 .cv-card__icon-glow { background: linear-gradient(135deg, #f59e0b, #ef4444); }
.cv-card--3 .cv-card__bottom-bar { background: linear-gradient(90deg, #f59e0b, #ef4444); }
.cv-card--3:hover { border-color: rgba(245,158,11,.35); }

/* Text */
.cv-card__title {
  font-weight: 800;
  font-size: 1.05rem;
  color: var(--ps-text-h);
  margin-bottom: .6rem;
}
.cv-card__desc {
  font-size: .875rem;
  color: var(--ps-text-faint);
  line-height: 1.75;
  margin: 0;
}

/* Bottom accent bar */
.cv-card__bottom-bar {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 3px;
  opacity: 0;
  transition: opacity .35s;
}
.cv-card:hover .cv-card__bottom-bar { opacity: 1; }

/* ── Responsive ────────────────────────────────────────── */
@media (max-width: 991px) {
  .cv-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 576px) {
  .cv-grid { grid-template-columns: 1fr; }
}
</style>
