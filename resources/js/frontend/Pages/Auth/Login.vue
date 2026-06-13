<template>
  <Head title="Login" />
  <div class="login-root">
    <video class="bg-video" autoplay muted loop playsinline>
      <source src="/frontend/encryption-bg.webm" type="video/webm" />
    </video>
    <div class="bg-overlay"></div>
    <div class="bg-glass" aria-hidden="true"></div>
    <canvas ref="rainCanvas" class="binary-canvas" aria-hidden="true"></canvas>

    <div class="login-wrapper">
      <div class="login-card">

        <!-- Brand -->
        <div class="brand-area">
          <div class="brand-icon">
            <img v-if="siteLogo" :src="siteLogo" class="brand-logo-img" alt="logo" />
            <svg v-else width="26" height="26" viewBox="0 0 24 24" fill="currentColor">
              <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
            </svg>
          </div>
          <div>
            <h1 class="brand-name">{{ siteName || 'BM Accounting' }}</h1>
            <p class="brand-tagline">Smart Software, Better Business</p>
          </div>
        </div>

        <!-- Form Intro -->
        <div class="form-intro">
          <h2 class="form-heading">Welcome Back</h2>
          <p class="form-subtext">Sign in to access your financial dashboard</p>
        </div>

        <!-- Form -->
        <form @submit.prevent="LoginSubmitHandler" class="auth-form">

          <!-- Email -->
          <div class="field-group">
            <label class="field-label">Email Address</label>
            <div class="input-wrap">
              <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
              </svg>
              <input v-model="email" type="email" name="email" class="auth-input" placeholder="Enter your email address" autocomplete="email" required />
            </div>
          </div>

          <!-- Password -->
          <div class="field-group">
            <label class="field-label">Password</label>
            <div class="input-wrap">
              <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
              </svg>
              <input
                :type="showPassword ? 'text' : 'password'"
                v-model="password"
                name="password"
                class="auth-input"
                placeholder="Enter your password"
                autocomplete="current-password"
                required
              />
              <button type="button" @click="showPassword = !showPassword" class="eye-toggle">
                <svg v-if="!showPassword" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                </svg>
                <svg v-else width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M11.83,9L15,12.16C15,12.11 15,12.05 15,12A3,3 0 0,0 12,9C11.94,9 11.89,9 11.83,9M7.53,9.8L9.08,11.35C9.03,11.56 9,11.77 9,12A3,3 0 0,0 12,15C12.22,15 12.44,14.97 12.65,14.92L14.2,16.47C13.53,16.8 12.79,17 12,17A5,5 0 0,1 7,12C7,11.21 7.2,10.47 7.53,9.8M2,4.27L4.28,6.55L4.73,7C3.08,8.3 1.78,10 1,12C2.73,16.39 7,19.5 12,19.5C13.55,19.5 15.03,19.2 16.38,18.66L16.81,19.09L19.73,22L21,20.73L3.27,3M12,7A5,5 0 0,1 17,12C17,12.64 16.87,13.26 16.64,13.82L19.57,16.75C21.07,15.5 22.27,13.86 23,12C21.27,7.61 17,4.5 12,4.5C10.6,4.5 9.26,4.75 8,5.2L10.17,7.35C10.76,7.13 11.38,7 12,7Z"/>
                </svg>
              </button>
            </div>
          </div>

          <!-- Options Row -->
          <div class="options-row">
            <label class="remember-wrap">
              <input type="checkbox" v-model="rememberMe" class="cb-hidden" />
              <span class="cb-box"></span>
              <span class="cb-label">Remember me</span>
            </label>
            <Link href="forgot-password" class="link-forgot">Forgot password?</Link>
          </div>

          <!-- Sign In Button -->
          <button type="submit" class="btn-signin" :disabled="loading">
            <span v-if="!loading" class="btn-content">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 17v-3H3v-4h7V7l5 5-5 5z"/>
                <path d="M19 3h-8c-1.1 0-2 .9-2 2v2h2V5h8v14h-8v-2H9v2c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
              </svg>
              Sign In to Dashboard
            </span>
            <span v-else class="btn-content">
              <span class="spin-ring"></span>
              Authenticating...
            </span>
          </button>
        </form>

      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { auth_store } from "../../GlobalStore/auth_store";
