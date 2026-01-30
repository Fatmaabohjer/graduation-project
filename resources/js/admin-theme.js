// resources/js/admin-theme.js
// نفس فكرة Canva: config + onConfigChange (بس هنا نطبق على IDs الموجودة في blade)

const defaultConfig = {
  background_color: '#FAFAFA',
  surface_color: '#FFFFFF',
  text_color: '#111827',
  primary_action_color: '#111827',
  secondary_action_color: '#F9C74F',
  font_family: 'Inter',
  font_size: 16,

  dashboard_title: 'Admin Dashboard',
  subtitle: 'Overview of users, templates, and activity.',

  stat_1_title: 'Users',
  stat_2_title: 'Meal Templates',
  stat_3_title: 'Workout Templates',
  stat_4_title: 'Activity Logs',
};

function setText(id, value) {
  const el = document.getElementById(id);
  if (el) el.textContent = value;
}

function setStyle(id, styles) {
  const el = document.getElementById(id);
  if (!el) return;
  Object.entries(styles).forEach(([k, v]) => (el.style[k] = v));
}

function applyAdminTheme(config = {}) {
  const c = { ...defaultConfig, ...config };
  const baseFont = `${c.font_family}, -apple-system, BlinkMacSystemFont, sans-serif`;

  document.querySelectorAll('*').forEach((el) => (el.style.fontFamily = baseFont));
  document.body.style.backgroundColor = c.background_color;

  // Titles
  setText('admin-title', c.dashboard_title);
  setText('admin-subtitle', c.subtitle);

  setStyle('admin-title', { color: c.text_color, fontSize: `${c.font_size * 1.875}px` });
  setStyle('admin-subtitle', { color: '#6B7280', fontSize: `${c.font_size * 0.95}px` });

  // Cards background
  ['stat-card-1', 'stat-card-2', 'stat-card-3', 'stat-card-4', 'quick-actions-card', 'activity-table']
    .forEach((id) => setStyle(id, { backgroundColor: c.surface_color }));

  // Stat titles
  setText('stat-1-title', c.stat_1_title);
  setText('stat-2-title', c.stat_2_title);
  setText('stat-3-title', c.stat_3_title);
  setText('stat-4-title', c.stat_4_title);

  ['stat-1-title','stat-2-title','stat-3-title','stat-4-title'].forEach((id) => {
    setStyle(id, { color: '#6B7280', fontSize: `${c.font_size * 0.875}px`, fontWeight: '600' });
  });

  // Buttons colors (Quick actions)
  ['qa-btn-1','qa-btn-2','qa-btn-3'].forEach((id) => {
    setStyle(id, { backgroundColor: c.secondary_action_color, color: c.text_color });
  });

  // Icons bg
  setStyle('stat-1-icon', { backgroundColor: '#3B82F6' });
  setStyle('stat-2-icon', { backgroundColor: '#10B981' });
  setStyle('stat-3-icon', { backgroundColor: '#F59E0B' });
  setStyle('stat-4-icon', { backgroundColor: '#8B5CF6' });
}

document.addEventListener('DOMContentLoaded', () => {
  applyAdminTheme();
});

// لو حبيتي بعدين تبدلي theme من أي مكان:
window.applyAdminTheme = applyAdminTheme;
