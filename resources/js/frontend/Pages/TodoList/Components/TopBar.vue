<template>
  <header class="tb-topbar">

    <div class="tb-topbar__brand">
      <div class="tb-logo">P</div>
      <div>
        <h1 class="tb-title">Task Board</h1>
        <p class="tb-sub">PriyoSoft · Project Management</p>
      </div>
    </div>

    <div class="tb-search-wrap">
      <i class="fas fa-search tb-search-icon"></i>
      <input
        class="tb-search-input"
        :value="search"
        @input="$emit('update:search', $event.target.value)"
        placeholder="Search tasks…"
      />
      <button v-if="search" class="tb-search-clear" @click="$emit('update:search', '')">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="tb-topbar__stats">
      <div class="tb-chip">
        <span class="tb-chip__val">{{ stats.total }}</span>
        <span class="tb-chip__lbl">Total</span>
      </div>
      <div class="tb-chip tb-chip--green">
        <span class="tb-chip__val">{{ stats.completed }}</span>
        <span class="tb-chip__lbl">Done</span>
      </div>
      <div class="tb-chip tb-chip--indigo">
        <span class="tb-chip__val">{{ stats.inProgress }}</span>
        <span class="tb-chip__lbl">Active</span>
      </div>
      <div class="tb-chip tb-chip--amber">
        <span class="tb-chip__val">{{ stats.pending }}</span>
        <span class="tb-chip__lbl">Pending</span>
      </div>
      <div class="tb-chip tb-chip--slate">
        <span class="tb-chip__val">{{ stats.skipped }}</span>
        <span class="tb-chip__lbl">Skipped</span>
      </div>

      <div class="tb-ring-wrap" :title="overallPct + '% complete'">
        <svg class="tb-ring" viewBox="0 0 36 36">
          <circle class="tb-ring__track" cx="18" cy="18" r="15.9"/>
          <circle
            class="tb-ring__fill"
            cx="18" cy="18" r="15.9"
            :stroke-dasharray="overallPct + ' 100'"
          />
        </svg>
        <span class="tb-ring__label">{{ overallPct }}%</span>
      </div>
    </div>

  </header>
</template>

<script>
export default {
  name: 'TopBar',
  props: {
    stats:  { type: Object, default: () => ({ total: 0, completed: 0, inProgress: 0, pending: 0, skipped: 0 }) },
    search: { type: String, default: '' },
  },
  emits: ['update:search'],
  computed: {
    overallPct() {
      const { total, completed } = this.stats;
      return total ? Math.round((completed / total) * 100) : 0;
    },
  },
};
</script>

<style scoped>
.tb-topbar {
  display: flex;
  align-items: center;
  gap: 1.25rem;
  flex-wrap: wrap;
  padding: .9rem 1.5rem;
  background: rgba(5,5,18,.97);
  border-bottom: 1px solid rgba(255,255,255,.06);
  backdrop-filter: blur(16px);
  flex-shrink: 0;
  z-index: 20;
}

/* Brand */
.tb-topbar__brand { display: flex; align-items: center; gap: .75rem; flex-shrink: 0; }
.tb-logo {
  width: 38px; height: 38px; border-radius: 10px;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  display: flex; align-items: center; justify-content: center;
  font-weight: 900; font-size: 1.1rem; color: #fff;
}
.tb-title { font-size: 1rem; font-weight: 900; color: #f1f5f9; line-height: 1.2; }
.tb-sub   { font-size: .68rem; color: #475569; }

/* Search */
.tb-search-wrap {
  flex: 1; min-width: 180px; max-width: 340px;
  display: flex; align-items: center; gap: .55rem;
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(255,255,255,.09);
  border-radius: 10px;
  padding: .5rem .9rem;
}
.tb-search-icon  { color: #374151; font-size: .8rem; }
.tb-search-input { flex: 1; background: none; border: none; outline: none; color: #e2e8f0; font-size: .875rem; }
.tb-search-input::placeholder { color: #374151; }
.tb-search-clear { background: none; border: none; color: #475569; cursor: pointer; font-size: .72rem; padding: 0; }

/* Stats chips */
.tb-topbar__stats {
  display: flex; align-items: center; gap: .6rem; margin-left: auto; flex-wrap: wrap;
}

.tb-chip {
  display: flex; flex-direction: column; align-items: center;
  background: rgba(255,255,255,.04);
  border: 1px solid rgba(255,255,255,.07);
  border-radius: 10px; padding: .35rem .8rem; min-width: 50px;
  text-align: center;
}
.tb-chip__val { font-size: 1.05rem; font-weight: 900; color: #e2e8f0; line-height: 1; }
.tb-chip__lbl { font-size: .58rem; color: #475569; text-transform: uppercase; letter-spacing: .5px; margin-top: .15rem; }
.tb-chip--green  .tb-chip__val { color: #6ee7b7; }
.tb-chip--indigo .tb-chip__val { color: #a5b4fc; }
.tb-chip--amber  .tb-chip__val { color: #fbbf24; }
.tb-chip--slate  .tb-chip__val { color: #94a3b8; }

/* Progress ring */
.tb-ring-wrap {
  position: relative;
  width: 44px; height: 44px;
  display: flex; align-items: center; justify-content: center;
}
.tb-ring {
  position: absolute; inset: 0;
  width: 44px; height: 44px;
  transform: rotate(-90deg);
}
.tb-ring__track {
  fill: none; stroke: rgba(255,255,255,.07); stroke-width: 3.5;
}
.tb-ring__fill {
  fill: none; stroke: url(#tbGrad); stroke-width: 3.5;
  stroke-linecap: round;
  stroke-dashoffset: 0;
  transition: stroke-dasharray .6s ease;
}
.tb-ring__label {
  position: relative; z-index: 1;
  font-size: .64rem; font-weight: 900; color: #a5b4fc;
}
</style>
