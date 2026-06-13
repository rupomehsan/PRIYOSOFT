<template>
  <footer class="ps-footer">
    <div class="container">

      <!-- ── Top grid ── -->
      <div class="row g-5 ps-footer-top">

        <!-- Brand column -->
        <div class="col-lg-4 col-md-12">
          <div class="ps-footer-brand">
            <span class="ps-footer-icon">P</span>
            <span class="ps-footer-bname">Priyo<em>Soft</em></span>
          </div>
          <p class="ps-footer-desc">
            We craft modern, scalable web &amp; mobile software that empowers
            businesses to grow faster and smarter. From idea to launch — we build it.
          </p>
          <div class="ps-socials">
            <a href="#" aria-label="LinkedIn"  class="ps-social-link"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" aria-label="GitHub"    class="ps-social-link"><i class="fab fa-github"></i></a>
            <a href="#" aria-label="Twitter"   class="ps-social-link"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Facebook"  class="ps-social-link"><i class="fab fa-facebook-f"></i></a>
          </div>
        </div>

        <!-- Products column -->
        <div class="col-lg-2 col-sm-6 col-6">
          <h6 class="ps-footer-heading">Products</h6>
          <ul class="ps-footer-links">
            <li><a href="#products">Our Software</a></li>
            <li><a href="#products">SaaS Solutions</a></li>
            <li><a href="#products">Mobile Apps</a></li>
            <li><a href="#products">Open Source</a></li>
          </ul>
        </div>

        <!-- Company column -->
        <div class="col-lg-2 col-sm-6 col-6">
          <h6 class="ps-footer-heading">Company</h6>
          <ul class="ps-footer-links">
            <li><a href="#about">About Us</a></li>
            <li><a href="#team">Our Team</a></li>
            <li><a href="#blog">Blog</a></li>
            <li><a href="#faq">FAQ</a></li>
            <li><a href="#testimonials">Testimonials</a></li>
          </ul>
        </div>

        <!-- Contact column -->
        <div class="col-lg-4 col-md-12">
          <h6 class="ps-footer-heading">Get In Touch</h6>
          <ul class="ps-footer-contact">
            <li>
              <span class="ps-contact-icon"><i class="fas fa-envelope"></i></span>
              hello@priyosoft.com
            </li>
            <li>
              <span class="ps-contact-icon"><i class="fas fa-phone"></i></span>
              +880 1XXX-XXXXXX
            </li>
            <li>
              <span class="ps-contact-icon"><i class="fas fa-map-marker-alt"></i></span>
              Dhaka, Bangladesh
            </li>
          </ul>
          <a href="#newsletter" class="ps-footer-cta">
            Send a Message <i class="fas fa-arrow-right ms-2"></i>
          </a>
        </div>
      </div>

      <!-- ── Divider ── -->
      <hr class="ps-footer-hr">

      <!-- ── Bottom bar ── -->
      <div class="ps-footer-bottom">
        <p class="ps-copy">
          &copy; {{ year }} <strong>PriyoSoft</strong>. All rights reserved.
        </p>
        <p class="ps-stack">
          Built with <i class="fas fa-heart ps-heart"></i> using
          <span>Laravel</span> &amp; <span>Vue.js</span>
        </p>
      </div>

    </div>
  </footer>
</template>

<script>
export default {
  name: 'PsFooter',
  computed: {
    year() { return new Date().getFullYear(); },
  },
};
</script>

