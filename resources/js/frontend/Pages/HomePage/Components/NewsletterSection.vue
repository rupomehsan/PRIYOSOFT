<template>
  <section id="newsletter" class="newsletter-section">
    <div class="nl-bg-glow nl-bg-glow--1"></div>
    <div class="nl-bg-glow nl-bg-glow--2"></div>
    <div class="nl-bg-glow nl-bg-glow--3"></div>

    <div class="container position-relative">
      <div class="nl-wrap">

        <!-- Left -->
        <div class="nl-left">
          <span class="nl-tag">Let's Work Together</span>
          <h2 class="nl-title">Ready to Build<br><span class="gradient-text">Something Amazing?</span></h2>
          <p class="nl-sub">
            Subscribe for our latest insights, or drop us a message — we'd love to discuss your next project.
          </p>
          <ul class="nl-perks">
            <li v-for="perk in perks" :key="perk">
              <span class="nl-perk-icon"><i class="fas fa-check"></i></span>
              {{ perk }}
            </li>
          </ul>
          <div class="nl-contact-info">
            <a href="mailto:hello@priyosoft.com" class="nl-contact-link">
              <i class="fas fa-envelope"></i>hello@priyosoft.com
            </a>
          </div>
        </div>

        <!-- Right: form -->
        <div class="nl-right">
          <div class="nl-card">
            <div v-if="success" class="nl-success">
              <div class="nl-success__icon"><i class="fas fa-check"></i></div>
              <h4>You're subscribed!</h4>
              <p>Thanks for joining. We'll be in touch soon.</p>
            </div>
            <form v-else @submit.prevent="submit">
              <div class="nl-field">
                <label>Your Name</label>
                <input v-model="form.name" type="text" placeholder="John Doe" />
              </div>
              <div class="nl-field">
                <label>Email Address <span class="req">*</span></label>
                <input v-model="form.email" type="email" placeholder="you@company.com" required />
              </div>
              <p v-if="error" class="nl-error">{{ error }}</p>
              <button type="submit" class="nl-btn" :disabled="loading">
                <span v-if="loading"><i class="fas fa-spinner fa-spin me-2"></i>Sending…</span>
                <span v-else><i class="fas fa-paper-plane me-2"></i>Subscribe &amp; Get Updates</span>
              </button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'NewsletterSection',
  props: {
    loading: { type: Boolean, default: false },
    success: { type: Boolean, default: false },
    error:   { type: String,  default: null },
  },
  emits: ['subscribe'],
  data: () => ({
    form: { name: '', email: '' },
    perks: ['No spam, ever', 'Product updates & insights', 'Cancel anytime'],
  }),
  methods: {
    submit() {
      if (!this.form.email) return;
      this.$emit('subscribe', { ...this.form });
    },
  },
};
</script>

<style scoped>
.newsletter-section {
  background: #050512;
  padding: 7rem 0;
  position: relative;
  overflow: hidden;
  border-top: 1px solid rgba(99,102,241,.12);
}

/* Ambient glows */
.nl-bg-glow {
  position: absolute; border-radius: 50%;
  filter: blur(100px); pointer-events: none;
}
.nl-bg-glow--1 { width:600px;height:600px;background:rgba(99,102,241,.12);top:-200px;left:-150px; }
.nl-bg-glow--2 { width:500px;height:500px;background:rgba(168,85,247,.1);bottom:-150px;right:-150px; }
.nl-bg-glow--3 { width:300px;height:300px;background:rgba(6,182,212,.07);top:40%;left:45%; }

/* Wrapper */
.nl-wrap {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 5rem;
  align-items: center;
}

/* Left */
.nl-tag {
  display: inline-block;
  background: rgba(99,102,241,.12);
  color: #a5b4fc;
  font-size: .7rem; font-weight: 800;
  letter-spacing: 2.5px; text-transform: uppercase;
  padding: .45rem 1.2rem; border-radius: 50px;
  border: 1px solid rgba(99,102,241,.25);
  margin-bottom: 1.25rem;
}

.nl-title {
  font-size: clamp(2.2rem, 4vw, 3rem);
  font-weight: 900;
  color: #f1f5f9;
  line-height: 1.2;
  letter-spacing: -.025em;
  margin-bottom: 1.25rem;
}

.nl-sub {
  font-size: 1rem; color: #64748b;
  line-height: 1.8; margin-bottom: 2rem;
}

/* Perks */
.nl-perks {
  list-style: none; padding: 0; margin: 0 0 2rem;
  display: flex; flex-direction: column; gap: .65rem;
}
.nl-perks li {
  display: flex; align-items: center; gap: .75rem;
  color: #94a3b8; font-size: .9rem;
}
.nl-perk-icon {
  width: 22px; height: 22px; border-radius: 50%;
  background: rgba(16,185,129,.15);
  border: 1px solid rgba(16,185,129,.25);
  display: flex; align-items: center; justify-content: center;
  color: #10b981; font-size: .65rem; flex-shrink: 0;
}

/* Contact link */
.nl-contact-link {
  display: inline-flex; align-items: center; gap: .6rem;
  color: #6366f1; font-weight: 600; font-size: .9rem;
  text-decoration: none; transition: color .2s;
}
.nl-contact-link:hover { color: #a5b4fc; }

/* Card */
.nl-card {
  background: rgba(255,255,255,.03);
  border: 1px solid rgba(255,255,255,.08);
  border-radius: 24px;
  padding: 2.5rem;
  backdrop-filter: blur(16px);
}

/* Form fields */
.nl-field { margin-bottom: 1.25rem; }
.nl-field label {
  display: block; font-size: .82rem; font-weight: 700;
  color: #94a3b8; margin-bottom: .5rem; letter-spacing: .3px;
}
.nl-field input {
  width: 100%; padding: .9rem 1.25rem;
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(255,255,255,.1);
  border-radius: 12px; color: #e2e8f0;
  font-size: .95rem; outline: none;
  transition: border-color .25s, background .25s;
}
.nl-field input::placeholder { color: #475569; }
.nl-field input:focus {
  border-color: rgba(99,102,241,.5);
  background: rgba(99,102,241,.06);
}
.req { color: #f87171; }
.nl-error { font-size: .82rem; color: #f87171; margin-bottom: .75rem; }

/* Submit */
.nl-btn {
  width: 100%; padding: 1rem 1.5rem;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  color: #fff; border: none; border-radius: 12px;
  font-weight: 800; font-size: 1rem; cursor: pointer;
  transition: opacity .3s, transform .3s, box-shadow .3s;
  box-shadow: 0 8px 24px rgba(99,102,241,.35);
}
.nl-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 14px 35px rgba(99,102,241,.5);
}
.nl-btn:disabled { opacity: .6; cursor: not-allowed; }

/* Success */
.nl-success { text-align: center; padding: 1.5rem 0; }
.nl-success__icon {
  width: 64px; height: 64px; border-radius: 50%;
  background: linear-gradient(135deg, #10b981, #06b6d4);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.5rem; color: #fff;
  margin: 0 auto 1.25rem;
  box-shadow: 0 8px 24px rgba(16,185,129,.35);
}
.nl-success h4 { font-weight: 800; font-size: 1.35rem; color: #f1f5f9; margin-bottom: .5rem; }
.nl-success p  { color: #64748b; font-size: .9rem; }

/* Responsive */
@media (max-width: 991px) {
  .nl-wrap { grid-template-columns: 1fr; gap: 3rem; }
}
@media (max-width: 576px) {
  .nl-card { padding: 1.75rem; }
  .nl-title { font-size: 2rem; }
}
</style>
