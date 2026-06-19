<template>
  <div class="pp-page">

    <!-- Loading -->
    <div v-if="loading" class="pp-loading">
      <div class="pp-spinner"></div>
    </div>

    <!-- Not found -->
    <div v-else-if="!product" class="pp-notfound">
      <div class="pp-notfound__icon"><i class="fas fa-box-open"></i></div>
      <h2>Product Not Found</h2>
      <p>The product you're looking for doesn't exist or has been removed.</p>
      <a href="/#products" class="pp-btn pp-btn--primary">← Back to Products</a>
    </div>

    <!-- Success -->
    <div v-else-if="submitted" class="pp-success-page">
      <div class="pp-success-card">
        <div class="pp-success-glow"></div>
        <div class="pp-success-icon">
          <svg viewBox="0 0 52 52" fill="none">
            <circle cx="26" cy="26" r="26" fill="#ecfdf5"/>
            <path d="M14 26l8 8 16-16" stroke="#10b981" stroke-width="3.5"
                  stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <h2>Order Confirmed!</h2>
        <p>Thank you, <strong>{{ form.name }}</strong>! Your order for <strong>{{ product.name }}</strong> has been received. We'll verify your payment and reach you at <strong>{{ form.phone }}</strong> within 24 hours.</p>
        <div class="pp-success-ref">
          <span class="pp-success-ref__label">Reference Number</span>
          <span class="pp-success-ref__code">{{ refCode }}</span>
        </div>
        <div class="pp-success-meta">
          <div class="pp-success-meta__item">
            <i class="fas fa-clock"></i>
            <span>Verification within 24 hours</span>
          </div>
          <div class="pp-success-meta__item">
            <i class="fab fa-whatsapp"></i>
            <span>We'll contact you on WhatsApp</span>
          </div>
        </div>
        <a href="/#products" class="pp-btn pp-btn--primary pp-btn--full">← Explore More Products</a>
      </div>
    </div>

    <!-- Checkout -->
    <template v-else>
      <!-- Top bar -->
      <div class="pp-topbar">
        <div class="pp-topbar__inner">
          <a :href="'/products/' + slug" class="pp-back">
            <i class="fas fa-chevron-left"></i><span>Back</span>
          </a>
          <div class="pp-topbar__steps">
            <div class="pp-step pp-step--done">
              <span class="pp-step__num">1</span>
              <span class="pp-step__label">Product</span>
            </div>
            <div class="pp-step__line"></div>
            <div class="pp-step pp-step--active">
              <span class="pp-step__num">2</span>
              <span class="pp-step__label">Order</span>
            </div>
            <div class="pp-step__line"></div>
            <div class="pp-step">
              <span class="pp-step__num">3</span>
              <span class="pp-step__label">Confirm</span>
            </div>
          </div>
          <div class="pp-secure"><i class="fas fa-lock"></i><span>Secure</span></div>
        </div>
      </div>
      <!-- Hero -->
      <div class="pp-hero" :style="heroBg">
        <div class="pp-hero__noise"></div>
        <div class="pp-hero__inner">
          <div class="pp-hero__thumb">
            <img v-if="productThumb" :src="productThumb" :alt="product.name" />
            <i v-else class="fas fa-cube"></i>
          </div>
          <div class="pp-hero__text">
            <div class="pp-hero__badge">{{ product.productGroupId?.name || 'Software' }}</div>
            <h1 class="pp-hero__name">{{ product.name }}</h1>
            <div class="pp-hero__price-row">
              <span v-if="product.sales_price" class="pp-hero__price">৳{{ fmt(product.sales_price) }}</span>
              <span v-if="product.sales_price && product.regular_price" class="pp-hero__price-strike">৳{{ fmt(product.regular_price) }}</span>
              <span v-else-if="product.regular_price" class="pp-hero__price">৳{{ fmt(product.regular_price) }}</span>
              <span v-if="discountPct" class="pp-hero__save">{{ discountPct }}% OFF</span>
            </div>
          </div>
        </div>
      </div>
      <!-- Body -->
      <div class="pp-body">
        <div class="pp-layout">

          <!-- Left: Form -->
          <div class="pp-form-col">

            <!-- Section 1: Your Info + Project Details (combined) -->
            <div class="pp-card">
              <div class="pp-card__head">
                <div class="pp-step-tag"><span class="pp-step-tag__num">1</span> Your Information &amp; Project Details</div>
                <p class="pp-card__sub">Fill in your contact details and tell us about your project.</p>
              </div>
              <div class="pp-fields">

                <!-- Contact fields -->
                <div class="pp-row">
                  <div class="pp-field" :class="{ 'pp-field--error': err.name }">
                    <label class="pp-label">Full Name <span class="pp-req">*</span></label>
                    <div class="pp-input-wrap">
                      <i class="fas fa-user pp-input-icon"></i>
                      <input v-model="form.name" type="text" placeholder="Ahsan Rahman" class="pp-input pp-input--icon" @input="clearErr('name')" />
                    </div>
                    <span v-if="err.name" class="pp-err">{{ err.name }}</span>
                  </div>
                  <div class="pp-field" :class="{ 'pp-field--error': err.phone }">
                    <label class="pp-label">Phone Number <span class="pp-req">*</span></label>
                    <div class="pp-input-wrap">
                      <i class="fas fa-phone pp-input-icon"></i>
                      <input v-model="form.phone" type="tel" placeholder="01XXXXXXXXX" class="pp-input pp-input--icon" @input="clearErr('phone')" />
                    </div>
                    <span v-if="err.phone" class="pp-err">{{ err.phone }}</span>
                  </div>
                </div>
                <div class="pp-row">
                  <div class="pp-field">
                    <label class="pp-label">Email Address <span class="pp-opt">optional</span></label>
                    <div class="pp-input-wrap">
                      <i class="fas fa-envelope pp-input-icon"></i>
                      <input v-model="form.email" type="email" placeholder="you@email.com" class="pp-input pp-input--icon" />
                    </div>
                  </div>
                  <div class="pp-field">
                    <label class="pp-label">Special Requirements <span class="pp-opt">optional</span></label>
                    <div class="pp-input-wrap">
                      <i class="fas fa-comment pp-input-icon"></i>
                      <input v-model="form.message" type="text" placeholder="Any specific requirements?" class="pp-input pp-input--icon" />
                    </div>
                  </div>
                </div>

                <!-- Inline divider -->
                <div class="pp-section-divider">
                  <span class="pp-section-divider__label"><i class="fas fa-folder-open"></i> Project Details</span>
                </div>

                <!-- Project fields -->
                <div class="pp-row">
                  <div class="pp-field" :class="{ 'pp-field--error': err.domain }">
                    <label class="pp-label">Domain Name <span class="pp-opt">if applicable</span></label>
                    <div class="pp-input-wrap">
                      <i class="fas fa-globe pp-input-icon"></i>
                      <input v-model="form.domain" type="text" placeholder="e.g. mycompany.com" class="pp-input pp-input--icon pp-input--mono" @input="clearErr('domain')" />
                    </div>
                    <span v-if="err.domain" class="pp-err">{{ err.domain }}</span>
                    <span class="pp-field__hint">Leave blank if you don't have a domain yet</span>
                  </div>
                  <div class="pp-field">
                    <label class="pp-label">Preferred Delivery Date <span class="pp-opt">optional</span></label>
                    <div class="pp-input-wrap">
                      <i class="fas fa-calendar-alt pp-input-icon"></i>
                      <input v-model="form.delivery_date" type="date" class="pp-input pp-input--icon" />
                    </div>
                  </div>
                </div>
                <div class="pp-field">
                  <label class="pp-label">Project Description <span class="pp-opt">optional</span></label>
                  <div class="pp-desc-wrap">
                    <i class="fas fa-align-left pp-desc-icon"></i>
                    <textarea
                      v-model="form.description"
                      rows="5"
                      placeholder="Describe your project in detail:&#10;• What features do you need?&#10;• Preferred design style / colors?&#10;• Reference websites?&#10;• Target audience?&#10;• Any other important info..."
                      class="pp-textarea"
                      @input="clearErr('description')"
                    ></textarea>
                  </div>
                  <div v-if="form.description.length > 0" class="pp-char-count">
                    <i class="fas fa-info-circle"></i>
                    {{ form.description.length }} characters
                  </div>
                </div>

              </div>
            </div>

            <!-- Section 2: Payment -->
            <div class="pp-card pp-card--mt">
              <div class="pp-card__head pp-card__head--flex">
                <div>
                  <div class="pp-step-tag pp-step-tag--violet">
                    <span class="pp-step-tag__num pp-step-tag__num--violet">2</span>
                    Payment
                  </div>
                  <p class="pp-card__sub">
                    {{ payNow ? 'Select your method and send the exact amount.' : 'You can pay after we confirm your order.' }}
                  </p>
                </div>
                <!-- Toggle switch -->
                <div class="pp-toggle-wrap">
                  <span class="pp-toggle-label">{{ payNow ? 'Pay Now' : 'Pay Later' }}</span>
                  <button
                    type="button"
                    class="pp-toggle"
                    :class="{ 'pp-toggle--on': payNow }"
                    @click="payNow = !payNow"
                    :aria-checked="payNow"
                    role="switch"
                  >
                    <span class="pp-toggle__thumb"></span>
                  </button>
                </div>
              </div>

              <!-- Pay Later placeholder -->
              <div v-if="!payNow" class="pp-paylater">
                <div class="pp-paylater__icon"><i class="fas fa-clock"></i></div>
                <div>
                  <p class="pp-paylater__title">Pay after confirmation</p>
                  <p class="pp-paylater__sub">We'll review your order and send payment instructions to <strong>{{ form.phone || 'your phone' }}</strong> within 24 hours.</p>
                </div>
              </div>

              <!-- Payment method tabs (shown only when payNow is true) -->
              <template v-if="payNow">
              <div class="pp-method-tabs">
                <button
                  v-for="m in availableMethods"
                  :key="m.key"
                  type="button"
                  class="pp-method-tab"
                  :class="['pp-method-tab--' + m.key, { 'pp-method-tab--active': paymentMethod === m.key }]"
                  @click="selectMethod(m.key)"
                >
                  <span class="pp-method-tab__icon" :style="{ background: m.color }">
                    <i :class="m.icon"></i>
                  </span>
                  <span class="pp-method-tab__label">{{ m.label }}</span>
                  <span v-if="paymentMethod === m.key" class="pp-method-tab__check">
                    <i class="fas fa-check-circle"></i>
                  </span>
                </button>
              </div>

              <!-- bKash block -->
              <div v-if="paymentMethod === 'bkash'" class="pp-pay-block pp-pay-block--bkash">
                <div class="pp-pay-block__top">
                  <div class="pp-pay-block__brand">
                    <div class="pp-pay-block__logo-box" style="background:#e11d48">
                      <span class="pp-pay-block__logo-text">bKash</span>
                    </div>
                    <div>
                      <p class="pp-pay-block__type" style="color:#e11d48">
                        {{ get_setting_value('bkash_account_type') || 'Personal' }} Account
                      </p>
                      <p class="pp-pay-block__acname">Send Money</p>
                    </div>
                  </div>
                  <div class="pp-pay-block__amount-box">
                    <span class="pp-pay-block__amount-label">Amount</span>
                    <span class="pp-pay-block__amount" style="color:#e11d48">৳{{ fmt(payAmount) }}</span>
                  </div>
                </div>
                <div class="pp-pay-block__number-section">
                  <p class="pp-pay-block__number-label">bKash Number</p>
                  <div class="pp-pay-block__number-row">
                    <span class="pp-pay-block__number" style="color:#e11d48">{{ get_setting_value('bkash_number') || '—' }}</span>
                    <button type="button" class="pp-copy-btn" style="--c:#e11d48;--cb:#fff1f2" @click="copyText(get_setting_value('bkash_number'), 'bkash')" :class="{ 'pp-copy-btn--copied': copied.bkash }">
                      <i :class="copied.bkash ? 'fas fa-check' : 'far fa-copy'"></i>
                      {{ copied.bkash ? 'Copied!' : 'Copy' }}
                    </button>
                  </div>
                </div>
                <div class="pp-pay-block__steps">
                  <p class="pp-pay-block__steps-title"><i class="fas fa-list-ol"></i> How to pay</p>
                  <div class="pp-pay-block__steps-grid">
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#e11d48">1</span><span>Open bKash → <strong>Send Money</strong></span></div>
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#e11d48">2</span><span>Enter: <strong>{{ get_setting_value('bkash_number') }}</strong></span></div>
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#e11d48">3</span><span>Amount: <strong>৳{{ fmt(payAmount) }}</strong></span></div>
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#e11d48">4</span><span>Copy the <strong>Transaction ID</strong></span></div>
                  </div>
                </div>
              </div>

              <!-- Nagad block -->
              <div v-if="paymentMethod === 'nagad'" class="pp-pay-block pp-pay-block--nagad">
                <div class="pp-pay-block__top">
                  <div class="pp-pay-block__brand">
                    <div class="pp-pay-block__logo-box" style="background:#f97316">
                      <span class="pp-pay-block__logo-text">Nagad</span>
                    </div>
                    <div>
                      <p class="pp-pay-block__type" style="color:#f97316">
                        {{ get_setting_value('nagad_account_type') || 'Personal' }} Account
                      </p>
                      <p class="pp-pay-block__acname">Send Money</p>
                    </div>
                  </div>
                  <div class="pp-pay-block__amount-box">
                    <span class="pp-pay-block__amount-label">Amount</span>
                    <span class="pp-pay-block__amount" style="color:#f97316">৳{{ fmt(payAmount) }}</span>
                  </div>
                </div>
                <div class="pp-pay-block__number-section">
                  <p class="pp-pay-block__number-label">Nagad Number</p>
                  <div class="pp-pay-block__number-row">
                    <span class="pp-pay-block__number" style="color:#f97316">{{ get_setting_value('nagad_number') || '—' }}</span>
                    <button type="button" class="pp-copy-btn" style="--c:#f97316;--cb:#fff7ed" @click="copyText(get_setting_value('nagad_number'), 'nagad')" :class="{ 'pp-copy-btn--copied': copied.nagad }">
                      <i :class="copied.nagad ? 'fas fa-check' : 'far fa-copy'"></i>
                      {{ copied.nagad ? 'Copied!' : 'Copy' }}
                    </button>
                  </div>
                </div>
                <div class="pp-pay-block__steps">
                  <p class="pp-pay-block__steps-title"><i class="fas fa-list-ol"></i> How to pay</p>
                  <div class="pp-pay-block__steps-grid">
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#f97316">1</span><span>Open Nagad → <strong>Send Money</strong></span></div>
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#f97316">2</span><span>Enter: <strong>{{ get_setting_value('nagad_number') }}</strong></span></div>
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#f97316">3</span><span>Amount: <strong>৳{{ fmt(payAmount) }}</strong></span></div>
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#f97316">4</span><span>Copy the <strong>Transaction ID</strong></span></div>
                  </div>
                </div>
              </div>

              <!-- Rocket block -->
              <div v-if="paymentMethod === 'rocket'" class="pp-pay-block pp-pay-block--rocket">
                <div class="pp-pay-block__top">
                  <div class="pp-pay-block__brand">
                    <div class="pp-pay-block__logo-box" style="background:#7c3aed">
                      <span class="pp-pay-block__logo-text">Rocket</span>
                    </div>
                    <div>
                      <p class="pp-pay-block__type" style="color:#7c3aed">
                        {{ get_setting_value('rocket_account_type') || 'Personal' }} Account
                      </p>
                      <p class="pp-pay-block__acname">Send Money</p>
                    </div>
                  </div>
                  <div class="pp-pay-block__amount-box">
                    <span class="pp-pay-block__amount-label">Amount</span>
                    <span class="pp-pay-block__amount" style="color:#7c3aed">৳{{ fmt(payAmount) }}</span>
                  </div>
                </div>
                <div class="pp-pay-block__number-section">
                  <p class="pp-pay-block__number-label">Rocket Number</p>
                  <div class="pp-pay-block__number-row">
                    <span class="pp-pay-block__number" style="color:#7c3aed">{{ get_setting_value('rocket_number') || '—' }}</span>
                    <button type="button" class="pp-copy-btn" style="--c:#7c3aed;--cb:#f5f3ff" @click="copyText(get_setting_value('rocket_number'), 'rocket')" :class="{ 'pp-copy-btn--copied': copied.rocket }">
                      <i :class="copied.rocket ? 'fas fa-check' : 'far fa-copy'"></i>
                      {{ copied.rocket ? 'Copied!' : 'Copy' }}
                    </button>
                  </div>
                </div>
                <div class="pp-pay-block__steps">
                  <p class="pp-pay-block__steps-title"><i class="fas fa-list-ol"></i> How to pay</p>
                  <div class="pp-pay-block__steps-grid">
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#7c3aed">1</span><span>Open Rocket → <strong>Send Money</strong></span></div>
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#7c3aed">2</span><span>Enter: <strong>{{ get_setting_value('rocket_number') }}</strong></span></div>
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#7c3aed">3</span><span>Amount: <strong>৳{{ fmt(payAmount) }}</strong></span></div>
                    <div class="pp-pay-block__step"><span class="pp-pay-block__step-n" style="background:#7c3aed">4</span><span>Copy the <strong>Transaction ID</strong></span></div>
                  </div>
                </div>
              </div>

              <!-- Bank Transfer block -->
              <div v-if="paymentMethod === 'bank'" class="pp-pay-block pp-pay-block--bank">
                <div class="pp-pay-block__top">
                  <div class="pp-pay-block__brand">
                    <div class="pp-pay-block__logo-box" style="background:#1d4ed8">
                      <i class="fas fa-university" style="color:#fff;font-size:1.1rem"></i>
                    </div>
                    <div>
                      <p class="pp-pay-block__type" style="color:#1d4ed8">Bank Transfer</p>
                      <p class="pp-pay-block__acname">{{ get_setting_value('bank_name') || 'Bank Deposit' }}</p>
                    </div>
                  </div>
                  <div class="pp-pay-block__amount-box">
                    <span class="pp-pay-block__amount-label">Amount</span>
                    <span class="pp-pay-block__amount" style="color:#1d4ed8">৳{{ fmt(payAmount) }}</span>
                  </div>
                </div>
                <div class="pp-bank-details">
                  <div class="pp-bank-row">
                    <span class="pp-bank-row__label">Bank Name</span>
                    <span class="pp-bank-row__value">{{ get_setting_value('bank_name') || '—' }}</span>
                  </div>
                  <div class="pp-bank-row">
                    <span class="pp-bank-row__label">Account Name</span>
                    <span class="pp-bank-row__value">{{ get_setting_value('bank_account_name') || '—' }}</span>
                  </div>
                  <div class="pp-bank-row pp-bank-row--highlight">
                    <span class="pp-bank-row__label">Account Number</span>
                    <div class="pp-pay-block__number-row">
                      <span class="pp-bank-row__acc">{{ get_setting_value('bank_account_number') || '—' }}</span>
                      <button type="button" class="pp-copy-btn" style="--c:#1d4ed8;--cb:#eff6ff" @click="copyText(get_setting_value('bank_account_number'), 'bank')" :class="{ 'pp-copy-btn--copied': copied.bank }">
                        <i :class="copied.bank ? 'fas fa-check' : 'far fa-copy'"></i>
                        {{ copied.bank ? 'Copied!' : 'Copy' }}
                      </button>
                    </div>
                  </div>
                  <div class="pp-bank-row">
                    <span class="pp-bank-row__label">Branch</span>
                    <span class="pp-bank-row__value">{{ get_setting_value('bank_branch_name') || '—' }}</span>
                  </div>
                  <div class="pp-bank-row">
                    <span class="pp-bank-row__label">Routing Number</span>
                    <span class="pp-bank-row__value">{{ get_setting_value('bank_routing_number') || '—' }}</span>
                  </div>
                  <div class="pp-bank-row pp-bank-row--total">
                    <span class="pp-bank-row__label">Deposit Amount</span>
                    <span class="pp-bank-row__value" style="color:#1d4ed8;font-weight:800">৳{{ fmt(payAmount) }}</span>
                  </div>
                </div>
              </div>

              <!-- Proof -->
              <div class="pp-proof">
                <div class="pp-proof__title">Payment Proof</div>
                <div class="pp-row" :class="{ 'pp-field--error': err.payment }">
                  <div class="pp-field">
                    <label class="pp-label">
                      {{ paymentMethod === 'bank' ? 'Transaction / Reference ID' : 'Transaction ID' }}
                      <span class="pp-req">*</span>
                    </label>
                    <div class="pp-input-wrap">
                      <i class="fas fa-hashtag pp-input-icon"></i>
                      <input v-model="form.txn_id" type="text" placeholder="e.g. 8KJ3YU9P2Q" class="pp-input pp-input--icon pp-input--mono" @input="clearErr('payment')" />
                    </div>
                  </div>
                  <div class="pp-field">
                    <label class="pp-label">Payment Screenshot <span class="pp-opt">optional</span></label>
                    <div
                      class="pp-upload"
                      :class="{ 'pp-upload--drag': dragOver, 'pp-upload--has': !!form.screenshot }"
                      @dragover.prevent="dragOver = true"
                      @dragleave.prevent="dragOver = false"
                      @drop.prevent="onDrop"
                      @click="$refs.fileInput.click()"
                    >
                      <template v-if="!form.screenshot">
                        <i class="fas fa-cloud-upload-alt pp-upload__icon"></i>
                        <span class="pp-upload__text">Drop screenshot or click to browse</span>
                      </template>
                      <template v-else>
                        <img :src="screenshotPreview" class="pp-upload__preview" />
                        <button type="button" class="pp-upload__remove" @click.stop="removeScreenshot">
                          <i class="fas fa-times"></i> Remove
                        </button>
                      </template>
                    </div>
                    <input ref="fileInput" type="file" accept="image/*" style="display:none" @change="onFileChange" />
                  </div>
                </div>
                <p v-if="err.payment" class="pp-err pp-err--block">
                  <i class="fas fa-exclamation-circle"></i> {{ err.payment }}
                </p>
              </div>
              </template><!-- /v-if="payNow" -->

              <!-- Footer -->
              <div class="pp-card__foot">
                <div class="pp-foot-trust">
                  <i class="fas fa-lock"></i>
                  <span>100% Secure & Encrypted</span>
                </div>
                <button class="pp-btn pp-btn--confirm" @click="submitOrder" :disabled="submitting">
                  <span v-if="submitting">
                    <i class="fas fa-spinner fa-spin"></i> Processing…
                  </span>
                  <span v-else>
                    <i class="fas fa-shield-alt"></i> Confirm Order · ৳{{ fmt(payAmount) }}
                  </span>
                </button>
              </div>
            </div>

          </div>

          <!-- Right: Summary -->
          <div class="pp-summary-col">
            <div class="pp-summary">
              <h3 class="pp-summary__title">Order Summary</h3>
              <div class="pp-summary__product">
                <div class="pp-summary__thumb" :style="heroBg">
                  <img v-if="productThumb" :src="productThumb" :alt="product.name" />
                  <i v-else class="fas fa-cube"></i>
                </div>
                <div class="pp-summary__info">
                  <p class="pp-summary__name">{{ product.name }}</p>
                  <p v-if="product.productGroupId" class="pp-summary__cat">
                    <i class="fas fa-tag me-1"></i>{{ product.productGroupId.name }}
                  </p>
                  <span class="pp-summary__status" :class="'status--' + product.project_status">
                    {{ statusLabel(product.project_status) }}
                  </span>
                </div>
              </div>
              <div class="pp-summary__hr"></div>
              <div class="pp-summary__pricing">
                <div v-if="product.regular_price" class="pp-summary__row">
                  <span>Regular Price</span>
                  <span>৳{{ fmt(product.regular_price) }}</span>
                </div>
                <div v-if="discountPct" class="pp-summary__row pp-summary__row--green">
                  <span>Discount ({{ discountPct }}% off)</span>
                  <span>− ৳{{ fmt(product.regular_price - product.sales_price) }}</span>
                </div>
                <div class="pp-summary__hr"></div>
                <div class="pp-summary__row pp-summary__row--total">
                  <span>You Pay</span>
                  <span>৳{{ fmt(payAmount) }}</span>
                </div>
              </div>

              <!-- Payment method badge -->
              <div v-if="selectedMethod" class="pp-summary__method">
                <span class="pp-summary__method-dot" :style="{ background: selectedMethod.color }"></span>
                <span>Paying via <strong>{{ selectedMethod.label }}</strong></span>
              </div>

              <div v-if="features.length" class="pp-summary__features">
                <p class="pp-summary__feat-head">What's Included</p>
                <ul>
                  <li v-for="(f, i) in features.slice(0, 6)" :key="i">
                    <span class="pp-feat-tick"><i class="fas fa-check"></i></span>
                    <span>{{ f }}</span>
                  </li>
                  <li v-if="features.length > 6" class="pp-summary__more">
                    <span class="pp-feat-tick"><i class="fas fa-plus"></i></span>
                    <span>{{ features.length - 6 }} more features included</span>
                  </li>
                </ul>
              </div>

              <div class="pp-summary__hr"></div>
              <div class="pp-trust-list">
                <div class="pp-trust-item"><i class="fas fa-shield-alt"></i><span>Secure payment process</span></div>
                <div class="pp-trust-item"><i class="fas fa-headset"></i><span>Dedicated post-launch support</span></div>
                <div class="pp-trust-item"><i class="fas fa-clock"></i><span>Verified within 24 hours</span></div>
                <div class="pp-trust-item"><i class="fab fa-whatsapp"></i><span>WhatsApp confirmation sent</span></div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </template>
  </div>
