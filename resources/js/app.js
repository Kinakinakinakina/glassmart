/* ==========================================================================
   GlassMart — Frutiger Aero behaviour (hand-written vanilla JS)
   --------------------------------------------------------------------------
   Four small, independent enhancements, all progressive (the site works with
   JS off — these only add atmosphere):
     1. Floating bubbles generator
     2. Loading splash screen
     3. Sound-FX toggle (synthesised blips via the Web Audio API, no files)
     4. Retro visitor counter + "users online" number
   ========================================================================== */

/* 1. ---------- Floating bubbles ------------------------------------------- */
function spawnBubbles(layer, count) {
    for (let i = 0; i < count; i++) {
        const b = document.createElement('div');
        b.className = 'bubble';

        const size = 10 + Math.random() * 60;            // 10–70px
        b.style.width = b.style.height = size + 'px';
        b.style.left = Math.random() * 100 + 'vw';       // random x start
        b.style.animationDuration = (16 + Math.random() * 16) + 's'; // slow, calm drift
        b.style.animationDelay = (-Math.random() * 26) + 's';        // desync them
        b.style.opacity = (0.3 + Math.random() * 0.45).toFixed(2);

        layer.appendChild(b);
    }
}

/* 2. ---------- Top loading sliver ----------------------------------------- */
/* A thin bar at the very top of the page (never covers the content, so there
   is no full-screen flash). It just fades out once the page has loaded. */
function finishLoadbar() {
    const bar = document.querySelector('.aero-loadbar');
    if (bar) bar.classList.add('aero-loadbar--done');
}

/* 3. ---------- Sound FX (Web Audio, synthesised — no asset files) --------- */
const AeroSound = {
    ctx: null,
    on: false,

    init() {
        try {
            this.on = localStorage.getItem('aero-sound') === 'on';
        } catch (e) {
            this.on = false;
        }
    },

    // lazily create the AudioContext on first real use (browsers require a
    // user gesture before audio can start)
    ensureCtx() {
        if (!this.ctx) {
            const AC = window.AudioContext || window.webkitAudioContext;
            if (AC) this.ctx = new AC();
        }
        return this.ctx;
    },

    blip(freq = 660, duration = 0.08, type = 'sine') {
        if (!this.on) return;
        const ctx = this.ensureCtx();
        if (!ctx) return;
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = type;
        osc.frequency.value = freq;
        // quick pluck envelope so it sounds like a soft UI "tick"
        gain.gain.setValueAtTime(0.0001, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.18, ctx.currentTime + 0.01);
        gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + duration);
        osc.connect(gain).connect(ctx.destination);
        osc.start();
        osc.stop(ctx.currentTime + duration);
    },

    toggle(btn) {
        this.on = !this.on;
        try { localStorage.setItem('aero-sound', this.on ? 'on' : 'off'); } catch (e) {}
        if (btn) btn.textContent = this.on ? '[ sound: on ]' : '[ sound: off ]';
        if (this.on) this.blip(880, 0.12, 'triangle');   // confirmation chirp
    },
};

/* 4. ---------- Visitor counter + online number --------------------------- */
function renderVisitorCounter() {
    const el = document.querySelector('.aero-counter .digits');
    if (!el) return;

    // A believable-looking running total: a fixed base, nudged up once per
    // browser via localStorage so it climbs as "you" revisit.
    const BASE = 42318;
    let visits = 0;
    try {
        visits = parseInt(localStorage.getItem('aero-visits') || '0', 10) || 0;
        visits += 1;
        localStorage.setItem('aero-visits', String(visits));
    } catch (e) {
        visits = 1;
    }
    const total = BASE + visits;
    el.textContent = String(total).padStart(7, '0'); // 0042319

    const online = document.querySelector('.aero-online-num');
    if (online) online.textContent = 7 + Math.floor(Math.random() * 20);
}

/* 5. ---------- Cross-fading backdrops ------------------------------------- */
/* One shared engine for every "two stacked layers that cross-fade through a
   shuffled image list" effect on the site. Pass the container, its layer
   selector, how often to advance, and (optionally) a sessionStorage key to
   persist the shuffled order + current frame across page loads. */
