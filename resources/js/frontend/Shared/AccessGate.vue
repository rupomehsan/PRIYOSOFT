<template>
  <div class="ag-wrap">
    <div class="ag-content" :class="{ 'ag-content--locked': !unlocked }">
      <slot />
    </div>

    <div v-if="!unlocked" class="ag-overlay">
      <form class="ag-box" @submit.prevent="submit">
        <div class="ag-icon"><i class="fas fa-lock"></i></div>
        <h3 class="ag-title">Restricted Access</h3>
        <p class="ag-sub">Enter the passcode to continue</p>
        <input
          ref="input"
          v-model="code"
          type="password"
          class="ag-input"
          :class="{ 'ag-input--error': error }"
          placeholder="Passcode"
          autocomplete="off"
          autocapitalize="off"
          autocorrect="off"
          spellcheck="false"
          @input="error = false"
        />
        <span v-if="error" class="ag-error">Incorrect passcode. Try again.</span>
        <button type="submit" class="ag-btn">
          <i class="fas fa-unlock"></i> Unlock
        </button>
      </form>
    </div>
  </div>
</template>

<script>
const VALID_CODES = ['sabbiR', 'billaL', 'ehsaN'];
const STORAGE_KEY = 'ps_access_gate_unlocked';

export default {
  name: 'AccessGate',
  data() {
    return {
      unlocked: false,
      code: '',
      error: false,
    };
  },
  methods: {
    submit() {
      if (VALID_CODES.includes(this.code.trim())) {
        this.unlocked = true;
        this.error = false;
        this.code = '';
        try {
          localStorage.setItem(STORAGE_KEY, JSON.stringify({
            unlocked: true,
            date: new Date().toISOString(),
          }));
        } catch { /* storage unavailable — access still granted for this session */ }
      } else {
        this.error = true;
        this.code = '';
        this.$nextTick(() => this.$refs.input?.focus());
      }
    },
  },
  mounted() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      const data = raw ? JSON.parse(raw) : null;
      if (data?.unlocked) this.unlocked = true;
    } catch { /* ignore malformed/blocked storage */ }

    if (!this.unlocked) {
      this.$nextTick(() => this.$refs.input?.focus());
    }
  },
};
</script>

<style scoped>
.ag-wrap {
  position: relative;
  min-height: 100vh;
}

.ag-content--locked {
  filter: blur(10px);
  pointer-events: none;
  user-select: none;
  height: 100vh;
  overflow: hidden;
}

.ag-overlay {
  position: fixed;
  inset: 0;
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(10, 10, 20, 0.55);
  padding: 1rem;
}

.ag-box {
  width: 100%;
  max-width: 340px;
  background: #14141f;
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 18px;
  padding: 2rem 1.75rem 1.75rem;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
  text-align: center;
}

.ag-icon {
  width: 52px;
  height: 52px;
  margin: 0 auto 1rem;
  border-radius: 14px;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  color: #fff;
}

.ag-title {
  font-size: 1.05rem;
  font-weight: 800;
  color: #e2e8f0;
  margin: 0 0 0.3rem;
}

.ag-sub {
  font-size: 0.8rem;
  color: #64748b;
  margin: 0 0 1.25rem;
}

.ag-input {
  width: 100%;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  color: #e2e8f0;
  font-size: 0.95rem;
  padding: 0.7rem 0.9rem;
  text-align: center;
  letter-spacing: 1px;
  outline: none;
  transition: border-color 0.2s, background 0.2s;
}
.ag-input:focus {
  border-color: #818cf8;
  background: rgba(255, 255, 255, 0.06);
}
.ag-input--error {
  border-color: #f43f5e;
}

.ag-error {
  display: block;
  font-size: 0.75rem;
  color: #f87171;
  margin-top: 0.5rem;
}

.ag-btn {
  width: 100%;
  margin-top: 1.1rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  color: #fff;
  font-size: 0.85rem;
  font-weight: 700;
  border: none;
  border-radius: 10px;
  padding: 0.65rem 1rem;
  cursor: pointer;
  transition: opacity 0.2s;
}
.ag-btn:hover {
  opacity: 0.9;
}
</style>
