<template>
  <section id="faq" class="faq-section section-pad section-dark">
    <div class="faq-glow"></div>
    <div class="container position-relative">
      <div class="row justify-content-center">
        <div class="col-lg-10">

          <!-- ── Skeleton ── -->
          <template v-if="loading">
            <div class="text-center" style="margin-bottom:3rem">
              <span class="skel skel-pill" style="height:26px;width:120px;display:inline-block;margin-bottom:1rem"></span>
              <div class="skel" style="height:36px;max-width:340px;margin:0 auto .75rem;border-radius:10px"></div>
              <div class="skel" style="height:13px;max-width:300px;margin:0 auto;border-radius:6px"></div>
            </div>
            <div class="faq-list">
              <div v-for="n in 5" :key="n" class="skel-card" style="border-radius:16px;padding:1.35rem 1.5rem;display:flex;align-items:center;gap:1.25rem">
                <span class="skel skel-pill" style="width:36px;height:26px;flex-shrink:0;border-radius:8px"></span>
                <span class="skel" :style="`height:16px;width:${55 + n * 7}%;border-radius:6px`"></span>
                <span class="skel skel-circle" style="width:30px;height:30px;flex-shrink:0;margin-left:auto"></span>
              </div>
            </div>
          </template>

          <!-- ── Real content ── -->
          <template v-else>
          <div class="section-head text-center animate from-bottom section-content-in">
            <span class="section-tag">Got Questions?</span>
            <h2 class="section-title">Frequently Asked <span class="gradient-text shimmer-text">Questions</span></h2>
            <div class="ps-divider">
              <span class="ps-divider__bar"></span>
              <i class="fas fa-circle ps-divider__dot"></i>
              <span class="ps-divider__bar"></span>
            </div>
            <p class="section-sub">Everything you need to know about working with us.</p>
          </div>

          <div class="faq-cols">
            <div class="faq-list animate from-bottom">
              <div
                v-for="(faq, i) in items"
                :key="faq.id || i"
                class="faq-item"
                :class="{ 'faq-item--open': openIndex === i }"
              >
                <button class="faq-q" @click="toggle(i)">
                  <span class="faq-q__num">{{ String(i + 1).padStart(2, '0') }}</span>
                  <span class="faq-q__text">{{ faq.question }}</span>
                  <span class="faq-q__icon" :class="{ rotated: openIndex === i }">
                    <i class="fas fa-plus"></i>
                  </span>
                </button>
                <transition name="faq-slide">
                  <div v-if="openIndex === i" class="faq-a">
                    <p>{{ faq.answer }}</p>
                  </div>
                </transition>
              </div>
            </div>
          </div>

          </template><!-- /v-else -->

        </div>
      </div>
    </div>
  </section>
</template>

<script>
const FALLBACK = [
  { id:1, question:'What technologies do you use?',             answer:'We primarily build with Laravel (PHP) and Vue.js / React on the frontend. For mobile we use Flutter. Infrastructure runs on AWS and DigitalOcean with Docker-based deployments.' },
  { id:2, question:'How long does a typical project take?',     answer:'A standard SaaS MVP takes 6–12 weeks. Enterprise systems typically run 3–6 months. We provide a detailed timeline after the discovery phase.' },
  { id:3, question:'Do you offer support after launch?',        answer:'Yes — we offer maintenance packages covering bug fixes, security patches, and feature additions. Most clients stay with us 12+ months post-launch.' },
  { id:4, question:'Can you work with our existing codebase?',  answer:'Absolutely. We regularly perform code audits, refactors, and feature additions on legacy codebases. We assess first and give honest recommendations.' },
  { id:5, question:'How do we get started?',                    answer:'Send us a message via the contact form below or email  We schedule a free discovery call within 24 hours to understand your needs and propose a plan.' },
];

export default {
  name: 'FaqSection',
  props: {
    data:    { type: Array,   default: () => [] },
    loading: { type: Boolean, default: false },
  },
  data: () => ({ openIndex: 0 }),
  computed: {
    items() {
      const list = this.data.filter(f => f.is_visible !== false);
      return list.length ? list : FALLBACK;
    },
  },
  methods: {
    toggle(i) { this.openIndex = this.openIndex === i ? null : i; },
  },
};
</script>

<style scoped>
.faq-section {
  background: var(--ps-bg-4);
  position: relative;
  overflow: hidden;
}
.faq-glow {
  position: absolute;
  width: 600px; height: 600px;
  border-radius: 50%;
  background: rgba(99,102,241,.08);
  filter: blur(100px);
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  pointer-events: none;
}

/* List */
.faq-list { display: flex; flex-direction: column; gap: .85rem; }

/* Item */
.faq-item {
  background: var(--ps-card-bg);
  border: 1px solid var(--ps-card-border);
  border-radius: 16px;
  overflow: hidden;
  transition: border-color .3s, background .3s;
}
.faq-item--open {
  background: rgba(99,102,241,.07);
  border-color: rgba(99,102,241,.35);
}

/* Question button */
.faq-q {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 1.25rem;
  padding: 1.35rem 1.5rem;
  background: none; border: none;
  text-align: left; cursor: pointer;
}

.faq-q__num {
  font-size: .72rem; font-weight: 900;
  color: #6366f1; background: rgba(99,102,241,.1);
  padding: .3rem .65rem; border-radius: 8px;
  flex-shrink: 0; letter-spacing: .5px;
}

.faq-q__text {
  flex: 1;
  font-weight: 700; font-size: .97rem;
  color: var(--ps-text-h); line-height: 1.45;
}

.faq-q__icon {
  width: 30px; height: 30px; border-radius: 50%;
  border: 1px solid var(--ps-card-border);
  background: var(--ps-card-bg);
  color: var(--ps-text-body);
  display: flex; align-items: center; justify-content: center;
  font-size: .75rem; flex-shrink: 0;
  transition: transform .3s, background .3s, color .3s, border-color .3s;
}
.faq-q__icon.rotated {
  transform: rotate(45deg);
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  border-color: transparent;
  color: #fff;
}

/* Answer */
.faq-a { padding: 0 1.5rem 1.5rem 4.25rem; }
.faq-a p {
  font-size: .9rem;
  color: var(--ps-text-faint);
  line-height: 1.85;
  margin: 0;
}

/* Transition */
.faq-slide-enter-active,
.faq-slide-leave-active { transition: all .3s ease; max-height: 500px; overflow: hidden; }
.faq-slide-enter-from,
.faq-slide-leave-to     { opacity: 0; transform: translateY(-6px); max-height: 0; }
</style>