function startCrossfade({ container, layerSelector, intervalMs, persistKey = null, fallback = [] }) {
    const root = document.querySelector(container);
    const layers = root ? root.querySelectorAll(layerSelector) : [];
    if (!root || layers.length < 2) return;

    let images = fallback;
    try {
        const fromData = JSON.parse(root.dataset.images || '[]');
        if (Array.isArray(fromData) && fromData.length) images = fromData;
    } catch (e) { /* malformed data — keep the fallback list */ }
    if (!images.length) return;

    // When a persist key is given, reuse the saved shuffle + frame as long as it
    // still matches the current image set — this is what makes a backdrop "stay
    // the same for a new window" instead of re-rolling on every page load.
    // We ALSO store a timestamp and advance by however many whole intervals have
    // really elapsed since that frame was set. Without this, the shuffle only
    // ever moves via the in-page timer below, which restarts on every reload —
    // so refreshing/navigating faster than one interval would freeze it forever.
    let order = null, idx = 0, ts = Date.now();
    if (persistKey) {
        try {
            const saved = JSON.parse(sessionStorage.getItem(persistKey) || 'null');
            if (saved && Array.isArray(saved.order)
                && saved.order.length === images.length
                && saved.order.every((s) => images.includes(s))) {
                order = saved.order;
                idx = Number.isInteger(saved.idx) ? saved.idx : 0;
                ts = Number.isFinite(saved.ts) ? saved.ts : Date.now();
                const steps = Math.floor((Date.now() - ts) / intervalMs);
                if (steps > 0) { idx += steps; ts += steps * intervalMs; }
            }
        } catch (e) { /* ignore — fall through to a fresh shuffle */ }
    }
    if (!order) { order = [...images].sort(() => Math.random() - 0.5); idx = 0; ts = Date.now(); }
    idx = ((idx % order.length) + order.length) % order.length;

    order.forEach((src) => { const im = new Image(); im.src = src; }); // preload
    const save = () => {
        if (!persistKey) return;
        try { sessionStorage.setItem(persistKey, JSON.stringify({ order, idx, ts })); } catch (e) {}
    };
    save();

    let front = 0;
    layers[0].style.backgroundImage = `url("${order[idx]}")`;
    layers[0].classList.add('is-active');
    layers[1].classList.remove('is-active');

    // Only skip when there's a single image. These are deliberate Frutiger-Aero
    // cross-fades the site owner explicitly asked for, so — unlike the bubbles and
    // load bar — they run even under prefers-reduced-motion (gentle opacity fades,
    // no large/vestibular motion). That setting was silently freezing every
    // backdrop + ad shuffle on machines with Windows "Animation effects" off.
    if (order.length < 2) return;

    const tick = () => {
        idx = (idx + 1) % order.length;
        ts = Date.now();
        const back = front ^ 1;
        layers[back].style.backgroundImage = `url("${order[idx]}")`;
        layers[back].classList.add('is-active');
        layers[front].classList.remove('is-active');
        front = back;
        save();
    };

    // Fire the first change at the next real interval boundary (so a reload
    // mid-cycle keeps the wall-clock rhythm), then settle into a steady cadence.
    const remaining = Math.max(1200, intervalMs - (Date.now() - ts));
    setTimeout(() => { tick(); setInterval(tick, intervalMs); }, remaining);
}

// Outside wallpaper (the Frutiger Aero sky down both sides) — reshuffles each
// visit, slow ~90s fade. The real list comes from .aero-sky[data-images].
function startSkyRotator() {
    startCrossfade({
        container: '.aero-sky', layerSelector: '.aero-sky-layer',
        intervalMs: 90000,
        fallback: ['/images/bg/2.png', '/images/bg/3.png'],
    });
}

// Touhou backdrop INSIDE the shell window — persists across pages (sessionStorage)
// so it stays put as you navigate, carrying on its slow ~90s fade.
function startWindowBg() {
    startCrossfade({
        container: '.aero-winbg', layerSelector: '.aero-winbg-layer',
        intervalMs: 20000, persistKey: 'gm_winbg_v1',
        fallback: ['/images/touhou/touhou_47.jpg'],
    });
}

// Shuffling ad panel in the home-page left column — soft fade every ~4s.
function startSideAds() {
    startCrossfade({
        container: '.aero-shuffle-ad', layerSelector: '.aero-shuffle-ad-layer',
        intervalMs: 4000,
    });
}

/* 6. ---------- Random ad pop-ups ------------------------------------------ */
/* Period-authentic fake "ad" windows that pop up occasionally at random spots.
   Each is a real Win7 glass window with a working [X] close and can be dragged
   by its title bar. Gentle by design: capped at MAX on screen at once. */
// Image list; the real list comes from #aero-popup-src[data-images] (globbed
// from public/images/popups/ server-side). Just the image pops up — no caption,
// no title text, no "Learn here" / "Adopt now" button, per the brief.
let AD_IMAGES = ['/images/popups/image.png'];
try {
    const src = document.getElementById('aero-popup-src');
    const list = src ? JSON.parse(src.dataset.images || '[]') : [];
    if (Array.isArray(list) && list.length) AD_IMAGES = list;
} catch (e) { /* keep the fallback */ }
// Preload, and only let an image into the rotation once it has actually decoded
// — that way a pop-up never flashes as an empty white window while its (often
// multi-MB) image is still downloading.
const AD_LOADED = [];
AD_IMAGES.forEach((src) => {
    const mark = () => { if (!AD_LOADED.includes(src)) AD_LOADED.push(src); };
    const im = new Image();
    im.onload = mark;
    im.src = src;
    if (im.complete && im.naturalWidth) mark();   // already cached
});