</template>

<script>
import { site_settings_store } from '../../GlobalStore/site_settings_store';
import { mapActions } from 'pinia';

const STATUS_LABELS = {
  active: 'Live Now', development: 'In Development',
  planning: 'Coming Soon', paused: 'Paused',
};
const HERO_BG = {
  active:      'linear-gradient(140deg,#0f0c29,#302b63,#24243e)',
  development: 'linear-gradient(140deg,#200122,#6f0000,#3b0a5a)',
  planning:    'linear-gradient(140deg,#0f2027,#203a43,#2c5364)',
  paused:      'linear-gradient(140deg,#1a1a2e,#16213e,#0f3460)',
};

const ALL_METHODS = [
  { key: 'bkash',  label: 'bKash',         icon: 'fas fa-mobile-alt', color: '#e11d48', settingKey: 'bkash_number'  },
  { key: 'nagad',  label: 'Nagad',          icon: 'fas fa-mobile-alt', color: '#f97316', settingKey: 'nagad_number'  },
  { key: 'rocket', label: 'Rocket',         icon: 'fas fa-rocket',     color: '#7c3aed', settingKey: 'rocket_number' },
  { key: 'bank',   label: 'Bank Transfer',  icon: 'fas fa-university', color: '#1d4ed8', settingKey: 'bank_account_number' },
];