import { site_settings_store } from "../../GlobalStore/site_settings_store";

export default {
  data() {
    return {
      loading: false,
      checkingAuth: true,
      showPassword: false,
      email: "superadmin@gmail.com",
      password: "12345678",
      rememberMe: false,
      _rainId: null,
    };
  },

  async created() {
    this.checkingAuth = true;
    const token = localStorage.getItem("auth_token");
    const role = localStorage.getItem("auth_role");

    if (token && role) {
      try {
        await this.check_is_auth();
        if (this.is_auth) {
          window.location.href = "/admin#/dashboard";
        } else {
          this.clearAuthData();
        }
      } catch {
        this.clearAuthData();
      }
    }
    this.checkingAuth = false;
  },

  mounted() {
    this.loadRememberedCredentials();
    this.startBinaryRain();
    this.get_all_website_settings();
  },

  beforeUnmount() {
    if (this._rainId) cancelAnimationFrame(this._rainId);
  },

  computed: {
    ...mapState(auth_store, {
      is_auth: "is_auth",
    }),
    ...mapState(site_settings_store, {
      website_settings_data: "website_settings_data",
    }),
    siteName() {
      return this.get_setting_value("site_name");
    },
    siteLogo() {
      return this.get_setting_value("image");
    },
  },

  methods: {
    ...mapActions(auth_store, { check_is_auth: "check_is_auth" }),
    ...mapActions(site_settings_store, {
      get_all_website_settings: "get_all_website_settings",
      get_setting_value: "get_setting_value",
    }),

    startBinaryRain() {
      const canvas = this.$refs.rainCanvas;
      if (!canvas) return;
      const ctx = canvas.getContext("2d");
      const fontSize = 18;
      let frame = 0;
      let mouseX = canvas.width / 2;
      let mouseY = canvas.height / 2;

      const resize = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
      };
      resize();
      window.addEventListener("resize", resize);

      document.addEventListener("mousemove", (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
      });

      let rows = Math.ceil(canvas.height / fontSize);
      let cols = Math.ceil(canvas.width / fontSize);
      let binaryGrid = Array.from({ length: rows }, () =>
        Array.from({ length: cols }, () => (Math.random() > 0.5 ? "1" : "0"))
      );

      const draw = () => {
        frame++;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.font = `${fontSize}px "Courier New", monospace`;

        const hoverCol = Math.floor(mouseX / fontSize);
        const hoverRow = Math.floor(mouseY / fontSize);

        for (let row = 0; row < rows; row++) {
          for (let col = 0; col < cols; col++) {
            const bit = binaryGrid[row][col];
            const x = col * fontSize;
            const y = row * fontSize + fontSize;

            let opacity = 0.12 + 0.06 * Math.sin((row + col + frame * 0.02) * 0.1);
            if (row === hoverRow && col === hoverCol) opacity = 1;

            ctx.fillStyle = `rgba(0, 255, 210, ${opacity})`;
            ctx.fillText(bit, x, y);
          }
        }

        if (frame % 120 === 0) {
          const randRow = Math.floor(Math.random() * rows);
          const randCol = Math.floor(Math.random() * cols);
          binaryGrid[randRow][randCol] = Math.random() > 0.5 ? "1" : "0";
        }

        this._rainId = requestAnimationFrame(draw);
      };

      draw();
    },

    async LoginSubmitHandler() {
      try {
        this.loading = true;
        if (this.rememberMe) {
          this.saveCredentials();
        } else {
          this.clearSavedCredentials();
        }

        let formData = new FormData();
        formData.append("email", this.email);
        formData.append("password", this.password);
        formData.append("remember", this.rememberMe);

        let response = await axios.post("/login", formData);

        if (response.data?.status === "success") {
          let data = response.data?.data;
          if (data.access_token && data.user) {
            localStorage.setItem("auth_token", data.access_token);
            localStorage.setItem("auth_role", data.user.role_id);
            window.sessionStorage.removeItem("prevurl");
            window.s_alert("Login Successfully");
            if (data.user.role_id) {
              setTimeout(() => {
                window.location.href = "/admin#/dashboard";
              }, 100);
            }
          } else {
            window.s_alert("Login failed. Invalid response from server.", "error");
          }
        } else {
          window.s_alert(response.data?.message || "Login failed. Please try again.", "error");
        }
      } catch (error) {
        if (error.response?.data?.message) {
          window.s_alert(error.response.data.message, "error");
        } else if (error.response?.status === 401) {
          window.s_alert("Invalid credentials. Please check your email and password.", "error");
        } else {
          window.s_alert("Login failed. Please check your connection and try again.", "error");
        }
      } finally {
        this.loading = false;
      }
    },

    saveCredentials() {
      localStorage.setItem(
        "rememberedCredentials",
        JSON.stringify({ email: this.email, password: this.password, rememberMe: this.rememberMe })
      );
    },

    clearSavedCredentials() {
      localStorage.removeItem("rememberedCredentials");
    },

    clearAuthData() {
      localStorage.removeItem("auth_token");
      localStorage.removeItem("auth_role");
      window.sessionStorage.removeItem("prevurl");
    },

    loadRememberedCredentials() {
      const saved = localStorage.getItem("rememberedCredentials");
      if (saved) {
        try {
          const c = JSON.parse(saved);
          this.email = c.email || "";
          this.password = c.password || "";
          this.rememberMe = c.rememberMe || false;
        } catch {
          this.clearSavedCredentials();
        }
      }
    },
  },
};
</script>