const AdPopups = {
    open: 0,
    MAX: 7, // at most 7 on screen at once, per the brief

    spawn() {
        if (this.open >= this.MAX) return;
        if (!AD_LOADED.length) return;   // nothing decoded yet — wait for next tick
        const img = AD_LOADED[Math.floor(Math.random() * AD_LOADED.length)];

        const el = document.createElement('div');
        el.className = 'window glass active aero-popup';
        // No title text — just the image, with a working [X] to close/drag by.
        el.innerHTML =
            '<div class="title-bar">' +
                '<div class="title-bar-text"></div>' +
                '<div class="title-bar-controls"><button type="button" aria-label="Close"></button></div>' +
            '</div>' +
            '<div class="window-body has-space">' +
                '<img src="' + img + '" alt="">' +
            '</div>';

        // Keep pop-ups out in the SIDE gutters (left & right of the centred shell),
        // like the reference. They may creep a little over the shell edge but never
        // land over the middle content.
        const vw = window.innerWidth, vh = window.innerHeight;
        const w = 220, h = 240;   // smaller so they tuck into the gutters
        const shellW = Math.min(1240, vw - 40);
        const gutter = Math.max(0, (vw - shellW) / 2);
        const overlap = 34;   // how far a pop-up may nudge over the shell edge
        let left;
        if (Math.random() < 0.5) {            // left gutter
            const hi = Math.max(6, gutter - w + overlap);
            left = 6 + Math.floor(Math.random() * Math.max(1, hi - 6));
        } else {                              // right gutter
            const lo = Math.min(vw - w - 6, vw - gutter - overlap);
            left = Math.floor(lo + Math.random() * Math.max(1, (vw - w - 6) - lo));
        }
        el.style.left = Math.max(6, Math.min(left, vw - w - 6)) + 'px';
        el.style.top  = (64 + Math.floor(Math.random() * Math.max(1, vh - h - 90))) + 'px';

        document.body.appendChild(el);
        this.open++;
        AeroSound.blip(440, 0.08, 'sawtooth');

        el.querySelector('[aria-label="Close"]').addEventListener('click', () => {
            el.remove();
            this.open--;
        });
        this.makeDraggable(el, el.querySelector('.title-bar'));
    },

    makeDraggable(el, handle) {
        let sx, sy, ox, oy, dragging = false;
        handle.addEventListener('pointerdown', (e) => {
            if (e.target.closest('button')) return;      // let the [X] work
            dragging = true;
            el.style.zIndex = 901;
            sx = e.clientX; sy = e.clientY;
            const r = el.getBoundingClientRect();
            ox = r.left; oy = r.top;
            handle.setPointerCapture(e.pointerId);
        });
        handle.addEventListener('pointermove', (e) => {
            if (!dragging) return;
            el.style.left = (ox + e.clientX - sx) + 'px';
            el.style.top  = (oy + e.clientY - sy) + 'px';
        });
        handle.addEventListener('pointerup', () => { dragging = false; });
    },
};

function startAdPopups() {
    // Come in hot: two almost straight away, then frequent waves (capped at MAX).
    setTimeout(() => AdPopups.spawn(), 1500 + Math.random() * 2000);
    setTimeout(() => AdPopups.spawn(), 4000 + Math.random() * 3000);
    setInterval(() => { if (Math.random() < 0.9) AdPopups.spawn(); }, 9000);
}

/* ---------- Wire everything up -------------------------------------------- */
document.addEventListener('DOMContentLoaded', () => {
    const bubbles = document.querySelector('.aero-bubbles');
    if (bubbles) spawnBubbles(bubbles, 10);

    startSkyRotator();
    startWindowBg();
    startSideAds();
    startAdPopups();

    AeroSound.init();

    const soundBtn = document.getElementById('aero-sound-toggle');
    if (soundBtn) {
        soundBtn.textContent = AeroSound.on ? '[ sound: on ]' : '[ sound: off ]';
        soundBtn.addEventListener('click', () => AeroSound.toggle(soundBtn));
    }

    // soft tick on every glossy button press
    document.querySelectorAll('.aero-btn, .btn, .aero-chip').forEach((el) => {
        el.addEventListener('click', () => AeroSound.blip(620, 0.07, 'sine'));
    });

    renderVisitorCounter();
});

// fade the top loading sliver once the page has finished loading
window.addEventListener('load', finishLoadbar);
// safety net in case 'load' is slow
setTimeout(finishLoadbar, 3000);
