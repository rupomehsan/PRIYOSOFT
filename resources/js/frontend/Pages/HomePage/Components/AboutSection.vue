<template>
  <section id="about" class="about-section section-pad">
    <div class="container">

      <!-- Story / Main about -->
      <div class="row align-items-center g-5 mb-5">
        <div class="col-lg-6">
          <div class="about__img-wrap">
            <img v-if="storyItem && storyItem.image" :src="storyItem.image" alt="About Us" class="about__img" />
            <div v-else class="about__img-placeholder">
              <i class="fas fa-laptop-code"></i>
            </div>
            <div class="about__badge">
              <i class="fas fa-award me-2"></i>
              {{ yearsExp }}+ Years of Excellence
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <span class="section-tag">Who We Are</span>
          <h2 class="section-title">{{ storyTitle }}</h2>
          <p class="about__lead">{{ storyDesc }}</p>

          <div class="row g-3 mt-2">
            <div v-for="(kv, i) in keyValues" :key="i" class="col-6">
              <div class="kv-card">
                <i :class="kv.icon" class="kv-card__icon"></i>
                <div>
                  <div class="kv-card__title">{{ kv.title }}</div>
                  <div class="kv-card__desc">{{ kv.desc }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Mission / Vision / Values cards -->
      <div v-if="pillars.length" class="row g-4">
        <div v-for="(p, i) in pillars" :key="i" class="col-md-4">
          <div class="pillar-card" :class="'pillar-card--' + (i % 3)">
            <div class="pillar-card__icon-wrap">
              <i :class="pillarIcon(p.section)"></i>
            </div>
            <h4 class="pillar-card__title">{{ p.title || pillarLabel(p.section) }}</h4>
            <p class="pillar-card__desc">{{ p.description }}</p>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script>
const FALLBACK_STORY = {
  title: 'Crafting Digital Excellence Since 2016',
  description: 'We are a passionate team of developers, designers, and strategists dedicated to building software that drives real business results. From startup MVPs to enterprise-scale platforms, we deliver with precision and care.',
};
const PILLAR_ICONS = { story: 'fas fa-book-open', mission: 'fas fa-bullseye', vision: 'fas fa-eye', value: 'fas fa-gem', stat: 'fas fa-chart-bar' };
const PILLAR_LABELS = { story: 'Our Story', mission: 'Our Mission', vision: 'Our Vision', value: 'Our Values' };

export default {
  name: 'AboutSection',
  props: { data: { type: Array, default: () => [] } },
  computed: {
    storyItem() { return this.data.find(s => s.section === 'story') || null; },
    storyTitle() { return this.storyItem?.title || FALLBACK_STORY.title; },
    storyDesc()  { return this.storyItem?.description || FALLBACK_STORY.description; },
    yearsExp()   { return new Date().getFullYear() - 2016; },
    pillars()    { return this.data.filter(s => ['mission','vision','value'].includes(s.section)); },
    keyValues() {
      return [
        { icon: 'fas fa-rocket',      title: 'Fast Delivery',   desc: 'We ship on time, every time.' },
        { icon: 'fas fa-shield-alt',  title: 'Reliable Code',   desc: 'Clean, tested, maintainable.' },
        { icon: 'fas fa-users',       title: 'Client-Focused',  desc: 'Your success is our goal.' },
        { icon: 'fas fa-lightbulb',   title: 'Innovation',      desc: 'Always evolving our stack.' },
      ];
    },
  },
  methods: {
    pillarIcon(s)  { return PILLAR_ICONS[s]  || 'fas fa-star'; },
    pillarLabel(s) { return PILLAR_LABELS[s] || s; },
  },
};
</script>

<style scoped>
.about-section { background: #fff; }

.about__img-wrap { position: relative; }
.about__img { width: 100%; border-radius: 24px; box-shadow: 0 24px 60px rgba(102,126,234,.2); }
.about__img-placeholder {
  height: 400px; border-radius: 24px;
  background: linear-gradient(135deg, #eef2ff, #f5f3ff);
  display: flex; align-items: center; justify-content: center;
  font-size: 6rem; color: #a5b4fc;
  border: 2px dashed #c7d2fe;
}
.about__badge {
  position: absolute; bottom: -1.5rem; right: -1.5rem;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff;
  padding: 1rem 1.5rem;
  border-radius: 16px;
  font-weight: 700;
  box-shadow: 0 10px 30px rgba(102,126,234,.4);
  font-size: .95rem;
}
.about__lead { font-size: 1.1rem; color: #374151; line-height: 1.8; margin-bottom: 1.5rem; }

.kv-card {
  display: flex; gap: .75rem; align-items: flex-start;
  padding: 1rem; border-radius: 14px;
  background: #f8f9ff; border: 1px solid #e8eeff;
  transition: all .3s;
}
.kv-card:hover { border-color: #667eea; background: #eef2ff; }
.kv-card__icon { font-size: 1.3rem; color: #667eea; margin-top: .15rem; }
.kv-card__title { font-weight: 700; font-size: .95rem; color: #1a1a3e; }
.kv-card__desc  { font-size: .8rem; color: #6b7280; }

/* Pillars */
.pillar-card {
  padding: 2rem 1.5rem; border-radius: 20px; text-align: center;
  transition: all .35s; border: 2px solid transparent; height: 100%;
}
.pillar-card--0 { background: #f0f4ff; }
.pillar-card--1 { background: #fdf4ff; }
.pillar-card--2 { background: #f0fdf9; }
.pillar-card:hover { transform: translateY(-6px); border-color: #667eea; box-shadow: 0 16px 40px rgba(102,126,234,.15); }
.pillar-card__icon-wrap {
  width: 72px; height: 72px; border-radius: 20px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.75rem; color: #fff;
  margin: 0 auto 1.25rem;
  box-shadow: 0 8px 20px rgba(102,126,234,.35);
}
.pillar-card__title { font-weight: 700; font-size: 1.15rem; color: #1a1a3e; margin-bottom: .75rem; }
.pillar-card__desc  { font-size: .9rem; color: #6b7280; line-height: 1.7; }

@media (max-width: 991px) { .about__badge { display: none; } }
</style>
