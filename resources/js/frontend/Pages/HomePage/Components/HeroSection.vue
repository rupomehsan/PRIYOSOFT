<template>
  <section class="hero-slider">

    <!-- Slides -->
    <div class="hero-track" :style="trackStyle">
      <div
        v-for="(slide, i) in visibleSlides"
        :key="i"
        class="hero-slide"
        :style="slideStyle(slide)"
      >
        <div class="hero-overlay"></div>
        <div class="container hero-content position-relative" style="z-index:2;">
          <div class="row align-items-center g-5 hero-row">

            <!-- Left: text -->
            <div class="col-lg-6">
              <span class="hero-badge">{{ slide.badge_text || 'Welcome to PriyoSoft' }}</span>
              <h1 class="hero-title">{{ slide.headline || 'Building Software That Matters' }}</h1>
              <p class="hero-sub">{{ slide.subheadline || 'We craft modern web & mobile solutions tailored for your business growth.' }}</p>
              <p v-if="slide.description" class="hero-desc">{{ slide.description }}</p>

              <div class="d-flex flex-wrap gap-3 mb-4">
                <a :href="slide.primary_button_url || '#products'" class="hero-btn-primary">
                  {{ slide.primary_button_text || 'Explore Our Work' }}
                  <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <a v-if="slide.secondary_button_text || !slide.primary_button_url"
                   :href="slide.secondary_button_url || '#newsletter'" class="hero-btn-secondary">
                  {{ slide.secondary_button_text || 'Contact Us' }}
                </a>
              </div>

              <div class="d-flex flex-wrap gap-4">
                <span class="hero-trust"><i class="fas fa-check-circle text-success me-1"></i> 100% Trusted</span>
                <span class="hero-trust"><i class="fas fa-shield-alt text-info me-1"></i> Secure & Reliable</span>
                <span class="hero-trust"><i class="fas fa-headset text-warning me-1"></i> 24/7 Support</span>
              </div>
            </div>

            <!-- Right: media -->
            <div class="col-lg-6 text-center">
              <div v-if="slide.media_type === 'video' && slide.video_url" class="hero-video-wrap">
                <iframe :src="youtubeEmbed(slide.video_url)" frameborder="0" allowfullscreen class="hero-video"></iframe>
              </div>
              <div v-else-if="slide.hero_image" class="hero-img-wrap">
                <div v-if="!imageLoadedMap[i]" class="hero-img-skeleton">
                  <div class="skeleton-shimmer"></div>
                  <div class="skeleton-lines">
                    <div class="skeleton-line skeleton-line--wide"></div>
                    <div class="skeleton-line skeleton-line--medium"></div>
                    <div class="skeleton-line skeleton-line--short"></div>
                  </div>
                </div>
                <img
                  :src="slide.hero_image"
                  :alt="slide.headline"
                  class="hero-img"
                  :class="{ 'hero-img--loaded': imageLoadedMap[i] }"
                  @load="onImageLoad(i)"
                />
              </div>
              <div v-else class="hero-placeholder">
                <i class="fas fa-code"></i>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Prev / Next arrows -->
    <button v-if="visibleSlides.length > 1" class="hero-arrow hero-arrow--prev" @click="prev" aria-label="Previous slide">
      <i class="fas fa-chevron-left"></i>
    </button>
    <button v-if="visibleSlides.length > 1" class="hero-arrow hero-arrow--next" @click="next" aria-label="Next slide">
      <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Dot indicators -->
    <div v-if="visibleSlides.length > 1" class="hero-dots">
      <button
        v-for="(_, i) in visibleSlides"
        :key="i"
        class="hero-dot"
        :class="{ active: i === current }"
        @click="goTo(i)"
        :aria-label="'Go to slide ' + (i + 1)"
      ></button>
    </div>

    <!-- Scroll cue -->
    <div class="hero-scroll" @click="scrollDown">
      <i class="fas fa-chevron-down"></i>
    </div>

  </section>
</template>

<script>
const FALLBACK = [
  {
    badge_text: 'Welcome to PriyoSoft',
    headline: 'Building Software That Matters',
    subheadline: 'We craft modern web & mobile solutions tailored for your business growth.',
    primary_button_text: 'Explore Our Work',
    primary_button_url: '#products',
    secondary_button_text: 'Contact Us',
    secondary_button_url: '#newsletter',
  },
  {
    badge_text: 'Enterprise Solutions',
    headline: 'From Startup MVP to Enterprise Scale',
    subheadline: 'Battle-tested Laravel & Vue.js architecture that grows with your business — without the tech debt.',
    primary_button_text: 'Our Products',
    primary_button_url: '#products',
    secondary_button_text: 'Meet the Team',
    secondary_button_url: '#team',
  },
  {
    badge_text: 'Trusted by 30+ Clients',
    headline: 'Your Vision, Our Craftsmanship',
    subheadline: '8+ years delivering clean code, on-time launches, and post-launch support that actually works.',
    primary_button_text: 'See Our Work',
    primary_button_url: '#products',
    secondary_button_text: 'Get In Touch',
    secondary_button_url: '#newsletter',
  },
];

