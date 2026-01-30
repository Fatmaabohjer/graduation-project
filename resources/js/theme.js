// resources/js/theme.js
// VitaPlan Theme System (Canva-like)
// Applies global CSS variables + font to the whole app.

export function applyVitaTheme() {
  const root = document.documentElement;

  // ===== Colors (edit here only) =====
  const theme = {
    bg: "#FAFAFA",
    surface: "#FFFFFF",
    text: "#1C1C1E",
    muted: "#6B7280",
    border: "rgba(0,0,0,0.06)",

    // Primary actions (black buttons)
    primary: "#1C1C1E",
    primaryText: "#FFFFFF",

    // Secondary accent (yellow)
    accent: "#F5C543",
    accentText: "#1C1C1E",
  };

  // CSS Vars used across pages
  root.style.setProperty("--vp-bg", theme.bg);
  root.style.setProperty("--vp-surface", theme.surface);
  root.style.setProperty("--vp-text", theme.text);
  root.style.setProperty("--vp-muted", theme.muted);
  root.style.setProperty("--vp-border", theme.border);

  root.style.setProperty("--vp-primary", theme.primary);
  root.style.setProperty("--vp-primary-text", theme.primaryText);

  root.style.setProperty("--vp-accent", theme.accent);
  root.style.setProperty("--vp-accent-text", theme.accentText);

  // Base background + text
  document.body.classList.add("antialiased");
  document.body.style.backgroundColor = theme.bg;
  document.body.style.color = theme.text;
}

// Auto-apply when loaded
if (typeof window !== "undefined") {
  window.addEventListener("DOMContentLoaded", () => applyVitaTheme());
}
