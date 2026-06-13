<template>
  <section class="hero-wrap" :style="bgStyle">
    <div class="hero-overlay"></div>
    <div class="container position-relative" style="z-index:2;">
      <div class="row align-items-center g-5 hero-row">

        <!-- Left: text -->
        <div class="col-lg-6">
          <span class="hero-badge">{{ badge }}</span>
          <h1 class="hero-title">{{ headline }}</h1>
          <p class="hero-sub">{{ subheadline }}</p>
          <p v-if="description" class="hero-desc">{{ description }}</p>

          <div class="d-flex flex-wrap gap-3 mb-4">
            <a :href="primaryUrl" class="hero-btn-primary">
              {{ primaryText }} <i class="fas fa-arrow-right ms-2"></i>
            </a>
            <a v-if="secondaryText" :href="secondaryUrl" class="hero-btn-secondary">
              {{ secondaryText }}
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
          <div v-if="mediaType === 'video' && videoUrl" class="hero-video-wrap">
            <iframe :src="youtubeEmbed" frameborder="0" allowfullscreen class="hero-video"></iframe>
          </div>
          <div v-else-if="heroImage" class="hero-img-wrap">
            <img :src="heroImage" :alt="headline" class="hero-img" />
          </div>
          <div v-else class="hero-placeholder">
            <i class="fas fa-code"></i>
          </div>
        </div>

      </div>
    </div>

    <!-- Scroll cue -->
    <div class="hero-scroll" @click="scrollDown">
      <i class="fas fa-chevron-down"></i>
    </div>
  </section>
</template>

<script>
export default {
  name: 'HeroSection',
  props: { data: { type: Object, default: null } },
  computed: {
    badge()       { return this.data?.badge_text          || 'Welcome to PriyoSoft'; },
    headline()    { return this.data?.headline             || 'Building Software That Matters'; },
    subheadline() { return this.data?.subheadline          || 'We craft modern web & mobile solutions tailored for your business growth.'; },
    description() { return this.data?.description          || null; },
    primaryText() { return this.data?.primary_button_text  || 'Explore Our Work'; },
    primaryUrl()  { return this.data?.primary_button_url   || '#products'; },
    secondaryText(){ return this.data?.secondary_button_text || 'Contact Us'; },
    secondaryUrl(){ return this.data?.secondary_button_url  || '#contact'; },
    mediaType()   { return this.data?.media_type            || 'image'; },
    heroImage()   { return this.data?.hero_image            || this.data?.background_image || null; },
    videoUrl()    { return this.data?.video_url             || null; },
    bgStyle() {
      if (this.data?.background_image) return { backgroundImage: `url(${this.data.background_image})` };
      return {};
    },
    youtubeEmbed() {
      if (!this.videoUrl) return '';
      const m = this.videoUrl.match(/(?:v=|youtu\.be\/)([^&?/]+)/);
      return m ? `https://www.youtube.com/embed/${m[1]}?rel=0` : this.videoUrl;
    },
  },
  methods: {
    scrollDown() {
      const next = document.querySelector('.stats-wrap, section:not(.hero-wrap)');
      if (next) next.scrollIntoView({ behavior: 'smooth' });
    },
  },
};
</script>

<style scoped>
.hero-wrap {
  position: relative;
  background: linear-gradient(135deg, #0f0f23 0%, #1a1a3e 40%, #2d1b69 70%, #4c3699 100%);
  background-size: cover;
  background-position: center;
  overflow: hidden;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(15,15,35,.9) 0%, rgba(76,54,153,.45) 100%);
  z-index: 1;
}

.hero-row {
  min-height: 92vh;
  padding: 6rem 0 5rem;
}

/* Badge */
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

/* Title */
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

/* Buttons */
.hero-btn-primary {
  display: inline-flex;
  align-items: center;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff;
  padding: .85rem 2rem;
  border-radius: 50px;
  font-weight: 700;
  font-size: 1rem;
  text-decoration: none;
  border: 2px solid transparent;
  transition: transform .25s, box-shadow .25s;
}
.hero-btn-primary:hover {
  color: #fff;
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(102,126,234,.55);
}

.hero-btn-secondary {
  display: inline-flex;
  align-items: center;
  background: transparent;
  color: #fff;
  padding: .85rem 2rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: 1rem;
  text-decoration: none;
  border: 2px solid rgba(255,255,255,.45);
  transition: border-color .25s, background .25s;
}
.hero-btn-secondary:hover {
  color: #fff;
  border-color: #fff;
  background: rgba(255,255,255,.1);
}

.hero-trust {
  color: rgba(255,255,255,.7);
  font-size: .85rem;
  display: flex;
  align-items: center;
}

/* Media */
.hero-img-wrap {
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(255,255,255,.1);
  border-radius: 24px;
  padding: .75rem;
  backdrop-filter: blur(8px);
  box-shadow: 0 30px 80px rgba(0,0,0,.4);
}
.hero-img {
  width: 100%;
  border-radius: 18px;
  display: block;
}
.hero-video-wrap {
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,0,0,.5);
}
.hero-video {
  width: 100%;
  aspect-ratio: 16 / 9;
}
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

/* Scroll cue */
.hero-scroll {
  position: absolute;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%);
  z-index: 3;
  color: rgba(255,255,255,.5);
  font-size: 1.4rem;
  cursor: pointer;
  animation: bounce 2s infinite;
}
@keyframes bounce {
  0%, 100% { transform: translateX(-50%) translateY(0); }
  50%       { transform: translateX(-50%) translateY(8px); }
}

@media (max-width: 991px) {
  .hero-row { min-height: auto; padding: 5rem 0 6rem; }
}
@media (max-width: 767px) {
  .hero-row { padding: 4rem 0 5rem; }
  .hero-title { font-size: 2rem; }
}
</style>
