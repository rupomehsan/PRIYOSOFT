<template>
  <div class="pp-page">

    <!-- Loading -->
    <div v-if="loading" class="pp-loading">
      <div class="pp-spinner"></div>
    </div>

    <!-- Not found -->
    <div v-else-if="!product" class="pp-notfound">
      <i class="fas fa-exclamation-circle"></i>
      <p>Product not found.</p>
      <a href="/#products">← Back to Products</a>
    </div>

    <!-- Success -->
    <div v-else-if="submitted" class="pp-success-page">
      <div class="pp-success-card">
        <div class="pp-success-icon-wrap">
          <i class="fas fa-check-circle"></i>
        </div>
        <h2>Order Received!</h2>
        <p>
          Thank you, <strong>{{ form.name }}</strong>!<br/>
          We've received your order for <strong>{{ product.name }}</strong>.<br/>
          We'll verify your payment and contact you at <strong>{{ form.phone }}</strong> within 24 hours.
        </p>
        <div class="pp-success-ref">
          Reference: <strong>REF-{{ refCode }}</strong>
        </div>
        <a href="/#products" class="pp-btn pp-btn--primary">← Back to Products</a>
      </div>
    </div>

    <!-- Payment form -->
    <template v-else>

      <!-- Top bar -->
      <div class="pp-steps-bar">
        <div class="pp-steps-bar__inner">
          <a :href="'/products/' + slug" class="pp-back">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Product</span>
          </a>
          <span class="pp-secure-badge">
            <i class="fas fa-lock"></i> Secure Order
          </span>
        </div>
      </div>

      <!-- Body -->
      <div class="pp-body">
        <div class="pp-layout">

          <!-- ── Main form (single page) ── -->
          <div class="pp-form-col">

            <!-- Section A: Your Info -->
            <div class="pp-card">
              <div class="pp-card__head">
                <div class="pp-section-badge"><i class="fas fa-user"></i> Your Information</div>
                <p class="pp-card__sub">We'll use this to confirm your order and contact you.</p>
              </div>
              <div class="pp-fields">
                <div class="pp-row">
                  <div class="pp-field" :class="{ error: err.name }">
                    <label>Full Name <span class="pp-req">*</span></label>
                    <input v-model="form.name" type="text" placeholder="e.g. Ahsan Rahman" class="pp-input" @input="clearErr('name')" />
                    <span v-if="err.name" class="pp-err-msg"><i class="fas fa-exclamation-circle"></i> {{ err.name }}</span>
                  </div>
                  <div class="pp-field" :class="{ error: err.phone }">
                    <label>Phone Number <span class="pp-req">*</span></label>
                    <input v-model="form.phone" type="tel" placeholder="01XXXXXXXXX" class="pp-input" @input="clearErr('phone')" />
                    <span v-if="err.phone" class="pp-err-msg"><i class="fas fa-exclamation-circle"></i> {{ err.phone }}</span>
                  </div>
                </div>
                <div class="pp-row">
                  <div class="pp-field">
                    <label>Email Address</label>
                    <input v-model="form.email" type="email" placeholder="you@email.com" class="pp-input" />
                    <span class="pp-field__hint">Optional — for order confirmation</span>
                  </div>
                  <div class="pp-field">
                    <label>Message / Requirements</label>
                    <input v-model="form.message" type="text" placeholder="Any specific requirements?" class="pp-input" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Section B: Payment -->
            <div class="pp-card pp-card--mt">
              <div class="pp-card__head">
                <div class="pp-section-badge pp-section-badge--pink"><i class="fas fa-credit-card"></i> Payment via bKash</div>
                <p class="pp-card__sub">Send the amount to our bKash number, then fill in the proof below.</p>
              </div>

              <!-- bKash block -->
              <div class="pp-bkash-block">
                <div class="pp-bkash-header">
                  <div class="pp-bkash-logo-wrap">
                    <img src="/bkash-logo.svg" alt="bKash" class="pp-bkash-logo" />
                  </div>
                  <div class="pp-bkash-info">
                    <p class="pp-bkash-label">Send money to this bKash number</p>
                    <div class="pp-bkash-number-row">
                      <span class="pp-bkash-number">{{ bkashNumber }}</span>
                      <button type="button" class="pp-copy-btn" @click="copyNumber" :class="{ copied: numberCopied }">
                        <i :class="numberCopied ? 'fas fa-check' : 'far fa-copy'"></i>
                        {{ numberCopied ? 'Copied!' : 'Copy' }}
                      </button>
                    </div>
                    <p class="pp-bkash-acname">Account Name: <strong>{{ bkashAccountName }}</strong></p>
                  </div>
                </div>
                <div class="pp-payment-steps">
                  <p class="pp-payment-steps__title">How to pay:</p>
                  <ol class="pp-payment-steps__list">
                    <li>Open bKash app → <strong>Send Money</strong></li>
                    <li>Enter number: <strong>{{ bkashNumber }}</strong></li>
                    <li>Enter amount: <strong>৳{{ fmt(payAmount) }}</strong></li>
                    <li>Use reference: <strong>{{ product.name }}</strong></li>
                    <li>Save the Transaction ID shown after payment</li>
                  </ol>
                </div>
              </div>

              <!-- Proof -->
              <div class="pp-proof-section">
                <div class="pp-row">
                  <div class="pp-field" :class="{ error: err.payment }">
                    <label>Transaction ID (TXN ID) <span class="pp-req">*</span></label>
                    <div class="pp-txn-input-wrap">
                      <i class="fas fa-hashtag pp-txn-icon"></i>
                      <input v-model="form.txn_id" type="text" placeholder="e.g. 8KJ3YU9P2Q" class="pp-input pp-input--icon" @input="clearErr('payment')" />
                    </div>
                  </div>
                  <div class="pp-field">
                    <label>Payment Screenshot</label>
                    <div class="pp-upload-zone pp-upload-zone--sm"
                      :class="{ dragging: dragOver, 'has-file': !!form.screenshot }"
                      @dragover.prevent="dragOver = true"
                      @dragleave.prevent="dragOver = false"
                      @drop.prevent="onDrop"
                      @click="$refs.fileInput.click()"
                    >
                      <template v-if="!form.screenshot">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Click or drag screenshot</span>
                      </template>
                      <template v-else>
                        <img :src="screenshotPreview" class="pp-upload-zone__preview" />
                        <button type="button" class="pp-upload-zone__remove" @click.stop="removeScreenshot">
                          <i class="fas fa-times"></i>
                        </button>
                      </template>
                    </div>
                    <input ref="fileInput" type="file" accept="image/*" style="display:none" @change="onFileChange" />
                  </div>
                </div>
                <p v-if="err.payment" class="pp-err-msg mt-2">
                  <i class="fas fa-exclamation-circle"></i> {{ err.payment }}
                </p>
              </div>

              <div class="pp-card__foot">
                <span></span>
                <button class="pp-btn pp-btn--confirm" @click="submitOrder" :disabled="submitting">
                  <span v-if="submitting"><i class="fas fa-spinner fa-spin me-2"></i>Processing…</span>
                  <span v-else><i class="fas fa-shield-alt me-2"></i>Confirm Order</span>
                </button>
              </div>
            </div>

          </div>

          <!-- ── Order summary ── -->
          <div class="pp-summary-col">
            <div class="pp-summary">
              <h3 class="pp-summary__title">Order Summary</h3>

              <div class="pp-summary__product">
                <div class="pp-summary__thumb" :style="thumbBg">
                  <img v-if="product.screenshots" :src="product.screenshots" :alt="product.name" />
                  <i v-else class="fas fa-cube"></i>
                </div>
                <div class="pp-summary__info">
                  <p class="pp-summary__name">{{ product.name }}</p>
                  <p v-if="product.productGroupId" class="pp-summary__cat">{{ product.productGroupId.name }}</p>
                </div>
              </div>

              <div class="pp-summary__divider"></div>

              <div class="pp-summary__pricing">
                <div class="pp-summary__line" v-if="product.regular_price">
                  <span>Regular Price</span>
                  <span>৳{{ fmt(product.regular_price) }}</span>
                </div>
                <div class="pp-summary__line pp-summary__line--discount" v-if="product.sales_price && discountPct">
                  <span>Discount ({{ discountPct }}% off)</span>
                  <span>- ৳{{ fmt(product.regular_price - product.sales_price) }}</span>
                </div>
                <div class="pp-summary__divider"></div>
                <div class="pp-summary__line pp-summary__line--total">
                  <span>Total</span>
                  <span>৳{{ fmt(payAmount) }}</span>
                </div>
              </div>

              <div class="pp-summary__features" v-if="features.length">
                <p class="pp-summary__feat-title">What's Included:</p>
                <ul>
                  <li v-for="(f, i) in features.slice(0, 5)" :key="i">
                    <i class="fas fa-check"></i> {{ f }}
                  </li>
                  <li v-if="features.length > 5" class="pp-summary__more">
                    +{{ features.length - 5 }} more features
                  </li>
                </ul>
              </div>

              <div class="pp-summary__guarantee">
                <i class="fas fa-shield-alt"></i>
                <span>Secure & verified order process</span>
              </div>

            </div>
          </div>

        </div>
      </div>

    </template>
  </div>
