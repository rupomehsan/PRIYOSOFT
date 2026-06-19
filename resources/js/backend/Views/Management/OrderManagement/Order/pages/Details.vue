<template>
  <div class="od-page">

    <!-- Loading -->
    <div v-if="loading" class="od-loading">
      <div class="od-spinner"></div>
    </div>

    <template v-else-if="item && item.id">

      <!-- ── Order Header ──────────────────────────────────────────────── -->
      <div class="od-header mb-4">
        <div class="od-header__top">
          <router-link :to="{ name: `All${setup.route_prefix}` }" class="od-back-btn">
            <i class="fa fa-chevron-left"></i> All Orders
          </router-link>
          <div class="od-header__actions">
            <router-link
              :to="{ name: `Edit${setup.route_prefix}`, params: { id: item.slug } }"
              class="od-btn od-btn--outline od-btn--sm"
            >
              <i class="fa fa-pencil"></i> Edit
            </router-link>
            <button class="od-btn od-btn--primary od-btn--sm" @click="printInvoice">
              <i class="fa fa-print"></i> Print Invoice
            </button>
          </div>
        </div>

        <div class="od-header__body">
          <div class="od-header__icon-wrap">
            <i class="fa fa-file-text-o"></i>
          </div>
          <div class="od-header__info">
            <div class="od-header__row">
              <h4 class="od-order-num">{{ item.order_number || '—' }}</h4>
              <span class="od-status-badge" :class="'od-s--' + item.order_status">
                <span class="od-status-dot"></span>{{ statusLabel(item.order_status) }}
              </span>
            </div>
            <div class="od-header__meta">
              <span><i class="fa fa-tag"></i> Ref: <strong>{{ item.ref_code || '—' }}</strong></span>
              <span class="od-meta-sep">·</span>
              <span><i class="fa fa-user"></i> {{ item.customer_name || '—' }}</span>
              <span class="od-meta-sep">·</span>
              <span><i class="fa fa-phone"></i> {{ item.customer_phone || '—' }}</span>
              <span class="od-meta-sep">·</span>
              <span><i class="fa fa-clock-o"></i> {{ fmtDate(item.ordered_at || item.created_at) }}</span>
            </div>
          </div>
          <div class="od-header__amount">
            <span class="od-header__amount-label">Total</span>
            <span class="od-header__amount-val">৳{{ fmt(item.total_amount) }}</span>
          </div>
        </div>
      </div>

      <!-- ── Main Grid ──────────────────────────────────────────────── -->
      <div class="od-grid">

        <!-- Left column -->
        <div class="od-col-main">

          <!-- Customer Info -->
          <div class="od-card">
            <div class="od-card__head">
              <i class="fa fa-user-circle od-card__icon od-card__icon--blue"></i>
              <span>Customer Information</span>
            </div>
            <div class="od-card__body">
              <div class="od-info-grid">
                <div class="od-info-item">
                  <span class="od-info-label"><i class="fa fa-user"></i> Name</span>
                  <span class="od-info-value">{{ item.customer_name || '—' }}</span>
                </div>
                <div class="od-info-item">
                  <span class="od-info-label"><i class="fa fa-phone"></i> Phone</span>
                  <span class="od-info-value">{{ item.customer_phone || '—' }}</span>
                </div>
                <div class="od-info-item">
                  <span class="od-info-label"><i class="fa fa-envelope"></i> Email</span>
                  <span class="od-info-value">{{ item.customer_email || '—' }}</span>
                </div>
                <div class="od-info-item">
                  <span class="od-info-label"><i class="fa fa-globe"></i> Domain</span>
                  <span class="od-info-value">{{ item.domain_name || '—' }}</span>
                </div>
                <div class="od-info-item">
                  <span class="od-info-label"><i class="fa fa-calendar"></i> Delivery Date</span>
                  <span class="od-info-value">{{ item.preferred_delivery_date || '—' }}</span>
                </div>
                <div class="od-info-item">
                  <span class="od-info-label"><i class="fa fa-clock-o"></i> Ordered At</span>
                  <span class="od-info-value">{{ fmtDate(item.ordered_at || item.created_at) }}</span>
                </div>
              </div>
              <template v-if="item.project_description">
                <div class="od-divider"></div>
                <div class="od-info-item od-info-item--full">
                  <span class="od-info-label"><i class="fa fa-align-left"></i> Project Description</span>
                  <p class="od-desc-text">{{ item.project_description }}</p>
                </div>
              </template>
              <template v-if="item.special_requirements">
                <div class="od-info-item od-info-item--full mt-2">
                  <span class="od-info-label"><i class="fa fa-comment"></i> Special Requirements</span>
                  <p class="od-desc-text">{{ item.special_requirements }}</p>
                </div>
              </template>
            </div>
          </div>

          <!-- Product Table -->
          <div class="od-card mt-4">
            <div class="od-card__head">
              <i class="fa fa-shopping-cart od-card__icon od-card__icon--violet"></i>
              <span>Order Items</span>
            </div>
            <div class="od-table-wrap">
              <table class="od-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Plan</th>
                    <th>Billing</th>
                    <th>Payment</th>
                    <th class="text-right">Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="od-table__num">1</td>
                    <td>
                      <div class="od-product-cell">
                        <div class="od-product-thumb">
                          <img
                            :src="productThumb"
                            :alt="item.product_name"
                            @error="$event.target.src='/default.png'"
                          />
                        </div>
                        <div>
                          <div class="od-product-name">{{ item.product_name || item.productId?.name || '—' }}</div>
                          <div v-if="item.productId?.status" class="od-product-sub">{{ item.productId.status }}</div>
                        </div>
                      </div>
                    </td>
                    <td>{{ item.plan_name || '—' }}</td>
                    <td>
                      <span class="od-billing-badge">{{ billingLabel(item.billing_cycle) }}</span>
                    </td>
                    <td>
                      <span class="od-pay-badge" :class="item.pay_now ? 'od-pay--now' : 'od-pay--later'">
                        {{ item.pay_now ? 'Paid Now' : 'Pay Later' }}
                      </span>
                    </td>
                    <td class="text-right od-amount">৳{{ fmt(item.total_amount) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Totals -->
            <div class="od-totals">
              <div class="od-total-row" v-if="+item.subtotal">
                <span>Subtotal</span>
                <span>৳{{ fmt(item.subtotal) }}</span>
              </div>
              <div class="od-total-row od-total-row--discount" v-if="+item.discount_amount">
                <span>Discount <span v-if="item.coupon_code" class="od-coupon">{{ item.coupon_code }}</span></span>
                <span>− ৳{{ fmt(item.discount_amount) }}</span>
              </div>
              <div class="od-total-row od-total-row--grand">
                <span>Total</span>
                <span>৳{{ fmt(item.total_amount) }}</span>
              </div>
            </div>
          </div>

          <!-- Admin Note -->
          <div class="od-card mt-4">
            <div class="od-card__head">
              <i class="fa fa-sticky-note od-card__icon od-card__icon--yellow"></i>
              <span>Admin Note</span>
            </div>
            <div class="od-card__body">
              <textarea
                v-model="adminNote"
                class="od-textarea"
                rows="3"
                placeholder="Add an internal note about this order..."
              ></textarea>
              <button class="od-btn od-btn--primary mt-2" @click="saveNote" :disabled="savingNote">
                <i class="fa fa-save"></i> {{ savingNote ? 'Saving…' : 'Save Note' }}
              </button>
            </div>
          </div>

          <!-- Inline Edit -->
          <div class="od-card mt-4">
            <div class="od-card__head od-card__head--toggle" @click="showEdit = !showEdit" style="cursor:pointer">
              <div class="d-flex align-items-center gap-2">
                <i class="fa fa-pencil od-card__icon od-card__icon--violet"></i>
                <span>Edit Order Details</span>
              </div>
              <i class="fa" :class="showEdit ? 'fa-chevron-up' : 'fa-chevron-down'" style="color:#9ca3af;font-size:.8rem"></i>
            </div>
            <div v-show="showEdit" class="od-card__body">
              <div class="od-edit-grid">
                <div class="od-edit-field">
                  <label class="od-label">Customer Name</label>
                  <input v-model="edit.customer_name" class="od-input" placeholder="Customer name" />
                </div>
                <div class="od-edit-field">
                  <label class="od-label">Phone</label>
                  <input v-model="edit.customer_phone" class="od-input" placeholder="Phone" />
                </div>
                <div class="od-edit-field">
                  <label class="od-label">Email</label>
                  <input v-model="edit.customer_email" type="email" class="od-input" placeholder="Email" />
                </div>
                <div class="od-edit-field">
                  <label class="od-label">Domain</label>
                  <input v-model="edit.domain_name" class="od-input" placeholder="domain.com" />
                </div>
                <div class="od-edit-field">
                  <label class="od-label">Preferred Delivery Date</label>
                  <input v-model="edit.preferred_delivery_date" type="date" class="od-input" />
                </div>
                <div class="od-edit-field">
                  <label class="od-label">Plan Name</label>
                  <input v-model="edit.plan_name" class="od-input" placeholder="Plan name" />
                </div>
                <div class="od-edit-field">
                  <label class="od-label">Total Amount</label>
                  <input v-model="edit.total_amount" type="number" step="0.01" class="od-input" placeholder="0.00" />
                </div>
                <div class="od-edit-field">
                  <label class="od-label">Discount Amount</label>
                  <input v-model="edit.discount_amount" type="number" step="0.01" class="od-input" placeholder="0.00" />
                </div>
                <div class="od-edit-field">
                  <label class="od-label">Payment Method</label>
                  <select v-model="edit.payment_method" class="od-select">
                    <option value="">— Select —</option>
                    <option value="bkash">bKash</option>
                    <option value="nagad">Nagad</option>
                    <option value="rocket">Rocket</option>
                    <option value="bank">Bank Transfer</option>
                    <option value="card">Card</option>
                    <option value="cod">Cash on Delivery</option>
                  </select>
                </div>
                <div class="od-edit-field">
                  <label class="od-label">Delivery Method</label>
                  <select v-model="edit.delivery_method" class="od-select">
                    <option value="">— Select —</option>
                    <option value="email">Email</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="manual_contact">Manual Contact</option>
                  </select>
                </div>
                <div class="od-edit-field od-edit-field--full">
                  <label class="od-label">Project Description</label>
                  <textarea v-model="edit.project_description" class="od-textarea" rows="3" placeholder="Project description..."></textarea>
                </div>
                <div class="od-edit-field od-edit-field--full">
                  <label class="od-label">Special Requirements</label>
                  <textarea v-model="edit.special_requirements" class="od-textarea" rows="2" placeholder="Special requirements..."></textarea>
                </div>

                <!-- Payment Proof section -->
                <div class="od-edit-field od-edit-field--full">
                  <div class="od-proof-section-label">
                    <i class="fa fa-credit-card"></i> Add Payment Proof
                    <span class="od-proof-section-hint">(optional — creates a new payment record)</span>
                  </div>
                </div>
                <div class="od-edit-field">
                  <label class="od-label">Transaction ID</label>
                  <input v-model="edit.txn_id" class="od-input" placeholder="e.g. 8N7A3K92BX" />
                </div>
                <div class="od-edit-field">
                  <label class="od-label">Sender Number</label>
                  <input v-model="edit.sender_number" class="od-input" placeholder="e.g. 01XXXXXXXXX" />
                </div>
                <div class="od-edit-field od-edit-field--full">
                  <label class="od-label">Payment Screenshot</label>
                  <div class="od-file-drop" @click="$refs.screenshotInput.click()">
                    <template v-if="editScreenshotFile">
                      <i class="fa fa-check-circle od-file-drop__icon od-file-drop__icon--ok"></i>
                      <span class="od-file-drop__name">{{ editScreenshotFile.name }}</span>
                      <button type="button" class="od-file-drop__clear" @click.stop="editScreenshotFile = null; $refs.screenshotInput.value = ''">
                        <i class="fa fa-times"></i>
                      </button>
                    </template>
                    <template v-else>
                      <i class="fa fa-cloud-upload od-file-drop__icon"></i>
                      <span>Click to select screenshot (JPG, PNG, PDF — max 5 MB)</span>
                    </template>
                  </div>
                  <input
                    ref="screenshotInput"
                    type="file"
                    accept="image/jpeg,image/png,image/webp,application/pdf"
                    class="od-file-hidden"
                    @change="onScreenshotChange"
                  />
                </div>
                <div class="od-edit-field od-edit-field--full">
                  <label class="od-label">Payment Note</label>
                  <textarea v-model="edit.payment_note" class="od-textarea" rows="2" placeholder="Optional note about this payment..."></textarea>
                </div>
              </div>
              <div class="od-edit-footer">
                <button class="od-btn od-btn--outline" @click="resetEdit">
                  <i class="fa fa-times"></i> Reset
                </button>
                <button class="od-btn od-btn--primary" @click="saveEdit" :disabled="savingEdit">
                  <i class="fa fa-save"></i> {{ savingEdit ? 'Saving…' : 'Save Changes' }}
                </button>
              </div>
            </div>
          </div>

        </div>

        <!-- Right sidebar -->
        <div class="od-col-side">

          <!-- Order Status -->
          <div class="od-card">
            <div class="od-card__head">
              <i class="fa fa-tasks od-card__icon od-card__icon--green"></i>
              <span>Order Status</span>
            </div>
            <div class="od-card__body">
              <div class="od-status-track">
                <div
                  v-for="s in statusSteps"
                  :key="s.value"
                  class="od-status-step"
                  :class="{
                    'od-status-step--done':    isStepDone(s.value),
                    'od-status-step--active':  item.order_status === s.value,
                    'od-status-step--danger':  s.danger && item.order_status === s.value,
                  }"
                >
                  <div class="od-status-step__dot"></div>
                  <div class="od-status-step__label">{{ s.label }}</div>
                </div>
              </div>
              <div class="od-divider"></div>
              <label class="od-label">Change Status</label>
              <select v-model="newStatus" class="od-select">
                <option v-for="s in statusOptions" :key="s.value" :value="s.value">{{ s.label }}</option>
              </select>
              <button class="od-btn od-btn--green od-btn--full mt-2" @click="updateStatus" :disabled="updatingStatus">
                <i class="fa fa-check-circle"></i> {{ updatingStatus ? 'Updating…' : 'Update Status' }}
              </button>
              <p v-if="statusMsg" class="od-status-msg" :class="statusMsgOk ? 'od-msg--ok' : 'od-msg--err'">
                {{ statusMsg }}
              </p>
            </div>
          </div>

          <!-- Payment Info -->
          <div class="od-card mt-4">
            <div class="od-card__head">
              <i class="fa fa-credit-card od-card__icon od-card__icon--teal"></i>
              <span>Payment</span>
            </div>
            <div class="od-card__body">
              <div class="od-kv">
                <span class="od-kv__k">Method</span>
                <span class="od-kv__v od-method-badge">{{ methodLabel(item.payment_method) }}</span>
              </div>
              <div class="od-kv">
                <span class="od-kv__k">Pay Now</span>
                <span class="od-kv__v">{{ item.pay_now ? 'Yes' : 'No' }}</span>
              </div>
              <div class="od-kv">
                <span class="od-kv__k">Delivery</span>
                <span class="od-kv__v">{{ deliveryLabel(item.delivery_method) }}</span>
              </div>
              <div v-if="item.payment_verified_at" class="od-kv">
                <span class="od-kv__k">Verified At</span>
                <span class="od-kv__v">{{ fmtDate(item.payment_verified_at) }}</span>
              </div>

              <!-- Payment Proof Records -->
              <template v-if="payments.length">
                <div class="od-divider"></div>
                <p class="od-proof-title">
                  <i class="fa fa-paperclip"></i> Payment Proof ({{ payments.length }})
                </p>
                <div
                  v-for="(pmt, idx) in payments"
                  :key="pmt.id || idx"
                  class="od-proof-card"
                >
                  <div class="od-proof-top">
                    <span class="od-proof-badge" :class="'od-pmt--' + pmt.status">
                      {{ paymentStatusLabel(pmt.status) }}
                    </span>
                    <span class="od-proof-date">{{ fmtDate(pmt.submitted_at || pmt.created_at) }}</span>
                  </div>
                  <div class="od-proof-row">
                    <span class="od-proof-label">Transaction ID</span>
                    <span class="od-proof-val od-txn-id">{{ pmt.transaction_id || '—' }}</span>
                  </div>
                  <div class="od-proof-row">
                    <span class="od-proof-label">Amount</span>
                    <span class="od-proof-val">৳{{ fmt(pmt.amount || item.total_amount) }}</span>
                  </div>
                  <div v-if="pmt.sender_number" class="od-proof-row">
                    <span class="od-proof-label">Sender No.</span>
                    <span class="od-proof-val">{{ pmt.sender_number }}</span>
                  </div>
                  <div v-if="screenshotUrl(pmt.screenshot)" class="od-proof-screenshot-wrap">
                    <span class="od-proof-label">Screenshot</span>
                    <img
                      :src="screenshotUrl(pmt.screenshot)"
                      class="od-proof-screenshot"
                      alt="Payment Screenshot"
                      @click="lightboxImg = screenshotUrl(pmt.screenshot)"
                    />
                  </div>
                  <div v-if="pmt.note" class="od-proof-row od-proof-note">
                    <span class="od-proof-label">Note</span>
                    <span class="od-proof-val">{{ pmt.note }}</span>
                  </div>
                </div>
              </template>
              <div v-else class="od-proof-empty">
                <i class="fa fa-inbox"></i> No payment proof submitted yet.
              </div>
            </div>
          </div>

          <!-- Lightbox -->
          <div v-if="lightboxImg" class="od-lightbox" @click="lightboxImg = null">
            <div class="od-lightbox__inner" @click.stop>
              <button class="od-lightbox__close" @click="lightboxImg = null">
                <i class="fa fa-times"></i>
              </button>
              <img :src="lightboxImg" class="od-lightbox__img" alt="Payment Screenshot" />
              <a :href="lightboxImg" target="_blank" class="od-btn od-btn--outline od-lightbox__open mt-2">
                <i class="fa fa-external-link"></i> Open Full Size
              </a>
            </div>
          </div>

          <!-- Navigation -->
          <div class="od-card mt-4">
            <div class="od-card__body d-flex gap-2">
              <a v-if="item.prev_slug" href="#"
                @click.prevent="goTo(item.prev_slug)"
                class="od-btn od-btn--outline od-btn--half">
                <i class="fa fa-angle-left"></i> Prev
              </a>
              <a v-if="item.next_slug" href="#"
                @click.prevent="goTo(item.next_slug)"
                class="od-btn od-btn--outline od-btn--half">
                Next <i class="fa fa-angle-right"></i>
              </a>
            </div>
          </div>

        </div>
      </div>


    </template>

    <div v-else class="od-empty">
      <i class="fa fa-inbox"></i>
      <p>Order not found.</p>
      <router-link :to="{ name: `All${setup.route_prefix}` }" class="od-btn od-btn--outline">Back to Orders</router-link>
    </div>

  </div>
</template>

<script>
import { mapActions, mapWritableState } from 'pinia';
import { store } from '../store';
import setup from '../setup';

const STATUS_STEPS = [
  { value: 'pending_payment',   label: 'Pending Payment'   },
  { value: 'payment_submitted', label: 'Payment Submitted' },
  { value: 'payment_verified',  label: 'Payment Verified'  },
  { value: 'in_progress',       label: 'In Progress'       },
  { value: 'access_sent',       label: 'Access Sent'       },
  { value: 'completed',         label: 'Completed'         },
  { value: 'cancelled',         label: 'Cancelled', danger: true },
  { value: 'refunded',          label: 'Refunded',  danger: true },
];

const STEP_ORDER = STATUS_STEPS.filter(s => !s.danger).map(s => s.value);

export default {
  name: 'OrderDetails',
  data: () => ({
    setup,
    loading: true,
    newStatus: '',
    updatingStatus: false,
    statusMsg: '',
    statusMsgOk: true,
    adminNote: '',
    savingNote: false,
    payments: [],
    showEdit: false,
    savingEdit: false,
    lightboxImg: null,
    editScreenshotFile: null,
    edit: {
      customer_name: '', customer_phone: '', customer_email: '',
      domain_name: '', preferred_delivery_date: '', plan_name: '',
      total_amount: '', discount_amount: '',
      payment_method: '', delivery_method: '',
      project_description: '', special_requirements: '',
      txn_id: '', sender_number: '', payment_note: '',
    },
  }),

  computed: {
    ...mapWritableState(store, { item: 'item' }),
    statusSteps: () => STATUS_STEPS,
    statusOptions: () => STATUS_STEPS.map(s => ({ label: s.label, value: s.value })),

    productThumb() {
      const t = this.item?.productId?.thumbnail;
      if (t && t !== 'default.png') return t.startsWith('http') ? t : '/' + t;
      return '/default.png';
    },
  },

  methods: {
    ...mapActions(store, { details: 'details' }),

    async load(slug) {
      this.loading = true;
      this.item = {};
      this.payments = [];
      await this.details(slug);
      this.newStatus  = this.item?.order_status || '';
      this.adminNote  = this.item?.admin_note   || '';
      this.resetEdit();
      await this.loadPayments(slug);
      this.loading    = false;
    },

    async loadPayments(slug) {
      try {
        const res = await window.axios.get(`orders/${slug}/payments`);
        this.payments = res?.data?.data || res?.data || [];
      } catch {
        this.payments = [];
      }
    },

    screenshotUrl(path) {
      if (!path) return null;
      if (path.startsWith('http') || path.startsWith('/')) return path;
      return '/' + path;
    },

    paymentStatusLabel(s) {
      return { pending: 'Pending', submitted: 'Submitted', verified: 'Verified', rejected: 'Rejected' }[s] || s || '—';
    },

    resetEdit() {
      const orderFields = [
        'customer_name','customer_phone','customer_email','domain_name',
        'preferred_delivery_date','plan_name','total_amount','discount_amount',
        'payment_method','delivery_method','project_description','special_requirements',
      ];
      orderFields.forEach(k => { this.edit[k] = this.item?.[k] ?? ''; });
      this.edit.txn_id         = '';
      this.edit.sender_number  = '';
      this.edit.payment_note   = '';
      this.editScreenshotFile  = null;
    },

    onScreenshotChange(e) {
      this.editScreenshotFile = e.target.files[0] || null;
    },

    async saveEdit() {
      this.savingEdit = true;
      try {
        // 1 — Update order fields
        const fd = new FormData();
        const orderFields = [
          'customer_name','customer_phone','customer_email','domain_name',
          'preferred_delivery_date','plan_name','total_amount','discount_amount',
          'payment_method','delivery_method','project_description','special_requirements',
        ];
        orderFields.forEach(k => fd.append(k, this.edit[k] ?? ''));
        await window.axios.post(`orders/update/${this.item.slug}`, fd, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });
        orderFields.forEach(k => { this.item[k] = this.edit[k]; });

        // 2 — Add payment proof if txn_id or screenshot is provided
        if (this.edit.txn_id || this.editScreenshotFile) {
          const pfd = new FormData();
          pfd.append('transaction_id', this.edit.txn_id       || '');
          pfd.append('sender_number',  this.edit.sender_number || '');
          pfd.append('note',           this.edit.payment_note  || '');
          pfd.append('payment_method', this.edit.payment_method || this.item.payment_method || '');
          pfd.append('amount',         this.edit.total_amount  || this.item.total_amount || '');
          if (this.editScreenshotFile) pfd.append('screenshot', this.editScreenshotFile);
          await window.axios.post(`orders/${this.item.slug}/add-payment`, pfd, {
            headers: { 'Content-Type': 'multipart/form-data' },
          });
          await this.loadPayments(this.item.slug);
        }

        window.s_alert('Order updated successfully.');
        this.showEdit = false;
      } catch (err) {
        const msg = err?.response?.data?.message || 'Failed to save changes.';
        window.s_alert(msg);
      } finally {
        this.savingEdit = false;
      }
    },

    async goTo(slug) {
      this.$router.push({ name: `Details${setup.route_prefix}`, params: { id: slug } });
    },

    isStepDone(val) {
      const cur = STEP_ORDER.indexOf(this.item?.order_status);
      const idx = STEP_ORDER.indexOf(val);
      return idx !== -1 && cur !== -1 && idx < cur;
    },

    async updateStatus() {
      if (!this.newStatus) return;
      this.updatingStatus = true;
      this.statusMsg = '';
      try {
        await window.axios.post(`orders/${this.item.slug}/update-order-status`, {
          order_status: this.newStatus,
        });
        this.item.order_status = this.newStatus;
        this.statusMsg   = 'Status updated successfully.';
        this.statusMsgOk = true;
      } catch {
        this.statusMsg   = 'Failed to update status.';
        this.statusMsgOk = false;
      } finally {
        this.updatingStatus = false;
        setTimeout(() => { this.statusMsg = ''; }, 3000);
      }
    },

    async saveNote() {
      this.savingNote = true;
      try {
        await window.axios.post(`orders/${this.item.slug}/add-note`, {
          admin_note: this.adminNote,
        });
        this.item.admin_note = this.adminNote;
        window.s_alert('Note saved.');
      } catch {
        window.s_alert('Failed to save note.');
      } finally {
        this.savingNote = false;
      }
    },

    printInvoice() {
      const i   = this.item;
      const fmt = n => n ? new Intl.NumberFormat('en-BD').format(n) : '0';
      const pmt = this.payments.find(p => p.status === 'verified') || this.payments[0] || null;

      const rows = (() => {
        let r = `<tr>
          <td style="padding:12px 10px;border-bottom:1px solid #e5e7eb;">1</td>
          <td style="padding:12px 10px;border-bottom:1px solid #e5e7eb;font-weight:600;">${i.product_name || '—'}</td>
          <td style="padding:12px 10px;border-bottom:1px solid #e5e7eb;color:#6b7280;">${i.plan_name || this.billingLabel(i.billing_cycle) || '—'}</td>
          <td style="padding:12px 10px;border-bottom:1px solid #e5e7eb;text-align:right;font-weight:600;">৳${fmt(i.subtotal || i.total_amount)}</td>
        </tr>`;
        if (+i.discount_amount) {
          r += `<tr>
            <td colspan="3" style="padding:10px;text-align:right;color:#6b7280;font-size:12px;">Discount${i.coupon_code ? ` (${i.coupon_code})` : ''}</td>
            <td style="padding:10px;text-align:right;color:#059669;font-weight:600;">− ৳${fmt(i.discount_amount)}</td>
          </tr>`;
        }
        return r;
      })();

      const txnBlock = pmt ? `
        <div style="margin-top:24px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;">
          <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin:0 0 8px;">Payment Proof</p>
          <table style="width:100%;font-size:12px;border-collapse:collapse;">
            <tr>
              <td style="color:#64748b;padding:3px 0;width:130px;">Transaction ID</td>
              <td style="font-weight:700;font-family:monospace;color:#1e40af;">${pmt.transaction_id || '—'}</td>
            </tr>
            ${pmt.sender_number ? `<tr><td style="color:#64748b;padding:3px 0;">Sender Number</td><td style="font-weight:600;">${pmt.sender_number}</td></tr>` : ''}
            ${pmt.amount       ? `<tr><td style="color:#64748b;padding:3px 0;">Amount Paid</td><td style="font-weight:600;">৳${fmt(pmt.amount)}</td></tr>` : ''}
            <tr>
              <td style="color:#64748b;padding:3px 0;">Status</td>
              <td><span style="background:${pmt.status==='verified'?'#d1fae5':pmt.status==='rejected'?'#fee2e2':'#dbeafe'};color:${pmt.status==='verified'?'#065f46':pmt.status==='rejected'?'#991b1b':'#1e40af'};padding:2px 8px;border-radius:50px;font-size:10px;font-weight:700;">${this.paymentStatusLabel(pmt.status)}</span></td>
            </tr>
          </table>
        </div>` : '';

      const html = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Invoice — ${i.order_number}</title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    @page{size:A4;margin:20mm 15mm}
    body{font-family:'Segoe UI',Arial,sans-serif;color:#1e293b;font-size:13px;background:#fff;padding:40px}
    .inv-wrap{max-width:780px;margin:0 auto}

    /* header */
    .inv-head{display:flex;justify-content:space-between;align-items:flex-start;padding-bottom:24px;border-bottom:3px solid #4f46e5;margin-bottom:28px}
    .inv-brand{font-size:26px;font-weight:900;color:#4f46e5;letter-spacing:-1px}
    .inv-brand-sub{font-size:11px;color:#94a3b8;margin-top:2px}
    .inv-title-wrap{text-align:right}
    .inv-title{font-size:28px;font-weight:900;letter-spacing:3px;color:#0f172a}
    .inv-meta{font-size:11px;color:#64748b;margin-top:6px;line-height:1.7}
    .inv-meta strong{color:#1e293b}

    /* status bar */
    .inv-statusbar{display:flex;gap:0;margin-bottom:28px;border-radius:10px;overflow:hidden;border:1px solid #e2e8f0}
    .inv-statitem{flex:1;padding:10px 14px;background:#f8fafc}
    .inv-statitem+.inv-statitem{border-left:1px solid #e2e8f0}
    .inv-statitem__label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:3px}
    .inv-statitem__val{font-size:12px;font-weight:700;color:#0f172a}
    .badge{display:inline-block;padding:2px 10px;border-radius:50px;font-size:10px;font-weight:800;letter-spacing:.4px}
    .badge-green{background:#d1fae5;color:#065f46}
    .badge-blue{background:#dbeafe;color:#1e40af}
    .badge-yellow{background:#fef3c7;color:#92400e}
    .badge-red{background:#fee2e2;color:#991b1b}
    .badge-purple{background:#ede9fe;color:#4c1d95}
    .badge-gray{background:#f1f5f9;color:#475569}

    /* parties */
    .inv-parties{display:flex;gap:32px;margin-bottom:28px}
    .inv-party{flex:1}
    .inv-party__label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#94a3b8;margin-bottom:8px;padding-bottom:4px;border-bottom:1px solid #e2e8f0}
    .inv-party p{font-size:12px;color:#334155;line-height:1.7}
    .inv-party strong{color:#0f172a;font-size:13px}

    /* table */
    table.inv-table{width:100%;border-collapse:collapse;margin-bottom:0;font-size:12.5px}
    table.inv-table thead th{padding:11px 10px;background:#f8fafc;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;border-bottom:2px solid #e2e8f0;border-top:1px solid #e2e8f0}
    table.inv-table tbody td{padding:12px 10px;border-bottom:1px solid #f1f5f9;color:#1e293b}
    table.inv-table tfoot td{padding:10px;color:#475569}
    .grand-row td{border-top:2px solid #0f172a!important;padding-top:14px!important;font-size:14px;font-weight:800;color:#0f172a!important}
    .tr{text-align:right}

    /* footer */
    .inv-footer{margin-top:36px;padding-top:16px;border-top:1px solid #e2e8f0;text-align:center;font-size:11px;color:#94a3b8;line-height:1.8}
    .inv-footer strong{color:#4f46e5}
    .inv-watermark{margin-top:8px;font-size:10px;color:#cbd5e1}

    @media print{body{padding:0}.inv-wrap{padding:0}}
  </style>
</head>
<body>
<div class="inv-wrap">

  <!-- Header -->
  <div class="inv-head">
    <div>
      <div class="inv-brand">PriyoSoft</div>
      <div class="inv-brand-sub">Software Solutions &amp; Digital Services</div>
    </div>
    <div class="inv-title-wrap">
      <div class="inv-title">INVOICE</div>
      <div class="inv-meta">
        Order No: <strong>${i.order_number || '—'}</strong><br/>
        Ref Code: <strong>${i.ref_code || '—'}</strong><br/>
        Date: <strong>${this.fmtDate(i.ordered_at || i.created_at)}</strong>
      </div>
    </div>
  </div>

  <!-- Status Bar -->
  <div class="inv-statusbar">
    <div class="inv-statitem">
      <div class="inv-statitem__label">Order Status</div>
      <div class="inv-statitem__val">
        <span class="badge ${i.order_status==='completed'?'badge-green':i.order_status==='cancelled'?'badge-red':i.order_status==='in_progress'||i.order_status==='access_sent'?'badge-purple':i.order_status==='payment_verified'?'badge-green':i.order_status==='payment_submitted'?'badge-blue':'badge-yellow'}">
          ${this.statusLabel(i.order_status)}
        </span>
      </div>
    </div>
    <div class="inv-statitem">
      <div class="inv-statitem__label">Payment Method</div>
      <div class="inv-statitem__val">${this.methodLabel(i.payment_method)}</div>
    </div>
    <div class="inv-statitem">
      <div class="inv-statitem__label">Delivery Method</div>
      <div class="inv-statitem__val">${this.deliveryLabel(i.delivery_method)}</div>
    </div>
    ${i.preferred_delivery_date ? `<div class="inv-statitem">
      <div class="inv-statitem__label">Expected Delivery</div>
      <div class="inv-statitem__val">${i.preferred_delivery_date}</div>
    </div>` : ''}
  </div>

  <!-- Parties -->
  <div class="inv-parties">
    <div class="inv-party">
      <div class="inv-party__label">Bill To</div>
      <p><strong>${i.customer_name || '—'}</strong></p>
      ${i.customer_phone ? `<p>📞 ${i.customer_phone}</p>` : ''}
      ${i.customer_email ? `<p>✉ ${i.customer_email}</p>` : ''}
      ${i.domain_name    ? `<p>🌐 ${i.domain_name}</p>`   : ''}
    </div>
    <div class="inv-party">
      <div class="inv-party__label">From</div>
      <p><strong>PriyoSoft</strong></p>
      <p>📞 01931374336</p>
      <p>🌐 priyosoft.com</p>
      <p>📧 support@priyosoft.com</p>
    </div>
  </div>

  <!-- Items Table -->
  <table class="inv-table">
    <thead>
      <tr>
        <th style="width:36px">#</th>
        <th>Product / Description</th>
        <th>Plan</th>
        <th class="tr">Amount</th>
      </tr>
    </thead>
    <tbody>${rows}</tbody>
    <tfoot>
      <tr class="grand-row">
        <td colspan="3" class="tr">Grand Total</td>
        <td class="tr">৳${fmt(i.total_amount)}</td>
      </tr>
    </tfoot>
  </table>

  ${txnBlock}

  ${i.project_description ? `
  <div style="margin-top:20px;padding:12px 14px;background:#f8fafc;border-left:3px solid #4f46e5;border-radius:0 6px 6px 0;">
    <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:6px;">Project Description</p>
    <p style="font-size:12px;color:#334155;line-height:1.7;">${i.project_description}</p>
  </div>` : ''}

  <!-- Footer -->
  <div class="inv-footer">
    Thank you for choosing <strong>PriyoSoft</strong>. For queries contact us via WhatsApp at <strong>+8801931374336</strong>.<br/>
    All services are subject to our standard terms and conditions.
    <div class="inv-watermark">Generated by PriyoSoft Admin Panel</div>
  </div>

</div>
</body>
</html>`;

      const blob = new Blob([html], { type: 'text/html;charset=utf-8' });
      const url  = URL.createObjectURL(blob);
      const win  = window.open(url, '_blank');
      setTimeout(() => { win.print(); URL.revokeObjectURL(url); }, 700);
    },

    fmt: n => n ? new Intl.NumberFormat('en-BD').format(n) : '0',
    fmtDate(d) {
      if (!d) return '—';
      return new Date(d).toLocaleString('en-BD', { dateStyle: 'medium', timeStyle: 'short' });
    },
    statusLabel(s) {
      return STATUS_STEPS.find(x => x.value === s)?.label || s || '—';
    },
    billingLabel(b) {
      return { one_time: 'One Time', monthly: 'Monthly', yearly: 'Yearly' }[b] || b || '—';
    },
    methodLabel(m) {
      return { bkash: 'bKash', nagad: 'Nagad', rocket: 'Rocket', bank: 'Bank Transfer', card: 'Card', cod: 'Cash on Delivery' }[m] || m || '—';
    },
    deliveryLabel(d) {
      return { email: 'Email', whatsapp: 'WhatsApp', manual_contact: 'Manual Contact' }[d] || d || '—';
    },
  },

  async created() {
    await this.load(this.$route.params.id);
  },

  watch: {
    '$route.params.id'(slug) { if (slug) this.load(slug); },
  },
};
</script>

<style scoped>
/* ── Base ── */
.od-page { padding: 1.5rem; min-height: 100vh; background: var(--bg-main); }
.od-loading { display: flex; align-items: center; justify-content: center; min-height: 300px; }
.od-spinner {
  width: 44px; height: 44px; border-radius: 50%;
  border: 4px solid var(--border-color); border-top-color: var(--primary-color);
  animation: spin .7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
.od-empty { text-align: center; padding: 4rem; color: var(--text-tertiary); }
.od-empty i { font-size: 3rem; margin-bottom: 1rem; display: block; }

/* ── Header card ── */
.od-header {
  background: var(--bg-card);
  border: 1px solid var(--border-color);
  border-radius: 16px;
  box-shadow: var(--shadow-sm);
  overflow: hidden;
}
.od-header__top {
  display: flex; align-items: center; justify-content: space-between;
  padding: .75rem 1.5rem;
  border-bottom: 1px solid var(--border-light);
  background: var(--bg-hover);
}
.od-back-btn {
  display: inline-flex; align-items: center; gap: .45rem;
  font-size: .8rem; font-weight: 600; color: var(--text-tertiary);
  text-decoration: none; transition: color .15s;
}
.od-back-btn:hover { color: var(--primary-color); }
.od-back-btn .fa { font-size: .7rem; }
.od-header__actions { display: flex; gap: .6rem; }

.od-header__body {
  display: flex; align-items: center; gap: 1.25rem;
  padding: 1.25rem 1.5rem; flex-wrap: wrap;
}
.od-header__icon-wrap {
  width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
  background: linear-gradient(135deg, var(--primary-color), #7c3aed);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 1.25rem;
  box-shadow: 0 4px 12px rgba(59,130,246,.3);
}
.od-header__info { flex: 1; min-width: 0; }
.od-header__row { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; margin-bottom: .35rem; }
.od-order-num { font-size: 1.15rem; font-weight: 800; color: var(--text-primary); margin: 0; }
.od-header__meta {
  display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;
  font-size: .78rem; color: var(--text-tertiary);
}
.od-header__meta .fa { font-size: .72rem; color: var(--text-light); }
.od-header__meta strong { color: var(--text-secondary); }
.od-meta-sep { color: var(--border-dark); }
.od-header__amount { text-align: right; flex-shrink: 0; }
.od-header__amount-label { display: block; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: var(--text-light); margin-bottom: .15rem; }
.od-header__amount-val { font-size: 1.5rem; font-weight: 900; color: var(--primary-color); }

/* Status badges */
.od-status-badge {
  display: inline-flex; align-items: center; gap: .35rem;
  font-size: .68rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .6px;
  padding: .3rem .85rem; border-radius: 50px; white-space: nowrap;
}
.od-status-dot {
  width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0;
  background: currentColor; opacity: .8;
}
.od-s--pending_payment   { background:#fef3c7; color:#92400e; }
.od-s--payment_submitted { background:#dbeafe; color:#1e40af; }
.od-s--payment_verified  { background:#d1fae5; color:#065f46; }
.od-s--in_progress       { background:#ede9fe; color:#4c1d95; }
.od-s--access_sent       { background:#cffafe; color:#164e63; }
.od-s--completed         { background:#d1fae5; color:#065f46; }
.od-s--cancelled         { background:#fee2e2; color:#991b1b; }
.od-s--refunded          { background:#334155; color:#cbd5e1; }

/* ── Grid ── */
.od-grid { display: grid; grid-template-columns: 1fr 300px; gap: 1.5rem; align-items: start; }
@media(max-width:1024px) { .od-grid { grid-template-columns: 1fr; } }

/* ── Card ── */
.od-card {
  background: var(--bg-card); border-radius: 14px;
  border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);
  overflow: hidden;
}
.od-card__head {
  display: flex; align-items: center; gap: .6rem;
  padding: .9rem 1.25rem; border-bottom: 1px solid var(--border-light);
  font-size: .88rem; font-weight: 700; color: var(--text-secondary);
  background: var(--bg-hover);
}
.od-card__icon { font-size: 1rem; }
.od-card__icon--blue   { color: #3b82f6; }
.od-card__icon--violet { color: #7c3aed; }
.od-card__icon--green  { color: #10b981; }
.od-card__icon--teal   { color: #0d9488; }
.od-card__icon--yellow { color: #f59e0b; }
.od-card__body { padding: 1.25rem; }
.od-divider { height: 1px; background: var(--border-light); margin: 1rem 0; }

/* Info grid */
.od-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem 1.5rem; }
.od-info-item { display: flex; flex-direction: column; gap: .2rem; }
.od-info-item--full { grid-column: 1 / -1; }
.od-info-label {
  font-size: .72rem; font-weight: 600; text-transform: uppercase;
  letter-spacing: .5px; color: var(--text-light); display: flex; align-items: center; gap: .35rem;
}
.od-info-value { font-size: .9rem; font-weight: 600; color: var(--text-primary); }
.od-desc-text { font-size: .85rem; color: var(--text-secondary); line-height: 1.65; margin: .25rem 0 0; }

/* ── Product Table ── */
.od-table-wrap { overflow-x: auto; }
.od-table { width: 100%; border-collapse: collapse; }
.od-table th {
  padding: .75rem 1rem; font-size: .72rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .5px;
  color: var(--text-tertiary); border-bottom: 2px solid var(--border-color);
  white-space: nowrap; background: var(--bg-hover);
}
.od-table td {
  padding: .85rem 1rem; border-bottom: 1px solid var(--border-light);
  font-size: .875rem; color: var(--text-primary);
}
.od-table__num { color: var(--text-light); font-size: .8rem; width: 32px; }
.od-product-cell { display: flex; align-items: center; gap: .75rem; }
.od-product-thumb {
  width: 40px; height: 40px; border-radius: 10px; overflow: hidden;
  background: var(--bg-hover); border: 1px solid var(--border-color);
  display: flex; align-items: center; justify-content: center;
  color: var(--text-light); font-size: 1rem; flex-shrink: 0;
}
.od-product-thumb img { width: 100%; height: 100%; object-fit: cover; }
.od-product-name { font-weight: 700; color: var(--text-primary); font-size: .88rem; }
.od-product-sub  { font-size: .72rem; color: var(--text-light); text-transform: capitalize; }
.od-billing-badge {
  font-size: .7rem; font-weight: 700; background: #ede9fe; color: #6d28d9;
  padding: .2rem .65rem; border-radius: 50px;
}
.od-pay-badge { font-size: .7rem; font-weight: 700; padding: .2rem .65rem; border-radius: 50px; }
.od-pay--now  { background: #d1fae5; color: #065f46; }
.od-pay--later{ background: #fef3c7; color: #92400e; }
.od-amount { font-weight: 800; color: var(--text-primary); }
.text-right { text-align: right; }

/* Totals */
.od-totals { border-top: 1px solid var(--border-light); padding: .75rem 1rem; display: flex; flex-direction: column; align-items: flex-end; gap: .35rem; }
.od-total-row { display: flex; gap: 2rem; font-size: .875rem; color: var(--text-tertiary); justify-content: flex-end; min-width: 240px; }
.od-total-row span:last-child { font-weight: 600; color: var(--text-secondary); min-width: 80px; text-align: right; }
.od-total-row--discount span { color: var(--success-color); }
.od-total-row--grand { padding-top: .5rem; border-top: 2px solid var(--border-color); font-size: 1rem; }
.od-total-row--grand span { font-weight: 800; color: var(--text-primary); }
.od-coupon {
  font-size: .68rem; background: #fef3c7; color: #92400e;
  padding: .1rem .45rem; border-radius: 4px; margin-left: .4rem;
}

/* Textarea / Input */
.od-textarea, .od-input {
  width: 100%; border: 1.5px solid var(--border-color);
  border-radius: 10px; padding: .7rem 1rem;
  font-size: .875rem; color: var(--text-primary);
  background: var(--bg-input); outline: none;
  resize: vertical; font-family: inherit; line-height: 1.6;
  transition: border-color .2s;
}
.od-input { resize: none; }
.od-textarea:focus, .od-input:focus { border-color: var(--primary-color); }

/* ── Status tracker ── */
.od-status-track { display: flex; flex-direction: column; gap: .1rem; }
.od-status-step {
  display: flex; align-items: center; gap: .65rem;
  padding: .45rem 0; position: relative;
}
.od-status-step__dot {
  width: 16px; height: 16px; border-radius: 50%; flex-shrink: 0;
  border: 2px solid var(--border-color); background: var(--bg-card);
  transition: all .2s;
}
.od-status-step__label { font-size: .8rem; color: var(--text-light); }
.od-status-step--done .od-status-step__dot   { background: #10b981; border-color: #10b981; }
.od-status-step--done .od-status-step__label  { color: #10b981; }
.od-status-step--active .od-status-step__dot  { background: var(--primary-color); border-color: var(--primary-color); box-shadow: 0 0 0 4px rgba(59,130,246,.2); }
.od-status-step--active .od-status-step__label { color: var(--primary-color); font-weight: 700; }
.od-status-step--danger.od-status-step--active .od-status-step__dot  { background: var(--danger-color); border-color: var(--danger-color); box-shadow: 0 0 0 4px rgba(239,68,68,.2); }
.od-status-step--danger.od-status-step--active .od-status-step__label { color: var(--danger-color); }

/* Select / Label */
.od-label {
  font-size: .75rem; font-weight: 700; color: var(--text-tertiary);
  display: block; margin-bottom: .4rem; text-transform: uppercase; letter-spacing: .4px;
}
.od-select {
  width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--border-color);
  border-radius: 10px; font-size: .875rem; color: var(--text-primary);
  background: var(--bg-input); outline: none; transition: border-color .2s;
}
.od-select:focus { border-color: var(--primary-color); }

/* Status msg */
.od-status-msg { font-size: .78rem; margin-top: .5rem; }
.od-msg--ok  { color: var(--success-color); }
.od-msg--err { color: var(--danger-color); }

/* KV rows */
.od-kv { display: flex; justify-content: space-between; align-items: center; padding: .45rem 0; border-bottom: 1px solid var(--border-light); font-size: .83rem; }
.od-kv:last-child { border-bottom: none; }
.od-kv__k { color: var(--text-light); }
.od-kv__v { font-weight: 600; color: var(--text-primary); }
.od-method-badge { text-transform: capitalize; }

/* ── Buttons ── */
.od-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
  padding: .55rem 1.1rem; border-radius: 9px; font-size: .82rem; font-weight: 700;
  border: none; cursor: pointer; text-decoration: none; transition: all .15s;
  white-space: nowrap;
}
.od-btn:disabled { opacity: .6; cursor: not-allowed; }
.od-btn--primary { background: var(--primary-color); color: #fff; }
.od-btn--primary:hover { background: var(--primary-hover); }
.od-btn--green { background: var(--success-color); color: #fff; }
.od-btn--green:hover { filter: brightness(.9); }
.od-btn--outline { background: var(--bg-card); color: var(--text-secondary); border: 1.5px solid var(--border-color); }
.od-btn--outline:hover { border-color: var(--primary-color); color: var(--primary-color); }
.od-btn--sm { padding: .42rem .9rem; font-size: .78rem; }
.od-btn--full { width: 100%; }
.od-btn--half { flex: 1; }
.gap-2 { gap: .5rem; }

.mt-2 { margin-top: .5rem; }
.mt-4 { margin-top: 1rem; }

/* ── Card head toggle ── */
.od-card__head--toggle { justify-content: space-between; user-select: none; }
.od-card__head--toggle:hover { background: var(--bg-disabled); }

/* ── Inline edit grid ── */
.od-edit-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.od-edit-field { display: flex; flex-direction: column; gap: .35rem; }
.od-edit-field--full { grid-column: 1 / -1; }
.od-edit-footer {
  display: flex; justify-content: flex-end; gap: .75rem;
  margin-top: 1.25rem; padding-top: 1rem;
  border-top: 1px solid var(--border-light);
}
@media(max-width:640px) { .od-edit-grid { grid-template-columns: 1fr; } }

/* ── Payment Proof ── */
.od-proof-title {
  font-size: .75rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: .5px; color: var(--text-tertiary);
  margin: 0 0 .75rem; display: flex; align-items: center; gap: .4rem;
}
.od-proof-card {
  border: 1.5px solid var(--border-color); border-radius: 10px;
  padding: .85rem; margin-bottom: .75rem; background: var(--bg-hover);
}
.od-proof-card:last-child { margin-bottom: 0; }
.od-proof-top {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: .6rem;
}
.od-proof-date { font-size: .7rem; color: var(--text-light); }
.od-proof-badge {
  font-size: .65rem; font-weight: 800; text-transform: uppercase;
  letter-spacing: .5px; padding: .2rem .6rem; border-radius: 50px;
}
.od-pmt--pending   { background: #fef3c7; color: #92400e; }
.od-pmt--submitted { background: #dbeafe; color: #1e40af; }
.od-pmt--verified  { background: #d1fae5; color: #065f46; }
.od-pmt--rejected  { background: #fee2e2; color: #991b1b; }

.od-proof-row {
  display: flex; justify-content: space-between; align-items: flex-start;
  gap: .5rem; padding: .3rem 0; font-size: .8rem;
  border-bottom: 1px solid var(--border-light);
}
.od-proof-row:last-child { border-bottom: none; }
.od-proof-label { color: var(--text-light); white-space: nowrap; flex-shrink: 0; }
.od-proof-val { font-weight: 600; color: var(--text-primary); text-align: right; word-break: break-all; }
.od-txn-id { font-family: monospace; font-size: .78rem; color: var(--primary-color); }
.od-proof-note .od-proof-val { font-weight: 400; color: var(--text-secondary); }

.od-proof-screenshot-wrap { padding: .5rem 0; }
.od-proof-screenshot-wrap .od-proof-label { margin-bottom: .4rem; display: block; }
.od-proof-screenshot {
  width: 100%; border-radius: 8px; border: 1.5px solid var(--border-color);
  object-fit: cover; max-height: 160px; cursor: zoom-in;
  transition: opacity .15s;
}
.od-proof-screenshot:hover { opacity: .85; }

.od-proof-empty {
  font-size: .8rem; color: var(--text-light); text-align: center;
  padding: .75rem 0; display: flex; align-items: center; justify-content: center; gap: .45rem;
}

/* ── Payment proof section header in edit form ── */
.od-proof-section-label {
  display: flex; align-items: center; gap: .5rem;
  font-size: .78rem; font-weight: 700; color: var(--text-secondary);
  padding: .6rem .9rem; border-radius: 8px;
  background: var(--bg-hover); border: 1.5px dashed var(--border-color);
}
.od-proof-section-hint { font-weight: 400; color: var(--text-light); font-size: .72rem; }

/* ── File drop zone ── */
.od-file-drop {
  display: flex; align-items: center; gap: .6rem;
  padding: .75rem 1rem; border-radius: 10px;
  border: 1.5px dashed var(--border-color);
  background: var(--bg-hover); cursor: pointer; font-size: .82rem;
  color: var(--text-tertiary); transition: border-color .2s, background .2s;
  position: relative; min-height: 52px;
}
.od-file-drop:hover { border-color: var(--primary-color); background: var(--bg-input); }
.od-file-drop__icon { font-size: 1.1rem; color: var(--text-light); }
.od-file-drop__icon--ok { color: var(--success-color); }
.od-file-drop__name { flex: 1; font-weight: 600; color: var(--text-primary); font-size: .82rem; word-break: break-all; }
.od-file-drop__clear {
  background: none; border: none; cursor: pointer; padding: .2rem .4rem;
  color: var(--danger-color); font-size: .85rem; border-radius: 6px;
}
.od-file-drop__clear:hover { background: #fee2e2; }
.od-file-hidden { display: none; }

/* ── Lightbox ── */
.od-lightbox {
  position: fixed; inset: 0; z-index: 9999;
  background: rgba(0,0,0,.75); backdrop-filter: blur(4px);
  display: flex; align-items: center; justify-content: center;
}
.od-lightbox__inner {
  position: relative; max-width: 90vw; max-height: 90vh;
  display: flex; flex-direction: column; align-items: center; gap: .75rem;
}
.od-lightbox__close {
  position: absolute; top: -14px; right: -14px;
  width: 34px; height: 34px; border-radius: 50%;
  background: var(--bg-card); border: 1.5px solid var(--border-color);
  color: var(--text-primary); font-size: .9rem;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; z-index: 1;
}
.od-lightbox__img {
  max-width: 100%; max-height: 80vh;
  border-radius: 12px; border: 2px solid var(--border-color);
  box-shadow: 0 20px 60px rgba(0,0,0,.5);
}
.od-lightbox__open { font-size: .78rem; }
</style>
