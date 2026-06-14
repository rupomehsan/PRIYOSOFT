<template>
  <section id="testimonials" class="testimonials-section section-pad">
    <div class="container">
      <div class="section-head text-center">
        <span class="section-tag">Social Proof</span>
        <h2 class="section-title">What Our Clients Say</h2>
        <p class="section-sub">Real words from real people who trusted us with their vision.</p>
      </div>

      <div class="row g-4">
        <div v-for="t in items" :key="t.id" class="col-md-6 col-lg-4">
          <div class="t-card">
            <div class="t-card__quote"><i class="fas fa-quote-left"></i></div>
            <p class="t-card__message">{{ t.message }}</p>

            <div v-if="t.media_type === 'video' && t.video_url" class="t-card__video">
              <a :href="t.video_url" target="_blank" class="t-card__play">
                <i class="fab fa-youtube"></i> Watch Video Testimonial
              </a>
            </div>

            <div class="t-card__stars">
              <i v-for="n in 5" :key="n" class="fas fa-star" :class="n <= (t.rating || 5) ? 'filled' : 'empty'"></i>
            </div>
            <div class="t-card__client">
              <div class="t-card__avatar">
                <img v-if="t.client_photo" :src="t.client_photo" :alt="t.client_name" />
                <span v-else>{{ initial(t.client_name) }}</span>
              </div>
              <div class="t-card__info">
                <div class="t-card__name">{{ t.client_name }}</div>
                <div class="t-card__company">{{ t.client_company }}</div>
              </div>
              <span v-if="t.is_featured" class="t-card__featured"><i class="fas fa-medal"></i></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
const FALLBACK = [
  { id:1, client_name:'Karim Uddin',    client_company:'RetailPro BD',   rating:5, message:'PriyoSoft delivered our ERP in record time. The system is rock-solid and the team was incredibly responsive throughout.' },
  { id:2, client_name:'Sumaiya Haque',  client_company:'HealthLink Ltd',  rating:5, message:'We chose PriyoSoft for our hospital management system and could not be happier. Excellent code quality and great post-launch support.' },
  { id:3, client_name:'Imran Chowdhury',client_company:'LogiFlow Inc',    rating:5, message:'Their supply-chain dashboard transformed how we track inventory. Clean UI, fast performance, and very reasonable pricing.' },
];

export default {
  name: 'TestimonialsSection',
  props: { data: { type: Array, default: () => [] } },
  computed: {
    items() {
      const list = this.data.filter(t => t.is_visible !== false).slice(0, 6);
      return list.length ? list : FALLBACK;
    },
  },
  methods: {
    initial(name) { return name ? name[0].toUpperCase() : '?'; },
  },
};
</script>

<style scoped>
.testimonials-section { background: #fff; }

.t-card {
  background: #f8f9ff;
  border: 1px solid #e8eeff;
  border-radius: 20px;
  padding: 2rem 1.75rem;
  height: 100%;
  transition: all .35s;
  position: relative;
}
.t-card:hover {
  background: #fff;
  border-color: #667eea;
  box-shadow: 0 20px 50px rgba(102,126,234,.15);
  transform: translateY(-6px);
}
.t-card__quote {
  font-size: 2rem; color: #667eea; opacity: .5;
  margin-bottom: 1rem;
}
.t-card__message { font-size: .95rem; color: #374151; line-height: 1.8; margin-bottom: 1.25rem; flex: 1; }
.t-card__video { margin-bottom: 1rem; }
.t-card__play {
  display: inline-flex; align-items: center; gap: .5rem;
  color: #f5576c; font-weight: 600; font-size: .875rem; text-decoration: none;
  padding: .4rem .9rem; border-radius: 50px;
  border: 1.5px solid #f5576c; transition: all .25s;
}
.t-card__play:hover { background: #f5576c; color: #fff; }

.t-card__stars { margin-bottom: 1.25rem; }
.t-card__stars i { font-size: .9rem; margin-right: 2px; }
.filled { color: #f59e0b; }
.empty  { color: #d1d5db; }

.t-card__client { display: flex; align-items: center; gap: .875rem; }
.t-card__avatar {
  width: 48px; height: 48px; border-radius: 50%; overflow: hidden; flex-shrink: 0;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-weight: 700; font-size: 1.1rem;
}
.t-card__avatar img { width: 100%; height: 100%; object-fit: cover; }
.t-card__name    { font-weight: 700; font-size: .95rem; color: #1a1a3e; }
.t-card__company { font-size: .8rem; color: #9ca3af; }
.t-card__featured {
  margin-left: auto; color: #f59e0b; font-size: 1.2rem;
}

.t-skeleton {
  height: 260px; border-radius: 20px;
  background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
</style>