const SLIDE_GRADIENTS = [
  'linear-gradient(135deg, #0f0f23 0%, #1a1a3e 40%, #2d1b69 70%, #4c3699 100%)',
  'linear-gradient(135deg, #0f2027 0%, #203a43 40%, #2c5364 100%)',
  'linear-gradient(135deg, #1a0533 0%, #2d0b5e 40%, #4a1572 70%, #6b21a8 100%)',
];

export default {
  name: 'HeroSection',
  props: {
    slides: { type: Array, default: () => [] },
  },
  data() {
    return {
      current: 0,
      timer: null,
      autoplay: 5000,
      imageLoadedMap: {},
    };
  },
  computed: {
    visibleSlides() {
      return this.slides.length ? this.slides : FALLBACK;
    },
    trackStyle() {
      return {
        transform: `translateX(-${this.current * 100}%)`,
        transition: 'transform .65s cubic-bezier(.77,0,.175,1)',
      };
    },
  },
  methods: {
    slideStyle(slide) {
      const idx = this.visibleSlides.indexOf(slide);
      return { background: SLIDE_GRADIENTS[idx % SLIDE_GRADIENTS.length] };
    },
    youtubeEmbed(url) {
      if (!url) return '';
      const m = url.match(/(?:v=|youtu\.be\/)([^&?/]+)/);
      return m ? `https://www.youtube.com/embed/${m[1]}?rel=0` : url;
    },
    goTo(i) {
      this.current = i;
      this.resetTimer();
    },
    next() {
      this.current = (this.current + 1) % this.visibleSlides.length;
      this.resetTimer();
    },
    prev() {
      this.current = (this.current - 1 + this.visibleSlides.length) % this.visibleSlides.length;
      this.resetTimer();
    },
    startTimer() {
      if (this.visibleSlides.length < 2) return;
      this.timer = setInterval(this.next, this.autoplay);
    },
    resetTimer() {
      clearInterval(this.timer);
      this.startTimer();
    },
    onImageLoad(i) {
      this.imageLoadedMap = { ...this.imageLoadedMap, [i]: true };
    },
    scrollDown() {
      const next = document.querySelector('.stats-wrap, section:not(.hero-slider)');
      if (next) next.scrollIntoView({ behavior: 'smooth' });
    },
  },
  mounted()  { this.startTimer(); },
  beforeUnmount() { clearInterval(this.timer); },
};
</script>

<style scoped>
/* ── Container ──────────────────────────── */
.hero-slider {
  position: relative;
  overflow: hidden;
  width: 100%;
}

/* ── Track ──────────────────────────────── */
.hero-track {
  display: flex;
  will-change: transform;
}

/* ── Individual slide ───────────────────── */
.hero-slide {
  min-width: 100%;
  position: relative;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(15,15,35,.88) 0%, rgba(76,54,153,.4) 100%);
  z-index: 1;
}

.hero-row {
  min-height: 92vh;
  padding: 6rem 0 5rem;
}

/* ── Badge ──────────────────────────────── */
.hero-badge {
  display: inline-block;
  background: linear-gradient(90deg, #667eea, #f093fb);
  color: #fff;
  font-size: .72rem;
  font-weight: 800;
  letter-spacing: 2px;
  text-transform: uppercase;
  padding: .4rem 1.25rem;
  border-radius: 50px;
  margin-bottom: 1.5rem;
}

/* ── Title ──────────────────────────────── */
.hero-title {
  font-size: clamp(2.2rem, 5vw, 3.5rem);
  font-weight: 800;
  line-height: 1.12;
  margin-bottom: 1.25rem;
  background: linear-gradient(135deg, #ffffff 0%, #c9d6ff 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.hero-sub {
  font-size: 1.15rem;
  color: rgba(255,255,255,.8);
  line-height: 1.65;
  margin-bottom: 1rem;
}
.hero-desc {
  font-size: .95rem;
  color: rgba(255,255,255,.6);
  line-height: 1.7;
  margin-bottom: 1.75rem;
}

/* ── Buttons ────────────────────────────── */
.hero-btn-primary {
  display: inline-flex;
  align-items: center;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff !important;
  padding: .85rem 2rem;
  border-radius: 50px;
  font-weight: 700;
  font-size: 1rem;
  text-decoration: none;
  transition: transform .25s, box-shadow .25s;
}
.hero-btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(102,126,234,.55);
}

.hero-btn-secondary {
  display: inline-flex;
  align-items: center;
  background: transparent;
  color: #fff !important;
  padding: .85rem 2rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: 1rem;
  text-decoration: none;
  border: 2px solid rgba(255,255,255,.45);
  transition: border-color .25s, background .25s;
}
.hero-btn-secondary:hover {
  border-color: #fff;
  background: rgba(255,255,255,.1);
}

.hero-trust {
  color: rgba(255,255,255,.7);
  font-size: .85rem;
  display: flex;
  align-items: center;
}

/* ── Media ──────────────────────────────── */
.hero-img-wrap {
  position: relative;
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(255,255,255,.1);
  border-radius: 24px;
  padding: .75rem;
  backdrop-filter: blur(8px);
  box-shadow: 0 30px 80px rgba(0,0,0,.4);
  min-height: 320px;
}
.hero-img {
  width: 100%;
  border-radius: 18px;
  display: block;
  opacity: 0;
  transition: opacity .5s ease;
}
.hero-img--loaded { opacity: 1; }
.hero-video-wrap { border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,.5); }
.hero-video { width: 100%; aspect-ratio: 16/9; }
.hero-placeholder {
  height: 360px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255,255,255,.04);
  border: 1px dashed rgba(255,255,255,.15);
  border-radius: 24px;
  font-size: 7rem;
  color: rgba(255,255,255,.12);
}

