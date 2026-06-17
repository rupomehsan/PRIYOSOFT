<template>
  <section id="about" class="about-section section-pad section-dark">
    <div class="about-glow about-glow--1"></div>
    <div class="about-glow about-glow--2"></div>
    <div class="container position-relative">

      <!-- Story block -->
      <div class="row align-items-center g-5 mb-5">

        <!-- Visual left -->
        <div class="col-lg-5">
          <div class="about-visual">
            <div class="about-img-frame">
              <img v-if="storyItem && storyItem.image" :src="storyItem.image" alt="About PriyoSoft" class="about-img" />
              <div v-else class="about-img-code">
                <div class="code-line" v-for="l in codeLines" :key="l.id" :style="{ width: l.w, background: l.c, opacity: l.o }"></div>
              </div>
            </div>
            <div v-if="statBadge0" class="about-badge-yr">
              <span class="badge-num">{{ statBadge0.stat_value }}</span>
              <span class="badge-txt" v-html="statBadge0.stat_label.replace(' ', '<br>')"></span>
            </div>
            <div v-if="statBadge1" class="about-badge-proj">
              <i class="fas fa-rocket mb-1"></i>
              <span>{{ statBadge1.stat_value }} {{ statBadge1.stat_label }}</span>
            </div>
          </div>
        </div>

        <!-- Text right -->
        <div class="col-lg-7">
          <span class="section-tag">{{ sectionBadge }}</span>
          <h2 class="section-title">{{ sectionTitle }}</h2>
          <p class="about-lead">{{ sectionDesc }}</p>

          <div class="kv-grid">
            <div v-for="(kv, i) in keyValues" :key="i" class="kv-card">
              <div class="kv-card__icon">
                <i :class="kv.icon"></i>
              </div>
              <div>
                <div class="kv-card__title">{{ kv.title }}</div>
                <div class="kv-card__desc">{{ kv.description || kv.desc }}</div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Mission / Vision / Values -->
      <div v-if="pillars.length" class="pillar-row">
        <div v-for="(p, i) in pillars" :key="i" class="pillar-card" :class="'pillar-card--' + (i % 3)">
          <div class="pillar-icon">
            <i :class="pillarIcon(p.section)"></i>
          </div>
          <h4 class="pillar-title">{{ p.title || pillarLabel(p.section) }}</h4>
          <p class="pillar-desc">{{ p.description }}</p>
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
const PILLAR_ICONS  = { story:'fas fa-book-open', mission:'fas fa-bullseye', vision:'fas fa-eye', value:'fas fa-gem' };
const PILLAR_LABELS = { story:'Our Story', mission:'Our Mission', vision:'Our Vision', value:'Our Values' };

