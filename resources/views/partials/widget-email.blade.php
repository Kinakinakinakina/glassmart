{{-- Decorative "email updates" widget (very 2009). Client-side only — it just
     says thanks; there is no newsletter backend. Orange-framed window. --}}
<x-window title="Glassy email updates" bg="#e8740f">
    <p class="muted">Get fresh 2010s nostalgia dropped in your inbox!</p>
    <form class="aero-sidesearch"
          onsubmit="event.preventDefault(); this.querySelector('input').value=''; this.querySelector('button').textContent='Thanks! ✓';">
        <input type="email" placeholder="you@hotmail.com" aria-label="Email address">
        <button class="aero-btn aero-btn--sm aero-btn--orange" type="submit">Join</button>
    </form>
</x-window>