<style scoped>
* { box-sizing: border-box; margin: 0; padding: 0; }

:global(body), :global(html) {
  overflow: hidden !important;
  height: 100%;
}

.login-root {
  position: fixed;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  font-family: 'Segoe UI', 'Inter', system-ui, -apple-system, sans-serif;
  background: #020408;
}

.bg-video {
  position: fixed;
  top: 50%; left: 50%;
  width: 100vw; height: 100vh;
  min-width: 100vw; min-height: 100vh;
  object-fit: cover; object-position: center center;
  transform: translate(-50%, -50%) scale(1.6);
  transform-origin: center center;
  z-index: 0; opacity: 1;
}

.bg-overlay {
  position: fixed; inset: 0;
  background: rgba(2, 4, 8, 0.08);
  z-index: 1;
}

.bg-glass {
  position: fixed; inset: 0;
  z-index: 2; pointer-events: none;
  backdrop-filter: blur(6px) saturate(140%);
  -webkit-backdrop-filter: blur(6px) saturate(140%);
  background: linear-gradient(135deg, rgba(2,8,14,0.25) 0%, rgba(0,255,210,0.03) 50%, rgba(2,8,14,0.3) 100%);
  border-top: 1px solid rgba(255,255,255,0.04);
  box-shadow: inset 0 0 120px rgba(0,0,0,0.35);
}

.binary-canvas {
  position: fixed; inset: 0;
  z-index: 3; pointer-events: none;
  width: 100%; height: 100%;
}

/* ── Card Wrapper ── */
.login-wrapper {
  position: relative;
  z-index: 10;
  width: calc(100% - 32px);
  max-width: 460px;
  animation: cardIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
}

@keyframes cardIn {
  from { opacity: 0; transform: translateY(28px) scale(0.97); }
  to   { opacity: 1; transform: translateY(0)    scale(1);    }
}

/* ── Main Card ── */
.login-card {
  background: rgba(8, 13, 24, 0.96);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 16px;
  box-shadow:
    0 0 0 1px rgba(0, 200, 180, 0.06),
    0 0 60px rgba(0, 200, 180, 0.08),
    0 32px 80px rgba(0, 0, 0, 0.85);
  backdrop-filter: blur(20px);
  overflow: hidden;
  padding: 36px 40px 32px;
  display: flex;
  flex-direction: column;
  gap: 0;
}

/* Brand */
.brand-area {
  display: flex;
  align-items: center;
  gap: 12px;
  padding-bottom: 28px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  margin-bottom: 28px;
}

.brand-icon {
  width: 46px; height: 46px;
  border-radius: 10px;
  background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
  display: flex; align-items: center; justify-content: center;
  color: #fff;
  flex-shrink: 0;
  box-shadow: 0 4px 16px rgba(14, 165, 233, 0.35);
  overflow: hidden;
}

.brand-logo-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.brand-name {
  font-size: 1.15rem;
  font-weight: 700;
  color: #f1f5f9;
  letter-spacing: -0.01em;
  line-height: 1.2;
}