/* ── Image skeleton ─────────────────────── */
.hero-img-skeleton {
  position: absolute;
  inset: .75rem;
  border-radius: 18px;
  overflow: hidden;
  background: rgba(255,255,255,.06);
  z-index: 1;
}

.skeleton-shimmer {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    105deg,
    rgba(255,255,255,0)     0%,
    rgba(255,255,255,0)    38%,
    rgba(255,255,255,.09)  50%,
    rgba(255,255,255,0)    62%,
    rgba(255,255,255,0)   100%
  );
  background-size: 250% 100%;
  animation: skeleton-sweep 1.8s infinite linear;
}

@keyframes skeleton-sweep {
  0%   { background-position: -250% 0; }
  100% { background-position:  250% 0; }
}

.skeleton-lines {
  position: absolute;
  bottom: 1.5rem;
  left: 1.5rem;
  right: 1.5rem;
  display: flex;
  flex-direction: column;
  gap: .65rem;
  z-index: 1;
}

.skeleton-line {
  height: 11px;
  border-radius: 6px;
  background: rgba(255,255,255,.1);
  animation: skeleton-pulse 1.8s ease-in-out infinite;
}
.skeleton-line--wide   { width: 75%; }
.skeleton-line--medium { width: 55%; animation-delay: .2s; }
.skeleton-line--short  { width: 35%; animation-delay: .4s; }

@keyframes skeleton-pulse {
  0%, 100% { opacity: .4; }
  50%       { opacity: .85; }
}

/* ── Arrows ─────────────────────────────── */
.hero-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 10;
  width: 52px;
  height: 52px;
  border-radius: 50%;
  border: 2px solid rgba(255,255,255,.3);
  background: rgba(255,255,255,.1);
  backdrop-filter: blur(8px);
  color: #fff;
  font-size: 1.1rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background .25s, border-color .25s, transform .25s;
}
.hero-arrow:hover {
  background: linear-gradient(135deg, #667eea, #764ba2);
  border-color: transparent;
  transform: translateY(-50%) scale(1.08);
}
.hero-arrow--prev { left: 1.5rem; }
.hero-arrow--next { right: 1.5rem; }

/* ── Dots ───────────────────────────────── */
.hero-dots {
  position: absolute;
  bottom: 4.5rem;
  left: 50%;
  transform: translateX(-50%);
  z-index: 10;
  display: flex;
  gap: .6rem;
}
.hero-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  border: none;
  background: rgba(255,255,255,.35);
  cursor: pointer;
  padding: 0;
  transition: background .3s, transform .3s, width .3s;
}
.hero-dot.active {
  background: #fff;
  width: 28px;
  border-radius: 5px;
}

/* ── Scroll cue ─────────────────────────── */
.hero-scroll {
  position: absolute;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%);
  z-index: 10;
  color: rgba(255,255,255,.5);
  font-size: 1.4rem;
  cursor: pointer;
  animation: bounce 2s infinite;
}
@keyframes bounce {
  0%, 100% { transform: translateX(-50%) translateY(0); }
  50%       { transform: translateX(-50%) translateY(8px); }
}

/* ── Responsive ─────────────────────────── */
@media (max-width: 991px) {
  .hero-row { min-height: auto; padding: 5rem 0 6rem; }
  .hero-arrow { width: 42px; height: 42px; font-size: .9rem; }
  .hero-arrow--prev { left: .75rem; }
  .hero-arrow--next { right: .75rem; }
}
@media (max-width: 767px) {
  .hero-row { padding: 4rem 0 5rem; }
  .hero-title { font-size: 2rem; }
}
</style>