<style scoped>
/* ── Shell ──────────────────────────────────────── */
.ps-footer {
  background: linear-gradient(180deg, #0d0d24 0%, #0f0f23 100%);
  color: #9ca3af;
  padding-top: 4.5rem;
  padding-bottom: 0;
  border-top: 1px solid rgba(255,255,255,.06);
}

.ps-footer-top { padding-bottom: 3.5rem; }

/* ── Brand ──────────────────────────────────────── */
.ps-footer-brand {
  display: flex;
  align-items: center;
  gap: .6rem;
  margin-bottom: 1.1rem;
}
.ps-footer-icon {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-weight: 900;
  font-size: 1.2rem;
  flex-shrink: 0;
}
.ps-footer-bname {
  font-size: 1.3rem;
  font-weight: 800;
  color: #fff;
}
.ps-footer-bname em { font-style: normal; color: #a78bfa; }

.ps-footer-desc {
  font-size: .9rem;
  line-height: 1.75;
  color: #6b7280;
  margin-bottom: 1.5rem;
  max-width: 360px;
}

/* ── Social icons ───────────────────────────────── */
.ps-socials { display: flex; gap: .6rem; }
.ps-social-link {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  background: rgba(255,255,255,.06);
  border: 1px solid rgba(255,255,255,.1);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #9ca3af;
  font-size: .9rem;
  text-decoration: none;
  transition: background .2s, color .2s, border-color .2s, transform .2s;
}
.ps-social-link:hover {
  background: linear-gradient(135deg, #667eea, #764ba2);
  border-color: transparent;
  color: #fff;
  transform: translateY(-3px);
}

/* ── Heading ────────────────────────────────────── */
.ps-footer-heading {
  color: #e5e7eb;
  font-weight: 700;
  font-size: .8rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  margin-bottom: 1.25rem;
}

/* ── Link lists ─────────────────────────────────── */
.ps-footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: .65rem;
}
.ps-footer-links a {
  color: #6b7280;
  text-decoration: none;
  font-size: .9rem;
  transition: color .2s, padding-left .2s;
  display: inline-flex;
  align-items: center;
}
.ps-footer-links a::before {
  content: '→';
  margin-right: .4rem;
  opacity: 0;
  transition: opacity .2s;
  font-size: .75rem;
  color: #667eea;
}
.ps-footer-links a:hover {
  color: #c4b5fd;
  padding-left: 4px;
}
.ps-footer-links a:hover::before { opacity: 1; }

/* ── Contact list ───────────────────────────────── */
.ps-footer-contact {
  list-style: none;
  padding: 0;
  margin: 0 0 1.5rem;
  display: flex;
  flex-direction: column;
  gap: .8rem;
}
.ps-footer-contact li {
  display: flex;
  align-items: flex-start;
  gap: .75rem;
  font-size: .9rem;
  color: #6b7280;
  line-height: 1.5;
}
.ps-contact-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: rgba(102,126,234,.15);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #818cf8;
  font-size: .82rem;
  flex-shrink: 0;
}

/* ── Footer CTA ─────────────────────────────────── */
.ps-footer-cta {
  display: inline-flex;
  align-items: center;
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: #fff !important;
  font-weight: 700;
  font-size: .875rem;
  text-decoration: none;
  padding: .65rem 1.5rem;
  border-radius: 50px;
  transition: transform .2s, box-shadow .2s;
}
.ps-footer-cta:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(102,126,234,.45);
}

/* ── Divider ────────────────────────────────────── */
.ps-footer-hr {
  border: none;
  border-top: 1px solid rgba(255,255,255,.07);
  margin: 0;
}

/* ── Bottom bar ─────────────────────────────────── */
.ps-footer-bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: .5rem;
  padding: 1.25rem 0;
}
.ps-copy {
  margin: 0;
  font-size: .85rem;
  color: #4b5563;
}
.ps-copy strong { color: #9ca3af; }
.ps-stack {
  margin: 0;
  font-size: .82rem;
  color: #4b5563;
  display: flex;
  align-items: center;
  gap: .3rem;
}
.ps-stack span { color: #818cf8; font-weight: 600; }
.ps-heart {
  color: #f43f5e;
  font-size: .8rem;
  animation: heartbeat 1.4s infinite;
}
@keyframes heartbeat {
  0%, 100% { transform: scale(1); }
  50%       { transform: scale(1.25); }
}

/* ── Responsive ─────────────────────────────────── */
@media (max-width: 768px) {
  .ps-footer { padding-top: 3rem; }
  .ps-footer-top { padding-bottom: 2.5rem; }
  .ps-footer-bottom { justify-content: center; text-align: center; }
}
</style>
