<template>
  <section id="newsletter" class="newsletter-section">
    <div class="nl-bg-glow nl-bg-glow--1"></div>
    <div class="nl-bg-glow nl-bg-glow--2"></div>
    <div class="nl-bg-glow nl-bg-glow--3"></div>

    <div class="container position-relative">
      <div class="nl-wrap">

        <!-- Left -->
        <div class="nl-left animate from-left dur-slow">
          <span class="nl-tag">Let's Work Together</span>
          <h2 class="nl-title">Ready to Build<br><span class="gradient-text">Something Amazing?</span></h2>
          <div class="ps-divider" style="justify-content:flex-start;margin:.5rem 0 1rem">
            <span class="ps-divider__bar"></span>
            <i class="fas fa-circle ps-divider__dot"></i>
            <span class="ps-divider__bar"></span>
          </div>
          <p class="nl-sub">
            Have a project in mind? Fill out the form and we'll get back to you within 24 hours.
          </p>
          <div class="nl-subscribe-box">
            <p class="nl-subscribe-label">Get updates on new features &amp; releases</p>
            <div v-if="subDone" class="nl-sub-done">
              <i class="fas fa-check-circle"></i> You're subscribed!
            </div>
            <form v-else class="nl-subscribe-form" @submit.prevent="submitSub">
              <input
                v-model="subEmail"
                type="email"
                placeholder="your@email.com"
                :disabled="subLoading"
                required
              />
              <button type="submit" :disabled="subLoading">
                <i v-if="subLoading" class="fas fa-spinner fa-spin"></i>
                <span v-else>Subscribe</span>
              </button>
            </form>
            <p v-if="subError" class="nl-sub-error">{{ subError }}</p>
          </div>
        </div>

        <!-- Right: form -->
        <div class="nl-right animate from-right dur-slow delay-2">
          <div class="nl-card">

            <div v-if="submitted" class="nl-success">
              <div class="nl-success__icon"><i class="fas fa-check"></i></div>
              <h4>Message Sent!</h4>
              <p>Thanks for reaching out. We'll reply within 24 hours.</p>
              <button class="nl-btn" style="margin-top:1.25rem" @click="reset">Send Another</button>
            </div>

            <form v-else @submit.prevent="submit" novalidate>

              <div class="nl-row">
                <div class="nl-field">
                  <label>Name <span class="req">*</span></label>
                  <input v-model="form.name" type="text" placeholder="Your full name"
                         :class="{ 'input-error': errors.name }" />
                  <span v-if="errors.name" class="nl-field-error">{{ errors.name }}</span>
                </div>
                <div class="nl-field">
                  <label>Email <span class="req">*</span></label>
                  <input v-model="form.email" type="email" placeholder="you@company.com"
                         :class="{ 'input-error': errors.email }" />
                  <span v-if="errors.email" class="nl-field-error">{{ errors.email }}</span>
                </div>
              </div>

              <div class="nl-row">
                <div class="nl-field">
                  <label>Phone <span class="req">*</span></label>
                  <input v-model="form.phone" type="tel" placeholder="+880 1XXX-XXXXXX"
                         :class="{ 'input-error': errors.phone }" />
                  <span v-if="errors.phone" class="nl-field-error">{{ errors.phone }}</span>
                </div>
                <div class="nl-field">
                  <label>Subject <span class="req">*</span></label>
                  <input v-model="form.subject" type="text" placeholder="What is this about?"
                         :class="{ 'input-error': errors.subject }" />
                  <span v-if="errors.subject" class="nl-field-error">{{ errors.subject }}</span>
                </div>
              </div>

              <div class="nl-field">
                <label>Interested Product</label>
                <select v-model="form.product_id" class="nl-select">
                  <option value="">— Select a product (optional) —</option>
                  <option v-for="p in products" :key="p.id" :value="p.id">{{ p.name }}</option>
                </select>
              </div>

              <div class="nl-field">
                <label>Message <span class="req">*</span></label>
                <textarea v-model="form.message" rows="4" placeholder="Tell us about your project…"
                          :class="{ 'input-error': errors.message }"></textarea>
                <span v-if="errors.message" class="nl-field-error">{{ errors.message }}</span>
              </div>

              <p v-if="serverError" class="nl-error">{{ serverError }}</p>

              <button type="submit" class="nl-btn" :disabled="loading">
                <span v-if="loading"><i class="fas fa-spinner fa-spin me-2"></i>Sending…</span>
                <span v-else><i class="fas fa-paper-plane me-2"></i>Get In Touch</span>
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
  name: 'ContactSection',
  props: {
    products: { type: Array, default: () => [] },
  },
  data: () => ({
    form: { name: '', email: '', phone: '', subject: '', product_id: '', message: '' },
    errors: {},
    serverError: null,
    loading: false,
    submitted: false,
    subEmail: '',
    subLoading: false,
    subDone: false,
    subError: null,
  }),
  methods: {
    async submitSub() {
      this.subError = null;
      this.subLoading = true;
      try {
        await window.axios.post('public/subscribe', { email: this.subEmail });
        this.subDone = true;
      } catch (err) {
        this.subError = err?.response?.data?.message ?? 'Subscription failed. Try again.';
      } finally {
        this.subLoading = false;
      }
    },
    validate() {
      const e = {};
      if (!this.form.name.trim())    e.name    = 'Name is required.';
      if (!this.form.email.trim())   e.email   = 'Email is required.';
      if (!this.form.phone.trim())   e.phone   = 'Phone is required.';
      if (!this.form.subject.trim()) e.subject = 'Subject is required.';
      if (!this.form.message.trim()) e.message = 'Message is required.';
      this.errors = e;
      return !Object.keys(e).length;
    },
    async submit() {
      if (!this.validate()) return;
      this.loading = true;
      this.serverError = null;
      try {
        const payload = { ...this.form };
        if (!payload.product_id) delete payload.product_id;
        await window.axios.post('public/contact', payload);
        this.submitted = true;
      } catch (err) {
        this.serverError = err?.response?.data?.message ?? 'Something went wrong. Please try again.';
      } finally {
        this.loading = false;
      }
    },
    reset() {
      this.form = { name: '', email: '', phone: '', subject: '', product_id: '', message: '' };
      this.errors = {};
      this.serverError = null;
      this.submitted = false;
    },
  },
};
</script>

