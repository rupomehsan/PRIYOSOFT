<template>
  <section class="stats-section">
    <div class="stats-glow stats-glow--1"></div>
    <div class="stats-glow stats-glow--2"></div>
    <div class="container position-relative">
      <div class="stats-grid">
        <div v-for="(stat, i) in visibleStats" :key="i" class="stat-card">
          <div class="stat-card__icon" :style="{ background: stat.color }">
            <i :class="stat.icon || 'fas fa-chart-bar'"></i>
          </div>
          <div class="stat-card__value">{{ stat.stat_value || stat.value }}</div>
          <div class="stat-card__label">{{ stat.stat_label || stat.title }}</div>
          <div class="stat-card__line" :style="{ background: stat.color }"></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
const FALLBACK = [
  { stat_value: '50+',  stat_label: 'Projects Delivered',  icon: 'fas fa-rocket',       color: 'linear-gradient(135deg,#6366f1,#8b5cf6)' },
  { stat_value: '30+',  stat_label: 'Happy Clients',       icon: 'fas fa-users',         color: 'linear-gradient(135deg,#06b6d4,#3b82f6)' },
  { stat_value: '8+',   stat_label: 'Years Experience',    icon: 'fas fa-calendar-check',color: 'linear-gradient(135deg,#10b981,#06b6d4)' },
  { stat_value: '99%',  stat_label: 'Client Satisfaction', icon: 'fas fa-star',          color: 'linear-gradient(135deg,#f59e0b,#ef4444)' },
];
const ICONS  = ['fas fa-rocket','fas fa-users','fas fa-calendar-check','fas fa-star','fas fa-trophy','fas fa-code'];
const COLORS = [
  'linear-gradient(135deg,#6366f1,#8b5cf6)',
  'linear-gradient(135deg,#06b6d4,#3b82f6)',
  'linear-gradient(135deg,#10b981,#06b6d4)',
  'linear-gradient(135deg,#f59e0b,#ef4444)',
];

export default {
  name: 'StatsSection',
  props: { data: { type: Array, default: () => [] } },
  computed: {
    stats() { return this.data.filter(s => s.section === 'stat'); },
    visibleStats() {
      if (!this.stats.length) return FALLBACK;
      return this.stats.map((s, i) => ({ ...s, icon: s.icon || ICONS[i % ICONS.length], color: COLORS[i % COLORS.length] }));
    },
  },
};
</script>

<style scoped>
.stats-section {
  background: #07071a;
  padding: 5rem 0;
  position: relative;
  overflow: hidden;
  border-top: 1px solid rgba(99,102,241,.1);
  border-bottom: 1px solid rgba(99,102,241,.1);
}

/* Ambient glows */
.stats-glow {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  pointer-events: none;
}
.stats-glow--1 {
  width: 500px; height: 500px;
  background: rgba(99,102,241,.12);
  top: -200px; left: -100px;
}
.stats-glow--2 {
  width: 400px; height: 400px;
  background: rgba(6,182,212,.1);
  bottom: -200px; right: -100px;
}

/* Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}

/* Card */
.stat-card {
  background: rgba(255,255,255,.03);
  border: 1px solid rgba(255,255,255,.07);
  border-radius: 24px;
  padding: 2.5rem 1.75rem;
  text-align: center;
  position: relative;
  overflow: hidden;
  transition: border-color .3s, transform .3s, box-shadow .3s;
}
.stat-card:hover {
  border-color: rgba(99,102,241,.4);
  transform: translateY(-6px);
  box-shadow: 0 20px 50px rgba(99,102,241,.15);
}

.stat-card__icon {
  width: 60px; height: 60px;
  border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.4rem; color: #fff;
  margin: 0 auto 1.25rem;
  box-shadow: 0 8px 24px rgba(99,102,241,.3);
}

.stat-card__value {
  font-size: 3rem;
  font-weight: 900;
  line-height: 1;
  margin-bottom: .5rem;
  background: linear-gradient(135deg, #e2e8f0, #ffffff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.stat-card__label {
  font-size: .78rem;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: #64748b;
}

.stat-card__line {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 3px;
  opacity: 0;
  transition: opacity .3s;
}
.stat-card:hover .stat-card__line { opacity: 1; }

@media (max-width: 768px) {
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 400px) {
  .stats-grid { grid-template-columns: 1fr 1fr; gap: 1rem; }
  .stat-card { padding: 1.75rem 1rem; }
  .stat-card__value { font-size: 2.25rem; }
}
</style>