</template>

<script>
const BKASH_NUMBER   = '01700000000';
const BKASH_ACC_NAME = 'PriyoSoft';

export default {
  name: 'ProductPaymentPage',
  props: { slug: { type: String, required: true } },

  data: () => ({
    product: null, loading: true,
    submitted: false, submitting: false,
    dragOver: false, screenshotPreview: null,
    numberCopied: false,
    refCode: '',
    bkashNumber:     BKASH_NUMBER,
    bkashAccountName: BKASH_ACC_NAME,
    form: { name: '', phone: '', email: '', message: '', txn_id: '', screenshot: null },
    err: {},
  }),

  computed: {
    features() {
      const f = this.product?.features;
      if (!f) return [];
      try { return Array.isArray(f) ? f : JSON.parse(f); } catch { return []; }
    },
    payAmount() {
      return this.product?.sales_price || this.product?.regular_price || 0;
    },
    discountPct() {
      const r = +this.product?.regular_price, s = +this.product?.sales_price;
      if (!r || !s || s >= r) return 0;
      return Math.round((r - s) / r * 100);
    },
    thumbBg() {
      const map = {
        active: 'linear-gradient(135deg,#4f46e5,#7c3aed)',
        planning: 'linear-gradient(135deg,#d97706,#f59e0b)',
        development: 'linear-gradient(135deg,#7c3aed,#a855f7)',
        paused: 'linear-gradient(135deg,#374151,#6b7280)',
      };
      return { background: map[this.product?.status] || map.active };
    },
  },

  methods: {
    fmt: n => n ? new Intl.NumberFormat('en-BD').format(n) : '0',

    clearErr(key) { const e = { ...this.err }; delete e[key]; this.err = e; },

    copyNumber() {
      navigator.clipboard.writeText(this.bkashNumber).catch(() => {});
      this.numberCopied = true;
      setTimeout(() => { this.numberCopied = false; }, 2000);
    },

    onFileChange(e) {
      const f = e.target.files[0]; if (f) this.setFile(f);
    },
    onDrop(e) {
      this.dragOver = false;
      const f = e.dataTransfer.files[0]; if (f) this.setFile(f);
    },
    setFile(f) {
      this.form.screenshot = f;
      this.screenshotPreview = URL.createObjectURL(f);
    },
    removeScreenshot() {
      this.form.screenshot = null;
      this.screenshotPreview = null;
      this.$refs.fileInput.value = '';
    },

    async submitOrder() {
      const e = {};
      if (!this.form.name.trim())  e.name  = 'Full name is required.';
      if (!this.form.phone.trim()) e.phone = 'Phone number is required.';
      if (!this.form.txn_id.trim() && !this.form.screenshot)
        e.payment = 'Provide a Transaction ID or upload a payment screenshot.';
      this.err = e;
      if (Object.keys(e).length) return;
      this.submitting = true;
      // TODO: wire up real endpoint
      await new Promise(r => setTimeout(r, 1500));
      this.refCode = 'PS' + Date.now().toString().slice(-8);
      this.submitting = false;
      this.submitted  = true;
    },

    async fetchProduct() {
      this.loading = true;
      try {
        const res = await window.axios.get(`public/products/${this.slug}`);
        this.product = res?.data?.data ?? res?.data ?? null;
      } catch { this.product = null; }
      finally { this.loading = false; }
    },
  },

  mounted() { this.fetchProduct(); },
};
</script>

