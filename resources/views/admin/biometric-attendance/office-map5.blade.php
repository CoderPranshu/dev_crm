@verbatim
<style>
/* Everything in the component is scoped to this section for embedding in an existing panel. */

#codesparrow-office-map{--brand:#197a83;--cyan:#15afbd;--ink:#263b47;--muted:#728b96;--line:#dcebf0;font-family:Inter,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;color:var(--ink);width:100%;padding:10px;background:#fff;box-sizing:border-box}
#codesparrow-office-map *,#codesparrow-office-map *::before,#codesparrow-office-map *::after{box-sizing:border-box}
#codesparrow-office-map button,#codesparrow-office-map input{font:inherit}
#codesparrow-office-map button{cursor:pointer;color:inherit;border:0;background:none;-webkit-tap-highlight-color:transparent}
#codesparrow-office-map button:focus-visible,#codesparrow-office-map input:focus-visible{outline:3px solid #15afbd66;outline-offset:3px}
#codesparrow-office-map button:disabled{opacity:.35;cursor:default}
#codesparrow-office-map .om-canvas{position:relative;width:100%;height:clamp(620px,calc(100svh - 20px),1100px);overflow:hidden;border:1px solid #e1edf1;border-radius:14px;background:radial-gradient(ellipse at 50% 45%,#fff 35%,#f7fcfd 100%)}
#codesparrow-office-map .om-stage{width:100%;height:100%;display:block;touch-action:none;user-select:none;cursor:grab}
#codesparrow-office-map .om-stage.panning{cursor:grabbing}
#codesparrow-office-map .om-logo{position:absolute;top:17px;left:24px;width:144px;height:auto;z-index:2;pointer-events:none}
#codesparrow-office-map .om-sample{position:absolute;top:23px;right:24px;font-size:10px;letter-spacing:.2px;color:#8a9faa;pointer-events:none}
#codesparrow-office-map .om-hint{position:absolute;bottom:19px;left:23px;display:flex;align-items:center;gap:7px;color:#8399a3;font-size:10px;pointer-events:none}
#codesparrow-office-map .om-icon{width:17px;height:17px;fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round;display:block;flex-shrink:0}
#codesparrow-office-map .om-controls{position:absolute;bottom:14px;right:18px;display:flex;align-items:center;gap:2px;padding:5px;border:1px solid #dcebf0;border-radius:9px;background:#fffffff5;box-shadow:0 3px 14px #197a830c;z-index:3}
#codesparrow-office-map .om-controls button{width:32px;height:32px;border-radius:6px;display:grid;place-items:center;color:#557d8b}
#codesparrow-office-map .om-controls button:hover{background:#e9f7fa;color:var(--brand)}
#codesparrow-office-map .om-zoom-label{min-width:39px;text-align:center;font-size:11px;color:#6e8e9c}
#codesparrow-office-map .om-control-separator{width:1px;height:19px;background:#e1edf2;margin:0 4px}
#codesparrow-office-map .seat{cursor:pointer;outline:none}
#codesparrow-office-map .selection-ring{opacity:0;transition:opacity .15s;pointer-events:none}
#codesparrow-office-map .seat:hover .selection-ring,#codesparrow-office-map .seat:focus .selection-ring,#codesparrow-office-map .seat.selected .selection-ring{opacity:1}
#codesparrow-office-map .seat:hover .name-plate,#codesparrow-office-map .seat.selected .name-plate{fill:#e5f6f8;stroke:#39a8b4}
#codesparrow-office-map .seat-code{fill:#75909c;font-size:11px;letter-spacing:1px;font-weight:550}
#codesparrow-office-map .seat-name{fill:#324e5a;font-size:14px;font-weight:600}
#codesparrow-office-map .status-text{font-size:11px;letter-spacing:.1px;font-weight:600}
#codesparrow-office-map .zone-label{font-size:12px;letter-spacing:1.3px;font-weight:700;fill:var(--brand)}
#codesparrow-office-map .zone-count{font-size:10px;fill:#90a7b0;font-weight:450;letter-spacing:0}
#codesparrow-office-map .zone-label-small{font-size:10px;fill:#6c939f;letter-spacing:1.5px;font-weight:600}
#codesparrow-office-map .entrance-label{font-size:8px;letter-spacing:2px;fill:#83a2ad}
#codesparrow-office-map .om-detail{position:fixed;inset:0;width:360px;max-width:calc(100vw - 28px);max-height:90svh;margin:auto;padding:23px;border:1px solid #d6e9f0;border-radius:16px;background:#fff;color:var(--ink);box-shadow:0 20px 80px #194d622b;overflow-y:auto}
#codesparrow-office-map .om-detail::backdrop{background:#345b692e;backdrop-filter:blur(3px)}
#codesparrow-office-map .om-detail-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;color:#79a0aa;font-size:10px;letter-spacing:1.4px;text-transform:uppercase}
#codesparrow-office-map .om-close{width:29px;height:29px;background:#eef8fa;border-radius:50%;display:grid;place-items:center;color:var(--brand)}
#codesparrow-office-map .om-close:hover{background:#dff3f6}
#codesparrow-office-map .om-preview{height:173px;background:radial-gradient(ellipse,#fff,#eef8fb);border:1px solid #e0eef3;border-radius:10px;margin-bottom:18px}
#codesparrow-office-map .om-preview svg{height:100%;width:100%;display:block}
#codesparrow-office-map .om-detail h2{font-size:24px;line-height:1.25;letter-spacing:-.5px;font-weight:650;margin:0}
#codesparrow-office-map .om-role{font-size:12px;color:#7b99a5;margin:8px 0 14px}
#codesparrow-office-map .om-status{display:inline-flex;gap:6px;align-items:center;border-radius:6px;padding:6px 9px;font-size:10px;font-weight:600;background:#e6f6ee;color:#14805d}
#codesparrow-office-map .om-status.absent{background:#fcecef;color:#c94e62}
#codesparrow-office-map .om-status.free{background:#eff5f8;color:#728b9b}
#codesparrow-office-map .om-dot{width:5px;height:5px;border-radius:50%;background:currentColor}
#codesparrow-office-map .om-details{margin:18px 0 0;padding:10px 0;border-top:1px solid #e4eff3}
#codesparrow-office-map .om-details>div{display:flex;align-items:center;justify-content:space-between;gap:12px;font-size:11px;padding:8px 0}
#codesparrow-office-map .om-details dt{color:#8aa1ac}
#codesparrow-office-map .om-details dd{margin:0;color:#486a7c;font-weight:550;text-align:right}
#codesparrow-office-map .om-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;min-height:38px;border:1px solid #d4e8ef;border-radius:7px;background:#fff;color:#567b8b;font-size:11px;font-weight:550;padding:10px 12px}
#codesparrow-office-map .om-btn:hover{background:#f1fafd}
#codesparrow-office-map .om-btn.primary{background:var(--brand);border-color:var(--brand);color:white}
#codesparrow-office-map .om-btn.primary:hover{background:#126b74}
#codesparrow-office-map .om-actions{display:grid;gap:8px;margin-top:13px}
#codesparrow-office-map .om-note{font-size:10px;line-height:1.7;color:#93aab5;margin:14px 0 0}
#codesparrow-office-map .om-allocate{display:grid;gap:9px;margin-top:10px}
#codesparrow-office-map .om-allocate label{font-size:10px;color:#6f919f}
#codesparrow-office-map .om-allocate input{width:100%;padding:10px;border:1px solid #d8eaf0;border-radius:7px;font-size:12px;background:#fcfeff;color:#345b6f}
#codesparrow-office-map .om-reset{display:block;font-size:10px;color:#6f99aa;text-decoration:underline;text-underline-offset:3px;margin:13px auto 0;padding:5px}
#codesparrow-office-map .om-toast{position:absolute;bottom:63px;left:50%;transform:translate(-50%,8px);opacity:0;pointer-events:none;transition:.2s;background:#197a83;color:white;padding:10px 15px;border-radius:8px;box-shadow:0 6px 22px #176d8320;font-size:11px;max-width:90%;text-align:center;z-index:5}
#codesparrow-office-map .om-toast.show{opacity:1;transform:translate(-50%,0)}
#codesparrow-office-map:fullscreen{padding:0;height:100svh;background:white}
#codesparrow-office-map:fullscreen .om-canvas{height:100svh;border:0;border-radius:0;max-height:none}
@media(max-width:700px){#codesparrow-office-map{padding:6px}#codesparrow-office-map .om-canvas{height:calc(100svh - 12px);min-height:560px;border-radius:11px}#codesparrow-office-map .om-logo{width:122px;left:16px;top:15px}#codesparrow-office-map .om-sample{right:16px;top:22px;font-size:9px}#codesparrow-office-map .om-hint{left:13px;bottom:63px;font-size:9px}#codesparrow-office-map .om-controls{right:12px;bottom:12px}#codesparrow-office-map .om-toast{bottom:108px;width:max-content;max-width:90%}}
@media(prefers-reduced-motion:reduce){#codesparrow-office-map *{transition:none!important}}

#codesparrow-office-map .om-canvas{box-shadow:0 10px 45px #197a830a;background:radial-gradient(ellipse at 55% 25%,#ffffff 40%,#eef9fc 100%)}
#codesparrow-office-map .om-seat-art{transform-box:fill-box;transform-origin:center center}
#codesparrow-office-map .om-person{transform-box:fill-box;transform-origin:50% 100%}
#codesparrow-office-map .selection-ring{stroke-dasharray:none;stroke-width:1.2;fill-opacity:.14}
#codesparrow-office-map .om-controls button{transition:background .2s,color .2s;box-shadow:0 1px 0 #ffffff}
#codesparrow-office-map .om-detail{background:linear-gradient(160deg,#fff 70%,#f1fafc);border-color:#c7e5ed}
#codesparrow-office-map .om-preview{background:radial-gradient(ellipse,#ffffff,#e7f5f9)}
#codesparrow-office-map .om-presence-halo{pointer-events:none}

#codesparrow-office-map .om-typing-left{transform-box:fill-box;transform-origin:85% 100%}
#codesparrow-office-map .om-typing-right{transform-box:fill-box;transform-origin:15% 100%}
#codesparrow-office-map .om-head{transform-box:fill-box;transform-origin:50% 100%}
#codesparrow-office-map .om-screen-code{transform-box:fill-box;transform-origin:center}
#codesparrow-office-map .om-sample{color:#197a83;font-weight:600;letter-spacing:.4px;background:#ecf9fb;border:1px solid #d8eef3;padding:7px 10px;border-radius:20px}
#codesparrow-office-map #viewToggle{font-weight:750;font-size:11px;background:#e5f5f7;color:#197a83}

#codesparrow-office-map .om-3d-legend{position:absolute;right:24px;top:62px;z-index:2;display:flex;gap:12px;font-size:10px;color:#69838b}
#codesparrow-office-map .om-3d-legend span{display:flex;gap:4px;align-items:center}
#codesparrow-office-map .om-3d-legend i{width:5px;height:5px;border-radius:50%}
@media(max-width:700px){#codesparrow-office-map .om-3d-legend{left:24px;right:auto;top:83px}}

#codesparrow-office-map .om-three{position:absolute;inset:0;z-index:1}
#codesparrow-office-map .om-three[hidden]{display:none}
#codesparrow-office-map .om-three canvas{display:block;width:100%;height:100%;touch-action:none}
#codesparrow-office-map .om-three-labels{position:absolute;inset:0;pointer-events:none;overflow:hidden}
#codesparrow-office-map .om-world-label{position:absolute;left:0;top:0;pointer-events:auto;background:#fffffff2;border:1px solid #d5e5e8;border-radius:5px;padding:4px 7px;display:flex;gap:5px;align-items:center;white-space:nowrap;font-size:10px;font-weight:600;box-shadow:0 2px 7px #24455112;color:#355661}
#codesparrow-office-map .om-world-label[hidden]{display:none}
#codesparrow-office-map .om-world-label i{width:6px;height:6px;border-radius:50%;background:#758c98}
#codesparrow-office-map .om-world-label.present i{background:#14805d;box-shadow:0 0 0 2px #14805d14}
#codesparrow-office-map .om-world-label.absent i{background:#c94e62}
#codesparrow-office-map .om-world-label:hover{border-color:#197a83;background:#eaf8fa}
#codesparrow-office-map .om-hint{z-index:2}
#codesparrow-office-map .om-sample{z-index:2}
</style>
<style>
/* Show the allocated seat number on the 3D label, including empty seats. */
#codesparrow-office-map .om-world-label .om-seat-id{font-size:9px;font-weight:700;color:#197a83;margin-left:3px;padding-left:5px;border-left:1px solid #d5e5e8}
/* The 2D fallback uses the SVG's natural proportions to avoid side gaps. */
@media (min-width:701px){
  #codesparrow-office-map:not(:fullscreen) .om-canvas:has(.om-three[hidden]){height:auto;max-height:none;aspect-ratio:1320 / 860}
  #codesparrow-office-map:not(:fullscreen) .om-canvas:has(.om-three[hidden]) .om-stage{position:absolute;inset:0;width:100%;height:100%}
}
</style>
<section id="codesparrow-office-map" aria-label="CodeSparrow interactive office map">
 <div class="om-canvas">
  <img class="om-logo" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUsAAABdCAYAAAAsT0SsAAAQAElEQVR4Aex9C3xcVbX3WnsmkzTkYqlpmoTKl+vtLU1asAIX8QXl6YOLgAqIiIgIiqDC5dmkLYc+QeRD5ANFRfACPoqX8hJBKC3KRa5XsGKZlsrlVixJX7f21pAmkzl7ff81yUxm5pwzmUlmklLO+e09Zz/WXnudtff+77X3PjkxFF57jQb2b18yu6lj4bKm9kUr4H/f2L74T+o13NSx6PGmuQtvbm5f+OkpjtOw1zx0+CChBsZIAyFYjpGiK1nN/nOXTm/uWHiDJfenJHwl6joFfjaTTFOvYRI6gZi/KsS3mETkvqb2hReEoAnNhC7UQJEaCMGySEXtkWSOY5o7Fn/VcvJhEb6ciKcT0XBtOgk0RxLx7QDNXzRfvegEcpwohVeogVADBTUw3MAqWHg0mWHZ0WugsT96mIgsoQGQpBFch4ihO8DnkBGUDYuEGnhLaSAEyzdpc0++wmlkkX+D+HXwBV1trIoueP976JEvnUsPnP9ZOu3dB5NhTpeZymLvfMeVTnM6IbyHGgg14NVACJZenezxKW2OE4tEox0QdCr8sO7Y6dPosmOOpHdPbaZ/+j/voMuPPZLamqbQ0MXTk1XmwqF4GAo1EGogXwNvPbDM18CbML6jLzaNWT5VrOgnzmqluupYhnzqxLfRSUjLJBBFCQdD+1/pFAW+WeXCYKiBt4wGzFvmSfeqB7UfxePUwxfl+l3XQ9fbn8xPi0mV0VP0/PQwHmog1AA0YOBD9ybSQP2KJ+Zwbc05pYh81388T9u738gUWdu1hX78/JpMPB0Q4o+kw+E91ECogVwNhGCZq48KxkbHuuXOVTUNK578DJO50769oY1KuF58vYsuWv4Afe/Z39K3n3mO2h96jLb8rdvLQWSaNzFMCTUQakA1EIKlamEP9/UP/rK5e6L9MRHfQUQtst8kQ7GhPUikFXS6DH/m1Y3kPPoELX5sJT3/l00kIj5leGrj1U6LT0aYFGrgLa+BECz38C5Qv+KpC1giK5noFMBbCiGlZgLZifpuedmFr2UT+VNTx6JfNLYv/GyL40wsew0hw1ADb1INhGC5hzbclPsfb8Cy+3YmuZ2EZuSLKU04uB56VzI/Ozteahgn4/RhJv5hXyLy56aOhYumtC+ZFf6VT6lqDOn3Ng2EYLmHteikRx/dd/KKp063HP2FEF8QJJ5gGS51fxeUXa70fUl4nhG7sqk/8nBz+8LPT73amRYCZ7nUG/J5M2kgBMs9qLUmL19VF+mrxt6k3AmxDoEv6OTv3lYwv2yZTA0k9GERPjPJkek4XQr7TdmUGzJ6s2gg7PR7QkutWhWdfP+TH+Yq+x8QR9+hrMV9WCd1w/6l47A8iiB4jYXnRpPu/l3L5h+/edn8R+OOkyiiHIU0oQb2Jg2EYDnOrQlrsrH+r3YZMf9ciGC0lSBQTVGYWgLDHNIkEX+nK+b+Q+eyedf95etOJ4VXqIG3sAZCsByvxoc1WX//k//MVXYlzmkugRglt4XuWwJkUbTsbjuRXFgdS16K/UmAZtn5hwxDDbzpNFDyAH3TPeEeKPDEFasm1v+vvYWZfzpoTY7se5LMRNGRFS2kFiy7b+yK2R9sdJzeQnR7bF4oWKiBCmjAVIBnyLKABhpWPHlKjOzjLPQlkI1+HW0iYFNOJ+v7k8m7YFHacnINeYUaeLNrIATLMWpB7E3WYdm9QIhXCNHhZatWwK1szIhYzA+33eBspvAKNRBqIEcDIVjmqKP8kZbU33SvPIGq5GFmvqbsNfh8UWg0dRhJ/mw05d/aZcOn35s1EIJlJVvXcUzPfvZiIbqdSOagqvLqW7BSti7Yls3ZTTX0atm4hYxCDexFGijv4N2LFDPaR3n7ipWHT37XB3+NVfIN4FWRj1NwTw8wWMC+bK6HHAcIXDZ+IaNQA3uNBkKwLHNT7rv8sUkND6y8HMcuvwbr98FXzHH3rnLzTpabYchvTDQQVjIGGgjBsoxKnnz/Ex+ojkX15fJFQpT6QlAZ2XtY8c6/etJGmRCC5SgVGBbfezUQgmU52nb58tjkB578JLG5m4SPIKGacrAtyCPRR9z9t4IkI8gM+8MIlBYWeWtoIBwco2znyQ+uPHJyrP5BEr4PrCqyNwm+uQ6HOpGN/0Vky769+FpuRWEs1EBhDbyVckOwHEVr6yEOWbqTRE4YBZuSi/KuXZWwKlWO8CRctRD6UAM+GgjB0kcpxSbZiN3MRGP6J4H8t11kXocBWOb3K1PPLPx86h7+hBoINeDRQAiWHpUUn/DXjx3/mjBfgRJjY5Fh2a1AyT1voMryO0vyYvm5hhxDDVRAA+PAMgTLUSp92ynHPOqynExClQUaWJKR/3qZ1LIcpchBxXdGqt2ngjLD9FADb3UNhGBZhh6wY80z63ESfg4Rr6YKXNzXS5E/v0r8vzsrwH2AJRM/0Ok4PQOx8DfUQKiBfA2EYJmvkZHEHcduO/XoNX39iU+g+DfhN8GP3okls20LmVdgUf7PNsJB0uh5+nPYDrC82T8rTA01EGpANTAAlhoK/ag1sOv0D+/YNtFcwcJfA7MN8CN3ImS2dJF57b+pUnuUaeEYWwgS6x+dvGlm4T3UwF6qgRAsy92wRx+d3PrxY+7fduqxB4rhk8H+WeLiT8y5dzeZzr9Q9A+/I/OXP1MF3qWESDku4RLdFC7Bc3QSRkINeDQQgqVHJeVL2H7yMQ+xK2ezyJmU7F/Ob3RbTvQRJZNEOLAhN0mcSBDv7sF+5F9T4KhLbtP1OlF/f/kEKcRJ6NlIwn2uEEmYF2og1ADROIPl3t8EWz953KtbTz3ugckvPXd2ZMPaZyLrX6LI+rWDHuGXNYz7hvVkNr+eAs4xsCbTiu9xxT2v80ZnezohvIcaCDXgr4EQLP31UvbUuOMkTD+fT329O1KWZM8blNqL7O0lWJ2oT+DH1jHz3K3XOa+Oba1hbaEG3pwaCMFyDNvt9WXtGwBQJwEWK/tO5vDPlGDhqzqXzPvW8KQhRaiBUAOqgbcqWOqzj4vvrEo+h4PuDiIeL4suKcT39FYnv0PhFWog1EDRGgjBsmhVlYnQceyWZfMfidjkh4gkXiauJbDh7ydiyUt3OM6uEgqFpKEG3vIaCMFynLrApuucVzhmj0L1D8D3wFfa7WCS87qWzrswBMpKqzrkvzdqIATLMW7V7Oo6HWd719L5p7KlU5H+AnwSvtxuJxMttzG3tXPpgh+Um3nIL9TAW0UDIVjuAS3ded38X3Kf+yHsZZ5JTI9BpNfgLfxIHY7YdYnP3yHm4ynmnrvFcbaOlFlYLtRAqAEK37PcUzqBvuu4edn8n3VVuSeJdY9iIf0783sgXwl7i7KeWRaKoY/YmD26C0vuriXzfgcLtgd8QhdqINTAKDRQMcuyra0t1tLSUvn/RTOKh98jizpOcvN1zsbOZfMf6Fo6/+yumLtfNOnuL8zvsUInYd/xLCE5F4dDZ+N+hjV0bITMu/pi7tu6li5o7Vyy4JrNi+ev9liSe+TDhkKFGnjzaMCMUlRz0EH/+M7W1tYjZ7a1XTurrXXFzLbWP8PvxqDu26d2wm6EXfi/zmxt/XfQ3Dmrre30tra22dOmTdt3lHWPuDjqP2D27NkTsxkcfPDBU9VnpxUTbsGEcOihh9aOxiuPOXPmRFGftz1wev6Xrzudm5fM+62eoncuXfCjzUsX3AVgvAf35VsWz39q09KOF8NDG2gvdKEGKqgB7+AcvrIUQAL8LpnZNmOFdSNPG6bHYeksEKJTiOgA+GyLUuuYSEzvA83nYA39FEC6qjpW9cTMma23trW1fWB2HnChfEUc6mpsa5uxhEUeTiQS07Mr6e/vP9hN9q9C/ucOPPDA5uy8QuF9Jkx4sHd3z6rR+LraCau2bdnyNCabVfAr2tpa74BuFkHHn501a8b7dEJSQPWTY8aMGS0HHTR9xkF7iIeOtf39RPVNa3ac2uaOxe9r6lj8L43ti+9o6lj086a5i1bh/nhT+6J7G+cuXtB89aITQFfvyyArsfmqaw5oBq9ifGPH4sOntC+ZNfkKp5EcRyeqLE7DBxvnLm0brp6Gq513Ds+JqMVxJg7HK50/pWPxEU3tSw7Zf+7S6ZMcp2iDYyR1qPzQe20xzxBE03i109I0d9HHmzsWXtvcvuinCD8Br+37i6b2xbcj/WJtC5UviIemazuldZB9b+pYfBjKZuONkqd889ylM7Jps8NT25ccnCLK/0FfaIJ+s2k1rDIqkOWTB8Z1wLa1td5q3ehKgN9NRPwx+KlE5Css0oPcRGQcTkJfBnD+IpnoexCDbDbSKubU+gVIPs7E7ZB9ugh29ry1TUP+96LGqDyHe7N9UpgOQarSjthjkjkCMr0P9yPhT2Giz0M385D2Q7G8SickBVSA5yUtLblbG8w8yXUjV4BG6cbdG5K872JCOwFOO6wkIo+jLR4nkRvRF/S5P4rnnoPnPwHFPo092GvRUg9LwjzdOHfRR5EW6CQaOV9Eni7GM+gM2VXRKvN0cyJyrw6QQMZ5GW2OE2N2bx+unoiJLMor6htNJCOHDccrnW8gN0Fua9ynqxORp5s7Ft6w/5WOjkFf3unEEutYpXVA/lWSiKxqnrv4SgWrNK9i7yh3NZvI02jP+0R4Afr26QgfB6/t+2EiuQDpt7DIyj70g2aAWxDvSJU5Ia2D7Dv6zYpEX6zFr5wY9+Zs2uywS/ZevzLv6KEGIvfebFoN4wzhp0WBJYAs1tY24wIsq5/HQP4SKvEVDukjcXVQ4pFMAquu9Y5yW5kASaz8W++A9fsEGsl/NsmVOgq6wyDPb2a2td2OZ5+Umz3msRgRT4WOFFBvQht0wer8MZ7rOCIy69ate4GILxTicwEw+tHhRiIaTz+8vhwn2ti+8LMu2V9D1g/A18EXcqqDNmZ6sGnu4nktjhM0OUfBpFivPGCt8nQhOp3IPt8My6cYUNj2BuEZBYOKhqtrBuQZ3iVJx+FwvNL50AXti7bWNp4NsLncRiO/b5q78GYF8cDKSqtDdaNW6wHgd7iwXB+tirzc1L7wC4gP6xS8m9sX34lyy0CsPPT5EAx02v6ox/0NVhKXk+N46YX1Yy9pHWTfJ6IeX+tXJDUOsmmzw6o/j0A2EgMesT57Ni3Cst0rVF5x7OM1YHa/nom/jaw2+Eq5iQyLClbmSiw954y2Et1DBEp+HiCpAP958NNOhlvRDrqRCwCav29rm/G5fIuuaC7lJ5yIgfIpPNcTWLI/DDA/IB6PJ+EfmzxlynsB9D9BlXv06XdTX+RjTPw9yKmdEreiXZRYru3rN58rukQJhAqakaror/fHErdQsUg0BrBk+EJUqbxpqd/K/9QT81f/mojeUsGq0Fb8PUxW7eQEb1vost2NRm7FdttI2mgisGYR+odu5+U8CrPZnJMwFKlFn1CwHUoZDGFy1QltMOa5TcJzGE8qSy0T1XrTaauXeIjKYCBOc5P9D2NwfhnJhWiR+WFtOwAAEABJREFUXR6HDnuIWLobltMpcwYOPUpiDJnrUPajvbvfeBgNpgBfKkjm13cAE9+6D/YmwTdlzWUTQF79J1+V++c42ZXlhVH3R5kIFvmMK6fhwGz16tVJET4fz30RSIM6F7LGz01xnAZimgsJRtouBv3xUt0LA49CbkR5mBynWXaX6KAPYsDG1iNPt5JwK+j2rZSc/rXK55rbF37eFwT8C5SeyjK3sS+iWyS+ZaU/+iX0SSyxfbOLSaxB/+jYv33J7Gxik+wPek/YsBVvW6h1KqTtlM0mO2ymkDdfAJYgqoXPcSwcDJYAhjbsJdyKEroXN9KOjeIjcTwVltP127dvLknpCpRYTl2DsncQ8TFEVC65a9GAJxiWe2GtflqBCbwHHV+IwXstIrpMwG2snbyTia+prq66tqWlpQYWZndDQ+M9AEwFpN6xlma4+jhh5oBmNvwoHE/jiCmpb5RY2QnUHw2UkcXqHmG0GJ6GI8Vs/RTDqhiamCX+Gk4ni7F6i+HnR1MHi+0s8rEuJzk4cLJyFQqNdtwdbMU9G3wyrqqWAseXZfE8LxLU2izYRpE+XSFkqhgIuKLlvPKz9V+GA3SmGeb7FCAGOIzL73SxfB9k+cBwtYOmDiCGGU1eBnBcDnrf/Qikj9JxA0Do7upY1fO6NFfLF+C046V1674pxH9PxAuJaDwAqgaAfQkOgR5XXaiFGY+vv8sOvNhuIdOe4RzdizJLIIx/J2bajJn960TyRWK+DHTPwPs5WJe8yG/A+hEPpu3CXVcAaV9IL/uKyA2g93XC1Oqb4ZOI/nK0T3IpSdqf0jLrPVGoMBPNsn0RNXAKkeXn6baN8k77ZD5BXvzI5t6IGiM5ydUJczoxNeQkZkeYfknMlw60rywmtHd2dlY4Ssyfy27fjY6T1kMW2UDQiPHUWdMXw5wxkB/060ZcD40Y8fBC+YSQed0gkONSe5RksfchxW1O55Que6QGy6I7YeXqibMfc90qOAYj5+folLrk9jy8X6EypOmp+Z3btmx5Ql/dAT8D0Ox+KR6/BqB5FDqD/sliEulj6oQIB2V0i7ahVozDn0eJWP/bpHY0Gu9rai/BCpZpAXL0RsR8aPOSBVd1LV3w3a4l8/5vV8yFLkk/NEI+V/3+iapZPul+STsNmaO6ls7fL+2rY+7bifg7FHy9Tw8q/LKxJMt57SyfJjfOszHoPeMsl6ZATOS7aZn1DrnfRsIdKLED3s8ZY+Q9fhlBaRg7FynvtLcxd388o65MgvpwM0Xk/V5+rO3lTSbCvE0PdS2Z/6GuJfO+OdC+C+ZbMceDuBvez03ytq/4L8WNnZzPQIz1A70cMizfvct0Nt40om6sJnKX4WopJZP9AEr2zBo5tYxNxKKa10jopqqqKj3lRTTjDEBqOqy7mwCmKxQkMjljGWCaEzG8amZb2xLI06JVAzR/WxWrOZNxOs1EOKnW1LH08hk3mVzU0jLwihF0s4SYlo+lBEF1WY4EHhCK8Pc3Le3I/Siy46APGH39xhcYXHJLAK1cqWCp7KyOJS8Voodyc4ZiyUhk9lBsINTmODGU0WX4QELml/2/T8pUjxkcq8IM4agCkLt3v+rkN4hEwcyXF3Q5zTejyET966/O6iQs/MB+YwLqCGhf3oiVqsdS37K0Yy0OZwI/QC3k5vFj3314yOIFRit+oEfZl/G1gi22MrOpUuFuMpwLllu2bDkMA/yTyPau2ZE4hs5CjscwHZ2HJe5tL774YvaMotbkCRHme5n4q5AJp3T4HT8HkJQrIc+dOMV/n4qxZs2anWvj8XuSVgCa9CTSCi6dkF9OF8VAOr22tjYlC8B7B04Yb0cFusTCbfwcltjeTj0oDlYHTwwGc2421o+J0t+i8O/sOcULRhR4MBnfHUTERvS1l5zs/yHCYYLAU94l+k/f/CyxicleKmsf1X9REk3aR/IEGIoCoIciIww5Dsag/DywtE8dQhSw/SWbqSrpazhY5pWoA5MifvOcsMnn57tviXq97cHDgyWq81ikJMbLi6SHrRnas8ReVxs6ny5lDZiMnxN6VojPWBtfdxKWkQo0GVmwHD9iVlvrf8KafBjW0mGZjPEPGMgzRyyn/qQTcqa2DdavX78Bz3E8QP8oDMpfjqGYE6GjFWjT1GBfu3Y9BjIHzuBjJhebINBIYub2HQgYRdhPY3ivlGKNT8f20hVKYcMbke/Ln6x3ScZ9MVgsnA/6loTXEbF+LYryrnqORPPp80hKj+qfwKJU7gSIhJQTqiUn+PWeFE0RP4YiawPJhOry8zg1keSnIs60K+hjLsYafQZ//ZPdD6UzDhZkZyaSFUC99S2OU5OVRCIeoM3OToWVZrLj5D2H5AM0aLk7GevvNAilHIt8HIFynNzp/hjMZcayRH3KKkiA93CuU4h+IMznNDQ06D4VxslAEQz6xpmtrZcAzH8IGgUiWE8DeXver3wGct6BA6fPz549OzWYAfrPRaqqzqOBAyBfUKDyX/uicT8zyNZGotFbYXFuHYyP1y3TpnkCRGngFDIvmaiKSMuo9+Sxscj2JJeWIKy81XvKgX91fqIxVpfU+aDfzWwxkAVWcH4JqolYvwHooSs9gUnHmm85rF+Nb0YJiQCnQP4AKD/+fmkl1OghNQD9DE/oXrdj/Nqqxu0hbZcUAwVOJos96VS0wI9MQgcaAlmdYIRSY5ayL6HuLUQ7UoLgQGAqLCM9qk/Fs+mKDCcpZRHKNWzkWBNxj8bgPEq9kDlaiD+CTWRYNrzeh98O1P0T0JzY0DDli1g2vrJ69erUckbBBqBzuSEsB5huRNkR71GhbNphJuP7sQ8KME8nEbmu+1sivouIAmY55BTnFMhn43nv6E/06en0h/VVI2wlbBo8AMKmNi8k4h9lPNNPiORn0OEv4X+HdJUtsKNSkRdkuFTrVnLUv5U49XwaHRcvYqF7/6olIr6nxtgPskS8hoj0ZDzHW6H/Rnolnc94sLNRIcTCb8bxDmHzCgf+XyWekSENA6VoIEf/IvQ6CvuMT6lLRqsyFiEsszpmzsRRJsg1Zm+RTH6D6ol9LGamrQDtZEoY/YgEuL0TfiQOSxB6yBU5Kx5fvxBLvmf/+McN6zE4N6kH+Kl7qqGh8TILGlQQh0+77SR0VVVV9YUgWrN6ECQ1c9asAw/uTySux4CHJ7UmU7Jq3ij8DtR3RVUsdhFk25rNZ8OGDdvf6Om5UOtDut9yCsklu8OZ5O7q6qqO2YNWpj6ngib8WRn/0rozX4qvPw37sx8S5pPY2LMx8K5ioidLrjG3QH1NTfSIdJK19FMhuqeSnogfp4CLLWPF4Z8pYj6JDqkTTQ7BRsfp7YolL9wv5h6b7zfH7L/mEI9BxIp5d3416DO7Im6yE0aqn2VJwvT3+WXe7HH0ITv0DGMUEla88AFLrrHGDlmEu6WWBMA3rFhSbziWsSyrojHwQFlPOdSLtBQAGUNnIOzpqEgbziWF+FRhPhP7c7r3E0i/GkCI5egLVbHq9xPT19HBLkPZAwEQ39cDkXRBPVWeObP1erHmN7C2LkB6SkbcR+N2ap39SddTXzbTjRs39irgQ653Q9nzkbcTfrSuHryuhJX557a2GVdjSyFWiCHAdLNOOGvj8W+tja/T/c5DITssT7KFygXlWctno87UEkX1H4+vO7uSfm08vjRQlhrXd5Nf6TGpTGtOmM9q2OMdJ6mHGvke4Go9tJVPODK/CiO0fVMNbRShP+XnpeIi0/UUPRUegx8WSqiuKlkV6hj1yqdU+azhTmLu9ilXl73VYU11nbBn60P7ivqs4txIxmb2LG3EhTVqarMIUkG0q1q0ZBSc8ODFvq+WKjz4A2XxDxoaGh6Nx+OwfAdTh7kpMMKSXNbT03sbyu1Ik+tyEafJqVNugMvFSPcIjbRSnU1ZZ0IX1tTUXqvWYzEMVC5MAF9nI7DwSAc4nrWYkgVp9mXi+cxyK8DrA3PmpL5fWbCAZirAifBVxLRc46V61HmYiDSXWq4S9Nj30f1abHf4c8ck9ZUpjtPgnzv+qfonkAD1lnxJ0Mm2AriTYjjIspy0o5fK3wZCvgaOMGXGVb6spcSTLIETe7nqKEWeqDV4LvGxLKkG4yNlECg/NraWmDNxTROizcSUs5pE+r4A1QxYskuTcDJUi/RcZyzqJTJRYz4ARiNYgmPfLxa7Si3GXM7DxxQw1YpLUwI86rBUvR2nySvwQPrKi1fgNHFx9yTI4gDdL1ZPqD0Z1utPnn/+eT8lg8zfATATsPAescTHM/H54IW9RLL+1EWn6vLgCxhwD27bunVRsaUgy2sA+/OI5LFiywzRyXSY5iOZDIdYlCvkOBYT8xKwC5p8Zkf6Ij8e07+nZoF6IJGPY6IcI4ATVbpn7gEoTICvaPFIfzJ113Cer6cC75jm0RYVbXEcLBkxuH2oIU/2VpcPRXFJEbFBuJAsVx3FSTJAlahOdCKkf4mFW8qlf2qFaEo6gk62LwnlTLpoy01Iy5/MTLZFSvrXO357lhYWLZgbVDITd1U8bkW7JND7x2vWrCnHMpWi0ShAhHXjfLQgqQ+QZKJHhFj3AL9fKkgqg2wPoNqBpeU9gq0GAPny7LxRhCcBMAM/RuDHV59DyOirXX7ZhdIMZs9sa8hgcpo0ffr0+pF6LY8KA0EGecGu2n0WmX4HfUjGdMB0DLO5dAyXrdrnalKV5/1Ya/6WnSRiW7LjmbDQXzQ8cQJvxl0natyGHPrjRAxE/7JDZCWFevsialT4toFY/kNJzIKIjXzQN0toB1n+vW9eBRO3OU43MXX7VcFiMpakcUnxLFc3TNtRdjvlX0yZcmRTPGrySKwYTuGcgdmps2VefuEoE6231minL0w4xrmQ61cAyXetja/7BECuLLNr+hHA75WXcBAD/seSkL4QbNN5Y3WHDKhX8pcSw1bPZA6kwevggw9uhp7+syoa2TZSD6B/Hts3qXc4B9kWfet0nO0ipNZlIrAQ88V/TUR+PGg9BZKVJUPoTPDxWItII2Kbd9DHM8jnYsP69gIN7hP6vZtYS9a0+hQtPclxovplIWYKmDhlQzKZmpBK5z1YYpLj7NvUvvAzIqx/9DGYmnVjeiZW7T6WlTJmQRZW69JTn5BkLEkxgr3HPBItJ5xvWWIoU1OaUigVzgVZom5YGylr1kDpzWniYu8Q7FUM3BTaFlumsnSyCbPG1zmSPBdyKUhWDMjA/ymc/H+FiBfDDtpEY3tZEtbnK61Wkfp0gWQy2QOw60nHx+NeU+0+CcB+oEDd2mFP6UtEb2h2nIzsBehLzprsOHWNqS+vy6eCCkcosiE7T5j8TrV7ACrZY8G3fYyRkVmWzEc2zV14k/rGuYtvaeqPPIj6lkEuv8kqifF8y7Z9qKQJlbFqUv7qm9sX31rTF1mBfnYj6vDbs+whoXs3Ok7QVgqKVdCx9VqHqI4lx0L09hm2WzH5ecuKydBia0EtUnDLckx4Xu7RFOO8qssAABAASURBVCPEaQKNF+mN7s1UDJCKFCJFJkTLrfDJsPrm/vGPf0rN8KmMCv7oyf9LqY9mGH03UA8sxkwXGLClP+PAN/pSGpkwYUKvCI1PR09JQISBtrM35p6PqB6e4ebrDCajL0hf5L53XOmUPKHncayzZL/XpP/bR337oqejicgqZroPdP79n2nz67H+HCuRRTx/c43+tzPiJjNgKcK+y1PBiTjqGombTcyXqMdgvhhA9VFiylhRuQz5rs4qexs5Tmn9UegEGqwDhtCX0ceOoYA68HzX71ftYoWTW/NYxbCixTmhtzYcsmVAzzBl9i8HKXuZzBb4LvJ8FWzIIvV7Zjxvt3ETqaW/dshaMCjJCdltJRWoDPFrTHxePL7uTD0xRhWldRAUGK2Lx+OvvNGz+yghORsDe0ysTDxzapYrTXZWCwFtTbR79261PpKllS8/tf43SiMRXQLnLXXz6mKa40Yid4/ylFyX2YdhMMxJeSJ9/ecw1BTU99GX+HpynBw9AUQ8YMkkO/trKLVMAz8CoOYArKYNeG4Bv1QbDMTL+csbUfHS/WLJi1CHLSfnNC8h6sSznrV52byFg9sN6awxvTNb3Rf21ImJL2sCkQxwDhJ2W0E5gXVJlAK+wXS9TYLOBtpFKL8cuot0R2opNeZAJPBapnjPwhVpkOIlSFHWwlqYOGfOnJLlT5Uu009NTU0jM7+LiIc2iqmilwJfSRUwkbaX+lQ5kVQ8FR7Pn9eXtW9I9rv6ObFfFZIDIHWMSUR/s/8w/+6hEI8S856rrkrelV1mquNo+/osfXkHTJ3UqyVKb4zRwZyxNDVt0Mf274t5wHYwb5Q3MSxmIkZ0EPiPkj8BNAgLONMIYNGJh8brYsOqX2/1CnSOYyAfVsuUt2fJuwybTaSeODOxDTKpQ8PWaRgTQl45TaXujUSpMgAaLnlJJixvS7Ep088I2dQz8bXbtm25Gaez+rFTPMsIOY2gGEA62traelyE+V4SuhgsKtZRwXvIZe0/DiUWDknWsrunp8eg549rh8+WdtsNzmZm7kDaGvgCTt4pxr2xxXH8l80FSpaYtVNIbt7oODmA5/ZHg16/2ogBmkzX0W/7dWB1p+PZd4m4PmCbTTHi8AFCckEiEb1pMvZiR8ylcMGpOAy+tqnPXD/JcfL/Nr5wyTLmusKq214fllEFPezX6Gl23liUHrZmO6knwZySXVpq038fzkSeviVEO9C+KUPDkNcsRVJhx2RGtllNZb/qAFRfZrIPz2xru2bOnOJe9B6tFDhRbgBI34G9kQcBPPoKR17jjLaGAuWZfE9kC5QgMmjwQYJoNKqWqfrBlPG/dS6Z90w06Z4ISfRdVtz8HUD/n/sSkZtbHKfGn2LUqbvY0hmbY/Zn+ZyQnvmz0ew8Ef5DdjxWQwqy6in/wr5lhSzLVE1RAObnIv1mfipWmZ86Yv5qLGE+Xhn2RXAdAMs8wBsoF+1NLaMxFgV+IE1/GRi3uzqxOQavYU0b8lwrvVQ32KdyyikNE2/Vu3oDsNmkgdK8tOlf3JRWppLUjP0KWbBt65b/VCtzToVAU/nOamu73E32/zv0pn+a51FuJZ8Sz6bLhJLBEoM008axWExlVl9JUUvmrZ8cszEAJtMvhyn86b6E+eQwNKVmvwar6Zuudd/ded38X6YtiWwmWE3pdkF2UipsRHI+WAxF70JGZlmO8JCzlHmFayixcAiWDfjzd4j4O0L8AyLSLQs/ywpZcMKfKXW7goWeIvBXD3C4i4h00spYy4hnuyhozp06sC2RnT4mYbb9almq99Snn8KzAD4irqOsC9s4O3c4zq6NjrMTYW2frFyqY1NVm9gtwJDs5MGwnqIPBg1mCizJB2PF36Zj0JXjc27F11gc5Wwm+c22rVu/B2AZfslTHE+l0he52/TfSGD2vgEJlbQQwN7fGaLPIAc3/JbgWDjzdR5rrVplavnowcrIvFAn2j9oMJUgWS7pFsfZmqxyP8FMhU5bsYXAl7WUthxPoKb7ifi7g/47zPINAOBFhtx3d8Xcf+hatuDSrdc5vm8aDC5tfftTxLq5BzqOo3oBZpLnYsMl9xscGK3uWjrvQvWbl847r2vp/KPY0ElC/IqnAiQwUbPLydkIFu0sy91dg3V0Lp13LvTxHmY+Ggx8LTikt9mEOQH3MXdSo4ct4guW2FWtJ/YaAyw8tM8pNBQekL4Wh2N1EonVD0Rzf6HPrnQKNkPtHxHxrxwZAa4WTM4DIOUgeADtsMm7cIHoUfj8B0FSyQ5gIp8FaK7Ub2DOnj3bsw9RCkfsS86aObN1GZNdRTiZLaVsMK1gMPGPg/O9OSqHkP2aN2fYlG6OSDxNZYzpxEA7zbVy1Eh9pKrqjEmTJpWjrdJiZe7bHKfbuO6lSHgGPsi19SbMx4IyfdKxUWsWARC+OOgv7Fyy4IrNSxbc9vpSZw0syaRPmUxS1W7BdhjDZ5LSgZ1qEacjmTuLTkKZaDoAC39aOjyae2fUfQqW8NwgHtge+qegvKLSHcfq1ggPfLLQr8gkjIVD/TIqnRbBkpqIfUEcE2A9DXwYo5ayLmGb6avCkgkPktREXNmXrfUFSys0tAzHnoua3L5vxQ8yC7jJ6Zj1LgnILJisIAuvS8oU3caNG3snNzRcBcGOZ6LcmTpFUfIPAJOmoUFvSib6Hpw1a8ackjmgAMD2UzhmXIkl95VE7G+mU2mXEN0jZE5aG49/o9iS0JV+xf7fiHgqlXoJvcjsZgZvPB5PwL+m74qO1L/44oubVq8e+OZoqeIUQ7/pOucVnJKfBl11BtDH0E8CwSKgzIiTORKbRCSewQT5MnrNYS70XznxTITfSXpim4mPMOA41lS7alz4MsCYnuabUWKiWHk4oIhBHUF/Nx5QpDzJnY7Tw0L5S+kB5mLqAYZqwOWAJZPJWIfZYUpfBm2rPh0fulsyPASWU6ZMeRFgMBKAqgUYzcdA/hh80QcGA3uddgmT/LGtrfXbswctPx1869atW1s9ofY9QnIu5A0aKMgq3gnRkWL55zPb2m7HwUxRYNPa2noIgPJhPB+sv/KAJOmHYYXOiac+kRZfQ0Vchx56aC3kuBK60v+FUvKfpQ5W8Yu3v31//0E9SLAn3vSUHABVABB5RvPcpTPGQnaxVidKzwkwALu3cd6iOfmeMWgD5Irtn6g6OCCvpGQFDfTPfCspzaMeoIztinR0ZHfDEd9tiUFuGWNnMD5mN+v9etBA3cZOjljxyiU2A3icFR4ohF7GpoH8/quj0HYWzqy6jYIUM+tgTJct5Y4ZXv4N5u/1AEzMvsFF5+DQZcaMGS3VVVW/YGL9m9N6JvpSf6Lv9wCEz7a0DPw3Qv1gRDy+/i4sEfW7l98HxwT8aF0tVHKBm+z/A+T8MLzOPh6eswHcANVbsIx5Gh3xnz0EI0vYQcT/D6D9rpfWrcv5WK3qBLLE1Csw4j4JfhrA+ggcJLX37u75E+S4nohG/PaBMD+ibUxvwgun0j+C2MFAX+LeHHiNyNmITAsoeDhbWpXvYd0sC6AnS66+5haUXVq6iK+FhXGlr9Ggz5fGLp86kUz48h+kGzX/QT4l31gkA345hTFJiRjPWLGGM5OKmxVOlxWyTfD5f/VDGHtbxZrMkt8QLkv0K4AJ9tEQKd1FSehiPMDjbW0zbsBAPw7+kIMOmj4DA1/d4Rj4p+PQ5YcRw7rvp6/aZNfSAqG+vU9t7R0odxwyUjLpEhGm/kVs5Ezw1w3/coCmfu3nPiZ774EHHtiMujJu4MvsfY9DD/rOpC+YZoiLCyRUbit0/Bs9PVfE4/HMDJUuDp3cakieVt/b05O6Q7ZVAOuVQrIEdDkyIl6Sw6B5AfXiNHWgGBrjAOj4iEp61NE2UJv3t2nuoo83tS/+tsd3LP4XWEKpds8p5ThJYr45Jy0rImLGZCkIMPzHrGpHFRQyvqfqI2RqR1iuqGJ6oFEU4ZgTmS3+VUo9ef9+H8v2LOtQWCeADAAqHyPcQgBaDWd7xn6lsX2ZcZvqoBhQrwrxcK9sZPPJD0ch5GFMfDkG+uPwq6xrnmYAgXoM/J8ChD6NQi3wfg6zlHzaMK0A4C7CcrlBiSCXflPyflhHZ4L32UiDlYbf0TkAIZ9gjMk53bSWDwHbMs36sklB/o3du0/D1sILuicL3h4H3RwsREeoV/3hPosG9iWhDyrDxd8Dk8yAMiQ3Q8dPV9STBIIb+sAH4b/k8SKnQk5fB+H161a9vplkvdaAP+GoUnkEp9hBFaLNZ7Q5TtHbVkF83tLpWa/zZOsBYNaAg69cjGHaxdZkAC8VFsrEB8sDC6R+MJy5WSz3zYQsoB3MsSKkA2skrxENssjcIDNhfye116cC6KsqmcxhAnUAxXY32f/vsH5O0WWq0gM0u3Egsjzp2oMAKPpNyfyHVbI9wfdiYrgmEo29d+3a9fcHgeQYCbqmu6fnrnRd2AKZDt19FHEdqJX2qKY8jq1RS8C/vdnoc5SnogAu+toQxoZ3HyyAfvhkqd/2BhXcshqex1ubwma/CpSlCkuMAx7OBUvhHnYHPoShpKkwDwGgpmFcTMVdPW5DDqvlzQCyTN9TYEvlwgL6LQb6tanI+P9Mg/Vz37YtW57AINeHT8n58ssvd8bj686wQicykX6xxo6/qCkJkioP5Ho/9lsX6mlxKnX8fnawseenwVr3g6OGb4I4FQcX1FHIFWqvVBvnF0aihdWdzE/XOHRu9V5JX+C1oRFWy5Mwme6tYFl6e7Cgif1VifZNYHvGwzNiWFeYPfmlYLVPU5+dDkzrrqqlDOBpWNOyaRBWoPSsKpnMlrjjZLb/sgW1EybsA6tNniIij4BIG2unS/s5UMzjsDKPya4cwP6rRNL9EBNfSiS61zqe8v6WhL5miY+HXArg2aKOR7gX8txUX9+UOXGvq6s5DrPnnPEQJl2n3oXM/+rdx+vHDHy3HkTfmxPC1om3lLBVq9ObUcaUwdeG/MBNB6se2Pl7pqCP407ERKYrrjJKuWewQh/TP3bwCoP2Uwvdm0FkWWC8ke/qM6i/MKxFIvY/5KHciyn1IYwMWKKT9WhaLlVALG+5nw2WpCfREPAaFPX96wCkj70T2igiHnn0n49haf4tyHs+wOHJsReMYPDQoyaSPBOn3LfF43Gd7Wi8L3TYnwnz91evHngPEgcuk8SSfjsS/WR8pQNIBHXw+tpeSu1TeyQUOwNpvmBJmPmRV1EHsFZg0wGdX8+GrqXzzwnyETFX5RcYjEdZrFoyg9G96ub9uC4eT4gbI/1R34M/47Ie+EZB5nU+r/mkiFJgKb51pfKzf5h2kuMkafBKWYrYxxyMFry5wjn9NQcstSQG/TPo1GchXJb3HMFnNG5jpKrqbD0ZD2ICeR+bPGXKiVgCHw8a/RAvbhV2QqvRAT64Nr7uxD+O0QeHi3oioUcaGqacC51kXpVgEexFc7legypKjCAiJpM5mafca2rSRG6c5DgE48FQAAAHtklEQVQ5oDS1fcnBRHwTBV8Vt+TtwGD2jBMifo4KXDbW75ng0+TCNDMd3rvu/Du/59GlsbGyrMXJ/QBKU8fiI4llvl8ZTROJ+ravvtIkRMXhk/47CWWW5cUnLSs7EzR5rxn5dAKitWtf/h0b+QpKFScQCCvg1gjxGdj/y0F3v3rUisIS+MmX4uvei/2Ib4EmAxYIl9NtZsiEU+6PAJAK/TleOesshpfumT4AuU5TXaQLzGxt/QLM348j7tvOSB9TF6tKauf3XToz0ceqE9E/NM5dvKCxY+GX9fUil+x/QMB6eD+3q7oqOfzk6FeyhDRj5J/8ya3vF9HTtJ2Oo8t0X+uHhYPe20wXf1PeWf8kOEByTBDH9CXMH5rnLr66uWPhxfrvK0hkJcj999GFtm5e1h5Hvse5+xCW0rlWn4conZD1p46ZJJ+0dF72nZP9OdgTOIjq6xsfYmNPRuEN8BZ+LJ0C5RcBSKUOBtvQ0HiZFToRIKF7Sf57KKU/yXYh0q++HLs2Hl+ePjgpnU0lSuieLS/tTfSfk5YLS++YvtsKHegL7ZWodEQ8NzpOLywJncwC+pO0MMu1AJNbieRLqMR3LwvpFtbBjSl+iFTMOY7BFoZn4x/1JYlN4H+oRH7avZoOZN+FaOqkPCs6O3+0YfA3NX8jfxAaLfOh8p6lM8fsY+hzBQwVni4sy9B2t8Co+TJYeXggTR0OVeRHGvDz2O/qprz9RD86TYMuMn/qqHH1mJg9aZqe72MTcgE5ECxXY89LLUwhPg8dd3U+o4rFhX4HsNOXuEsFypRIKjeszBcmT55yHvYyO5C4E37kTuhFJsb+E38N4O07042c+ahLbhYyF73R07PslVdeyVhsxtg56IwAHPI7mBh1paNhYGz0biEqMKCK4r7JSvKeoihHQTSVaCIGv99e6q6IcDH9KmBlJhOrElUH0OgvG8Ai2m8oCIio2CsiFMQfLMQDxp2Os50t67ZJEgSjcRsiHLkzkIHjQC5T3L+2EfJa935p3sq6NzqY3LPSA8EyTQOAeKZmwj4nMfEVSCvHe5hg4+s60TEXY//xvQC7UR/YrAbY68FLJFp1oJDMRY3FdG6QZdx2gO2lkOdQWJM/gB4w22XyxjvwCp7pMiH+R8j1ULZFObOt7RaxfB8EDFq+Imv83OvL2jcwybWQYKT67EX5uUGfUwPfsjnbH9XDJQ8/6H0HlmjeQZhDCRODZUNe0mCUG3jg4GowPtIbdweUjMWisX0D8opOjv0dBfEnYvblH6tO6srhRzTyaydbumzT0o6g/e0UZxHbmQoU/kkwG8/ELGy0bLJwUVGaHJJhwVKp9ZS8esKE22Dx6Z8e3o9uoK/raFY5/HYmehS8z4F5fr2CXDmYpnnonueECfvg1JzPhNxPIR2zEn6DXTdA8hEMiDOE+bZyyxNc7bA5Cva/ZUxa2B45E9sN3wJQpjuz0fdRsYS9Hs/4BXDy7chI3yNcdcwux37VbRAmLT+CRbmd6CPL+mP2oaKoR0skVt/x9XABWO/qraWMJe8hGEwwZF4fDObf0D7syzufsFBcgi30fZMRF4ZxodLD5210YFlh79CXUmhS/oGN0mkZkQj6Iek2WFLTivaMFYfwjbEa91fDlRHDw05WxLSDsj6EkcWzhwR5WQneoJd/UWCpjBQwYfE9B0vrDNfSsajsUiZ6gIjU2iyl0/diQANs5THwmC/ER3X37P4EeD+ZNfipnJfKDt6PCZmTYZFdiPqfjURsTkOiY+shya/YyEkAyTNB/xT8SK2fosTHs+ueFqwP1rt+MEJ1qaeoutwHMNKjkHcp/Fls7FGg1z3Tb+j2yOrVqVeDjP5N+8zW1vaI4VXQ5yWouAZ+j3YbHWdnV7W9jA2dKkQPwessbgOERjqrXu6xzB/R/y64zXF8+5tY8z9ESpvrwf81VzhBJV6iX6Px4Qc2a4NkQF7GuSxrybc8d6I9307pK8I95E+3UUifiXwvw/IE+ZQT4kREeBZlXwXqIH9ASZUWI3eRTx1I6+ztjx5MPpcezFTH3C+i32ILjxT4CgEbxmHKAr9HbOTYrurkdRsdgLQP3+ykqBsBhuS2M3nkpBdc269GBmVfrpvcQYZwcl+wvMeyLRos05WtxiBdv379Bixxv1nfMOU0K3QOCV1FxHcxkS6fMfhJO78KqV7DSJOnhOge0M61wudiaf8J8FgMQIqnl5FU4Qt1dcfj679rIu75iYToAMzUaIle6HftmWvXrl+tdJmMCgZcazswaM4SonPYyDkWuhRixPk03D+yNr7uRMjbAf+jtWtfftFPLnFNm4qIjnkn/DXj7S1J8F6TCpr2jmM7F89/sibmnkFC5xPL15Glk+8z6EfPIfwr3JeL8LWwEM7pirnnblkyT9OR5e+sJO/H4D433xvmi9zqhE5G/gUDUiNu8pF8Xqn4gOUUUGoouT/q/i5Fb8Qjk5XIvWlKU5WMB9FFJfmjNF3+3a2yy33KnUtGzrfW6FjMFClUh5t0n8kQ5gXchL3Jrw5Nq+pPArDyCgxGNwLwNi9d8K8AzZNhiX9F0L7M9Aiy9W/9n0Wbr0b4HhbuIDZnafsqyGa/E4n8QFeF9lQZCnkjpqO2JoVFOXw0TfMKlWUxN+cUIqL/DwAA//8PN64JAAAABklEQVQDAC4fJqtjL65qAAAAAElFTkSuQmCC" alt="CodeSparrow" width="331" height="93">
  <span class="om-sample" id="dataMode">Attendance map</span>
  <svg class="om-stage" id="officeMap" viewBox="0 -35 1320 860" aria-label="Office floor plan with IT, SEO, Calling, owner cabin and kitchen"><defs id="mapDefs"></defs><g id="camera"><g id="officeWorld"><g id="architecture"></g><g id="seats"></g></g></g></svg>
  <div class="om-hint"><span data-icon="pointer"></span><span>3D office · Click a desk · Drag to move</span></div>
  <div class="om-controls" aria-label="Map controls"><button id="viewToggle" aria-label="Switch to top view" title="Switch to top view" aria-pressed="true">3D</button><i class="om-control-separator"></i><button id="zoomOut" aria-label="Zoom out" title="Zoom out" data-icon="minus"></button><span class="om-zoom-label" id="zoomLabel">100%</span><button id="zoomIn" aria-label="Zoom in" title="Zoom in" data-icon="plus"></button><i class="om-control-separator"></i><button id="motionToggle" aria-label="Pause animations" aria-pressed="false" title="Pause animations" data-icon="motion"></button><button id="fitBtn" aria-label="Fit entire office" title="Fit entire office" data-icon="fit"></button><button id="fullscreenBtn" aria-label="Enter fullscreen" title="Fullscreen" data-icon="expand"></button></div>
  <div class="om-toast" id="toast" role="status" aria-live="polite"></div>
 </div>
 <dialog class="om-detail" id="deskDialog" aria-label="Desk details"><div class="om-detail-head"><span id="detailTitle">Desk details</span><button class="om-close" id="closeDetails" aria-label="Close details" data-icon="close"></button></div><div id="detailContent"></div></dialog>
</section>
<script>(()=>{function $t(e,t){e.indexOf(t)===-1&&e.push(t)}function Z(e,t){let r=e.indexOf(t);r>-1&&e.splice(r,1)}var F=(e,t,r)=>r>t?t:r<e?e:r;var W=()=>{},k=()=>{};var K={};var _e=e=>/^-?(?:\d+(?:\.\d+)?|\.\d+)$/u.test(e);var ce=e=>typeof e=="object"&&e!==null;var ze=e=>/^0[^.\s]+$/u.test(e);function je(e){let t;return()=>(t===void 0&&(t=e()),t)}var _=e=>e;var ue=(...e)=>e.reduce((t,r)=>o=>r(t(o)));var de=(e,t,r)=>{let o=t-e;return o?(r-e)/o:1};var Ee=class{constructor(){this.subscriptions=[]}add(t){return $t(this.subscriptions,t),()=>this.remove(t)}remove(t){Z(this.subscriptions,t)}notify(t,r,o){let n=this.subscriptions.length;if(n)if(n===1)this.subscriptions[0](t,r,o);else for(let i=0;i<n;i++){let s=this.subscriptions[i];s&&s(t,r,o)}}getSize(){return this.subscriptions.length}clear(){this.subscriptions.length=0}};var R=e=>e*1e3,I=e=>e/1e3;var $e=(e,t)=>t?e*(1e3/t):0;var Hr=(e,t,r)=>{let o=t-e;return((r-e)%o+o)%o+e};var Jr=(e,t,r)=>(((1-3*r+3*t)*e+(3*r-6*t))*e+3*t)*e,En=1e-7,Dn=12;function wn(e,t,r,o,n){let i,s,a=0;do s=t+(r-t)/2,i=Jr(s,o,n)-e,i>0?r=s:t=s;while(Math.abs(i)>En&&++a<Dn);return s}function ne(e,t,r,o){if(e===t&&r===o)return _;let n=i=>wn(i,0,1,e,r);return i=>i===0||i===1?i:Jr(n(i),t,o)}var ht=e=>t=>t<=.5?e(2*t)/2:(2-e(2*(1-t)))/2;var he=e=>t=>1-e(1-t);var gt=ne(.33,1.53,.69,.99),De=he(gt),Ue=ht(De);var qe=e=>e>=1?1:(e*=2)<1?.5*De(e):.5*(2-Math.pow(2,-10*(e-1)));var Ye=e=>1-Math.sin(Math.acos(e)),Ut=he(Ye),Xe=ht(Ye);var qt=ne(.42,0,1,1),Yt=ne(0,0,.58,1),we=ne(.42,0,.58,1);var Ze=e=>Array.isArray(e)&&typeof e[0]!="number";function He(e,t){return Ze(e)?e[Hr(0,e.length,t)]:e}var Je=e=>Array.isArray(e)&&typeof e[0]=="number";var Qr={linear:_,easeIn:qt,easeInOut:we,easeOut:Yt,circIn:Ye,circInOut:Xe,circOut:Ut,backIn:De,backInOut:Ue,backOut:gt,anticipate:qe},Cn=e=>typeof e=="string",Ce=e=>{if(Je(e)){k(e.length===4,"Cubic bezier arrays must contain four numerical values.","cubic-bezier-length");let[t,r,o,n]=e;return ne(t,r,o,n)}else if(Cn(e))return k(Qr[e]!==void 0,`Invalid easing type '${e}'`,"invalid-easing-type"),Qr[e];return e};var Qe=["setup","read","resolveKeyframes","preUpdate","update","preRender","render","postRender"];function eo(e){let t=new Set,r=new Set,o=!1,n=!1,i=new Set,s={delta:0,timestamp:0,isProcessing:!1};function a(l){i.has(l)&&(r.add(l),e()),l(s)}let m={schedule:(l,f=!1,p=!1)=>{let T=p&&o?t:r;return f&&i.add(l),T.add(l),l},cancel:l=>{r.delete(l),i.delete(l)},process:l=>{if(s=l,o){n=!0;return}o=!0;let f=t;t=r,r=f,t.forEach(a),t.clear(),o=!1,n&&(n=!1,m.process(l))}};return m}var Pn=40;function to(e,t){let r=!1,o=!0,n={delta:0,timestamp:0,isProcessing:!1},i=()=>r=!0,s=Qe.reduce((S,y)=>(S[y]=eo(i),S),{}),{setup:a,read:m,resolveKeyframes:l,preUpdate:f,update:p,preRender:g,render:T,postRender:v}=s,b=()=>{let S=K.useManualTiming,y=S?n.timestamp:performance.now();r=!1,S||(n.delta=o?1e3/60:Math.max(Math.min(y-n.timestamp,Pn),1)),n.timestamp=y,n.isProcessing=!0,a.process(n),m.process(n),l.process(n),f.process(n),p.process(n),g.process(n),T.process(n),v.process(n),n.isProcessing=!1,r&&t&&(o=!1,e(b))},h=()=>{r=!0,o=!0,n.isProcessing||e(b)};return{schedule:Qe.reduce((S,y)=>{let E=s[y];return S[y]=(w,c=!1,d=!1)=>(r||h(),E.schedule(w,c,d)),S},{}),cancel:S=>{for(let y=0;y<Qe.length;y++)s[Qe[y]].cancel(S)},state:n,steps:s}}var{schedule:B,cancel:ro,state:H,steps:Ea}=to(typeof requestAnimationFrame<"u"?requestAnimationFrame:_,!0);var xt;function On(){xt=void 0}var C={now:()=>(xt===void 0&&C.set(H.isProcessing||K.useManualTiming?H.timestamp:performance.now()),xt),set:e=>{xt=e,queueMicrotask(On)}};var $=e=>Math.round(e*1e5)/1e5;var Fn=e=>t=>typeof t=="string"&&t.startsWith(e);var Rn=Fn("var(--"),Pe=e=>Rn(e)?In.test(e.split("/*")[0].trim()):!1,In=/var\(--(?:[\w-]+\s*|[\w-]+\s*,(?:\s*[^)(\s]|\s*\((?:[^)(]|\([^)(]*\))*\))+\s*)\)$/iu;function Xt(e){return typeof e!="string"?!1:e.split("/*")[0].includes("var(--")}var U={test:e=>typeof e=="number",parse:parseFloat,transform:e=>e},J={...U,transform:e=>F(0,1,e)},et={...U,default:1};var Oe=/-?(?:\d+(?:\.\d+)?|\.\d+)/gu;function oo(e){return e==null}var no=/^(?:#[\da-f]{3,8}|(?:rgb|hsl)a?\((?:-?[\d.]+%?[,\s]+){2}-?[\d.]+%?\s*(?:[,/]\s*)?(?:\b\d+(?:\.\d+)?|\.\d+)?%?\))$/iu;var Fe=(e,t)=>r=>!!(typeof r=="string"&&no.test(r)&&r.startsWith(e)||t&&!oo(r)&&Object.prototype.hasOwnProperty.call(r,t)),yt=(e,t,r)=>o=>{if(typeof o!="string")return o;let[n,i,s,a]=o.match(Oe);return{[e]:parseFloat(n),[t]:parseFloat(i),[r]:parseFloat(s),alpha:a!==void 0?parseFloat(a):1}};var Bn=e=>F(0,255,e),Zt={...U,transform:e=>Math.round(Bn(e))},q={test:Fe("rgb","red"),parse:yt("red","green","blue"),transform:({red:e,green:t,blue:r,alpha:o=1})=>"rgba("+Zt.transform(e)+", "+Zt.transform(t)+", "+Zt.transform(r)+", "+$(J.transform(o))+")"};function kn(e){let t="",r="",o="",n="";return e.length>5?(t=e.substring(1,3),r=e.substring(3,5),o=e.substring(5,7),n=e.substring(7,9)):(t=e.substring(1,2),r=e.substring(2,3),o=e.substring(3,4),n=e.substring(4,5),t+=t,r+=r,o+=o,n+=n),{red:parseInt(t,16),green:parseInt(r,16),blue:parseInt(o,16),alpha:n?parseInt(n,16)/255:1}}var tt={test:Fe("#"),parse:kn,transform:q.transform};var rt=e=>({test:t=>typeof t=="string"&&t.endsWith(e)&&t.split(" ").length===1,parse:parseFloat,transform:t=>`${t}${e}`}),z=rt("deg"),ie=rt("%"),u=rt("px"),io=rt("vh"),so=rt("vw"),Ht={...ie,parse:e=>ie.parse(e)/100,transform:e=>ie.transform(e*100)};var se={test:Fe("hsl","hue"),parse:yt("hue","saturation","lightness"),transform:({hue:e,saturation:t,lightness:r,alpha:o=1})=>"hsla("+Math.round(e)+", "+ie.transform($(t))+", "+ie.transform($(r))+", "+$(J.transform(o))+")"};var D={test:e=>q.test(e)||tt.test(e)||se.test(e),parse:e=>q.test(e)?q.parse(e):se.test(e)?se.parse(e):tt.parse(e),transform:e=>typeof e=="string"?e:e.hasOwnProperty("red")?q.transform(e):se.transform(e),getAnimatableNone:e=>{let t=D.parse(e);return t.alpha=0,D.transform(t)}};var ao=/(?:#[\da-f]{3,8}|(?:rgb|hsl)a?\((?:-?[\d.]+%?[,\s]+){2}-?[\d.]+%?\s*(?:[,/]\s*)?(?:\b\d+(?:\.\d+)?|\.\d+)?%?\))/giu;var fo=new RegExp(Oe.source),lo=new RegExp(ao.source,"i");function Nn(e){return isNaN(e)&&typeof e=="string"&&(fo.test(e)||lo.test(e))}var po="number",co="color",Kn="var",Gn="var(",mo="${}",Ln=/var\s*\(\s*--(?:[\w-]+\s*|[\w-]+\s*,(?:\s*[^)(\s]|\s*\((?:[^)(]|\([^)(]*\))*\))+\s*)\)|#[\da-f]{3,8}|(?:rgb|hsl)a?\((?:-?[\d.]+%?[,\s]+){2}-?[\d.]+%?\s*(?:[,/]\s*)?(?:\b\d+(?:\.\d+)?|\.\d+)?%?\)|-?(?:\d+(?:\.\d+)?|\.\d+)/giu;function uo(e){let t=e.toString();return fo.test(t)||lo.test(t)}function Re(e){let t=e.toString(),r=[],o={color:[],number:[],var:[]},n=[],i=0,a=t.replace(Ln,m=>(D.test(m)?(o.color.push(i),n.push(co),r.push(D.parse(m))):m.startsWith(Gn)?(o.var.push(i),n.push(Kn),r.push(m)):(o.number.push(i),n.push(po),r.push(parseFloat(m))),++i,mo)).split(mo);return{values:r,split:a,indexes:o,types:n}}function Wn(e){return Re(e).values}function ho({split:e,types:t}){let r=e.length;return o=>{let n="";for(let i=0;i<r;i++)if(n+=e[i],o[i]!==void 0){let s=t[i];s===po?n+=$(o[i]):s===co?n+=D.transform(o[i]):n+=o[i]}return n}}function _n(e){return ho(Re(e))}var zn=e=>typeof e=="number"?0:D.test(e)?D.getAnimatableNone(e):e,jn=(e,t)=>typeof e=="number"?t?.trim().endsWith("/")?e:0:zn(e);function $n(e){let t=Re(e);return ho(t)(t.values.map((o,n)=>jn(o,t.split[n])))}var N={test:Nn,parse:Wn,createTransformer:_n,getAnimatableNone:$n};function Jt(e,t,r){return r<0&&(r+=1),r>1&&(r-=1),r<1/6?e+(t-e)*6*r:r<1/2?t:r<2/3?e+(t-e)*(2/3-r)*6:e}function go({hue:e,saturation:t,lightness:r,alpha:o}){e/=360,t/=100,r/=100;let n=0,i=0,s=0;if(!t)n=i=s=r;else{let a=r<.5?r*(1+t):r+t-r*t,m=2*r-a;n=Jt(m,a,e+1/3),i=Jt(m,a,e),s=Jt(m,a,e-1/3)}return{red:Math.round(n*255),green:Math.round(i*255),blue:Math.round(s*255),alpha:o}}function Ie(e,t){return r=>r>0?t:e}var G=(e,t,r)=>e+(t-e)*r;var Qt=(e,t,r)=>{let o=e*e,n=r*(t*t-o)+o;return n<0?0:Math.sqrt(n)},Un=[tt,q,se],qn=e=>Un.find(t=>t.test(e));function xo(e){let t=qn(e);if(!t)return W(!1,`'${e}' is not an animatable color. Use the equivalent color code instead.`,"color-not-animatable"),!1;let r=t.parse(e);return t===se&&(r=go(r)),r}var er=(e,t)=>{let r=xo(e),o=xo(t);if(!r||!o)return Ie(e,t);let n={...r};return i=>(n.red=Qt(r.red,o.red,i),n.green=Qt(r.green,o.green,i),n.blue=Qt(r.blue,o.blue,i),n.alpha=G(r.alpha,o.alpha,i),q.transform(n))};var bt=new Set(["none","hidden"]);function yo(e,t){return bt.has(e)?r=>r<=0?e:t:r=>r>=1?t:e}function Yn(e,t){return r=>G(e,t,r)}function Tt(e){return typeof e=="number"?Yn:typeof e=="string"?Pe(e)?Ie:D.test(e)?er:Hn:Array.isArray(e)?bo:typeof e=="object"?D.test(e)?er:Xn:Ie}function bo(e,t){let r=[...e],o=r.length,n=e.map((i,s)=>Tt(i)(i,t[s]));return i=>{for(let s=0;s<o;s++)r[s]=n[s](i);return r}}function Xn(e,t){let r={...e,...t},o={};for(let n in r)e[n]!==void 0&&t[n]!==void 0&&(o[n]=Tt(e[n])(e[n],t[n]));return n=>{for(let i in o)r[i]=o[i](n);return r}}function Zn(e,t){let r=[],o={color:0,var:0,number:0};for(let n=0;n<t.values.length;n++){let i=t.types[n],s=e.indexes[i][o[i]],a=e.values[s]??0;r[n]=a,o[i]++}return r}var Hn=(e,t)=>{let r=N.createTransformer(t),o=Re(e),n=Re(t);return o.indexes.var.length===n.indexes.var.length&&o.indexes.color.length===n.indexes.color.length&&o.indexes.number.length>=n.indexes.number.length?bt.has(e)&&!n.values.length||bt.has(t)&&!o.values.length?yo(e,t):ue(bo(Zn(o,n),n.values),r):(W(!0,`Complex values '${e}' and '${t}' too different to mix. Ensure all colors are of the same type, and that each contains the same quantity of number and color values. Falling back to instant transition.`,"complex-values-different"),Ie(e,t))};var To=/^(-?(?:\d+(?:\.\d*)?|\.\d+))([a-z%]*)$/iu;function Jn(e,t){let r=To.exec(e);if(!r)return;let o=To.exec(t);if(!o||r[2]!==o[2])return;let n=r[2],i=parseFloat(r[1]),s=parseFloat(o[1]);return a=>$(G(i,s,a))+n}function Be(e,t,r){if(typeof e=="number"&&typeof t=="number"&&typeof r=="number")return G(e,t,r);if(typeof e=="string"&&typeof t=="string"){let n=Jn(e,t);if(n)return n}return Tt(e)(e,t)}var So=e=>{let t=({timestamp:r})=>e(r);return{start:(r=!0)=>B.update(t,r),stop:()=>ro(t),now:()=>H.isProcessing?H.timestamp:C.now()}};var St=(e,t,r=10)=>{let o="",n=Math.max(Math.round(t/r),2);for(let i=0;i<n;i++)o+=Math.round(e(i/(n-1))*1e4)/1e4+", ";return`linear(${o.substring(0,o.length-2)})`};function ke(e,t=50,r=2e4,o){let n=0,i=e.next(n);for(o?.push(i.value);!i.done&&n<r;)n+=t,i=e.next(n),o?.push(i.value);return n>=r?1/0:n}function ot(e,t=100,r){let o=r({...e,keyframes:[0,t]}),n=Math.min(ke(o),2e4);return{type:"keyframes",ease:i=>o.next(n*i).value/t,duration:I(n)}}var P={stiffness:100,damping:10,mass:1,duration:800,bounce:.3,visualDuration:.3,restSpeed:{granular:.01,default:2},restDelta:{granular:.005,default:.5},minDuration:.01,maxDuration:10,minDamping:.05,maxDamping:1};function nr(e,t){return e*Math.sqrt(1-t*t)}var Qn=12;function ei(e,t,r){let o=r;for(let n=1;n<Qn;n++)o=o-e(o)/t(o);return o}var rr=.001;function ti({duration:e=P.duration,bounce:t=P.bounce}){let r,o;W(e<=R(P.maxDuration),"Spring duration must be 10 seconds or less","spring-duration-limit");let n=1-t;n=F(P.minDamping,P.maxDamping,n),e=F(P.minDuration,P.maxDuration,I(e)),n<1?(r=m=>{let l=m*n,f=l*e,p=nr(m,n),g=Math.exp(-f);return rr-l/p*g},o=m=>{let f=m*n*e,p=n*n*m*m*e,g=Math.exp(-f),T=nr(m*m,n);return(-r(m)+rr>0?-1:1)*-p*g/T}):(r=m=>{let l=Math.exp(-m*e),f=m*e+1;return-rr+l*f},o=m=>{let l=Math.exp(-m*e),f=-m*(e*e);return l*f});let i=5/e,s=ei(r,o,i),a=s*s;return{stiffness:a,damping:n*2*Math.sqrt(a),duration:R(e)}}var ir=(e,t)=>(t?e>=0:e>0)&&e<1/0;function or(e,t){if(ir(e,t))return e}function ri(e){let t=or(e.stiffness),r=or(e.damping,!0),o=or(e.mass),n={...e,stiffness:t??P.stiffness,damping:r??P.damping,mass:o??P.mass,isResolvedFromDuration:!1,isTimeDefined:(t??r??o)===void 0&&(e.duration!==void 0||e.bounce!==void 0)};if(n.isTimeDefined){if(e.visualDuration){let i=2*Math.PI/(e.visualDuration*1.2);n.stiffness=i*i,n.damping=2*F(.05,1,1-(e.bounce||0))*Math.sqrt(n.stiffness)}else Object.assign(n,ti(n)),n.isResolvedFromDuration=!0;(!ir(n.stiffness)||!ir(n.damping,!0))&&(n.stiffness=P.stiffness,n.damping=P.damping)}return n}function Q(e=P.visualDuration,t=P.bounce){let r=typeof e!="object"?{visualDuration:e,keyframes:[0,1],bounce:t}:e,o=r.keyframes[0],n=r.keyframes[r.keyframes.length-1],i={done:!1,value:o},{stiffness:s,damping:a,mass:m,duration:l,isResolvedFromDuration:f,isTimeDefined:p}=ri({...r}),g=c=>p?0:-I(c),T=a/(2*Math.sqrt(s*m)),v=I(Math.sqrt(s/m)),b=T*v,h={target:n,delta:n-o,velocity:g(r.velocity||0)||0,restSpeed:0,restDelta:0},A=()=>{let c=Math.abs(h.delta)<5;h.restSpeed=r.restSpeed||(c?P.restSpeed.granular:P.restSpeed.default),h.restDelta=r.restDelta||(c?P.restDelta.granular:P.restDelta.default)};A();let M,S,y;if(T<1){let c=nr(v,T),d={A:0,sinC:0,cosC:0,t:-1,env:0,sin:0,cos:0};y=()=>{d.A=(h.velocity+b*h.delta)/c,d.sinC=b*d.A+h.delta*c,d.cosC=b*h.delta-d.A*c};let x=V=>{V!==d.t&&(d.t=V,d.env=Math.exp(-b*V),d.sin=Math.sin(c*V),d.cos=Math.cos(c*V))};M=V=>(x(V),h.target-d.env*(d.A*d.sin+h.delta*d.cos)),S=V=>(x(V),d.env*(d.sinC*d.sin+d.cosC*d.cos))}else if(T===1){M=d=>h.target-Math.exp(-v*d)*(h.delta+(h.velocity+v*h.delta)*d);let c={C:0};y=()=>{c.C=h.velocity+v*h.delta},S=d=>Math.exp(-v*d)*(v*c.C*d-h.velocity)}else{let c=v*Math.sqrt(T*T-1);M=x=>{let V=Math.exp(-b*x),O=Math.min(c*x,300);return h.target-V*((h.velocity+b*h.delta)*Math.sinh(O)+c*h.delta*Math.cosh(O))/c};let d={P:0,sinh:0,cosh:0};y=()=>{d.P=(h.velocity+b*h.delta)/c,d.sinh=b*d.P-h.delta*c,d.cosh=b*h.delta-d.P*c},S=x=>{let V=Math.exp(-b*x),O=Math.min(c*x,300);return V*(d.sinh*Math.sinh(O)+d.cosh*Math.cosh(O))}}y();let E=f&&l||null,w={calculatedDuration:E,retarget:(c,d)=>{h.target=c[c.length-1],h.delta=h.target-c[0],h.velocity=g(d),r.restSpeed&&r.restDelta||A(),w.calculatedDuration=E,i.done=!1,y()},velocity:c=>R(S(c)),next:c=>{let d=M(c);if(f)i.done=c>=l;else{let x=R(S(c));i.done=Math.abs(x)<=h.restSpeed&&Math.abs(h.target-d)<=h.restDelta}return i.value=i.done?h.target:d,i},toString:()=>{let c=Math.min(ke(w),2e4),d=St(x=>w.next(c*x).value,c,30);return c+"ms "+d},toTransition:()=>{}};return w}Q.applyToOptions=e=>{let t=ot(e,100,Q);return e.ease=t.ease,e.duration=R(t.duration),e.type="keyframes",e};function nt({keyframes:e,velocity:t=0,power:r=.8,timeConstant:o=325,bounceDamping:n=10,bounceStiffness:i=500,modifyTarget:s,min:a,max:m,restDelta:l=.5,restSpeed:f}){let p=e[0],g={done:!1,value:p},T=c=>c<a||c>m,v=c=>a===void 0?m:m===void 0||Math.abs(a-c)<Math.abs(m-c)?a:m,b=r*t,h=p+b,A=s===void 0?h:s(h);A!==h&&(b=A-p);let M=c=>-b*Math.exp(-c/o),S=c=>{let d=M(c);g.done=Math.abs(d)<=l,g.value=g.done?A:A+d},y,E,w=c=>{T(g.value)&&(y=c,E=Q({keyframes:[g.value,v(g.value)],velocity:-M(c)/o*1e3,damping:n,stiffness:i,restDelta:l,restSpeed:f}))};return w(0),{calculatedDuration:null,next:c=>{let d=!1;return!E&&y===void 0&&(d=!0,S(c),w(c)),y!==void 0&&c>=y?E.next(c-y):(!d&&S(c),g)}}}function oi(e,t,r){let o=[],n=r||K.mix||Be,i=e.length-1;for(let s=0;s<i;s++){let a=n(e[s],e[s+1]);if(t){let m=Array.isArray(t)?t[s]||_:t;a=ue(m,a)}o.push(a)}return o}function vo(e,t,{clamp:r=!0,ease:o,mixer:n}={}){let i=e.length;if(k(i===t.length,"Both input and output ranges must be the same length","range-length"),i===1)return()=>t[0];if(i===2&&t[0]===t[1])return()=>t[1];let s=e[0]===e[1];e[0]>e[i-1]&&(e=[...e].reverse(),t=[...t].reverse());let a=oi(t,o,n),m=a.length,l=f=>{if(s&&f<e[0])return t[0];let p=0;if(m>1)for(;p<e.length-2&&!(f<e[p+1]);p++);let g=de(e[p],e[p+1],f);return a[p](g)};return r?f=>l(F(e[0],e[i-1],f)):l}function it(e,t){let r=e[e.length-1];for(let o=1;o<=t;o++){let n=de(0,t,o);e.push(G(r,1,n))}}function st(e){let t=[0];return it(t,e.length-1),t}function Vo(e,t){return e.map(r=>r*t)}function ni(e,t){return e.map(()=>t||we).splice(0,e.length-1)}function ge({duration:e=300,keyframes:t,times:r,ease:o="easeInOut"}){let n=Ze(o)?o.map(Ce):Ce(o)||we,i={done:!1,value:t[0]};if(t.length===2&&!Array.isArray(n)&&(!r||r.length!==2||r[0]===0&&r[1]===1)){let[m,l]=t,f=m===l?void 0:(K.mix||Be)(m,l);return{calculatedDuration:e,next:p=>(i.value=f?f(n(e>0?F(0,1,p/e):1)):l,i.done=p>=e,i)}}let s=Vo(r&&r.length===t.length?r:st(t),e),a=vo(s,t,{ease:Array.isArray(n)?n:ni(t,n)});return{calculatedDuration:e,next:m=>(i.value=a(m),i.done=m>=e,i)}}var ii=5;function si(e,t,r){let o=Math.max(t-ii,0);return $e(r-e(o),t-o)}function Ao(e,t,r=0){return t<=0?r:e.velocity?e.velocity(t):si(o=>e.next(o).value,t,e.next(t).value)}var ai=e=>e!==null;function ae(e,{repeat:t,repeatType:r="loop"},o,n=1){let i=e.filter(ai),a=n<0||t&&r!=="loop"&&t%2===1?0:i.length-1;return!a||o===void 0?i[a]:o}var mi={decay:nt,inertia:nt,tween:ge,keyframes:ge,spring:Q};function vt(e){typeof e.type=="string"&&(e.type=mi[e.type])}function fi(e,t){return{kind:e,animation:t,timestamp:C.now(),frameTimestamp:H.timestamp,frameIsProcessing:H.isProcessing}}function Vt(e,t,r){let o=globalThis.__MOTION_INSPECT__;if(o)try{o({...fi("animation-start",e),options:r?{...t,...r}:t})}catch{}}var me=class{constructor(){this.isResolved=!1}get finished(){return this._finished||(this._finished=this.isResolved?Promise.resolve():new Promise(t=>{this._resolve=t})),this._finished}updateFinished(){this._finished=this._resolve=void 0,this.isResolved=!1}notifyFinished(){this.isResolved=!0,this._resolve?.()}then(t,r){return this.finished.then(t,r)}};var li=e=>e/100,ee=class extends me{constructor(t){super(),this.state="idle",this.startTime=null,this.isStopped=!1,this.currentTime=0,this.holdTime=null,this.playbackSpeed=1,this.delayState={done:!1,value:void 0},this.stop=()=>{let{motionValue:r}=this.options;r&&r.updatedAt!==C.now()&&this.tick(C.now()),this.isStopped=!0,this.state!=="idle"&&(this.teardown(),this.options.onStop?.())},this.options=t,this.initAnimation(),this.play(),t.autoplay===!1&&this.pause(),Vt(this,this.options)}initAnimation(){let{options:t}=this;vt(t);let{type:r=ge,repeat:o=0,repeatDelay:n=0,repeatType:i,velocity:s=0}=t,{keyframes:a}=t,m=r||ge;m!==ge&&typeof a[0]!="number"&&(this.mixKeyframes=ue(li,Be(a[0],a[1])),a=[0,100]);let l=m(a===t.keyframes?t:{...t,keyframes:a});i==="mirror"&&(this.mirroredGenerator=m({...t,keyframes:[...a].reverse(),velocity:-s})),l.calculatedDuration===null&&(l.calculatedDuration=ke(l));let{calculatedDuration:f}=l;this.calculatedDuration=f,this.resolvedDuration=f+n,this.totalDuration=this.resolvedDuration*(o+1)-n,this.generator=l}updateTime(t){let r=Math.round(t-this.startTime)*this.playbackSpeed;this.holdTime!==null?this.currentTime=this.holdTime:this.currentTime=r}tick(t,r=!1){let{generator:o,totalDuration:n,mixKeyframes:i,mirroredGenerator:s,resolvedDuration:a,calculatedDuration:m}=this;if(this.startTime===null)return o.next(0);let{delay:l=0,keyframes:f,repeat:p,repeatType:g,repeatDelay:T,type:v,onUpdate:b,finalKeyframe:h}=this.options;this.speed>0?this.startTime=Math.min(this.startTime,t):this.speed<0&&(this.startTime=Math.min(t-n/this.speed,this.startTime)),r?this.currentTime=t:this.updateTime(t);let A=this.currentTime-l*(this.playbackSpeed>=0?1:-1),M=this.playbackSpeed>=0?A<0:A>n;this.currentTime=Math.max(A,0),this.state==="finished"&&this.holdTime===null&&(this.currentTime=n);let S=this.currentTime,y=o;if(p){let d=Math.min(this.currentTime,n)/a,x=Math.floor(d),V=d%1;!V&&d>=1&&(V=1),V===1&&x--,x=Math.min(x,p+1),x%2&&(g==="reverse"?(V=1-V,T&&(V-=T/a)):g==="mirror"&&(y=s)),S=F(0,1,V)*a}let E;M?(this.delayState.value=f[0],E=this.delayState):E=y.next(S),i&&!M&&(E.value=i(E.value));let{done:w}=E;!M&&m!==null&&(w=this.playbackSpeed>=0?this.currentTime>=n:this.currentTime<=0);let c=this.holdTime===null&&(this.state==="finished"||this.state==="running"&&w);return c&&v!==nt&&(E.value=ae(f,this.options,h,this.speed)),b&&b(E.value),c&&this.finish(),E}then(t,r){return this.finished.then(t,r)}get duration(){return I(this.calculatedDuration)}get iterationDuration(){let{delay:t=0}=this.options||{};return this.duration+I(t)}get time(){return I(this.currentTime)}set time(t){t=R(t),this.currentTime=t,this.startTime===null||this.holdTime!==null||this.playbackSpeed===0?this.holdTime=t:this.driver&&(this.startTime=this.driver.now()-t/this.playbackSpeed),this.driver?this.driver.start(!1):(this.startTime=0,this.state="paused",this.holdTime=t,this.tick(t))}getGeneratorVelocity(){return Ao(this.generator,this.currentTime,this.options.velocity)}get speed(){return this.playbackSpeed}set speed(t){let r=this.playbackSpeed!==t;r&&this.driver&&this.updateTime(C.now()),this.playbackSpeed=t,r&&this.driver&&(this.time=I(this.currentTime))}play(){if(this.isStopped)return;let{driver:t=So,startTime:r}=this.options;this.driver||(this.driver=t(n=>this.tick(n))),this.options.onPlay?.();let o=this.driver.now();this.state==="finished"?(this.updateFinished(),this.startTime=o):this.holdTime!==null?this.startTime=o-this.holdTime:this.startTime||(this.startTime=r??o),this.state==="finished"&&this.speed<0&&(this.startTime+=this.calculatedDuration),this.holdTime=null,this.state="running",this.driver.start()}pause(){this.state="paused",this.updateTime(C.now()),this.holdTime=this.currentTime}complete(){this.state!=="running"&&this.play(),this.state="finished",this.holdTime=null}finish(){this.notifyFinished(),this.teardown(),this.state="finished",this.options.onComplete?.()}cancel(){this.holdTime=null,this.startTime=0,this.tick(0),this.teardown(),this.options.onCancel?.()}teardown(){this.state="idle",this.stopDriver(),this.startTime=this.holdTime=null}stopDriver(){this.driver&&(this.driver.stop(),this.driver=void 0)}sample(t){return this.startTime=0,this.tick(t,!0)}attachTimeline(t){return this.options.allowFlatten&&(this.options.type="keyframes",this.options.ease="linear",this.initAnimation()),this.driver?.stop(),t.observe(this)}};var pi=new Set(["brightness","contrast","saturate","opacity"]);function ci(e){let[t,r]=e.slice(0,-1).split("(");if(t==="drop-shadow")return e;let[o]=r.match(Oe)||[];if(!o)return e;let n=r.replace(o,""),i=pi.has(t)?1:0;return o!==r&&(i*=100),t+"("+i+n+")"}var ui=/\b([a-z-]*)\(.*?\)/gu,at={...N,getAnimatableNone:e=>{let t=e.match(ui);return t?t.map(ci).join(" "):e}};var mt={...N,getAnimatableNone:e=>{let t=N.parse(e);return N.createTransformer(e)(t.map(o=>typeof o=="number"?0:typeof o=="object"?{...o,alpha:1}:o))}};var sr={...U,transform:Math.round};var ft={rotate:z,pathRotation:z,rotateX:z,rotateY:z,rotateZ:z,scale:et,scaleX:et,scaleY:et,scaleZ:et,skew:z,skewX:z,skewY:z,distance:u,translateX:u,translateY:u,translateZ:u,x:u,y:u,z:u,perspective:u,transformPerspective:u,opacity:J,originX:Ht,originY:Ht,originZ:u};var j={borderWidth:u,borderTopWidth:u,borderRightWidth:u,borderBottomWidth:u,borderLeftWidth:u,borderRadius:u,borderTopLeftRadius:u,borderTopRightRadius:u,borderBottomRightRadius:u,borderBottomLeftRadius:u,width:u,maxWidth:u,height:u,maxHeight:u,top:u,right:u,bottom:u,left:u,inset:u,insetBlock:u,insetBlockStart:u,insetBlockEnd:u,insetInline:u,insetInlineStart:u,insetInlineEnd:u,padding:u,paddingTop:u,paddingRight:u,paddingBottom:u,paddingLeft:u,paddingBlock:u,paddingBlockStart:u,paddingBlockEnd:u,paddingInline:u,paddingInlineStart:u,paddingInlineEnd:u,margin:u,marginTop:u,marginRight:u,marginBottom:u,marginLeft:u,marginBlock:u,marginBlockStart:u,marginBlockEnd:u,marginInline:u,marginInlineStart:u,marginInlineEnd:u,fontSize:u,backgroundPositionX:u,backgroundPositionY:u,...ft,zIndex:sr,fillOpacity:J,strokeOpacity:J,numOctaves:sr};var di={...j,color:D,backgroundColor:D,outlineColor:D,fill:D,stroke:D,borderColor:D,borderTopColor:D,borderRightColor:D,borderBottomColor:D,borderLeftColor:D,filter:at,WebkitFilter:at,mask:mt,WebkitMask:mt},Mo=e=>di[e];var hi=new Set([at,mt]);function At(e,t){let r=Mo(e);return hi.has(r)||(r=N),r.getAnimatableNone?r.getAnimatableNone(t):void 0}function Eo(e){for(let t=1;t<e.length;t++)e[t]??(e[t]=e[t-1])}var xe=e=>e*180/Math.PI,ar=e=>{let t=xe(Math.atan2(e[1],e[0]));return mr(t)},gi={x:4,y:5,translateX:4,translateY:5,scaleX:0,scaleY:3,scale:e=>(Math.abs(e[0])+Math.abs(e[3]))/2,rotate:ar,rotateZ:ar,skewX:e=>xe(Math.atan(e[1])),skewY:e=>xe(Math.atan(e[2])),skew:e=>(Math.abs(e[1])+Math.abs(e[2]))/2},mr=e=>(e=e%360,e<0&&(e+=360),e),Do=ar,wo=e=>Math.sqrt(e[0]*e[0]+e[1]*e[1]),Co=e=>Math.sqrt(e[4]*e[4]+e[5]*e[5]),xi={x:12,y:13,z:14,translateX:12,translateY:13,translateZ:14,scaleX:wo,scaleY:Co,scale:e=>(wo(e)+Co(e))/2,rotateX:e=>mr(xe(Math.atan2(e[6],e[5]))),rotateY:e=>mr(xe(Math.atan2(-e[2],e[0]))),rotateZ:Do,rotate:Do,skewX:e=>xe(Math.atan(e[4])),skewY:e=>xe(Math.atan(e[1])),skew:e=>(Math.abs(e[1])+Math.abs(e[4]))/2};function Po(e){return e.includes("scale")?1:0}function Mt(e,t){if(!e||e==="none")return Po(t);let r=e.match(/^matrix3d\(([-\d.e\s,]+)\)$/u),o,n;if(r)o=xi,n=r;else{let a=e.match(/^matrix\(([-\d.e\s,]+)\)$/u);o=gi,n=a}if(!n)return Po(t);let i=o[t],s=n[1].split(",").map(yi);return typeof i=="function"?i(s):s[i]}var Oo=(e,t)=>{let{transform:r="none"}=getComputedStyle(e);return Mt(r,t)};function yi(e){return parseFloat(e.trim())}var fe=["transformPerspective","x","y","z","translateX","translateY","translateZ","scale","scaleX","scaleY","rotate","rotateX","rotateY","rotateZ","skew","skewX","skewY"],ye=new Set([...fe,"pathRotation"]);var fr=e=>e===U||e===u,bi=new Set(["x","y","z"]),Ti=fe.filter(e=>!bi.has(e));function Ro(e){let t=[];return Ti.forEach(r=>{let o=e.getValue(r);if(o!==void 0){let n=o.get(),i=r.startsWith("scale")?1:0;if(n===i)return;t.push([r,n]),o.set(i)}}),t}var Io=new Set(["bottom","right"]);function Fo(e,t,r,o,n,i){let s=parseFloat(e);if(!isNaN(s))return s;let{min:a,max:m}=t()[r],l=m-a;return i==="border-box"?l:l-parseFloat(o)-parseFloat(n)}var le={width:({width:e,paddingLeft:t="0",paddingRight:r="0",boxSizing:o},n)=>Fo(e,n,"x",t,r,o),height:({height:e,paddingTop:t="0",paddingBottom:r="0",boxSizing:o},n)=>Fo(e,n,"y",t,r,o),top:({top:e})=>parseFloat(e),left:({left:e})=>parseFloat(e),bottom:({top:e},t)=>{let{y:r}=t();return parseFloat(e)+(r.max-r.min)},right:({left:e},t)=>{let{x:r}=t();return parseFloat(e)+(r.max-r.min)},x:({transform:e})=>Mt(e,"x"),y:({transform:e})=>Mt(e,"y")};le.translateX=le.x;le.translateY=le.y;var be=new Set,lr=!1,pr=!1,cr=!1;function Bo(){if(pr){let e=[],t=new Set,r=new Set;be.forEach(n=>{n.needsMeasurement&&(e.push(n),t.add(n.element),Io.has(n.name)&&r.add(n.element))});let o=new Map;r.forEach(n=>{let i=Ro(n);i.length&&(o.set(n,i),n.render())}),e.forEach(n=>n.measureInitialState()),t.forEach(n=>{n.render();let i=o.get(n);i&&i.forEach(([s,a])=>{n.getValue(s)?.set(a)})}),e.forEach(n=>n.measureEndState()),e.forEach(n=>{n.suspendedScrollY!==void 0&&window.scrollTo(0,n.suspendedScrollY)})}pr=!1,lr=!1,be.forEach(e=>e.complete(cr)),be.clear()}function ko(){be.forEach(e=>{e.readKeyframes(),e.needsMeasurement&&(pr=!0)})}function No(){cr=!0,ko(),Bo(),cr=!1}function Si(e,t,r){if(typeof e=="string"){if(_e(e)||ze(e))return parseFloat(e);if(!N.test(e)&&N.test(r))return At(t,r)}return e??void 0}var Ne=class{constructor(t,r,o,n,i,s=!1){this.state="pending",this.isAsync=!1,this.needsMeasurement=!1,this.unresolvedKeyframes=[...t],this.onComplete=r,this.name=o,this.motionValue=n,this.element=i,this.isAsync=s}scheduleResolve(){this.state="scheduled",this.isAsync?(be.add(this),lr||(lr=!0,B.read(ko),B.resolveKeyframes(Bo))):(this.readKeyframes(),this.complete())}readKeyframes(){let{unresolvedKeyframes:t,name:r,element:o,motionValue:n}=this;if(t[0]===null){let i=n?.get(),s=t[t.length-1];if(i!==void 0)t[0]=i;else if(o&&r){let a=Si(o.readValue(r,s),r,s);a!==void 0&&(t[0]=a)}t[0]===void 0&&(t[0]=s),n&&i===void 0&&n.set(t[0])}Eo(t)}setFinalKeyframe(){}measureInitialState(){}renderEndStyles(){}measureEndState(){}complete(t=!1){this.state="complete",this.onComplete(this.unresolvedKeyframes,this.finalKeyframe,t),be.delete(this)}cancel(){this.state==="scheduled"&&(be.delete(this),this.state="pending")}resume(){this.state==="pending"&&this.scheduleResolve()}};var pe=e=>e.startsWith("--");function Et(e,t,r){pe(t)?e.style.setProperty(t,r):e.style[t]=r}var Ko={};function Dt(e,t){let r=je(e);return()=>Ko[t]??r()}var Go=Dt(()=>window.ScrollTimeline!==void 0,"scrollTimeline");var wt=Dt(()=>{try{document.createElement("div").animate({opacity:0},{easing:"linear(0, 1)"})}catch{return!1}return!0},"linearEasing");var Te=([e,t,r,o])=>`cubic-bezier(${e}, ${t}, ${r}, ${o})`;var ur={linear:"linear",ease:"ease",easeIn:"ease-in",easeOut:"ease-out",easeInOut:"ease-in-out",circIn:Te([0,.65,.55,1]),circOut:Te([.55,0,1,.45]),backIn:Te([.31,.01,.66,-.59]),backOut:Te([.33,1.53,.69,.99])};function dr(e,t){if(e)return typeof e=="function"?wt()?St(e,t):"ease-out":Je(e)?Te(e):Array.isArray(e)?e.map(r=>dr(r,t)||ur.easeOut):ur[e]}function Lo(e,t,r,{delay:o=0,duration:n=300,repeat:i=0,repeatType:s="loop",ease:a="easeOut",times:m}={},l=void 0){let f={[t]:r};m&&(f.offset=m);let p=dr(a,n);Array.isArray(p)&&(f.easing=p);let g={delay:o,duration:n,easing:Array.isArray(p)?"linear":p,fill:"both",iterations:i+1,direction:s==="reverse"?"alternate":"normal"};return l&&(g.pseudoElement=l),e.animate(f,g)}function Se(e){return typeof e=="function"&&"applyToOptions"in e}function Wo({type:e,...t}){return Se(e)&&wt()?e.applyToOptions(t):(t.duration??(t.duration=300),t.ease??(t.ease="easeOut"),t)}var Ct=class extends me{constructor(t){if(super(),this.finishedTime=null,this.isStopped=!1,this.manualStartTime=null,!t)return;let{element:r,name:o,keyframes:n,pseudoElement:i,allowFlatten:s=!1,finalKeyframe:a,onComplete:m}=t;this.isPseudoElement=!!i,this.allowFlatten=s,this.options=t,k(typeof t.type!="string",`Mini animate() doesn't support "type" as a string.`,"mini-spring");let l=Wo(t);this.animation=Lo(r,o,n,l,i),l.autoplay===!1&&this.animation.pause(),this.animation.onfinish=()=>{if(this.finishedTime=this.time,!i){let f=ae(n,this.options,a,this.speed);this.updateMotionValue&&this.updateMotionValue(f),Et(r,o,f),this.animation.cancel()}m?.(),this.notifyFinished()},Vt(this,t,l)}play(){this.isStopped||(this.manualStartTime=null,this.animation.play(),this.state==="finished"&&this.updateFinished())}pause(){this.animation.pause()}complete(){this.animation.finish?.()}cancel(){try{this.animation.cancel()}catch{}}stop(){if(this.isStopped)return;this.isStopped=!0;let{state:t}=this;t==="idle"||t==="finished"||(this.updateMotionValue?this.updateMotionValue():this.commitStyles(),this.isPseudoElement||this.cancel())}commitStyles(){let t=this.options?.element;!this.isPseudoElement&&t?.isConnected&&this.animation.commitStyles?.()}get duration(){let t=this.animation.effect?.getComputedTiming?.().duration||0;return I(Number(t))}get iterationDuration(){let{delay:t=0}=this.options||{};return this.duration+I(t)}get time(){return I(Number(this.animation.currentTime)||0)}set time(t){let r=this.finishedTime!==null;this.manualStartTime=null,this.finishedTime=null,this.animation.currentTime=R(t),r&&this.animation.pause()}get speed(){return this.animation.playbackRate}set speed(t){t<0&&(this.finishedTime=null),this.animation.playbackRate=t}get state(){return this.finishedTime!==null?"finished":this.animation.playState}get startTime(){return this.manualStartTime??Number(this.animation.startTime)}set startTime(t){this.manualStartTime=this.animation.startTime=t}attachTimeline({timeline:t,rangeStart:r,rangeEnd:o,observe:n}){return this.allowFlatten&&this.animation.effect?.updateTiming({easing:"linear"}),this.animation.onfinish=null,t&&Go()?(this.animation.timeline=t,r&&(this.animation.rangeStart=r),o&&(this.animation.rangeEnd=o),_):n(this)}};var _o={anticipate:qe,backInOut:Ue,circInOut:Xe};function vi(e){return e in _o}function zo(e){typeof e.ease=="string"&&vi(e.ease)&&(e.ease=_o[e.ease])}var hr=10,Pt=class extends Ct{constructor(t){zo(t),vt(t),super(t),t.startTime!==void 0&&t.autoplay!==!1&&(this.startTime=t.startTime),this.options=t}updateMotionValue(t){let{motionValue:r,onUpdate:o,onComplete:n,element:i,...s}=this.options;if(!r)return;if(t!==void 0){r.set(t);return}let a=new ee({...s,autoplay:!1}),m=Math.max(hr,C.now()-this.startTime),l=F(0,hr,m-hr),f=a.sample(m).value,{name:p}=this.options;i&&p&&Et(i,p,f),r.setWithVelocity(a.sample(Math.max(0,m-l)).value,f,l),a.stop()}};var gr=(e,t)=>t==="zIndex"?!1:!!(typeof e=="number"||Array.isArray(e)||typeof e=="string"&&(N.test(e)||e==="0")&&!e.startsWith("url("));function Vi(e){let t=e[0];if(e.length===1)return!0;for(let r=0;r<e.length;r++)if(e[r]!==t)return!0}function jo(e,t,r,o){let n=e[0];if(n===null)return!1;if(t==="display"||t==="visibility")return!0;let i=e[e.length-1],s=gr(n,t),a=gr(i,t);return!s||!a?(s!==a&&W(!1,`You are trying to animate ${t} from "${n}" to "${i}". "${s?i:n}" is not an animatable value.`,"value-not-animatable"),!1):Vi(e)||(r==="spring"||Se(r))&&o}function lt(e){e.duration=0,e.type="keyframes"}var xr=new Set(["opacity","clipPath","filter","transform","backgroundColor"]);var Ai=/^(?:oklch|oklab|lab|lch|color|color-mix|light-dark)\(/;function $o(e){for(let t=0;t<e.length;t++)if(typeof e[t]=="string"&&Ai.test(e[t]))return!0;return!1}var Uo=new Set(["color","backgroundColor","outlineColor","fill","stroke","borderColor","borderTopColor","borderRightColor","borderBottomColor","borderLeftColor"]),Mi=je(()=>Object.hasOwnProperty.call(Element.prototype,"animate"));function qo(e){let{motionValue:t,name:r,repeatDelay:o,repeatType:n,damping:i,type:s,keyframes:a}=e;if(!r||!(xr.has(r)||Uo.has(r)))return!1;let m=t?.owner?.current;if(!(m instanceof HTMLElement)&&!(m instanceof SVGElement))return!1;let{onUpdate:l,transformTemplate:f}=t.owner.getProps();return Mi()&&(xr.has(r)||Uo.has(r)&&$o(a))&&(r!=="transform"||!f)&&!l&&!o&&n!=="mirror"&&i!==0&&s!=="inertia"}var Ei=40,Ot=class extends me{constructor(t){super(),this.stop=()=>{this._animation&&(this._animation.stop(),this.stopTimeline?.()),this.keyframeResolver?.cancel()},this.createdAt=C.now();let{keyframes:r,name:o,motionValue:n,element:i}=t,s=t;s.autoplay??(s.autoplay=!0),s.delay??(s.delay=0),s.type??(s.type="keyframes"),s.repeat??(s.repeat=0),s.repeatDelay??(s.repeatDelay=0),s.repeatType??(s.repeatType="loop");let a=i?.KeyframeResolver||Ne;this.keyframeResolver=new a(r,(m,l,f)=>this.onKeyframesResolved(m,l,s,!f),o,n,i),this.keyframeResolver?.scheduleResolve()}onKeyframesResolved(t,r,o,n){this.keyframeResolver=void 0;let{name:i,type:s,velocity:a,delay:m,isHandoff:l,onUpdate:f}=o;this.resolvedAt=C.now();let p=!0;jo(t,i,s,a)||(p=!1,(K.instantAnimations||!m)&&f?.(ae(t,o,r)),t[0]=t[t.length-1],lt(o),o.repeat=0);let g=n?this.resolvedAt?this.resolvedAt-this.createdAt>Ei?this.resolvedAt:this.createdAt:this.createdAt:void 0,{onComplete:T}=o;o.startTime??(o.startTime=g),o.finalKeyframe=r,o.keyframes=t,o.onComplete=()=>{T?.(),this.notifyFinished()};let v=p&&!l&&qo(o),b;if(v){o.element=o.motionValue?.owner?.current;try{b=new Pt(o)}catch{b=new ee(o)}}else b=new ee(o);this.pendingTimeline&&(this.stopTimeline=b.attachTimeline(this.pendingTimeline),this.pendingTimeline=void 0),this._animation=b}get finished(){return this._animation?this._animation.finished:super.finished}then(t,r){return this.finished.finally(t).then(()=>{})}get animation(){return this._animation||(this.keyframeResolver?.resume(),No()),this._animation}get duration(){return this.animation.duration}get iterationDuration(){return this.animation.iterationDuration}get time(){return this.animation.time}set time(t){this.animation.time=t}get speed(){return this.animation.speed}get state(){return this.animation.state}set speed(t){this.animation.speed=t}get startTime(){return this.animation.startTime}attachTimeline(t){return this._animation?this.stopTimeline=this.animation.attachTimeline(t):this.pendingTimeline=t,()=>this.stop()}play(){this.animation.play()}pause(){this.animation.pause()}complete(){this.animation.complete()}cancel(){this._animation&&this.animation.cancel(),this.keyframeResolver?.cancel()}};var Ft=class{constructor(t){this.stop=()=>this.runAll("stop"),this.animations=t.filter(Boolean)}get finished(){return Promise.all(this.animations.map(t=>t.finished))}getAll(t){return this.animations[0][t]}setAll(t,r){for(let o=0;o<this.animations.length;o++)this.animations[o][t]=r}attachTimeline(t){let r=this.animations.map(o=>o.attachTimeline(t));return()=>{r.forEach((o,n)=>{o&&o(),this.animations[n].stop()})}}get time(){return this.getAll("time")}set time(t){this.setAll("time",t)}get speed(){return this.getAll("speed")}set speed(t){this.setAll("speed",t)}get state(){return this.getAll("state")}get startTime(){return this.getAll("startTime")}get duration(){return Yo(this.animations,"duration")}get iterationDuration(){return Yo(this.animations,"iterationDuration")}runAll(t){this.animations.forEach(r=>r[t]())}play(){this.runAll("play")}pause(){this.runAll("pause")}cancel(){this.runAll("cancel")}complete(){this.runAll("complete")}};function Yo(e,t){let r=0;for(let o=0;o<e.length;o++){let n=e[o][t];n!==null&&n>r&&(r=n)}return r}var pt=class extends Ft{then(t,r){return this.finished.finally(t).then(()=>{})}};var Xo=30,Di=e=>!isNaN(parseFloat(e)),yr={current:void 0},Y=class{constructor(t,r={}){this.canTrackVelocity=null,this.events={},this.updateAndNotify=o=>{let n=C.now();if(this.updatedAt!==n&&this.setPrevFrameValue(),this.prev=this.current,this.setCurrent(o),this.current!==this.prev&&(this.notifyChange(),this.dependents))for(let i of this.dependents)i.dirty()},this.hasAnimated=!1,this.setCurrent(t),this.owner=r.owner}setCurrent(t){this.current=t,this.updatedAt=C.now(),this.canTrackVelocity===null&&t!==void 0&&(this.canTrackVelocity=Di(this.current))}setPrevFrameValue(t=this.current){this.prevFrameValue=t,this.prevUpdatedAt=this.updatedAt}onChange(t){return this.on("change",t)}on(t,r){var o;return t==="change"?this.onChangeSubscribe(r):((o=this.events)[t]||(o[t]=new Ee)).add(r)}onChangeSubscribe(t){let{events:r}=this;return!r.change&&!this.changeSubscriber?this.changeSubscriber=t:(r.change||(r.change=new Ee,r.change.add(this.changeSubscriber),this.changeSubscriber=void 0),r.change.add(t)),()=>{this.changeSubscriber===t?this.changeSubscriber=void 0:r.change?.remove(t),this.stopIfUnobserved()}}stopIfUnobserved(){B.read(()=>{!this.changeSubscriber&&!this.events.change?.getSize()&&this.stop()})}clearListeners(){this.changeSubscriber=void 0;for(let t in this.events)this.events[t].clear()}attach(t,r){this.passiveEffect=t,this.stopPassiveEffect=r}set(t){this.passiveEffect?this.passiveEffect(t,this.updateAndNotify):this.updateAndNotify(t)}setWithVelocity(t,r,o){this.set(r),this.prev=void 0,this.prevFrameValue=t,this.prevUpdatedAt=this.updatedAt-o}jump(t,r=!0){this.updateAndNotify(t),this.prev=t,this.prevUpdatedAt=this.prevFrameValue=void 0,r&&this.stop(),this.stopPassiveEffect&&this.stopPassiveEffect()}dirty(){this.notifyChange()}notifyChange(){let{current:t,changeSubscriber:r}=this;r?r(t):this.events.change?.notify(t)}addDependent(t){this.dependents||(this.dependents=new Set),this.dependents.add(t)}removeDependent(t){this.dependents&&this.dependents.delete(t)}get(){return yr.current&&yr.current.push(this),this.current}getPrevious(){return this.prev}getVelocity(){let t=C.now();if(!this.canTrackVelocity||this.prevFrameValue===void 0||t-this.updatedAt>Xo)return 0;let r=Math.min(this.updatedAt-this.prevUpdatedAt,Xo);return $e(parseFloat(this.current)-parseFloat(this.prevFrameValue),r)}start(t){return this.stop(),new Promise(r=>{this.hasAnimated=!0;let o=!1,n;n=t(()=>{o=!0,this.events.animationComplete?.notify(),this.animation===n&&this.clearAnimation(),r()}),o||(this.animation=n),this.events.animationStart?.notify()})}stop(){this.animation&&(this.animation.stop(),this.events.animationCancel&&this.events.animationCancel.notify()),this.clearAnimation()}isAnimating(){return!!this.animation}clearAnimation(){this.animation=void 0}destroy(){this.dependents?.clear(),this.events.destroy?.notify(),this.clearListeners(),this.stop(),this.stopPassiveEffect&&this.stopPassiveEffect()}};function ve(e,t){return new Y(e,t)}function Zo(e,t){if(e?.inherit&&t){let{inherit:r,...o}=e;return{...t,...o}}return e}function Ho(e,t){let r=e?.[t]??e?.default??e;return r!==e?Zo(r,e):r}var wi={type:"spring",stiffness:500,damping:25,restSpeed:10},Ci=e=>({type:"spring",stiffness:550,damping:e===0?2*Math.sqrt(550):30,restSpeed:10}),Pi={type:"keyframes",duration:.8},Oi={type:"keyframes",ease:[.25,.1,.35,1],duration:.3},Jo=(e,{keyframes:t})=>t.length>2?Pi:ye.has(e)?e.startsWith("scale")?Ci(t[1]):wi:Oi;var Fi=new Set(["when","delay","delayChildren","staggerChildren","staggerDirection","repeat","repeatType","repeatDelay","from","elapsed"]);function Qo(e){for(let t in e)if(!Fi.has(t))return!0;return!1}var Rt=(e,t,r,o={},n,i)=>s=>{let a=Ho(o,e)||{},m=a.delay||o.delay||0,{elapsed:l=0}=o;l=l-R(m);let f={keyframes:Array.isArray(r)?r:[null,r],ease:"easeOut",velocity:t.getVelocity(),...a,delay:-l,onUpdate:g=>{t.set(g),a.onUpdate&&a.onUpdate(g)},onComplete:()=>{s(),a.onComplete&&a.onComplete()},name:e,motionValue:t,element:i?void 0:n};Qo(a)||Object.assign(f,Jo(e,f)),f.duration&&(f.duration=R(f.duration)),f.repeatDelay&&(f.repeatDelay=R(f.repeatDelay)),f.from!==void 0&&(f.keyframes[0]=f.from);let p=!1;if((f.type===!1||f.duration===0&&!f.repeatDelay)&&(lt(f),f.delay===0&&(p=!0)),(K.instantAnimations||K.skipAnimations||n?.shouldSkipAnimations||a.skipAnimations)&&(p=!0,lt(f),f.delay=0),f.allowFlatten=!a.type&&!a.ease,p&&!i&&t.get()!==void 0){let g=ae(f.keyframes,a);if(g!==void 0){B.update(()=>{f.onUpdate(g),f.onComplete()});return}}return a.isSync?new ee(f):new Ot(f)};var Ri=/^var\(--(?:([\w-]+)|([\w-]+), ?([a-zA-Z\d ()%#.,-]+))\)/u;function Ii(e){let t=Ri.exec(e);if(!t)return[,];let[,r,o,n]=t;return[`--${r??o}`,n]}var Bi=4;function br(e,t,r=1){k(r<=Bi,`Max CSS variable fallback depth detected in property "${e}". This may indicate a circular fallback dependency.`,"max-css-var-depth");let[o,n]=Ii(e);if(!o)return;let i=window.getComputedStyle(t).getPropertyValue(o);if(i){let s=i.trim();return _e(s)?parseFloat(s):s}return Pe(n)?br(n,t,r+1):n}var It=new Set(["width","height","top","left","right","bottom",...fe]);var Ve=e=>!!(e&&e.getVelocity);function Bt(e){return e.replace(/([A-Z])/g,t=>`-${t.toLowerCase()}`)}var en={test:e=>e==="auto",parse:e=>e};var tn=e=>t=>t.test(e);var ki=[U,u,ie,z,so,io,en],Tr=e=>ki.find(tn(e));function rn(e){return typeof e=="number"?e===0:e!==null?e==="none"||e==="0"||ze(e):!0}var Ni=new Set(["auto","none","0"]);function on(e,t,r){let o=0,n;for(;o<e.length&&!n;){let i=e[o];typeof i=="string"&&!Ni.has(i)&&uo(i)&&(n=e[o]),o++}if(n&&r)for(let i of t)e[i]!==n&&(e[i]=At(r,n))}var kt=class extends Ne{constructor(t,r,o,n,i){super(t,r,o,n,i,!0)}readKeyframes(){let{unresolvedKeyframes:t,element:r,name:o}=this;if(!r||!r.current)return;super.readKeyframes();for(let f=0;f<t.length;f++){let p=t[f];if(typeof p=="string"&&(p=p.trim(),Pe(p))){let g=br(p,r.current);g!==void 0&&(t[f]=g),f===t.length-1&&(this.finalKeyframe=p)}}if(this.resolveNoneKeyframes(),!It.has(o)||t.length!==2)return;let[n,i]=t;if(typeof n=="number"&&typeof i=="number")return;let s=Tr(n),a=Tr(i),m=Xt(n),l=Xt(i);if(m!==l&&le[o]){this.needsMeasurement=!0;return}if(s!==a)if(fr(s)&&fr(a))for(let f=0;f<t.length;f++){let p=t[f];typeof p=="string"&&(t[f]=parseFloat(p))}else le[o]&&(this.needsMeasurement=!0)}resolveNoneKeyframes(){let{unresolvedKeyframes:t,name:r}=this,o=[];for(let n=0;n<t.length;n++)(t[n]===null||rn(t[n]))&&o.push(n);o.length&&on(t,o,r)}measure(){let{element:t,name:r}=this;return le[r](window.getComputedStyle(t.current),()=>t.measureViewportBox())}measureInitialState(){let{element:t,unresolvedKeyframes:r,name:o}=this;if(!t||!t.current)return;o==="height"&&(this.suspendedScrollY=window.pageYOffset),this.measuredOrigin=this.measure(),r[0]=this.measuredOrigin;let n=r[r.length-1];n!==void 0&&this.motionValue?.jump(n,!1)}measureEndState(){let{element:t,unresolvedKeyframes:r}=this;if(!t||!t.current)return;this.motionValue?.jump(this.measuredOrigin,!1);let o=r.length-1,n=r[o];r[o]=this.measure(),n!==null&&this.finalKeyframe===void 0&&(this.finalKeyframe=n),this.removedTransforms?.length&&this.removedTransforms.forEach(([i,s])=>{t.getValue(i).set(s)}),this.resolveNoneKeyframes()}};var Sr=[];function vr(e){k(typeof e.test=="function"&&typeof e.read=="function","Effects passed to animate.addEffect() need test() and read().","effect-missing-test"),Nt(e),Sr.unshift(e)}function Nt(e){Z(Sr,e)}function Vr(e){return Sr.find(t=>t.test(e))}function Kt(e,t,r={},o){let n=[],{velocity:i}=r,s=r.reduceMotion??o?.shouldReduceMotion;for(let m in t){if(m==="transition"||m==="transitionEnd")continue;let l=t[m];if(l===void 0)continue;let f=e(m),p=f.get();if(p!==void 0&&!f.isAnimating()&&!Array.isArray(l)&&l===p&&!i){B.update(()=>f.set(l));continue}f.start(Rt(m,f,l,s&&It.has(m)?{type:!1}:r,o)),f.animation&&n.push(f.animation)}let{transitionEnd:a}=t;if(a){let m=()=>B.update(()=>{for(let l in a)e(l).set(a[l])});n.length?Promise.all(n).then(m):m()}return n}function ct(e,t,r,o,n){return Kt(i=>{let s=e.get(t,i);if(!s){let a;if(!n){let m=r[i];a=Ki(m)??e.read(t,i,m),k(a!==void 0,`"${i}" can't be read from the animated subject. Provide [from, to] keyframes.`,"effect-unreadable-value")}s=ve(a,{owner:n}),e(t,{[i]:s})}return s},r,o,n)}function Ki(e){let t=Array.isArray(e)?e[0]:void 0;return t===null?void 0:t}function Ar(e){return ce(e)&&"offsetHeight"in e&&!("ownerSVGElement"in e)}function Ke(e){return ce(e)&&"ownerSVGElement"in e}var te=(e,t)=>t&&typeof e=="number"?t.transform(e):e;function Mr(e,t,r){if(e==null)return[];if(e instanceof EventTarget)return[e];if(typeof e=="string"){let o=document;t&&(o=t.current);let n=r?.[e]??o.querySelectorAll(e);return n?Array.from(n):[]}return Array.from(e).filter(o=>o!=null)}var Gt=class{constructor(t=B.render){this.step=t,this.values=new Map,this.pending=[],this.numPending=0,this.flush=()=>{let{pending:r,numPending:o}=this;this.numPending=0;for(let n=0;n<o;n++)r[n]()}}set(t,r,o,n){if(this.values.get(t)?.onRemove(),n)for(let m of this.values.values())m.value===n&&(o=m.render);let i=()=>o&&this.schedule(o);r.get()!==void 0&&i();let s=r.on("change",i),a=()=>{s(),o&&!n&&this.cancel(o),this.values.delete(t)};return this.values.set(t,{value:r,render:n?void 0:o,onRemove:a}),a}get(t){return this.values.get(t)?.value}release(){let t=new Map;return this.values.forEach((r,o)=>{t.set(o,r.value),r.onRemove()}),this.transformKeys=this.transformValues=void 0,t}schedule(t){let{pending:r,numPending:o}=this;for(let n=0;n<o;n++)if(r[n]===t)return;o||this.step(this.flush),r[this.numPending++]=t}cancel(t){let{pending:r}=this;for(let o=0;o<this.numPending;o++)if(r[o]===t){r[o]=r[--this.numPending];return}}};function Ge(e,{step:t,...r}={}){let o=new WeakMap;return Object.assign((i,s)=>{let a=o.get(i)??new Gt(t);o.set(i,a);let m=[];for(let l in s){let f=s[l],p=e(i,a,l,f);m.push(p)}return()=>{for(let l of m)l()}},r,{get:(i,s)=>o.get(i)?.get(s),flush:i=>o.get(i)?.flush(),state:i=>o.get(i)})}var Gi={x:"translateX",y:"translateY",z:"translateZ",transformPerspective:"perspective"},nn={};function sn(e){let t="",{transformKeys:r=[],transformValues:o={}}=e;for(let i=0;i<r.length;i++){let s=r[i],a=o[s].get();if(a===void 0)continue;(typeof a=="number"?a:parseFloat(a))!==(s.startsWith("scale")?1:0)&&(t+=(t&&" ")+(nn[s]||(nn[s]=(Gi[s]||s)+"("))+te(a,ft[s])+")")}let n=e.get("pathRotation")?.get();return n&&(t+=(t&&" ")+"rotate("+te(n,ft.pathRotation)+")"),t||"none"}var Li=new Set(["originX","originY","originZ"]),Er=(e,t)=>te(e.get(t)?.get(),j[t]),Lt=(e,t,r,o)=>{let n,i;if(ye.has(r)){if(r!=="pathRotation"){let s=t.transformKeys??(t.transformKeys=[]);(t.transformValues??(t.transformValues={}))[r]=o,s.includes(r)||(s.push(r),s.sort((a,m)=>fe.indexOf(a)-fe.indexOf(m)))}t.get("transform")||(!Ar(e)&&!t.get("transformBox")&&Lt(e,t,"transformBox",new Y("fill-box")),t.set("transform",new Y("none"),()=>{e.style.transform=sn(t)})),i=t.get("transform")}else Li.has(r)?(t.get("transformOrigin")||t.set("transformOrigin",new Y(""),()=>{let s=Er(t,"originX")??"50%",a=Er(t,"originY")??"50%",m=Er(t,"originZ")??0;e.style.transformOrigin=`${s} ${a} ${m}`}),i=t.get("transformOrigin")):pe(r)?n=()=>{e.style.setProperty(r,o.get())}:n=()=>{e.style[r]=te(o.get(),j[r])};return t.set(r,o,n,i)},Wi=e=>Ar(e)||Ke(e),Dr=(e,t)=>{if(ye.has(t))return Oo(e,t);let r=getComputedStyle(e),o=pe(t)?r.getPropertyValue(t):r[t];return typeof o=="string"&&o.trim()||0},an=Ge(Lt,{test:Wi,read:Dr});var mn=["transform","opacity","offsetDistance","offsetPath","offsetRotate","offsetAnchor"];function _i(e,t){if(!(t in e))return!1;let r=Object.getOwnPropertyDescriptor(Object.getPrototypeOf(e),t)||Object.getOwnPropertyDescriptor(e,t);return r&&typeof r.set=="function"}var wr=(e,t,r,o,n=r)=>{let i=_i(e,n);!i&&(n.startsWith("data")||n.startsWith("aria"))&&(n=Bt(n));let s=j[r]||j[n],a=i?()=>{e[n]=te(o.get(),j[r])}:()=>{let m=te(o.get(),s);m==null?e.removeAttribute(n):e.setAttribute(n,String(m))};return t.set(r,o,a)};function zi(e,t,r,o){return B.render(()=>e.setAttribute("pathLength","1")),r==="pathOffset"?t.set(r,o,()=>{let n=o.get();e.setAttribute("stroke-dashoffset",`${-n}`)}):(t.get("stroke-dasharray")||t.set("stroke-dasharray",new Y("1 1"),()=>{let n=t.get("pathLength")?.get()??1,i=t.get("pathSpacing")?.get();e.setAttribute("stroke-dasharray",`${n} ${i??1-Number(n)}`)}),t.set(r,o,void 0,t.get("stroke-dasharray")))}var ji=(e,t,r,o)=>r.startsWith("path")?zi(e,t,r,o):r.startsWith("attr")?wr(e,t,r,o,ln(r)):(pe(r)||r in e.style?Lt:wr)(e,t,r,o),$i=(e,t)=>ye.has(t)?j[t]?.default||0:pe(t)||mn.includes(t)?Dr(e,t):(t=ln(t),e.getAttribute(Bt(t))??e.getAttribute(t)??void 0),fn=Ge(ji,{test:Ke,read:$i});function ln(e){return e.replace(/^attr([A-Z])/,(t,r)=>r.toLowerCase())}function pn({top:e,left:t,right:r,bottom:o}){return{x:{min:t,max:r},y:{min:e,max:o}}}function cn(e,t){if(!t)return e;let r=t({x:e.left,y:e.top}),o=t({x:e.right,y:e.bottom});return{top:r.y,left:r.x,bottom:o.y,right:o.x}}function un(e,t){return pn(cn(e.getBoundingClientRect(),t))}var Ui={},qi=e=>Ke(e)?fn:an,Cr=class{constructor(t,r){this.effect=t,this.current=r,this.KeyframeResolver=kt}getValue(t){return this.effect.get(this.current,t)}readValue(t,r){return this.effect.read(this.current,t,r)}render(){this.effect.flush(this.current)}measureViewportBox(){return un(this.current)}getProps(){return Ui}};function Pr(e,t,r,o){if(o)return Kt(i=>o.getValue(i,null),t,r,o);let n=qi(e);return ct(n,e,t,r,new Cr(n,e))}var Or=Ge((e,t,r,o)=>t.set(r,o,()=>{e[r]=o.get()}),{test:e=>ce(e),read:(e,t)=>{let r=e[t];return typeof r=="string"||typeof r=="number"?r:void 0}});function dn(e,t){if(e==="first")return 0;{let r=t-1;return e==="last"?r:r/2}}function Fr(e=.1,{startDelay:t=0,from:r=0,ease:o}={}){return(n,i)=>{let s=typeof r=="number"?r:dn(r,i),a=Math.abs(s-n),m=e*a;if(o){let l=i*e;m=Ce(o)(m/l)*l}return t+m}}var Rr=new WeakMap;function Ir(e,t,r){let o=Ve(e)?e:ve(e);return o.start(Rt("",o,t,r)),o.animation}function ut(e){return typeof e=="object"&&!Array.isArray(e)}function Wt(e,t,r,o){return e==null?[]:typeof e=="string"&&ut(t)?Mr(e,r,o):e instanceof NodeList?Array.from(e):Array.isArray(e)?e.filter(n=>n!=null):[e]}function hn(e,t,r){return e*(t+1)+r*t}function Br(e,t,r,o){return typeof t=="number"?t:t.startsWith("-")||t.startsWith("+")?Math.max(0,e+parseFloat(t)):t==="<"?r:t.startsWith("<")?Math.max(0,r+parseFloat(t.slice(1))):o.get(t)??e}function Yi(e,t,r){for(let o=0;o<e.length;o++){let n=e[o];n.at>t&&n.at<r&&(Z(e,n),o--)}}function gn(e,t,r,o,n,i){Yi(e,n,i);for(let s=0;s<t.length;s++)e.push({value:t[s],at:G(n,i,o[s]),easing:He(r,s)})}function xn(e,t,r=0){let o=t+1+t*r;for(let n=0;n<e.length;n++)e[n]=e[n]/o}function yn(e,t){return e.at===t.at?e.value===null?1:t.value===null?-1:0:e.at-t.at}var Xi="easeInOut",kr=20;function Sn(e,{defaultTransition:t={},...r}={},o,n){let i=t.duration||.3,s=new Map,a=new Map,m={},l=new Map,f=0,p=0,g=0;for(let T=0;T<e.length;T++){let v=e[T];if(typeof v=="string"){l.set(v,p);continue}else if(!Array.isArray(v)){l.set(v.name,Br(p,v.at,f,l));continue}let[b,h,A={}]=v;A.at!==void 0&&(p=Br(p,A.at,f,l));let M=0,S=(y,E,w,c=0,d=0)=>{let x=Zi(y),{delay:V=0,times:O=st(x),type:zt=t.type||"keyframes",repeat:re,repeatType:jt,repeatDelay:Kr=0,...An}=E,{ease:X=t.ease||"easeOut",duration:L}=E,Gr=typeof V=="function"?V(c,d):V,Lr=x.length,Wr=Se(zt)?zt:n?.[zt||"keyframes"];if(Lr<=2&&Wr){let Ae=100;if(Lr===2&&Qi(x)){let Le=x[1]-x[0];Ae=Math.abs(Le)}let Me={...t,...An};L!==void 0&&(Me.duration=R(L));let dt=ot(Me,Ae,Wr);X=dt.ease,L=dt.duration}L??(L=i);let _r=p+Gr;O.length===1&&O[0]===0&&(O[1]=1);let zr=O.length-x.length;if(zr>0&&it(O,zr),x.length===1&&x.unshift(null),re&&W(re<kr,`Sequence segments can't repeat ${re} times \u2014 ignoring repeat option. Use a value below ${kr} or apply repeat at the sequence level instead.`),re&&re<kr){let Ae=L>0?Kr/L:0;L=hn(L,re,Kr);let Me=[...x],dt=[...O];X=Array.isArray(X)?[...X]:[X];let Le=[...X],$r=jt==="reverse"||jt==="mirror",Ur=Me,qr=Le;$r&&(Ur=[...Me].reverse(),jt==="reverse"&&(qr=[...Le].reverse().map(oe=>typeof oe=="function"?he(oe):oe)));for(let oe=0;oe<re;oe++){let Yr=$r&&oe%2===0,Xr=Yr?Ur:Me,Mn=Yr?qr:Le,Zr=(oe+1)*(1+Ae);Ae>0&&(x.push(x[x.length-1]),O.push(Zr),X.push("linear")),x.push(...Xr);for(let We=0;We<Xr.length;We++)O.push(dt[We]+Zr),X.push(We===0?"linear":He(Mn,We-1))}xn(O,re,Ae)}let jr=_r+L;gn(w,x,X,O,_r,jr),M=Math.max(Gr+L,M),g=Math.max(jr,g)};if(Ve(b)){let y=bn(b,a);S(h,A,Tn("default",y))}else{let y=Wt(b,h,o,m),E=y.length;for(let w=0;w<E;w++){h=h,A=A;let c=y[w],d=bn(c,a);for(let x in h)S(h[x],Hi(A,x),Tn(x,d),w,E)}}f=p,p+=M}return a.forEach((T,v)=>{for(let b in T){let h=T[b];h.sort(yn);let A=[],M=[],S=[];for(let c=0;c<h.length;c++){let{at:d,value:x,easing:V}=h[c];A.push(x),M.push(de(0,g,d)),S.push(V||"easeOut")}M[0]!==0&&(M.unshift(0),A.unshift(A[0]),S.unshift(Xi)),M[M.length-1]!==1&&(M.push(1),A.push(null)),s.has(v)||s.set(v,{keyframes:{},transition:{}});let y=s.get(v);y.keyframes[b]=A;let{type:E,...w}=t;y.transition[b]={...w,duration:g,ease:S,times:M,...r}}}),s}function bn(e,t){return!t.has(e)&&t.set(e,{}),t.get(e)}function Tn(e,t){return t[e]||(t[e]=[]),t[e]}function Zi(e){return Array.isArray(e)?e:[e]}function Hi(e,t){return e&&e[t]?{...e,...e[t]}:{...e}}var Ji=e=>typeof e=="number",Qi=e=>e.every(Ji);function es(e,t){return Ve(e)||typeof e=="number"||typeof e=="string"&&!ut(t)}function _t(e,t,r,o){let n=[];if(es(e,t))n.push(Ir(e,ut(t)&&t.default||t,r&&(r.default||r)));else{if(e==null)return n;let i=Wt(e,t,o),s=i.length;k(!!s,"No valid elements provided.","no-valid-elements");for(let a=0;a<s;a++){let m=i[a],l={...r};"delay"in l&&typeof l.delay=="function"&&(l.delay=l.delay(a,s)),m instanceof Element?n.push(...Pr(m,t,l,Rr.get(m))):n.push(...ct(Vr(m)??Or,m,t,l))}}return n}function vn(e,t,r){let o=[],n=e.map(s=>{if(Array.isArray(s)&&typeof s[0]=="function"){let a=s[0],m=ve(0);return m.on("change",a),s.length===1?[m,[0,1]]:s.length===2?[m,[0,1],s[1]]:[m,s[1],s[2]]}return s});return Sn(n,t,r,{spring:Q}).forEach(({keyframes:s,transition:a},m)=>{o.push(..._t(m,s,a))}),o}function ts(e){return Array.isArray(e)&&e.some(Array.isArray)}function Vn(e={}){let{scope:t,reduceMotion:r,skipAnimations:o}=e;function n(i,s,a){let m=[],l,f={};if(r!==void 0&&(f.reduceMotion=r),o!==void 0&&(f.skipAnimations=o),ts(i)){let{onComplete:g,...T}=s||{};typeof g=="function"&&(l=g),m=vn(i,{...f,...T},t)}else{let{onComplete:g,...T}=a||{};typeof g=="function"&&(l=g),m=_t(i,s,{...f,...T},t)}let p=new pt(m);return l&&p.finished.then(l),t&&(t.animations.push(p),p.finished.then(()=>{Z(t.animations,p)})),p}return n}var Nr=Object.assign(Vn(),{addEffect:vr,removeEffect:Nt});window.OfficeMotion={animate:Nr,stagger:Fr};})();
</script>
<script>
(()=>{
'use strict';
/* Standalone, scoped office-map section. No CDN, framework or server required.
   For Laravel integration: OfficeMap.load({users,punches,allocations,date}).
   users: [{id:1,name:'Rahul',paycode:'00000001',role:'Developer'}]
   punches: [{employee_no:1,punched_at:'2026-10-01T09:12:00+05:30'}]
   allocations: [{desk_id:'IT-01',user_id:1}]. date defaults to today in India.
   Loaded snapshots are read-only. Demo controls modify sample data only.
*/
const root=document.getElementById('codesparrow-office-map');
const $=s=>root.querySelector(s),$$=s=>[...root.querySelectorAll(s)];
const escapeHTML=s=>String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const pad=n=>String(n).padStart(2,'0');
const localDay=date=>new Intl.DateTimeFormat('en-CA',{timeZone:'Asia/Kolkata',year:'numeric',month:'2-digit',day:'2-digit'}).format(date);
const today=localDay(new Date());
const {animate,stagger}=window.OfficeMotion;
const reducedMotion=matchMedia('(prefers-reduced-motion: reduce)');
let motionEnabled=!reducedMotion.matches,seatAnimations=[],hoverAnimations=new Map(),cameraAnimation=null,dialogAnimation=null;
function stopSeatMotion(){seatAnimations.forEach(a=>a.stop());seatAnimations=[];hoverAnimations.forEach(a=>a.stop());hoverAnimations.clear()}
function setupSeatMotion(reveal=false){
 stopSeatMotion();
 $$('#seats .seat').forEach((seat,i)=>{
  let art=seat.querySelector('.om-seat-art');
  if(!art){art=document.createElementNS('http://www.w3.org/2000/svg','g');art.classList.add('om-seat-art');while(seat.firstChild)art.appendChild(seat.firstChild);seat.appendChild(art)}
  if(!motionEnabled){art.style.opacity=1;art.style.transform='none';return}
  if(reveal)seatAnimations.push(animate(art,{opacity:[0,1],y:[12,0]},{duration:.6,delay:i*.045,ease:[.22,1,.36,1]}));
  const person=seat.querySelector('.om-person');if(person)seatAnimations.push(animate(person,{scaleY:[1,1.035,1],y:[0,-1.8,0],rotate:[-1.3,1.3,-1.3]},{duration:2.8+(i%3)*.25,repeat:Infinity,ease:'easeInOut',delay:reveal?1.3+i*.08:0}));
  seat.querySelectorAll('.om-typing-left,.om-typing-right').forEach((arm,j)=>seatAnimations.push(animate(arm,{y:[0,3.4,0,-1.1,0],rotate:j?[0,5,0,-3,0]:[0,-5,0,3,0]},{duration:.72+j*.14,repeat:Infinity,ease:'easeInOut',delay:i*.17+j*.25})));
  const head=seat.querySelector('.om-head');if(head)seatAnimations.push(animate(head,{rotate:[-4,3,-4],x:[-1,1,-1]},{duration:3.5,repeat:Infinity,ease:'easeInOut',delay:i*.35}));
  const code=seat.querySelector('.om-screen-code');if(code)seatAnimations.push(animate(code,{opacity:[.6,1,.7],y:[0,-2,0]},{duration:1.8,repeat:Infinity,ease:'easeInOut',delay:i*.2}));
  const cursor=seat.querySelector('.om-screen-cursor');if(cursor)seatAnimations.push(animate(cursor,{opacity:[1,0,1]},{duration:.85,repeat:Infinity,ease:'linear',delay:i*.11}));
  const halo=seat.querySelector('.om-presence-halo');if(halo)seatAnimations.push(animate(halo,{opacity:[.12,.5,.12]},{duration:3.4,repeat:Infinity,ease:'easeInOut',delay:i*.13}));
 });
}
function deskHover(seat,on){if(!motionEnabled||didDrag)return;const art=seat.querySelector('.om-seat-art');hoverAnimations.get(seat)?.stop();hoverAnimations.set(seat,animate(art,{y:on?-7:0,scale:on?1.035:1},{type:'spring',stiffness:350,damping:26}));}
function setMotionEnabled(enabled){motionEnabled=enabled&&!reducedMotion.matches;stopSeatMotion();cameraAnimation?.stop();dialogAnimation?.stop();$$('.om-person,.om-seat-art,.om-typing-left,.om-typing-right,.om-head,.om-screen-code,.om-screen-cursor,.om-presence-halo').forEach(el=>{el.style.transform='none';el.style.opacity=1});$('#architecture').style.opacity=1;$('#deskDialog').style.opacity=1;$('#deskDialog').style.transform='none';setupSeatMotion();$('#motionToggle').setAttribute('aria-pressed',String(!motionEnabled));$('#motionToggle').setAttribute('aria-label',motionEnabled?'Pause animations':'Resume animations');$('#motionToggle').title=motionEnabled?'Pause animations':'Resume animations';if(isDemo)$('#dataMode').textContent=motionEnabled?'● Animated demo':'Animations paused';}
reducedMotion.addEventListener('change',()=>setMotionEnabled(!reducedMotion.matches));
document.addEventListener('visibilitychange',()=>{seatAnimations.forEach(a=>document.hidden?a.pause():a.play())});

const paths={motion:'M3 9h3l3-5 6 16 3-7h3',minus:'M5 12h14',plus:'M5 12h14M12 5v14',fit:'M8 3H3v5M16 3h5v5M21 16v5h-5M8 21H3v-5M8 8h8v8H8Z',expand:'M8 3H3v5M3 3l6 6M16 3h5v5M21 3l-6 6M21 16v5h-5M21 21l-6-6M8 21H3v-5M3 21l6-6',close:'m6 6 12 12M6 18 18 6',pointer:'m4 2 5 18 3-7 7-3L4 2Zm8 11 6 7'};
function icon(name){return `<svg class="om-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="${paths[name]||paths.pointer}"/></svg>`}
$$('[data-icon]').forEach(el=>el.innerHTML=icon(el.dataset.icon));
const departmentNames={IT:'IT department',SEO:'SEO department',CALL:'Calling department'};
const statusNames={present:'Punched today',absent:'No punch',free:'Not allocated'};
const deskConfig=[...Array.from({length:8},(_,i)=>({id:`IT-${pad(i+1)}`,dept:'IT',x:178+(i%4)*202,y:i<4?133:287})),...Array.from({length:6},(_,i)=>({id:`SEO-${pad(i+1)}`,dept:'SEO',x:175+(i%3)*202,y:i<3?498:638})),...Array.from({length:2},(_,i)=>({id:`CALL-${pad(i+1)}`,dept:'CALL',x:925+i*207,y:635}))];
const samplePeople=[];
const initialSeats=()=>deskConfig.map(d=>({...d,name:'',role:'',status:'free',time:'',paycode:'',hair:'short'}));

let seats=initialSeats(),selectedId=null,isDemo=false,lastFocus=null;
function save(){}

const defs=`
<linearGradient id="floor" x2="1" y2="1"><stop stop-color="#fafcfd"/><stop offset="1" stop-color="#eaf1f3"/></linearGradient>
<pattern id="tile" width="90" height="70" patternUnits="userSpaceOnUse"><rect width="90" height="70" fill="transparent"/><path d="M90 0H0V70" fill="none" stroke="#b9cbd1" stroke-opacity=".18" stroke-width="1"/><path d="M3 2h86" stroke="#fff" stroke-opacity=".32"/></pattern>
<linearGradient id="wood" x1="0" y1="0" x2="0" y2="1"><stop stop-color="#e9cfaa"/><stop offset=".5" stop-color="#dfbc8e"/><stop offset="1" stop-color="#efd5ad"/></linearGradient>
<linearGradient id="darkwood" x2="0" y2="1"><stop stop-color="#a78259"/><stop offset="1" stop-color="#785940"/></linearGradient>
<linearGradient id="glass" x2="0" y2="1"><stop stop-color="#bae4e9" stop-opacity=".45"/><stop offset=".7" stop-color="#d4f0f1" stop-opacity=".16"/><stop offset="1" stop-color="#68b6be" stop-opacity=".3"/></linearGradient>
<linearGradient id="chair" x2="0" y2="1"><stop stop-color="#485252"/><stop offset=".45" stop-color="#344044"/><stop offset="1" stop-color="#222e31"/></linearGradient>
<linearGradient id="shirt" x1="0" x2="1"><stop stop-color="#166a6a"/><stop offset=".45" stop-color="#44a49c"/><stop offset="1" stop-color="#237b74"/></linearGradient>
<linearGradient id="suit" x1="0" x2="1"><stop stop-color="#2d3a46"/><stop offset=".5" stop-color="#54616c"/><stop offset="1" stop-color="#25353f"/></linearGradient>
<linearGradient id="monitor" x2="0" y2="1"><stop stop-color="#3b4949"/><stop offset="1" stop-color="#202d2e"/></linearGradient>
<linearGradient id="screen" x2="1" y2="1"><stop stop-color="#718d98"/><stop offset="1" stop-color="#314e59"/></linearGradient>
<linearGradient id="skin" x2="1" y2="1"><stop stop-color="#c79268"/><stop offset=".5" stop-color="#e4b590"/><stop offset="1" stop-color="#b38361"/></linearGradient>
<radialGradient id="hair"><stop stop-color="#514039"/><stop offset="1" stop-color="#252728"/></radialGradient>
<linearGradient id="pot" x2="1"><stop stop-color="#b7b8a9"/><stop offset=".5" stop-color="#f4f2e7"/><stop offset="1" stop-color="#b3b8aa"/></linearGradient>
<filter id="floorShadow" x="-10%" y="-10%" width="120%" height="130%"><feDropShadow dx="0" dy="9" stdDeviation="9" flood-color="#52634b" flood-opacity=".2"/></filter>
<filter id="softShadow" x="-25%" y="-30%" width="150%" height="175%"><feDropShadow dx="1" dy="5" stdDeviation="3" flood-color="#4d4b3e" flood-opacity=".18"/></filter>
<filter id="tinyShadow" x="-40%" y="-30%" width="190%" height="185%"><feDropShadow dx="0" dy="2" stdDeviation="1.2" flood-color="#253423" flood-opacity=".22"/></filter>
<g id="plant"><ellipse cx="0" cy="7" rx="20" ry="10" fill="#4c634b" opacity=".09"/><path d="M-12-7-10 11Q0 20 10 11L13-7" fill="url(#pot)" stroke="#b8c9cc" stroke-width=".6"/><ellipse cy="-7" rx="13" ry="7" fill="#748063"/><ellipse cy="-8" rx="10" ry="5" fill="#665d46"/><path d="M0-6v-27M0-9l-14-22M0-10l17-24M-1-10l-20-10M1-13l20-5" stroke="#6b7f39" stroke-width="2"/><g fill="#547644"><path d="M0-10Q-23-13-23-37-2-33 0-10"/><path d="M0-13Q-14-34-4-50 8-36 0-13"/><path d="M3-11Q0-39 21-44 24-24 3-11"/><path d="M4-9Q15-30 30-19 18-7 4-9"/><path d="M-3-9Q-20-25-34-16-21-4-3-9"/></g><g fill="#7e9950"><path d="M0-8Q-13-19-11-35 3-29 0-8"/><path d="M1-8Q6-34 16-28 18-12 1-8"/><path d="M-2-7Q-15-22-22-13-13-5-2-7"/><path d="M3-7Q14-21 20-11 11-5 3-7"/></g><path d="M0-8v-28" stroke="#b0b777" stroke-width="1"/></g>
<g id="smallPlant"><path d="M-5-1-4 8Q0 10 4 8L5-1" fill="#eaece2" stroke="#b2baaa" stroke-width=".5"/><ellipse rx="5" ry="2.5" fill="#6f7754"/><path d="M0 1Q-13-7-6-10L0-3Q-3-16 3-15L3-4Q13-13 10-5L0 1" fill="#68864d"/><path d="M0 2V-10" stroke="#8c9e67"/></g>
<g id="guestChair"><ellipse cy="20" rx="23" ry="8" fill="#34463a" opacity=".08"/><path d="M-13 11-14 27M13 11l1 16" stroke="#727a70" stroke-width="2"/><path d="M-18-8Q0-17 18-8L17 12Q0 20-17 12Z" fill="url(#chair)"/><path d="M-20-11Q0-23 20-11L17 2Q0-5-17 2Z" fill="#4b5856"/><path d="M-17-8Q0-17 17-8" stroke="#6e7a70" fill="none"/></g>`;
$('#mapDefs').innerHTML=defs;
let isometric=true;
const projection='matrix(.86 .12 -.32 .76 220 8)';
function hGlass(x,y,w){
 const panels=Math.max(1,Math.round(w/220));
 return `<g class="om-glass-wall"><path d="M${x} ${y}v-42h${w}v42Z" fill="url(#glass)" stroke="#8fb9c5" stroke-opacity=".55" stroke-width="1"/><path d="M${x} ${y-42}h${w}" stroke="#f8ffff" stroke-width="3"/><rect x="${x+2}" y="${y+1}" width="${Math.max(1,w-4)}" height="3" rx="1.5" fill="#366b82" opacity=".07"/><rect x="${x}" y="${y-19}" width="${w}" height="20" rx="1.5" fill="url(#glass)" stroke="#9fbdc9" stroke-opacity=".48" stroke-width=".8"/><path d="M${x+1} ${y-18}h${w-2}" stroke="#ffffff" stroke-opacity=".95" stroke-width="1.5"/><path d="M${x} ${y}h${w}" stroke="#82a8b9" stroke-opacity=".64" stroke-width="1.3"/>${Array.from({length:panels-1},(_,i)=>`<path d="M${x+(i+1)*w/panels} ${y-18}v17" stroke="#9cb9c5" stroke-opacity=".43" stroke-width=".7"/>`).join('')}<path d="M${x+4} ${y-10}h${Math.max(0,w-8)}" stroke="#ffffff" stroke-opacity=".36" stroke-width="2"/></g>`;
}
function vGlass(x,y,h){
 return `<g class="om-glass-wall"><path d="M${x} ${y}l-13-39v${h}l13 39Z" fill="url(#glass)" stroke="#a0c1cd" stroke-opacity=".7"/><path d="M${x-13} ${y-39}v${h}" stroke="#f2fcfe" stroke-width="2"/><rect x="${x+5}" y="${y-16}" width="5" height="${h+16}" rx="2" fill="#366b82" opacity=".045"/><rect x="${x}" y="${y-18}" width="7" height="${h+18}" rx="1.8" fill="url(#glass)" stroke="#9fbdc9" stroke-opacity=".46" stroke-width=".8"/><path d="M${x+1.3} ${y-16}v${h+13}" stroke="#ffffff" stroke-opacity=".85" stroke-width="1.4"/><path d="M${x+6} ${y-17}v${h+16}" stroke="#7fa6b7" stroke-opacity=".55" stroke-width="1.1"/></g>`;
}
function plantAt(x,y,s=1){return `<use href="#plant" class="decorative" transform="translate(${x} ${y}) scale(${s})"/>`}
function roomLabel(x,y,name,count=''){return `<text x="${x}" y="${y}" class="zone-label">${name}<tspan dx="12" class="zone-count">${count}</tspan></text>`}
function renderArchitecture(){
 $('#officeWorld').setAttribute('transform',isometric?projection:'');
 $('#architecture').innerHTML=`
 <g filter="url(#floorShadow)"><path d="M43 770h1236v28H43Z" fill="#acc4cf"/><path d="M1279 64v734l18-10V56Z" fill="#8faebb"/><path d="M43 63H1279V780H43Z" fill="#c9dce2"/><path d="M43 64H1279V770H43Z" fill="url(#floor)"/><path d="M43 64H1279V770H43Z" fill="url(#tile)"/><path d="M43 770h1236v10H43Z" fill="#d5e5e9"/></g>
 <rect x="940" y="64" width="339" height="262" fill="#f0f4f6"/><rect x="940" y="64" width="339" height="262" fill="url(#tile)"/><rect x="970" y="143" width="263" height="155" rx="3" fill="#c0d6db" opacity=".28"/><path d="M974 147h255v147H974Z" fill="none" stroke="#adc5cf" stroke-opacity=".2"/>
 <rect x="1040" y="352" width="239" height="174" fill="#edf4f7"/><rect x="1040" y="352" width="239" height="174" fill="url(#tile)"/>
 <path d="M57 450h665v314H57Z" fill="#ffffff" opacity=".16"/><path d="M786 565h482v199H786Z" fill="#ffffff" opacity=".2"/>
 ${hGlass(43,64,1236)}${vGlass(43,64,706)}${vGlass(1267,64,706)}
 <g class="decorative"><path d="M56 63h1220" stroke="#effbfd" stroke-width="1.8"/><path d="M316 48h313M642 48h248M954 48h274" stroke="#607985" stroke-width="2" stroke-opacity=".3"/></g>
 ${vGlass(891,64,330)}${hGlass(891,64,30)}${vGlass(929,64,262)}${hGlass(938,326,329)}${vGlass(1029,352,174)}${hGlass(1040,526,227)}
 ${hGlass(54,432,837)}${vGlass(731,450,320)}${hGlass(781,565,486)}${vGlass(770,565,119)}${vGlass(770,736,34)}
 <g class="decorative"><path d="M774 736h50a50 50 0 0 0-50-50" fill="none" stroke="#a4bcc6" stroke-width="1" stroke-dasharray="3 3"/><path d="M774 736h50" stroke="#92bac8" stroke-width="2"/><path d="M935 356v45a45 45 0 0 1-45-45" fill="none" stroke="#a6c1cb" stroke-dasharray="3 3"/><path d="M935 356v45" stroke="#92b4c1" stroke-width="2"/></g>
 ${roomLabel(119,97,'IT DEPARTMENT','08 desks')}${roomLabel(119,464,'SEO DEPARTMENT','06 desks')}${roomLabel(831,589,'CALLING DEPARTMENT','02 desks')}
 <text x="1100" y="98" text-anchor="middle" class="zone-label-small">OWNER CABIN</text><text x="1155" y="373" text-anchor="middle" class="zone-label-small">KITCHEN & BREAK</text>
 <g class="decorative" filter="url(#softShadow)"><path d="M976 116h245v32H976Z" fill="url(#darkwood)"/><path d="M976 116h245v-8H976Z" fill="#b49a77"/><path d="M1053 121v22M1139 121v22" stroke="#674f3f" stroke-opacity=".5"/><path d="M988 128h19M1070 128h19M1156 128h19" stroke="#c1b091" stroke-width="1.2"/><path d="M1054 107h21v-12h-21Z" fill="#91a09e"/><path d="M1059 106V96M1064 106V94M1069 106v-13" stroke="#dddccb" stroke-width="2"/><use href="#smallPlant" x="1185" y="101"/></g>
 <g transform="translate(1100 174)"><ellipse cy="29" rx="27" ry="10" fill="#6a7262" opacity=".13"/><rect x="-21" y="-11" width="42" height="39" rx="10" fill="url(#chair)"/><path d="M-24 30-20 9Q0-3 20 9l4 21Z" fill="url(#suit)"/><path d="m-7 8 7 14 7-14" fill="#e5e8e1"/><ellipse cy="0" rx="11" ry="12" fill="url(#skin)"/><path d="M-11 0Q-15-19 0-18T11 0L7-7Q0-3-8-7Z" fill="url(#hair)"/></g>
 <g transform="translate(1100 213)" filter="url(#softShadow)"><path d="M-94 0h188l4 51H-98Z" fill="url(#darkwood)"/><path d="M-98 51H98v7H-98Z" fill="#816346"/><path d="M-90 58v15M90 58v15" stroke="#594b3e" stroke-width="5"/><rect x="-28" y="7" width="56" height="29" rx="2" fill="#667270" stroke="#394a45"/><path d="M-32 37h64l-7 5h-50Z" fill="#a1aba1"/><circle cy="22" r="2" fill="#d4d9cb"/><rect x="-77" y="12" width="26" height="30" rx="1" fill="#363f3c"/><path d="M-74 14v24" stroke="#b4ab8c" stroke-width="2"/><ellipse cx="64" cy="35" rx="11" ry="6" fill="#e0dec9"/><ellipse cx="64" cy="31" rx="7" ry="5" fill="#faf9ec"/><ellipse cx="64" cy="29" rx="5" ry="3" fill="#725b41"/><use href="#smallPlant" x="79" y="9"/></g>
 <use href="#guestChair" transform="translate(1055 290) scale(.78)"/><use href="#guestChair" transform="translate(1150 290) scale(.78)"/>
 <g class="decorative"><rect x="1237" y="110" width="28" height="53" rx="2" fill="#e9e9df" stroke="#788876" stroke-width="2"/><path d="M1242 126h18M1245 132h12M1242 138h18M1245 145h12" stroke="#96a18e" stroke-width="2"/></g>
 <g filter="url(#softShadow)"><rect x="1053" y="411" width="175" height="31" rx="1" fill="#8399a2"/><path d="M1051 397h180v18h-180Z" fill="#e5edef" stroke="#adbdc5"/><path d="M1110 417v23M1166 417v23" stroke="#626d5c"/><path d="M1111 400h34v12h-34Z" fill="#788879" stroke="#c5d1be" stroke-width="2"/><path d="M1127 407v-18q0-8 7-8q7 0 7 6" fill="none" stroke="#90a08c" stroke-width="3"/><rect x="1067" y="378" width="24" height="28" rx="3" fill="#45554d"/><rect x="1071" y="383" width="16" height="11" rx="1" fill="#809185"/><path d="M1078 396v6" stroke="#e1e6d8" stroke-width="2"/><path d="M1170 399h9v8h-9Zm14 0h9v8h-9Zm14 0h9v8h-9Z" fill="#f7f5e6"/><rect x="1236" y="381" width="29" height="70" rx="2" fill="#d1dfe5" stroke="#adc0c9"/><path d="M1237 407h27M1241 394v8m0 13v16" stroke="#89a1ad" stroke-width="1.6"/></g>
 <use href="#guestChair" transform="translate(1123 472) rotate(-70) scale(.68)"/><use href="#guestChair" transform="translate(1195 481) rotate(65) scale(.68)"/><g filter="url(#softShadow)"><path d="M1159 483v28" stroke="#8c9b85" stroke-width="3"/><ellipse cx="1159" cy="480" rx="29" ry="22" fill="#eeefe4" stroke="#ccd3c1"/><use href="#smallPlant" x="1159" y="473"/></g>
 <g class="decorative" filter="url(#softShadow)"><path d="M64 548h29v139H64Z" fill="url(#darkwood)"/><path d="M61 544h34v7H61Z" fill="#a79779"/><use href="#smallPlant" x="79" y="571"/><use href="#smallPlant" x="79" y="640"/><path d="M1245 620h27v98h-27Z" fill="url(#darkwood)"/><path d="M1242 615h30v6h-30Z" fill="#b1a181"/><use href="#smallPlant" x="1257" y="639"/><use href="#smallPlant" x="1257" y="685"/></g>
 ${plantAt(87,124,.86)}${plantAt(850,113,.85)}${plantAt(81,384,.65)}${plantAt(977,121,.58)}${plantAt(1246,194,.6)}${plantAt(1215,397,.35)}${plantAt(81,516,.55)}${plantAt(80,745,.8)}${plantAt(686,749,.8)}${plantAt(821,744,.7)}${plantAt(1251,590,.6)}
 ${hGlass(43,774,688)}${hGlass(781,774,498)}<path d="M742 770v18h29v-18" fill="#e2edf2" stroke="#a2b9c5" stroke-width="1"/><path d="m750 779 6-7 6 7M756 775v12" stroke="#8badbb" fill="none"/><text x="757" y="805" text-anchor="middle" class="entrance-label">ENTRANCE</text>
 <g class="decorative" fill="#8fadb9" fill-opacity=".6"><rect x="42" y="45" width="5" height="19" rx="1.5"/><rect x="1266" y="45" width="5" height="19" rx="1.5"/><rect x="731" y="757" width="4" height="18" rx="1.2"/><rect x="780" y="757" width="4" height="18" rx="1.2"/></g>`;
}
function deskSVG(s,{preview=false}={}){
 const st=s.status, present=st==='present',free=st==='free';const color=present?'#14805d':free?'#748a99':'#c94e62';const bg=present?'#e6f6ee':free?'#f0f5f8':'#fcecef';const short=s.name?s.name.split(' ')[0]:'Available';
 return `<g ${preview?'':`class="seat${s.id===selectedId?' selected':''}" tabindex="0" role="button" data-id="${s.id}" aria-label="${escapeHTML(s.id+', '+(s.name||'Unallocated')+', '+statusNames[st])}"`} transform="translate(${preview?0:s.x} ${preview?0:s.y}) scale(${preview?1:isometric?.66:.82}) ${!preview&&isometric?'matrix(1.09827 -.17341 .46243 1.24277 0 0)':''}">
 <title>${escapeHTML(s.id+' · '+(s.name||'Available desk')+' · '+statusNames[st])}</title>
 <rect class="selection-ring" x="-82" y="-42" width="164" height="174" rx="16" fill="#7dcfdc" fill-opacity=".09" stroke="#0da8b4" stroke-width="1.5" stroke-dasharray="4 3"/>
 <ellipse cx="2" cy="63" rx="70" ry="25" fill="#6d715b" opacity=".10"/>
 <g filter="url(#softShadow)"><path d="M-64 37v32M64 37v32" stroke="#666d60" stroke-width="3.5"/><path d="M-58 6v52M58 6v52" stroke="#8a8d76" stroke-width="3"/><path d="M-65 41H65v6H-65Z" fill="#c8a576"/><path d="M-60-5H60l5 46H-65Z" fill="url(#wood)" stroke="#c7ab81" stroke-width=".8"/><path d="M-58-2H58M-59 11H59M-62 32H62" stroke="#a88964" stroke-opacity=".13"/><path d="M-59 0h18M19 0h37M-48 16h72M-52 36h24M35 36h21" stroke="#f8e5c8" stroke-width=".7" opacity=".6"/></g>
 <g filter="url(#tinyShadow)"><path d="M-5 14v9h10v-9" fill="#68726a"/><ellipse cy="24" rx="15" ry="3" fill="#788075"/><rect x="-27" y="-6" width="54" height="28" rx="2" fill="url(#monitor)" stroke="#78817a" stroke-width=".6"/><rect x="-24" y="-3" width="48" height="21" rx=".6" fill="${present?'url(#screen)':'#334342'}"/>${present?'<g class="om-screen-code"><rect x="-20" y="0" width="29" height="3" rx=".5" fill="#dbe7dc" opacity=".8"/><rect x="-20" y="6" width="13" height="8" rx=".5" fill="#a6c3bc" opacity=".75"/><path d="M-3 7h22M-3 10h17M-3 13h20" stroke="#b3ccbe" stroke-width="1"/></g><rect class="om-screen-cursor" x="17" y="11" width="2" height="5" fill="#edfaff"/>':'<path d="m-23-2 23 19h23V-2Z" fill="#52625b" opacity=".16"/>'}<circle cy="20" r=".7" fill="${present?'#a7cba8':'#69796c'}"/></g>
 <path d="M-19 27h38l3 9h-44Z" fill="#d9dbcb" stroke="#a6ad9c" stroke-width=".6"/><path d="M-16 30h32M-15 33h31" stroke="#9da795" stroke-width="1" stroke-dasharray="2 1"/><path d="M-10 29v5M-4 29v5M2 29v5M8 29v5M14 29v5" stroke="#b2b9a5" stroke-width=".6"/><ellipse cx="30" cy="32" rx="4" ry="6" fill="#cfd5c5" stroke="#9ca895" stroke-width=".5"/>
 <g class="decorative"><use href="#smallPlant" transform="translate(47 12) scale(.7)"/><path d="M-50 13h11l-1 11h-9Z" fill="#f3f2e6" stroke="#b4b5a4" stroke-width=".5"/><ellipse cx="-44.5" cy="13" rx="5.5" ry="2.5" fill="#827356"/><path d="M-49 16h-4v6h4" fill="none" stroke="#d9dacc" stroke-width="1.5"/><rect x="-53" y="29" width="9" height="14" rx="1.5" fill="#506156" transform="rotate(-8 -48 36)"/><rect x="-51" y="31" width="5" height="8" fill="#758f7e"/></g>
 <g><path d="M0 65v27M-19 101l19-9 19 9M0 91v14M-17 87l17 5 17-5" stroke="#626e63" stroke-width="2.2"/><circle cx="-19" cy="101" r="2.3" fill="#465247"/><circle cx="19" cy="101" r="2.3" fill="#465247"/><circle cy="105" r="2.3" fill="#465247"/><path d="M-20 43Q0 36 20 43l3 27Q0 83-23 70Z" fill="url(#chair)"/><path d="M-20 44Q0 38 20 44" stroke="#788377" stroke-opacity=".5"/></g>
 ${present?`<g class="om-person"><path d="M-15 60-23 74l11 6 12-4 12 4 11-6-8-14Z" fill="#3f4f47"/><path d="M-22 45Q0 34 22 45l3 29Q0 88-25 74Z" fill="url(#shirt)"/><g class="om-typing-left"><path d="M-21 47-25 40-12 33" fill="none" stroke="#237f77" stroke-width="10" stroke-linecap="round"/><path d="M-12 33-7 31" stroke="url(#skin)" stroke-width="6" stroke-linecap="round"/></g><g class="om-typing-right"><path d="M21 47 25 40 12 33" fill="none" stroke="#36948b" stroke-width="10" stroke-linecap="round"/><path d="M12 33 7 31" stroke="url(#skin)" stroke-width="6" stroke-linecap="round"/></g><path d="M-17 49-16 72M17 49l-1 23" stroke="#205f61" fill="none" stroke-opacity=".35"/><path d="M-24 69q24 12 48 0" stroke="#67b5ae" fill="none" stroke-opacity=".3"/><g class="om-head"><rect x="-5" y="38" width="10" height="9" rx="3" fill="url(#skin)"/><ellipse cy="28" rx="12" ry="14" fill="url(#skin)"/><ellipse cx="-12" cy="31" rx="2" ry="4" fill="#cfa17b"/><ellipse cx="12" cy="31" rx="2" ry="4" fill="#cfa17b"/>${s.hair==='long'?'<path d="M-13 26Q-15 11 0 11T13 26l4 26Q0 59-17 51Z" fill="url(#hair)"/><path d="M-8 22v26M-3 19v33M5 20v30M10 25v22" stroke="#645047" stroke-opacity=".35" stroke-width="1"/>':'<path d="M-12 31Q-16 12 0 12T12 31Q7 43 0 41T-12 31Z" fill="url(#hair)"/><path d="M-8 19Q-3 14 7 18" fill="none" stroke="#79604d" stroke-opacity=".5" stroke-width="1.3"/>'}</g></g>`:''}
 <g><path d="M-25 57v17M25 57v17" stroke="#2d3d37" stroke-width="3"/><path d="M-28 55h8M20 55h8" stroke="#45554b" stroke-width="3.8" stroke-linecap="round"/><path d="M-23 76Q0 84 23 76l-2 13Q0 96-21 89Z" fill="url(#chair)" stroke="#566254" stroke-width=".6"/><path d="M-20 79Q0 86 20 79" fill="none" stroke="#7c8678" stroke-opacity=".35"/></g>
 <g class="badge"><rect x="-62" y="-34" width="124" height="23" rx="5" fill="${bg}" stroke="${color}" stroke-opacity=".18" stroke-width=".7"/>${present?`<circle class="om-presence-halo" cx="-50" cy="-22.5" r="6" fill="none" stroke="${color}" stroke-width="1.2" opacity=".2"/>`:""}<circle cx="-50" cy="-22.5" r="2.8" fill="${color}"/><text x="-42" y="-18.8" fill="${color}" class="status-text">${statusNames[st]}</text></g>
 <g class="name-label"><rect class="name-plate" x="-63" y="98" width="126" height="22" rx="5" fill="#ffffff" fill-opacity=".88" stroke="#dae8ec" stroke-width=".6"/><text x="0" y="113.5" text-anchor="middle" class="seat-name">${escapeHTML(short.length>15?short.slice(0,14)+'…':short)}</text><text x="0" y="132" text-anchor="middle" class="seat-code">${s.id}</text></g></g>`;
}

function renderSeats(reveal=false){ $('#seats').innerHTML=seats.map(s=>deskSVG(s)).join('');$$('#seats .seat').forEach(el=>{el.addEventListener('pointerenter',()=>deskHover(el,true));el.addEventListener('pointerleave',()=>deskHover(el,false));el.addEventListener('focus',()=>deskHover(el,true));el.addEventListener('blur',()=>deskHover(el,false));el.addEventListener('click',()=>{if(!didDrag)openDesk(el.dataset.id)});el.addEventListener('keydown',e=>{if(e.key==='Enter'||e.key===' '){e.preventDefault();openDesk(el.dataset.id)}})});setupSeatMotion(reveal);}
function refresh(){renderSeats();if($('#deskDialog').open)renderDetails()}
function openDesk(id){if(!seats.some(s=>s.id===id))return;lastFocus=document.activeElement;selectedId=id;$$('.seat').forEach(el=>el.classList.toggle('selected',el.dataset.id===id));renderDetails();$('#deskDialog').showModal();dialogAnimation?.stop();if(motionEnabled)dialogAnimation=animate($('#deskDialog'),{opacity:[0,1],scale:[.94,1],y:[15,0]},{type:'spring',stiffness:320,damping:28});$('#closeDetails').focus()}
async function closeDetails(){dialogAnimation?.stop();if(motionEnabled&&$('#deskDialog').open){dialogAnimation=animate($('#deskDialog'),{opacity:0,scale:.97,y:9},{duration:.17,ease:'easeIn'});await dialogAnimation.finished;}$('#deskDialog').close();$('#deskDialog').style.opacity=1;$('#deskDialog').style.transform='none';}
$('#closeDetails').addEventListener('click',closeDetails);$('#deskDialog').addEventListener('cancel',e=>{e.preventDefault();closeDetails()});$('#motionToggle').addEventListener('click',()=>setMotionEnabled(!motionEnabled));
$('#deskDialog').addEventListener('close',()=>{const previous=lastFocus?.isConnected?lastFocus:$('#seats .seat[data-id="'+selectedId+'"]');previous?.focus({preventScroll:true})});
$('#deskDialog').addEventListener('click',e=>{if(e.target!==$('#deskDialog'))return;const b=e.target.getBoundingClientRect();if(e.clientX<b.left||e.clientX>b.right||e.clientY<b.top||e.clientY>b.bottom)closeDetails()});
function renderDetails(){const s=seats.find(x=>x.id===selectedId);if(!s)return;const free=s.status==='free';$('#detailTitle').textContent=s.id+' · '+departmentNames[s.dept];$('#detailContent').innerHTML=`<div class="om-preview"><svg viewBox="-150 -49 300 207" aria-hidden="true">${deskSVG(s,{preview:true})}</svg></div><h2>${escapeHTML(s.name||'Available desk')}</h2><p class="om-role">${escapeHTML(s.role||'Ready for a new team member')}</p><span class="om-status ${s.status}"><i class="om-dot"></i>${statusNames[s.status]}</span><dl class="om-details"><div><dt>Department</dt><dd>${departmentNames[s.dept]}</dd></div><div><dt>Desk</dt><dd>${s.id} · Ground floor</dd></div>${!free?`<div><dt>Employee paycode</dt><dd>${escapeHTML(s.paycode)}</dd></div><div><dt>First punch today</dt><dd>${escapeHTML(s.time||'No punch recorded')}</dd></div>`:''}</dl>${isDemo?(free?`<form class="om-allocate" id="allocateForm"><label for="employeeName">Employee name</label><input id="employeeName" placeholder="e.g. Riya Sharma" maxlength="60" required><label for="employeePaycode">Employee paycode</label><input id="employeePaycode" placeholder="e.g. 00000017" inputmode="numeric" pattern="[0-9]{1,20}" maxlength="20" required><button class="om-btn primary" type="submit">Allocate desk</button></form>`:`<div class="om-actions"><button class="om-btn primary" id="togglePunch">${s.status==='present'?'Remove demo punch':'Record demo punch'}</button><button class="om-btn" id="releaseDesk">Unallocate desk</button></div>`):''}<p class="om-note">${isDemo?'Sample data. These actions update the demo in this browser.':'Loaded attendance snapshot.'}</p>${isDemo?'<button class="om-reset" id="resetDemo">Restore original sample data</button>':''}`;
 if($('#togglePunch'))$('#togglePunch').addEventListener('click',()=>{s.status=s.status==='present'?'absent':'present';s.time=s.status==='present'?new Intl.DateTimeFormat('en-GB',{timeZone:'Asia/Kolkata',hour:'2-digit',minute:'2-digit'}).format(new Date()):'';save();refresh();$('#togglePunch')?.focus();});
 if($('#releaseDesk'))$('#releaseDesk').addEventListener('click',()=>{Object.assign(s,{name:'',role:'',paycode:'',time:'',status:'free',hair:'short'});save();refresh();$('#employeeName')?.focus()});
 if($('#allocateForm'))$('#allocateForm').addEventListener('submit',e=>{e.preventDefault();const name=$('#employeeName').value.trim(),paycode=$('#employeePaycode').value.trim();if(!name){$('#employeeName').setCustomValidity('Enter a name.');$('#employeeName').reportValidity();return}if(seats.some(x=>x.id!==s.id&&x.paycode&&normalizePaycode(x.paycode)===normalizePaycode(paycode))){$('#employeePaycode').setCustomValidity('This employee already has an allocated desk.');$('#employeePaycode').reportValidity();return}Object.assign(s,{name,paycode,status:'absent',time:'',role:'Team member',hair:'short'});save();refresh();$('#togglePunch')?.focus()});
 $$('.om-allocate input').forEach(input=>input.addEventListener('input',()=>input.setCustomValidity('')));
 if($('#resetDemo'))$('#resetDemo').addEventListener('click',()=>{seats=initialSeats();save();refresh();closeDetails();toast('Original sample data restored.');});
}
let toastTimer;function toast(message){$('#toast').textContent=message;$('#toast').classList.add('show');clearTimeout(toastTimer);toastTimer=setTimeout(()=>$('#toast').classList.remove('show'),2800)}
let isMobile=root.clientWidth<=700,camera=isMobile?{scale:2.35,x:-280,y:-300}:{scale:1,x:0,y:0},didDrag=false,dragStart=null,pinch=null;const pointers=new Map();
function updateCamera(){$('#camera').setAttribute('transform',`translate(${camera.x} ${camera.y}) scale(${camera.scale})`);$('#zoomLabel').textContent=Math.round(camera.scale*100)+'%';$('#zoomOut').disabled=camera.scale<=.7;$('#zoomIn').disabled=camera.scale>=(isMobile?4.5:2.8)}
function tweenCamera(next){cameraAnimation?.stop();if(!motionEnabled){camera={...next};updateCamera();return}const start={...camera};cameraAnimation=animate(0,1,{duration:.38,ease:[.22,1,.36,1],onUpdate:p=>{camera={x:start.x+(next.x-start.x)*p,y:start.y+(next.y-start.y)*p,scale:start.scale+(next.scale-start.scale)*p};updateCamera()}})}
function setZoom(scale,point={x:660,y:395}){const next=Math.max(.7,Math.min(isMobile?4.5:2.8,scale)),ratio=next/camera.scale;tweenCamera({x:point.x-(point.x-camera.x)*ratio,y:point.y-(point.y-camera.y)*ratio,scale:next})}
function fit(){tweenCamera({scale:1,x:0,y:0})}
function svgPoint(e){return new DOMPoint(e.clientX,e.clientY).matrixTransform($('#officeMap').getScreenCTM().inverse())}
$('#viewToggle').addEventListener('click',()=>{isometric=!isometric;$('#officeWorld').setAttribute('transform',isometric?projection:'');renderSeats();$('#viewToggle').textContent=isometric?'3D':'2D';$('#viewToggle').setAttribute('aria-pressed',String(isometric));$('#viewToggle').setAttribute('aria-label',isometric?'Switch to top view':'Switch to 3D view');$('#viewToggle').title=isometric?'Switch to top view':'Switch to 3D view';fit()});
$('#zoomIn').addEventListener('click',()=>setZoom(camera.scale+.2));$('#zoomOut').addEventListener('click',()=>setZoom(camera.scale-.2));$('#fitBtn').addEventListener('click',fit);
$('#officeMap').addEventListener('pointerdown',e=>{if(e.button!==0)return;cameraAnimation?.stop();didDrag=false;const p=svgPoint(e);pointers.set(e.pointerId,p);dragStart={p,x:camera.x,y:camera.y};if(pointers.size===2){const [a,b]=[...pointers.values()];pinch={distance:Math.hypot(a.x-b.x,a.y-b.y),scale:camera.scale};didDrag=true}if(!e.target.closest('.seat'))$('#officeMap').setPointerCapture(e.pointerId)});
$('#officeMap').addEventListener('pointermove',e=>{if(!pointers.has(e.pointerId)||!dragStart)return;const p=svgPoint(e);pointers.set(e.pointerId,p);if(pointers.size===2&&pinch){const [a,b]=[...pointers.values()];setZoom(pinch.scale*Math.hypot(a.x-b.x,a.y-b.y)/pinch.distance,{x:(a.x+b.x)/2,y:(a.y+b.y)/2});didDrag=true;return}const dx=p.x-dragStart.p.x,dy=p.y-dragStart.p.y;if(Math.abs(dx)+Math.abs(dy)>5){didDrag=true;$('#officeMap').classList.add('panning');$('#officeMap').setPointerCapture(e.pointerId);camera.x=dragStart.x+dx;camera.y=dragStart.y+dy;updateCamera()}});
function endPointer(e){pointers.delete(e.pointerId);pinch=null;if(!pointers.size){dragStart=null;$('#officeMap').classList.remove('panning');setTimeout(()=>didDrag=false,50)}else dragStart={p:[...pointers.values()][0],x:camera.x,y:camera.y};}
$('#officeMap').addEventListener('pointerup',endPointer);$('#officeMap').addEventListener('pointercancel',endPointer);
$('#officeMap').addEventListener('wheel',e=>{if(e.ctrlKey||e.metaKey){e.preventDefault();setZoom(camera.scale*(e.deltaY<0?1.09:.92),svgPoint(e))}},{passive:false});
$('#fullscreenBtn').addEventListener('click',async()=>{try{if(document.fullscreenElement===root)await document.exitFullscreen();else if(root.requestFullscreen)await root.requestFullscreen();else toast('Fullscreen is not available in this browser.')}catch(e){toast('Open the HTML file directly to use fullscreen.')}});
document.addEventListener('fullscreenchange',()=>$('#fullscreenBtn').setAttribute('aria-label',document.fullscreenElement===root?'Exit fullscreen':'Enter fullscreen'));
new ResizeObserver(()=>{const mobile=root.clientWidth<=700;if(mobile!==isMobile){isMobile=mobile;camera=mobile?{scale:2.35,x:-280,y:-300}:{scale:1,x:0,y:0};updateCamera()}}).observe(root);
root.addEventListener('keydown',e=>{if($('#deskDialog').open||/INPUT|TEXTAREA|SELECT/.test(document.activeElement.tagName))return;if(e.key==='+'||e.key==='='){e.preventDefault();setZoom(camera.scale+.2)}if(e.key==='-'){e.preventDefault();setZoom(camera.scale-.2)}if(e.key==='0')fit()});
function normalizePaycode(value){const v=String(value??'').trim();return /^\d+$/.test(v)?v.replace(/^0+(?=\d)/,''):v;}
function punchInfo(value){if(typeof value!=='string')return null;const sql=value.match(/^(\d{4}-\d{2}-\d{2})[ T](\d{2}:\d{2})(?::\d{2}(?:\.\d+)?)?$/);if(sql){const stamp=Date.parse(value.replace(' ','T')+'+05:30');return Number.isNaN(stamp)?null:{day:sql[1],time:sql[2],stamp}}const parsed=new Date(value);if(Number.isNaN(parsed.getTime()))return null;return {day:localDay(parsed),time:new Intl.DateTimeFormat('en-GB',{timeZone:'Asia/Kolkata',hour:'2-digit',minute:'2-digit'}).format(parsed),stamp:parsed.getTime()};}
window.OfficeMap={setTopView(){isometric=false;renderArchitecture();renderSeats();},normalizePaycode,getData:()=>JSON.parse(JSON.stringify(seats)),fit,load({users=[],punches=[],allocations=[],date=today}={}){const userMap=new Map(users.map(u=>[String(u.id),u])),allocationsMap=new Map(allocations.map(a=>[String(a.desk_id),a.user_id])),punchesMap=new Map();punches.forEach(p=>{const key=normalizePaycode(p.employee_no),info=punchInfo(p.punched_at);if(key&&info?.day===date&&(!punchesMap.has(key)||info.stamp<punchesMap.get(key).stamp))punchesMap.set(key,info)});seats=deskConfig.map(d=>{const u=userMap.get(String(allocationsMap.get(d.id)));if(!u)return {...d,name:'',role:'',paycode:'',status:'free',time:'',hair:'short'};const punch=punchesMap.get(normalizePaycode(u.paycode));return {...d,name:String(u.name||'Team member'),role:String(u.role||'Team member'),paycode:String(u.paycode??''),status:punch?'present':'absent',time:punch?.time||'',hair:u.avatar_hair==='long'?'long':'short'}});isDemo=false;selectedId=null;if($('#deskDialog').open)closeDetails();$('#dataMode').textContent='Attendance · '+date;refresh();}};
renderArchitecture();renderSeats(true);updateCamera();if(motionEnabled){animate($('#architecture'),{opacity:[0,1]},{duration:.85,ease:'easeOut'});animate($('.om-logo'),{opacity:[0,1],y:[-6,0]},{duration:.6,ease:'easeOut'});}setMotionButton();
function setMotionButton(){$('#motionToggle').setAttribute('aria-pressed',String(!motionEnabled));$('#motionToggle').setAttribute('aria-label',motionEnabled?'Pause animations':'Resume animations')}
})();
</script>
<script>
(()=>{var Gn={LEFT:0,MIDDLE:1,RIGHT:2,ROTATE:0,DOLLY:1,PAN:2},Wn={ROTATE:0,PAN:1,DOLLY_PAN:2,DOLLY_ROTATE:3},Nl=0,fo=1,Fl=2;var po=1,Rr=2,pn=3,Tn=0,De=1,mn=2,wn=0,ei=1,mo=2,go=3,_o=4,Ol=5,On=100,Bl=101,zl=102,kl=103,Vl=104,Hl=200,Gl=201,Wl=202,Xl=203,or=204,lr=205,ql=206,Yl=207,Zl=208,Jl=209,$l=210,Kl=211,jl=212,Ql=213,tc=214,Ir=0,Pr=1,Dr=2,ni=3,Lr=4,Ur=5,Nr=6,Fr=7,xo=0,ec=1,nc=2,An=0,ic=1,sc=2,rc=3,Or=4,ac=5,oc=6,lc=7;var yo=300,ci=301,hi=302,Br=303,zr=304,Is=306,cr=1e3,Fn=1001,hr=1002,Ze=1003,cc=1004;var Ps=1005;var nn=1006,kr=1007;var Xn=1008;var an=1009,vo=1010,Mo=1011,Hi=1012,Vr=1013,qn=1014,gn=1015,Gi=1016,Hr=1017,Gr=1018,Wi=1020,So=35902,bo=35899,Eo=1021,To=1022,$e=1023,Li=1026,Xi=1027,wo=1028,Wr=1029,Ao=1030,Xr=1031;var qr=1033,Ds=33776,Ls=33777,Us=33778,Ns=33779,Yr=35840,Zr=35841,Jr=35842,$r=35843,Kr=36196,jr=37492,Qr=37496,ta=37808,ea=37809,na=37810,ia=37811,sa=37812,ra=37813,aa=37814,oa=37815,la=37816,ca=37817,ha=37818,ua=37819,da=37820,fa=37821,pa=36492,ma=36494,ga=36495,_a=36283,xa=36284,ya=36285,va=36286;var ls=2300,ur=2301,ar=2302,io=2400,so=2401,ro=2402;var hc=3200,uc=3201;var Co=0,dc=1,Cn="",Te="srgb",ii="srgb-linear",cs="linear",Zt="srgb";var ti=7680;var ao=519,fc=512,pc=513,mc=514,Ro=515,gc=516,_c=517,xc=518,yc=519,oo=35044;var Io="300 es",en=2e3,hs=2001;var un=class{addEventListener(t,e){this._listeners===void 0&&(this._listeners={});let n=this._listeners;n[t]===void 0&&(n[t]=[]),n[t].indexOf(e)===-1&&n[t].push(e)}hasEventListener(t,e){let n=this._listeners;return n===void 0?!1:n[t]!==void 0&&n[t].indexOf(e)!==-1}removeEventListener(t,e){let n=this._listeners;if(n===void 0)return;let s=n[t];if(s!==void 0){let r=s.indexOf(e);r!==-1&&s.splice(r,1)}}dispatchEvent(t){let e=this._listeners;if(e===void 0)return;let n=e[t.type];if(n!==void 0){t.target=this;let s=n.slice(0);for(let r=0,a=s.length;r<a;r++)s[r].call(this,t);t.target=null}}},be=["00","01","02","03","04","05","06","07","08","09","0a","0b","0c","0d","0e","0f","10","11","12","13","14","15","16","17","18","19","1a","1b","1c","1d","1e","1f","20","21","22","23","24","25","26","27","28","29","2a","2b","2c","2d","2e","2f","30","31","32","33","34","35","36","37","38","39","3a","3b","3c","3d","3e","3f","40","41","42","43","44","45","46","47","48","49","4a","4b","4c","4d","4e","4f","50","51","52","53","54","55","56","57","58","59","5a","5b","5c","5d","5e","5f","60","61","62","63","64","65","66","67","68","69","6a","6b","6c","6d","6e","6f","70","71","72","73","74","75","76","77","78","79","7a","7b","7c","7d","7e","7f","80","81","82","83","84","85","86","87","88","89","8a","8b","8c","8d","8e","8f","90","91","92","93","94","95","96","97","98","99","9a","9b","9c","9d","9e","9f","a0","a1","a2","a3","a4","a5","a6","a7","a8","a9","aa","ab","ac","ad","ae","af","b0","b1","b2","b3","b4","b5","b6","b7","b8","b9","ba","bb","bc","bd","be","bf","c0","c1","c2","c3","c4","c5","c6","c7","c8","c9","ca","cb","cc","cd","ce","cf","d0","d1","d2","d3","d4","d5","d6","d7","d8","d9","da","db","dc","dd","de","df","e0","e1","e2","e3","e4","e5","e6","e7","e8","e9","ea","eb","ec","ed","ee","ef","f0","f1","f2","f3","f4","f5","f6","f7","f8","f9","fa","fb","fc","fd","fe","ff"],fl=1234567,as=Math.PI/180,Ui=180/Math.PI;function qi(){let i=Math.random()*4294967295|0,t=Math.random()*4294967295|0,e=Math.random()*4294967295|0,n=Math.random()*4294967295|0;return(be[i&255]+be[i>>8&255]+be[i>>16&255]+be[i>>24&255]+"-"+be[t&255]+be[t>>8&255]+"-"+be[t>>16&15|64]+be[t>>24&255]+"-"+be[e&63|128]+be[e>>8&255]+"-"+be[e>>16&255]+be[e>>24&255]+be[n&255]+be[n>>8&255]+be[n>>16&255]+be[n>>24&255]).toLowerCase()}function zt(i,t,e){return Math.max(t,Math.min(e,i))}function Po(i,t){return(i%t+t)%t}function bh(i,t,e,n,s){return n+(i-t)*(s-n)/(e-t)}function Eh(i,t,e){return i!==t?(e-i)/(t-i):0}function os(i,t,e){return(1-e)*i+e*t}function Th(i,t,e,n){return os(i,t,1-Math.exp(-e*n))}function wh(i,t=1){return t-Math.abs(Po(i,t*2)-t)}function Ah(i,t,e){return i<=t?0:i>=e?1:(i=(i-t)/(e-t),i*i*(3-2*i))}function Ch(i,t,e){return i<=t?0:i>=e?1:(i=(i-t)/(e-t),i*i*i*(i*(i*6-15)+10))}function Rh(i,t){return i+Math.floor(Math.random()*(t-i+1))}function Ih(i,t){return i+Math.random()*(t-i)}function Ph(i){return i*(.5-Math.random())}function Dh(i){i!==void 0&&(fl=i);let t=fl+=1831565813;return t=Math.imul(t^t>>>15,t|1),t^=t+Math.imul(t^t>>>7,t|61),((t^t>>>14)>>>0)/4294967296}function Lh(i){return i*as}function Uh(i){return i*Ui}function Nh(i){return(i&i-1)===0&&i!==0}function Fh(i){return Math.pow(2,Math.ceil(Math.log(i)/Math.LN2))}function Oh(i){return Math.pow(2,Math.floor(Math.log(i)/Math.LN2))}function Bh(i,t,e,n,s){let r=Math.cos,a=Math.sin,o=r(e/2),l=a(e/2),c=r((t+n)/2),u=a((t+n)/2),d=r((t-n)/2),f=a((t-n)/2),p=r((n-t)/2),_=a((n-t)/2);switch(s){case"XYX":i.set(o*u,l*d,l*f,o*c);break;case"YZY":i.set(l*f,o*u,l*d,o*c);break;case"ZXZ":i.set(l*d,l*f,o*u,o*c);break;case"XZX":i.set(o*u,l*_,l*p,o*c);break;case"YXY":i.set(l*p,o*u,l*_,o*c);break;case"ZYZ":i.set(l*_,l*p,o*u,o*c);break;default:console.warn("THREE.MathUtils: .setQuaternionFromProperEuler() encountered an unknown order: "+s)}}function Pi(i,t){switch(t.constructor){case Float32Array:return i;case Uint32Array:return i/4294967295;case Uint16Array:return i/65535;case Uint8Array:return i/255;case Int32Array:return Math.max(i/2147483647,-1);case Int16Array:return Math.max(i/32767,-1);case Int8Array:return Math.max(i/127,-1);default:throw new Error("Invalid component type.")}}function Ie(i,t){switch(t.constructor){case Float32Array:return i;case Uint32Array:return Math.round(i*4294967295);case Uint16Array:return Math.round(i*65535);case Uint8Array:return Math.round(i*255);case Int32Array:return Math.round(i*2147483647);case Int16Array:return Math.round(i*32767);case Int8Array:return Math.round(i*127);default:throw new Error("Invalid component type.")}}var Do={DEG2RAD:as,RAD2DEG:Ui,generateUUID:qi,clamp:zt,euclideanModulo:Po,mapLinear:bh,inverseLerp:Eh,lerp:os,damp:Th,pingpong:wh,smoothstep:Ah,smootherstep:Ch,randInt:Rh,randFloat:Ih,randFloatSpread:Ph,seededRandom:Dh,degToRad:Lh,radToDeg:Uh,isPowerOfTwo:Nh,ceilPowerOfTwo:Fh,floorPowerOfTwo:Oh,setQuaternionFromProperEuler:Bh,normalize:Ie,denormalize:Pi},Rt=class i{constructor(t=0,e=0){i.prototype.isVector2=!0,this.x=t,this.y=e}get width(){return this.x}set width(t){this.x=t}get height(){return this.y}set height(t){this.y=t}set(t,e){return this.x=t,this.y=e,this}setScalar(t){return this.x=t,this.y=t,this}setX(t){return this.x=t,this}setY(t){return this.y=t,this}setComponent(t,e){switch(t){case 0:this.x=e;break;case 1:this.y=e;break;default:throw new Error("index is out of range: "+t)}return this}getComponent(t){switch(t){case 0:return this.x;case 1:return this.y;default:throw new Error("index is out of range: "+t)}}clone(){return new this.constructor(this.x,this.y)}copy(t){return this.x=t.x,this.y=t.y,this}add(t){return this.x+=t.x,this.y+=t.y,this}addScalar(t){return this.x+=t,this.y+=t,this}addVectors(t,e){return this.x=t.x+e.x,this.y=t.y+e.y,this}addScaledVector(t,e){return this.x+=t.x*e,this.y+=t.y*e,this}sub(t){return this.x-=t.x,this.y-=t.y,this}subScalar(t){return this.x-=t,this.y-=t,this}subVectors(t,e){return this.x=t.x-e.x,this.y=t.y-e.y,this}multiply(t){return this.x*=t.x,this.y*=t.y,this}multiplyScalar(t){return this.x*=t,this.y*=t,this}divide(t){return this.x/=t.x,this.y/=t.y,this}divideScalar(t){return this.multiplyScalar(1/t)}applyMatrix3(t){let e=this.x,n=this.y,s=t.elements;return this.x=s[0]*e+s[3]*n+s[6],this.y=s[1]*e+s[4]*n+s[7],this}min(t){return this.x=Math.min(this.x,t.x),this.y=Math.min(this.y,t.y),this}max(t){return this.x=Math.max(this.x,t.x),this.y=Math.max(this.y,t.y),this}clamp(t,e){return this.x=zt(this.x,t.x,e.x),this.y=zt(this.y,t.y,e.y),this}clampScalar(t,e){return this.x=zt(this.x,t,e),this.y=zt(this.y,t,e),this}clampLength(t,e){let n=this.length();return this.divideScalar(n||1).multiplyScalar(zt(n,t,e))}floor(){return this.x=Math.floor(this.x),this.y=Math.floor(this.y),this}ceil(){return this.x=Math.ceil(this.x),this.y=Math.ceil(this.y),this}round(){return this.x=Math.round(this.x),this.y=Math.round(this.y),this}roundToZero(){return this.x=Math.trunc(this.x),this.y=Math.trunc(this.y),this}negate(){return this.x=-this.x,this.y=-this.y,this}dot(t){return this.x*t.x+this.y*t.y}cross(t){return this.x*t.y-this.y*t.x}lengthSq(){return this.x*this.x+this.y*this.y}length(){return Math.sqrt(this.x*this.x+this.y*this.y)}manhattanLength(){return Math.abs(this.x)+Math.abs(this.y)}normalize(){return this.divideScalar(this.length()||1)}angle(){return Math.atan2(-this.y,-this.x)+Math.PI}angleTo(t){let e=Math.sqrt(this.lengthSq()*t.lengthSq());if(e===0)return Math.PI/2;let n=this.dot(t)/e;return Math.acos(zt(n,-1,1))}distanceTo(t){return Math.sqrt(this.distanceToSquared(t))}distanceToSquared(t){let e=this.x-t.x,n=this.y-t.y;return e*e+n*n}manhattanDistanceTo(t){return Math.abs(this.x-t.x)+Math.abs(this.y-t.y)}setLength(t){return this.normalize().multiplyScalar(t)}lerp(t,e){return this.x+=(t.x-this.x)*e,this.y+=(t.y-this.y)*e,this}lerpVectors(t,e,n){return this.x=t.x+(e.x-t.x)*n,this.y=t.y+(e.y-t.y)*n,this}equals(t){return t.x===this.x&&t.y===this.y}fromArray(t,e=0){return this.x=t[e],this.y=t[e+1],this}toArray(t=[],e=0){return t[e]=this.x,t[e+1]=this.y,t}fromBufferAttribute(t,e){return this.x=t.getX(e),this.y=t.getY(e),this}rotateAround(t,e){let n=Math.cos(e),s=Math.sin(e),r=this.x-t.x,a=this.y-t.y;return this.x=r*n-a*s+t.x,this.y=r*s+a*n+t.y,this}random(){return this.x=Math.random(),this.y=Math.random(),this}*[Symbol.iterator](){yield this.x,yield this.y}},Je=class{constructor(t=0,e=0,n=0,s=1){this.isQuaternion=!0,this._x=t,this._y=e,this._z=n,this._w=s}static slerpFlat(t,e,n,s,r,a,o){let l=n[s+0],c=n[s+1],u=n[s+2],d=n[s+3],f=r[a+0],p=r[a+1],_=r[a+2],v=r[a+3];if(o===0){t[e+0]=l,t[e+1]=c,t[e+2]=u,t[e+3]=d;return}if(o===1){t[e+0]=f,t[e+1]=p,t[e+2]=_,t[e+3]=v;return}if(d!==v||l!==f||c!==p||u!==_){let m=1-o,h=l*f+c*p+u*_+d*v,w=h>=0?1:-1,E=1-h*h;if(E>Number.EPSILON){let C=Math.sqrt(E),A=Math.atan2(C,h*w);m=Math.sin(m*A)/C,o=Math.sin(o*A)/C}let S=o*w;if(l=l*m+f*S,c=c*m+p*S,u=u*m+_*S,d=d*m+v*S,m===1-o){let C=1/Math.sqrt(l*l+c*c+u*u+d*d);l*=C,c*=C,u*=C,d*=C}}t[e]=l,t[e+1]=c,t[e+2]=u,t[e+3]=d}static multiplyQuaternionsFlat(t,e,n,s,r,a){let o=n[s],l=n[s+1],c=n[s+2],u=n[s+3],d=r[a],f=r[a+1],p=r[a+2],_=r[a+3];return t[e]=o*_+u*d+l*p-c*f,t[e+1]=l*_+u*f+c*d-o*p,t[e+2]=c*_+u*p+o*f-l*d,t[e+3]=u*_-o*d-l*f-c*p,t}get x(){return this._x}set x(t){this._x=t,this._onChangeCallback()}get y(){return this._y}set y(t){this._y=t,this._onChangeCallback()}get z(){return this._z}set z(t){this._z=t,this._onChangeCallback()}get w(){return this._w}set w(t){this._w=t,this._onChangeCallback()}set(t,e,n,s){return this._x=t,this._y=e,this._z=n,this._w=s,this._onChangeCallback(),this}clone(){return new this.constructor(this._x,this._y,this._z,this._w)}copy(t){return this._x=t.x,this._y=t.y,this._z=t.z,this._w=t.w,this._onChangeCallback(),this}setFromEuler(t,e=!0){let n=t._x,s=t._y,r=t._z,a=t._order,o=Math.cos,l=Math.sin,c=o(n/2),u=o(s/2),d=o(r/2),f=l(n/2),p=l(s/2),_=l(r/2);switch(a){case"XYZ":this._x=f*u*d+c*p*_,this._y=c*p*d-f*u*_,this._z=c*u*_+f*p*d,this._w=c*u*d-f*p*_;break;case"YXZ":this._x=f*u*d+c*p*_,this._y=c*p*d-f*u*_,this._z=c*u*_-f*p*d,this._w=c*u*d+f*p*_;break;case"ZXY":this._x=f*u*d-c*p*_,this._y=c*p*d+f*u*_,this._z=c*u*_+f*p*d,this._w=c*u*d-f*p*_;break;case"ZYX":this._x=f*u*d-c*p*_,this._y=c*p*d+f*u*_,this._z=c*u*_-f*p*d,this._w=c*u*d+f*p*_;break;case"YZX":this._x=f*u*d+c*p*_,this._y=c*p*d+f*u*_,this._z=c*u*_-f*p*d,this._w=c*u*d-f*p*_;break;case"XZY":this._x=f*u*d-c*p*_,this._y=c*p*d-f*u*_,this._z=c*u*_+f*p*d,this._w=c*u*d+f*p*_;break;default:console.warn("THREE.Quaternion: .setFromEuler() encountered an unknown order: "+a)}return e===!0&&this._onChangeCallback(),this}setFromAxisAngle(t,e){let n=e/2,s=Math.sin(n);return this._x=t.x*s,this._y=t.y*s,this._z=t.z*s,this._w=Math.cos(n),this._onChangeCallback(),this}setFromRotationMatrix(t){let e=t.elements,n=e[0],s=e[4],r=e[8],a=e[1],o=e[5],l=e[9],c=e[2],u=e[6],d=e[10],f=n+o+d;if(f>0){let p=.5/Math.sqrt(f+1);this._w=.25/p,this._x=(u-l)*p,this._y=(r-c)*p,this._z=(a-s)*p}else if(n>o&&n>d){let p=2*Math.sqrt(1+n-o-d);this._w=(u-l)/p,this._x=.25*p,this._y=(s+a)/p,this._z=(r+c)/p}else if(o>d){let p=2*Math.sqrt(1+o-n-d);this._w=(r-c)/p,this._x=(s+a)/p,this._y=.25*p,this._z=(l+u)/p}else{let p=2*Math.sqrt(1+d-n-o);this._w=(a-s)/p,this._x=(r+c)/p,this._y=(l+u)/p,this._z=.25*p}return this._onChangeCallback(),this}setFromUnitVectors(t,e){let n=t.dot(e)+1;return n<1e-8?(n=0,Math.abs(t.x)>Math.abs(t.z)?(this._x=-t.y,this._y=t.x,this._z=0,this._w=n):(this._x=0,this._y=-t.z,this._z=t.y,this._w=n)):(this._x=t.y*e.z-t.z*e.y,this._y=t.z*e.x-t.x*e.z,this._z=t.x*e.y-t.y*e.x,this._w=n),this.normalize()}angleTo(t){return 2*Math.acos(Math.abs(zt(this.dot(t),-1,1)))}rotateTowards(t,e){let n=this.angleTo(t);if(n===0)return this;let s=Math.min(1,e/n);return this.slerp(t,s),this}identity(){return this.set(0,0,0,1)}invert(){return this.conjugate()}conjugate(){return this._x*=-1,this._y*=-1,this._z*=-1,this._onChangeCallback(),this}dot(t){return this._x*t._x+this._y*t._y+this._z*t._z+this._w*t._w}lengthSq(){return this._x*this._x+this._y*this._y+this._z*this._z+this._w*this._w}length(){return Math.sqrt(this._x*this._x+this._y*this._y+this._z*this._z+this._w*this._w)}normalize(){let t=this.length();return t===0?(this._x=0,this._y=0,this._z=0,this._w=1):(t=1/t,this._x=this._x*t,this._y=this._y*t,this._z=this._z*t,this._w=this._w*t),this._onChangeCallback(),this}multiply(t){return this.multiplyQuaternions(this,t)}premultiply(t){return this.multiplyQuaternions(t,this)}multiplyQuaternions(t,e){let n=t._x,s=t._y,r=t._z,a=t._w,o=e._x,l=e._y,c=e._z,u=e._w;return this._x=n*u+a*o+s*c-r*l,this._y=s*u+a*l+r*o-n*c,this._z=r*u+a*c+n*l-s*o,this._w=a*u-n*o-s*l-r*c,this._onChangeCallback(),this}slerp(t,e){if(e===0)return this;if(e===1)return this.copy(t);let n=this._x,s=this._y,r=this._z,a=this._w,o=a*t._w+n*t._x+s*t._y+r*t._z;if(o<0?(this._w=-t._w,this._x=-t._x,this._y=-t._y,this._z=-t._z,o=-o):this.copy(t),o>=1)return this._w=a,this._x=n,this._y=s,this._z=r,this;let l=1-o*o;if(l<=Number.EPSILON){let p=1-e;return this._w=p*a+e*this._w,this._x=p*n+e*this._x,this._y=p*s+e*this._y,this._z=p*r+e*this._z,this.normalize(),this}let c=Math.sqrt(l),u=Math.atan2(c,o),d=Math.sin((1-e)*u)/c,f=Math.sin(e*u)/c;return this._w=a*d+this._w*f,this._x=n*d+this._x*f,this._y=s*d+this._y*f,this._z=r*d+this._z*f,this._onChangeCallback(),this}slerpQuaternions(t,e,n){return this.copy(t).slerp(e,n)}random(){let t=2*Math.PI*Math.random(),e=2*Math.PI*Math.random(),n=Math.random(),s=Math.sqrt(1-n),r=Math.sqrt(n);return this.set(s*Math.sin(t),s*Math.cos(t),r*Math.sin(e),r*Math.cos(e))}equals(t){return t._x===this._x&&t._y===this._y&&t._z===this._z&&t._w===this._w}fromArray(t,e=0){return this._x=t[e],this._y=t[e+1],this._z=t[e+2],this._w=t[e+3],this._onChangeCallback(),this}toArray(t=[],e=0){return t[e]=this._x,t[e+1]=this._y,t[e+2]=this._z,t[e+3]=this._w,t}fromBufferAttribute(t,e){return this._x=t.getX(e),this._y=t.getY(e),this._z=t.getZ(e),this._w=t.getW(e),this._onChangeCallback(),this}toJSON(){return this.toArray()}_onChange(t){return this._onChangeCallback=t,this}_onChangeCallback(){}*[Symbol.iterator](){yield this._x,yield this._y,yield this._z,yield this._w}},N=class i{constructor(t=0,e=0,n=0){i.prototype.isVector3=!0,this.x=t,this.y=e,this.z=n}set(t,e,n){return n===void 0&&(n=this.z),this.x=t,this.y=e,this.z=n,this}setScalar(t){return this.x=t,this.y=t,this.z=t,this}setX(t){return this.x=t,this}setY(t){return this.y=t,this}setZ(t){return this.z=t,this}setComponent(t,e){switch(t){case 0:this.x=e;break;case 1:this.y=e;break;case 2:this.z=e;break;default:throw new Error("index is out of range: "+t)}return this}getComponent(t){switch(t){case 0:return this.x;case 1:return this.y;case 2:return this.z;default:throw new Error("index is out of range: "+t)}}clone(){return new this.constructor(this.x,this.y,this.z)}copy(t){return this.x=t.x,this.y=t.y,this.z=t.z,this}add(t){return this.x+=t.x,this.y+=t.y,this.z+=t.z,this}addScalar(t){return this.x+=t,this.y+=t,this.z+=t,this}addVectors(t,e){return this.x=t.x+e.x,this.y=t.y+e.y,this.z=t.z+e.z,this}addScaledVector(t,e){return this.x+=t.x*e,this.y+=t.y*e,this.z+=t.z*e,this}sub(t){return this.x-=t.x,this.y-=t.y,this.z-=t.z,this}subScalar(t){return this.x-=t,this.y-=t,this.z-=t,this}subVectors(t,e){return this.x=t.x-e.x,this.y=t.y-e.y,this.z=t.z-e.z,this}multiply(t){return this.x*=t.x,this.y*=t.y,this.z*=t.z,this}multiplyScalar(t){return this.x*=t,this.y*=t,this.z*=t,this}multiplyVectors(t,e){return this.x=t.x*e.x,this.y=t.y*e.y,this.z=t.z*e.z,this}applyEuler(t){return this.applyQuaternion(pl.setFromEuler(t))}applyAxisAngle(t,e){return this.applyQuaternion(pl.setFromAxisAngle(t,e))}applyMatrix3(t){let e=this.x,n=this.y,s=this.z,r=t.elements;return this.x=r[0]*e+r[3]*n+r[6]*s,this.y=r[1]*e+r[4]*n+r[7]*s,this.z=r[2]*e+r[5]*n+r[8]*s,this}applyNormalMatrix(t){return this.applyMatrix3(t).normalize()}applyMatrix4(t){let e=this.x,n=this.y,s=this.z,r=t.elements,a=1/(r[3]*e+r[7]*n+r[11]*s+r[15]);return this.x=(r[0]*e+r[4]*n+r[8]*s+r[12])*a,this.y=(r[1]*e+r[5]*n+r[9]*s+r[13])*a,this.z=(r[2]*e+r[6]*n+r[10]*s+r[14])*a,this}applyQuaternion(t){let e=this.x,n=this.y,s=this.z,r=t.x,a=t.y,o=t.z,l=t.w,c=2*(a*s-o*n),u=2*(o*e-r*s),d=2*(r*n-a*e);return this.x=e+l*c+a*d-o*u,this.y=n+l*u+o*c-r*d,this.z=s+l*d+r*u-a*c,this}project(t){return this.applyMatrix4(t.matrixWorldInverse).applyMatrix4(t.projectionMatrix)}unproject(t){return this.applyMatrix4(t.projectionMatrixInverse).applyMatrix4(t.matrixWorld)}transformDirection(t){let e=this.x,n=this.y,s=this.z,r=t.elements;return this.x=r[0]*e+r[4]*n+r[8]*s,this.y=r[1]*e+r[5]*n+r[9]*s,this.z=r[2]*e+r[6]*n+r[10]*s,this.normalize()}divide(t){return this.x/=t.x,this.y/=t.y,this.z/=t.z,this}divideScalar(t){return this.multiplyScalar(1/t)}min(t){return this.x=Math.min(this.x,t.x),this.y=Math.min(this.y,t.y),this.z=Math.min(this.z,t.z),this}max(t){return this.x=Math.max(this.x,t.x),this.y=Math.max(this.y,t.y),this.z=Math.max(this.z,t.z),this}clamp(t,e){return this.x=zt(this.x,t.x,e.x),this.y=zt(this.y,t.y,e.y),this.z=zt(this.z,t.z,e.z),this}clampScalar(t,e){return this.x=zt(this.x,t,e),this.y=zt(this.y,t,e),this.z=zt(this.z,t,e),this}clampLength(t,e){let n=this.length();return this.divideScalar(n||1).multiplyScalar(zt(n,t,e))}floor(){return this.x=Math.floor(this.x),this.y=Math.floor(this.y),this.z=Math.floor(this.z),this}ceil(){return this.x=Math.ceil(this.x),this.y=Math.ceil(this.y),this.z=Math.ceil(this.z),this}round(){return this.x=Math.round(this.x),this.y=Math.round(this.y),this.z=Math.round(this.z),this}roundToZero(){return this.x=Math.trunc(this.x),this.y=Math.trunc(this.y),this.z=Math.trunc(this.z),this}negate(){return this.x=-this.x,this.y=-this.y,this.z=-this.z,this}dot(t){return this.x*t.x+this.y*t.y+this.z*t.z}lengthSq(){return this.x*this.x+this.y*this.y+this.z*this.z}length(){return Math.sqrt(this.x*this.x+this.y*this.y+this.z*this.z)}manhattanLength(){return Math.abs(this.x)+Math.abs(this.y)+Math.abs(this.z)}normalize(){return this.divideScalar(this.length()||1)}setLength(t){return this.normalize().multiplyScalar(t)}lerp(t,e){return this.x+=(t.x-this.x)*e,this.y+=(t.y-this.y)*e,this.z+=(t.z-this.z)*e,this}lerpVectors(t,e,n){return this.x=t.x+(e.x-t.x)*n,this.y=t.y+(e.y-t.y)*n,this.z=t.z+(e.z-t.z)*n,this}cross(t){return this.crossVectors(this,t)}crossVectors(t,e){let n=t.x,s=t.y,r=t.z,a=e.x,o=e.y,l=e.z;return this.x=s*l-r*o,this.y=r*a-n*l,this.z=n*o-s*a,this}projectOnVector(t){let e=t.lengthSq();if(e===0)return this.set(0,0,0);let n=t.dot(this)/e;return this.copy(t).multiplyScalar(n)}projectOnPlane(t){return Na.copy(this).projectOnVector(t),this.sub(Na)}reflect(t){return this.sub(Na.copy(t).multiplyScalar(2*this.dot(t)))}angleTo(t){let e=Math.sqrt(this.lengthSq()*t.lengthSq());if(e===0)return Math.PI/2;let n=this.dot(t)/e;return Math.acos(zt(n,-1,1))}distanceTo(t){return Math.sqrt(this.distanceToSquared(t))}distanceToSquared(t){let e=this.x-t.x,n=this.y-t.y,s=this.z-t.z;return e*e+n*n+s*s}manhattanDistanceTo(t){return Math.abs(this.x-t.x)+Math.abs(this.y-t.y)+Math.abs(this.z-t.z)}setFromSpherical(t){return this.setFromSphericalCoords(t.radius,t.phi,t.theta)}setFromSphericalCoords(t,e,n){let s=Math.sin(e)*t;return this.x=s*Math.sin(n),this.y=Math.cos(e)*t,this.z=s*Math.cos(n),this}setFromCylindrical(t){return this.setFromCylindricalCoords(t.radius,t.theta,t.y)}setFromCylindricalCoords(t,e,n){return this.x=t*Math.sin(e),this.y=n,this.z=t*Math.cos(e),this}setFromMatrixPosition(t){let e=t.elements;return this.x=e[12],this.y=e[13],this.z=e[14],this}setFromMatrixScale(t){let e=this.setFromMatrixColumn(t,0).length(),n=this.setFromMatrixColumn(t,1).length(),s=this.setFromMatrixColumn(t,2).length();return this.x=e,this.y=n,this.z=s,this}setFromMatrixColumn(t,e){return this.fromArray(t.elements,e*4)}setFromMatrix3Column(t,e){return this.fromArray(t.elements,e*3)}setFromEuler(t){return this.x=t._x,this.y=t._y,this.z=t._z,this}setFromColor(t){return this.x=t.r,this.y=t.g,this.z=t.b,this}equals(t){return t.x===this.x&&t.y===this.y&&t.z===this.z}fromArray(t,e=0){return this.x=t[e],this.y=t[e+1],this.z=t[e+2],this}toArray(t=[],e=0){return t[e]=this.x,t[e+1]=this.y,t[e+2]=this.z,t}fromBufferAttribute(t,e){return this.x=t.getX(e),this.y=t.getY(e),this.z=t.getZ(e),this}random(){return this.x=Math.random(),this.y=Math.random(),this.z=Math.random(),this}randomDirection(){let t=Math.random()*Math.PI*2,e=Math.random()*2-1,n=Math.sqrt(1-e*e);return this.x=n*Math.cos(t),this.y=e,this.z=n*Math.sin(t),this}*[Symbol.iterator](){yield this.x,yield this.y,yield this.z}},Na=new N,pl=new Je,Ut=class i{constructor(t,e,n,s,r,a,o,l,c){i.prototype.isMatrix3=!0,this.elements=[1,0,0,0,1,0,0,0,1],t!==void 0&&this.set(t,e,n,s,r,a,o,l,c)}set(t,e,n,s,r,a,o,l,c){let u=this.elements;return u[0]=t,u[1]=s,u[2]=o,u[3]=e,u[4]=r,u[5]=l,u[6]=n,u[7]=a,u[8]=c,this}identity(){return this.set(1,0,0,0,1,0,0,0,1),this}copy(t){let e=this.elements,n=t.elements;return e[0]=n[0],e[1]=n[1],e[2]=n[2],e[3]=n[3],e[4]=n[4],e[5]=n[5],e[6]=n[6],e[7]=n[7],e[8]=n[8],this}extractBasis(t,e,n){return t.setFromMatrix3Column(this,0),e.setFromMatrix3Column(this,1),n.setFromMatrix3Column(this,2),this}setFromMatrix4(t){let e=t.elements;return this.set(e[0],e[4],e[8],e[1],e[5],e[9],e[2],e[6],e[10]),this}multiply(t){return this.multiplyMatrices(this,t)}premultiply(t){return this.multiplyMatrices(t,this)}multiplyMatrices(t,e){let n=t.elements,s=e.elements,r=this.elements,a=n[0],o=n[3],l=n[6],c=n[1],u=n[4],d=n[7],f=n[2],p=n[5],_=n[8],v=s[0],m=s[3],h=s[6],w=s[1],E=s[4],S=s[7],C=s[2],A=s[5],P=s[8];return r[0]=a*v+o*w+l*C,r[3]=a*m+o*E+l*A,r[6]=a*h+o*S+l*P,r[1]=c*v+u*w+d*C,r[4]=c*m+u*E+d*A,r[7]=c*h+u*S+d*P,r[2]=f*v+p*w+_*C,r[5]=f*m+p*E+_*A,r[8]=f*h+p*S+_*P,this}multiplyScalar(t){let e=this.elements;return e[0]*=t,e[3]*=t,e[6]*=t,e[1]*=t,e[4]*=t,e[7]*=t,e[2]*=t,e[5]*=t,e[8]*=t,this}determinant(){let t=this.elements,e=t[0],n=t[1],s=t[2],r=t[3],a=t[4],o=t[5],l=t[6],c=t[7],u=t[8];return e*a*u-e*o*c-n*r*u+n*o*l+s*r*c-s*a*l}invert(){let t=this.elements,e=t[0],n=t[1],s=t[2],r=t[3],a=t[4],o=t[5],l=t[6],c=t[7],u=t[8],d=u*a-o*c,f=o*l-u*r,p=c*r-a*l,_=e*d+n*f+s*p;if(_===0)return this.set(0,0,0,0,0,0,0,0,0);let v=1/_;return t[0]=d*v,t[1]=(s*c-u*n)*v,t[2]=(o*n-s*a)*v,t[3]=f*v,t[4]=(u*e-s*l)*v,t[5]=(s*r-o*e)*v,t[6]=p*v,t[7]=(n*l-c*e)*v,t[8]=(a*e-n*r)*v,this}transpose(){let t,e=this.elements;return t=e[1],e[1]=e[3],e[3]=t,t=e[2],e[2]=e[6],e[6]=t,t=e[5],e[5]=e[7],e[7]=t,this}getNormalMatrix(t){return this.setFromMatrix4(t).invert().transpose()}transposeIntoArray(t){let e=this.elements;return t[0]=e[0],t[1]=e[3],t[2]=e[6],t[3]=e[1],t[4]=e[4],t[5]=e[7],t[6]=e[2],t[7]=e[5],t[8]=e[8],this}setUvTransform(t,e,n,s,r,a,o){let l=Math.cos(r),c=Math.sin(r);return this.set(n*l,n*c,-n*(l*a+c*o)+a+t,-s*c,s*l,-s*(-c*a+l*o)+o+e,0,0,1),this}scale(t,e){return this.premultiply(Fa.makeScale(t,e)),this}rotate(t){return this.premultiply(Fa.makeRotation(-t)),this}translate(t,e){return this.premultiply(Fa.makeTranslation(t,e)),this}makeTranslation(t,e){return t.isVector2?this.set(1,0,t.x,0,1,t.y,0,0,1):this.set(1,0,t,0,1,e,0,0,1),this}makeRotation(t){let e=Math.cos(t),n=Math.sin(t);return this.set(e,-n,0,n,e,0,0,0,1),this}makeScale(t,e){return this.set(t,0,0,0,e,0,0,0,1),this}equals(t){let e=this.elements,n=t.elements;for(let s=0;s<9;s++)if(e[s]!==n[s])return!1;return!0}fromArray(t,e=0){for(let n=0;n<9;n++)this.elements[n]=t[n+e];return this}toArray(t=[],e=0){let n=this.elements;return t[e]=n[0],t[e+1]=n[1],t[e+2]=n[2],t[e+3]=n[3],t[e+4]=n[4],t[e+5]=n[5],t[e+6]=n[6],t[e+7]=n[7],t[e+8]=n[8],t}clone(){return new this.constructor().fromArray(this.elements)}},Fa=new Ut;function Lo(i){for(let t=i.length-1;t>=0;--t)if(i[t]>=65535)return!0;return!1}function us(i){return document.createElementNS("http://www.w3.org/1999/xhtml",i)}function vc(){let i=us("canvas");return i.style.display="block",i}var ml={};function Ni(i){i in ml||(ml[i]=!0,console.warn(i))}function Mc(i,t,e){return new Promise(function(n,s){function r(){switch(i.clientWaitSync(t,i.SYNC_FLUSH_COMMANDS_BIT,0)){case i.WAIT_FAILED:s();break;case i.TIMEOUT_EXPIRED:setTimeout(r,e);break;default:n()}}setTimeout(r,e)})}var gl=new Ut().set(.4123908,.3575843,.1804808,.212639,.7151687,.0721923,.0193308,.1191948,.9505322),_l=new Ut().set(3.2409699,-1.5373832,-.4986108,-.9692436,1.8759675,.0415551,.0556301,-.203977,1.0569715);function zh(){let i={enabled:!0,workingColorSpace:ii,spaces:{},convert:function(s,r,a){return this.enabled===!1||r===a||!r||!a||(this.spaces[r].transfer===Zt&&(s.r=En(s.r),s.g=En(s.g),s.b=En(s.b)),this.spaces[r].primaries!==this.spaces[a].primaries&&(s.applyMatrix3(this.spaces[r].toXYZ),s.applyMatrix3(this.spaces[a].fromXYZ)),this.spaces[a].transfer===Zt&&(s.r=Di(s.r),s.g=Di(s.g),s.b=Di(s.b))),s},workingToColorSpace:function(s,r){return this.convert(s,this.workingColorSpace,r)},colorSpaceToWorking:function(s,r){return this.convert(s,r,this.workingColorSpace)},getPrimaries:function(s){return this.spaces[s].primaries},getTransfer:function(s){return s===Cn?cs:this.spaces[s].transfer},getToneMappingMode:function(s){return this.spaces[s].outputColorSpaceConfig.toneMappingMode||"standard"},getLuminanceCoefficients:function(s,r=this.workingColorSpace){return s.fromArray(this.spaces[r].luminanceCoefficients)},define:function(s){Object.assign(this.spaces,s)},_getMatrix:function(s,r,a){return s.copy(this.spaces[r].toXYZ).multiply(this.spaces[a].fromXYZ)},_getDrawingBufferColorSpace:function(s){return this.spaces[s].outputColorSpaceConfig.drawingBufferColorSpace},_getUnpackColorSpace:function(s=this.workingColorSpace){return this.spaces[s].workingColorSpaceConfig.unpackColorSpace},fromWorkingColorSpace:function(s,r){return Ni("THREE.ColorManagement: .fromWorkingColorSpace() has been renamed to .workingToColorSpace()."),i.workingToColorSpace(s,r)},toWorkingColorSpace:function(s,r){return Ni("THREE.ColorManagement: .toWorkingColorSpace() has been renamed to .colorSpaceToWorking()."),i.colorSpaceToWorking(s,r)}},t=[.64,.33,.3,.6,.15,.06],e=[.2126,.7152,.0722],n=[.3127,.329];return i.define({[ii]:{primaries:t,whitePoint:n,transfer:cs,toXYZ:gl,fromXYZ:_l,luminanceCoefficients:e,workingColorSpaceConfig:{unpackColorSpace:Te},outputColorSpaceConfig:{drawingBufferColorSpace:Te}},[Te]:{primaries:t,whitePoint:n,transfer:Zt,toXYZ:gl,fromXYZ:_l,luminanceCoefficients:e,outputColorSpaceConfig:{drawingBufferColorSpace:Te}}}),i}var Wt=zh();function En(i){return i<.04045?i*.0773993808:Math.pow(i*.9478672986+.0521327014,2.4)}function Di(i){return i<.0031308?i*12.92:1.055*Math.pow(i,.41666)-.055}var yi,dr=class{static getDataURL(t,e="image/png"){if(/^data:/i.test(t.src)||typeof HTMLCanvasElement>"u")return t.src;let n;if(t instanceof HTMLCanvasElement)n=t;else{yi===void 0&&(yi=us("canvas")),yi.width=t.width,yi.height=t.height;let s=yi.getContext("2d");t instanceof ImageData?s.putImageData(t,0,0):s.drawImage(t,0,0,t.width,t.height),n=yi}return n.toDataURL(e)}static sRGBToLinear(t){if(typeof HTMLImageElement<"u"&&t instanceof HTMLImageElement||typeof HTMLCanvasElement<"u"&&t instanceof HTMLCanvasElement||typeof ImageBitmap<"u"&&t instanceof ImageBitmap){let e=us("canvas");e.width=t.width,e.height=t.height;let n=e.getContext("2d");n.drawImage(t,0,0,t.width,t.height);let s=n.getImageData(0,0,t.width,t.height),r=s.data;for(let a=0;a<r.length;a++)r[a]=En(r[a]/255)*255;return n.putImageData(s,0,0),e}else if(t.data){let e=t.data.slice(0);for(let n=0;n<e.length;n++)e instanceof Uint8Array||e instanceof Uint8ClampedArray?e[n]=Math.floor(En(e[n]/255)*255):e[n]=En(e[n]);return{data:e,width:t.width,height:t.height}}else return console.warn("THREE.ImageUtils.sRGBToLinear(): Unsupported image type. No color space conversion applied."),t}},kh=0,Fi=class{constructor(t=null){this.isSource=!0,Object.defineProperty(this,"id",{value:kh++}),this.uuid=qi(),this.data=t,this.dataReady=!0,this.version=0}getSize(t){let e=this.data;return typeof HTMLVideoElement<"u"&&e instanceof HTMLVideoElement?t.set(e.videoWidth,e.videoHeight,0):e instanceof VideoFrame?t.set(e.displayHeight,e.displayWidth,0):e!==null?t.set(e.width,e.height,e.depth||0):t.set(0,0,0),t}set needsUpdate(t){t===!0&&this.version++}toJSON(t){let e=t===void 0||typeof t=="string";if(!e&&t.images[this.uuid]!==void 0)return t.images[this.uuid];let n={uuid:this.uuid,url:""},s=this.data;if(s!==null){let r;if(Array.isArray(s)){r=[];for(let a=0,o=s.length;a<o;a++)s[a].isDataTexture?r.push(Oa(s[a].image)):r.push(Oa(s[a]))}else r=Oa(s);n.url=r}return e||(t.images[this.uuid]=n),n}};function Oa(i){return typeof HTMLImageElement<"u"&&i instanceof HTMLImageElement||typeof HTMLCanvasElement<"u"&&i instanceof HTMLCanvasElement||typeof ImageBitmap<"u"&&i instanceof ImageBitmap?dr.getDataURL(i):i.data?{data:Array.from(i.data),width:i.width,height:i.height,type:i.data.constructor.name}:(console.warn("THREE.Texture: Unable to serialize Texture."),{})}var Vh=0,Ba=new N,Ne=class i extends un{constructor(t=i.DEFAULT_IMAGE,e=i.DEFAULT_MAPPING,n=Fn,s=Fn,r=nn,a=Xn,o=$e,l=an,c=i.DEFAULT_ANISOTROPY,u=Cn){super(),this.isTexture=!0,Object.defineProperty(this,"id",{value:Vh++}),this.uuid=qi(),this.name="",this.source=new Fi(t),this.mipmaps=[],this.mapping=e,this.channel=0,this.wrapS=n,this.wrapT=s,this.magFilter=r,this.minFilter=a,this.anisotropy=c,this.format=o,this.internalFormat=null,this.type=l,this.offset=new Rt(0,0),this.repeat=new Rt(1,1),this.center=new Rt(0,0),this.rotation=0,this.matrixAutoUpdate=!0,this.matrix=new Ut,this.generateMipmaps=!0,this.premultiplyAlpha=!1,this.flipY=!0,this.unpackAlignment=4,this.colorSpace=u,this.userData={},this.updateRanges=[],this.version=0,this.onUpdate=null,this.renderTarget=null,this.isRenderTargetTexture=!1,this.isArrayTexture=!!(t&&t.depth&&t.depth>1),this.pmremVersion=0}get width(){return this.source.getSize(Ba).x}get height(){return this.source.getSize(Ba).y}get depth(){return this.source.getSize(Ba).z}get image(){return this.source.data}set image(t=null){this.source.data=t}updateMatrix(){this.matrix.setUvTransform(this.offset.x,this.offset.y,this.repeat.x,this.repeat.y,this.rotation,this.center.x,this.center.y)}addUpdateRange(t,e){this.updateRanges.push({start:t,count:e})}clearUpdateRanges(){this.updateRanges.length=0}clone(){return new this.constructor().copy(this)}copy(t){return this.name=t.name,this.source=t.source,this.mipmaps=t.mipmaps.slice(0),this.mapping=t.mapping,this.channel=t.channel,this.wrapS=t.wrapS,this.wrapT=t.wrapT,this.magFilter=t.magFilter,this.minFilter=t.minFilter,this.anisotropy=t.anisotropy,this.format=t.format,this.internalFormat=t.internalFormat,this.type=t.type,this.offset.copy(t.offset),this.repeat.copy(t.repeat),this.center.copy(t.center),this.rotation=t.rotation,this.matrixAutoUpdate=t.matrixAutoUpdate,this.matrix.copy(t.matrix),this.generateMipmaps=t.generateMipmaps,this.premultiplyAlpha=t.premultiplyAlpha,this.flipY=t.flipY,this.unpackAlignment=t.unpackAlignment,this.colorSpace=t.colorSpace,this.renderTarget=t.renderTarget,this.isRenderTargetTexture=t.isRenderTargetTexture,this.isArrayTexture=t.isArrayTexture,this.userData=JSON.parse(JSON.stringify(t.userData)),this.needsUpdate=!0,this}setValues(t){for(let e in t){let n=t[e];if(n===void 0){console.warn(`THREE.Texture.setValues(): parameter '${e}' has value of undefined.`);continue}let s=this[e];if(s===void 0){console.warn(`THREE.Texture.setValues(): property '${e}' does not exist.`);continue}s&&n&&s.isVector2&&n.isVector2||s&&n&&s.isVector3&&n.isVector3||s&&n&&s.isMatrix3&&n.isMatrix3?s.copy(n):this[e]=n}}toJSON(t){let e=t===void 0||typeof t=="string";if(!e&&t.textures[this.uuid]!==void 0)return t.textures[this.uuid];let n={metadata:{version:4.7,type:"Texture",generator:"Texture.toJSON"},uuid:this.uuid,name:this.name,image:this.source.toJSON(t).uuid,mapping:this.mapping,channel:this.channel,repeat:[this.repeat.x,this.repeat.y],offset:[this.offset.x,this.offset.y],center:[this.center.x,this.center.y],rotation:this.rotation,wrap:[this.wrapS,this.wrapT],format:this.format,internalFormat:this.internalFormat,type:this.type,colorSpace:this.colorSpace,minFilter:this.minFilter,magFilter:this.magFilter,anisotropy:this.anisotropy,flipY:this.flipY,generateMipmaps:this.generateMipmaps,premultiplyAlpha:this.premultiplyAlpha,unpackAlignment:this.unpackAlignment};return Object.keys(this.userData).length>0&&(n.userData=this.userData),e||(t.textures[this.uuid]=n),n}dispose(){this.dispatchEvent({type:"dispose"})}transformUv(t){if(this.mapping!==yo)return t;if(t.applyMatrix3(this.matrix),t.x<0||t.x>1)switch(this.wrapS){case cr:t.x=t.x-Math.floor(t.x);break;case Fn:t.x=t.x<0?0:1;break;case hr:Math.abs(Math.floor(t.x)%2)===1?t.x=Math.ceil(t.x)-t.x:t.x=t.x-Math.floor(t.x);break}if(t.y<0||t.y>1)switch(this.wrapT){case cr:t.y=t.y-Math.floor(t.y);break;case Fn:t.y=t.y<0?0:1;break;case hr:Math.abs(Math.floor(t.y)%2)===1?t.y=Math.ceil(t.y)-t.y:t.y=t.y-Math.floor(t.y);break}return this.flipY&&(t.y=1-t.y),t}set needsUpdate(t){t===!0&&(this.version++,this.source.needsUpdate=!0)}set needsPMREMUpdate(t){t===!0&&this.pmremVersion++}};Ne.DEFAULT_IMAGE=null;Ne.DEFAULT_MAPPING=yo;Ne.DEFAULT_ANISOTROPY=1;var oe=class i{constructor(t=0,e=0,n=0,s=1){i.prototype.isVector4=!0,this.x=t,this.y=e,this.z=n,this.w=s}get width(){return this.z}set width(t){this.z=t}get height(){return this.w}set height(t){this.w=t}set(t,e,n,s){return this.x=t,this.y=e,this.z=n,this.w=s,this}setScalar(t){return this.x=t,this.y=t,this.z=t,this.w=t,this}setX(t){return this.x=t,this}setY(t){return this.y=t,this}setZ(t){return this.z=t,this}setW(t){return this.w=t,this}setComponent(t,e){switch(t){case 0:this.x=e;break;case 1:this.y=e;break;case 2:this.z=e;break;case 3:this.w=e;break;default:throw new Error("index is out of range: "+t)}return this}getComponent(t){switch(t){case 0:return this.x;case 1:return this.y;case 2:return this.z;case 3:return this.w;default:throw new Error("index is out of range: "+t)}}clone(){return new this.constructor(this.x,this.y,this.z,this.w)}copy(t){return this.x=t.x,this.y=t.y,this.z=t.z,this.w=t.w!==void 0?t.w:1,this}add(t){return this.x+=t.x,this.y+=t.y,this.z+=t.z,this.w+=t.w,this}addScalar(t){return this.x+=t,this.y+=t,this.z+=t,this.w+=t,this}addVectors(t,e){return this.x=t.x+e.x,this.y=t.y+e.y,this.z=t.z+e.z,this.w=t.w+e.w,this}addScaledVector(t,e){return this.x+=t.x*e,this.y+=t.y*e,this.z+=t.z*e,this.w+=t.w*e,this}sub(t){return this.x-=t.x,this.y-=t.y,this.z-=t.z,this.w-=t.w,this}subScalar(t){return this.x-=t,this.y-=t,this.z-=t,this.w-=t,this}subVectors(t,e){return this.x=t.x-e.x,this.y=t.y-e.y,this.z=t.z-e.z,this.w=t.w-e.w,this}multiply(t){return this.x*=t.x,this.y*=t.y,this.z*=t.z,this.w*=t.w,this}multiplyScalar(t){return this.x*=t,this.y*=t,this.z*=t,this.w*=t,this}applyMatrix4(t){let e=this.x,n=this.y,s=this.z,r=this.w,a=t.elements;return this.x=a[0]*e+a[4]*n+a[8]*s+a[12]*r,this.y=a[1]*e+a[5]*n+a[9]*s+a[13]*r,this.z=a[2]*e+a[6]*n+a[10]*s+a[14]*r,this.w=a[3]*e+a[7]*n+a[11]*s+a[15]*r,this}divide(t){return this.x/=t.x,this.y/=t.y,this.z/=t.z,this.w/=t.w,this}divideScalar(t){return this.multiplyScalar(1/t)}setAxisAngleFromQuaternion(t){this.w=2*Math.acos(t.w);let e=Math.sqrt(1-t.w*t.w);return e<1e-4?(this.x=1,this.y=0,this.z=0):(this.x=t.x/e,this.y=t.y/e,this.z=t.z/e),this}setAxisAngleFromRotationMatrix(t){let e,n,s,r,l=t.elements,c=l[0],u=l[4],d=l[8],f=l[1],p=l[5],_=l[9],v=l[2],m=l[6],h=l[10];if(Math.abs(u-f)<.01&&Math.abs(d-v)<.01&&Math.abs(_-m)<.01){if(Math.abs(u+f)<.1&&Math.abs(d+v)<.1&&Math.abs(_+m)<.1&&Math.abs(c+p+h-3)<.1)return this.set(1,0,0,0),this;e=Math.PI;let E=(c+1)/2,S=(p+1)/2,C=(h+1)/2,A=(u+f)/4,P=(d+v)/4,U=(_+m)/4;return E>S&&E>C?E<.01?(n=0,s=.707106781,r=.707106781):(n=Math.sqrt(E),s=A/n,r=P/n):S>C?S<.01?(n=.707106781,s=0,r=.707106781):(s=Math.sqrt(S),n=A/s,r=U/s):C<.01?(n=.707106781,s=.707106781,r=0):(r=Math.sqrt(C),n=P/r,s=U/r),this.set(n,s,r,e),this}let w=Math.sqrt((m-_)*(m-_)+(d-v)*(d-v)+(f-u)*(f-u));return Math.abs(w)<.001&&(w=1),this.x=(m-_)/w,this.y=(d-v)/w,this.z=(f-u)/w,this.w=Math.acos((c+p+h-1)/2),this}setFromMatrixPosition(t){let e=t.elements;return this.x=e[12],this.y=e[13],this.z=e[14],this.w=e[15],this}min(t){return this.x=Math.min(this.x,t.x),this.y=Math.min(this.y,t.y),this.z=Math.min(this.z,t.z),this.w=Math.min(this.w,t.w),this}max(t){return this.x=Math.max(this.x,t.x),this.y=Math.max(this.y,t.y),this.z=Math.max(this.z,t.z),this.w=Math.max(this.w,t.w),this}clamp(t,e){return this.x=zt(this.x,t.x,e.x),this.y=zt(this.y,t.y,e.y),this.z=zt(this.z,t.z,e.z),this.w=zt(this.w,t.w,e.w),this}clampScalar(t,e){return this.x=zt(this.x,t,e),this.y=zt(this.y,t,e),this.z=zt(this.z,t,e),this.w=zt(this.w,t,e),this}clampLength(t,e){let n=this.length();return this.divideScalar(n||1).multiplyScalar(zt(n,t,e))}floor(){return this.x=Math.floor(this.x),this.y=Math.floor(this.y),this.z=Math.floor(this.z),this.w=Math.floor(this.w),this}ceil(){return this.x=Math.ceil(this.x),this.y=Math.ceil(this.y),this.z=Math.ceil(this.z),this.w=Math.ceil(this.w),this}round(){return this.x=Math.round(this.x),this.y=Math.round(this.y),this.z=Math.round(this.z),this.w=Math.round(this.w),this}roundToZero(){return this.x=Math.trunc(this.x),this.y=Math.trunc(this.y),this.z=Math.trunc(this.z),this.w=Math.trunc(this.w),this}negate(){return this.x=-this.x,this.y=-this.y,this.z=-this.z,this.w=-this.w,this}dot(t){return this.x*t.x+this.y*t.y+this.z*t.z+this.w*t.w}lengthSq(){return this.x*this.x+this.y*this.y+this.z*this.z+this.w*this.w}length(){return Math.sqrt(this.x*this.x+this.y*this.y+this.z*this.z+this.w*this.w)}manhattanLength(){return Math.abs(this.x)+Math.abs(this.y)+Math.abs(this.z)+Math.abs(this.w)}normalize(){return this.divideScalar(this.length()||1)}setLength(t){return this.normalize().multiplyScalar(t)}lerp(t,e){return this.x+=(t.x-this.x)*e,this.y+=(t.y-this.y)*e,this.z+=(t.z-this.z)*e,this.w+=(t.w-this.w)*e,this}lerpVectors(t,e,n){return this.x=t.x+(e.x-t.x)*n,this.y=t.y+(e.y-t.y)*n,this.z=t.z+(e.z-t.z)*n,this.w=t.w+(e.w-t.w)*n,this}equals(t){return t.x===this.x&&t.y===this.y&&t.z===this.z&&t.w===this.w}fromArray(t,e=0){return this.x=t[e],this.y=t[e+1],this.z=t[e+2],this.w=t[e+3],this}toArray(t=[],e=0){return t[e]=this.x,t[e+1]=this.y,t[e+2]=this.z,t[e+3]=this.w,t}fromBufferAttribute(t,e){return this.x=t.getX(e),this.y=t.getY(e),this.z=t.getZ(e),this.w=t.getW(e),this}random(){return this.x=Math.random(),this.y=Math.random(),this.z=Math.random(),this.w=Math.random(),this}*[Symbol.iterator](){yield this.x,yield this.y,yield this.z,yield this.w}},fr=class extends un{constructor(t=1,e=1,n={}){super(),n=Object.assign({generateMipmaps:!1,internalFormat:null,minFilter:nn,depthBuffer:!0,stencilBuffer:!1,resolveDepthBuffer:!0,resolveStencilBuffer:!0,depthTexture:null,samples:0,count:1,depth:1,multiview:!1},n),this.isRenderTarget=!0,this.width=t,this.height=e,this.depth=n.depth,this.scissor=new oe(0,0,t,e),this.scissorTest=!1,this.viewport=new oe(0,0,t,e);let s={width:t,height:e,depth:n.depth},r=new Ne(s);this.textures=[];let a=n.count;for(let o=0;o<a;o++)this.textures[o]=r.clone(),this.textures[o].isRenderTargetTexture=!0,this.textures[o].renderTarget=this;this._setTextureOptions(n),this.depthBuffer=n.depthBuffer,this.stencilBuffer=n.stencilBuffer,this.resolveDepthBuffer=n.resolveDepthBuffer,this.resolveStencilBuffer=n.resolveStencilBuffer,this._depthTexture=null,this.depthTexture=n.depthTexture,this.samples=n.samples,this.multiview=n.multiview}_setTextureOptions(t={}){let e={minFilter:nn,generateMipmaps:!1,flipY:!1,internalFormat:null};t.mapping!==void 0&&(e.mapping=t.mapping),t.wrapS!==void 0&&(e.wrapS=t.wrapS),t.wrapT!==void 0&&(e.wrapT=t.wrapT),t.wrapR!==void 0&&(e.wrapR=t.wrapR),t.magFilter!==void 0&&(e.magFilter=t.magFilter),t.minFilter!==void 0&&(e.minFilter=t.minFilter),t.format!==void 0&&(e.format=t.format),t.type!==void 0&&(e.type=t.type),t.anisotropy!==void 0&&(e.anisotropy=t.anisotropy),t.colorSpace!==void 0&&(e.colorSpace=t.colorSpace),t.flipY!==void 0&&(e.flipY=t.flipY),t.generateMipmaps!==void 0&&(e.generateMipmaps=t.generateMipmaps),t.internalFormat!==void 0&&(e.internalFormat=t.internalFormat);for(let n=0;n<this.textures.length;n++)this.textures[n].setValues(e)}get texture(){return this.textures[0]}set texture(t){this.textures[0]=t}set depthTexture(t){this._depthTexture!==null&&(this._depthTexture.renderTarget=null),t!==null&&(t.renderTarget=this),this._depthTexture=t}get depthTexture(){return this._depthTexture}setSize(t,e,n=1){if(this.width!==t||this.height!==e||this.depth!==n){this.width=t,this.height=e,this.depth=n;for(let s=0,r=this.textures.length;s<r;s++)this.textures[s].image.width=t,this.textures[s].image.height=e,this.textures[s].image.depth=n,this.textures[s].isArrayTexture=this.textures[s].image.depth>1;this.dispose()}this.viewport.set(0,0,t,e),this.scissor.set(0,0,t,e)}clone(){return new this.constructor().copy(this)}copy(t){this.width=t.width,this.height=t.height,this.depth=t.depth,this.scissor.copy(t.scissor),this.scissorTest=t.scissorTest,this.viewport.copy(t.viewport),this.textures.length=0;for(let e=0,n=t.textures.length;e<n;e++){this.textures[e]=t.textures[e].clone(),this.textures[e].isRenderTargetTexture=!0,this.textures[e].renderTarget=this;let s=Object.assign({},t.textures[e].image);this.textures[e].source=new Fi(s)}return this.depthBuffer=t.depthBuffer,this.stencilBuffer=t.stencilBuffer,this.resolveDepthBuffer=t.resolveDepthBuffer,this.resolveStencilBuffer=t.resolveStencilBuffer,t.depthTexture!==null&&(this.depthTexture=t.depthTexture.clone()),this.samples=t.samples,this}dispose(){this.dispatchEvent({type:"dispose"})}},dn=class extends fr{constructor(t=1,e=1,n={}){super(t,e,n),this.isWebGLRenderTarget=!0}},ds=class extends Ne{constructor(t=null,e=1,n=1,s=1){super(null),this.isDataArrayTexture=!0,this.image={data:t,width:e,height:n,depth:s},this.magFilter=Ze,this.minFilter=Ze,this.wrapR=Fn,this.generateMipmaps=!1,this.flipY=!1,this.unpackAlignment=1,this.layerUpdates=new Set}addLayerUpdate(t){this.layerUpdates.add(t)}clearLayerUpdates(){this.layerUpdates.clear()}};var pr=class extends Ne{constructor(t=null,e=1,n=1,s=1){super(null),this.isData3DTexture=!0,this.image={data:t,width:e,height:n,depth:s},this.magFilter=Ze,this.minFilter=Ze,this.wrapR=Fn,this.generateMipmaps=!1,this.flipY=!1,this.unpackAlignment=1}};var Bn=class{constructor(t=new N(1/0,1/0,1/0),e=new N(-1/0,-1/0,-1/0)){this.isBox3=!0,this.min=t,this.max=e}set(t,e){return this.min.copy(t),this.max.copy(e),this}setFromArray(t){this.makeEmpty();for(let e=0,n=t.length;e<n;e+=3)this.expandByPoint(je.fromArray(t,e));return this}setFromBufferAttribute(t){this.makeEmpty();for(let e=0,n=t.count;e<n;e++)this.expandByPoint(je.fromBufferAttribute(t,e));return this}setFromPoints(t){this.makeEmpty();for(let e=0,n=t.length;e<n;e++)this.expandByPoint(t[e]);return this}setFromCenterAndSize(t,e){let n=je.copy(e).multiplyScalar(.5);return this.min.copy(t).sub(n),this.max.copy(t).add(n),this}setFromObject(t,e=!1){return this.makeEmpty(),this.expandByObject(t,e)}clone(){return new this.constructor().copy(this)}copy(t){return this.min.copy(t.min),this.max.copy(t.max),this}makeEmpty(){return this.min.x=this.min.y=this.min.z=1/0,this.max.x=this.max.y=this.max.z=-1/0,this}isEmpty(){return this.max.x<this.min.x||this.max.y<this.min.y||this.max.z<this.min.z}getCenter(t){return this.isEmpty()?t.set(0,0,0):t.addVectors(this.min,this.max).multiplyScalar(.5)}getSize(t){return this.isEmpty()?t.set(0,0,0):t.subVectors(this.max,this.min)}expandByPoint(t){return this.min.min(t),this.max.max(t),this}expandByVector(t){return this.min.sub(t),this.max.add(t),this}expandByScalar(t){return this.min.addScalar(-t),this.max.addScalar(t),this}expandByObject(t,e=!1){t.updateWorldMatrix(!1,!1);let n=t.geometry;if(n!==void 0){let r=n.getAttribute("position");if(e===!0&&r!==void 0&&t.isInstancedMesh!==!0)for(let a=0,o=r.count;a<o;a++)t.isMesh===!0?t.getVertexPosition(a,je):je.fromBufferAttribute(r,a),je.applyMatrix4(t.matrixWorld),this.expandByPoint(je);else t.boundingBox!==void 0?(t.boundingBox===null&&t.computeBoundingBox(),Hs.copy(t.boundingBox)):(n.boundingBox===null&&n.computeBoundingBox(),Hs.copy(n.boundingBox)),Hs.applyMatrix4(t.matrixWorld),this.union(Hs)}let s=t.children;for(let r=0,a=s.length;r<a;r++)this.expandByObject(s[r],e);return this}containsPoint(t){return t.x>=this.min.x&&t.x<=this.max.x&&t.y>=this.min.y&&t.y<=this.max.y&&t.z>=this.min.z&&t.z<=this.max.z}containsBox(t){return this.min.x<=t.min.x&&t.max.x<=this.max.x&&this.min.y<=t.min.y&&t.max.y<=this.max.y&&this.min.z<=t.min.z&&t.max.z<=this.max.z}getParameter(t,e){return e.set((t.x-this.min.x)/(this.max.x-this.min.x),(t.y-this.min.y)/(this.max.y-this.min.y),(t.z-this.min.z)/(this.max.z-this.min.z))}intersectsBox(t){return t.max.x>=this.min.x&&t.min.x<=this.max.x&&t.max.y>=this.min.y&&t.min.y<=this.max.y&&t.max.z>=this.min.z&&t.min.z<=this.max.z}intersectsSphere(t){return this.clampPoint(t.center,je),je.distanceToSquared(t.center)<=t.radius*t.radius}intersectsPlane(t){let e,n;return t.normal.x>0?(e=t.normal.x*this.min.x,n=t.normal.x*this.max.x):(e=t.normal.x*this.max.x,n=t.normal.x*this.min.x),t.normal.y>0?(e+=t.normal.y*this.min.y,n+=t.normal.y*this.max.y):(e+=t.normal.y*this.max.y,n+=t.normal.y*this.min.y),t.normal.z>0?(e+=t.normal.z*this.min.z,n+=t.normal.z*this.max.z):(e+=t.normal.z*this.max.z,n+=t.normal.z*this.min.z),e<=-t.constant&&n>=-t.constant}intersectsTriangle(t){if(this.isEmpty())return!1;this.getCenter(ns),Gs.subVectors(this.max,ns),vi.subVectors(t.a,ns),Mi.subVectors(t.b,ns),Si.subVectors(t.c,ns),Rn.subVectors(Mi,vi),In.subVectors(Si,Mi),$n.subVectors(vi,Si);let e=[0,-Rn.z,Rn.y,0,-In.z,In.y,0,-$n.z,$n.y,Rn.z,0,-Rn.x,In.z,0,-In.x,$n.z,0,-$n.x,-Rn.y,Rn.x,0,-In.y,In.x,0,-$n.y,$n.x,0];return!za(e,vi,Mi,Si,Gs)||(e=[1,0,0,0,1,0,0,0,1],!za(e,vi,Mi,Si,Gs))?!1:(Ws.crossVectors(Rn,In),e=[Ws.x,Ws.y,Ws.z],za(e,vi,Mi,Si,Gs))}clampPoint(t,e){return e.copy(t).clamp(this.min,this.max)}distanceToPoint(t){return this.clampPoint(t,je).distanceTo(t)}getBoundingSphere(t){return this.isEmpty()?t.makeEmpty():(this.getCenter(t.center),t.radius=this.getSize(je).length()*.5),t}intersect(t){return this.min.max(t.min),this.max.min(t.max),this.isEmpty()&&this.makeEmpty(),this}union(t){return this.min.min(t.min),this.max.max(t.max),this}applyMatrix4(t){return this.isEmpty()?this:(yn[0].set(this.min.x,this.min.y,this.min.z).applyMatrix4(t),yn[1].set(this.min.x,this.min.y,this.max.z).applyMatrix4(t),yn[2].set(this.min.x,this.max.y,this.min.z).applyMatrix4(t),yn[3].set(this.min.x,this.max.y,this.max.z).applyMatrix4(t),yn[4].set(this.max.x,this.min.y,this.min.z).applyMatrix4(t),yn[5].set(this.max.x,this.min.y,this.max.z).applyMatrix4(t),yn[6].set(this.max.x,this.max.y,this.min.z).applyMatrix4(t),yn[7].set(this.max.x,this.max.y,this.max.z).applyMatrix4(t),this.setFromPoints(yn),this)}translate(t){return this.min.add(t),this.max.add(t),this}equals(t){return t.min.equals(this.min)&&t.max.equals(this.max)}toJSON(){return{min:this.min.toArray(),max:this.max.toArray()}}fromJSON(t){return this.min.fromArray(t.min),this.max.fromArray(t.max),this}},yn=[new N,new N,new N,new N,new N,new N,new N,new N],je=new N,Hs=new Bn,vi=new N,Mi=new N,Si=new N,Rn=new N,In=new N,$n=new N,ns=new N,Gs=new N,Ws=new N,Kn=new N;function za(i,t,e,n,s){for(let r=0,a=i.length-3;r<=a;r+=3){Kn.fromArray(i,r);let o=s.x*Math.abs(Kn.x)+s.y*Math.abs(Kn.y)+s.z*Math.abs(Kn.z),l=t.dot(Kn),c=e.dot(Kn),u=n.dot(Kn);if(Math.max(-Math.max(l,c,u),Math.min(l,c,u))>o)return!1}return!0}var Hh=new Bn,is=new N,ka=new N,Oi=class{constructor(t=new N,e=-1){this.isSphere=!0,this.center=t,this.radius=e}set(t,e){return this.center.copy(t),this.radius=e,this}setFromPoints(t,e){let n=this.center;e!==void 0?n.copy(e):Hh.setFromPoints(t).getCenter(n);let s=0;for(let r=0,a=t.length;r<a;r++)s=Math.max(s,n.distanceToSquared(t[r]));return this.radius=Math.sqrt(s),this}copy(t){return this.center.copy(t.center),this.radius=t.radius,this}isEmpty(){return this.radius<0}makeEmpty(){return this.center.set(0,0,0),this.radius=-1,this}containsPoint(t){return t.distanceToSquared(this.center)<=this.radius*this.radius}distanceToPoint(t){return t.distanceTo(this.center)-this.radius}intersectsSphere(t){let e=this.radius+t.radius;return t.center.distanceToSquared(this.center)<=e*e}intersectsBox(t){return t.intersectsSphere(this)}intersectsPlane(t){return Math.abs(t.distanceToPoint(this.center))<=this.radius}clampPoint(t,e){let n=this.center.distanceToSquared(t);return e.copy(t),n>this.radius*this.radius&&(e.sub(this.center).normalize(),e.multiplyScalar(this.radius).add(this.center)),e}getBoundingBox(t){return this.isEmpty()?(t.makeEmpty(),t):(t.set(this.center,this.center),t.expandByScalar(this.radius),t)}applyMatrix4(t){return this.center.applyMatrix4(t),this.radius=this.radius*t.getMaxScaleOnAxis(),this}translate(t){return this.center.add(t),this}expandByPoint(t){if(this.isEmpty())return this.center.copy(t),this.radius=0,this;is.subVectors(t,this.center);let e=is.lengthSq();if(e>this.radius*this.radius){let n=Math.sqrt(e),s=(n-this.radius)*.5;this.center.addScaledVector(is,s/n),this.radius+=s}return this}union(t){return t.isEmpty()?this:this.isEmpty()?(this.copy(t),this):(this.center.equals(t.center)===!0?this.radius=Math.max(this.radius,t.radius):(ka.subVectors(t.center,this.center).setLength(t.radius),this.expandByPoint(is.copy(t.center).add(ka)),this.expandByPoint(is.copy(t.center).sub(ka))),this)}equals(t){return t.center.equals(this.center)&&t.radius===this.radius}clone(){return new this.constructor().copy(this)}toJSON(){return{radius:this.radius,center:this.center.toArray()}}fromJSON(t){return this.radius=t.radius,this.center.fromArray(t.center),this}},vn=new N,Va=new N,Xs=new N,Pn=new N,Ha=new N,qs=new N,Ga=new N,si=class{constructor(t=new N,e=new N(0,0,-1)){this.origin=t,this.direction=e}set(t,e){return this.origin.copy(t),this.direction.copy(e),this}copy(t){return this.origin.copy(t.origin),this.direction.copy(t.direction),this}at(t,e){return e.copy(this.origin).addScaledVector(this.direction,t)}lookAt(t){return this.direction.copy(t).sub(this.origin).normalize(),this}recast(t){return this.origin.copy(this.at(t,vn)),this}closestPointToPoint(t,e){e.subVectors(t,this.origin);let n=e.dot(this.direction);return n<0?e.copy(this.origin):e.copy(this.origin).addScaledVector(this.direction,n)}distanceToPoint(t){return Math.sqrt(this.distanceSqToPoint(t))}distanceSqToPoint(t){let e=vn.subVectors(t,this.origin).dot(this.direction);return e<0?this.origin.distanceToSquared(t):(vn.copy(this.origin).addScaledVector(this.direction,e),vn.distanceToSquared(t))}distanceSqToSegment(t,e,n,s){Va.copy(t).add(e).multiplyScalar(.5),Xs.copy(e).sub(t).normalize(),Pn.copy(this.origin).sub(Va);let r=t.distanceTo(e)*.5,a=-this.direction.dot(Xs),o=Pn.dot(this.direction),l=-Pn.dot(Xs),c=Pn.lengthSq(),u=Math.abs(1-a*a),d,f,p,_;if(u>0)if(d=a*l-o,f=a*o-l,_=r*u,d>=0)if(f>=-_)if(f<=_){let v=1/u;d*=v,f*=v,p=d*(d+a*f+2*o)+f*(a*d+f+2*l)+c}else f=r,d=Math.max(0,-(a*f+o)),p=-d*d+f*(f+2*l)+c;else f=-r,d=Math.max(0,-(a*f+o)),p=-d*d+f*(f+2*l)+c;else f<=-_?(d=Math.max(0,-(-a*r+o)),f=d>0?-r:Math.min(Math.max(-r,-l),r),p=-d*d+f*(f+2*l)+c):f<=_?(d=0,f=Math.min(Math.max(-r,-l),r),p=f*(f+2*l)+c):(d=Math.max(0,-(a*r+o)),f=d>0?r:Math.min(Math.max(-r,-l),r),p=-d*d+f*(f+2*l)+c);else f=a>0?-r:r,d=Math.max(0,-(a*f+o)),p=-d*d+f*(f+2*l)+c;return n&&n.copy(this.origin).addScaledVector(this.direction,d),s&&s.copy(Va).addScaledVector(Xs,f),p}intersectSphere(t,e){vn.subVectors(t.center,this.origin);let n=vn.dot(this.direction),s=vn.dot(vn)-n*n,r=t.radius*t.radius;if(s>r)return null;let a=Math.sqrt(r-s),o=n-a,l=n+a;return l<0?null:o<0?this.at(l,e):this.at(o,e)}intersectsSphere(t){return t.radius<0?!1:this.distanceSqToPoint(t.center)<=t.radius*t.radius}distanceToPlane(t){let e=t.normal.dot(this.direction);if(e===0)return t.distanceToPoint(this.origin)===0?0:null;let n=-(this.origin.dot(t.normal)+t.constant)/e;return n>=0?n:null}intersectPlane(t,e){let n=this.distanceToPlane(t);return n===null?null:this.at(n,e)}intersectsPlane(t){let e=t.distanceToPoint(this.origin);return e===0||t.normal.dot(this.direction)*e<0}intersectBox(t,e){let n,s,r,a,o,l,c=1/this.direction.x,u=1/this.direction.y,d=1/this.direction.z,f=this.origin;return c>=0?(n=(t.min.x-f.x)*c,s=(t.max.x-f.x)*c):(n=(t.max.x-f.x)*c,s=(t.min.x-f.x)*c),u>=0?(r=(t.min.y-f.y)*u,a=(t.max.y-f.y)*u):(r=(t.max.y-f.y)*u,a=(t.min.y-f.y)*u),n>a||r>s||((r>n||isNaN(n))&&(n=r),(a<s||isNaN(s))&&(s=a),d>=0?(o=(t.min.z-f.z)*d,l=(t.max.z-f.z)*d):(o=(t.max.z-f.z)*d,l=(t.min.z-f.z)*d),n>l||o>s)||((o>n||n!==n)&&(n=o),(l<s||s!==s)&&(s=l),s<0)?null:this.at(n>=0?n:s,e)}intersectsBox(t){return this.intersectBox(t,vn)!==null}intersectTriangle(t,e,n,s,r){Ha.subVectors(e,t),qs.subVectors(n,t),Ga.crossVectors(Ha,qs);let a=this.direction.dot(Ga),o;if(a>0){if(s)return null;o=1}else if(a<0)o=-1,a=-a;else return null;Pn.subVectors(this.origin,t);let l=o*this.direction.dot(qs.crossVectors(Pn,qs));if(l<0)return null;let c=o*this.direction.dot(Ha.cross(Pn));if(c<0||l+c>a)return null;let u=-o*Pn.dot(Ga);return u<0?null:this.at(u/a,r)}applyMatrix4(t){return this.origin.applyMatrix4(t),this.direction.transformDirection(t),this}equals(t){return t.origin.equals(this.origin)&&t.direction.equals(this.direction)}clone(){return new this.constructor().copy(this)}},ce=class i{constructor(t,e,n,s,r,a,o,l,c,u,d,f,p,_,v,m){i.prototype.isMatrix4=!0,this.elements=[1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1],t!==void 0&&this.set(t,e,n,s,r,a,o,l,c,u,d,f,p,_,v,m)}set(t,e,n,s,r,a,o,l,c,u,d,f,p,_,v,m){let h=this.elements;return h[0]=t,h[4]=e,h[8]=n,h[12]=s,h[1]=r,h[5]=a,h[9]=o,h[13]=l,h[2]=c,h[6]=u,h[10]=d,h[14]=f,h[3]=p,h[7]=_,h[11]=v,h[15]=m,this}identity(){return this.set(1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1),this}clone(){return new i().fromArray(this.elements)}copy(t){let e=this.elements,n=t.elements;return e[0]=n[0],e[1]=n[1],e[2]=n[2],e[3]=n[3],e[4]=n[4],e[5]=n[5],e[6]=n[6],e[7]=n[7],e[8]=n[8],e[9]=n[9],e[10]=n[10],e[11]=n[11],e[12]=n[12],e[13]=n[13],e[14]=n[14],e[15]=n[15],this}copyPosition(t){let e=this.elements,n=t.elements;return e[12]=n[12],e[13]=n[13],e[14]=n[14],this}setFromMatrix3(t){let e=t.elements;return this.set(e[0],e[3],e[6],0,e[1],e[4],e[7],0,e[2],e[5],e[8],0,0,0,0,1),this}extractBasis(t,e,n){return t.setFromMatrixColumn(this,0),e.setFromMatrixColumn(this,1),n.setFromMatrixColumn(this,2),this}makeBasis(t,e,n){return this.set(t.x,e.x,n.x,0,t.y,e.y,n.y,0,t.z,e.z,n.z,0,0,0,0,1),this}extractRotation(t){let e=this.elements,n=t.elements,s=1/bi.setFromMatrixColumn(t,0).length(),r=1/bi.setFromMatrixColumn(t,1).length(),a=1/bi.setFromMatrixColumn(t,2).length();return e[0]=n[0]*s,e[1]=n[1]*s,e[2]=n[2]*s,e[3]=0,e[4]=n[4]*r,e[5]=n[5]*r,e[6]=n[6]*r,e[7]=0,e[8]=n[8]*a,e[9]=n[9]*a,e[10]=n[10]*a,e[11]=0,e[12]=0,e[13]=0,e[14]=0,e[15]=1,this}makeRotationFromEuler(t){let e=this.elements,n=t.x,s=t.y,r=t.z,a=Math.cos(n),o=Math.sin(n),l=Math.cos(s),c=Math.sin(s),u=Math.cos(r),d=Math.sin(r);if(t.order==="XYZ"){let f=a*u,p=a*d,_=o*u,v=o*d;e[0]=l*u,e[4]=-l*d,e[8]=c,e[1]=p+_*c,e[5]=f-v*c,e[9]=-o*l,e[2]=v-f*c,e[6]=_+p*c,e[10]=a*l}else if(t.order==="YXZ"){let f=l*u,p=l*d,_=c*u,v=c*d;e[0]=f+v*o,e[4]=_*o-p,e[8]=a*c,e[1]=a*d,e[5]=a*u,e[9]=-o,e[2]=p*o-_,e[6]=v+f*o,e[10]=a*l}else if(t.order==="ZXY"){let f=l*u,p=l*d,_=c*u,v=c*d;e[0]=f-v*o,e[4]=-a*d,e[8]=_+p*o,e[1]=p+_*o,e[5]=a*u,e[9]=v-f*o,e[2]=-a*c,e[6]=o,e[10]=a*l}else if(t.order==="ZYX"){let f=a*u,p=a*d,_=o*u,v=o*d;e[0]=l*u,e[4]=_*c-p,e[8]=f*c+v,e[1]=l*d,e[5]=v*c+f,e[9]=p*c-_,e[2]=-c,e[6]=o*l,e[10]=a*l}else if(t.order==="YZX"){let f=a*l,p=a*c,_=o*l,v=o*c;e[0]=l*u,e[4]=v-f*d,e[8]=_*d+p,e[1]=d,e[5]=a*u,e[9]=-o*u,e[2]=-c*u,e[6]=p*d+_,e[10]=f-v*d}else if(t.order==="XZY"){let f=a*l,p=a*c,_=o*l,v=o*c;e[0]=l*u,e[4]=-d,e[8]=c*u,e[1]=f*d+v,e[5]=a*u,e[9]=p*d-_,e[2]=_*d-p,e[6]=o*u,e[10]=v*d+f}return e[3]=0,e[7]=0,e[11]=0,e[12]=0,e[13]=0,e[14]=0,e[15]=1,this}makeRotationFromQuaternion(t){return this.compose(Gh,t,Wh)}lookAt(t,e,n){let s=this.elements;return ze.subVectors(t,e),ze.lengthSq()===0&&(ze.z=1),ze.normalize(),Dn.crossVectors(n,ze),Dn.lengthSq()===0&&(Math.abs(n.z)===1?ze.x+=1e-4:ze.z+=1e-4,ze.normalize(),Dn.crossVectors(n,ze)),Dn.normalize(),Ys.crossVectors(ze,Dn),s[0]=Dn.x,s[4]=Ys.x,s[8]=ze.x,s[1]=Dn.y,s[5]=Ys.y,s[9]=ze.y,s[2]=Dn.z,s[6]=Ys.z,s[10]=ze.z,this}multiply(t){return this.multiplyMatrices(this,t)}premultiply(t){return this.multiplyMatrices(t,this)}multiplyMatrices(t,e){let n=t.elements,s=e.elements,r=this.elements,a=n[0],o=n[4],l=n[8],c=n[12],u=n[1],d=n[5],f=n[9],p=n[13],_=n[2],v=n[6],m=n[10],h=n[14],w=n[3],E=n[7],S=n[11],C=n[15],A=s[0],P=s[4],U=s[8],M=s[12],y=s[1],I=s[5],O=s[9],k=s[13],G=s[2],q=s[6],W=s[10],et=s[14],V=s[3],rt=s[7],ct=s[11],St=s[15];return r[0]=a*A+o*y+l*G+c*V,r[4]=a*P+o*I+l*q+c*rt,r[8]=a*U+o*O+l*W+c*ct,r[12]=a*M+o*k+l*et+c*St,r[1]=u*A+d*y+f*G+p*V,r[5]=u*P+d*I+f*q+p*rt,r[9]=u*U+d*O+f*W+p*ct,r[13]=u*M+d*k+f*et+p*St,r[2]=_*A+v*y+m*G+h*V,r[6]=_*P+v*I+m*q+h*rt,r[10]=_*U+v*O+m*W+h*ct,r[14]=_*M+v*k+m*et+h*St,r[3]=w*A+E*y+S*G+C*V,r[7]=w*P+E*I+S*q+C*rt,r[11]=w*U+E*O+S*W+C*ct,r[15]=w*M+E*k+S*et+C*St,this}multiplyScalar(t){let e=this.elements;return e[0]*=t,e[4]*=t,e[8]*=t,e[12]*=t,e[1]*=t,e[5]*=t,e[9]*=t,e[13]*=t,e[2]*=t,e[6]*=t,e[10]*=t,e[14]*=t,e[3]*=t,e[7]*=t,e[11]*=t,e[15]*=t,this}determinant(){let t=this.elements,e=t[0],n=t[4],s=t[8],r=t[12],a=t[1],o=t[5],l=t[9],c=t[13],u=t[2],d=t[6],f=t[10],p=t[14],_=t[3],v=t[7],m=t[11],h=t[15];return _*(+r*l*d-s*c*d-r*o*f+n*c*f+s*o*p-n*l*p)+v*(+e*l*p-e*c*f+r*a*f-s*a*p+s*c*u-r*l*u)+m*(+e*c*d-e*o*p-r*a*d+n*a*p+r*o*u-n*c*u)+h*(-s*o*u-e*l*d+e*o*f+s*a*d-n*a*f+n*l*u)}transpose(){let t=this.elements,e;return e=t[1],t[1]=t[4],t[4]=e,e=t[2],t[2]=t[8],t[8]=e,e=t[6],t[6]=t[9],t[9]=e,e=t[3],t[3]=t[12],t[12]=e,e=t[7],t[7]=t[13],t[13]=e,e=t[11],t[11]=t[14],t[14]=e,this}setPosition(t,e,n){let s=this.elements;return t.isVector3?(s[12]=t.x,s[13]=t.y,s[14]=t.z):(s[12]=t,s[13]=e,s[14]=n),this}invert(){let t=this.elements,e=t[0],n=t[1],s=t[2],r=t[3],a=t[4],o=t[5],l=t[6],c=t[7],u=t[8],d=t[9],f=t[10],p=t[11],_=t[12],v=t[13],m=t[14],h=t[15],w=d*m*c-v*f*c+v*l*p-o*m*p-d*l*h+o*f*h,E=_*f*c-u*m*c-_*l*p+a*m*p+u*l*h-a*f*h,S=u*v*c-_*d*c+_*o*p-a*v*p-u*o*h+a*d*h,C=_*d*l-u*v*l-_*o*f+a*v*f+u*o*m-a*d*m,A=e*w+n*E+s*S+r*C;if(A===0)return this.set(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);let P=1/A;return t[0]=w*P,t[1]=(v*f*r-d*m*r-v*s*p+n*m*p+d*s*h-n*f*h)*P,t[2]=(o*m*r-v*l*r+v*s*c-n*m*c-o*s*h+n*l*h)*P,t[3]=(d*l*r-o*f*r-d*s*c+n*f*c+o*s*p-n*l*p)*P,t[4]=E*P,t[5]=(u*m*r-_*f*r+_*s*p-e*m*p-u*s*h+e*f*h)*P,t[6]=(_*l*r-a*m*r-_*s*c+e*m*c+a*s*h-e*l*h)*P,t[7]=(a*f*r-u*l*r+u*s*c-e*f*c-a*s*p+e*l*p)*P,t[8]=S*P,t[9]=(_*d*r-u*v*r-_*n*p+e*v*p+u*n*h-e*d*h)*P,t[10]=(a*v*r-_*o*r+_*n*c-e*v*c-a*n*h+e*o*h)*P,t[11]=(u*o*r-a*d*r-u*n*c+e*d*c+a*n*p-e*o*p)*P,t[12]=C*P,t[13]=(u*v*s-_*d*s+_*n*f-e*v*f-u*n*m+e*d*m)*P,t[14]=(_*o*s-a*v*s-_*n*l+e*v*l+a*n*m-e*o*m)*P,t[15]=(a*d*s-u*o*s+u*n*l-e*d*l-a*n*f+e*o*f)*P,this}scale(t){let e=this.elements,n=t.x,s=t.y,r=t.z;return e[0]*=n,e[4]*=s,e[8]*=r,e[1]*=n,e[5]*=s,e[9]*=r,e[2]*=n,e[6]*=s,e[10]*=r,e[3]*=n,e[7]*=s,e[11]*=r,this}getMaxScaleOnAxis(){let t=this.elements,e=t[0]*t[0]+t[1]*t[1]+t[2]*t[2],n=t[4]*t[4]+t[5]*t[5]+t[6]*t[6],s=t[8]*t[8]+t[9]*t[9]+t[10]*t[10];return Math.sqrt(Math.max(e,n,s))}makeTranslation(t,e,n){return t.isVector3?this.set(1,0,0,t.x,0,1,0,t.y,0,0,1,t.z,0,0,0,1):this.set(1,0,0,t,0,1,0,e,0,0,1,n,0,0,0,1),this}makeRotationX(t){let e=Math.cos(t),n=Math.sin(t);return this.set(1,0,0,0,0,e,-n,0,0,n,e,0,0,0,0,1),this}makeRotationY(t){let e=Math.cos(t),n=Math.sin(t);return this.set(e,0,n,0,0,1,0,0,-n,0,e,0,0,0,0,1),this}makeRotationZ(t){let e=Math.cos(t),n=Math.sin(t);return this.set(e,-n,0,0,n,e,0,0,0,0,1,0,0,0,0,1),this}makeRotationAxis(t,e){let n=Math.cos(e),s=Math.sin(e),r=1-n,a=t.x,o=t.y,l=t.z,c=r*a,u=r*o;return this.set(c*a+n,c*o-s*l,c*l+s*o,0,c*o+s*l,u*o+n,u*l-s*a,0,c*l-s*o,u*l+s*a,r*l*l+n,0,0,0,0,1),this}makeScale(t,e,n){return this.set(t,0,0,0,0,e,0,0,0,0,n,0,0,0,0,1),this}makeShear(t,e,n,s,r,a){return this.set(1,n,r,0,t,1,a,0,e,s,1,0,0,0,0,1),this}compose(t,e,n){let s=this.elements,r=e._x,a=e._y,o=e._z,l=e._w,c=r+r,u=a+a,d=o+o,f=r*c,p=r*u,_=r*d,v=a*u,m=a*d,h=o*d,w=l*c,E=l*u,S=l*d,C=n.x,A=n.y,P=n.z;return s[0]=(1-(v+h))*C,s[1]=(p+S)*C,s[2]=(_-E)*C,s[3]=0,s[4]=(p-S)*A,s[5]=(1-(f+h))*A,s[6]=(m+w)*A,s[7]=0,s[8]=(_+E)*P,s[9]=(m-w)*P,s[10]=(1-(f+v))*P,s[11]=0,s[12]=t.x,s[13]=t.y,s[14]=t.z,s[15]=1,this}decompose(t,e,n){let s=this.elements,r=bi.set(s[0],s[1],s[2]).length(),a=bi.set(s[4],s[5],s[6]).length(),o=bi.set(s[8],s[9],s[10]).length();this.determinant()<0&&(r=-r),t.x=s[12],t.y=s[13],t.z=s[14],Qe.copy(this);let c=1/r,u=1/a,d=1/o;return Qe.elements[0]*=c,Qe.elements[1]*=c,Qe.elements[2]*=c,Qe.elements[4]*=u,Qe.elements[5]*=u,Qe.elements[6]*=u,Qe.elements[8]*=d,Qe.elements[9]*=d,Qe.elements[10]*=d,e.setFromRotationMatrix(Qe),n.x=r,n.y=a,n.z=o,this}makePerspective(t,e,n,s,r,a,o=en,l=!1){let c=this.elements,u=2*r/(e-t),d=2*r/(n-s),f=(e+t)/(e-t),p=(n+s)/(n-s),_,v;if(l)_=r/(a-r),v=a*r/(a-r);else if(o===en)_=-(a+r)/(a-r),v=-2*a*r/(a-r);else if(o===hs)_=-a/(a-r),v=-a*r/(a-r);else throw new Error("THREE.Matrix4.makePerspective(): Invalid coordinate system: "+o);return c[0]=u,c[4]=0,c[8]=f,c[12]=0,c[1]=0,c[5]=d,c[9]=p,c[13]=0,c[2]=0,c[6]=0,c[10]=_,c[14]=v,c[3]=0,c[7]=0,c[11]=-1,c[15]=0,this}makeOrthographic(t,e,n,s,r,a,o=en,l=!1){let c=this.elements,u=2/(e-t),d=2/(n-s),f=-(e+t)/(e-t),p=-(n+s)/(n-s),_,v;if(l)_=1/(a-r),v=a/(a-r);else if(o===en)_=-2/(a-r),v=-(a+r)/(a-r);else if(o===hs)_=-1/(a-r),v=-r/(a-r);else throw new Error("THREE.Matrix4.makeOrthographic(): Invalid coordinate system: "+o);return c[0]=u,c[4]=0,c[8]=0,c[12]=f,c[1]=0,c[5]=d,c[9]=0,c[13]=p,c[2]=0,c[6]=0,c[10]=_,c[14]=v,c[3]=0,c[7]=0,c[11]=0,c[15]=1,this}equals(t){let e=this.elements,n=t.elements;for(let s=0;s<16;s++)if(e[s]!==n[s])return!1;return!0}fromArray(t,e=0){for(let n=0;n<16;n++)this.elements[n]=t[n+e];return this}toArray(t=[],e=0){let n=this.elements;return t[e]=n[0],t[e+1]=n[1],t[e+2]=n[2],t[e+3]=n[3],t[e+4]=n[4],t[e+5]=n[5],t[e+6]=n[6],t[e+7]=n[7],t[e+8]=n[8],t[e+9]=n[9],t[e+10]=n[10],t[e+11]=n[11],t[e+12]=n[12],t[e+13]=n[13],t[e+14]=n[14],t[e+15]=n[15],t}},bi=new N,Qe=new ce,Gh=new N(0,0,0),Wh=new N(1,1,1),Dn=new N,Ys=new N,ze=new N,xl=new ce,yl=new Je,sn=class i{constructor(t=0,e=0,n=0,s=i.DEFAULT_ORDER){this.isEuler=!0,this._x=t,this._y=e,this._z=n,this._order=s}get x(){return this._x}set x(t){this._x=t,this._onChangeCallback()}get y(){return this._y}set y(t){this._y=t,this._onChangeCallback()}get z(){return this._z}set z(t){this._z=t,this._onChangeCallback()}get order(){return this._order}set order(t){this._order=t,this._onChangeCallback()}set(t,e,n,s=this._order){return this._x=t,this._y=e,this._z=n,this._order=s,this._onChangeCallback(),this}clone(){return new this.constructor(this._x,this._y,this._z,this._order)}copy(t){return this._x=t._x,this._y=t._y,this._z=t._z,this._order=t._order,this._onChangeCallback(),this}setFromRotationMatrix(t,e=this._order,n=!0){let s=t.elements,r=s[0],a=s[4],o=s[8],l=s[1],c=s[5],u=s[9],d=s[2],f=s[6],p=s[10];switch(e){case"XYZ":this._y=Math.asin(zt(o,-1,1)),Math.abs(o)<.9999999?(this._x=Math.atan2(-u,p),this._z=Math.atan2(-a,r)):(this._x=Math.atan2(f,c),this._z=0);break;case"YXZ":this._x=Math.asin(-zt(u,-1,1)),Math.abs(u)<.9999999?(this._y=Math.atan2(o,p),this._z=Math.atan2(l,c)):(this._y=Math.atan2(-d,r),this._z=0);break;case"ZXY":this._x=Math.asin(zt(f,-1,1)),Math.abs(f)<.9999999?(this._y=Math.atan2(-d,p),this._z=Math.atan2(-a,c)):(this._y=0,this._z=Math.atan2(l,r));break;case"ZYX":this._y=Math.asin(-zt(d,-1,1)),Math.abs(d)<.9999999?(this._x=Math.atan2(f,p),this._z=Math.atan2(l,r)):(this._x=0,this._z=Math.atan2(-a,c));break;case"YZX":this._z=Math.asin(zt(l,-1,1)),Math.abs(l)<.9999999?(this._x=Math.atan2(-u,c),this._y=Math.atan2(-d,r)):(this._x=0,this._y=Math.atan2(o,p));break;case"XZY":this._z=Math.asin(-zt(a,-1,1)),Math.abs(a)<.9999999?(this._x=Math.atan2(f,c),this._y=Math.atan2(o,r)):(this._x=Math.atan2(-u,p),this._y=0);break;default:console.warn("THREE.Euler: .setFromRotationMatrix() encountered an unknown order: "+e)}return this._order=e,n===!0&&this._onChangeCallback(),this}setFromQuaternion(t,e,n){return xl.makeRotationFromQuaternion(t),this.setFromRotationMatrix(xl,e,n)}setFromVector3(t,e=this._order){return this.set(t.x,t.y,t.z,e)}reorder(t){return yl.setFromEuler(this),this.setFromQuaternion(yl,t)}equals(t){return t._x===this._x&&t._y===this._y&&t._z===this._z&&t._order===this._order}fromArray(t){return this._x=t[0],this._y=t[1],this._z=t[2],t[3]!==void 0&&(this._order=t[3]),this._onChangeCallback(),this}toArray(t=[],e=0){return t[e]=this._x,t[e+1]=this._y,t[e+2]=this._z,t[e+3]=this._order,t}_onChange(t){return this._onChangeCallback=t,this}_onChangeCallback(){}*[Symbol.iterator](){yield this._x,yield this._y,yield this._z,yield this._order}};sn.DEFAULT_ORDER="XYZ";var Bi=class{constructor(){this.mask=1}set(t){this.mask=(1<<t|0)>>>0}enable(t){this.mask|=1<<t|0}enableAll(){this.mask=-1}toggle(t){this.mask^=1<<t|0}disable(t){this.mask&=~(1<<t|0)}disableAll(){this.mask=0}test(t){return(this.mask&t.mask)!==0}isEnabled(t){return(this.mask&(1<<t|0))!==0}},Xh=0,vl=new N,Ei=new Je,Mn=new ce,Zs=new N,ss=new N,qh=new N,Yh=new Je,Ml=new N(1,0,0),Sl=new N(0,1,0),bl=new N(0,0,1),El={type:"added"},Zh={type:"removed"},Ti={type:"childadded",child:null},Wa={type:"childremoved",child:null},Ae=class i extends un{constructor(){super(),this.isObject3D=!0,Object.defineProperty(this,"id",{value:Xh++}),this.uuid=qi(),this.name="",this.type="Object3D",this.parent=null,this.children=[],this.up=i.DEFAULT_UP.clone();let t=new N,e=new sn,n=new Je,s=new N(1,1,1);function r(){n.setFromEuler(e,!1)}function a(){e.setFromQuaternion(n,void 0,!1)}e._onChange(r),n._onChange(a),Object.defineProperties(this,{position:{configurable:!0,enumerable:!0,value:t},rotation:{configurable:!0,enumerable:!0,value:e},quaternion:{configurable:!0,enumerable:!0,value:n},scale:{configurable:!0,enumerable:!0,value:s},modelViewMatrix:{value:new ce},normalMatrix:{value:new Ut}}),this.matrix=new ce,this.matrixWorld=new ce,this.matrixAutoUpdate=i.DEFAULT_MATRIX_AUTO_UPDATE,this.matrixWorldAutoUpdate=i.DEFAULT_MATRIX_WORLD_AUTO_UPDATE,this.matrixWorldNeedsUpdate=!1,this.layers=new Bi,this.visible=!0,this.castShadow=!1,this.receiveShadow=!1,this.frustumCulled=!0,this.renderOrder=0,this.animations=[],this.customDepthMaterial=void 0,this.customDistanceMaterial=void 0,this.userData={}}onBeforeShadow(){}onAfterShadow(){}onBeforeRender(){}onAfterRender(){}applyMatrix4(t){this.matrixAutoUpdate&&this.updateMatrix(),this.matrix.premultiply(t),this.matrix.decompose(this.position,this.quaternion,this.scale)}applyQuaternion(t){return this.quaternion.premultiply(t),this}setRotationFromAxisAngle(t,e){this.quaternion.setFromAxisAngle(t,e)}setRotationFromEuler(t){this.quaternion.setFromEuler(t,!0)}setRotationFromMatrix(t){this.quaternion.setFromRotationMatrix(t)}setRotationFromQuaternion(t){this.quaternion.copy(t)}rotateOnAxis(t,e){return Ei.setFromAxisAngle(t,e),this.quaternion.multiply(Ei),this}rotateOnWorldAxis(t,e){return Ei.setFromAxisAngle(t,e),this.quaternion.premultiply(Ei),this}rotateX(t){return this.rotateOnAxis(Ml,t)}rotateY(t){return this.rotateOnAxis(Sl,t)}rotateZ(t){return this.rotateOnAxis(bl,t)}translateOnAxis(t,e){return vl.copy(t).applyQuaternion(this.quaternion),this.position.add(vl.multiplyScalar(e)),this}translateX(t){return this.translateOnAxis(Ml,t)}translateY(t){return this.translateOnAxis(Sl,t)}translateZ(t){return this.translateOnAxis(bl,t)}localToWorld(t){return this.updateWorldMatrix(!0,!1),t.applyMatrix4(this.matrixWorld)}worldToLocal(t){return this.updateWorldMatrix(!0,!1),t.applyMatrix4(Mn.copy(this.matrixWorld).invert())}lookAt(t,e,n){t.isVector3?Zs.copy(t):Zs.set(t,e,n);let s=this.parent;this.updateWorldMatrix(!0,!1),ss.setFromMatrixPosition(this.matrixWorld),this.isCamera||this.isLight?Mn.lookAt(ss,Zs,this.up):Mn.lookAt(Zs,ss,this.up),this.quaternion.setFromRotationMatrix(Mn),s&&(Mn.extractRotation(s.matrixWorld),Ei.setFromRotationMatrix(Mn),this.quaternion.premultiply(Ei.invert()))}add(t){if(arguments.length>1){for(let e=0;e<arguments.length;e++)this.add(arguments[e]);return this}return t===this?(console.error("THREE.Object3D.add: object can't be added as a child of itself.",t),this):(t&&t.isObject3D?(t.removeFromParent(),t.parent=this,this.children.push(t),t.dispatchEvent(El),Ti.child=t,this.dispatchEvent(Ti),Ti.child=null):console.error("THREE.Object3D.add: object not an instance of THREE.Object3D.",t),this)}remove(t){if(arguments.length>1){for(let n=0;n<arguments.length;n++)this.remove(arguments[n]);return this}let e=this.children.indexOf(t);return e!==-1&&(t.parent=null,this.children.splice(e,1),t.dispatchEvent(Zh),Wa.child=t,this.dispatchEvent(Wa),Wa.child=null),this}removeFromParent(){let t=this.parent;return t!==null&&t.remove(this),this}clear(){return this.remove(...this.children)}attach(t){return this.updateWorldMatrix(!0,!1),Mn.copy(this.matrixWorld).invert(),t.parent!==null&&(t.parent.updateWorldMatrix(!0,!1),Mn.multiply(t.parent.matrixWorld)),t.applyMatrix4(Mn),t.removeFromParent(),t.parent=this,this.children.push(t),t.updateWorldMatrix(!1,!0),t.dispatchEvent(El),Ti.child=t,this.dispatchEvent(Ti),Ti.child=null,this}getObjectById(t){return this.getObjectByProperty("id",t)}getObjectByName(t){return this.getObjectByProperty("name",t)}getObjectByProperty(t,e){if(this[t]===e)return this;for(let n=0,s=this.children.length;n<s;n++){let a=this.children[n].getObjectByProperty(t,e);if(a!==void 0)return a}}getObjectsByProperty(t,e,n=[]){this[t]===e&&n.push(this);let s=this.children;for(let r=0,a=s.length;r<a;r++)s[r].getObjectsByProperty(t,e,n);return n}getWorldPosition(t){return this.updateWorldMatrix(!0,!1),t.setFromMatrixPosition(this.matrixWorld)}getWorldQuaternion(t){return this.updateWorldMatrix(!0,!1),this.matrixWorld.decompose(ss,t,qh),t}getWorldScale(t){return this.updateWorldMatrix(!0,!1),this.matrixWorld.decompose(ss,Yh,t),t}getWorldDirection(t){this.updateWorldMatrix(!0,!1);let e=this.matrixWorld.elements;return t.set(e[8],e[9],e[10]).normalize()}raycast(){}traverse(t){t(this);let e=this.children;for(let n=0,s=e.length;n<s;n++)e[n].traverse(t)}traverseVisible(t){if(this.visible===!1)return;t(this);let e=this.children;for(let n=0,s=e.length;n<s;n++)e[n].traverseVisible(t)}traverseAncestors(t){let e=this.parent;e!==null&&(t(e),e.traverseAncestors(t))}updateMatrix(){this.matrix.compose(this.position,this.quaternion,this.scale),this.matrixWorldNeedsUpdate=!0}updateMatrixWorld(t){this.matrixAutoUpdate&&this.updateMatrix(),(this.matrixWorldNeedsUpdate||t)&&(this.matrixWorldAutoUpdate===!0&&(this.parent===null?this.matrixWorld.copy(this.matrix):this.matrixWorld.multiplyMatrices(this.parent.matrixWorld,this.matrix)),this.matrixWorldNeedsUpdate=!1,t=!0);let e=this.children;for(let n=0,s=e.length;n<s;n++)e[n].updateMatrixWorld(t)}updateWorldMatrix(t,e){let n=this.parent;if(t===!0&&n!==null&&n.updateWorldMatrix(!0,!1),this.matrixAutoUpdate&&this.updateMatrix(),this.matrixWorldAutoUpdate===!0&&(this.parent===null?this.matrixWorld.copy(this.matrix):this.matrixWorld.multiplyMatrices(this.parent.matrixWorld,this.matrix)),e===!0){let s=this.children;for(let r=0,a=s.length;r<a;r++)s[r].updateWorldMatrix(!1,!0)}}toJSON(t){let e=t===void 0||typeof t=="string",n={};e&&(t={geometries:{},materials:{},textures:{},images:{},shapes:{},skeletons:{},animations:{},nodes:{}},n.metadata={version:4.7,type:"Object",generator:"Object3D.toJSON"});let s={};s.uuid=this.uuid,s.type=this.type,this.name!==""&&(s.name=this.name),this.castShadow===!0&&(s.castShadow=!0),this.receiveShadow===!0&&(s.receiveShadow=!0),this.visible===!1&&(s.visible=!1),this.frustumCulled===!1&&(s.frustumCulled=!1),this.renderOrder!==0&&(s.renderOrder=this.renderOrder),Object.keys(this.userData).length>0&&(s.userData=this.userData),s.layers=this.layers.mask,s.matrix=this.matrix.toArray(),s.up=this.up.toArray(),this.matrixAutoUpdate===!1&&(s.matrixAutoUpdate=!1),this.isInstancedMesh&&(s.type="InstancedMesh",s.count=this.count,s.instanceMatrix=this.instanceMatrix.toJSON(),this.instanceColor!==null&&(s.instanceColor=this.instanceColor.toJSON())),this.isBatchedMesh&&(s.type="BatchedMesh",s.perObjectFrustumCulled=this.perObjectFrustumCulled,s.sortObjects=this.sortObjects,s.drawRanges=this._drawRanges,s.reservedRanges=this._reservedRanges,s.geometryInfo=this._geometryInfo.map(o=>({...o,boundingBox:o.boundingBox?o.boundingBox.toJSON():void 0,boundingSphere:o.boundingSphere?o.boundingSphere.toJSON():void 0})),s.instanceInfo=this._instanceInfo.map(o=>({...o})),s.availableInstanceIds=this._availableInstanceIds.slice(),s.availableGeometryIds=this._availableGeometryIds.slice(),s.nextIndexStart=this._nextIndexStart,s.nextVertexStart=this._nextVertexStart,s.geometryCount=this._geometryCount,s.maxInstanceCount=this._maxInstanceCount,s.maxVertexCount=this._maxVertexCount,s.maxIndexCount=this._maxIndexCount,s.geometryInitialized=this._geometryInitialized,s.matricesTexture=this._matricesTexture.toJSON(t),s.indirectTexture=this._indirectTexture.toJSON(t),this._colorsTexture!==null&&(s.colorsTexture=this._colorsTexture.toJSON(t)),this.boundingSphere!==null&&(s.boundingSphere=this.boundingSphere.toJSON()),this.boundingBox!==null&&(s.boundingBox=this.boundingBox.toJSON()));function r(o,l){return o[l.uuid]===void 0&&(o[l.uuid]=l.toJSON(t)),l.uuid}if(this.isScene)this.background&&(this.background.isColor?s.background=this.background.toJSON():this.background.isTexture&&(s.background=this.background.toJSON(t).uuid)),this.environment&&this.environment.isTexture&&this.environment.isRenderTargetTexture!==!0&&(s.environment=this.environment.toJSON(t).uuid);else if(this.isMesh||this.isLine||this.isPoints){s.geometry=r(t.geometries,this.geometry);let o=this.geometry.parameters;if(o!==void 0&&o.shapes!==void 0){let l=o.shapes;if(Array.isArray(l))for(let c=0,u=l.length;c<u;c++){let d=l[c];r(t.shapes,d)}else r(t.shapes,l)}}if(this.isSkinnedMesh&&(s.bindMode=this.bindMode,s.bindMatrix=this.bindMatrix.toArray(),this.skeleton!==void 0&&(r(t.skeletons,this.skeleton),s.skeleton=this.skeleton.uuid)),this.material!==void 0)if(Array.isArray(this.material)){let o=[];for(let l=0,c=this.material.length;l<c;l++)o.push(r(t.materials,this.material[l]));s.material=o}else s.material=r(t.materials,this.material);if(this.children.length>0){s.children=[];for(let o=0;o<this.children.length;o++)s.children.push(this.children[o].toJSON(t).object)}if(this.animations.length>0){s.animations=[];for(let o=0;o<this.animations.length;o++){let l=this.animations[o];s.animations.push(r(t.animations,l))}}if(e){let o=a(t.geometries),l=a(t.materials),c=a(t.textures),u=a(t.images),d=a(t.shapes),f=a(t.skeletons),p=a(t.animations),_=a(t.nodes);o.length>0&&(n.geometries=o),l.length>0&&(n.materials=l),c.length>0&&(n.textures=c),u.length>0&&(n.images=u),d.length>0&&(n.shapes=d),f.length>0&&(n.skeletons=f),p.length>0&&(n.animations=p),_.length>0&&(n.nodes=_)}return n.object=s,n;function a(o){let l=[];for(let c in o){let u=o[c];delete u.metadata,l.push(u)}return l}}clone(t){return new this.constructor().copy(this,t)}copy(t,e=!0){if(this.name=t.name,this.up.copy(t.up),this.position.copy(t.position),this.rotation.order=t.rotation.order,this.quaternion.copy(t.quaternion),this.scale.copy(t.scale),this.matrix.copy(t.matrix),this.matrixWorld.copy(t.matrixWorld),this.matrixAutoUpdate=t.matrixAutoUpdate,this.matrixWorldAutoUpdate=t.matrixWorldAutoUpdate,this.matrixWorldNeedsUpdate=t.matrixWorldNeedsUpdate,this.layers.mask=t.layers.mask,this.visible=t.visible,this.castShadow=t.castShadow,this.receiveShadow=t.receiveShadow,this.frustumCulled=t.frustumCulled,this.renderOrder=t.renderOrder,this.animations=t.animations.slice(),this.userData=JSON.parse(JSON.stringify(t.userData)),e===!0)for(let n=0;n<t.children.length;n++){let s=t.children[n];this.add(s.clone())}return this}};Ae.DEFAULT_UP=new N(0,1,0);Ae.DEFAULT_MATRIX_AUTO_UPDATE=!0;Ae.DEFAULT_MATRIX_WORLD_AUTO_UPDATE=!0;var tn=new N,Sn=new N,Xa=new N,bn=new N,wi=new N,Ai=new N,Tl=new N,qa=new N,Ya=new N,Za=new N,Ja=new oe,$a=new oe,Ka=new oe,Nn=class i{constructor(t=new N,e=new N,n=new N){this.a=t,this.b=e,this.c=n}static getNormal(t,e,n,s){s.subVectors(n,e),tn.subVectors(t,e),s.cross(tn);let r=s.lengthSq();return r>0?s.multiplyScalar(1/Math.sqrt(r)):s.set(0,0,0)}static getBarycoord(t,e,n,s,r){tn.subVectors(s,e),Sn.subVectors(n,e),Xa.subVectors(t,e);let a=tn.dot(tn),o=tn.dot(Sn),l=tn.dot(Xa),c=Sn.dot(Sn),u=Sn.dot(Xa),d=a*c-o*o;if(d===0)return r.set(0,0,0),null;let f=1/d,p=(c*l-o*u)*f,_=(a*u-o*l)*f;return r.set(1-p-_,_,p)}static containsPoint(t,e,n,s){return this.getBarycoord(t,e,n,s,bn)===null?!1:bn.x>=0&&bn.y>=0&&bn.x+bn.y<=1}static getInterpolation(t,e,n,s,r,a,o,l){return this.getBarycoord(t,e,n,s,bn)===null?(l.x=0,l.y=0,"z"in l&&(l.z=0),"w"in l&&(l.w=0),null):(l.setScalar(0),l.addScaledVector(r,bn.x),l.addScaledVector(a,bn.y),l.addScaledVector(o,bn.z),l)}static getInterpolatedAttribute(t,e,n,s,r,a){return Ja.setScalar(0),$a.setScalar(0),Ka.setScalar(0),Ja.fromBufferAttribute(t,e),$a.fromBufferAttribute(t,n),Ka.fromBufferAttribute(t,s),a.setScalar(0),a.addScaledVector(Ja,r.x),a.addScaledVector($a,r.y),a.addScaledVector(Ka,r.z),a}static isFrontFacing(t,e,n,s){return tn.subVectors(n,e),Sn.subVectors(t,e),tn.cross(Sn).dot(s)<0}set(t,e,n){return this.a.copy(t),this.b.copy(e),this.c.copy(n),this}setFromPointsAndIndices(t,e,n,s){return this.a.copy(t[e]),this.b.copy(t[n]),this.c.copy(t[s]),this}setFromAttributeAndIndices(t,e,n,s){return this.a.fromBufferAttribute(t,e),this.b.fromBufferAttribute(t,n),this.c.fromBufferAttribute(t,s),this}clone(){return new this.constructor().copy(this)}copy(t){return this.a.copy(t.a),this.b.copy(t.b),this.c.copy(t.c),this}getArea(){return tn.subVectors(this.c,this.b),Sn.subVectors(this.a,this.b),tn.cross(Sn).length()*.5}getMidpoint(t){return t.addVectors(this.a,this.b).add(this.c).multiplyScalar(1/3)}getNormal(t){return i.getNormal(this.a,this.b,this.c,t)}getPlane(t){return t.setFromCoplanarPoints(this.a,this.b,this.c)}getBarycoord(t,e){return i.getBarycoord(t,this.a,this.b,this.c,e)}getInterpolation(t,e,n,s,r){return i.getInterpolation(t,this.a,this.b,this.c,e,n,s,r)}containsPoint(t){return i.containsPoint(t,this.a,this.b,this.c)}isFrontFacing(t){return i.isFrontFacing(this.a,this.b,this.c,t)}intersectsBox(t){return t.intersectsTriangle(this)}closestPointToPoint(t,e){let n=this.a,s=this.b,r=this.c,a,o;wi.subVectors(s,n),Ai.subVectors(r,n),qa.subVectors(t,n);let l=wi.dot(qa),c=Ai.dot(qa);if(l<=0&&c<=0)return e.copy(n);Ya.subVectors(t,s);let u=wi.dot(Ya),d=Ai.dot(Ya);if(u>=0&&d<=u)return e.copy(s);let f=l*d-u*c;if(f<=0&&l>=0&&u<=0)return a=l/(l-u),e.copy(n).addScaledVector(wi,a);Za.subVectors(t,r);let p=wi.dot(Za),_=Ai.dot(Za);if(_>=0&&p<=_)return e.copy(r);let v=p*c-l*_;if(v<=0&&c>=0&&_<=0)return o=c/(c-_),e.copy(n).addScaledVector(Ai,o);let m=u*_-p*d;if(m<=0&&d-u>=0&&p-_>=0)return Tl.subVectors(r,s),o=(d-u)/(d-u+(p-_)),e.copy(s).addScaledVector(Tl,o);let h=1/(m+v+f);return a=v*h,o=f*h,e.copy(n).addScaledVector(wi,a).addScaledVector(Ai,o)}equals(t){return t.a.equals(this.a)&&t.b.equals(this.b)&&t.c.equals(this.c)}},Sc={aliceblue:15792383,antiquewhite:16444375,aqua:65535,aquamarine:8388564,azure:15794175,beige:16119260,bisque:16770244,black:0,blanchedalmond:16772045,blue:255,blueviolet:9055202,brown:10824234,burlywood:14596231,cadetblue:6266528,chartreuse:8388352,chocolate:13789470,coral:16744272,cornflowerblue:6591981,cornsilk:16775388,crimson:14423100,cyan:65535,darkblue:139,darkcyan:35723,darkgoldenrod:12092939,darkgray:11119017,darkgreen:25600,darkgrey:11119017,darkkhaki:12433259,darkmagenta:9109643,darkolivegreen:5597999,darkorange:16747520,darkorchid:10040012,darkred:9109504,darksalmon:15308410,darkseagreen:9419919,darkslateblue:4734347,darkslategray:3100495,darkslategrey:3100495,darkturquoise:52945,darkviolet:9699539,deeppink:16716947,deepskyblue:49151,dimgray:6908265,dimgrey:6908265,dodgerblue:2003199,firebrick:11674146,floralwhite:16775920,forestgreen:2263842,fuchsia:16711935,gainsboro:14474460,ghostwhite:16316671,gold:16766720,goldenrod:14329120,gray:8421504,green:32768,greenyellow:11403055,grey:8421504,honeydew:15794160,hotpink:16738740,indianred:13458524,indigo:4915330,ivory:16777200,khaki:15787660,lavender:15132410,lavenderblush:16773365,lawngreen:8190976,lemonchiffon:16775885,lightblue:11393254,lightcoral:15761536,lightcyan:14745599,lightgoldenrodyellow:16448210,lightgray:13882323,lightgreen:9498256,lightgrey:13882323,lightpink:16758465,lightsalmon:16752762,lightseagreen:2142890,lightskyblue:8900346,lightslategray:7833753,lightslategrey:7833753,lightsteelblue:11584734,lightyellow:16777184,lime:65280,limegreen:3329330,linen:16445670,magenta:16711935,maroon:8388608,mediumaquamarine:6737322,mediumblue:205,mediumorchid:12211667,mediumpurple:9662683,mediumseagreen:3978097,mediumslateblue:8087790,mediumspringgreen:64154,mediumturquoise:4772300,mediumvioletred:13047173,midnightblue:1644912,mintcream:16121850,mistyrose:16770273,moccasin:16770229,navajowhite:16768685,navy:128,oldlace:16643558,olive:8421376,olivedrab:7048739,orange:16753920,orangered:16729344,orchid:14315734,palegoldenrod:15657130,palegreen:10025880,paleturquoise:11529966,palevioletred:14381203,papayawhip:16773077,peachpuff:16767673,peru:13468991,pink:16761035,plum:14524637,powderblue:11591910,purple:8388736,rebeccapurple:6697881,red:16711680,rosybrown:12357519,royalblue:4286945,saddlebrown:9127187,salmon:16416882,sandybrown:16032864,seagreen:3050327,seashell:16774638,sienna:10506797,silver:12632256,skyblue:8900331,slateblue:6970061,slategray:7372944,slategrey:7372944,snow:16775930,springgreen:65407,steelblue:4620980,tan:13808780,teal:32896,thistle:14204888,tomato:16737095,turquoise:4251856,violet:15631086,wheat:16113331,white:16777215,whitesmoke:16119285,yellow:16776960,yellowgreen:10145074},Ln={h:0,s:0,l:0},Js={h:0,s:0,l:0};function ja(i,t,e){return e<0&&(e+=1),e>1&&(e-=1),e<1/6?i+(t-i)*6*e:e<1/2?t:e<2/3?i+(t-i)*6*(2/3-e):i}var Ht=class{constructor(t,e,n){return this.isColor=!0,this.r=1,this.g=1,this.b=1,this.set(t,e,n)}set(t,e,n){if(e===void 0&&n===void 0){let s=t;s&&s.isColor?this.copy(s):typeof s=="number"?this.setHex(s):typeof s=="string"&&this.setStyle(s)}else this.setRGB(t,e,n);return this}setScalar(t){return this.r=t,this.g=t,this.b=t,this}setHex(t,e=Te){return t=Math.floor(t),this.r=(t>>16&255)/255,this.g=(t>>8&255)/255,this.b=(t&255)/255,Wt.colorSpaceToWorking(this,e),this}setRGB(t,e,n,s=Wt.workingColorSpace){return this.r=t,this.g=e,this.b=n,Wt.colorSpaceToWorking(this,s),this}setHSL(t,e,n,s=Wt.workingColorSpace){if(t=Po(t,1),e=zt(e,0,1),n=zt(n,0,1),e===0)this.r=this.g=this.b=n;else{let r=n<=.5?n*(1+e):n+e-n*e,a=2*n-r;this.r=ja(a,r,t+1/3),this.g=ja(a,r,t),this.b=ja(a,r,t-1/3)}return Wt.colorSpaceToWorking(this,s),this}setStyle(t,e=Te){function n(r){r!==void 0&&parseFloat(r)<1&&console.warn("THREE.Color: Alpha component of "+t+" will be ignored.")}let s;if(s=/^(\w+)\(([^\)]*)\)/.exec(t)){let r,a=s[1],o=s[2];switch(a){case"rgb":case"rgba":if(r=/^\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*(?:,\s*(\d*\.?\d+)\s*)?$/.exec(o))return n(r[4]),this.setRGB(Math.min(255,parseInt(r[1],10))/255,Math.min(255,parseInt(r[2],10))/255,Math.min(255,parseInt(r[3],10))/255,e);if(r=/^\s*(\d+)\%\s*,\s*(\d+)\%\s*,\s*(\d+)\%\s*(?:,\s*(\d*\.?\d+)\s*)?$/.exec(o))return n(r[4]),this.setRGB(Math.min(100,parseInt(r[1],10))/100,Math.min(100,parseInt(r[2],10))/100,Math.min(100,parseInt(r[3],10))/100,e);break;case"hsl":case"hsla":if(r=/^\s*(\d*\.?\d+)\s*,\s*(\d*\.?\d+)\%\s*,\s*(\d*\.?\d+)\%\s*(?:,\s*(\d*\.?\d+)\s*)?$/.exec(o))return n(r[4]),this.setHSL(parseFloat(r[1])/360,parseFloat(r[2])/100,parseFloat(r[3])/100,e);break;default:console.warn("THREE.Color: Unknown color model "+t)}}else if(s=/^\#([A-Fa-f\d]+)$/.exec(t)){let r=s[1],a=r.length;if(a===3)return this.setRGB(parseInt(r.charAt(0),16)/15,parseInt(r.charAt(1),16)/15,parseInt(r.charAt(2),16)/15,e);if(a===6)return this.setHex(parseInt(r,16),e);console.warn("THREE.Color: Invalid hex color "+t)}else if(t&&t.length>0)return this.setColorName(t,e);return this}setColorName(t,e=Te){let n=Sc[t.toLowerCase()];return n!==void 0?this.setHex(n,e):console.warn("THREE.Color: Unknown color "+t),this}clone(){return new this.constructor(this.r,this.g,this.b)}copy(t){return this.r=t.r,this.g=t.g,this.b=t.b,this}copySRGBToLinear(t){return this.r=En(t.r),this.g=En(t.g),this.b=En(t.b),this}copyLinearToSRGB(t){return this.r=Di(t.r),this.g=Di(t.g),this.b=Di(t.b),this}convertSRGBToLinear(){return this.copySRGBToLinear(this),this}convertLinearToSRGB(){return this.copyLinearToSRGB(this),this}getHex(t=Te){return Wt.workingToColorSpace(Ee.copy(this),t),Math.round(zt(Ee.r*255,0,255))*65536+Math.round(zt(Ee.g*255,0,255))*256+Math.round(zt(Ee.b*255,0,255))}getHexString(t=Te){return("000000"+this.getHex(t).toString(16)).slice(-6)}getHSL(t,e=Wt.workingColorSpace){Wt.workingToColorSpace(Ee.copy(this),e);let n=Ee.r,s=Ee.g,r=Ee.b,a=Math.max(n,s,r),o=Math.min(n,s,r),l,c,u=(o+a)/2;if(o===a)l=0,c=0;else{let d=a-o;switch(c=u<=.5?d/(a+o):d/(2-a-o),a){case n:l=(s-r)/d+(s<r?6:0);break;case s:l=(r-n)/d+2;break;case r:l=(n-s)/d+4;break}l/=6}return t.h=l,t.s=c,t.l=u,t}getRGB(t,e=Wt.workingColorSpace){return Wt.workingToColorSpace(Ee.copy(this),e),t.r=Ee.r,t.g=Ee.g,t.b=Ee.b,t}getStyle(t=Te){Wt.workingToColorSpace(Ee.copy(this),t);let e=Ee.r,n=Ee.g,s=Ee.b;return t!==Te?`color(${t} ${e.toFixed(3)} ${n.toFixed(3)} ${s.toFixed(3)})`:`rgb(${Math.round(e*255)},${Math.round(n*255)},${Math.round(s*255)})`}offsetHSL(t,e,n){return this.getHSL(Ln),this.setHSL(Ln.h+t,Ln.s+e,Ln.l+n)}add(t){return this.r+=t.r,this.g+=t.g,this.b+=t.b,this}addColors(t,e){return this.r=t.r+e.r,this.g=t.g+e.g,this.b=t.b+e.b,this}addScalar(t){return this.r+=t,this.g+=t,this.b+=t,this}sub(t){return this.r=Math.max(0,this.r-t.r),this.g=Math.max(0,this.g-t.g),this.b=Math.max(0,this.b-t.b),this}multiply(t){return this.r*=t.r,this.g*=t.g,this.b*=t.b,this}multiplyScalar(t){return this.r*=t,this.g*=t,this.b*=t,this}lerp(t,e){return this.r+=(t.r-this.r)*e,this.g+=(t.g-this.g)*e,this.b+=(t.b-this.b)*e,this}lerpColors(t,e,n){return this.r=t.r+(e.r-t.r)*n,this.g=t.g+(e.g-t.g)*n,this.b=t.b+(e.b-t.b)*n,this}lerpHSL(t,e){this.getHSL(Ln),t.getHSL(Js);let n=os(Ln.h,Js.h,e),s=os(Ln.s,Js.s,e),r=os(Ln.l,Js.l,e);return this.setHSL(n,s,r),this}setFromVector3(t){return this.r=t.x,this.g=t.y,this.b=t.z,this}applyMatrix3(t){let e=this.r,n=this.g,s=this.b,r=t.elements;return this.r=r[0]*e+r[3]*n+r[6]*s,this.g=r[1]*e+r[4]*n+r[7]*s,this.b=r[2]*e+r[5]*n+r[8]*s,this}equals(t){return t.r===this.r&&t.g===this.g&&t.b===this.b}fromArray(t,e=0){return this.r=t[e],this.g=t[e+1],this.b=t[e+2],this}toArray(t=[],e=0){return t[e]=this.r,t[e+1]=this.g,t[e+2]=this.b,t}fromBufferAttribute(t,e){return this.r=t.getX(e),this.g=t.getY(e),this.b=t.getZ(e),this}toJSON(){return this.getHex()}*[Symbol.iterator](){yield this.r,yield this.g,yield this.b}},Ee=new Ht;Ht.NAMES=Sc;var Jh=0,zn=class extends un{constructor(){super(),this.isMaterial=!0,Object.defineProperty(this,"id",{value:Jh++}),this.uuid=qi(),this.name="",this.type="Material",this.blending=ei,this.side=Tn,this.vertexColors=!1,this.opacity=1,this.transparent=!1,this.alphaHash=!1,this.blendSrc=or,this.blendDst=lr,this.blendEquation=On,this.blendSrcAlpha=null,this.blendDstAlpha=null,this.blendEquationAlpha=null,this.blendColor=new Ht(0,0,0),this.blendAlpha=0,this.depthFunc=ni,this.depthTest=!0,this.depthWrite=!0,this.stencilWriteMask=255,this.stencilFunc=ao,this.stencilRef=0,this.stencilFuncMask=255,this.stencilFail=ti,this.stencilZFail=ti,this.stencilZPass=ti,this.stencilWrite=!1,this.clippingPlanes=null,this.clipIntersection=!1,this.clipShadows=!1,this.shadowSide=null,this.colorWrite=!0,this.precision=null,this.polygonOffset=!1,this.polygonOffsetFactor=0,this.polygonOffsetUnits=0,this.dithering=!1,this.alphaToCoverage=!1,this.premultipliedAlpha=!1,this.forceSinglePass=!1,this.allowOverride=!0,this.visible=!0,this.toneMapped=!0,this.userData={},this.version=0,this._alphaTest=0}get alphaTest(){return this._alphaTest}set alphaTest(t){this._alphaTest>0!=t>0&&this.version++,this._alphaTest=t}onBeforeRender(){}onBeforeCompile(){}customProgramCacheKey(){return this.onBeforeCompile.toString()}setValues(t){if(t!==void 0)for(let e in t){let n=t[e];if(n===void 0){console.warn(`THREE.Material: parameter '${e}' has value of undefined.`);continue}let s=this[e];if(s===void 0){console.warn(`THREE.Material: '${e}' is not a property of THREE.${this.type}.`);continue}s&&s.isColor?s.set(n):s&&s.isVector3&&n&&n.isVector3?s.copy(n):this[e]=n}}toJSON(t){let e=t===void 0||typeof t=="string";e&&(t={textures:{},images:{}});let n={metadata:{version:4.7,type:"Material",generator:"Material.toJSON"}};n.uuid=this.uuid,n.type=this.type,this.name!==""&&(n.name=this.name),this.color&&this.color.isColor&&(n.color=this.color.getHex()),this.roughness!==void 0&&(n.roughness=this.roughness),this.metalness!==void 0&&(n.metalness=this.metalness),this.sheen!==void 0&&(n.sheen=this.sheen),this.sheenColor&&this.sheenColor.isColor&&(n.sheenColor=this.sheenColor.getHex()),this.sheenRoughness!==void 0&&(n.sheenRoughness=this.sheenRoughness),this.emissive&&this.emissive.isColor&&(n.emissive=this.emissive.getHex()),this.emissiveIntensity!==void 0&&this.emissiveIntensity!==1&&(n.emissiveIntensity=this.emissiveIntensity),this.specular&&this.specular.isColor&&(n.specular=this.specular.getHex()),this.specularIntensity!==void 0&&(n.specularIntensity=this.specularIntensity),this.specularColor&&this.specularColor.isColor&&(n.specularColor=this.specularColor.getHex()),this.shininess!==void 0&&(n.shininess=this.shininess),this.clearcoat!==void 0&&(n.clearcoat=this.clearcoat),this.clearcoatRoughness!==void 0&&(n.clearcoatRoughness=this.clearcoatRoughness),this.clearcoatMap&&this.clearcoatMap.isTexture&&(n.clearcoatMap=this.clearcoatMap.toJSON(t).uuid),this.clearcoatRoughnessMap&&this.clearcoatRoughnessMap.isTexture&&(n.clearcoatRoughnessMap=this.clearcoatRoughnessMap.toJSON(t).uuid),this.clearcoatNormalMap&&this.clearcoatNormalMap.isTexture&&(n.clearcoatNormalMap=this.clearcoatNormalMap.toJSON(t).uuid,n.clearcoatNormalScale=this.clearcoatNormalScale.toArray()),this.sheenColorMap&&this.sheenColorMap.isTexture&&(n.sheenColorMap=this.sheenColorMap.toJSON(t).uuid),this.sheenRoughnessMap&&this.sheenRoughnessMap.isTexture&&(n.sheenRoughnessMap=this.sheenRoughnessMap.toJSON(t).uuid),this.dispersion!==void 0&&(n.dispersion=this.dispersion),this.iridescence!==void 0&&(n.iridescence=this.iridescence),this.iridescenceIOR!==void 0&&(n.iridescenceIOR=this.iridescenceIOR),this.iridescenceThicknessRange!==void 0&&(n.iridescenceThicknessRange=this.iridescenceThicknessRange),this.iridescenceMap&&this.iridescenceMap.isTexture&&(n.iridescenceMap=this.iridescenceMap.toJSON(t).uuid),this.iridescenceThicknessMap&&this.iridescenceThicknessMap.isTexture&&(n.iridescenceThicknessMap=this.iridescenceThicknessMap.toJSON(t).uuid),this.anisotropy!==void 0&&(n.anisotropy=this.anisotropy),this.anisotropyRotation!==void 0&&(n.anisotropyRotation=this.anisotropyRotation),this.anisotropyMap&&this.anisotropyMap.isTexture&&(n.anisotropyMap=this.anisotropyMap.toJSON(t).uuid),this.map&&this.map.isTexture&&(n.map=this.map.toJSON(t).uuid),this.matcap&&this.matcap.isTexture&&(n.matcap=this.matcap.toJSON(t).uuid),this.alphaMap&&this.alphaMap.isTexture&&(n.alphaMap=this.alphaMap.toJSON(t).uuid),this.lightMap&&this.lightMap.isTexture&&(n.lightMap=this.lightMap.toJSON(t).uuid,n.lightMapIntensity=this.lightMapIntensity),this.aoMap&&this.aoMap.isTexture&&(n.aoMap=this.aoMap.toJSON(t).uuid,n.aoMapIntensity=this.aoMapIntensity),this.bumpMap&&this.bumpMap.isTexture&&(n.bumpMap=this.bumpMap.toJSON(t).uuid,n.bumpScale=this.bumpScale),this.normalMap&&this.normalMap.isTexture&&(n.normalMap=this.normalMap.toJSON(t).uuid,n.normalMapType=this.normalMapType,n.normalScale=this.normalScale.toArray()),this.displacementMap&&this.displacementMap.isTexture&&(n.displacementMap=this.displacementMap.toJSON(t).uuid,n.displacementScale=this.displacementScale,n.displacementBias=this.displacementBias),this.roughnessMap&&this.roughnessMap.isTexture&&(n.roughnessMap=this.roughnessMap.toJSON(t).uuid),this.metalnessMap&&this.metalnessMap.isTexture&&(n.metalnessMap=this.metalnessMap.toJSON(t).uuid),this.emissiveMap&&this.emissiveMap.isTexture&&(n.emissiveMap=this.emissiveMap.toJSON(t).uuid),this.specularMap&&this.specularMap.isTexture&&(n.specularMap=this.specularMap.toJSON(t).uuid),this.specularIntensityMap&&this.specularIntensityMap.isTexture&&(n.specularIntensityMap=this.specularIntensityMap.toJSON(t).uuid),this.specularColorMap&&this.specularColorMap.isTexture&&(n.specularColorMap=this.specularColorMap.toJSON(t).uuid),this.envMap&&this.envMap.isTexture&&(n.envMap=this.envMap.toJSON(t).uuid,this.combine!==void 0&&(n.combine=this.combine)),this.envMapRotation!==void 0&&(n.envMapRotation=this.envMapRotation.toArray()),this.envMapIntensity!==void 0&&(n.envMapIntensity=this.envMapIntensity),this.reflectivity!==void 0&&(n.reflectivity=this.reflectivity),this.refractionRatio!==void 0&&(n.refractionRatio=this.refractionRatio),this.gradientMap&&this.gradientMap.isTexture&&(n.gradientMap=this.gradientMap.toJSON(t).uuid),this.transmission!==void 0&&(n.transmission=this.transmission),this.transmissionMap&&this.transmissionMap.isTexture&&(n.transmissionMap=this.transmissionMap.toJSON(t).uuid),this.thickness!==void 0&&(n.thickness=this.thickness),this.thicknessMap&&this.thicknessMap.isTexture&&(n.thicknessMap=this.thicknessMap.toJSON(t).uuid),this.attenuationDistance!==void 0&&this.attenuationDistance!==1/0&&(n.attenuationDistance=this.attenuationDistance),this.attenuationColor!==void 0&&(n.attenuationColor=this.attenuationColor.getHex()),this.size!==void 0&&(n.size=this.size),this.shadowSide!==null&&(n.shadowSide=this.shadowSide),this.sizeAttenuation!==void 0&&(n.sizeAttenuation=this.sizeAttenuation),this.blending!==ei&&(n.blending=this.blending),this.side!==Tn&&(n.side=this.side),this.vertexColors===!0&&(n.vertexColors=!0),this.opacity<1&&(n.opacity=this.opacity),this.transparent===!0&&(n.transparent=!0),this.blendSrc!==or&&(n.blendSrc=this.blendSrc),this.blendDst!==lr&&(n.blendDst=this.blendDst),this.blendEquation!==On&&(n.blendEquation=this.blendEquation),this.blendSrcAlpha!==null&&(n.blendSrcAlpha=this.blendSrcAlpha),this.blendDstAlpha!==null&&(n.blendDstAlpha=this.blendDstAlpha),this.blendEquationAlpha!==null&&(n.blendEquationAlpha=this.blendEquationAlpha),this.blendColor&&this.blendColor.isColor&&(n.blendColor=this.blendColor.getHex()),this.blendAlpha!==0&&(n.blendAlpha=this.blendAlpha),this.depthFunc!==ni&&(n.depthFunc=this.depthFunc),this.depthTest===!1&&(n.depthTest=this.depthTest),this.depthWrite===!1&&(n.depthWrite=this.depthWrite),this.colorWrite===!1&&(n.colorWrite=this.colorWrite),this.stencilWriteMask!==255&&(n.stencilWriteMask=this.stencilWriteMask),this.stencilFunc!==ao&&(n.stencilFunc=this.stencilFunc),this.stencilRef!==0&&(n.stencilRef=this.stencilRef),this.stencilFuncMask!==255&&(n.stencilFuncMask=this.stencilFuncMask),this.stencilFail!==ti&&(n.stencilFail=this.stencilFail),this.stencilZFail!==ti&&(n.stencilZFail=this.stencilZFail),this.stencilZPass!==ti&&(n.stencilZPass=this.stencilZPass),this.stencilWrite===!0&&(n.stencilWrite=this.stencilWrite),this.rotation!==void 0&&this.rotation!==0&&(n.rotation=this.rotation),this.polygonOffset===!0&&(n.polygonOffset=!0),this.polygonOffsetFactor!==0&&(n.polygonOffsetFactor=this.polygonOffsetFactor),this.polygonOffsetUnits!==0&&(n.polygonOffsetUnits=this.polygonOffsetUnits),this.linewidth!==void 0&&this.linewidth!==1&&(n.linewidth=this.linewidth),this.dashSize!==void 0&&(n.dashSize=this.dashSize),this.gapSize!==void 0&&(n.gapSize=this.gapSize),this.scale!==void 0&&(n.scale=this.scale),this.dithering===!0&&(n.dithering=!0),this.alphaTest>0&&(n.alphaTest=this.alphaTest),this.alphaHash===!0&&(n.alphaHash=!0),this.alphaToCoverage===!0&&(n.alphaToCoverage=!0),this.premultipliedAlpha===!0&&(n.premultipliedAlpha=!0),this.forceSinglePass===!0&&(n.forceSinglePass=!0),this.wireframe===!0&&(n.wireframe=!0),this.wireframeLinewidth>1&&(n.wireframeLinewidth=this.wireframeLinewidth),this.wireframeLinecap!=="round"&&(n.wireframeLinecap=this.wireframeLinecap),this.wireframeLinejoin!=="round"&&(n.wireframeLinejoin=this.wireframeLinejoin),this.flatShading===!0&&(n.flatShading=!0),this.visible===!1&&(n.visible=!1),this.toneMapped===!1&&(n.toneMapped=!1),this.fog===!1&&(n.fog=!1),Object.keys(this.userData).length>0&&(n.userData=this.userData);function s(r){let a=[];for(let o in r){let l=r[o];delete l.metadata,a.push(l)}return a}if(e){let r=s(t.textures),a=s(t.images);r.length>0&&(n.textures=r),a.length>0&&(n.images=a)}return n}clone(){return new this.constructor().copy(this)}copy(t){this.name=t.name,this.blending=t.blending,this.side=t.side,this.vertexColors=t.vertexColors,this.opacity=t.opacity,this.transparent=t.transparent,this.blendSrc=t.blendSrc,this.blendDst=t.blendDst,this.blendEquation=t.blendEquation,this.blendSrcAlpha=t.blendSrcAlpha,this.blendDstAlpha=t.blendDstAlpha,this.blendEquationAlpha=t.blendEquationAlpha,this.blendColor.copy(t.blendColor),this.blendAlpha=t.blendAlpha,this.depthFunc=t.depthFunc,this.depthTest=t.depthTest,this.depthWrite=t.depthWrite,this.stencilWriteMask=t.stencilWriteMask,this.stencilFunc=t.stencilFunc,this.stencilRef=t.stencilRef,this.stencilFuncMask=t.stencilFuncMask,this.stencilFail=t.stencilFail,this.stencilZFail=t.stencilZFail,this.stencilZPass=t.stencilZPass,this.stencilWrite=t.stencilWrite;let e=t.clippingPlanes,n=null;if(e!==null){let s=e.length;n=new Array(s);for(let r=0;r!==s;++r)n[r]=e[r].clone()}return this.clippingPlanes=n,this.clipIntersection=t.clipIntersection,this.clipShadows=t.clipShadows,this.shadowSide=t.shadowSide,this.colorWrite=t.colorWrite,this.precision=t.precision,this.polygonOffset=t.polygonOffset,this.polygonOffsetFactor=t.polygonOffsetFactor,this.polygonOffsetUnits=t.polygonOffsetUnits,this.dithering=t.dithering,this.alphaTest=t.alphaTest,this.alphaHash=t.alphaHash,this.alphaToCoverage=t.alphaToCoverage,this.premultipliedAlpha=t.premultipliedAlpha,this.forceSinglePass=t.forceSinglePass,this.visible=t.visible,this.toneMapped=t.toneMapped,this.userData=JSON.parse(JSON.stringify(t.userData)),this}dispose(){this.dispatchEvent({type:"dispose"})}set needsUpdate(t){t===!0&&this.version++}},ri=class extends zn{constructor(t){super(),this.isMeshBasicMaterial=!0,this.type="MeshBasicMaterial",this.color=new Ht(16777215),this.map=null,this.lightMap=null,this.lightMapIntensity=1,this.aoMap=null,this.aoMapIntensity=1,this.specularMap=null,this.alphaMap=null,this.envMap=null,this.envMapRotation=new sn,this.combine=xo,this.reflectivity=1,this.refractionRatio=.98,this.wireframe=!1,this.wireframeLinewidth=1,this.wireframeLinecap="round",this.wireframeLinejoin="round",this.fog=!0,this.setValues(t)}copy(t){return super.copy(t),this.color.copy(t.color),this.map=t.map,this.lightMap=t.lightMap,this.lightMapIntensity=t.lightMapIntensity,this.aoMap=t.aoMap,this.aoMapIntensity=t.aoMapIntensity,this.specularMap=t.specularMap,this.alphaMap=t.alphaMap,this.envMap=t.envMap,this.envMapRotation.copy(t.envMapRotation),this.combine=t.combine,this.reflectivity=t.reflectivity,this.refractionRatio=t.refractionRatio,this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this.wireframeLinecap=t.wireframeLinecap,this.wireframeLinejoin=t.wireframeLinejoin,this.fog=t.fog,this}};var de=new N,$s=new Rt,$h=0,Ve=class{constructor(t,e,n=!1){if(Array.isArray(t))throw new TypeError("THREE.BufferAttribute: array should be a Typed Array.");this.isBufferAttribute=!0,Object.defineProperty(this,"id",{value:$h++}),this.name="",this.array=t,this.itemSize=e,this.count=t!==void 0?t.length/e:0,this.normalized=n,this.usage=oo,this.updateRanges=[],this.gpuType=gn,this.version=0}onUploadCallback(){}set needsUpdate(t){t===!0&&this.version++}setUsage(t){return this.usage=t,this}addUpdateRange(t,e){this.updateRanges.push({start:t,count:e})}clearUpdateRanges(){this.updateRanges.length=0}copy(t){return this.name=t.name,this.array=new t.array.constructor(t.array),this.itemSize=t.itemSize,this.count=t.count,this.normalized=t.normalized,this.usage=t.usage,this.gpuType=t.gpuType,this}copyAt(t,e,n){t*=this.itemSize,n*=e.itemSize;for(let s=0,r=this.itemSize;s<r;s++)this.array[t+s]=e.array[n+s];return this}copyArray(t){return this.array.set(t),this}applyMatrix3(t){if(this.itemSize===2)for(let e=0,n=this.count;e<n;e++)$s.fromBufferAttribute(this,e),$s.applyMatrix3(t),this.setXY(e,$s.x,$s.y);else if(this.itemSize===3)for(let e=0,n=this.count;e<n;e++)de.fromBufferAttribute(this,e),de.applyMatrix3(t),this.setXYZ(e,de.x,de.y,de.z);return this}applyMatrix4(t){for(let e=0,n=this.count;e<n;e++)de.fromBufferAttribute(this,e),de.applyMatrix4(t),this.setXYZ(e,de.x,de.y,de.z);return this}applyNormalMatrix(t){for(let e=0,n=this.count;e<n;e++)de.fromBufferAttribute(this,e),de.applyNormalMatrix(t),this.setXYZ(e,de.x,de.y,de.z);return this}transformDirection(t){for(let e=0,n=this.count;e<n;e++)de.fromBufferAttribute(this,e),de.transformDirection(t),this.setXYZ(e,de.x,de.y,de.z);return this}set(t,e=0){return this.array.set(t,e),this}getComponent(t,e){let n=this.array[t*this.itemSize+e];return this.normalized&&(n=Pi(n,this.array)),n}setComponent(t,e,n){return this.normalized&&(n=Ie(n,this.array)),this.array[t*this.itemSize+e]=n,this}getX(t){let e=this.array[t*this.itemSize];return this.normalized&&(e=Pi(e,this.array)),e}setX(t,e){return this.normalized&&(e=Ie(e,this.array)),this.array[t*this.itemSize]=e,this}getY(t){let e=this.array[t*this.itemSize+1];return this.normalized&&(e=Pi(e,this.array)),e}setY(t,e){return this.normalized&&(e=Ie(e,this.array)),this.array[t*this.itemSize+1]=e,this}getZ(t){let e=this.array[t*this.itemSize+2];return this.normalized&&(e=Pi(e,this.array)),e}setZ(t,e){return this.normalized&&(e=Ie(e,this.array)),this.array[t*this.itemSize+2]=e,this}getW(t){let e=this.array[t*this.itemSize+3];return this.normalized&&(e=Pi(e,this.array)),e}setW(t,e){return this.normalized&&(e=Ie(e,this.array)),this.array[t*this.itemSize+3]=e,this}setXY(t,e,n){return t*=this.itemSize,this.normalized&&(e=Ie(e,this.array),n=Ie(n,this.array)),this.array[t+0]=e,this.array[t+1]=n,this}setXYZ(t,e,n,s){return t*=this.itemSize,this.normalized&&(e=Ie(e,this.array),n=Ie(n,this.array),s=Ie(s,this.array)),this.array[t+0]=e,this.array[t+1]=n,this.array[t+2]=s,this}setXYZW(t,e,n,s,r){return t*=this.itemSize,this.normalized&&(e=Ie(e,this.array),n=Ie(n,this.array),s=Ie(s,this.array),r=Ie(r,this.array)),this.array[t+0]=e,this.array[t+1]=n,this.array[t+2]=s,this.array[t+3]=r,this}onUpload(t){return this.onUploadCallback=t,this}clone(){return new this.constructor(this.array,this.itemSize).copy(this)}toJSON(){let t={itemSize:this.itemSize,type:this.array.constructor.name,array:Array.from(this.array),normalized:this.normalized};return this.name!==""&&(t.name=this.name),this.usage!==oo&&(t.usage=this.usage),t}};var fs=class extends Ve{constructor(t,e,n){super(new Uint16Array(t),e,n)}};var ps=class extends Ve{constructor(t,e,n){super(new Uint32Array(t),e,n)}};var we=class extends Ve{constructor(t,e,n){super(new Float32Array(t),e,n)}},Kh=0,qe=new ce,Qa=new Ae,Ci=new N,ke=new Bn,rs=new Bn,ve=new N,fn=class i extends un{constructor(){super(),this.isBufferGeometry=!0,Object.defineProperty(this,"id",{value:Kh++}),this.uuid=qi(),this.name="",this.type="BufferGeometry",this.index=null,this.indirect=null,this.attributes={},this.morphAttributes={},this.morphTargetsRelative=!1,this.groups=[],this.boundingBox=null,this.boundingSphere=null,this.drawRange={start:0,count:1/0},this.userData={}}getIndex(){return this.index}setIndex(t){return Array.isArray(t)?this.index=new(Lo(t)?ps:fs)(t,1):this.index=t,this}setIndirect(t){return this.indirect=t,this}getIndirect(){return this.indirect}getAttribute(t){return this.attributes[t]}setAttribute(t,e){return this.attributes[t]=e,this}deleteAttribute(t){return delete this.attributes[t],this}hasAttribute(t){return this.attributes[t]!==void 0}addGroup(t,e,n=0){this.groups.push({start:t,count:e,materialIndex:n})}clearGroups(){this.groups=[]}setDrawRange(t,e){this.drawRange.start=t,this.drawRange.count=e}applyMatrix4(t){let e=this.attributes.position;e!==void 0&&(e.applyMatrix4(t),e.needsUpdate=!0);let n=this.attributes.normal;if(n!==void 0){let r=new Ut().getNormalMatrix(t);n.applyNormalMatrix(r),n.needsUpdate=!0}let s=this.attributes.tangent;return s!==void 0&&(s.transformDirection(t),s.needsUpdate=!0),this.boundingBox!==null&&this.computeBoundingBox(),this.boundingSphere!==null&&this.computeBoundingSphere(),this}applyQuaternion(t){return qe.makeRotationFromQuaternion(t),this.applyMatrix4(qe),this}rotateX(t){return qe.makeRotationX(t),this.applyMatrix4(qe),this}rotateY(t){return qe.makeRotationY(t),this.applyMatrix4(qe),this}rotateZ(t){return qe.makeRotationZ(t),this.applyMatrix4(qe),this}translate(t,e,n){return qe.makeTranslation(t,e,n),this.applyMatrix4(qe),this}scale(t,e,n){return qe.makeScale(t,e,n),this.applyMatrix4(qe),this}lookAt(t){return Qa.lookAt(t),Qa.updateMatrix(),this.applyMatrix4(Qa.matrix),this}center(){return this.computeBoundingBox(),this.boundingBox.getCenter(Ci).negate(),this.translate(Ci.x,Ci.y,Ci.z),this}setFromPoints(t){let e=this.getAttribute("position");if(e===void 0){let n=[];for(let s=0,r=t.length;s<r;s++){let a=t[s];n.push(a.x,a.y,a.z||0)}this.setAttribute("position",new we(n,3))}else{let n=Math.min(t.length,e.count);for(let s=0;s<n;s++){let r=t[s];e.setXYZ(s,r.x,r.y,r.z||0)}t.length>e.count&&console.warn("THREE.BufferGeometry: Buffer size too small for points data. Use .dispose() and create a new geometry."),e.needsUpdate=!0}return this}computeBoundingBox(){this.boundingBox===null&&(this.boundingBox=new Bn);let t=this.attributes.position,e=this.morphAttributes.position;if(t&&t.isGLBufferAttribute){console.error("THREE.BufferGeometry.computeBoundingBox(): GLBufferAttribute requires a manual bounding box.",this),this.boundingBox.set(new N(-1/0,-1/0,-1/0),new N(1/0,1/0,1/0));return}if(t!==void 0){if(this.boundingBox.setFromBufferAttribute(t),e)for(let n=0,s=e.length;n<s;n++){let r=e[n];ke.setFromBufferAttribute(r),this.morphTargetsRelative?(ve.addVectors(this.boundingBox.min,ke.min),this.boundingBox.expandByPoint(ve),ve.addVectors(this.boundingBox.max,ke.max),this.boundingBox.expandByPoint(ve)):(this.boundingBox.expandByPoint(ke.min),this.boundingBox.expandByPoint(ke.max))}}else this.boundingBox.makeEmpty();(isNaN(this.boundingBox.min.x)||isNaN(this.boundingBox.min.y)||isNaN(this.boundingBox.min.z))&&console.error('THREE.BufferGeometry.computeBoundingBox(): Computed min/max have NaN values. The "position" attribute is likely to have NaN values.',this)}computeBoundingSphere(){this.boundingSphere===null&&(this.boundingSphere=new Oi);let t=this.attributes.position,e=this.morphAttributes.position;if(t&&t.isGLBufferAttribute){console.error("THREE.BufferGeometry.computeBoundingSphere(): GLBufferAttribute requires a manual bounding sphere.",this),this.boundingSphere.set(new N,1/0);return}if(t){let n=this.boundingSphere.center;if(ke.setFromBufferAttribute(t),e)for(let r=0,a=e.length;r<a;r++){let o=e[r];rs.setFromBufferAttribute(o),this.morphTargetsRelative?(ve.addVectors(ke.min,rs.min),ke.expandByPoint(ve),ve.addVectors(ke.max,rs.max),ke.expandByPoint(ve)):(ke.expandByPoint(rs.min),ke.expandByPoint(rs.max))}ke.getCenter(n);let s=0;for(let r=0,a=t.count;r<a;r++)ve.fromBufferAttribute(t,r),s=Math.max(s,n.distanceToSquared(ve));if(e)for(let r=0,a=e.length;r<a;r++){let o=e[r],l=this.morphTargetsRelative;for(let c=0,u=o.count;c<u;c++)ve.fromBufferAttribute(o,c),l&&(Ci.fromBufferAttribute(t,c),ve.add(Ci)),s=Math.max(s,n.distanceToSquared(ve))}this.boundingSphere.radius=Math.sqrt(s),isNaN(this.boundingSphere.radius)&&console.error('THREE.BufferGeometry.computeBoundingSphere(): Computed radius is NaN. The "position" attribute is likely to have NaN values.',this)}}computeTangents(){let t=this.index,e=this.attributes;if(t===null||e.position===void 0||e.normal===void 0||e.uv===void 0){console.error("THREE.BufferGeometry: .computeTangents() failed. Missing required attributes (index, position, normal or uv)");return}let n=e.position,s=e.normal,r=e.uv;this.hasAttribute("tangent")===!1&&this.setAttribute("tangent",new Ve(new Float32Array(4*n.count),4));let a=this.getAttribute("tangent"),o=[],l=[];for(let U=0;U<n.count;U++)o[U]=new N,l[U]=new N;let c=new N,u=new N,d=new N,f=new Rt,p=new Rt,_=new Rt,v=new N,m=new N;function h(U,M,y){c.fromBufferAttribute(n,U),u.fromBufferAttribute(n,M),d.fromBufferAttribute(n,y),f.fromBufferAttribute(r,U),p.fromBufferAttribute(r,M),_.fromBufferAttribute(r,y),u.sub(c),d.sub(c),p.sub(f),_.sub(f);let I=1/(p.x*_.y-_.x*p.y);isFinite(I)&&(v.copy(u).multiplyScalar(_.y).addScaledVector(d,-p.y).multiplyScalar(I),m.copy(d).multiplyScalar(p.x).addScaledVector(u,-_.x).multiplyScalar(I),o[U].add(v),o[M].add(v),o[y].add(v),l[U].add(m),l[M].add(m),l[y].add(m))}let w=this.groups;w.length===0&&(w=[{start:0,count:t.count}]);for(let U=0,M=w.length;U<M;++U){let y=w[U],I=y.start,O=y.count;for(let k=I,G=I+O;k<G;k+=3)h(t.getX(k+0),t.getX(k+1),t.getX(k+2))}let E=new N,S=new N,C=new N,A=new N;function P(U){C.fromBufferAttribute(s,U),A.copy(C);let M=o[U];E.copy(M),E.sub(C.multiplyScalar(C.dot(M))).normalize(),S.crossVectors(A,M);let I=S.dot(l[U])<0?-1:1;a.setXYZW(U,E.x,E.y,E.z,I)}for(let U=0,M=w.length;U<M;++U){let y=w[U],I=y.start,O=y.count;for(let k=I,G=I+O;k<G;k+=3)P(t.getX(k+0)),P(t.getX(k+1)),P(t.getX(k+2))}}computeVertexNormals(){let t=this.index,e=this.getAttribute("position");if(e!==void 0){let n=this.getAttribute("normal");if(n===void 0)n=new Ve(new Float32Array(e.count*3),3),this.setAttribute("normal",n);else for(let f=0,p=n.count;f<p;f++)n.setXYZ(f,0,0,0);let s=new N,r=new N,a=new N,o=new N,l=new N,c=new N,u=new N,d=new N;if(t)for(let f=0,p=t.count;f<p;f+=3){let _=t.getX(f+0),v=t.getX(f+1),m=t.getX(f+2);s.fromBufferAttribute(e,_),r.fromBufferAttribute(e,v),a.fromBufferAttribute(e,m),u.subVectors(a,r),d.subVectors(s,r),u.cross(d),o.fromBufferAttribute(n,_),l.fromBufferAttribute(n,v),c.fromBufferAttribute(n,m),o.add(u),l.add(u),c.add(u),n.setXYZ(_,o.x,o.y,o.z),n.setXYZ(v,l.x,l.y,l.z),n.setXYZ(m,c.x,c.y,c.z)}else for(let f=0,p=e.count;f<p;f+=3)s.fromBufferAttribute(e,f+0),r.fromBufferAttribute(e,f+1),a.fromBufferAttribute(e,f+2),u.subVectors(a,r),d.subVectors(s,r),u.cross(d),n.setXYZ(f+0,u.x,u.y,u.z),n.setXYZ(f+1,u.x,u.y,u.z),n.setXYZ(f+2,u.x,u.y,u.z);this.normalizeNormals(),n.needsUpdate=!0}}normalizeNormals(){let t=this.attributes.normal;for(let e=0,n=t.count;e<n;e++)ve.fromBufferAttribute(t,e),ve.normalize(),t.setXYZ(e,ve.x,ve.y,ve.z)}toNonIndexed(){function t(o,l){let c=o.array,u=o.itemSize,d=o.normalized,f=new c.constructor(l.length*u),p=0,_=0;for(let v=0,m=l.length;v<m;v++){o.isInterleavedBufferAttribute?p=l[v]*o.data.stride+o.offset:p=l[v]*u;for(let h=0;h<u;h++)f[_++]=c[p++]}return new Ve(f,u,d)}if(this.index===null)return console.warn("THREE.BufferGeometry.toNonIndexed(): BufferGeometry is already non-indexed."),this;let e=new i,n=this.index.array,s=this.attributes;for(let o in s){let l=s[o],c=t(l,n);e.setAttribute(o,c)}let r=this.morphAttributes;for(let o in r){let l=[],c=r[o];for(let u=0,d=c.length;u<d;u++){let f=c[u],p=t(f,n);l.push(p)}e.morphAttributes[o]=l}e.morphTargetsRelative=this.morphTargetsRelative;let a=this.groups;for(let o=0,l=a.length;o<l;o++){let c=a[o];e.addGroup(c.start,c.count,c.materialIndex)}return e}toJSON(){let t={metadata:{version:4.7,type:"BufferGeometry",generator:"BufferGeometry.toJSON"}};if(t.uuid=this.uuid,t.type=this.type,this.name!==""&&(t.name=this.name),Object.keys(this.userData).length>0&&(t.userData=this.userData),this.parameters!==void 0){let l=this.parameters;for(let c in l)l[c]!==void 0&&(t[c]=l[c]);return t}t.data={attributes:{}};let e=this.index;e!==null&&(t.data.index={type:e.array.constructor.name,array:Array.prototype.slice.call(e.array)});let n=this.attributes;for(let l in n){let c=n[l];t.data.attributes[l]=c.toJSON(t.data)}let s={},r=!1;for(let l in this.morphAttributes){let c=this.morphAttributes[l],u=[];for(let d=0,f=c.length;d<f;d++){let p=c[d];u.push(p.toJSON(t.data))}u.length>0&&(s[l]=u,r=!0)}r&&(t.data.morphAttributes=s,t.data.morphTargetsRelative=this.morphTargetsRelative);let a=this.groups;a.length>0&&(t.data.groups=JSON.parse(JSON.stringify(a)));let o=this.boundingSphere;return o!==null&&(t.data.boundingSphere=o.toJSON()),t}clone(){return new this.constructor().copy(this)}copy(t){this.index=null,this.attributes={},this.morphAttributes={},this.groups=[],this.boundingBox=null,this.boundingSphere=null;let e={};this.name=t.name;let n=t.index;n!==null&&this.setIndex(n.clone());let s=t.attributes;for(let c in s){let u=s[c];this.setAttribute(c,u.clone(e))}let r=t.morphAttributes;for(let c in r){let u=[],d=r[c];for(let f=0,p=d.length;f<p;f++)u.push(d[f].clone(e));this.morphAttributes[c]=u}this.morphTargetsRelative=t.morphTargetsRelative;let a=t.groups;for(let c=0,u=a.length;c<u;c++){let d=a[c];this.addGroup(d.start,d.count,d.materialIndex)}let o=t.boundingBox;o!==null&&(this.boundingBox=o.clone());let l=t.boundingSphere;return l!==null&&(this.boundingSphere=l.clone()),this.drawRange.start=t.drawRange.start,this.drawRange.count=t.drawRange.count,this.userData=t.userData,this}dispose(){this.dispatchEvent({type:"dispose"})}},wl=new ce,jn=new si,Ks=new Oi,Al=new N,js=new N,Qs=new N,tr=new N,to=new N,er=new N,Cl=new N,nr=new N,Me=class extends Ae{constructor(t=new fn,e=new ri){super(),this.isMesh=!0,this.type="Mesh",this.geometry=t,this.material=e,this.morphTargetDictionary=void 0,this.morphTargetInfluences=void 0,this.count=1,this.updateMorphTargets()}copy(t,e){return super.copy(t,e),t.morphTargetInfluences!==void 0&&(this.morphTargetInfluences=t.morphTargetInfluences.slice()),t.morphTargetDictionary!==void 0&&(this.morphTargetDictionary=Object.assign({},t.morphTargetDictionary)),this.material=Array.isArray(t.material)?t.material.slice():t.material,this.geometry=t.geometry,this}updateMorphTargets(){let e=this.geometry.morphAttributes,n=Object.keys(e);if(n.length>0){let s=e[n[0]];if(s!==void 0){this.morphTargetInfluences=[],this.morphTargetDictionary={};for(let r=0,a=s.length;r<a;r++){let o=s[r].name||String(r);this.morphTargetInfluences.push(0),this.morphTargetDictionary[o]=r}}}}getVertexPosition(t,e){let n=this.geometry,s=n.attributes.position,r=n.morphAttributes.position,a=n.morphTargetsRelative;e.fromBufferAttribute(s,t);let o=this.morphTargetInfluences;if(r&&o){er.set(0,0,0);for(let l=0,c=r.length;l<c;l++){let u=o[l],d=r[l];u!==0&&(to.fromBufferAttribute(d,t),a?er.addScaledVector(to,u):er.addScaledVector(to.sub(e),u))}e.add(er)}return e}raycast(t,e){let n=this.geometry,s=this.material,r=this.matrixWorld;s!==void 0&&(n.boundingSphere===null&&n.computeBoundingSphere(),Ks.copy(n.boundingSphere),Ks.applyMatrix4(r),jn.copy(t.ray).recast(t.near),!(Ks.containsPoint(jn.origin)===!1&&(jn.intersectSphere(Ks,Al)===null||jn.origin.distanceToSquared(Al)>(t.far-t.near)**2))&&(wl.copy(r).invert(),jn.copy(t.ray).applyMatrix4(wl),!(n.boundingBox!==null&&jn.intersectsBox(n.boundingBox)===!1)&&this._computeIntersections(t,e,jn)))}_computeIntersections(t,e,n){let s,r=this.geometry,a=this.material,o=r.index,l=r.attributes.position,c=r.attributes.uv,u=r.attributes.uv1,d=r.attributes.normal,f=r.groups,p=r.drawRange;if(o!==null)if(Array.isArray(a))for(let _=0,v=f.length;_<v;_++){let m=f[_],h=a[m.materialIndex],w=Math.max(m.start,p.start),E=Math.min(o.count,Math.min(m.start+m.count,p.start+p.count));for(let S=w,C=E;S<C;S+=3){let A=o.getX(S),P=o.getX(S+1),U=o.getX(S+2);s=ir(this,h,t,n,c,u,d,A,P,U),s&&(s.faceIndex=Math.floor(S/3),s.face.materialIndex=m.materialIndex,e.push(s))}}else{let _=Math.max(0,p.start),v=Math.min(o.count,p.start+p.count);for(let m=_,h=v;m<h;m+=3){let w=o.getX(m),E=o.getX(m+1),S=o.getX(m+2);s=ir(this,a,t,n,c,u,d,w,E,S),s&&(s.faceIndex=Math.floor(m/3),e.push(s))}}else if(l!==void 0)if(Array.isArray(a))for(let _=0,v=f.length;_<v;_++){let m=f[_],h=a[m.materialIndex],w=Math.max(m.start,p.start),E=Math.min(l.count,Math.min(m.start+m.count,p.start+p.count));for(let S=w,C=E;S<C;S+=3){let A=S,P=S+1,U=S+2;s=ir(this,h,t,n,c,u,d,A,P,U),s&&(s.faceIndex=Math.floor(S/3),s.face.materialIndex=m.materialIndex,e.push(s))}}else{let _=Math.max(0,p.start),v=Math.min(l.count,p.start+p.count);for(let m=_,h=v;m<h;m+=3){let w=m,E=m+1,S=m+2;s=ir(this,a,t,n,c,u,d,w,E,S),s&&(s.faceIndex=Math.floor(m/3),e.push(s))}}}};function jh(i,t,e,n,s,r,a,o){let l;if(t.side===De?l=n.intersectTriangle(a,r,s,!0,o):l=n.intersectTriangle(s,r,a,t.side===Tn,o),l===null)return null;nr.copy(o),nr.applyMatrix4(i.matrixWorld);let c=e.ray.origin.distanceTo(nr);return c<e.near||c>e.far?null:{distance:c,point:nr.clone(),object:i}}function ir(i,t,e,n,s,r,a,o,l,c){i.getVertexPosition(o,js),i.getVertexPosition(l,Qs),i.getVertexPosition(c,tr);let u=jh(i,t,e,n,js,Qs,tr,Cl);if(u){let d=new N;Nn.getBarycoord(Cl,js,Qs,tr,d),s&&(u.uv=Nn.getInterpolatedAttribute(s,o,l,c,d,new Rt)),r&&(u.uv1=Nn.getInterpolatedAttribute(r,o,l,c,d,new Rt)),a&&(u.normal=Nn.getInterpolatedAttribute(a,o,l,c,d,new N),u.normal.dot(n.direction)>0&&u.normal.multiplyScalar(-1));let f={a:o,b:l,c,normal:new N,materialIndex:0};Nn.getNormal(js,Qs,tr,f.normal),u.face=f,u.barycoord=d}return u}var kn=class i extends fn{constructor(t=1,e=1,n=1,s=1,r=1,a=1){super(),this.type="BoxGeometry",this.parameters={width:t,height:e,depth:n,widthSegments:s,heightSegments:r,depthSegments:a};let o=this;s=Math.floor(s),r=Math.floor(r),a=Math.floor(a);let l=[],c=[],u=[],d=[],f=0,p=0;_("z","y","x",-1,-1,n,e,t,a,r,0),_("z","y","x",1,-1,n,e,-t,a,r,1),_("x","z","y",1,1,t,n,e,s,a,2),_("x","z","y",1,-1,t,n,-e,s,a,3),_("x","y","z",1,-1,t,e,n,s,r,4),_("x","y","z",-1,-1,t,e,-n,s,r,5),this.setIndex(l),this.setAttribute("position",new we(c,3)),this.setAttribute("normal",new we(u,3)),this.setAttribute("uv",new we(d,2));function _(v,m,h,w,E,S,C,A,P,U,M){let y=S/P,I=C/U,O=S/2,k=C/2,G=A/2,q=P+1,W=U+1,et=0,V=0,rt=new N;for(let ct=0;ct<W;ct++){let St=ct*I-k;for(let kt=0;kt<q;kt++){let jt=kt*y-O;rt[v]=jt*w,rt[m]=St*E,rt[h]=G,c.push(rt.x,rt.y,rt.z),rt[v]=0,rt[m]=0,rt[h]=A>0?1:-1,u.push(rt.x,rt.y,rt.z),d.push(kt/P),d.push(1-ct/U),et+=1}}for(let ct=0;ct<U;ct++)for(let St=0;St<P;St++){let kt=f+St+q*ct,jt=f+St+q*(ct+1),ne=f+(St+1)+q*(ct+1),qt=f+(St+1)+q*ct;l.push(kt,jt,qt),l.push(jt,ne,qt),V+=6}o.addGroup(p,V,M),p+=V,f+=et}}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}static fromJSON(t){return new i(t.width,t.height,t.depth,t.widthSegments,t.heightSegments,t.depthSegments)}};function ui(i){let t={};for(let e in i){t[e]={};for(let n in i[e]){let s=i[e][n];s&&(s.isColor||s.isMatrix3||s.isMatrix4||s.isVector2||s.isVector3||s.isVector4||s.isTexture||s.isQuaternion)?s.isRenderTargetTexture?(console.warn("UniformsUtils: Textures of render targets cannot be cloned via cloneUniforms() or mergeUniforms()."),t[e][n]=null):t[e][n]=s.clone():Array.isArray(s)?t[e][n]=s.slice():t[e][n]=s}}return t}function Ce(i){let t={};for(let e=0;e<i.length;e++){let n=ui(i[e]);for(let s in n)t[s]=n[s]}return t}function Qh(i){let t=[];for(let e=0;e<i.length;e++)t.push(i[e].clone());return t}function Uo(i){let t=i.getRenderTarget();return t===null?i.outputColorSpace:t.isXRRenderTarget===!0?t.texture.colorSpace:Wt.workingColorSpace}var bc={clone:ui,merge:Ce},tu=`void main() {
	gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );
}`,eu=`void main() {
	gl_FragColor = vec4( 1.0, 0.0, 0.0, 1.0 );
}`,rn=class extends zn{constructor(t){super(),this.isShaderMaterial=!0,this.type="ShaderMaterial",this.defines={},this.uniforms={},this.uniformsGroups=[],this.vertexShader=tu,this.fragmentShader=eu,this.linewidth=1,this.wireframe=!1,this.wireframeLinewidth=1,this.fog=!1,this.lights=!1,this.clipping=!1,this.forceSinglePass=!0,this.extensions={clipCullDistance:!1,multiDraw:!1},this.defaultAttributeValues={color:[1,1,1],uv:[0,0],uv1:[0,0]},this.index0AttributeName=void 0,this.uniformsNeedUpdate=!1,this.glslVersion=null,t!==void 0&&this.setValues(t)}copy(t){return super.copy(t),this.fragmentShader=t.fragmentShader,this.vertexShader=t.vertexShader,this.uniforms=ui(t.uniforms),this.uniformsGroups=Qh(t.uniformsGroups),this.defines=Object.assign({},t.defines),this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this.fog=t.fog,this.lights=t.lights,this.clipping=t.clipping,this.extensions=Object.assign({},t.extensions),this.glslVersion=t.glslVersion,this}toJSON(t){let e=super.toJSON(t);e.glslVersion=this.glslVersion,e.uniforms={};for(let s in this.uniforms){let a=this.uniforms[s].value;a&&a.isTexture?e.uniforms[s]={type:"t",value:a.toJSON(t).uuid}:a&&a.isColor?e.uniforms[s]={type:"c",value:a.getHex()}:a&&a.isVector2?e.uniforms[s]={type:"v2",value:a.toArray()}:a&&a.isVector3?e.uniforms[s]={type:"v3",value:a.toArray()}:a&&a.isVector4?e.uniforms[s]={type:"v4",value:a.toArray()}:a&&a.isMatrix3?e.uniforms[s]={type:"m3",value:a.toArray()}:a&&a.isMatrix4?e.uniforms[s]={type:"m4",value:a.toArray()}:e.uniforms[s]={value:a}}Object.keys(this.defines).length>0&&(e.defines=this.defines),e.vertexShader=this.vertexShader,e.fragmentShader=this.fragmentShader,e.lights=this.lights,e.clipping=this.clipping;let n={};for(let s in this.extensions)this.extensions[s]===!0&&(n[s]=!0);return Object.keys(n).length>0&&(e.extensions=n),e}},ms=class extends Ae{constructor(){super(),this.isCamera=!0,this.type="Camera",this.matrixWorldInverse=new ce,this.projectionMatrix=new ce,this.projectionMatrixInverse=new ce,this.coordinateSystem=en,this._reversedDepth=!1}get reversedDepth(){return this._reversedDepth}copy(t,e){return super.copy(t,e),this.matrixWorldInverse.copy(t.matrixWorldInverse),this.projectionMatrix.copy(t.projectionMatrix),this.projectionMatrixInverse.copy(t.projectionMatrixInverse),this.coordinateSystem=t.coordinateSystem,this}getWorldDirection(t){return super.getWorldDirection(t).negate()}updateMatrixWorld(t){super.updateMatrixWorld(t),this.matrixWorldInverse.copy(this.matrixWorld).invert()}updateWorldMatrix(t,e){super.updateWorldMatrix(t,e),this.matrixWorldInverse.copy(this.matrixWorld).invert()}clone(){return new this.constructor().copy(this)}},Un=new N,Rl=new Rt,Il=new Rt,Ue=class extends ms{constructor(t=50,e=1,n=.1,s=2e3){super(),this.isPerspectiveCamera=!0,this.type="PerspectiveCamera",this.fov=t,this.zoom=1,this.near=n,this.far=s,this.focus=10,this.aspect=e,this.view=null,this.filmGauge=35,this.filmOffset=0,this.updateProjectionMatrix()}copy(t,e){return super.copy(t,e),this.fov=t.fov,this.zoom=t.zoom,this.near=t.near,this.far=t.far,this.focus=t.focus,this.aspect=t.aspect,this.view=t.view===null?null:Object.assign({},t.view),this.filmGauge=t.filmGauge,this.filmOffset=t.filmOffset,this}setFocalLength(t){let e=.5*this.getFilmHeight()/t;this.fov=Ui*2*Math.atan(e),this.updateProjectionMatrix()}getFocalLength(){let t=Math.tan(as*.5*this.fov);return .5*this.getFilmHeight()/t}getEffectiveFOV(){return Ui*2*Math.atan(Math.tan(as*.5*this.fov)/this.zoom)}getFilmWidth(){return this.filmGauge*Math.min(this.aspect,1)}getFilmHeight(){return this.filmGauge/Math.max(this.aspect,1)}getViewBounds(t,e,n){Un.set(-1,-1,.5).applyMatrix4(this.projectionMatrixInverse),e.set(Un.x,Un.y).multiplyScalar(-t/Un.z),Un.set(1,1,.5).applyMatrix4(this.projectionMatrixInverse),n.set(Un.x,Un.y).multiplyScalar(-t/Un.z)}getViewSize(t,e){return this.getViewBounds(t,Rl,Il),e.subVectors(Il,Rl)}setViewOffset(t,e,n,s,r,a){this.aspect=t/e,this.view===null&&(this.view={enabled:!0,fullWidth:1,fullHeight:1,offsetX:0,offsetY:0,width:1,height:1}),this.view.enabled=!0,this.view.fullWidth=t,this.view.fullHeight=e,this.view.offsetX=n,this.view.offsetY=s,this.view.width=r,this.view.height=a,this.updateProjectionMatrix()}clearViewOffset(){this.view!==null&&(this.view.enabled=!1),this.updateProjectionMatrix()}updateProjectionMatrix(){let t=this.near,e=t*Math.tan(as*.5*this.fov)/this.zoom,n=2*e,s=this.aspect*n,r=-.5*s,a=this.view;if(this.view!==null&&this.view.enabled){let l=a.fullWidth,c=a.fullHeight;r+=a.offsetX*s/l,e-=a.offsetY*n/c,s*=a.width/l,n*=a.height/c}let o=this.filmOffset;o!==0&&(r+=t*o/this.getFilmWidth()),this.projectionMatrix.makePerspective(r,r+s,e,e-n,t,this.far,this.coordinateSystem,this.reversedDepth),this.projectionMatrixInverse.copy(this.projectionMatrix).invert()}toJSON(t){let e=super.toJSON(t);return e.object.fov=this.fov,e.object.zoom=this.zoom,e.object.near=this.near,e.object.far=this.far,e.object.focus=this.focus,e.object.aspect=this.aspect,this.view!==null&&(e.object.view=Object.assign({},this.view)),e.object.filmGauge=this.filmGauge,e.object.filmOffset=this.filmOffset,e}},Ri=-90,Ii=1,mr=class extends Ae{constructor(t,e,n){super(),this.type="CubeCamera",this.renderTarget=n,this.coordinateSystem=null,this.activeMipmapLevel=0;let s=new Ue(Ri,Ii,t,e);s.layers=this.layers,this.add(s);let r=new Ue(Ri,Ii,t,e);r.layers=this.layers,this.add(r);let a=new Ue(Ri,Ii,t,e);a.layers=this.layers,this.add(a);let o=new Ue(Ri,Ii,t,e);o.layers=this.layers,this.add(o);let l=new Ue(Ri,Ii,t,e);l.layers=this.layers,this.add(l);let c=new Ue(Ri,Ii,t,e);c.layers=this.layers,this.add(c)}updateCoordinateSystem(){let t=this.coordinateSystem,e=this.children.concat(),[n,s,r,a,o,l]=e;for(let c of e)this.remove(c);if(t===en)n.up.set(0,1,0),n.lookAt(1,0,0),s.up.set(0,1,0),s.lookAt(-1,0,0),r.up.set(0,0,-1),r.lookAt(0,1,0),a.up.set(0,0,1),a.lookAt(0,-1,0),o.up.set(0,1,0),o.lookAt(0,0,1),l.up.set(0,1,0),l.lookAt(0,0,-1);else if(t===hs)n.up.set(0,-1,0),n.lookAt(-1,0,0),s.up.set(0,-1,0),s.lookAt(1,0,0),r.up.set(0,0,1),r.lookAt(0,1,0),a.up.set(0,0,-1),a.lookAt(0,-1,0),o.up.set(0,-1,0),o.lookAt(0,0,1),l.up.set(0,-1,0),l.lookAt(0,0,-1);else throw new Error("THREE.CubeCamera.updateCoordinateSystem(): Invalid coordinate system: "+t);for(let c of e)this.add(c),c.updateMatrixWorld()}update(t,e){this.parent===null&&this.updateMatrixWorld();let{renderTarget:n,activeMipmapLevel:s}=this;this.coordinateSystem!==t.coordinateSystem&&(this.coordinateSystem=t.coordinateSystem,this.updateCoordinateSystem());let[r,a,o,l,c,u]=this.children,d=t.getRenderTarget(),f=t.getActiveCubeFace(),p=t.getActiveMipmapLevel(),_=t.xr.enabled;t.xr.enabled=!1;let v=n.texture.generateMipmaps;n.texture.generateMipmaps=!1,t.setRenderTarget(n,0,s),t.render(e,r),t.setRenderTarget(n,1,s),t.render(e,a),t.setRenderTarget(n,2,s),t.render(e,o),t.setRenderTarget(n,3,s),t.render(e,l),t.setRenderTarget(n,4,s),t.render(e,c),n.texture.generateMipmaps=v,t.setRenderTarget(n,5,s),t.render(e,u),t.setRenderTarget(d,f,p),t.xr.enabled=_,n.texture.needsPMREMUpdate=!0}},gs=class extends Ne{constructor(t=[],e=ci,n,s,r,a,o,l,c,u){super(t,e,n,s,r,a,o,l,c,u),this.isCubeTexture=!0,this.flipY=!1}get images(){return this.image}set images(t){this.image=t}},gr=class extends dn{constructor(t=1,e={}){super(t,t,e),this.isWebGLCubeRenderTarget=!0;let n={width:t,height:t,depth:1},s=[n,n,n,n,n,n];this.texture=new gs(s),this._setTextureOptions(e),this.texture.isRenderTargetTexture=!0}fromEquirectangularTexture(t,e){this.texture.type=e.type,this.texture.colorSpace=e.colorSpace,this.texture.generateMipmaps=e.generateMipmaps,this.texture.minFilter=e.minFilter,this.texture.magFilter=e.magFilter;let n={uniforms:{tEquirect:{value:null}},vertexShader:`

				varying vec3 vWorldDirection;

				vec3 transformDirection( in vec3 dir, in mat4 matrix ) {

					return normalize( ( matrix * vec4( dir, 0.0 ) ).xyz );

				}

				void main() {

					vWorldDirection = transformDirection( position, modelMatrix );

					#include <begin_vertex>
					#include <project_vertex>

				}
			`,fragmentShader:`

				uniform sampler2D tEquirect;

				varying vec3 vWorldDirection;

				#include <common>

				void main() {

					vec3 direction = normalize( vWorldDirection );

					vec2 sampleUV = equirectUv( direction );

					gl_FragColor = texture2D( tEquirect, sampleUV );

				}
			`},s=new kn(5,5,5),r=new rn({name:"CubemapFromEquirect",uniforms:ui(n.uniforms),vertexShader:n.vertexShader,fragmentShader:n.fragmentShader,side:De,blending:wn});r.uniforms.tEquirect.value=e;let a=new Me(s,r),o=e.minFilter;return e.minFilter===Xn&&(e.minFilter=nn),new mr(1,10,this).update(t,a),e.minFilter=o,a.geometry.dispose(),a.material.dispose(),this}clear(t,e=!0,n=!0,s=!0){let r=t.getRenderTarget();for(let a=0;a<6;a++)t.setRenderTarget(this,a),t.clear(e,n,s);t.setRenderTarget(r)}},Pe=class extends Ae{constructor(){super(),this.isGroup=!0,this.type="Group"}},nu={type:"move"},zi=class{constructor(){this._targetRay=null,this._grip=null,this._hand=null}getHandSpace(){return this._hand===null&&(this._hand=new Pe,this._hand.matrixAutoUpdate=!1,this._hand.visible=!1,this._hand.joints={},this._hand.inputState={pinching:!1}),this._hand}getTargetRaySpace(){return this._targetRay===null&&(this._targetRay=new Pe,this._targetRay.matrixAutoUpdate=!1,this._targetRay.visible=!1,this._targetRay.hasLinearVelocity=!1,this._targetRay.linearVelocity=new N,this._targetRay.hasAngularVelocity=!1,this._targetRay.angularVelocity=new N),this._targetRay}getGripSpace(){return this._grip===null&&(this._grip=new Pe,this._grip.matrixAutoUpdate=!1,this._grip.visible=!1,this._grip.hasLinearVelocity=!1,this._grip.linearVelocity=new N,this._grip.hasAngularVelocity=!1,this._grip.angularVelocity=new N),this._grip}dispatchEvent(t){return this._targetRay!==null&&this._targetRay.dispatchEvent(t),this._grip!==null&&this._grip.dispatchEvent(t),this._hand!==null&&this._hand.dispatchEvent(t),this}connect(t){if(t&&t.hand){let e=this._hand;if(e)for(let n of t.hand.values())this._getHandJoint(e,n)}return this.dispatchEvent({type:"connected",data:t}),this}disconnect(t){return this.dispatchEvent({type:"disconnected",data:t}),this._targetRay!==null&&(this._targetRay.visible=!1),this._grip!==null&&(this._grip.visible=!1),this._hand!==null&&(this._hand.visible=!1),this}update(t,e,n){let s=null,r=null,a=null,o=this._targetRay,l=this._grip,c=this._hand;if(t&&e.session.visibilityState!=="visible-blurred"){if(c&&t.hand){a=!0;for(let v of t.hand.values()){let m=e.getJointPose(v,n),h=this._getHandJoint(c,v);m!==null&&(h.matrix.fromArray(m.transform.matrix),h.matrix.decompose(h.position,h.rotation,h.scale),h.matrixWorldNeedsUpdate=!0,h.jointRadius=m.radius),h.visible=m!==null}let u=c.joints["index-finger-tip"],d=c.joints["thumb-tip"],f=u.position.distanceTo(d.position),p=.02,_=.005;c.inputState.pinching&&f>p+_?(c.inputState.pinching=!1,this.dispatchEvent({type:"pinchend",handedness:t.handedness,target:this})):!c.inputState.pinching&&f<=p-_&&(c.inputState.pinching=!0,this.dispatchEvent({type:"pinchstart",handedness:t.handedness,target:this}))}else l!==null&&t.gripSpace&&(r=e.getPose(t.gripSpace,n),r!==null&&(l.matrix.fromArray(r.transform.matrix),l.matrix.decompose(l.position,l.rotation,l.scale),l.matrixWorldNeedsUpdate=!0,r.linearVelocity?(l.hasLinearVelocity=!0,l.linearVelocity.copy(r.linearVelocity)):l.hasLinearVelocity=!1,r.angularVelocity?(l.hasAngularVelocity=!0,l.angularVelocity.copy(r.angularVelocity)):l.hasAngularVelocity=!1));o!==null&&(s=e.getPose(t.targetRaySpace,n),s===null&&r!==null&&(s=r),s!==null&&(o.matrix.fromArray(s.transform.matrix),o.matrix.decompose(o.position,o.rotation,o.scale),o.matrixWorldNeedsUpdate=!0,s.linearVelocity?(o.hasLinearVelocity=!0,o.linearVelocity.copy(s.linearVelocity)):o.hasLinearVelocity=!1,s.angularVelocity?(o.hasAngularVelocity=!0,o.angularVelocity.copy(s.angularVelocity)):o.hasAngularVelocity=!1,this.dispatchEvent(nu)))}return o!==null&&(o.visible=s!==null),l!==null&&(l.visible=r!==null),c!==null&&(c.visible=a!==null),this}_getHandJoint(t,e){if(t.joints[e.jointName]===void 0){let n=new Pe;n.matrixAutoUpdate=!1,n.visible=!1,t.joints[e.jointName]=n,t.add(n)}return t.joints[e.jointName]}};var _s=class extends Ae{constructor(){super(),this.isScene=!0,this.type="Scene",this.background=null,this.environment=null,this.fog=null,this.backgroundBlurriness=0,this.backgroundIntensity=1,this.backgroundRotation=new sn,this.environmentIntensity=1,this.environmentRotation=new sn,this.overrideMaterial=null,typeof __THREE_DEVTOOLS__<"u"&&__THREE_DEVTOOLS__.dispatchEvent(new CustomEvent("observe",{detail:this}))}copy(t,e){return super.copy(t,e),t.background!==null&&(this.background=t.background.clone()),t.environment!==null&&(this.environment=t.environment.clone()),t.fog!==null&&(this.fog=t.fog.clone()),this.backgroundBlurriness=t.backgroundBlurriness,this.backgroundIntensity=t.backgroundIntensity,this.backgroundRotation.copy(t.backgroundRotation),this.environmentIntensity=t.environmentIntensity,this.environmentRotation.copy(t.environmentRotation),t.overrideMaterial!==null&&(this.overrideMaterial=t.overrideMaterial.clone()),this.matrixAutoUpdate=t.matrixAutoUpdate,this}toJSON(t){let e=super.toJSON(t);return this.fog!==null&&(e.object.fog=this.fog.toJSON()),this.backgroundBlurriness>0&&(e.object.backgroundBlurriness=this.backgroundBlurriness),this.backgroundIntensity!==1&&(e.object.backgroundIntensity=this.backgroundIntensity),e.object.backgroundRotation=this.backgroundRotation.toArray(),this.environmentIntensity!==1&&(e.object.environmentIntensity=this.environmentIntensity),e.object.environmentRotation=this.environmentRotation.toArray(),e}};var eo=new N,iu=new N,su=new Ut,Ye=class{constructor(t=new N(1,0,0),e=0){this.isPlane=!0,this.normal=t,this.constant=e}set(t,e){return this.normal.copy(t),this.constant=e,this}setComponents(t,e,n,s){return this.normal.set(t,e,n),this.constant=s,this}setFromNormalAndCoplanarPoint(t,e){return this.normal.copy(t),this.constant=-e.dot(this.normal),this}setFromCoplanarPoints(t,e,n){let s=eo.subVectors(n,e).cross(iu.subVectors(t,e)).normalize();return this.setFromNormalAndCoplanarPoint(s,t),this}copy(t){return this.normal.copy(t.normal),this.constant=t.constant,this}normalize(){let t=1/this.normal.length();return this.normal.multiplyScalar(t),this.constant*=t,this}negate(){return this.constant*=-1,this.normal.negate(),this}distanceToPoint(t){return this.normal.dot(t)+this.constant}distanceToSphere(t){return this.distanceToPoint(t.center)-t.radius}projectPoint(t,e){return e.copy(t).addScaledVector(this.normal,-this.distanceToPoint(t))}intersectLine(t,e){let n=t.delta(eo),s=this.normal.dot(n);if(s===0)return this.distanceToPoint(t.start)===0?e.copy(t.start):null;let r=-(t.start.dot(this.normal)+this.constant)/s;return r<0||r>1?null:e.copy(t.start).addScaledVector(n,r)}intersectsLine(t){let e=this.distanceToPoint(t.start),n=this.distanceToPoint(t.end);return e<0&&n>0||n<0&&e>0}intersectsBox(t){return t.intersectsPlane(this)}intersectsSphere(t){return t.intersectsPlane(this)}coplanarPoint(t){return t.copy(this.normal).multiplyScalar(-this.constant)}applyMatrix4(t,e){let n=e||su.getNormalMatrix(t),s=this.coplanarPoint(eo).applyMatrix4(t),r=this.normal.applyMatrix3(n).normalize();return this.constant=-s.dot(r),this}translate(t){return this.constant-=t.dot(this.normal),this}equals(t){return t.normal.equals(this.normal)&&t.constant===this.constant}clone(){return new this.constructor().copy(this)}},Qn=new Oi,ru=new Rt(.5,.5),sr=new N,ki=class{constructor(t=new Ye,e=new Ye,n=new Ye,s=new Ye,r=new Ye,a=new Ye){this.planes=[t,e,n,s,r,a]}set(t,e,n,s,r,a){let o=this.planes;return o[0].copy(t),o[1].copy(e),o[2].copy(n),o[3].copy(s),o[4].copy(r),o[5].copy(a),this}copy(t){let e=this.planes;for(let n=0;n<6;n++)e[n].copy(t.planes[n]);return this}setFromProjectionMatrix(t,e=en,n=!1){let s=this.planes,r=t.elements,a=r[0],o=r[1],l=r[2],c=r[3],u=r[4],d=r[5],f=r[6],p=r[7],_=r[8],v=r[9],m=r[10],h=r[11],w=r[12],E=r[13],S=r[14],C=r[15];if(s[0].setComponents(c-a,p-u,h-_,C-w).normalize(),s[1].setComponents(c+a,p+u,h+_,C+w).normalize(),s[2].setComponents(c+o,p+d,h+v,C+E).normalize(),s[3].setComponents(c-o,p-d,h-v,C-E).normalize(),n)s[4].setComponents(l,f,m,S).normalize(),s[5].setComponents(c-l,p-f,h-m,C-S).normalize();else if(s[4].setComponents(c-l,p-f,h-m,C-S).normalize(),e===en)s[5].setComponents(c+l,p+f,h+m,C+S).normalize();else if(e===hs)s[5].setComponents(l,f,m,S).normalize();else throw new Error("THREE.Frustum.setFromProjectionMatrix(): Invalid coordinate system: "+e);return this}intersectsObject(t){if(t.boundingSphere!==void 0)t.boundingSphere===null&&t.computeBoundingSphere(),Qn.copy(t.boundingSphere).applyMatrix4(t.matrixWorld);else{let e=t.geometry;e.boundingSphere===null&&e.computeBoundingSphere(),Qn.copy(e.boundingSphere).applyMatrix4(t.matrixWorld)}return this.intersectsSphere(Qn)}intersectsSprite(t){Qn.center.set(0,0,0);let e=ru.distanceTo(t.center);return Qn.radius=.7071067811865476+e,Qn.applyMatrix4(t.matrixWorld),this.intersectsSphere(Qn)}intersectsSphere(t){let e=this.planes,n=t.center,s=-t.radius;for(let r=0;r<6;r++)if(e[r].distanceToPoint(n)<s)return!1;return!0}intersectsBox(t){let e=this.planes;for(let n=0;n<6;n++){let s=e[n];if(sr.x=s.normal.x>0?t.max.x:t.min.x,sr.y=s.normal.y>0?t.max.y:t.min.y,sr.z=s.normal.z>0?t.max.z:t.min.z,s.distanceToPoint(sr)<0)return!1}return!0}containsPoint(t){let e=this.planes;for(let n=0;n<6;n++)if(e[n].distanceToPoint(t)<0)return!1;return!0}clone(){return new this.constructor().copy(this)}};var xs=class extends Ne{constructor(t,e,n,s,r,a,o,l,c){super(t,e,n,s,r,a,o,l,c),this.isCanvasTexture=!0,this.needsUpdate=!0}},ys=class extends Ne{constructor(t,e,n=qn,s,r,a,o=Ze,l=Ze,c,u=Li,d=1){if(u!==Li&&u!==Xi)throw new Error("DepthTexture format must be either THREE.DepthFormat or THREE.DepthStencilFormat");let f={width:t,height:e,depth:d};super(f,s,r,a,o,l,u,n,c),this.isDepthTexture=!0,this.flipY=!1,this.generateMipmaps=!1,this.compareFunction=null}copy(t){return super.copy(t),this.source=new Fi(Object.assign({},t.image)),this.compareFunction=t.compareFunction,this}toJSON(t){let e=super.toJSON(t);return this.compareFunction!==null&&(e.compareFunction=this.compareFunction),e}},vs=class extends Ne{constructor(t=null){super(),this.sourceTexture=t,this.isExternalTexture=!0}copy(t){return super.copy(t),this.sourceTexture=t.sourceTexture,this}};var Ms=class i extends fn{constructor(t=1,e=1,n=1,s=32,r=1,a=!1,o=0,l=Math.PI*2){super(),this.type="CylinderGeometry",this.parameters={radiusTop:t,radiusBottom:e,height:n,radialSegments:s,heightSegments:r,openEnded:a,thetaStart:o,thetaLength:l};let c=this;s=Math.floor(s),r=Math.floor(r);let u=[],d=[],f=[],p=[],_=0,v=[],m=n/2,h=0;w(),a===!1&&(t>0&&E(!0),e>0&&E(!1)),this.setIndex(u),this.setAttribute("position",new we(d,3)),this.setAttribute("normal",new we(f,3)),this.setAttribute("uv",new we(p,2));function w(){let S=new N,C=new N,A=0,P=(e-t)/n;for(let U=0;U<=r;U++){let M=[],y=U/r,I=y*(e-t)+t;for(let O=0;O<=s;O++){let k=O/s,G=k*l+o,q=Math.sin(G),W=Math.cos(G);C.x=I*q,C.y=-y*n+m,C.z=I*W,d.push(C.x,C.y,C.z),S.set(q,P,W).normalize(),f.push(S.x,S.y,S.z),p.push(k,1-y),M.push(_++)}v.push(M)}for(let U=0;U<s;U++)for(let M=0;M<r;M++){let y=v[M][U],I=v[M+1][U],O=v[M+1][U+1],k=v[M][U+1];(t>0||M!==0)&&(u.push(y,I,k),A+=3),(e>0||M!==r-1)&&(u.push(I,O,k),A+=3)}c.addGroup(h,A,0),h+=A}function E(S){let C=_,A=new Rt,P=new N,U=0,M=S===!0?t:e,y=S===!0?1:-1;for(let O=1;O<=s;O++)d.push(0,m*y,0),f.push(0,y,0),p.push(.5,.5),_++;let I=_;for(let O=0;O<=s;O++){let G=O/s*l+o,q=Math.cos(G),W=Math.sin(G);P.x=M*W,P.y=m*y,P.z=M*q,d.push(P.x,P.y,P.z),f.push(0,y,0),A.x=q*.5+.5,A.y=W*.5*y+.5,p.push(A.x,A.y),_++}for(let O=0;O<s;O++){let k=C+O,G=I+O;S===!0?u.push(G,G+1,k):u.push(G+1,G,k),U+=3}c.addGroup(h,U,S===!0?1:2),h+=U}}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}static fromJSON(t){return new i(t.radiusTop,t.radiusBottom,t.height,t.radialSegments,t.heightSegments,t.openEnded,t.thetaStart,t.thetaLength)}};var ai=class i extends fn{constructor(t=1,e=1,n=1,s=1){super(),this.type="PlaneGeometry",this.parameters={width:t,height:e,widthSegments:n,heightSegments:s};let r=t/2,a=e/2,o=Math.floor(n),l=Math.floor(s),c=o+1,u=l+1,d=t/o,f=e/l,p=[],_=[],v=[],m=[];for(let h=0;h<u;h++){let w=h*f-a;for(let E=0;E<c;E++){let S=E*d-r;_.push(S,-w,0),v.push(0,0,1),m.push(E/o),m.push(1-h/l)}}for(let h=0;h<l;h++)for(let w=0;w<o;w++){let E=w+c*h,S=w+c*(h+1),C=w+1+c*(h+1),A=w+1+c*h;p.push(E,S,A),p.push(S,C,A)}this.setIndex(p),this.setAttribute("position",new we(_,3)),this.setAttribute("normal",new we(v,3)),this.setAttribute("uv",new we(m,2))}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}static fromJSON(t){return new i(t.width,t.height,t.widthSegments,t.heightSegments)}};var Ss=class i extends fn{constructor(t=1,e=32,n=16,s=0,r=Math.PI*2,a=0,o=Math.PI){super(),this.type="SphereGeometry",this.parameters={radius:t,widthSegments:e,heightSegments:n,phiStart:s,phiLength:r,thetaStart:a,thetaLength:o},e=Math.max(3,Math.floor(e)),n=Math.max(2,Math.floor(n));let l=Math.min(a+o,Math.PI),c=0,u=[],d=new N,f=new N,p=[],_=[],v=[],m=[];for(let h=0;h<=n;h++){let w=[],E=h/n,S=0;h===0&&a===0?S=.5/e:h===n&&l===Math.PI&&(S=-.5/e);for(let C=0;C<=e;C++){let A=C/e;d.x=-t*Math.cos(s+A*r)*Math.sin(a+E*o),d.y=t*Math.cos(a+E*o),d.z=t*Math.sin(s+A*r)*Math.sin(a+E*o),_.push(d.x,d.y,d.z),f.copy(d).normalize(),v.push(f.x,f.y,f.z),m.push(A+S,1-E),w.push(c++)}u.push(w)}for(let h=0;h<n;h++)for(let w=0;w<e;w++){let E=u[h][w+1],S=u[h][w],C=u[h+1][w],A=u[h+1][w+1];(h!==0||a>0)&&p.push(E,S,A),(h!==n-1||l<Math.PI)&&p.push(S,C,A)}this.setIndex(p),this.setAttribute("position",new we(_,3)),this.setAttribute("normal",new we(v,3)),this.setAttribute("uv",new we(m,2))}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}static fromJSON(t){return new i(t.radius,t.widthSegments,t.heightSegments,t.phiStart,t.phiLength,t.thetaStart,t.thetaLength)}};var bs=class extends zn{constructor(t){super(),this.isMeshStandardMaterial=!0,this.type="MeshStandardMaterial",this.defines={STANDARD:""},this.color=new Ht(16777215),this.roughness=1,this.metalness=0,this.map=null,this.lightMap=null,this.lightMapIntensity=1,this.aoMap=null,this.aoMapIntensity=1,this.emissive=new Ht(0),this.emissiveIntensity=1,this.emissiveMap=null,this.bumpMap=null,this.bumpScale=1,this.normalMap=null,this.normalMapType=Co,this.normalScale=new Rt(1,1),this.displacementMap=null,this.displacementScale=1,this.displacementBias=0,this.roughnessMap=null,this.metalnessMap=null,this.alphaMap=null,this.envMap=null,this.envMapRotation=new sn,this.envMapIntensity=1,this.wireframe=!1,this.wireframeLinewidth=1,this.wireframeLinecap="round",this.wireframeLinejoin="round",this.flatShading=!1,this.fog=!0,this.setValues(t)}copy(t){return super.copy(t),this.defines={STANDARD:""},this.color.copy(t.color),this.roughness=t.roughness,this.metalness=t.metalness,this.map=t.map,this.lightMap=t.lightMap,this.lightMapIntensity=t.lightMapIntensity,this.aoMap=t.aoMap,this.aoMapIntensity=t.aoMapIntensity,this.emissive.copy(t.emissive),this.emissiveMap=t.emissiveMap,this.emissiveIntensity=t.emissiveIntensity,this.bumpMap=t.bumpMap,this.bumpScale=t.bumpScale,this.normalMap=t.normalMap,this.normalMapType=t.normalMapType,this.normalScale.copy(t.normalScale),this.displacementMap=t.displacementMap,this.displacementScale=t.displacementScale,this.displacementBias=t.displacementBias,this.roughnessMap=t.roughnessMap,this.metalnessMap=t.metalnessMap,this.alphaMap=t.alphaMap,this.envMap=t.envMap,this.envMapRotation.copy(t.envMapRotation),this.envMapIntensity=t.envMapIntensity,this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this.wireframeLinecap=t.wireframeLinecap,this.wireframeLinejoin=t.wireframeLinejoin,this.flatShading=t.flatShading,this.fog=t.fog,this}};var _r=class extends zn{constructor(t){super(),this.isMeshDepthMaterial=!0,this.type="MeshDepthMaterial",this.depthPacking=hc,this.map=null,this.alphaMap=null,this.displacementMap=null,this.displacementScale=1,this.displacementBias=0,this.wireframe=!1,this.wireframeLinewidth=1,this.setValues(t)}copy(t){return super.copy(t),this.depthPacking=t.depthPacking,this.map=t.map,this.alphaMap=t.alphaMap,this.displacementMap=t.displacementMap,this.displacementScale=t.displacementScale,this.displacementBias=t.displacementBias,this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this}},xr=class extends zn{constructor(t){super(),this.isMeshDistanceMaterial=!0,this.type="MeshDistanceMaterial",this.map=null,this.alphaMap=null,this.displacementMap=null,this.displacementScale=1,this.displacementBias=0,this.setValues(t)}copy(t){return super.copy(t),this.map=t.map,this.alphaMap=t.alphaMap,this.displacementMap=t.displacementMap,this.displacementScale=t.displacementScale,this.displacementBias=t.displacementBias,this}};function rr(i,t){return!i||i.constructor===t?i:typeof t.BYTES_PER_ELEMENT=="number"?new t(i):Array.prototype.slice.call(i)}function au(i){return ArrayBuffer.isView(i)&&!(i instanceof DataView)}var oi=class{constructor(t,e,n,s){this.parameterPositions=t,this._cachedIndex=0,this.resultBuffer=s!==void 0?s:new e.constructor(n),this.sampleValues=e,this.valueSize=n,this.settings=null,this.DefaultSettings_={}}evaluate(t){let e=this.parameterPositions,n=this._cachedIndex,s=e[n],r=e[n-1];n:{t:{let a;e:{i:if(!(t<s)){for(let o=n+2;;){if(s===void 0){if(t<r)break i;return n=e.length,this._cachedIndex=n,this.copySampleValue_(n-1)}if(n===o)break;if(r=s,s=e[++n],t<s)break t}a=e.length;break e}if(!(t>=r)){let o=e[1];t<o&&(n=2,r=o);for(let l=n-2;;){if(r===void 0)return this._cachedIndex=0,this.copySampleValue_(0);if(n===l)break;if(s=r,r=e[--n-1],t>=r)break t}a=n,n=0;break e}break n}for(;n<a;){let o=n+a>>>1;t<e[o]?a=o:n=o+1}if(s=e[n],r=e[n-1],r===void 0)return this._cachedIndex=0,this.copySampleValue_(0);if(s===void 0)return n=e.length,this._cachedIndex=n,this.copySampleValue_(n-1)}this._cachedIndex=n,this.intervalChanged_(n,r,s)}return this.interpolate_(n,r,t,s)}getSettings_(){return this.settings||this.DefaultSettings_}copySampleValue_(t){let e=this.resultBuffer,n=this.sampleValues,s=this.valueSize,r=t*s;for(let a=0;a!==s;++a)e[a]=n[r+a];return e}interpolate_(){throw new Error("call to abstract method")}intervalChanged_(){}},yr=class extends oi{constructor(t,e,n,s){super(t,e,n,s),this._weightPrev=-0,this._offsetPrev=-0,this._weightNext=-0,this._offsetNext=-0,this.DefaultSettings_={endingStart:io,endingEnd:io}}intervalChanged_(t,e,n){let s=this.parameterPositions,r=t-2,a=t+1,o=s[r],l=s[a];if(o===void 0)switch(this.getSettings_().endingStart){case so:r=t,o=2*e-n;break;case ro:r=s.length-2,o=e+s[r]-s[r+1];break;default:r=t,o=n}if(l===void 0)switch(this.getSettings_().endingEnd){case so:a=t,l=2*n-e;break;case ro:a=1,l=n+s[1]-s[0];break;default:a=t-1,l=e}let c=(n-e)*.5,u=this.valueSize;this._weightPrev=c/(e-o),this._weightNext=c/(l-n),this._offsetPrev=r*u,this._offsetNext=a*u}interpolate_(t,e,n,s){let r=this.resultBuffer,a=this.sampleValues,o=this.valueSize,l=t*o,c=l-o,u=this._offsetPrev,d=this._offsetNext,f=this._weightPrev,p=this._weightNext,_=(n-e)/(s-e),v=_*_,m=v*_,h=-f*m+2*f*v-f*_,w=(1+f)*m+(-1.5-2*f)*v+(-.5+f)*_+1,E=(-1-p)*m+(1.5+p)*v+.5*_,S=p*m-p*v;for(let C=0;C!==o;++C)r[C]=h*a[u+C]+w*a[c+C]+E*a[l+C]+S*a[d+C];return r}},vr=class extends oi{constructor(t,e,n,s){super(t,e,n,s)}interpolate_(t,e,n,s){let r=this.resultBuffer,a=this.sampleValues,o=this.valueSize,l=t*o,c=l-o,u=(n-e)/(s-e),d=1-u;for(let f=0;f!==o;++f)r[f]=a[c+f]*d+a[l+f]*u;return r}},Mr=class extends oi{constructor(t,e,n,s){super(t,e,n,s)}interpolate_(t){return this.copySampleValue_(t-1)}},He=class{constructor(t,e,n,s){if(t===void 0)throw new Error("THREE.KeyframeTrack: track name is undefined");if(e===void 0||e.length===0)throw new Error("THREE.KeyframeTrack: no keyframes in track named "+t);this.name=t,this.times=rr(e,this.TimeBufferType),this.values=rr(n,this.ValueBufferType),this.setInterpolation(s||this.DefaultInterpolation)}static toJSON(t){let e=t.constructor,n;if(e.toJSON!==this.toJSON)n=e.toJSON(t);else{n={name:t.name,times:rr(t.times,Array),values:rr(t.values,Array)};let s=t.getInterpolation();s!==t.DefaultInterpolation&&(n.interpolation=s)}return n.type=t.ValueTypeName,n}InterpolantFactoryMethodDiscrete(t){return new Mr(this.times,this.values,this.getValueSize(),t)}InterpolantFactoryMethodLinear(t){return new vr(this.times,this.values,this.getValueSize(),t)}InterpolantFactoryMethodSmooth(t){return new yr(this.times,this.values,this.getValueSize(),t)}setInterpolation(t){let e;switch(t){case ls:e=this.InterpolantFactoryMethodDiscrete;break;case ur:e=this.InterpolantFactoryMethodLinear;break;case ar:e=this.InterpolantFactoryMethodSmooth;break}if(e===void 0){let n="unsupported interpolation for "+this.ValueTypeName+" keyframe track named "+this.name;if(this.createInterpolant===void 0)if(t!==this.DefaultInterpolation)this.setInterpolation(this.DefaultInterpolation);else throw new Error(n);return console.warn("THREE.KeyframeTrack:",n),this}return this.createInterpolant=e,this}getInterpolation(){switch(this.createInterpolant){case this.InterpolantFactoryMethodDiscrete:return ls;case this.InterpolantFactoryMethodLinear:return ur;case this.InterpolantFactoryMethodSmooth:return ar}}getValueSize(){return this.values.length/this.times.length}shift(t){if(t!==0){let e=this.times;for(let n=0,s=e.length;n!==s;++n)e[n]+=t}return this}scale(t){if(t!==1){let e=this.times;for(let n=0,s=e.length;n!==s;++n)e[n]*=t}return this}trim(t,e){let n=this.times,s=n.length,r=0,a=s-1;for(;r!==s&&n[r]<t;)++r;for(;a!==-1&&n[a]>e;)--a;if(++a,r!==0||a!==s){r>=a&&(a=Math.max(a,1),r=a-1);let o=this.getValueSize();this.times=n.slice(r,a),this.values=this.values.slice(r*o,a*o)}return this}validate(){let t=!0,e=this.getValueSize();e-Math.floor(e)!==0&&(console.error("THREE.KeyframeTrack: Invalid value size in track.",this),t=!1);let n=this.times,s=this.values,r=n.length;r===0&&(console.error("THREE.KeyframeTrack: Track is empty.",this),t=!1);let a=null;for(let o=0;o!==r;o++){let l=n[o];if(typeof l=="number"&&isNaN(l)){console.error("THREE.KeyframeTrack: Time is not a valid number.",this,o,l),t=!1;break}if(a!==null&&a>l){console.error("THREE.KeyframeTrack: Out of order keys.",this,o,l,a),t=!1;break}a=l}if(s!==void 0&&au(s))for(let o=0,l=s.length;o!==l;++o){let c=s[o];if(isNaN(c)){console.error("THREE.KeyframeTrack: Value is not a valid number.",this,o,c),t=!1;break}}return t}optimize(){let t=this.times.slice(),e=this.values.slice(),n=this.getValueSize(),s=this.getInterpolation()===ar,r=t.length-1,a=1;for(let o=1;o<r;++o){let l=!1,c=t[o],u=t[o+1];if(c!==u&&(o!==1||c!==t[0]))if(s)l=!0;else{let d=o*n,f=d-n,p=d+n;for(let _=0;_!==n;++_){let v=e[d+_];if(v!==e[f+_]||v!==e[p+_]){l=!0;break}}}if(l){if(o!==a){t[a]=t[o];let d=o*n,f=a*n;for(let p=0;p!==n;++p)e[f+p]=e[d+p]}++a}}if(r>0){t[a]=t[r];for(let o=r*n,l=a*n,c=0;c!==n;++c)e[l+c]=e[o+c];++a}return a!==t.length?(this.times=t.slice(0,a),this.values=e.slice(0,a*n)):(this.times=t,this.values=e),this}clone(){let t=this.times.slice(),e=this.values.slice(),n=this.constructor,s=new n(this.name,t,e);return s.createInterpolant=this.createInterpolant,s}};He.prototype.ValueTypeName="";He.prototype.TimeBufferType=Float32Array;He.prototype.ValueBufferType=Float32Array;He.prototype.DefaultInterpolation=ur;var Vn=class extends He{constructor(t,e,n){super(t,e,n)}};Vn.prototype.ValueTypeName="bool";Vn.prototype.ValueBufferType=Array;Vn.prototype.DefaultInterpolation=ls;Vn.prototype.InterpolantFactoryMethodLinear=void 0;Vn.prototype.InterpolantFactoryMethodSmooth=void 0;var Sr=class extends He{constructor(t,e,n,s){super(t,e,n,s)}};Sr.prototype.ValueTypeName="color";var br=class extends He{constructor(t,e,n,s){super(t,e,n,s)}};br.prototype.ValueTypeName="number";var Er=class extends oi{constructor(t,e,n,s){super(t,e,n,s)}interpolate_(t,e,n,s){let r=this.resultBuffer,a=this.sampleValues,o=this.valueSize,l=(n-e)/(s-e),c=t*o;for(let u=c+o;c!==u;c+=4)Je.slerpFlat(r,0,a,c-o,a,c,l);return r}},Es=class extends He{constructor(t,e,n,s){super(t,e,n,s)}InterpolantFactoryMethodLinear(t){return new Er(this.times,this.values,this.getValueSize(),t)}};Es.prototype.ValueTypeName="quaternion";Es.prototype.InterpolantFactoryMethodSmooth=void 0;var Hn=class extends He{constructor(t,e,n){super(t,e,n)}};Hn.prototype.ValueTypeName="string";Hn.prototype.ValueBufferType=Array;Hn.prototype.DefaultInterpolation=ls;Hn.prototype.InterpolantFactoryMethodLinear=void 0;Hn.prototype.InterpolantFactoryMethodSmooth=void 0;var Tr=class extends He{constructor(t,e,n,s){super(t,e,n,s)}};Tr.prototype.ValueTypeName="vector";var wr=class{constructor(t,e,n){let s=this,r=!1,a=0,o=0,l,c=[];this.onStart=void 0,this.onLoad=t,this.onProgress=e,this.onError=n,this.abortController=new AbortController,this.itemStart=function(u){o++,r===!1&&s.onStart!==void 0&&s.onStart(u,a,o),r=!0},this.itemEnd=function(u){a++,s.onProgress!==void 0&&s.onProgress(u,a,o),a===o&&(r=!1,s.onLoad!==void 0&&s.onLoad())},this.itemError=function(u){s.onError!==void 0&&s.onError(u)},this.resolveURL=function(u){return l?l(u):u},this.setURLModifier=function(u){return l=u,this},this.addHandler=function(u,d){return c.push(u,d),this},this.removeHandler=function(u){let d=c.indexOf(u);return d!==-1&&c.splice(d,2),this},this.getHandler=function(u){for(let d=0,f=c.length;d<f;d+=2){let p=c[d],_=c[d+1];if(p.global&&(p.lastIndex=0),p.test(u))return _}return null},this.abort=function(){return this.abortController.abort(),this.abortController=new AbortController,this}}},Ec=new wr,Ar=class{constructor(t){this.manager=t!==void 0?t:Ec,this.crossOrigin="anonymous",this.withCredentials=!1,this.path="",this.resourcePath="",this.requestHeader={}}load(){}loadAsync(t,e){let n=this;return new Promise(function(s,r){n.load(t,s,e,r)})}parse(){}setCrossOrigin(t){return this.crossOrigin=t,this}setWithCredentials(t){return this.withCredentials=t,this}setPath(t){return this.path=t,this}setResourcePath(t){return this.resourcePath=t,this}setRequestHeader(t){return this.requestHeader=t,this}abort(){return this}};Ar.DEFAULT_MATERIAL_NAME="__DEFAULT";var Ts=class extends Ae{constructor(t,e=1){super(),this.isLight=!0,this.type="Light",this.color=new Ht(t),this.intensity=e}dispose(){}copy(t,e){return super.copy(t,e),this.color.copy(t.color),this.intensity=t.intensity,this}toJSON(t){let e=super.toJSON(t);return e.object.color=this.color.getHex(),e.object.intensity=this.intensity,this.groundColor!==void 0&&(e.object.groundColor=this.groundColor.getHex()),this.distance!==void 0&&(e.object.distance=this.distance),this.angle!==void 0&&(e.object.angle=this.angle),this.decay!==void 0&&(e.object.decay=this.decay),this.penumbra!==void 0&&(e.object.penumbra=this.penumbra),this.shadow!==void 0&&(e.object.shadow=this.shadow.toJSON()),this.target!==void 0&&(e.object.target=this.target.uuid),e}},ws=class extends Ts{constructor(t,e,n){super(t,n),this.isHemisphereLight=!0,this.type="HemisphereLight",this.position.copy(Ae.DEFAULT_UP),this.updateMatrix(),this.groundColor=new Ht(e)}copy(t,e){return super.copy(t,e),this.groundColor.copy(t.groundColor),this}},no=new ce,Pl=new N,Dl=new N,lo=class{constructor(t){this.camera=t,this.intensity=1,this.bias=0,this.normalBias=0,this.radius=1,this.blurSamples=8,this.mapSize=new Rt(512,512),this.mapType=an,this.map=null,this.mapPass=null,this.matrix=new ce,this.autoUpdate=!0,this.needsUpdate=!1,this._frustum=new ki,this._frameExtents=new Rt(1,1),this._viewportCount=1,this._viewports=[new oe(0,0,1,1)]}getViewportCount(){return this._viewportCount}getFrustum(){return this._frustum}updateMatrices(t){let e=this.camera,n=this.matrix;Pl.setFromMatrixPosition(t.matrixWorld),e.position.copy(Pl),Dl.setFromMatrixPosition(t.target.matrixWorld),e.lookAt(Dl),e.updateMatrixWorld(),no.multiplyMatrices(e.projectionMatrix,e.matrixWorldInverse),this._frustum.setFromProjectionMatrix(no,e.coordinateSystem,e.reversedDepth),e.reversedDepth?n.set(.5,0,0,.5,0,.5,0,.5,0,0,1,0,0,0,0,1):n.set(.5,0,0,.5,0,.5,0,.5,0,0,.5,.5,0,0,0,1),n.multiply(no)}getViewport(t){return this._viewports[t]}getFrameExtents(){return this._frameExtents}dispose(){this.map&&this.map.dispose(),this.mapPass&&this.mapPass.dispose()}copy(t){return this.camera=t.camera.clone(),this.intensity=t.intensity,this.bias=t.bias,this.radius=t.radius,this.autoUpdate=t.autoUpdate,this.needsUpdate=t.needsUpdate,this.normalBias=t.normalBias,this.blurSamples=t.blurSamples,this.mapSize.copy(t.mapSize),this}clone(){return new this.constructor().copy(this)}toJSON(){let t={};return this.intensity!==1&&(t.intensity=this.intensity),this.bias!==0&&(t.bias=this.bias),this.normalBias!==0&&(t.normalBias=this.normalBias),this.radius!==1&&(t.radius=this.radius),(this.mapSize.x!==512||this.mapSize.y!==512)&&(t.mapSize=this.mapSize.toArray()),t.camera=this.camera.toJSON(!1).object,delete t.camera.matrix,t}};var li=class extends ms{constructor(t=-1,e=1,n=1,s=-1,r=.1,a=2e3){super(),this.isOrthographicCamera=!0,this.type="OrthographicCamera",this.zoom=1,this.view=null,this.left=t,this.right=e,this.top=n,this.bottom=s,this.near=r,this.far=a,this.updateProjectionMatrix()}copy(t,e){return super.copy(t,e),this.left=t.left,this.right=t.right,this.top=t.top,this.bottom=t.bottom,this.near=t.near,this.far=t.far,this.zoom=t.zoom,this.view=t.view===null?null:Object.assign({},t.view),this}setViewOffset(t,e,n,s,r,a){this.view===null&&(this.view={enabled:!0,fullWidth:1,fullHeight:1,offsetX:0,offsetY:0,width:1,height:1}),this.view.enabled=!0,this.view.fullWidth=t,this.view.fullHeight=e,this.view.offsetX=n,this.view.offsetY=s,this.view.width=r,this.view.height=a,this.updateProjectionMatrix()}clearViewOffset(){this.view!==null&&(this.view.enabled=!1),this.updateProjectionMatrix()}updateProjectionMatrix(){let t=(this.right-this.left)/(2*this.zoom),e=(this.top-this.bottom)/(2*this.zoom),n=(this.right+this.left)/2,s=(this.top+this.bottom)/2,r=n-t,a=n+t,o=s+e,l=s-e;if(this.view!==null&&this.view.enabled){let c=(this.right-this.left)/this.view.fullWidth/this.zoom,u=(this.top-this.bottom)/this.view.fullHeight/this.zoom;r+=c*this.view.offsetX,a=r+c*this.view.width,o-=u*this.view.offsetY,l=o-u*this.view.height}this.projectionMatrix.makeOrthographic(r,a,o,l,this.near,this.far,this.coordinateSystem,this.reversedDepth),this.projectionMatrixInverse.copy(this.projectionMatrix).invert()}toJSON(t){let e=super.toJSON(t);return e.object.zoom=this.zoom,e.object.left=this.left,e.object.right=this.right,e.object.top=this.top,e.object.bottom=this.bottom,e.object.near=this.near,e.object.far=this.far,this.view!==null&&(e.object.view=Object.assign({},this.view)),e}},co=class extends lo{constructor(){super(new li(-5,5,5,-5,.5,500)),this.isDirectionalLightShadow=!0}},As=class extends Ts{constructor(t,e){super(t,e),this.isDirectionalLight=!0,this.type="DirectionalLight",this.position.copy(Ae.DEFAULT_UP),this.updateMatrix(),this.target=new Ae,this.shadow=new co}dispose(){this.shadow.dispose()}copy(t){return super.copy(t),this.target=t.target.clone(),this.shadow=t.shadow.clone(),this}};var Cr=class extends Ue{constructor(t=[]){super(),this.isArrayCamera=!0,this.isMultiViewCamera=!1,this.cameras=t}};var No="\\[\\]\\.:\\/",ou=new RegExp("["+No+"]","g"),Fo="[^"+No+"]",lu="[^"+No.replace("\\.","")+"]",cu=/((?:WC+[\/:])*)/.source.replace("WC",Fo),hu=/(WCOD+)?/.source.replace("WCOD",lu),uu=/(?:\.(WC+)(?:\[(.+)\])?)?/.source.replace("WC",Fo),du=/\.(WC+)(?:\[(.+)\])?/.source.replace("WC",Fo),fu=new RegExp("^"+cu+hu+uu+du+"$"),pu=["material","materials","bones","map"],ho=class{constructor(t,e,n){let s=n||ee.parseTrackName(e);this._targetGroup=t,this._bindings=t.subscribe_(e,s)}getValue(t,e){this.bind();let n=this._targetGroup.nCachedObjects_,s=this._bindings[n];s!==void 0&&s.getValue(t,e)}setValue(t,e){let n=this._bindings;for(let s=this._targetGroup.nCachedObjects_,r=n.length;s!==r;++s)n[s].setValue(t,e)}bind(){let t=this._bindings;for(let e=this._targetGroup.nCachedObjects_,n=t.length;e!==n;++e)t[e].bind()}unbind(){let t=this._bindings;for(let e=this._targetGroup.nCachedObjects_,n=t.length;e!==n;++e)t[e].unbind()}},ee=class i{constructor(t,e,n){this.path=e,this.parsedPath=n||i.parseTrackName(e),this.node=i.findNode(t,this.parsedPath.nodeName),this.rootNode=t,this.getValue=this._getValue_unbound,this.setValue=this._setValue_unbound}static create(t,e,n){return t&&t.isAnimationObjectGroup?new i.Composite(t,e,n):new i(t,e,n)}static sanitizeNodeName(t){return t.replace(/\s/g,"_").replace(ou,"")}static parseTrackName(t){let e=fu.exec(t);if(e===null)throw new Error("PropertyBinding: Cannot parse trackName: "+t);let n={nodeName:e[2],objectName:e[3],objectIndex:e[4],propertyName:e[5],propertyIndex:e[6]},s=n.nodeName&&n.nodeName.lastIndexOf(".");if(s!==void 0&&s!==-1){let r=n.nodeName.substring(s+1);pu.indexOf(r)!==-1&&(n.nodeName=n.nodeName.substring(0,s),n.objectName=r)}if(n.propertyName===null||n.propertyName.length===0)throw new Error("PropertyBinding: can not parse propertyName from trackName: "+t);return n}static findNode(t,e){if(e===void 0||e===""||e==="."||e===-1||e===t.name||e===t.uuid)return t;if(t.skeleton){let n=t.skeleton.getBoneByName(e);if(n!==void 0)return n}if(t.children){let n=function(r){for(let a=0;a<r.length;a++){let o=r[a];if(o.name===e||o.uuid===e)return o;let l=n(o.children);if(l)return l}return null},s=n(t.children);if(s)return s}return null}_getValue_unavailable(){}_setValue_unavailable(){}_getValue_direct(t,e){t[e]=this.targetObject[this.propertyName]}_getValue_array(t,e){let n=this.resolvedProperty;for(let s=0,r=n.length;s!==r;++s)t[e++]=n[s]}_getValue_arrayElement(t,e){t[e]=this.resolvedProperty[this.propertyIndex]}_getValue_toArray(t,e){this.resolvedProperty.toArray(t,e)}_setValue_direct(t,e){this.targetObject[this.propertyName]=t[e]}_setValue_direct_setNeedsUpdate(t,e){this.targetObject[this.propertyName]=t[e],this.targetObject.needsUpdate=!0}_setValue_direct_setMatrixWorldNeedsUpdate(t,e){this.targetObject[this.propertyName]=t[e],this.targetObject.matrixWorldNeedsUpdate=!0}_setValue_array(t,e){let n=this.resolvedProperty;for(let s=0,r=n.length;s!==r;++s)n[s]=t[e++]}_setValue_array_setNeedsUpdate(t,e){let n=this.resolvedProperty;for(let s=0,r=n.length;s!==r;++s)n[s]=t[e++];this.targetObject.needsUpdate=!0}_setValue_array_setMatrixWorldNeedsUpdate(t,e){let n=this.resolvedProperty;for(let s=0,r=n.length;s!==r;++s)n[s]=t[e++];this.targetObject.matrixWorldNeedsUpdate=!0}_setValue_arrayElement(t,e){this.resolvedProperty[this.propertyIndex]=t[e]}_setValue_arrayElement_setNeedsUpdate(t,e){this.resolvedProperty[this.propertyIndex]=t[e],this.targetObject.needsUpdate=!0}_setValue_arrayElement_setMatrixWorldNeedsUpdate(t,e){this.resolvedProperty[this.propertyIndex]=t[e],this.targetObject.matrixWorldNeedsUpdate=!0}_setValue_fromArray(t,e){this.resolvedProperty.fromArray(t,e)}_setValue_fromArray_setNeedsUpdate(t,e){this.resolvedProperty.fromArray(t,e),this.targetObject.needsUpdate=!0}_setValue_fromArray_setMatrixWorldNeedsUpdate(t,e){this.resolvedProperty.fromArray(t,e),this.targetObject.matrixWorldNeedsUpdate=!0}_getValue_unbound(t,e){this.bind(),this.getValue(t,e)}_setValue_unbound(t,e){this.bind(),this.setValue(t,e)}bind(){let t=this.node,e=this.parsedPath,n=e.objectName,s=e.propertyName,r=e.propertyIndex;if(t||(t=i.findNode(this.rootNode,e.nodeName),this.node=t),this.getValue=this._getValue_unavailable,this.setValue=this._setValue_unavailable,!t){console.warn("THREE.PropertyBinding: No target node found for track: "+this.path+".");return}if(n){let c=e.objectIndex;switch(n){case"materials":if(!t.material){console.error("THREE.PropertyBinding: Can not bind to material as node does not have a material.",this);return}if(!t.material.materials){console.error("THREE.PropertyBinding: Can not bind to material.materials as node.material does not have a materials array.",this);return}t=t.material.materials;break;case"bones":if(!t.skeleton){console.error("THREE.PropertyBinding: Can not bind to bones as node does not have a skeleton.",this);return}t=t.skeleton.bones;for(let u=0;u<t.length;u++)if(t[u].name===c){c=u;break}break;case"map":if("map"in t){t=t.map;break}if(!t.material){console.error("THREE.PropertyBinding: Can not bind to material as node does not have a material.",this);return}if(!t.material.map){console.error("THREE.PropertyBinding: Can not bind to material.map as node.material does not have a map.",this);return}t=t.material.map;break;default:if(t[n]===void 0){console.error("THREE.PropertyBinding: Can not bind to objectName of node undefined.",this);return}t=t[n]}if(c!==void 0){if(t[c]===void 0){console.error("THREE.PropertyBinding: Trying to bind to objectIndex of objectName, but is undefined.",this,t);return}t=t[c]}}let a=t[s];if(a===void 0){let c=e.nodeName;console.error("THREE.PropertyBinding: Trying to update property for track: "+c+"."+s+" but it wasn't found.",t);return}let o=this.Versioning.None;this.targetObject=t,t.isMaterial===!0?o=this.Versioning.NeedsUpdate:t.isObject3D===!0&&(o=this.Versioning.MatrixWorldNeedsUpdate);let l=this.BindingType.Direct;if(r!==void 0){if(s==="morphTargetInfluences"){if(!t.geometry){console.error("THREE.PropertyBinding: Can not bind to morphTargetInfluences because node does not have a geometry.",this);return}if(!t.geometry.morphAttributes){console.error("THREE.PropertyBinding: Can not bind to morphTargetInfluences because node does not have a geometry.morphAttributes.",this);return}t.morphTargetDictionary[r]!==void 0&&(r=t.morphTargetDictionary[r])}l=this.BindingType.ArrayElement,this.resolvedProperty=a,this.propertyIndex=r}else a.fromArray!==void 0&&a.toArray!==void 0?(l=this.BindingType.HasFromToArray,this.resolvedProperty=a):Array.isArray(a)?(l=this.BindingType.EntireArray,this.resolvedProperty=a):this.propertyName=s;this.getValue=this.GetterByBindingType[l],this.setValue=this.SetterByBindingTypeAndVersioning[l][o]}unbind(){this.node=null,this.getValue=this._getValue_unbound,this.setValue=this._setValue_unbound}};ee.Composite=ho;ee.prototype.BindingType={Direct:0,EntireArray:1,ArrayElement:2,HasFromToArray:3};ee.prototype.Versioning={None:0,NeedsUpdate:1,MatrixWorldNeedsUpdate:2};ee.prototype.GetterByBindingType=[ee.prototype._getValue_direct,ee.prototype._getValue_array,ee.prototype._getValue_arrayElement,ee.prototype._getValue_toArray];ee.prototype.SetterByBindingTypeAndVersioning=[[ee.prototype._setValue_direct,ee.prototype._setValue_direct_setNeedsUpdate,ee.prototype._setValue_direct_setMatrixWorldNeedsUpdate],[ee.prototype._setValue_array,ee.prototype._setValue_array_setNeedsUpdate,ee.prototype._setValue_array_setMatrixWorldNeedsUpdate],[ee.prototype._setValue_arrayElement,ee.prototype._setValue_arrayElement_setNeedsUpdate,ee.prototype._setValue_arrayElement_setMatrixWorldNeedsUpdate],[ee.prototype._setValue_fromArray,ee.prototype._setValue_fromArray_setNeedsUpdate,ee.prototype._setValue_fromArray_setMatrixWorldNeedsUpdate]];var ug=new Float32Array(1);var Ll=new ce,Cs=class{constructor(t,e,n=0,s=1/0){this.ray=new si(t,e),this.near=n,this.far=s,this.camera=null,this.layers=new Bi,this.params={Mesh:{},Line:{threshold:1},LOD:{},Points:{threshold:1},Sprite:{}}}set(t,e){this.ray.set(t,e)}setFromCamera(t,e){e.isPerspectiveCamera?(this.ray.origin.setFromMatrixPosition(e.matrixWorld),this.ray.direction.set(t.x,t.y,.5).unproject(e).sub(this.ray.origin).normalize(),this.camera=e):e.isOrthographicCamera?(this.ray.origin.set(t.x,t.y,(e.near+e.far)/(e.near-e.far)).unproject(e),this.ray.direction.set(0,0,-1).transformDirection(e.matrixWorld),this.camera=e):console.error("THREE.Raycaster: Unsupported camera type: "+e.type)}setFromXRController(t){return Ll.identity().extractRotation(t.matrixWorld),this.ray.origin.setFromMatrixPosition(t.matrixWorld),this.ray.direction.set(0,0,-1).applyMatrix4(Ll),this}intersectObject(t,e=!0,n=[]){return uo(t,this,n,e),n.sort(Ul),n}intersectObjects(t,e=!0,n=[]){for(let s=0,r=t.length;s<r;s++)uo(t[s],this,n,e);return n.sort(Ul),n}};function Ul(i,t){return i.distance-t.distance}function uo(i,t,e,n){let s=!0;if(i.layers.test(t.layers)&&i.raycast(t,e)===!1&&(s=!1),s===!0&&n===!0){let r=i.children;for(let a=0,o=r.length;a<o;a++)uo(r[a],t,e,!0)}}var Vi=class{constructor(t=1,e=0,n=0){this.radius=t,this.phi=e,this.theta=n}set(t,e,n){return this.radius=t,this.phi=e,this.theta=n,this}copy(t){return this.radius=t.radius,this.phi=t.phi,this.theta=t.theta,this}makeSafe(){return this.phi=zt(this.phi,1e-6,Math.PI-1e-6),this}setFromVector3(t){return this.setFromCartesianCoords(t.x,t.y,t.z)}setFromCartesianCoords(t,e,n){return this.radius=Math.sqrt(t*t+e*e+n*n),this.radius===0?(this.theta=0,this.phi=0):(this.theta=Math.atan2(t,n),this.phi=Math.acos(zt(e/this.radius,-1,1))),this}clone(){return new this.constructor().copy(this)}};var Rs=class extends un{constructor(t,e=null){super(),this.object=t,this.domElement=e,this.enabled=!0,this.state=-1,this.keys={},this.mouseButtons={LEFT:null,MIDDLE:null,RIGHT:null},this.touches={ONE:null,TWO:null}}connect(t){if(t===void 0){console.warn("THREE.Controls: connect() now requires an element.");return}this.domElement!==null&&this.disconnect(),this.domElement=t}disconnect(){}dispose(){}update(){}};function Oo(i,t,e,n){let s=mu(n);switch(e){case Eo:return i*t;case wo:return i*t/s.components*s.byteLength;case Wr:return i*t/s.components*s.byteLength;case Ao:return i*t*2/s.components*s.byteLength;case Xr:return i*t*2/s.components*s.byteLength;case To:return i*t*3/s.components*s.byteLength;case $e:return i*t*4/s.components*s.byteLength;case qr:return i*t*4/s.components*s.byteLength;case Ds:case Ls:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*8;case Us:case Ns:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*16;case Zr:case $r:return Math.max(i,16)*Math.max(t,8)/4;case Yr:case Jr:return Math.max(i,8)*Math.max(t,8)/2;case Kr:case jr:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*8;case Qr:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*16;case ta:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*16;case ea:return Math.floor((i+4)/5)*Math.floor((t+3)/4)*16;case na:return Math.floor((i+4)/5)*Math.floor((t+4)/5)*16;case ia:return Math.floor((i+5)/6)*Math.floor((t+4)/5)*16;case sa:return Math.floor((i+5)/6)*Math.floor((t+5)/6)*16;case ra:return Math.floor((i+7)/8)*Math.floor((t+4)/5)*16;case aa:return Math.floor((i+7)/8)*Math.floor((t+5)/6)*16;case oa:return Math.floor((i+7)/8)*Math.floor((t+7)/8)*16;case la:return Math.floor((i+9)/10)*Math.floor((t+4)/5)*16;case ca:return Math.floor((i+9)/10)*Math.floor((t+5)/6)*16;case ha:return Math.floor((i+9)/10)*Math.floor((t+7)/8)*16;case ua:return Math.floor((i+9)/10)*Math.floor((t+9)/10)*16;case da:return Math.floor((i+11)/12)*Math.floor((t+9)/10)*16;case fa:return Math.floor((i+11)/12)*Math.floor((t+11)/12)*16;case pa:case ma:case ga:return Math.ceil(i/4)*Math.ceil(t/4)*16;case _a:case xa:return Math.ceil(i/4)*Math.ceil(t/4)*8;case ya:case va:return Math.ceil(i/4)*Math.ceil(t/4)*16}throw new Error(`Unable to determine texture byte length for ${e} format.`)}function mu(i){switch(i){case an:case vo:return{byteLength:1,components:1};case Hi:case Mo:case Gi:return{byteLength:2,components:1};case Hr:case Gr:return{byteLength:2,components:4};case qn:case Vr:case gn:return{byteLength:4,components:1};case So:case bo:return{byteLength:4,components:3}}throw new Error(`Unknown texture type ${i}.`)}typeof __THREE_DEVTOOLS__<"u"&&__THREE_DEVTOOLS__.dispatchEvent(new CustomEvent("register",{detail:{revision:"180"}}));typeof window<"u"&&(window.__THREE__?console.warn("WARNING: Multiple instances of Three.js being imported."):window.__THREE__="180");function Zc(){let i=null,t=!1,e=null,n=null;function s(r,a){e(r,a),n=i.requestAnimationFrame(s)}return{start:function(){t!==!0&&e!==null&&(n=i.requestAnimationFrame(s),t=!0)},stop:function(){i.cancelAnimationFrame(n),t=!1},setAnimationLoop:function(r){e=r},setContext:function(r){i=r}}}function _u(i){let t=new WeakMap;function e(o,l){let c=o.array,u=o.usage,d=c.byteLength,f=i.createBuffer();i.bindBuffer(l,f),i.bufferData(l,c,u),o.onUploadCallback();let p;if(c instanceof Float32Array)p=i.FLOAT;else if(typeof Float16Array<"u"&&c instanceof Float16Array)p=i.HALF_FLOAT;else if(c instanceof Uint16Array)o.isFloat16BufferAttribute?p=i.HALF_FLOAT:p=i.UNSIGNED_SHORT;else if(c instanceof Int16Array)p=i.SHORT;else if(c instanceof Uint32Array)p=i.UNSIGNED_INT;else if(c instanceof Int32Array)p=i.INT;else if(c instanceof Int8Array)p=i.BYTE;else if(c instanceof Uint8Array)p=i.UNSIGNED_BYTE;else if(c instanceof Uint8ClampedArray)p=i.UNSIGNED_BYTE;else throw new Error("THREE.WebGLAttributes: Unsupported buffer data format: "+c);return{buffer:f,type:p,bytesPerElement:c.BYTES_PER_ELEMENT,version:o.version,size:d}}function n(o,l,c){let u=l.array,d=l.updateRanges;if(i.bindBuffer(c,o),d.length===0)i.bufferSubData(c,0,u);else{d.sort((p,_)=>p.start-_.start);let f=0;for(let p=1;p<d.length;p++){let _=d[f],v=d[p];v.start<=_.start+_.count+1?_.count=Math.max(_.count,v.start+v.count-_.start):(++f,d[f]=v)}d.length=f+1;for(let p=0,_=d.length;p<_;p++){let v=d[p];i.bufferSubData(c,v.start*u.BYTES_PER_ELEMENT,u,v.start,v.count)}l.clearUpdateRanges()}l.onUploadCallback()}function s(o){return o.isInterleavedBufferAttribute&&(o=o.data),t.get(o)}function r(o){o.isInterleavedBufferAttribute&&(o=o.data);let l=t.get(o);l&&(i.deleteBuffer(l.buffer),t.delete(o))}function a(o,l){if(o.isInterleavedBufferAttribute&&(o=o.data),o.isGLBufferAttribute){let u=t.get(o);(!u||u.version<o.version)&&t.set(o,{buffer:o.buffer,type:o.type,bytesPerElement:o.elementSize,version:o.version});return}let c=t.get(o);if(c===void 0)t.set(o,e(o,l));else if(c.version<o.version){if(c.size!==o.array.byteLength)throw new Error("THREE.WebGLAttributes: The size of the buffer attribute's array buffer does not match the original size. Resizing buffer attributes is not supported.");n(c.buffer,o,l),c.version=o.version}}return{get:s,remove:r,update:a}}var xu=`#ifdef USE_ALPHAHASH
	if ( diffuseColor.a < getAlphaHashThreshold( vPosition ) ) discard;
#endif`,yu=`#ifdef USE_ALPHAHASH
	const float ALPHA_HASH_SCALE = 0.05;
	float hash2D( vec2 value ) {
		return fract( 1.0e4 * sin( 17.0 * value.x + 0.1 * value.y ) * ( 0.1 + abs( sin( 13.0 * value.y + value.x ) ) ) );
	}
	float hash3D( vec3 value ) {
		return hash2D( vec2( hash2D( value.xy ), value.z ) );
	}
	float getAlphaHashThreshold( vec3 position ) {
		float maxDeriv = max(
			length( dFdx( position.xyz ) ),
			length( dFdy( position.xyz ) )
		);
		float pixScale = 1.0 / ( ALPHA_HASH_SCALE * maxDeriv );
		vec2 pixScales = vec2(
			exp2( floor( log2( pixScale ) ) ),
			exp2( ceil( log2( pixScale ) ) )
		);
		vec2 alpha = vec2(
			hash3D( floor( pixScales.x * position.xyz ) ),
			hash3D( floor( pixScales.y * position.xyz ) )
		);
		float lerpFactor = fract( log2( pixScale ) );
		float x = ( 1.0 - lerpFactor ) * alpha.x + lerpFactor * alpha.y;
		float a = min( lerpFactor, 1.0 - lerpFactor );
		vec3 cases = vec3(
			x * x / ( 2.0 * a * ( 1.0 - a ) ),
			( x - 0.5 * a ) / ( 1.0 - a ),
			1.0 - ( ( 1.0 - x ) * ( 1.0 - x ) / ( 2.0 * a * ( 1.0 - a ) ) )
		);
		float threshold = ( x < ( 1.0 - a ) )
			? ( ( x < a ) ? cases.x : cases.y )
			: cases.z;
		return clamp( threshold , 1.0e-6, 1.0 );
	}
#endif`,vu=`#ifdef USE_ALPHAMAP
	diffuseColor.a *= texture2D( alphaMap, vAlphaMapUv ).g;
#endif`,Mu=`#ifdef USE_ALPHAMAP
	uniform sampler2D alphaMap;
#endif`,Su=`#ifdef USE_ALPHATEST
	#ifdef ALPHA_TO_COVERAGE
	diffuseColor.a = smoothstep( alphaTest, alphaTest + fwidth( diffuseColor.a ), diffuseColor.a );
	if ( diffuseColor.a == 0.0 ) discard;
	#else
	if ( diffuseColor.a < alphaTest ) discard;
	#endif
#endif`,bu=`#ifdef USE_ALPHATEST
	uniform float alphaTest;
#endif`,Eu=`#ifdef USE_AOMAP
	float ambientOcclusion = ( texture2D( aoMap, vAoMapUv ).r - 1.0 ) * aoMapIntensity + 1.0;
	reflectedLight.indirectDiffuse *= ambientOcclusion;
	#if defined( USE_CLEARCOAT ) 
		clearcoatSpecularIndirect *= ambientOcclusion;
	#endif
	#if defined( USE_SHEEN ) 
		sheenSpecularIndirect *= ambientOcclusion;
	#endif
	#if defined( USE_ENVMAP ) && defined( STANDARD )
		float dotNV = saturate( dot( geometryNormal, geometryViewDir ) );
		reflectedLight.indirectSpecular *= computeSpecularOcclusion( dotNV, ambientOcclusion, material.roughness );
	#endif
#endif`,Tu=`#ifdef USE_AOMAP
	uniform sampler2D aoMap;
	uniform float aoMapIntensity;
#endif`,wu=`#ifdef USE_BATCHING
	#if ! defined( GL_ANGLE_multi_draw )
	#define gl_DrawID _gl_DrawID
	uniform int _gl_DrawID;
	#endif
	uniform highp sampler2D batchingTexture;
	uniform highp usampler2D batchingIdTexture;
	mat4 getBatchingMatrix( const in float i ) {
		int size = textureSize( batchingTexture, 0 ).x;
		int j = int( i ) * 4;
		int x = j % size;
		int y = j / size;
		vec4 v1 = texelFetch( batchingTexture, ivec2( x, y ), 0 );
		vec4 v2 = texelFetch( batchingTexture, ivec2( x + 1, y ), 0 );
		vec4 v3 = texelFetch( batchingTexture, ivec2( x + 2, y ), 0 );
		vec4 v4 = texelFetch( batchingTexture, ivec2( x + 3, y ), 0 );
		return mat4( v1, v2, v3, v4 );
	}
	float getIndirectIndex( const in int i ) {
		int size = textureSize( batchingIdTexture, 0 ).x;
		int x = i % size;
		int y = i / size;
		return float( texelFetch( batchingIdTexture, ivec2( x, y ), 0 ).r );
	}
#endif
#ifdef USE_BATCHING_COLOR
	uniform sampler2D batchingColorTexture;
	vec3 getBatchingColor( const in float i ) {
		int size = textureSize( batchingColorTexture, 0 ).x;
		int j = int( i );
		int x = j % size;
		int y = j / size;
		return texelFetch( batchingColorTexture, ivec2( x, y ), 0 ).rgb;
	}
#endif`,Au=`#ifdef USE_BATCHING
	mat4 batchingMatrix = getBatchingMatrix( getIndirectIndex( gl_DrawID ) );
#endif`,Cu=`vec3 transformed = vec3( position );
#ifdef USE_ALPHAHASH
	vPosition = vec3( position );
#endif`,Ru=`vec3 objectNormal = vec3( normal );
#ifdef USE_TANGENT
	vec3 objectTangent = vec3( tangent.xyz );
#endif`,Iu=`float G_BlinnPhong_Implicit( ) {
	return 0.25;
}
float D_BlinnPhong( const in float shininess, const in float dotNH ) {
	return RECIPROCAL_PI * ( shininess * 0.5 + 1.0 ) * pow( dotNH, shininess );
}
vec3 BRDF_BlinnPhong( const in vec3 lightDir, const in vec3 viewDir, const in vec3 normal, const in vec3 specularColor, const in float shininess ) {
	vec3 halfDir = normalize( lightDir + viewDir );
	float dotNH = saturate( dot( normal, halfDir ) );
	float dotVH = saturate( dot( viewDir, halfDir ) );
	vec3 F = F_Schlick( specularColor, 1.0, dotVH );
	float G = G_BlinnPhong_Implicit( );
	float D = D_BlinnPhong( shininess, dotNH );
	return F * ( G * D );
} // validated`,Pu=`#ifdef USE_IRIDESCENCE
	const mat3 XYZ_TO_REC709 = mat3(
		 3.2404542, -0.9692660,  0.0556434,
		-1.5371385,  1.8760108, -0.2040259,
		-0.4985314,  0.0415560,  1.0572252
	);
	vec3 Fresnel0ToIor( vec3 fresnel0 ) {
		vec3 sqrtF0 = sqrt( fresnel0 );
		return ( vec3( 1.0 ) + sqrtF0 ) / ( vec3( 1.0 ) - sqrtF0 );
	}
	vec3 IorToFresnel0( vec3 transmittedIor, float incidentIor ) {
		return pow2( ( transmittedIor - vec3( incidentIor ) ) / ( transmittedIor + vec3( incidentIor ) ) );
	}
	float IorToFresnel0( float transmittedIor, float incidentIor ) {
		return pow2( ( transmittedIor - incidentIor ) / ( transmittedIor + incidentIor ));
	}
	vec3 evalSensitivity( float OPD, vec3 shift ) {
		float phase = 2.0 * PI * OPD * 1.0e-9;
		vec3 val = vec3( 5.4856e-13, 4.4201e-13, 5.2481e-13 );
		vec3 pos = vec3( 1.6810e+06, 1.7953e+06, 2.2084e+06 );
		vec3 var = vec3( 4.3278e+09, 9.3046e+09, 6.6121e+09 );
		vec3 xyz = val * sqrt( 2.0 * PI * var ) * cos( pos * phase + shift ) * exp( - pow2( phase ) * var );
		xyz.x += 9.7470e-14 * sqrt( 2.0 * PI * 4.5282e+09 ) * cos( 2.2399e+06 * phase + shift[ 0 ] ) * exp( - 4.5282e+09 * pow2( phase ) );
		xyz /= 1.0685e-7;
		vec3 rgb = XYZ_TO_REC709 * xyz;
		return rgb;
	}
	vec3 evalIridescence( float outsideIOR, float eta2, float cosTheta1, float thinFilmThickness, vec3 baseF0 ) {
		vec3 I;
		float iridescenceIOR = mix( outsideIOR, eta2, smoothstep( 0.0, 0.03, thinFilmThickness ) );
		float sinTheta2Sq = pow2( outsideIOR / iridescenceIOR ) * ( 1.0 - pow2( cosTheta1 ) );
		float cosTheta2Sq = 1.0 - sinTheta2Sq;
		if ( cosTheta2Sq < 0.0 ) {
			return vec3( 1.0 );
		}
		float cosTheta2 = sqrt( cosTheta2Sq );
		float R0 = IorToFresnel0( iridescenceIOR, outsideIOR );
		float R12 = F_Schlick( R0, 1.0, cosTheta1 );
		float T121 = 1.0 - R12;
		float phi12 = 0.0;
		if ( iridescenceIOR < outsideIOR ) phi12 = PI;
		float phi21 = PI - phi12;
		vec3 baseIOR = Fresnel0ToIor( clamp( baseF0, 0.0, 0.9999 ) );		vec3 R1 = IorToFresnel0( baseIOR, iridescenceIOR );
		vec3 R23 = F_Schlick( R1, 1.0, cosTheta2 );
		vec3 phi23 = vec3( 0.0 );
		if ( baseIOR[ 0 ] < iridescenceIOR ) phi23[ 0 ] = PI;
		if ( baseIOR[ 1 ] < iridescenceIOR ) phi23[ 1 ] = PI;
		if ( baseIOR[ 2 ] < iridescenceIOR ) phi23[ 2 ] = PI;
		float OPD = 2.0 * iridescenceIOR * thinFilmThickness * cosTheta2;
		vec3 phi = vec3( phi21 ) + phi23;
		vec3 R123 = clamp( R12 * R23, 1e-5, 0.9999 );
		vec3 r123 = sqrt( R123 );
		vec3 Rs = pow2( T121 ) * R23 / ( vec3( 1.0 ) - R123 );
		vec3 C0 = R12 + Rs;
		I = C0;
		vec3 Cm = Rs - T121;
		for ( int m = 1; m <= 2; ++ m ) {
			Cm *= r123;
			vec3 Sm = 2.0 * evalSensitivity( float( m ) * OPD, float( m ) * phi );
			I += Cm * Sm;
		}
		return max( I, vec3( 0.0 ) );
	}
#endif`,Du=`#ifdef USE_BUMPMAP
	uniform sampler2D bumpMap;
	uniform float bumpScale;
	vec2 dHdxy_fwd() {
		vec2 dSTdx = dFdx( vBumpMapUv );
		vec2 dSTdy = dFdy( vBumpMapUv );
		float Hll = bumpScale * texture2D( bumpMap, vBumpMapUv ).x;
		float dBx = bumpScale * texture2D( bumpMap, vBumpMapUv + dSTdx ).x - Hll;
		float dBy = bumpScale * texture2D( bumpMap, vBumpMapUv + dSTdy ).x - Hll;
		return vec2( dBx, dBy );
	}
	vec3 perturbNormalArb( vec3 surf_pos, vec3 surf_norm, vec2 dHdxy, float faceDirection ) {
		vec3 vSigmaX = normalize( dFdx( surf_pos.xyz ) );
		vec3 vSigmaY = normalize( dFdy( surf_pos.xyz ) );
		vec3 vN = surf_norm;
		vec3 R1 = cross( vSigmaY, vN );
		vec3 R2 = cross( vN, vSigmaX );
		float fDet = dot( vSigmaX, R1 ) * faceDirection;
		vec3 vGrad = sign( fDet ) * ( dHdxy.x * R1 + dHdxy.y * R2 );
		return normalize( abs( fDet ) * surf_norm - vGrad );
	}
#endif`,Lu=`#if NUM_CLIPPING_PLANES > 0
	vec4 plane;
	#ifdef ALPHA_TO_COVERAGE
		float distanceToPlane, distanceGradient;
		float clipOpacity = 1.0;
		#pragma unroll_loop_start
		for ( int i = 0; i < UNION_CLIPPING_PLANES; i ++ ) {
			plane = clippingPlanes[ i ];
			distanceToPlane = - dot( vClipPosition, plane.xyz ) + plane.w;
			distanceGradient = fwidth( distanceToPlane ) / 2.0;
			clipOpacity *= smoothstep( - distanceGradient, distanceGradient, distanceToPlane );
			if ( clipOpacity == 0.0 ) discard;
		}
		#pragma unroll_loop_end
		#if UNION_CLIPPING_PLANES < NUM_CLIPPING_PLANES
			float unionClipOpacity = 1.0;
			#pragma unroll_loop_start
			for ( int i = UNION_CLIPPING_PLANES; i < NUM_CLIPPING_PLANES; i ++ ) {
				plane = clippingPlanes[ i ];
				distanceToPlane = - dot( vClipPosition, plane.xyz ) + plane.w;
				distanceGradient = fwidth( distanceToPlane ) / 2.0;
				unionClipOpacity *= 1.0 - smoothstep( - distanceGradient, distanceGradient, distanceToPlane );
			}
			#pragma unroll_loop_end
			clipOpacity *= 1.0 - unionClipOpacity;
		#endif
		diffuseColor.a *= clipOpacity;
		if ( diffuseColor.a == 0.0 ) discard;
	#else
		#pragma unroll_loop_start
		for ( int i = 0; i < UNION_CLIPPING_PLANES; i ++ ) {
			plane = clippingPlanes[ i ];
			if ( dot( vClipPosition, plane.xyz ) > plane.w ) discard;
		}
		#pragma unroll_loop_end
		#if UNION_CLIPPING_PLANES < NUM_CLIPPING_PLANES
			bool clipped = true;
			#pragma unroll_loop_start
			for ( int i = UNION_CLIPPING_PLANES; i < NUM_CLIPPING_PLANES; i ++ ) {
				plane = clippingPlanes[ i ];
				clipped = ( dot( vClipPosition, plane.xyz ) > plane.w ) && clipped;
			}
			#pragma unroll_loop_end
			if ( clipped ) discard;
		#endif
	#endif
#endif`,Uu=`#if NUM_CLIPPING_PLANES > 0
	varying vec3 vClipPosition;
	uniform vec4 clippingPlanes[ NUM_CLIPPING_PLANES ];
#endif`,Nu=`#if NUM_CLIPPING_PLANES > 0
	varying vec3 vClipPosition;
#endif`,Fu=`#if NUM_CLIPPING_PLANES > 0
	vClipPosition = - mvPosition.xyz;
#endif`,Ou=`#if defined( USE_COLOR_ALPHA )
	diffuseColor *= vColor;
#elif defined( USE_COLOR )
	diffuseColor.rgb *= vColor;
#endif`,Bu=`#if defined( USE_COLOR_ALPHA )
	varying vec4 vColor;
#elif defined( USE_COLOR )
	varying vec3 vColor;
#endif`,zu=`#if defined( USE_COLOR_ALPHA )
	varying vec4 vColor;
#elif defined( USE_COLOR ) || defined( USE_INSTANCING_COLOR ) || defined( USE_BATCHING_COLOR )
	varying vec3 vColor;
#endif`,ku=`#if defined( USE_COLOR_ALPHA )
	vColor = vec4( 1.0 );
#elif defined( USE_COLOR ) || defined( USE_INSTANCING_COLOR ) || defined( USE_BATCHING_COLOR )
	vColor = vec3( 1.0 );
#endif
#ifdef USE_COLOR
	vColor *= color;
#endif
#ifdef USE_INSTANCING_COLOR
	vColor.xyz *= instanceColor.xyz;
#endif
#ifdef USE_BATCHING_COLOR
	vec3 batchingColor = getBatchingColor( getIndirectIndex( gl_DrawID ) );
	vColor.xyz *= batchingColor.xyz;
#endif`,Vu=`#define PI 3.141592653589793
#define PI2 6.283185307179586
#define PI_HALF 1.5707963267948966
#define RECIPROCAL_PI 0.3183098861837907
#define RECIPROCAL_PI2 0.15915494309189535
#define EPSILON 1e-6
#ifndef saturate
#define saturate( a ) clamp( a, 0.0, 1.0 )
#endif
#define whiteComplement( a ) ( 1.0 - saturate( a ) )
float pow2( const in float x ) { return x*x; }
vec3 pow2( const in vec3 x ) { return x*x; }
float pow3( const in float x ) { return x*x*x; }
float pow4( const in float x ) { float x2 = x*x; return x2*x2; }
float max3( const in vec3 v ) { return max( max( v.x, v.y ), v.z ); }
float average( const in vec3 v ) { return dot( v, vec3( 0.3333333 ) ); }
highp float rand( const in vec2 uv ) {
	const highp float a = 12.9898, b = 78.233, c = 43758.5453;
	highp float dt = dot( uv.xy, vec2( a,b ) ), sn = mod( dt, PI );
	return fract( sin( sn ) * c );
}
#ifdef HIGH_PRECISION
	float precisionSafeLength( vec3 v ) { return length( v ); }
#else
	float precisionSafeLength( vec3 v ) {
		float maxComponent = max3( abs( v ) );
		return length( v / maxComponent ) * maxComponent;
	}
#endif
struct IncidentLight {
	vec3 color;
	vec3 direction;
	bool visible;
};
struct ReflectedLight {
	vec3 directDiffuse;
	vec3 directSpecular;
	vec3 indirectDiffuse;
	vec3 indirectSpecular;
};
#ifdef USE_ALPHAHASH
	varying vec3 vPosition;
#endif
vec3 transformDirection( in vec3 dir, in mat4 matrix ) {
	return normalize( ( matrix * vec4( dir, 0.0 ) ).xyz );
}
vec3 inverseTransformDirection( in vec3 dir, in mat4 matrix ) {
	return normalize( ( vec4( dir, 0.0 ) * matrix ).xyz );
}
mat3 transposeMat3( const in mat3 m ) {
	mat3 tmp;
	tmp[ 0 ] = vec3( m[ 0 ].x, m[ 1 ].x, m[ 2 ].x );
	tmp[ 1 ] = vec3( m[ 0 ].y, m[ 1 ].y, m[ 2 ].y );
	tmp[ 2 ] = vec3( m[ 0 ].z, m[ 1 ].z, m[ 2 ].z );
	return tmp;
}
bool isPerspectiveMatrix( mat4 m ) {
	return m[ 2 ][ 3 ] == - 1.0;
}
vec2 equirectUv( in vec3 dir ) {
	float u = atan( dir.z, dir.x ) * RECIPROCAL_PI2 + 0.5;
	float v = asin( clamp( dir.y, - 1.0, 1.0 ) ) * RECIPROCAL_PI + 0.5;
	return vec2( u, v );
}
vec3 BRDF_Lambert( const in vec3 diffuseColor ) {
	return RECIPROCAL_PI * diffuseColor;
}
vec3 F_Schlick( const in vec3 f0, const in float f90, const in float dotVH ) {
	float fresnel = exp2( ( - 5.55473 * dotVH - 6.98316 ) * dotVH );
	return f0 * ( 1.0 - fresnel ) + ( f90 * fresnel );
}
float F_Schlick( const in float f0, const in float f90, const in float dotVH ) {
	float fresnel = exp2( ( - 5.55473 * dotVH - 6.98316 ) * dotVH );
	return f0 * ( 1.0 - fresnel ) + ( f90 * fresnel );
} // validated`,Hu=`#ifdef ENVMAP_TYPE_CUBE_UV
	#define cubeUV_minMipLevel 4.0
	#define cubeUV_minTileSize 16.0
	float getFace( vec3 direction ) {
		vec3 absDirection = abs( direction );
		float face = - 1.0;
		if ( absDirection.x > absDirection.z ) {
			if ( absDirection.x > absDirection.y )
				face = direction.x > 0.0 ? 0.0 : 3.0;
			else
				face = direction.y > 0.0 ? 1.0 : 4.0;
		} else {
			if ( absDirection.z > absDirection.y )
				face = direction.z > 0.0 ? 2.0 : 5.0;
			else
				face = direction.y > 0.0 ? 1.0 : 4.0;
		}
		return face;
	}
	vec2 getUV( vec3 direction, float face ) {
		vec2 uv;
		if ( face == 0.0 ) {
			uv = vec2( direction.z, direction.y ) / abs( direction.x );
		} else if ( face == 1.0 ) {
			uv = vec2( - direction.x, - direction.z ) / abs( direction.y );
		} else if ( face == 2.0 ) {
			uv = vec2( - direction.x, direction.y ) / abs( direction.z );
		} else if ( face == 3.0 ) {
			uv = vec2( - direction.z, direction.y ) / abs( direction.x );
		} else if ( face == 4.0 ) {
			uv = vec2( - direction.x, direction.z ) / abs( direction.y );
		} else {
			uv = vec2( direction.x, direction.y ) / abs( direction.z );
		}
		return 0.5 * ( uv + 1.0 );
	}
	vec3 bilinearCubeUV( sampler2D envMap, vec3 direction, float mipInt ) {
		float face = getFace( direction );
		float filterInt = max( cubeUV_minMipLevel - mipInt, 0.0 );
		mipInt = max( mipInt, cubeUV_minMipLevel );
		float faceSize = exp2( mipInt );
		highp vec2 uv = getUV( direction, face ) * ( faceSize - 2.0 ) + 1.0;
		if ( face > 2.0 ) {
			uv.y += faceSize;
			face -= 3.0;
		}
		uv.x += face * faceSize;
		uv.x += filterInt * 3.0 * cubeUV_minTileSize;
		uv.y += 4.0 * ( exp2( CUBEUV_MAX_MIP ) - faceSize );
		uv.x *= CUBEUV_TEXEL_WIDTH;
		uv.y *= CUBEUV_TEXEL_HEIGHT;
		#ifdef texture2DGradEXT
			return texture2DGradEXT( envMap, uv, vec2( 0.0 ), vec2( 0.0 ) ).rgb;
		#else
			return texture2D( envMap, uv ).rgb;
		#endif
	}
	#define cubeUV_r0 1.0
	#define cubeUV_m0 - 2.0
	#define cubeUV_r1 0.8
	#define cubeUV_m1 - 1.0
	#define cubeUV_r4 0.4
	#define cubeUV_m4 2.0
	#define cubeUV_r5 0.305
	#define cubeUV_m5 3.0
	#define cubeUV_r6 0.21
	#define cubeUV_m6 4.0
	float roughnessToMip( float roughness ) {
		float mip = 0.0;
		if ( roughness >= cubeUV_r1 ) {
			mip = ( cubeUV_r0 - roughness ) * ( cubeUV_m1 - cubeUV_m0 ) / ( cubeUV_r0 - cubeUV_r1 ) + cubeUV_m0;
		} else if ( roughness >= cubeUV_r4 ) {
			mip = ( cubeUV_r1 - roughness ) * ( cubeUV_m4 - cubeUV_m1 ) / ( cubeUV_r1 - cubeUV_r4 ) + cubeUV_m1;
		} else if ( roughness >= cubeUV_r5 ) {
			mip = ( cubeUV_r4 - roughness ) * ( cubeUV_m5 - cubeUV_m4 ) / ( cubeUV_r4 - cubeUV_r5 ) + cubeUV_m4;
		} else if ( roughness >= cubeUV_r6 ) {
			mip = ( cubeUV_r5 - roughness ) * ( cubeUV_m6 - cubeUV_m5 ) / ( cubeUV_r5 - cubeUV_r6 ) + cubeUV_m5;
		} else {
			mip = - 2.0 * log2( 1.16 * roughness );		}
		return mip;
	}
	vec4 textureCubeUV( sampler2D envMap, vec3 sampleDir, float roughness ) {
		float mip = clamp( roughnessToMip( roughness ), cubeUV_m0, CUBEUV_MAX_MIP );
		float mipF = fract( mip );
		float mipInt = floor( mip );
		vec3 color0 = bilinearCubeUV( envMap, sampleDir, mipInt );
		if ( mipF == 0.0 ) {
			return vec4( color0, 1.0 );
		} else {
			vec3 color1 = bilinearCubeUV( envMap, sampleDir, mipInt + 1.0 );
			return vec4( mix( color0, color1, mipF ), 1.0 );
		}
	}
#endif`,Gu=`vec3 transformedNormal = objectNormal;
#ifdef USE_TANGENT
	vec3 transformedTangent = objectTangent;
#endif
#ifdef USE_BATCHING
	mat3 bm = mat3( batchingMatrix );
	transformedNormal /= vec3( dot( bm[ 0 ], bm[ 0 ] ), dot( bm[ 1 ], bm[ 1 ] ), dot( bm[ 2 ], bm[ 2 ] ) );
	transformedNormal = bm * transformedNormal;
	#ifdef USE_TANGENT
		transformedTangent = bm * transformedTangent;
	#endif
#endif
#ifdef USE_INSTANCING
	mat3 im = mat3( instanceMatrix );
	transformedNormal /= vec3( dot( im[ 0 ], im[ 0 ] ), dot( im[ 1 ], im[ 1 ] ), dot( im[ 2 ], im[ 2 ] ) );
	transformedNormal = im * transformedNormal;
	#ifdef USE_TANGENT
		transformedTangent = im * transformedTangent;
	#endif
#endif
transformedNormal = normalMatrix * transformedNormal;
#ifdef FLIP_SIDED
	transformedNormal = - transformedNormal;
#endif
#ifdef USE_TANGENT
	transformedTangent = ( modelViewMatrix * vec4( transformedTangent, 0.0 ) ).xyz;
	#ifdef FLIP_SIDED
		transformedTangent = - transformedTangent;
	#endif
#endif`,Wu=`#ifdef USE_DISPLACEMENTMAP
	uniform sampler2D displacementMap;
	uniform float displacementScale;
	uniform float displacementBias;
#endif`,Xu=`#ifdef USE_DISPLACEMENTMAP
	transformed += normalize( objectNormal ) * ( texture2D( displacementMap, vDisplacementMapUv ).x * displacementScale + displacementBias );
#endif`,qu=`#ifdef USE_EMISSIVEMAP
	vec4 emissiveColor = texture2D( emissiveMap, vEmissiveMapUv );
	#ifdef DECODE_VIDEO_TEXTURE_EMISSIVE
		emissiveColor = sRGBTransferEOTF( emissiveColor );
	#endif
	totalEmissiveRadiance *= emissiveColor.rgb;
#endif`,Yu=`#ifdef USE_EMISSIVEMAP
	uniform sampler2D emissiveMap;
#endif`,Zu="gl_FragColor = linearToOutputTexel( gl_FragColor );",Ju=`vec4 LinearTransferOETF( in vec4 value ) {
	return value;
}
vec4 sRGBTransferEOTF( in vec4 value ) {
	return vec4( mix( pow( value.rgb * 0.9478672986 + vec3( 0.0521327014 ), vec3( 2.4 ) ), value.rgb * 0.0773993808, vec3( lessThanEqual( value.rgb, vec3( 0.04045 ) ) ) ), value.a );
}
vec4 sRGBTransferOETF( in vec4 value ) {
	return vec4( mix( pow( value.rgb, vec3( 0.41666 ) ) * 1.055 - vec3( 0.055 ), value.rgb * 12.92, vec3( lessThanEqual( value.rgb, vec3( 0.0031308 ) ) ) ), value.a );
}`,$u=`#ifdef USE_ENVMAP
	#ifdef ENV_WORLDPOS
		vec3 cameraToFrag;
		if ( isOrthographic ) {
			cameraToFrag = normalize( vec3( - viewMatrix[ 0 ][ 2 ], - viewMatrix[ 1 ][ 2 ], - viewMatrix[ 2 ][ 2 ] ) );
		} else {
			cameraToFrag = normalize( vWorldPosition - cameraPosition );
		}
		vec3 worldNormal = inverseTransformDirection( normal, viewMatrix );
		#ifdef ENVMAP_MODE_REFLECTION
			vec3 reflectVec = reflect( cameraToFrag, worldNormal );
		#else
			vec3 reflectVec = refract( cameraToFrag, worldNormal, refractionRatio );
		#endif
	#else
		vec3 reflectVec = vReflect;
	#endif
	#ifdef ENVMAP_TYPE_CUBE
		vec4 envColor = textureCube( envMap, envMapRotation * vec3( flipEnvMap * reflectVec.x, reflectVec.yz ) );
	#else
		vec4 envColor = vec4( 0.0 );
	#endif
	#ifdef ENVMAP_BLENDING_MULTIPLY
		outgoingLight = mix( outgoingLight, outgoingLight * envColor.xyz, specularStrength * reflectivity );
	#elif defined( ENVMAP_BLENDING_MIX )
		outgoingLight = mix( outgoingLight, envColor.xyz, specularStrength * reflectivity );
	#elif defined( ENVMAP_BLENDING_ADD )
		outgoingLight += envColor.xyz * specularStrength * reflectivity;
	#endif
#endif`,Ku=`#ifdef USE_ENVMAP
	uniform float envMapIntensity;
	uniform float flipEnvMap;
	uniform mat3 envMapRotation;
	#ifdef ENVMAP_TYPE_CUBE
		uniform samplerCube envMap;
	#else
		uniform sampler2D envMap;
	#endif
	
#endif`,ju=`#ifdef USE_ENVMAP
	uniform float reflectivity;
	#if defined( USE_BUMPMAP ) || defined( USE_NORMALMAP ) || defined( PHONG ) || defined( LAMBERT )
		#define ENV_WORLDPOS
	#endif
	#ifdef ENV_WORLDPOS
		varying vec3 vWorldPosition;
		uniform float refractionRatio;
	#else
		varying vec3 vReflect;
	#endif
#endif`,Qu=`#ifdef USE_ENVMAP
	#if defined( USE_BUMPMAP ) || defined( USE_NORMALMAP ) || defined( PHONG ) || defined( LAMBERT )
		#define ENV_WORLDPOS
	#endif
	#ifdef ENV_WORLDPOS
		
		varying vec3 vWorldPosition;
	#else
		varying vec3 vReflect;
		uniform float refractionRatio;
	#endif
#endif`,td=`#ifdef USE_ENVMAP
	#ifdef ENV_WORLDPOS
		vWorldPosition = worldPosition.xyz;
	#else
		vec3 cameraToVertex;
		if ( isOrthographic ) {
			cameraToVertex = normalize( vec3( - viewMatrix[ 0 ][ 2 ], - viewMatrix[ 1 ][ 2 ], - viewMatrix[ 2 ][ 2 ] ) );
		} else {
			cameraToVertex = normalize( worldPosition.xyz - cameraPosition );
		}
		vec3 worldNormal = inverseTransformDirection( transformedNormal, viewMatrix );
		#ifdef ENVMAP_MODE_REFLECTION
			vReflect = reflect( cameraToVertex, worldNormal );
		#else
			vReflect = refract( cameraToVertex, worldNormal, refractionRatio );
		#endif
	#endif
#endif`,ed=`#ifdef USE_FOG
	vFogDepth = - mvPosition.z;
#endif`,nd=`#ifdef USE_FOG
	varying float vFogDepth;
#endif`,id=`#ifdef USE_FOG
	#ifdef FOG_EXP2
		float fogFactor = 1.0 - exp( - fogDensity * fogDensity * vFogDepth * vFogDepth );
	#else
		float fogFactor = smoothstep( fogNear, fogFar, vFogDepth );
	#endif
	gl_FragColor.rgb = mix( gl_FragColor.rgb, fogColor, fogFactor );
#endif`,sd=`#ifdef USE_FOG
	uniform vec3 fogColor;
	varying float vFogDepth;
	#ifdef FOG_EXP2
		uniform float fogDensity;
	#else
		uniform float fogNear;
		uniform float fogFar;
	#endif
#endif`,rd=`#ifdef USE_GRADIENTMAP
	uniform sampler2D gradientMap;
#endif
vec3 getGradientIrradiance( vec3 normal, vec3 lightDirection ) {
	float dotNL = dot( normal, lightDirection );
	vec2 coord = vec2( dotNL * 0.5 + 0.5, 0.0 );
	#ifdef USE_GRADIENTMAP
		return vec3( texture2D( gradientMap, coord ).r );
	#else
		vec2 fw = fwidth( coord ) * 0.5;
		return mix( vec3( 0.7 ), vec3( 1.0 ), smoothstep( 0.7 - fw.x, 0.7 + fw.x, coord.x ) );
	#endif
}`,ad=`#ifdef USE_LIGHTMAP
	uniform sampler2D lightMap;
	uniform float lightMapIntensity;
#endif`,od=`LambertMaterial material;
material.diffuseColor = diffuseColor.rgb;
material.specularStrength = specularStrength;`,ld=`varying vec3 vViewPosition;
struct LambertMaterial {
	vec3 diffuseColor;
	float specularStrength;
};
void RE_Direct_Lambert( const in IncidentLight directLight, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in LambertMaterial material, inout ReflectedLight reflectedLight ) {
	float dotNL = saturate( dot( geometryNormal, directLight.direction ) );
	vec3 irradiance = dotNL * directLight.color;
	reflectedLight.directDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
void RE_IndirectDiffuse_Lambert( const in vec3 irradiance, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in LambertMaterial material, inout ReflectedLight reflectedLight ) {
	reflectedLight.indirectDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
#define RE_Direct				RE_Direct_Lambert
#define RE_IndirectDiffuse		RE_IndirectDiffuse_Lambert`,cd=`uniform bool receiveShadow;
uniform vec3 ambientLightColor;
#if defined( USE_LIGHT_PROBES )
	uniform vec3 lightProbe[ 9 ];
#endif
vec3 shGetIrradianceAt( in vec3 normal, in vec3 shCoefficients[ 9 ] ) {
	float x = normal.x, y = normal.y, z = normal.z;
	vec3 result = shCoefficients[ 0 ] * 0.886227;
	result += shCoefficients[ 1 ] * 2.0 * 0.511664 * y;
	result += shCoefficients[ 2 ] * 2.0 * 0.511664 * z;
	result += shCoefficients[ 3 ] * 2.0 * 0.511664 * x;
	result += shCoefficients[ 4 ] * 2.0 * 0.429043 * x * y;
	result += shCoefficients[ 5 ] * 2.0 * 0.429043 * y * z;
	result += shCoefficients[ 6 ] * ( 0.743125 * z * z - 0.247708 );
	result += shCoefficients[ 7 ] * 2.0 * 0.429043 * x * z;
	result += shCoefficients[ 8 ] * 0.429043 * ( x * x - y * y );
	return result;
}
vec3 getLightProbeIrradiance( const in vec3 lightProbe[ 9 ], const in vec3 normal ) {
	vec3 worldNormal = inverseTransformDirection( normal, viewMatrix );
	vec3 irradiance = shGetIrradianceAt( worldNormal, lightProbe );
	return irradiance;
}
vec3 getAmbientLightIrradiance( const in vec3 ambientLightColor ) {
	vec3 irradiance = ambientLightColor;
	return irradiance;
}
float getDistanceAttenuation( const in float lightDistance, const in float cutoffDistance, const in float decayExponent ) {
	float distanceFalloff = 1.0 / max( pow( lightDistance, decayExponent ), 0.01 );
	if ( cutoffDistance > 0.0 ) {
		distanceFalloff *= pow2( saturate( 1.0 - pow4( lightDistance / cutoffDistance ) ) );
	}
	return distanceFalloff;
}
float getSpotAttenuation( const in float coneCosine, const in float penumbraCosine, const in float angleCosine ) {
	return smoothstep( coneCosine, penumbraCosine, angleCosine );
}
#if NUM_DIR_LIGHTS > 0
	struct DirectionalLight {
		vec3 direction;
		vec3 color;
	};
	uniform DirectionalLight directionalLights[ NUM_DIR_LIGHTS ];
	void getDirectionalLightInfo( const in DirectionalLight directionalLight, out IncidentLight light ) {
		light.color = directionalLight.color;
		light.direction = directionalLight.direction;
		light.visible = true;
	}
#endif
#if NUM_POINT_LIGHTS > 0
	struct PointLight {
		vec3 position;
		vec3 color;
		float distance;
		float decay;
	};
	uniform PointLight pointLights[ NUM_POINT_LIGHTS ];
	void getPointLightInfo( const in PointLight pointLight, const in vec3 geometryPosition, out IncidentLight light ) {
		vec3 lVector = pointLight.position - geometryPosition;
		light.direction = normalize( lVector );
		float lightDistance = length( lVector );
		light.color = pointLight.color;
		light.color *= getDistanceAttenuation( lightDistance, pointLight.distance, pointLight.decay );
		light.visible = ( light.color != vec3( 0.0 ) );
	}
#endif
#if NUM_SPOT_LIGHTS > 0
	struct SpotLight {
		vec3 position;
		vec3 direction;
		vec3 color;
		float distance;
		float decay;
		float coneCos;
		float penumbraCos;
	};
	uniform SpotLight spotLights[ NUM_SPOT_LIGHTS ];
	void getSpotLightInfo( const in SpotLight spotLight, const in vec3 geometryPosition, out IncidentLight light ) {
		vec3 lVector = spotLight.position - geometryPosition;
		light.direction = normalize( lVector );
		float angleCos = dot( light.direction, spotLight.direction );
		float spotAttenuation = getSpotAttenuation( spotLight.coneCos, spotLight.penumbraCos, angleCos );
		if ( spotAttenuation > 0.0 ) {
			float lightDistance = length( lVector );
			light.color = spotLight.color * spotAttenuation;
			light.color *= getDistanceAttenuation( lightDistance, spotLight.distance, spotLight.decay );
			light.visible = ( light.color != vec3( 0.0 ) );
		} else {
			light.color = vec3( 0.0 );
			light.visible = false;
		}
	}
#endif
#if NUM_RECT_AREA_LIGHTS > 0
	struct RectAreaLight {
		vec3 color;
		vec3 position;
		vec3 halfWidth;
		vec3 halfHeight;
	};
	uniform sampler2D ltc_1;	uniform sampler2D ltc_2;
	uniform RectAreaLight rectAreaLights[ NUM_RECT_AREA_LIGHTS ];
#endif
#if NUM_HEMI_LIGHTS > 0
	struct HemisphereLight {
		vec3 direction;
		vec3 skyColor;
		vec3 groundColor;
	};
	uniform HemisphereLight hemisphereLights[ NUM_HEMI_LIGHTS ];
	vec3 getHemisphereLightIrradiance( const in HemisphereLight hemiLight, const in vec3 normal ) {
		float dotNL = dot( normal, hemiLight.direction );
		float hemiDiffuseWeight = 0.5 * dotNL + 0.5;
		vec3 irradiance = mix( hemiLight.groundColor, hemiLight.skyColor, hemiDiffuseWeight );
		return irradiance;
	}
#endif`,hd=`#ifdef USE_ENVMAP
	vec3 getIBLIrradiance( const in vec3 normal ) {
		#ifdef ENVMAP_TYPE_CUBE_UV
			vec3 worldNormal = inverseTransformDirection( normal, viewMatrix );
			vec4 envMapColor = textureCubeUV( envMap, envMapRotation * worldNormal, 1.0 );
			return PI * envMapColor.rgb * envMapIntensity;
		#else
			return vec3( 0.0 );
		#endif
	}
	vec3 getIBLRadiance( const in vec3 viewDir, const in vec3 normal, const in float roughness ) {
		#ifdef ENVMAP_TYPE_CUBE_UV
			vec3 reflectVec = reflect( - viewDir, normal );
			reflectVec = normalize( mix( reflectVec, normal, roughness * roughness) );
			reflectVec = inverseTransformDirection( reflectVec, viewMatrix );
			vec4 envMapColor = textureCubeUV( envMap, envMapRotation * reflectVec, roughness );
			return envMapColor.rgb * envMapIntensity;
		#else
			return vec3( 0.0 );
		#endif
	}
	#ifdef USE_ANISOTROPY
		vec3 getIBLAnisotropyRadiance( const in vec3 viewDir, const in vec3 normal, const in float roughness, const in vec3 bitangent, const in float anisotropy ) {
			#ifdef ENVMAP_TYPE_CUBE_UV
				vec3 bentNormal = cross( bitangent, viewDir );
				bentNormal = normalize( cross( bentNormal, bitangent ) );
				bentNormal = normalize( mix( bentNormal, normal, pow2( pow2( 1.0 - anisotropy * ( 1.0 - roughness ) ) ) ) );
				return getIBLRadiance( viewDir, bentNormal, roughness );
			#else
				return vec3( 0.0 );
			#endif
		}
	#endif
#endif`,ud=`ToonMaterial material;
material.diffuseColor = diffuseColor.rgb;`,dd=`varying vec3 vViewPosition;
struct ToonMaterial {
	vec3 diffuseColor;
};
void RE_Direct_Toon( const in IncidentLight directLight, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in ToonMaterial material, inout ReflectedLight reflectedLight ) {
	vec3 irradiance = getGradientIrradiance( geometryNormal, directLight.direction ) * directLight.color;
	reflectedLight.directDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
void RE_IndirectDiffuse_Toon( const in vec3 irradiance, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in ToonMaterial material, inout ReflectedLight reflectedLight ) {
	reflectedLight.indirectDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
#define RE_Direct				RE_Direct_Toon
#define RE_IndirectDiffuse		RE_IndirectDiffuse_Toon`,fd=`BlinnPhongMaterial material;
material.diffuseColor = diffuseColor.rgb;
material.specularColor = specular;
material.specularShininess = shininess;
material.specularStrength = specularStrength;`,pd=`varying vec3 vViewPosition;
struct BlinnPhongMaterial {
	vec3 diffuseColor;
	vec3 specularColor;
	float specularShininess;
	float specularStrength;
};
void RE_Direct_BlinnPhong( const in IncidentLight directLight, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in BlinnPhongMaterial material, inout ReflectedLight reflectedLight ) {
	float dotNL = saturate( dot( geometryNormal, directLight.direction ) );
	vec3 irradiance = dotNL * directLight.color;
	reflectedLight.directDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
	reflectedLight.directSpecular += irradiance * BRDF_BlinnPhong( directLight.direction, geometryViewDir, geometryNormal, material.specularColor, material.specularShininess ) * material.specularStrength;
}
void RE_IndirectDiffuse_BlinnPhong( const in vec3 irradiance, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in BlinnPhongMaterial material, inout ReflectedLight reflectedLight ) {
	reflectedLight.indirectDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
#define RE_Direct				RE_Direct_BlinnPhong
#define RE_IndirectDiffuse		RE_IndirectDiffuse_BlinnPhong`,md=`PhysicalMaterial material;
material.diffuseColor = diffuseColor.rgb * ( 1.0 - metalnessFactor );
vec3 dxy = max( abs( dFdx( nonPerturbedNormal ) ), abs( dFdy( nonPerturbedNormal ) ) );
float geometryRoughness = max( max( dxy.x, dxy.y ), dxy.z );
material.roughness = max( roughnessFactor, 0.0525 );material.roughness += geometryRoughness;
material.roughness = min( material.roughness, 1.0 );
#ifdef IOR
	material.ior = ior;
	#ifdef USE_SPECULAR
		float specularIntensityFactor = specularIntensity;
		vec3 specularColorFactor = specularColor;
		#ifdef USE_SPECULAR_COLORMAP
			specularColorFactor *= texture2D( specularColorMap, vSpecularColorMapUv ).rgb;
		#endif
		#ifdef USE_SPECULAR_INTENSITYMAP
			specularIntensityFactor *= texture2D( specularIntensityMap, vSpecularIntensityMapUv ).a;
		#endif
		material.specularF90 = mix( specularIntensityFactor, 1.0, metalnessFactor );
	#else
		float specularIntensityFactor = 1.0;
		vec3 specularColorFactor = vec3( 1.0 );
		material.specularF90 = 1.0;
	#endif
	material.specularColor = mix( min( pow2( ( material.ior - 1.0 ) / ( material.ior + 1.0 ) ) * specularColorFactor, vec3( 1.0 ) ) * specularIntensityFactor, diffuseColor.rgb, metalnessFactor );
#else
	material.specularColor = mix( vec3( 0.04 ), diffuseColor.rgb, metalnessFactor );
	material.specularF90 = 1.0;
#endif
#ifdef USE_CLEARCOAT
	material.clearcoat = clearcoat;
	material.clearcoatRoughness = clearcoatRoughness;
	material.clearcoatF0 = vec3( 0.04 );
	material.clearcoatF90 = 1.0;
	#ifdef USE_CLEARCOATMAP
		material.clearcoat *= texture2D( clearcoatMap, vClearcoatMapUv ).x;
	#endif
	#ifdef USE_CLEARCOAT_ROUGHNESSMAP
		material.clearcoatRoughness *= texture2D( clearcoatRoughnessMap, vClearcoatRoughnessMapUv ).y;
	#endif
	material.clearcoat = saturate( material.clearcoat );	material.clearcoatRoughness = max( material.clearcoatRoughness, 0.0525 );
	material.clearcoatRoughness += geometryRoughness;
	material.clearcoatRoughness = min( material.clearcoatRoughness, 1.0 );
#endif
#ifdef USE_DISPERSION
	material.dispersion = dispersion;
#endif
#ifdef USE_IRIDESCENCE
	material.iridescence = iridescence;
	material.iridescenceIOR = iridescenceIOR;
	#ifdef USE_IRIDESCENCEMAP
		material.iridescence *= texture2D( iridescenceMap, vIridescenceMapUv ).r;
	#endif
	#ifdef USE_IRIDESCENCE_THICKNESSMAP
		material.iridescenceThickness = (iridescenceThicknessMaximum - iridescenceThicknessMinimum) * texture2D( iridescenceThicknessMap, vIridescenceThicknessMapUv ).g + iridescenceThicknessMinimum;
	#else
		material.iridescenceThickness = iridescenceThicknessMaximum;
	#endif
#endif
#ifdef USE_SHEEN
	material.sheenColor = sheenColor;
	#ifdef USE_SHEEN_COLORMAP
		material.sheenColor *= texture2D( sheenColorMap, vSheenColorMapUv ).rgb;
	#endif
	material.sheenRoughness = clamp( sheenRoughness, 0.07, 1.0 );
	#ifdef USE_SHEEN_ROUGHNESSMAP
		material.sheenRoughness *= texture2D( sheenRoughnessMap, vSheenRoughnessMapUv ).a;
	#endif
#endif
#ifdef USE_ANISOTROPY
	#ifdef USE_ANISOTROPYMAP
		mat2 anisotropyMat = mat2( anisotropyVector.x, anisotropyVector.y, - anisotropyVector.y, anisotropyVector.x );
		vec3 anisotropyPolar = texture2D( anisotropyMap, vAnisotropyMapUv ).rgb;
		vec2 anisotropyV = anisotropyMat * normalize( 2.0 * anisotropyPolar.rg - vec2( 1.0 ) ) * anisotropyPolar.b;
	#else
		vec2 anisotropyV = anisotropyVector;
	#endif
	material.anisotropy = length( anisotropyV );
	if( material.anisotropy == 0.0 ) {
		anisotropyV = vec2( 1.0, 0.0 );
	} else {
		anisotropyV /= material.anisotropy;
		material.anisotropy = saturate( material.anisotropy );
	}
	material.alphaT = mix( pow2( material.roughness ), 1.0, pow2( material.anisotropy ) );
	material.anisotropyT = tbn[ 0 ] * anisotropyV.x + tbn[ 1 ] * anisotropyV.y;
	material.anisotropyB = tbn[ 1 ] * anisotropyV.x - tbn[ 0 ] * anisotropyV.y;
#endif`,gd=`struct PhysicalMaterial {
	vec3 diffuseColor;
	float roughness;
	vec3 specularColor;
	float specularF90;
	float dispersion;
	#ifdef USE_CLEARCOAT
		float clearcoat;
		float clearcoatRoughness;
		vec3 clearcoatF0;
		float clearcoatF90;
	#endif
	#ifdef USE_IRIDESCENCE
		float iridescence;
		float iridescenceIOR;
		float iridescenceThickness;
		vec3 iridescenceFresnel;
		vec3 iridescenceF0;
	#endif
	#ifdef USE_SHEEN
		vec3 sheenColor;
		float sheenRoughness;
	#endif
	#ifdef IOR
		float ior;
	#endif
	#ifdef USE_TRANSMISSION
		float transmission;
		float transmissionAlpha;
		float thickness;
		float attenuationDistance;
		vec3 attenuationColor;
	#endif
	#ifdef USE_ANISOTROPY
		float anisotropy;
		float alphaT;
		vec3 anisotropyT;
		vec3 anisotropyB;
	#endif
};
vec3 clearcoatSpecularDirect = vec3( 0.0 );
vec3 clearcoatSpecularIndirect = vec3( 0.0 );
vec3 sheenSpecularDirect = vec3( 0.0 );
vec3 sheenSpecularIndirect = vec3(0.0 );
vec3 Schlick_to_F0( const in vec3 f, const in float f90, const in float dotVH ) {
    float x = clamp( 1.0 - dotVH, 0.0, 1.0 );
    float x2 = x * x;
    float x5 = clamp( x * x2 * x2, 0.0, 0.9999 );
    return ( f - vec3( f90 ) * x5 ) / ( 1.0 - x5 );
}
float V_GGX_SmithCorrelated( const in float alpha, const in float dotNL, const in float dotNV ) {
	float a2 = pow2( alpha );
	float gv = dotNL * sqrt( a2 + ( 1.0 - a2 ) * pow2( dotNV ) );
	float gl = dotNV * sqrt( a2 + ( 1.0 - a2 ) * pow2( dotNL ) );
	return 0.5 / max( gv + gl, EPSILON );
}
float D_GGX( const in float alpha, const in float dotNH ) {
	float a2 = pow2( alpha );
	float denom = pow2( dotNH ) * ( a2 - 1.0 ) + 1.0;
	return RECIPROCAL_PI * a2 / pow2( denom );
}
#ifdef USE_ANISOTROPY
	float V_GGX_SmithCorrelated_Anisotropic( const in float alphaT, const in float alphaB, const in float dotTV, const in float dotBV, const in float dotTL, const in float dotBL, const in float dotNV, const in float dotNL ) {
		float gv = dotNL * length( vec3( alphaT * dotTV, alphaB * dotBV, dotNV ) );
		float gl = dotNV * length( vec3( alphaT * dotTL, alphaB * dotBL, dotNL ) );
		float v = 0.5 / ( gv + gl );
		return saturate(v);
	}
	float D_GGX_Anisotropic( const in float alphaT, const in float alphaB, const in float dotNH, const in float dotTH, const in float dotBH ) {
		float a2 = alphaT * alphaB;
		highp vec3 v = vec3( alphaB * dotTH, alphaT * dotBH, a2 * dotNH );
		highp float v2 = dot( v, v );
		float w2 = a2 / v2;
		return RECIPROCAL_PI * a2 * pow2 ( w2 );
	}
#endif
#ifdef USE_CLEARCOAT
	vec3 BRDF_GGX_Clearcoat( const in vec3 lightDir, const in vec3 viewDir, const in vec3 normal, const in PhysicalMaterial material) {
		vec3 f0 = material.clearcoatF0;
		float f90 = material.clearcoatF90;
		float roughness = material.clearcoatRoughness;
		float alpha = pow2( roughness );
		vec3 halfDir = normalize( lightDir + viewDir );
		float dotNL = saturate( dot( normal, lightDir ) );
		float dotNV = saturate( dot( normal, viewDir ) );
		float dotNH = saturate( dot( normal, halfDir ) );
		float dotVH = saturate( dot( viewDir, halfDir ) );
		vec3 F = F_Schlick( f0, f90, dotVH );
		float V = V_GGX_SmithCorrelated( alpha, dotNL, dotNV );
		float D = D_GGX( alpha, dotNH );
		return F * ( V * D );
	}
#endif
vec3 BRDF_GGX( const in vec3 lightDir, const in vec3 viewDir, const in vec3 normal, const in PhysicalMaterial material ) {
	vec3 f0 = material.specularColor;
	float f90 = material.specularF90;
	float roughness = material.roughness;
	float alpha = pow2( roughness );
	vec3 halfDir = normalize( lightDir + viewDir );
	float dotNL = saturate( dot( normal, lightDir ) );
	float dotNV = saturate( dot( normal, viewDir ) );
	float dotNH = saturate( dot( normal, halfDir ) );
	float dotVH = saturate( dot( viewDir, halfDir ) );
	vec3 F = F_Schlick( f0, f90, dotVH );
	#ifdef USE_IRIDESCENCE
		F = mix( F, material.iridescenceFresnel, material.iridescence );
	#endif
	#ifdef USE_ANISOTROPY
		float dotTL = dot( material.anisotropyT, lightDir );
		float dotTV = dot( material.anisotropyT, viewDir );
		float dotTH = dot( material.anisotropyT, halfDir );
		float dotBL = dot( material.anisotropyB, lightDir );
		float dotBV = dot( material.anisotropyB, viewDir );
		float dotBH = dot( material.anisotropyB, halfDir );
		float V = V_GGX_SmithCorrelated_Anisotropic( material.alphaT, alpha, dotTV, dotBV, dotTL, dotBL, dotNV, dotNL );
		float D = D_GGX_Anisotropic( material.alphaT, alpha, dotNH, dotTH, dotBH );
	#else
		float V = V_GGX_SmithCorrelated( alpha, dotNL, dotNV );
		float D = D_GGX( alpha, dotNH );
	#endif
	return F * ( V * D );
}
vec2 LTC_Uv( const in vec3 N, const in vec3 V, const in float roughness ) {
	const float LUT_SIZE = 64.0;
	const float LUT_SCALE = ( LUT_SIZE - 1.0 ) / LUT_SIZE;
	const float LUT_BIAS = 0.5 / LUT_SIZE;
	float dotNV = saturate( dot( N, V ) );
	vec2 uv = vec2( roughness, sqrt( 1.0 - dotNV ) );
	uv = uv * LUT_SCALE + LUT_BIAS;
	return uv;
}
float LTC_ClippedSphereFormFactor( const in vec3 f ) {
	float l = length( f );
	return max( ( l * l + f.z ) / ( l + 1.0 ), 0.0 );
}
vec3 LTC_EdgeVectorFormFactor( const in vec3 v1, const in vec3 v2 ) {
	float x = dot( v1, v2 );
	float y = abs( x );
	float a = 0.8543985 + ( 0.4965155 + 0.0145206 * y ) * y;
	float b = 3.4175940 + ( 4.1616724 + y ) * y;
	float v = a / b;
	float theta_sintheta = ( x > 0.0 ) ? v : 0.5 * inversesqrt( max( 1.0 - x * x, 1e-7 ) ) - v;
	return cross( v1, v2 ) * theta_sintheta;
}
vec3 LTC_Evaluate( const in vec3 N, const in vec3 V, const in vec3 P, const in mat3 mInv, const in vec3 rectCoords[ 4 ] ) {
	vec3 v1 = rectCoords[ 1 ] - rectCoords[ 0 ];
	vec3 v2 = rectCoords[ 3 ] - rectCoords[ 0 ];
	vec3 lightNormal = cross( v1, v2 );
	if( dot( lightNormal, P - rectCoords[ 0 ] ) < 0.0 ) return vec3( 0.0 );
	vec3 T1, T2;
	T1 = normalize( V - N * dot( V, N ) );
	T2 = - cross( N, T1 );
	mat3 mat = mInv * transposeMat3( mat3( T1, T2, N ) );
	vec3 coords[ 4 ];
	coords[ 0 ] = mat * ( rectCoords[ 0 ] - P );
	coords[ 1 ] = mat * ( rectCoords[ 1 ] - P );
	coords[ 2 ] = mat * ( rectCoords[ 2 ] - P );
	coords[ 3 ] = mat * ( rectCoords[ 3 ] - P );
	coords[ 0 ] = normalize( coords[ 0 ] );
	coords[ 1 ] = normalize( coords[ 1 ] );
	coords[ 2 ] = normalize( coords[ 2 ] );
	coords[ 3 ] = normalize( coords[ 3 ] );
	vec3 vectorFormFactor = vec3( 0.0 );
	vectorFormFactor += LTC_EdgeVectorFormFactor( coords[ 0 ], coords[ 1 ] );
	vectorFormFactor += LTC_EdgeVectorFormFactor( coords[ 1 ], coords[ 2 ] );
	vectorFormFactor += LTC_EdgeVectorFormFactor( coords[ 2 ], coords[ 3 ] );
	vectorFormFactor += LTC_EdgeVectorFormFactor( coords[ 3 ], coords[ 0 ] );
	float result = LTC_ClippedSphereFormFactor( vectorFormFactor );
	return vec3( result );
}
#if defined( USE_SHEEN )
float D_Charlie( float roughness, float dotNH ) {
	float alpha = pow2( roughness );
	float invAlpha = 1.0 / alpha;
	float cos2h = dotNH * dotNH;
	float sin2h = max( 1.0 - cos2h, 0.0078125 );
	return ( 2.0 + invAlpha ) * pow( sin2h, invAlpha * 0.5 ) / ( 2.0 * PI );
}
float V_Neubelt( float dotNV, float dotNL ) {
	return saturate( 1.0 / ( 4.0 * ( dotNL + dotNV - dotNL * dotNV ) ) );
}
vec3 BRDF_Sheen( const in vec3 lightDir, const in vec3 viewDir, const in vec3 normal, vec3 sheenColor, const in float sheenRoughness ) {
	vec3 halfDir = normalize( lightDir + viewDir );
	float dotNL = saturate( dot( normal, lightDir ) );
	float dotNV = saturate( dot( normal, viewDir ) );
	float dotNH = saturate( dot( normal, halfDir ) );
	float D = D_Charlie( sheenRoughness, dotNH );
	float V = V_Neubelt( dotNV, dotNL );
	return sheenColor * ( D * V );
}
#endif
float IBLSheenBRDF( const in vec3 normal, const in vec3 viewDir, const in float roughness ) {
	float dotNV = saturate( dot( normal, viewDir ) );
	float r2 = roughness * roughness;
	float a = roughness < 0.25 ? -339.2 * r2 + 161.4 * roughness - 25.9 : -8.48 * r2 + 14.3 * roughness - 9.95;
	float b = roughness < 0.25 ? 44.0 * r2 - 23.7 * roughness + 3.26 : 1.97 * r2 - 3.27 * roughness + 0.72;
	float DG = exp( a * dotNV + b ) + ( roughness < 0.25 ? 0.0 : 0.1 * ( roughness - 0.25 ) );
	return saturate( DG * RECIPROCAL_PI );
}
vec2 DFGApprox( const in vec3 normal, const in vec3 viewDir, const in float roughness ) {
	float dotNV = saturate( dot( normal, viewDir ) );
	const vec4 c0 = vec4( - 1, - 0.0275, - 0.572, 0.022 );
	const vec4 c1 = vec4( 1, 0.0425, 1.04, - 0.04 );
	vec4 r = roughness * c0 + c1;
	float a004 = min( r.x * r.x, exp2( - 9.28 * dotNV ) ) * r.x + r.y;
	vec2 fab = vec2( - 1.04, 1.04 ) * a004 + r.zw;
	return fab;
}
vec3 EnvironmentBRDF( const in vec3 normal, const in vec3 viewDir, const in vec3 specularColor, const in float specularF90, const in float roughness ) {
	vec2 fab = DFGApprox( normal, viewDir, roughness );
	return specularColor * fab.x + specularF90 * fab.y;
}
#ifdef USE_IRIDESCENCE
void computeMultiscatteringIridescence( const in vec3 normal, const in vec3 viewDir, const in vec3 specularColor, const in float specularF90, const in float iridescence, const in vec3 iridescenceF0, const in float roughness, inout vec3 singleScatter, inout vec3 multiScatter ) {
#else
void computeMultiscattering( const in vec3 normal, const in vec3 viewDir, const in vec3 specularColor, const in float specularF90, const in float roughness, inout vec3 singleScatter, inout vec3 multiScatter ) {
#endif
	vec2 fab = DFGApprox( normal, viewDir, roughness );
	#ifdef USE_IRIDESCENCE
		vec3 Fr = mix( specularColor, iridescenceF0, iridescence );
	#else
		vec3 Fr = specularColor;
	#endif
	vec3 FssEss = Fr * fab.x + specularF90 * fab.y;
	float Ess = fab.x + fab.y;
	float Ems = 1.0 - Ess;
	vec3 Favg = Fr + ( 1.0 - Fr ) * 0.047619;	vec3 Fms = FssEss * Favg / ( 1.0 - Ems * Favg );
	singleScatter += FssEss;
	multiScatter += Fms * Ems;
}
#if NUM_RECT_AREA_LIGHTS > 0
	void RE_Direct_RectArea_Physical( const in RectAreaLight rectAreaLight, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in PhysicalMaterial material, inout ReflectedLight reflectedLight ) {
		vec3 normal = geometryNormal;
		vec3 viewDir = geometryViewDir;
		vec3 position = geometryPosition;
		vec3 lightPos = rectAreaLight.position;
		vec3 halfWidth = rectAreaLight.halfWidth;
		vec3 halfHeight = rectAreaLight.halfHeight;
		vec3 lightColor = rectAreaLight.color;
		float roughness = material.roughness;
		vec3 rectCoords[ 4 ];
		rectCoords[ 0 ] = lightPos + halfWidth - halfHeight;		rectCoords[ 1 ] = lightPos - halfWidth - halfHeight;
		rectCoords[ 2 ] = lightPos - halfWidth + halfHeight;
		rectCoords[ 3 ] = lightPos + halfWidth + halfHeight;
		vec2 uv = LTC_Uv( normal, viewDir, roughness );
		vec4 t1 = texture2D( ltc_1, uv );
		vec4 t2 = texture2D( ltc_2, uv );
		mat3 mInv = mat3(
			vec3( t1.x, 0, t1.y ),
			vec3(    0, 1,    0 ),
			vec3( t1.z, 0, t1.w )
		);
		vec3 fresnel = ( material.specularColor * t2.x + ( vec3( 1.0 ) - material.specularColor ) * t2.y );
		reflectedLight.directSpecular += lightColor * fresnel * LTC_Evaluate( normal, viewDir, position, mInv, rectCoords );
		reflectedLight.directDiffuse += lightColor * material.diffuseColor * LTC_Evaluate( normal, viewDir, position, mat3( 1.0 ), rectCoords );
	}
#endif
void RE_Direct_Physical( const in IncidentLight directLight, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in PhysicalMaterial material, inout ReflectedLight reflectedLight ) {
	float dotNL = saturate( dot( geometryNormal, directLight.direction ) );
	vec3 irradiance = dotNL * directLight.color;
	#ifdef USE_CLEARCOAT
		float dotNLcc = saturate( dot( geometryClearcoatNormal, directLight.direction ) );
		vec3 ccIrradiance = dotNLcc * directLight.color;
		clearcoatSpecularDirect += ccIrradiance * BRDF_GGX_Clearcoat( directLight.direction, geometryViewDir, geometryClearcoatNormal, material );
	#endif
	#ifdef USE_SHEEN
		sheenSpecularDirect += irradiance * BRDF_Sheen( directLight.direction, geometryViewDir, geometryNormal, material.sheenColor, material.sheenRoughness );
	#endif
	reflectedLight.directSpecular += irradiance * BRDF_GGX( directLight.direction, geometryViewDir, geometryNormal, material );
	reflectedLight.directDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
void RE_IndirectDiffuse_Physical( const in vec3 irradiance, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in PhysicalMaterial material, inout ReflectedLight reflectedLight ) {
	reflectedLight.indirectDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
void RE_IndirectSpecular_Physical( const in vec3 radiance, const in vec3 irradiance, const in vec3 clearcoatRadiance, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in PhysicalMaterial material, inout ReflectedLight reflectedLight) {
	#ifdef USE_CLEARCOAT
		clearcoatSpecularIndirect += clearcoatRadiance * EnvironmentBRDF( geometryClearcoatNormal, geometryViewDir, material.clearcoatF0, material.clearcoatF90, material.clearcoatRoughness );
	#endif
	#ifdef USE_SHEEN
		sheenSpecularIndirect += irradiance * material.sheenColor * IBLSheenBRDF( geometryNormal, geometryViewDir, material.sheenRoughness );
	#endif
	vec3 singleScattering = vec3( 0.0 );
	vec3 multiScattering = vec3( 0.0 );
	vec3 cosineWeightedIrradiance = irradiance * RECIPROCAL_PI;
	#ifdef USE_IRIDESCENCE
		computeMultiscatteringIridescence( geometryNormal, geometryViewDir, material.specularColor, material.specularF90, material.iridescence, material.iridescenceFresnel, material.roughness, singleScattering, multiScattering );
	#else
		computeMultiscattering( geometryNormal, geometryViewDir, material.specularColor, material.specularF90, material.roughness, singleScattering, multiScattering );
	#endif
	vec3 totalScattering = singleScattering + multiScattering;
	vec3 diffuse = material.diffuseColor * ( 1.0 - max( max( totalScattering.r, totalScattering.g ), totalScattering.b ) );
	reflectedLight.indirectSpecular += radiance * singleScattering;
	reflectedLight.indirectSpecular += multiScattering * cosineWeightedIrradiance;
	reflectedLight.indirectDiffuse += diffuse * cosineWeightedIrradiance;
}
#define RE_Direct				RE_Direct_Physical
#define RE_Direct_RectArea		RE_Direct_RectArea_Physical
#define RE_IndirectDiffuse		RE_IndirectDiffuse_Physical
#define RE_IndirectSpecular		RE_IndirectSpecular_Physical
float computeSpecularOcclusion( const in float dotNV, const in float ambientOcclusion, const in float roughness ) {
	return saturate( pow( dotNV + ambientOcclusion, exp2( - 16.0 * roughness - 1.0 ) ) - 1.0 + ambientOcclusion );
}`,_d=`
vec3 geometryPosition = - vViewPosition;
vec3 geometryNormal = normal;
vec3 geometryViewDir = ( isOrthographic ) ? vec3( 0, 0, 1 ) : normalize( vViewPosition );
vec3 geometryClearcoatNormal = vec3( 0.0 );
#ifdef USE_CLEARCOAT
	geometryClearcoatNormal = clearcoatNormal;
#endif
#ifdef USE_IRIDESCENCE
	float dotNVi = saturate( dot( normal, geometryViewDir ) );
	if ( material.iridescenceThickness == 0.0 ) {
		material.iridescence = 0.0;
	} else {
		material.iridescence = saturate( material.iridescence );
	}
	if ( material.iridescence > 0.0 ) {
		material.iridescenceFresnel = evalIridescence( 1.0, material.iridescenceIOR, dotNVi, material.iridescenceThickness, material.specularColor );
		material.iridescenceF0 = Schlick_to_F0( material.iridescenceFresnel, 1.0, dotNVi );
	}
#endif
IncidentLight directLight;
#if ( NUM_POINT_LIGHTS > 0 ) && defined( RE_Direct )
	PointLight pointLight;
	#if defined( USE_SHADOWMAP ) && NUM_POINT_LIGHT_SHADOWS > 0
	PointLightShadow pointLightShadow;
	#endif
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_POINT_LIGHTS; i ++ ) {
		pointLight = pointLights[ i ];
		getPointLightInfo( pointLight, geometryPosition, directLight );
		#if defined( USE_SHADOWMAP ) && ( UNROLLED_LOOP_INDEX < NUM_POINT_LIGHT_SHADOWS )
		pointLightShadow = pointLightShadows[ i ];
		directLight.color *= ( directLight.visible && receiveShadow ) ? getPointShadow( pointShadowMap[ i ], pointLightShadow.shadowMapSize, pointLightShadow.shadowIntensity, pointLightShadow.shadowBias, pointLightShadow.shadowRadius, vPointShadowCoord[ i ], pointLightShadow.shadowCameraNear, pointLightShadow.shadowCameraFar ) : 1.0;
		#endif
		RE_Direct( directLight, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
	}
	#pragma unroll_loop_end
#endif
#if ( NUM_SPOT_LIGHTS > 0 ) && defined( RE_Direct )
	SpotLight spotLight;
	vec4 spotColor;
	vec3 spotLightCoord;
	bool inSpotLightMap;
	#if defined( USE_SHADOWMAP ) && NUM_SPOT_LIGHT_SHADOWS > 0
	SpotLightShadow spotLightShadow;
	#endif
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_SPOT_LIGHTS; i ++ ) {
		spotLight = spotLights[ i ];
		getSpotLightInfo( spotLight, geometryPosition, directLight );
		#if ( UNROLLED_LOOP_INDEX < NUM_SPOT_LIGHT_SHADOWS_WITH_MAPS )
		#define SPOT_LIGHT_MAP_INDEX UNROLLED_LOOP_INDEX
		#elif ( UNROLLED_LOOP_INDEX < NUM_SPOT_LIGHT_SHADOWS )
		#define SPOT_LIGHT_MAP_INDEX NUM_SPOT_LIGHT_MAPS
		#else
		#define SPOT_LIGHT_MAP_INDEX ( UNROLLED_LOOP_INDEX - NUM_SPOT_LIGHT_SHADOWS + NUM_SPOT_LIGHT_SHADOWS_WITH_MAPS )
		#endif
		#if ( SPOT_LIGHT_MAP_INDEX < NUM_SPOT_LIGHT_MAPS )
			spotLightCoord = vSpotLightCoord[ i ].xyz / vSpotLightCoord[ i ].w;
			inSpotLightMap = all( lessThan( abs( spotLightCoord * 2. - 1. ), vec3( 1.0 ) ) );
			spotColor = texture2D( spotLightMap[ SPOT_LIGHT_MAP_INDEX ], spotLightCoord.xy );
			directLight.color = inSpotLightMap ? directLight.color * spotColor.rgb : directLight.color;
		#endif
		#undef SPOT_LIGHT_MAP_INDEX
		#if defined( USE_SHADOWMAP ) && ( UNROLLED_LOOP_INDEX < NUM_SPOT_LIGHT_SHADOWS )
		spotLightShadow = spotLightShadows[ i ];
		directLight.color *= ( directLight.visible && receiveShadow ) ? getShadow( spotShadowMap[ i ], spotLightShadow.shadowMapSize, spotLightShadow.shadowIntensity, spotLightShadow.shadowBias, spotLightShadow.shadowRadius, vSpotLightCoord[ i ] ) : 1.0;
		#endif
		RE_Direct( directLight, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
	}
	#pragma unroll_loop_end
#endif
#if ( NUM_DIR_LIGHTS > 0 ) && defined( RE_Direct )
	DirectionalLight directionalLight;
	#if defined( USE_SHADOWMAP ) && NUM_DIR_LIGHT_SHADOWS > 0
	DirectionalLightShadow directionalLightShadow;
	#endif
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_DIR_LIGHTS; i ++ ) {
		directionalLight = directionalLights[ i ];
		getDirectionalLightInfo( directionalLight, directLight );
		#if defined( USE_SHADOWMAP ) && ( UNROLLED_LOOP_INDEX < NUM_DIR_LIGHT_SHADOWS )
		directionalLightShadow = directionalLightShadows[ i ];
		directLight.color *= ( directLight.visible && receiveShadow ) ? getShadow( directionalShadowMap[ i ], directionalLightShadow.shadowMapSize, directionalLightShadow.shadowIntensity, directionalLightShadow.shadowBias, directionalLightShadow.shadowRadius, vDirectionalShadowCoord[ i ] ) : 1.0;
		#endif
		RE_Direct( directLight, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
	}
	#pragma unroll_loop_end
#endif
#if ( NUM_RECT_AREA_LIGHTS > 0 ) && defined( RE_Direct_RectArea )
	RectAreaLight rectAreaLight;
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_RECT_AREA_LIGHTS; i ++ ) {
		rectAreaLight = rectAreaLights[ i ];
		RE_Direct_RectArea( rectAreaLight, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
	}
	#pragma unroll_loop_end
#endif
#if defined( RE_IndirectDiffuse )
	vec3 iblIrradiance = vec3( 0.0 );
	vec3 irradiance = getAmbientLightIrradiance( ambientLightColor );
	#if defined( USE_LIGHT_PROBES )
		irradiance += getLightProbeIrradiance( lightProbe, geometryNormal );
	#endif
	#if ( NUM_HEMI_LIGHTS > 0 )
		#pragma unroll_loop_start
		for ( int i = 0; i < NUM_HEMI_LIGHTS; i ++ ) {
			irradiance += getHemisphereLightIrradiance( hemisphereLights[ i ], geometryNormal );
		}
		#pragma unroll_loop_end
	#endif
#endif
#if defined( RE_IndirectSpecular )
	vec3 radiance = vec3( 0.0 );
	vec3 clearcoatRadiance = vec3( 0.0 );
#endif`,xd=`#if defined( RE_IndirectDiffuse )
	#ifdef USE_LIGHTMAP
		vec4 lightMapTexel = texture2D( lightMap, vLightMapUv );
		vec3 lightMapIrradiance = lightMapTexel.rgb * lightMapIntensity;
		irradiance += lightMapIrradiance;
	#endif
	#if defined( USE_ENVMAP ) && defined( STANDARD ) && defined( ENVMAP_TYPE_CUBE_UV )
		iblIrradiance += getIBLIrradiance( geometryNormal );
	#endif
#endif
#if defined( USE_ENVMAP ) && defined( RE_IndirectSpecular )
	#ifdef USE_ANISOTROPY
		radiance += getIBLAnisotropyRadiance( geometryViewDir, geometryNormal, material.roughness, material.anisotropyB, material.anisotropy );
	#else
		radiance += getIBLRadiance( geometryViewDir, geometryNormal, material.roughness );
	#endif
	#ifdef USE_CLEARCOAT
		clearcoatRadiance += getIBLRadiance( geometryViewDir, geometryClearcoatNormal, material.clearcoatRoughness );
	#endif
#endif`,yd=`#if defined( RE_IndirectDiffuse )
	RE_IndirectDiffuse( irradiance, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
#endif
#if defined( RE_IndirectSpecular )
	RE_IndirectSpecular( radiance, iblIrradiance, clearcoatRadiance, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
#endif`,vd=`#if defined( USE_LOGARITHMIC_DEPTH_BUFFER )
	gl_FragDepth = vIsPerspective == 0.0 ? gl_FragCoord.z : log2( vFragDepth ) * logDepthBufFC * 0.5;
#endif`,Md=`#if defined( USE_LOGARITHMIC_DEPTH_BUFFER )
	uniform float logDepthBufFC;
	varying float vFragDepth;
	varying float vIsPerspective;
#endif`,Sd=`#ifdef USE_LOGARITHMIC_DEPTH_BUFFER
	varying float vFragDepth;
	varying float vIsPerspective;
#endif`,bd=`#ifdef USE_LOGARITHMIC_DEPTH_BUFFER
	vFragDepth = 1.0 + gl_Position.w;
	vIsPerspective = float( isPerspectiveMatrix( projectionMatrix ) );
#endif`,Ed=`#ifdef USE_MAP
	vec4 sampledDiffuseColor = texture2D( map, vMapUv );
	#ifdef DECODE_VIDEO_TEXTURE
		sampledDiffuseColor = sRGBTransferEOTF( sampledDiffuseColor );
	#endif
	diffuseColor *= sampledDiffuseColor;
#endif`,Td=`#ifdef USE_MAP
	uniform sampler2D map;
#endif`,wd=`#if defined( USE_MAP ) || defined( USE_ALPHAMAP )
	#if defined( USE_POINTS_UV )
		vec2 uv = vUv;
	#else
		vec2 uv = ( uvTransform * vec3( gl_PointCoord.x, 1.0 - gl_PointCoord.y, 1 ) ).xy;
	#endif
#endif
#ifdef USE_MAP
	diffuseColor *= texture2D( map, uv );
#endif
#ifdef USE_ALPHAMAP
	diffuseColor.a *= texture2D( alphaMap, uv ).g;
#endif`,Ad=`#if defined( USE_POINTS_UV )
	varying vec2 vUv;
#else
	#if defined( USE_MAP ) || defined( USE_ALPHAMAP )
		uniform mat3 uvTransform;
	#endif
#endif
#ifdef USE_MAP
	uniform sampler2D map;
#endif
#ifdef USE_ALPHAMAP
	uniform sampler2D alphaMap;
#endif`,Cd=`float metalnessFactor = metalness;
#ifdef USE_METALNESSMAP
	vec4 texelMetalness = texture2D( metalnessMap, vMetalnessMapUv );
	metalnessFactor *= texelMetalness.b;
#endif`,Rd=`#ifdef USE_METALNESSMAP
	uniform sampler2D metalnessMap;
#endif`,Id=`#ifdef USE_INSTANCING_MORPH
	float morphTargetInfluences[ MORPHTARGETS_COUNT ];
	float morphTargetBaseInfluence = texelFetch( morphTexture, ivec2( 0, gl_InstanceID ), 0 ).r;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		morphTargetInfluences[i] =  texelFetch( morphTexture, ivec2( i + 1, gl_InstanceID ), 0 ).r;
	}
#endif`,Pd=`#if defined( USE_MORPHCOLORS )
	vColor *= morphTargetBaseInfluence;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		#if defined( USE_COLOR_ALPHA )
			if ( morphTargetInfluences[ i ] != 0.0 ) vColor += getMorph( gl_VertexID, i, 2 ) * morphTargetInfluences[ i ];
		#elif defined( USE_COLOR )
			if ( morphTargetInfluences[ i ] != 0.0 ) vColor += getMorph( gl_VertexID, i, 2 ).rgb * morphTargetInfluences[ i ];
		#endif
	}
#endif`,Dd=`#ifdef USE_MORPHNORMALS
	objectNormal *= morphTargetBaseInfluence;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		if ( morphTargetInfluences[ i ] != 0.0 ) objectNormal += getMorph( gl_VertexID, i, 1 ).xyz * morphTargetInfluences[ i ];
	}
#endif`,Ld=`#ifdef USE_MORPHTARGETS
	#ifndef USE_INSTANCING_MORPH
		uniform float morphTargetBaseInfluence;
		uniform float morphTargetInfluences[ MORPHTARGETS_COUNT ];
	#endif
	uniform sampler2DArray morphTargetsTexture;
	uniform ivec2 morphTargetsTextureSize;
	vec4 getMorph( const in int vertexIndex, const in int morphTargetIndex, const in int offset ) {
		int texelIndex = vertexIndex * MORPHTARGETS_TEXTURE_STRIDE + offset;
		int y = texelIndex / morphTargetsTextureSize.x;
		int x = texelIndex - y * morphTargetsTextureSize.x;
		ivec3 morphUV = ivec3( x, y, morphTargetIndex );
		return texelFetch( morphTargetsTexture, morphUV, 0 );
	}
#endif`,Ud=`#ifdef USE_MORPHTARGETS
	transformed *= morphTargetBaseInfluence;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		if ( morphTargetInfluences[ i ] != 0.0 ) transformed += getMorph( gl_VertexID, i, 0 ).xyz * morphTargetInfluences[ i ];
	}
#endif`,Nd=`float faceDirection = gl_FrontFacing ? 1.0 : - 1.0;
#ifdef FLAT_SHADED
	vec3 fdx = dFdx( vViewPosition );
	vec3 fdy = dFdy( vViewPosition );
	vec3 normal = normalize( cross( fdx, fdy ) );
#else
	vec3 normal = normalize( vNormal );
	#ifdef DOUBLE_SIDED
		normal *= faceDirection;
	#endif
#endif
#if defined( USE_NORMALMAP_TANGENTSPACE ) || defined( USE_CLEARCOAT_NORMALMAP ) || defined( USE_ANISOTROPY )
	#ifdef USE_TANGENT
		mat3 tbn = mat3( normalize( vTangent ), normalize( vBitangent ), normal );
	#else
		mat3 tbn = getTangentFrame( - vViewPosition, normal,
		#if defined( USE_NORMALMAP )
			vNormalMapUv
		#elif defined( USE_CLEARCOAT_NORMALMAP )
			vClearcoatNormalMapUv
		#else
			vUv
		#endif
		);
	#endif
	#if defined( DOUBLE_SIDED ) && ! defined( FLAT_SHADED )
		tbn[0] *= faceDirection;
		tbn[1] *= faceDirection;
	#endif
#endif
#ifdef USE_CLEARCOAT_NORMALMAP
	#ifdef USE_TANGENT
		mat3 tbn2 = mat3( normalize( vTangent ), normalize( vBitangent ), normal );
	#else
		mat3 tbn2 = getTangentFrame( - vViewPosition, normal, vClearcoatNormalMapUv );
	#endif
	#if defined( DOUBLE_SIDED ) && ! defined( FLAT_SHADED )
		tbn2[0] *= faceDirection;
		tbn2[1] *= faceDirection;
	#endif
#endif
vec3 nonPerturbedNormal = normal;`,Fd=`#ifdef USE_NORMALMAP_OBJECTSPACE
	normal = texture2D( normalMap, vNormalMapUv ).xyz * 2.0 - 1.0;
	#ifdef FLIP_SIDED
		normal = - normal;
	#endif
	#ifdef DOUBLE_SIDED
		normal = normal * faceDirection;
	#endif
	normal = normalize( normalMatrix * normal );
#elif defined( USE_NORMALMAP_TANGENTSPACE )
	vec3 mapN = texture2D( normalMap, vNormalMapUv ).xyz * 2.0 - 1.0;
	mapN.xy *= normalScale;
	normal = normalize( tbn * mapN );
#elif defined( USE_BUMPMAP )
	normal = perturbNormalArb( - vViewPosition, normal, dHdxy_fwd(), faceDirection );
#endif`,Od=`#ifndef FLAT_SHADED
	varying vec3 vNormal;
	#ifdef USE_TANGENT
		varying vec3 vTangent;
		varying vec3 vBitangent;
	#endif
#endif`,Bd=`#ifndef FLAT_SHADED
	varying vec3 vNormal;
	#ifdef USE_TANGENT
		varying vec3 vTangent;
		varying vec3 vBitangent;
	#endif
#endif`,zd=`#ifndef FLAT_SHADED
	vNormal = normalize( transformedNormal );
	#ifdef USE_TANGENT
		vTangent = normalize( transformedTangent );
		vBitangent = normalize( cross( vNormal, vTangent ) * tangent.w );
	#endif
#endif`,kd=`#ifdef USE_NORMALMAP
	uniform sampler2D normalMap;
	uniform vec2 normalScale;
#endif
#ifdef USE_NORMALMAP_OBJECTSPACE
	uniform mat3 normalMatrix;
#endif
#if ! defined ( USE_TANGENT ) && ( defined ( USE_NORMALMAP_TANGENTSPACE ) || defined ( USE_CLEARCOAT_NORMALMAP ) || defined( USE_ANISOTROPY ) )
	mat3 getTangentFrame( vec3 eye_pos, vec3 surf_norm, vec2 uv ) {
		vec3 q0 = dFdx( eye_pos.xyz );
		vec3 q1 = dFdy( eye_pos.xyz );
		vec2 st0 = dFdx( uv.st );
		vec2 st1 = dFdy( uv.st );
		vec3 N = surf_norm;
		vec3 q1perp = cross( q1, N );
		vec3 q0perp = cross( N, q0 );
		vec3 T = q1perp * st0.x + q0perp * st1.x;
		vec3 B = q1perp * st0.y + q0perp * st1.y;
		float det = max( dot( T, T ), dot( B, B ) );
		float scale = ( det == 0.0 ) ? 0.0 : inversesqrt( det );
		return mat3( T * scale, B * scale, N );
	}
#endif`,Vd=`#ifdef USE_CLEARCOAT
	vec3 clearcoatNormal = nonPerturbedNormal;
#endif`,Hd=`#ifdef USE_CLEARCOAT_NORMALMAP
	vec3 clearcoatMapN = texture2D( clearcoatNormalMap, vClearcoatNormalMapUv ).xyz * 2.0 - 1.0;
	clearcoatMapN.xy *= clearcoatNormalScale;
	clearcoatNormal = normalize( tbn2 * clearcoatMapN );
#endif`,Gd=`#ifdef USE_CLEARCOATMAP
	uniform sampler2D clearcoatMap;
#endif
#ifdef USE_CLEARCOAT_NORMALMAP
	uniform sampler2D clearcoatNormalMap;
	uniform vec2 clearcoatNormalScale;
#endif
#ifdef USE_CLEARCOAT_ROUGHNESSMAP
	uniform sampler2D clearcoatRoughnessMap;
#endif`,Wd=`#ifdef USE_IRIDESCENCEMAP
	uniform sampler2D iridescenceMap;
#endif
#ifdef USE_IRIDESCENCE_THICKNESSMAP
	uniform sampler2D iridescenceThicknessMap;
#endif`,Xd=`#ifdef OPAQUE
diffuseColor.a = 1.0;
#endif
#ifdef USE_TRANSMISSION
diffuseColor.a *= material.transmissionAlpha;
#endif
gl_FragColor = vec4( outgoingLight, diffuseColor.a );`,qd=`vec3 packNormalToRGB( const in vec3 normal ) {
	return normalize( normal ) * 0.5 + 0.5;
}
vec3 unpackRGBToNormal( const in vec3 rgb ) {
	return 2.0 * rgb.xyz - 1.0;
}
const float PackUpscale = 256. / 255.;const float UnpackDownscale = 255. / 256.;const float ShiftRight8 = 1. / 256.;
const float Inv255 = 1. / 255.;
const vec4 PackFactors = vec4( 1.0, 256.0, 256.0 * 256.0, 256.0 * 256.0 * 256.0 );
const vec2 UnpackFactors2 = vec2( UnpackDownscale, 1.0 / PackFactors.g );
const vec3 UnpackFactors3 = vec3( UnpackDownscale / PackFactors.rg, 1.0 / PackFactors.b );
const vec4 UnpackFactors4 = vec4( UnpackDownscale / PackFactors.rgb, 1.0 / PackFactors.a );
vec4 packDepthToRGBA( const in float v ) {
	if( v <= 0.0 )
		return vec4( 0., 0., 0., 0. );
	if( v >= 1.0 )
		return vec4( 1., 1., 1., 1. );
	float vuf;
	float af = modf( v * PackFactors.a, vuf );
	float bf = modf( vuf * ShiftRight8, vuf );
	float gf = modf( vuf * ShiftRight8, vuf );
	return vec4( vuf * Inv255, gf * PackUpscale, bf * PackUpscale, af );
}
vec3 packDepthToRGB( const in float v ) {
	if( v <= 0.0 )
		return vec3( 0., 0., 0. );
	if( v >= 1.0 )
		return vec3( 1., 1., 1. );
	float vuf;
	float bf = modf( v * PackFactors.b, vuf );
	float gf = modf( vuf * ShiftRight8, vuf );
	return vec3( vuf * Inv255, gf * PackUpscale, bf );
}
vec2 packDepthToRG( const in float v ) {
	if( v <= 0.0 )
		return vec2( 0., 0. );
	if( v >= 1.0 )
		return vec2( 1., 1. );
	float vuf;
	float gf = modf( v * 256., vuf );
	return vec2( vuf * Inv255, gf );
}
float unpackRGBAToDepth( const in vec4 v ) {
	return dot( v, UnpackFactors4 );
}
float unpackRGBToDepth( const in vec3 v ) {
	return dot( v, UnpackFactors3 );
}
float unpackRGToDepth( const in vec2 v ) {
	return v.r * UnpackFactors2.r + v.g * UnpackFactors2.g;
}
vec4 pack2HalfToRGBA( const in vec2 v ) {
	vec4 r = vec4( v.x, fract( v.x * 255.0 ), v.y, fract( v.y * 255.0 ) );
	return vec4( r.x - r.y / 255.0, r.y, r.z - r.w / 255.0, r.w );
}
vec2 unpackRGBATo2Half( const in vec4 v ) {
	return vec2( v.x + ( v.y / 255.0 ), v.z + ( v.w / 255.0 ) );
}
float viewZToOrthographicDepth( const in float viewZ, const in float near, const in float far ) {
	return ( viewZ + near ) / ( near - far );
}
float orthographicDepthToViewZ( const in float depth, const in float near, const in float far ) {
	return depth * ( near - far ) - near;
}
float viewZToPerspectiveDepth( const in float viewZ, const in float near, const in float far ) {
	return ( ( near + viewZ ) * far ) / ( ( far - near ) * viewZ );
}
float perspectiveDepthToViewZ( const in float depth, const in float near, const in float far ) {
	return ( near * far ) / ( ( far - near ) * depth - far );
}`,Yd=`#ifdef PREMULTIPLIED_ALPHA
	gl_FragColor.rgb *= gl_FragColor.a;
#endif`,Zd=`vec4 mvPosition = vec4( transformed, 1.0 );
#ifdef USE_BATCHING
	mvPosition = batchingMatrix * mvPosition;
#endif
#ifdef USE_INSTANCING
	mvPosition = instanceMatrix * mvPosition;
#endif
mvPosition = modelViewMatrix * mvPosition;
gl_Position = projectionMatrix * mvPosition;`,Jd=`#ifdef DITHERING
	gl_FragColor.rgb = dithering( gl_FragColor.rgb );
#endif`,$d=`#ifdef DITHERING
	vec3 dithering( vec3 color ) {
		float grid_position = rand( gl_FragCoord.xy );
		vec3 dither_shift_RGB = vec3( 0.25 / 255.0, -0.25 / 255.0, 0.25 / 255.0 );
		dither_shift_RGB = mix( 2.0 * dither_shift_RGB, -2.0 * dither_shift_RGB, grid_position );
		return color + dither_shift_RGB;
	}
#endif`,Kd=`float roughnessFactor = roughness;
#ifdef USE_ROUGHNESSMAP
	vec4 texelRoughness = texture2D( roughnessMap, vRoughnessMapUv );
	roughnessFactor *= texelRoughness.g;
#endif`,jd=`#ifdef USE_ROUGHNESSMAP
	uniform sampler2D roughnessMap;
#endif`,Qd=`#if NUM_SPOT_LIGHT_COORDS > 0
	varying vec4 vSpotLightCoord[ NUM_SPOT_LIGHT_COORDS ];
#endif
#if NUM_SPOT_LIGHT_MAPS > 0
	uniform sampler2D spotLightMap[ NUM_SPOT_LIGHT_MAPS ];
#endif
#ifdef USE_SHADOWMAP
	#if NUM_DIR_LIGHT_SHADOWS > 0
		uniform sampler2D directionalShadowMap[ NUM_DIR_LIGHT_SHADOWS ];
		varying vec4 vDirectionalShadowCoord[ NUM_DIR_LIGHT_SHADOWS ];
		struct DirectionalLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
		};
		uniform DirectionalLightShadow directionalLightShadows[ NUM_DIR_LIGHT_SHADOWS ];
	#endif
	#if NUM_SPOT_LIGHT_SHADOWS > 0
		uniform sampler2D spotShadowMap[ NUM_SPOT_LIGHT_SHADOWS ];
		struct SpotLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
		};
		uniform SpotLightShadow spotLightShadows[ NUM_SPOT_LIGHT_SHADOWS ];
	#endif
	#if NUM_POINT_LIGHT_SHADOWS > 0
		uniform sampler2D pointShadowMap[ NUM_POINT_LIGHT_SHADOWS ];
		varying vec4 vPointShadowCoord[ NUM_POINT_LIGHT_SHADOWS ];
		struct PointLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
			float shadowCameraNear;
			float shadowCameraFar;
		};
		uniform PointLightShadow pointLightShadows[ NUM_POINT_LIGHT_SHADOWS ];
	#endif
	float texture2DCompare( sampler2D depths, vec2 uv, float compare ) {
		float depth = unpackRGBAToDepth( texture2D( depths, uv ) );
		#ifdef USE_REVERSED_DEPTH_BUFFER
			return step( depth, compare );
		#else
			return step( compare, depth );
		#endif
	}
	vec2 texture2DDistribution( sampler2D shadow, vec2 uv ) {
		return unpackRGBATo2Half( texture2D( shadow, uv ) );
	}
	float VSMShadow( sampler2D shadow, vec2 uv, float compare ) {
		float occlusion = 1.0;
		vec2 distribution = texture2DDistribution( shadow, uv );
		#ifdef USE_REVERSED_DEPTH_BUFFER
			float hard_shadow = step( distribution.x, compare );
		#else
			float hard_shadow = step( compare, distribution.x );
		#endif
		if ( hard_shadow != 1.0 ) {
			float distance = compare - distribution.x;
			float variance = max( 0.00000, distribution.y * distribution.y );
			float softness_probability = variance / (variance + distance * distance );			softness_probability = clamp( ( softness_probability - 0.3 ) / ( 0.95 - 0.3 ), 0.0, 1.0 );			occlusion = clamp( max( hard_shadow, softness_probability ), 0.0, 1.0 );
		}
		return occlusion;
	}
	float getShadow( sampler2D shadowMap, vec2 shadowMapSize, float shadowIntensity, float shadowBias, float shadowRadius, vec4 shadowCoord ) {
		float shadow = 1.0;
		shadowCoord.xyz /= shadowCoord.w;
		shadowCoord.z += shadowBias;
		bool inFrustum = shadowCoord.x >= 0.0 && shadowCoord.x <= 1.0 && shadowCoord.y >= 0.0 && shadowCoord.y <= 1.0;
		bool frustumTest = inFrustum && shadowCoord.z <= 1.0;
		if ( frustumTest ) {
		#if defined( SHADOWMAP_TYPE_PCF )
			vec2 texelSize = vec2( 1.0 ) / shadowMapSize;
			float dx0 = - texelSize.x * shadowRadius;
			float dy0 = - texelSize.y * shadowRadius;
			float dx1 = + texelSize.x * shadowRadius;
			float dy1 = + texelSize.y * shadowRadius;
			float dx2 = dx0 / 2.0;
			float dy2 = dy0 / 2.0;
			float dx3 = dx1 / 2.0;
			float dy3 = dy1 / 2.0;
			shadow = (
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx0, dy0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( 0.0, dy0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx1, dy0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx2, dy2 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( 0.0, dy2 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx3, dy2 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx0, 0.0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx2, 0.0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy, shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx3, 0.0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx1, 0.0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx2, dy3 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( 0.0, dy3 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx3, dy3 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx0, dy1 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( 0.0, dy1 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx1, dy1 ), shadowCoord.z )
			) * ( 1.0 / 17.0 );
		#elif defined( SHADOWMAP_TYPE_PCF_SOFT )
			vec2 texelSize = vec2( 1.0 ) / shadowMapSize;
			float dx = texelSize.x;
			float dy = texelSize.y;
			vec2 uv = shadowCoord.xy;
			vec2 f = fract( uv * shadowMapSize + 0.5 );
			uv -= f * texelSize;
			shadow = (
				texture2DCompare( shadowMap, uv, shadowCoord.z ) +
				texture2DCompare( shadowMap, uv + vec2( dx, 0.0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, uv + vec2( 0.0, dy ), shadowCoord.z ) +
				texture2DCompare( shadowMap, uv + texelSize, shadowCoord.z ) +
				mix( texture2DCompare( shadowMap, uv + vec2( -dx, 0.0 ), shadowCoord.z ),
					 texture2DCompare( shadowMap, uv + vec2( 2.0 * dx, 0.0 ), shadowCoord.z ),
					 f.x ) +
				mix( texture2DCompare( shadowMap, uv + vec2( -dx, dy ), shadowCoord.z ),
					 texture2DCompare( shadowMap, uv + vec2( 2.0 * dx, dy ), shadowCoord.z ),
					 f.x ) +
				mix( texture2DCompare( shadowMap, uv + vec2( 0.0, -dy ), shadowCoord.z ),
					 texture2DCompare( shadowMap, uv + vec2( 0.0, 2.0 * dy ), shadowCoord.z ),
					 f.y ) +
				mix( texture2DCompare( shadowMap, uv + vec2( dx, -dy ), shadowCoord.z ),
					 texture2DCompare( shadowMap, uv + vec2( dx, 2.0 * dy ), shadowCoord.z ),
					 f.y ) +
				mix( mix( texture2DCompare( shadowMap, uv + vec2( -dx, -dy ), shadowCoord.z ),
						  texture2DCompare( shadowMap, uv + vec2( 2.0 * dx, -dy ), shadowCoord.z ),
						  f.x ),
					 mix( texture2DCompare( shadowMap, uv + vec2( -dx, 2.0 * dy ), shadowCoord.z ),
						  texture2DCompare( shadowMap, uv + vec2( 2.0 * dx, 2.0 * dy ), shadowCoord.z ),
						  f.x ),
					 f.y )
			) * ( 1.0 / 9.0 );
		#elif defined( SHADOWMAP_TYPE_VSM )
			shadow = VSMShadow( shadowMap, shadowCoord.xy, shadowCoord.z );
		#else
			shadow = texture2DCompare( shadowMap, shadowCoord.xy, shadowCoord.z );
		#endif
		}
		return mix( 1.0, shadow, shadowIntensity );
	}
	vec2 cubeToUV( vec3 v, float texelSizeY ) {
		vec3 absV = abs( v );
		float scaleToCube = 1.0 / max( absV.x, max( absV.y, absV.z ) );
		absV *= scaleToCube;
		v *= scaleToCube * ( 1.0 - 2.0 * texelSizeY );
		vec2 planar = v.xy;
		float almostATexel = 1.5 * texelSizeY;
		float almostOne = 1.0 - almostATexel;
		if ( absV.z >= almostOne ) {
			if ( v.z > 0.0 )
				planar.x = 4.0 - v.x;
		} else if ( absV.x >= almostOne ) {
			float signX = sign( v.x );
			planar.x = v.z * signX + 2.0 * signX;
		} else if ( absV.y >= almostOne ) {
			float signY = sign( v.y );
			planar.x = v.x + 2.0 * signY + 2.0;
			planar.y = v.z * signY - 2.0;
		}
		return vec2( 0.125, 0.25 ) * planar + vec2( 0.375, 0.75 );
	}
	float getPointShadow( sampler2D shadowMap, vec2 shadowMapSize, float shadowIntensity, float shadowBias, float shadowRadius, vec4 shadowCoord, float shadowCameraNear, float shadowCameraFar ) {
		float shadow = 1.0;
		vec3 lightToPosition = shadowCoord.xyz;
		
		float lightToPositionLength = length( lightToPosition );
		if ( lightToPositionLength - shadowCameraFar <= 0.0 && lightToPositionLength - shadowCameraNear >= 0.0 ) {
			float dp = ( lightToPositionLength - shadowCameraNear ) / ( shadowCameraFar - shadowCameraNear );			dp += shadowBias;
			vec3 bd3D = normalize( lightToPosition );
			vec2 texelSize = vec2( 1.0 ) / ( shadowMapSize * vec2( 4.0, 2.0 ) );
			#if defined( SHADOWMAP_TYPE_PCF ) || defined( SHADOWMAP_TYPE_PCF_SOFT ) || defined( SHADOWMAP_TYPE_VSM )
				vec2 offset = vec2( - 1, 1 ) * shadowRadius * texelSize.y;
				shadow = (
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.xyy, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.yyy, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.xyx, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.yyx, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.xxy, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.yxy, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.xxx, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.yxx, texelSize.y ), dp )
				) * ( 1.0 / 9.0 );
			#else
				shadow = texture2DCompare( shadowMap, cubeToUV( bd3D, texelSize.y ), dp );
			#endif
		}
		return mix( 1.0, shadow, shadowIntensity );
	}
#endif`,tf=`#if NUM_SPOT_LIGHT_COORDS > 0
	uniform mat4 spotLightMatrix[ NUM_SPOT_LIGHT_COORDS ];
	varying vec4 vSpotLightCoord[ NUM_SPOT_LIGHT_COORDS ];
#endif
#ifdef USE_SHADOWMAP
	#if NUM_DIR_LIGHT_SHADOWS > 0
		uniform mat4 directionalShadowMatrix[ NUM_DIR_LIGHT_SHADOWS ];
		varying vec4 vDirectionalShadowCoord[ NUM_DIR_LIGHT_SHADOWS ];
		struct DirectionalLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
		};
		uniform DirectionalLightShadow directionalLightShadows[ NUM_DIR_LIGHT_SHADOWS ];
	#endif
	#if NUM_SPOT_LIGHT_SHADOWS > 0
		struct SpotLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
		};
		uniform SpotLightShadow spotLightShadows[ NUM_SPOT_LIGHT_SHADOWS ];
	#endif
	#if NUM_POINT_LIGHT_SHADOWS > 0
		uniform mat4 pointShadowMatrix[ NUM_POINT_LIGHT_SHADOWS ];
		varying vec4 vPointShadowCoord[ NUM_POINT_LIGHT_SHADOWS ];
		struct PointLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
			float shadowCameraNear;
			float shadowCameraFar;
		};
		uniform PointLightShadow pointLightShadows[ NUM_POINT_LIGHT_SHADOWS ];
	#endif
#endif`,ef=`#if ( defined( USE_SHADOWMAP ) && ( NUM_DIR_LIGHT_SHADOWS > 0 || NUM_POINT_LIGHT_SHADOWS > 0 ) ) || ( NUM_SPOT_LIGHT_COORDS > 0 )
	vec3 shadowWorldNormal = inverseTransformDirection( transformedNormal, viewMatrix );
	vec4 shadowWorldPosition;
#endif
#if defined( USE_SHADOWMAP )
	#if NUM_DIR_LIGHT_SHADOWS > 0
		#pragma unroll_loop_start
		for ( int i = 0; i < NUM_DIR_LIGHT_SHADOWS; i ++ ) {
			shadowWorldPosition = worldPosition + vec4( shadowWorldNormal * directionalLightShadows[ i ].shadowNormalBias, 0 );
			vDirectionalShadowCoord[ i ] = directionalShadowMatrix[ i ] * shadowWorldPosition;
		}
		#pragma unroll_loop_end
	#endif
	#if NUM_POINT_LIGHT_SHADOWS > 0
		#pragma unroll_loop_start
		for ( int i = 0; i < NUM_POINT_LIGHT_SHADOWS; i ++ ) {
			shadowWorldPosition = worldPosition + vec4( shadowWorldNormal * pointLightShadows[ i ].shadowNormalBias, 0 );
			vPointShadowCoord[ i ] = pointShadowMatrix[ i ] * shadowWorldPosition;
		}
		#pragma unroll_loop_end
	#endif
#endif
#if NUM_SPOT_LIGHT_COORDS > 0
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_SPOT_LIGHT_COORDS; i ++ ) {
		shadowWorldPosition = worldPosition;
		#if ( defined( USE_SHADOWMAP ) && UNROLLED_LOOP_INDEX < NUM_SPOT_LIGHT_SHADOWS )
			shadowWorldPosition.xyz += shadowWorldNormal * spotLightShadows[ i ].shadowNormalBias;
		#endif
		vSpotLightCoord[ i ] = spotLightMatrix[ i ] * shadowWorldPosition;
	}
	#pragma unroll_loop_end
#endif`,nf=`float getShadowMask() {
	float shadow = 1.0;
	#ifdef USE_SHADOWMAP
	#if NUM_DIR_LIGHT_SHADOWS > 0
	DirectionalLightShadow directionalLight;
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_DIR_LIGHT_SHADOWS; i ++ ) {
		directionalLight = directionalLightShadows[ i ];
		shadow *= receiveShadow ? getShadow( directionalShadowMap[ i ], directionalLight.shadowMapSize, directionalLight.shadowIntensity, directionalLight.shadowBias, directionalLight.shadowRadius, vDirectionalShadowCoord[ i ] ) : 1.0;
	}
	#pragma unroll_loop_end
	#endif
	#if NUM_SPOT_LIGHT_SHADOWS > 0
	SpotLightShadow spotLight;
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_SPOT_LIGHT_SHADOWS; i ++ ) {
		spotLight = spotLightShadows[ i ];
		shadow *= receiveShadow ? getShadow( spotShadowMap[ i ], spotLight.shadowMapSize, spotLight.shadowIntensity, spotLight.shadowBias, spotLight.shadowRadius, vSpotLightCoord[ i ] ) : 1.0;
	}
	#pragma unroll_loop_end
	#endif
	#if NUM_POINT_LIGHT_SHADOWS > 0
	PointLightShadow pointLight;
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_POINT_LIGHT_SHADOWS; i ++ ) {
		pointLight = pointLightShadows[ i ];
		shadow *= receiveShadow ? getPointShadow( pointShadowMap[ i ], pointLight.shadowMapSize, pointLight.shadowIntensity, pointLight.shadowBias, pointLight.shadowRadius, vPointShadowCoord[ i ], pointLight.shadowCameraNear, pointLight.shadowCameraFar ) : 1.0;
	}
	#pragma unroll_loop_end
	#endif
	#endif
	return shadow;
}`,sf=`#ifdef USE_SKINNING
	mat4 boneMatX = getBoneMatrix( skinIndex.x );
	mat4 boneMatY = getBoneMatrix( skinIndex.y );
	mat4 boneMatZ = getBoneMatrix( skinIndex.z );
	mat4 boneMatW = getBoneMatrix( skinIndex.w );
#endif`,rf=`#ifdef USE_SKINNING
	uniform mat4 bindMatrix;
	uniform mat4 bindMatrixInverse;
	uniform highp sampler2D boneTexture;
	mat4 getBoneMatrix( const in float i ) {
		int size = textureSize( boneTexture, 0 ).x;
		int j = int( i ) * 4;
		int x = j % size;
		int y = j / size;
		vec4 v1 = texelFetch( boneTexture, ivec2( x, y ), 0 );
		vec4 v2 = texelFetch( boneTexture, ivec2( x + 1, y ), 0 );
		vec4 v3 = texelFetch( boneTexture, ivec2( x + 2, y ), 0 );
		vec4 v4 = texelFetch( boneTexture, ivec2( x + 3, y ), 0 );
		return mat4( v1, v2, v3, v4 );
	}
#endif`,af=`#ifdef USE_SKINNING
	vec4 skinVertex = bindMatrix * vec4( transformed, 1.0 );
	vec4 skinned = vec4( 0.0 );
	skinned += boneMatX * skinVertex * skinWeight.x;
	skinned += boneMatY * skinVertex * skinWeight.y;
	skinned += boneMatZ * skinVertex * skinWeight.z;
	skinned += boneMatW * skinVertex * skinWeight.w;
	transformed = ( bindMatrixInverse * skinned ).xyz;
#endif`,of=`#ifdef USE_SKINNING
	mat4 skinMatrix = mat4( 0.0 );
	skinMatrix += skinWeight.x * boneMatX;
	skinMatrix += skinWeight.y * boneMatY;
	skinMatrix += skinWeight.z * boneMatZ;
	skinMatrix += skinWeight.w * boneMatW;
	skinMatrix = bindMatrixInverse * skinMatrix * bindMatrix;
	objectNormal = vec4( skinMatrix * vec4( objectNormal, 0.0 ) ).xyz;
	#ifdef USE_TANGENT
		objectTangent = vec4( skinMatrix * vec4( objectTangent, 0.0 ) ).xyz;
	#endif
#endif`,lf=`float specularStrength;
#ifdef USE_SPECULARMAP
	vec4 texelSpecular = texture2D( specularMap, vSpecularMapUv );
	specularStrength = texelSpecular.r;
#else
	specularStrength = 1.0;
#endif`,cf=`#ifdef USE_SPECULARMAP
	uniform sampler2D specularMap;
#endif`,hf=`#if defined( TONE_MAPPING )
	gl_FragColor.rgb = toneMapping( gl_FragColor.rgb );
#endif`,uf=`#ifndef saturate
#define saturate( a ) clamp( a, 0.0, 1.0 )
#endif
uniform float toneMappingExposure;
vec3 LinearToneMapping( vec3 color ) {
	return saturate( toneMappingExposure * color );
}
vec3 ReinhardToneMapping( vec3 color ) {
	color *= toneMappingExposure;
	return saturate( color / ( vec3( 1.0 ) + color ) );
}
vec3 CineonToneMapping( vec3 color ) {
	color *= toneMappingExposure;
	color = max( vec3( 0.0 ), color - 0.004 );
	return pow( ( color * ( 6.2 * color + 0.5 ) ) / ( color * ( 6.2 * color + 1.7 ) + 0.06 ), vec3( 2.2 ) );
}
vec3 RRTAndODTFit( vec3 v ) {
	vec3 a = v * ( v + 0.0245786 ) - 0.000090537;
	vec3 b = v * ( 0.983729 * v + 0.4329510 ) + 0.238081;
	return a / b;
}
vec3 ACESFilmicToneMapping( vec3 color ) {
	const mat3 ACESInputMat = mat3(
		vec3( 0.59719, 0.07600, 0.02840 ),		vec3( 0.35458, 0.90834, 0.13383 ),
		vec3( 0.04823, 0.01566, 0.83777 )
	);
	const mat3 ACESOutputMat = mat3(
		vec3(  1.60475, -0.10208, -0.00327 ),		vec3( -0.53108,  1.10813, -0.07276 ),
		vec3( -0.07367, -0.00605,  1.07602 )
	);
	color *= toneMappingExposure / 0.6;
	color = ACESInputMat * color;
	color = RRTAndODTFit( color );
	color = ACESOutputMat * color;
	return saturate( color );
}
const mat3 LINEAR_REC2020_TO_LINEAR_SRGB = mat3(
	vec3( 1.6605, - 0.1246, - 0.0182 ),
	vec3( - 0.5876, 1.1329, - 0.1006 ),
	vec3( - 0.0728, - 0.0083, 1.1187 )
);
const mat3 LINEAR_SRGB_TO_LINEAR_REC2020 = mat3(
	vec3( 0.6274, 0.0691, 0.0164 ),
	vec3( 0.3293, 0.9195, 0.0880 ),
	vec3( 0.0433, 0.0113, 0.8956 )
);
vec3 agxDefaultContrastApprox( vec3 x ) {
	vec3 x2 = x * x;
	vec3 x4 = x2 * x2;
	return + 15.5 * x4 * x2
		- 40.14 * x4 * x
		+ 31.96 * x4
		- 6.868 * x2 * x
		+ 0.4298 * x2
		+ 0.1191 * x
		- 0.00232;
}
vec3 AgXToneMapping( vec3 color ) {
	const mat3 AgXInsetMatrix = mat3(
		vec3( 0.856627153315983, 0.137318972929847, 0.11189821299995 ),
		vec3( 0.0951212405381588, 0.761241990602591, 0.0767994186031903 ),
		vec3( 0.0482516061458583, 0.101439036467562, 0.811302368396859 )
	);
	const mat3 AgXOutsetMatrix = mat3(
		vec3( 1.1271005818144368, - 0.1413297634984383, - 0.14132976349843826 ),
		vec3( - 0.11060664309660323, 1.157823702216272, - 0.11060664309660294 ),
		vec3( - 0.016493938717834573, - 0.016493938717834257, 1.2519364065950405 )
	);
	const float AgxMinEv = - 12.47393;	const float AgxMaxEv = 4.026069;
	color *= toneMappingExposure;
	color = LINEAR_SRGB_TO_LINEAR_REC2020 * color;
	color = AgXInsetMatrix * color;
	color = max( color, 1e-10 );	color = log2( color );
	color = ( color - AgxMinEv ) / ( AgxMaxEv - AgxMinEv );
	color = clamp( color, 0.0, 1.0 );
	color = agxDefaultContrastApprox( color );
	color = AgXOutsetMatrix * color;
	color = pow( max( vec3( 0.0 ), color ), vec3( 2.2 ) );
	color = LINEAR_REC2020_TO_LINEAR_SRGB * color;
	color = clamp( color, 0.0, 1.0 );
	return color;
}
vec3 NeutralToneMapping( vec3 color ) {
	const float StartCompression = 0.8 - 0.04;
	const float Desaturation = 0.15;
	color *= toneMappingExposure;
	float x = min( color.r, min( color.g, color.b ) );
	float offset = x < 0.08 ? x - 6.25 * x * x : 0.04;
	color -= offset;
	float peak = max( color.r, max( color.g, color.b ) );
	if ( peak < StartCompression ) return color;
	float d = 1. - StartCompression;
	float newPeak = 1. - d * d / ( peak + d - StartCompression );
	color *= newPeak / peak;
	float g = 1. - 1. / ( Desaturation * ( peak - newPeak ) + 1. );
	return mix( color, vec3( newPeak ), g );
}
vec3 CustomToneMapping( vec3 color ) { return color; }`,df=`#ifdef USE_TRANSMISSION
	material.transmission = transmission;
	material.transmissionAlpha = 1.0;
	material.thickness = thickness;
	material.attenuationDistance = attenuationDistance;
	material.attenuationColor = attenuationColor;
	#ifdef USE_TRANSMISSIONMAP
		material.transmission *= texture2D( transmissionMap, vTransmissionMapUv ).r;
	#endif
	#ifdef USE_THICKNESSMAP
		material.thickness *= texture2D( thicknessMap, vThicknessMapUv ).g;
	#endif
	vec3 pos = vWorldPosition;
	vec3 v = normalize( cameraPosition - pos );
	vec3 n = inverseTransformDirection( normal, viewMatrix );
	vec4 transmitted = getIBLVolumeRefraction(
		n, v, material.roughness, material.diffuseColor, material.specularColor, material.specularF90,
		pos, modelMatrix, viewMatrix, projectionMatrix, material.dispersion, material.ior, material.thickness,
		material.attenuationColor, material.attenuationDistance );
	material.transmissionAlpha = mix( material.transmissionAlpha, transmitted.a, material.transmission );
	totalDiffuse = mix( totalDiffuse, transmitted.rgb, material.transmission );
#endif`,ff=`#ifdef USE_TRANSMISSION
	uniform float transmission;
	uniform float thickness;
	uniform float attenuationDistance;
	uniform vec3 attenuationColor;
	#ifdef USE_TRANSMISSIONMAP
		uniform sampler2D transmissionMap;
	#endif
	#ifdef USE_THICKNESSMAP
		uniform sampler2D thicknessMap;
	#endif
	uniform vec2 transmissionSamplerSize;
	uniform sampler2D transmissionSamplerMap;
	uniform mat4 modelMatrix;
	uniform mat4 projectionMatrix;
	varying vec3 vWorldPosition;
	float w0( float a ) {
		return ( 1.0 / 6.0 ) * ( a * ( a * ( - a + 3.0 ) - 3.0 ) + 1.0 );
	}
	float w1( float a ) {
		return ( 1.0 / 6.0 ) * ( a *  a * ( 3.0 * a - 6.0 ) + 4.0 );
	}
	float w2( float a ){
		return ( 1.0 / 6.0 ) * ( a * ( a * ( - 3.0 * a + 3.0 ) + 3.0 ) + 1.0 );
	}
	float w3( float a ) {
		return ( 1.0 / 6.0 ) * ( a * a * a );
	}
	float g0( float a ) {
		return w0( a ) + w1( a );
	}
	float g1( float a ) {
		return w2( a ) + w3( a );
	}
	float h0( float a ) {
		return - 1.0 + w1( a ) / ( w0( a ) + w1( a ) );
	}
	float h1( float a ) {
		return 1.0 + w3( a ) / ( w2( a ) + w3( a ) );
	}
	vec4 bicubic( sampler2D tex, vec2 uv, vec4 texelSize, float lod ) {
		uv = uv * texelSize.zw + 0.5;
		vec2 iuv = floor( uv );
		vec2 fuv = fract( uv );
		float g0x = g0( fuv.x );
		float g1x = g1( fuv.x );
		float h0x = h0( fuv.x );
		float h1x = h1( fuv.x );
		float h0y = h0( fuv.y );
		float h1y = h1( fuv.y );
		vec2 p0 = ( vec2( iuv.x + h0x, iuv.y + h0y ) - 0.5 ) * texelSize.xy;
		vec2 p1 = ( vec2( iuv.x + h1x, iuv.y + h0y ) - 0.5 ) * texelSize.xy;
		vec2 p2 = ( vec2( iuv.x + h0x, iuv.y + h1y ) - 0.5 ) * texelSize.xy;
		vec2 p3 = ( vec2( iuv.x + h1x, iuv.y + h1y ) - 0.5 ) * texelSize.xy;
		return g0( fuv.y ) * ( g0x * textureLod( tex, p0, lod ) + g1x * textureLod( tex, p1, lod ) ) +
			g1( fuv.y ) * ( g0x * textureLod( tex, p2, lod ) + g1x * textureLod( tex, p3, lod ) );
	}
	vec4 textureBicubic( sampler2D sampler, vec2 uv, float lod ) {
		vec2 fLodSize = vec2( textureSize( sampler, int( lod ) ) );
		vec2 cLodSize = vec2( textureSize( sampler, int( lod + 1.0 ) ) );
		vec2 fLodSizeInv = 1.0 / fLodSize;
		vec2 cLodSizeInv = 1.0 / cLodSize;
		vec4 fSample = bicubic( sampler, uv, vec4( fLodSizeInv, fLodSize ), floor( lod ) );
		vec4 cSample = bicubic( sampler, uv, vec4( cLodSizeInv, cLodSize ), ceil( lod ) );
		return mix( fSample, cSample, fract( lod ) );
	}
	vec3 getVolumeTransmissionRay( const in vec3 n, const in vec3 v, const in float thickness, const in float ior, const in mat4 modelMatrix ) {
		vec3 refractionVector = refract( - v, normalize( n ), 1.0 / ior );
		vec3 modelScale;
		modelScale.x = length( vec3( modelMatrix[ 0 ].xyz ) );
		modelScale.y = length( vec3( modelMatrix[ 1 ].xyz ) );
		modelScale.z = length( vec3( modelMatrix[ 2 ].xyz ) );
		return normalize( refractionVector ) * thickness * modelScale;
	}
	float applyIorToRoughness( const in float roughness, const in float ior ) {
		return roughness * clamp( ior * 2.0 - 2.0, 0.0, 1.0 );
	}
	vec4 getTransmissionSample( const in vec2 fragCoord, const in float roughness, const in float ior ) {
		float lod = log2( transmissionSamplerSize.x ) * applyIorToRoughness( roughness, ior );
		return textureBicubic( transmissionSamplerMap, fragCoord.xy, lod );
	}
	vec3 volumeAttenuation( const in float transmissionDistance, const in vec3 attenuationColor, const in float attenuationDistance ) {
		if ( isinf( attenuationDistance ) ) {
			return vec3( 1.0 );
		} else {
			vec3 attenuationCoefficient = -log( attenuationColor ) / attenuationDistance;
			vec3 transmittance = exp( - attenuationCoefficient * transmissionDistance );			return transmittance;
		}
	}
	vec4 getIBLVolumeRefraction( const in vec3 n, const in vec3 v, const in float roughness, const in vec3 diffuseColor,
		const in vec3 specularColor, const in float specularF90, const in vec3 position, const in mat4 modelMatrix,
		const in mat4 viewMatrix, const in mat4 projMatrix, const in float dispersion, const in float ior, const in float thickness,
		const in vec3 attenuationColor, const in float attenuationDistance ) {
		vec4 transmittedLight;
		vec3 transmittance;
		#ifdef USE_DISPERSION
			float halfSpread = ( ior - 1.0 ) * 0.025 * dispersion;
			vec3 iors = vec3( ior - halfSpread, ior, ior + halfSpread );
			for ( int i = 0; i < 3; i ++ ) {
				vec3 transmissionRay = getVolumeTransmissionRay( n, v, thickness, iors[ i ], modelMatrix );
				vec3 refractedRayExit = position + transmissionRay;
				vec4 ndcPos = projMatrix * viewMatrix * vec4( refractedRayExit, 1.0 );
				vec2 refractionCoords = ndcPos.xy / ndcPos.w;
				refractionCoords += 1.0;
				refractionCoords /= 2.0;
				vec4 transmissionSample = getTransmissionSample( refractionCoords, roughness, iors[ i ] );
				transmittedLight[ i ] = transmissionSample[ i ];
				transmittedLight.a += transmissionSample.a;
				transmittance[ i ] = diffuseColor[ i ] * volumeAttenuation( length( transmissionRay ), attenuationColor, attenuationDistance )[ i ];
			}
			transmittedLight.a /= 3.0;
		#else
			vec3 transmissionRay = getVolumeTransmissionRay( n, v, thickness, ior, modelMatrix );
			vec3 refractedRayExit = position + transmissionRay;
			vec4 ndcPos = projMatrix * viewMatrix * vec4( refractedRayExit, 1.0 );
			vec2 refractionCoords = ndcPos.xy / ndcPos.w;
			refractionCoords += 1.0;
			refractionCoords /= 2.0;
			transmittedLight = getTransmissionSample( refractionCoords, roughness, ior );
			transmittance = diffuseColor * volumeAttenuation( length( transmissionRay ), attenuationColor, attenuationDistance );
		#endif
		vec3 attenuatedColor = transmittance * transmittedLight.rgb;
		vec3 F = EnvironmentBRDF( n, v, specularColor, specularF90, roughness );
		float transmittanceFactor = ( transmittance.r + transmittance.g + transmittance.b ) / 3.0;
		return vec4( ( 1.0 - F ) * attenuatedColor, 1.0 - ( 1.0 - transmittedLight.a ) * transmittanceFactor );
	}
#endif`,pf=`#if defined( USE_UV ) || defined( USE_ANISOTROPY )
	varying vec2 vUv;
#endif
#ifdef USE_MAP
	varying vec2 vMapUv;
#endif
#ifdef USE_ALPHAMAP
	varying vec2 vAlphaMapUv;
#endif
#ifdef USE_LIGHTMAP
	varying vec2 vLightMapUv;
#endif
#ifdef USE_AOMAP
	varying vec2 vAoMapUv;
#endif
#ifdef USE_BUMPMAP
	varying vec2 vBumpMapUv;
#endif
#ifdef USE_NORMALMAP
	varying vec2 vNormalMapUv;
#endif
#ifdef USE_EMISSIVEMAP
	varying vec2 vEmissiveMapUv;
#endif
#ifdef USE_METALNESSMAP
	varying vec2 vMetalnessMapUv;
#endif
#ifdef USE_ROUGHNESSMAP
	varying vec2 vRoughnessMapUv;
#endif
#ifdef USE_ANISOTROPYMAP
	varying vec2 vAnisotropyMapUv;
#endif
#ifdef USE_CLEARCOATMAP
	varying vec2 vClearcoatMapUv;
#endif
#ifdef USE_CLEARCOAT_NORMALMAP
	varying vec2 vClearcoatNormalMapUv;
#endif
#ifdef USE_CLEARCOAT_ROUGHNESSMAP
	varying vec2 vClearcoatRoughnessMapUv;
#endif
#ifdef USE_IRIDESCENCEMAP
	varying vec2 vIridescenceMapUv;
#endif
#ifdef USE_IRIDESCENCE_THICKNESSMAP
	varying vec2 vIridescenceThicknessMapUv;
#endif
#ifdef USE_SHEEN_COLORMAP
	varying vec2 vSheenColorMapUv;
#endif
#ifdef USE_SHEEN_ROUGHNESSMAP
	varying vec2 vSheenRoughnessMapUv;
#endif
#ifdef USE_SPECULARMAP
	varying vec2 vSpecularMapUv;
#endif
#ifdef USE_SPECULAR_COLORMAP
	varying vec2 vSpecularColorMapUv;
#endif
#ifdef USE_SPECULAR_INTENSITYMAP
	varying vec2 vSpecularIntensityMapUv;
#endif
#ifdef USE_TRANSMISSIONMAP
	uniform mat3 transmissionMapTransform;
	varying vec2 vTransmissionMapUv;
#endif
#ifdef USE_THICKNESSMAP
	uniform mat3 thicknessMapTransform;
	varying vec2 vThicknessMapUv;
#endif`,mf=`#if defined( USE_UV ) || defined( USE_ANISOTROPY )
	varying vec2 vUv;
#endif
#ifdef USE_MAP
	uniform mat3 mapTransform;
	varying vec2 vMapUv;
#endif
#ifdef USE_ALPHAMAP
	uniform mat3 alphaMapTransform;
	varying vec2 vAlphaMapUv;
#endif
#ifdef USE_LIGHTMAP
	uniform mat3 lightMapTransform;
	varying vec2 vLightMapUv;
#endif
#ifdef USE_AOMAP
	uniform mat3 aoMapTransform;
	varying vec2 vAoMapUv;
#endif
#ifdef USE_BUMPMAP
	uniform mat3 bumpMapTransform;
	varying vec2 vBumpMapUv;
#endif
#ifdef USE_NORMALMAP
	uniform mat3 normalMapTransform;
	varying vec2 vNormalMapUv;
#endif
#ifdef USE_DISPLACEMENTMAP
	uniform mat3 displacementMapTransform;
	varying vec2 vDisplacementMapUv;
#endif
#ifdef USE_EMISSIVEMAP
	uniform mat3 emissiveMapTransform;
	varying vec2 vEmissiveMapUv;
#endif
#ifdef USE_METALNESSMAP
	uniform mat3 metalnessMapTransform;
	varying vec2 vMetalnessMapUv;
#endif
#ifdef USE_ROUGHNESSMAP
	uniform mat3 roughnessMapTransform;
	varying vec2 vRoughnessMapUv;
#endif
#ifdef USE_ANISOTROPYMAP
	uniform mat3 anisotropyMapTransform;
	varying vec2 vAnisotropyMapUv;
#endif
#ifdef USE_CLEARCOATMAP
	uniform mat3 clearcoatMapTransform;
	varying vec2 vClearcoatMapUv;
#endif
#ifdef USE_CLEARCOAT_NORMALMAP
	uniform mat3 clearcoatNormalMapTransform;
	varying vec2 vClearcoatNormalMapUv;
#endif
#ifdef USE_CLEARCOAT_ROUGHNESSMAP
	uniform mat3 clearcoatRoughnessMapTransform;
	varying vec2 vClearcoatRoughnessMapUv;
#endif
#ifdef USE_SHEEN_COLORMAP
	uniform mat3 sheenColorMapTransform;
	varying vec2 vSheenColorMapUv;
#endif
#ifdef USE_SHEEN_ROUGHNESSMAP
	uniform mat3 sheenRoughnessMapTransform;
	varying vec2 vSheenRoughnessMapUv;
#endif
#ifdef USE_IRIDESCENCEMAP
	uniform mat3 iridescenceMapTransform;
	varying vec2 vIridescenceMapUv;
#endif
#ifdef USE_IRIDESCENCE_THICKNESSMAP
	uniform mat3 iridescenceThicknessMapTransform;
	varying vec2 vIridescenceThicknessMapUv;
#endif
#ifdef USE_SPECULARMAP
	uniform mat3 specularMapTransform;
	varying vec2 vSpecularMapUv;
#endif
#ifdef USE_SPECULAR_COLORMAP
	uniform mat3 specularColorMapTransform;
	varying vec2 vSpecularColorMapUv;
#endif
#ifdef USE_SPECULAR_INTENSITYMAP
	uniform mat3 specularIntensityMapTransform;
	varying vec2 vSpecularIntensityMapUv;
#endif
#ifdef USE_TRANSMISSIONMAP
	uniform mat3 transmissionMapTransform;
	varying vec2 vTransmissionMapUv;
#endif
#ifdef USE_THICKNESSMAP
	uniform mat3 thicknessMapTransform;
	varying vec2 vThicknessMapUv;
#endif`,gf=`#if defined( USE_UV ) || defined( USE_ANISOTROPY )
	vUv = vec3( uv, 1 ).xy;
#endif
#ifdef USE_MAP
	vMapUv = ( mapTransform * vec3( MAP_UV, 1 ) ).xy;
#endif
#ifdef USE_ALPHAMAP
	vAlphaMapUv = ( alphaMapTransform * vec3( ALPHAMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_LIGHTMAP
	vLightMapUv = ( lightMapTransform * vec3( LIGHTMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_AOMAP
	vAoMapUv = ( aoMapTransform * vec3( AOMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_BUMPMAP
	vBumpMapUv = ( bumpMapTransform * vec3( BUMPMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_NORMALMAP
	vNormalMapUv = ( normalMapTransform * vec3( NORMALMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_DISPLACEMENTMAP
	vDisplacementMapUv = ( displacementMapTransform * vec3( DISPLACEMENTMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_EMISSIVEMAP
	vEmissiveMapUv = ( emissiveMapTransform * vec3( EMISSIVEMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_METALNESSMAP
	vMetalnessMapUv = ( metalnessMapTransform * vec3( METALNESSMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_ROUGHNESSMAP
	vRoughnessMapUv = ( roughnessMapTransform * vec3( ROUGHNESSMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_ANISOTROPYMAP
	vAnisotropyMapUv = ( anisotropyMapTransform * vec3( ANISOTROPYMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_CLEARCOATMAP
	vClearcoatMapUv = ( clearcoatMapTransform * vec3( CLEARCOATMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_CLEARCOAT_NORMALMAP
	vClearcoatNormalMapUv = ( clearcoatNormalMapTransform * vec3( CLEARCOAT_NORMALMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_CLEARCOAT_ROUGHNESSMAP
	vClearcoatRoughnessMapUv = ( clearcoatRoughnessMapTransform * vec3( CLEARCOAT_ROUGHNESSMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_IRIDESCENCEMAP
	vIridescenceMapUv = ( iridescenceMapTransform * vec3( IRIDESCENCEMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_IRIDESCENCE_THICKNESSMAP
	vIridescenceThicknessMapUv = ( iridescenceThicknessMapTransform * vec3( IRIDESCENCE_THICKNESSMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_SHEEN_COLORMAP
	vSheenColorMapUv = ( sheenColorMapTransform * vec3( SHEEN_COLORMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_SHEEN_ROUGHNESSMAP
	vSheenRoughnessMapUv = ( sheenRoughnessMapTransform * vec3( SHEEN_ROUGHNESSMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_SPECULARMAP
	vSpecularMapUv = ( specularMapTransform * vec3( SPECULARMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_SPECULAR_COLORMAP
	vSpecularColorMapUv = ( specularColorMapTransform * vec3( SPECULAR_COLORMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_SPECULAR_INTENSITYMAP
	vSpecularIntensityMapUv = ( specularIntensityMapTransform * vec3( SPECULAR_INTENSITYMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_TRANSMISSIONMAP
	vTransmissionMapUv = ( transmissionMapTransform * vec3( TRANSMISSIONMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_THICKNESSMAP
	vThicknessMapUv = ( thicknessMapTransform * vec3( THICKNESSMAP_UV, 1 ) ).xy;
#endif`,_f=`#if defined( USE_ENVMAP ) || defined( DISTANCE ) || defined ( USE_SHADOWMAP ) || defined ( USE_TRANSMISSION ) || NUM_SPOT_LIGHT_COORDS > 0
	vec4 worldPosition = vec4( transformed, 1.0 );
	#ifdef USE_BATCHING
		worldPosition = batchingMatrix * worldPosition;
	#endif
	#ifdef USE_INSTANCING
		worldPosition = instanceMatrix * worldPosition;
	#endif
	worldPosition = modelMatrix * worldPosition;
#endif`,xf=`varying vec2 vUv;
uniform mat3 uvTransform;
void main() {
	vUv = ( uvTransform * vec3( uv, 1 ) ).xy;
	gl_Position = vec4( position.xy, 1.0, 1.0 );
}`,yf=`uniform sampler2D t2D;
uniform float backgroundIntensity;
varying vec2 vUv;
void main() {
	vec4 texColor = texture2D( t2D, vUv );
	#ifdef DECODE_VIDEO_TEXTURE
		texColor = vec4( mix( pow( texColor.rgb * 0.9478672986 + vec3( 0.0521327014 ), vec3( 2.4 ) ), texColor.rgb * 0.0773993808, vec3( lessThanEqual( texColor.rgb, vec3( 0.04045 ) ) ) ), texColor.w );
	#endif
	texColor.rgb *= backgroundIntensity;
	gl_FragColor = texColor;
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
}`,vf=`varying vec3 vWorldDirection;
#include <common>
void main() {
	vWorldDirection = transformDirection( position, modelMatrix );
	#include <begin_vertex>
	#include <project_vertex>
	gl_Position.z = gl_Position.w;
}`,Mf=`#ifdef ENVMAP_TYPE_CUBE
	uniform samplerCube envMap;
#elif defined( ENVMAP_TYPE_CUBE_UV )
	uniform sampler2D envMap;
#endif
uniform float flipEnvMap;
uniform float backgroundBlurriness;
uniform float backgroundIntensity;
uniform mat3 backgroundRotation;
varying vec3 vWorldDirection;
#include <cube_uv_reflection_fragment>
void main() {
	#ifdef ENVMAP_TYPE_CUBE
		vec4 texColor = textureCube( envMap, backgroundRotation * vec3( flipEnvMap * vWorldDirection.x, vWorldDirection.yz ) );
	#elif defined( ENVMAP_TYPE_CUBE_UV )
		vec4 texColor = textureCubeUV( envMap, backgroundRotation * vWorldDirection, backgroundBlurriness );
	#else
		vec4 texColor = vec4( 0.0, 0.0, 0.0, 1.0 );
	#endif
	texColor.rgb *= backgroundIntensity;
	gl_FragColor = texColor;
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
}`,Sf=`varying vec3 vWorldDirection;
#include <common>
void main() {
	vWorldDirection = transformDirection( position, modelMatrix );
	#include <begin_vertex>
	#include <project_vertex>
	gl_Position.z = gl_Position.w;
}`,bf=`uniform samplerCube tCube;
uniform float tFlip;
uniform float opacity;
varying vec3 vWorldDirection;
void main() {
	vec4 texColor = textureCube( tCube, vec3( tFlip * vWorldDirection.x, vWorldDirection.yz ) );
	gl_FragColor = texColor;
	gl_FragColor.a *= opacity;
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
}`,Ef=`#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
varying vec2 vHighPrecisionZW;
void main() {
	#include <uv_vertex>
	#include <batching_vertex>
	#include <skinbase_vertex>
	#include <morphinstance_vertex>
	#ifdef USE_DISPLACEMENTMAP
		#include <beginnormal_vertex>
		#include <morphnormal_vertex>
		#include <skinnormal_vertex>
	#endif
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	vHighPrecisionZW = gl_Position.zw;
}`,Tf=`#if DEPTH_PACKING == 3200
	uniform float opacity;
#endif
#include <common>
#include <packing>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
varying vec2 vHighPrecisionZW;
void main() {
	vec4 diffuseColor = vec4( 1.0 );
	#include <clipping_planes_fragment>
	#if DEPTH_PACKING == 3200
		diffuseColor.a = opacity;
	#endif
	#include <map_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <logdepthbuf_fragment>
	#ifdef USE_REVERSED_DEPTH_BUFFER
		float fragCoordZ = vHighPrecisionZW[ 0 ] / vHighPrecisionZW[ 1 ];
	#else
		float fragCoordZ = 0.5 * vHighPrecisionZW[ 0 ] / vHighPrecisionZW[ 1 ] + 0.5;
	#endif
	#if DEPTH_PACKING == 3200
		gl_FragColor = vec4( vec3( 1.0 - fragCoordZ ), opacity );
	#elif DEPTH_PACKING == 3201
		gl_FragColor = packDepthToRGBA( fragCoordZ );
	#elif DEPTH_PACKING == 3202
		gl_FragColor = vec4( packDepthToRGB( fragCoordZ ), 1.0 );
	#elif DEPTH_PACKING == 3203
		gl_FragColor = vec4( packDepthToRG( fragCoordZ ), 0.0, 1.0 );
	#endif
}`,wf=`#define DISTANCE
varying vec3 vWorldPosition;
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <batching_vertex>
	#include <skinbase_vertex>
	#include <morphinstance_vertex>
	#ifdef USE_DISPLACEMENTMAP
		#include <beginnormal_vertex>
		#include <morphnormal_vertex>
		#include <skinnormal_vertex>
	#endif
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <worldpos_vertex>
	#include <clipping_planes_vertex>
	vWorldPosition = worldPosition.xyz;
}`,Af=`#define DISTANCE
uniform vec3 referencePosition;
uniform float nearDistance;
uniform float farDistance;
varying vec3 vWorldPosition;
#include <common>
#include <packing>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <clipping_planes_pars_fragment>
void main () {
	vec4 diffuseColor = vec4( 1.0 );
	#include <clipping_planes_fragment>
	#include <map_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	float dist = length( vWorldPosition - referencePosition );
	dist = ( dist - nearDistance ) / ( farDistance - nearDistance );
	dist = saturate( dist );
	gl_FragColor = packDepthToRGBA( dist );
}`,Cf=`varying vec3 vWorldDirection;
#include <common>
void main() {
	vWorldDirection = transformDirection( position, modelMatrix );
	#include <begin_vertex>
	#include <project_vertex>
}`,Rf=`uniform sampler2D tEquirect;
varying vec3 vWorldDirection;
#include <common>
void main() {
	vec3 direction = normalize( vWorldDirection );
	vec2 sampleUV = equirectUv( direction );
	gl_FragColor = texture2D( tEquirect, sampleUV );
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
}`,If=`uniform float scale;
attribute float lineDistance;
varying float vLineDistance;
#include <common>
#include <uv_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <morphtarget_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	vLineDistance = scale * lineDistance;
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	#include <fog_vertex>
}`,Pf=`uniform vec3 diffuse;
uniform float opacity;
uniform float dashSize;
uniform float totalSize;
varying float vLineDistance;
#include <common>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <fog_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	if ( mod( vLineDistance, totalSize ) > dashSize ) {
		discard;
	}
	vec3 outgoingLight = vec3( 0.0 );
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	outgoingLight = diffuseColor.rgb;
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
}`,Df=`#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <envmap_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#if defined ( USE_ENVMAP ) || defined ( USE_SKINNING )
		#include <beginnormal_vertex>
		#include <morphnormal_vertex>
		#include <skinbase_vertex>
		#include <skinnormal_vertex>
		#include <defaultnormal_vertex>
	#endif
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	#include <worldpos_vertex>
	#include <envmap_vertex>
	#include <fog_vertex>
}`,Lf=`uniform vec3 diffuse;
uniform float opacity;
#ifndef FLAT_SHADED
	varying vec3 vNormal;
#endif
#include <common>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <aomap_pars_fragment>
#include <lightmap_pars_fragment>
#include <envmap_common_pars_fragment>
#include <envmap_pars_fragment>
#include <fog_pars_fragment>
#include <specularmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <specularmap_fragment>
	ReflectedLight reflectedLight = ReflectedLight( vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ) );
	#ifdef USE_LIGHTMAP
		vec4 lightMapTexel = texture2D( lightMap, vLightMapUv );
		reflectedLight.indirectDiffuse += lightMapTexel.rgb * lightMapIntensity * RECIPROCAL_PI;
	#else
		reflectedLight.indirectDiffuse += vec3( 1.0 );
	#endif
	#include <aomap_fragment>
	reflectedLight.indirectDiffuse *= diffuseColor.rgb;
	vec3 outgoingLight = reflectedLight.indirectDiffuse;
	#include <envmap_fragment>
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,Uf=`#define LAMBERT
varying vec3 vViewPosition;
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <envmap_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <shadowmap_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	vViewPosition = - mvPosition.xyz;
	#include <worldpos_vertex>
	#include <envmap_vertex>
	#include <shadowmap_vertex>
	#include <fog_vertex>
}`,Nf=`#define LAMBERT
uniform vec3 diffuse;
uniform vec3 emissive;
uniform float opacity;
#include <common>
#include <packing>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <aomap_pars_fragment>
#include <lightmap_pars_fragment>
#include <emissivemap_pars_fragment>
#include <envmap_common_pars_fragment>
#include <envmap_pars_fragment>
#include <fog_pars_fragment>
#include <bsdfs>
#include <lights_pars_begin>
#include <normal_pars_fragment>
#include <lights_lambert_pars_fragment>
#include <shadowmap_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <specularmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	ReflectedLight reflectedLight = ReflectedLight( vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ) );
	vec3 totalEmissiveRadiance = emissive;
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <specularmap_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	#include <emissivemap_fragment>
	#include <lights_lambert_fragment>
	#include <lights_fragment_begin>
	#include <lights_fragment_maps>
	#include <lights_fragment_end>
	#include <aomap_fragment>
	vec3 outgoingLight = reflectedLight.directDiffuse + reflectedLight.indirectDiffuse + totalEmissiveRadiance;
	#include <envmap_fragment>
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,Ff=`#define MATCAP
varying vec3 vViewPosition;
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <color_pars_vertex>
#include <displacementmap_pars_vertex>
#include <fog_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	#include <fog_vertex>
	vViewPosition = - mvPosition.xyz;
}`,Of=`#define MATCAP
uniform vec3 diffuse;
uniform float opacity;
uniform sampler2D matcap;
varying vec3 vViewPosition;
#include <common>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <fog_pars_fragment>
#include <normal_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	vec3 viewDir = normalize( vViewPosition );
	vec3 x = normalize( vec3( viewDir.z, 0.0, - viewDir.x ) );
	vec3 y = cross( viewDir, x );
	vec2 uv = vec2( dot( x, normal ), dot( y, normal ) ) * 0.495 + 0.5;
	#ifdef USE_MATCAP
		vec4 matcapColor = texture2D( matcap, uv );
	#else
		vec4 matcapColor = vec4( vec3( mix( 0.2, 0.8, uv.y ) ), 1.0 );
	#endif
	vec3 outgoingLight = diffuseColor.rgb * matcapColor.rgb;
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,Bf=`#define NORMAL
#if defined( FLAT_SHADED ) || defined( USE_BUMPMAP ) || defined( USE_NORMALMAP_TANGENTSPACE )
	varying vec3 vViewPosition;
#endif
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphinstance_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
#if defined( FLAT_SHADED ) || defined( USE_BUMPMAP ) || defined( USE_NORMALMAP_TANGENTSPACE )
	vViewPosition = - mvPosition.xyz;
#endif
}`,zf=`#define NORMAL
uniform float opacity;
#if defined( FLAT_SHADED ) || defined( USE_BUMPMAP ) || defined( USE_NORMALMAP_TANGENTSPACE )
	varying vec3 vViewPosition;
#endif
#include <packing>
#include <uv_pars_fragment>
#include <normal_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( 0.0, 0.0, 0.0, opacity );
	#include <clipping_planes_fragment>
	#include <logdepthbuf_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	gl_FragColor = vec4( packNormalToRGB( normal ), diffuseColor.a );
	#ifdef OPAQUE
		gl_FragColor.a = 1.0;
	#endif
}`,kf=`#define PHONG
varying vec3 vViewPosition;
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <envmap_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <shadowmap_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphinstance_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	vViewPosition = - mvPosition.xyz;
	#include <worldpos_vertex>
	#include <envmap_vertex>
	#include <shadowmap_vertex>
	#include <fog_vertex>
}`,Vf=`#define PHONG
uniform vec3 diffuse;
uniform vec3 emissive;
uniform vec3 specular;
uniform float shininess;
uniform float opacity;
#include <common>
#include <packing>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <aomap_pars_fragment>
#include <lightmap_pars_fragment>
#include <emissivemap_pars_fragment>
#include <envmap_common_pars_fragment>
#include <envmap_pars_fragment>
#include <fog_pars_fragment>
#include <bsdfs>
#include <lights_pars_begin>
#include <normal_pars_fragment>
#include <lights_phong_pars_fragment>
#include <shadowmap_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <specularmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	ReflectedLight reflectedLight = ReflectedLight( vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ) );
	vec3 totalEmissiveRadiance = emissive;
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <specularmap_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	#include <emissivemap_fragment>
	#include <lights_phong_fragment>
	#include <lights_fragment_begin>
	#include <lights_fragment_maps>
	#include <lights_fragment_end>
	#include <aomap_fragment>
	vec3 outgoingLight = reflectedLight.directDiffuse + reflectedLight.indirectDiffuse + reflectedLight.directSpecular + reflectedLight.indirectSpecular + totalEmissiveRadiance;
	#include <envmap_fragment>
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,Hf=`#define STANDARD
varying vec3 vViewPosition;
#ifdef USE_TRANSMISSION
	varying vec3 vWorldPosition;
#endif
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <shadowmap_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	vViewPosition = - mvPosition.xyz;
	#include <worldpos_vertex>
	#include <shadowmap_vertex>
	#include <fog_vertex>
#ifdef USE_TRANSMISSION
	vWorldPosition = worldPosition.xyz;
#endif
}`,Gf=`#define STANDARD
#ifdef PHYSICAL
	#define IOR
	#define USE_SPECULAR
#endif
uniform vec3 diffuse;
uniform vec3 emissive;
uniform float roughness;
uniform float metalness;
uniform float opacity;
#ifdef IOR
	uniform float ior;
#endif
#ifdef USE_SPECULAR
	uniform float specularIntensity;
	uniform vec3 specularColor;
	#ifdef USE_SPECULAR_COLORMAP
		uniform sampler2D specularColorMap;
	#endif
	#ifdef USE_SPECULAR_INTENSITYMAP
		uniform sampler2D specularIntensityMap;
	#endif
#endif
#ifdef USE_CLEARCOAT
	uniform float clearcoat;
	uniform float clearcoatRoughness;
#endif
#ifdef USE_DISPERSION
	uniform float dispersion;
#endif
#ifdef USE_IRIDESCENCE
	uniform float iridescence;
	uniform float iridescenceIOR;
	uniform float iridescenceThicknessMinimum;
	uniform float iridescenceThicknessMaximum;
#endif
#ifdef USE_SHEEN
	uniform vec3 sheenColor;
	uniform float sheenRoughness;
	#ifdef USE_SHEEN_COLORMAP
		uniform sampler2D sheenColorMap;
	#endif
	#ifdef USE_SHEEN_ROUGHNESSMAP
		uniform sampler2D sheenRoughnessMap;
	#endif
#endif
#ifdef USE_ANISOTROPY
	uniform vec2 anisotropyVector;
	#ifdef USE_ANISOTROPYMAP
		uniform sampler2D anisotropyMap;
	#endif
#endif
varying vec3 vViewPosition;
#include <common>
#include <packing>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <aomap_pars_fragment>
#include <lightmap_pars_fragment>
#include <emissivemap_pars_fragment>
#include <iridescence_fragment>
#include <cube_uv_reflection_fragment>
#include <envmap_common_pars_fragment>
#include <envmap_physical_pars_fragment>
#include <fog_pars_fragment>
#include <lights_pars_begin>
#include <normal_pars_fragment>
#include <lights_physical_pars_fragment>
#include <transmission_pars_fragment>
#include <shadowmap_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <clearcoat_pars_fragment>
#include <iridescence_pars_fragment>
#include <roughnessmap_pars_fragment>
#include <metalnessmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	ReflectedLight reflectedLight = ReflectedLight( vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ) );
	vec3 totalEmissiveRadiance = emissive;
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <roughnessmap_fragment>
	#include <metalnessmap_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	#include <clearcoat_normal_fragment_begin>
	#include <clearcoat_normal_fragment_maps>
	#include <emissivemap_fragment>
	#include <lights_physical_fragment>
	#include <lights_fragment_begin>
	#include <lights_fragment_maps>
	#include <lights_fragment_end>
	#include <aomap_fragment>
	vec3 totalDiffuse = reflectedLight.directDiffuse + reflectedLight.indirectDiffuse;
	vec3 totalSpecular = reflectedLight.directSpecular + reflectedLight.indirectSpecular;
	#include <transmission_fragment>
	vec3 outgoingLight = totalDiffuse + totalSpecular + totalEmissiveRadiance;
	#ifdef USE_SHEEN
		float sheenEnergyComp = 1.0 - 0.157 * max3( material.sheenColor );
		outgoingLight = outgoingLight * sheenEnergyComp + sheenSpecularDirect + sheenSpecularIndirect;
	#endif
	#ifdef USE_CLEARCOAT
		float dotNVcc = saturate( dot( geometryClearcoatNormal, geometryViewDir ) );
		vec3 Fcc = F_Schlick( material.clearcoatF0, material.clearcoatF90, dotNVcc );
		outgoingLight = outgoingLight * ( 1.0 - material.clearcoat * Fcc ) + ( clearcoatSpecularDirect + clearcoatSpecularIndirect ) * material.clearcoat;
	#endif
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,Wf=`#define TOON
varying vec3 vViewPosition;
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <shadowmap_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	vViewPosition = - mvPosition.xyz;
	#include <worldpos_vertex>
	#include <shadowmap_vertex>
	#include <fog_vertex>
}`,Xf=`#define TOON
uniform vec3 diffuse;
uniform vec3 emissive;
uniform float opacity;
#include <common>
#include <packing>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <aomap_pars_fragment>
#include <lightmap_pars_fragment>
#include <emissivemap_pars_fragment>
#include <gradientmap_pars_fragment>
#include <fog_pars_fragment>
#include <bsdfs>
#include <lights_pars_begin>
#include <normal_pars_fragment>
#include <lights_toon_pars_fragment>
#include <shadowmap_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	ReflectedLight reflectedLight = ReflectedLight( vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ) );
	vec3 totalEmissiveRadiance = emissive;
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	#include <emissivemap_fragment>
	#include <lights_toon_fragment>
	#include <lights_fragment_begin>
	#include <lights_fragment_maps>
	#include <lights_fragment_end>
	#include <aomap_fragment>
	vec3 outgoingLight = reflectedLight.directDiffuse + reflectedLight.indirectDiffuse + totalEmissiveRadiance;
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,qf=`uniform float size;
uniform float scale;
#include <common>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <morphtarget_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
#ifdef USE_POINTS_UV
	varying vec2 vUv;
	uniform mat3 uvTransform;
#endif
void main() {
	#ifdef USE_POINTS_UV
		vUv = ( uvTransform * vec3( uv, 1 ) ).xy;
	#endif
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <project_vertex>
	gl_PointSize = size;
	#ifdef USE_SIZEATTENUATION
		bool isPerspective = isPerspectiveMatrix( projectionMatrix );
		if ( isPerspective ) gl_PointSize *= ( scale / - mvPosition.z );
	#endif
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	#include <worldpos_vertex>
	#include <fog_vertex>
}`,Yf=`uniform vec3 diffuse;
uniform float opacity;
#include <common>
#include <color_pars_fragment>
#include <map_particle_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <fog_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	vec3 outgoingLight = vec3( 0.0 );
	#include <logdepthbuf_fragment>
	#include <map_particle_fragment>
	#include <color_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	outgoingLight = diffuseColor.rgb;
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
}`,Zf=`#include <common>
#include <batching_pars_vertex>
#include <fog_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <shadowmap_pars_vertex>
void main() {
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphinstance_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <worldpos_vertex>
	#include <shadowmap_vertex>
	#include <fog_vertex>
}`,Jf=`uniform vec3 color;
uniform float opacity;
#include <common>
#include <packing>
#include <fog_pars_fragment>
#include <bsdfs>
#include <lights_pars_begin>
#include <logdepthbuf_pars_fragment>
#include <shadowmap_pars_fragment>
#include <shadowmask_pars_fragment>
void main() {
	#include <logdepthbuf_fragment>
	gl_FragColor = vec4( color, opacity * ( 1.0 - getShadowMask() ) );
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
}`,$f=`uniform float rotation;
uniform vec2 center;
#include <common>
#include <uv_pars_vertex>
#include <fog_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	vec4 mvPosition = modelViewMatrix[ 3 ];
	vec2 scale = vec2( length( modelMatrix[ 0 ].xyz ), length( modelMatrix[ 1 ].xyz ) );
	#ifndef USE_SIZEATTENUATION
		bool isPerspective = isPerspectiveMatrix( projectionMatrix );
		if ( isPerspective ) scale *= - mvPosition.z;
	#endif
	vec2 alignedPosition = ( position.xy - ( center - vec2( 0.5 ) ) ) * scale;
	vec2 rotatedPosition;
	rotatedPosition.x = cos( rotation ) * alignedPosition.x - sin( rotation ) * alignedPosition.y;
	rotatedPosition.y = sin( rotation ) * alignedPosition.x + cos( rotation ) * alignedPosition.y;
	mvPosition.xy += rotatedPosition;
	gl_Position = projectionMatrix * mvPosition;
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	#include <fog_vertex>
}`,Kf=`uniform vec3 diffuse;
uniform float opacity;
#include <common>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <fog_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	vec3 outgoingLight = vec3( 0.0 );
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	outgoingLight = diffuseColor.rgb;
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
}`,Bt={alphahash_fragment:xu,alphahash_pars_fragment:yu,alphamap_fragment:vu,alphamap_pars_fragment:Mu,alphatest_fragment:Su,alphatest_pars_fragment:bu,aomap_fragment:Eu,aomap_pars_fragment:Tu,batching_pars_vertex:wu,batching_vertex:Au,begin_vertex:Cu,beginnormal_vertex:Ru,bsdfs:Iu,iridescence_fragment:Pu,bumpmap_pars_fragment:Du,clipping_planes_fragment:Lu,clipping_planes_pars_fragment:Uu,clipping_planes_pars_vertex:Nu,clipping_planes_vertex:Fu,color_fragment:Ou,color_pars_fragment:Bu,color_pars_vertex:zu,color_vertex:ku,common:Vu,cube_uv_reflection_fragment:Hu,defaultnormal_vertex:Gu,displacementmap_pars_vertex:Wu,displacementmap_vertex:Xu,emissivemap_fragment:qu,emissivemap_pars_fragment:Yu,colorspace_fragment:Zu,colorspace_pars_fragment:Ju,envmap_fragment:$u,envmap_common_pars_fragment:Ku,envmap_pars_fragment:ju,envmap_pars_vertex:Qu,envmap_physical_pars_fragment:hd,envmap_vertex:td,fog_vertex:ed,fog_pars_vertex:nd,fog_fragment:id,fog_pars_fragment:sd,gradientmap_pars_fragment:rd,lightmap_pars_fragment:ad,lights_lambert_fragment:od,lights_lambert_pars_fragment:ld,lights_pars_begin:cd,lights_toon_fragment:ud,lights_toon_pars_fragment:dd,lights_phong_fragment:fd,lights_phong_pars_fragment:pd,lights_physical_fragment:md,lights_physical_pars_fragment:gd,lights_fragment_begin:_d,lights_fragment_maps:xd,lights_fragment_end:yd,logdepthbuf_fragment:vd,logdepthbuf_pars_fragment:Md,logdepthbuf_pars_vertex:Sd,logdepthbuf_vertex:bd,map_fragment:Ed,map_pars_fragment:Td,map_particle_fragment:wd,map_particle_pars_fragment:Ad,metalnessmap_fragment:Cd,metalnessmap_pars_fragment:Rd,morphinstance_vertex:Id,morphcolor_vertex:Pd,morphnormal_vertex:Dd,morphtarget_pars_vertex:Ld,morphtarget_vertex:Ud,normal_fragment_begin:Nd,normal_fragment_maps:Fd,normal_pars_fragment:Od,normal_pars_vertex:Bd,normal_vertex:zd,normalmap_pars_fragment:kd,clearcoat_normal_fragment_begin:Vd,clearcoat_normal_fragment_maps:Hd,clearcoat_pars_fragment:Gd,iridescence_pars_fragment:Wd,opaque_fragment:Xd,packing:qd,premultiplied_alpha_fragment:Yd,project_vertex:Zd,dithering_fragment:Jd,dithering_pars_fragment:$d,roughnessmap_fragment:Kd,roughnessmap_pars_fragment:jd,shadowmap_pars_fragment:Qd,shadowmap_pars_vertex:tf,shadowmap_vertex:ef,shadowmask_pars_fragment:nf,skinbase_vertex:sf,skinning_pars_vertex:rf,skinning_vertex:af,skinnormal_vertex:of,specularmap_fragment:lf,specularmap_pars_fragment:cf,tonemapping_fragment:hf,tonemapping_pars_fragment:uf,transmission_fragment:df,transmission_pars_fragment:ff,uv_pars_fragment:pf,uv_pars_vertex:mf,uv_vertex:gf,worldpos_vertex:_f,background_vert:xf,background_frag:yf,backgroundCube_vert:vf,backgroundCube_frag:Mf,cube_vert:Sf,cube_frag:bf,depth_vert:Ef,depth_frag:Tf,distanceRGBA_vert:wf,distanceRGBA_frag:Af,equirect_vert:Cf,equirect_frag:Rf,linedashed_vert:If,linedashed_frag:Pf,meshbasic_vert:Df,meshbasic_frag:Lf,meshlambert_vert:Uf,meshlambert_frag:Nf,meshmatcap_vert:Ff,meshmatcap_frag:Of,meshnormal_vert:Bf,meshnormal_frag:zf,meshphong_vert:kf,meshphong_frag:Vf,meshphysical_vert:Hf,meshphysical_frag:Gf,meshtoon_vert:Wf,meshtoon_frag:Xf,points_vert:qf,points_frag:Yf,shadow_vert:Zf,shadow_frag:Jf,sprite_vert:$f,sprite_frag:Kf},st={common:{diffuse:{value:new Ht(16777215)},opacity:{value:1},map:{value:null},mapTransform:{value:new Ut},alphaMap:{value:null},alphaMapTransform:{value:new Ut},alphaTest:{value:0}},specularmap:{specularMap:{value:null},specularMapTransform:{value:new Ut}},envmap:{envMap:{value:null},envMapRotation:{value:new Ut},flipEnvMap:{value:-1},reflectivity:{value:1},ior:{value:1.5},refractionRatio:{value:.98}},aomap:{aoMap:{value:null},aoMapIntensity:{value:1},aoMapTransform:{value:new Ut}},lightmap:{lightMap:{value:null},lightMapIntensity:{value:1},lightMapTransform:{value:new Ut}},bumpmap:{bumpMap:{value:null},bumpMapTransform:{value:new Ut},bumpScale:{value:1}},normalmap:{normalMap:{value:null},normalMapTransform:{value:new Ut},normalScale:{value:new Rt(1,1)}},displacementmap:{displacementMap:{value:null},displacementMapTransform:{value:new Ut},displacementScale:{value:1},displacementBias:{value:0}},emissivemap:{emissiveMap:{value:null},emissiveMapTransform:{value:new Ut}},metalnessmap:{metalnessMap:{value:null},metalnessMapTransform:{value:new Ut}},roughnessmap:{roughnessMap:{value:null},roughnessMapTransform:{value:new Ut}},gradientmap:{gradientMap:{value:null}},fog:{fogDensity:{value:25e-5},fogNear:{value:1},fogFar:{value:2e3},fogColor:{value:new Ht(16777215)}},lights:{ambientLightColor:{value:[]},lightProbe:{value:[]},directionalLights:{value:[],properties:{direction:{},color:{}}},directionalLightShadows:{value:[],properties:{shadowIntensity:1,shadowBias:{},shadowNormalBias:{},shadowRadius:{},shadowMapSize:{}}},directionalShadowMap:{value:[]},directionalShadowMatrix:{value:[]},spotLights:{value:[],properties:{color:{},position:{},direction:{},distance:{},coneCos:{},penumbraCos:{},decay:{}}},spotLightShadows:{value:[],properties:{shadowIntensity:1,shadowBias:{},shadowNormalBias:{},shadowRadius:{},shadowMapSize:{}}},spotLightMap:{value:[]},spotShadowMap:{value:[]},spotLightMatrix:{value:[]},pointLights:{value:[],properties:{color:{},position:{},decay:{},distance:{}}},pointLightShadows:{value:[],properties:{shadowIntensity:1,shadowBias:{},shadowNormalBias:{},shadowRadius:{},shadowMapSize:{},shadowCameraNear:{},shadowCameraFar:{}}},pointShadowMap:{value:[]},pointShadowMatrix:{value:[]},hemisphereLights:{value:[],properties:{direction:{},skyColor:{},groundColor:{}}},rectAreaLights:{value:[],properties:{color:{},position:{},width:{},height:{}}},ltc_1:{value:null},ltc_2:{value:null}},points:{diffuse:{value:new Ht(16777215)},opacity:{value:1},size:{value:1},scale:{value:1},map:{value:null},alphaMap:{value:null},alphaMapTransform:{value:new Ut},alphaTest:{value:0},uvTransform:{value:new Ut}},sprite:{diffuse:{value:new Ht(16777215)},opacity:{value:1},center:{value:new Rt(.5,.5)},rotation:{value:0},map:{value:null},mapTransform:{value:new Ut},alphaMap:{value:null},alphaMapTransform:{value:new Ut},alphaTest:{value:0}}},_n={basic:{uniforms:Ce([st.common,st.specularmap,st.envmap,st.aomap,st.lightmap,st.fog]),vertexShader:Bt.meshbasic_vert,fragmentShader:Bt.meshbasic_frag},lambert:{uniforms:Ce([st.common,st.specularmap,st.envmap,st.aomap,st.lightmap,st.emissivemap,st.bumpmap,st.normalmap,st.displacementmap,st.fog,st.lights,{emissive:{value:new Ht(0)}}]),vertexShader:Bt.meshlambert_vert,fragmentShader:Bt.meshlambert_frag},phong:{uniforms:Ce([st.common,st.specularmap,st.envmap,st.aomap,st.lightmap,st.emissivemap,st.bumpmap,st.normalmap,st.displacementmap,st.fog,st.lights,{emissive:{value:new Ht(0)},specular:{value:new Ht(1118481)},shininess:{value:30}}]),vertexShader:Bt.meshphong_vert,fragmentShader:Bt.meshphong_frag},standard:{uniforms:Ce([st.common,st.envmap,st.aomap,st.lightmap,st.emissivemap,st.bumpmap,st.normalmap,st.displacementmap,st.roughnessmap,st.metalnessmap,st.fog,st.lights,{emissive:{value:new Ht(0)},roughness:{value:1},metalness:{value:0},envMapIntensity:{value:1}}]),vertexShader:Bt.meshphysical_vert,fragmentShader:Bt.meshphysical_frag},toon:{uniforms:Ce([st.common,st.aomap,st.lightmap,st.emissivemap,st.bumpmap,st.normalmap,st.displacementmap,st.gradientmap,st.fog,st.lights,{emissive:{value:new Ht(0)}}]),vertexShader:Bt.meshtoon_vert,fragmentShader:Bt.meshtoon_frag},matcap:{uniforms:Ce([st.common,st.bumpmap,st.normalmap,st.displacementmap,st.fog,{matcap:{value:null}}]),vertexShader:Bt.meshmatcap_vert,fragmentShader:Bt.meshmatcap_frag},points:{uniforms:Ce([st.points,st.fog]),vertexShader:Bt.points_vert,fragmentShader:Bt.points_frag},dashed:{uniforms:Ce([st.common,st.fog,{scale:{value:1},dashSize:{value:1},totalSize:{value:2}}]),vertexShader:Bt.linedashed_vert,fragmentShader:Bt.linedashed_frag},depth:{uniforms:Ce([st.common,st.displacementmap]),vertexShader:Bt.depth_vert,fragmentShader:Bt.depth_frag},normal:{uniforms:Ce([st.common,st.bumpmap,st.normalmap,st.displacementmap,{opacity:{value:1}}]),vertexShader:Bt.meshnormal_vert,fragmentShader:Bt.meshnormal_frag},sprite:{uniforms:Ce([st.sprite,st.fog]),vertexShader:Bt.sprite_vert,fragmentShader:Bt.sprite_frag},background:{uniforms:{uvTransform:{value:new Ut},t2D:{value:null},backgroundIntensity:{value:1}},vertexShader:Bt.background_vert,fragmentShader:Bt.background_frag},backgroundCube:{uniforms:{envMap:{value:null},flipEnvMap:{value:-1},backgroundBlurriness:{value:0},backgroundIntensity:{value:1},backgroundRotation:{value:new Ut}},vertexShader:Bt.backgroundCube_vert,fragmentShader:Bt.backgroundCube_frag},cube:{uniforms:{tCube:{value:null},tFlip:{value:-1},opacity:{value:1}},vertexShader:Bt.cube_vert,fragmentShader:Bt.cube_frag},equirect:{uniforms:{tEquirect:{value:null}},vertexShader:Bt.equirect_vert,fragmentShader:Bt.equirect_frag},distanceRGBA:{uniforms:Ce([st.common,st.displacementmap,{referencePosition:{value:new N},nearDistance:{value:1},farDistance:{value:1e3}}]),vertexShader:Bt.distanceRGBA_vert,fragmentShader:Bt.distanceRGBA_frag},shadow:{uniforms:Ce([st.lights,st.fog,{color:{value:new Ht(0)},opacity:{value:1}}]),vertexShader:Bt.shadow_vert,fragmentShader:Bt.shadow_frag}};_n.physical={uniforms:Ce([_n.standard.uniforms,{clearcoat:{value:0},clearcoatMap:{value:null},clearcoatMapTransform:{value:new Ut},clearcoatNormalMap:{value:null},clearcoatNormalMapTransform:{value:new Ut},clearcoatNormalScale:{value:new Rt(1,1)},clearcoatRoughness:{value:0},clearcoatRoughnessMap:{value:null},clearcoatRoughnessMapTransform:{value:new Ut},dispersion:{value:0},iridescence:{value:0},iridescenceMap:{value:null},iridescenceMapTransform:{value:new Ut},iridescenceIOR:{value:1.3},iridescenceThicknessMinimum:{value:100},iridescenceThicknessMaximum:{value:400},iridescenceThicknessMap:{value:null},iridescenceThicknessMapTransform:{value:new Ut},sheen:{value:0},sheenColor:{value:new Ht(0)},sheenColorMap:{value:null},sheenColorMapTransform:{value:new Ut},sheenRoughness:{value:1},sheenRoughnessMap:{value:null},sheenRoughnessMapTransform:{value:new Ut},transmission:{value:0},transmissionMap:{value:null},transmissionMapTransform:{value:new Ut},transmissionSamplerSize:{value:new Rt},transmissionSamplerMap:{value:null},thickness:{value:0},thicknessMap:{value:null},thicknessMapTransform:{value:new Ut},attenuationDistance:{value:0},attenuationColor:{value:new Ht(0)},specularColor:{value:new Ht(1,1,1)},specularColorMap:{value:null},specularColorMapTransform:{value:new Ut},specularIntensity:{value:1},specularIntensityMap:{value:null},specularIntensityMapTransform:{value:new Ut},anisotropyVector:{value:new Rt},anisotropyMap:{value:null},anisotropyMapTransform:{value:new Ut}}]),vertexShader:Bt.meshphysical_vert,fragmentShader:Bt.meshphysical_frag};var Ma={r:0,b:0,g:0},di=new sn,jf=new ce;function Qf(i,t,e,n,s,r,a){let o=new Ht(0),l=r===!0?0:1,c,u,d=null,f=0,p=null;function _(E){let S=E.isScene===!0?E.background:null;return S&&S.isTexture&&(S=(E.backgroundBlurriness>0?e:t).get(S)),S}function v(E){let S=!1,C=_(E);C===null?h(o,l):C&&C.isColor&&(h(C,1),S=!0);let A=i.xr.getEnvironmentBlendMode();A==="additive"?n.buffers.color.setClear(0,0,0,1,a):A==="alpha-blend"&&n.buffers.color.setClear(0,0,0,0,a),(i.autoClear||S)&&(n.buffers.depth.setTest(!0),n.buffers.depth.setMask(!0),n.buffers.color.setMask(!0),i.clear(i.autoClearColor,i.autoClearDepth,i.autoClearStencil))}function m(E,S){let C=_(S);C&&(C.isCubeTexture||C.mapping===Is)?(u===void 0&&(u=new Me(new kn(1,1,1),new rn({name:"BackgroundCubeMaterial",uniforms:ui(_n.backgroundCube.uniforms),vertexShader:_n.backgroundCube.vertexShader,fragmentShader:_n.backgroundCube.fragmentShader,side:De,depthTest:!1,depthWrite:!1,fog:!1,allowOverride:!1})),u.geometry.deleteAttribute("normal"),u.geometry.deleteAttribute("uv"),u.onBeforeRender=function(A,P,U){this.matrixWorld.copyPosition(U.matrixWorld)},Object.defineProperty(u.material,"envMap",{get:function(){return this.uniforms.envMap.value}}),s.update(u)),di.copy(S.backgroundRotation),di.x*=-1,di.y*=-1,di.z*=-1,C.isCubeTexture&&C.isRenderTargetTexture===!1&&(di.y*=-1,di.z*=-1),u.material.uniforms.envMap.value=C,u.material.uniforms.flipEnvMap.value=C.isCubeTexture&&C.isRenderTargetTexture===!1?-1:1,u.material.uniforms.backgroundBlurriness.value=S.backgroundBlurriness,u.material.uniforms.backgroundIntensity.value=S.backgroundIntensity,u.material.uniforms.backgroundRotation.value.setFromMatrix4(jf.makeRotationFromEuler(di)),u.material.toneMapped=Wt.getTransfer(C.colorSpace)!==Zt,(d!==C||f!==C.version||p!==i.toneMapping)&&(u.material.needsUpdate=!0,d=C,f=C.version,p=i.toneMapping),u.layers.enableAll(),E.unshift(u,u.geometry,u.material,0,0,null)):C&&C.isTexture&&(c===void 0&&(c=new Me(new ai(2,2),new rn({name:"BackgroundMaterial",uniforms:ui(_n.background.uniforms),vertexShader:_n.background.vertexShader,fragmentShader:_n.background.fragmentShader,side:Tn,depthTest:!1,depthWrite:!1,fog:!1,allowOverride:!1})),c.geometry.deleteAttribute("normal"),Object.defineProperty(c.material,"map",{get:function(){return this.uniforms.t2D.value}}),s.update(c)),c.material.uniforms.t2D.value=C,c.material.uniforms.backgroundIntensity.value=S.backgroundIntensity,c.material.toneMapped=Wt.getTransfer(C.colorSpace)!==Zt,C.matrixAutoUpdate===!0&&C.updateMatrix(),c.material.uniforms.uvTransform.value.copy(C.matrix),(d!==C||f!==C.version||p!==i.toneMapping)&&(c.material.needsUpdate=!0,d=C,f=C.version,p=i.toneMapping),c.layers.enableAll(),E.unshift(c,c.geometry,c.material,0,0,null))}function h(E,S){E.getRGB(Ma,Uo(i)),n.buffers.color.setClear(Ma.r,Ma.g,Ma.b,S,a)}function w(){u!==void 0&&(u.geometry.dispose(),u.material.dispose(),u=void 0),c!==void 0&&(c.geometry.dispose(),c.material.dispose(),c=void 0)}return{getClearColor:function(){return o},setClearColor:function(E,S=1){o.set(E),l=S,h(o,l)},getClearAlpha:function(){return l},setClearAlpha:function(E){l=E,h(o,l)},render:v,addToRenderList:m,dispose:w}}function tp(i,t){let e=i.getParameter(i.MAX_VERTEX_ATTRIBS),n={},s=f(null),r=s,a=!1;function o(y,I,O,k,G){let q=!1,W=d(k,O,I);r!==W&&(r=W,c(r.object)),q=p(y,k,O,G),q&&_(y,k,O,G),G!==null&&t.update(G,i.ELEMENT_ARRAY_BUFFER),(q||a)&&(a=!1,S(y,I,O,k),G!==null&&i.bindBuffer(i.ELEMENT_ARRAY_BUFFER,t.get(G).buffer))}function l(){return i.createVertexArray()}function c(y){return i.bindVertexArray(y)}function u(y){return i.deleteVertexArray(y)}function d(y,I,O){let k=O.wireframe===!0,G=n[y.id];G===void 0&&(G={},n[y.id]=G);let q=G[I.id];q===void 0&&(q={},G[I.id]=q);let W=q[k];return W===void 0&&(W=f(l()),q[k]=W),W}function f(y){let I=[],O=[],k=[];for(let G=0;G<e;G++)I[G]=0,O[G]=0,k[G]=0;return{geometry:null,program:null,wireframe:!1,newAttributes:I,enabledAttributes:O,attributeDivisors:k,object:y,attributes:{},index:null}}function p(y,I,O,k){let G=r.attributes,q=I.attributes,W=0,et=O.getAttributes();for(let V in et)if(et[V].location>=0){let ct=G[V],St=q[V];if(St===void 0&&(V==="instanceMatrix"&&y.instanceMatrix&&(St=y.instanceMatrix),V==="instanceColor"&&y.instanceColor&&(St=y.instanceColor)),ct===void 0||ct.attribute!==St||St&&ct.data!==St.data)return!0;W++}return r.attributesNum!==W||r.index!==k}function _(y,I,O,k){let G={},q=I.attributes,W=0,et=O.getAttributes();for(let V in et)if(et[V].location>=0){let ct=q[V];ct===void 0&&(V==="instanceMatrix"&&y.instanceMatrix&&(ct=y.instanceMatrix),V==="instanceColor"&&y.instanceColor&&(ct=y.instanceColor));let St={};St.attribute=ct,ct&&ct.data&&(St.data=ct.data),G[V]=St,W++}r.attributes=G,r.attributesNum=W,r.index=k}function v(){let y=r.newAttributes;for(let I=0,O=y.length;I<O;I++)y[I]=0}function m(y){h(y,0)}function h(y,I){let O=r.newAttributes,k=r.enabledAttributes,G=r.attributeDivisors;O[y]=1,k[y]===0&&(i.enableVertexAttribArray(y),k[y]=1),G[y]!==I&&(i.vertexAttribDivisor(y,I),G[y]=I)}function w(){let y=r.newAttributes,I=r.enabledAttributes;for(let O=0,k=I.length;O<k;O++)I[O]!==y[O]&&(i.disableVertexAttribArray(O),I[O]=0)}function E(y,I,O,k,G,q,W){W===!0?i.vertexAttribIPointer(y,I,O,G,q):i.vertexAttribPointer(y,I,O,k,G,q)}function S(y,I,O,k){v();let G=k.attributes,q=O.getAttributes(),W=I.defaultAttributeValues;for(let et in q){let V=q[et];if(V.location>=0){let rt=G[et];if(rt===void 0&&(et==="instanceMatrix"&&y.instanceMatrix&&(rt=y.instanceMatrix),et==="instanceColor"&&y.instanceColor&&(rt=y.instanceColor)),rt!==void 0){let ct=rt.normalized,St=rt.itemSize,kt=t.get(rt);if(kt===void 0)continue;let jt=kt.buffer,ne=kt.type,qt=kt.bytesPerElement,Y=ne===i.INT||ne===i.UNSIGNED_INT||rt.gpuType===Vr;if(rt.isInterleavedBufferAttribute){let $=rt.data,dt=$.stride,Pt=rt.offset;if($.isInstancedInterleavedBuffer){for(let Mt=0;Mt<V.locationSize;Mt++)h(V.location+Mt,$.meshPerAttribute);y.isInstancedMesh!==!0&&k._maxInstanceCount===void 0&&(k._maxInstanceCount=$.meshPerAttribute*$.count)}else for(let Mt=0;Mt<V.locationSize;Mt++)m(V.location+Mt);i.bindBuffer(i.ARRAY_BUFFER,jt);for(let Mt=0;Mt<V.locationSize;Mt++)E(V.location+Mt,St/V.locationSize,ne,ct,dt*qt,(Pt+St/V.locationSize*Mt)*qt,Y)}else{if(rt.isInstancedBufferAttribute){for(let $=0;$<V.locationSize;$++)h(V.location+$,rt.meshPerAttribute);y.isInstancedMesh!==!0&&k._maxInstanceCount===void 0&&(k._maxInstanceCount=rt.meshPerAttribute*rt.count)}else for(let $=0;$<V.locationSize;$++)m(V.location+$);i.bindBuffer(i.ARRAY_BUFFER,jt);for(let $=0;$<V.locationSize;$++)E(V.location+$,St/V.locationSize,ne,ct,St*qt,St/V.locationSize*$*qt,Y)}}else if(W!==void 0){let ct=W[et];if(ct!==void 0)switch(ct.length){case 2:i.vertexAttrib2fv(V.location,ct);break;case 3:i.vertexAttrib3fv(V.location,ct);break;case 4:i.vertexAttrib4fv(V.location,ct);break;default:i.vertexAttrib1fv(V.location,ct)}}}}w()}function C(){U();for(let y in n){let I=n[y];for(let O in I){let k=I[O];for(let G in k)u(k[G].object),delete k[G];delete I[O]}delete n[y]}}function A(y){if(n[y.id]===void 0)return;let I=n[y.id];for(let O in I){let k=I[O];for(let G in k)u(k[G].object),delete k[G];delete I[O]}delete n[y.id]}function P(y){for(let I in n){let O=n[I];if(O[y.id]===void 0)continue;let k=O[y.id];for(let G in k)u(k[G].object),delete k[G];delete O[y.id]}}function U(){M(),a=!0,r!==s&&(r=s,c(r.object))}function M(){s.geometry=null,s.program=null,s.wireframe=!1}return{setup:o,reset:U,resetDefaultState:M,dispose:C,releaseStatesOfGeometry:A,releaseStatesOfProgram:P,initAttributes:v,enableAttribute:m,disableUnusedAttributes:w}}function ep(i,t,e){let n;function s(c){n=c}function r(c,u){i.drawArrays(n,c,u),e.update(u,n,1)}function a(c,u,d){d!==0&&(i.drawArraysInstanced(n,c,u,d),e.update(u,n,d))}function o(c,u,d){if(d===0)return;t.get("WEBGL_multi_draw").multiDrawArraysWEBGL(n,c,0,u,0,d);let p=0;for(let _=0;_<d;_++)p+=u[_];e.update(p,n,1)}function l(c,u,d,f){if(d===0)return;let p=t.get("WEBGL_multi_draw");if(p===null)for(let _=0;_<c.length;_++)a(c[_],u[_],f[_]);else{p.multiDrawArraysInstancedWEBGL(n,c,0,u,0,f,0,d);let _=0;for(let v=0;v<d;v++)_+=u[v]*f[v];e.update(_,n,1)}}this.setMode=s,this.render=r,this.renderInstances=a,this.renderMultiDraw=o,this.renderMultiDrawInstances=l}function np(i,t,e,n){let s;function r(){if(s!==void 0)return s;if(t.has("EXT_texture_filter_anisotropic")===!0){let P=t.get("EXT_texture_filter_anisotropic");s=i.getParameter(P.MAX_TEXTURE_MAX_ANISOTROPY_EXT)}else s=0;return s}function a(P){return!(P!==$e&&n.convert(P)!==i.getParameter(i.IMPLEMENTATION_COLOR_READ_FORMAT))}function o(P){let U=P===Gi&&(t.has("EXT_color_buffer_half_float")||t.has("EXT_color_buffer_float"));return!(P!==an&&n.convert(P)!==i.getParameter(i.IMPLEMENTATION_COLOR_READ_TYPE)&&P!==gn&&!U)}function l(P){if(P==="highp"){if(i.getShaderPrecisionFormat(i.VERTEX_SHADER,i.HIGH_FLOAT).precision>0&&i.getShaderPrecisionFormat(i.FRAGMENT_SHADER,i.HIGH_FLOAT).precision>0)return"highp";P="mediump"}return P==="mediump"&&i.getShaderPrecisionFormat(i.VERTEX_SHADER,i.MEDIUM_FLOAT).precision>0&&i.getShaderPrecisionFormat(i.FRAGMENT_SHADER,i.MEDIUM_FLOAT).precision>0?"mediump":"lowp"}let c=e.precision!==void 0?e.precision:"highp",u=l(c);u!==c&&(console.warn("THREE.WebGLRenderer:",c,"not supported, using",u,"instead."),c=u);let d=e.logarithmicDepthBuffer===!0,f=e.reversedDepthBuffer===!0&&t.has("EXT_clip_control"),p=i.getParameter(i.MAX_TEXTURE_IMAGE_UNITS),_=i.getParameter(i.MAX_VERTEX_TEXTURE_IMAGE_UNITS),v=i.getParameter(i.MAX_TEXTURE_SIZE),m=i.getParameter(i.MAX_CUBE_MAP_TEXTURE_SIZE),h=i.getParameter(i.MAX_VERTEX_ATTRIBS),w=i.getParameter(i.MAX_VERTEX_UNIFORM_VECTORS),E=i.getParameter(i.MAX_VARYING_VECTORS),S=i.getParameter(i.MAX_FRAGMENT_UNIFORM_VECTORS),C=_>0,A=i.getParameter(i.MAX_SAMPLES);return{isWebGL2:!0,getMaxAnisotropy:r,getMaxPrecision:l,textureFormatReadable:a,textureTypeReadable:o,precision:c,logarithmicDepthBuffer:d,reversedDepthBuffer:f,maxTextures:p,maxVertexTextures:_,maxTextureSize:v,maxCubemapSize:m,maxAttributes:h,maxVertexUniforms:w,maxVaryings:E,maxFragmentUniforms:S,vertexTextures:C,maxSamples:A}}function ip(i){let t=this,e=null,n=0,s=!1,r=!1,a=new Ye,o=new Ut,l={value:null,needsUpdate:!1};this.uniform=l,this.numPlanes=0,this.numIntersection=0,this.init=function(d,f){let p=d.length!==0||f||n!==0||s;return s=f,n=d.length,p},this.beginShadows=function(){r=!0,u(null)},this.endShadows=function(){r=!1},this.setGlobalState=function(d,f){e=u(d,f,0)},this.setState=function(d,f,p){let _=d.clippingPlanes,v=d.clipIntersection,m=d.clipShadows,h=i.get(d);if(!s||_===null||_.length===0||r&&!m)r?u(null):c();else{let w=r?0:n,E=w*4,S=h.clippingState||null;l.value=S,S=u(_,f,E,p);for(let C=0;C!==E;++C)S[C]=e[C];h.clippingState=S,this.numIntersection=v?this.numPlanes:0,this.numPlanes+=w}};function c(){l.value!==e&&(l.value=e,l.needsUpdate=n>0),t.numPlanes=n,t.numIntersection=0}function u(d,f,p,_){let v=d!==null?d.length:0,m=null;if(v!==0){if(m=l.value,_!==!0||m===null){let h=p+v*4,w=f.matrixWorldInverse;o.getNormalMatrix(w),(m===null||m.length<h)&&(m=new Float32Array(h));for(let E=0,S=p;E!==v;++E,S+=4)a.copy(d[E]).applyMatrix4(w,o),a.normal.toArray(m,S),m[S+3]=a.constant}l.value=m,l.needsUpdate=!0}return t.numPlanes=v,t.numIntersection=0,m}}function sp(i){let t=new WeakMap;function e(a,o){return o===Br?a.mapping=ci:o===zr&&(a.mapping=hi),a}function n(a){if(a&&a.isTexture){let o=a.mapping;if(o===Br||o===zr)if(t.has(a)){let l=t.get(a).texture;return e(l,a.mapping)}else{let l=a.image;if(l&&l.height>0){let c=new gr(l.height);return c.fromEquirectangularTexture(i,a),t.set(a,c),a.addEventListener("dispose",s),e(c.texture,a.mapping)}else return null}}return a}function s(a){let o=a.target;o.removeEventListener("dispose",s);let l=t.get(o);l!==void 0&&(t.delete(o),l.dispose())}function r(){t=new WeakMap}return{get:n,dispose:r}}var Zi=4,Tc=[.125,.215,.35,.446,.526,.582],mi=20,Bo=new li,wc=new Ht,zo=null,ko=0,Vo=0,Ho=!1,pi=(1+Math.sqrt(5))/2,Yi=1/pi,Ac=[new N(-pi,Yi,0),new N(pi,Yi,0),new N(-Yi,0,pi),new N(Yi,0,pi),new N(0,pi,-Yi),new N(0,pi,Yi),new N(-1,1,-1),new N(1,1,-1),new N(-1,1,1),new N(1,1,1)],rp=new N,Ea=class{constructor(t){this._renderer=t,this._pingPongRenderTarget=null,this._lodMax=0,this._cubeSize=0,this._lodPlanes=[],this._sizeLods=[],this._sigmas=[],this._blurMaterial=null,this._cubemapMaterial=null,this._equirectMaterial=null,this._compileMaterial(this._blurMaterial)}fromScene(t,e=0,n=.1,s=100,r={}){let{size:a=256,position:o=rp}=r;zo=this._renderer.getRenderTarget(),ko=this._renderer.getActiveCubeFace(),Vo=this._renderer.getActiveMipmapLevel(),Ho=this._renderer.xr.enabled,this._renderer.xr.enabled=!1,this._setSize(a);let l=this._allocateTargets();return l.depthBuffer=!0,this._sceneToCubeUV(t,n,s,l,o),e>0&&this._blur(l,0,0,e),this._applyPMREM(l),this._cleanup(l),l}fromEquirectangular(t,e=null){return this._fromTexture(t,e)}fromCubemap(t,e=null){return this._fromTexture(t,e)}compileCubemapShader(){this._cubemapMaterial===null&&(this._cubemapMaterial=Ic(),this._compileMaterial(this._cubemapMaterial))}compileEquirectangularShader(){this._equirectMaterial===null&&(this._equirectMaterial=Rc(),this._compileMaterial(this._equirectMaterial))}dispose(){this._dispose(),this._cubemapMaterial!==null&&this._cubemapMaterial.dispose(),this._equirectMaterial!==null&&this._equirectMaterial.dispose()}_setSize(t){this._lodMax=Math.floor(Math.log2(t)),this._cubeSize=Math.pow(2,this._lodMax)}_dispose(){this._blurMaterial!==null&&this._blurMaterial.dispose(),this._pingPongRenderTarget!==null&&this._pingPongRenderTarget.dispose();for(let t=0;t<this._lodPlanes.length;t++)this._lodPlanes[t].dispose()}_cleanup(t){this._renderer.setRenderTarget(zo,ko,Vo),this._renderer.xr.enabled=Ho,t.scissorTest=!1,Sa(t,0,0,t.width,t.height)}_fromTexture(t,e){t.mapping===ci||t.mapping===hi?this._setSize(t.image.length===0?16:t.image[0].width||t.image[0].image.width):this._setSize(t.image.width/4),zo=this._renderer.getRenderTarget(),ko=this._renderer.getActiveCubeFace(),Vo=this._renderer.getActiveMipmapLevel(),Ho=this._renderer.xr.enabled,this._renderer.xr.enabled=!1;let n=e||this._allocateTargets();return this._textureToCubeUV(t,n),this._applyPMREM(n),this._cleanup(n),n}_allocateTargets(){let t=3*Math.max(this._cubeSize,112),e=4*this._cubeSize,n={magFilter:nn,minFilter:nn,generateMipmaps:!1,type:Gi,format:$e,colorSpace:ii,depthBuffer:!1},s=Cc(t,e,n);if(this._pingPongRenderTarget===null||this._pingPongRenderTarget.width!==t||this._pingPongRenderTarget.height!==e){this._pingPongRenderTarget!==null&&this._dispose(),this._pingPongRenderTarget=Cc(t,e,n);let{_lodMax:r}=this;({sizeLods:this._sizeLods,lodPlanes:this._lodPlanes,sigmas:this._sigmas}=ap(r)),this._blurMaterial=op(r,t,e)}return s}_compileMaterial(t){let e=new Me(this._lodPlanes[0],t);this._renderer.compile(e,Bo)}_sceneToCubeUV(t,e,n,s,r){let l=new Ue(90,1,e,n),c=[1,-1,1,1,1,1],u=[1,1,1,-1,-1,-1],d=this._renderer,f=d.autoClear,p=d.toneMapping;d.getClearColor(wc),d.toneMapping=An,d.autoClear=!1,d.state.buffers.depth.getReversed()&&(d.setRenderTarget(s),d.clearDepth(),d.setRenderTarget(null));let v=new ri({name:"PMREM.Background",side:De,depthWrite:!1,depthTest:!1}),m=new Me(new kn,v),h=!1,w=t.background;w?w.isColor&&(v.color.copy(w),t.background=null,h=!0):(v.color.copy(wc),h=!0);for(let E=0;E<6;E++){let S=E%3;S===0?(l.up.set(0,c[E],0),l.position.set(r.x,r.y,r.z),l.lookAt(r.x+u[E],r.y,r.z)):S===1?(l.up.set(0,0,c[E]),l.position.set(r.x,r.y,r.z),l.lookAt(r.x,r.y+u[E],r.z)):(l.up.set(0,c[E],0),l.position.set(r.x,r.y,r.z),l.lookAt(r.x,r.y,r.z+u[E]));let C=this._cubeSize;Sa(s,S*C,E>2?C:0,C,C),d.setRenderTarget(s),h&&d.render(m,l),d.render(t,l)}m.geometry.dispose(),m.material.dispose(),d.toneMapping=p,d.autoClear=f,t.background=w}_textureToCubeUV(t,e){let n=this._renderer,s=t.mapping===ci||t.mapping===hi;s?(this._cubemapMaterial===null&&(this._cubemapMaterial=Ic()),this._cubemapMaterial.uniforms.flipEnvMap.value=t.isRenderTargetTexture===!1?-1:1):this._equirectMaterial===null&&(this._equirectMaterial=Rc());let r=s?this._cubemapMaterial:this._equirectMaterial,a=new Me(this._lodPlanes[0],r),o=r.uniforms;o.envMap.value=t;let l=this._cubeSize;Sa(e,0,0,3*l,2*l),n.setRenderTarget(e),n.render(a,Bo)}_applyPMREM(t){let e=this._renderer,n=e.autoClear;e.autoClear=!1;let s=this._lodPlanes.length;for(let r=1;r<s;r++){let a=Math.sqrt(this._sigmas[r]*this._sigmas[r]-this._sigmas[r-1]*this._sigmas[r-1]),o=Ac[(s-r-1)%Ac.length];this._blur(t,r-1,r,a,o)}e.autoClear=n}_blur(t,e,n,s,r){let a=this._pingPongRenderTarget;this._halfBlur(t,a,e,n,s,"latitudinal",r),this._halfBlur(a,t,n,n,s,"longitudinal",r)}_halfBlur(t,e,n,s,r,a,o){let l=this._renderer,c=this._blurMaterial;a!=="latitudinal"&&a!=="longitudinal"&&console.error("blur direction must be either latitudinal or longitudinal!");let u=3,d=new Me(this._lodPlanes[s],c),f=c.uniforms,p=this._sizeLods[n]-1,_=isFinite(r)?Math.PI/(2*p):2*Math.PI/(2*mi-1),v=r/_,m=isFinite(r)?1+Math.floor(u*v):mi;m>mi&&console.warn(`sigmaRadians, ${r}, is too large and will clip, as it requested ${m} samples when the maximum is set to ${mi}`);let h=[],w=0;for(let P=0;P<mi;++P){let U=P/v,M=Math.exp(-U*U/2);h.push(M),P===0?w+=M:P<m&&(w+=2*M)}for(let P=0;P<h.length;P++)h[P]=h[P]/w;f.envMap.value=t.texture,f.samples.value=m,f.weights.value=h,f.latitudinal.value=a==="latitudinal",o&&(f.poleAxis.value=o);let{_lodMax:E}=this;f.dTheta.value=_,f.mipInt.value=E-n;let S=this._sizeLods[s],C=3*S*(s>E-Zi?s-E+Zi:0),A=4*(this._cubeSize-S);Sa(e,C,A,3*S,2*S),l.setRenderTarget(e),l.render(d,Bo)}};function ap(i){let t=[],e=[],n=[],s=i,r=i-Zi+1+Tc.length;for(let a=0;a<r;a++){let o=Math.pow(2,s);e.push(o);let l=1/o;a>i-Zi?l=Tc[a-i+Zi-1]:a===0&&(l=0),n.push(l);let c=1/(o-2),u=-c,d=1+c,f=[u,u,d,u,d,d,u,u,d,d,u,d],p=6,_=6,v=3,m=2,h=1,w=new Float32Array(v*_*p),E=new Float32Array(m*_*p),S=new Float32Array(h*_*p);for(let A=0;A<p;A++){let P=A%3*2/3-1,U=A>2?0:-1,M=[P,U,0,P+2/3,U,0,P+2/3,U+1,0,P,U,0,P+2/3,U+1,0,P,U+1,0];w.set(M,v*_*A),E.set(f,m*_*A);let y=[A,A,A,A,A,A];S.set(y,h*_*A)}let C=new fn;C.setAttribute("position",new Ve(w,v)),C.setAttribute("uv",new Ve(E,m)),C.setAttribute("faceIndex",new Ve(S,h)),t.push(C),s>Zi&&s--}return{lodPlanes:t,sizeLods:e,sigmas:n}}function Cc(i,t,e){let n=new dn(i,t,e);return n.texture.mapping=Is,n.texture.name="PMREM.cubeUv",n.scissorTest=!0,n}function Sa(i,t,e,n,s){i.viewport.set(t,e,n,s),i.scissor.set(t,e,n,s)}function op(i,t,e){let n=new Float32Array(mi),s=new N(0,1,0);return new rn({name:"SphericalGaussianBlur",defines:{n:mi,CUBEUV_TEXEL_WIDTH:1/t,CUBEUV_TEXEL_HEIGHT:1/e,CUBEUV_MAX_MIP:`${i}.0`},uniforms:{envMap:{value:null},samples:{value:1},weights:{value:n},latitudinal:{value:!1},dTheta:{value:0},mipInt:{value:0},poleAxis:{value:s}},vertexShader:jo(),fragmentShader:`

			precision mediump float;
			precision mediump int;

			varying vec3 vOutputDirection;

			uniform sampler2D envMap;
			uniform int samples;
			uniform float weights[ n ];
			uniform bool latitudinal;
			uniform float dTheta;
			uniform float mipInt;
			uniform vec3 poleAxis;

			#define ENVMAP_TYPE_CUBE_UV
			#include <cube_uv_reflection_fragment>

			vec3 getSample( float theta, vec3 axis ) {

				float cosTheta = cos( theta );
				// Rodrigues' axis-angle rotation
				vec3 sampleDirection = vOutputDirection * cosTheta
					+ cross( axis, vOutputDirection ) * sin( theta )
					+ axis * dot( axis, vOutputDirection ) * ( 1.0 - cosTheta );

				return bilinearCubeUV( envMap, sampleDirection, mipInt );

			}

			void main() {

				vec3 axis = latitudinal ? poleAxis : cross( poleAxis, vOutputDirection );

				if ( all( equal( axis, vec3( 0.0 ) ) ) ) {

					axis = vec3( vOutputDirection.z, 0.0, - vOutputDirection.x );

				}

				axis = normalize( axis );

				gl_FragColor = vec4( 0.0, 0.0, 0.0, 1.0 );
				gl_FragColor.rgb += weights[ 0 ] * getSample( 0.0, axis );

				for ( int i = 1; i < n; i++ ) {

					if ( i >= samples ) {

						break;

					}

					float theta = dTheta * float( i );
					gl_FragColor.rgb += weights[ i ] * getSample( -1.0 * theta, axis );
					gl_FragColor.rgb += weights[ i ] * getSample( theta, axis );

				}

			}
		`,blending:wn,depthTest:!1,depthWrite:!1})}function Rc(){return new rn({name:"EquirectangularToCubeUV",uniforms:{envMap:{value:null}},vertexShader:jo(),fragmentShader:`

			precision mediump float;
			precision mediump int;

			varying vec3 vOutputDirection;

			uniform sampler2D envMap;

			#include <common>

			void main() {

				vec3 outputDirection = normalize( vOutputDirection );
				vec2 uv = equirectUv( outputDirection );

				gl_FragColor = vec4( texture2D ( envMap, uv ).rgb, 1.0 );

			}
		`,blending:wn,depthTest:!1,depthWrite:!1})}function Ic(){return new rn({name:"CubemapToCubeUV",uniforms:{envMap:{value:null},flipEnvMap:{value:-1}},vertexShader:jo(),fragmentShader:`

			precision mediump float;
			precision mediump int;

			uniform float flipEnvMap;

			varying vec3 vOutputDirection;

			uniform samplerCube envMap;

			void main() {

				gl_FragColor = textureCube( envMap, vec3( flipEnvMap * vOutputDirection.x, vOutputDirection.yz ) );

			}
		`,blending:wn,depthTest:!1,depthWrite:!1})}function jo(){return`

		precision mediump float;
		precision mediump int;

		attribute float faceIndex;

		varying vec3 vOutputDirection;

		// RH coordinate system; PMREM face-indexing convention
		vec3 getDirection( vec2 uv, float face ) {

			uv = 2.0 * uv - 1.0;

			vec3 direction = vec3( uv, 1.0 );

			if ( face == 0.0 ) {

				direction = direction.zyx; // ( 1, v, u ) pos x

			} else if ( face == 1.0 ) {

				direction = direction.xzy;
				direction.xz *= -1.0; // ( -u, 1, -v ) pos y

			} else if ( face == 2.0 ) {

				direction.x *= -1.0; // ( -u, v, 1 ) pos z

			} else if ( face == 3.0 ) {

				direction = direction.zyx;
				direction.xz *= -1.0; // ( -1, v, -u ) neg x

			} else if ( face == 4.0 ) {

				direction = direction.xzy;
				direction.xy *= -1.0; // ( -u, -1, v ) neg y

			} else if ( face == 5.0 ) {

				direction.z *= -1.0; // ( u, v, -1 ) neg z

			}

			return direction;

		}

		void main() {

			vOutputDirection = getDirection( uv, faceIndex );
			gl_Position = vec4( position, 1.0 );

		}
	`}function lp(i){let t=new WeakMap,e=null;function n(o){if(o&&o.isTexture){let l=o.mapping,c=l===Br||l===zr,u=l===ci||l===hi;if(c||u){let d=t.get(o),f=d!==void 0?d.texture.pmremVersion:0;if(o.isRenderTargetTexture&&o.pmremVersion!==f)return e===null&&(e=new Ea(i)),d=c?e.fromEquirectangular(o,d):e.fromCubemap(o,d),d.texture.pmremVersion=o.pmremVersion,t.set(o,d),d.texture;if(d!==void 0)return d.texture;{let p=o.image;return c&&p&&p.height>0||u&&p&&s(p)?(e===null&&(e=new Ea(i)),d=c?e.fromEquirectangular(o):e.fromCubemap(o),d.texture.pmremVersion=o.pmremVersion,t.set(o,d),o.addEventListener("dispose",r),d.texture):null}}}return o}function s(o){let l=0,c=6;for(let u=0;u<c;u++)o[u]!==void 0&&l++;return l===c}function r(o){let l=o.target;l.removeEventListener("dispose",r);let c=t.get(l);c!==void 0&&(t.delete(l),c.dispose())}function a(){t=new WeakMap,e!==null&&(e.dispose(),e=null)}return{get:n,dispose:a}}function cp(i){let t={};function e(n){if(t[n]!==void 0)return t[n];let s;switch(n){case"WEBGL_depth_texture":s=i.getExtension("WEBGL_depth_texture")||i.getExtension("MOZ_WEBGL_depth_texture")||i.getExtension("WEBKIT_WEBGL_depth_texture");break;case"EXT_texture_filter_anisotropic":s=i.getExtension("EXT_texture_filter_anisotropic")||i.getExtension("MOZ_EXT_texture_filter_anisotropic")||i.getExtension("WEBKIT_EXT_texture_filter_anisotropic");break;case"WEBGL_compressed_texture_s3tc":s=i.getExtension("WEBGL_compressed_texture_s3tc")||i.getExtension("MOZ_WEBGL_compressed_texture_s3tc")||i.getExtension("WEBKIT_WEBGL_compressed_texture_s3tc");break;case"WEBGL_compressed_texture_pvrtc":s=i.getExtension("WEBGL_compressed_texture_pvrtc")||i.getExtension("WEBKIT_WEBGL_compressed_texture_pvrtc");break;default:s=i.getExtension(n)}return t[n]=s,s}return{has:function(n){return e(n)!==null},init:function(){e("EXT_color_buffer_float"),e("WEBGL_clip_cull_distance"),e("OES_texture_float_linear"),e("EXT_color_buffer_half_float"),e("WEBGL_multisampled_render_to_texture"),e("WEBGL_render_shared_exponent")},get:function(n){let s=e(n);return s===null&&Ni("THREE.WebGLRenderer: "+n+" extension not supported."),s}}}function hp(i,t,e,n){let s={},r=new WeakMap;function a(d){let f=d.target;f.index!==null&&t.remove(f.index);for(let _ in f.attributes)t.remove(f.attributes[_]);f.removeEventListener("dispose",a),delete s[f.id];let p=r.get(f);p&&(t.remove(p),r.delete(f)),n.releaseStatesOfGeometry(f),f.isInstancedBufferGeometry===!0&&delete f._maxInstanceCount,e.memory.geometries--}function o(d,f){return s[f.id]===!0||(f.addEventListener("dispose",a),s[f.id]=!0,e.memory.geometries++),f}function l(d){let f=d.attributes;for(let p in f)t.update(f[p],i.ARRAY_BUFFER)}function c(d){let f=[],p=d.index,_=d.attributes.position,v=0;if(p!==null){let w=p.array;v=p.version;for(let E=0,S=w.length;E<S;E+=3){let C=w[E+0],A=w[E+1],P=w[E+2];f.push(C,A,A,P,P,C)}}else if(_!==void 0){let w=_.array;v=_.version;for(let E=0,S=w.length/3-1;E<S;E+=3){let C=E+0,A=E+1,P=E+2;f.push(C,A,A,P,P,C)}}else return;let m=new(Lo(f)?ps:fs)(f,1);m.version=v;let h=r.get(d);h&&t.remove(h),r.set(d,m)}function u(d){let f=r.get(d);if(f){let p=d.index;p!==null&&f.version<p.version&&c(d)}else c(d);return r.get(d)}return{get:o,update:l,getWireframeAttribute:u}}function up(i,t,e){let n;function s(f){n=f}let r,a;function o(f){r=f.type,a=f.bytesPerElement}function l(f,p){i.drawElements(n,p,r,f*a),e.update(p,n,1)}function c(f,p,_){_!==0&&(i.drawElementsInstanced(n,p,r,f*a,_),e.update(p,n,_))}function u(f,p,_){if(_===0)return;t.get("WEBGL_multi_draw").multiDrawElementsWEBGL(n,p,0,r,f,0,_);let m=0;for(let h=0;h<_;h++)m+=p[h];e.update(m,n,1)}function d(f,p,_,v){if(_===0)return;let m=t.get("WEBGL_multi_draw");if(m===null)for(let h=0;h<f.length;h++)c(f[h]/a,p[h],v[h]);else{m.multiDrawElementsInstancedWEBGL(n,p,0,r,f,0,v,0,_);let h=0;for(let w=0;w<_;w++)h+=p[w]*v[w];e.update(h,n,1)}}this.setMode=s,this.setIndex=o,this.render=l,this.renderInstances=c,this.renderMultiDraw=u,this.renderMultiDrawInstances=d}function dp(i){let t={geometries:0,textures:0},e={frame:0,calls:0,triangles:0,points:0,lines:0};function n(r,a,o){switch(e.calls++,a){case i.TRIANGLES:e.triangles+=o*(r/3);break;case i.LINES:e.lines+=o*(r/2);break;case i.LINE_STRIP:e.lines+=o*(r-1);break;case i.LINE_LOOP:e.lines+=o*r;break;case i.POINTS:e.points+=o*r;break;default:console.error("THREE.WebGLInfo: Unknown draw mode:",a);break}}function s(){e.calls=0,e.triangles=0,e.points=0,e.lines=0}return{memory:t,render:e,programs:null,autoReset:!0,reset:s,update:n}}function fp(i,t,e){let n=new WeakMap,s=new oe;function r(a,o,l){let c=a.morphTargetInfluences,u=o.morphAttributes.position||o.morphAttributes.normal||o.morphAttributes.color,d=u!==void 0?u.length:0,f=n.get(o);if(f===void 0||f.count!==d){let M=function(){P.dispose(),n.delete(o),o.removeEventListener("dispose",M)};f!==void 0&&f.texture.dispose();let p=o.morphAttributes.position!==void 0,_=o.morphAttributes.normal!==void 0,v=o.morphAttributes.color!==void 0,m=o.morphAttributes.position||[],h=o.morphAttributes.normal||[],w=o.morphAttributes.color||[],E=0;p===!0&&(E=1),_===!0&&(E=2),v===!0&&(E=3);let S=o.attributes.position.count*E,C=1;S>t.maxTextureSize&&(C=Math.ceil(S/t.maxTextureSize),S=t.maxTextureSize);let A=new Float32Array(S*C*4*d),P=new ds(A,S,C,d);P.type=gn,P.needsUpdate=!0;let U=E*4;for(let y=0;y<d;y++){let I=m[y],O=h[y],k=w[y],G=S*C*4*y;for(let q=0;q<I.count;q++){let W=q*U;p===!0&&(s.fromBufferAttribute(I,q),A[G+W+0]=s.x,A[G+W+1]=s.y,A[G+W+2]=s.z,A[G+W+3]=0),_===!0&&(s.fromBufferAttribute(O,q),A[G+W+4]=s.x,A[G+W+5]=s.y,A[G+W+6]=s.z,A[G+W+7]=0),v===!0&&(s.fromBufferAttribute(k,q),A[G+W+8]=s.x,A[G+W+9]=s.y,A[G+W+10]=s.z,A[G+W+11]=k.itemSize===4?s.w:1)}}f={count:d,texture:P,size:new Rt(S,C)},n.set(o,f),o.addEventListener("dispose",M)}if(a.isInstancedMesh===!0&&a.morphTexture!==null)l.getUniforms().setValue(i,"morphTexture",a.morphTexture,e);else{let p=0;for(let v=0;v<c.length;v++)p+=c[v];let _=o.morphTargetsRelative?1:1-p;l.getUniforms().setValue(i,"morphTargetBaseInfluence",_),l.getUniforms().setValue(i,"morphTargetInfluences",c)}l.getUniforms().setValue(i,"morphTargetsTexture",f.texture,e),l.getUniforms().setValue(i,"morphTargetsTextureSize",f.size)}return{update:r}}function pp(i,t,e,n){let s=new WeakMap;function r(l){let c=n.render.frame,u=l.geometry,d=t.get(l,u);if(s.get(d)!==c&&(t.update(d),s.set(d,c)),l.isInstancedMesh&&(l.hasEventListener("dispose",o)===!1&&l.addEventListener("dispose",o),s.get(l)!==c&&(e.update(l.instanceMatrix,i.ARRAY_BUFFER),l.instanceColor!==null&&e.update(l.instanceColor,i.ARRAY_BUFFER),s.set(l,c))),l.isSkinnedMesh){let f=l.skeleton;s.get(f)!==c&&(f.update(),s.set(f,c))}return d}function a(){s=new WeakMap}function o(l){let c=l.target;c.removeEventListener("dispose",o),e.remove(c.instanceMatrix),c.instanceColor!==null&&e.remove(c.instanceColor)}return{update:r,dispose:a}}var Jc=new Ne,Pc=new ys(1,1),$c=new ds,Kc=new pr,jc=new gs,Dc=[],Lc=[],Uc=new Float32Array(16),Nc=new Float32Array(9),Fc=new Float32Array(4);function $i(i,t,e){let n=i[0];if(n<=0||n>0)return i;let s=t*e,r=Dc[s];if(r===void 0&&(r=new Float32Array(s),Dc[s]=r),t!==0){n.toArray(r,0);for(let a=1,o=0;a!==t;++a)o+=e,i[a].toArray(r,o)}return r}function me(i,t){if(i.length!==t.length)return!1;for(let e=0,n=i.length;e<n;e++)if(i[e]!==t[e])return!1;return!0}function ge(i,t){for(let e=0,n=t.length;e<n;e++)i[e]=t[e]}function wa(i,t){let e=Lc[t];e===void 0&&(e=new Int32Array(t),Lc[t]=e);for(let n=0;n!==t;++n)e[n]=i.allocateTextureUnit();return e}function mp(i,t){let e=this.cache;e[0]!==t&&(i.uniform1f(this.addr,t),e[0]=t)}function gp(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y)&&(i.uniform2f(this.addr,t.x,t.y),e[0]=t.x,e[1]=t.y);else{if(me(e,t))return;i.uniform2fv(this.addr,t),ge(e,t)}}function _p(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z)&&(i.uniform3f(this.addr,t.x,t.y,t.z),e[0]=t.x,e[1]=t.y,e[2]=t.z);else if(t.r!==void 0)(e[0]!==t.r||e[1]!==t.g||e[2]!==t.b)&&(i.uniform3f(this.addr,t.r,t.g,t.b),e[0]=t.r,e[1]=t.g,e[2]=t.b);else{if(me(e,t))return;i.uniform3fv(this.addr,t),ge(e,t)}}function xp(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z||e[3]!==t.w)&&(i.uniform4f(this.addr,t.x,t.y,t.z,t.w),e[0]=t.x,e[1]=t.y,e[2]=t.z,e[3]=t.w);else{if(me(e,t))return;i.uniform4fv(this.addr,t),ge(e,t)}}function yp(i,t){let e=this.cache,n=t.elements;if(n===void 0){if(me(e,t))return;i.uniformMatrix2fv(this.addr,!1,t),ge(e,t)}else{if(me(e,n))return;Fc.set(n),i.uniformMatrix2fv(this.addr,!1,Fc),ge(e,n)}}function vp(i,t){let e=this.cache,n=t.elements;if(n===void 0){if(me(e,t))return;i.uniformMatrix3fv(this.addr,!1,t),ge(e,t)}else{if(me(e,n))return;Nc.set(n),i.uniformMatrix3fv(this.addr,!1,Nc),ge(e,n)}}function Mp(i,t){let e=this.cache,n=t.elements;if(n===void 0){if(me(e,t))return;i.uniformMatrix4fv(this.addr,!1,t),ge(e,t)}else{if(me(e,n))return;Uc.set(n),i.uniformMatrix4fv(this.addr,!1,Uc),ge(e,n)}}function Sp(i,t){let e=this.cache;e[0]!==t&&(i.uniform1i(this.addr,t),e[0]=t)}function bp(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y)&&(i.uniform2i(this.addr,t.x,t.y),e[0]=t.x,e[1]=t.y);else{if(me(e,t))return;i.uniform2iv(this.addr,t),ge(e,t)}}function Ep(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z)&&(i.uniform3i(this.addr,t.x,t.y,t.z),e[0]=t.x,e[1]=t.y,e[2]=t.z);else{if(me(e,t))return;i.uniform3iv(this.addr,t),ge(e,t)}}function Tp(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z||e[3]!==t.w)&&(i.uniform4i(this.addr,t.x,t.y,t.z,t.w),e[0]=t.x,e[1]=t.y,e[2]=t.z,e[3]=t.w);else{if(me(e,t))return;i.uniform4iv(this.addr,t),ge(e,t)}}function wp(i,t){let e=this.cache;e[0]!==t&&(i.uniform1ui(this.addr,t),e[0]=t)}function Ap(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y)&&(i.uniform2ui(this.addr,t.x,t.y),e[0]=t.x,e[1]=t.y);else{if(me(e,t))return;i.uniform2uiv(this.addr,t),ge(e,t)}}function Cp(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z)&&(i.uniform3ui(this.addr,t.x,t.y,t.z),e[0]=t.x,e[1]=t.y,e[2]=t.z);else{if(me(e,t))return;i.uniform3uiv(this.addr,t),ge(e,t)}}function Rp(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z||e[3]!==t.w)&&(i.uniform4ui(this.addr,t.x,t.y,t.z,t.w),e[0]=t.x,e[1]=t.y,e[2]=t.z,e[3]=t.w);else{if(me(e,t))return;i.uniform4uiv(this.addr,t),ge(e,t)}}function Ip(i,t,e){let n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s);let r;this.type===i.SAMPLER_2D_SHADOW?(Pc.compareFunction=Ro,r=Pc):r=Jc,e.setTexture2D(t||r,s)}function Pp(i,t,e){let n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s),e.setTexture3D(t||Kc,s)}function Dp(i,t,e){let n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s),e.setTextureCube(t||jc,s)}function Lp(i,t,e){let n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s),e.setTexture2DArray(t||$c,s)}function Up(i){switch(i){case 5126:return mp;case 35664:return gp;case 35665:return _p;case 35666:return xp;case 35674:return yp;case 35675:return vp;case 35676:return Mp;case 5124:case 35670:return Sp;case 35667:case 35671:return bp;case 35668:case 35672:return Ep;case 35669:case 35673:return Tp;case 5125:return wp;case 36294:return Ap;case 36295:return Cp;case 36296:return Rp;case 35678:case 36198:case 36298:case 36306:case 35682:return Ip;case 35679:case 36299:case 36307:return Pp;case 35680:case 36300:case 36308:case 36293:return Dp;case 36289:case 36303:case 36311:case 36292:return Lp}}function Np(i,t){i.uniform1fv(this.addr,t)}function Fp(i,t){let e=$i(t,this.size,2);i.uniform2fv(this.addr,e)}function Op(i,t){let e=$i(t,this.size,3);i.uniform3fv(this.addr,e)}function Bp(i,t){let e=$i(t,this.size,4);i.uniform4fv(this.addr,e)}function zp(i,t){let e=$i(t,this.size,4);i.uniformMatrix2fv(this.addr,!1,e)}function kp(i,t){let e=$i(t,this.size,9);i.uniformMatrix3fv(this.addr,!1,e)}function Vp(i,t){let e=$i(t,this.size,16);i.uniformMatrix4fv(this.addr,!1,e)}function Hp(i,t){i.uniform1iv(this.addr,t)}function Gp(i,t){i.uniform2iv(this.addr,t)}function Wp(i,t){i.uniform3iv(this.addr,t)}function Xp(i,t){i.uniform4iv(this.addr,t)}function qp(i,t){i.uniform1uiv(this.addr,t)}function Yp(i,t){i.uniform2uiv(this.addr,t)}function Zp(i,t){i.uniform3uiv(this.addr,t)}function Jp(i,t){i.uniform4uiv(this.addr,t)}function $p(i,t,e){let n=this.cache,s=t.length,r=wa(e,s);me(n,r)||(i.uniform1iv(this.addr,r),ge(n,r));for(let a=0;a!==s;++a)e.setTexture2D(t[a]||Jc,r[a])}function Kp(i,t,e){let n=this.cache,s=t.length,r=wa(e,s);me(n,r)||(i.uniform1iv(this.addr,r),ge(n,r));for(let a=0;a!==s;++a)e.setTexture3D(t[a]||Kc,r[a])}function jp(i,t,e){let n=this.cache,s=t.length,r=wa(e,s);me(n,r)||(i.uniform1iv(this.addr,r),ge(n,r));for(let a=0;a!==s;++a)e.setTextureCube(t[a]||jc,r[a])}function Qp(i,t,e){let n=this.cache,s=t.length,r=wa(e,s);me(n,r)||(i.uniform1iv(this.addr,r),ge(n,r));for(let a=0;a!==s;++a)e.setTexture2DArray(t[a]||$c,r[a])}function tm(i){switch(i){case 5126:return Np;case 35664:return Fp;case 35665:return Op;case 35666:return Bp;case 35674:return zp;case 35675:return kp;case 35676:return Vp;case 5124:case 35670:return Hp;case 35667:case 35671:return Gp;case 35668:case 35672:return Wp;case 35669:case 35673:return Xp;case 5125:return qp;case 36294:return Yp;case 36295:return Zp;case 36296:return Jp;case 35678:case 36198:case 36298:case 36306:case 35682:return $p;case 35679:case 36299:case 36307:return Kp;case 35680:case 36300:case 36308:case 36293:return jp;case 36289:case 36303:case 36311:case 36292:return Qp}}var Wo=class{constructor(t,e,n){this.id=t,this.addr=n,this.cache=[],this.type=e.type,this.setValue=Up(e.type)}},Xo=class{constructor(t,e,n){this.id=t,this.addr=n,this.cache=[],this.type=e.type,this.size=e.size,this.setValue=tm(e.type)}},qo=class{constructor(t){this.id=t,this.seq=[],this.map={}}setValue(t,e,n){let s=this.seq;for(let r=0,a=s.length;r!==a;++r){let o=s[r];o.setValue(t,e[o.id],n)}}},Go=/(\w+)(\])?(\[|\.)?/g;function Oc(i,t){i.seq.push(t),i.map[t.id]=t}function em(i,t,e){let n=i.name,s=n.length;for(Go.lastIndex=0;;){let r=Go.exec(n),a=Go.lastIndex,o=r[1],l=r[2]==="]",c=r[3];if(l&&(o=o|0),c===void 0||c==="["&&a+2===s){Oc(e,c===void 0?new Wo(o,i,t):new Xo(o,i,t));break}else{let d=e.map[o];d===void 0&&(d=new qo(o),Oc(e,d)),e=d}}}var Ji=class{constructor(t,e){this.seq=[],this.map={};let n=t.getProgramParameter(e,t.ACTIVE_UNIFORMS);for(let s=0;s<n;++s){let r=t.getActiveUniform(e,s),a=t.getUniformLocation(e,r.name);em(r,a,this)}}setValue(t,e,n,s){let r=this.map[e];r!==void 0&&r.setValue(t,n,s)}setOptional(t,e,n){let s=e[n];s!==void 0&&this.setValue(t,n,s)}static upload(t,e,n,s){for(let r=0,a=e.length;r!==a;++r){let o=e[r],l=n[o.id];l.needsUpdate!==!1&&o.setValue(t,l.value,s)}}static seqWithValue(t,e){let n=[];for(let s=0,r=t.length;s!==r;++s){let a=t[s];a.id in e&&n.push(a)}return n}};function Bc(i,t,e){let n=i.createShader(t);return i.shaderSource(n,e),i.compileShader(n),n}var nm=37297,im=0;function sm(i,t){let e=i.split(`
`),n=[],s=Math.max(t-6,0),r=Math.min(t+6,e.length);for(let a=s;a<r;a++){let o=a+1;n.push(`${o===t?">":" "} ${o}: ${e[a]}`)}return n.join(`
`)}var zc=new Ut;function rm(i){Wt._getMatrix(zc,Wt.workingColorSpace,i);let t=`mat3( ${zc.elements.map(e=>e.toFixed(4))} )`;switch(Wt.getTransfer(i)){case cs:return[t,"LinearTransferOETF"];case Zt:return[t,"sRGBTransferOETF"];default:return console.warn("THREE.WebGLProgram: Unsupported color space: ",i),[t,"LinearTransferOETF"]}}function kc(i,t,e){let n=i.getShaderParameter(t,i.COMPILE_STATUS),r=(i.getShaderInfoLog(t)||"").trim();if(n&&r==="")return"";let a=/ERROR: 0:(\d+)/.exec(r);if(a){let o=parseInt(a[1]);return e.toUpperCase()+`

`+r+`

`+sm(i.getShaderSource(t),o)}else return r}function am(i,t){let e=rm(t);return[`vec4 ${i}( vec4 value ) {`,`	return ${e[1]}( vec4( value.rgb * ${e[0]}, value.a ) );`,"}"].join(`
`)}function om(i,t){let e;switch(t){case ic:e="Linear";break;case sc:e="Reinhard";break;case rc:e="Cineon";break;case Or:e="ACESFilmic";break;case oc:e="AgX";break;case lc:e="Neutral";break;case ac:e="Custom";break;default:console.warn("THREE.WebGLProgram: Unsupported toneMapping:",t),e="Linear"}return"vec3 "+i+"( vec3 color ) { return "+e+"ToneMapping( color ); }"}var ba=new N;function lm(){Wt.getLuminanceCoefficients(ba);let i=ba.x.toFixed(4),t=ba.y.toFixed(4),e=ba.z.toFixed(4);return["float luminance( const in vec3 rgb ) {",`	const vec3 weights = vec3( ${i}, ${t}, ${e} );`,"	return dot( weights, rgb );","}"].join(`
`)}function cm(i){return[i.extensionClipCullDistance?"#extension GL_ANGLE_clip_cull_distance : require":"",i.extensionMultiDraw?"#extension GL_ANGLE_multi_draw : require":""].filter(Fs).join(`
`)}function hm(i){let t=[];for(let e in i){let n=i[e];n!==!1&&t.push("#define "+e+" "+n)}return t.join(`
`)}function um(i,t){let e={},n=i.getProgramParameter(t,i.ACTIVE_ATTRIBUTES);for(let s=0;s<n;s++){let r=i.getActiveAttrib(t,s),a=r.name,o=1;r.type===i.FLOAT_MAT2&&(o=2),r.type===i.FLOAT_MAT3&&(o=3),r.type===i.FLOAT_MAT4&&(o=4),e[a]={type:r.type,location:i.getAttribLocation(t,a),locationSize:o}}return e}function Fs(i){return i!==""}function Vc(i,t){let e=t.numSpotLightShadows+t.numSpotLightMaps-t.numSpotLightShadowsWithMaps;return i.replace(/NUM_DIR_LIGHTS/g,t.numDirLights).replace(/NUM_SPOT_LIGHTS/g,t.numSpotLights).replace(/NUM_SPOT_LIGHT_MAPS/g,t.numSpotLightMaps).replace(/NUM_SPOT_LIGHT_COORDS/g,e).replace(/NUM_RECT_AREA_LIGHTS/g,t.numRectAreaLights).replace(/NUM_POINT_LIGHTS/g,t.numPointLights).replace(/NUM_HEMI_LIGHTS/g,t.numHemiLights).replace(/NUM_DIR_LIGHT_SHADOWS/g,t.numDirLightShadows).replace(/NUM_SPOT_LIGHT_SHADOWS_WITH_MAPS/g,t.numSpotLightShadowsWithMaps).replace(/NUM_SPOT_LIGHT_SHADOWS/g,t.numSpotLightShadows).replace(/NUM_POINT_LIGHT_SHADOWS/g,t.numPointLightShadows)}function Hc(i,t){return i.replace(/NUM_CLIPPING_PLANES/g,t.numClippingPlanes).replace(/UNION_CLIPPING_PLANES/g,t.numClippingPlanes-t.numClipIntersection)}var dm=/^[ \t]*#include +<([\w\d./]+)>/gm;function Yo(i){return i.replace(dm,pm)}var fm=new Map;function pm(i,t){let e=Bt[t];if(e===void 0){let n=fm.get(t);if(n!==void 0)e=Bt[n],console.warn('THREE.WebGLRenderer: Shader chunk "%s" has been deprecated. Use "%s" instead.',t,n);else throw new Error("Can not resolve #include <"+t+">")}return Yo(e)}var mm=/#pragma unroll_loop_start\s+for\s*\(\s*int\s+i\s*=\s*(\d+)\s*;\s*i\s*<\s*(\d+)\s*;\s*i\s*\+\+\s*\)\s*{([\s\S]+?)}\s+#pragma unroll_loop_end/g;function Gc(i){return i.replace(mm,gm)}function gm(i,t,e,n){let s="";for(let r=parseInt(t);r<parseInt(e);r++)s+=n.replace(/\[\s*i\s*\]/g,"[ "+r+" ]").replace(/UNROLLED_LOOP_INDEX/g,r);return s}function Wc(i){let t=`precision ${i.precision} float;
	precision ${i.precision} int;
	precision ${i.precision} sampler2D;
	precision ${i.precision} samplerCube;
	precision ${i.precision} sampler3D;
	precision ${i.precision} sampler2DArray;
	precision ${i.precision} sampler2DShadow;
	precision ${i.precision} samplerCubeShadow;
	precision ${i.precision} sampler2DArrayShadow;
	precision ${i.precision} isampler2D;
	precision ${i.precision} isampler3D;
	precision ${i.precision} isamplerCube;
	precision ${i.precision} isampler2DArray;
	precision ${i.precision} usampler2D;
	precision ${i.precision} usampler3D;
	precision ${i.precision} usamplerCube;
	precision ${i.precision} usampler2DArray;
	`;return i.precision==="highp"?t+=`
#define HIGH_PRECISION`:i.precision==="mediump"?t+=`
#define MEDIUM_PRECISION`:i.precision==="lowp"&&(t+=`
#define LOW_PRECISION`),t}function _m(i){let t="SHADOWMAP_TYPE_BASIC";return i.shadowMapType===po?t="SHADOWMAP_TYPE_PCF":i.shadowMapType===Rr?t="SHADOWMAP_TYPE_PCF_SOFT":i.shadowMapType===pn&&(t="SHADOWMAP_TYPE_VSM"),t}function xm(i){let t="ENVMAP_TYPE_CUBE";if(i.envMap)switch(i.envMapMode){case ci:case hi:t="ENVMAP_TYPE_CUBE";break;case Is:t="ENVMAP_TYPE_CUBE_UV";break}return t}function ym(i){let t="ENVMAP_MODE_REFLECTION";if(i.envMap)switch(i.envMapMode){case hi:t="ENVMAP_MODE_REFRACTION";break}return t}function vm(i){let t="ENVMAP_BLENDING_NONE";if(i.envMap)switch(i.combine){case xo:t="ENVMAP_BLENDING_MULTIPLY";break;case ec:t="ENVMAP_BLENDING_MIX";break;case nc:t="ENVMAP_BLENDING_ADD";break}return t}function Mm(i){let t=i.envMapCubeUVHeight;if(t===null)return null;let e=Math.log2(t)-2,n=1/t;return{texelWidth:1/(3*Math.max(Math.pow(2,e),112)),texelHeight:n,maxMip:e}}function Sm(i,t,e,n){let s=i.getContext(),r=e.defines,a=e.vertexShader,o=e.fragmentShader,l=_m(e),c=xm(e),u=ym(e),d=vm(e),f=Mm(e),p=cm(e),_=hm(r),v=s.createProgram(),m,h,w=e.glslVersion?"#version "+e.glslVersion+`
`:"";e.isRawShaderMaterial?(m=["#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,_].filter(Fs).join(`
`),m.length>0&&(m+=`
`),h=["#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,_].filter(Fs).join(`
`),h.length>0&&(h+=`
`)):(m=[Wc(e),"#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,_,e.extensionClipCullDistance?"#define USE_CLIP_DISTANCE":"",e.batching?"#define USE_BATCHING":"",e.batchingColor?"#define USE_BATCHING_COLOR":"",e.instancing?"#define USE_INSTANCING":"",e.instancingColor?"#define USE_INSTANCING_COLOR":"",e.instancingMorph?"#define USE_INSTANCING_MORPH":"",e.useFog&&e.fog?"#define USE_FOG":"",e.useFog&&e.fogExp2?"#define FOG_EXP2":"",e.map?"#define USE_MAP":"",e.envMap?"#define USE_ENVMAP":"",e.envMap?"#define "+u:"",e.lightMap?"#define USE_LIGHTMAP":"",e.aoMap?"#define USE_AOMAP":"",e.bumpMap?"#define USE_BUMPMAP":"",e.normalMap?"#define USE_NORMALMAP":"",e.normalMapObjectSpace?"#define USE_NORMALMAP_OBJECTSPACE":"",e.normalMapTangentSpace?"#define USE_NORMALMAP_TANGENTSPACE":"",e.displacementMap?"#define USE_DISPLACEMENTMAP":"",e.emissiveMap?"#define USE_EMISSIVEMAP":"",e.anisotropy?"#define USE_ANISOTROPY":"",e.anisotropyMap?"#define USE_ANISOTROPYMAP":"",e.clearcoatMap?"#define USE_CLEARCOATMAP":"",e.clearcoatRoughnessMap?"#define USE_CLEARCOAT_ROUGHNESSMAP":"",e.clearcoatNormalMap?"#define USE_CLEARCOAT_NORMALMAP":"",e.iridescenceMap?"#define USE_IRIDESCENCEMAP":"",e.iridescenceThicknessMap?"#define USE_IRIDESCENCE_THICKNESSMAP":"",e.specularMap?"#define USE_SPECULARMAP":"",e.specularColorMap?"#define USE_SPECULAR_COLORMAP":"",e.specularIntensityMap?"#define USE_SPECULAR_INTENSITYMAP":"",e.roughnessMap?"#define USE_ROUGHNESSMAP":"",e.metalnessMap?"#define USE_METALNESSMAP":"",e.alphaMap?"#define USE_ALPHAMAP":"",e.alphaHash?"#define USE_ALPHAHASH":"",e.transmission?"#define USE_TRANSMISSION":"",e.transmissionMap?"#define USE_TRANSMISSIONMAP":"",e.thicknessMap?"#define USE_THICKNESSMAP":"",e.sheenColorMap?"#define USE_SHEEN_COLORMAP":"",e.sheenRoughnessMap?"#define USE_SHEEN_ROUGHNESSMAP":"",e.mapUv?"#define MAP_UV "+e.mapUv:"",e.alphaMapUv?"#define ALPHAMAP_UV "+e.alphaMapUv:"",e.lightMapUv?"#define LIGHTMAP_UV "+e.lightMapUv:"",e.aoMapUv?"#define AOMAP_UV "+e.aoMapUv:"",e.emissiveMapUv?"#define EMISSIVEMAP_UV "+e.emissiveMapUv:"",e.bumpMapUv?"#define BUMPMAP_UV "+e.bumpMapUv:"",e.normalMapUv?"#define NORMALMAP_UV "+e.normalMapUv:"",e.displacementMapUv?"#define DISPLACEMENTMAP_UV "+e.displacementMapUv:"",e.metalnessMapUv?"#define METALNESSMAP_UV "+e.metalnessMapUv:"",e.roughnessMapUv?"#define ROUGHNESSMAP_UV "+e.roughnessMapUv:"",e.anisotropyMapUv?"#define ANISOTROPYMAP_UV "+e.anisotropyMapUv:"",e.clearcoatMapUv?"#define CLEARCOATMAP_UV "+e.clearcoatMapUv:"",e.clearcoatNormalMapUv?"#define CLEARCOAT_NORMALMAP_UV "+e.clearcoatNormalMapUv:"",e.clearcoatRoughnessMapUv?"#define CLEARCOAT_ROUGHNESSMAP_UV "+e.clearcoatRoughnessMapUv:"",e.iridescenceMapUv?"#define IRIDESCENCEMAP_UV "+e.iridescenceMapUv:"",e.iridescenceThicknessMapUv?"#define IRIDESCENCE_THICKNESSMAP_UV "+e.iridescenceThicknessMapUv:"",e.sheenColorMapUv?"#define SHEEN_COLORMAP_UV "+e.sheenColorMapUv:"",e.sheenRoughnessMapUv?"#define SHEEN_ROUGHNESSMAP_UV "+e.sheenRoughnessMapUv:"",e.specularMapUv?"#define SPECULARMAP_UV "+e.specularMapUv:"",e.specularColorMapUv?"#define SPECULAR_COLORMAP_UV "+e.specularColorMapUv:"",e.specularIntensityMapUv?"#define SPECULAR_INTENSITYMAP_UV "+e.specularIntensityMapUv:"",e.transmissionMapUv?"#define TRANSMISSIONMAP_UV "+e.transmissionMapUv:"",e.thicknessMapUv?"#define THICKNESSMAP_UV "+e.thicknessMapUv:"",e.vertexTangents&&e.flatShading===!1?"#define USE_TANGENT":"",e.vertexColors?"#define USE_COLOR":"",e.vertexAlphas?"#define USE_COLOR_ALPHA":"",e.vertexUv1s?"#define USE_UV1":"",e.vertexUv2s?"#define USE_UV2":"",e.vertexUv3s?"#define USE_UV3":"",e.pointsUvs?"#define USE_POINTS_UV":"",e.flatShading?"#define FLAT_SHADED":"",e.skinning?"#define USE_SKINNING":"",e.morphTargets?"#define USE_MORPHTARGETS":"",e.morphNormals&&e.flatShading===!1?"#define USE_MORPHNORMALS":"",e.morphColors?"#define USE_MORPHCOLORS":"",e.morphTargetsCount>0?"#define MORPHTARGETS_TEXTURE_STRIDE "+e.morphTextureStride:"",e.morphTargetsCount>0?"#define MORPHTARGETS_COUNT "+e.morphTargetsCount:"",e.doubleSided?"#define DOUBLE_SIDED":"",e.flipSided?"#define FLIP_SIDED":"",e.shadowMapEnabled?"#define USE_SHADOWMAP":"",e.shadowMapEnabled?"#define "+l:"",e.sizeAttenuation?"#define USE_SIZEATTENUATION":"",e.numLightProbes>0?"#define USE_LIGHT_PROBES":"",e.logarithmicDepthBuffer?"#define USE_LOGARITHMIC_DEPTH_BUFFER":"",e.reversedDepthBuffer?"#define USE_REVERSED_DEPTH_BUFFER":"","uniform mat4 modelMatrix;","uniform mat4 modelViewMatrix;","uniform mat4 projectionMatrix;","uniform mat4 viewMatrix;","uniform mat3 normalMatrix;","uniform vec3 cameraPosition;","uniform bool isOrthographic;","#ifdef USE_INSTANCING","	attribute mat4 instanceMatrix;","#endif","#ifdef USE_INSTANCING_COLOR","	attribute vec3 instanceColor;","#endif","#ifdef USE_INSTANCING_MORPH","	uniform sampler2D morphTexture;","#endif","attribute vec3 position;","attribute vec3 normal;","attribute vec2 uv;","#ifdef USE_UV1","	attribute vec2 uv1;","#endif","#ifdef USE_UV2","	attribute vec2 uv2;","#endif","#ifdef USE_UV3","	attribute vec2 uv3;","#endif","#ifdef USE_TANGENT","	attribute vec4 tangent;","#endif","#if defined( USE_COLOR_ALPHA )","	attribute vec4 color;","#elif defined( USE_COLOR )","	attribute vec3 color;","#endif","#ifdef USE_SKINNING","	attribute vec4 skinIndex;","	attribute vec4 skinWeight;","#endif",`
`].filter(Fs).join(`
`),h=[Wc(e),"#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,_,e.useFog&&e.fog?"#define USE_FOG":"",e.useFog&&e.fogExp2?"#define FOG_EXP2":"",e.alphaToCoverage?"#define ALPHA_TO_COVERAGE":"",e.map?"#define USE_MAP":"",e.matcap?"#define USE_MATCAP":"",e.envMap?"#define USE_ENVMAP":"",e.envMap?"#define "+c:"",e.envMap?"#define "+u:"",e.envMap?"#define "+d:"",f?"#define CUBEUV_TEXEL_WIDTH "+f.texelWidth:"",f?"#define CUBEUV_TEXEL_HEIGHT "+f.texelHeight:"",f?"#define CUBEUV_MAX_MIP "+f.maxMip+".0":"",e.lightMap?"#define USE_LIGHTMAP":"",e.aoMap?"#define USE_AOMAP":"",e.bumpMap?"#define USE_BUMPMAP":"",e.normalMap?"#define USE_NORMALMAP":"",e.normalMapObjectSpace?"#define USE_NORMALMAP_OBJECTSPACE":"",e.normalMapTangentSpace?"#define USE_NORMALMAP_TANGENTSPACE":"",e.emissiveMap?"#define USE_EMISSIVEMAP":"",e.anisotropy?"#define USE_ANISOTROPY":"",e.anisotropyMap?"#define USE_ANISOTROPYMAP":"",e.clearcoat?"#define USE_CLEARCOAT":"",e.clearcoatMap?"#define USE_CLEARCOATMAP":"",e.clearcoatRoughnessMap?"#define USE_CLEARCOAT_ROUGHNESSMAP":"",e.clearcoatNormalMap?"#define USE_CLEARCOAT_NORMALMAP":"",e.dispersion?"#define USE_DISPERSION":"",e.iridescence?"#define USE_IRIDESCENCE":"",e.iridescenceMap?"#define USE_IRIDESCENCEMAP":"",e.iridescenceThicknessMap?"#define USE_IRIDESCENCE_THICKNESSMAP":"",e.specularMap?"#define USE_SPECULARMAP":"",e.specularColorMap?"#define USE_SPECULAR_COLORMAP":"",e.specularIntensityMap?"#define USE_SPECULAR_INTENSITYMAP":"",e.roughnessMap?"#define USE_ROUGHNESSMAP":"",e.metalnessMap?"#define USE_METALNESSMAP":"",e.alphaMap?"#define USE_ALPHAMAP":"",e.alphaTest?"#define USE_ALPHATEST":"",e.alphaHash?"#define USE_ALPHAHASH":"",e.sheen?"#define USE_SHEEN":"",e.sheenColorMap?"#define USE_SHEEN_COLORMAP":"",e.sheenRoughnessMap?"#define USE_SHEEN_ROUGHNESSMAP":"",e.transmission?"#define USE_TRANSMISSION":"",e.transmissionMap?"#define USE_TRANSMISSIONMAP":"",e.thicknessMap?"#define USE_THICKNESSMAP":"",e.vertexTangents&&e.flatShading===!1?"#define USE_TANGENT":"",e.vertexColors||e.instancingColor||e.batchingColor?"#define USE_COLOR":"",e.vertexAlphas?"#define USE_COLOR_ALPHA":"",e.vertexUv1s?"#define USE_UV1":"",e.vertexUv2s?"#define USE_UV2":"",e.vertexUv3s?"#define USE_UV3":"",e.pointsUvs?"#define USE_POINTS_UV":"",e.gradientMap?"#define USE_GRADIENTMAP":"",e.flatShading?"#define FLAT_SHADED":"",e.doubleSided?"#define DOUBLE_SIDED":"",e.flipSided?"#define FLIP_SIDED":"",e.shadowMapEnabled?"#define USE_SHADOWMAP":"",e.shadowMapEnabled?"#define "+l:"",e.premultipliedAlpha?"#define PREMULTIPLIED_ALPHA":"",e.numLightProbes>0?"#define USE_LIGHT_PROBES":"",e.decodeVideoTexture?"#define DECODE_VIDEO_TEXTURE":"",e.decodeVideoTextureEmissive?"#define DECODE_VIDEO_TEXTURE_EMISSIVE":"",e.logarithmicDepthBuffer?"#define USE_LOGARITHMIC_DEPTH_BUFFER":"",e.reversedDepthBuffer?"#define USE_REVERSED_DEPTH_BUFFER":"","uniform mat4 viewMatrix;","uniform vec3 cameraPosition;","uniform bool isOrthographic;",e.toneMapping!==An?"#define TONE_MAPPING":"",e.toneMapping!==An?Bt.tonemapping_pars_fragment:"",e.toneMapping!==An?om("toneMapping",e.toneMapping):"",e.dithering?"#define DITHERING":"",e.opaque?"#define OPAQUE":"",Bt.colorspace_pars_fragment,am("linearToOutputTexel",e.outputColorSpace),lm(),e.useDepthPacking?"#define DEPTH_PACKING "+e.depthPacking:"",`
`].filter(Fs).join(`
`)),a=Yo(a),a=Vc(a,e),a=Hc(a,e),o=Yo(o),o=Vc(o,e),o=Hc(o,e),a=Gc(a),o=Gc(o),e.isRawShaderMaterial!==!0&&(w=`#version 300 es
`,m=[p,"#define attribute in","#define varying out","#define texture2D texture"].join(`
`)+`
`+m,h=["#define varying in",e.glslVersion===Io?"":"layout(location = 0) out highp vec4 pc_fragColor;",e.glslVersion===Io?"":"#define gl_FragColor pc_fragColor","#define gl_FragDepthEXT gl_FragDepth","#define texture2D texture","#define textureCube texture","#define texture2DProj textureProj","#define texture2DLodEXT textureLod","#define texture2DProjLodEXT textureProjLod","#define textureCubeLodEXT textureLod","#define texture2DGradEXT textureGrad","#define texture2DProjGradEXT textureProjGrad","#define textureCubeGradEXT textureGrad"].join(`
`)+`
`+h);let E=w+m+a,S=w+h+o,C=Bc(s,s.VERTEX_SHADER,E),A=Bc(s,s.FRAGMENT_SHADER,S);s.attachShader(v,C),s.attachShader(v,A),e.index0AttributeName!==void 0?s.bindAttribLocation(v,0,e.index0AttributeName):e.morphTargets===!0&&s.bindAttribLocation(v,0,"position"),s.linkProgram(v);function P(I){if(i.debug.checkShaderErrors){let O=s.getProgramInfoLog(v)||"",k=s.getShaderInfoLog(C)||"",G=s.getShaderInfoLog(A)||"",q=O.trim(),W=k.trim(),et=G.trim(),V=!0,rt=!0;if(s.getProgramParameter(v,s.LINK_STATUS)===!1)if(V=!1,typeof i.debug.onShaderError=="function")i.debug.onShaderError(s,v,C,A);else{let ct=kc(s,C,"vertex"),St=kc(s,A,"fragment");console.error("THREE.WebGLProgram: Shader Error "+s.getError()+" - VALIDATE_STATUS "+s.getProgramParameter(v,s.VALIDATE_STATUS)+`

Material Name: `+I.name+`
Material Type: `+I.type+`

Program Info Log: `+q+`
`+ct+`
`+St)}else q!==""?console.warn("THREE.WebGLProgram: Program Info Log:",q):(W===""||et==="")&&(rt=!1);rt&&(I.diagnostics={runnable:V,programLog:q,vertexShader:{log:W,prefix:m},fragmentShader:{log:et,prefix:h}})}s.deleteShader(C),s.deleteShader(A),U=new Ji(s,v),M=um(s,v)}let U;this.getUniforms=function(){return U===void 0&&P(this),U};let M;this.getAttributes=function(){return M===void 0&&P(this),M};let y=e.rendererExtensionParallelShaderCompile===!1;return this.isReady=function(){return y===!1&&(y=s.getProgramParameter(v,nm)),y},this.destroy=function(){n.releaseStatesOfProgram(this),s.deleteProgram(v),this.program=void 0},this.type=e.shaderType,this.name=e.shaderName,this.id=im++,this.cacheKey=t,this.usedTimes=1,this.program=v,this.vertexShader=C,this.fragmentShader=A,this}var bm=0,Zo=class{constructor(){this.shaderCache=new Map,this.materialCache=new Map}update(t){let e=t.vertexShader,n=t.fragmentShader,s=this._getShaderStage(e),r=this._getShaderStage(n),a=this._getShaderCacheForMaterial(t);return a.has(s)===!1&&(a.add(s),s.usedTimes++),a.has(r)===!1&&(a.add(r),r.usedTimes++),this}remove(t){let e=this.materialCache.get(t);for(let n of e)n.usedTimes--,n.usedTimes===0&&this.shaderCache.delete(n.code);return this.materialCache.delete(t),this}getVertexShaderID(t){return this._getShaderStage(t.vertexShader).id}getFragmentShaderID(t){return this._getShaderStage(t.fragmentShader).id}dispose(){this.shaderCache.clear(),this.materialCache.clear()}_getShaderCacheForMaterial(t){let e=this.materialCache,n=e.get(t);return n===void 0&&(n=new Set,e.set(t,n)),n}_getShaderStage(t){let e=this.shaderCache,n=e.get(t);return n===void 0&&(n=new Jo(t),e.set(t,n)),n}},Jo=class{constructor(t){this.id=bm++,this.code=t,this.usedTimes=0}};function Em(i,t,e,n,s,r,a){let o=new Bi,l=new Zo,c=new Set,u=[],d=s.logarithmicDepthBuffer,f=s.vertexTextures,p=s.precision,_={MeshDepthMaterial:"depth",MeshDistanceMaterial:"distanceRGBA",MeshNormalMaterial:"normal",MeshBasicMaterial:"basic",MeshLambertMaterial:"lambert",MeshPhongMaterial:"phong",MeshToonMaterial:"toon",MeshStandardMaterial:"physical",MeshPhysicalMaterial:"physical",MeshMatcapMaterial:"matcap",LineBasicMaterial:"basic",LineDashedMaterial:"dashed",PointsMaterial:"points",ShadowMaterial:"shadow",SpriteMaterial:"sprite"};function v(M){return c.add(M),M===0?"uv":`uv${M}`}function m(M,y,I,O,k){let G=O.fog,q=k.geometry,W=M.isMeshStandardMaterial?O.environment:null,et=(M.isMeshStandardMaterial?e:t).get(M.envMap||W),V=et&&et.mapping===Is?et.image.height:null,rt=_[M.type];M.precision!==null&&(p=s.getMaxPrecision(M.precision),p!==M.precision&&console.warn("THREE.WebGLProgram.getParameters:",M.precision,"not supported, using",p,"instead."));let ct=q.morphAttributes.position||q.morphAttributes.normal||q.morphAttributes.color,St=ct!==void 0?ct.length:0,kt=0;q.morphAttributes.position!==void 0&&(kt=1),q.morphAttributes.normal!==void 0&&(kt=2),q.morphAttributes.color!==void 0&&(kt=3);let jt,ne,qt,Y;if(rt){let Yt=_n[rt];jt=Yt.vertexShader,ne=Yt.fragmentShader}else jt=M.vertexShader,ne=M.fragmentShader,l.update(M),qt=l.getVertexShaderID(M),Y=l.getFragmentShaderID(M);let $=i.getRenderTarget(),dt=i.state.buffers.depth.getReversed(),Pt=k.isInstancedMesh===!0,Mt=k.isBatchedMesh===!0,Gt=!!M.map,Se=!!M.matcap,T=!!et,ie=!!M.aoMap,Lt=!!M.lightMap,At=!!M.bumpMap,mt=!!M.normalMap,se=!!M.displacementMap,gt=!!M.emissiveMap,Ot=!!M.metalnessMap,ye=!!M.roughnessMap,he=M.anisotropy>0,b=M.clearcoat>0,g=M.dispersion>0,F=M.iridescence>0,X=M.sheen>0,J=M.transmission>0,H=he&&!!M.anisotropyMap,vt=b&&!!M.clearcoatMap,nt=b&&!!M.clearcoatNormalMap,_t=b&&!!M.clearcoatRoughnessMap,xt=F&&!!M.iridescenceMap,Q=F&&!!M.iridescenceThicknessMap,lt=X&&!!M.sheenColorMap,wt=X&&!!M.sheenRoughnessMap,yt=!!M.specularMap,at=!!M.specularColorMap,Nt=!!M.specularIntensityMap,R=J&&!!M.transmissionMap,tt=J&&!!M.thicknessMap,it=!!M.gradientMap,ut=!!M.alphaMap,K=M.alphaTest>0,Z=!!M.alphaHash,pt=!!M.extensions,Dt=An;M.toneMapped&&($===null||$.isXRRenderTarget===!0)&&(Dt=i.toneMapping);let Qt={shaderID:rt,shaderType:M.type,shaderName:M.name,vertexShader:jt,fragmentShader:ne,defines:M.defines,customVertexShaderID:qt,customFragmentShaderID:Y,isRawShaderMaterial:M.isRawShaderMaterial===!0,glslVersion:M.glslVersion,precision:p,batching:Mt,batchingColor:Mt&&k._colorsTexture!==null,instancing:Pt,instancingColor:Pt&&k.instanceColor!==null,instancingMorph:Pt&&k.morphTexture!==null,supportsVertexTextures:f,outputColorSpace:$===null?i.outputColorSpace:$.isXRRenderTarget===!0?$.texture.colorSpace:ii,alphaToCoverage:!!M.alphaToCoverage,map:Gt,matcap:Se,envMap:T,envMapMode:T&&et.mapping,envMapCubeUVHeight:V,aoMap:ie,lightMap:Lt,bumpMap:At,normalMap:mt,displacementMap:f&&se,emissiveMap:gt,normalMapObjectSpace:mt&&M.normalMapType===dc,normalMapTangentSpace:mt&&M.normalMapType===Co,metalnessMap:Ot,roughnessMap:ye,anisotropy:he,anisotropyMap:H,clearcoat:b,clearcoatMap:vt,clearcoatNormalMap:nt,clearcoatRoughnessMap:_t,dispersion:g,iridescence:F,iridescenceMap:xt,iridescenceThicknessMap:Q,sheen:X,sheenColorMap:lt,sheenRoughnessMap:wt,specularMap:yt,specularColorMap:at,specularIntensityMap:Nt,transmission:J,transmissionMap:R,thicknessMap:tt,gradientMap:it,opaque:M.transparent===!1&&M.blending===ei&&M.alphaToCoverage===!1,alphaMap:ut,alphaTest:K,alphaHash:Z,combine:M.combine,mapUv:Gt&&v(M.map.channel),aoMapUv:ie&&v(M.aoMap.channel),lightMapUv:Lt&&v(M.lightMap.channel),bumpMapUv:At&&v(M.bumpMap.channel),normalMapUv:mt&&v(M.normalMap.channel),displacementMapUv:se&&v(M.displacementMap.channel),emissiveMapUv:gt&&v(M.emissiveMap.channel),metalnessMapUv:Ot&&v(M.metalnessMap.channel),roughnessMapUv:ye&&v(M.roughnessMap.channel),anisotropyMapUv:H&&v(M.anisotropyMap.channel),clearcoatMapUv:vt&&v(M.clearcoatMap.channel),clearcoatNormalMapUv:nt&&v(M.clearcoatNormalMap.channel),clearcoatRoughnessMapUv:_t&&v(M.clearcoatRoughnessMap.channel),iridescenceMapUv:xt&&v(M.iridescenceMap.channel),iridescenceThicknessMapUv:Q&&v(M.iridescenceThicknessMap.channel),sheenColorMapUv:lt&&v(M.sheenColorMap.channel),sheenRoughnessMapUv:wt&&v(M.sheenRoughnessMap.channel),specularMapUv:yt&&v(M.specularMap.channel),specularColorMapUv:at&&v(M.specularColorMap.channel),specularIntensityMapUv:Nt&&v(M.specularIntensityMap.channel),transmissionMapUv:R&&v(M.transmissionMap.channel),thicknessMapUv:tt&&v(M.thicknessMap.channel),alphaMapUv:ut&&v(M.alphaMap.channel),vertexTangents:!!q.attributes.tangent&&(mt||he),vertexColors:M.vertexColors,vertexAlphas:M.vertexColors===!0&&!!q.attributes.color&&q.attributes.color.itemSize===4,pointsUvs:k.isPoints===!0&&!!q.attributes.uv&&(Gt||ut),fog:!!G,useFog:M.fog===!0,fogExp2:!!G&&G.isFogExp2,flatShading:M.flatShading===!0&&M.wireframe===!1,sizeAttenuation:M.sizeAttenuation===!0,logarithmicDepthBuffer:d,reversedDepthBuffer:dt,skinning:k.isSkinnedMesh===!0,morphTargets:q.morphAttributes.position!==void 0,morphNormals:q.morphAttributes.normal!==void 0,morphColors:q.morphAttributes.color!==void 0,morphTargetsCount:St,morphTextureStride:kt,numDirLights:y.directional.length,numPointLights:y.point.length,numSpotLights:y.spot.length,numSpotLightMaps:y.spotLightMap.length,numRectAreaLights:y.rectArea.length,numHemiLights:y.hemi.length,numDirLightShadows:y.directionalShadowMap.length,numPointLightShadows:y.pointShadowMap.length,numSpotLightShadows:y.spotShadowMap.length,numSpotLightShadowsWithMaps:y.numSpotLightShadowsWithMaps,numLightProbes:y.numLightProbes,numClippingPlanes:a.numPlanes,numClipIntersection:a.numIntersection,dithering:M.dithering,shadowMapEnabled:i.shadowMap.enabled&&I.length>0,shadowMapType:i.shadowMap.type,toneMapping:Dt,decodeVideoTexture:Gt&&M.map.isVideoTexture===!0&&Wt.getTransfer(M.map.colorSpace)===Zt,decodeVideoTextureEmissive:gt&&M.emissiveMap.isVideoTexture===!0&&Wt.getTransfer(M.emissiveMap.colorSpace)===Zt,premultipliedAlpha:M.premultipliedAlpha,doubleSided:M.side===mn,flipSided:M.side===De,useDepthPacking:M.depthPacking>=0,depthPacking:M.depthPacking||0,index0AttributeName:M.index0AttributeName,extensionClipCullDistance:pt&&M.extensions.clipCullDistance===!0&&n.has("WEBGL_clip_cull_distance"),extensionMultiDraw:(pt&&M.extensions.multiDraw===!0||Mt)&&n.has("WEBGL_multi_draw"),rendererExtensionParallelShaderCompile:n.has("KHR_parallel_shader_compile"),customProgramCacheKey:M.customProgramCacheKey()};return Qt.vertexUv1s=c.has(1),Qt.vertexUv2s=c.has(2),Qt.vertexUv3s=c.has(3),c.clear(),Qt}function h(M){let y=[];if(M.shaderID?y.push(M.shaderID):(y.push(M.customVertexShaderID),y.push(M.customFragmentShaderID)),M.defines!==void 0)for(let I in M.defines)y.push(I),y.push(M.defines[I]);return M.isRawShaderMaterial===!1&&(w(y,M),E(y,M),y.push(i.outputColorSpace)),y.push(M.customProgramCacheKey),y.join()}function w(M,y){M.push(y.precision),M.push(y.outputColorSpace),M.push(y.envMapMode),M.push(y.envMapCubeUVHeight),M.push(y.mapUv),M.push(y.alphaMapUv),M.push(y.lightMapUv),M.push(y.aoMapUv),M.push(y.bumpMapUv),M.push(y.normalMapUv),M.push(y.displacementMapUv),M.push(y.emissiveMapUv),M.push(y.metalnessMapUv),M.push(y.roughnessMapUv),M.push(y.anisotropyMapUv),M.push(y.clearcoatMapUv),M.push(y.clearcoatNormalMapUv),M.push(y.clearcoatRoughnessMapUv),M.push(y.iridescenceMapUv),M.push(y.iridescenceThicknessMapUv),M.push(y.sheenColorMapUv),M.push(y.sheenRoughnessMapUv),M.push(y.specularMapUv),M.push(y.specularColorMapUv),M.push(y.specularIntensityMapUv),M.push(y.transmissionMapUv),M.push(y.thicknessMapUv),M.push(y.combine),M.push(y.fogExp2),M.push(y.sizeAttenuation),M.push(y.morphTargetsCount),M.push(y.morphAttributeCount),M.push(y.numDirLights),M.push(y.numPointLights),M.push(y.numSpotLights),M.push(y.numSpotLightMaps),M.push(y.numHemiLights),M.push(y.numRectAreaLights),M.push(y.numDirLightShadows),M.push(y.numPointLightShadows),M.push(y.numSpotLightShadows),M.push(y.numSpotLightShadowsWithMaps),M.push(y.numLightProbes),M.push(y.shadowMapType),M.push(y.toneMapping),M.push(y.numClippingPlanes),M.push(y.numClipIntersection),M.push(y.depthPacking)}function E(M,y){o.disableAll(),y.supportsVertexTextures&&o.enable(0),y.instancing&&o.enable(1),y.instancingColor&&o.enable(2),y.instancingMorph&&o.enable(3),y.matcap&&o.enable(4),y.envMap&&o.enable(5),y.normalMapObjectSpace&&o.enable(6),y.normalMapTangentSpace&&o.enable(7),y.clearcoat&&o.enable(8),y.iridescence&&o.enable(9),y.alphaTest&&o.enable(10),y.vertexColors&&o.enable(11),y.vertexAlphas&&o.enable(12),y.vertexUv1s&&o.enable(13),y.vertexUv2s&&o.enable(14),y.vertexUv3s&&o.enable(15),y.vertexTangents&&o.enable(16),y.anisotropy&&o.enable(17),y.alphaHash&&o.enable(18),y.batching&&o.enable(19),y.dispersion&&o.enable(20),y.batchingColor&&o.enable(21),y.gradientMap&&o.enable(22),M.push(o.mask),o.disableAll(),y.fog&&o.enable(0),y.useFog&&o.enable(1),y.flatShading&&o.enable(2),y.logarithmicDepthBuffer&&o.enable(3),y.reversedDepthBuffer&&o.enable(4),y.skinning&&o.enable(5),y.morphTargets&&o.enable(6),y.morphNormals&&o.enable(7),y.morphColors&&o.enable(8),y.premultipliedAlpha&&o.enable(9),y.shadowMapEnabled&&o.enable(10),y.doubleSided&&o.enable(11),y.flipSided&&o.enable(12),y.useDepthPacking&&o.enable(13),y.dithering&&o.enable(14),y.transmission&&o.enable(15),y.sheen&&o.enable(16),y.opaque&&o.enable(17),y.pointsUvs&&o.enable(18),y.decodeVideoTexture&&o.enable(19),y.decodeVideoTextureEmissive&&o.enable(20),y.alphaToCoverage&&o.enable(21),M.push(o.mask)}function S(M){let y=_[M.type],I;if(y){let O=_n[y];I=bc.clone(O.uniforms)}else I=M.uniforms;return I}function C(M,y){let I;for(let O=0,k=u.length;O<k;O++){let G=u[O];if(G.cacheKey===y){I=G,++I.usedTimes;break}}return I===void 0&&(I=new Sm(i,y,M,r),u.push(I)),I}function A(M){if(--M.usedTimes===0){let y=u.indexOf(M);u[y]=u[u.length-1],u.pop(),M.destroy()}}function P(M){l.remove(M)}function U(){l.dispose()}return{getParameters:m,getProgramCacheKey:h,getUniforms:S,acquireProgram:C,releaseProgram:A,releaseShaderCache:P,programs:u,dispose:U}}function Tm(){let i=new WeakMap;function t(a){return i.has(a)}function e(a){let o=i.get(a);return o===void 0&&(o={},i.set(a,o)),o}function n(a){i.delete(a)}function s(a,o,l){i.get(a)[o]=l}function r(){i=new WeakMap}return{has:t,get:e,remove:n,update:s,dispose:r}}function wm(i,t){return i.groupOrder!==t.groupOrder?i.groupOrder-t.groupOrder:i.renderOrder!==t.renderOrder?i.renderOrder-t.renderOrder:i.material.id!==t.material.id?i.material.id-t.material.id:i.z!==t.z?i.z-t.z:i.id-t.id}function Xc(i,t){return i.groupOrder!==t.groupOrder?i.groupOrder-t.groupOrder:i.renderOrder!==t.renderOrder?i.renderOrder-t.renderOrder:i.z!==t.z?t.z-i.z:i.id-t.id}function qc(){let i=[],t=0,e=[],n=[],s=[];function r(){t=0,e.length=0,n.length=0,s.length=0}function a(d,f,p,_,v,m){let h=i[t];return h===void 0?(h={id:d.id,object:d,geometry:f,material:p,groupOrder:_,renderOrder:d.renderOrder,z:v,group:m},i[t]=h):(h.id=d.id,h.object=d,h.geometry=f,h.material=p,h.groupOrder=_,h.renderOrder=d.renderOrder,h.z=v,h.group=m),t++,h}function o(d,f,p,_,v,m){let h=a(d,f,p,_,v,m);p.transmission>0?n.push(h):p.transparent===!0?s.push(h):e.push(h)}function l(d,f,p,_,v,m){let h=a(d,f,p,_,v,m);p.transmission>0?n.unshift(h):p.transparent===!0?s.unshift(h):e.unshift(h)}function c(d,f){e.length>1&&e.sort(d||wm),n.length>1&&n.sort(f||Xc),s.length>1&&s.sort(f||Xc)}function u(){for(let d=t,f=i.length;d<f;d++){let p=i[d];if(p.id===null)break;p.id=null,p.object=null,p.geometry=null,p.material=null,p.group=null}}return{opaque:e,transmissive:n,transparent:s,init:r,push:o,unshift:l,finish:u,sort:c}}function Am(){let i=new WeakMap;function t(n,s){let r=i.get(n),a;return r===void 0?(a=new qc,i.set(n,[a])):s>=r.length?(a=new qc,r.push(a)):a=r[s],a}function e(){i=new WeakMap}return{get:t,dispose:e}}function Cm(){let i={};return{get:function(t){if(i[t.id]!==void 0)return i[t.id];let e;switch(t.type){case"DirectionalLight":e={direction:new N,color:new Ht};break;case"SpotLight":e={position:new N,direction:new N,color:new Ht,distance:0,coneCos:0,penumbraCos:0,decay:0};break;case"PointLight":e={position:new N,color:new Ht,distance:0,decay:0};break;case"HemisphereLight":e={direction:new N,skyColor:new Ht,groundColor:new Ht};break;case"RectAreaLight":e={color:new Ht,position:new N,halfWidth:new N,halfHeight:new N};break}return i[t.id]=e,e}}}function Rm(){let i={};return{get:function(t){if(i[t.id]!==void 0)return i[t.id];let e;switch(t.type){case"DirectionalLight":e={shadowIntensity:1,shadowBias:0,shadowNormalBias:0,shadowRadius:1,shadowMapSize:new Rt};break;case"SpotLight":e={shadowIntensity:1,shadowBias:0,shadowNormalBias:0,shadowRadius:1,shadowMapSize:new Rt};break;case"PointLight":e={shadowIntensity:1,shadowBias:0,shadowNormalBias:0,shadowRadius:1,shadowMapSize:new Rt,shadowCameraNear:1,shadowCameraFar:1e3};break}return i[t.id]=e,e}}}var Im=0;function Pm(i,t){return(t.castShadow?2:0)-(i.castShadow?2:0)+(t.map?1:0)-(i.map?1:0)}function Dm(i){let t=new Cm,e=Rm(),n={version:0,hash:{directionalLength:-1,pointLength:-1,spotLength:-1,rectAreaLength:-1,hemiLength:-1,numDirectionalShadows:-1,numPointShadows:-1,numSpotShadows:-1,numSpotMaps:-1,numLightProbes:-1},ambient:[0,0,0],probe:[],directional:[],directionalShadow:[],directionalShadowMap:[],directionalShadowMatrix:[],spot:[],spotLightMap:[],spotShadow:[],spotShadowMap:[],spotLightMatrix:[],rectArea:[],rectAreaLTC1:null,rectAreaLTC2:null,point:[],pointShadow:[],pointShadowMap:[],pointShadowMatrix:[],hemi:[],numSpotLightShadowsWithMaps:0,numLightProbes:0};for(let c=0;c<9;c++)n.probe.push(new N);let s=new N,r=new ce,a=new ce;function o(c){let u=0,d=0,f=0;for(let M=0;M<9;M++)n.probe[M].set(0,0,0);let p=0,_=0,v=0,m=0,h=0,w=0,E=0,S=0,C=0,A=0,P=0;c.sort(Pm);for(let M=0,y=c.length;M<y;M++){let I=c[M],O=I.color,k=I.intensity,G=I.distance,q=I.shadow&&I.shadow.map?I.shadow.map.texture:null;if(I.isAmbientLight)u+=O.r*k,d+=O.g*k,f+=O.b*k;else if(I.isLightProbe){for(let W=0;W<9;W++)n.probe[W].addScaledVector(I.sh.coefficients[W],k);P++}else if(I.isDirectionalLight){let W=t.get(I);if(W.color.copy(I.color).multiplyScalar(I.intensity),I.castShadow){let et=I.shadow,V=e.get(I);V.shadowIntensity=et.intensity,V.shadowBias=et.bias,V.shadowNormalBias=et.normalBias,V.shadowRadius=et.radius,V.shadowMapSize=et.mapSize,n.directionalShadow[p]=V,n.directionalShadowMap[p]=q,n.directionalShadowMatrix[p]=I.shadow.matrix,w++}n.directional[p]=W,p++}else if(I.isSpotLight){let W=t.get(I);W.position.setFromMatrixPosition(I.matrixWorld),W.color.copy(O).multiplyScalar(k),W.distance=G,W.coneCos=Math.cos(I.angle),W.penumbraCos=Math.cos(I.angle*(1-I.penumbra)),W.decay=I.decay,n.spot[v]=W;let et=I.shadow;if(I.map&&(n.spotLightMap[C]=I.map,C++,et.updateMatrices(I),I.castShadow&&A++),n.spotLightMatrix[v]=et.matrix,I.castShadow){let V=e.get(I);V.shadowIntensity=et.intensity,V.shadowBias=et.bias,V.shadowNormalBias=et.normalBias,V.shadowRadius=et.radius,V.shadowMapSize=et.mapSize,n.spotShadow[v]=V,n.spotShadowMap[v]=q,S++}v++}else if(I.isRectAreaLight){let W=t.get(I);W.color.copy(O).multiplyScalar(k),W.halfWidth.set(I.width*.5,0,0),W.halfHeight.set(0,I.height*.5,0),n.rectArea[m]=W,m++}else if(I.isPointLight){let W=t.get(I);if(W.color.copy(I.color).multiplyScalar(I.intensity),W.distance=I.distance,W.decay=I.decay,I.castShadow){let et=I.shadow,V=e.get(I);V.shadowIntensity=et.intensity,V.shadowBias=et.bias,V.shadowNormalBias=et.normalBias,V.shadowRadius=et.radius,V.shadowMapSize=et.mapSize,V.shadowCameraNear=et.camera.near,V.shadowCameraFar=et.camera.far,n.pointShadow[_]=V,n.pointShadowMap[_]=q,n.pointShadowMatrix[_]=I.shadow.matrix,E++}n.point[_]=W,_++}else if(I.isHemisphereLight){let W=t.get(I);W.skyColor.copy(I.color).multiplyScalar(k),W.groundColor.copy(I.groundColor).multiplyScalar(k),n.hemi[h]=W,h++}}m>0&&(i.has("OES_texture_float_linear")===!0?(n.rectAreaLTC1=st.LTC_FLOAT_1,n.rectAreaLTC2=st.LTC_FLOAT_2):(n.rectAreaLTC1=st.LTC_HALF_1,n.rectAreaLTC2=st.LTC_HALF_2)),n.ambient[0]=u,n.ambient[1]=d,n.ambient[2]=f;let U=n.hash;(U.directionalLength!==p||U.pointLength!==_||U.spotLength!==v||U.rectAreaLength!==m||U.hemiLength!==h||U.numDirectionalShadows!==w||U.numPointShadows!==E||U.numSpotShadows!==S||U.numSpotMaps!==C||U.numLightProbes!==P)&&(n.directional.length=p,n.spot.length=v,n.rectArea.length=m,n.point.length=_,n.hemi.length=h,n.directionalShadow.length=w,n.directionalShadowMap.length=w,n.pointShadow.length=E,n.pointShadowMap.length=E,n.spotShadow.length=S,n.spotShadowMap.length=S,n.directionalShadowMatrix.length=w,n.pointShadowMatrix.length=E,n.spotLightMatrix.length=S+C-A,n.spotLightMap.length=C,n.numSpotLightShadowsWithMaps=A,n.numLightProbes=P,U.directionalLength=p,U.pointLength=_,U.spotLength=v,U.rectAreaLength=m,U.hemiLength=h,U.numDirectionalShadows=w,U.numPointShadows=E,U.numSpotShadows=S,U.numSpotMaps=C,U.numLightProbes=P,n.version=Im++)}function l(c,u){let d=0,f=0,p=0,_=0,v=0,m=u.matrixWorldInverse;for(let h=0,w=c.length;h<w;h++){let E=c[h];if(E.isDirectionalLight){let S=n.directional[d];S.direction.setFromMatrixPosition(E.matrixWorld),s.setFromMatrixPosition(E.target.matrixWorld),S.direction.sub(s),S.direction.transformDirection(m),d++}else if(E.isSpotLight){let S=n.spot[p];S.position.setFromMatrixPosition(E.matrixWorld),S.position.applyMatrix4(m),S.direction.setFromMatrixPosition(E.matrixWorld),s.setFromMatrixPosition(E.target.matrixWorld),S.direction.sub(s),S.direction.transformDirection(m),p++}else if(E.isRectAreaLight){let S=n.rectArea[_];S.position.setFromMatrixPosition(E.matrixWorld),S.position.applyMatrix4(m),a.identity(),r.copy(E.matrixWorld),r.premultiply(m),a.extractRotation(r),S.halfWidth.set(E.width*.5,0,0),S.halfHeight.set(0,E.height*.5,0),S.halfWidth.applyMatrix4(a),S.halfHeight.applyMatrix4(a),_++}else if(E.isPointLight){let S=n.point[f];S.position.setFromMatrixPosition(E.matrixWorld),S.position.applyMatrix4(m),f++}else if(E.isHemisphereLight){let S=n.hemi[v];S.direction.setFromMatrixPosition(E.matrixWorld),S.direction.transformDirection(m),v++}}}return{setup:o,setupView:l,state:n}}function Yc(i){let t=new Dm(i),e=[],n=[];function s(u){c.camera=u,e.length=0,n.length=0}function r(u){e.push(u)}function a(u){n.push(u)}function o(){t.setup(e)}function l(u){t.setupView(e,u)}let c={lightsArray:e,shadowsArray:n,camera:null,lights:t,transmissionRenderTarget:{}};return{init:s,state:c,setupLights:o,setupLightsView:l,pushLight:r,pushShadow:a}}function Lm(i){let t=new WeakMap;function e(s,r=0){let a=t.get(s),o;return a===void 0?(o=new Yc(i),t.set(s,[o])):r>=a.length?(o=new Yc(i),a.push(o)):o=a[r],o}function n(){t=new WeakMap}return{get:e,dispose:n}}var Um=`void main() {
	gl_Position = vec4( position, 1.0 );
}`,Nm=`uniform sampler2D shadow_pass;
uniform vec2 resolution;
uniform float radius;
#include <packing>
void main() {
	const float samples = float( VSM_SAMPLES );
	float mean = 0.0;
	float squared_mean = 0.0;
	float uvStride = samples <= 1.0 ? 0.0 : 2.0 / ( samples - 1.0 );
	float uvStart = samples <= 1.0 ? 0.0 : - 1.0;
	for ( float i = 0.0; i < samples; i ++ ) {
		float uvOffset = uvStart + i * uvStride;
		#ifdef HORIZONTAL_PASS
			vec2 distribution = unpackRGBATo2Half( texture2D( shadow_pass, ( gl_FragCoord.xy + vec2( uvOffset, 0.0 ) * radius ) / resolution ) );
			mean += distribution.x;
			squared_mean += distribution.y * distribution.y + distribution.x * distribution.x;
		#else
			float depth = unpackRGBAToDepth( texture2D( shadow_pass, ( gl_FragCoord.xy + vec2( 0.0, uvOffset ) * radius ) / resolution ) );
			mean += depth;
			squared_mean += depth * depth;
		#endif
	}
	mean = mean / samples;
	squared_mean = squared_mean / samples;
	float std_dev = sqrt( squared_mean - mean * mean );
	gl_FragColor = pack2HalfToRGBA( vec2( mean, std_dev ) );
}`;function Fm(i,t,e){let n=new ki,s=new Rt,r=new Rt,a=new oe,o=new _r({depthPacking:uc}),l=new xr,c={},u=e.maxTextureSize,d={[Tn]:De,[De]:Tn,[mn]:mn},f=new rn({defines:{VSM_SAMPLES:8},uniforms:{shadow_pass:{value:null},resolution:{value:new Rt},radius:{value:4}},vertexShader:Um,fragmentShader:Nm}),p=f.clone();p.defines.HORIZONTAL_PASS=1;let _=new fn;_.setAttribute("position",new Ve(new Float32Array([-1,-1,.5,3,-1,.5,-1,3,.5]),3));let v=new Me(_,f),m=this;this.enabled=!1,this.autoUpdate=!0,this.needsUpdate=!1,this.type=po;let h=this.type;this.render=function(A,P,U){if(m.enabled===!1||m.autoUpdate===!1&&m.needsUpdate===!1||A.length===0)return;let M=i.getRenderTarget(),y=i.getActiveCubeFace(),I=i.getActiveMipmapLevel(),O=i.state;O.setBlending(wn),O.buffers.depth.getReversed()===!0?O.buffers.color.setClear(0,0,0,0):O.buffers.color.setClear(1,1,1,1),O.buffers.depth.setTest(!0),O.setScissorTest(!1);let k=h!==pn&&this.type===pn,G=h===pn&&this.type!==pn;for(let q=0,W=A.length;q<W;q++){let et=A[q],V=et.shadow;if(V===void 0){console.warn("THREE.WebGLShadowMap:",et,"has no shadow.");continue}if(V.autoUpdate===!1&&V.needsUpdate===!1)continue;s.copy(V.mapSize);let rt=V.getFrameExtents();if(s.multiply(rt),r.copy(V.mapSize),(s.x>u||s.y>u)&&(s.x>u&&(r.x=Math.floor(u/rt.x),s.x=r.x*rt.x,V.mapSize.x=r.x),s.y>u&&(r.y=Math.floor(u/rt.y),s.y=r.y*rt.y,V.mapSize.y=r.y)),V.map===null||k===!0||G===!0){let St=this.type!==pn?{minFilter:Ze,magFilter:Ze}:{};V.map!==null&&V.map.dispose(),V.map=new dn(s.x,s.y,St),V.map.texture.name=et.name+".shadowMap",V.camera.updateProjectionMatrix()}i.setRenderTarget(V.map),i.clear();let ct=V.getViewportCount();for(let St=0;St<ct;St++){let kt=V.getViewport(St);a.set(r.x*kt.x,r.y*kt.y,r.x*kt.z,r.y*kt.w),O.viewport(a),V.updateMatrices(et,St),n=V.getFrustum(),S(P,U,V.camera,et,this.type)}V.isPointLightShadow!==!0&&this.type===pn&&w(V,U),V.needsUpdate=!1}h=this.type,m.needsUpdate=!1,i.setRenderTarget(M,y,I)};function w(A,P){let U=t.update(v);f.defines.VSM_SAMPLES!==A.blurSamples&&(f.defines.VSM_SAMPLES=A.blurSamples,p.defines.VSM_SAMPLES=A.blurSamples,f.needsUpdate=!0,p.needsUpdate=!0),A.mapPass===null&&(A.mapPass=new dn(s.x,s.y)),f.uniforms.shadow_pass.value=A.map.texture,f.uniforms.resolution.value=A.mapSize,f.uniforms.radius.value=A.radius,i.setRenderTarget(A.mapPass),i.clear(),i.renderBufferDirect(P,null,U,f,v,null),p.uniforms.shadow_pass.value=A.mapPass.texture,p.uniforms.resolution.value=A.mapSize,p.uniforms.radius.value=A.radius,i.setRenderTarget(A.map),i.clear(),i.renderBufferDirect(P,null,U,p,v,null)}function E(A,P,U,M){let y=null,I=U.isPointLight===!0?A.customDistanceMaterial:A.customDepthMaterial;if(I!==void 0)y=I;else if(y=U.isPointLight===!0?l:o,i.localClippingEnabled&&P.clipShadows===!0&&Array.isArray(P.clippingPlanes)&&P.clippingPlanes.length!==0||P.displacementMap&&P.displacementScale!==0||P.alphaMap&&P.alphaTest>0||P.map&&P.alphaTest>0||P.alphaToCoverage===!0){let O=y.uuid,k=P.uuid,G=c[O];G===void 0&&(G={},c[O]=G);let q=G[k];q===void 0&&(q=y.clone(),G[k]=q,P.addEventListener("dispose",C)),y=q}if(y.visible=P.visible,y.wireframe=P.wireframe,M===pn?y.side=P.shadowSide!==null?P.shadowSide:P.side:y.side=P.shadowSide!==null?P.shadowSide:d[P.side],y.alphaMap=P.alphaMap,y.alphaTest=P.alphaToCoverage===!0?.5:P.alphaTest,y.map=P.map,y.clipShadows=P.clipShadows,y.clippingPlanes=P.clippingPlanes,y.clipIntersection=P.clipIntersection,y.displacementMap=P.displacementMap,y.displacementScale=P.displacementScale,y.displacementBias=P.displacementBias,y.wireframeLinewidth=P.wireframeLinewidth,y.linewidth=P.linewidth,U.isPointLight===!0&&y.isMeshDistanceMaterial===!0){let O=i.properties.get(y);O.light=U}return y}function S(A,P,U,M,y){if(A.visible===!1)return;if(A.layers.test(P.layers)&&(A.isMesh||A.isLine||A.isPoints)&&(A.castShadow||A.receiveShadow&&y===pn)&&(!A.frustumCulled||n.intersectsObject(A))){A.modelViewMatrix.multiplyMatrices(U.matrixWorldInverse,A.matrixWorld);let k=t.update(A),G=A.material;if(Array.isArray(G)){let q=k.groups;for(let W=0,et=q.length;W<et;W++){let V=q[W],rt=G[V.materialIndex];if(rt&&rt.visible){let ct=E(A,rt,M,y);A.onBeforeShadow(i,A,P,U,k,ct,V),i.renderBufferDirect(U,null,k,ct,A,V),A.onAfterShadow(i,A,P,U,k,ct,V)}}}else if(G.visible){let q=E(A,G,M,y);A.onBeforeShadow(i,A,P,U,k,q,null),i.renderBufferDirect(U,null,k,q,A,null),A.onAfterShadow(i,A,P,U,k,q,null)}}let O=A.children;for(let k=0,G=O.length;k<G;k++)S(O[k],P,U,M,y)}function C(A){A.target.removeEventListener("dispose",C);for(let U in c){let M=c[U],y=A.target.uuid;y in M&&(M[y].dispose(),delete M[y])}}}var Om={[Ir]:Pr,[Dr]:Nr,[Lr]:Fr,[ni]:Ur,[Pr]:Ir,[Nr]:Dr,[Fr]:Lr,[Ur]:ni};function Bm(i,t){function e(){let R=!1,tt=new oe,it=null,ut=new oe(0,0,0,0);return{setMask:function(K){it!==K&&!R&&(i.colorMask(K,K,K,K),it=K)},setLocked:function(K){R=K},setClear:function(K,Z,pt,Dt,Qt){Qt===!0&&(K*=Dt,Z*=Dt,pt*=Dt),tt.set(K,Z,pt,Dt),ut.equals(tt)===!1&&(i.clearColor(K,Z,pt,Dt),ut.copy(tt))},reset:function(){R=!1,it=null,ut.set(-1,0,0,0)}}}function n(){let R=!1,tt=!1,it=null,ut=null,K=null;return{setReversed:function(Z){if(tt!==Z){let pt=t.get("EXT_clip_control");Z?pt.clipControlEXT(pt.LOWER_LEFT_EXT,pt.ZERO_TO_ONE_EXT):pt.clipControlEXT(pt.LOWER_LEFT_EXT,pt.NEGATIVE_ONE_TO_ONE_EXT),tt=Z;let Dt=K;K=null,this.setClear(Dt)}},getReversed:function(){return tt},setTest:function(Z){Z?$(i.DEPTH_TEST):dt(i.DEPTH_TEST)},setMask:function(Z){it!==Z&&!R&&(i.depthMask(Z),it=Z)},setFunc:function(Z){if(tt&&(Z=Om[Z]),ut!==Z){switch(Z){case Ir:i.depthFunc(i.NEVER);break;case Pr:i.depthFunc(i.ALWAYS);break;case Dr:i.depthFunc(i.LESS);break;case ni:i.depthFunc(i.LEQUAL);break;case Lr:i.depthFunc(i.EQUAL);break;case Ur:i.depthFunc(i.GEQUAL);break;case Nr:i.depthFunc(i.GREATER);break;case Fr:i.depthFunc(i.NOTEQUAL);break;default:i.depthFunc(i.LEQUAL)}ut=Z}},setLocked:function(Z){R=Z},setClear:function(Z){K!==Z&&(tt&&(Z=1-Z),i.clearDepth(Z),K=Z)},reset:function(){R=!1,it=null,ut=null,K=null,tt=!1}}}function s(){let R=!1,tt=null,it=null,ut=null,K=null,Z=null,pt=null,Dt=null,Qt=null;return{setTest:function(Yt){R||(Yt?$(i.STENCIL_TEST):dt(i.STENCIL_TEST))},setMask:function(Yt){tt!==Yt&&!R&&(i.stencilMask(Yt),tt=Yt)},setFunc:function(Yt,xn,hn){(it!==Yt||ut!==xn||K!==hn)&&(i.stencilFunc(Yt,xn,hn),it=Yt,ut=xn,K=hn)},setOp:function(Yt,xn,hn){(Z!==Yt||pt!==xn||Dt!==hn)&&(i.stencilOp(Yt,xn,hn),Z=Yt,pt=xn,Dt=hn)},setLocked:function(Yt){R=Yt},setClear:function(Yt){Qt!==Yt&&(i.clearStencil(Yt),Qt=Yt)},reset:function(){R=!1,tt=null,it=null,ut=null,K=null,Z=null,pt=null,Dt=null,Qt=null}}}let r=new e,a=new n,o=new s,l=new WeakMap,c=new WeakMap,u={},d={},f=new WeakMap,p=[],_=null,v=!1,m=null,h=null,w=null,E=null,S=null,C=null,A=null,P=new Ht(0,0,0),U=0,M=!1,y=null,I=null,O=null,k=null,G=null,q=i.getParameter(i.MAX_COMBINED_TEXTURE_IMAGE_UNITS),W=!1,et=0,V=i.getParameter(i.VERSION);V.indexOf("WebGL")!==-1?(et=parseFloat(/^WebGL (\d)/.exec(V)[1]),W=et>=1):V.indexOf("OpenGL ES")!==-1&&(et=parseFloat(/^OpenGL ES (\d)/.exec(V)[1]),W=et>=2);let rt=null,ct={},St=i.getParameter(i.SCISSOR_BOX),kt=i.getParameter(i.VIEWPORT),jt=new oe().fromArray(St),ne=new oe().fromArray(kt);function qt(R,tt,it,ut){let K=new Uint8Array(4),Z=i.createTexture();i.bindTexture(R,Z),i.texParameteri(R,i.TEXTURE_MIN_FILTER,i.NEAREST),i.texParameteri(R,i.TEXTURE_MAG_FILTER,i.NEAREST);for(let pt=0;pt<it;pt++)R===i.TEXTURE_3D||R===i.TEXTURE_2D_ARRAY?i.texImage3D(tt,0,i.RGBA,1,1,ut,0,i.RGBA,i.UNSIGNED_BYTE,K):i.texImage2D(tt+pt,0,i.RGBA,1,1,0,i.RGBA,i.UNSIGNED_BYTE,K);return Z}let Y={};Y[i.TEXTURE_2D]=qt(i.TEXTURE_2D,i.TEXTURE_2D,1),Y[i.TEXTURE_CUBE_MAP]=qt(i.TEXTURE_CUBE_MAP,i.TEXTURE_CUBE_MAP_POSITIVE_X,6),Y[i.TEXTURE_2D_ARRAY]=qt(i.TEXTURE_2D_ARRAY,i.TEXTURE_2D_ARRAY,1,1),Y[i.TEXTURE_3D]=qt(i.TEXTURE_3D,i.TEXTURE_3D,1,1),r.setClear(0,0,0,1),a.setClear(1),o.setClear(0),$(i.DEPTH_TEST),a.setFunc(ni),At(!1),mt(fo),$(i.CULL_FACE),ie(wn);function $(R){u[R]!==!0&&(i.enable(R),u[R]=!0)}function dt(R){u[R]!==!1&&(i.disable(R),u[R]=!1)}function Pt(R,tt){return d[R]!==tt?(i.bindFramebuffer(R,tt),d[R]=tt,R===i.DRAW_FRAMEBUFFER&&(d[i.FRAMEBUFFER]=tt),R===i.FRAMEBUFFER&&(d[i.DRAW_FRAMEBUFFER]=tt),!0):!1}function Mt(R,tt){let it=p,ut=!1;if(R){it=f.get(tt),it===void 0&&(it=[],f.set(tt,it));let K=R.textures;if(it.length!==K.length||it[0]!==i.COLOR_ATTACHMENT0){for(let Z=0,pt=K.length;Z<pt;Z++)it[Z]=i.COLOR_ATTACHMENT0+Z;it.length=K.length,ut=!0}}else it[0]!==i.BACK&&(it[0]=i.BACK,ut=!0);ut&&i.drawBuffers(it)}function Gt(R){return _!==R?(i.useProgram(R),_=R,!0):!1}let Se={[On]:i.FUNC_ADD,[Bl]:i.FUNC_SUBTRACT,[zl]:i.FUNC_REVERSE_SUBTRACT};Se[kl]=i.MIN,Se[Vl]=i.MAX;let T={[Hl]:i.ZERO,[Gl]:i.ONE,[Wl]:i.SRC_COLOR,[or]:i.SRC_ALPHA,[$l]:i.SRC_ALPHA_SATURATE,[Zl]:i.DST_COLOR,[ql]:i.DST_ALPHA,[Xl]:i.ONE_MINUS_SRC_COLOR,[lr]:i.ONE_MINUS_SRC_ALPHA,[Jl]:i.ONE_MINUS_DST_COLOR,[Yl]:i.ONE_MINUS_DST_ALPHA,[Kl]:i.CONSTANT_COLOR,[jl]:i.ONE_MINUS_CONSTANT_COLOR,[Ql]:i.CONSTANT_ALPHA,[tc]:i.ONE_MINUS_CONSTANT_ALPHA};function ie(R,tt,it,ut,K,Z,pt,Dt,Qt,Yt){if(R===wn){v===!0&&(dt(i.BLEND),v=!1);return}if(v===!1&&($(i.BLEND),v=!0),R!==Ol){if(R!==m||Yt!==M){if((h!==On||S!==On)&&(i.blendEquation(i.FUNC_ADD),h=On,S=On),Yt)switch(R){case ei:i.blendFuncSeparate(i.ONE,i.ONE_MINUS_SRC_ALPHA,i.ONE,i.ONE_MINUS_SRC_ALPHA);break;case mo:i.blendFunc(i.ONE,i.ONE);break;case go:i.blendFuncSeparate(i.ZERO,i.ONE_MINUS_SRC_COLOR,i.ZERO,i.ONE);break;case _o:i.blendFuncSeparate(i.DST_COLOR,i.ONE_MINUS_SRC_ALPHA,i.ZERO,i.ONE);break;default:console.error("THREE.WebGLState: Invalid blending: ",R);break}else switch(R){case ei:i.blendFuncSeparate(i.SRC_ALPHA,i.ONE_MINUS_SRC_ALPHA,i.ONE,i.ONE_MINUS_SRC_ALPHA);break;case mo:i.blendFuncSeparate(i.SRC_ALPHA,i.ONE,i.ONE,i.ONE);break;case go:console.error("THREE.WebGLState: SubtractiveBlending requires material.premultipliedAlpha = true");break;case _o:console.error("THREE.WebGLState: MultiplyBlending requires material.premultipliedAlpha = true");break;default:console.error("THREE.WebGLState: Invalid blending: ",R);break}w=null,E=null,C=null,A=null,P.set(0,0,0),U=0,m=R,M=Yt}return}K=K||tt,Z=Z||it,pt=pt||ut,(tt!==h||K!==S)&&(i.blendEquationSeparate(Se[tt],Se[K]),h=tt,S=K),(it!==w||ut!==E||Z!==C||pt!==A)&&(i.blendFuncSeparate(T[it],T[ut],T[Z],T[pt]),w=it,E=ut,C=Z,A=pt),(Dt.equals(P)===!1||Qt!==U)&&(i.blendColor(Dt.r,Dt.g,Dt.b,Qt),P.copy(Dt),U=Qt),m=R,M=!1}function Lt(R,tt){R.side===mn?dt(i.CULL_FACE):$(i.CULL_FACE);let it=R.side===De;tt&&(it=!it),At(it),R.blending===ei&&R.transparent===!1?ie(wn):ie(R.blending,R.blendEquation,R.blendSrc,R.blendDst,R.blendEquationAlpha,R.blendSrcAlpha,R.blendDstAlpha,R.blendColor,R.blendAlpha,R.premultipliedAlpha),a.setFunc(R.depthFunc),a.setTest(R.depthTest),a.setMask(R.depthWrite),r.setMask(R.colorWrite);let ut=R.stencilWrite;o.setTest(ut),ut&&(o.setMask(R.stencilWriteMask),o.setFunc(R.stencilFunc,R.stencilRef,R.stencilFuncMask),o.setOp(R.stencilFail,R.stencilZFail,R.stencilZPass)),gt(R.polygonOffset,R.polygonOffsetFactor,R.polygonOffsetUnits),R.alphaToCoverage===!0?$(i.SAMPLE_ALPHA_TO_COVERAGE):dt(i.SAMPLE_ALPHA_TO_COVERAGE)}function At(R){y!==R&&(R?i.frontFace(i.CW):i.frontFace(i.CCW),y=R)}function mt(R){R!==Nl?($(i.CULL_FACE),R!==I&&(R===fo?i.cullFace(i.BACK):R===Fl?i.cullFace(i.FRONT):i.cullFace(i.FRONT_AND_BACK))):dt(i.CULL_FACE),I=R}function se(R){R!==O&&(W&&i.lineWidth(R),O=R)}function gt(R,tt,it){R?($(i.POLYGON_OFFSET_FILL),(k!==tt||G!==it)&&(i.polygonOffset(tt,it),k=tt,G=it)):dt(i.POLYGON_OFFSET_FILL)}function Ot(R){R?$(i.SCISSOR_TEST):dt(i.SCISSOR_TEST)}function ye(R){R===void 0&&(R=i.TEXTURE0+q-1),rt!==R&&(i.activeTexture(R),rt=R)}function he(R,tt,it){it===void 0&&(rt===null?it=i.TEXTURE0+q-1:it=rt);let ut=ct[it];ut===void 0&&(ut={type:void 0,texture:void 0},ct[it]=ut),(ut.type!==R||ut.texture!==tt)&&(rt!==it&&(i.activeTexture(it),rt=it),i.bindTexture(R,tt||Y[R]),ut.type=R,ut.texture=tt)}function b(){let R=ct[rt];R!==void 0&&R.type!==void 0&&(i.bindTexture(R.type,null),R.type=void 0,R.texture=void 0)}function g(){try{i.compressedTexImage2D(...arguments)}catch(R){console.error("THREE.WebGLState:",R)}}function F(){try{i.compressedTexImage3D(...arguments)}catch(R){console.error("THREE.WebGLState:",R)}}function X(){try{i.texSubImage2D(...arguments)}catch(R){console.error("THREE.WebGLState:",R)}}function J(){try{i.texSubImage3D(...arguments)}catch(R){console.error("THREE.WebGLState:",R)}}function H(){try{i.compressedTexSubImage2D(...arguments)}catch(R){console.error("THREE.WebGLState:",R)}}function vt(){try{i.compressedTexSubImage3D(...arguments)}catch(R){console.error("THREE.WebGLState:",R)}}function nt(){try{i.texStorage2D(...arguments)}catch(R){console.error("THREE.WebGLState:",R)}}function _t(){try{i.texStorage3D(...arguments)}catch(R){console.error("THREE.WebGLState:",R)}}function xt(){try{i.texImage2D(...arguments)}catch(R){console.error("THREE.WebGLState:",R)}}function Q(){try{i.texImage3D(...arguments)}catch(R){console.error("THREE.WebGLState:",R)}}function lt(R){jt.equals(R)===!1&&(i.scissor(R.x,R.y,R.z,R.w),jt.copy(R))}function wt(R){ne.equals(R)===!1&&(i.viewport(R.x,R.y,R.z,R.w),ne.copy(R))}function yt(R,tt){let it=c.get(tt);it===void 0&&(it=new WeakMap,c.set(tt,it));let ut=it.get(R);ut===void 0&&(ut=i.getUniformBlockIndex(tt,R.name),it.set(R,ut))}function at(R,tt){let ut=c.get(tt).get(R);l.get(tt)!==ut&&(i.uniformBlockBinding(tt,ut,R.__bindingPointIndex),l.set(tt,ut))}function Nt(){i.disable(i.BLEND),i.disable(i.CULL_FACE),i.disable(i.DEPTH_TEST),i.disable(i.POLYGON_OFFSET_FILL),i.disable(i.SCISSOR_TEST),i.disable(i.STENCIL_TEST),i.disable(i.SAMPLE_ALPHA_TO_COVERAGE),i.blendEquation(i.FUNC_ADD),i.blendFunc(i.ONE,i.ZERO),i.blendFuncSeparate(i.ONE,i.ZERO,i.ONE,i.ZERO),i.blendColor(0,0,0,0),i.colorMask(!0,!0,!0,!0),i.clearColor(0,0,0,0),i.depthMask(!0),i.depthFunc(i.LESS),a.setReversed(!1),i.clearDepth(1),i.stencilMask(4294967295),i.stencilFunc(i.ALWAYS,0,4294967295),i.stencilOp(i.KEEP,i.KEEP,i.KEEP),i.clearStencil(0),i.cullFace(i.BACK),i.frontFace(i.CCW),i.polygonOffset(0,0),i.activeTexture(i.TEXTURE0),i.bindFramebuffer(i.FRAMEBUFFER,null),i.bindFramebuffer(i.DRAW_FRAMEBUFFER,null),i.bindFramebuffer(i.READ_FRAMEBUFFER,null),i.useProgram(null),i.lineWidth(1),i.scissor(0,0,i.canvas.width,i.canvas.height),i.viewport(0,0,i.canvas.width,i.canvas.height),u={},rt=null,ct={},d={},f=new WeakMap,p=[],_=null,v=!1,m=null,h=null,w=null,E=null,S=null,C=null,A=null,P=new Ht(0,0,0),U=0,M=!1,y=null,I=null,O=null,k=null,G=null,jt.set(0,0,i.canvas.width,i.canvas.height),ne.set(0,0,i.canvas.width,i.canvas.height),r.reset(),a.reset(),o.reset()}return{buffers:{color:r,depth:a,stencil:o},enable:$,disable:dt,bindFramebuffer:Pt,drawBuffers:Mt,useProgram:Gt,setBlending:ie,setMaterial:Lt,setFlipSided:At,setCullFace:mt,setLineWidth:se,setPolygonOffset:gt,setScissorTest:Ot,activeTexture:ye,bindTexture:he,unbindTexture:b,compressedTexImage2D:g,compressedTexImage3D:F,texImage2D:xt,texImage3D:Q,updateUBOMapping:yt,uniformBlockBinding:at,texStorage2D:nt,texStorage3D:_t,texSubImage2D:X,texSubImage3D:J,compressedTexSubImage2D:H,compressedTexSubImage3D:vt,scissor:lt,viewport:wt,reset:Nt}}function zm(i,t,e,n,s,r,a){let o=t.has("WEBGL_multisampled_render_to_texture")?t.get("WEBGL_multisampled_render_to_texture"):null,l=typeof navigator>"u"?!1:/OculusBrowser/g.test(navigator.userAgent),c=new Rt,u=new WeakMap,d,f=new WeakMap,p=!1;try{p=typeof OffscreenCanvas<"u"&&new OffscreenCanvas(1,1).getContext("2d")!==null}catch{}function _(b,g){return p?new OffscreenCanvas(b,g):us("canvas")}function v(b,g,F){let X=1,J=he(b);if((J.width>F||J.height>F)&&(X=F/Math.max(J.width,J.height)),X<1)if(typeof HTMLImageElement<"u"&&b instanceof HTMLImageElement||typeof HTMLCanvasElement<"u"&&b instanceof HTMLCanvasElement||typeof ImageBitmap<"u"&&b instanceof ImageBitmap||typeof VideoFrame<"u"&&b instanceof VideoFrame){let H=Math.floor(X*J.width),vt=Math.floor(X*J.height);d===void 0&&(d=_(H,vt));let nt=g?_(H,vt):d;return nt.width=H,nt.height=vt,nt.getContext("2d").drawImage(b,0,0,H,vt),console.warn("THREE.WebGLRenderer: Texture has been resized from ("+J.width+"x"+J.height+") to ("+H+"x"+vt+")."),nt}else return"data"in b&&console.warn("THREE.WebGLRenderer: Image in DataTexture is too big ("+J.width+"x"+J.height+")."),b;return b}function m(b){return b.generateMipmaps}function h(b){i.generateMipmap(b)}function w(b){return b.isWebGLCubeRenderTarget?i.TEXTURE_CUBE_MAP:b.isWebGL3DRenderTarget?i.TEXTURE_3D:b.isWebGLArrayRenderTarget||b.isCompressedArrayTexture?i.TEXTURE_2D_ARRAY:i.TEXTURE_2D}function E(b,g,F,X,J=!1){if(b!==null){if(i[b]!==void 0)return i[b];console.warn("THREE.WebGLRenderer: Attempt to use non-existing WebGL internal format '"+b+"'")}let H=g;if(g===i.RED&&(F===i.FLOAT&&(H=i.R32F),F===i.HALF_FLOAT&&(H=i.R16F),F===i.UNSIGNED_BYTE&&(H=i.R8)),g===i.RED_INTEGER&&(F===i.UNSIGNED_BYTE&&(H=i.R8UI),F===i.UNSIGNED_SHORT&&(H=i.R16UI),F===i.UNSIGNED_INT&&(H=i.R32UI),F===i.BYTE&&(H=i.R8I),F===i.SHORT&&(H=i.R16I),F===i.INT&&(H=i.R32I)),g===i.RG&&(F===i.FLOAT&&(H=i.RG32F),F===i.HALF_FLOAT&&(H=i.RG16F),F===i.UNSIGNED_BYTE&&(H=i.RG8)),g===i.RG_INTEGER&&(F===i.UNSIGNED_BYTE&&(H=i.RG8UI),F===i.UNSIGNED_SHORT&&(H=i.RG16UI),F===i.UNSIGNED_INT&&(H=i.RG32UI),F===i.BYTE&&(H=i.RG8I),F===i.SHORT&&(H=i.RG16I),F===i.INT&&(H=i.RG32I)),g===i.RGB_INTEGER&&(F===i.UNSIGNED_BYTE&&(H=i.RGB8UI),F===i.UNSIGNED_SHORT&&(H=i.RGB16UI),F===i.UNSIGNED_INT&&(H=i.RGB32UI),F===i.BYTE&&(H=i.RGB8I),F===i.SHORT&&(H=i.RGB16I),F===i.INT&&(H=i.RGB32I)),g===i.RGBA_INTEGER&&(F===i.UNSIGNED_BYTE&&(H=i.RGBA8UI),F===i.UNSIGNED_SHORT&&(H=i.RGBA16UI),F===i.UNSIGNED_INT&&(H=i.RGBA32UI),F===i.BYTE&&(H=i.RGBA8I),F===i.SHORT&&(H=i.RGBA16I),F===i.INT&&(H=i.RGBA32I)),g===i.RGB&&(F===i.UNSIGNED_INT_5_9_9_9_REV&&(H=i.RGB9_E5),F===i.UNSIGNED_INT_10F_11F_11F_REV&&(H=i.R11F_G11F_B10F)),g===i.RGBA){let vt=J?cs:Wt.getTransfer(X);F===i.FLOAT&&(H=i.RGBA32F),F===i.HALF_FLOAT&&(H=i.RGBA16F),F===i.UNSIGNED_BYTE&&(H=vt===Zt?i.SRGB8_ALPHA8:i.RGBA8),F===i.UNSIGNED_SHORT_4_4_4_4&&(H=i.RGBA4),F===i.UNSIGNED_SHORT_5_5_5_1&&(H=i.RGB5_A1)}return(H===i.R16F||H===i.R32F||H===i.RG16F||H===i.RG32F||H===i.RGBA16F||H===i.RGBA32F)&&t.get("EXT_color_buffer_float"),H}function S(b,g){let F;return b?g===null||g===qn||g===Wi?F=i.DEPTH24_STENCIL8:g===gn?F=i.DEPTH32F_STENCIL8:g===Hi&&(F=i.DEPTH24_STENCIL8,console.warn("DepthTexture: 16 bit depth attachment is not supported with stencil. Using 24-bit attachment.")):g===null||g===qn||g===Wi?F=i.DEPTH_COMPONENT24:g===gn?F=i.DEPTH_COMPONENT32F:g===Hi&&(F=i.DEPTH_COMPONENT16),F}function C(b,g){return m(b)===!0||b.isFramebufferTexture&&b.minFilter!==Ze&&b.minFilter!==nn?Math.log2(Math.max(g.width,g.height))+1:b.mipmaps!==void 0&&b.mipmaps.length>0?b.mipmaps.length:b.isCompressedTexture&&Array.isArray(b.image)?g.mipmaps.length:1}function A(b){let g=b.target;g.removeEventListener("dispose",A),U(g),g.isVideoTexture&&u.delete(g)}function P(b){let g=b.target;g.removeEventListener("dispose",P),y(g)}function U(b){let g=n.get(b);if(g.__webglInit===void 0)return;let F=b.source,X=f.get(F);if(X){let J=X[g.__cacheKey];J.usedTimes--,J.usedTimes===0&&M(b),Object.keys(X).length===0&&f.delete(F)}n.remove(b)}function M(b){let g=n.get(b);i.deleteTexture(g.__webglTexture);let F=b.source,X=f.get(F);delete X[g.__cacheKey],a.memory.textures--}function y(b){let g=n.get(b);if(b.depthTexture&&(b.depthTexture.dispose(),n.remove(b.depthTexture)),b.isWebGLCubeRenderTarget)for(let X=0;X<6;X++){if(Array.isArray(g.__webglFramebuffer[X]))for(let J=0;J<g.__webglFramebuffer[X].length;J++)i.deleteFramebuffer(g.__webglFramebuffer[X][J]);else i.deleteFramebuffer(g.__webglFramebuffer[X]);g.__webglDepthbuffer&&i.deleteRenderbuffer(g.__webglDepthbuffer[X])}else{if(Array.isArray(g.__webglFramebuffer))for(let X=0;X<g.__webglFramebuffer.length;X++)i.deleteFramebuffer(g.__webglFramebuffer[X]);else i.deleteFramebuffer(g.__webglFramebuffer);if(g.__webglDepthbuffer&&i.deleteRenderbuffer(g.__webglDepthbuffer),g.__webglMultisampledFramebuffer&&i.deleteFramebuffer(g.__webglMultisampledFramebuffer),g.__webglColorRenderbuffer)for(let X=0;X<g.__webglColorRenderbuffer.length;X++)g.__webglColorRenderbuffer[X]&&i.deleteRenderbuffer(g.__webglColorRenderbuffer[X]);g.__webglDepthRenderbuffer&&i.deleteRenderbuffer(g.__webglDepthRenderbuffer)}let F=b.textures;for(let X=0,J=F.length;X<J;X++){let H=n.get(F[X]);H.__webglTexture&&(i.deleteTexture(H.__webglTexture),a.memory.textures--),n.remove(F[X])}n.remove(b)}let I=0;function O(){I=0}function k(){let b=I;return b>=s.maxTextures&&console.warn("THREE.WebGLTextures: Trying to use "+b+" texture units while this GPU supports only "+s.maxTextures),I+=1,b}function G(b){let g=[];return g.push(b.wrapS),g.push(b.wrapT),g.push(b.wrapR||0),g.push(b.magFilter),g.push(b.minFilter),g.push(b.anisotropy),g.push(b.internalFormat),g.push(b.format),g.push(b.type),g.push(b.generateMipmaps),g.push(b.premultiplyAlpha),g.push(b.flipY),g.push(b.unpackAlignment),g.push(b.colorSpace),g.join()}function q(b,g){let F=n.get(b);if(b.isVideoTexture&&Ot(b),b.isRenderTargetTexture===!1&&b.isExternalTexture!==!0&&b.version>0&&F.__version!==b.version){let X=b.image;if(X===null)console.warn("THREE.WebGLRenderer: Texture marked for update but no image data found.");else if(X.complete===!1)console.warn("THREE.WebGLRenderer: Texture marked for update but image is incomplete");else{Y(F,b,g);return}}else b.isExternalTexture&&(F.__webglTexture=b.sourceTexture?b.sourceTexture:null);e.bindTexture(i.TEXTURE_2D,F.__webglTexture,i.TEXTURE0+g)}function W(b,g){let F=n.get(b);if(b.isRenderTargetTexture===!1&&b.version>0&&F.__version!==b.version){Y(F,b,g);return}e.bindTexture(i.TEXTURE_2D_ARRAY,F.__webglTexture,i.TEXTURE0+g)}function et(b,g){let F=n.get(b);if(b.isRenderTargetTexture===!1&&b.version>0&&F.__version!==b.version){Y(F,b,g);return}e.bindTexture(i.TEXTURE_3D,F.__webglTexture,i.TEXTURE0+g)}function V(b,g){let F=n.get(b);if(b.version>0&&F.__version!==b.version){$(F,b,g);return}e.bindTexture(i.TEXTURE_CUBE_MAP,F.__webglTexture,i.TEXTURE0+g)}let rt={[cr]:i.REPEAT,[Fn]:i.CLAMP_TO_EDGE,[hr]:i.MIRRORED_REPEAT},ct={[Ze]:i.NEAREST,[cc]:i.NEAREST_MIPMAP_NEAREST,[Ps]:i.NEAREST_MIPMAP_LINEAR,[nn]:i.LINEAR,[kr]:i.LINEAR_MIPMAP_NEAREST,[Xn]:i.LINEAR_MIPMAP_LINEAR},St={[fc]:i.NEVER,[yc]:i.ALWAYS,[pc]:i.LESS,[Ro]:i.LEQUAL,[mc]:i.EQUAL,[xc]:i.GEQUAL,[gc]:i.GREATER,[_c]:i.NOTEQUAL};function kt(b,g){if(g.type===gn&&t.has("OES_texture_float_linear")===!1&&(g.magFilter===nn||g.magFilter===kr||g.magFilter===Ps||g.magFilter===Xn||g.minFilter===nn||g.minFilter===kr||g.minFilter===Ps||g.minFilter===Xn)&&console.warn("THREE.WebGLRenderer: Unable to use linear filtering with floating point textures. OES_texture_float_linear not supported on this device."),i.texParameteri(b,i.TEXTURE_WRAP_S,rt[g.wrapS]),i.texParameteri(b,i.TEXTURE_WRAP_T,rt[g.wrapT]),(b===i.TEXTURE_3D||b===i.TEXTURE_2D_ARRAY)&&i.texParameteri(b,i.TEXTURE_WRAP_R,rt[g.wrapR]),i.texParameteri(b,i.TEXTURE_MAG_FILTER,ct[g.magFilter]),i.texParameteri(b,i.TEXTURE_MIN_FILTER,ct[g.minFilter]),g.compareFunction&&(i.texParameteri(b,i.TEXTURE_COMPARE_MODE,i.COMPARE_REF_TO_TEXTURE),i.texParameteri(b,i.TEXTURE_COMPARE_FUNC,St[g.compareFunction])),t.has("EXT_texture_filter_anisotropic")===!0){if(g.magFilter===Ze||g.minFilter!==Ps&&g.minFilter!==Xn||g.type===gn&&t.has("OES_texture_float_linear")===!1)return;if(g.anisotropy>1||n.get(g).__currentAnisotropy){let F=t.get("EXT_texture_filter_anisotropic");i.texParameterf(b,F.TEXTURE_MAX_ANISOTROPY_EXT,Math.min(g.anisotropy,s.getMaxAnisotropy())),n.get(g).__currentAnisotropy=g.anisotropy}}}function jt(b,g){let F=!1;b.__webglInit===void 0&&(b.__webglInit=!0,g.addEventListener("dispose",A));let X=g.source,J=f.get(X);J===void 0&&(J={},f.set(X,J));let H=G(g);if(H!==b.__cacheKey){J[H]===void 0&&(J[H]={texture:i.createTexture(),usedTimes:0},a.memory.textures++,F=!0),J[H].usedTimes++;let vt=J[b.__cacheKey];vt!==void 0&&(J[b.__cacheKey].usedTimes--,vt.usedTimes===0&&M(g)),b.__cacheKey=H,b.__webglTexture=J[H].texture}return F}function ne(b,g,F){return Math.floor(Math.floor(b/F)/g)}function qt(b,g,F,X){let H=b.updateRanges;if(H.length===0)e.texSubImage2D(i.TEXTURE_2D,0,0,0,g.width,g.height,F,X,g.data);else{H.sort((Q,lt)=>Q.start-lt.start);let vt=0;for(let Q=1;Q<H.length;Q++){let lt=H[vt],wt=H[Q],yt=lt.start+lt.count,at=ne(wt.start,g.width,4),Nt=ne(lt.start,g.width,4);wt.start<=yt+1&&at===Nt&&ne(wt.start+wt.count-1,g.width,4)===at?lt.count=Math.max(lt.count,wt.start+wt.count-lt.start):(++vt,H[vt]=wt)}H.length=vt+1;let nt=i.getParameter(i.UNPACK_ROW_LENGTH),_t=i.getParameter(i.UNPACK_SKIP_PIXELS),xt=i.getParameter(i.UNPACK_SKIP_ROWS);i.pixelStorei(i.UNPACK_ROW_LENGTH,g.width);for(let Q=0,lt=H.length;Q<lt;Q++){let wt=H[Q],yt=Math.floor(wt.start/4),at=Math.ceil(wt.count/4),Nt=yt%g.width,R=Math.floor(yt/g.width),tt=at,it=1;i.pixelStorei(i.UNPACK_SKIP_PIXELS,Nt),i.pixelStorei(i.UNPACK_SKIP_ROWS,R),e.texSubImage2D(i.TEXTURE_2D,0,Nt,R,tt,it,F,X,g.data)}b.clearUpdateRanges(),i.pixelStorei(i.UNPACK_ROW_LENGTH,nt),i.pixelStorei(i.UNPACK_SKIP_PIXELS,_t),i.pixelStorei(i.UNPACK_SKIP_ROWS,xt)}}function Y(b,g,F){let X=i.TEXTURE_2D;(g.isDataArrayTexture||g.isCompressedArrayTexture)&&(X=i.TEXTURE_2D_ARRAY),g.isData3DTexture&&(X=i.TEXTURE_3D);let J=jt(b,g),H=g.source;e.bindTexture(X,b.__webglTexture,i.TEXTURE0+F);let vt=n.get(H);if(H.version!==vt.__version||J===!0){e.activeTexture(i.TEXTURE0+F);let nt=Wt.getPrimaries(Wt.workingColorSpace),_t=g.colorSpace===Cn?null:Wt.getPrimaries(g.colorSpace),xt=g.colorSpace===Cn||nt===_t?i.NONE:i.BROWSER_DEFAULT_WEBGL;i.pixelStorei(i.UNPACK_FLIP_Y_WEBGL,g.flipY),i.pixelStorei(i.UNPACK_PREMULTIPLY_ALPHA_WEBGL,g.premultiplyAlpha),i.pixelStorei(i.UNPACK_ALIGNMENT,g.unpackAlignment),i.pixelStorei(i.UNPACK_COLORSPACE_CONVERSION_WEBGL,xt);let Q=v(g.image,!1,s.maxTextureSize);Q=ye(g,Q);let lt=r.convert(g.format,g.colorSpace),wt=r.convert(g.type),yt=E(g.internalFormat,lt,wt,g.colorSpace,g.isVideoTexture);kt(X,g);let at,Nt=g.mipmaps,R=g.isVideoTexture!==!0,tt=vt.__version===void 0||J===!0,it=H.dataReady,ut=C(g,Q);if(g.isDepthTexture)yt=S(g.format===Xi,g.type),tt&&(R?e.texStorage2D(i.TEXTURE_2D,1,yt,Q.width,Q.height):e.texImage2D(i.TEXTURE_2D,0,yt,Q.width,Q.height,0,lt,wt,null));else if(g.isDataTexture)if(Nt.length>0){R&&tt&&e.texStorage2D(i.TEXTURE_2D,ut,yt,Nt[0].width,Nt[0].height);for(let K=0,Z=Nt.length;K<Z;K++)at=Nt[K],R?it&&e.texSubImage2D(i.TEXTURE_2D,K,0,0,at.width,at.height,lt,wt,at.data):e.texImage2D(i.TEXTURE_2D,K,yt,at.width,at.height,0,lt,wt,at.data);g.generateMipmaps=!1}else R?(tt&&e.texStorage2D(i.TEXTURE_2D,ut,yt,Q.width,Q.height),it&&qt(g,Q,lt,wt)):e.texImage2D(i.TEXTURE_2D,0,yt,Q.width,Q.height,0,lt,wt,Q.data);else if(g.isCompressedTexture)if(g.isCompressedArrayTexture){R&&tt&&e.texStorage3D(i.TEXTURE_2D_ARRAY,ut,yt,Nt[0].width,Nt[0].height,Q.depth);for(let K=0,Z=Nt.length;K<Z;K++)if(at=Nt[K],g.format!==$e)if(lt!==null)if(R){if(it)if(g.layerUpdates.size>0){let pt=Oo(at.width,at.height,g.format,g.type);for(let Dt of g.layerUpdates){let Qt=at.data.subarray(Dt*pt/at.data.BYTES_PER_ELEMENT,(Dt+1)*pt/at.data.BYTES_PER_ELEMENT);e.compressedTexSubImage3D(i.TEXTURE_2D_ARRAY,K,0,0,Dt,at.width,at.height,1,lt,Qt)}g.clearLayerUpdates()}else e.compressedTexSubImage3D(i.TEXTURE_2D_ARRAY,K,0,0,0,at.width,at.height,Q.depth,lt,at.data)}else e.compressedTexImage3D(i.TEXTURE_2D_ARRAY,K,yt,at.width,at.height,Q.depth,0,at.data,0,0);else console.warn("THREE.WebGLRenderer: Attempt to load unsupported compressed texture format in .uploadTexture()");else R?it&&e.texSubImage3D(i.TEXTURE_2D_ARRAY,K,0,0,0,at.width,at.height,Q.depth,lt,wt,at.data):e.texImage3D(i.TEXTURE_2D_ARRAY,K,yt,at.width,at.height,Q.depth,0,lt,wt,at.data)}else{R&&tt&&e.texStorage2D(i.TEXTURE_2D,ut,yt,Nt[0].width,Nt[0].height);for(let K=0,Z=Nt.length;K<Z;K++)at=Nt[K],g.format!==$e?lt!==null?R?it&&e.compressedTexSubImage2D(i.TEXTURE_2D,K,0,0,at.width,at.height,lt,at.data):e.compressedTexImage2D(i.TEXTURE_2D,K,yt,at.width,at.height,0,at.data):console.warn("THREE.WebGLRenderer: Attempt to load unsupported compressed texture format in .uploadTexture()"):R?it&&e.texSubImage2D(i.TEXTURE_2D,K,0,0,at.width,at.height,lt,wt,at.data):e.texImage2D(i.TEXTURE_2D,K,yt,at.width,at.height,0,lt,wt,at.data)}else if(g.isDataArrayTexture)if(R){if(tt&&e.texStorage3D(i.TEXTURE_2D_ARRAY,ut,yt,Q.width,Q.height,Q.depth),it)if(g.layerUpdates.size>0){let K=Oo(Q.width,Q.height,g.format,g.type);for(let Z of g.layerUpdates){let pt=Q.data.subarray(Z*K/Q.data.BYTES_PER_ELEMENT,(Z+1)*K/Q.data.BYTES_PER_ELEMENT);e.texSubImage3D(i.TEXTURE_2D_ARRAY,0,0,0,Z,Q.width,Q.height,1,lt,wt,pt)}g.clearLayerUpdates()}else e.texSubImage3D(i.TEXTURE_2D_ARRAY,0,0,0,0,Q.width,Q.height,Q.depth,lt,wt,Q.data)}else e.texImage3D(i.TEXTURE_2D_ARRAY,0,yt,Q.width,Q.height,Q.depth,0,lt,wt,Q.data);else if(g.isData3DTexture)R?(tt&&e.texStorage3D(i.TEXTURE_3D,ut,yt,Q.width,Q.height,Q.depth),it&&e.texSubImage3D(i.TEXTURE_3D,0,0,0,0,Q.width,Q.height,Q.depth,lt,wt,Q.data)):e.texImage3D(i.TEXTURE_3D,0,yt,Q.width,Q.height,Q.depth,0,lt,wt,Q.data);else if(g.isFramebufferTexture){if(tt)if(R)e.texStorage2D(i.TEXTURE_2D,ut,yt,Q.width,Q.height);else{let K=Q.width,Z=Q.height;for(let pt=0;pt<ut;pt++)e.texImage2D(i.TEXTURE_2D,pt,yt,K,Z,0,lt,wt,null),K>>=1,Z>>=1}}else if(Nt.length>0){if(R&&tt){let K=he(Nt[0]);e.texStorage2D(i.TEXTURE_2D,ut,yt,K.width,K.height)}for(let K=0,Z=Nt.length;K<Z;K++)at=Nt[K],R?it&&e.texSubImage2D(i.TEXTURE_2D,K,0,0,lt,wt,at):e.texImage2D(i.TEXTURE_2D,K,yt,lt,wt,at);g.generateMipmaps=!1}else if(R){if(tt){let K=he(Q);e.texStorage2D(i.TEXTURE_2D,ut,yt,K.width,K.height)}it&&e.texSubImage2D(i.TEXTURE_2D,0,0,0,lt,wt,Q)}else e.texImage2D(i.TEXTURE_2D,0,yt,lt,wt,Q);m(g)&&h(X),vt.__version=H.version,g.onUpdate&&g.onUpdate(g)}b.__version=g.version}function $(b,g,F){if(g.image.length!==6)return;let X=jt(b,g),J=g.source;e.bindTexture(i.TEXTURE_CUBE_MAP,b.__webglTexture,i.TEXTURE0+F);let H=n.get(J);if(J.version!==H.__version||X===!0){e.activeTexture(i.TEXTURE0+F);let vt=Wt.getPrimaries(Wt.workingColorSpace),nt=g.colorSpace===Cn?null:Wt.getPrimaries(g.colorSpace),_t=g.colorSpace===Cn||vt===nt?i.NONE:i.BROWSER_DEFAULT_WEBGL;i.pixelStorei(i.UNPACK_FLIP_Y_WEBGL,g.flipY),i.pixelStorei(i.UNPACK_PREMULTIPLY_ALPHA_WEBGL,g.premultiplyAlpha),i.pixelStorei(i.UNPACK_ALIGNMENT,g.unpackAlignment),i.pixelStorei(i.UNPACK_COLORSPACE_CONVERSION_WEBGL,_t);let xt=g.isCompressedTexture||g.image[0].isCompressedTexture,Q=g.image[0]&&g.image[0].isDataTexture,lt=[];for(let Z=0;Z<6;Z++)!xt&&!Q?lt[Z]=v(g.image[Z],!0,s.maxCubemapSize):lt[Z]=Q?g.image[Z].image:g.image[Z],lt[Z]=ye(g,lt[Z]);let wt=lt[0],yt=r.convert(g.format,g.colorSpace),at=r.convert(g.type),Nt=E(g.internalFormat,yt,at,g.colorSpace),R=g.isVideoTexture!==!0,tt=H.__version===void 0||X===!0,it=J.dataReady,ut=C(g,wt);kt(i.TEXTURE_CUBE_MAP,g);let K;if(xt){R&&tt&&e.texStorage2D(i.TEXTURE_CUBE_MAP,ut,Nt,wt.width,wt.height);for(let Z=0;Z<6;Z++){K=lt[Z].mipmaps;for(let pt=0;pt<K.length;pt++){let Dt=K[pt];g.format!==$e?yt!==null?R?it&&e.compressedTexSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,pt,0,0,Dt.width,Dt.height,yt,Dt.data):e.compressedTexImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,pt,Nt,Dt.width,Dt.height,0,Dt.data):console.warn("THREE.WebGLRenderer: Attempt to load unsupported compressed texture format in .setTextureCube()"):R?it&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,pt,0,0,Dt.width,Dt.height,yt,at,Dt.data):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,pt,Nt,Dt.width,Dt.height,0,yt,at,Dt.data)}}}else{if(K=g.mipmaps,R&&tt){K.length>0&&ut++;let Z=he(lt[0]);e.texStorage2D(i.TEXTURE_CUBE_MAP,ut,Nt,Z.width,Z.height)}for(let Z=0;Z<6;Z++)if(Q){R?it&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,0,0,0,lt[Z].width,lt[Z].height,yt,at,lt[Z].data):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,0,Nt,lt[Z].width,lt[Z].height,0,yt,at,lt[Z].data);for(let pt=0;pt<K.length;pt++){let Qt=K[pt].image[Z].image;R?it&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,pt+1,0,0,Qt.width,Qt.height,yt,at,Qt.data):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,pt+1,Nt,Qt.width,Qt.height,0,yt,at,Qt.data)}}else{R?it&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,0,0,0,yt,at,lt[Z]):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,0,Nt,yt,at,lt[Z]);for(let pt=0;pt<K.length;pt++){let Dt=K[pt];R?it&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,pt+1,0,0,yt,at,Dt.image[Z]):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+Z,pt+1,Nt,yt,at,Dt.image[Z])}}}m(g)&&h(i.TEXTURE_CUBE_MAP),H.__version=J.version,g.onUpdate&&g.onUpdate(g)}b.__version=g.version}function dt(b,g,F,X,J,H){let vt=r.convert(F.format,F.colorSpace),nt=r.convert(F.type),_t=E(F.internalFormat,vt,nt,F.colorSpace),xt=n.get(g),Q=n.get(F);if(Q.__renderTarget=g,!xt.__hasExternalTextures){let lt=Math.max(1,g.width>>H),wt=Math.max(1,g.height>>H);J===i.TEXTURE_3D||J===i.TEXTURE_2D_ARRAY?e.texImage3D(J,H,_t,lt,wt,g.depth,0,vt,nt,null):e.texImage2D(J,H,_t,lt,wt,0,vt,nt,null)}e.bindFramebuffer(i.FRAMEBUFFER,b),gt(g)?o.framebufferTexture2DMultisampleEXT(i.FRAMEBUFFER,X,J,Q.__webglTexture,0,se(g)):(J===i.TEXTURE_2D||J>=i.TEXTURE_CUBE_MAP_POSITIVE_X&&J<=i.TEXTURE_CUBE_MAP_NEGATIVE_Z)&&i.framebufferTexture2D(i.FRAMEBUFFER,X,J,Q.__webglTexture,H),e.bindFramebuffer(i.FRAMEBUFFER,null)}function Pt(b,g,F){if(i.bindRenderbuffer(i.RENDERBUFFER,b),g.depthBuffer){let X=g.depthTexture,J=X&&X.isDepthTexture?X.type:null,H=S(g.stencilBuffer,J),vt=g.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,nt=se(g);gt(g)?o.renderbufferStorageMultisampleEXT(i.RENDERBUFFER,nt,H,g.width,g.height):F?i.renderbufferStorageMultisample(i.RENDERBUFFER,nt,H,g.width,g.height):i.renderbufferStorage(i.RENDERBUFFER,H,g.width,g.height),i.framebufferRenderbuffer(i.FRAMEBUFFER,vt,i.RENDERBUFFER,b)}else{let X=g.textures;for(let J=0;J<X.length;J++){let H=X[J],vt=r.convert(H.format,H.colorSpace),nt=r.convert(H.type),_t=E(H.internalFormat,vt,nt,H.colorSpace),xt=se(g);F&&gt(g)===!1?i.renderbufferStorageMultisample(i.RENDERBUFFER,xt,_t,g.width,g.height):gt(g)?o.renderbufferStorageMultisampleEXT(i.RENDERBUFFER,xt,_t,g.width,g.height):i.renderbufferStorage(i.RENDERBUFFER,_t,g.width,g.height)}}i.bindRenderbuffer(i.RENDERBUFFER,null)}function Mt(b,g){if(g&&g.isWebGLCubeRenderTarget)throw new Error("Depth Texture with cube render targets is not supported");if(e.bindFramebuffer(i.FRAMEBUFFER,b),!(g.depthTexture&&g.depthTexture.isDepthTexture))throw new Error("renderTarget.depthTexture must be an instance of THREE.DepthTexture");let X=n.get(g.depthTexture);X.__renderTarget=g,(!X.__webglTexture||g.depthTexture.image.width!==g.width||g.depthTexture.image.height!==g.height)&&(g.depthTexture.image.width=g.width,g.depthTexture.image.height=g.height,g.depthTexture.needsUpdate=!0),q(g.depthTexture,0);let J=X.__webglTexture,H=se(g);if(g.depthTexture.format===Li)gt(g)?o.framebufferTexture2DMultisampleEXT(i.FRAMEBUFFER,i.DEPTH_ATTACHMENT,i.TEXTURE_2D,J,0,H):i.framebufferTexture2D(i.FRAMEBUFFER,i.DEPTH_ATTACHMENT,i.TEXTURE_2D,J,0);else if(g.depthTexture.format===Xi)gt(g)?o.framebufferTexture2DMultisampleEXT(i.FRAMEBUFFER,i.DEPTH_STENCIL_ATTACHMENT,i.TEXTURE_2D,J,0,H):i.framebufferTexture2D(i.FRAMEBUFFER,i.DEPTH_STENCIL_ATTACHMENT,i.TEXTURE_2D,J,0);else throw new Error("Unknown depthTexture format")}function Gt(b){let g=n.get(b),F=b.isWebGLCubeRenderTarget===!0;if(g.__boundDepthTexture!==b.depthTexture){let X=b.depthTexture;if(g.__depthDisposeCallback&&g.__depthDisposeCallback(),X){let J=()=>{delete g.__boundDepthTexture,delete g.__depthDisposeCallback,X.removeEventListener("dispose",J)};X.addEventListener("dispose",J),g.__depthDisposeCallback=J}g.__boundDepthTexture=X}if(b.depthTexture&&!g.__autoAllocateDepthBuffer){if(F)throw new Error("target.depthTexture not supported in Cube render targets");let X=b.texture.mipmaps;X&&X.length>0?Mt(g.__webglFramebuffer[0],b):Mt(g.__webglFramebuffer,b)}else if(F){g.__webglDepthbuffer=[];for(let X=0;X<6;X++)if(e.bindFramebuffer(i.FRAMEBUFFER,g.__webglFramebuffer[X]),g.__webglDepthbuffer[X]===void 0)g.__webglDepthbuffer[X]=i.createRenderbuffer(),Pt(g.__webglDepthbuffer[X],b,!1);else{let J=b.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,H=g.__webglDepthbuffer[X];i.bindRenderbuffer(i.RENDERBUFFER,H),i.framebufferRenderbuffer(i.FRAMEBUFFER,J,i.RENDERBUFFER,H)}}else{let X=b.texture.mipmaps;if(X&&X.length>0?e.bindFramebuffer(i.FRAMEBUFFER,g.__webglFramebuffer[0]):e.bindFramebuffer(i.FRAMEBUFFER,g.__webglFramebuffer),g.__webglDepthbuffer===void 0)g.__webglDepthbuffer=i.createRenderbuffer(),Pt(g.__webglDepthbuffer,b,!1);else{let J=b.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,H=g.__webglDepthbuffer;i.bindRenderbuffer(i.RENDERBUFFER,H),i.framebufferRenderbuffer(i.FRAMEBUFFER,J,i.RENDERBUFFER,H)}}e.bindFramebuffer(i.FRAMEBUFFER,null)}function Se(b,g,F){let X=n.get(b);g!==void 0&&dt(X.__webglFramebuffer,b,b.texture,i.COLOR_ATTACHMENT0,i.TEXTURE_2D,0),F!==void 0&&Gt(b)}function T(b){let g=b.texture,F=n.get(b),X=n.get(g);b.addEventListener("dispose",P);let J=b.textures,H=b.isWebGLCubeRenderTarget===!0,vt=J.length>1;if(vt||(X.__webglTexture===void 0&&(X.__webglTexture=i.createTexture()),X.__version=g.version,a.memory.textures++),H){F.__webglFramebuffer=[];for(let nt=0;nt<6;nt++)if(g.mipmaps&&g.mipmaps.length>0){F.__webglFramebuffer[nt]=[];for(let _t=0;_t<g.mipmaps.length;_t++)F.__webglFramebuffer[nt][_t]=i.createFramebuffer()}else F.__webglFramebuffer[nt]=i.createFramebuffer()}else{if(g.mipmaps&&g.mipmaps.length>0){F.__webglFramebuffer=[];for(let nt=0;nt<g.mipmaps.length;nt++)F.__webglFramebuffer[nt]=i.createFramebuffer()}else F.__webglFramebuffer=i.createFramebuffer();if(vt)for(let nt=0,_t=J.length;nt<_t;nt++){let xt=n.get(J[nt]);xt.__webglTexture===void 0&&(xt.__webglTexture=i.createTexture(),a.memory.textures++)}if(b.samples>0&&gt(b)===!1){F.__webglMultisampledFramebuffer=i.createFramebuffer(),F.__webglColorRenderbuffer=[],e.bindFramebuffer(i.FRAMEBUFFER,F.__webglMultisampledFramebuffer);for(let nt=0;nt<J.length;nt++){let _t=J[nt];F.__webglColorRenderbuffer[nt]=i.createRenderbuffer(),i.bindRenderbuffer(i.RENDERBUFFER,F.__webglColorRenderbuffer[nt]);let xt=r.convert(_t.format,_t.colorSpace),Q=r.convert(_t.type),lt=E(_t.internalFormat,xt,Q,_t.colorSpace,b.isXRRenderTarget===!0),wt=se(b);i.renderbufferStorageMultisample(i.RENDERBUFFER,wt,lt,b.width,b.height),i.framebufferRenderbuffer(i.FRAMEBUFFER,i.COLOR_ATTACHMENT0+nt,i.RENDERBUFFER,F.__webglColorRenderbuffer[nt])}i.bindRenderbuffer(i.RENDERBUFFER,null),b.depthBuffer&&(F.__webglDepthRenderbuffer=i.createRenderbuffer(),Pt(F.__webglDepthRenderbuffer,b,!0)),e.bindFramebuffer(i.FRAMEBUFFER,null)}}if(H){e.bindTexture(i.TEXTURE_CUBE_MAP,X.__webglTexture),kt(i.TEXTURE_CUBE_MAP,g);for(let nt=0;nt<6;nt++)if(g.mipmaps&&g.mipmaps.length>0)for(let _t=0;_t<g.mipmaps.length;_t++)dt(F.__webglFramebuffer[nt][_t],b,g,i.COLOR_ATTACHMENT0,i.TEXTURE_CUBE_MAP_POSITIVE_X+nt,_t);else dt(F.__webglFramebuffer[nt],b,g,i.COLOR_ATTACHMENT0,i.TEXTURE_CUBE_MAP_POSITIVE_X+nt,0);m(g)&&h(i.TEXTURE_CUBE_MAP),e.unbindTexture()}else if(vt){for(let nt=0,_t=J.length;nt<_t;nt++){let xt=J[nt],Q=n.get(xt),lt=i.TEXTURE_2D;(b.isWebGL3DRenderTarget||b.isWebGLArrayRenderTarget)&&(lt=b.isWebGL3DRenderTarget?i.TEXTURE_3D:i.TEXTURE_2D_ARRAY),e.bindTexture(lt,Q.__webglTexture),kt(lt,xt),dt(F.__webglFramebuffer,b,xt,i.COLOR_ATTACHMENT0+nt,lt,0),m(xt)&&h(lt)}e.unbindTexture()}else{let nt=i.TEXTURE_2D;if((b.isWebGL3DRenderTarget||b.isWebGLArrayRenderTarget)&&(nt=b.isWebGL3DRenderTarget?i.TEXTURE_3D:i.TEXTURE_2D_ARRAY),e.bindTexture(nt,X.__webglTexture),kt(nt,g),g.mipmaps&&g.mipmaps.length>0)for(let _t=0;_t<g.mipmaps.length;_t++)dt(F.__webglFramebuffer[_t],b,g,i.COLOR_ATTACHMENT0,nt,_t);else dt(F.__webglFramebuffer,b,g,i.COLOR_ATTACHMENT0,nt,0);m(g)&&h(nt),e.unbindTexture()}b.depthBuffer&&Gt(b)}function ie(b){let g=b.textures;for(let F=0,X=g.length;F<X;F++){let J=g[F];if(m(J)){let H=w(b),vt=n.get(J).__webglTexture;e.bindTexture(H,vt),h(H),e.unbindTexture()}}}let Lt=[],At=[];function mt(b){if(b.samples>0){if(gt(b)===!1){let g=b.textures,F=b.width,X=b.height,J=i.COLOR_BUFFER_BIT,H=b.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,vt=n.get(b),nt=g.length>1;if(nt)for(let xt=0;xt<g.length;xt++)e.bindFramebuffer(i.FRAMEBUFFER,vt.__webglMultisampledFramebuffer),i.framebufferRenderbuffer(i.FRAMEBUFFER,i.COLOR_ATTACHMENT0+xt,i.RENDERBUFFER,null),e.bindFramebuffer(i.FRAMEBUFFER,vt.__webglFramebuffer),i.framebufferTexture2D(i.DRAW_FRAMEBUFFER,i.COLOR_ATTACHMENT0+xt,i.TEXTURE_2D,null,0);e.bindFramebuffer(i.READ_FRAMEBUFFER,vt.__webglMultisampledFramebuffer);let _t=b.texture.mipmaps;_t&&_t.length>0?e.bindFramebuffer(i.DRAW_FRAMEBUFFER,vt.__webglFramebuffer[0]):e.bindFramebuffer(i.DRAW_FRAMEBUFFER,vt.__webglFramebuffer);for(let xt=0;xt<g.length;xt++){if(b.resolveDepthBuffer&&(b.depthBuffer&&(J|=i.DEPTH_BUFFER_BIT),b.stencilBuffer&&b.resolveStencilBuffer&&(J|=i.STENCIL_BUFFER_BIT)),nt){i.framebufferRenderbuffer(i.READ_FRAMEBUFFER,i.COLOR_ATTACHMENT0,i.RENDERBUFFER,vt.__webglColorRenderbuffer[xt]);let Q=n.get(g[xt]).__webglTexture;i.framebufferTexture2D(i.DRAW_FRAMEBUFFER,i.COLOR_ATTACHMENT0,i.TEXTURE_2D,Q,0)}i.blitFramebuffer(0,0,F,X,0,0,F,X,J,i.NEAREST),l===!0&&(Lt.length=0,At.length=0,Lt.push(i.COLOR_ATTACHMENT0+xt),b.depthBuffer&&b.resolveDepthBuffer===!1&&(Lt.push(H),At.push(H),i.invalidateFramebuffer(i.DRAW_FRAMEBUFFER,At)),i.invalidateFramebuffer(i.READ_FRAMEBUFFER,Lt))}if(e.bindFramebuffer(i.READ_FRAMEBUFFER,null),e.bindFramebuffer(i.DRAW_FRAMEBUFFER,null),nt)for(let xt=0;xt<g.length;xt++){e.bindFramebuffer(i.FRAMEBUFFER,vt.__webglMultisampledFramebuffer),i.framebufferRenderbuffer(i.FRAMEBUFFER,i.COLOR_ATTACHMENT0+xt,i.RENDERBUFFER,vt.__webglColorRenderbuffer[xt]);let Q=n.get(g[xt]).__webglTexture;e.bindFramebuffer(i.FRAMEBUFFER,vt.__webglFramebuffer),i.framebufferTexture2D(i.DRAW_FRAMEBUFFER,i.COLOR_ATTACHMENT0+xt,i.TEXTURE_2D,Q,0)}e.bindFramebuffer(i.DRAW_FRAMEBUFFER,vt.__webglMultisampledFramebuffer)}else if(b.depthBuffer&&b.resolveDepthBuffer===!1&&l){let g=b.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT;i.invalidateFramebuffer(i.DRAW_FRAMEBUFFER,[g])}}}function se(b){return Math.min(s.maxSamples,b.samples)}function gt(b){let g=n.get(b);return b.samples>0&&t.has("WEBGL_multisampled_render_to_texture")===!0&&g.__useRenderToTexture!==!1}function Ot(b){let g=a.render.frame;u.get(b)!==g&&(u.set(b,g),b.update())}function ye(b,g){let F=b.colorSpace,X=b.format,J=b.type;return b.isCompressedTexture===!0||b.isVideoTexture===!0||F!==ii&&F!==Cn&&(Wt.getTransfer(F)===Zt?(X!==$e||J!==an)&&console.warn("THREE.WebGLTextures: sRGB encoded textures have to use RGBAFormat and UnsignedByteType."):console.error("THREE.WebGLTextures: Unsupported texture color space:",F)),g}function he(b){return typeof HTMLImageElement<"u"&&b instanceof HTMLImageElement?(c.width=b.naturalWidth||b.width,c.height=b.naturalHeight||b.height):typeof VideoFrame<"u"&&b instanceof VideoFrame?(c.width=b.displayWidth,c.height=b.displayHeight):(c.width=b.width,c.height=b.height),c}this.allocateTextureUnit=k,this.resetTextureUnits=O,this.setTexture2D=q,this.setTexture2DArray=W,this.setTexture3D=et,this.setTextureCube=V,this.rebindTextures=Se,this.setupRenderTarget=T,this.updateRenderTargetMipmap=ie,this.updateMultisampleRenderTarget=mt,this.setupDepthRenderbuffer=Gt,this.setupFrameBufferTexture=dt,this.useMultisampledRTT=gt}function km(i,t){function e(n,s=Cn){let r,a=Wt.getTransfer(s);if(n===an)return i.UNSIGNED_BYTE;if(n===Hr)return i.UNSIGNED_SHORT_4_4_4_4;if(n===Gr)return i.UNSIGNED_SHORT_5_5_5_1;if(n===So)return i.UNSIGNED_INT_5_9_9_9_REV;if(n===bo)return i.UNSIGNED_INT_10F_11F_11F_REV;if(n===vo)return i.BYTE;if(n===Mo)return i.SHORT;if(n===Hi)return i.UNSIGNED_SHORT;if(n===Vr)return i.INT;if(n===qn)return i.UNSIGNED_INT;if(n===gn)return i.FLOAT;if(n===Gi)return i.HALF_FLOAT;if(n===Eo)return i.ALPHA;if(n===To)return i.RGB;if(n===$e)return i.RGBA;if(n===Li)return i.DEPTH_COMPONENT;if(n===Xi)return i.DEPTH_STENCIL;if(n===wo)return i.RED;if(n===Wr)return i.RED_INTEGER;if(n===Ao)return i.RG;if(n===Xr)return i.RG_INTEGER;if(n===qr)return i.RGBA_INTEGER;if(n===Ds||n===Ls||n===Us||n===Ns)if(a===Zt)if(r=t.get("WEBGL_compressed_texture_s3tc_srgb"),r!==null){if(n===Ds)return r.COMPRESSED_SRGB_S3TC_DXT1_EXT;if(n===Ls)return r.COMPRESSED_SRGB_ALPHA_S3TC_DXT1_EXT;if(n===Us)return r.COMPRESSED_SRGB_ALPHA_S3TC_DXT3_EXT;if(n===Ns)return r.COMPRESSED_SRGB_ALPHA_S3TC_DXT5_EXT}else return null;else if(r=t.get("WEBGL_compressed_texture_s3tc"),r!==null){if(n===Ds)return r.COMPRESSED_RGB_S3TC_DXT1_EXT;if(n===Ls)return r.COMPRESSED_RGBA_S3TC_DXT1_EXT;if(n===Us)return r.COMPRESSED_RGBA_S3TC_DXT3_EXT;if(n===Ns)return r.COMPRESSED_RGBA_S3TC_DXT5_EXT}else return null;if(n===Yr||n===Zr||n===Jr||n===$r)if(r=t.get("WEBGL_compressed_texture_pvrtc"),r!==null){if(n===Yr)return r.COMPRESSED_RGB_PVRTC_4BPPV1_IMG;if(n===Zr)return r.COMPRESSED_RGB_PVRTC_2BPPV1_IMG;if(n===Jr)return r.COMPRESSED_RGBA_PVRTC_4BPPV1_IMG;if(n===$r)return r.COMPRESSED_RGBA_PVRTC_2BPPV1_IMG}else return null;if(n===Kr||n===jr||n===Qr)if(r=t.get("WEBGL_compressed_texture_etc"),r!==null){if(n===Kr||n===jr)return a===Zt?r.COMPRESSED_SRGB8_ETC2:r.COMPRESSED_RGB8_ETC2;if(n===Qr)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ETC2_EAC:r.COMPRESSED_RGBA8_ETC2_EAC}else return null;if(n===ta||n===ea||n===na||n===ia||n===sa||n===ra||n===aa||n===oa||n===la||n===ca||n===ha||n===ua||n===da||n===fa)if(r=t.get("WEBGL_compressed_texture_astc"),r!==null){if(n===ta)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_4x4_KHR:r.COMPRESSED_RGBA_ASTC_4x4_KHR;if(n===ea)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_5x4_KHR:r.COMPRESSED_RGBA_ASTC_5x4_KHR;if(n===na)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_5x5_KHR:r.COMPRESSED_RGBA_ASTC_5x5_KHR;if(n===ia)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_6x5_KHR:r.COMPRESSED_RGBA_ASTC_6x5_KHR;if(n===sa)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_6x6_KHR:r.COMPRESSED_RGBA_ASTC_6x6_KHR;if(n===ra)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_8x5_KHR:r.COMPRESSED_RGBA_ASTC_8x5_KHR;if(n===aa)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_8x6_KHR:r.COMPRESSED_RGBA_ASTC_8x6_KHR;if(n===oa)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_8x8_KHR:r.COMPRESSED_RGBA_ASTC_8x8_KHR;if(n===la)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x5_KHR:r.COMPRESSED_RGBA_ASTC_10x5_KHR;if(n===ca)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x6_KHR:r.COMPRESSED_RGBA_ASTC_10x6_KHR;if(n===ha)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x8_KHR:r.COMPRESSED_RGBA_ASTC_10x8_KHR;if(n===ua)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x10_KHR:r.COMPRESSED_RGBA_ASTC_10x10_KHR;if(n===da)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_12x10_KHR:r.COMPRESSED_RGBA_ASTC_12x10_KHR;if(n===fa)return a===Zt?r.COMPRESSED_SRGB8_ALPHA8_ASTC_12x12_KHR:r.COMPRESSED_RGBA_ASTC_12x12_KHR}else return null;if(n===pa||n===ma||n===ga)if(r=t.get("EXT_texture_compression_bptc"),r!==null){if(n===pa)return a===Zt?r.COMPRESSED_SRGB_ALPHA_BPTC_UNORM_EXT:r.COMPRESSED_RGBA_BPTC_UNORM_EXT;if(n===ma)return r.COMPRESSED_RGB_BPTC_SIGNED_FLOAT_EXT;if(n===ga)return r.COMPRESSED_RGB_BPTC_UNSIGNED_FLOAT_EXT}else return null;if(n===_a||n===xa||n===ya||n===va)if(r=t.get("EXT_texture_compression_rgtc"),r!==null){if(n===_a)return r.COMPRESSED_RED_RGTC1_EXT;if(n===xa)return r.COMPRESSED_SIGNED_RED_RGTC1_EXT;if(n===ya)return r.COMPRESSED_RED_GREEN_RGTC2_EXT;if(n===va)return r.COMPRESSED_SIGNED_RED_GREEN_RGTC2_EXT}else return null;return n===Wi?i.UNSIGNED_INT_24_8:i[n]!==void 0?i[n]:null}return{convert:e}}var Vm=`
void main() {

	gl_Position = vec4( position, 1.0 );

}`,Hm=`
uniform sampler2DArray depthColor;
uniform float depthWidth;
uniform float depthHeight;

void main() {

	vec2 coord = vec2( gl_FragCoord.x / depthWidth, gl_FragCoord.y / depthHeight );

	if ( coord.x >= 1.0 ) {

		gl_FragDepth = texture( depthColor, vec3( coord.x - 1.0, coord.y, 1 ) ).r;

	} else {

		gl_FragDepth = texture( depthColor, vec3( coord.x, coord.y, 0 ) ).r;

	}

}`,$o=class{constructor(){this.texture=null,this.mesh=null,this.depthNear=0,this.depthFar=0}init(t,e){if(this.texture===null){let n=new vs(t.texture);(t.depthNear!==e.depthNear||t.depthFar!==e.depthFar)&&(this.depthNear=t.depthNear,this.depthFar=t.depthFar),this.texture=n}}getMesh(t){if(this.texture!==null&&this.mesh===null){let e=t.cameras[0].viewport,n=new rn({vertexShader:Vm,fragmentShader:Hm,uniforms:{depthColor:{value:this.texture},depthWidth:{value:e.z},depthHeight:{value:e.w}}});this.mesh=new Me(new ai(20,20),n)}return this.mesh}reset(){this.texture=null,this.mesh=null}getDepthTexture(){return this.texture}},Ko=class extends un{constructor(t,e){super();let n=this,s=null,r=1,a=null,o="local-floor",l=1,c=null,u=null,d=null,f=null,p=null,_=null,v=typeof XRWebGLBinding<"u",m=new $o,h={},w=e.getContextAttributes(),E=null,S=null,C=[],A=[],P=new Rt,U=null,M=new Ue;M.viewport=new oe;let y=new Ue;y.viewport=new oe;let I=[M,y],O=new Cr,k=null,G=null;this.cameraAutoUpdate=!0,this.enabled=!1,this.isPresenting=!1,this.getController=function(Y){let $=C[Y];return $===void 0&&($=new zi,C[Y]=$),$.getTargetRaySpace()},this.getControllerGrip=function(Y){let $=C[Y];return $===void 0&&($=new zi,C[Y]=$),$.getGripSpace()},this.getHand=function(Y){let $=C[Y];return $===void 0&&($=new zi,C[Y]=$),$.getHandSpace()};function q(Y){let $=A.indexOf(Y.inputSource);if($===-1)return;let dt=C[$];dt!==void 0&&(dt.update(Y.inputSource,Y.frame,c||a),dt.dispatchEvent({type:Y.type,data:Y.inputSource}))}function W(){s.removeEventListener("select",q),s.removeEventListener("selectstart",q),s.removeEventListener("selectend",q),s.removeEventListener("squeeze",q),s.removeEventListener("squeezestart",q),s.removeEventListener("squeezeend",q),s.removeEventListener("end",W),s.removeEventListener("inputsourceschange",et);for(let Y=0;Y<C.length;Y++){let $=A[Y];$!==null&&(A[Y]=null,C[Y].disconnect($))}k=null,G=null,m.reset();for(let Y in h)delete h[Y];t.setRenderTarget(E),p=null,f=null,d=null,s=null,S=null,qt.stop(),n.isPresenting=!1,t.setPixelRatio(U),t.setSize(P.width,P.height,!1),n.dispatchEvent({type:"sessionend"})}this.setFramebufferScaleFactor=function(Y){r=Y,n.isPresenting===!0&&console.warn("THREE.WebXRManager: Cannot change framebuffer scale while presenting.")},this.setReferenceSpaceType=function(Y){o=Y,n.isPresenting===!0&&console.warn("THREE.WebXRManager: Cannot change reference space type while presenting.")},this.getReferenceSpace=function(){return c||a},this.setReferenceSpace=function(Y){c=Y},this.getBaseLayer=function(){return f!==null?f:p},this.getBinding=function(){return d===null&&v&&(d=new XRWebGLBinding(s,e)),d},this.getFrame=function(){return _},this.getSession=function(){return s},this.setSession=async function(Y){if(s=Y,s!==null){if(E=t.getRenderTarget(),s.addEventListener("select",q),s.addEventListener("selectstart",q),s.addEventListener("selectend",q),s.addEventListener("squeeze",q),s.addEventListener("squeezestart",q),s.addEventListener("squeezeend",q),s.addEventListener("end",W),s.addEventListener("inputsourceschange",et),w.xrCompatible!==!0&&await e.makeXRCompatible(),U=t.getPixelRatio(),t.getSize(P),v&&"createProjectionLayer"in XRWebGLBinding.prototype){let dt=null,Pt=null,Mt=null;w.depth&&(Mt=w.stencil?e.DEPTH24_STENCIL8:e.DEPTH_COMPONENT24,dt=w.stencil?Xi:Li,Pt=w.stencil?Wi:qn);let Gt={colorFormat:e.RGBA8,depthFormat:Mt,scaleFactor:r};d=this.getBinding(),f=d.createProjectionLayer(Gt),s.updateRenderState({layers:[f]}),t.setPixelRatio(1),t.setSize(f.textureWidth,f.textureHeight,!1),S=new dn(f.textureWidth,f.textureHeight,{format:$e,type:an,depthTexture:new ys(f.textureWidth,f.textureHeight,Pt,void 0,void 0,void 0,void 0,void 0,void 0,dt),stencilBuffer:w.stencil,colorSpace:t.outputColorSpace,samples:w.antialias?4:0,resolveDepthBuffer:f.ignoreDepthValues===!1,resolveStencilBuffer:f.ignoreDepthValues===!1})}else{let dt={antialias:w.antialias,alpha:!0,depth:w.depth,stencil:w.stencil,framebufferScaleFactor:r};p=new XRWebGLLayer(s,e,dt),s.updateRenderState({baseLayer:p}),t.setPixelRatio(1),t.setSize(p.framebufferWidth,p.framebufferHeight,!1),S=new dn(p.framebufferWidth,p.framebufferHeight,{format:$e,type:an,colorSpace:t.outputColorSpace,stencilBuffer:w.stencil,resolveDepthBuffer:p.ignoreDepthValues===!1,resolveStencilBuffer:p.ignoreDepthValues===!1})}S.isXRRenderTarget=!0,this.setFoveation(l),c=null,a=await s.requestReferenceSpace(o),qt.setContext(s),qt.start(),n.isPresenting=!0,n.dispatchEvent({type:"sessionstart"})}},this.getEnvironmentBlendMode=function(){if(s!==null)return s.environmentBlendMode},this.getDepthTexture=function(){return m.getDepthTexture()};function et(Y){for(let $=0;$<Y.removed.length;$++){let dt=Y.removed[$],Pt=A.indexOf(dt);Pt>=0&&(A[Pt]=null,C[Pt].disconnect(dt))}for(let $=0;$<Y.added.length;$++){let dt=Y.added[$],Pt=A.indexOf(dt);if(Pt===-1){for(let Gt=0;Gt<C.length;Gt++)if(Gt>=A.length){A.push(dt),Pt=Gt;break}else if(A[Gt]===null){A[Gt]=dt,Pt=Gt;break}if(Pt===-1)break}let Mt=C[Pt];Mt&&Mt.connect(dt)}}let V=new N,rt=new N;function ct(Y,$,dt){V.setFromMatrixPosition($.matrixWorld),rt.setFromMatrixPosition(dt.matrixWorld);let Pt=V.distanceTo(rt),Mt=$.projectionMatrix.elements,Gt=dt.projectionMatrix.elements,Se=Mt[14]/(Mt[10]-1),T=Mt[14]/(Mt[10]+1),ie=(Mt[9]+1)/Mt[5],Lt=(Mt[9]-1)/Mt[5],At=(Mt[8]-1)/Mt[0],mt=(Gt[8]+1)/Gt[0],se=Se*At,gt=Se*mt,Ot=Pt/(-At+mt),ye=Ot*-At;if($.matrixWorld.decompose(Y.position,Y.quaternion,Y.scale),Y.translateX(ye),Y.translateZ(Ot),Y.matrixWorld.compose(Y.position,Y.quaternion,Y.scale),Y.matrixWorldInverse.copy(Y.matrixWorld).invert(),Mt[10]===-1)Y.projectionMatrix.copy($.projectionMatrix),Y.projectionMatrixInverse.copy($.projectionMatrixInverse);else{let he=Se+Ot,b=T+Ot,g=se-ye,F=gt+(Pt-ye),X=ie*T/b*he,J=Lt*T/b*he;Y.projectionMatrix.makePerspective(g,F,X,J,he,b),Y.projectionMatrixInverse.copy(Y.projectionMatrix).invert()}}function St(Y,$){$===null?Y.matrixWorld.copy(Y.matrix):Y.matrixWorld.multiplyMatrices($.matrixWorld,Y.matrix),Y.matrixWorldInverse.copy(Y.matrixWorld).invert()}this.updateCamera=function(Y){if(s===null)return;let $=Y.near,dt=Y.far;m.texture!==null&&(m.depthNear>0&&($=m.depthNear),m.depthFar>0&&(dt=m.depthFar)),O.near=y.near=M.near=$,O.far=y.far=M.far=dt,(k!==O.near||G!==O.far)&&(s.updateRenderState({depthNear:O.near,depthFar:O.far}),k=O.near,G=O.far),O.layers.mask=Y.layers.mask|6,M.layers.mask=O.layers.mask&3,y.layers.mask=O.layers.mask&5;let Pt=Y.parent,Mt=O.cameras;St(O,Pt);for(let Gt=0;Gt<Mt.length;Gt++)St(Mt[Gt],Pt);Mt.length===2?ct(O,M,y):O.projectionMatrix.copy(M.projectionMatrix),kt(Y,O,Pt)};function kt(Y,$,dt){dt===null?Y.matrix.copy($.matrixWorld):(Y.matrix.copy(dt.matrixWorld),Y.matrix.invert(),Y.matrix.multiply($.matrixWorld)),Y.matrix.decompose(Y.position,Y.quaternion,Y.scale),Y.updateMatrixWorld(!0),Y.projectionMatrix.copy($.projectionMatrix),Y.projectionMatrixInverse.copy($.projectionMatrixInverse),Y.isPerspectiveCamera&&(Y.fov=Ui*2*Math.atan(1/Y.projectionMatrix.elements[5]),Y.zoom=1)}this.getCamera=function(){return O},this.getFoveation=function(){if(!(f===null&&p===null))return l},this.setFoveation=function(Y){l=Y,f!==null&&(f.fixedFoveation=Y),p!==null&&p.fixedFoveation!==void 0&&(p.fixedFoveation=Y)},this.hasDepthSensing=function(){return m.texture!==null},this.getDepthSensingMesh=function(){return m.getMesh(O)},this.getCameraTexture=function(Y){return h[Y]};let jt=null;function ne(Y,$){if(u=$.getViewerPose(c||a),_=$,u!==null){let dt=u.views;p!==null&&(t.setRenderTargetFramebuffer(S,p.framebuffer),t.setRenderTarget(S));let Pt=!1;dt.length!==O.cameras.length&&(O.cameras.length=0,Pt=!0);for(let T=0;T<dt.length;T++){let ie=dt[T],Lt=null;if(p!==null)Lt=p.getViewport(ie);else{let mt=d.getViewSubImage(f,ie);Lt=mt.viewport,T===0&&(t.setRenderTargetTextures(S,mt.colorTexture,mt.depthStencilTexture),t.setRenderTarget(S))}let At=I[T];At===void 0&&(At=new Ue,At.layers.enable(T),At.viewport=new oe,I[T]=At),At.matrix.fromArray(ie.transform.matrix),At.matrix.decompose(At.position,At.quaternion,At.scale),At.projectionMatrix.fromArray(ie.projectionMatrix),At.projectionMatrixInverse.copy(At.projectionMatrix).invert(),At.viewport.set(Lt.x,Lt.y,Lt.width,Lt.height),T===0&&(O.matrix.copy(At.matrix),O.matrix.decompose(O.position,O.quaternion,O.scale)),Pt===!0&&O.cameras.push(At)}let Mt=s.enabledFeatures;if(Mt&&Mt.includes("depth-sensing")&&s.depthUsage=="gpu-optimized"&&v){d=n.getBinding();let T=d.getDepthInformation(dt[0]);T&&T.isValid&&T.texture&&m.init(T,s.renderState)}if(Mt&&Mt.includes("camera-access")&&v){t.state.unbindTexture(),d=n.getBinding();for(let T=0;T<dt.length;T++){let ie=dt[T].camera;if(ie){let Lt=h[ie];Lt||(Lt=new vs,h[ie]=Lt);let At=d.getCameraImage(ie);Lt.sourceTexture=At}}}}for(let dt=0;dt<C.length;dt++){let Pt=A[dt],Mt=C[dt];Pt!==null&&Mt!==void 0&&Mt.update(Pt,$,c||a)}jt&&jt(Y,$),$.detectedPlanes&&n.dispatchEvent({type:"planesdetected",data:$}),_=null}let qt=new Zc;qt.setAnimationLoop(ne),this.setAnimationLoop=function(Y){jt=Y},this.dispose=function(){}}},fi=new sn,Gm=new ce;function Wm(i,t){function e(m,h){m.matrixAutoUpdate===!0&&m.updateMatrix(),h.value.copy(m.matrix)}function n(m,h){h.color.getRGB(m.fogColor.value,Uo(i)),h.isFog?(m.fogNear.value=h.near,m.fogFar.value=h.far):h.isFogExp2&&(m.fogDensity.value=h.density)}function s(m,h,w,E,S){h.isMeshBasicMaterial||h.isMeshLambertMaterial?r(m,h):h.isMeshToonMaterial?(r(m,h),d(m,h)):h.isMeshPhongMaterial?(r(m,h),u(m,h)):h.isMeshStandardMaterial?(r(m,h),f(m,h),h.isMeshPhysicalMaterial&&p(m,h,S)):h.isMeshMatcapMaterial?(r(m,h),_(m,h)):h.isMeshDepthMaterial?r(m,h):h.isMeshDistanceMaterial?(r(m,h),v(m,h)):h.isMeshNormalMaterial?r(m,h):h.isLineBasicMaterial?(a(m,h),h.isLineDashedMaterial&&o(m,h)):h.isPointsMaterial?l(m,h,w,E):h.isSpriteMaterial?c(m,h):h.isShadowMaterial?(m.color.value.copy(h.color),m.opacity.value=h.opacity):h.isShaderMaterial&&(h.uniformsNeedUpdate=!1)}function r(m,h){m.opacity.value=h.opacity,h.color&&m.diffuse.value.copy(h.color),h.emissive&&m.emissive.value.copy(h.emissive).multiplyScalar(h.emissiveIntensity),h.map&&(m.map.value=h.map,e(h.map,m.mapTransform)),h.alphaMap&&(m.alphaMap.value=h.alphaMap,e(h.alphaMap,m.alphaMapTransform)),h.bumpMap&&(m.bumpMap.value=h.bumpMap,e(h.bumpMap,m.bumpMapTransform),m.bumpScale.value=h.bumpScale,h.side===De&&(m.bumpScale.value*=-1)),h.normalMap&&(m.normalMap.value=h.normalMap,e(h.normalMap,m.normalMapTransform),m.normalScale.value.copy(h.normalScale),h.side===De&&m.normalScale.value.negate()),h.displacementMap&&(m.displacementMap.value=h.displacementMap,e(h.displacementMap,m.displacementMapTransform),m.displacementScale.value=h.displacementScale,m.displacementBias.value=h.displacementBias),h.emissiveMap&&(m.emissiveMap.value=h.emissiveMap,e(h.emissiveMap,m.emissiveMapTransform)),h.specularMap&&(m.specularMap.value=h.specularMap,e(h.specularMap,m.specularMapTransform)),h.alphaTest>0&&(m.alphaTest.value=h.alphaTest);let w=t.get(h),E=w.envMap,S=w.envMapRotation;E&&(m.envMap.value=E,fi.copy(S),fi.x*=-1,fi.y*=-1,fi.z*=-1,E.isCubeTexture&&E.isRenderTargetTexture===!1&&(fi.y*=-1,fi.z*=-1),m.envMapRotation.value.setFromMatrix4(Gm.makeRotationFromEuler(fi)),m.flipEnvMap.value=E.isCubeTexture&&E.isRenderTargetTexture===!1?-1:1,m.reflectivity.value=h.reflectivity,m.ior.value=h.ior,m.refractionRatio.value=h.refractionRatio),h.lightMap&&(m.lightMap.value=h.lightMap,m.lightMapIntensity.value=h.lightMapIntensity,e(h.lightMap,m.lightMapTransform)),h.aoMap&&(m.aoMap.value=h.aoMap,m.aoMapIntensity.value=h.aoMapIntensity,e(h.aoMap,m.aoMapTransform))}function a(m,h){m.diffuse.value.copy(h.color),m.opacity.value=h.opacity,h.map&&(m.map.value=h.map,e(h.map,m.mapTransform))}function o(m,h){m.dashSize.value=h.dashSize,m.totalSize.value=h.dashSize+h.gapSize,m.scale.value=h.scale}function l(m,h,w,E){m.diffuse.value.copy(h.color),m.opacity.value=h.opacity,m.size.value=h.size*w,m.scale.value=E*.5,h.map&&(m.map.value=h.map,e(h.map,m.uvTransform)),h.alphaMap&&(m.alphaMap.value=h.alphaMap,e(h.alphaMap,m.alphaMapTransform)),h.alphaTest>0&&(m.alphaTest.value=h.alphaTest)}function c(m,h){m.diffuse.value.copy(h.color),m.opacity.value=h.opacity,m.rotation.value=h.rotation,h.map&&(m.map.value=h.map,e(h.map,m.mapTransform)),h.alphaMap&&(m.alphaMap.value=h.alphaMap,e(h.alphaMap,m.alphaMapTransform)),h.alphaTest>0&&(m.alphaTest.value=h.alphaTest)}function u(m,h){m.specular.value.copy(h.specular),m.shininess.value=Math.max(h.shininess,1e-4)}function d(m,h){h.gradientMap&&(m.gradientMap.value=h.gradientMap)}function f(m,h){m.metalness.value=h.metalness,h.metalnessMap&&(m.metalnessMap.value=h.metalnessMap,e(h.metalnessMap,m.metalnessMapTransform)),m.roughness.value=h.roughness,h.roughnessMap&&(m.roughnessMap.value=h.roughnessMap,e(h.roughnessMap,m.roughnessMapTransform)),h.envMap&&(m.envMapIntensity.value=h.envMapIntensity)}function p(m,h,w){m.ior.value=h.ior,h.sheen>0&&(m.sheenColor.value.copy(h.sheenColor).multiplyScalar(h.sheen),m.sheenRoughness.value=h.sheenRoughness,h.sheenColorMap&&(m.sheenColorMap.value=h.sheenColorMap,e(h.sheenColorMap,m.sheenColorMapTransform)),h.sheenRoughnessMap&&(m.sheenRoughnessMap.value=h.sheenRoughnessMap,e(h.sheenRoughnessMap,m.sheenRoughnessMapTransform))),h.clearcoat>0&&(m.clearcoat.value=h.clearcoat,m.clearcoatRoughness.value=h.clearcoatRoughness,h.clearcoatMap&&(m.clearcoatMap.value=h.clearcoatMap,e(h.clearcoatMap,m.clearcoatMapTransform)),h.clearcoatRoughnessMap&&(m.clearcoatRoughnessMap.value=h.clearcoatRoughnessMap,e(h.clearcoatRoughnessMap,m.clearcoatRoughnessMapTransform)),h.clearcoatNormalMap&&(m.clearcoatNormalMap.value=h.clearcoatNormalMap,e(h.clearcoatNormalMap,m.clearcoatNormalMapTransform),m.clearcoatNormalScale.value.copy(h.clearcoatNormalScale),h.side===De&&m.clearcoatNormalScale.value.negate())),h.dispersion>0&&(m.dispersion.value=h.dispersion),h.iridescence>0&&(m.iridescence.value=h.iridescence,m.iridescenceIOR.value=h.iridescenceIOR,m.iridescenceThicknessMinimum.value=h.iridescenceThicknessRange[0],m.iridescenceThicknessMaximum.value=h.iridescenceThicknessRange[1],h.iridescenceMap&&(m.iridescenceMap.value=h.iridescenceMap,e(h.iridescenceMap,m.iridescenceMapTransform)),h.iridescenceThicknessMap&&(m.iridescenceThicknessMap.value=h.iridescenceThicknessMap,e(h.iridescenceThicknessMap,m.iridescenceThicknessMapTransform))),h.transmission>0&&(m.transmission.value=h.transmission,m.transmissionSamplerMap.value=w.texture,m.transmissionSamplerSize.value.set(w.width,w.height),h.transmissionMap&&(m.transmissionMap.value=h.transmissionMap,e(h.transmissionMap,m.transmissionMapTransform)),m.thickness.value=h.thickness,h.thicknessMap&&(m.thicknessMap.value=h.thicknessMap,e(h.thicknessMap,m.thicknessMapTransform)),m.attenuationDistance.value=h.attenuationDistance,m.attenuationColor.value.copy(h.attenuationColor)),h.anisotropy>0&&(m.anisotropyVector.value.set(h.anisotropy*Math.cos(h.anisotropyRotation),h.anisotropy*Math.sin(h.anisotropyRotation)),h.anisotropyMap&&(m.anisotropyMap.value=h.anisotropyMap,e(h.anisotropyMap,m.anisotropyMapTransform))),m.specularIntensity.value=h.specularIntensity,m.specularColor.value.copy(h.specularColor),h.specularColorMap&&(m.specularColorMap.value=h.specularColorMap,e(h.specularColorMap,m.specularColorMapTransform)),h.specularIntensityMap&&(m.specularIntensityMap.value=h.specularIntensityMap,e(h.specularIntensityMap,m.specularIntensityMapTransform))}function _(m,h){h.matcap&&(m.matcap.value=h.matcap)}function v(m,h){let w=t.get(h).light;m.referencePosition.value.setFromMatrixPosition(w.matrixWorld),m.nearDistance.value=w.shadow.camera.near,m.farDistance.value=w.shadow.camera.far}return{refreshFogUniforms:n,refreshMaterialUniforms:s}}function Xm(i,t,e,n){let s={},r={},a=[],o=i.getParameter(i.MAX_UNIFORM_BUFFER_BINDINGS);function l(w,E){let S=E.program;n.uniformBlockBinding(w,S)}function c(w,E){let S=s[w.id];S===void 0&&(_(w),S=u(w),s[w.id]=S,w.addEventListener("dispose",m));let C=E.program;n.updateUBOMapping(w,C);let A=t.render.frame;r[w.id]!==A&&(f(w),r[w.id]=A)}function u(w){let E=d();w.__bindingPointIndex=E;let S=i.createBuffer(),C=w.__size,A=w.usage;return i.bindBuffer(i.UNIFORM_BUFFER,S),i.bufferData(i.UNIFORM_BUFFER,C,A),i.bindBuffer(i.UNIFORM_BUFFER,null),i.bindBufferBase(i.UNIFORM_BUFFER,E,S),S}function d(){for(let w=0;w<o;w++)if(a.indexOf(w)===-1)return a.push(w),w;return console.error("THREE.WebGLRenderer: Maximum number of simultaneously usable uniforms groups reached."),0}function f(w){let E=s[w.id],S=w.uniforms,C=w.__cache;i.bindBuffer(i.UNIFORM_BUFFER,E);for(let A=0,P=S.length;A<P;A++){let U=Array.isArray(S[A])?S[A]:[S[A]];for(let M=0,y=U.length;M<y;M++){let I=U[M];if(p(I,A,M,C)===!0){let O=I.__offset,k=Array.isArray(I.value)?I.value:[I.value],G=0;for(let q=0;q<k.length;q++){let W=k[q],et=v(W);typeof W=="number"||typeof W=="boolean"?(I.__data[0]=W,i.bufferSubData(i.UNIFORM_BUFFER,O+G,I.__data)):W.isMatrix3?(I.__data[0]=W.elements[0],I.__data[1]=W.elements[1],I.__data[2]=W.elements[2],I.__data[3]=0,I.__data[4]=W.elements[3],I.__data[5]=W.elements[4],I.__data[6]=W.elements[5],I.__data[7]=0,I.__data[8]=W.elements[6],I.__data[9]=W.elements[7],I.__data[10]=W.elements[8],I.__data[11]=0):(W.toArray(I.__data,G),G+=et.storage/Float32Array.BYTES_PER_ELEMENT)}i.bufferSubData(i.UNIFORM_BUFFER,O,I.__data)}}}i.bindBuffer(i.UNIFORM_BUFFER,null)}function p(w,E,S,C){let A=w.value,P=E+"_"+S;if(C[P]===void 0)return typeof A=="number"||typeof A=="boolean"?C[P]=A:C[P]=A.clone(),!0;{let U=C[P];if(typeof A=="number"||typeof A=="boolean"){if(U!==A)return C[P]=A,!0}else if(U.equals(A)===!1)return U.copy(A),!0}return!1}function _(w){let E=w.uniforms,S=0,C=16;for(let P=0,U=E.length;P<U;P++){let M=Array.isArray(E[P])?E[P]:[E[P]];for(let y=0,I=M.length;y<I;y++){let O=M[y],k=Array.isArray(O.value)?O.value:[O.value];for(let G=0,q=k.length;G<q;G++){let W=k[G],et=v(W),V=S%C,rt=V%et.boundary,ct=V+rt;S+=rt,ct!==0&&C-ct<et.storage&&(S+=C-ct),O.__data=new Float32Array(et.storage/Float32Array.BYTES_PER_ELEMENT),O.__offset=S,S+=et.storage}}}let A=S%C;return A>0&&(S+=C-A),w.__size=S,w.__cache={},this}function v(w){let E={boundary:0,storage:0};return typeof w=="number"||typeof w=="boolean"?(E.boundary=4,E.storage=4):w.isVector2?(E.boundary=8,E.storage=8):w.isVector3||w.isColor?(E.boundary=16,E.storage=12):w.isVector4?(E.boundary=16,E.storage=16):w.isMatrix3?(E.boundary=48,E.storage=48):w.isMatrix4?(E.boundary=64,E.storage=64):w.isTexture?console.warn("THREE.WebGLRenderer: Texture samplers can not be part of an uniforms group."):console.warn("THREE.WebGLRenderer: Unsupported uniform value type.",w),E}function m(w){let E=w.target;E.removeEventListener("dispose",m);let S=a.indexOf(E.__bindingPointIndex);a.splice(S,1),i.deleteBuffer(s[E.id]),delete s[E.id],delete r[E.id]}function h(){for(let w in s)i.deleteBuffer(s[w]);a=[],s={},r={}}return{bind:l,update:c,dispose:h}}var Ta=class{constructor(t={}){let{canvas:e=vc(),context:n=null,depth:s=!0,stencil:r=!1,alpha:a=!1,antialias:o=!1,premultipliedAlpha:l=!0,preserveDrawingBuffer:c=!1,powerPreference:u="default",failIfMajorPerformanceCaveat:d=!1,reversedDepthBuffer:f=!1}=t;this.isWebGLRenderer=!0;let p;if(n!==null){if(typeof WebGLRenderingContext<"u"&&n instanceof WebGLRenderingContext)throw new Error("THREE.WebGLRenderer: WebGL 1 is not supported since r163.");p=n.getContextAttributes().alpha}else p=a;let _=new Uint32Array(4),v=new Int32Array(4),m=null,h=null,w=[],E=[];this.domElement=e,this.debug={checkShaderErrors:!0,onShaderError:null},this.autoClear=!0,this.autoClearColor=!0,this.autoClearDepth=!0,this.autoClearStencil=!0,this.sortObjects=!0,this.clippingPlanes=[],this.localClippingEnabled=!1,this.toneMapping=An,this.toneMappingExposure=1,this.transmissionResolutionScale=1;let S=this,C=!1;this._outputColorSpace=Te;let A=0,P=0,U=null,M=-1,y=null,I=new oe,O=new oe,k=null,G=new Ht(0),q=0,W=e.width,et=e.height,V=1,rt=null,ct=null,St=new oe(0,0,W,et),kt=new oe(0,0,W,et),jt=!1,ne=new ki,qt=!1,Y=!1,$=new ce,dt=new N,Pt=new oe,Mt={background:null,fog:null,environment:null,overrideMaterial:null,isScene:!0},Gt=!1;function Se(){return U===null?V:1}let T=n;function ie(x,D){return e.getContext(x,D)}try{let x={alpha:!0,depth:s,stencil:r,antialias:o,premultipliedAlpha:l,preserveDrawingBuffer:c,powerPreference:u,failIfMajorPerformanceCaveat:d};if("setAttribute"in e&&e.setAttribute("data-engine",`three.js r${"180"}`),e.addEventListener("webglcontextlost",it,!1),e.addEventListener("webglcontextrestored",ut,!1),e.addEventListener("webglcontextcreationerror",K,!1),T===null){let D="webgl2";if(T=ie(D,x),T===null)throw ie(D)?new Error("Error creating WebGL context with your selected attributes."):new Error("Error creating WebGL context.")}}catch(x){throw console.error("THREE.WebGLRenderer: "+x.message),x}let Lt,At,mt,se,gt,Ot,ye,he,b,g,F,X,J,H,vt,nt,_t,xt,Q,lt,wt,yt,at,Nt;function R(){Lt=new cp(T),Lt.init(),yt=new km(T,Lt),At=new np(T,Lt,t,yt),mt=new Bm(T,Lt),At.reversedDepthBuffer&&f&&mt.buffers.depth.setReversed(!0),se=new dp(T),gt=new Tm,Ot=new zm(T,Lt,mt,gt,At,yt,se),ye=new sp(S),he=new lp(S),b=new _u(T),at=new tp(T,b),g=new hp(T,b,se,at),F=new pp(T,g,b,se),Q=new fp(T,At,Ot),nt=new ip(gt),X=new Em(S,ye,he,Lt,At,at,nt),J=new Wm(S,gt),H=new Am,vt=new Lm(Lt),xt=new Qf(S,ye,he,mt,F,p,l),_t=new Fm(S,F,At),Nt=new Xm(T,se,At,mt),lt=new ep(T,Lt,se),wt=new up(T,Lt,se),se.programs=X.programs,S.capabilities=At,S.extensions=Lt,S.properties=gt,S.renderLists=H,S.shadowMap=_t,S.state=mt,S.info=se}R();let tt=new Ko(S,T);this.xr=tt,this.getContext=function(){return T},this.getContextAttributes=function(){return T.getContextAttributes()},this.forceContextLoss=function(){let x=Lt.get("WEBGL_lose_context");x&&x.loseContext()},this.forceContextRestore=function(){let x=Lt.get("WEBGL_lose_context");x&&x.restoreContext()},this.getPixelRatio=function(){return V},this.setPixelRatio=function(x){x!==void 0&&(V=x,this.setSize(W,et,!1))},this.getSize=function(x){return x.set(W,et)},this.setSize=function(x,D,B=!0){if(tt.isPresenting){console.warn("THREE.WebGLRenderer: Can't change size while VR device is presenting.");return}W=x,et=D,e.width=Math.floor(x*V),e.height=Math.floor(D*V),B===!0&&(e.style.width=x+"px",e.style.height=D+"px"),this.setViewport(0,0,x,D)},this.getDrawingBufferSize=function(x){return x.set(W*V,et*V).floor()},this.setDrawingBufferSize=function(x,D,B){W=x,et=D,V=B,e.width=Math.floor(x*B),e.height=Math.floor(D*B),this.setViewport(0,0,x,D)},this.getCurrentViewport=function(x){return x.copy(I)},this.getViewport=function(x){return x.copy(St)},this.setViewport=function(x,D,B,z){x.isVector4?St.set(x.x,x.y,x.z,x.w):St.set(x,D,B,z),mt.viewport(I.copy(St).multiplyScalar(V).round())},this.getScissor=function(x){return x.copy(kt)},this.setScissor=function(x,D,B,z){x.isVector4?kt.set(x.x,x.y,x.z,x.w):kt.set(x,D,B,z),mt.scissor(O.copy(kt).multiplyScalar(V).round())},this.getScissorTest=function(){return jt},this.setScissorTest=function(x){mt.setScissorTest(jt=x)},this.setOpaqueSort=function(x){rt=x},this.setTransparentSort=function(x){ct=x},this.getClearColor=function(x){return x.copy(xt.getClearColor())},this.setClearColor=function(){xt.setClearColor(...arguments)},this.getClearAlpha=function(){return xt.getClearAlpha()},this.setClearAlpha=function(){xt.setClearAlpha(...arguments)},this.clear=function(x=!0,D=!0,B=!0){let z=0;if(x){let L=!1;if(U!==null){let j=U.texture.format;L=j===qr||j===Xr||j===Wr}if(L){let j=U.texture.type,ot=j===an||j===qn||j===Hi||j===Wi||j===Hr||j===Gr,ft=xt.getClearColor(),ht=xt.getClearAlpha(),Tt=ft.r,Ct=ft.g,bt=ft.b;ot?(_[0]=Tt,_[1]=Ct,_[2]=bt,_[3]=ht,T.clearBufferuiv(T.COLOR,0,_)):(v[0]=Tt,v[1]=Ct,v[2]=bt,v[3]=ht,T.clearBufferiv(T.COLOR,0,v))}else z|=T.COLOR_BUFFER_BIT}D&&(z|=T.DEPTH_BUFFER_BIT),B&&(z|=T.STENCIL_BUFFER_BIT,this.state.buffers.stencil.setMask(4294967295)),T.clear(z)},this.clearColor=function(){this.clear(!0,!1,!1)},this.clearDepth=function(){this.clear(!1,!0,!1)},this.clearStencil=function(){this.clear(!1,!1,!0)},this.dispose=function(){e.removeEventListener("webglcontextlost",it,!1),e.removeEventListener("webglcontextrestored",ut,!1),e.removeEventListener("webglcontextcreationerror",K,!1),xt.dispose(),H.dispose(),vt.dispose(),gt.dispose(),ye.dispose(),he.dispose(),F.dispose(),at.dispose(),Nt.dispose(),X.dispose(),tt.dispose(),tt.removeEventListener("sessionstart",hn),tt.removeEventListener("sessionend",ol),Zn.stop()};function it(x){x.preventDefault(),console.log("THREE.WebGLRenderer: Context Lost."),C=!0}function ut(){console.log("THREE.WebGLRenderer: Context Restored."),C=!1;let x=se.autoReset,D=_t.enabled,B=_t.autoUpdate,z=_t.needsUpdate,L=_t.type;R(),se.autoReset=x,_t.enabled=D,_t.autoUpdate=B,_t.needsUpdate=z,_t.type=L}function K(x){console.error("THREE.WebGLRenderer: A WebGL context could not be created. Reason: ",x.statusMessage)}function Z(x){let D=x.target;D.removeEventListener("dispose",Z),pt(D)}function pt(x){Dt(x),gt.remove(x)}function Dt(x){let D=gt.get(x).programs;D!==void 0&&(D.forEach(function(B){X.releaseProgram(B)}),x.isShaderMaterial&&X.releaseShaderCache(x))}this.renderBufferDirect=function(x,D,B,z,L,j){D===null&&(D=Mt);let ot=L.isMesh&&L.matrixWorld.determinant()<0,ft=_h(x,D,B,z,L);mt.setMaterial(z,ot);let ht=B.index,Tt=1;if(z.wireframe===!0){if(ht=g.getWireframeAttribute(B),ht===void 0)return;Tt=2}let Ct=B.drawRange,bt=B.attributes.position,Vt=Ct.start*Tt,Jt=(Ct.start+Ct.count)*Tt;j!==null&&(Vt=Math.max(Vt,j.start*Tt),Jt=Math.min(Jt,(j.start+j.count)*Tt)),ht!==null?(Vt=Math.max(Vt,0),Jt=Math.min(Jt,ht.count)):bt!=null&&(Vt=Math.max(Vt,0),Jt=Math.min(Jt,bt.count));let le=Jt-Vt;if(le<0||le===1/0)return;at.setup(L,z,ft,B,ht);let te,Kt=lt;if(ht!==null&&(te=b.get(ht),Kt=wt,Kt.setIndex(te)),L.isMesh)z.wireframe===!0?(mt.setLineWidth(z.wireframeLinewidth*Se()),Kt.setMode(T.LINES)):Kt.setMode(T.TRIANGLES);else if(L.isLine){let Et=z.linewidth;Et===void 0&&(Et=1),mt.setLineWidth(Et*Se()),L.isLineSegments?Kt.setMode(T.LINES):L.isLineLoop?Kt.setMode(T.LINE_LOOP):Kt.setMode(T.LINE_STRIP)}else L.isPoints?Kt.setMode(T.POINTS):L.isSprite&&Kt.setMode(T.TRIANGLES);if(L.isBatchedMesh)if(L._multiDrawInstances!==null)Ni("THREE.WebGLRenderer: renderMultiDrawInstances has been deprecated and will be removed in r184. Append to renderMultiDraw arguments and use indirection."),Kt.renderMultiDrawInstances(L._multiDrawStarts,L._multiDrawCounts,L._multiDrawCount,L._multiDrawInstances);else if(Lt.get("WEBGL_multi_draw"))Kt.renderMultiDraw(L._multiDrawStarts,L._multiDrawCounts,L._multiDrawCount);else{let Et=L._multiDrawStarts,re=L._multiDrawCounts,Xt=L._multiDrawCount,Oe=ht?b.get(ht).bytesPerElement:1,xi=gt.get(z).currentProgram.getUniforms();for(let Be=0;Be<Xt;Be++)xi.setValue(T,"_gl_DrawID",Be),Kt.render(Et[Be]/Oe,re[Be])}else if(L.isInstancedMesh)Kt.renderInstances(Vt,le,L.count);else if(B.isInstancedBufferGeometry){let Et=B._maxInstanceCount!==void 0?B._maxInstanceCount:1/0,re=Math.min(B.instanceCount,Et);Kt.renderInstances(Vt,le,re)}else Kt.render(Vt,le)};function Qt(x,D,B){x.transparent===!0&&x.side===mn&&x.forceSinglePass===!1?(x.side=De,x.needsUpdate=!0,Vs(x,D,B),x.side=Tn,x.needsUpdate=!0,Vs(x,D,B),x.side=mn):Vs(x,D,B)}this.compile=function(x,D,B=null){B===null&&(B=x),h=vt.get(B),h.init(D),E.push(h),B.traverseVisible(function(L){L.isLight&&L.layers.test(D.layers)&&(h.pushLight(L),L.castShadow&&h.pushShadow(L))}),x!==B&&x.traverseVisible(function(L){L.isLight&&L.layers.test(D.layers)&&(h.pushLight(L),L.castShadow&&h.pushShadow(L))}),h.setupLights();let z=new Set;return x.traverse(function(L){if(!(L.isMesh||L.isPoints||L.isLine||L.isSprite))return;let j=L.material;if(j)if(Array.isArray(j))for(let ot=0;ot<j.length;ot++){let ft=j[ot];Qt(ft,B,L),z.add(ft)}else Qt(j,B,L),z.add(j)}),h=E.pop(),z},this.compileAsync=function(x,D,B=null){let z=this.compile(x,D,B);return new Promise(L=>{function j(){if(z.forEach(function(ot){gt.get(ot).currentProgram.isReady()&&z.delete(ot)}),z.size===0){L(x);return}setTimeout(j,10)}Lt.get("KHR_parallel_shader_compile")!==null?j():setTimeout(j,10)})};let Yt=null;function xn(x){Yt&&Yt(x)}function hn(){Zn.stop()}function ol(){Zn.start()}let Zn=new Zc;Zn.setAnimationLoop(xn),typeof self<"u"&&Zn.setContext(self),this.setAnimationLoop=function(x){Yt=x,tt.setAnimationLoop(x),x===null?Zn.stop():Zn.start()},tt.addEventListener("sessionstart",hn),tt.addEventListener("sessionend",ol),this.render=function(x,D){if(D!==void 0&&D.isCamera!==!0){console.error("THREE.WebGLRenderer.render: camera is not an instance of THREE.Camera.");return}if(C===!0)return;if(x.matrixWorldAutoUpdate===!0&&x.updateMatrixWorld(),D.parent===null&&D.matrixWorldAutoUpdate===!0&&D.updateMatrixWorld(),tt.enabled===!0&&tt.isPresenting===!0&&(tt.cameraAutoUpdate===!0&&tt.updateCamera(D),D=tt.getCamera()),x.isScene===!0&&x.onBeforeRender(S,x,D,U),h=vt.get(x,E.length),h.init(D),E.push(h),$.multiplyMatrices(D.projectionMatrix,D.matrixWorldInverse),ne.setFromProjectionMatrix($,en,D.reversedDepth),Y=this.localClippingEnabled,qt=nt.init(this.clippingPlanes,Y),m=H.get(x,w.length),m.init(),w.push(m),tt.enabled===!0&&tt.isPresenting===!0){let j=S.xr.getDepthSensingMesh();j!==null&&La(j,D,-1/0,S.sortObjects)}La(x,D,0,S.sortObjects),m.finish(),S.sortObjects===!0&&m.sort(rt,ct),Gt=tt.enabled===!1||tt.isPresenting===!1||tt.hasDepthSensing()===!1,Gt&&xt.addToRenderList(m,x),this.info.render.frame++,qt===!0&&nt.beginShadows();let B=h.state.shadowsArray;_t.render(B,x,D),qt===!0&&nt.endShadows(),this.info.autoReset===!0&&this.info.reset();let z=m.opaque,L=m.transmissive;if(h.setupLights(),D.isArrayCamera){let j=D.cameras;if(L.length>0)for(let ot=0,ft=j.length;ot<ft;ot++){let ht=j[ot];cl(z,L,x,ht)}Gt&&xt.render(x);for(let ot=0,ft=j.length;ot<ft;ot++){let ht=j[ot];ll(m,x,ht,ht.viewport)}}else L.length>0&&cl(z,L,x,D),Gt&&xt.render(x),ll(m,x,D);U!==null&&P===0&&(Ot.updateMultisampleRenderTarget(U),Ot.updateRenderTargetMipmap(U)),x.isScene===!0&&x.onAfterRender(S,x,D),at.resetDefaultState(),M=-1,y=null,E.pop(),E.length>0?(h=E[E.length-1],qt===!0&&nt.setGlobalState(S.clippingPlanes,h.state.camera)):h=null,w.pop(),w.length>0?m=w[w.length-1]:m=null};function La(x,D,B,z){if(x.visible===!1)return;if(x.layers.test(D.layers)){if(x.isGroup)B=x.renderOrder;else if(x.isLOD)x.autoUpdate===!0&&x.update(D);else if(x.isLight)h.pushLight(x),x.castShadow&&h.pushShadow(x);else if(x.isSprite){if(!x.frustumCulled||ne.intersectsSprite(x)){z&&Pt.setFromMatrixPosition(x.matrixWorld).applyMatrix4($);let ot=F.update(x),ft=x.material;ft.visible&&m.push(x,ot,ft,B,Pt.z,null)}}else if((x.isMesh||x.isLine||x.isPoints)&&(!x.frustumCulled||ne.intersectsObject(x))){let ot=F.update(x),ft=x.material;if(z&&(x.boundingSphere!==void 0?(x.boundingSphere===null&&x.computeBoundingSphere(),Pt.copy(x.boundingSphere.center)):(ot.boundingSphere===null&&ot.computeBoundingSphere(),Pt.copy(ot.boundingSphere.center)),Pt.applyMatrix4(x.matrixWorld).applyMatrix4($)),Array.isArray(ft)){let ht=ot.groups;for(let Tt=0,Ct=ht.length;Tt<Ct;Tt++){let bt=ht[Tt],Vt=ft[bt.materialIndex];Vt&&Vt.visible&&m.push(x,ot,Vt,B,Pt.z,bt)}}else ft.visible&&m.push(x,ot,ft,B,Pt.z,null)}}let j=x.children;for(let ot=0,ft=j.length;ot<ft;ot++)La(j[ot],D,B,z)}function ll(x,D,B,z){let L=x.opaque,j=x.transmissive,ot=x.transparent;h.setupLightsView(B),qt===!0&&nt.setGlobalState(S.clippingPlanes,B),z&&mt.viewport(I.copy(z)),L.length>0&&ks(L,D,B),j.length>0&&ks(j,D,B),ot.length>0&&ks(ot,D,B),mt.buffers.depth.setTest(!0),mt.buffers.depth.setMask(!0),mt.buffers.color.setMask(!0),mt.setPolygonOffset(!1)}function cl(x,D,B,z){if((B.isScene===!0?B.overrideMaterial:null)!==null)return;h.state.transmissionRenderTarget[z.id]===void 0&&(h.state.transmissionRenderTarget[z.id]=new dn(1,1,{generateMipmaps:!0,type:Lt.has("EXT_color_buffer_half_float")||Lt.has("EXT_color_buffer_float")?Gi:an,minFilter:Xn,samples:4,stencilBuffer:r,resolveDepthBuffer:!1,resolveStencilBuffer:!1,colorSpace:Wt.workingColorSpace}));let j=h.state.transmissionRenderTarget[z.id],ot=z.viewport||I;j.setSize(ot.z*S.transmissionResolutionScale,ot.w*S.transmissionResolutionScale);let ft=S.getRenderTarget(),ht=S.getActiveCubeFace(),Tt=S.getActiveMipmapLevel();S.setRenderTarget(j),S.getClearColor(G),q=S.getClearAlpha(),q<1&&S.setClearColor(16777215,.5),S.clear(),Gt&&xt.render(B);let Ct=S.toneMapping;S.toneMapping=An;let bt=z.viewport;if(z.viewport!==void 0&&(z.viewport=void 0),h.setupLightsView(z),qt===!0&&nt.setGlobalState(S.clippingPlanes,z),ks(x,B,z),Ot.updateMultisampleRenderTarget(j),Ot.updateRenderTargetMipmap(j),Lt.has("WEBGL_multisampled_render_to_texture")===!1){let Vt=!1;for(let Jt=0,le=D.length;Jt<le;Jt++){let te=D[Jt],Kt=te.object,Et=te.geometry,re=te.material,Xt=te.group;if(re.side===mn&&Kt.layers.test(z.layers)){let Oe=re.side;re.side=De,re.needsUpdate=!0,hl(Kt,B,z,Et,re,Xt),re.side=Oe,re.needsUpdate=!0,Vt=!0}}Vt===!0&&(Ot.updateMultisampleRenderTarget(j),Ot.updateRenderTargetMipmap(j))}S.setRenderTarget(ft,ht,Tt),S.setClearColor(G,q),bt!==void 0&&(z.viewport=bt),S.toneMapping=Ct}function ks(x,D,B){let z=D.isScene===!0?D.overrideMaterial:null;for(let L=0,j=x.length;L<j;L++){let ot=x[L],ft=ot.object,ht=ot.geometry,Tt=ot.group,Ct=ot.material;Ct.allowOverride===!0&&z!==null&&(Ct=z),ft.layers.test(B.layers)&&hl(ft,D,B,ht,Ct,Tt)}}function hl(x,D,B,z,L,j){x.onBeforeRender(S,D,B,z,L,j),x.modelViewMatrix.multiplyMatrices(B.matrixWorldInverse,x.matrixWorld),x.normalMatrix.getNormalMatrix(x.modelViewMatrix),L.onBeforeRender(S,D,B,z,x,j),L.transparent===!0&&L.side===mn&&L.forceSinglePass===!1?(L.side=De,L.needsUpdate=!0,S.renderBufferDirect(B,D,z,L,x,j),L.side=Tn,L.needsUpdate=!0,S.renderBufferDirect(B,D,z,L,x,j),L.side=mn):S.renderBufferDirect(B,D,z,L,x,j),x.onAfterRender(S,D,B,z,L,j)}function Vs(x,D,B){D.isScene!==!0&&(D=Mt);let z=gt.get(x),L=h.state.lights,j=h.state.shadowsArray,ot=L.state.version,ft=X.getParameters(x,L.state,j,D,B),ht=X.getProgramCacheKey(ft),Tt=z.programs;z.environment=x.isMeshStandardMaterial?D.environment:null,z.fog=D.fog,z.envMap=(x.isMeshStandardMaterial?he:ye).get(x.envMap||z.environment),z.envMapRotation=z.environment!==null&&x.envMap===null?D.environmentRotation:x.envMapRotation,Tt===void 0&&(x.addEventListener("dispose",Z),Tt=new Map,z.programs=Tt);let Ct=Tt.get(ht);if(Ct!==void 0){if(z.currentProgram===Ct&&z.lightsStateVersion===ot)return dl(x,ft),Ct}else ft.uniforms=X.getUniforms(x),x.onBeforeCompile(ft,S),Ct=X.acquireProgram(ft,ht),Tt.set(ht,Ct),z.uniforms=ft.uniforms;let bt=z.uniforms;return(!x.isShaderMaterial&&!x.isRawShaderMaterial||x.clipping===!0)&&(bt.clippingPlanes=nt.uniform),dl(x,ft),z.needsLights=yh(x),z.lightsStateVersion=ot,z.needsLights&&(bt.ambientLightColor.value=L.state.ambient,bt.lightProbe.value=L.state.probe,bt.directionalLights.value=L.state.directional,bt.directionalLightShadows.value=L.state.directionalShadow,bt.spotLights.value=L.state.spot,bt.spotLightShadows.value=L.state.spotShadow,bt.rectAreaLights.value=L.state.rectArea,bt.ltc_1.value=L.state.rectAreaLTC1,bt.ltc_2.value=L.state.rectAreaLTC2,bt.pointLights.value=L.state.point,bt.pointLightShadows.value=L.state.pointShadow,bt.hemisphereLights.value=L.state.hemi,bt.directionalShadowMap.value=L.state.directionalShadowMap,bt.directionalShadowMatrix.value=L.state.directionalShadowMatrix,bt.spotShadowMap.value=L.state.spotShadowMap,bt.spotLightMatrix.value=L.state.spotLightMatrix,bt.spotLightMap.value=L.state.spotLightMap,bt.pointShadowMap.value=L.state.pointShadowMap,bt.pointShadowMatrix.value=L.state.pointShadowMatrix),z.currentProgram=Ct,z.uniformsList=null,Ct}function ul(x){if(x.uniformsList===null){let D=x.currentProgram.getUniforms();x.uniformsList=Ji.seqWithValue(D.seq,x.uniforms)}return x.uniformsList}function dl(x,D){let B=gt.get(x);B.outputColorSpace=D.outputColorSpace,B.batching=D.batching,B.batchingColor=D.batchingColor,B.instancing=D.instancing,B.instancingColor=D.instancingColor,B.instancingMorph=D.instancingMorph,B.skinning=D.skinning,B.morphTargets=D.morphTargets,B.morphNormals=D.morphNormals,B.morphColors=D.morphColors,B.morphTargetsCount=D.morphTargetsCount,B.numClippingPlanes=D.numClippingPlanes,B.numIntersection=D.numClipIntersection,B.vertexAlphas=D.vertexAlphas,B.vertexTangents=D.vertexTangents,B.toneMapping=D.toneMapping}function _h(x,D,B,z,L){D.isScene!==!0&&(D=Mt),Ot.resetTextureUnits();let j=D.fog,ot=z.isMeshStandardMaterial?D.environment:null,ft=U===null?S.outputColorSpace:U.isXRRenderTarget===!0?U.texture.colorSpace:ii,ht=(z.isMeshStandardMaterial?he:ye).get(z.envMap||ot),Tt=z.vertexColors===!0&&!!B.attributes.color&&B.attributes.color.itemSize===4,Ct=!!B.attributes.tangent&&(!!z.normalMap||z.anisotropy>0),bt=!!B.morphAttributes.position,Vt=!!B.morphAttributes.normal,Jt=!!B.morphAttributes.color,le=An;z.toneMapped&&(U===null||U.isXRRenderTarget===!0)&&(le=S.toneMapping);let te=B.morphAttributes.position||B.morphAttributes.normal||B.morphAttributes.color,Kt=te!==void 0?te.length:0,Et=gt.get(z),re=h.state.lights;if(qt===!0&&(Y===!0||x!==y)){let Re=x===y&&z.id===M;nt.setState(z,x,Re)}let Xt=!1;z.version===Et.__version?(Et.needsLights&&Et.lightsStateVersion!==re.state.version||Et.outputColorSpace!==ft||L.isBatchedMesh&&Et.batching===!1||!L.isBatchedMesh&&Et.batching===!0||L.isBatchedMesh&&Et.batchingColor===!0&&L.colorTexture===null||L.isBatchedMesh&&Et.batchingColor===!1&&L.colorTexture!==null||L.isInstancedMesh&&Et.instancing===!1||!L.isInstancedMesh&&Et.instancing===!0||L.isSkinnedMesh&&Et.skinning===!1||!L.isSkinnedMesh&&Et.skinning===!0||L.isInstancedMesh&&Et.instancingColor===!0&&L.instanceColor===null||L.isInstancedMesh&&Et.instancingColor===!1&&L.instanceColor!==null||L.isInstancedMesh&&Et.instancingMorph===!0&&L.morphTexture===null||L.isInstancedMesh&&Et.instancingMorph===!1&&L.morphTexture!==null||Et.envMap!==ht||z.fog===!0&&Et.fog!==j||Et.numClippingPlanes!==void 0&&(Et.numClippingPlanes!==nt.numPlanes||Et.numIntersection!==nt.numIntersection)||Et.vertexAlphas!==Tt||Et.vertexTangents!==Ct||Et.morphTargets!==bt||Et.morphNormals!==Vt||Et.morphColors!==Jt||Et.toneMapping!==le||Et.morphTargetsCount!==Kt)&&(Xt=!0):(Xt=!0,Et.__version=z.version);let Oe=Et.currentProgram;Xt===!0&&(Oe=Vs(z,D,L));let xi=!1,Be=!1,es=!1,ae=Oe.getUniforms(),We=Et.uniforms;if(mt.useProgram(Oe.program)&&(xi=!0,Be=!0,es=!0),z.id!==M&&(M=z.id,Be=!0),xi||y!==x){mt.buffers.depth.getReversed()&&x.reversedDepth!==!0&&(x._reversedDepth=!0,x.updateProjectionMatrix()),ae.setValue(T,"projectionMatrix",x.projectionMatrix),ae.setValue(T,"viewMatrix",x.matrixWorldInverse);let Le=ae.map.cameraPosition;Le!==void 0&&Le.setValue(T,dt.setFromMatrixPosition(x.matrixWorld)),At.logarithmicDepthBuffer&&ae.setValue(T,"logDepthBufFC",2/(Math.log(x.far+1)/Math.LN2)),(z.isMeshPhongMaterial||z.isMeshToonMaterial||z.isMeshLambertMaterial||z.isMeshBasicMaterial||z.isMeshStandardMaterial||z.isShaderMaterial)&&ae.setValue(T,"isOrthographic",x.isOrthographicCamera===!0),y!==x&&(y=x,Be=!0,es=!0)}if(L.isSkinnedMesh){ae.setOptional(T,L,"bindMatrix"),ae.setOptional(T,L,"bindMatrixInverse");let Re=L.skeleton;Re&&(Re.boneTexture===null&&Re.computeBoneTexture(),ae.setValue(T,"boneTexture",Re.boneTexture,Ot))}L.isBatchedMesh&&(ae.setOptional(T,L,"batchingTexture"),ae.setValue(T,"batchingTexture",L._matricesTexture,Ot),ae.setOptional(T,L,"batchingIdTexture"),ae.setValue(T,"batchingIdTexture",L._indirectTexture,Ot),ae.setOptional(T,L,"batchingColorTexture"),L._colorsTexture!==null&&ae.setValue(T,"batchingColorTexture",L._colorsTexture,Ot));let Xe=B.morphAttributes;if((Xe.position!==void 0||Xe.normal!==void 0||Xe.color!==void 0)&&Q.update(L,B,Oe),(Be||Et.receiveShadow!==L.receiveShadow)&&(Et.receiveShadow=L.receiveShadow,ae.setValue(T,"receiveShadow",L.receiveShadow)),z.isMeshGouraudMaterial&&z.envMap!==null&&(We.envMap.value=ht,We.flipEnvMap.value=ht.isCubeTexture&&ht.isRenderTargetTexture===!1?-1:1),z.isMeshStandardMaterial&&z.envMap===null&&D.environment!==null&&(We.envMapIntensity.value=D.environmentIntensity),Be&&(ae.setValue(T,"toneMappingExposure",S.toneMappingExposure),Et.needsLights&&xh(We,es),j&&z.fog===!0&&J.refreshFogUniforms(We,j),J.refreshMaterialUniforms(We,z,V,et,h.state.transmissionRenderTarget[x.id]),Ji.upload(T,ul(Et),We,Ot)),z.isShaderMaterial&&z.uniformsNeedUpdate===!0&&(Ji.upload(T,ul(Et),We,Ot),z.uniformsNeedUpdate=!1),z.isSpriteMaterial&&ae.setValue(T,"center",L.center),ae.setValue(T,"modelViewMatrix",L.modelViewMatrix),ae.setValue(T,"normalMatrix",L.normalMatrix),ae.setValue(T,"modelMatrix",L.matrixWorld),z.isShaderMaterial||z.isRawShaderMaterial){let Re=z.uniformsGroups;for(let Le=0,Ua=Re.length;Le<Ua;Le++){let Jn=Re[Le];Nt.update(Jn,Oe),Nt.bind(Jn,Oe)}}return Oe}function xh(x,D){x.ambientLightColor.needsUpdate=D,x.lightProbe.needsUpdate=D,x.directionalLights.needsUpdate=D,x.directionalLightShadows.needsUpdate=D,x.pointLights.needsUpdate=D,x.pointLightShadows.needsUpdate=D,x.spotLights.needsUpdate=D,x.spotLightShadows.needsUpdate=D,x.rectAreaLights.needsUpdate=D,x.hemisphereLights.needsUpdate=D}function yh(x){return x.isMeshLambertMaterial||x.isMeshToonMaterial||x.isMeshPhongMaterial||x.isMeshStandardMaterial||x.isShadowMaterial||x.isShaderMaterial&&x.lights===!0}this.getActiveCubeFace=function(){return A},this.getActiveMipmapLevel=function(){return P},this.getRenderTarget=function(){return U},this.setRenderTargetTextures=function(x,D,B){let z=gt.get(x);z.__autoAllocateDepthBuffer=x.resolveDepthBuffer===!1,z.__autoAllocateDepthBuffer===!1&&(z.__useRenderToTexture=!1),gt.get(x.texture).__webglTexture=D,gt.get(x.depthTexture).__webglTexture=z.__autoAllocateDepthBuffer?void 0:B,z.__hasExternalTextures=!0},this.setRenderTargetFramebuffer=function(x,D){let B=gt.get(x);B.__webglFramebuffer=D,B.__useDefaultFramebuffer=D===void 0};let vh=T.createFramebuffer();this.setRenderTarget=function(x,D=0,B=0){U=x,A=D,P=B;let z=!0,L=null,j=!1,ot=!1;if(x){let ht=gt.get(x);if(ht.__useDefaultFramebuffer!==void 0)mt.bindFramebuffer(T.FRAMEBUFFER,null),z=!1;else if(ht.__webglFramebuffer===void 0)Ot.setupRenderTarget(x);else if(ht.__hasExternalTextures)Ot.rebindTextures(x,gt.get(x.texture).__webglTexture,gt.get(x.depthTexture).__webglTexture);else if(x.depthBuffer){let bt=x.depthTexture;if(ht.__boundDepthTexture!==bt){if(bt!==null&&gt.has(bt)&&(x.width!==bt.image.width||x.height!==bt.image.height))throw new Error("WebGLRenderTarget: Attached DepthTexture is initialized to the incorrect size.");Ot.setupDepthRenderbuffer(x)}}let Tt=x.texture;(Tt.isData3DTexture||Tt.isDataArrayTexture||Tt.isCompressedArrayTexture)&&(ot=!0);let Ct=gt.get(x).__webglFramebuffer;x.isWebGLCubeRenderTarget?(Array.isArray(Ct[D])?L=Ct[D][B]:L=Ct[D],j=!0):x.samples>0&&Ot.useMultisampledRTT(x)===!1?L=gt.get(x).__webglMultisampledFramebuffer:Array.isArray(Ct)?L=Ct[B]:L=Ct,I.copy(x.viewport),O.copy(x.scissor),k=x.scissorTest}else I.copy(St).multiplyScalar(V).floor(),O.copy(kt).multiplyScalar(V).floor(),k=jt;if(B!==0&&(L=vh),mt.bindFramebuffer(T.FRAMEBUFFER,L)&&z&&mt.drawBuffers(x,L),mt.viewport(I),mt.scissor(O),mt.setScissorTest(k),j){let ht=gt.get(x.texture);T.framebufferTexture2D(T.FRAMEBUFFER,T.COLOR_ATTACHMENT0,T.TEXTURE_CUBE_MAP_POSITIVE_X+D,ht.__webglTexture,B)}else if(ot){let ht=D;for(let Tt=0;Tt<x.textures.length;Tt++){let Ct=gt.get(x.textures[Tt]);T.framebufferTextureLayer(T.FRAMEBUFFER,T.COLOR_ATTACHMENT0+Tt,Ct.__webglTexture,B,ht)}}else if(x!==null&&B!==0){let ht=gt.get(x.texture);T.framebufferTexture2D(T.FRAMEBUFFER,T.COLOR_ATTACHMENT0,T.TEXTURE_2D,ht.__webglTexture,B)}M=-1},this.readRenderTargetPixels=function(x,D,B,z,L,j,ot,ft=0){if(!(x&&x.isWebGLRenderTarget)){console.error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not THREE.WebGLRenderTarget.");return}let ht=gt.get(x).__webglFramebuffer;if(x.isWebGLCubeRenderTarget&&ot!==void 0&&(ht=ht[ot]),ht){mt.bindFramebuffer(T.FRAMEBUFFER,ht);try{let Tt=x.textures[ft],Ct=Tt.format,bt=Tt.type;if(!At.textureFormatReadable(Ct)){console.error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not in RGBA or implementation defined format.");return}if(!At.textureTypeReadable(bt)){console.error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not in UnsignedByteType or implementation defined type.");return}D>=0&&D<=x.width-z&&B>=0&&B<=x.height-L&&(x.textures.length>1&&T.readBuffer(T.COLOR_ATTACHMENT0+ft),T.readPixels(D,B,z,L,yt.convert(Ct),yt.convert(bt),j))}finally{let Tt=U!==null?gt.get(U).__webglFramebuffer:null;mt.bindFramebuffer(T.FRAMEBUFFER,Tt)}}},this.readRenderTargetPixelsAsync=async function(x,D,B,z,L,j,ot,ft=0){if(!(x&&x.isWebGLRenderTarget))throw new Error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not THREE.WebGLRenderTarget.");let ht=gt.get(x).__webglFramebuffer;if(x.isWebGLCubeRenderTarget&&ot!==void 0&&(ht=ht[ot]),ht)if(D>=0&&D<=x.width-z&&B>=0&&B<=x.height-L){mt.bindFramebuffer(T.FRAMEBUFFER,ht);let Tt=x.textures[ft],Ct=Tt.format,bt=Tt.type;if(!At.textureFormatReadable(Ct))throw new Error("THREE.WebGLRenderer.readRenderTargetPixelsAsync: renderTarget is not in RGBA or implementation defined format.");if(!At.textureTypeReadable(bt))throw new Error("THREE.WebGLRenderer.readRenderTargetPixelsAsync: renderTarget is not in UnsignedByteType or implementation defined type.");let Vt=T.createBuffer();T.bindBuffer(T.PIXEL_PACK_BUFFER,Vt),T.bufferData(T.PIXEL_PACK_BUFFER,j.byteLength,T.STREAM_READ),x.textures.length>1&&T.readBuffer(T.COLOR_ATTACHMENT0+ft),T.readPixels(D,B,z,L,yt.convert(Ct),yt.convert(bt),0);let Jt=U!==null?gt.get(U).__webglFramebuffer:null;mt.bindFramebuffer(T.FRAMEBUFFER,Jt);let le=T.fenceSync(T.SYNC_GPU_COMMANDS_COMPLETE,0);return T.flush(),await Mc(T,le,4),T.bindBuffer(T.PIXEL_PACK_BUFFER,Vt),T.getBufferSubData(T.PIXEL_PACK_BUFFER,0,j),T.deleteBuffer(Vt),T.deleteSync(le),j}else throw new Error("THREE.WebGLRenderer.readRenderTargetPixelsAsync: requested read bounds are out of range.")},this.copyFramebufferToTexture=function(x,D=null,B=0){let z=Math.pow(2,-B),L=Math.floor(x.image.width*z),j=Math.floor(x.image.height*z),ot=D!==null?D.x:0,ft=D!==null?D.y:0;Ot.setTexture2D(x,0),T.copyTexSubImage2D(T.TEXTURE_2D,B,0,0,ot,ft,L,j),mt.unbindTexture()};let Mh=T.createFramebuffer(),Sh=T.createFramebuffer();this.copyTextureToTexture=function(x,D,B=null,z=null,L=0,j=null){j===null&&(L!==0?(Ni("WebGLRenderer: copyTextureToTexture function signature has changed to support src and dst mipmap levels."),j=L,L=0):j=0);let ot,ft,ht,Tt,Ct,bt,Vt,Jt,le,te=x.isCompressedTexture?x.mipmaps[j]:x.image;if(B!==null)ot=B.max.x-B.min.x,ft=B.max.y-B.min.y,ht=B.isBox3?B.max.z-B.min.z:1,Tt=B.min.x,Ct=B.min.y,bt=B.isBox3?B.min.z:0;else{let Xe=Math.pow(2,-L);ot=Math.floor(te.width*Xe),ft=Math.floor(te.height*Xe),x.isDataArrayTexture?ht=te.depth:x.isData3DTexture?ht=Math.floor(te.depth*Xe):ht=1,Tt=0,Ct=0,bt=0}z!==null?(Vt=z.x,Jt=z.y,le=z.z):(Vt=0,Jt=0,le=0);let Kt=yt.convert(D.format),Et=yt.convert(D.type),re;D.isData3DTexture?(Ot.setTexture3D(D,0),re=T.TEXTURE_3D):D.isDataArrayTexture||D.isCompressedArrayTexture?(Ot.setTexture2DArray(D,0),re=T.TEXTURE_2D_ARRAY):(Ot.setTexture2D(D,0),re=T.TEXTURE_2D),T.pixelStorei(T.UNPACK_FLIP_Y_WEBGL,D.flipY),T.pixelStorei(T.UNPACK_PREMULTIPLY_ALPHA_WEBGL,D.premultiplyAlpha),T.pixelStorei(T.UNPACK_ALIGNMENT,D.unpackAlignment);let Xt=T.getParameter(T.UNPACK_ROW_LENGTH),Oe=T.getParameter(T.UNPACK_IMAGE_HEIGHT),xi=T.getParameter(T.UNPACK_SKIP_PIXELS),Be=T.getParameter(T.UNPACK_SKIP_ROWS),es=T.getParameter(T.UNPACK_SKIP_IMAGES);T.pixelStorei(T.UNPACK_ROW_LENGTH,te.width),T.pixelStorei(T.UNPACK_IMAGE_HEIGHT,te.height),T.pixelStorei(T.UNPACK_SKIP_PIXELS,Tt),T.pixelStorei(T.UNPACK_SKIP_ROWS,Ct),T.pixelStorei(T.UNPACK_SKIP_IMAGES,bt);let ae=x.isDataArrayTexture||x.isData3DTexture,We=D.isDataArrayTexture||D.isData3DTexture;if(x.isDepthTexture){let Xe=gt.get(x),Re=gt.get(D),Le=gt.get(Xe.__renderTarget),Ua=gt.get(Re.__renderTarget);mt.bindFramebuffer(T.READ_FRAMEBUFFER,Le.__webglFramebuffer),mt.bindFramebuffer(T.DRAW_FRAMEBUFFER,Ua.__webglFramebuffer);for(let Jn=0;Jn<ht;Jn++)ae&&(T.framebufferTextureLayer(T.READ_FRAMEBUFFER,T.COLOR_ATTACHMENT0,gt.get(x).__webglTexture,L,bt+Jn),T.framebufferTextureLayer(T.DRAW_FRAMEBUFFER,T.COLOR_ATTACHMENT0,gt.get(D).__webglTexture,j,le+Jn)),T.blitFramebuffer(Tt,Ct,ot,ft,Vt,Jt,ot,ft,T.DEPTH_BUFFER_BIT,T.NEAREST);mt.bindFramebuffer(T.READ_FRAMEBUFFER,null),mt.bindFramebuffer(T.DRAW_FRAMEBUFFER,null)}else if(L!==0||x.isRenderTargetTexture||gt.has(x)){let Xe=gt.get(x),Re=gt.get(D);mt.bindFramebuffer(T.READ_FRAMEBUFFER,Mh),mt.bindFramebuffer(T.DRAW_FRAMEBUFFER,Sh);for(let Le=0;Le<ht;Le++)ae?T.framebufferTextureLayer(T.READ_FRAMEBUFFER,T.COLOR_ATTACHMENT0,Xe.__webglTexture,L,bt+Le):T.framebufferTexture2D(T.READ_FRAMEBUFFER,T.COLOR_ATTACHMENT0,T.TEXTURE_2D,Xe.__webglTexture,L),We?T.framebufferTextureLayer(T.DRAW_FRAMEBUFFER,T.COLOR_ATTACHMENT0,Re.__webglTexture,j,le+Le):T.framebufferTexture2D(T.DRAW_FRAMEBUFFER,T.COLOR_ATTACHMENT0,T.TEXTURE_2D,Re.__webglTexture,j),L!==0?T.blitFramebuffer(Tt,Ct,ot,ft,Vt,Jt,ot,ft,T.COLOR_BUFFER_BIT,T.NEAREST):We?T.copyTexSubImage3D(re,j,Vt,Jt,le+Le,Tt,Ct,ot,ft):T.copyTexSubImage2D(re,j,Vt,Jt,Tt,Ct,ot,ft);mt.bindFramebuffer(T.READ_FRAMEBUFFER,null),mt.bindFramebuffer(T.DRAW_FRAMEBUFFER,null)}else We?x.isDataTexture||x.isData3DTexture?T.texSubImage3D(re,j,Vt,Jt,le,ot,ft,ht,Kt,Et,te.data):D.isCompressedArrayTexture?T.compressedTexSubImage3D(re,j,Vt,Jt,le,ot,ft,ht,Kt,te.data):T.texSubImage3D(re,j,Vt,Jt,le,ot,ft,ht,Kt,Et,te):x.isDataTexture?T.texSubImage2D(T.TEXTURE_2D,j,Vt,Jt,ot,ft,Kt,Et,te.data):x.isCompressedTexture?T.compressedTexSubImage2D(T.TEXTURE_2D,j,Vt,Jt,te.width,te.height,Kt,te.data):T.texSubImage2D(T.TEXTURE_2D,j,Vt,Jt,ot,ft,Kt,Et,te);T.pixelStorei(T.UNPACK_ROW_LENGTH,Xt),T.pixelStorei(T.UNPACK_IMAGE_HEIGHT,Oe),T.pixelStorei(T.UNPACK_SKIP_PIXELS,xi),T.pixelStorei(T.UNPACK_SKIP_ROWS,Be),T.pixelStorei(T.UNPACK_SKIP_IMAGES,es),j===0&&D.generateMipmaps&&T.generateMipmap(re),mt.unbindTexture()},this.initRenderTarget=function(x){gt.get(x).__webglFramebuffer===void 0&&Ot.setupRenderTarget(x)},this.initTexture=function(x){x.isCubeTexture?Ot.setTextureCube(x,0):x.isData3DTexture?Ot.setTexture3D(x,0):x.isDataArrayTexture||x.isCompressedArrayTexture?Ot.setTexture2DArray(x,0):Ot.setTexture2D(x,0),mt.unbindTexture()},this.resetState=function(){A=0,P=0,U=null,mt.reset(),at.reset()},typeof __THREE_DEVTOOLS__<"u"&&__THREE_DEVTOOLS__.dispatchEvent(new CustomEvent("observe",{detail:this}))}get coordinateSystem(){return en}get outputColorSpace(){return this._outputColorSpace}set outputColorSpace(t){this._outputColorSpace=t;let e=this.getContext();e.drawingBufferColorSpace=Wt._getDrawingBufferColorSpace(t),e.unpackColorSpace=Wt._getUnpackColorSpace()}};var Qc={type:"change"},tl={type:"start"},eh={type:"end"},Aa=new si,th=new Ye,Ym=Math.cos(70*Do.DEG2RAD),_e=new N,Fe=2*Math.PI,$t={NONE:-1,ROTATE:0,DOLLY:1,PAN:2,TOUCH_ROTATE:3,TOUCH_PAN:4,TOUCH_DOLLY_PAN:5,TOUCH_DOLLY_ROTATE:6},Qo=1e-6,Ca=class extends Rs{constructor(t,e=null){super(t,e),this.state=$t.NONE,this.target=new N,this.cursor=new N,this.minDistance=0,this.maxDistance=1/0,this.minZoom=0,this.maxZoom=1/0,this.minTargetRadius=0,this.maxTargetRadius=1/0,this.minPolarAngle=0,this.maxPolarAngle=Math.PI,this.minAzimuthAngle=-1/0,this.maxAzimuthAngle=1/0,this.enableDamping=!1,this.dampingFactor=.05,this.enableZoom=!0,this.zoomSpeed=1,this.enableRotate=!0,this.rotateSpeed=1,this.keyRotateSpeed=1,this.enablePan=!0,this.panSpeed=1,this.screenSpacePanning=!0,this.keyPanSpeed=7,this.zoomToCursor=!1,this.autoRotate=!1,this.autoRotateSpeed=2,this.keys={LEFT:"ArrowLeft",UP:"ArrowUp",RIGHT:"ArrowRight",BOTTOM:"ArrowDown"},this.mouseButtons={LEFT:Gn.ROTATE,MIDDLE:Gn.DOLLY,RIGHT:Gn.PAN},this.touches={ONE:Wn.ROTATE,TWO:Wn.DOLLY_PAN},this.target0=this.target.clone(),this.position0=this.object.position.clone(),this.zoom0=this.object.zoom,this._domElementKeyEvents=null,this._lastPosition=new N,this._lastQuaternion=new Je,this._lastTargetPosition=new N,this._quat=new Je().setFromUnitVectors(t.up,new N(0,1,0)),this._quatInverse=this._quat.clone().invert(),this._spherical=new Vi,this._sphericalDelta=new Vi,this._scale=1,this._panOffset=new N,this._rotateStart=new Rt,this._rotateEnd=new Rt,this._rotateDelta=new Rt,this._panStart=new Rt,this._panEnd=new Rt,this._panDelta=new Rt,this._dollyStart=new Rt,this._dollyEnd=new Rt,this._dollyDelta=new Rt,this._dollyDirection=new N,this._mouse=new Rt,this._performCursorZoom=!1,this._pointers=[],this._pointerPositions={},this._controlActive=!1,this._onPointerMove=Jm.bind(this),this._onPointerDown=Zm.bind(this),this._onPointerUp=$m.bind(this),this._onContextMenu=ig.bind(this),this._onMouseWheel=Qm.bind(this),this._onKeyDown=tg.bind(this),this._onTouchStart=eg.bind(this),this._onTouchMove=ng.bind(this),this._onMouseDown=Km.bind(this),this._onMouseMove=jm.bind(this),this._interceptControlDown=sg.bind(this),this._interceptControlUp=rg.bind(this),this.domElement!==null&&this.connect(this.domElement),this.update()}connect(t){super.connect(t),this.domElement.addEventListener("pointerdown",this._onPointerDown),this.domElement.addEventListener("pointercancel",this._onPointerUp),this.domElement.addEventListener("contextmenu",this._onContextMenu),this.domElement.addEventListener("wheel",this._onMouseWheel,{passive:!1}),this.domElement.getRootNode().addEventListener("keydown",this._interceptControlDown,{passive:!0,capture:!0}),this.domElement.style.touchAction="none"}disconnect(){this.domElement.removeEventListener("pointerdown",this._onPointerDown),this.domElement.removeEventListener("pointermove",this._onPointerMove),this.domElement.removeEventListener("pointerup",this._onPointerUp),this.domElement.removeEventListener("pointercancel",this._onPointerUp),this.domElement.removeEventListener("wheel",this._onMouseWheel),this.domElement.removeEventListener("contextmenu",this._onContextMenu),this.stopListenToKeyEvents(),this.domElement.getRootNode().removeEventListener("keydown",this._interceptControlDown,{capture:!0}),this.domElement.style.touchAction="auto"}dispose(){this.disconnect()}getPolarAngle(){return this._spherical.phi}getAzimuthalAngle(){return this._spherical.theta}getDistance(){return this.object.position.distanceTo(this.target)}listenToKeyEvents(t){t.addEventListener("keydown",this._onKeyDown),this._domElementKeyEvents=t}stopListenToKeyEvents(){this._domElementKeyEvents!==null&&(this._domElementKeyEvents.removeEventListener("keydown",this._onKeyDown),this._domElementKeyEvents=null)}saveState(){this.target0.copy(this.target),this.position0.copy(this.object.position),this.zoom0=this.object.zoom}reset(){this.target.copy(this.target0),this.object.position.copy(this.position0),this.object.zoom=this.zoom0,this.object.updateProjectionMatrix(),this.dispatchEvent(Qc),this.update(),this.state=$t.NONE}update(t=null){let e=this.object.position;_e.copy(e).sub(this.target),_e.applyQuaternion(this._quat),this._spherical.setFromVector3(_e),this.autoRotate&&this.state===$t.NONE&&this._rotateLeft(this._getAutoRotationAngle(t)),this.enableDamping?(this._spherical.theta+=this._sphericalDelta.theta*this.dampingFactor,this._spherical.phi+=this._sphericalDelta.phi*this.dampingFactor):(this._spherical.theta+=this._sphericalDelta.theta,this._spherical.phi+=this._sphericalDelta.phi);let n=this.minAzimuthAngle,s=this.maxAzimuthAngle;isFinite(n)&&isFinite(s)&&(n<-Math.PI?n+=Fe:n>Math.PI&&(n-=Fe),s<-Math.PI?s+=Fe:s>Math.PI&&(s-=Fe),n<=s?this._spherical.theta=Math.max(n,Math.min(s,this._spherical.theta)):this._spherical.theta=this._spherical.theta>(n+s)/2?Math.max(n,this._spherical.theta):Math.min(s,this._spherical.theta)),this._spherical.phi=Math.max(this.minPolarAngle,Math.min(this.maxPolarAngle,this._spherical.phi)),this._spherical.makeSafe(),this.enableDamping===!0?this.target.addScaledVector(this._panOffset,this.dampingFactor):this.target.add(this._panOffset),this.target.sub(this.cursor),this.target.clampLength(this.minTargetRadius,this.maxTargetRadius),this.target.add(this.cursor);let r=!1;if(this.zoomToCursor&&this._performCursorZoom||this.object.isOrthographicCamera)this._spherical.radius=this._clampDistance(this._spherical.radius);else{let a=this._spherical.radius;this._spherical.radius=this._clampDistance(this._spherical.radius*this._scale),r=a!=this._spherical.radius}if(_e.setFromSpherical(this._spherical),_e.applyQuaternion(this._quatInverse),e.copy(this.target).add(_e),this.object.lookAt(this.target),this.enableDamping===!0?(this._sphericalDelta.theta*=1-this.dampingFactor,this._sphericalDelta.phi*=1-this.dampingFactor,this._panOffset.multiplyScalar(1-this.dampingFactor)):(this._sphericalDelta.set(0,0,0),this._panOffset.set(0,0,0)),this.zoomToCursor&&this._performCursorZoom){let a=null;if(this.object.isPerspectiveCamera){let o=_e.length();a=this._clampDistance(o*this._scale);let l=o-a;this.object.position.addScaledVector(this._dollyDirection,l),this.object.updateMatrixWorld(),r=!!l}else if(this.object.isOrthographicCamera){let o=new N(this._mouse.x,this._mouse.y,0);o.unproject(this.object);let l=this.object.zoom;this.object.zoom=Math.max(this.minZoom,Math.min(this.maxZoom,this.object.zoom/this._scale)),this.object.updateProjectionMatrix(),r=l!==this.object.zoom;let c=new N(this._mouse.x,this._mouse.y,0);c.unproject(this.object),this.object.position.sub(c).add(o),this.object.updateMatrixWorld(),a=_e.length()}else console.warn("WARNING: OrbitControls.js encountered an unknown camera type - zoom to cursor disabled."),this.zoomToCursor=!1;a!==null&&(this.screenSpacePanning?this.target.set(0,0,-1).transformDirection(this.object.matrix).multiplyScalar(a).add(this.object.position):(Aa.origin.copy(this.object.position),Aa.direction.set(0,0,-1).transformDirection(this.object.matrix),Math.abs(this.object.up.dot(Aa.direction))<Ym?this.object.lookAt(this.target):(th.setFromNormalAndCoplanarPoint(this.object.up,this.target),Aa.intersectPlane(th,this.target))))}else if(this.object.isOrthographicCamera){let a=this.object.zoom;this.object.zoom=Math.max(this.minZoom,Math.min(this.maxZoom,this.object.zoom/this._scale)),a!==this.object.zoom&&(this.object.updateProjectionMatrix(),r=!0)}return this._scale=1,this._performCursorZoom=!1,r||this._lastPosition.distanceToSquared(this.object.position)>Qo||8*(1-this._lastQuaternion.dot(this.object.quaternion))>Qo||this._lastTargetPosition.distanceToSquared(this.target)>Qo?(this.dispatchEvent(Qc),this._lastPosition.copy(this.object.position),this._lastQuaternion.copy(this.object.quaternion),this._lastTargetPosition.copy(this.target),!0):!1}_getAutoRotationAngle(t){return t!==null?Fe/60*this.autoRotateSpeed*t:Fe/60/60*this.autoRotateSpeed}_getZoomScale(t){let e=Math.abs(t*.01);return Math.pow(.95,this.zoomSpeed*e)}_rotateLeft(t){this._sphericalDelta.theta-=t}_rotateUp(t){this._sphericalDelta.phi-=t}_panLeft(t,e){_e.setFromMatrixColumn(e,0),_e.multiplyScalar(-t),this._panOffset.add(_e)}_panUp(t,e){this.screenSpacePanning===!0?_e.setFromMatrixColumn(e,1):(_e.setFromMatrixColumn(e,0),_e.crossVectors(this.object.up,_e)),_e.multiplyScalar(t),this._panOffset.add(_e)}_pan(t,e){let n=this.domElement;if(this.object.isPerspectiveCamera){let s=this.object.position;_e.copy(s).sub(this.target);let r=_e.length();r*=Math.tan(this.object.fov/2*Math.PI/180),this._panLeft(2*t*r/n.clientHeight,this.object.matrix),this._panUp(2*e*r/n.clientHeight,this.object.matrix)}else this.object.isOrthographicCamera?(this._panLeft(t*(this.object.right-this.object.left)/this.object.zoom/n.clientWidth,this.object.matrix),this._panUp(e*(this.object.top-this.object.bottom)/this.object.zoom/n.clientHeight,this.object.matrix)):(console.warn("WARNING: OrbitControls.js encountered an unknown camera type - pan disabled."),this.enablePan=!1)}_dollyOut(t){this.object.isPerspectiveCamera||this.object.isOrthographicCamera?this._scale/=t:(console.warn("WARNING: OrbitControls.js encountered an unknown camera type - dolly/zoom disabled."),this.enableZoom=!1)}_dollyIn(t){this.object.isPerspectiveCamera||this.object.isOrthographicCamera?this._scale*=t:(console.warn("WARNING: OrbitControls.js encountered an unknown camera type - dolly/zoom disabled."),this.enableZoom=!1)}_updateZoomParameters(t,e){if(!this.zoomToCursor)return;this._performCursorZoom=!0;let n=this.domElement.getBoundingClientRect(),s=t-n.left,r=e-n.top,a=n.width,o=n.height;this._mouse.x=s/a*2-1,this._mouse.y=-(r/o)*2+1,this._dollyDirection.set(this._mouse.x,this._mouse.y,1).unproject(this.object).sub(this.object.position).normalize()}_clampDistance(t){return Math.max(this.minDistance,Math.min(this.maxDistance,t))}_handleMouseDownRotate(t){this._rotateStart.set(t.clientX,t.clientY)}_handleMouseDownDolly(t){this._updateZoomParameters(t.clientX,t.clientX),this._dollyStart.set(t.clientX,t.clientY)}_handleMouseDownPan(t){this._panStart.set(t.clientX,t.clientY)}_handleMouseMoveRotate(t){this._rotateEnd.set(t.clientX,t.clientY),this._rotateDelta.subVectors(this._rotateEnd,this._rotateStart).multiplyScalar(this.rotateSpeed);let e=this.domElement;this._rotateLeft(Fe*this._rotateDelta.x/e.clientHeight),this._rotateUp(Fe*this._rotateDelta.y/e.clientHeight),this._rotateStart.copy(this._rotateEnd),this.update()}_handleMouseMoveDolly(t){this._dollyEnd.set(t.clientX,t.clientY),this._dollyDelta.subVectors(this._dollyEnd,this._dollyStart),this._dollyDelta.y>0?this._dollyOut(this._getZoomScale(this._dollyDelta.y)):this._dollyDelta.y<0&&this._dollyIn(this._getZoomScale(this._dollyDelta.y)),this._dollyStart.copy(this._dollyEnd),this.update()}_handleMouseMovePan(t){this._panEnd.set(t.clientX,t.clientY),this._panDelta.subVectors(this._panEnd,this._panStart).multiplyScalar(this.panSpeed),this._pan(this._panDelta.x,this._panDelta.y),this._panStart.copy(this._panEnd),this.update()}_handleMouseWheel(t){this._updateZoomParameters(t.clientX,t.clientY),t.deltaY<0?this._dollyIn(this._getZoomScale(t.deltaY)):t.deltaY>0&&this._dollyOut(this._getZoomScale(t.deltaY)),this.update()}_handleKeyDown(t){let e=!1;switch(t.code){case this.keys.UP:t.ctrlKey||t.metaKey||t.shiftKey?this.enableRotate&&this._rotateUp(Fe*this.keyRotateSpeed/this.domElement.clientHeight):this.enablePan&&this._pan(0,this.keyPanSpeed),e=!0;break;case this.keys.BOTTOM:t.ctrlKey||t.metaKey||t.shiftKey?this.enableRotate&&this._rotateUp(-Fe*this.keyRotateSpeed/this.domElement.clientHeight):this.enablePan&&this._pan(0,-this.keyPanSpeed),e=!0;break;case this.keys.LEFT:t.ctrlKey||t.metaKey||t.shiftKey?this.enableRotate&&this._rotateLeft(Fe*this.keyRotateSpeed/this.domElement.clientHeight):this.enablePan&&this._pan(this.keyPanSpeed,0),e=!0;break;case this.keys.RIGHT:t.ctrlKey||t.metaKey||t.shiftKey?this.enableRotate&&this._rotateLeft(-Fe*this.keyRotateSpeed/this.domElement.clientHeight):this.enablePan&&this._pan(-this.keyPanSpeed,0),e=!0;break}e&&(t.preventDefault(),this.update())}_handleTouchStartRotate(t){if(this._pointers.length===1)this._rotateStart.set(t.pageX,t.pageY);else{let e=this._getSecondPointerPosition(t),n=.5*(t.pageX+e.x),s=.5*(t.pageY+e.y);this._rotateStart.set(n,s)}}_handleTouchStartPan(t){if(this._pointers.length===1)this._panStart.set(t.pageX,t.pageY);else{let e=this._getSecondPointerPosition(t),n=.5*(t.pageX+e.x),s=.5*(t.pageY+e.y);this._panStart.set(n,s)}}_handleTouchStartDolly(t){let e=this._getSecondPointerPosition(t),n=t.pageX-e.x,s=t.pageY-e.y,r=Math.sqrt(n*n+s*s);this._dollyStart.set(0,r)}_handleTouchStartDollyPan(t){this.enableZoom&&this._handleTouchStartDolly(t),this.enablePan&&this._handleTouchStartPan(t)}_handleTouchStartDollyRotate(t){this.enableZoom&&this._handleTouchStartDolly(t),this.enableRotate&&this._handleTouchStartRotate(t)}_handleTouchMoveRotate(t){if(this._pointers.length==1)this._rotateEnd.set(t.pageX,t.pageY);else{let n=this._getSecondPointerPosition(t),s=.5*(t.pageX+n.x),r=.5*(t.pageY+n.y);this._rotateEnd.set(s,r)}this._rotateDelta.subVectors(this._rotateEnd,this._rotateStart).multiplyScalar(this.rotateSpeed);let e=this.domElement;this._rotateLeft(Fe*this._rotateDelta.x/e.clientHeight),this._rotateUp(Fe*this._rotateDelta.y/e.clientHeight),this._rotateStart.copy(this._rotateEnd)}_handleTouchMovePan(t){if(this._pointers.length===1)this._panEnd.set(t.pageX,t.pageY);else{let e=this._getSecondPointerPosition(t),n=.5*(t.pageX+e.x),s=.5*(t.pageY+e.y);this._panEnd.set(n,s)}this._panDelta.subVectors(this._panEnd,this._panStart).multiplyScalar(this.panSpeed),this._pan(this._panDelta.x,this._panDelta.y),this._panStart.copy(this._panEnd)}_handleTouchMoveDolly(t){let e=this._getSecondPointerPosition(t),n=t.pageX-e.x,s=t.pageY-e.y,r=Math.sqrt(n*n+s*s);this._dollyEnd.set(0,r),this._dollyDelta.set(0,Math.pow(this._dollyEnd.y/this._dollyStart.y,this.zoomSpeed)),this._dollyOut(this._dollyDelta.y),this._dollyStart.copy(this._dollyEnd);let a=(t.pageX+e.x)*.5,o=(t.pageY+e.y)*.5;this._updateZoomParameters(a,o)}_handleTouchMoveDollyPan(t){this.enableZoom&&this._handleTouchMoveDolly(t),this.enablePan&&this._handleTouchMovePan(t)}_handleTouchMoveDollyRotate(t){this.enableZoom&&this._handleTouchMoveDolly(t),this.enableRotate&&this._handleTouchMoveRotate(t)}_addPointer(t){this._pointers.push(t.pointerId)}_removePointer(t){delete this._pointerPositions[t.pointerId];for(let e=0;e<this._pointers.length;e++)if(this._pointers[e]==t.pointerId){this._pointers.splice(e,1);return}}_isTrackingPointer(t){for(let e=0;e<this._pointers.length;e++)if(this._pointers[e]==t.pointerId)return!0;return!1}_trackPointer(t){let e=this._pointerPositions[t.pointerId];e===void 0&&(e=new Rt,this._pointerPositions[t.pointerId]=e),e.set(t.pageX,t.pageY)}_getSecondPointerPosition(t){let e=t.pointerId===this._pointers[0]?this._pointers[1]:this._pointers[0];return this._pointerPositions[e]}_customWheelEvent(t){let e=t.deltaMode,n={clientX:t.clientX,clientY:t.clientY,deltaY:t.deltaY};switch(e){case 1:n.deltaY*=16;break;case 2:n.deltaY*=100;break}return t.ctrlKey&&!this._controlActive&&(n.deltaY*=10),n}};function Zm(i){this.enabled!==!1&&(this._pointers.length===0&&(this.domElement.setPointerCapture(i.pointerId),this.domElement.addEventListener("pointermove",this._onPointerMove),this.domElement.addEventListener("pointerup",this._onPointerUp)),!this._isTrackingPointer(i)&&(this._addPointer(i),i.pointerType==="touch"?this._onTouchStart(i):this._onMouseDown(i)))}function Jm(i){this.enabled!==!1&&(i.pointerType==="touch"?this._onTouchMove(i):this._onMouseMove(i))}function $m(i){switch(this._removePointer(i),this._pointers.length){case 0:this.domElement.releasePointerCapture(i.pointerId),this.domElement.removeEventListener("pointermove",this._onPointerMove),this.domElement.removeEventListener("pointerup",this._onPointerUp),this.dispatchEvent(eh),this.state=$t.NONE;break;case 1:let t=this._pointers[0],e=this._pointerPositions[t];this._onTouchStart({pointerId:t,pageX:e.x,pageY:e.y});break}}function Km(i){let t;switch(i.button){case 0:t=this.mouseButtons.LEFT;break;case 1:t=this.mouseButtons.MIDDLE;break;case 2:t=this.mouseButtons.RIGHT;break;default:t=-1}switch(t){case Gn.DOLLY:if(this.enableZoom===!1)return;this._handleMouseDownDolly(i),this.state=$t.DOLLY;break;case Gn.ROTATE:if(i.ctrlKey||i.metaKey||i.shiftKey){if(this.enablePan===!1)return;this._handleMouseDownPan(i),this.state=$t.PAN}else{if(this.enableRotate===!1)return;this._handleMouseDownRotate(i),this.state=$t.ROTATE}break;case Gn.PAN:if(i.ctrlKey||i.metaKey||i.shiftKey){if(this.enableRotate===!1)return;this._handleMouseDownRotate(i),this.state=$t.ROTATE}else{if(this.enablePan===!1)return;this._handleMouseDownPan(i),this.state=$t.PAN}break;default:this.state=$t.NONE}this.state!==$t.NONE&&this.dispatchEvent(tl)}function jm(i){switch(this.state){case $t.ROTATE:if(this.enableRotate===!1)return;this._handleMouseMoveRotate(i);break;case $t.DOLLY:if(this.enableZoom===!1)return;this._handleMouseMoveDolly(i);break;case $t.PAN:if(this.enablePan===!1)return;this._handleMouseMovePan(i);break}}function Qm(i){this.enabled===!1||this.enableZoom===!1||this.state!==$t.NONE||(i.preventDefault(),this.dispatchEvent(tl),this._handleMouseWheel(this._customWheelEvent(i)),this.dispatchEvent(eh))}function tg(i){this.enabled!==!1&&this._handleKeyDown(i)}function eg(i){switch(this._trackPointer(i),this._pointers.length){case 1:switch(this.touches.ONE){case Wn.ROTATE:if(this.enableRotate===!1)return;this._handleTouchStartRotate(i),this.state=$t.TOUCH_ROTATE;break;case Wn.PAN:if(this.enablePan===!1)return;this._handleTouchStartPan(i),this.state=$t.TOUCH_PAN;break;default:this.state=$t.NONE}break;case 2:switch(this.touches.TWO){case Wn.DOLLY_PAN:if(this.enableZoom===!1&&this.enablePan===!1)return;this._handleTouchStartDollyPan(i),this.state=$t.TOUCH_DOLLY_PAN;break;case Wn.DOLLY_ROTATE:if(this.enableZoom===!1&&this.enableRotate===!1)return;this._handleTouchStartDollyRotate(i),this.state=$t.TOUCH_DOLLY_ROTATE;break;default:this.state=$t.NONE}break;default:this.state=$t.NONE}this.state!==$t.NONE&&this.dispatchEvent(tl)}function ng(i){switch(this._trackPointer(i),this.state){case $t.TOUCH_ROTATE:if(this.enableRotate===!1)return;this._handleTouchMoveRotate(i),this.update();break;case $t.TOUCH_PAN:if(this.enablePan===!1)return;this._handleTouchMovePan(i),this.update();break;case $t.TOUCH_DOLLY_PAN:if(this.enableZoom===!1&&this.enablePan===!1)return;this._handleTouchMoveDollyPan(i),this.update();break;case $t.TOUCH_DOLLY_ROTATE:if(this.enableZoom===!1&&this.enableRotate===!1)return;this._handleTouchMoveDollyRotate(i),this.update();break;default:this.state=$t.NONE}}function ig(i){this.enabled!==!1&&i.preventDefault()}function sg(i){i.key==="Control"&&(this._controlActive=!0,this.domElement.getRootNode().addEventListener("keyup",this._interceptControlUp,{passive:!0,capture:!0}))}function rg(i){i.key==="Control"&&(this._controlActive=!1,this.domElement.getRootNode().removeEventListener("keyup",this._interceptControlUp,{passive:!0,capture:!0}))}var ln=document.querySelector("#codesparrow-office-map"),ah=ln.querySelector(".om-canvas"),oh=ln.querySelector("#officeMap"),cn=document.createElement("div");cn.className="om-three";ah.prepend(cn);var Ia=document.createElement("div");Ia.className="om-three-labels";cn.append(Ia);var xe;try{xe=new Ta({antialias:!0,alpha:!0})}catch(i){throw cn.remove(),ln.querySelector(".om-hint span:last-child").textContent="3D unavailable on this browser \xB7 Top view",console.warn("3D renderer unavailable",i),i}xe.setPixelRatio(Math.min(devicePixelRatio,2));xe.shadowMap.enabled=!0;xe.shadowMap.type=Rr;xe.outputColorSpace=Te;xe.toneMapping=Or;xe.toneMappingExposure=1;xe.setClearColor(16054521,0);cn.prepend(xe.domElement);oh.style.visibility="hidden";var sl=document.createElement("div");sl.className="om-3d-legend";sl.innerHTML='<span><i style="background:#14805d"></i>Punched</span><span><i style="background:#c94e62"></i>No punch</span><span><i style="background:#758c98"></i>Available</span>';ah.append(sl);var Ft=new _s,ue=new li(-20,20,14,-14,.1,150);ue.position.set(29,31,34);var Ge=new Ca(ue,xe.domElement);Ge.target.set(0,0,0);Ge.enableDamping=!0;Ge.dampingFactor=.09;Ge.minPolarAngle=.12;Ge.maxPolarAngle=Math.PI/2.3;Ge.minZoom=.55;Ge.maxZoom=2.6;Ge.maxDistance=90;Ge.update();Ft.add(new ws(16777215,10268600,1.8));var _i=new As(16774889,2.5);_i.position.set(-16,28,12);_i.castShadow=!0;_i.shadow.mapSize.set(2048,2048);Object.assign(_i.shadow.camera,{left:-23,right:23,top:23,bottom:-23,near:.1,far:85});_i.shadow.normalBias=.025;_i.shadow.bias=-3e-4;Ft.add(_i);var pe=(i,t={})=>new bs({color:i,roughness:.72,...t}),Pa=pe("#d7ba91"),Ke=pe("#f6f5ef"),lh=pe("#e3e9e9"),fe=pe("#59696c"),Yn=pe("#3c4a50"),el=pe("#278a88"),nl=pe("#d4a47e"),ch=pe("#343434"),ag=pe("#b6dbe0",{transparent:!0,opacity:.19,roughness:.15,metalness:.1,depthWrite:!1});function It(i,t,e,n,s,r,a,o){let l=new Me(new kn(t,e,n),o);return l.position.set(s,r,a),l.castShadow=!0,l.receiveShadow=!0,i.add(l),l}function gi(i,t,e,n,s,r,a,o){let l=new Me(new Ms(t,e,n,16),o);return l.position.set(s,r,a),l.castShadow=!0,l.receiveShadow=!0,i.add(l),l}function Qi(i,t,e,n,s,r,a=[1,1,1]){let o=new Me(new Ss(t,14,10),r);return o.position.set(e,n,s),o.scale.set(...a),o.castShadow=!0,i.add(o),o}It(Ft,28,.42,22,0,-.26,0,pe("#8caaae"));It(Ft,27.9,.1,21.9,0,0,0,pe("#ecebe4"));It(Ft,150,.1,150,0,-.56,0,pe("#f7fafb",{toneMapped:!1}));var hh=pe("#d5dbd7");for(let i=-12;i<14;i+=2)It(Ft,.012,.005,22,i,.056,0,hh);for(let i=-9;i<11;i+=2)It(Ft,28,.005,.012,0,.056,i,hh);It(Ft,28,3.5,.2,0,1.75,-11,lh);It(Ft,.2,3.5,22,-14,1.75,0,lh);It(Ft,28,.12,.28,0,3.56,-11,Ke);It(Ft,.28,.12,22,-14,3.56,0,Ke);for(let i of[-10,-5,0,6,11]){It(Ft,3.5,2,.06,i,2,-10.86,pe("#eff9fb",{roughness:.25}));for(let t of[-1.78,0,1.78])It(Ft,.055,2.1,.09,i+t,2,-10.8,fe);It(Ft,3.6,.065,.09,i,1,-10.8,fe),It(Ft,3.6,.065,.09,i,3,-10.8,fe)}It(Ft,28,.14,.16,0,.13,11,Ke);It(Ft,.16,.14,22,14,.13,0,Ke);function Da(i,t,e,n="x"){let s=new Pe;s.position.set(i,0,t),n==="z"&&(s.rotation.y=Math.PI/2),Ft.add(s),It(s,e,2.6,.045,0,1.35,0,ag),It(s,e,.055,.07,0,2.66,0,fe),It(s,e,.06,.07,0,.07,0,fe);for(let r=-e/2;r<=e/2+.01;r+=e/Math.ceil(e/2.8))It(s,.04,2.65,.07,r,1.35,0,fe);return s}Da(4.6,-6.7,8.6,"z");Da(9.3,-2.4,9.4);Da(9.3,4.2,9.4);Da(4.6,1.2,3.2,"z");function og(i,t,e=1){let n=new Pe;Ft.add(n),n.position.set(i,0,t),n.scale.setScalar(e),gi(n,.32,.23,.55,0,.33,0,Ke),gi(n,.28,.28,.035,0,.61,0,pe("#716149"));for(let s=0;s<9;s++){let r=s*2.4,a=.18+s%3*.13,o=Qi(n,.28,Math.cos(r)*a,1+s%4*.14,Math.sin(r)*a,pe(s%2?"#799665":"#4d7858"),[.6,1.8,.5]);o.rotation.z=Math.cos(r)*.55}return n}for(let[i,t,e]of[[-12.5,-9.5,1.2],[3,-9.5,1],[12.5,-9.5,1.1],[-12.6,9,1.2],[3,9.2,1.1],[12.6,9,1],[12.3,3,.85]])og(i,t,e);function Bs(i,t,e,n=6){let s=document.createElement("canvas");s.width=1024,s.height=128;let r=s.getContext("2d");r.font="600 55px Arial",r.fillStyle="#297e87",r.textAlign="center",r.fillText(i,512,82);let a=new xs(s);a.colorSpace=Te;let o=new Me(new ai(n,n/8),new ri({map:a,transparent:!0,depthWrite:!1,toneMapped:!1}));o.rotation.x=-Math.PI/2,o.position.set(t,.07,e),Ft.add(o)}Bs("IT DEPARTMENT",-4.5,-9,6);Bs("SEO DEPARTMENT",-5,1.5,6);Bs("CALLING",8,5.1,4);Bs("OWNER CABIN",9,-9,4);Bs("KITCHEN & BREAK",9,3.5,4);function ts(i,t,e,n=0){let s=new Pe;s.position.set(t,0,e),s.rotation.y=n,i.add(s),gi(s,.055,.055,.65,0,.37,0,fe);for(let r=0;r<5;r++){let a=r*Math.PI*2/5,o=It(s,.06,.05,.6,Math.sin(a)*.25,.15,Math.cos(a)*.25,fe);o.rotation.y=a,Qi(s,.065,Math.sin(a)*.51,.09,Math.cos(a)*.51,Yn)}It(s,.76,.14,.67,0,.78,0,Yn),It(s,.73,.78,.13,0,1.2,.31,Yn);for(let r of[-.4,.4])It(s,.055,.37,.055,r,.95,0,fe),It(s,.11,.065,.49,r,1.14,0,Yn);return s}var ji=new Pe;Ft.add(ji);var rl=[],nh=[],il=[],ih=[[-10,-6],[-6,-6],[-2,-6],[2,-6],[-10,-2],[-6,-2],[-2,-2],[2,-2],[-10,4],[-6,4],[-2,4],[-10,8],[-6,8],[-2,8],[7,8],[11,8]];function uh(i,t,e,n=!1){if(It(i,.12,.4,.12,t,1.64,e,fe),It(i,.58,.04,.3,t,1.43,e,fe),It(i,1.1,.73,.1,t,2,e,Yn),It(i,.99,.61,.012,t,2,e+.06,pe(n?"#5b8994":"#293c43",{emissive:n?"#315561":"#000000",emissiveIntensity:.3})),n)for(let s=0;s<4;s++)It(i,.48+s%2*.27,.019,.016,t-.08,2.18-s*.1,e+.074,pe("#b7d8d2"))}function dh(i,t=2.8){It(i,t,.12,1.35,0,1.35,0,Pa);for(let e of[-t/2+.12,t/2-.12])for(let n of[-.52,.52])It(i,.065,1.3,.065,e,.65,n,fe);It(i,t-.2,.12,.08,0,.75,-.5,fe)}function lg(i){let t=new Pe;i.add(t),t.position.set(0,0,1.06),It(t,.6,.7,.35,0,1.23,0,el),It(t,.49,.16,.52,0,.84,-.16,Yn),Qi(t,.235,0,1.88,-.06,nl,[1,1.15,1]),Qi(t,.24,0,1.98,-.1,ch,[1,.72,1]);let e=[];for(let n of[-.37,.37]){let s=It(t,.17,.16,.65,n,1.32,-.36,el);s.rotation.x=-.2,e.push(s),Qi(t,.1,n,1.36,-.74,nl)}rl.push({p:t,arms:e,seed:Math.random()*6})}function cg(i){i.traverse(t=>{t.geometry?.dispose(),t.material&&![Pa,Ke,fe,Yn,el,nl,ch].includes(t.material)&&t.material.dispose()})}function al(){for(;ji.children.length;){let i=ji.children[0];cg(i),ji.remove(i)}Ia.replaceChildren(),rl=[],nh=[],il=[],window.OfficeMap.getData().forEach((i,t)=>{let e=new Pe;e.position.set(ih[t][0],0,ih[t][1]),e.userData.deskId=i.id,ji.add(e),dh(e),uh(e,0,-.35,i.status==="present"),It(e,.75,.045,.27,0,1.45,.34,pe("#d2d8d6")),Qi(e,.09,.65,1.46,.35,Ke,[.7,.35,1]),gi(e,.09,.08,.18,-1,1.49,.25,Ke),ts(e,0,1.06),i.status==="present"&&lg(e);let n=It(e,2.95,.02,2.8,0,.07,.45,pe("#4cb9be",{transparent:!0,opacity:0}));e.userData.highlight=n,nh.push(e);let s=document.createElement("button");s.className="om-world-label "+i.status;let r=document.createElement("i"),a=document.createElement("span");a.textContent=i.name?i.name.split(" ")[0]:"Available";let b=document.createElement("small");b.className="om-seat-id";b.textContent=i.id;s.append(r,a,b),s.dataset.seat=i.id,s.title=i.id+" \xB7 "+{present:"Punched today",absent:"No punch",free:"Not allocated"}[i.status],s.setAttribute("aria-label",s.title+" \xB7 "+(i.name||"Available")),s.onclick=()=>fh(i.id),Ia.append(s),il.push({el:s,position:new N(e.position.x,2.8,e.position.z),g:e})})}function fh(i){ln.querySelector(`#seats .seat[data-id="${i}"]`)?.dispatchEvent(new MouseEvent("click",{bubbles:!0}))}var zs=new Pe;zs.position.set(9,0,-6);Ft.add(zs);dh(zs,3.8);uh(zs,0,-.35,!0);ts(zs,0,1.1);ts(Ft,8,-3.8,Math.PI);ts(Ft,10,-3.8,Math.PI);It(Ft,7.8,1.1,.7,9.4,.6,-10,Pa);It(Ft,7.9,.08,.75,9.4,1.2,-10,Ke);for(let i=6;i<13;i+=1.4)It(Ft,.025,.8,.01,i,.65,-9.64,fe);It(Ft,5.6,1.05,.85,10.2,.58,-1,Pa);It(Ft,5.8,.12,.95,10.2,1.17,-1,Ke);It(Ft,1,.05,.6,9.5,1.24,-1,fe);var Ox=gi(Ft,.025,.025,.4,9.5,1.45,-1.25,fe);It(Ft,.28,.05,.05,9.6,1.66,-1.25,fe);It(Ft,.5,.55,.4,12,1.51,-1,Yn);It(Ft,1.1,2.2,.9,13.1,1.15,.4,Ke);It(Ft,.05,.45,.07,12.72,1.5,.89,fe);gi(Ft,1.15,1.15,.1,9.3,.95,1.9,Ke);gi(Ft,.085,.085,.9,9.3,.47,1.9,fe);ts(Ft,7.9,1.9,-Math.PI/2);ts(Ft,10.7,1.9,Math.PI/2);var on=!0,Ki=null,Os=null,sh=new Cs,rh=new Rt;function ph(i){let t=xe.domElement.getBoundingClientRect();rh.set((i.clientX-t.left)/t.width*2-1,-(i.clientY-t.top)/t.height*2+1),sh.setFromCamera(rh,ue);let e=sh.intersectObjects(ji.children,!0);if(!e.length)return null;let n=e[0].object;for(;n&&!n.userData.deskId;)n=n.parent;return n}xe.domElement.addEventListener("pointerdown",i=>{Os=[i.clientX,i.clientY]});xe.domElement.addEventListener("pointerup",i=>{if(Os&&Math.hypot(i.clientX-Os[0],i.clientY-Os[1])<5){let t=ph(i);t&&fh(t.userData.deskId)}Os=null});xe.domElement.addEventListener("pointermove",i=>{Ki&&(Ki.userData.highlight.material.opacity=0),Ki=ph(i),Ki&&(Ki.userData.highlight.material.opacity=.12),xe.domElement.style.cursor=Ki?"pointer":"grab"});function mh(){let i=cn.clientWidth,t=cn.clientHeight;xe.setSize(i,t);let e=i/t,n=innerWidth<700?21:16;ue.left=-n*e,ue.right=n*e,ue.top=n,ue.bottom=-n,ue.updateProjectionMatrix()}new ResizeObserver(mh).observe(cn);function gh(){Ge.target.set(0,0,0),ue.position.set(29,31,34),ue.zoom=1,ue.updateProjectionMatrix(),Ge.update()}for(let[i,t]of[["zoomIn",()=>{ue.zoom=Math.min(2.6,ue.zoom*1.15),ue.updateProjectionMatrix()}],["zoomOut",()=>{ue.zoom=Math.max(.55,ue.zoom/1.15),ue.updateProjectionMatrix()}],["fitBtn",gh]])ln.querySelector("#"+i).addEventListener("click",e=>{on&&(e.stopImmediatePropagation(),t())},!0);var Ra=ln.querySelector("#viewToggle");Ra.addEventListener("click",i=>{i.stopImmediatePropagation(),on=!on,cn.hidden=!on,oh.style.visibility=on?"hidden":"visible",Ra.textContent=on?"3D":"2D",Ra.setAttribute("aria-pressed",String(on)),Ra.setAttribute("aria-label",on?"Switch to top view":"Switch to 3D view"),ln.querySelector(".om-hint span:last-child").textContent=on?"Drag to rotate \xB7 Scroll to zoom \xB7 Click a desk":"Click a desk \xB7 Drag to move",on||(window.OfficeMap.setTopView(),window.OfficeMap.fit())},!0);var hg=new MutationObserver(al);hg.observe(ln.querySelector("#seats"),{childList:!0});al();mh();ln.querySelector(".om-hint span:last-child").textContent="Drag to rotate \xB7 Scroll to zoom \xB7 Click a desk";xe.setAnimationLoop(i=>{if(!on||document.hidden)return;if(Ge.update(),!matchMedia("(prefers-reduced-motion: reduce)").matches&&ln.querySelector("#motionToggle").getAttribute("aria-pressed")==="false")for(let{p:s,arms:r,seed:a}of rl)s.rotation.y=Math.sin(i*.0015+a)*.035,r.forEach((o,l)=>o.rotation.x=-.2+Math.sin(i*.011+a+l*2)*.085);xe.render(Ft,ue);let e=cn.clientWidth,n=cn.clientHeight;for(let{el:s,position:r}of il){let a=r.clone().project(ue);s.style.transform=`translate(-50%,-50%) translate(${(a.x*.5+.5)*e}px,${(-a.y*.5+.5)*n}px)`,s.hidden=Math.abs(a.x)>1||Math.abs(a.y)>1}ln.querySelector("#zoomLabel").textContent=Math.round(ue.zoom*100)+"%"});window.Office3D={renderer:xe,scene:Ft,camera:ue,controls:Ge,fit:gh,sync:al};})();
/*! Bundled license information:

three/build/three.core.js:
three/build/three.module.js:
  (**
   * @license
   * Copyright 2010-2025 Three.js Authors
   * SPDX-License-Identifier: MIT
   *)
*/

</script>
@endverbatim
<script>window.OfficeMap.load({{ \Illuminate\Support\Js::from($officeMapData) }});</script>