.brand-tagline {
  font-size: 11.5px;
  color: rgba(148, 163, 184, 0.8);
  margin-top: 2px;
  letter-spacing: 0.01em;
}

/* Form Intro */
.form-intro {
  margin-bottom: 24px;
}

.form-heading {
  font-size: 1.45rem;
  font-weight: 700;
  color: #f1f5f9;
  letter-spacing: -0.02em;
  margin-bottom: 5px;
}

.form-subtext {
  font-size: 13px;
  color: rgba(148, 163, 184, 0.75);
}

/* Auth Form */
.auth-form {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.field-group {
  display: flex;
  flex-direction: column;
  gap: 7px;
}

.field-label {
  font-size: 12.5px;
  font-weight: 600;
  color: rgba(203, 213, 225, 0.85);
  letter-spacing: 0.01em;
}

.input-wrap {
  display: flex;
  align-items: center;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 9px;
  transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
  overflow: hidden;
}

.input-wrap:focus-within {
  border-color: rgba(14, 165, 233, 0.55);
  background: rgba(14, 165, 233, 0.04);
  box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
}

.input-icon {
  padding: 0 12px;
  color: rgba(148, 163, 184, 0.5);
  flex-shrink: 0;
}

.auth-input {
  flex: 1;
  background: transparent;
  border: none;
  outline: none;
  color: #e2e8f0;
  font-family: inherit;
  font-size: 14px;
  padding: 12px 12px 12px 0;
  caret-color: #0ea5e9;
}

.auth-input::placeholder {
  color: rgba(148, 163, 184, 0.35);
}

.eye-toggle {
  background: none;
  border: none;
  color: rgba(148, 163, 184, 0.45);
  cursor: pointer;
  padding: 0 13px;
  display: flex;
  align-items: center;
  transition: color 0.2s;
  flex-shrink: 0;
}
.eye-toggle:hover { color: #94a3b8; }

/* Options Row */
.options-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: -4px;
}

.remember-wrap {
  display: flex;
  align-items: center;
  gap: 7px;
  cursor: pointer;
  user-select: none;
}

.cb-hidden { display: none; }

.cb-box {
  width: 15px; height: 15px;
  border: 1.5px solid rgba(148, 163, 184, 0.35);
  border-radius: 4px;
  background: transparent;
  display: inline-flex; align-items: center; justify-content: center;
  position: relative;
  flex-shrink: 0;
  transition: border-color 0.2s, background 0.2s;
}

.cb-hidden:checked + .cb-box {
  background: #0ea5e9;
  border-color: #0ea5e9;
}
.cb-hidden:checked + .cb-box::after {
  content: '';
  position: absolute;
  left: 3px; top: 1px;
  width: 5px; height: 8px;
  border: solid #fff;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

.cb-label {
  font-size: 12.5px;
  color: rgba(148, 163, 184, 0.75);
}

.link-forgot {
  font-size: 12.5px;
  color: #0ea5e9;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s;
}
.link-forgot:hover { color: #38bdf8; }

/* Sign In Button */
.btn-signin {
  width: 100%;
  background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
  border: none;
  border-radius: 9px;
  color: #fff;
  font-family: inherit;
  font-size: 14px;
  font-weight: 600;
  letter-spacing: 0.01em;
  padding: 13px 24px;
  cursor: pointer;
  transition: all 0.25s ease;
  box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
  margin-top: 4px;
}

.btn-signin:hover:not(:disabled) {
  background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
  box-shadow: 0 6px 24px rgba(14, 165, 233, 0.45);
  transform: translateY(-1px);
}

.btn-signin:active:not(:disabled) {
  transform: translateY(0);
  box-shadow: 0 2px 10px rgba(14, 165, 233, 0.3);
}

.btn-signin:disabled {
  opacity: 0.65;
  cursor: not-allowed;
}

.btn-content {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

/* Spinner */
.spin-ring {
  width: 15px; height: 15px;
  border: 2px solid rgba(255,255,255,0.25);
  border-top-color: #fff;
  border-radius: 50%;
  display: inline-block;
  animation: spin 0.65s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Responsive ── */
@media (max-width: 520px) {
  .login-card { padding: 28px 24px 26px; }
  .form-heading { font-size: 1.25rem; }
  .brand-icon { width: 38px; height: 38px; }
}
</style>