export default {
  name: 'ProductPaymentPage',
  props: { slug: { type: String, required: true } },

  data: () => ({
    product: null, loading: true,
    submitted: false, submitting: false,
    dragOver: false, screenshotPreview: null,
    refCode: '',
    paymentMethod: 'bkash',
    payNow: false,
    copied: { bkash: false, nagad: false, rocket: false, bank: false },
    form: {
      name: '', phone: '', email: '', message: '',
      domain: '', description: '', delivery_date: '',
      txn_id: '', screenshot: null,
    },
    err: {},
    settingsReady: false,
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
    heroBg() {
      return { background: HERO_BG[this.product?.project_status] || HERO_BG.active };
    },
    productThumb() {
      const t = this.product?.thumbnail;
      if (t && t !== 'default.png') return t.startsWith('http') ? t : '/' + t;
      const s = this.product?.screenshots;
      if (!s) return '/default.png';
      let first = s;
      try {
        const arr = JSON.parse(s);
        first = Array.isArray(arr) ? arr[0] : s;
      } catch { first = s; }  // single screenshot stored as plain string, not JSON
      if (!first || first === 'default.png') return '/default.png';
      return first.startsWith('http') ? first : '/' + first;
    },
    availableMethods() {
      return ALL_METHODS.filter(m => {
        if (!this.settingsReady) return true;
        if (m.key === 'bank') return !!this.get_setting_value('bank_account_number');
        return !!this.get_setting_value(m.settingKey);
      });
    },
    selectedMethod() {
      return ALL_METHODS.find(m => m.key === this.paymentMethod) || null;
    },
  },

  methods: {
    ...mapActions(site_settings_store, ['get_all_website_settings', 'get_setting_value']),

    fmt: n => n ? new Intl.NumberFormat('en-BD').format(n) : '0',
    statusLabel: s => STATUS_LABELS[s] || s,
    clearErr(key) { const e = { ...this.err }; delete e[key]; this.err = e; },

    selectMethod(key) {
      this.paymentMethod = key;
      this.form.txn_id = '';
      this.clearErr('payment');
    },

    copyText(text, key) {
      if (!text) return;
      navigator.clipboard.writeText(text).catch(() => {});
      this.copied = { ...this.copied, [key]: true };
      setTimeout(() => { this.copied = { ...this.copied, [key]: false }; }, 2000);
    },

    onFileChange(e) { const f = e.target.files[0]; if (f) this.setFile(f); },
    onDrop(e) { this.dragOver = false; const f = e.dataTransfer.files[0]; if (f) this.setFile(f); },
    setFile(f) { this.form.screenshot = f; this.screenshotPreview = URL.createObjectURL(f); },
    removeScreenshot() {
      this.form.screenshot = null; this.screenshotPreview = null;
      this.$refs.fileInput.value = '';
    },

    async submitOrder() {
      const e = {};
      if (!this.form.name.trim())  e.name  = 'Full name is required.';
      if (!this.form.phone.trim()) e.phone = 'Phone number is required.';
      if (this.payNow && !this.form.txn_id.trim() && !this.form.screenshot)
                                   e.payment = 'Enter a Transaction ID or upload a payment screenshot.';
      this.err = e;
      if (Object.keys(e).length) return;

      this.submitting = true;
      try {
        const fd = new FormData();
        fd.append('name',          this.form.name.trim());
        fd.append('phone',         this.form.phone.trim());
        fd.append('email',         this.form.email.trim());
        fd.append('message',       this.form.message.trim());
        fd.append('domain',        this.form.domain.trim());
        fd.append('description',   this.form.description.trim());
        fd.append('delivery_date', this.form.delivery_date);
        fd.append('pay_now',       this.payNow ? '1' : '0');
        fd.append('product_id',    this.product?.id ?? '');
        fd.append('product_name',  this.product?.name ?? '');
        fd.append('total_amount',  this.payAmount);

        if (this.payNow) {
          fd.append('payment_method', this.paymentMethod);
          fd.append('txn_id',         this.form.txn_id.trim());
          if (this.form.screenshot) fd.append('screenshot', this.form.screenshot);
        }

        const res = await window.axios.post('orders/submit', fd, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });

        this.refCode   = res?.data?.data?.ref_code || 'PFC-' + Date.now().toString().slice(-8);
        this.submitted = true;
      } catch (err) {
        const v = err?.response?.data?.data || {};
        const msg = err?.response?.data?.message || 'Something went wrong. Please try again.';
        this.err = {
          ...(v.name    ? { name:    v.name[0]    } : {}),
          ...(v.phone   ? { phone:   v.phone[0]   } : {}),
          ...(v.domain  ? { domain:  v.domain[0]  } : {}),
          ...((v.txn_id || v.screenshot) ? { payment: (v.txn_id || v.screenshot)[0] } : {}),
          ...(!Object.keys(v).length ? { name: msg } : {}),
        };
      } finally {
        this.submitting = false;
      }
    },

    async fetchProduct() {
      this.loading = true;
      try {
        const res = await window.axios.get(`public/products/${this.slug}`);
        this.product = res?.data?.data ?? res?.data ?? null;
      } catch { this.product = null; }
      finally { this.loading = false; }
    },

    async loadSettings() {
      await this.get_all_website_settings();
      this.settingsReady = true;
      // Auto-select first available method
      const first = this.availableMethods[0];
      if (first) this.paymentMethod = first.key;
    },
  },

  mounted() {
    this.fetchProduct();
    this.loadSettings();
  },
};
</script>

