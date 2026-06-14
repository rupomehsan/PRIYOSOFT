<template>
  <section id="team" class="team-section section-pad">
    <div class="container">
      <div class="section-head text-center">
        <span class="section-tag">The People Behind</span>
        <h2 class="section-title">Meet Our Team</h2>
        <p class="section-sub">Talented individuals working together to build extraordinary things.</p>
      </div>

      <div class="row g-4 justify-content-center">
        <div v-for="member in items" :key="member.id" class="col-sm-6 col-md-4 col-lg-3">
          <div class="team-card">
            <div class="team-card__photo-wrap">
              <img v-if="member.photo" :src="member.photo" :alt="member.name" class="team-card__photo" />
              <div v-else class="team-card__initial">{{ initials(member.name) }}</div>
              <div class="team-card__overlay">
                <div class="team-card__socials">
                  <a v-if="member.linkedin" :href="member.linkedin" target="_blank" class="social-btn">
                    <i class="fab fa-linkedin-in"></i>
                  </a>
                  <a v-if="member.github" :href="member.github" target="_blank" class="social-btn">
                    <i class="fab fa-github"></i>
                  </a>
                </div>
              </div>
            </div>
            <div class="team-card__body">
              <h5 class="team-card__name">{{ member.name }}</h5>
              <p class="team-card__role">{{ member.role }}</p>
              <p v-if="member.bio" class="team-card__bio">{{ truncate(member.bio, 80) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
const FALLBACK = [
  { id:1, name:'Ahsan Habib',     role:'CEO & Co-founder',       bio:'Leads vision and strategy. 10+ years building software products.' },
  { id:2, name:'Nadia Rahman',    role:'CTO',                    bio:'Architect of our core platforms. Loves clean code and fast APIs.' },
  { id:3, name:'Rifat Islam',     role:'Lead Designer',          bio:'Crafts interfaces that are beautiful and accessible.' },
  { id:4, name:'Tanvir Ahmed',    role:'Senior Developer',       bio:'Full-stack engineer with a passion for performance.' },
];

export default {
  name: 'TeamSection',
  props: { data: { type: Array, default: () => [] } },
  computed: {
    items() {
      const list = this.data.filter(m => m.is_visible !== false);
      return list.length ? list : FALLBACK;
    },
  },
  methods: {
    initials(name) {
      if (!name) return '?';
      return name.split(' ').slice(0, 2).map(n => n[0]).join('').toUpperCase();
    },
    truncate(str, n) {
      if (!str) return '';
      return str.length > n ? str.slice(0, n) + '…' : str;
    },
  },
};
</script>

<style scoped>
.team-section { background: #f8f9ff; }

.team-card {
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  text-align: center;
  box-shadow: 0 4px 20px rgba(102,126,234,.08);
  border: 1px solid rgba(102,126,234,.1);
  transition: all .35s;
}
.team-card:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(102,126,234,.2); }

.team-card__photo-wrap {
  position: relative;
  height: 200px;
  background: linear-gradient(135deg, #eef2ff, #f5f3ff);
  overflow: hidden;
}
.team-card__photo { width: 100%; height: 100%; object-fit: cover; }
.team-card__initial {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  font-size: 3rem; font-weight: 800;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff;
}
.team-card__overlay {
  position: absolute; inset: 0;
  background: rgba(102,126,234,.85);
  display: flex; align-items: center; justify-content: center;
  opacity: 0; transition: opacity .3s;
}
.team-card:hover .team-card__overlay { opacity: 1; }
.team-card__socials { display: flex; gap: 1rem; }
.social-btn {
  width: 44px; height: 44px; border-radius: 50%;
  background: rgba(255,255,255,.2); color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.1rem; text-decoration: none;
  border: 2px solid rgba(255,255,255,.4);
  transition: all .25s;
}
.social-btn:hover { background: #fff; color: #667eea; }

.team-card__body { padding: 1.25rem 1rem; }
.team-card__name { font-weight: 700; font-size: 1rem; color: #1a1a3e; margin-bottom: .25rem; }
.team-card__role { font-size: .8rem; color: #667eea; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; margin-bottom: .5rem; }
.team-card__bio  { font-size: .82rem; color: #9ca3af; line-height: 1.5; margin: 0; }

.team-skeleton {
  height: 300px; border-radius: 20px;
  background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
</style>
