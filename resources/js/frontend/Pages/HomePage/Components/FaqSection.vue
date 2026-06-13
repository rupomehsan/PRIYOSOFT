<template>
  <section id="faq" class="faq-section section-pad">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="section-head text-center">
            <span class="section-tag">Got Questions?</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-sub">Everything you need to know about working with us.</p>
          </div>

          <div v-if="!items.length" class="faq-fallback">
            <div v-for="i in 4" :key="i" class="faq-skeleton mb-3"></div>
          </div>

          <div v-else class="faq-list">
            <div v-for="(faq, i) in items" :key="faq.id || i" class="faq-item" :class="{ 'faq-item--open': openIndex === i }">
              <button class="faq-q" @click="toggle(i)">
                <span class="faq-q__num">{{ String(i + 1).padStart(2, '0') }}</span>
                <span class="faq-q__text">{{ faq.question }}</span>
                <span class="faq-q__icon">
                  <i class="fas" :class="openIndex === i ? 'fa-minus' : 'fa-plus'"></i>
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
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'FaqSection',
  props: { data: { type: Array, default: () => [] } },
  data: () => ({ openIndex: 0 }),
  computed: {
    items() { return this.data.filter(f => f.is_visible !== false); },
  },
  methods: {
    toggle(i) { this.openIndex = this.openIndex === i ? null : i; },
  },
};
</script>

<style scoped>
.faq-section { background: #fff; }

.faq-item {
  border: 1.5px solid #e8eeff;
  border-radius: 16px;
  margin-bottom: 1rem;
  overflow: hidden;
  transition: border-color .3s, box-shadow .3s;
  background: #f8f9ff;
}
.faq-item--open {
  border-color: #667eea;
  box-shadow: 0 8px 24px rgba(102,126,234,.15);
  background: #fff;
}
.faq-q {
  width: 100%; display: flex; align-items: center; gap: 1rem;
  padding: 1.25rem 1.5rem;
  background: none; border: none; text-align: left; cursor: pointer;
}
.faq-q__num {
  font-size: .75rem; font-weight: 800; color: #667eea;
  background: #eef2ff; padding: .3rem .6rem; border-radius: 8px; flex-shrink: 0;
}
.faq-q__text { flex: 1; font-weight: 600; font-size: 1rem; color: #1a1a3e; line-height: 1.5; }
.faq-q__icon {
  width: 32px; height: 32px; border-radius: 50%;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff; display: flex; align-items: center; justify-content: center;
  font-size: .85rem; flex-shrink: 0;
  transition: transform .3s;
}
.faq-item--open .faq-q__icon { background: linear-gradient(135deg, #764ba2, #667eea); }

.faq-a { padding: 0 1.5rem 1.5rem 4rem; }
.faq-a p { font-size: .95rem; color: #374151; line-height: 1.8; margin: 0; }

.faq-slide-enter-active, .faq-slide-leave-active { transition: all .3s ease; }
.faq-slide-enter-from, .faq-slide-leave-to { opacity: 0; transform: translateY(-8px); }

.faq-skeleton {
  height: 64px; border-radius: 16px;
  background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
</style>
