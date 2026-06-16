<template>
  <div class="tb-task" :class="'tb-task--' + (task.priority || 'low')">

    <!-- Priority side bar rendered via ::before in CSS -->

    <div class="tb-task__status-dot"
         :class="'dot--' + (task.current_status || 'pending')"
         :title="task.current_status || 'pending'">
    </div>

    <div class="tb-task__body">
      <div class="tb-task__row">
        <span class="tb-task__title"
              :class="{ 'tb-task__title--done': task.current_status === 'completed' }">
          {{ task.title }}
        </span>
        <div class="tb-task__badges">
          <span v-if="task.priority" class="pr-badge" :class="'pr-badge--' + task.priority">
            {{ task.priority }}
          </span>
          <span class="st-badge" :class="'st-badge--' + (task.current_status || 'pending')">
            {{ statusLabel(task.current_status) }}
          </span>
        </div>
      </div>

      <p v-if="task.note" class="tb-task__note">{{ truncate(task.note, 110) }}</p>

      <div class="tb-task__meta">
        <span v-if="task.assigned_to" class="tb-task__assignee">
          <span class="tb-avatar">{{ (task.assigned_to[0] || '?').toUpperCase() }}</span>
          {{ task.assigned_to }}
        </span>
        <span v-if="task.estimated_days" class="tb-task__days">
          <i class="fas fa-clock"></i> {{ task.estimated_days }}d
        </span>
        <span v-if="task.is_recurring" class="tb-task__recur" title="Recurring task">
          <i class="fas fa-redo"></i>
        </span>
        <span v-if="task.completed_at" class="tb-task__done-at">
          <i class="fas fa-check-circle"></i> {{ formatDate(task.completed_at) }}
        </span>
        <span v-if="task.fixed_cost" class="tb-task__cost">
          <i class="fas fa-dollar-sign"></i> {{ task.fixed_cost }}
        </span>
      </div>
    </div>

  </div>
</template>

<script>
const STATUS_LABELS = {
  pending:     'Pending',
  in_progress: 'In Progress',
  completed:   'Done',
  skipped:     'Skipped',
};

export default {
  name: 'TaskItem',
  props: {
    task: { type: Object, required: true },
  },
  methods: {
    statusLabel(s) { return STATUS_LABELS[s] ?? (s || 'Pending'); },
    truncate(str, n) { return str && str.length > n ? str.slice(0, n) + '…' : (str || ''); },
    formatDate(d) {
      if (!d) return '';
      try { return new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }); }
      catch { return d; }
    },
  },
};
</script>

<style scoped>
.tb-task {
  display: flex;
  align-items: flex-start;
  gap: .85rem;
  padding: .85rem 1rem;
  border-radius: 10px;
  border: 1px solid rgba(255,255,255,.05);
  background: rgba(255,255,255,.02);
  position: relative;
  overflow: hidden;
  transition: background .2s, border-color .2s, transform .18s;
}

/* Priority colour strip — left edge */
.tb-task::before {
  content: '';
  position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
  border-radius: 3px 0 0 3px;
}
.tb-task--critical::before { background: #f43f5e; }
.tb-task--high::before     { background: #f97316; }
.tb-task--medium::before   { background: #f59e0b; }
.tb-task--low::before      { background: #06b6d4; }

.tb-task:hover {
  background: rgba(255,255,255,.045);
  border-color: rgba(255,255,255,.1);
  transform: translateX(3px);
}

/* Status dot */
.tb-task__status-dot {
  width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; margin-top: .3rem;
  transition: box-shadow .2s;
}
.dot--pending     { background: #f59e0b; }
.dot--in_progress { background: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.2); }
.dot--completed   { background: #10b981; }
.dot--skipped     { background: #475569; }

/* Body */
.tb-task__body { flex: 1; min-width: 0; }

.tb-task__row {
  display: flex; align-items: flex-start; justify-content: space-between; gap: .75rem;
  margin-bottom: .3rem;
}

.tb-task__title {
  font-size: .875rem; font-weight: 600; color: #e2e8f0;
  line-height: 1.45; flex: 1; min-width: 0; word-break: break-word;
}
.tb-task__title--done {
  color: #475569; text-decoration: line-through;
}

.tb-task__badges { display: flex; gap: .35rem; flex-shrink: 0; flex-wrap: wrap; align-items: center; }

.tb-task__note {
  font-size: .76rem; color: #64748b; line-height: 1.5; margin: 0 0 .4rem;
}

.tb-task__meta {
  display: flex; align-items: center; gap: .65rem; flex-wrap: wrap;
  font-size: .71rem; color: #475569;
}

.tb-task__assignee { display: flex; align-items: center; gap: .35rem; }
.tb-avatar {
  width: 18px; height: 18px; border-radius: 50%; flex-shrink: 0;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  display: inline-flex; align-items: center; justify-content: center;
  font-size: .55rem; font-weight: 900; color: #fff;
}

.tb-task__days   { display: flex; align-items: center; gap: .3rem; }
.tb-task__recur  { color: #818cf8; }
.tb-task__done-at { display: flex; align-items: center; gap: .3rem; color: #10b981; }
.tb-task__cost   { display: flex; align-items: center; gap: .2rem; color: #fbbf24; }
</style>