export default {
  name: 'AboutSection',
  props: {
    data:      { type: Array,  default: () => [] },
    whoWeAre:  { type: Object, default: () => null },
  },
  computed: {
    storyItem()    { return this.data.find(s => s.section === 'story') || null; },
    sectionBadge() { return this.whoWeAre?.badge_label || 'Who We Are'; },
    sectionTitle() { return this.whoWeAre?.title || this.storyItem?.title || FALLBACK_STORY.title; },
    sectionDesc()  { return this.whoWeAre?.description || this.storyItem?.description || FALLBACK_STORY.description; },
    storyTitle()   { return this.sectionTitle; },
    storyDesc()    { return this.sectionDesc; },
    yearsExp()   { return new Date().getFullYear() - 2016; },
    pillars()    { return this.data.filter(s => ['mission','vision','value'].includes(s.section)); },
    statsArr()   {
      const s = this.whoWeAre?.stats;
      if (!s) return [];
      return Array.isArray(s) ? s : (typeof s === 'string' ? JSON.parse(s) : []);
    },
    statBadge0() { return this.statsArr[0] || null; },
    statBadge1() { return this.statsArr[1] || null; },
    keyValues() {
      const f = this.whoWeAre?.features;
      if (f) {
        const arr = Array.isArray(f) ? f : (typeof f === 'string' ? JSON.parse(f) : []);
        if (arr.length) return arr;
      }
      return [
        { icon:'fas fa-rocket',     title:'Fast Delivery',  description:'We ship on time, every time.' },
        { icon:'fas fa-shield-alt', title:'Reliable Code',  description:'Clean, tested, maintainable.' },
        { icon:'fas fa-users',      title:'Client-Focused', description:'Your success is our goal.' },
        { icon:'fas fa-lightbulb',  title:'Innovation',     description:'Always evolving our stack.' },
      ];
    },
    codeLines() {
      return [
        { id:1,  w:'55%', c:'#6366f1', o:.9 },{ id:2,  w:'80%', c:'#8b5cf6', o:.6 },
        { id:3,  w:'40%', c:'#06b6d4', o:.8 },{ id:4,  w:'70%', c:'rgba(255,255,255,.15)', o:1 },
        { id:5,  w:'90%', c:'#6366f1', o:.5 },{ id:6,  w:'60%', c:'#8b5cf6', o:.7 },
        { id:7,  w:'35%', c:'#06b6d4', o:.9 },{ id:8,  w:'75%', c:'rgba(255,255,255,.1)', o:1 },
        { id:9,  w:'50%', c:'#6366f1', o:.6 },{ id:10, w:'85%', c:'#8b5cf6', o:.4 },
        { id:11, w:'45%', c:'#06b6d4', o:.7 },{ id:12, w:'65%', c:'rgba(255,255,255,.12)', o:1 },
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
.about-section {
  background: var(--ps-bg-2);
  position: relative;
  overflow: hidden;
}

/* Glows */
.about-glow {
  position: absolute;
  border-radius: 50%;
  filter: blur(100px);
  pointer-events: none;
}
.about-glow--1 { width:600px;height:600px;background:rgba(99,102,241,.1);top:-150px;left:-150px; }
.about-glow--2 { width:500px;height:500px;background:rgba(6,182,212,.08);bottom:-150px;right:-100px; }

/* Visual */
.about-visual { position: relative; }

.about-img-frame {
  border-radius: 24px;
  overflow: hidden;
  border: 1px solid rgba(255,255,255,.08);
  background: rgba(255,255,255,.03);
  aspect-ratio: 4/3;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
}
.about-img { width:100%;height:100%;object-fit:cover;border-radius:18px; }

/* Code-lines visual placeholder */
.about-img-code {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: .65rem;
  padding: 1rem;
}
.code-line {
  height: 10px;
  border-radius: 6px;
}

/* Floating badges */
.about-badge-yr,
.about-badge-proj {
  position: absolute;
  border-radius: 16px;
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,.12);
}
.about-badge-yr {
  bottom: -1.25rem; left: -1.25rem;
  background: rgba(99,102,241,.2);
  padding: 1rem 1.5rem;
  display: flex; align-items: center; gap: .75rem;
}
.badge-num { font-size: 2rem; font-weight: 900; color: #fff; line-height: 1; }
.badge-txt { font-size: .75rem; font-weight: 600; color: #c4b5fd; line-height: 1.35; }

.about-badge-proj {
  top: -1rem; right: -1rem;
  background: rgba(6,182,212,.15);
  padding: .75rem 1.25rem;
  display: flex; flex-direction: column; align-items: center;
  font-size: .8rem; font-weight: 700; color: #67e8f9;
}
.about-badge-proj i { font-size: 1.1rem; }

/* Text */
.about-lead {
  font-size: 1.05rem;
  color: var(--ps-text-body);
  line-height: 1.85;
  margin-bottom: 2rem;
}

/* KV grid */
.kv-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}
.kv-card {
  display: flex;
  gap: .85rem;
  align-items: flex-start;
  padding: 1.1rem 1.25rem;
  border-radius: 14px;
  background: var(--ps-card-bg);
  border: 1px solid var(--ps-card-border);
  transition: border-color .3s, background .3s;
}
.kv-card:hover { border-color: rgba(99,102,241,.35); background: rgba(99,102,241,.06); }
.kv-card__icon {
  width: 38px; height: 38px; border-radius: 10px;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  display: flex; align-items: center; justify-content: center;
  font-size: .95rem; color: #fff; flex-shrink: 0;
}
.kv-card__title { font-weight: 700; font-size: .9rem; color: var(--ps-text-h); margin-bottom: .2rem; }
.kv-card__desc  { font-size: .78rem; color: var(--ps-text-faint); }

/* Pillars */
.pillar-row {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
  margin-top: 4rem;
}
.pillar-card {
  padding: 2.25rem 2rem;
  border-radius: 20px;
  border: 1px solid var(--ps-card-border);
  background: var(--ps-card-bg);
  transition: transform .3s, border-color .3s, box-shadow .3s;
}
.pillar-card:hover {
  transform: translateY(-6px);
  border-color: rgba(99,102,241,.35);
  box-shadow: 0 20px 50px rgba(99,102,241,.1);
}
.pillar-card--0 .pillar-icon { background: linear-gradient(135deg,#6366f1,#8b5cf6); }
.pillar-card--1 .pillar-icon { background: linear-gradient(135deg,#06b6d4,#3b82f6); }
.pillar-card--2 .pillar-icon { background: linear-gradient(135deg,#10b981,#06b6d4); }

.pillar-icon {
  width: 60px; height: 60px; border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.5rem; color: #fff;
  margin-bottom: 1.25rem;
  box-shadow: 0 8px 24px rgba(99,102,241,.25);
}
.pillar-title { font-weight: 800; font-size: 1.1rem; color: var(--ps-text-h); margin-bottom: .6rem; }
.pillar-desc  { font-size: .875rem; color: var(--ps-text-faint); line-height: 1.75; margin: 0; }

@media (max-width: 991px) {
  .about-badge-yr  { display: none; }
  .about-badge-proj { display: none; }
  .pillar-row { grid-template-columns: 1fr; }
}
@media (max-width: 576px) {
  .kv-grid { grid-template-columns: 1fr; }
}
</style>