<style scoped>
.newsletter-section {
  background: var(--ps-bg-1);
  padding: 7rem 0;
  position: relative;
  overflow: hidden;
  border-top: 1px solid rgba(99,102,241,.12);
}

.nl-bg-glow {
  position: absolute; border-radius: 50%;
  filter: blur(100px); pointer-events: none;
}
.nl-bg-glow--1 { width:600px;height:600px;background:rgba(99,102,241,.12);top:-200px;left:-150px; }
.nl-bg-glow--2 { width:500px;height:500px;background:rgba(168,85,247,.1);bottom:-150px;right:-150px; }
.nl-bg-glow--3 { width:300px;height:300px;background:rgba(6,182,212,.07);top:40%;left:45%; }

.nl-wrap {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 5rem;
  align-items: start;
}

/* Left */
.nl-tag {
  display: inline-block;
  background: rgba(99,102,241,.12); color: #a5b4fc;
  font-size: .7rem; font-weight: 800;
  letter-spacing: 2.5px; text-transform: uppercase;
  padding: .45rem 1.2rem; border-radius: 50px;
  border: 1px solid rgba(99,102,241,.25);
  margin-bottom: 1.25rem;
}
.nl-title {
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 900; color: var(--ps-text-h);
  line-height: 1.2; letter-spacing: -.025em;
  margin-bottom: 1.25rem;
}
.nl-sub { font-size: 1rem; color: var(--ps-text-faint); line-height: 1.8; margin-bottom: 1.5rem; }

