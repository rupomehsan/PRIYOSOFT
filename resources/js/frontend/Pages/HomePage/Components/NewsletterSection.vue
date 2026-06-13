<template>
  <section id="contact" class="newsletter-section">
    <div class="container">
      <div class="newsletter-card">
        <div class="row align-items-center g-4">

          <div class="col-lg-6">
            <span class="section-tag" style="color:#fff;background:rgba(255,255,255,.2)">Stay Updated</span>
            <h2 class="newsletter-title">Ready to Build Something Amazing?</h2>
            <p class="newsletter-sub">
              Subscribe for our latest insights, or drop us a message — we'd love to talk about your next project.
            </p>
            <div class="newsletter-perks">
              <div v-for="perk in perks" :key="perk" class="newsletter-perk">
                <i class="fas fa-check-circle me-2"></i>{{ perk }}
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div v-if="success" class="newsletter-success">
              <i class="fas fa-check-circle fa-3x mb-3"></i>
              <h4>You're subscribed!</h4>
              <p>Thanks for joining us. We'll be in touch soon.</p>
            </div>
            <form v-else class="newsletter-form" @submit.prevent="submit">
              <div class="newsletter-form__field">
                <label>Your Name</label>
                <input v-model="form.name" type="text" placeholder="John Doe" />
              </div>
              <div class="newsletter-form__field">
                <label>Email Address <span class="req">*</span></label>
                <input v-model="form.email" type="email" placeholder="you@company.com" required />
              </div>
              <p v-if="error" class="newsletter-error">{{ error }}</p>
              <button type="submit" class="newsletter-btn" :disabled="loading">
                <span v-if="loading"><i class="fas fa-spinner fa-spin me-2"></i>Subscribing…</span>
                <span v-else><i class="fas fa-paper-plane me-2"></i>Subscribe &amp; Stay Updated</span>
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
  background: #f8f9ff;
  padding: 5rem 0;
}
.newsletter-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 60%, #a855f7 100%);
  border-radius: 28px;
  padding: 4rem 3.5rem;
  box-shadow: 0 30px 80px rgba(102,126,234,.35);
  position: relative;
  overflow: hidden;
}
.newsletter-card::before {
  content: '';
  position: absolute; inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.newsletter-title { font-size: 2rem; font-weight: 800; color: #fff; margin: 1rem 0 .75rem; }
.newsletter-sub   { color: rgba(255,255,255,.85); font-size: 1rem; line-height: 1.7; margin-bottom: 1.5rem; }
.newsletter-perks { display: flex; flex-direction: column; gap: .5rem; }
.newsletter-perk  { color: rgba(255,255,255,.9); font-size: .9rem; display: flex; align-items: center; }
.newsletter-perk i { color: #86efac; }

.newsletter-form { background: rgba(255,255,255,.12); border-radius: 20px; padding: 2rem; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,.2); }
.newsletter-form__field { margin-bottom: 1.25rem; }
.newsletter-form__field label { display: block; color: rgba(255,255,255,.85); font-size: .85rem; font-weight: 600; margin-bottom: .4rem; }
.newsletter-form__field input {
  width: 100%; padding: .875rem 1.25rem;
  border-radius: 12px; border: 1.5px solid rgba(255,255,255,.25);
  background: rgba(255,255,255,.1); color: #fff; font-size: .95rem;
  outline: none; transition: border-color .25s;
}
.newsletter-form__field input::placeholder { color: rgba(255,255,255,.5); }
.newsletter-form__field input:focus { border-color: rgba(255,255,255,.7); background: rgba(255,255,255,.15); }
.req { color: #fca5a5; }

.newsletter-btn {
  width: 100%; padding: 1rem;
  background: #fff; color: #667eea;
  border: none; border-radius: 12px;
  font-weight: 800; font-size: 1rem; cursor: pointer;
  transition: all .3s;
}
.newsletter-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.2); }
.newsletter-btn:disabled { opacity: .7; cursor: not-allowed; }

.newsletter-error { color: #fca5a5; font-size: .85rem; margin-bottom: .75rem; }

.newsletter-success {
  text-align: center; color: #fff; padding: 2.5rem 1rem;
}
.newsletter-success i { color: #86efac; }
.newsletter-success h4 { font-weight: 800; font-size: 1.5rem; margin-bottom: .5rem; }
.newsletter-success p  { color: rgba(255,255,255,.8); }

@media (max-width: 768px) {
  .newsletter-card { padding: 2.5rem 1.5rem; }
  .newsletter-title { font-size: 1.6rem; }
}
</style>