<style scoped>
/* ── Base ── */
.pp-page { min-height: 100vh; background: #f4f6fb; }
.me-1 { margin-right: .25rem; }

/* ── Loading ── */
.pp-loading { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
.pp-spinner {
  width: 48px; height: 48px; border-radius: 50%;
  border: 4px solid #e0e7ff; border-top-color: #4f46e5;
  animation: spin .7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Not found ── */
.pp-notfound {
  min-height: 80vh; display: flex; flex-direction: column;
  align-items: center; justify-content: center; gap: 1rem;
  text-align: center; padding: 2rem;
}
.pp-notfound__icon { font-size: 4rem; color: #c7d2fe; }
.pp-notfound h2 { font-size: 1.6rem; font-weight: 800; color: #1e1b4b; margin: 0; }
.pp-notfound p { color: #6b7280; margin: 0; }

/* ── Topbar ── */
.pp-topbar {
  background: #fff; border-bottom: 1px solid #e5e7eb;
  box-shadow: 0 1px 6px rgba(0,0,0,.05);
  margin-top: 72px; position: sticky; top: 0; z-index: 50;
}
.pp-topbar__inner {
  max-width: 1100px; margin: 0 auto; padding: 0 1.5rem;
  height: 56px; display: flex; align-items: center;
  justify-content: space-between; gap: 1rem;
}
.pp-back {
  display: inline-flex; align-items: center; gap: .4rem;
  color: #6b7280; font-weight: 600; font-size: .82rem;
  text-decoration: none; transition: color .15s; flex-shrink: 0;
}
.pp-back:hover { color: #4f46e5; }
.pp-topbar__steps { display: flex; align-items: center; gap: .5rem; }
.pp-step { display: flex; align-items: center; gap: .4rem; flex-shrink: 0; }
.pp-step__num {
  width: 24px; height: 24px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: .72rem; font-weight: 800;
  background: #f3f4f6; color: #9ca3af; border: 1.5px solid #e5e7eb;
}
.pp-step__label { font-size: .75rem; font-weight: 600; color: #9ca3af; }
.pp-step--active .pp-step__num { background: #4f46e5; color: #fff; border-color: #4f46e5; }
.pp-step--active .pp-step__label { color: #4f46e5; }
.pp-step--done .pp-step__num { background: #ecfdf5; color: #10b981; border-color: #10b981; }
.pp-step--done .pp-step__label { color: #10b981; }
.pp-step__line { width: 40px; height: 1.5px; background: #e5e7eb; flex-shrink: 0; }
.pp-secure {
  display: flex; align-items: center; gap: .35rem;
  font-size: .72rem; font-weight: 700; color: #10b981;
  background: #ecfdf5; padding: .3rem .75rem; border-radius: 20px; flex-shrink: 0;
}

/* ── Hero ── */
.pp-hero { position: relative; overflow: hidden; padding: 2.5rem 0; }
.pp-hero__noise {
  position: absolute; inset: 0; z-index: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
  background-size: 200px;
}
.pp-hero__inner {
  position: relative; z-index: 2;
  max-width: 1100px; margin: 0 auto; padding: 0 1.5rem;
  display: flex; align-items: center; gap: 1.5rem;
}
.pp-hero__thumb {
  width: 72px; height: 72px; border-radius: 16px; overflow: hidden;
  background: rgba(255,255,255,.12); border: 2px solid rgba(255,255,255,.2);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; font-size: 2rem; color: rgba(255,255,255,.4);
}
.pp-hero__thumb img { width: 100%; height: 100%; object-fit: cover; }
.pp-hero__text { flex: 1; min-width: 0; }
.pp-hero__badge {
  display: inline-block; font-size: .68rem; font-weight: 700; letter-spacing: .7px;
  text-transform: uppercase; color: rgba(255,255,255,.7);
  background: rgba(255,255,255,.12); border-radius: 50px;
  padding: .2rem .75rem; margin-bottom: .4rem;
}
.pp-hero__name {
  font-size: clamp(1.1rem,2.5vw,1.5rem); font-weight: 800; color: #fff;
  margin: 0 0 .4rem; line-height: 1.2;
}
.pp-hero__price-row { display: flex; align-items: baseline; gap: .6rem; flex-wrap: wrap; }
.pp-hero__price { font-size: 1.6rem; font-weight: 900; color: #fff; }
.pp-hero__price-strike { font-size: 1rem; color: rgba(255,255,255,.4); text-decoration: line-through; }
.pp-hero__save {
  font-size: .7rem; font-weight: 800; background: #ecfdf5; color: #065f46;
  padding: .2rem .65rem; border-radius: 50px; letter-spacing: .5px;
}

/* ── Layout ── */
.pp-body { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem 5rem; }
.pp-layout { display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start; }

/* ── Card ── */
.pp-card {
  background: #fff; border-radius: 20px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 20px rgba(0,0,0,.06); overflow: hidden;
}
.pp-card--mt { margin-top: 1.5rem; }
.pp-card__head {
  padding: 1.5rem 2rem 1.25rem;
  border-bottom: 1px solid #f3f4f6;
  background: #fafbff;
}
.pp-card__sub { font-size: .875rem; color: #6b7280; margin: .4rem 0 0; }
.pp-card__foot {
  display: flex; align-items: center; justify-content: space-between;
  padding: 1.25rem 2rem; border-top: 1px solid #f3f4f6;
  background: #fafbff; gap: 1rem; flex-wrap: wrap;
}
.pp-foot-trust {
  display: flex; align-items: center; gap: .4rem;
  font-size: .78rem; color: #10b981; font-weight: 600;
}

/* Step tags */
.pp-step-tag {
  display: inline-flex; align-items: center; gap: .5rem;
  font-size: .8rem; font-weight: 700; color: #4f46e5; margin-bottom: .1rem;
}
.pp-step-tag__num {
  width: 22px; height: 22px; border-radius: 50%;
  background: #4f46e5; color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: .7rem; font-weight: 800; flex-shrink: 0;
}
.pp-step-tag--violet { color: #7c3aed; }
.pp-step-tag__num--violet { background: #7c3aed; }
.pp-step-tag--teal { color: #0d9488; }
.pp-step-tag__num--teal { background: #0d9488; }

/* Fields */
.pp-fields { padding: 1.75rem 2rem; display: flex; flex-direction: column; gap: 1.25rem; }
.pp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.pp-field { display: flex; flex-direction: column; gap: .4rem; }
.pp-label { font-size: .83rem; font-weight: 600; color: #374151; }
.pp-req { color: #ef4444; margin-left: .1rem; }
.pp-opt { font-size: .72rem; font-weight: 400; color: #9ca3af; margin-left: .35rem; }
.pp-input-wrap { position: relative; }
.pp-input-icon {
  position: absolute; left: .9rem; top: 50%; transform: translateY(-50%);
  color: #d1d5db; font-size: .82rem; pointer-events: none;
}
.pp-input {
  width: 100%; padding: .78rem 1rem; border-radius: 10px;
  border: 1.5px solid #e5e7eb; font-size: .9rem; color: #111827;
  background: #fff; outline: none; transition: border-color .2s, box-shadow .2s;
}
.pp-input--icon { padding-left: 2.6rem; }
.pp-input--mono { font-family: 'Courier New', monospace; font-size: .95rem; letter-spacing: .5px; }
.pp-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,.1); }
.pp-field--error .pp-input { border-color: #ef4444; }
.pp-err { font-size: .78rem; color: #ef4444; display: flex; align-items: center; gap: .3rem; }
.pp-err--block { margin-top: .75rem; }
.pp-field__hint { font-size: .74rem; color: #9ca3af; }
.pp-char-count {
  font-size: .74rem; color: #10b981; display: flex; align-items: center; gap: .3rem;
}
.pp-char-count--warn { color: #f59e0b; }

/* ── Textarea ── */
.pp-desc-wrap { position: relative; }
.pp-desc-icon {
  position: absolute; left: .9rem; top: .9rem;
  color: #d1d5db; font-size: .82rem; pointer-events: none;
}
.pp-textarea {
  width: 100%; padding: .78rem 1rem .78rem 2.6rem;
  border-radius: 10px; border: 1.5px solid #e5e7eb;
  font-size: .9rem; color: #111827; background: #fff;
  outline: none; resize: vertical; line-height: 1.6;
  transition: border-color .2s, box-shadow .2s; font-family: inherit;
}
.pp-textarea:focus { border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13,148,136,.1); }
.pp-field--error .pp-textarea { border-color: #ef4444; }

/* ── Card head flex (for toggle) ── */
.pp-card__head--flex {
  display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;
}

/* ── Toggle switch ── */
.pp-toggle-wrap {
  display: flex; flex-direction: column; align-items: center; gap: .3rem; flex-shrink: 0;
}
.pp-toggle-label {
  font-size: .72rem; font-weight: 700; color: #6b7280; white-space: nowrap;
}
.pp-toggle {
  width: 52px; height: 28px; border-radius: 14px; border: none; cursor: pointer;
  background: #e5e7eb; position: relative; transition: background .25s;
  padding: 0;
}
.pp-toggle--on { background: #7c3aed; }
.pp-toggle__thumb {
  position: absolute; top: 3px; left: 3px;
  width: 22px; height: 22px; border-radius: 50%;
  background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,.2);
  transition: transform .25s cubic-bezier(.34,1.56,.64,1);
}
.pp-toggle--on .pp-toggle__thumb { transform: translateX(24px); }

/* ── Pay Later placeholder ── */
.pp-paylater {
  display: flex; align-items: flex-start; gap: 1rem;
  margin: 1.5rem 2rem; padding: 1.25rem 1.5rem;
  background: #f5f3ff; border: 1.5px solid #ddd6fe;
  border-radius: 14px;
}
.pp-paylater__icon {
  width: 42px; height: 42px; border-radius: 10px;
  background: #ede9fe; color: #7c3aed;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.1rem; flex-shrink: 0;
}
.pp-paylater__title { font-size: .9rem; font-weight: 700; color: #4c1d95; margin: 0 0 .2rem; }
.pp-paylater__sub { font-size: .82rem; color: #6b7280; margin: 0; line-height: 1.5; }

/* ── Payment Method Tabs ── */
.pp-method-tabs {
  display: flex; gap: .75rem; padding: 1.25rem 2rem;
  border-bottom: 1px solid #f3f4f6; flex-wrap: wrap;
}
.pp-method-tab {
  display: flex; align-items: center; gap: .6rem;
  padding: .65rem 1.1rem; border-radius: 12px;
  border: 1.5px solid #e5e7eb; background: #f9fafb;
  cursor: pointer; transition: all .2s; flex: 1; min-width: 110px;
  font-weight: 600; font-size: .82rem; color: #6b7280;
}
.pp-method-tab:hover { border-color: #c7d2fe; background: #fff; color: #374151; }
.pp-method-tab--active {
  border-color: currentColor; background: #fff;
  color: #111827; box-shadow: 0 2px 12px rgba(0,0,0,.08);
}
.pp-method-tab--bkash.pp-method-tab--active   { border-color: #e11d48; color: #e11d48; }
.pp-method-tab--nagad.pp-method-tab--active   { border-color: #f97316; color: #f97316; }
.pp-method-tab--rocket.pp-method-tab--active  { border-color: #7c3aed; color: #7c3aed; }
.pp-method-tab--bank.pp-method-tab--active    { border-color: #1d4ed8; color: #1d4ed8; }
.pp-method-tab__icon {
  width: 30px; height: 30px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: .8rem; flex-shrink: 0;
}
.pp-method-tab__label { flex: 1; text-align: left; }
.pp-method-tab__check { font-size: .85rem; margin-left: auto; }

/* ── Pay Block (shared) ── */
.pp-pay-block {
  margin: 0 2rem 0;
  border-radius: 16px; overflow: hidden;
  border: 1.5px solid #e5e7eb;
  animation: fadeSlide .2s ease;
}
.pp-pay-block--bkash  { border-color: #fda4af; background: linear-gradient(135deg,#fff1f2,#fff7f7); }
.pp-pay-block--nagad  { border-color: #fed7aa; background: linear-gradient(135deg,#fff7ed,#fffbf5); }
.pp-pay-block--rocket { border-color: #ddd6fe; background: linear-gradient(135deg,#f5f3ff,#faf9ff); }
.pp-pay-block--bank   { border-color: #bfdbfe; background: linear-gradient(135deg,#eff6ff,#f8faff); }

@keyframes fadeSlide {
  from { opacity: 0; transform: translateY(8px); }
  to   { opacity: 1; transform: translateY(0); }
}

.pp-pay-block__top {
  display: flex; align-items: center; justify-content: space-between;
  padding: 1.25rem 1.5rem; flex-wrap: wrap; gap: 1rem;
  border-bottom: 1px solid rgba(0,0,0,.06);
}
.pp-pay-block__brand { display: flex; align-items: center; gap: .85rem; }
.pp-pay-block__logo-box {
  border-radius: 10px; padding: .5rem .8rem;
  display: flex; align-items: center; justify-content: center; min-width: 64px;
}
.pp-pay-block__logo-text { color: #fff; font-weight: 900; font-size: .9rem; letter-spacing: .5px; white-space: nowrap; }
.pp-pay-block__type { font-size: .75rem; font-weight: 600; margin: 0 0 .1rem; }
.pp-pay-block__acname { font-size: .88rem; font-weight: 700; color: #1f2937; margin: 0; }
.pp-pay-block__amount-box { text-align: right; flex-shrink: 0; }
.pp-pay-block__amount-label { font-size: .72rem; color: #9ca3af; display: block; margin-bottom: .1rem; }
.pp-pay-block__amount { font-size: 1.8rem; font-weight: 900; }

.pp-pay-block__number-section {
  padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(0,0,0,.06);
  background: rgba(255,255,255,.6);
}
.pp-pay-block__number-label {
  font-size: .72rem; font-weight: 600; color: #6b7280;
  text-transform: uppercase; letter-spacing: .5px; margin-bottom: .5rem;
}
.pp-pay-block__number-row { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.pp-pay-block__number { font-size: 1.6rem; font-weight: 900; letter-spacing: 2px; font-family: 'Courier New', monospace; }

.pp-pay-block__steps { padding: 1.25rem 1.5rem; }
.pp-pay-block__steps-title { font-size: .8rem; font-weight: 700; color: #374151; margin-bottom: .85rem; }
.pp-pay-block__steps-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .65rem; }
.pp-pay-block__step { display: flex; align-items: flex-start; gap: .6rem; font-size: .82rem; color: #4b5563; }
.pp-pay-block__step-n {
  width: 20px; height: 20px; border-radius: 50%; flex-shrink: 0;
  color: #fff; display: flex; align-items: center; justify-content: center;
  font-size: .65rem; font-weight: 800; margin-top: .05rem;
}

/* ── Copy button ── */
.pp-copy-btn {
  display: inline-flex; align-items: center; gap: .35rem;
  font-size: .78rem; font-weight: 700; padding: .45rem 1rem;
  border-radius: 8px; border: 1.5px solid; cursor: pointer;
  transition: all .2s; white-space: nowrap;
  border-color: var(--c, #e11d48);
  background: var(--cb, #fff1f2);
  color: var(--c, #e11d48);
}
.pp-copy-btn:hover { filter: brightness(.95); }
.pp-copy-btn--copied { background: var(--c, #e11d48) !important; color: #fff !important; }

/* ── Bank details ── */
.pp-bank-details { padding: .5rem 1.5rem 1.25rem; }
.pp-bank-row {
  display: flex; justify-content: space-between; align-items: center;
  padding: .75rem 0; border-bottom: 1px solid rgba(0,0,0,.05);
  gap: 1rem;
}
.pp-bank-row:last-child { border-bottom: none; }
.pp-bank-row--highlight { background: rgba(29,78,216,.04); padding: .75rem .75rem; border-radius: 10px; margin: .25rem 0; border: none; }
.pp-bank-row--total { padding-top: 1rem; }
.pp-bank-row__label { font-size: .78rem; font-weight: 600; color: #6b7280; white-space: nowrap; }
.pp-bank-row__value { font-size: .88rem; font-weight: 700; color: #111827; text-align: right; }
.pp-bank-row__acc { font-size: 1.2rem; font-weight: 900; color: #1d4ed8; font-family: 'Courier New', monospace; letter-spacing: 1px; }

/* ── Proof ── */
.pp-proof { padding: 1.5rem 2rem 1.75rem; }
.pp-proof__title {
  font-size: .9rem; font-weight: 700; color: #111827; margin-bottom: 1.1rem;
  display: flex; align-items: center; gap: .5rem;
}
.pp-proof__title::before {
  content: ''; display: block; width: 3px; height: 18px;
  background: #4f46e5; border-radius: 2px;
}
.pp-upload {
  border: 2px dashed #d1d5db; border-radius: 12px;
  padding: 1.25rem; text-align: center; cursor: pointer;
  transition: border-color .2s, background .2s; position: relative;
  background: #fafafa; min-height: 80px;
  display: flex; align-items: center; justify-content: center;
  flex-direction: column; gap: .4rem;
}
.pp-upload:hover, .pp-upload--drag { border-color: #4f46e5; background: #f5f3ff; }
.pp-upload--has { border-style: solid; border-color: #a5b4fc; background: #f5f3ff; }
.pp-upload__icon { font-size: 1.5rem; color: #c7d2fe; }
.pp-upload__text { font-size: .78rem; color: #9ca3af; }
.pp-upload__preview { max-height: 100px; border-radius: 8px; object-fit: cover; }
.pp-upload__remove {
  position: absolute; top: .5rem; right: .5rem;
  background: #fef2f2; color: #ef4444; border: 1px solid #fecaca;
  border-radius: 6px; padding: .25rem .6rem; font-size: .72rem; cursor: pointer;
  display: flex; align-items: center; gap: .25rem; font-weight: 600;
}

/* ── Buttons ── */
.pp-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
  font-weight: 700; text-decoration: none; padding: .85rem 1.75rem;
  border-radius: 12px; border: none; cursor: pointer; font-size: .95rem;
  transition: transform .15s, box-shadow .15s;
}
.pp-btn:hover { transform: translateY(-2px); }
.pp-btn--primary { background: linear-gradient(135deg,#4f46e5,#7c3aed); color: #fff; box-shadow: 0 4px 16px rgba(79,70,229,.3); }
.pp-btn--primary:hover { box-shadow: 0 8px 24px rgba(79,70,229,.4); }
.pp-btn--full { width: 100%; margin-top: 1.5rem; }
.pp-btn--confirm {
  background: linear-gradient(135deg,#059669,#10b981); color: #fff;
  box-shadow: 0 4px 16px rgba(16,185,129,.25);
  padding: .9rem 2rem; white-space: nowrap;
}
.pp-btn--confirm:hover { box-shadow: 0 8px 24px rgba(16,185,129,.4); }
.pp-btn--confirm:disabled { opacity: .6; cursor: not-allowed; transform: none; box-shadow: none; }

/* ── Summary ── */
.pp-summary {
  background: #fff; border-radius: 20px; border: 1px solid #e5e7eb;
  box-shadow: 0 2px 20px rgba(0,0,0,.06); padding: 1.75rem;
  position: sticky; top: 80px;
}
.pp-summary__title { font-size: 1rem; font-weight: 800; color: #111827; margin-bottom: 1.25rem; }
.pp-summary__product { display: flex; gap: 1rem; margin-bottom: 1.25rem; align-items: flex-start; }
.pp-summary__thumb {
  width: 64px; height: 64px; border-radius: 12px; overflow: hidden;
  flex-shrink: 0; display: flex; align-items: center; justify-content: center;
  color: rgba(255,255,255,.5); font-size: 1.5rem;
}
.pp-summary__thumb img { width: 100%; height: 100%; object-fit: cover; }
.pp-summary__info { flex: 1; min-width: 0; }
.pp-summary__name { font-size: .9rem; font-weight: 700; color: #111827; margin: 0 0 .25rem; line-height: 1.35; }
.pp-summary__cat  { font-size: .75rem; color: #9ca3af; margin: 0 0 .35rem; }
.pp-summary__status {
  display: inline-block; font-size: .65rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .5px;
  padding: .15rem .6rem; border-radius: 50px;
}
.status--active      { background: #ecfdf5; color: #065f46; }
.status--development { background: #ede9fe; color: #4c1d95; }
.status--planning    { background: #fffbeb; color: #78350f; }
.status--paused      { background: #f9fafb; color: #374151; }
.pp-summary__hr { height: 1px; background: #f3f4f6; margin: 1rem 0; }
.pp-summary__pricing { display: flex; flex-direction: column; gap: .5rem; }
.pp-summary__row { display: flex; justify-content: space-between; font-size: .87rem; color: #6b7280; }
.pp-summary__row--green { color: #059669; }
.pp-summary__row--total { font-size: 1.05rem; font-weight: 800; color: #111827; padding-top: .25rem; }

.pp-summary__method {
  display: flex; align-items: center; gap: .6rem;
  padding: .65rem .9rem; border-radius: 10px;
  background: #f9fafb; border: 1px solid #e5e7eb;
  font-size: .82rem; color: #374151; margin-bottom: .5rem;
}
.pp-summary__method-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

.pp-summary__features { margin-top: .25rem; }
.pp-summary__feat-head {
  font-size: .72rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: .6px; color: #9ca3af; margin-bottom: .75rem;
}
.pp-summary__features ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .45rem; }
.pp-summary__features li { display: flex; align-items: flex-start; gap: .5rem; font-size: .82rem; color: #4b5563; }
.pp-feat-tick {
  width: 16px; height: 16px; border-radius: 50%; background: #ecfdf5;
  color: #10b981; display: flex; align-items: center; justify-content: center;
  font-size: .55rem; flex-shrink: 0; margin-top: .1rem;
}
.pp-summary__more { color: #9ca3af !important; font-style: italic; }
.pp-trust-list { display: flex; flex-direction: column; gap: .6rem; }
.pp-trust-item { display: flex; align-items: center; gap: .65rem; font-size: .78rem; color: #6b7280; }
.pp-trust-item i { width: 16px; text-align: center; color: #4f46e5; font-size: .82rem; }

/* ── Success ── */
.pp-success-page {
  min-height: 100vh; display: flex; align-items: center; justify-content: center;
  background: linear-gradient(135deg,#f0f4ff,#fdf2f8); padding: 2rem;
}
.pp-success-card {
  background: #fff; border-radius: 28px; padding: 3.5rem 3rem;
  text-align: center; max-width: 520px; width: 100%;
  box-shadow: 0 12px 60px rgba(79,70,229,.12);
  border: 1px solid #e0e7ff; position: relative; overflow: hidden;
}
.pp-success-glow {
  position: absolute; top: -60px; left: 50%; transform: translateX(-50%);
  width: 300px; height: 200px;
  background: radial-gradient(ellipse,rgba(79,70,229,.08) 0%,transparent 70%);
  pointer-events: none;
}
.pp-success-icon { width: 72px; height: 72px; margin: 0 auto 1.75rem; animation: popIn .5s cubic-bezier(.34,1.56,.64,1); }
.pp-success-icon svg { width: 72px; height: 72px; }
@keyframes popIn { from { transform: scale(.4); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.pp-success-card h2 { font-size: 1.9rem; font-weight: 900; color: #111827; margin-bottom: .75rem; }
.pp-success-card p  { font-size: .95rem; color: #6b7280; line-height: 1.8; margin-bottom: 1.5rem; }
.pp-success-ref {
  display: inline-flex; flex-direction: column; align-items: center; gap: .2rem;
  background: #f5f3ff; border: 1.5px solid #e0e7ff; border-radius: 12px;
  padding: .75rem 2rem; margin-bottom: 1.25rem;
}
.pp-success-ref__label { font-size: .68rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: .8px; }
.pp-success-ref__code  { font-size: 1.2rem; font-weight: 900; color: #4f46e5; font-family: 'Courier New', monospace; letter-spacing: 1px; }
.pp-success-meta { display: flex; flex-direction: column; gap: .5rem; margin-bottom: .5rem; }
.pp-success-meta__item { display: flex; align-items: center; justify-content: center; gap: .5rem; font-size: .83rem; color: #6b7280; }
.pp-success-meta__item i { color: #4f46e5; }

/* ── Responsive ── */
@media (max-width: 1024px) {
  .pp-layout { grid-template-columns: 1fr; }
  .pp-summary { position: static; }
  .pp-summary-col { order: -1; }
}
@media (max-width: 640px) {
  .pp-topbar__steps { display: none; }
  .pp-card__head, .pp-card__foot { padding: 1.25rem 1.5rem; }
  .pp-fields, .pp-proof { padding: 1.25rem 1.5rem; }
  .pp-pay-block { margin: 0 1.25rem; }
  .pp-method-tabs { padding: 1rem 1.25rem; gap: .5rem; }
  .pp-method-tab { min-width: 0; padding: .55rem .75rem; font-size: .78rem; }
  .pp-pay-block__steps-grid { grid-template-columns: 1fr; }
  .pp-row { grid-template-columns: 1fr; }
  .pp-hero__inner { gap: 1rem; }
  .pp-success-card { padding: 2.5rem 1.5rem; }
  .pp-section-divider { margin: .5rem 0; }
}

/* ── Section divider (inside card) ── */
.pp-section-divider {
  display: flex; align-items: center; gap: .75rem;
  margin: .25rem 0;
}
.pp-section-divider::before,
.pp-section-divider::after {
  content: ''; flex: 1; height: 1px; background: #e5e7eb;
}
.pp-section-divider__label {
  display: flex; align-items: center; gap: .4rem;
  font-size: .75rem; font-weight: 700; color: #9ca3af;
  text-transform: uppercase; letter-spacing: .6px; white-space: nowrap;
}
.pp-section-divider__label i { color: #0d9488; font-size: .78rem; }
</style>