/* Subscription mini-form */
.nl-subscribe-box { margin-top: .25rem; }
.nl-subscribe-label { font-size: .82rem; color: var(--ps-text-faint); margin-bottom: .75rem; }
.nl-subscribe-form {
  display: flex; gap: .5rem;
}
.nl-subscribe-form input {
  flex: 1; padding: .75rem 1rem;
  background: var(--ps-card-bg); border: 1px solid var(--ps-card-border);
  border-radius: 10px; color: var(--ps-text-h); font-size: .88rem; outline: none;
  transition: border-color .25s;
}
.nl-subscribe-form input:focus { border-color: rgba(99,102,241,.5); }
.nl-subscribe-form input::placeholder { color: #475569; }
.nl-subscribe-form button {
  padding: .75rem 1.4rem;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  color: #fff; border: none; border-radius: 10px;
  font-weight: 700; font-size: .88rem; cursor: pointer; white-space: nowrap;
  transition: opacity .25s, transform .25s;
}
.nl-subscribe-form button:hover:not(:disabled) { transform: translateY(-1px); opacity: .9; }
.nl-subscribe-form button:disabled { opacity: .6; cursor: not-allowed; }
.nl-sub-done { color: #10b981; font-size: .9rem; font-weight: 600; display: flex; align-items: center; gap: .5rem; }
.nl-sub-done i { font-size: 1.1rem; }
.nl-sub-error { font-size: .78rem; color: #f87171; margin-top: .4rem; }

/* Card */
.nl-card {
  background: var(--ps-card-bg); border: 1px solid var(--ps-card-border);
  border-radius: 24px; padding: 2.5rem; backdrop-filter: blur(16px);
}

/* Form */
.nl-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.nl-field { margin-bottom: 1.1rem; }
.nl-field label {
  display: block; font-size: .82rem; font-weight: 700;
  color: var(--ps-text-body); margin-bottom: .45rem; letter-spacing: .3px;
}
.nl-field input,
.nl-field textarea,
.nl-select {
  width: 100%; padding: .8rem 1.1rem;
  background: var(--ps-card-bg); border: 1px solid var(--ps-card-border);
  border-radius: 10px; color: var(--ps-text-h);
  font-size: .9rem; outline: none;
  transition: border-color .25s, background .25s;
}
.nl-field input::placeholder,
.nl-field textarea::placeholder { color: #475569; }
.nl-field input:focus,
.nl-field textarea:focus,
.nl-select:focus {
  border-color: rgba(99,102,241,.5);
  background: rgba(99,102,241,.06);
}
.input-error { border-color: #f87171 !important; }
.nl-field textarea { resize: vertical; min-height: 110px; }
.nl-select { appearance: none; cursor: pointer; }
.nl-select option { background: #1e1b4b; color: #fff; }

.req { color: #f87171; }
.nl-field-error { font-size: .75rem; color: #f87171; margin-top: .25rem; display: block; }
.nl-error { font-size: .82rem; color: #f87171; margin-bottom: .75rem; }

/* Button */
.nl-btn {
  width: 100%; padding: .95rem 1.5rem;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  color: #fff; border: none; border-radius: 12px;
  font-weight: 800; font-size: 1rem; cursor: pointer;
  transition: opacity .3s, transform .3s, box-shadow .3s;
  box-shadow: 0 8px 24px rgba(99,102,241,.35);
  display: flex; align-items: center; justify-content: center; gap: .5rem;
}
.nl-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 14px 35px rgba(99,102,241,.5); }
.nl-btn:disabled { opacity: .6; cursor: not-allowed; }

/* Success */
.nl-success { text-align: center; padding: 1.5rem 0; }
.nl-success__icon {
  width: 64px; height: 64px; border-radius: 50%;
  background: linear-gradient(135deg, #10b981, #06b6d4);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.5rem; color: #fff; margin: 0 auto 1.25rem;
  box-shadow: 0 8px 24px rgba(16,185,129,.35);
}
.nl-success h4 { font-weight: 800; font-size: 1.35rem; color: var(--ps-text-h); margin-bottom: .5rem; }
.nl-success p  { color: var(--ps-text-faint); font-size: .9rem; }

@media (max-width: 991px) { .nl-wrap { grid-template-columns: 1fr; gap: 3rem; } }
@media (max-width: 640px) { .nl-row { grid-template-columns: 1fr; } }
@media (max-width: 576px) { .nl-card { padding: 1.75rem; } .nl-title { font-size: 2rem; } }
</style>
