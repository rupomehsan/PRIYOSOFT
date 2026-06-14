<template>
  <section id="team" class="team-section section-pad">
    <div class="container">
      <div class="section-head text-center">
        <span class="section-tag">The People Behind</span>
        <h2 class="section-title">Meet Our <span class="gradient-text">Team</span></h2>
        <p class="section-sub">Talented individuals who turn complex problems into elegant, working software.</p>
      </div>

      <div class="team-grid">
        <div v-for="member in items" :key="member.id" class="team-card">
          <div class="team-card__photo-ring">
            <div class="team-card__photo-wrap">
              <img v-if="member.photo" :src="member.photo" :alt="member.name" class="team-card__photo" />
              <div v-else class="team-card__initial">{{ initials(member.name) }}</div>
            </div>
          </div>

          <div class="team-card__body">
            <h5 class="team-card__name">{{ member.name }}</h5>
            <p class="team-card__role">{{ member.role }}</p>
            <p v-if="member.bio" class="team-card__bio">{{ truncate(member.bio, 90) }}</p>
          </div>

          <div class="team-card__socials">
            <a v-if="member.linkedin" :href="member.linkedin" target="_blank" class="social-btn" aria-label="LinkedIn">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a v-if="member.github" :href="member.github" target="_blank" class="social-btn" aria-label="GitHub">
              <i class="fab fa-github"></i>
            </a>
            <span v-if="!member.linkedin && !member.github" class="social-btn" style="opacity:.25;cursor:default">
              <i class="fas fa-user"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
const FALLBACK = [
  { id:1, name:'Ahsan Habib',      role:'CEO & Co-founder',  bio:'Leads vision and strategy. 10+ years building software products from the ground up.' },
  { id:2, name:'Nadia Rahman',     role:'CTO',               bio:'Architect of our core platforms. Loves clean code, fast APIs, and zero technical debt.' },
  { id:3, name:'Rifat Islam',      role:'Lead Designer',     bio:'Crafts interfaces that feel intuitive, beautiful, and pixel-perfect across all devices.' },
  { id:4, name:'Tanvir Ahmed',     role:'Senior Developer',  bio:'Full-stack engineer with a passion for performance and developer experience.' },
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
.team-section { background: #fff; }

.team-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.75rem;
}

/* Card */
.team-card {
  background: #fafbff;
  border: 1px solid #e8eeff;
  border-radius: 24px;
  padding: 2rem 1.5rem 1.5rem;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: transform .3s, box-shadow .3s, border-color .3s;
}
.team-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 24px 60px rgba(99,102,241,.14);
  border-color: #c7d2fe;
}

/* Photo ring */
.team-card__photo-ring {
  width: 100px; height: 100px;
  border-radius: 50%;
  background: linear-gradient(135deg, #6366f1, #a855f7, #06b6d4);
  padding: 3px;
  margin-bottom: 1.25rem;
  flex-shrink: 0;
}
.team-card__photo-wrap {
  width: 100%; height: 100%;
  border-radius: 50%;
  overflow: hidden;
  background: #fff;
  display: flex; align-items: center; justify-content: center;
}
.team-card__photo { width:100%;height:100%;object-fit:cover; }
.team-card__initial {
  width: 100%; height: 100%;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.85rem; font-weight: 900;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  color: #fff;
}

/* Body */
.team-card__body { flex: 1; }
.team-card__name { font-weight: 800; font-size: 1rem; color: #0f172a; margin-bottom: .2rem; }
.team-card__role {
  font-size: .75rem; font-weight: 700;
  color: #6366f1; text-transform: uppercase;
  letter-spacing: .8px; margin-bottom: .65rem;
}
.team-card__bio { font-size: .82rem; color: #64748b; line-height: 1.6; margin: 0; }

/* Socials */
.team-card__socials {
  display: flex;
  gap: .5rem;
  margin-top: 1.25rem;
}
.social-btn {
  width: 36px; height: 36px; border-radius: 50%;
  background: #f1f5f9;
  border: 1px solid #e2e8f0;
  display: flex; align-items: center; justify-content: center;
  color: #64748b; font-size: .85rem;
  text-decoration: none;
  transition: all .25s;
}
.social-btn:hover {
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  border-color: transparent;
  color: #fff;
  transform: translateY(-2px);
}

@media (max-width: 991px) { .team-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px)  { .team-grid { grid-template-columns: 1fr 1fr; gap: 1rem; } }
</style>