<style scoped>
/* ─── Base ──────────────────────────────────── */
.pp-page { min-height: 100vh; background: #f4f6fb; }

/* ─── Loading ───────────────────────────────── */
.pp-loading {
  min-height: 100vh; display: flex; align-items: center; justify-content: center;
}
.pp-spinner {
  width: 48px; height: 48px; border-radius: 50%;
  border: 4px solid #e0e7ff; border-top-color: #4f46e5;
  animation: spin .7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ─── Not found ─────────────────────────────── */
.pp-notfound {
  min-height: 60vh; display: flex; flex-direction: column;
  align-items: center; justify-content: center; gap: .75rem;
  color: #6b7280; text-align: center;
}
.pp-notfound i { font-size: 3rem; color: #fca5a5; }

/* ─── Steps bar (below fixed global header 72px) ── */
.pp-steps-bar {
  background: #fff;
  border-bottom: 1px solid #e5e7eb;
  box-shadow: 0 1px 6px rgba(0,0,0,.05);
  margin-top: 72px;
}
.pp-steps-bar__inner {
  max-width: 1100px; margin: 0 auto; padding: 0 1.5rem;
  height: 52px;
  display: flex; align-items: center;
  justify-content: space-between; gap: 1rem;
}
.pp-back {
  display: inline-flex; align-items: center; gap: .45rem;
  color: #4f46e5; font-weight: 600; font-size: .82rem;
  text-decoration: none; flex-shrink: 0; transition: color .2s;
}
.pp-back:hover { color: #3730a3; }
.pp-secure-badge {
  display: flex; align-items: center; gap: .35rem;
  font-size: .75rem; font-weight: 600; color: #10b981;
  background: #ecfdf5; border-radius: 20px;
  padding: .25rem .75rem; flex-shrink: 0;
}
.pp-secure-badge i { font-size: .7rem; }


/* ─── Body ──────────────────────────────────── */
.pp-body { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem 5rem; }
.pp-layout {
  display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;
}

/* ─── Card ──────────────────────────────────── */
.pp-card {
  background: #fff; border-radius: 20px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 16px rgba(0,0,0,.06);
  overflow: hidden;
}
.pp-card--mt { margin-top: 1.5rem; }
.pp-card__head {
  padding: 1.5rem 2rem 1.1rem;
  border-bottom: 1px solid #f3f4f6;
}
.pp-section-badge {
  display: inline-flex; align-items: center; gap: .4rem;
  font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .6px;
  background: #eef2ff; color: #4f46e5;
  padding: .25rem .85rem; border-radius: 50px; margin-bottom: .55rem;
}
.pp-section-badge--pink { background: #fdf2f8; color: #db2777; }
.pp-card__title { font-size: 1.4rem; font-weight: 800; color: #111827; margin: 0 0 .35rem; }
.pp-card__sub   { font-size: .9rem; color: #6b7280; margin: 0; }

.pp-fields { padding: 1.75rem 2rem; display: flex; flex-direction: column; gap: 1.1rem; }

.pp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

.pp-field { display: flex; flex-direction: column; gap: .4rem; }
.pp-field label { font-size: .84rem; font-weight: 600; color: #374151; }
.pp-req { color: #ef4444; }
.pp-field__hint { font-size: .75rem; color: #9ca3af; }
.pp-input {
  padding: .75rem 1rem; border-radius: 10px;
  border: 1.5px solid #e5e7eb; font-size: .9rem; color: #111827;
  background: #fff; outline: none; transition: border-color .2s, box-shadow .2s;
  width: 100%;
}
.pp-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,.1); }
.pp-field.error .pp-input { border-color: #ef4444; }
.pp-input--icon { padding-left: 2.5rem; }
.pp-textarea { resize: vertical; min-height: 80px; }
.pp-txn-input-wrap { position: relative; }
.pp-txn-icon {
  position: absolute; left: .9rem; top: 50%; transform: translateY(-50%);
  color: #9ca3af; font-size: .85rem;
}
.pp-err-msg { font-size: .78rem; color: #ef4444; display: flex; align-items: center; gap: .35rem; }
.mt-2 { margin-top: .5rem; }

.pp-card__foot {
  display: flex; align-items: center; justify-content: space-between;
  padding: 1.25rem 2rem; border-top: 1px solid #f3f4f6;
}

/* ─── bKash block ───────────────────────────── */
.pp-bkash-block {
  margin: 0 2rem; padding: 1.5rem;
  background: #f0fdf4; border: 1.5px solid #bbf7d0;
  border-radius: 16px;
}
.pp-bkash-header { display: flex; align-items: flex-start; gap: 1.25rem; flex-wrap: wrap; }
.pp-bkash-logo-wrap {
  background: #fff; border-radius: 10px; padding: .5rem .65rem;
  box-shadow: 0 1px 6px rgba(0,0,0,.1); flex-shrink: 0;
  display: flex; align-items: center;
}
.pp-bkash-logo { height: 28px; width: auto; object-fit: contain; display: block; border-radius: 4px; }
.pp-bkash-label { font-size: .78rem; color: #16a34a; font-weight: 600; margin-bottom: .35rem; }
.pp-bkash-number-row { display: flex; align-items: center; gap: .75rem; margin-bottom: .3rem; }
.pp-bkash-number { font-size: 1.5rem; font-weight: 900; color: #e11d48; letter-spacing: 1px; }
.pp-copy-btn {
  display: inline-flex; align-items: center; gap: .35rem;
  font-size: .75rem; font-weight: 600; padding: .3rem .75rem;
  border-radius: 6px; border: 1.5px solid #d1fae5;
  background: #fff; color: #059669; cursor: pointer;
  transition: all .2s;
}
.pp-copy-btn.copied { background: #059669; color: #fff; border-color: #059669; }
.pp-bkash-acname { font-size: .82rem; color: #4b5563; margin: 0; }

.pp-payment-steps { margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid #d1fae5; }
.pp-payment-steps__title { font-size: .82rem; font-weight: 700; color: #374151; margin-bottom: .6rem; }
.pp-payment-steps__list { padding-left: 1.25rem; margin: 0; display: flex; flex-direction: column; gap: .4rem; }
.pp-payment-steps__list li { font-size: .85rem; color: #4b5563; }

/* ─── Proof section ─────────────────────────── */
.pp-proof-section { padding: 1.5rem 2rem; }
.pp-proof-title { font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 1rem; }

.pp-divider {
  display: flex; align-items: center; gap: .85rem;
  margin: 1.1rem 0; font-size: .78rem; color: #9ca3af;
}
.pp-divider::before, .pp-divider::after {
  content: ''; flex: 1; height: 1px; background: #e5e7eb;
}

.pp-upload-zone {
  border: 2px dashed #d1d5db; border-radius: 14px;
  padding: 2.25rem 1.5rem; text-align: center; cursor: pointer;
  transition: border-color .2s, background .2s; position: relative;
  background: #fafafa;
}
.pp-upload-zone:hover, .pp-upload-zone.dragging {
  border-color: #4f46e5; background: #f5f3ff;
}
.pp-upload-zone.has-file { border-style: solid; border-color: #a5b4fc; background: #f5f3ff; }
.pp-upload-zone--sm {
  padding: 1rem; display: flex; align-items: center; justify-content: center;
  gap: .6rem; min-height: 68px; flex-direction: row;
}
.pp-upload-zone--sm i { font-size: 1.25rem; color: #c7d2fe; flex-shrink: 0; }
.pp-upload-zone--sm span { font-size: .8rem; color: #9ca3af; }
.pp-upload-zone__icon { font-size: 2.25rem; color: #c7d2fe; margin-bottom: .6rem; }
.pp-upload-zone__text { font-size: .9rem; color: #6b7280; margin-bottom: .25rem; }
.pp-upload-zone__hint { font-size: .75rem; color: #d1d5db; }
.pp-upload-zone__preview { max-height: 160px; border-radius: 10px; object-fit: cover; margin: 0 auto; display: block; }
.pp-upload-zone__remove {
  margin-top: .75rem; background: #fef2f2; color: #ef4444;
  border: 1px solid #fecaca; border-radius: 8px;
  padding: .35rem .9rem; cursor: pointer; font-size: .8rem;
  display: inline-flex; align-items: center; gap: .35rem;
}

/* ─── Buttons ───────────────────────────────── */
.pp-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
  font-weight: 700; text-decoration: none;
  padding: .8rem 1.75rem; border-radius: 10px; border: none; cursor: pointer;
  font-size: .95rem; transition: transform .15s, box-shadow .15s;
}
.pp-btn:hover { transform: translateY(-2px); }
.pp-btn--primary {
  background: linear-gradient(135deg,#4f46e5,#7c3aed); color: #fff;
  box-shadow: 0 4px 16px rgba(79,70,229,.3);
}
.pp-btn--primary:hover { box-shadow: 0 8px 24px rgba(79,70,229,.4); }
.pp-btn--ghost {
  background: #f9fafb; color: #374151;
  border: 1.5px solid #e5e7eb;
}
.pp-btn--ghost:hover { background: #f3f4f6; }
.pp-btn--confirm {
  background: linear-gradient(135deg,#059669,#10b981); color: #fff;
  box-shadow: 0 4px 16px rgba(16,185,129,.3);
  padding: .9rem 2.25rem;
}
.pp-btn--confirm:hover { box-shadow: 0 8px 24px rgba(16,185,129,.4); }
.pp-btn--confirm:disabled { opacity: .65; cursor: not-allowed; transform: none; }
.ms-2 { margin-left: .5rem; }
.me-1 { margin-right: .25rem; }
.me-2 { margin-right: .5rem; }

/* ─── Summary col ───────────────────────────── */
.pp-summary {
  background: #fff; border-radius: 20px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 16px rgba(0,0,0,.06);
  padding: 1.75rem;
  position: sticky; top: 140px;
}
.pp-summary__title { font-size: 1.1rem; font-weight: 800; color: #111827; margin-bottom: 1.25rem; }
.pp-summary__product { display: flex; gap: 1rem; margin-bottom: 1.25rem; align-items: center; }
.pp-summary__thumb {
  width: 64px; height: 64px; border-radius: 12px; overflow: hidden;
  flex-shrink: 0; display: flex; align-items: center; justify-content: center;
  color: rgba(255,255,255,.6); font-size: 1.75rem;
}
.pp-summary__thumb img { width: 100%; height: 100%; object-fit: cover; }
.pp-summary__name { font-size: .95rem; font-weight: 700; color: #111827; margin: 0 0 .2rem; line-height: 1.3; }
.pp-summary__cat  { font-size: .78rem; color: #9ca3af; margin: 0; }
.pp-summary__divider { height: 1px; background: #f3f4f6; margin: 1rem 0; }
.pp-summary__pricing { display: flex; flex-direction: column; gap: .5rem; }
.pp-summary__line { display: flex; justify-content: space-between; font-size: .88rem; color: #6b7280; }
.pp-summary__line--discount { color: #059669; }
.pp-summary__line--total { font-size: 1.1rem; font-weight: 800; color: #111827; padding-top: .5rem; }
.pp-summary__features { margin-top: 1.25rem; }
.pp-summary__feat-title { font-size: .8rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: .5px; margin-bottom: .65rem; }
.pp-summary__features ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .4rem; }
.pp-summary__features li { font-size: .83rem; color: #4b5563; display: flex; align-items: flex-start; gap: .5rem; }
.pp-summary__features li i { color: #10b981; font-size: .7rem; margin-top: .2rem; flex-shrink: 0; }
.pp-summary__more { color: #9ca3af !important; font-style: italic; }
.pp-summary__guarantee {
  margin-top: 1.25rem; padding: .85rem 1rem;
  background: #f0fdf4; border-radius: 10px;
  display: flex; align-items: center; gap: .65rem;
  font-size: .8rem; color: #16a34a; font-weight: 600;
}
.pp-summary__guarantee i { font-size: 1rem; }

/* ─── Success page ──────────────────────────── */
.pp-success-page {
  min-height: 100vh; display: flex; align-items: center; justify-content: center;
  background: #f4f6fb; padding: 2rem;
}
.pp-success-card {
  background: #fff; border-radius: 24px; padding: 3.5rem 3rem;
  text-align: center; max-width: 520px; width: 100%;
  box-shadow: 0 8px 40px rgba(0,0,0,.1);
}
.pp-success-icon-wrap {
  width: 80px; height: 80px; border-radius: 50%;
  background: #ecfdf5; display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1.5rem;
}
.pp-success-icon-wrap i { font-size: 2.5rem; color: #10b981; }
.pp-success-card h2 { font-size: 1.75rem; font-weight: 900; color: #111827; margin-bottom: 1rem; }
.pp-success-card p  { font-size: .97rem; color: #6b7280; line-height: 1.75; margin-bottom: 1.25rem; }
.pp-success-ref {
  background: #f3f4f6; border-radius: 8px; padding: .65rem 1.25rem;
  font-size: .85rem; color: #374151; display: inline-block; margin-bottom: 1.75rem;
}

/* ─── Responsive ────────────────────────────── */
@media (max-width: 1024px) {
  .pp-layout { grid-template-columns: 1fr; }
  .pp-summary { position: static; }
}
@media (max-width: 640px) {
  .pp-card__head { padding: 1.5rem; }
  .pp-fields { padding: 1.25rem 1.5rem; }
  .pp-card__foot { padding: 1.25rem 1.5rem; }
  .pp-bkash-block { margin: 0 1.25rem; }
  .pp-proof-section { padding: 1.25rem 1.5rem; }
  .pp-row { grid-template-columns: 1fr; }
}
</style>
