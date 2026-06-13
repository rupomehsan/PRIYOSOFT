<template>
  <section class="stats-wrap stats-section">
    <div class="container">
      <div class="row g-4 justify-content-center">
        <div v-for="(stat, i) in visibleStats" :key="i" class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-icon" :style="{ background: stat.color }">
              <i :class="stat.icon || 'fas fa-chart-bar'"></i>
            </div>
            <div class="stat-value">{{ stat.stat_value || stat.value }}</div>
            <div class="stat-label">{{ stat.stat_label || stat.title }}</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
const FALLBACK = [
  { stat_value: '50+',  stat_label: 'Projects Delivered', icon: 'fas fa-rocket',     color: 'linear-gradient(135deg,#667eea,#764ba2)' },
  { stat_value: '30+',  stat_label: 'Happy Clients',      icon: 'fas fa-users',      color: 'linear-gradient(135deg,#f093fb,#f5576c)' },
  { stat_value: '8+',   stat_label: 'Years Experience',   icon: 'fas fa-calendar',   color: 'linear-gradient(135deg,#4facfe,#00f2fe)' },
  { stat_value: '99%',  stat_label: 'Client Satisfaction',icon: 'fas fa-star',       color: 'linear-gradient(135deg,#43e97b,#38f9d7)' },
];
const ICONS = ['fas fa-rocket','fas fa-users','fas fa-calendar-check','fas fa-star','fas fa-trophy','fas fa-code'];
const COLORS = [
  'linear-gradient(135deg,#667eea,#764ba2)',
  'linear-gradient(135deg,#f093fb,#f5576c)',
  'linear-gradient(135deg,#4facfe,#00f2fe)',
  'linear-gradient(135deg,#43e97b,#38f9d7)',
];

export default {
  name: 'StatsSection',
  props: {
    data: { type: Array, default: () => [] },
  },
  computed: {
    stats() {
      return this.data.filter(s => s.section === 'stat');
    },
    visibleStats() {
      if (!this.stats.length) return FALLBACK;
      return this.stats.map((s, i) => ({ ...s, icon: ICONS[i % ICONS.length], color: COLORS[i % COLORS.length] }));
    },
  },
};
</script>

<style scoped>
.stats-section {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 3.5rem 0;
}
.stat-card {
  text-align: center;
  color: #fff;
  padding: 1.5rem 1rem;
}
.stat-icon {
  width: 64px; height: 64px;
  border-radius: 18px;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1rem;
  font-size: 1.6rem;
  background: rgba(255,255,255,.15) !important;
}
.stat-value {
  font-size: 2.25rem;
  font-weight: 800;
  line-height: 1;
  margin-bottom: .4rem;
}
.stat-label {
  font-size: .875rem;
  opacity: .85;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 600;
}
</style>
