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

#codesparrow-office-map .om-room-label{position:absolute;left:0;top:0;white-space:nowrap;font-size:10px;letter-spacing:.8px;font-weight:750;color:#197a83;background:#ffffffd9;border:1px solid #d9e9ec;border-radius:4px;padding:4px 8px;box-shadow:0 2px 6px #193b4210}
#codesparrow-office-map .om-room-label[hidden]{display:none}

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
/* Keep this wide isometric floor legible inside the full-width CRM page. */
@media (min-width:701px){#codesparrow-office-map:not(:fullscreen) .om-canvas:has(.om-three){height:auto;min-height:640px;max-height:none;aspect-ratio:1.48}}
#codesparrow-office-map .om-world-label .om-seat-id{font-size:9px;font-weight:700;color:#197a83;margin-left:3px;padding-left:5px;border-left:1px solid #d5e5e8}
</style>
<section id="codesparrow-office-map" aria-label="CodeSparrow interactive office map">
 <div class="om-canvas">
  <img class="om-logo" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUsAAABdCAYAAAAsT0SsAAAQAElEQVR4Aex9C3xcVbX3WnsmkzTkYqlpmoTKl+vtLU1asAIX8QXl6YOLgAqIiIgIiqDC5dmkLYc+QeRD5ANFRfACPoqX8hJBKC3KRa5XsGKZlsrlVixJX7f21pAmkzl7ff81yUxm5pwzmUlmklLO+e09Zz/WXnudtff+77X3PjkxFF57jQb2b18yu6lj4bKm9kUr4H/f2L74T+o13NSx6PGmuQtvbm5f+OkpjtOw1zx0+CChBsZIAyFYjpGiK1nN/nOXTm/uWHiDJfenJHwl6joFfjaTTFOvYRI6gZi/KsS3mETkvqb2hReEoAnNhC7UQJEaCMGySEXtkWSOY5o7Fn/VcvJhEb6ciKcT0XBtOgk0RxLx7QDNXzRfvegEcpwohVeogVADBTUw3MAqWHg0mWHZ0WugsT96mIgsoQGQpBFch4ihO8DnkBGUDYuEGnhLaSAEyzdpc0++wmlkkX+D+HXwBV1trIoueP976JEvnUsPnP9ZOu3dB5NhTpeZymLvfMeVTnM6IbyHGgg14NVACJZenezxKW2OE4tEox0QdCr8sO7Y6dPosmOOpHdPbaZ/+j/voMuPPZLamqbQ0MXTk1XmwqF4GAo1EGogXwNvPbDM18CbML6jLzaNWT5VrOgnzmqluupYhnzqxLfRSUjLJBBFCQdD+1/pFAW+WeXCYKiBt4wGzFvmSfeqB7UfxePUwxfl+l3XQ9fbn8xPi0mV0VP0/PQwHmog1AA0YOBD9ybSQP2KJ+Zwbc05pYh81388T9u738gUWdu1hX78/JpMPB0Q4o+kw+E91ECogVwNhGCZq48KxkbHuuXOVTUNK578DJO50769oY1KuF58vYsuWv4Afe/Z39K3n3mO2h96jLb8rdvLQWSaNzFMCTUQakA1EIKlamEP9/UP/rK5e6L9MRHfQUQtst8kQ7GhPUikFXS6DH/m1Y3kPPoELX5sJT3/l00kIj5leGrj1U6LT0aYFGrgLa+BECz38C5Qv+KpC1giK5noFMBbCiGlZgLZifpuedmFr2UT+VNTx6JfNLYv/GyL40wsew0hw1ADb1INhGC5hzbclPsfb8Cy+3YmuZ2EZuSLKU04uB56VzI/Ozteahgn4/RhJv5hXyLy56aOhYumtC+ZFf6VT6lqDOn3Ng2EYLmHteikRx/dd/KKp063HP2FEF8QJJ5gGS51fxeUXa70fUl4nhG7sqk/8nBz+8LPT73amRYCZ7nUG/J5M2kgBMs9qLUmL19VF+mrxt6k3AmxDoEv6OTv3lYwv2yZTA0k9GERPjPJkek4XQr7TdmUGzJ6s2gg7PR7QkutWhWdfP+TH+Yq+x8QR9+hrMV9WCd1w/6l47A8iiB4jYXnRpPu/l3L5h+/edn8R+OOkyiiHIU0oQb2Jg2EYDnOrQlrsrH+r3YZMf9ciGC0lSBQTVGYWgLDHNIkEX+nK+b+Q+eyedf95etOJ4VXqIG3sAZCsByvxoc1WX//k//MVXYlzmkugRglt4XuWwJkUbTsbjuRXFgdS16K/UmAZtn5hwxDDbzpNFDyAH3TPeEeKPDEFasm1v+vvYWZfzpoTY7se5LMRNGRFS2kFiy7b+yK2R9sdJzeQnR7bF4oWKiBCmjAVIBnyLKABhpWPHlKjOzjLPQlkI1+HW0iYFNOJ+v7k8m7YFHacnINeYUaeLNrIATLMWpB7E3WYdm9QIhXCNHhZatWwK1szIhYzA+33eBspvAKNRBqIEcDIVjmqKP8kZbU33SvPIGq5GFmvqbsNfh8UWg0dRhJ/mw05d/aZcOn35s1EIJlJVvXcUzPfvZiIbqdSOagqvLqW7BSti7Yls3ZTTX0atm4hYxCDexFGijv4N2LFDPaR3n7ipWHT37XB3+NVfIN4FWRj1NwTw8wWMC+bK6HHAcIXDZ+IaNQA3uNBkKwLHNT7rv8sUkND6y8HMcuvwbr98FXzHH3rnLzTpabYchvTDQQVjIGGgjBsoxKnnz/Ex+ojkX15fJFQpT6QlAZ2XtY8c6/etJGmRCC5SgVGBbfezUQgmU52nb58tjkB578JLG5m4SPIKGacrAtyCPRR9z9t4IkI8gM+8MIlBYWeWtoIBwco2znyQ+uPHJyrP5BEr4PrCqyNwm+uQ6HOpGN/0Vky769+FpuRWEs1EBhDbyVckOwHEVr6yEOWbqTRE4YBZuSi/KuXZWwKlWO8CRctRD6UAM+GgjB0kcpxSbZiN3MRGP6J4H8t11kXocBWOb3K1PPLPx86h7+hBoINeDRQAiWHpUUn/DXjx3/mjBfgRJjY5Fh2a1AyT1voMryO0vyYvm5hhxDDVRAA+PAMgTLUSp92ynHPOqynExClQUaWJKR/3qZ1LIcpchBxXdGqt2ngjLD9FADb3UNhGBZhh6wY80z63ESfg4Rr6YKXNzXS5E/v0r8vzsrwH2AJRM/0Ok4PQOx8DfUQKiBfA2EYJmvkZHEHcduO/XoNX39iU+g+DfhN8GP3okls20LmVdgUf7PNsJB0uh5+nPYDrC82T8rTA01EGpANTAAlhoK/ag1sOv0D+/YNtFcwcJfA7MN8CN3ImS2dJF57b+pUnuUaeEYWwgS6x+dvGlm4T3UwF6qgRAsy92wRx+d3PrxY+7fduqxB4rhk8H+WeLiT8y5dzeZzr9Q9A+/I/OXP1MF3qWESDku4RLdFC7Bc3QSRkINeDQQgqVHJeVL2H7yMQ+xK2ezyJmU7F/Ob3RbTvQRJZNEOLAhN0mcSBDv7sF+5F9T4KhLbtP1OlF/f/kEKcRJ6NlIwn2uEEmYF2og1ADROIPl3t8EWz953KtbTz3ugckvPXd2ZMPaZyLrX6LI+rWDHuGXNYz7hvVkNr+eAs4xsCbTiu9xxT2v80ZnezohvIcaCDXgr4EQLP31UvbUuOMkTD+fT329O1KWZM8blNqL7O0lWJ2oT+DH1jHz3K3XOa+Oba1hbaEG3pwaCMFyDNvt9WXtGwBQJwEWK/tO5vDPlGDhqzqXzPvW8KQhRaiBUAOqgbcqWOqzj4vvrEo+h4PuDiIeL4suKcT39FYnv0PhFWog1EDRGgjBsmhVlYnQceyWZfMfidjkh4gkXiauJbDh7ydiyUt3OM6uEgqFpKEG3vIaCMFynLrApuucVzhmj0L1D8D3wFfa7WCS87qWzrswBMpKqzrkvzdqIATLMW7V7Oo6HWd719L5p7KlU5H+AnwSvtxuJxMttzG3tXPpgh+Um3nIL9TAW0UDIVjuAS3ded38X3Kf+yHsZZ5JTI9BpNfgLfxIHY7YdYnP3yHm4ynmnrvFcbaOlFlYLtRAqAEK37PcUzqBvuu4edn8n3VVuSeJdY9iIf0783sgXwl7i7KeWRaKoY/YmD26C0vuriXzfgcLtgd8QhdqINTAKDRQMcuyra0t1tLSUvn/RTOKh98jizpOcvN1zsbOZfMf6Fo6/+yumLtfNOnuL8zvsUInYd/xLCE5F4dDZ+N+hjV0bITMu/pi7tu6li5o7Vyy4JrNi+ev9liSe+TDhkKFGnjzaMCMUlRz0EH/+M7W1tYjZ7a1XTurrXXFzLbWP8PvxqDu26d2wm6EXfi/zmxt/XfQ3Dmrre30tra22dOmTdt3lHWPuDjqP2D27NkTsxkcfPDBU9VnpxUTbsGEcOihh9aOxiuPOXPmRFGftz1wev6Xrzudm5fM+62eoncuXfCjzUsX3AVgvAf35VsWz39q09KOF8NDG2gvdKEGKqgB7+AcvrIUQAL8LpnZNmOFdSNPG6bHYeksEKJTiOgA+GyLUuuYSEzvA83nYA39FEC6qjpW9cTMma23trW1fWB2HnChfEUc6mpsa5uxhEUeTiQS07Mr6e/vP9hN9q9C/ucOPPDA5uy8QuF9Jkx4sHd3z6rR+LraCau2bdnyNCabVfAr2tpa74BuFkHHn501a8b7dEJSQPWTY8aMGS0HHTR9xkF7iIeOtf39RPVNa3ac2uaOxe9r6lj8L43ti+9o6lj086a5i1bh/nhT+6J7G+cuXtB89aITQFfvyyArsfmqaw5oBq9ifGPH4sOntC+ZNfkKp5EcRyeqLE7DBxvnLm0brp6Gq513Ds+JqMVxJg7HK50/pWPxEU3tSw7Zf+7S6ZMcp2iDYyR1qPzQe20xzxBE03i109I0d9HHmzsWXtvcvuinCD8Br+37i6b2xbcj/WJtC5UviIemazuldZB9b+pYfBjKZuONkqd889ylM7Jps8NT25ccnCLK/0FfaIJ+s2k1rDIqkOWTB8Z1wLa1td5q3ehKgN9NRPwx+KlE5Css0oPcRGQcTkJfBnD+IpnoexCDbDbSKubU+gVIPs7E7ZB9ugh29ry1TUP+96LGqDyHe7N9UpgOQarSjthjkjkCMr0P9yPhT2Giz0M385D2Q7G8SickBVSA5yUtLblbG8w8yXUjV4BG6cbdG5K872JCOwFOO6wkIo+jLR4nkRvRF/S5P4rnnoPnPwHFPo092GvRUg9LwjzdOHfRR5EW6CQaOV9Eni7GM+gM2VXRKvN0cyJyrw6QQMZ5GW2OE2N2bx+unoiJLMor6htNJCOHDccrnW8gN0Fua9ynqxORp5s7Ft6w/5WOjkFf3unEEutYpXVA/lWSiKxqnrv4SgWrNK9i7yh3NZvI02jP+0R4Afr26QgfB6/t+2EiuQDpt7DIyj70g2aAWxDvSJU5Ia2D7Dv6zYpEX6zFr5wY9+Zs2uywS/ZevzLv6KEGIvfebFoN4wzhp0WBJYAs1tY24wIsq5/HQP4SKvEVDukjcXVQ4pFMAquu9Y5yW5kASaz8W++A9fsEGsl/NsmVOgq6wyDPb2a2td2OZ5+Umz3msRgRT4WOFFBvQht0wer8MZ7rOCIy69ate4GILxTicwEw+tHhRiIaTz+8vhwn2ti+8LMu2V9D1g/A18EXcqqDNmZ6sGnu4nktjhM0OUfBpFivPGCt8nQhOp3IPt8My6cYUNj2BuEZBYOKhqtrBuQZ3iVJx+FwvNL50AXti7bWNp4NsLncRiO/b5q78GYF8cDKSqtDdaNW6wHgd7iwXB+tirzc1L7wC4gP6xS8m9sX34lyy0CsPPT5EAx02v6ox/0NVhKXk+N46YX1Yy9pHWTfJ6IeX+tXJDUOsmmzw6o/j0A2EgMesT57Ni3Cst0rVF5x7OM1YHa/nom/jaw2+Eq5iQyLClbmSiw954y2Et1DBEp+HiCpAP958NNOhlvRDrqRCwCav29rm/G5fIuuaC7lJ5yIgfIpPNcTWLI/DDA/IB6PJ+EfmzxlynsB9D9BlXv06XdTX+RjTPw9yKmdEreiXZRYru3rN58rukQJhAqakaror/fHErdQsUg0BrBk+EJUqbxpqd/K/9QT81f/mojeUsGq0Fb8PUxW7eQEb1vost2NRm7FdttI2mgisGYR+odu5+U8CrPZnJMwFKlFn1CwHUoZDGFy1QltMOa5TcJzGE8qSy0T1XrTaauXeIjKYCBOc5P9D2NwfhnJhWiR+WFtOwAAEABJREFUXR6HDnuIWLobltMpcwYOPUpiDJnrUPajvbvfeBgNpgBfKkjm13cAE9+6D/YmwTdlzWUTQF79J1+V++c42ZXlhVH3R5kIFvmMK6fhwGz16tVJET4fz30RSIM6F7LGz01xnAZimgsJRtouBv3xUt0LA49CbkR5mBynWXaX6KAPYsDG1iNPt5JwK+j2rZSc/rXK55rbF37eFwT8C5SeyjK3sS+iWyS+ZaU/+iX0SSyxfbOLSaxB/+jYv33J7Gxik+wPek/YsBVvW6h1KqTtlM0mO2ymkDdfAJYgqoXPcSwcDJYAhjbsJdyKEroXN9KOjeIjcTwVltP127dvLknpCpRYTl2DsncQ8TFEVC65a9GAJxiWe2GtflqBCbwHHV+IwXstIrpMwG2snbyTia+prq66tqWlpQYWZndDQ+M9AEwFpN6xlma4+jhh5oBmNvwoHE/jiCmpb5RY2QnUHw2UkcXqHmG0GJ6GI8Vs/RTDqhiamCX+Gk4ni7F6i+HnR1MHi+0s8rEuJzk4cLJyFQqNdtwdbMU9G3wyrqqWAseXZfE8LxLU2izYRpE+XSFkqhgIuKLlvPKz9V+GA3SmGeb7FCAGOIzL73SxfB9k+cBwtYOmDiCGGU1eBnBcDnrf/Qikj9JxA0Do7upY1fO6NFfLF+C046V1674pxH9PxAuJaDwAqgaAfQkOgR5XXaiFGY+vv8sOvNhuIdOe4RzdizJLIIx/J2bajJn960TyRWK+DHTPwPs5WJe8yG/A+hEPpu3CXVcAaV9IL/uKyA2g93XC1Oqb4ZOI/nK0T3IpSdqf0jLrPVGoMBPNsn0RNXAKkeXn6baN8k77ZD5BXvzI5t6IGiM5ydUJczoxNeQkZkeYfknMlw60rywmtHd2dlY4Ssyfy27fjY6T1kMW2UDQiPHUWdMXw5wxkB/060ZcD40Y8fBC+YSQed0gkONSe5RksfchxW1O55Que6QGy6I7YeXqibMfc90qOAYj5+folLrk9jy8X6EypOmp+Z3btmx5Ql/dAT8D0Ox+KR6/BqB5FDqD/sliEulj6oQIB2V0i7ahVozDn0eJWP/bpHY0Gu9rai/BCpZpAXL0RsR8aPOSBVd1LV3w3a4l8/5vV8yFLkk/NEI+V/3+iapZPul+STsNmaO6ls7fL+2rY+7bifg7FHy9Tw8q/LKxJMt57SyfJjfOszHoPeMsl6ZATOS7aZn1DrnfRsIdKLED3s8ZY+Q9fhlBaRg7FynvtLcxd388o65MgvpwM0Xk/V5+rO3lTSbCvE0PdS2Z/6GuJfO+OdC+C+ZbMceDuBvez03ytq/4L8WNnZzPQIz1A70cMizfvct0Nt40om6sJnKX4WopJZP9AEr2zBo5tYxNxKKa10jopqqqKj3lRTTjDEBqOqy7mwCmKxQkMjljGWCaEzG8amZb2xLI06JVAzR/WxWrOZNxOs1EOKnW1LH08hk3mVzU0jLwihF0s4SYlo+lBEF1WY4EHhCK8Pc3Le3I/Siy46APGH39xhcYXHJLAK1cqWCp7KyOJS8Voodyc4ZiyUhk9lBsINTmODGU0WX4QELml/2/T8pUjxkcq8IM4agCkLt3v+rkN4hEwcyXF3Q5zTejyET966/O6iQs/MB+YwLqCGhf3oiVqsdS37K0Yy0OZwI/QC3k5vFj3314yOIFRit+oEfZl/G1gi22MrOpUuFuMpwLllu2bDkMA/yTyPau2ZE4hs5CjscwHZ2HJe5tL774YvaMotbkCRHme5n4q5AJp3T4HT8HkJQrIc+dOMV/n4qxZs2anWvj8XuSVgCa9CTSCi6dkF9OF8VAOr22tjYlC8B7B04Yb0cFusTCbfwcltjeTj0oDlYHTwwGc2421o+J0t+i8O/sOcULRhR4MBnfHUTERvS1l5zs/yHCYYLAU94l+k/f/CyxicleKmsf1X9REk3aR/IEGIoCoIciIww5Dsag/DywtE8dQhSw/SWbqSrpazhY5pWoA5MifvOcsMnn57tviXq97cHDgyWq81ikJMbLi6SHrRnas8ReVxs6ny5lDZiMnxN6VojPWBtfdxKWkQo0GVmwHD9iVlvrf8KafBjW0mGZjPEPGMgzRyyn/qQTcqa2DdavX78Bz3E8QP8oDMpfjqGYE6GjFWjT1GBfu3Y9BjIHzuBjJhebINBIYub2HQgYRdhPY3ivlGKNT8f20hVKYcMbke/Ln6x3ScZ9MVgsnA/6loTXEbF+LYryrnqORPPp80hKj+qfwKJU7gSIhJQTqiUn+PWeFE0RP4YiawPJhOry8zg1keSnIs60K+hjLsYafQZ//ZPdD6UzDhZkZyaSFUC99S2OU5OVRCIeoM3OToWVZrLj5D2H5AM0aLk7GevvNAilHIt8HIFynNzp/hjMZcayRH3KKkiA93CuU4h+IMznNDQ06D4VxslAEQz6xpmtrZcAzH8IGgUiWE8DeXver3wGct6BA6fPz549OzWYAfrPRaqqzqOBAyBfUKDyX/uicT8zyNZGotFbYXFuHYyP1y3TpnkCRGngFDIvmaiKSMuo9+Sxscj2JJeWIKy81XvKgX91fqIxVpfU+aDfzWwxkAVWcH4JqolYvwHooSs9gUnHmm85rF+Nb0YJiQCnQP4AKD/+fmkl1OghNQD9DE/oXrdj/Nqqxu0hbZcUAwVOJos96VS0wI9MQgcaAlmdYIRSY5ayL6HuLUQ7UoLgQGAqLCM9qk/Fs+mKDCcpZRHKNWzkWBNxj8bgPEq9kDlaiD+CTWRYNrzeh98O1P0T0JzY0DDli1g2vrJ69erUckbBBqBzuSEsB5huRNkR71GhbNphJuP7sQ8KME8nEbmu+1sivouIAmY55BTnFMhn43nv6E/06en0h/VVI2wlbBo8AMKmNi8k4h9lPNNPiORn0OEv4X+HdJUtsKNSkRdkuFTrVnLUv5U49XwaHRcvYqF7/6olIr6nxtgPskS8hoj0ZDzHW6H/Rnolnc94sLNRIcTCb8bxDmHzCgf+XyWekSENA6VoIEf/IvQ6CvuMT6lLRqsyFiEsszpmzsRRJsg1Zm+RTH6D6ol9LGamrQDtZEoY/YgEuL0TfiQOSxB6yBU5Kx5fvxBLvmf/+McN6zE4N6kH+Kl7qqGh8TILGlQQh0+77SR0VVVV9YUgWrN6ECQ1c9asAw/uTySux4CHJ7UmU7Jq3ij8DtR3RVUsdhFk25rNZ8OGDdvf6Om5UOtDut9yCsklu8OZ5O7q6qqO2YNWpj6ngib8WRn/0rozX4qvPw37sx8S5pPY2LMx8K5ioidLrjG3QH1NTfSIdJK19FMhuqeSnogfp4CLLWPF4Z8pYj6JDqkTTQ7BRsfp7YolL9wv5h6b7zfH7L/mEI9BxIp5d3416DO7Im6yE0aqn2VJwvT3+WXe7HH0ITv0DGMUEla88AFLrrHGDlmEu6WWBMA3rFhSbziWsSyrojHwQFlPOdSLtBQAGUNnIOzpqEgbziWF+FRhPhP7c7r3E0i/GkCI5egLVbHq9xPT19HBLkPZAwEQ39cDkXRBPVWeObP1erHmN7C2LkB6SkbcR+N2ap39SddTXzbTjRs39irgQ653Q9nzkbcTfrSuHryuhJX557a2GVdjSyFWiCHAdLNOOGvj8W+tja/T/c5DITssT7KFygXlWctno87UEkX1H4+vO7uSfm08vjRQlhrXd5Nf6TGpTGtOmM9q2OMdJ6mHGvke4Go9tJVPODK/CiO0fVMNbRShP+XnpeIi0/UUPRUegx8WSqiuKlkV6hj1yqdU+azhTmLu9ilXl73VYU11nbBn60P7ivqs4txIxmb2LG3EhTVqarMIUkG0q1q0ZBSc8ODFvq+WKjz4A2XxDxoaGh6Nx+OwfAdTh7kpMMKSXNbT03sbyu1Ik+tyEafJqVNugMvFSPcIjbRSnU1ZZ0IX1tTUXqvWYzEMVC5MAF9nI7DwSAc4nrWYkgVp9mXi+cxyK8DrA3PmpL5fWbCAZirAifBVxLRc46V61HmYiDSXWq4S9Nj30f1abHf4c8ck9ZUpjtPgnzv+qfonkAD1lnxJ0Mm2AriTYjjIspy0o5fK3wZCvgaOMGXGVb6spcSTLIETe7nqKEWeqDV4LvGxLKkG4yNlECg/NraWmDNxTROizcSUs5pE+r4A1QxYskuTcDJUi/RcZyzqJTJRYz4ARiNYgmPfLxa7Si3GXM7DxxQw1YpLUwI86rBUvR2nySvwQPrKi1fgNHFx9yTI4gDdL1ZPqD0Z1utPnn/+eT8lg8zfATATsPAescTHM/H54IW9RLL+1EWn6vLgCxhwD27bunVRsaUgy2sA+/OI5LFiywzRyXSY5iOZDIdYlCvkOBYT8xKwC5p8Zkf6Ij8e07+nZoF6IJGPY6IcI4ATVbpn7gEoTICvaPFIfzJ113Cer6cC75jm0RYVbXEcLBkxuH2oIU/2VpcPRXFJEbFBuJAsVx3FSTJAlahOdCKkf4mFW8qlf2qFaEo6gk62LwnlTLpoy01Iy5/MTLZFSvrXO357lhYWLZgbVDITd1U8bkW7JND7x2vWrCnHMpWi0ShAhHXjfLQgqQ+QZKJHhFj3AL9fKkgqg2wPoNqBpeU9gq0GAPny7LxRhCcBMAM/RuDHV59DyOirXX7ZhdIMZs9sa8hgcpo0ffr0+pF6LY8KA0EGecGu2n0WmX4HfUjGdMB0DLO5dAyXrdrnalKV5/1Ya/6WnSRiW7LjmbDQXzQ8cQJvxl0natyGHPrjRAxE/7JDZCWFevsialT4toFY/kNJzIKIjXzQN0toB1n+vW9eBRO3OU43MXX7VcFiMpakcUnxLFc3TNtRdjvlX0yZcmRTPGrySKwYTuGcgdmps2VefuEoE6231minL0w4xrmQ61cAyXetja/7BECuLLNr+hHA75WXcBAD/seSkL4QbNN5Y3WHDKhX8pcSw1bPZA6kwevggw9uhp7+syoa2TZSD6B/Hts3qXc4B9kWfet0nO0ipNZlIrAQ88V/TUR+PGg9BZKVJUPoTPDxWItII2Kbd9DHM8jnYsP69gIN7hP6vZtYS9a0+hQtPclxovplIWYKmDhlQzKZmpBK5z1YYpLj7NvUvvAzIqx/9DGYmnVjeiZW7T6WlTJmQRZW69JTn5BkLEkxgr3HPBItJ5xvWWIoU1OaUigVzgVZom5YGylr1kDpzWniYu8Q7FUM3BTaFlumsnSyCbPG1zmSPBdyKUhWDMjA/ymc/H+FiBfDDtpEY3tZEtbnK61Wkfp0gWQy2QOw60nHx+NeU+0+CcB+oEDd2mFP6UtEb2h2nIzsBehLzprsOHWNqS+vy6eCCkcosiE7T5j8TrV7ACrZY8G3fYyRkVmWzEc2zV14k/rGuYtvaeqPPIj6lkEuv8kqifF8y7Z9qKQJlbFqUv7qm9sX31rTF1mBfnYj6vDbs+whoXs3Ok7QVgqKVdCx9VqHqI4lx0L09hm2WzH5ecuKydBia0EtUnDLckx4Xu7RFOO8qssAABAASURBVCPEaQKNF+mN7s1UDJCKFCJFJkTLrfDJsPrm/vGPf0rN8KmMCv7oyf9LqY9mGH03UA8sxkwXGLClP+PAN/pSGpkwYUKvCI1PR09JQISBtrM35p6PqB6e4ebrDCajL0hf5L53XOmUPKHncayzZL/XpP/bR337oqejicgqZroPdP79n2nz67H+HCuRRTx/c43+tzPiJjNgKcK+y1PBiTjqGombTcyXqMdgvhhA9VFiylhRuQz5rs4qexs5Tmn9UegEGqwDhtCX0ceOoYA68HzX71ftYoWTW/NYxbCixTmhtzYcsmVAzzBl9i8HKXuZzBb4LvJ8FWzIIvV7Zjxvt3ETqaW/dshaMCjJCdltJRWoDPFrTHxePL7uTD0xRhWldRAUGK2Lx+OvvNGz+yghORsDe0ysTDxzapYrTXZWCwFtTbR79261PpKllS8/tf43SiMRXQLnLXXz6mKa40Yid4/ylFyX2YdhMMxJeSJ9/ecw1BTU99GX+HpynBw9AUQ8YMkkO/trKLVMAz8CoOYArKYNeG4Bv1QbDMTL+csbUfHS/WLJi1CHLSfnNC8h6sSznrV52byFg9sN6awxvTNb3Rf21ImJL2sCkQxwDhJ2W0E5gXVJlAK+wXS9TYLOBtpFKL8cuot0R2opNeZAJPBapnjPwhVpkOIlSFHWwlqYOGfOnJLlT5Uu009NTU0jM7+LiIc2iqmilwJfSRUwkbaX+lQ5kVQ8FR7Pn9eXtW9I9rv6ObFfFZIDIHWMSUR/s/8w/+6hEI8S856rrkrelV1mquNo+/osfXkHTJ3UqyVKb4zRwZyxNDVt0Mf274t5wHYwb5Q3MSxmIkZ0EPiPkj8BNAgLONMIYNGJh8brYsOqX2/1CnSOYyAfVsuUt2fJuwybTaSeODOxDTKpQ8PWaRgTQl45TaXujUSpMgAaLnlJJixvS7Ep088I2dQz8bXbtm25Gaez+rFTPMsIOY2gGEA62traelyE+V4SuhgsKtZRwXvIZe0/DiUWDknWsrunp8eg549rh8+WdtsNzmZm7kDaGvgCTt4pxr2xxXH8l80FSpaYtVNIbt7oODmA5/ZHg16/2ogBmkzX0W/7dWB1p+PZd4m4PmCbTTHi8AFCckEiEb1pMvZiR8ylcMGpOAy+tqnPXD/JcfL/Nr5wyTLmusKq214fllEFPezX6Gl23liUHrZmO6knwZySXVpq038fzkSeviVEO9C+KUPDkNcsRVJhx2RGtllNZb/qAFRfZrIPz2xru2bOnOJe9B6tFDhRbgBI34G9kQcBPPoKR17jjLaGAuWZfE9kC5QgMmjwQYJoNKqWqfrBlPG/dS6Z90w06Z4ISfRdVtz8HUD/n/sSkZtbHKfGn2LUqbvY0hmbY/Zn+ZyQnvmz0ew8Ef5DdjxWQwqy6in/wr5lhSzLVE1RAObnIv1mfipWmZ86Yv5qLGE+Xhn2RXAdAMs8wBsoF+1NLaMxFgV+IE1/GRi3uzqxOQavYU0b8lwrvVQ32KdyyikNE2/Vu3oDsNmkgdK8tOlf3JRWppLUjP0KWbBt65b/VCtzToVAU/nOamu73E32/zv0pn+a51FuJZ8Sz6bLhJLBEoM008axWExlVl9JUUvmrZ8cszEAJtMvhyn86b6E+eQwNKVmvwar6Zuudd/ded38X6YtiWwmWE3pdkF2UipsRHI+WAxF70JGZlmO8JCzlHmFayixcAiWDfjzd4j4O0L8AyLSLQs/ywpZcMKfKXW7goWeIvBXD3C4i4h00spYy4hnuyhozp06sC2RnT4mYbb9almq99Snn8KzAD4irqOsC9s4O3c4zq6NjrMTYW2frFyqY1NVm9gtwJDs5MGwnqIPBg1mCizJB2PF36Zj0JXjc27F11gc5Wwm+c22rVu/B2AZfslTHE+l0he52/TfSGD2vgEJlbQQwN7fGaLPIAc3/JbgWDjzdR5rrVplavnowcrIvFAn2j9oMJUgWS7pFsfZmqxyP8FMhU5bsYXAl7WUthxPoKb7ifi7g/47zPINAOBFhtx3d8Xcf+hatuDSrdc5vm8aDC5tfftTxLq5BzqOo3oBZpLnYsMl9xscGK3uWjrvQvWbl847r2vp/KPY0ElC/IqnAiQwUbPLydkIFu0sy91dg3V0Lp13LvTxHmY+Ggx8LTikt9mEOQH3MXdSo4ct4guW2FWtJ/YaAyw8tM8pNBQekL4Wh2N1EonVD0Rzf6HPrnQKNkPtHxHxrxwZAa4WTM4DIOUgeADtsMm7cIHoUfj8B0FSyQ5gIp8FaK7Ub2DOnj3bsw9RCkfsS86aObN1GZNdRTiZLaVsMK1gMPGPg/O9OSqHkP2aN2fYlG6OSDxNZYzpxEA7zbVy1Eh9pKrqjEmTJpWjrdJiZe7bHKfbuO6lSHgGPsi19SbMx4IyfdKxUWsWARC+OOgv7Fyy4IrNSxbc9vpSZw0syaRPmUxS1W7BdhjDZ5LSgZ1qEacjmTuLTkKZaDoAC39aOjyae2fUfQqW8NwgHtge+qegvKLSHcfq1ggPfLLQr8gkjIVD/TIqnRbBkpqIfUEcE2A9DXwYo5ayLmGb6avCkgkPktREXNmXrfUFSys0tAzHnoua3L5vxQ8yC7jJ6Zj1LgnILJisIAuvS8oU3caNG3snNzRcBcGOZ6LcmTpFUfIPAJOmoUFvSib6Hpw1a8ackjmgAMD2UzhmXIkl95VE7G+mU2mXEN0jZE5aG49/o9iS0JV+xf7fiHgqlXoJvcjsZgZvPB5PwL+m74qO1L/44oubVq8e+OZoqeIUQ7/pOucVnJKfBl11BtDH0E8CwSKgzIiTORKbRCSewQT5MnrNYS70XznxTITfSXpim4mPMOA41lS7alz4MsCYnuabUWKiWHk4oIhBHUF/Nx5QpDzJnY7Tw0L5S+kB5mLqAYZqwOWAJZPJWIfZYUpfBm2rPh0fulsyPASWU6ZMeRFgMBKAqgUYzcdA/hh80QcGA3uddgmT/LGtrfXbswctPx1869atW1s9ofY9QnIu5A0aKMgq3gnRkWL55zPb2m7HwUxRYNPa2noIgPJhPB+sv/KAJOmHYYXOiac+kRZfQ0Vchx56aC3kuBK60v+FUvKfpQ5W8Yu3v31//0E9SLAn3vSUHABVABB5RvPcpTPGQnaxVidKzwkwALu3cd6iOfmeMWgD5Irtn6g6OCCvpGQFDfTPfCspzaMeoIztinR0ZHfDEd9tiUFuGWNnMD5mN+v9etBA3cZOjljxyiU2A3icFR4ohF7GpoH8/quj0HYWzqy6jYIUM+tgTJct5Y4ZXv4N5u/1AEzMvsFF5+DQZcaMGS3VVVW/YGL9m9N6JvpSf6Lv9wCEz7a0DPw3Qv1gRDy+/i4sEfW7l98HxwT8aF0tVHKBm+z/A+T8MLzOPh6eswHcANVbsIx5Gh3xnz0EI0vYQcT/D6D9rpfWrcv5WK3qBLLE1Csw4j4JfhrA+ggcJLX37u75E+S4nohG/PaBMD+ibUxvwgun0j+C2MFAX+LeHHiNyNmITAsoeDhbWpXvYd0sC6AnS66+5haUXVq6iK+FhXGlr9Ggz5fGLp86kUz48h+kGzX/QT4l31gkA345hTFJiRjPWLGGM5OKmxVOlxWyTfD5f/VDGHtbxZrMkt8QLkv0K4AJ9tEQKd1FSehiPMDjbW0zbsBAPw7+kIMOmj4DA1/d4Rj4p+PQ5YcRw7rvp6/aZNfSAqG+vU9t7R0odxwyUjLpEhGm/kVs5Ezw1w3/coCmfu3nPiZ774EHHtiMujJu4MvsfY9DD/rOpC+YZoiLCyRUbit0/Bs9PVfE4/HMDJUuDp3cakieVt/b05O6Q7ZVAOuVQrIEdDkyIl6Sw6B5AfXiNHWgGBrjAOj4iEp61NE2UJv3t2nuoo83tS/+tsd3LP4XWEKpds8p5ThJYr45Jy0rImLGZCkIMPzHrGpHFRQyvqfqI2RqR1iuqGJ6oFEU4ZgTmS3+VUo9ef9+H8v2LOtQWCeADAAqHyPcQgBaDWd7xn6lsX2ZcZvqoBhQrwrxcK9sZPPJD0ch5GFMfDkG+uPwq6xrnmYAgXoM/J8ChD6NQi3wfg6zlHzaMK0A4C7CcrlBiSCXflPyflhHZ4L32UiDlYbf0TkAIZ9gjMk53bSWDwHbMs36sklB/o3du0/D1sILuicL3h4H3RwsREeoV/3hPosG9iWhDyrDxd8Dk8yAMiQ3Q8dPV9STBIIb+sAH4b/k8SKnQk5fB+H161a9vplkvdaAP+GoUnkEp9hBFaLNZ7Q5TtHbVkF83tLpWa/zZOsBYNaAg69cjGHaxdZkAC8VFsrEB8sDC6R+MJy5WSz3zYQsoB3MsSKkA2skrxENssjcIDNhfye116cC6KsqmcxhAnUAxXY32f/vsH5O0WWq0gM0u3Egsjzp2oMAKPpNyfyHVbI9wfdiYrgmEo29d+3a9fcHgeQYCbqmu6fnrnRd2AKZDt19FHEdqJX2qKY8jq1RS8C/vdnoc5SnogAu+toQxoZ3HyyAfvhkqd/2BhXcshqex1ubwma/CpSlCkuMAx7OBUvhHnYHPoShpKkwDwGgpmFcTMVdPW5DDqvlzQCyTN9TYEvlwgL6LQb6tanI+P9Mg/Vz37YtW57AINeHT8n58ssvd8bj686wQicykX6xxo6/qCkJkioP5Ho/9lsX6mlxKnX8fnawseenwVr3g6OGb4I4FQcX1FHIFWqvVBvnF0aihdWdzE/XOHRu9V5JX+C1oRFWy5Mwme6tYFl6e7Cgif1VifZNYHvGwzNiWFeYPfmlYLVPU5+dDkzrrqqlDOBpWNOyaRBWoPSsKpnMlrjjZLb/sgW1EybsA6tNniIij4BIG2unS/s5UMzjsDKPya4cwP6rRNL9EBNfSiS61zqe8v6WhL5miY+HXArg2aKOR7gX8txUX9+UOXGvq6s5DrPnnPEQJl2n3oXM/+rdx+vHDHy3HkTfmxPC1om3lLBVq9ObUcaUwdeG/MBNB6se2Pl7pqCP407ERKYrrjJKuWewQh/TP3bwCoP2Uwvdm0FkWWC8ke/qM6i/MKxFIvY/5KHciyn1IYwMWKKT9WhaLlVALG+5nw2WpCfREPAaFPX96wCkj70T2igiHnn0n49haf4tyHs+wOHJsReMYPDQoyaSPBOn3LfF43Gd7Wi8L3TYnwnz91evHngPEgcuk8SSfjsS/WR8pQNIBHXw+tpeSu1TeyQUOwNpvmBJmPmRV1EHsFZg0wGdX8+GrqXzzwnyETFX5RcYjEdZrFoyg9G96ub9uC4eT4gbI/1R34M/47Ie+EZB5nU+r/mkiFJgKb51pfKzf5h2kuMkafBKWYrYxxyMFry5wjn9NQcstSQG/TPo1GchXJb3HMFnNG5jpKrqbD0ZD2ICeR+bPGXKiVgCHw8a/RAvbhV2QqvRAT64Nr7uxD+O0QeHi3oioUcaGqacC51kXpVgEexFc7legypKjCAiJpM5mafca2rSRG6c5DgE48FQAAAHtklEQVQ5oDS1fcnBRHwTBV8Vt+TtwGD2jBMifo4KXDbW75ng0+TCNDMd3rvu/Du/59GlsbGyrMXJ/QBKU8fiI4llvl8ZTROJ+ravvtIkRMXhk/47CWWW5cUnLSs7EzR5rxn5dAKitWtf/h0b+QpKFScQCCvg1gjxGdj/y0F3v3rUisIS+MmX4uvei/2Ib4EmAxYIl9NtZsiEU+6PAJAK/TleOesshpfumT4AuU5TXaQLzGxt/QLM348j7tvOSB9TF6tKauf3XToz0ceqE9E/NM5dvKCxY+GX9fUil+x/QMB6eD+3q7oqOfzk6FeyhDRj5J/8ya3vF9HTtJ2Oo8t0X+uHhYPe20wXf1PeWf8kOEByTBDH9CXMH5rnLr66uWPhxfrvK0hkJcj999GFtm5e1h5Hvse5+xCW0rlWn4conZD1p46ZJJ+0dF72nZP9OdgTOIjq6xsfYmNPRuEN8BZ+LJ0C5RcBSKUOBtvQ0HiZFToRIKF7Sf57KKU/yXYh0q++HLs2Hl+ePjgpnU0lSuieLS/tTfSfk5YLS++YvtsKHegL7ZWodEQ8NzpOLywJncwC+pO0MMu1AJNbieRLqMR3LwvpFtbBjSl+iFTMOY7BFoZn4x/1JYlN4H+oRH7avZoOZN+FaOqkPCs6O3+0YfA3NX8jfxAaLfOh8p6lM8fsY+hzBQwVni4sy9B2t8Co+TJYeXggTR0OVeRHGvDz2O/qprz9RD86TYMuMn/qqHH1mJg9aZqe72MTcgE5ECxXY89LLUwhPg8dd3U+o4rFhX4HsNOXuEsFypRIKjeszBcmT55yHvYyO5C4E37kTuhFJsb+E38N4O07042c+ahLbhYyF73R07PslVdeyVhsxtg56IwAHPI7mBh1paNhYGz0biEqMKCK4r7JSvKeoihHQTSVaCIGv99e6q6IcDH9KmBlJhOrElUH0OgvG8Ai2m8oCIio2CsiFMQfLMQDxp2Os50t67ZJEgSjcRsiHLkzkIHjQC5T3L+2EfJa935p3sq6NzqY3LPSA8EyTQOAeKZmwj4nMfEVSCvHe5hg4+s60TEXY//xvQC7UR/YrAbY68FLJFp1oJDMRY3FdG6QZdx2gO2lkOdQWJM/gB4w22XyxjvwCp7pMiH+R8j1ULZFObOt7RaxfB8EDFq+Imv83OvL2jcwybWQYKT67EX5uUGfUwPfsjnbH9XDJQ8/6H0HlmjeQZhDCRODZUNe0mCUG3jg4GowPtIbdweUjMWisX0D8opOjv0dBfEnYvblH6tO6srhRzTyaydbumzT0o6g/e0UZxHbmQoU/kkwG8/ELGy0bLJwUVGaHJJhwVKp9ZS8esKE22Dx6Z8e3o9uoK/raFY5/HYmehS8z4F5fr2CXDmYpnnonueECfvg1JzPhNxPIR2zEn6DXTdA8hEMiDOE+bZyyxNc7bA5Cva/ZUxa2B45E9sN3wJQpjuz0fdRsYS9Hs/4BXDy7chI3yNcdcwux37VbRAmLT+CRbmd6CPL+mP2oaKoR0skVt/x9XABWO/qraWMJe8hGEwwZF4fDObf0D7syzufsFBcgi30fZMRF4ZxodLD5210YFlh79CXUmhS/oGN0mkZkQj6Iek2WFLTivaMFYfwjbEa91fDlRHDw05WxLSDsj6EkcWzhwR5WQneoJd/UWCpjBQwYfE9B0vrDNfSsajsUiZ6gIjU2iyl0/diQANs5THwmC/ER3X37P4EeD+ZNfipnJfKDt6PCZmTYZFdiPqfjURsTkOiY+shya/YyEkAyTNB/xT8SK2fosTHs+ueFqwP1rt+MEJ1qaeoutwHMNKjkHcp/Fls7FGg1z3Tb+j2yOrVqVeDjP5N+8zW1vaI4VXQ5yWouAZ+j3YbHWdnV7W9jA2dKkQPwessbgOERjqrXu6xzB/R/y64zXF8+5tY8z9ESpvrwf81VzhBJV6iX6Px4Qc2a4NkQF7GuSxrybc8d6I9307pK8I95E+3UUifiXwvw/IE+ZQT4kREeBZlXwXqIH9ASZUWI3eRTx1I6+ztjx5MPpcezFTH3C+i32ILjxT4CgEbxmHKAr9HbOTYrurkdRsdgLQP3+ykqBsBhuS2M3nkpBdc269GBmVfrpvcQYZwcl+wvMeyLRos05WtxiBdv379Bixxv1nfMOU0K3QOCV1FxHcxkS6fMfhJO78KqV7DSJOnhOge0M61wudiaf8J8FgMQIqnl5FU4Qt1dcfj679rIu75iYToAMzUaIle6HftmWvXrl+tdJmMCgZcazswaM4SonPYyDkWuhRixPk03D+yNr7uRMjbAf+jtWtfftFPLnFNm4qIjnkn/DXj7S1J8F6TCpr2jmM7F89/sibmnkFC5xPL15Glk+8z6EfPIfwr3JeL8LWwEM7pirnnblkyT9OR5e+sJO/H4D433xvmi9zqhE5G/gUDUiNu8pF8Xqn4gOUUUGoouT/q/i5Fb8Qjk5XIvWlKU5WMB9FFJfmjNF3+3a2yy33KnUtGzrfW6FjMFClUh5t0n8kQ5gXchL3Jrw5Nq+pPArDyCgxGNwLwNi9d8K8AzZNhiX9F0L7M9Aiy9W/9n0Wbr0b4HhbuIDZnafsqyGa/E4n8QFeF9lQZCnkjpqO2JoVFOXw0TfMKlWUxN+cUIqL/DwAA//8PN64JAAAABklEQVQDAC4fJqtjL65qAAAAAElFTkSuQmCC" alt="CodeSparrow" width="331" height="93">
  <span class="om-sample" id="dataMode">Attendance · loading</span>
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
const initialSeats=()=>deskConfig.map(d=>({...d,name:'',role:'',status:'free',time:'',paycode:'',hair:'short',gender:''}));
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
 <ellipse cx="2" cy="63" rx="70" ry="25" fill="${free?'#748a99':present?'#6d715b':'#c94e62'}" opacity="${present?'.10':'.22'}"/>
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
window.OfficeMap={setTopView(){isometric=false;renderArchitecture();renderSeats();},normalizePaycode,getData:()=>JSON.parse(JSON.stringify(seats)),fit,load({users=[],punches=[],allocations=[],date=today}={}){const userMap=new Map(users.map(u=>[String(u.id),u])),allocationsMap=new Map(allocations.map(a=>[String(a.desk_id),a.user_id])),punchesMap=new Map();punches.forEach(p=>{const key=normalizePaycode(p.employee_no),info=punchInfo(p.punched_at);if(key&&info?.day===date&&(!punchesMap.has(key)||info.stamp<punchesMap.get(key).stamp))punchesMap.set(key,info)});seats=deskConfig.map(d=>{const u=userMap.get(String(allocationsMap.get(d.id)));if(!u)return {...d,name:'',role:'',paycode:'',status:'free',time:'',hair:'short'};const punch=punchesMap.get(normalizePaycode(u.paycode));return {...d,name:String(u.name||'Team member'),role:String(u.role||'Team member'),paycode:String(u.paycode??''),status:punch?'present':'absent',time:punch?.time||'',gender:['female','f'].includes(String(u.gender||'').trim().toLowerCase())?'female':['male','m'].includes(String(u.gender||'').trim().toLowerCase())?'male':'',hair:['female','f'].includes(String(u.gender||'').trim().toLowerCase())?'long':'short'}});isDemo=false;selectedId=null;if($('#deskDialog').open)closeDetails();$('#dataMode').textContent='Attendance · '+date;refresh();}};
renderArchitecture();renderSeats(true);updateCamera();if(motionEnabled){animate($('#architecture'),{opacity:[0,1]},{duration:.85,ease:'easeOut'});animate($('.om-logo'),{opacity:[0,1],y:[-6,0]},{duration:.6,ease:'easeOut'});}setMotionButton();
function setMotionButton(){$('#motionToggle').setAttribute('aria-pressed',String(!motionEnabled));$('#motionToggle').setAttribute('aria-label',motionEnabled?'Pause animations':'Resume animations')}
})();
</script>
<script>
(()=>{var Yn={LEFT:0,MIDDLE:1,RIGHT:2,ROTATE:0,DOLLY:1,PAN:2},Zn={ROTATE:0,PAN:1,DOLLY_PAN:2,DOLLY_ROTATE:3},wc=0,ja=1,Ac=2;var Qa=1,ao=2,mn=3,An=0,Ue=1,gn=2,Cn=0,oi=1,tl=2,el=3,nl=4,Cc=5,Vn=100,Rc=101,Ic=102,Pc=103,Dc=104,Lc=200,Uc=201,Nc=202,Fc=203,Lr=204,Ur=205,Oc=206,Bc=207,zc=208,kc=209,Vc=210,Hc=211,Gc=212,Wc=213,Xc=214,lo=0,co=1,ho=2,ai=3,uo=4,fo=5,po=6,mo=7,il=0,qc=1,Yc=2,Rn=0,Zc=1,Jc=2,$c=3,go=4,Kc=5,jc=6,Qc=7;var sl=300,fi=301,pi=302,_o=303,xo=304,Ks=306,Nr=1e3,kn=1001,Fr=1002,Ke=1003,th=1004;var js=1005;var rn=1006,yo=1007;var Jn=1008;var cn=1009,rl=1010,ol=1011,ts=1012,vo=1013,$n=1014,_n=1015,es=1016,Mo=1017,So=1018,ns=1020,al=35902,ll=35899,cl=1021,hl=1022,Qe=1023,ki=1026,is=1027,ul=1028,bo=1029,dl=1030,Eo=1031;var To=1033,Qs=33776,tr=33777,er=33778,nr=33779,wo=35840,Ao=35841,Co=35842,Ro=35843,Io=36196,Po=37492,Do=37496,Lo=37808,Uo=37809,No=37810,Fo=37811,Oo=37812,Bo=37813,zo=37814,ko=37815,Vo=37816,Ho=37817,Go=37818,Wo=37819,Xo=37820,qo=37821,Yo=36492,Zo=36494,Jo=36495,$o=36283,Ko=36284,jo=36285,Qo=36286;var Ms=2300,Or=2301,Dr=2302,za=2400,ka=2401,Va=2402;var eh=3200,nh=3201;var fl=0,ih=1,In="",Le="srgb",li="srgb-linear",Ss="linear",te="srgb";var si=7680;var Ha=519,sh=512,rh=513,oh=514,pl=515,ah=516,lh=517,ch=518,hh=519,Ga=35044;var ml="300 es",sn=2e3,bs=2001;var fn=class{addEventListener(t,e){this._listeners===void 0&&(this._listeners={});let n=this._listeners;n[t]===void 0&&(n[t]=[]),n[t].indexOf(e)===-1&&n[t].push(e)}hasEventListener(t,e){let n=this._listeners;return n===void 0?!1:n[t]!==void 0&&n[t].indexOf(e)!==-1}removeEventListener(t,e){let n=this._listeners;if(n===void 0)return;let s=n[t];if(s!==void 0){let r=s.indexOf(e);r!==-1&&s.splice(r,1)}}dispatchEvent(t){let e=this._listeners;if(e===void 0)return;let n=e[t.type];if(n!==void 0){t.target=this;let s=n.slice(0);for(let r=0,o=s.length;r<o;r++)s[r].call(this,t);t.target=null}}},Ae=["00","01","02","03","04","05","06","07","08","09","0a","0b","0c","0d","0e","0f","10","11","12","13","14","15","16","17","18","19","1a","1b","1c","1d","1e","1f","20","21","22","23","24","25","26","27","28","29","2a","2b","2c","2d","2e","2f","30","31","32","33","34","35","36","37","38","39","3a","3b","3c","3d","3e","3f","40","41","42","43","44","45","46","47","48","49","4a","4b","4c","4d","4e","4f","50","51","52","53","54","55","56","57","58","59","5a","5b","5c","5d","5e","5f","60","61","62","63","64","65","66","67","68","69","6a","6b","6c","6d","6e","6f","70","71","72","73","74","75","76","77","78","79","7a","7b","7c","7d","7e","7f","80","81","82","83","84","85","86","87","88","89","8a","8b","8c","8d","8e","8f","90","91","92","93","94","95","96","97","98","99","9a","9b","9c","9d","9e","9f","a0","a1","a2","a3","a4","a5","a6","a7","a8","a9","aa","ab","ac","ad","ae","af","b0","b1","b2","b3","b4","b5","b6","b7","b8","b9","ba","bb","bc","bd","be","bf","c0","c1","c2","c3","c4","c5","c6","c7","c8","c9","ca","cb","cc","cd","ce","cf","d0","d1","d2","d3","d4","d5","d6","d7","d8","d9","da","db","dc","dd","de","df","e0","e1","e2","e3","e4","e5","e6","e7","e8","e9","ea","eb","ec","ed","ee","ef","f0","f1","f2","f3","f4","f5","f6","f7","f8","f9","fa","fb","fc","fd","fe","ff"],tc=1234567,_s=Math.PI/180,Vi=180/Math.PI;function mi(){let i=Math.random()*4294967295|0,t=Math.random()*4294967295|0,e=Math.random()*4294967295|0,n=Math.random()*4294967295|0;return(Ae[i&255]+Ae[i>>8&255]+Ae[i>>16&255]+Ae[i>>24&255]+"-"+Ae[t&255]+Ae[t>>8&255]+"-"+Ae[t>>16&15|64]+Ae[t>>24&255]+"-"+Ae[e&63|128]+Ae[e>>8&255]+"-"+Ae[e>>16&255]+Ae[e>>24&255]+Ae[n&255]+Ae[n>>8&255]+Ae[n>>16&255]+Ae[n>>24&255]).toLowerCase()}function Gt(i,t,e){return Math.max(t,Math.min(e,i))}function gl(i,t){return(i%t+t)%t}function yu(i,t,e,n,s){return n+(i-t)*(s-n)/(e-t)}function vu(i,t,e){return i!==t?(e-i)/(t-i):0}function xs(i,t,e){return(1-e)*i+e*t}function Mu(i,t,e,n){return xs(i,t,1-Math.exp(-e*n))}function Su(i,t=1){return t-Math.abs(gl(i,t*2)-t)}function bu(i,t,e){return i<=t?0:i>=e?1:(i=(i-t)/(e-t),i*i*(3-2*i))}function Eu(i,t,e){return i<=t?0:i>=e?1:(i=(i-t)/(e-t),i*i*i*(i*(i*6-15)+10))}function Tu(i,t){return i+Math.floor(Math.random()*(t-i+1))}function wu(i,t){return i+Math.random()*(t-i)}function Au(i){return i*(.5-Math.random())}function Cu(i){i!==void 0&&(tc=i);let t=tc+=1831565813;return t=Math.imul(t^t>>>15,t|1),t^=t+Math.imul(t^t>>>7,t|61),((t^t>>>14)>>>0)/4294967296}function Ru(i){return i*_s}function Iu(i){return i*Vi}function Pu(i){return(i&i-1)===0&&i!==0}function Du(i){return Math.pow(2,Math.ceil(Math.log(i)/Math.LN2))}function Lu(i){return Math.pow(2,Math.floor(Math.log(i)/Math.LN2))}function Uu(i,t,e,n,s){let r=Math.cos,o=Math.sin,a=r(e/2),l=o(e/2),c=r((t+n)/2),h=o((t+n)/2),u=r((t-n)/2),f=o((t-n)/2),p=r((n-t)/2),g=o((n-t)/2);switch(s){case"XYX":i.set(a*h,l*u,l*f,a*c);break;case"YZY":i.set(l*f,a*h,l*u,a*c);break;case"ZXZ":i.set(l*u,l*f,a*h,a*c);break;case"XZX":i.set(a*h,l*g,l*p,a*c);break;case"YXY":i.set(l*p,a*h,l*g,a*c);break;case"ZYZ":i.set(l*g,l*p,a*h,a*c);break;default:console.warn("THREE.MathUtils: .setQuaternionFromProperEuler() encountered an unknown order: "+s)}}function Bi(i,t){switch(t.constructor){case Float32Array:return i;case Uint32Array:return i/4294967295;case Uint16Array:return i/65535;case Uint8Array:return i/255;case Int32Array:return Math.max(i/2147483647,-1);case Int16Array:return Math.max(i/32767,-1);case Int8Array:return Math.max(i/127,-1);default:throw new Error("Invalid component type.")}}function De(i,t){switch(t.constructor){case Float32Array:return i;case Uint32Array:return Math.round(i*4294967295);case Uint16Array:return Math.round(i*65535);case Uint8Array:return Math.round(i*255);case Int32Array:return Math.round(i*2147483647);case Int16Array:return Math.round(i*32767);case Int8Array:return Math.round(i*127);default:throw new Error("Invalid component type.")}}var _l={DEG2RAD:_s,RAD2DEG:Vi,generateUUID:mi,clamp:Gt,euclideanModulo:gl,mapLinear:yu,inverseLerp:vu,lerp:xs,damp:Mu,pingpong:Su,smoothstep:bu,smootherstep:Eu,randInt:Tu,randFloat:wu,randFloatSpread:Au,seededRandom:Cu,degToRad:Ru,radToDeg:Iu,isPowerOfTwo:Pu,ceilPowerOfTwo:Du,floorPowerOfTwo:Lu,setQuaternionFromProperEuler:Uu,normalize:De,denormalize:Bi},at=class i{constructor(t=0,e=0){i.prototype.isVector2=!0,this.x=t,this.y=e}get width(){return this.x}set width(t){this.x=t}get height(){return this.y}set height(t){this.y=t}set(t,e){return this.x=t,this.y=e,this}setScalar(t){return this.x=t,this.y=t,this}setX(t){return this.x=t,this}setY(t){return this.y=t,this}setComponent(t,e){switch(t){case 0:this.x=e;break;case 1:this.y=e;break;default:throw new Error("index is out of range: "+t)}return this}getComponent(t){switch(t){case 0:return this.x;case 1:return this.y;default:throw new Error("index is out of range: "+t)}}clone(){return new this.constructor(this.x,this.y)}copy(t){return this.x=t.x,this.y=t.y,this}add(t){return this.x+=t.x,this.y+=t.y,this}addScalar(t){return this.x+=t,this.y+=t,this}addVectors(t,e){return this.x=t.x+e.x,this.y=t.y+e.y,this}addScaledVector(t,e){return this.x+=t.x*e,this.y+=t.y*e,this}sub(t){return this.x-=t.x,this.y-=t.y,this}subScalar(t){return this.x-=t,this.y-=t,this}subVectors(t,e){return this.x=t.x-e.x,this.y=t.y-e.y,this}multiply(t){return this.x*=t.x,this.y*=t.y,this}multiplyScalar(t){return this.x*=t,this.y*=t,this}divide(t){return this.x/=t.x,this.y/=t.y,this}divideScalar(t){return this.multiplyScalar(1/t)}applyMatrix3(t){let e=this.x,n=this.y,s=t.elements;return this.x=s[0]*e+s[3]*n+s[6],this.y=s[1]*e+s[4]*n+s[7],this}min(t){return this.x=Math.min(this.x,t.x),this.y=Math.min(this.y,t.y),this}max(t){return this.x=Math.max(this.x,t.x),this.y=Math.max(this.y,t.y),this}clamp(t,e){return this.x=Gt(this.x,t.x,e.x),this.y=Gt(this.y,t.y,e.y),this}clampScalar(t,e){return this.x=Gt(this.x,t,e),this.y=Gt(this.y,t,e),this}clampLength(t,e){let n=this.length();return this.divideScalar(n||1).multiplyScalar(Gt(n,t,e))}floor(){return this.x=Math.floor(this.x),this.y=Math.floor(this.y),this}ceil(){return this.x=Math.ceil(this.x),this.y=Math.ceil(this.y),this}round(){return this.x=Math.round(this.x),this.y=Math.round(this.y),this}roundToZero(){return this.x=Math.trunc(this.x),this.y=Math.trunc(this.y),this}negate(){return this.x=-this.x,this.y=-this.y,this}dot(t){return this.x*t.x+this.y*t.y}cross(t){return this.x*t.y-this.y*t.x}lengthSq(){return this.x*this.x+this.y*this.y}length(){return Math.sqrt(this.x*this.x+this.y*this.y)}manhattanLength(){return Math.abs(this.x)+Math.abs(this.y)}normalize(){return this.divideScalar(this.length()||1)}angle(){return Math.atan2(-this.y,-this.x)+Math.PI}angleTo(t){let e=Math.sqrt(this.lengthSq()*t.lengthSq());if(e===0)return Math.PI/2;let n=this.dot(t)/e;return Math.acos(Gt(n,-1,1))}distanceTo(t){return Math.sqrt(this.distanceToSquared(t))}distanceToSquared(t){let e=this.x-t.x,n=this.y-t.y;return e*e+n*n}manhattanDistanceTo(t){return Math.abs(this.x-t.x)+Math.abs(this.y-t.y)}setLength(t){return this.normalize().multiplyScalar(t)}lerp(t,e){return this.x+=(t.x-this.x)*e,this.y+=(t.y-this.y)*e,this}lerpVectors(t,e,n){return this.x=t.x+(e.x-t.x)*n,this.y=t.y+(e.y-t.y)*n,this}equals(t){return t.x===this.x&&t.y===this.y}fromArray(t,e=0){return this.x=t[e],this.y=t[e+1],this}toArray(t=[],e=0){return t[e]=this.x,t[e+1]=this.y,t}fromBufferAttribute(t,e){return this.x=t.getX(e),this.y=t.getY(e),this}rotateAround(t,e){let n=Math.cos(e),s=Math.sin(e),r=this.x-t.x,o=this.y-t.y;return this.x=r*n-o*s+t.x,this.y=r*s+o*n+t.y,this}random(){return this.x=Math.random(),this.y=Math.random(),this}*[Symbol.iterator](){yield this.x,yield this.y}},je=class{constructor(t=0,e=0,n=0,s=1){this.isQuaternion=!0,this._x=t,this._y=e,this._z=n,this._w=s}static slerpFlat(t,e,n,s,r,o,a){let l=n[s+0],c=n[s+1],h=n[s+2],u=n[s+3],f=r[o+0],p=r[o+1],g=r[o+2],y=r[o+3];if(a===0){t[e+0]=l,t[e+1]=c,t[e+2]=h,t[e+3]=u;return}if(a===1){t[e+0]=f,t[e+1]=p,t[e+2]=g,t[e+3]=y;return}if(u!==y||l!==f||c!==p||h!==g){let m=1-a,d=l*f+c*p+h*g+u*y,w=d>=0?1:-1,E=1-d*d;if(E>Number.EPSILON){let C=Math.sqrt(E),A=Math.atan2(C,d*w);m=Math.sin(m*A)/C,a=Math.sin(a*A)/C}let v=a*w;if(l=l*m+f*v,c=c*m+p*v,h=h*m+g*v,u=u*m+y*v,m===1-a){let C=1/Math.sqrt(l*l+c*c+h*h+u*u);l*=C,c*=C,h*=C,u*=C}}t[e]=l,t[e+1]=c,t[e+2]=h,t[e+3]=u}static multiplyQuaternionsFlat(t,e,n,s,r,o){let a=n[s],l=n[s+1],c=n[s+2],h=n[s+3],u=r[o],f=r[o+1],p=r[o+2],g=r[o+3];return t[e]=a*g+h*u+l*p-c*f,t[e+1]=l*g+h*f+c*u-a*p,t[e+2]=c*g+h*p+a*f-l*u,t[e+3]=h*g-a*u-l*f-c*p,t}get x(){return this._x}set x(t){this._x=t,this._onChangeCallback()}get y(){return this._y}set y(t){this._y=t,this._onChangeCallback()}get z(){return this._z}set z(t){this._z=t,this._onChangeCallback()}get w(){return this._w}set w(t){this._w=t,this._onChangeCallback()}set(t,e,n,s){return this._x=t,this._y=e,this._z=n,this._w=s,this._onChangeCallback(),this}clone(){return new this.constructor(this._x,this._y,this._z,this._w)}copy(t){return this._x=t.x,this._y=t.y,this._z=t.z,this._w=t.w,this._onChangeCallback(),this}setFromEuler(t,e=!0){let n=t._x,s=t._y,r=t._z,o=t._order,a=Math.cos,l=Math.sin,c=a(n/2),h=a(s/2),u=a(r/2),f=l(n/2),p=l(s/2),g=l(r/2);switch(o){case"XYZ":this._x=f*h*u+c*p*g,this._y=c*p*u-f*h*g,this._z=c*h*g+f*p*u,this._w=c*h*u-f*p*g;break;case"YXZ":this._x=f*h*u+c*p*g,this._y=c*p*u-f*h*g,this._z=c*h*g-f*p*u,this._w=c*h*u+f*p*g;break;case"ZXY":this._x=f*h*u-c*p*g,this._y=c*p*u+f*h*g,this._z=c*h*g+f*p*u,this._w=c*h*u-f*p*g;break;case"ZYX":this._x=f*h*u-c*p*g,this._y=c*p*u+f*h*g,this._z=c*h*g-f*p*u,this._w=c*h*u+f*p*g;break;case"YZX":this._x=f*h*u+c*p*g,this._y=c*p*u+f*h*g,this._z=c*h*g-f*p*u,this._w=c*h*u-f*p*g;break;case"XZY":this._x=f*h*u-c*p*g,this._y=c*p*u-f*h*g,this._z=c*h*g+f*p*u,this._w=c*h*u+f*p*g;break;default:console.warn("THREE.Quaternion: .setFromEuler() encountered an unknown order: "+o)}return e===!0&&this._onChangeCallback(),this}setFromAxisAngle(t,e){let n=e/2,s=Math.sin(n);return this._x=t.x*s,this._y=t.y*s,this._z=t.z*s,this._w=Math.cos(n),this._onChangeCallback(),this}setFromRotationMatrix(t){let e=t.elements,n=e[0],s=e[4],r=e[8],o=e[1],a=e[5],l=e[9],c=e[2],h=e[6],u=e[10],f=n+a+u;if(f>0){let p=.5/Math.sqrt(f+1);this._w=.25/p,this._x=(h-l)*p,this._y=(r-c)*p,this._z=(o-s)*p}else if(n>a&&n>u){let p=2*Math.sqrt(1+n-a-u);this._w=(h-l)/p,this._x=.25*p,this._y=(s+o)/p,this._z=(r+c)/p}else if(a>u){let p=2*Math.sqrt(1+a-n-u);this._w=(r-c)/p,this._x=(s+o)/p,this._y=.25*p,this._z=(l+h)/p}else{let p=2*Math.sqrt(1+u-n-a);this._w=(o-s)/p,this._x=(r+c)/p,this._y=(l+h)/p,this._z=.25*p}return this._onChangeCallback(),this}setFromUnitVectors(t,e){let n=t.dot(e)+1;return n<1e-8?(n=0,Math.abs(t.x)>Math.abs(t.z)?(this._x=-t.y,this._y=t.x,this._z=0,this._w=n):(this._x=0,this._y=-t.z,this._z=t.y,this._w=n)):(this._x=t.y*e.z-t.z*e.y,this._y=t.z*e.x-t.x*e.z,this._z=t.x*e.y-t.y*e.x,this._w=n),this.normalize()}angleTo(t){return 2*Math.acos(Math.abs(Gt(this.dot(t),-1,1)))}rotateTowards(t,e){let n=this.angleTo(t);if(n===0)return this;let s=Math.min(1,e/n);return this.slerp(t,s),this}identity(){return this.set(0,0,0,1)}invert(){return this.conjugate()}conjugate(){return this._x*=-1,this._y*=-1,this._z*=-1,this._onChangeCallback(),this}dot(t){return this._x*t._x+this._y*t._y+this._z*t._z+this._w*t._w}lengthSq(){return this._x*this._x+this._y*this._y+this._z*this._z+this._w*this._w}length(){return Math.sqrt(this._x*this._x+this._y*this._y+this._z*this._z+this._w*this._w)}normalize(){let t=this.length();return t===0?(this._x=0,this._y=0,this._z=0,this._w=1):(t=1/t,this._x=this._x*t,this._y=this._y*t,this._z=this._z*t,this._w=this._w*t),this._onChangeCallback(),this}multiply(t){return this.multiplyQuaternions(this,t)}premultiply(t){return this.multiplyQuaternions(t,this)}multiplyQuaternions(t,e){let n=t._x,s=t._y,r=t._z,o=t._w,a=e._x,l=e._y,c=e._z,h=e._w;return this._x=n*h+o*a+s*c-r*l,this._y=s*h+o*l+r*a-n*c,this._z=r*h+o*c+n*l-s*a,this._w=o*h-n*a-s*l-r*c,this._onChangeCallback(),this}slerp(t,e){if(e===0)return this;if(e===1)return this.copy(t);let n=this._x,s=this._y,r=this._z,o=this._w,a=o*t._w+n*t._x+s*t._y+r*t._z;if(a<0?(this._w=-t._w,this._x=-t._x,this._y=-t._y,this._z=-t._z,a=-a):this.copy(t),a>=1)return this._w=o,this._x=n,this._y=s,this._z=r,this;let l=1-a*a;if(l<=Number.EPSILON){let p=1-e;return this._w=p*o+e*this._w,this._x=p*n+e*this._x,this._y=p*s+e*this._y,this._z=p*r+e*this._z,this.normalize(),this}let c=Math.sqrt(l),h=Math.atan2(c,a),u=Math.sin((1-e)*h)/c,f=Math.sin(e*h)/c;return this._w=o*u+this._w*f,this._x=n*u+this._x*f,this._y=s*u+this._y*f,this._z=r*u+this._z*f,this._onChangeCallback(),this}slerpQuaternions(t,e,n){return this.copy(t).slerp(e,n)}random(){let t=2*Math.PI*Math.random(),e=2*Math.PI*Math.random(),n=Math.random(),s=Math.sqrt(1-n),r=Math.sqrt(n);return this.set(s*Math.sin(t),s*Math.cos(t),r*Math.sin(e),r*Math.cos(e))}equals(t){return t._x===this._x&&t._y===this._y&&t._z===this._z&&t._w===this._w}fromArray(t,e=0){return this._x=t[e],this._y=t[e+1],this._z=t[e+2],this._w=t[e+3],this._onChangeCallback(),this}toArray(t=[],e=0){return t[e]=this._x,t[e+1]=this._y,t[e+2]=this._z,t[e+3]=this._w,t}fromBufferAttribute(t,e){return this._x=t.getX(e),this._y=t.getY(e),this._z=t.getZ(e),this._w=t.getW(e),this._onChangeCallback(),this}toJSON(){return this.toArray()}_onChange(t){return this._onChangeCallback=t,this}_onChangeCallback(){}*[Symbol.iterator](){yield this._x,yield this._y,yield this._z,yield this._w}},D=class i{constructor(t=0,e=0,n=0){i.prototype.isVector3=!0,this.x=t,this.y=e,this.z=n}set(t,e,n){return n===void 0&&(n=this.z),this.x=t,this.y=e,this.z=n,this}setScalar(t){return this.x=t,this.y=t,this.z=t,this}setX(t){return this.x=t,this}setY(t){return this.y=t,this}setZ(t){return this.z=t,this}setComponent(t,e){switch(t){case 0:this.x=e;break;case 1:this.y=e;break;case 2:this.z=e;break;default:throw new Error("index is out of range: "+t)}return this}getComponent(t){switch(t){case 0:return this.x;case 1:return this.y;case 2:return this.z;default:throw new Error("index is out of range: "+t)}}clone(){return new this.constructor(this.x,this.y,this.z)}copy(t){return this.x=t.x,this.y=t.y,this.z=t.z,this}add(t){return this.x+=t.x,this.y+=t.y,this.z+=t.z,this}addScalar(t){return this.x+=t,this.y+=t,this.z+=t,this}addVectors(t,e){return this.x=t.x+e.x,this.y=t.y+e.y,this.z=t.z+e.z,this}addScaledVector(t,e){return this.x+=t.x*e,this.y+=t.y*e,this.z+=t.z*e,this}sub(t){return this.x-=t.x,this.y-=t.y,this.z-=t.z,this}subScalar(t){return this.x-=t,this.y-=t,this.z-=t,this}subVectors(t,e){return this.x=t.x-e.x,this.y=t.y-e.y,this.z=t.z-e.z,this}multiply(t){return this.x*=t.x,this.y*=t.y,this.z*=t.z,this}multiplyScalar(t){return this.x*=t,this.y*=t,this.z*=t,this}multiplyVectors(t,e){return this.x=t.x*e.x,this.y=t.y*e.y,this.z=t.z*e.z,this}applyEuler(t){return this.applyQuaternion(ec.setFromEuler(t))}applyAxisAngle(t,e){return this.applyQuaternion(ec.setFromAxisAngle(t,e))}applyMatrix3(t){let e=this.x,n=this.y,s=this.z,r=t.elements;return this.x=r[0]*e+r[3]*n+r[6]*s,this.y=r[1]*e+r[4]*n+r[7]*s,this.z=r[2]*e+r[5]*n+r[8]*s,this}applyNormalMatrix(t){return this.applyMatrix3(t).normalize()}applyMatrix4(t){let e=this.x,n=this.y,s=this.z,r=t.elements,o=1/(r[3]*e+r[7]*n+r[11]*s+r[15]);return this.x=(r[0]*e+r[4]*n+r[8]*s+r[12])*o,this.y=(r[1]*e+r[5]*n+r[9]*s+r[13])*o,this.z=(r[2]*e+r[6]*n+r[10]*s+r[14])*o,this}applyQuaternion(t){let e=this.x,n=this.y,s=this.z,r=t.x,o=t.y,a=t.z,l=t.w,c=2*(o*s-a*n),h=2*(a*e-r*s),u=2*(r*n-o*e);return this.x=e+l*c+o*u-a*h,this.y=n+l*h+a*c-r*u,this.z=s+l*u+r*h-o*c,this}project(t){return this.applyMatrix4(t.matrixWorldInverse).applyMatrix4(t.projectionMatrix)}unproject(t){return this.applyMatrix4(t.projectionMatrixInverse).applyMatrix4(t.matrixWorld)}transformDirection(t){let e=this.x,n=this.y,s=this.z,r=t.elements;return this.x=r[0]*e+r[4]*n+r[8]*s,this.y=r[1]*e+r[5]*n+r[9]*s,this.z=r[2]*e+r[6]*n+r[10]*s,this.normalize()}divide(t){return this.x/=t.x,this.y/=t.y,this.z/=t.z,this}divideScalar(t){return this.multiplyScalar(1/t)}min(t){return this.x=Math.min(this.x,t.x),this.y=Math.min(this.y,t.y),this.z=Math.min(this.z,t.z),this}max(t){return this.x=Math.max(this.x,t.x),this.y=Math.max(this.y,t.y),this.z=Math.max(this.z,t.z),this}clamp(t,e){return this.x=Gt(this.x,t.x,e.x),this.y=Gt(this.y,t.y,e.y),this.z=Gt(this.z,t.z,e.z),this}clampScalar(t,e){return this.x=Gt(this.x,t,e),this.y=Gt(this.y,t,e),this.z=Gt(this.z,t,e),this}clampLength(t,e){let n=this.length();return this.divideScalar(n||1).multiplyScalar(Gt(n,t,e))}floor(){return this.x=Math.floor(this.x),this.y=Math.floor(this.y),this.z=Math.floor(this.z),this}ceil(){return this.x=Math.ceil(this.x),this.y=Math.ceil(this.y),this.z=Math.ceil(this.z),this}round(){return this.x=Math.round(this.x),this.y=Math.round(this.y),this.z=Math.round(this.z),this}roundToZero(){return this.x=Math.trunc(this.x),this.y=Math.trunc(this.y),this.z=Math.trunc(this.z),this}negate(){return this.x=-this.x,this.y=-this.y,this.z=-this.z,this}dot(t){return this.x*t.x+this.y*t.y+this.z*t.z}lengthSq(){return this.x*this.x+this.y*this.y+this.z*this.z}length(){return Math.sqrt(this.x*this.x+this.y*this.y+this.z*this.z)}manhattanLength(){return Math.abs(this.x)+Math.abs(this.y)+Math.abs(this.z)}normalize(){return this.divideScalar(this.length()||1)}setLength(t){return this.normalize().multiplyScalar(t)}lerp(t,e){return this.x+=(t.x-this.x)*e,this.y+=(t.y-this.y)*e,this.z+=(t.z-this.z)*e,this}lerpVectors(t,e,n){return this.x=t.x+(e.x-t.x)*n,this.y=t.y+(e.y-t.y)*n,this.z=t.z+(e.z-t.z)*n,this}cross(t){return this.crossVectors(this,t)}crossVectors(t,e){let n=t.x,s=t.y,r=t.z,o=e.x,a=e.y,l=e.z;return this.x=s*l-r*a,this.y=r*o-n*l,this.z=n*a-s*o,this}projectOnVector(t){let e=t.lengthSq();if(e===0)return this.set(0,0,0);let n=t.dot(this)/e;return this.copy(t).multiplyScalar(n)}projectOnPlane(t){return pa.copy(this).projectOnVector(t),this.sub(pa)}reflect(t){return this.sub(pa.copy(t).multiplyScalar(2*this.dot(t)))}angleTo(t){let e=Math.sqrt(this.lengthSq()*t.lengthSq());if(e===0)return Math.PI/2;let n=this.dot(t)/e;return Math.acos(Gt(n,-1,1))}distanceTo(t){return Math.sqrt(this.distanceToSquared(t))}distanceToSquared(t){let e=this.x-t.x,n=this.y-t.y,s=this.z-t.z;return e*e+n*n+s*s}manhattanDistanceTo(t){return Math.abs(this.x-t.x)+Math.abs(this.y-t.y)+Math.abs(this.z-t.z)}setFromSpherical(t){return this.setFromSphericalCoords(t.radius,t.phi,t.theta)}setFromSphericalCoords(t,e,n){let s=Math.sin(e)*t;return this.x=s*Math.sin(n),this.y=Math.cos(e)*t,this.z=s*Math.cos(n),this}setFromCylindrical(t){return this.setFromCylindricalCoords(t.radius,t.theta,t.y)}setFromCylindricalCoords(t,e,n){return this.x=t*Math.sin(e),this.y=n,this.z=t*Math.cos(e),this}setFromMatrixPosition(t){let e=t.elements;return this.x=e[12],this.y=e[13],this.z=e[14],this}setFromMatrixScale(t){let e=this.setFromMatrixColumn(t,0).length(),n=this.setFromMatrixColumn(t,1).length(),s=this.setFromMatrixColumn(t,2).length();return this.x=e,this.y=n,this.z=s,this}setFromMatrixColumn(t,e){return this.fromArray(t.elements,e*4)}setFromMatrix3Column(t,e){return this.fromArray(t.elements,e*3)}setFromEuler(t){return this.x=t._x,this.y=t._y,this.z=t._z,this}setFromColor(t){return this.x=t.r,this.y=t.g,this.z=t.b,this}equals(t){return t.x===this.x&&t.y===this.y&&t.z===this.z}fromArray(t,e=0){return this.x=t[e],this.y=t[e+1],this.z=t[e+2],this}toArray(t=[],e=0){return t[e]=this.x,t[e+1]=this.y,t[e+2]=this.z,t}fromBufferAttribute(t,e){return this.x=t.getX(e),this.y=t.getY(e),this.z=t.getZ(e),this}random(){return this.x=Math.random(),this.y=Math.random(),this.z=Math.random(),this}randomDirection(){let t=Math.random()*Math.PI*2,e=Math.random()*2-1,n=Math.sqrt(1-e*e);return this.x=n*Math.cos(t),this.y=e,this.z=n*Math.sin(t),this}*[Symbol.iterator](){yield this.x,yield this.y,yield this.z}},pa=new D,ec=new je,Vt=class i{constructor(t,e,n,s,r,o,a,l,c){i.prototype.isMatrix3=!0,this.elements=[1,0,0,0,1,0,0,0,1],t!==void 0&&this.set(t,e,n,s,r,o,a,l,c)}set(t,e,n,s,r,o,a,l,c){let h=this.elements;return h[0]=t,h[1]=s,h[2]=a,h[3]=e,h[4]=r,h[5]=l,h[6]=n,h[7]=o,h[8]=c,this}identity(){return this.set(1,0,0,0,1,0,0,0,1),this}copy(t){let e=this.elements,n=t.elements;return e[0]=n[0],e[1]=n[1],e[2]=n[2],e[3]=n[3],e[4]=n[4],e[5]=n[5],e[6]=n[6],e[7]=n[7],e[8]=n[8],this}extractBasis(t,e,n){return t.setFromMatrix3Column(this,0),e.setFromMatrix3Column(this,1),n.setFromMatrix3Column(this,2),this}setFromMatrix4(t){let e=t.elements;return this.set(e[0],e[4],e[8],e[1],e[5],e[9],e[2],e[6],e[10]),this}multiply(t){return this.multiplyMatrices(this,t)}premultiply(t){return this.multiplyMatrices(t,this)}multiplyMatrices(t,e){let n=t.elements,s=e.elements,r=this.elements,o=n[0],a=n[3],l=n[6],c=n[1],h=n[4],u=n[7],f=n[2],p=n[5],g=n[8],y=s[0],m=s[3],d=s[6],w=s[1],E=s[4],v=s[7],C=s[2],A=s[5],I=s[8];return r[0]=o*y+a*w+l*C,r[3]=o*m+a*E+l*A,r[6]=o*d+a*v+l*I,r[1]=c*y+h*w+u*C,r[4]=c*m+h*E+u*A,r[7]=c*d+h*v+u*I,r[2]=f*y+p*w+g*C,r[5]=f*m+p*E+g*A,r[8]=f*d+p*v+g*I,this}multiplyScalar(t){let e=this.elements;return e[0]*=t,e[3]*=t,e[6]*=t,e[1]*=t,e[4]*=t,e[7]*=t,e[2]*=t,e[5]*=t,e[8]*=t,this}determinant(){let t=this.elements,e=t[0],n=t[1],s=t[2],r=t[3],o=t[4],a=t[5],l=t[6],c=t[7],h=t[8];return e*o*h-e*a*c-n*r*h+n*a*l+s*r*c-s*o*l}invert(){let t=this.elements,e=t[0],n=t[1],s=t[2],r=t[3],o=t[4],a=t[5],l=t[6],c=t[7],h=t[8],u=h*o-a*c,f=a*l-h*r,p=c*r-o*l,g=e*u+n*f+s*p;if(g===0)return this.set(0,0,0,0,0,0,0,0,0);let y=1/g;return t[0]=u*y,t[1]=(s*c-h*n)*y,t[2]=(a*n-s*o)*y,t[3]=f*y,t[4]=(h*e-s*l)*y,t[5]=(s*r-a*e)*y,t[6]=p*y,t[7]=(n*l-c*e)*y,t[8]=(o*e-n*r)*y,this}transpose(){let t,e=this.elements;return t=e[1],e[1]=e[3],e[3]=t,t=e[2],e[2]=e[6],e[6]=t,t=e[5],e[5]=e[7],e[7]=t,this}getNormalMatrix(t){return this.setFromMatrix4(t).invert().transpose()}transposeIntoArray(t){let e=this.elements;return t[0]=e[0],t[1]=e[3],t[2]=e[6],t[3]=e[1],t[4]=e[4],t[5]=e[7],t[6]=e[2],t[7]=e[5],t[8]=e[8],this}setUvTransform(t,e,n,s,r,o,a){let l=Math.cos(r),c=Math.sin(r);return this.set(n*l,n*c,-n*(l*o+c*a)+o+t,-s*c,s*l,-s*(-c*o+l*a)+a+e,0,0,1),this}scale(t,e){return this.premultiply(ma.makeScale(t,e)),this}rotate(t){return this.premultiply(ma.makeRotation(-t)),this}translate(t,e){return this.premultiply(ma.makeTranslation(t,e)),this}makeTranslation(t,e){return t.isVector2?this.set(1,0,t.x,0,1,t.y,0,0,1):this.set(1,0,t,0,1,e,0,0,1),this}makeRotation(t){let e=Math.cos(t),n=Math.sin(t);return this.set(e,-n,0,n,e,0,0,0,1),this}makeScale(t,e){return this.set(t,0,0,0,e,0,0,0,1),this}equals(t){let e=this.elements,n=t.elements;for(let s=0;s<9;s++)if(e[s]!==n[s])return!1;return!0}fromArray(t,e=0){for(let n=0;n<9;n++)this.elements[n]=t[n+e];return this}toArray(t=[],e=0){let n=this.elements;return t[e]=n[0],t[e+1]=n[1],t[e+2]=n[2],t[e+3]=n[3],t[e+4]=n[4],t[e+5]=n[5],t[e+6]=n[6],t[e+7]=n[7],t[e+8]=n[8],t}clone(){return new this.constructor().fromArray(this.elements)}},ma=new Vt;function xl(i){for(let t=i.length-1;t>=0;--t)if(i[t]>=65535)return!0;return!1}function Es(i){return document.createElementNS("http://www.w3.org/1999/xhtml",i)}function uh(){let i=Es("canvas");return i.style.display="block",i}var nc={};function Hi(i){i in nc||(nc[i]=!0,console.warn(i))}function dh(i,t,e){return new Promise(function(n,s){function r(){switch(i.clientWaitSync(t,i.SYNC_FLUSH_COMMANDS_BIT,0)){case i.WAIT_FAILED:s();break;case i.TIMEOUT_EXPIRED:setTimeout(r,e);break;default:n()}}setTimeout(r,e)})}var ic=new Vt().set(.4123908,.3575843,.1804808,.212639,.7151687,.0721923,.0193308,.1191948,.9505322),sc=new Vt().set(3.2409699,-1.5373832,-.4986108,-.9692436,1.8759675,.0415551,.0556301,-.203977,1.0569715);function Nu(){let i={enabled:!0,workingColorSpace:li,spaces:{},convert:function(s,r,o){return this.enabled===!1||r===o||!r||!o||(this.spaces[r].transfer===te&&(s.r=wn(s.r),s.g=wn(s.g),s.b=wn(s.b)),this.spaces[r].primaries!==this.spaces[o].primaries&&(s.applyMatrix3(this.spaces[r].toXYZ),s.applyMatrix3(this.spaces[o].fromXYZ)),this.spaces[o].transfer===te&&(s.r=zi(s.r),s.g=zi(s.g),s.b=zi(s.b))),s},workingToColorSpace:function(s,r){return this.convert(s,this.workingColorSpace,r)},colorSpaceToWorking:function(s,r){return this.convert(s,r,this.workingColorSpace)},getPrimaries:function(s){return this.spaces[s].primaries},getTransfer:function(s){return s===In?Ss:this.spaces[s].transfer},getToneMappingMode:function(s){return this.spaces[s].outputColorSpaceConfig.toneMappingMode||"standard"},getLuminanceCoefficients:function(s,r=this.workingColorSpace){return s.fromArray(this.spaces[r].luminanceCoefficients)},define:function(s){Object.assign(this.spaces,s)},_getMatrix:function(s,r,o){return s.copy(this.spaces[r].toXYZ).multiply(this.spaces[o].fromXYZ)},_getDrawingBufferColorSpace:function(s){return this.spaces[s].outputColorSpaceConfig.drawingBufferColorSpace},_getUnpackColorSpace:function(s=this.workingColorSpace){return this.spaces[s].workingColorSpaceConfig.unpackColorSpace},fromWorkingColorSpace:function(s,r){return Hi("THREE.ColorManagement: .fromWorkingColorSpace() has been renamed to .workingToColorSpace()."),i.workingToColorSpace(s,r)},toWorkingColorSpace:function(s,r){return Hi("THREE.ColorManagement: .toWorkingColorSpace() has been renamed to .colorSpaceToWorking()."),i.colorSpaceToWorking(s,r)}},t=[.64,.33,.3,.6,.15,.06],e=[.2126,.7152,.0722],n=[.3127,.329];return i.define({[li]:{primaries:t,whitePoint:n,transfer:Ss,toXYZ:ic,fromXYZ:sc,luminanceCoefficients:e,workingColorSpaceConfig:{unpackColorSpace:Le},outputColorSpaceConfig:{drawingBufferColorSpace:Le}},[Le]:{primaries:t,whitePoint:n,transfer:te,toXYZ:ic,fromXYZ:sc,luminanceCoefficients:e,outputColorSpaceConfig:{drawingBufferColorSpace:Le}}}),i}var $t=Nu();function wn(i){return i<.04045?i*.0773993808:Math.pow(i*.9478672986+.0521327014,2.4)}function zi(i){return i<.0031308?i*12.92:1.055*Math.pow(i,.41666)-.055}var wi,Br=class{static getDataURL(t,e="image/png"){if(/^data:/i.test(t.src)||typeof HTMLCanvasElement>"u")return t.src;let n;if(t instanceof HTMLCanvasElement)n=t;else{wi===void 0&&(wi=Es("canvas")),wi.width=t.width,wi.height=t.height;let s=wi.getContext("2d");t instanceof ImageData?s.putImageData(t,0,0):s.drawImage(t,0,0,t.width,t.height),n=wi}return n.toDataURL(e)}static sRGBToLinear(t){if(typeof HTMLImageElement<"u"&&t instanceof HTMLImageElement||typeof HTMLCanvasElement<"u"&&t instanceof HTMLCanvasElement||typeof ImageBitmap<"u"&&t instanceof ImageBitmap){let e=Es("canvas");e.width=t.width,e.height=t.height;let n=e.getContext("2d");n.drawImage(t,0,0,t.width,t.height);let s=n.getImageData(0,0,t.width,t.height),r=s.data;for(let o=0;o<r.length;o++)r[o]=wn(r[o]/255)*255;return n.putImageData(s,0,0),e}else if(t.data){let e=t.data.slice(0);for(let n=0;n<e.length;n++)e instanceof Uint8Array||e instanceof Uint8ClampedArray?e[n]=Math.floor(wn(e[n]/255)*255):e[n]=wn(e[n]);return{data:e,width:t.width,height:t.height}}else return console.warn("THREE.ImageUtils.sRGBToLinear(): Unsupported image type. No color space conversion applied."),t}},Fu=0,Gi=class{constructor(t=null){this.isSource=!0,Object.defineProperty(this,"id",{value:Fu++}),this.uuid=mi(),this.data=t,this.dataReady=!0,this.version=0}getSize(t){let e=this.data;return typeof HTMLVideoElement<"u"&&e instanceof HTMLVideoElement?t.set(e.videoWidth,e.videoHeight,0):e instanceof VideoFrame?t.set(e.displayHeight,e.displayWidth,0):e!==null?t.set(e.width,e.height,e.depth||0):t.set(0,0,0),t}set needsUpdate(t){t===!0&&this.version++}toJSON(t){let e=t===void 0||typeof t=="string";if(!e&&t.images[this.uuid]!==void 0)return t.images[this.uuid];let n={uuid:this.uuid,url:""},s=this.data;if(s!==null){let r;if(Array.isArray(s)){r=[];for(let o=0,a=s.length;o<a;o++)s[o].isDataTexture?r.push(ga(s[o].image)):r.push(ga(s[o]))}else r=ga(s);n.url=r}return e||(t.images[this.uuid]=n),n}};function ga(i){return typeof HTMLImageElement<"u"&&i instanceof HTMLImageElement||typeof HTMLCanvasElement<"u"&&i instanceof HTMLCanvasElement||typeof ImageBitmap<"u"&&i instanceof ImageBitmap?Br.getDataURL(i):i.data?{data:Array.from(i.data),width:i.width,height:i.height,type:i.data.constructor.name}:(console.warn("THREE.Texture: Unable to serialize Texture."),{})}var Ou=0,_a=new D,We=class i extends fn{constructor(t=i.DEFAULT_IMAGE,e=i.DEFAULT_MAPPING,n=kn,s=kn,r=rn,o=Jn,a=Qe,l=cn,c=i.DEFAULT_ANISOTROPY,h=In){super(),this.isTexture=!0,Object.defineProperty(this,"id",{value:Ou++}),this.uuid=mi(),this.name="",this.source=new Gi(t),this.mipmaps=[],this.mapping=e,this.channel=0,this.wrapS=n,this.wrapT=s,this.magFilter=r,this.minFilter=o,this.anisotropy=c,this.format=a,this.internalFormat=null,this.type=l,this.offset=new at(0,0),this.repeat=new at(1,1),this.center=new at(0,0),this.rotation=0,this.matrixAutoUpdate=!0,this.matrix=new Vt,this.generateMipmaps=!0,this.premultiplyAlpha=!1,this.flipY=!0,this.unpackAlignment=4,this.colorSpace=h,this.userData={},this.updateRanges=[],this.version=0,this.onUpdate=null,this.renderTarget=null,this.isRenderTargetTexture=!1,this.isArrayTexture=!!(t&&t.depth&&t.depth>1),this.pmremVersion=0}get width(){return this.source.getSize(_a).x}get height(){return this.source.getSize(_a).y}get depth(){return this.source.getSize(_a).z}get image(){return this.source.data}set image(t=null){this.source.data=t}updateMatrix(){this.matrix.setUvTransform(this.offset.x,this.offset.y,this.repeat.x,this.repeat.y,this.rotation,this.center.x,this.center.y)}addUpdateRange(t,e){this.updateRanges.push({start:t,count:e})}clearUpdateRanges(){this.updateRanges.length=0}clone(){return new this.constructor().copy(this)}copy(t){return this.name=t.name,this.source=t.source,this.mipmaps=t.mipmaps.slice(0),this.mapping=t.mapping,this.channel=t.channel,this.wrapS=t.wrapS,this.wrapT=t.wrapT,this.magFilter=t.magFilter,this.minFilter=t.minFilter,this.anisotropy=t.anisotropy,this.format=t.format,this.internalFormat=t.internalFormat,this.type=t.type,this.offset.copy(t.offset),this.repeat.copy(t.repeat),this.center.copy(t.center),this.rotation=t.rotation,this.matrixAutoUpdate=t.matrixAutoUpdate,this.matrix.copy(t.matrix),this.generateMipmaps=t.generateMipmaps,this.premultiplyAlpha=t.premultiplyAlpha,this.flipY=t.flipY,this.unpackAlignment=t.unpackAlignment,this.colorSpace=t.colorSpace,this.renderTarget=t.renderTarget,this.isRenderTargetTexture=t.isRenderTargetTexture,this.isArrayTexture=t.isArrayTexture,this.userData=JSON.parse(JSON.stringify(t.userData)),this.needsUpdate=!0,this}setValues(t){for(let e in t){let n=t[e];if(n===void 0){console.warn(`THREE.Texture.setValues(): parameter '${e}' has value of undefined.`);continue}let s=this[e];if(s===void 0){console.warn(`THREE.Texture.setValues(): property '${e}' does not exist.`);continue}s&&n&&s.isVector2&&n.isVector2||s&&n&&s.isVector3&&n.isVector3||s&&n&&s.isMatrix3&&n.isMatrix3?s.copy(n):this[e]=n}}toJSON(t){let e=t===void 0||typeof t=="string";if(!e&&t.textures[this.uuid]!==void 0)return t.textures[this.uuid];let n={metadata:{version:4.7,type:"Texture",generator:"Texture.toJSON"},uuid:this.uuid,name:this.name,image:this.source.toJSON(t).uuid,mapping:this.mapping,channel:this.channel,repeat:[this.repeat.x,this.repeat.y],offset:[this.offset.x,this.offset.y],center:[this.center.x,this.center.y],rotation:this.rotation,wrap:[this.wrapS,this.wrapT],format:this.format,internalFormat:this.internalFormat,type:this.type,colorSpace:this.colorSpace,minFilter:this.minFilter,magFilter:this.magFilter,anisotropy:this.anisotropy,flipY:this.flipY,generateMipmaps:this.generateMipmaps,premultiplyAlpha:this.premultiplyAlpha,unpackAlignment:this.unpackAlignment};return Object.keys(this.userData).length>0&&(n.userData=this.userData),e||(t.textures[this.uuid]=n),n}dispose(){this.dispatchEvent({type:"dispose"})}transformUv(t){if(this.mapping!==sl)return t;if(t.applyMatrix3(this.matrix),t.x<0||t.x>1)switch(this.wrapS){case Nr:t.x=t.x-Math.floor(t.x);break;case kn:t.x=t.x<0?0:1;break;case Fr:Math.abs(Math.floor(t.x)%2)===1?t.x=Math.ceil(t.x)-t.x:t.x=t.x-Math.floor(t.x);break}if(t.y<0||t.y>1)switch(this.wrapT){case Nr:t.y=t.y-Math.floor(t.y);break;case kn:t.y=t.y<0?0:1;break;case Fr:Math.abs(Math.floor(t.y)%2)===1?t.y=Math.ceil(t.y)-t.y:t.y=t.y-Math.floor(t.y);break}return this.flipY&&(t.y=1-t.y),t}set needsUpdate(t){t===!0&&(this.version++,this.source.needsUpdate=!0)}set needsPMREMUpdate(t){t===!0&&this.pmremVersion++}};We.DEFAULT_IMAGE=null;We.DEFAULT_MAPPING=sl;We.DEFAULT_ANISOTROPY=1;var pe=class i{constructor(t=0,e=0,n=0,s=1){i.prototype.isVector4=!0,this.x=t,this.y=e,this.z=n,this.w=s}get width(){return this.z}set width(t){this.z=t}get height(){return this.w}set height(t){this.w=t}set(t,e,n,s){return this.x=t,this.y=e,this.z=n,this.w=s,this}setScalar(t){return this.x=t,this.y=t,this.z=t,this.w=t,this}setX(t){return this.x=t,this}setY(t){return this.y=t,this}setZ(t){return this.z=t,this}setW(t){return this.w=t,this}setComponent(t,e){switch(t){case 0:this.x=e;break;case 1:this.y=e;break;case 2:this.z=e;break;case 3:this.w=e;break;default:throw new Error("index is out of range: "+t)}return this}getComponent(t){switch(t){case 0:return this.x;case 1:return this.y;case 2:return this.z;case 3:return this.w;default:throw new Error("index is out of range: "+t)}}clone(){return new this.constructor(this.x,this.y,this.z,this.w)}copy(t){return this.x=t.x,this.y=t.y,this.z=t.z,this.w=t.w!==void 0?t.w:1,this}add(t){return this.x+=t.x,this.y+=t.y,this.z+=t.z,this.w+=t.w,this}addScalar(t){return this.x+=t,this.y+=t,this.z+=t,this.w+=t,this}addVectors(t,e){return this.x=t.x+e.x,this.y=t.y+e.y,this.z=t.z+e.z,this.w=t.w+e.w,this}addScaledVector(t,e){return this.x+=t.x*e,this.y+=t.y*e,this.z+=t.z*e,this.w+=t.w*e,this}sub(t){return this.x-=t.x,this.y-=t.y,this.z-=t.z,this.w-=t.w,this}subScalar(t){return this.x-=t,this.y-=t,this.z-=t,this.w-=t,this}subVectors(t,e){return this.x=t.x-e.x,this.y=t.y-e.y,this.z=t.z-e.z,this.w=t.w-e.w,this}multiply(t){return this.x*=t.x,this.y*=t.y,this.z*=t.z,this.w*=t.w,this}multiplyScalar(t){return this.x*=t,this.y*=t,this.z*=t,this.w*=t,this}applyMatrix4(t){let e=this.x,n=this.y,s=this.z,r=this.w,o=t.elements;return this.x=o[0]*e+o[4]*n+o[8]*s+o[12]*r,this.y=o[1]*e+o[5]*n+o[9]*s+o[13]*r,this.z=o[2]*e+o[6]*n+o[10]*s+o[14]*r,this.w=o[3]*e+o[7]*n+o[11]*s+o[15]*r,this}divide(t){return this.x/=t.x,this.y/=t.y,this.z/=t.z,this.w/=t.w,this}divideScalar(t){return this.multiplyScalar(1/t)}setAxisAngleFromQuaternion(t){this.w=2*Math.acos(t.w);let e=Math.sqrt(1-t.w*t.w);return e<1e-4?(this.x=1,this.y=0,this.z=0):(this.x=t.x/e,this.y=t.y/e,this.z=t.z/e),this}setAxisAngleFromRotationMatrix(t){let e,n,s,r,l=t.elements,c=l[0],h=l[4],u=l[8],f=l[1],p=l[5],g=l[9],y=l[2],m=l[6],d=l[10];if(Math.abs(h-f)<.01&&Math.abs(u-y)<.01&&Math.abs(g-m)<.01){if(Math.abs(h+f)<.1&&Math.abs(u+y)<.1&&Math.abs(g+m)<.1&&Math.abs(c+p+d-3)<.1)return this.set(1,0,0,0),this;e=Math.PI;let E=(c+1)/2,v=(p+1)/2,C=(d+1)/2,A=(h+f)/4,I=(u+y)/4,U=(g+m)/4;return E>v&&E>C?E<.01?(n=0,s=.707106781,r=.707106781):(n=Math.sqrt(E),s=A/n,r=I/n):v>C?v<.01?(n=.707106781,s=0,r=.707106781):(s=Math.sqrt(v),n=A/s,r=U/s):C<.01?(n=.707106781,s=.707106781,r=0):(r=Math.sqrt(C),n=I/r,s=U/r),this.set(n,s,r,e),this}let w=Math.sqrt((m-g)*(m-g)+(u-y)*(u-y)+(f-h)*(f-h));return Math.abs(w)<.001&&(w=1),this.x=(m-g)/w,this.y=(u-y)/w,this.z=(f-h)/w,this.w=Math.acos((c+p+d-1)/2),this}setFromMatrixPosition(t){let e=t.elements;return this.x=e[12],this.y=e[13],this.z=e[14],this.w=e[15],this}min(t){return this.x=Math.min(this.x,t.x),this.y=Math.min(this.y,t.y),this.z=Math.min(this.z,t.z),this.w=Math.min(this.w,t.w),this}max(t){return this.x=Math.max(this.x,t.x),this.y=Math.max(this.y,t.y),this.z=Math.max(this.z,t.z),this.w=Math.max(this.w,t.w),this}clamp(t,e){return this.x=Gt(this.x,t.x,e.x),this.y=Gt(this.y,t.y,e.y),this.z=Gt(this.z,t.z,e.z),this.w=Gt(this.w,t.w,e.w),this}clampScalar(t,e){return this.x=Gt(this.x,t,e),this.y=Gt(this.y,t,e),this.z=Gt(this.z,t,e),this.w=Gt(this.w,t,e),this}clampLength(t,e){let n=this.length();return this.divideScalar(n||1).multiplyScalar(Gt(n,t,e))}floor(){return this.x=Math.floor(this.x),this.y=Math.floor(this.y),this.z=Math.floor(this.z),this.w=Math.floor(this.w),this}ceil(){return this.x=Math.ceil(this.x),this.y=Math.ceil(this.y),this.z=Math.ceil(this.z),this.w=Math.ceil(this.w),this}round(){return this.x=Math.round(this.x),this.y=Math.round(this.y),this.z=Math.round(this.z),this.w=Math.round(this.w),this}roundToZero(){return this.x=Math.trunc(this.x),this.y=Math.trunc(this.y),this.z=Math.trunc(this.z),this.w=Math.trunc(this.w),this}negate(){return this.x=-this.x,this.y=-this.y,this.z=-this.z,this.w=-this.w,this}dot(t){return this.x*t.x+this.y*t.y+this.z*t.z+this.w*t.w}lengthSq(){return this.x*this.x+this.y*this.y+this.z*this.z+this.w*this.w}length(){return Math.sqrt(this.x*this.x+this.y*this.y+this.z*this.z+this.w*this.w)}manhattanLength(){return Math.abs(this.x)+Math.abs(this.y)+Math.abs(this.z)+Math.abs(this.w)}normalize(){return this.divideScalar(this.length()||1)}setLength(t){return this.normalize().multiplyScalar(t)}lerp(t,e){return this.x+=(t.x-this.x)*e,this.y+=(t.y-this.y)*e,this.z+=(t.z-this.z)*e,this.w+=(t.w-this.w)*e,this}lerpVectors(t,e,n){return this.x=t.x+(e.x-t.x)*n,this.y=t.y+(e.y-t.y)*n,this.z=t.z+(e.z-t.z)*n,this.w=t.w+(e.w-t.w)*n,this}equals(t){return t.x===this.x&&t.y===this.y&&t.z===this.z&&t.w===this.w}fromArray(t,e=0){return this.x=t[e],this.y=t[e+1],this.z=t[e+2],this.w=t[e+3],this}toArray(t=[],e=0){return t[e]=this.x,t[e+1]=this.y,t[e+2]=this.z,t[e+3]=this.w,t}fromBufferAttribute(t,e){return this.x=t.getX(e),this.y=t.getY(e),this.z=t.getZ(e),this.w=t.getW(e),this}random(){return this.x=Math.random(),this.y=Math.random(),this.z=Math.random(),this.w=Math.random(),this}*[Symbol.iterator](){yield this.x,yield this.y,yield this.z,yield this.w}},zr=class extends fn{constructor(t=1,e=1,n={}){super(),n=Object.assign({generateMipmaps:!1,internalFormat:null,minFilter:rn,depthBuffer:!0,stencilBuffer:!1,resolveDepthBuffer:!0,resolveStencilBuffer:!0,depthTexture:null,samples:0,count:1,depth:1,multiview:!1},n),this.isRenderTarget=!0,this.width=t,this.height=e,this.depth=n.depth,this.scissor=new pe(0,0,t,e),this.scissorTest=!1,this.viewport=new pe(0,0,t,e);let s={width:t,height:e,depth:n.depth},r=new We(s);this.textures=[];let o=n.count;for(let a=0;a<o;a++)this.textures[a]=r.clone(),this.textures[a].isRenderTargetTexture=!0,this.textures[a].renderTarget=this;this._setTextureOptions(n),this.depthBuffer=n.depthBuffer,this.stencilBuffer=n.stencilBuffer,this.resolveDepthBuffer=n.resolveDepthBuffer,this.resolveStencilBuffer=n.resolveStencilBuffer,this._depthTexture=null,this.depthTexture=n.depthTexture,this.samples=n.samples,this.multiview=n.multiview}_setTextureOptions(t={}){let e={minFilter:rn,generateMipmaps:!1,flipY:!1,internalFormat:null};t.mapping!==void 0&&(e.mapping=t.mapping),t.wrapS!==void 0&&(e.wrapS=t.wrapS),t.wrapT!==void 0&&(e.wrapT=t.wrapT),t.wrapR!==void 0&&(e.wrapR=t.wrapR),t.magFilter!==void 0&&(e.magFilter=t.magFilter),t.minFilter!==void 0&&(e.minFilter=t.minFilter),t.format!==void 0&&(e.format=t.format),t.type!==void 0&&(e.type=t.type),t.anisotropy!==void 0&&(e.anisotropy=t.anisotropy),t.colorSpace!==void 0&&(e.colorSpace=t.colorSpace),t.flipY!==void 0&&(e.flipY=t.flipY),t.generateMipmaps!==void 0&&(e.generateMipmaps=t.generateMipmaps),t.internalFormat!==void 0&&(e.internalFormat=t.internalFormat);for(let n=0;n<this.textures.length;n++)this.textures[n].setValues(e)}get texture(){return this.textures[0]}set texture(t){this.textures[0]=t}set depthTexture(t){this._depthTexture!==null&&(this._depthTexture.renderTarget=null),t!==null&&(t.renderTarget=this),this._depthTexture=t}get depthTexture(){return this._depthTexture}setSize(t,e,n=1){if(this.width!==t||this.height!==e||this.depth!==n){this.width=t,this.height=e,this.depth=n;for(let s=0,r=this.textures.length;s<r;s++)this.textures[s].image.width=t,this.textures[s].image.height=e,this.textures[s].image.depth=n,this.textures[s].isArrayTexture=this.textures[s].image.depth>1;this.dispose()}this.viewport.set(0,0,t,e),this.scissor.set(0,0,t,e)}clone(){return new this.constructor().copy(this)}copy(t){this.width=t.width,this.height=t.height,this.depth=t.depth,this.scissor.copy(t.scissor),this.scissorTest=t.scissorTest,this.viewport.copy(t.viewport),this.textures.length=0;for(let e=0,n=t.textures.length;e<n;e++){this.textures[e]=t.textures[e].clone(),this.textures[e].isRenderTargetTexture=!0,this.textures[e].renderTarget=this;let s=Object.assign({},t.textures[e].image);this.textures[e].source=new Gi(s)}return this.depthBuffer=t.depthBuffer,this.stencilBuffer=t.stencilBuffer,this.resolveDepthBuffer=t.resolveDepthBuffer,this.resolveStencilBuffer=t.resolveStencilBuffer,t.depthTexture!==null&&(this.depthTexture=t.depthTexture.clone()),this.samples=t.samples,this}dispose(){this.dispatchEvent({type:"dispose"})}},pn=class extends zr{constructor(t=1,e=1,n={}){super(t,e,n),this.isWebGLRenderTarget=!0}},Ts=class extends We{constructor(t=null,e=1,n=1,s=1){super(null),this.isDataArrayTexture=!0,this.image={data:t,width:e,height:n,depth:s},this.magFilter=Ke,this.minFilter=Ke,this.wrapR=kn,this.generateMipmaps=!1,this.flipY=!1,this.unpackAlignment=1,this.layerUpdates=new Set}addLayerUpdate(t){this.layerUpdates.add(t)}clearLayerUpdates(){this.layerUpdates.clear()}};var kr=class extends We{constructor(t=null,e=1,n=1,s=1){super(null),this.isData3DTexture=!0,this.image={data:t,width:e,height:n,depth:s},this.magFilter=Ke,this.minFilter=Ke,this.wrapR=kn,this.generateMipmaps=!1,this.flipY=!1,this.unpackAlignment=1}};var Hn=class{constructor(t=new D(1/0,1/0,1/0),e=new D(-1/0,-1/0,-1/0)){this.isBox3=!0,this.min=t,this.max=e}set(t,e){return this.min.copy(t),this.max.copy(e),this}setFromArray(t){this.makeEmpty();for(let e=0,n=t.length;e<n;e+=3)this.expandByPoint(tn.fromArray(t,e));return this}setFromBufferAttribute(t){this.makeEmpty();for(let e=0,n=t.count;e<n;e++)this.expandByPoint(tn.fromBufferAttribute(t,e));return this}setFromPoints(t){this.makeEmpty();for(let e=0,n=t.length;e<n;e++)this.expandByPoint(t[e]);return this}setFromCenterAndSize(t,e){let n=tn.copy(e).multiplyScalar(.5);return this.min.copy(t).sub(n),this.max.copy(t).add(n),this}setFromObject(t,e=!1){return this.makeEmpty(),this.expandByObject(t,e)}clone(){return new this.constructor().copy(this)}copy(t){return this.min.copy(t.min),this.max.copy(t.max),this}makeEmpty(){return this.min.x=this.min.y=this.min.z=1/0,this.max.x=this.max.y=this.max.z=-1/0,this}isEmpty(){return this.max.x<this.min.x||this.max.y<this.min.y||this.max.z<this.min.z}getCenter(t){return this.isEmpty()?t.set(0,0,0):t.addVectors(this.min,this.max).multiplyScalar(.5)}getSize(t){return this.isEmpty()?t.set(0,0,0):t.subVectors(this.max,this.min)}expandByPoint(t){return this.min.min(t),this.max.max(t),this}expandByVector(t){return this.min.sub(t),this.max.add(t),this}expandByScalar(t){return this.min.addScalar(-t),this.max.addScalar(t),this}expandByObject(t,e=!1){t.updateWorldMatrix(!1,!1);let n=t.geometry;if(n!==void 0){let r=n.getAttribute("position");if(e===!0&&r!==void 0&&t.isInstancedMesh!==!0)for(let o=0,a=r.count;o<a;o++)t.isMesh===!0?t.getVertexPosition(o,tn):tn.fromBufferAttribute(r,o),tn.applyMatrix4(t.matrixWorld),this.expandByPoint(tn);else t.boundingBox!==void 0?(t.boundingBox===null&&t.computeBoundingBox(),ur.copy(t.boundingBox)):(n.boundingBox===null&&n.computeBoundingBox(),ur.copy(n.boundingBox)),ur.applyMatrix4(t.matrixWorld),this.union(ur)}let s=t.children;for(let r=0,o=s.length;r<o;r++)this.expandByObject(s[r],e);return this}containsPoint(t){return t.x>=this.min.x&&t.x<=this.max.x&&t.y>=this.min.y&&t.y<=this.max.y&&t.z>=this.min.z&&t.z<=this.max.z}containsBox(t){return this.min.x<=t.min.x&&t.max.x<=this.max.x&&this.min.y<=t.min.y&&t.max.y<=this.max.y&&this.min.z<=t.min.z&&t.max.z<=this.max.z}getParameter(t,e){return e.set((t.x-this.min.x)/(this.max.x-this.min.x),(t.y-this.min.y)/(this.max.y-this.min.y),(t.z-this.min.z)/(this.max.z-this.min.z))}intersectsBox(t){return t.max.x>=this.min.x&&t.min.x<=this.max.x&&t.max.y>=this.min.y&&t.min.y<=this.max.y&&t.max.z>=this.min.z&&t.min.z<=this.max.z}intersectsSphere(t){return this.clampPoint(t.center,tn),tn.distanceToSquared(t.center)<=t.radius*t.radius}intersectsPlane(t){let e,n;return t.normal.x>0?(e=t.normal.x*this.min.x,n=t.normal.x*this.max.x):(e=t.normal.x*this.max.x,n=t.normal.x*this.min.x),t.normal.y>0?(e+=t.normal.y*this.min.y,n+=t.normal.y*this.max.y):(e+=t.normal.y*this.max.y,n+=t.normal.y*this.min.y),t.normal.z>0?(e+=t.normal.z*this.min.z,n+=t.normal.z*this.max.z):(e+=t.normal.z*this.max.z,n+=t.normal.z*this.min.z),e<=-t.constant&&n>=-t.constant}intersectsTriangle(t){if(this.isEmpty())return!1;this.getCenter(ds),dr.subVectors(this.max,ds),Ai.subVectors(t.a,ds),Ci.subVectors(t.b,ds),Ri.subVectors(t.c,ds),Ln.subVectors(Ci,Ai),Un.subVectors(Ri,Ci),ti.subVectors(Ai,Ri);let e=[0,-Ln.z,Ln.y,0,-Un.z,Un.y,0,-ti.z,ti.y,Ln.z,0,-Ln.x,Un.z,0,-Un.x,ti.z,0,-ti.x,-Ln.y,Ln.x,0,-Un.y,Un.x,0,-ti.y,ti.x,0];return!xa(e,Ai,Ci,Ri,dr)||(e=[1,0,0,0,1,0,0,0,1],!xa(e,Ai,Ci,Ri,dr))?!1:(fr.crossVectors(Ln,Un),e=[fr.x,fr.y,fr.z],xa(e,Ai,Ci,Ri,dr))}clampPoint(t,e){return e.copy(t).clamp(this.min,this.max)}distanceToPoint(t){return this.clampPoint(t,tn).distanceTo(t)}getBoundingSphere(t){return this.isEmpty()?t.makeEmpty():(this.getCenter(t.center),t.radius=this.getSize(tn).length()*.5),t}intersect(t){return this.min.max(t.min),this.max.min(t.max),this.isEmpty()&&this.makeEmpty(),this}union(t){return this.min.min(t.min),this.max.max(t.max),this}applyMatrix4(t){return this.isEmpty()?this:(Mn[0].set(this.min.x,this.min.y,this.min.z).applyMatrix4(t),Mn[1].set(this.min.x,this.min.y,this.max.z).applyMatrix4(t),Mn[2].set(this.min.x,this.max.y,this.min.z).applyMatrix4(t),Mn[3].set(this.min.x,this.max.y,this.max.z).applyMatrix4(t),Mn[4].set(this.max.x,this.min.y,this.min.z).applyMatrix4(t),Mn[5].set(this.max.x,this.min.y,this.max.z).applyMatrix4(t),Mn[6].set(this.max.x,this.max.y,this.min.z).applyMatrix4(t),Mn[7].set(this.max.x,this.max.y,this.max.z).applyMatrix4(t),this.setFromPoints(Mn),this)}translate(t){return this.min.add(t),this.max.add(t),this}equals(t){return t.min.equals(this.min)&&t.max.equals(this.max)}toJSON(){return{min:this.min.toArray(),max:this.max.toArray()}}fromJSON(t){return this.min.fromArray(t.min),this.max.fromArray(t.max),this}},Mn=[new D,new D,new D,new D,new D,new D,new D,new D],tn=new D,ur=new Hn,Ai=new D,Ci=new D,Ri=new D,Ln=new D,Un=new D,ti=new D,ds=new D,dr=new D,fr=new D,ei=new D;function xa(i,t,e,n,s){for(let r=0,o=i.length-3;r<=o;r+=3){ei.fromArray(i,r);let a=s.x*Math.abs(ei.x)+s.y*Math.abs(ei.y)+s.z*Math.abs(ei.z),l=t.dot(ei),c=e.dot(ei),h=n.dot(ei);if(Math.max(-Math.max(l,c,h),Math.min(l,c,h))>a)return!1}return!0}var Bu=new Hn,fs=new D,ya=new D,Wi=class{constructor(t=new D,e=-1){this.isSphere=!0,this.center=t,this.radius=e}set(t,e){return this.center.copy(t),this.radius=e,this}setFromPoints(t,e){let n=this.center;e!==void 0?n.copy(e):Bu.setFromPoints(t).getCenter(n);let s=0;for(let r=0,o=t.length;r<o;r++)s=Math.max(s,n.distanceToSquared(t[r]));return this.radius=Math.sqrt(s),this}copy(t){return this.center.copy(t.center),this.radius=t.radius,this}isEmpty(){return this.radius<0}makeEmpty(){return this.center.set(0,0,0),this.radius=-1,this}containsPoint(t){return t.distanceToSquared(this.center)<=this.radius*this.radius}distanceToPoint(t){return t.distanceTo(this.center)-this.radius}intersectsSphere(t){let e=this.radius+t.radius;return t.center.distanceToSquared(this.center)<=e*e}intersectsBox(t){return t.intersectsSphere(this)}intersectsPlane(t){return Math.abs(t.distanceToPoint(this.center))<=this.radius}clampPoint(t,e){let n=this.center.distanceToSquared(t);return e.copy(t),n>this.radius*this.radius&&(e.sub(this.center).normalize(),e.multiplyScalar(this.radius).add(this.center)),e}getBoundingBox(t){return this.isEmpty()?(t.makeEmpty(),t):(t.set(this.center,this.center),t.expandByScalar(this.radius),t)}applyMatrix4(t){return this.center.applyMatrix4(t),this.radius=this.radius*t.getMaxScaleOnAxis(),this}translate(t){return this.center.add(t),this}expandByPoint(t){if(this.isEmpty())return this.center.copy(t),this.radius=0,this;fs.subVectors(t,this.center);let e=fs.lengthSq();if(e>this.radius*this.radius){let n=Math.sqrt(e),s=(n-this.radius)*.5;this.center.addScaledVector(fs,s/n),this.radius+=s}return this}union(t){return t.isEmpty()?this:this.isEmpty()?(this.copy(t),this):(this.center.equals(t.center)===!0?this.radius=Math.max(this.radius,t.radius):(ya.subVectors(t.center,this.center).setLength(t.radius),this.expandByPoint(fs.copy(t.center).add(ya)),this.expandByPoint(fs.copy(t.center).sub(ya))),this)}equals(t){return t.center.equals(this.center)&&t.radius===this.radius}clone(){return new this.constructor().copy(this)}toJSON(){return{radius:this.radius,center:this.center.toArray()}}fromJSON(t){return this.radius=t.radius,this.center.fromArray(t.center),this}},Sn=new D,va=new D,pr=new D,Nn=new D,Ma=new D,mr=new D,Sa=new D,ci=class{constructor(t=new D,e=new D(0,0,-1)){this.origin=t,this.direction=e}set(t,e){return this.origin.copy(t),this.direction.copy(e),this}copy(t){return this.origin.copy(t.origin),this.direction.copy(t.direction),this}at(t,e){return e.copy(this.origin).addScaledVector(this.direction,t)}lookAt(t){return this.direction.copy(t).sub(this.origin).normalize(),this}recast(t){return this.origin.copy(this.at(t,Sn)),this}closestPointToPoint(t,e){e.subVectors(t,this.origin);let n=e.dot(this.direction);return n<0?e.copy(this.origin):e.copy(this.origin).addScaledVector(this.direction,n)}distanceToPoint(t){return Math.sqrt(this.distanceSqToPoint(t))}distanceSqToPoint(t){let e=Sn.subVectors(t,this.origin).dot(this.direction);return e<0?this.origin.distanceToSquared(t):(Sn.copy(this.origin).addScaledVector(this.direction,e),Sn.distanceToSquared(t))}distanceSqToSegment(t,e,n,s){va.copy(t).add(e).multiplyScalar(.5),pr.copy(e).sub(t).normalize(),Nn.copy(this.origin).sub(va);let r=t.distanceTo(e)*.5,o=-this.direction.dot(pr),a=Nn.dot(this.direction),l=-Nn.dot(pr),c=Nn.lengthSq(),h=Math.abs(1-o*o),u,f,p,g;if(h>0)if(u=o*l-a,f=o*a-l,g=r*h,u>=0)if(f>=-g)if(f<=g){let y=1/h;u*=y,f*=y,p=u*(u+o*f+2*a)+f*(o*u+f+2*l)+c}else f=r,u=Math.max(0,-(o*f+a)),p=-u*u+f*(f+2*l)+c;else f=-r,u=Math.max(0,-(o*f+a)),p=-u*u+f*(f+2*l)+c;else f<=-g?(u=Math.max(0,-(-o*r+a)),f=u>0?-r:Math.min(Math.max(-r,-l),r),p=-u*u+f*(f+2*l)+c):f<=g?(u=0,f=Math.min(Math.max(-r,-l),r),p=f*(f+2*l)+c):(u=Math.max(0,-(o*r+a)),f=u>0?r:Math.min(Math.max(-r,-l),r),p=-u*u+f*(f+2*l)+c);else f=o>0?-r:r,u=Math.max(0,-(o*f+a)),p=-u*u+f*(f+2*l)+c;return n&&n.copy(this.origin).addScaledVector(this.direction,u),s&&s.copy(va).addScaledVector(pr,f),p}intersectSphere(t,e){Sn.subVectors(t.center,this.origin);let n=Sn.dot(this.direction),s=Sn.dot(Sn)-n*n,r=t.radius*t.radius;if(s>r)return null;let o=Math.sqrt(r-s),a=n-o,l=n+o;return l<0?null:a<0?this.at(l,e):this.at(a,e)}intersectsSphere(t){return t.radius<0?!1:this.distanceSqToPoint(t.center)<=t.radius*t.radius}distanceToPlane(t){let e=t.normal.dot(this.direction);if(e===0)return t.distanceToPoint(this.origin)===0?0:null;let n=-(this.origin.dot(t.normal)+t.constant)/e;return n>=0?n:null}intersectPlane(t,e){let n=this.distanceToPlane(t);return n===null?null:this.at(n,e)}intersectsPlane(t){let e=t.distanceToPoint(this.origin);return e===0||t.normal.dot(this.direction)*e<0}intersectBox(t,e){let n,s,r,o,a,l,c=1/this.direction.x,h=1/this.direction.y,u=1/this.direction.z,f=this.origin;return c>=0?(n=(t.min.x-f.x)*c,s=(t.max.x-f.x)*c):(n=(t.max.x-f.x)*c,s=(t.min.x-f.x)*c),h>=0?(r=(t.min.y-f.y)*h,o=(t.max.y-f.y)*h):(r=(t.max.y-f.y)*h,o=(t.min.y-f.y)*h),n>o||r>s||((r>n||isNaN(n))&&(n=r),(o<s||isNaN(s))&&(s=o),u>=0?(a=(t.min.z-f.z)*u,l=(t.max.z-f.z)*u):(a=(t.max.z-f.z)*u,l=(t.min.z-f.z)*u),n>l||a>s)||((a>n||n!==n)&&(n=a),(l<s||s!==s)&&(s=l),s<0)?null:this.at(n>=0?n:s,e)}intersectsBox(t){return this.intersectBox(t,Sn)!==null}intersectTriangle(t,e,n,s,r){Ma.subVectors(e,t),mr.subVectors(n,t),Sa.crossVectors(Ma,mr);let o=this.direction.dot(Sa),a;if(o>0){if(s)return null;a=1}else if(o<0)a=-1,o=-o;else return null;Nn.subVectors(this.origin,t);let l=a*this.direction.dot(mr.crossVectors(Nn,mr));if(l<0)return null;let c=a*this.direction.dot(Ma.cross(Nn));if(c<0||l+c>o)return null;let h=-a*Nn.dot(Sa);return h<0?null:this.at(h/o,r)}applyMatrix4(t){return this.origin.applyMatrix4(t),this.direction.transformDirection(t),this}equals(t){return t.origin.equals(this.origin)&&t.direction.equals(this.direction)}clone(){return new this.constructor().copy(this)}},fe=class i{constructor(t,e,n,s,r,o,a,l,c,h,u,f,p,g,y,m){i.prototype.isMatrix4=!0,this.elements=[1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1],t!==void 0&&this.set(t,e,n,s,r,o,a,l,c,h,u,f,p,g,y,m)}set(t,e,n,s,r,o,a,l,c,h,u,f,p,g,y,m){let d=this.elements;return d[0]=t,d[4]=e,d[8]=n,d[12]=s,d[1]=r,d[5]=o,d[9]=a,d[13]=l,d[2]=c,d[6]=h,d[10]=u,d[14]=f,d[3]=p,d[7]=g,d[11]=y,d[15]=m,this}identity(){return this.set(1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1),this}clone(){return new i().fromArray(this.elements)}copy(t){let e=this.elements,n=t.elements;return e[0]=n[0],e[1]=n[1],e[2]=n[2],e[3]=n[3],e[4]=n[4],e[5]=n[5],e[6]=n[6],e[7]=n[7],e[8]=n[8],e[9]=n[9],e[10]=n[10],e[11]=n[11],e[12]=n[12],e[13]=n[13],e[14]=n[14],e[15]=n[15],this}copyPosition(t){let e=this.elements,n=t.elements;return e[12]=n[12],e[13]=n[13],e[14]=n[14],this}setFromMatrix3(t){let e=t.elements;return this.set(e[0],e[3],e[6],0,e[1],e[4],e[7],0,e[2],e[5],e[8],0,0,0,0,1),this}extractBasis(t,e,n){return t.setFromMatrixColumn(this,0),e.setFromMatrixColumn(this,1),n.setFromMatrixColumn(this,2),this}makeBasis(t,e,n){return this.set(t.x,e.x,n.x,0,t.y,e.y,n.y,0,t.z,e.z,n.z,0,0,0,0,1),this}extractRotation(t){let e=this.elements,n=t.elements,s=1/Ii.setFromMatrixColumn(t,0).length(),r=1/Ii.setFromMatrixColumn(t,1).length(),o=1/Ii.setFromMatrixColumn(t,2).length();return e[0]=n[0]*s,e[1]=n[1]*s,e[2]=n[2]*s,e[3]=0,e[4]=n[4]*r,e[5]=n[5]*r,e[6]=n[6]*r,e[7]=0,e[8]=n[8]*o,e[9]=n[9]*o,e[10]=n[10]*o,e[11]=0,e[12]=0,e[13]=0,e[14]=0,e[15]=1,this}makeRotationFromEuler(t){let e=this.elements,n=t.x,s=t.y,r=t.z,o=Math.cos(n),a=Math.sin(n),l=Math.cos(s),c=Math.sin(s),h=Math.cos(r),u=Math.sin(r);if(t.order==="XYZ"){let f=o*h,p=o*u,g=a*h,y=a*u;e[0]=l*h,e[4]=-l*u,e[8]=c,e[1]=p+g*c,e[5]=f-y*c,e[9]=-a*l,e[2]=y-f*c,e[6]=g+p*c,e[10]=o*l}else if(t.order==="YXZ"){let f=l*h,p=l*u,g=c*h,y=c*u;e[0]=f+y*a,e[4]=g*a-p,e[8]=o*c,e[1]=o*u,e[5]=o*h,e[9]=-a,e[2]=p*a-g,e[6]=y+f*a,e[10]=o*l}else if(t.order==="ZXY"){let f=l*h,p=l*u,g=c*h,y=c*u;e[0]=f-y*a,e[4]=-o*u,e[8]=g+p*a,e[1]=p+g*a,e[5]=o*h,e[9]=y-f*a,e[2]=-o*c,e[6]=a,e[10]=o*l}else if(t.order==="ZYX"){let f=o*h,p=o*u,g=a*h,y=a*u;e[0]=l*h,e[4]=g*c-p,e[8]=f*c+y,e[1]=l*u,e[5]=y*c+f,e[9]=p*c-g,e[2]=-c,e[6]=a*l,e[10]=o*l}else if(t.order==="YZX"){let f=o*l,p=o*c,g=a*l,y=a*c;e[0]=l*h,e[4]=y-f*u,e[8]=g*u+p,e[1]=u,e[5]=o*h,e[9]=-a*h,e[2]=-c*h,e[6]=p*u+g,e[10]=f-y*u}else if(t.order==="XZY"){let f=o*l,p=o*c,g=a*l,y=a*c;e[0]=l*h,e[4]=-u,e[8]=c*h,e[1]=f*u+y,e[5]=o*h,e[9]=p*u-g,e[2]=g*u-p,e[6]=a*h,e[10]=y*u+f}return e[3]=0,e[7]=0,e[11]=0,e[12]=0,e[13]=0,e[14]=0,e[15]=1,this}makeRotationFromQuaternion(t){return this.compose(zu,t,ku)}lookAt(t,e,n){let s=this.elements;return Ve.subVectors(t,e),Ve.lengthSq()===0&&(Ve.z=1),Ve.normalize(),Fn.crossVectors(n,Ve),Fn.lengthSq()===0&&(Math.abs(n.z)===1?Ve.x+=1e-4:Ve.z+=1e-4,Ve.normalize(),Fn.crossVectors(n,Ve)),Fn.normalize(),gr.crossVectors(Ve,Fn),s[0]=Fn.x,s[4]=gr.x,s[8]=Ve.x,s[1]=Fn.y,s[5]=gr.y,s[9]=Ve.y,s[2]=Fn.z,s[6]=gr.z,s[10]=Ve.z,this}multiply(t){return this.multiplyMatrices(this,t)}premultiply(t){return this.multiplyMatrices(t,this)}multiplyMatrices(t,e){let n=t.elements,s=e.elements,r=this.elements,o=n[0],a=n[4],l=n[8],c=n[12],h=n[1],u=n[5],f=n[9],p=n[13],g=n[2],y=n[6],m=n[10],d=n[14],w=n[3],E=n[7],v=n[11],C=n[15],A=s[0],I=s[4],U=s[8],S=s[12],M=s[1],R=s[5],O=s[9],k=s[13],W=s[2],q=s[6],G=s[10],et=s[14],H=s[3],ut=s[7],xt=s[11],Mt=s[15];return r[0]=o*A+a*M+l*W+c*H,r[4]=o*I+a*R+l*q+c*ut,r[8]=o*U+a*O+l*G+c*xt,r[12]=o*S+a*k+l*et+c*Mt,r[1]=h*A+u*M+f*W+p*H,r[5]=h*I+u*R+f*q+p*ut,r[9]=h*U+u*O+f*G+p*xt,r[13]=h*S+u*k+f*et+p*Mt,r[2]=g*A+y*M+m*W+d*H,r[6]=g*I+y*R+m*q+d*ut,r[10]=g*U+y*O+m*G+d*xt,r[14]=g*S+y*k+m*et+d*Mt,r[3]=w*A+E*M+v*W+C*H,r[7]=w*I+E*R+v*q+C*ut,r[11]=w*U+E*O+v*G+C*xt,r[15]=w*S+E*k+v*et+C*Mt,this}multiplyScalar(t){let e=this.elements;return e[0]*=t,e[4]*=t,e[8]*=t,e[12]*=t,e[1]*=t,e[5]*=t,e[9]*=t,e[13]*=t,e[2]*=t,e[6]*=t,e[10]*=t,e[14]*=t,e[3]*=t,e[7]*=t,e[11]*=t,e[15]*=t,this}determinant(){let t=this.elements,e=t[0],n=t[4],s=t[8],r=t[12],o=t[1],a=t[5],l=t[9],c=t[13],h=t[2],u=t[6],f=t[10],p=t[14],g=t[3],y=t[7],m=t[11],d=t[15];return g*(+r*l*u-s*c*u-r*a*f+n*c*f+s*a*p-n*l*p)+y*(+e*l*p-e*c*f+r*o*f-s*o*p+s*c*h-r*l*h)+m*(+e*c*u-e*a*p-r*o*u+n*o*p+r*a*h-n*c*h)+d*(-s*a*h-e*l*u+e*a*f+s*o*u-n*o*f+n*l*h)}transpose(){let t=this.elements,e;return e=t[1],t[1]=t[4],t[4]=e,e=t[2],t[2]=t[8],t[8]=e,e=t[6],t[6]=t[9],t[9]=e,e=t[3],t[3]=t[12],t[12]=e,e=t[7],t[7]=t[13],t[13]=e,e=t[11],t[11]=t[14],t[14]=e,this}setPosition(t,e,n){let s=this.elements;return t.isVector3?(s[12]=t.x,s[13]=t.y,s[14]=t.z):(s[12]=t,s[13]=e,s[14]=n),this}invert(){let t=this.elements,e=t[0],n=t[1],s=t[2],r=t[3],o=t[4],a=t[5],l=t[6],c=t[7],h=t[8],u=t[9],f=t[10],p=t[11],g=t[12],y=t[13],m=t[14],d=t[15],w=u*m*c-y*f*c+y*l*p-a*m*p-u*l*d+a*f*d,E=g*f*c-h*m*c-g*l*p+o*m*p+h*l*d-o*f*d,v=h*y*c-g*u*c+g*a*p-o*y*p-h*a*d+o*u*d,C=g*u*l-h*y*l-g*a*f+o*y*f+h*a*m-o*u*m,A=e*w+n*E+s*v+r*C;if(A===0)return this.set(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);let I=1/A;return t[0]=w*I,t[1]=(y*f*r-u*m*r-y*s*p+n*m*p+u*s*d-n*f*d)*I,t[2]=(a*m*r-y*l*r+y*s*c-n*m*c-a*s*d+n*l*d)*I,t[3]=(u*l*r-a*f*r-u*s*c+n*f*c+a*s*p-n*l*p)*I,t[4]=E*I,t[5]=(h*m*r-g*f*r+g*s*p-e*m*p-h*s*d+e*f*d)*I,t[6]=(g*l*r-o*m*r-g*s*c+e*m*c+o*s*d-e*l*d)*I,t[7]=(o*f*r-h*l*r+h*s*c-e*f*c-o*s*p+e*l*p)*I,t[8]=v*I,t[9]=(g*u*r-h*y*r-g*n*p+e*y*p+h*n*d-e*u*d)*I,t[10]=(o*y*r-g*a*r+g*n*c-e*y*c-o*n*d+e*a*d)*I,t[11]=(h*a*r-o*u*r-h*n*c+e*u*c+o*n*p-e*a*p)*I,t[12]=C*I,t[13]=(h*y*s-g*u*s+g*n*f-e*y*f-h*n*m+e*u*m)*I,t[14]=(g*a*s-o*y*s-g*n*l+e*y*l+o*n*m-e*a*m)*I,t[15]=(o*u*s-h*a*s+h*n*l-e*u*l-o*n*f+e*a*f)*I,this}scale(t){let e=this.elements,n=t.x,s=t.y,r=t.z;return e[0]*=n,e[4]*=s,e[8]*=r,e[1]*=n,e[5]*=s,e[9]*=r,e[2]*=n,e[6]*=s,e[10]*=r,e[3]*=n,e[7]*=s,e[11]*=r,this}getMaxScaleOnAxis(){let t=this.elements,e=t[0]*t[0]+t[1]*t[1]+t[2]*t[2],n=t[4]*t[4]+t[5]*t[5]+t[6]*t[6],s=t[8]*t[8]+t[9]*t[9]+t[10]*t[10];return Math.sqrt(Math.max(e,n,s))}makeTranslation(t,e,n){return t.isVector3?this.set(1,0,0,t.x,0,1,0,t.y,0,0,1,t.z,0,0,0,1):this.set(1,0,0,t,0,1,0,e,0,0,1,n,0,0,0,1),this}makeRotationX(t){let e=Math.cos(t),n=Math.sin(t);return this.set(1,0,0,0,0,e,-n,0,0,n,e,0,0,0,0,1),this}makeRotationY(t){let e=Math.cos(t),n=Math.sin(t);return this.set(e,0,n,0,0,1,0,0,-n,0,e,0,0,0,0,1),this}makeRotationZ(t){let e=Math.cos(t),n=Math.sin(t);return this.set(e,-n,0,0,n,e,0,0,0,0,1,0,0,0,0,1),this}makeRotationAxis(t,e){let n=Math.cos(e),s=Math.sin(e),r=1-n,o=t.x,a=t.y,l=t.z,c=r*o,h=r*a;return this.set(c*o+n,c*a-s*l,c*l+s*a,0,c*a+s*l,h*a+n,h*l-s*o,0,c*l-s*a,h*l+s*o,r*l*l+n,0,0,0,0,1),this}makeScale(t,e,n){return this.set(t,0,0,0,0,e,0,0,0,0,n,0,0,0,0,1),this}makeShear(t,e,n,s,r,o){return this.set(1,n,r,0,t,1,o,0,e,s,1,0,0,0,0,1),this}compose(t,e,n){let s=this.elements,r=e._x,o=e._y,a=e._z,l=e._w,c=r+r,h=o+o,u=a+a,f=r*c,p=r*h,g=r*u,y=o*h,m=o*u,d=a*u,w=l*c,E=l*h,v=l*u,C=n.x,A=n.y,I=n.z;return s[0]=(1-(y+d))*C,s[1]=(p+v)*C,s[2]=(g-E)*C,s[3]=0,s[4]=(p-v)*A,s[5]=(1-(f+d))*A,s[6]=(m+w)*A,s[7]=0,s[8]=(g+E)*I,s[9]=(m-w)*I,s[10]=(1-(f+y))*I,s[11]=0,s[12]=t.x,s[13]=t.y,s[14]=t.z,s[15]=1,this}decompose(t,e,n){let s=this.elements,r=Ii.set(s[0],s[1],s[2]).length(),o=Ii.set(s[4],s[5],s[6]).length(),a=Ii.set(s[8],s[9],s[10]).length();this.determinant()<0&&(r=-r),t.x=s[12],t.y=s[13],t.z=s[14],en.copy(this);let c=1/r,h=1/o,u=1/a;return en.elements[0]*=c,en.elements[1]*=c,en.elements[2]*=c,en.elements[4]*=h,en.elements[5]*=h,en.elements[6]*=h,en.elements[8]*=u,en.elements[9]*=u,en.elements[10]*=u,e.setFromRotationMatrix(en),n.x=r,n.y=o,n.z=a,this}makePerspective(t,e,n,s,r,o,a=sn,l=!1){let c=this.elements,h=2*r/(e-t),u=2*r/(n-s),f=(e+t)/(e-t),p=(n+s)/(n-s),g,y;if(l)g=r/(o-r),y=o*r/(o-r);else if(a===sn)g=-(o+r)/(o-r),y=-2*o*r/(o-r);else if(a===bs)g=-o/(o-r),y=-o*r/(o-r);else throw new Error("THREE.Matrix4.makePerspective(): Invalid coordinate system: "+a);return c[0]=h,c[4]=0,c[8]=f,c[12]=0,c[1]=0,c[5]=u,c[9]=p,c[13]=0,c[2]=0,c[6]=0,c[10]=g,c[14]=y,c[3]=0,c[7]=0,c[11]=-1,c[15]=0,this}makeOrthographic(t,e,n,s,r,o,a=sn,l=!1){let c=this.elements,h=2/(e-t),u=2/(n-s),f=-(e+t)/(e-t),p=-(n+s)/(n-s),g,y;if(l)g=1/(o-r),y=o/(o-r);else if(a===sn)g=-2/(o-r),y=-(o+r)/(o-r);else if(a===bs)g=-1/(o-r),y=-r/(o-r);else throw new Error("THREE.Matrix4.makeOrthographic(): Invalid coordinate system: "+a);return c[0]=h,c[4]=0,c[8]=0,c[12]=f,c[1]=0,c[5]=u,c[9]=0,c[13]=p,c[2]=0,c[6]=0,c[10]=g,c[14]=y,c[3]=0,c[7]=0,c[11]=0,c[15]=1,this}equals(t){let e=this.elements,n=t.elements;for(let s=0;s<16;s++)if(e[s]!==n[s])return!1;return!0}fromArray(t,e=0){for(let n=0;n<16;n++)this.elements[n]=t[n+e];return this}toArray(t=[],e=0){let n=this.elements;return t[e]=n[0],t[e+1]=n[1],t[e+2]=n[2],t[e+3]=n[3],t[e+4]=n[4],t[e+5]=n[5],t[e+6]=n[6],t[e+7]=n[7],t[e+8]=n[8],t[e+9]=n[9],t[e+10]=n[10],t[e+11]=n[11],t[e+12]=n[12],t[e+13]=n[13],t[e+14]=n[14],t[e+15]=n[15],t}},Ii=new D,en=new fe,zu=new D(0,0,0),ku=new D(1,1,1),Fn=new D,gr=new D,Ve=new D,rc=new fe,oc=new je,on=class i{constructor(t=0,e=0,n=0,s=i.DEFAULT_ORDER){this.isEuler=!0,this._x=t,this._y=e,this._z=n,this._order=s}get x(){return this._x}set x(t){this._x=t,this._onChangeCallback()}get y(){return this._y}set y(t){this._y=t,this._onChangeCallback()}get z(){return this._z}set z(t){this._z=t,this._onChangeCallback()}get order(){return this._order}set order(t){this._order=t,this._onChangeCallback()}set(t,e,n,s=this._order){return this._x=t,this._y=e,this._z=n,this._order=s,this._onChangeCallback(),this}clone(){return new this.constructor(this._x,this._y,this._z,this._order)}copy(t){return this._x=t._x,this._y=t._y,this._z=t._z,this._order=t._order,this._onChangeCallback(),this}setFromRotationMatrix(t,e=this._order,n=!0){let s=t.elements,r=s[0],o=s[4],a=s[8],l=s[1],c=s[5],h=s[9],u=s[2],f=s[6],p=s[10];switch(e){case"XYZ":this._y=Math.asin(Gt(a,-1,1)),Math.abs(a)<.9999999?(this._x=Math.atan2(-h,p),this._z=Math.atan2(-o,r)):(this._x=Math.atan2(f,c),this._z=0);break;case"YXZ":this._x=Math.asin(-Gt(h,-1,1)),Math.abs(h)<.9999999?(this._y=Math.atan2(a,p),this._z=Math.atan2(l,c)):(this._y=Math.atan2(-u,r),this._z=0);break;case"ZXY":this._x=Math.asin(Gt(f,-1,1)),Math.abs(f)<.9999999?(this._y=Math.atan2(-u,p),this._z=Math.atan2(-o,c)):(this._y=0,this._z=Math.atan2(l,r));break;case"ZYX":this._y=Math.asin(-Gt(u,-1,1)),Math.abs(u)<.9999999?(this._x=Math.atan2(f,p),this._z=Math.atan2(l,r)):(this._x=0,this._z=Math.atan2(-o,c));break;case"YZX":this._z=Math.asin(Gt(l,-1,1)),Math.abs(l)<.9999999?(this._x=Math.atan2(-h,c),this._y=Math.atan2(-u,r)):(this._x=0,this._y=Math.atan2(a,p));break;case"XZY":this._z=Math.asin(-Gt(o,-1,1)),Math.abs(o)<.9999999?(this._x=Math.atan2(f,c),this._y=Math.atan2(a,r)):(this._x=Math.atan2(-h,p),this._y=0);break;default:console.warn("THREE.Euler: .setFromRotationMatrix() encountered an unknown order: "+e)}return this._order=e,n===!0&&this._onChangeCallback(),this}setFromQuaternion(t,e,n){return rc.makeRotationFromQuaternion(t),this.setFromRotationMatrix(rc,e,n)}setFromVector3(t,e=this._order){return this.set(t.x,t.y,t.z,e)}reorder(t){return oc.setFromEuler(this),this.setFromQuaternion(oc,t)}equals(t){return t._x===this._x&&t._y===this._y&&t._z===this._z&&t._order===this._order}fromArray(t){return this._x=t[0],this._y=t[1],this._z=t[2],t[3]!==void 0&&(this._order=t[3]),this._onChangeCallback(),this}toArray(t=[],e=0){return t[e]=this._x,t[e+1]=this._y,t[e+2]=this._z,t[e+3]=this._order,t}_onChange(t){return this._onChangeCallback=t,this}_onChangeCallback(){}*[Symbol.iterator](){yield this._x,yield this._y,yield this._z,yield this._order}};on.DEFAULT_ORDER="XYZ";var Xi=class{constructor(){this.mask=1}set(t){this.mask=(1<<t|0)>>>0}enable(t){this.mask|=1<<t|0}enableAll(){this.mask=-1}toggle(t){this.mask^=1<<t|0}disable(t){this.mask&=~(1<<t|0)}disableAll(){this.mask=0}test(t){return(this.mask&t.mask)!==0}isEnabled(t){return(this.mask&(1<<t|0))!==0}},Vu=0,ac=new D,Pi=new je,bn=new fe,_r=new D,ps=new D,Hu=new D,Gu=new je,lc=new D(1,0,0),cc=new D(0,1,0),hc=new D(0,0,1),uc={type:"added"},Wu={type:"removed"},Di={type:"childadded",child:null},ba={type:"childremoved",child:null},Re=class i extends fn{constructor(){super(),this.isObject3D=!0,Object.defineProperty(this,"id",{value:Vu++}),this.uuid=mi(),this.name="",this.type="Object3D",this.parent=null,this.children=[],this.up=i.DEFAULT_UP.clone();let t=new D,e=new on,n=new je,s=new D(1,1,1);function r(){n.setFromEuler(e,!1)}function o(){e.setFromQuaternion(n,void 0,!1)}e._onChange(r),n._onChange(o),Object.defineProperties(this,{position:{configurable:!0,enumerable:!0,value:t},rotation:{configurable:!0,enumerable:!0,value:e},quaternion:{configurable:!0,enumerable:!0,value:n},scale:{configurable:!0,enumerable:!0,value:s},modelViewMatrix:{value:new fe},normalMatrix:{value:new Vt}}),this.matrix=new fe,this.matrixWorld=new fe,this.matrixAutoUpdate=i.DEFAULT_MATRIX_AUTO_UPDATE,this.matrixWorldAutoUpdate=i.DEFAULT_MATRIX_WORLD_AUTO_UPDATE,this.matrixWorldNeedsUpdate=!1,this.layers=new Xi,this.visible=!0,this.castShadow=!1,this.receiveShadow=!1,this.frustumCulled=!0,this.renderOrder=0,this.animations=[],this.customDepthMaterial=void 0,this.customDistanceMaterial=void 0,this.userData={}}onBeforeShadow(){}onAfterShadow(){}onBeforeRender(){}onAfterRender(){}applyMatrix4(t){this.matrixAutoUpdate&&this.updateMatrix(),this.matrix.premultiply(t),this.matrix.decompose(this.position,this.quaternion,this.scale)}applyQuaternion(t){return this.quaternion.premultiply(t),this}setRotationFromAxisAngle(t,e){this.quaternion.setFromAxisAngle(t,e)}setRotationFromEuler(t){this.quaternion.setFromEuler(t,!0)}setRotationFromMatrix(t){this.quaternion.setFromRotationMatrix(t)}setRotationFromQuaternion(t){this.quaternion.copy(t)}rotateOnAxis(t,e){return Pi.setFromAxisAngle(t,e),this.quaternion.multiply(Pi),this}rotateOnWorldAxis(t,e){return Pi.setFromAxisAngle(t,e),this.quaternion.premultiply(Pi),this}rotateX(t){return this.rotateOnAxis(lc,t)}rotateY(t){return this.rotateOnAxis(cc,t)}rotateZ(t){return this.rotateOnAxis(hc,t)}translateOnAxis(t,e){return ac.copy(t).applyQuaternion(this.quaternion),this.position.add(ac.multiplyScalar(e)),this}translateX(t){return this.translateOnAxis(lc,t)}translateY(t){return this.translateOnAxis(cc,t)}translateZ(t){return this.translateOnAxis(hc,t)}localToWorld(t){return this.updateWorldMatrix(!0,!1),t.applyMatrix4(this.matrixWorld)}worldToLocal(t){return this.updateWorldMatrix(!0,!1),t.applyMatrix4(bn.copy(this.matrixWorld).invert())}lookAt(t,e,n){t.isVector3?_r.copy(t):_r.set(t,e,n);let s=this.parent;this.updateWorldMatrix(!0,!1),ps.setFromMatrixPosition(this.matrixWorld),this.isCamera||this.isLight?bn.lookAt(ps,_r,this.up):bn.lookAt(_r,ps,this.up),this.quaternion.setFromRotationMatrix(bn),s&&(bn.extractRotation(s.matrixWorld),Pi.setFromRotationMatrix(bn),this.quaternion.premultiply(Pi.invert()))}add(t){if(arguments.length>1){for(let e=0;e<arguments.length;e++)this.add(arguments[e]);return this}return t===this?(console.error("THREE.Object3D.add: object can't be added as a child of itself.",t),this):(t&&t.isObject3D?(t.removeFromParent(),t.parent=this,this.children.push(t),t.dispatchEvent(uc),Di.child=t,this.dispatchEvent(Di),Di.child=null):console.error("THREE.Object3D.add: object not an instance of THREE.Object3D.",t),this)}remove(t){if(arguments.length>1){for(let n=0;n<arguments.length;n++)this.remove(arguments[n]);return this}let e=this.children.indexOf(t);return e!==-1&&(t.parent=null,this.children.splice(e,1),t.dispatchEvent(Wu),ba.child=t,this.dispatchEvent(ba),ba.child=null),this}removeFromParent(){let t=this.parent;return t!==null&&t.remove(this),this}clear(){return this.remove(...this.children)}attach(t){return this.updateWorldMatrix(!0,!1),bn.copy(this.matrixWorld).invert(),t.parent!==null&&(t.parent.updateWorldMatrix(!0,!1),bn.multiply(t.parent.matrixWorld)),t.applyMatrix4(bn),t.removeFromParent(),t.parent=this,this.children.push(t),t.updateWorldMatrix(!1,!0),t.dispatchEvent(uc),Di.child=t,this.dispatchEvent(Di),Di.child=null,this}getObjectById(t){return this.getObjectByProperty("id",t)}getObjectByName(t){return this.getObjectByProperty("name",t)}getObjectByProperty(t,e){if(this[t]===e)return this;for(let n=0,s=this.children.length;n<s;n++){let o=this.children[n].getObjectByProperty(t,e);if(o!==void 0)return o}}getObjectsByProperty(t,e,n=[]){this[t]===e&&n.push(this);let s=this.children;for(let r=0,o=s.length;r<o;r++)s[r].getObjectsByProperty(t,e,n);return n}getWorldPosition(t){return this.updateWorldMatrix(!0,!1),t.setFromMatrixPosition(this.matrixWorld)}getWorldQuaternion(t){return this.updateWorldMatrix(!0,!1),this.matrixWorld.decompose(ps,t,Hu),t}getWorldScale(t){return this.updateWorldMatrix(!0,!1),this.matrixWorld.decompose(ps,Gu,t),t}getWorldDirection(t){this.updateWorldMatrix(!0,!1);let e=this.matrixWorld.elements;return t.set(e[8],e[9],e[10]).normalize()}raycast(){}traverse(t){t(this);let e=this.children;for(let n=0,s=e.length;n<s;n++)e[n].traverse(t)}traverseVisible(t){if(this.visible===!1)return;t(this);let e=this.children;for(let n=0,s=e.length;n<s;n++)e[n].traverseVisible(t)}traverseAncestors(t){let e=this.parent;e!==null&&(t(e),e.traverseAncestors(t))}updateMatrix(){this.matrix.compose(this.position,this.quaternion,this.scale),this.matrixWorldNeedsUpdate=!0}updateMatrixWorld(t){this.matrixAutoUpdate&&this.updateMatrix(),(this.matrixWorldNeedsUpdate||t)&&(this.matrixWorldAutoUpdate===!0&&(this.parent===null?this.matrixWorld.copy(this.matrix):this.matrixWorld.multiplyMatrices(this.parent.matrixWorld,this.matrix)),this.matrixWorldNeedsUpdate=!1,t=!0);let e=this.children;for(let n=0,s=e.length;n<s;n++)e[n].updateMatrixWorld(t)}updateWorldMatrix(t,e){let n=this.parent;if(t===!0&&n!==null&&n.updateWorldMatrix(!0,!1),this.matrixAutoUpdate&&this.updateMatrix(),this.matrixWorldAutoUpdate===!0&&(this.parent===null?this.matrixWorld.copy(this.matrix):this.matrixWorld.multiplyMatrices(this.parent.matrixWorld,this.matrix)),e===!0){let s=this.children;for(let r=0,o=s.length;r<o;r++)s[r].updateWorldMatrix(!1,!0)}}toJSON(t){let e=t===void 0||typeof t=="string",n={};e&&(t={geometries:{},materials:{},textures:{},images:{},shapes:{},skeletons:{},animations:{},nodes:{}},n.metadata={version:4.7,type:"Object",generator:"Object3D.toJSON"});let s={};s.uuid=this.uuid,s.type=this.type,this.name!==""&&(s.name=this.name),this.castShadow===!0&&(s.castShadow=!0),this.receiveShadow===!0&&(s.receiveShadow=!0),this.visible===!1&&(s.visible=!1),this.frustumCulled===!1&&(s.frustumCulled=!1),this.renderOrder!==0&&(s.renderOrder=this.renderOrder),Object.keys(this.userData).length>0&&(s.userData=this.userData),s.layers=this.layers.mask,s.matrix=this.matrix.toArray(),s.up=this.up.toArray(),this.matrixAutoUpdate===!1&&(s.matrixAutoUpdate=!1),this.isInstancedMesh&&(s.type="InstancedMesh",s.count=this.count,s.instanceMatrix=this.instanceMatrix.toJSON(),this.instanceColor!==null&&(s.instanceColor=this.instanceColor.toJSON())),this.isBatchedMesh&&(s.type="BatchedMesh",s.perObjectFrustumCulled=this.perObjectFrustumCulled,s.sortObjects=this.sortObjects,s.drawRanges=this._drawRanges,s.reservedRanges=this._reservedRanges,s.geometryInfo=this._geometryInfo.map(a=>({...a,boundingBox:a.boundingBox?a.boundingBox.toJSON():void 0,boundingSphere:a.boundingSphere?a.boundingSphere.toJSON():void 0})),s.instanceInfo=this._instanceInfo.map(a=>({...a})),s.availableInstanceIds=this._availableInstanceIds.slice(),s.availableGeometryIds=this._availableGeometryIds.slice(),s.nextIndexStart=this._nextIndexStart,s.nextVertexStart=this._nextVertexStart,s.geometryCount=this._geometryCount,s.maxInstanceCount=this._maxInstanceCount,s.maxVertexCount=this._maxVertexCount,s.maxIndexCount=this._maxIndexCount,s.geometryInitialized=this._geometryInitialized,s.matricesTexture=this._matricesTexture.toJSON(t),s.indirectTexture=this._indirectTexture.toJSON(t),this._colorsTexture!==null&&(s.colorsTexture=this._colorsTexture.toJSON(t)),this.boundingSphere!==null&&(s.boundingSphere=this.boundingSphere.toJSON()),this.boundingBox!==null&&(s.boundingBox=this.boundingBox.toJSON()));function r(a,l){return a[l.uuid]===void 0&&(a[l.uuid]=l.toJSON(t)),l.uuid}if(this.isScene)this.background&&(this.background.isColor?s.background=this.background.toJSON():this.background.isTexture&&(s.background=this.background.toJSON(t).uuid)),this.environment&&this.environment.isTexture&&this.environment.isRenderTargetTexture!==!0&&(s.environment=this.environment.toJSON(t).uuid);else if(this.isMesh||this.isLine||this.isPoints){s.geometry=r(t.geometries,this.geometry);let a=this.geometry.parameters;if(a!==void 0&&a.shapes!==void 0){let l=a.shapes;if(Array.isArray(l))for(let c=0,h=l.length;c<h;c++){let u=l[c];r(t.shapes,u)}else r(t.shapes,l)}}if(this.isSkinnedMesh&&(s.bindMode=this.bindMode,s.bindMatrix=this.bindMatrix.toArray(),this.skeleton!==void 0&&(r(t.skeletons,this.skeleton),s.skeleton=this.skeleton.uuid)),this.material!==void 0)if(Array.isArray(this.material)){let a=[];for(let l=0,c=this.material.length;l<c;l++)a.push(r(t.materials,this.material[l]));s.material=a}else s.material=r(t.materials,this.material);if(this.children.length>0){s.children=[];for(let a=0;a<this.children.length;a++)s.children.push(this.children[a].toJSON(t).object)}if(this.animations.length>0){s.animations=[];for(let a=0;a<this.animations.length;a++){let l=this.animations[a];s.animations.push(r(t.animations,l))}}if(e){let a=o(t.geometries),l=o(t.materials),c=o(t.textures),h=o(t.images),u=o(t.shapes),f=o(t.skeletons),p=o(t.animations),g=o(t.nodes);a.length>0&&(n.geometries=a),l.length>0&&(n.materials=l),c.length>0&&(n.textures=c),h.length>0&&(n.images=h),u.length>0&&(n.shapes=u),f.length>0&&(n.skeletons=f),p.length>0&&(n.animations=p),g.length>0&&(n.nodes=g)}return n.object=s,n;function o(a){let l=[];for(let c in a){let h=a[c];delete h.metadata,l.push(h)}return l}}clone(t){return new this.constructor().copy(this,t)}copy(t,e=!0){if(this.name=t.name,this.up.copy(t.up),this.position.copy(t.position),this.rotation.order=t.rotation.order,this.quaternion.copy(t.quaternion),this.scale.copy(t.scale),this.matrix.copy(t.matrix),this.matrixWorld.copy(t.matrixWorld),this.matrixAutoUpdate=t.matrixAutoUpdate,this.matrixWorldAutoUpdate=t.matrixWorldAutoUpdate,this.matrixWorldNeedsUpdate=t.matrixWorldNeedsUpdate,this.layers.mask=t.layers.mask,this.visible=t.visible,this.castShadow=t.castShadow,this.receiveShadow=t.receiveShadow,this.frustumCulled=t.frustumCulled,this.renderOrder=t.renderOrder,this.animations=t.animations.slice(),this.userData=JSON.parse(JSON.stringify(t.userData)),e===!0)for(let n=0;n<t.children.length;n++){let s=t.children[n];this.add(s.clone())}return this}};Re.DEFAULT_UP=new D(0,1,0);Re.DEFAULT_MATRIX_AUTO_UPDATE=!0;Re.DEFAULT_MATRIX_WORLD_AUTO_UPDATE=!0;var nn=new D,En=new D,Ea=new D,Tn=new D,Li=new D,Ui=new D,dc=new D,Ta=new D,wa=new D,Aa=new D,Ca=new pe,Ra=new pe,Ia=new pe,zn=class i{constructor(t=new D,e=new D,n=new D){this.a=t,this.b=e,this.c=n}static getNormal(t,e,n,s){s.subVectors(n,e),nn.subVectors(t,e),s.cross(nn);let r=s.lengthSq();return r>0?s.multiplyScalar(1/Math.sqrt(r)):s.set(0,0,0)}static getBarycoord(t,e,n,s,r){nn.subVectors(s,e),En.subVectors(n,e),Ea.subVectors(t,e);let o=nn.dot(nn),a=nn.dot(En),l=nn.dot(Ea),c=En.dot(En),h=En.dot(Ea),u=o*c-a*a;if(u===0)return r.set(0,0,0),null;let f=1/u,p=(c*l-a*h)*f,g=(o*h-a*l)*f;return r.set(1-p-g,g,p)}static containsPoint(t,e,n,s){return this.getBarycoord(t,e,n,s,Tn)===null?!1:Tn.x>=0&&Tn.y>=0&&Tn.x+Tn.y<=1}static getInterpolation(t,e,n,s,r,o,a,l){return this.getBarycoord(t,e,n,s,Tn)===null?(l.x=0,l.y=0,"z"in l&&(l.z=0),"w"in l&&(l.w=0),null):(l.setScalar(0),l.addScaledVector(r,Tn.x),l.addScaledVector(o,Tn.y),l.addScaledVector(a,Tn.z),l)}static getInterpolatedAttribute(t,e,n,s,r,o){return Ca.setScalar(0),Ra.setScalar(0),Ia.setScalar(0),Ca.fromBufferAttribute(t,e),Ra.fromBufferAttribute(t,n),Ia.fromBufferAttribute(t,s),o.setScalar(0),o.addScaledVector(Ca,r.x),o.addScaledVector(Ra,r.y),o.addScaledVector(Ia,r.z),o}static isFrontFacing(t,e,n,s){return nn.subVectors(n,e),En.subVectors(t,e),nn.cross(En).dot(s)<0}set(t,e,n){return this.a.copy(t),this.b.copy(e),this.c.copy(n),this}setFromPointsAndIndices(t,e,n,s){return this.a.copy(t[e]),this.b.copy(t[n]),this.c.copy(t[s]),this}setFromAttributeAndIndices(t,e,n,s){return this.a.fromBufferAttribute(t,e),this.b.fromBufferAttribute(t,n),this.c.fromBufferAttribute(t,s),this}clone(){return new this.constructor().copy(this)}copy(t){return this.a.copy(t.a),this.b.copy(t.b),this.c.copy(t.c),this}getArea(){return nn.subVectors(this.c,this.b),En.subVectors(this.a,this.b),nn.cross(En).length()*.5}getMidpoint(t){return t.addVectors(this.a,this.b).add(this.c).multiplyScalar(1/3)}getNormal(t){return i.getNormal(this.a,this.b,this.c,t)}getPlane(t){return t.setFromCoplanarPoints(this.a,this.b,this.c)}getBarycoord(t,e){return i.getBarycoord(t,this.a,this.b,this.c,e)}getInterpolation(t,e,n,s,r){return i.getInterpolation(t,this.a,this.b,this.c,e,n,s,r)}containsPoint(t){return i.containsPoint(t,this.a,this.b,this.c)}isFrontFacing(t){return i.isFrontFacing(this.a,this.b,this.c,t)}intersectsBox(t){return t.intersectsTriangle(this)}closestPointToPoint(t,e){let n=this.a,s=this.b,r=this.c,o,a;Li.subVectors(s,n),Ui.subVectors(r,n),Ta.subVectors(t,n);let l=Li.dot(Ta),c=Ui.dot(Ta);if(l<=0&&c<=0)return e.copy(n);wa.subVectors(t,s);let h=Li.dot(wa),u=Ui.dot(wa);if(h>=0&&u<=h)return e.copy(s);let f=l*u-h*c;if(f<=0&&l>=0&&h<=0)return o=l/(l-h),e.copy(n).addScaledVector(Li,o);Aa.subVectors(t,r);let p=Li.dot(Aa),g=Ui.dot(Aa);if(g>=0&&p<=g)return e.copy(r);let y=p*c-l*g;if(y<=0&&c>=0&&g<=0)return a=c/(c-g),e.copy(n).addScaledVector(Ui,a);let m=h*g-p*u;if(m<=0&&u-h>=0&&p-g>=0)return dc.subVectors(r,s),a=(u-h)/(u-h+(p-g)),e.copy(s).addScaledVector(dc,a);let d=1/(m+y+f);return o=y*d,a=f*d,e.copy(n).addScaledVector(Li,o).addScaledVector(Ui,a)}equals(t){return t.a.equals(this.a)&&t.b.equals(this.b)&&t.c.equals(this.c)}},fh={aliceblue:15792383,antiquewhite:16444375,aqua:65535,aquamarine:8388564,azure:15794175,beige:16119260,bisque:16770244,black:0,blanchedalmond:16772045,blue:255,blueviolet:9055202,brown:10824234,burlywood:14596231,cadetblue:6266528,chartreuse:8388352,chocolate:13789470,coral:16744272,cornflowerblue:6591981,cornsilk:16775388,crimson:14423100,cyan:65535,darkblue:139,darkcyan:35723,darkgoldenrod:12092939,darkgray:11119017,darkgreen:25600,darkgrey:11119017,darkkhaki:12433259,darkmagenta:9109643,darkolivegreen:5597999,darkorange:16747520,darkorchid:10040012,darkred:9109504,darksalmon:15308410,darkseagreen:9419919,darkslateblue:4734347,darkslategray:3100495,darkslategrey:3100495,darkturquoise:52945,darkviolet:9699539,deeppink:16716947,deepskyblue:49151,dimgray:6908265,dimgrey:6908265,dodgerblue:2003199,firebrick:11674146,floralwhite:16775920,forestgreen:2263842,fuchsia:16711935,gainsboro:14474460,ghostwhite:16316671,gold:16766720,goldenrod:14329120,gray:8421504,green:32768,greenyellow:11403055,grey:8421504,honeydew:15794160,hotpink:16738740,indianred:13458524,indigo:4915330,ivory:16777200,khaki:15787660,lavender:15132410,lavenderblush:16773365,lawngreen:8190976,lemonchiffon:16775885,lightblue:11393254,lightcoral:15761536,lightcyan:14745599,lightgoldenrodyellow:16448210,lightgray:13882323,lightgreen:9498256,lightgrey:13882323,lightpink:16758465,lightsalmon:16752762,lightseagreen:2142890,lightskyblue:8900346,lightslategray:7833753,lightslategrey:7833753,lightsteelblue:11584734,lightyellow:16777184,lime:65280,limegreen:3329330,linen:16445670,magenta:16711935,maroon:8388608,mediumaquamarine:6737322,mediumblue:205,mediumorchid:12211667,mediumpurple:9662683,mediumseagreen:3978097,mediumslateblue:8087790,mediumspringgreen:64154,mediumturquoise:4772300,mediumvioletred:13047173,midnightblue:1644912,mintcream:16121850,mistyrose:16770273,moccasin:16770229,navajowhite:16768685,navy:128,oldlace:16643558,olive:8421376,olivedrab:7048739,orange:16753920,orangered:16729344,orchid:14315734,palegoldenrod:15657130,palegreen:10025880,paleturquoise:11529966,palevioletred:14381203,papayawhip:16773077,peachpuff:16767673,peru:13468991,pink:16761035,plum:14524637,powderblue:11591910,purple:8388736,rebeccapurple:6697881,red:16711680,rosybrown:12357519,royalblue:4286945,saddlebrown:9127187,salmon:16416882,sandybrown:16032864,seagreen:3050327,seashell:16774638,sienna:10506797,silver:12632256,skyblue:8900331,slateblue:6970061,slategray:7372944,slategrey:7372944,snow:16775930,springgreen:65407,steelblue:4620980,tan:13808780,teal:32896,thistle:14204888,tomato:16737095,turquoise:4251856,violet:15631086,wheat:16113331,white:16777215,whitesmoke:16119285,yellow:16776960,yellowgreen:10145074},On={h:0,s:0,l:0},xr={h:0,s:0,l:0};function Pa(i,t,e){return e<0&&(e+=1),e>1&&(e-=1),e<1/6?i+(t-i)*6*e:e<1/2?t:e<2/3?i+(t-i)*6*(2/3-e):i}var Yt=class{constructor(t,e,n){return this.isColor=!0,this.r=1,this.g=1,this.b=1,this.set(t,e,n)}set(t,e,n){if(e===void 0&&n===void 0){let s=t;s&&s.isColor?this.copy(s):typeof s=="number"?this.setHex(s):typeof s=="string"&&this.setStyle(s)}else this.setRGB(t,e,n);return this}setScalar(t){return this.r=t,this.g=t,this.b=t,this}setHex(t,e=Le){return t=Math.floor(t),this.r=(t>>16&255)/255,this.g=(t>>8&255)/255,this.b=(t&255)/255,$t.colorSpaceToWorking(this,e),this}setRGB(t,e,n,s=$t.workingColorSpace){return this.r=t,this.g=e,this.b=n,$t.colorSpaceToWorking(this,s),this}setHSL(t,e,n,s=$t.workingColorSpace){if(t=gl(t,1),e=Gt(e,0,1),n=Gt(n,0,1),e===0)this.r=this.g=this.b=n;else{let r=n<=.5?n*(1+e):n+e-n*e,o=2*n-r;this.r=Pa(o,r,t+1/3),this.g=Pa(o,r,t),this.b=Pa(o,r,t-1/3)}return $t.colorSpaceToWorking(this,s),this}setStyle(t,e=Le){function n(r){r!==void 0&&parseFloat(r)<1&&console.warn("THREE.Color: Alpha component of "+t+" will be ignored.")}let s;if(s=/^(\w+)\(([^\)]*)\)/.exec(t)){let r,o=s[1],a=s[2];switch(o){case"rgb":case"rgba":if(r=/^\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*(?:,\s*(\d*\.?\d+)\s*)?$/.exec(a))return n(r[4]),this.setRGB(Math.min(255,parseInt(r[1],10))/255,Math.min(255,parseInt(r[2],10))/255,Math.min(255,parseInt(r[3],10))/255,e);if(r=/^\s*(\d+)\%\s*,\s*(\d+)\%\s*,\s*(\d+)\%\s*(?:,\s*(\d*\.?\d+)\s*)?$/.exec(a))return n(r[4]),this.setRGB(Math.min(100,parseInt(r[1],10))/100,Math.min(100,parseInt(r[2],10))/100,Math.min(100,parseInt(r[3],10))/100,e);break;case"hsl":case"hsla":if(r=/^\s*(\d*\.?\d+)\s*,\s*(\d*\.?\d+)\%\s*,\s*(\d*\.?\d+)\%\s*(?:,\s*(\d*\.?\d+)\s*)?$/.exec(a))return n(r[4]),this.setHSL(parseFloat(r[1])/360,parseFloat(r[2])/100,parseFloat(r[3])/100,e);break;default:console.warn("THREE.Color: Unknown color model "+t)}}else if(s=/^\#([A-Fa-f\d]+)$/.exec(t)){let r=s[1],o=r.length;if(o===3)return this.setRGB(parseInt(r.charAt(0),16)/15,parseInt(r.charAt(1),16)/15,parseInt(r.charAt(2),16)/15,e);if(o===6)return this.setHex(parseInt(r,16),e);console.warn("THREE.Color: Invalid hex color "+t)}else if(t&&t.length>0)return this.setColorName(t,e);return this}setColorName(t,e=Le){let n=fh[t.toLowerCase()];return n!==void 0?this.setHex(n,e):console.warn("THREE.Color: Unknown color "+t),this}clone(){return new this.constructor(this.r,this.g,this.b)}copy(t){return this.r=t.r,this.g=t.g,this.b=t.b,this}copySRGBToLinear(t){return this.r=wn(t.r),this.g=wn(t.g),this.b=wn(t.b),this}copyLinearToSRGB(t){return this.r=zi(t.r),this.g=zi(t.g),this.b=zi(t.b),this}convertSRGBToLinear(){return this.copySRGBToLinear(this),this}convertLinearToSRGB(){return this.copyLinearToSRGB(this),this}getHex(t=Le){return $t.workingToColorSpace(Ce.copy(this),t),Math.round(Gt(Ce.r*255,0,255))*65536+Math.round(Gt(Ce.g*255,0,255))*256+Math.round(Gt(Ce.b*255,0,255))}getHexString(t=Le){return("000000"+this.getHex(t).toString(16)).slice(-6)}getHSL(t,e=$t.workingColorSpace){$t.workingToColorSpace(Ce.copy(this),e);let n=Ce.r,s=Ce.g,r=Ce.b,o=Math.max(n,s,r),a=Math.min(n,s,r),l,c,h=(a+o)/2;if(a===o)l=0,c=0;else{let u=o-a;switch(c=h<=.5?u/(o+a):u/(2-o-a),o){case n:l=(s-r)/u+(s<r?6:0);break;case s:l=(r-n)/u+2;break;case r:l=(n-s)/u+4;break}l/=6}return t.h=l,t.s=c,t.l=h,t}getRGB(t,e=$t.workingColorSpace){return $t.workingToColorSpace(Ce.copy(this),e),t.r=Ce.r,t.g=Ce.g,t.b=Ce.b,t}getStyle(t=Le){$t.workingToColorSpace(Ce.copy(this),t);let e=Ce.r,n=Ce.g,s=Ce.b;return t!==Le?`color(${t} ${e.toFixed(3)} ${n.toFixed(3)} ${s.toFixed(3)})`:`rgb(${Math.round(e*255)},${Math.round(n*255)},${Math.round(s*255)})`}offsetHSL(t,e,n){return this.getHSL(On),this.setHSL(On.h+t,On.s+e,On.l+n)}add(t){return this.r+=t.r,this.g+=t.g,this.b+=t.b,this}addColors(t,e){return this.r=t.r+e.r,this.g=t.g+e.g,this.b=t.b+e.b,this}addScalar(t){return this.r+=t,this.g+=t,this.b+=t,this}sub(t){return this.r=Math.max(0,this.r-t.r),this.g=Math.max(0,this.g-t.g),this.b=Math.max(0,this.b-t.b),this}multiply(t){return this.r*=t.r,this.g*=t.g,this.b*=t.b,this}multiplyScalar(t){return this.r*=t,this.g*=t,this.b*=t,this}lerp(t,e){return this.r+=(t.r-this.r)*e,this.g+=(t.g-this.g)*e,this.b+=(t.b-this.b)*e,this}lerpColors(t,e,n){return this.r=t.r+(e.r-t.r)*n,this.g=t.g+(e.g-t.g)*n,this.b=t.b+(e.b-t.b)*n,this}lerpHSL(t,e){this.getHSL(On),t.getHSL(xr);let n=xs(On.h,xr.h,e),s=xs(On.s,xr.s,e),r=xs(On.l,xr.l,e);return this.setHSL(n,s,r),this}setFromVector3(t){return this.r=t.x,this.g=t.y,this.b=t.z,this}applyMatrix3(t){let e=this.r,n=this.g,s=this.b,r=t.elements;return this.r=r[0]*e+r[3]*n+r[6]*s,this.g=r[1]*e+r[4]*n+r[7]*s,this.b=r[2]*e+r[5]*n+r[8]*s,this}equals(t){return t.r===this.r&&t.g===this.g&&t.b===this.b}fromArray(t,e=0){return this.r=t[e],this.g=t[e+1],this.b=t[e+2],this}toArray(t=[],e=0){return t[e]=this.r,t[e+1]=this.g,t[e+2]=this.b,t}fromBufferAttribute(t,e){return this.r=t.getX(e),this.g=t.getY(e),this.b=t.getZ(e),this}toJSON(){return this.getHex()}*[Symbol.iterator](){yield this.r,yield this.g,yield this.b}},Ce=new Yt;Yt.NAMES=fh;var Xu=0,Gn=class extends fn{constructor(){super(),this.isMaterial=!0,Object.defineProperty(this,"id",{value:Xu++}),this.uuid=mi(),this.name="",this.type="Material",this.blending=oi,this.side=An,this.vertexColors=!1,this.opacity=1,this.transparent=!1,this.alphaHash=!1,this.blendSrc=Lr,this.blendDst=Ur,this.blendEquation=Vn,this.blendSrcAlpha=null,this.blendDstAlpha=null,this.blendEquationAlpha=null,this.blendColor=new Yt(0,0,0),this.blendAlpha=0,this.depthFunc=ai,this.depthTest=!0,this.depthWrite=!0,this.stencilWriteMask=255,this.stencilFunc=Ha,this.stencilRef=0,this.stencilFuncMask=255,this.stencilFail=si,this.stencilZFail=si,this.stencilZPass=si,this.stencilWrite=!1,this.clippingPlanes=null,this.clipIntersection=!1,this.clipShadows=!1,this.shadowSide=null,this.colorWrite=!0,this.precision=null,this.polygonOffset=!1,this.polygonOffsetFactor=0,this.polygonOffsetUnits=0,this.dithering=!1,this.alphaToCoverage=!1,this.premultipliedAlpha=!1,this.forceSinglePass=!1,this.allowOverride=!0,this.visible=!0,this.toneMapped=!0,this.userData={},this.version=0,this._alphaTest=0}get alphaTest(){return this._alphaTest}set alphaTest(t){this._alphaTest>0!=t>0&&this.version++,this._alphaTest=t}onBeforeRender(){}onBeforeCompile(){}customProgramCacheKey(){return this.onBeforeCompile.toString()}setValues(t){if(t!==void 0)for(let e in t){let n=t[e];if(n===void 0){console.warn(`THREE.Material: parameter '${e}' has value of undefined.`);continue}let s=this[e];if(s===void 0){console.warn(`THREE.Material: '${e}' is not a property of THREE.${this.type}.`);continue}s&&s.isColor?s.set(n):s&&s.isVector3&&n&&n.isVector3?s.copy(n):this[e]=n}}toJSON(t){let e=t===void 0||typeof t=="string";e&&(t={textures:{},images:{}});let n={metadata:{version:4.7,type:"Material",generator:"Material.toJSON"}};n.uuid=this.uuid,n.type=this.type,this.name!==""&&(n.name=this.name),this.color&&this.color.isColor&&(n.color=this.color.getHex()),this.roughness!==void 0&&(n.roughness=this.roughness),this.metalness!==void 0&&(n.metalness=this.metalness),this.sheen!==void 0&&(n.sheen=this.sheen),this.sheenColor&&this.sheenColor.isColor&&(n.sheenColor=this.sheenColor.getHex()),this.sheenRoughness!==void 0&&(n.sheenRoughness=this.sheenRoughness),this.emissive&&this.emissive.isColor&&(n.emissive=this.emissive.getHex()),this.emissiveIntensity!==void 0&&this.emissiveIntensity!==1&&(n.emissiveIntensity=this.emissiveIntensity),this.specular&&this.specular.isColor&&(n.specular=this.specular.getHex()),this.specularIntensity!==void 0&&(n.specularIntensity=this.specularIntensity),this.specularColor&&this.specularColor.isColor&&(n.specularColor=this.specularColor.getHex()),this.shininess!==void 0&&(n.shininess=this.shininess),this.clearcoat!==void 0&&(n.clearcoat=this.clearcoat),this.clearcoatRoughness!==void 0&&(n.clearcoatRoughness=this.clearcoatRoughness),this.clearcoatMap&&this.clearcoatMap.isTexture&&(n.clearcoatMap=this.clearcoatMap.toJSON(t).uuid),this.clearcoatRoughnessMap&&this.clearcoatRoughnessMap.isTexture&&(n.clearcoatRoughnessMap=this.clearcoatRoughnessMap.toJSON(t).uuid),this.clearcoatNormalMap&&this.clearcoatNormalMap.isTexture&&(n.clearcoatNormalMap=this.clearcoatNormalMap.toJSON(t).uuid,n.clearcoatNormalScale=this.clearcoatNormalScale.toArray()),this.sheenColorMap&&this.sheenColorMap.isTexture&&(n.sheenColorMap=this.sheenColorMap.toJSON(t).uuid),this.sheenRoughnessMap&&this.sheenRoughnessMap.isTexture&&(n.sheenRoughnessMap=this.sheenRoughnessMap.toJSON(t).uuid),this.dispersion!==void 0&&(n.dispersion=this.dispersion),this.iridescence!==void 0&&(n.iridescence=this.iridescence),this.iridescenceIOR!==void 0&&(n.iridescenceIOR=this.iridescenceIOR),this.iridescenceThicknessRange!==void 0&&(n.iridescenceThicknessRange=this.iridescenceThicknessRange),this.iridescenceMap&&this.iridescenceMap.isTexture&&(n.iridescenceMap=this.iridescenceMap.toJSON(t).uuid),this.iridescenceThicknessMap&&this.iridescenceThicknessMap.isTexture&&(n.iridescenceThicknessMap=this.iridescenceThicknessMap.toJSON(t).uuid),this.anisotropy!==void 0&&(n.anisotropy=this.anisotropy),this.anisotropyRotation!==void 0&&(n.anisotropyRotation=this.anisotropyRotation),this.anisotropyMap&&this.anisotropyMap.isTexture&&(n.anisotropyMap=this.anisotropyMap.toJSON(t).uuid),this.map&&this.map.isTexture&&(n.map=this.map.toJSON(t).uuid),this.matcap&&this.matcap.isTexture&&(n.matcap=this.matcap.toJSON(t).uuid),this.alphaMap&&this.alphaMap.isTexture&&(n.alphaMap=this.alphaMap.toJSON(t).uuid),this.lightMap&&this.lightMap.isTexture&&(n.lightMap=this.lightMap.toJSON(t).uuid,n.lightMapIntensity=this.lightMapIntensity),this.aoMap&&this.aoMap.isTexture&&(n.aoMap=this.aoMap.toJSON(t).uuid,n.aoMapIntensity=this.aoMapIntensity),this.bumpMap&&this.bumpMap.isTexture&&(n.bumpMap=this.bumpMap.toJSON(t).uuid,n.bumpScale=this.bumpScale),this.normalMap&&this.normalMap.isTexture&&(n.normalMap=this.normalMap.toJSON(t).uuid,n.normalMapType=this.normalMapType,n.normalScale=this.normalScale.toArray()),this.displacementMap&&this.displacementMap.isTexture&&(n.displacementMap=this.displacementMap.toJSON(t).uuid,n.displacementScale=this.displacementScale,n.displacementBias=this.displacementBias),this.roughnessMap&&this.roughnessMap.isTexture&&(n.roughnessMap=this.roughnessMap.toJSON(t).uuid),this.metalnessMap&&this.metalnessMap.isTexture&&(n.metalnessMap=this.metalnessMap.toJSON(t).uuid),this.emissiveMap&&this.emissiveMap.isTexture&&(n.emissiveMap=this.emissiveMap.toJSON(t).uuid),this.specularMap&&this.specularMap.isTexture&&(n.specularMap=this.specularMap.toJSON(t).uuid),this.specularIntensityMap&&this.specularIntensityMap.isTexture&&(n.specularIntensityMap=this.specularIntensityMap.toJSON(t).uuid),this.specularColorMap&&this.specularColorMap.isTexture&&(n.specularColorMap=this.specularColorMap.toJSON(t).uuid),this.envMap&&this.envMap.isTexture&&(n.envMap=this.envMap.toJSON(t).uuid,this.combine!==void 0&&(n.combine=this.combine)),this.envMapRotation!==void 0&&(n.envMapRotation=this.envMapRotation.toArray()),this.envMapIntensity!==void 0&&(n.envMapIntensity=this.envMapIntensity),this.reflectivity!==void 0&&(n.reflectivity=this.reflectivity),this.refractionRatio!==void 0&&(n.refractionRatio=this.refractionRatio),this.gradientMap&&this.gradientMap.isTexture&&(n.gradientMap=this.gradientMap.toJSON(t).uuid),this.transmission!==void 0&&(n.transmission=this.transmission),this.transmissionMap&&this.transmissionMap.isTexture&&(n.transmissionMap=this.transmissionMap.toJSON(t).uuid),this.thickness!==void 0&&(n.thickness=this.thickness),this.thicknessMap&&this.thicknessMap.isTexture&&(n.thicknessMap=this.thicknessMap.toJSON(t).uuid),this.attenuationDistance!==void 0&&this.attenuationDistance!==1/0&&(n.attenuationDistance=this.attenuationDistance),this.attenuationColor!==void 0&&(n.attenuationColor=this.attenuationColor.getHex()),this.size!==void 0&&(n.size=this.size),this.shadowSide!==null&&(n.shadowSide=this.shadowSide),this.sizeAttenuation!==void 0&&(n.sizeAttenuation=this.sizeAttenuation),this.blending!==oi&&(n.blending=this.blending),this.side!==An&&(n.side=this.side),this.vertexColors===!0&&(n.vertexColors=!0),this.opacity<1&&(n.opacity=this.opacity),this.transparent===!0&&(n.transparent=!0),this.blendSrc!==Lr&&(n.blendSrc=this.blendSrc),this.blendDst!==Ur&&(n.blendDst=this.blendDst),this.blendEquation!==Vn&&(n.blendEquation=this.blendEquation),this.blendSrcAlpha!==null&&(n.blendSrcAlpha=this.blendSrcAlpha),this.blendDstAlpha!==null&&(n.blendDstAlpha=this.blendDstAlpha),this.blendEquationAlpha!==null&&(n.blendEquationAlpha=this.blendEquationAlpha),this.blendColor&&this.blendColor.isColor&&(n.blendColor=this.blendColor.getHex()),this.blendAlpha!==0&&(n.blendAlpha=this.blendAlpha),this.depthFunc!==ai&&(n.depthFunc=this.depthFunc),this.depthTest===!1&&(n.depthTest=this.depthTest),this.depthWrite===!1&&(n.depthWrite=this.depthWrite),this.colorWrite===!1&&(n.colorWrite=this.colorWrite),this.stencilWriteMask!==255&&(n.stencilWriteMask=this.stencilWriteMask),this.stencilFunc!==Ha&&(n.stencilFunc=this.stencilFunc),this.stencilRef!==0&&(n.stencilRef=this.stencilRef),this.stencilFuncMask!==255&&(n.stencilFuncMask=this.stencilFuncMask),this.stencilFail!==si&&(n.stencilFail=this.stencilFail),this.stencilZFail!==si&&(n.stencilZFail=this.stencilZFail),this.stencilZPass!==si&&(n.stencilZPass=this.stencilZPass),this.stencilWrite===!0&&(n.stencilWrite=this.stencilWrite),this.rotation!==void 0&&this.rotation!==0&&(n.rotation=this.rotation),this.polygonOffset===!0&&(n.polygonOffset=!0),this.polygonOffsetFactor!==0&&(n.polygonOffsetFactor=this.polygonOffsetFactor),this.polygonOffsetUnits!==0&&(n.polygonOffsetUnits=this.polygonOffsetUnits),this.linewidth!==void 0&&this.linewidth!==1&&(n.linewidth=this.linewidth),this.dashSize!==void 0&&(n.dashSize=this.dashSize),this.gapSize!==void 0&&(n.gapSize=this.gapSize),this.scale!==void 0&&(n.scale=this.scale),this.dithering===!0&&(n.dithering=!0),this.alphaTest>0&&(n.alphaTest=this.alphaTest),this.alphaHash===!0&&(n.alphaHash=!0),this.alphaToCoverage===!0&&(n.alphaToCoverage=!0),this.premultipliedAlpha===!0&&(n.premultipliedAlpha=!0),this.forceSinglePass===!0&&(n.forceSinglePass=!0),this.wireframe===!0&&(n.wireframe=!0),this.wireframeLinewidth>1&&(n.wireframeLinewidth=this.wireframeLinewidth),this.wireframeLinecap!=="round"&&(n.wireframeLinecap=this.wireframeLinecap),this.wireframeLinejoin!=="round"&&(n.wireframeLinejoin=this.wireframeLinejoin),this.flatShading===!0&&(n.flatShading=!0),this.visible===!1&&(n.visible=!1),this.toneMapped===!1&&(n.toneMapped=!1),this.fog===!1&&(n.fog=!1),Object.keys(this.userData).length>0&&(n.userData=this.userData);function s(r){let o=[];for(let a in r){let l=r[a];delete l.metadata,o.push(l)}return o}if(e){let r=s(t.textures),o=s(t.images);r.length>0&&(n.textures=r),o.length>0&&(n.images=o)}return n}clone(){return new this.constructor().copy(this)}copy(t){this.name=t.name,this.blending=t.blending,this.side=t.side,this.vertexColors=t.vertexColors,this.opacity=t.opacity,this.transparent=t.transparent,this.blendSrc=t.blendSrc,this.blendDst=t.blendDst,this.blendEquation=t.blendEquation,this.blendSrcAlpha=t.blendSrcAlpha,this.blendDstAlpha=t.blendDstAlpha,this.blendEquationAlpha=t.blendEquationAlpha,this.blendColor.copy(t.blendColor),this.blendAlpha=t.blendAlpha,this.depthFunc=t.depthFunc,this.depthTest=t.depthTest,this.depthWrite=t.depthWrite,this.stencilWriteMask=t.stencilWriteMask,this.stencilFunc=t.stencilFunc,this.stencilRef=t.stencilRef,this.stencilFuncMask=t.stencilFuncMask,this.stencilFail=t.stencilFail,this.stencilZFail=t.stencilZFail,this.stencilZPass=t.stencilZPass,this.stencilWrite=t.stencilWrite;let e=t.clippingPlanes,n=null;if(e!==null){let s=e.length;n=new Array(s);for(let r=0;r!==s;++r)n[r]=e[r].clone()}return this.clippingPlanes=n,this.clipIntersection=t.clipIntersection,this.clipShadows=t.clipShadows,this.shadowSide=t.shadowSide,this.colorWrite=t.colorWrite,this.precision=t.precision,this.polygonOffset=t.polygonOffset,this.polygonOffsetFactor=t.polygonOffsetFactor,this.polygonOffsetUnits=t.polygonOffsetUnits,this.dithering=t.dithering,this.alphaTest=t.alphaTest,this.alphaHash=t.alphaHash,this.alphaToCoverage=t.alphaToCoverage,this.premultipliedAlpha=t.premultipliedAlpha,this.forceSinglePass=t.forceSinglePass,this.visible=t.visible,this.toneMapped=t.toneMapped,this.userData=JSON.parse(JSON.stringify(t.userData)),this}dispose(){this.dispatchEvent({type:"dispose"})}set needsUpdate(t){t===!0&&this.version++}},qi=class extends Gn{constructor(t){super(),this.isMeshBasicMaterial=!0,this.type="MeshBasicMaterial",this.color=new Yt(16777215),this.map=null,this.lightMap=null,this.lightMapIntensity=1,this.aoMap=null,this.aoMapIntensity=1,this.specularMap=null,this.alphaMap=null,this.envMap=null,this.envMapRotation=new on,this.combine=il,this.reflectivity=1,this.refractionRatio=.98,this.wireframe=!1,this.wireframeLinewidth=1,this.wireframeLinecap="round",this.wireframeLinejoin="round",this.fog=!0,this.setValues(t)}copy(t){return super.copy(t),this.color.copy(t.color),this.map=t.map,this.lightMap=t.lightMap,this.lightMapIntensity=t.lightMapIntensity,this.aoMap=t.aoMap,this.aoMapIntensity=t.aoMapIntensity,this.specularMap=t.specularMap,this.alphaMap=t.alphaMap,this.envMap=t.envMap,this.envMapRotation.copy(t.envMapRotation),this.combine=t.combine,this.reflectivity=t.reflectivity,this.refractionRatio=t.refractionRatio,this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this.wireframeLinecap=t.wireframeLinecap,this.wireframeLinejoin=t.wireframeLinejoin,this.fog=t.fog,this}};var _e=new D,yr=new at,qu=0,Ge=class{constructor(t,e,n=!1){if(Array.isArray(t))throw new TypeError("THREE.BufferAttribute: array should be a Typed Array.");this.isBufferAttribute=!0,Object.defineProperty(this,"id",{value:qu++}),this.name="",this.array=t,this.itemSize=e,this.count=t!==void 0?t.length/e:0,this.normalized=n,this.usage=Ga,this.updateRanges=[],this.gpuType=_n,this.version=0}onUploadCallback(){}set needsUpdate(t){t===!0&&this.version++}setUsage(t){return this.usage=t,this}addUpdateRange(t,e){this.updateRanges.push({start:t,count:e})}clearUpdateRanges(){this.updateRanges.length=0}copy(t){return this.name=t.name,this.array=new t.array.constructor(t.array),this.itemSize=t.itemSize,this.count=t.count,this.normalized=t.normalized,this.usage=t.usage,this.gpuType=t.gpuType,this}copyAt(t,e,n){t*=this.itemSize,n*=e.itemSize;for(let s=0,r=this.itemSize;s<r;s++)this.array[t+s]=e.array[n+s];return this}copyArray(t){return this.array.set(t),this}applyMatrix3(t){if(this.itemSize===2)for(let e=0,n=this.count;e<n;e++)yr.fromBufferAttribute(this,e),yr.applyMatrix3(t),this.setXY(e,yr.x,yr.y);else if(this.itemSize===3)for(let e=0,n=this.count;e<n;e++)_e.fromBufferAttribute(this,e),_e.applyMatrix3(t),this.setXYZ(e,_e.x,_e.y,_e.z);return this}applyMatrix4(t){for(let e=0,n=this.count;e<n;e++)_e.fromBufferAttribute(this,e),_e.applyMatrix4(t),this.setXYZ(e,_e.x,_e.y,_e.z);return this}applyNormalMatrix(t){for(let e=0,n=this.count;e<n;e++)_e.fromBufferAttribute(this,e),_e.applyNormalMatrix(t),this.setXYZ(e,_e.x,_e.y,_e.z);return this}transformDirection(t){for(let e=0,n=this.count;e<n;e++)_e.fromBufferAttribute(this,e),_e.transformDirection(t),this.setXYZ(e,_e.x,_e.y,_e.z);return this}set(t,e=0){return this.array.set(t,e),this}getComponent(t,e){let n=this.array[t*this.itemSize+e];return this.normalized&&(n=Bi(n,this.array)),n}setComponent(t,e,n){return this.normalized&&(n=De(n,this.array)),this.array[t*this.itemSize+e]=n,this}getX(t){let e=this.array[t*this.itemSize];return this.normalized&&(e=Bi(e,this.array)),e}setX(t,e){return this.normalized&&(e=De(e,this.array)),this.array[t*this.itemSize]=e,this}getY(t){let e=this.array[t*this.itemSize+1];return this.normalized&&(e=Bi(e,this.array)),e}setY(t,e){return this.normalized&&(e=De(e,this.array)),this.array[t*this.itemSize+1]=e,this}getZ(t){let e=this.array[t*this.itemSize+2];return this.normalized&&(e=Bi(e,this.array)),e}setZ(t,e){return this.normalized&&(e=De(e,this.array)),this.array[t*this.itemSize+2]=e,this}getW(t){let e=this.array[t*this.itemSize+3];return this.normalized&&(e=Bi(e,this.array)),e}setW(t,e){return this.normalized&&(e=De(e,this.array)),this.array[t*this.itemSize+3]=e,this}setXY(t,e,n){return t*=this.itemSize,this.normalized&&(e=De(e,this.array),n=De(n,this.array)),this.array[t+0]=e,this.array[t+1]=n,this}setXYZ(t,e,n,s){return t*=this.itemSize,this.normalized&&(e=De(e,this.array),n=De(n,this.array),s=De(s,this.array)),this.array[t+0]=e,this.array[t+1]=n,this.array[t+2]=s,this}setXYZW(t,e,n,s,r){return t*=this.itemSize,this.normalized&&(e=De(e,this.array),n=De(n,this.array),s=De(s,this.array),r=De(r,this.array)),this.array[t+0]=e,this.array[t+1]=n,this.array[t+2]=s,this.array[t+3]=r,this}onUpload(t){return this.onUploadCallback=t,this}clone(){return new this.constructor(this.array,this.itemSize).copy(this)}toJSON(){let t={itemSize:this.itemSize,type:this.array.constructor.name,array:Array.from(this.array),normalized:this.normalized};return this.name!==""&&(t.name=this.name),this.usage!==Ga&&(t.usage=this.usage),t}};var ws=class extends Ge{constructor(t,e,n){super(new Uint16Array(t),e,n)}};var As=class extends Ge{constructor(t,e,n){super(new Uint32Array(t),e,n)}};var Ee=class extends Ge{constructor(t,e,n){super(new Float32Array(t),e,n)}},Yu=0,Je=new fe,Da=new Re,Ni=new D,He=new Hn,ms=new Hn,be=new D,an=class i extends fn{constructor(){super(),this.isBufferGeometry=!0,Object.defineProperty(this,"id",{value:Yu++}),this.uuid=mi(),this.name="",this.type="BufferGeometry",this.index=null,this.indirect=null,this.attributes={},this.morphAttributes={},this.morphTargetsRelative=!1,this.groups=[],this.boundingBox=null,this.boundingSphere=null,this.drawRange={start:0,count:1/0},this.userData={}}getIndex(){return this.index}setIndex(t){return Array.isArray(t)?this.index=new(xl(t)?As:ws)(t,1):this.index=t,this}setIndirect(t){return this.indirect=t,this}getIndirect(){return this.indirect}getAttribute(t){return this.attributes[t]}setAttribute(t,e){return this.attributes[t]=e,this}deleteAttribute(t){return delete this.attributes[t],this}hasAttribute(t){return this.attributes[t]!==void 0}addGroup(t,e,n=0){this.groups.push({start:t,count:e,materialIndex:n})}clearGroups(){this.groups=[]}setDrawRange(t,e){this.drawRange.start=t,this.drawRange.count=e}applyMatrix4(t){let e=this.attributes.position;e!==void 0&&(e.applyMatrix4(t),e.needsUpdate=!0);let n=this.attributes.normal;if(n!==void 0){let r=new Vt().getNormalMatrix(t);n.applyNormalMatrix(r),n.needsUpdate=!0}let s=this.attributes.tangent;return s!==void 0&&(s.transformDirection(t),s.needsUpdate=!0),this.boundingBox!==null&&this.computeBoundingBox(),this.boundingSphere!==null&&this.computeBoundingSphere(),this}applyQuaternion(t){return Je.makeRotationFromQuaternion(t),this.applyMatrix4(Je),this}rotateX(t){return Je.makeRotationX(t),this.applyMatrix4(Je),this}rotateY(t){return Je.makeRotationY(t),this.applyMatrix4(Je),this}rotateZ(t){return Je.makeRotationZ(t),this.applyMatrix4(Je),this}translate(t,e,n){return Je.makeTranslation(t,e,n),this.applyMatrix4(Je),this}scale(t,e,n){return Je.makeScale(t,e,n),this.applyMatrix4(Je),this}lookAt(t){return Da.lookAt(t),Da.updateMatrix(),this.applyMatrix4(Da.matrix),this}center(){return this.computeBoundingBox(),this.boundingBox.getCenter(Ni).negate(),this.translate(Ni.x,Ni.y,Ni.z),this}setFromPoints(t){let e=this.getAttribute("position");if(e===void 0){let n=[];for(let s=0,r=t.length;s<r;s++){let o=t[s];n.push(o.x,o.y,o.z||0)}this.setAttribute("position",new Ee(n,3))}else{let n=Math.min(t.length,e.count);for(let s=0;s<n;s++){let r=t[s];e.setXYZ(s,r.x,r.y,r.z||0)}t.length>e.count&&console.warn("THREE.BufferGeometry: Buffer size too small for points data. Use .dispose() and create a new geometry."),e.needsUpdate=!0}return this}computeBoundingBox(){this.boundingBox===null&&(this.boundingBox=new Hn);let t=this.attributes.position,e=this.morphAttributes.position;if(t&&t.isGLBufferAttribute){console.error("THREE.BufferGeometry.computeBoundingBox(): GLBufferAttribute requires a manual bounding box.",this),this.boundingBox.set(new D(-1/0,-1/0,-1/0),new D(1/0,1/0,1/0));return}if(t!==void 0){if(this.boundingBox.setFromBufferAttribute(t),e)for(let n=0,s=e.length;n<s;n++){let r=e[n];He.setFromBufferAttribute(r),this.morphTargetsRelative?(be.addVectors(this.boundingBox.min,He.min),this.boundingBox.expandByPoint(be),be.addVectors(this.boundingBox.max,He.max),this.boundingBox.expandByPoint(be)):(this.boundingBox.expandByPoint(He.min),this.boundingBox.expandByPoint(He.max))}}else this.boundingBox.makeEmpty();(isNaN(this.boundingBox.min.x)||isNaN(this.boundingBox.min.y)||isNaN(this.boundingBox.min.z))&&console.error('THREE.BufferGeometry.computeBoundingBox(): Computed min/max have NaN values. The "position" attribute is likely to have NaN values.',this)}computeBoundingSphere(){this.boundingSphere===null&&(this.boundingSphere=new Wi);let t=this.attributes.position,e=this.morphAttributes.position;if(t&&t.isGLBufferAttribute){console.error("THREE.BufferGeometry.computeBoundingSphere(): GLBufferAttribute requires a manual bounding sphere.",this),this.boundingSphere.set(new D,1/0);return}if(t){let n=this.boundingSphere.center;if(He.setFromBufferAttribute(t),e)for(let r=0,o=e.length;r<o;r++){let a=e[r];ms.setFromBufferAttribute(a),this.morphTargetsRelative?(be.addVectors(He.min,ms.min),He.expandByPoint(be),be.addVectors(He.max,ms.max),He.expandByPoint(be)):(He.expandByPoint(ms.min),He.expandByPoint(ms.max))}He.getCenter(n);let s=0;for(let r=0,o=t.count;r<o;r++)be.fromBufferAttribute(t,r),s=Math.max(s,n.distanceToSquared(be));if(e)for(let r=0,o=e.length;r<o;r++){let a=e[r],l=this.morphTargetsRelative;for(let c=0,h=a.count;c<h;c++)be.fromBufferAttribute(a,c),l&&(Ni.fromBufferAttribute(t,c),be.add(Ni)),s=Math.max(s,n.distanceToSquared(be))}this.boundingSphere.radius=Math.sqrt(s),isNaN(this.boundingSphere.radius)&&console.error('THREE.BufferGeometry.computeBoundingSphere(): Computed radius is NaN. The "position" attribute is likely to have NaN values.',this)}}computeTangents(){let t=this.index,e=this.attributes;if(t===null||e.position===void 0||e.normal===void 0||e.uv===void 0){console.error("THREE.BufferGeometry: .computeTangents() failed. Missing required attributes (index, position, normal or uv)");return}let n=e.position,s=e.normal,r=e.uv;this.hasAttribute("tangent")===!1&&this.setAttribute("tangent",new Ge(new Float32Array(4*n.count),4));let o=this.getAttribute("tangent"),a=[],l=[];for(let U=0;U<n.count;U++)a[U]=new D,l[U]=new D;let c=new D,h=new D,u=new D,f=new at,p=new at,g=new at,y=new D,m=new D;function d(U,S,M){c.fromBufferAttribute(n,U),h.fromBufferAttribute(n,S),u.fromBufferAttribute(n,M),f.fromBufferAttribute(r,U),p.fromBufferAttribute(r,S),g.fromBufferAttribute(r,M),h.sub(c),u.sub(c),p.sub(f),g.sub(f);let R=1/(p.x*g.y-g.x*p.y);isFinite(R)&&(y.copy(h).multiplyScalar(g.y).addScaledVector(u,-p.y).multiplyScalar(R),m.copy(u).multiplyScalar(p.x).addScaledVector(h,-g.x).multiplyScalar(R),a[U].add(y),a[S].add(y),a[M].add(y),l[U].add(m),l[S].add(m),l[M].add(m))}let w=this.groups;w.length===0&&(w=[{start:0,count:t.count}]);for(let U=0,S=w.length;U<S;++U){let M=w[U],R=M.start,O=M.count;for(let k=R,W=R+O;k<W;k+=3)d(t.getX(k+0),t.getX(k+1),t.getX(k+2))}let E=new D,v=new D,C=new D,A=new D;function I(U){C.fromBufferAttribute(s,U),A.copy(C);let S=a[U];E.copy(S),E.sub(C.multiplyScalar(C.dot(S))).normalize(),v.crossVectors(A,S);let R=v.dot(l[U])<0?-1:1;o.setXYZW(U,E.x,E.y,E.z,R)}for(let U=0,S=w.length;U<S;++U){let M=w[U],R=M.start,O=M.count;for(let k=R,W=R+O;k<W;k+=3)I(t.getX(k+0)),I(t.getX(k+1)),I(t.getX(k+2))}}computeVertexNormals(){let t=this.index,e=this.getAttribute("position");if(e!==void 0){let n=this.getAttribute("normal");if(n===void 0)n=new Ge(new Float32Array(e.count*3),3),this.setAttribute("normal",n);else for(let f=0,p=n.count;f<p;f++)n.setXYZ(f,0,0,0);let s=new D,r=new D,o=new D,a=new D,l=new D,c=new D,h=new D,u=new D;if(t)for(let f=0,p=t.count;f<p;f+=3){let g=t.getX(f+0),y=t.getX(f+1),m=t.getX(f+2);s.fromBufferAttribute(e,g),r.fromBufferAttribute(e,y),o.fromBufferAttribute(e,m),h.subVectors(o,r),u.subVectors(s,r),h.cross(u),a.fromBufferAttribute(n,g),l.fromBufferAttribute(n,y),c.fromBufferAttribute(n,m),a.add(h),l.add(h),c.add(h),n.setXYZ(g,a.x,a.y,a.z),n.setXYZ(y,l.x,l.y,l.z),n.setXYZ(m,c.x,c.y,c.z)}else for(let f=0,p=e.count;f<p;f+=3)s.fromBufferAttribute(e,f+0),r.fromBufferAttribute(e,f+1),o.fromBufferAttribute(e,f+2),h.subVectors(o,r),u.subVectors(s,r),h.cross(u),n.setXYZ(f+0,h.x,h.y,h.z),n.setXYZ(f+1,h.x,h.y,h.z),n.setXYZ(f+2,h.x,h.y,h.z);this.normalizeNormals(),n.needsUpdate=!0}}normalizeNormals(){let t=this.attributes.normal;for(let e=0,n=t.count;e<n;e++)be.fromBufferAttribute(t,e),be.normalize(),t.setXYZ(e,be.x,be.y,be.z)}toNonIndexed(){function t(a,l){let c=a.array,h=a.itemSize,u=a.normalized,f=new c.constructor(l.length*h),p=0,g=0;for(let y=0,m=l.length;y<m;y++){a.isInterleavedBufferAttribute?p=l[y]*a.data.stride+a.offset:p=l[y]*h;for(let d=0;d<h;d++)f[g++]=c[p++]}return new Ge(f,h,u)}if(this.index===null)return console.warn("THREE.BufferGeometry.toNonIndexed(): BufferGeometry is already non-indexed."),this;let e=new i,n=this.index.array,s=this.attributes;for(let a in s){let l=s[a],c=t(l,n);e.setAttribute(a,c)}let r=this.morphAttributes;for(let a in r){let l=[],c=r[a];for(let h=0,u=c.length;h<u;h++){let f=c[h],p=t(f,n);l.push(p)}e.morphAttributes[a]=l}e.morphTargetsRelative=this.morphTargetsRelative;let o=this.groups;for(let a=0,l=o.length;a<l;a++){let c=o[a];e.addGroup(c.start,c.count,c.materialIndex)}return e}toJSON(){let t={metadata:{version:4.7,type:"BufferGeometry",generator:"BufferGeometry.toJSON"}};if(t.uuid=this.uuid,t.type=this.type,this.name!==""&&(t.name=this.name),Object.keys(this.userData).length>0&&(t.userData=this.userData),this.parameters!==void 0){let l=this.parameters;for(let c in l)l[c]!==void 0&&(t[c]=l[c]);return t}t.data={attributes:{}};let e=this.index;e!==null&&(t.data.index={type:e.array.constructor.name,array:Array.prototype.slice.call(e.array)});let n=this.attributes;for(let l in n){let c=n[l];t.data.attributes[l]=c.toJSON(t.data)}let s={},r=!1;for(let l in this.morphAttributes){let c=this.morphAttributes[l],h=[];for(let u=0,f=c.length;u<f;u++){let p=c[u];h.push(p.toJSON(t.data))}h.length>0&&(s[l]=h,r=!0)}r&&(t.data.morphAttributes=s,t.data.morphTargetsRelative=this.morphTargetsRelative);let o=this.groups;o.length>0&&(t.data.groups=JSON.parse(JSON.stringify(o)));let a=this.boundingSphere;return a!==null&&(t.data.boundingSphere=a.toJSON()),t}clone(){return new this.constructor().copy(this)}copy(t){this.index=null,this.attributes={},this.morphAttributes={},this.groups=[],this.boundingBox=null,this.boundingSphere=null;let e={};this.name=t.name;let n=t.index;n!==null&&this.setIndex(n.clone());let s=t.attributes;for(let c in s){let h=s[c];this.setAttribute(c,h.clone(e))}let r=t.morphAttributes;for(let c in r){let h=[],u=r[c];for(let f=0,p=u.length;f<p;f++)h.push(u[f].clone(e));this.morphAttributes[c]=h}this.morphTargetsRelative=t.morphTargetsRelative;let o=t.groups;for(let c=0,h=o.length;c<h;c++){let u=o[c];this.addGroup(u.start,u.count,u.materialIndex)}let a=t.boundingBox;a!==null&&(this.boundingBox=a.clone());let l=t.boundingSphere;return l!==null&&(this.boundingSphere=l.clone()),this.drawRange.start=t.drawRange.start,this.drawRange.count=t.drawRange.count,this.userData=t.userData,this}dispose(){this.dispatchEvent({type:"dispose"})}},fc=new fe,ni=new ci,vr=new Wi,pc=new D,Mr=new D,Sr=new D,br=new D,La=new D,Er=new D,mc=new D,Tr=new D,we=class extends Re{constructor(t=new an,e=new qi){super(),this.isMesh=!0,this.type="Mesh",this.geometry=t,this.material=e,this.morphTargetDictionary=void 0,this.morphTargetInfluences=void 0,this.count=1,this.updateMorphTargets()}copy(t,e){return super.copy(t,e),t.morphTargetInfluences!==void 0&&(this.morphTargetInfluences=t.morphTargetInfluences.slice()),t.morphTargetDictionary!==void 0&&(this.morphTargetDictionary=Object.assign({},t.morphTargetDictionary)),this.material=Array.isArray(t.material)?t.material.slice():t.material,this.geometry=t.geometry,this}updateMorphTargets(){let e=this.geometry.morphAttributes,n=Object.keys(e);if(n.length>0){let s=e[n[0]];if(s!==void 0){this.morphTargetInfluences=[],this.morphTargetDictionary={};for(let r=0,o=s.length;r<o;r++){let a=s[r].name||String(r);this.morphTargetInfluences.push(0),this.morphTargetDictionary[a]=r}}}}getVertexPosition(t,e){let n=this.geometry,s=n.attributes.position,r=n.morphAttributes.position,o=n.morphTargetsRelative;e.fromBufferAttribute(s,t);let a=this.morphTargetInfluences;if(r&&a){Er.set(0,0,0);for(let l=0,c=r.length;l<c;l++){let h=a[l],u=r[l];h!==0&&(La.fromBufferAttribute(u,t),o?Er.addScaledVector(La,h):Er.addScaledVector(La.sub(e),h))}e.add(Er)}return e}raycast(t,e){let n=this.geometry,s=this.material,r=this.matrixWorld;s!==void 0&&(n.boundingSphere===null&&n.computeBoundingSphere(),vr.copy(n.boundingSphere),vr.applyMatrix4(r),ni.copy(t.ray).recast(t.near),!(vr.containsPoint(ni.origin)===!1&&(ni.intersectSphere(vr,pc)===null||ni.origin.distanceToSquared(pc)>(t.far-t.near)**2))&&(fc.copy(r).invert(),ni.copy(t.ray).applyMatrix4(fc),!(n.boundingBox!==null&&ni.intersectsBox(n.boundingBox)===!1)&&this._computeIntersections(t,e,ni)))}_computeIntersections(t,e,n){let s,r=this.geometry,o=this.material,a=r.index,l=r.attributes.position,c=r.attributes.uv,h=r.attributes.uv1,u=r.attributes.normal,f=r.groups,p=r.drawRange;if(a!==null)if(Array.isArray(o))for(let g=0,y=f.length;g<y;g++){let m=f[g],d=o[m.materialIndex],w=Math.max(m.start,p.start),E=Math.min(a.count,Math.min(m.start+m.count,p.start+p.count));for(let v=w,C=E;v<C;v+=3){let A=a.getX(v),I=a.getX(v+1),U=a.getX(v+2);s=wr(this,d,t,n,c,h,u,A,I,U),s&&(s.faceIndex=Math.floor(v/3),s.face.materialIndex=m.materialIndex,e.push(s))}}else{let g=Math.max(0,p.start),y=Math.min(a.count,p.start+p.count);for(let m=g,d=y;m<d;m+=3){let w=a.getX(m),E=a.getX(m+1),v=a.getX(m+2);s=wr(this,o,t,n,c,h,u,w,E,v),s&&(s.faceIndex=Math.floor(m/3),e.push(s))}}else if(l!==void 0)if(Array.isArray(o))for(let g=0,y=f.length;g<y;g++){let m=f[g],d=o[m.materialIndex],w=Math.max(m.start,p.start),E=Math.min(l.count,Math.min(m.start+m.count,p.start+p.count));for(let v=w,C=E;v<C;v+=3){let A=v,I=v+1,U=v+2;s=wr(this,d,t,n,c,h,u,A,I,U),s&&(s.faceIndex=Math.floor(v/3),s.face.materialIndex=m.materialIndex,e.push(s))}}else{let g=Math.max(0,p.start),y=Math.min(l.count,p.start+p.count);for(let m=g,d=y;m<d;m+=3){let w=m,E=m+1,v=m+2;s=wr(this,o,t,n,c,h,u,w,E,v),s&&(s.faceIndex=Math.floor(m/3),e.push(s))}}}};function Zu(i,t,e,n,s,r,o,a){let l;if(t.side===Ue?l=n.intersectTriangle(o,r,s,!0,a):l=n.intersectTriangle(s,r,o,t.side===An,a),l===null)return null;Tr.copy(a),Tr.applyMatrix4(i.matrixWorld);let c=e.ray.origin.distanceTo(Tr);return c<e.near||c>e.far?null:{distance:c,point:Tr.clone(),object:i}}function wr(i,t,e,n,s,r,o,a,l,c){i.getVertexPosition(a,Mr),i.getVertexPosition(l,Sr),i.getVertexPosition(c,br);let h=Zu(i,t,e,n,Mr,Sr,br,mc);if(h){let u=new D;zn.getBarycoord(mc,Mr,Sr,br,u),s&&(h.uv=zn.getInterpolatedAttribute(s,a,l,c,u,new at)),r&&(h.uv1=zn.getInterpolatedAttribute(r,a,l,c,u,new at)),o&&(h.normal=zn.getInterpolatedAttribute(o,a,l,c,u,new D),h.normal.dot(n.direction)>0&&h.normal.multiplyScalar(-1));let f={a,b:l,c,normal:new D,materialIndex:0};zn.getNormal(Mr,Sr,br,f.normal),h.face=f,h.barycoord=u}return h}var Wn=class i extends an{constructor(t=1,e=1,n=1,s=1,r=1,o=1){super(),this.type="BoxGeometry",this.parameters={width:t,height:e,depth:n,widthSegments:s,heightSegments:r,depthSegments:o};let a=this;s=Math.floor(s),r=Math.floor(r),o=Math.floor(o);let l=[],c=[],h=[],u=[],f=0,p=0;g("z","y","x",-1,-1,n,e,t,o,r,0),g("z","y","x",1,-1,n,e,-t,o,r,1),g("x","z","y",1,1,t,n,e,s,o,2),g("x","z","y",1,-1,t,n,-e,s,o,3),g("x","y","z",1,-1,t,e,n,s,r,4),g("x","y","z",-1,-1,t,e,-n,s,r,5),this.setIndex(l),this.setAttribute("position",new Ee(c,3)),this.setAttribute("normal",new Ee(h,3)),this.setAttribute("uv",new Ee(u,2));function g(y,m,d,w,E,v,C,A,I,U,S){let M=v/I,R=C/U,O=v/2,k=C/2,W=A/2,q=I+1,G=U+1,et=0,H=0,ut=new D;for(let xt=0;xt<G;xt++){let Mt=xt*R-k;for(let kt=0;kt<q;kt++){let Zt=kt*M-O;ut[y]=Zt*w,ut[m]=Mt*E,ut[d]=W,c.push(ut.x,ut.y,ut.z),ut[y]=0,ut[m]=0,ut[d]=A>0?1:-1,h.push(ut.x,ut.y,ut.z),u.push(kt/I),u.push(1-xt/U),et+=1}}for(let xt=0;xt<U;xt++)for(let Mt=0;Mt<I;Mt++){let kt=f+Mt+q*xt,Zt=f+Mt+q*(xt+1),Qt=f+(Mt+1)+q*(xt+1),Jt=f+(Mt+1)+q*xt;l.push(kt,Zt,Jt),l.push(Zt,Qt,Jt),H+=6}a.addGroup(p,H,S),p+=H,f+=et}}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}static fromJSON(t){return new i(t.width,t.height,t.depth,t.widthSegments,t.heightSegments,t.depthSegments)}};function gi(i){let t={};for(let e in i){t[e]={};for(let n in i[e]){let s=i[e][n];s&&(s.isColor||s.isMatrix3||s.isMatrix4||s.isVector2||s.isVector3||s.isVector4||s.isTexture||s.isQuaternion)?s.isRenderTargetTexture?(console.warn("UniformsUtils: Textures of render targets cannot be cloned via cloneUniforms() or mergeUniforms()."),t[e][n]=null):t[e][n]=s.clone():Array.isArray(s)?t[e][n]=s.slice():t[e][n]=s}}return t}function Ie(i){let t={};for(let e=0;e<i.length;e++){let n=gi(i[e]);for(let s in n)t[s]=n[s]}return t}function Ju(i){let t=[];for(let e=0;e<i.length;e++)t.push(i[e].clone());return t}function yl(i){let t=i.getRenderTarget();return t===null?i.outputColorSpace:t.isXRRenderTarget===!0?t.texture.colorSpace:$t.workingColorSpace}var ph={clone:gi,merge:Ie},$u=`void main() {
	gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );
}`,Ku=`void main() {
	gl_FragColor = vec4( 1.0, 0.0, 0.0, 1.0 );
}`,ln=class extends Gn{constructor(t){super(),this.isShaderMaterial=!0,this.type="ShaderMaterial",this.defines={},this.uniforms={},this.uniformsGroups=[],this.vertexShader=$u,this.fragmentShader=Ku,this.linewidth=1,this.wireframe=!1,this.wireframeLinewidth=1,this.fog=!1,this.lights=!1,this.clipping=!1,this.forceSinglePass=!0,this.extensions={clipCullDistance:!1,multiDraw:!1},this.defaultAttributeValues={color:[1,1,1],uv:[0,0],uv1:[0,0]},this.index0AttributeName=void 0,this.uniformsNeedUpdate=!1,this.glslVersion=null,t!==void 0&&this.setValues(t)}copy(t){return super.copy(t),this.fragmentShader=t.fragmentShader,this.vertexShader=t.vertexShader,this.uniforms=gi(t.uniforms),this.uniformsGroups=Ju(t.uniformsGroups),this.defines=Object.assign({},t.defines),this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this.fog=t.fog,this.lights=t.lights,this.clipping=t.clipping,this.extensions=Object.assign({},t.extensions),this.glslVersion=t.glslVersion,this}toJSON(t){let e=super.toJSON(t);e.glslVersion=this.glslVersion,e.uniforms={};for(let s in this.uniforms){let o=this.uniforms[s].value;o&&o.isTexture?e.uniforms[s]={type:"t",value:o.toJSON(t).uuid}:o&&o.isColor?e.uniforms[s]={type:"c",value:o.getHex()}:o&&o.isVector2?e.uniforms[s]={type:"v2",value:o.toArray()}:o&&o.isVector3?e.uniforms[s]={type:"v3",value:o.toArray()}:o&&o.isVector4?e.uniforms[s]={type:"v4",value:o.toArray()}:o&&o.isMatrix3?e.uniforms[s]={type:"m3",value:o.toArray()}:o&&o.isMatrix4?e.uniforms[s]={type:"m4",value:o.toArray()}:e.uniforms[s]={value:o}}Object.keys(this.defines).length>0&&(e.defines=this.defines),e.vertexShader=this.vertexShader,e.fragmentShader=this.fragmentShader,e.lights=this.lights,e.clipping=this.clipping;let n={};for(let s in this.extensions)this.extensions[s]===!0&&(n[s]=!0);return Object.keys(n).length>0&&(e.extensions=n),e}},Cs=class extends Re{constructor(){super(),this.isCamera=!0,this.type="Camera",this.matrixWorldInverse=new fe,this.projectionMatrix=new fe,this.projectionMatrixInverse=new fe,this.coordinateSystem=sn,this._reversedDepth=!1}get reversedDepth(){return this._reversedDepth}copy(t,e){return super.copy(t,e),this.matrixWorldInverse.copy(t.matrixWorldInverse),this.projectionMatrix.copy(t.projectionMatrix),this.projectionMatrixInverse.copy(t.projectionMatrixInverse),this.coordinateSystem=t.coordinateSystem,this}getWorldDirection(t){return super.getWorldDirection(t).negate()}updateMatrixWorld(t){super.updateMatrixWorld(t),this.matrixWorldInverse.copy(this.matrixWorld).invert()}updateWorldMatrix(t,e){super.updateWorldMatrix(t,e),this.matrixWorldInverse.copy(this.matrixWorld).invert()}clone(){return new this.constructor().copy(this)}},Bn=new D,gc=new at,_c=new at,Oe=class extends Cs{constructor(t=50,e=1,n=.1,s=2e3){super(),this.isPerspectiveCamera=!0,this.type="PerspectiveCamera",this.fov=t,this.zoom=1,this.near=n,this.far=s,this.focus=10,this.aspect=e,this.view=null,this.filmGauge=35,this.filmOffset=0,this.updateProjectionMatrix()}copy(t,e){return super.copy(t,e),this.fov=t.fov,this.zoom=t.zoom,this.near=t.near,this.far=t.far,this.focus=t.focus,this.aspect=t.aspect,this.view=t.view===null?null:Object.assign({},t.view),this.filmGauge=t.filmGauge,this.filmOffset=t.filmOffset,this}setFocalLength(t){let e=.5*this.getFilmHeight()/t;this.fov=Vi*2*Math.atan(e),this.updateProjectionMatrix()}getFocalLength(){let t=Math.tan(_s*.5*this.fov);return .5*this.getFilmHeight()/t}getEffectiveFOV(){return Vi*2*Math.atan(Math.tan(_s*.5*this.fov)/this.zoom)}getFilmWidth(){return this.filmGauge*Math.min(this.aspect,1)}getFilmHeight(){return this.filmGauge/Math.max(this.aspect,1)}getViewBounds(t,e,n){Bn.set(-1,-1,.5).applyMatrix4(this.projectionMatrixInverse),e.set(Bn.x,Bn.y).multiplyScalar(-t/Bn.z),Bn.set(1,1,.5).applyMatrix4(this.projectionMatrixInverse),n.set(Bn.x,Bn.y).multiplyScalar(-t/Bn.z)}getViewSize(t,e){return this.getViewBounds(t,gc,_c),e.subVectors(_c,gc)}setViewOffset(t,e,n,s,r,o){this.aspect=t/e,this.view===null&&(this.view={enabled:!0,fullWidth:1,fullHeight:1,offsetX:0,offsetY:0,width:1,height:1}),this.view.enabled=!0,this.view.fullWidth=t,this.view.fullHeight=e,this.view.offsetX=n,this.view.offsetY=s,this.view.width=r,this.view.height=o,this.updateProjectionMatrix()}clearViewOffset(){this.view!==null&&(this.view.enabled=!1),this.updateProjectionMatrix()}updateProjectionMatrix(){let t=this.near,e=t*Math.tan(_s*.5*this.fov)/this.zoom,n=2*e,s=this.aspect*n,r=-.5*s,o=this.view;if(this.view!==null&&this.view.enabled){let l=o.fullWidth,c=o.fullHeight;r+=o.offsetX*s/l,e-=o.offsetY*n/c,s*=o.width/l,n*=o.height/c}let a=this.filmOffset;a!==0&&(r+=t*a/this.getFilmWidth()),this.projectionMatrix.makePerspective(r,r+s,e,e-n,t,this.far,this.coordinateSystem,this.reversedDepth),this.projectionMatrixInverse.copy(this.projectionMatrix).invert()}toJSON(t){let e=super.toJSON(t);return e.object.fov=this.fov,e.object.zoom=this.zoom,e.object.near=this.near,e.object.far=this.far,e.object.focus=this.focus,e.object.aspect=this.aspect,this.view!==null&&(e.object.view=Object.assign({},this.view)),e.object.filmGauge=this.filmGauge,e.object.filmOffset=this.filmOffset,e}},Fi=-90,Oi=1,Vr=class extends Re{constructor(t,e,n){super(),this.type="CubeCamera",this.renderTarget=n,this.coordinateSystem=null,this.activeMipmapLevel=0;let s=new Oe(Fi,Oi,t,e);s.layers=this.layers,this.add(s);let r=new Oe(Fi,Oi,t,e);r.layers=this.layers,this.add(r);let o=new Oe(Fi,Oi,t,e);o.layers=this.layers,this.add(o);let a=new Oe(Fi,Oi,t,e);a.layers=this.layers,this.add(a);let l=new Oe(Fi,Oi,t,e);l.layers=this.layers,this.add(l);let c=new Oe(Fi,Oi,t,e);c.layers=this.layers,this.add(c)}updateCoordinateSystem(){let t=this.coordinateSystem,e=this.children.concat(),[n,s,r,o,a,l]=e;for(let c of e)this.remove(c);if(t===sn)n.up.set(0,1,0),n.lookAt(1,0,0),s.up.set(0,1,0),s.lookAt(-1,0,0),r.up.set(0,0,-1),r.lookAt(0,1,0),o.up.set(0,0,1),o.lookAt(0,-1,0),a.up.set(0,1,0),a.lookAt(0,0,1),l.up.set(0,1,0),l.lookAt(0,0,-1);else if(t===bs)n.up.set(0,-1,0),n.lookAt(-1,0,0),s.up.set(0,-1,0),s.lookAt(1,0,0),r.up.set(0,0,1),r.lookAt(0,1,0),o.up.set(0,0,-1),o.lookAt(0,-1,0),a.up.set(0,-1,0),a.lookAt(0,0,1),l.up.set(0,-1,0),l.lookAt(0,0,-1);else throw new Error("THREE.CubeCamera.updateCoordinateSystem(): Invalid coordinate system: "+t);for(let c of e)this.add(c),c.updateMatrixWorld()}update(t,e){this.parent===null&&this.updateMatrixWorld();let{renderTarget:n,activeMipmapLevel:s}=this;this.coordinateSystem!==t.coordinateSystem&&(this.coordinateSystem=t.coordinateSystem,this.updateCoordinateSystem());let[r,o,a,l,c,h]=this.children,u=t.getRenderTarget(),f=t.getActiveCubeFace(),p=t.getActiveMipmapLevel(),g=t.xr.enabled;t.xr.enabled=!1;let y=n.texture.generateMipmaps;n.texture.generateMipmaps=!1,t.setRenderTarget(n,0,s),t.render(e,r),t.setRenderTarget(n,1,s),t.render(e,o),t.setRenderTarget(n,2,s),t.render(e,a),t.setRenderTarget(n,3,s),t.render(e,l),t.setRenderTarget(n,4,s),t.render(e,c),n.texture.generateMipmaps=y,t.setRenderTarget(n,5,s),t.render(e,h),t.setRenderTarget(u,f,p),t.xr.enabled=g,n.texture.needsPMREMUpdate=!0}},Rs=class extends We{constructor(t=[],e=fi,n,s,r,o,a,l,c,h){super(t,e,n,s,r,o,a,l,c,h),this.isCubeTexture=!0,this.flipY=!1}get images(){return this.image}set images(t){this.image=t}},Hr=class extends pn{constructor(t=1,e={}){super(t,t,e),this.isWebGLCubeRenderTarget=!0;let n={width:t,height:t,depth:1},s=[n,n,n,n,n,n];this.texture=new Rs(s),this._setTextureOptions(e),this.texture.isRenderTargetTexture=!0}fromEquirectangularTexture(t,e){this.texture.type=e.type,this.texture.colorSpace=e.colorSpace,this.texture.generateMipmaps=e.generateMipmaps,this.texture.minFilter=e.minFilter,this.texture.magFilter=e.magFilter;let n={uniforms:{tEquirect:{value:null}},vertexShader:`

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
			`},s=new Wn(5,5,5),r=new ln({name:"CubemapFromEquirect",uniforms:gi(n.uniforms),vertexShader:n.vertexShader,fragmentShader:n.fragmentShader,side:Ue,blending:Cn});r.uniforms.tEquirect.value=e;let o=new we(s,r),a=e.minFilter;return e.minFilter===Jn&&(e.minFilter=rn),new Vr(1,10,this).update(t,o),e.minFilter=a,o.geometry.dispose(),o.material.dispose(),this}clear(t,e=!0,n=!0,s=!0){let r=t.getRenderTarget();for(let o=0;o<6;o++)t.setRenderTarget(this,o),t.clear(e,n,s);t.setRenderTarget(r)}},Te=class extends Re{constructor(){super(),this.isGroup=!0,this.type="Group"}},ju={type:"move"},Yi=class{constructor(){this._targetRay=null,this._grip=null,this._hand=null}getHandSpace(){return this._hand===null&&(this._hand=new Te,this._hand.matrixAutoUpdate=!1,this._hand.visible=!1,this._hand.joints={},this._hand.inputState={pinching:!1}),this._hand}getTargetRaySpace(){return this._targetRay===null&&(this._targetRay=new Te,this._targetRay.matrixAutoUpdate=!1,this._targetRay.visible=!1,this._targetRay.hasLinearVelocity=!1,this._targetRay.linearVelocity=new D,this._targetRay.hasAngularVelocity=!1,this._targetRay.angularVelocity=new D),this._targetRay}getGripSpace(){return this._grip===null&&(this._grip=new Te,this._grip.matrixAutoUpdate=!1,this._grip.visible=!1,this._grip.hasLinearVelocity=!1,this._grip.linearVelocity=new D,this._grip.hasAngularVelocity=!1,this._grip.angularVelocity=new D),this._grip}dispatchEvent(t){return this._targetRay!==null&&this._targetRay.dispatchEvent(t),this._grip!==null&&this._grip.dispatchEvent(t),this._hand!==null&&this._hand.dispatchEvent(t),this}connect(t){if(t&&t.hand){let e=this._hand;if(e)for(let n of t.hand.values())this._getHandJoint(e,n)}return this.dispatchEvent({type:"connected",data:t}),this}disconnect(t){return this.dispatchEvent({type:"disconnected",data:t}),this._targetRay!==null&&(this._targetRay.visible=!1),this._grip!==null&&(this._grip.visible=!1),this._hand!==null&&(this._hand.visible=!1),this}update(t,e,n){let s=null,r=null,o=null,a=this._targetRay,l=this._grip,c=this._hand;if(t&&e.session.visibilityState!=="visible-blurred"){if(c&&t.hand){o=!0;for(let y of t.hand.values()){let m=e.getJointPose(y,n),d=this._getHandJoint(c,y);m!==null&&(d.matrix.fromArray(m.transform.matrix),d.matrix.decompose(d.position,d.rotation,d.scale),d.matrixWorldNeedsUpdate=!0,d.jointRadius=m.radius),d.visible=m!==null}let h=c.joints["index-finger-tip"],u=c.joints["thumb-tip"],f=h.position.distanceTo(u.position),p=.02,g=.005;c.inputState.pinching&&f>p+g?(c.inputState.pinching=!1,this.dispatchEvent({type:"pinchend",handedness:t.handedness,target:this})):!c.inputState.pinching&&f<=p-g&&(c.inputState.pinching=!0,this.dispatchEvent({type:"pinchstart",handedness:t.handedness,target:this}))}else l!==null&&t.gripSpace&&(r=e.getPose(t.gripSpace,n),r!==null&&(l.matrix.fromArray(r.transform.matrix),l.matrix.decompose(l.position,l.rotation,l.scale),l.matrixWorldNeedsUpdate=!0,r.linearVelocity?(l.hasLinearVelocity=!0,l.linearVelocity.copy(r.linearVelocity)):l.hasLinearVelocity=!1,r.angularVelocity?(l.hasAngularVelocity=!0,l.angularVelocity.copy(r.angularVelocity)):l.hasAngularVelocity=!1));a!==null&&(s=e.getPose(t.targetRaySpace,n),s===null&&r!==null&&(s=r),s!==null&&(a.matrix.fromArray(s.transform.matrix),a.matrix.decompose(a.position,a.rotation,a.scale),a.matrixWorldNeedsUpdate=!0,s.linearVelocity?(a.hasLinearVelocity=!0,a.linearVelocity.copy(s.linearVelocity)):a.hasLinearVelocity=!1,s.angularVelocity?(a.hasAngularVelocity=!0,a.angularVelocity.copy(s.angularVelocity)):a.hasAngularVelocity=!1,this.dispatchEvent(ju)))}return a!==null&&(a.visible=s!==null),l!==null&&(l.visible=r!==null),c!==null&&(c.visible=o!==null),this}_getHandJoint(t,e){if(t.joints[e.jointName]===void 0){let n=new Te;n.matrixAutoUpdate=!1,n.visible=!1,t.joints[e.jointName]=n,t.add(n)}return t.joints[e.jointName]}};var Is=class extends Re{constructor(){super(),this.isScene=!0,this.type="Scene",this.background=null,this.environment=null,this.fog=null,this.backgroundBlurriness=0,this.backgroundIntensity=1,this.backgroundRotation=new on,this.environmentIntensity=1,this.environmentRotation=new on,this.overrideMaterial=null,typeof __THREE_DEVTOOLS__<"u"&&__THREE_DEVTOOLS__.dispatchEvent(new CustomEvent("observe",{detail:this}))}copy(t,e){return super.copy(t,e),t.background!==null&&(this.background=t.background.clone()),t.environment!==null&&(this.environment=t.environment.clone()),t.fog!==null&&(this.fog=t.fog.clone()),this.backgroundBlurriness=t.backgroundBlurriness,this.backgroundIntensity=t.backgroundIntensity,this.backgroundRotation.copy(t.backgroundRotation),this.environmentIntensity=t.environmentIntensity,this.environmentRotation.copy(t.environmentRotation),t.overrideMaterial!==null&&(this.overrideMaterial=t.overrideMaterial.clone()),this.matrixAutoUpdate=t.matrixAutoUpdate,this}toJSON(t){let e=super.toJSON(t);return this.fog!==null&&(e.object.fog=this.fog.toJSON()),this.backgroundBlurriness>0&&(e.object.backgroundBlurriness=this.backgroundBlurriness),this.backgroundIntensity!==1&&(e.object.backgroundIntensity=this.backgroundIntensity),e.object.backgroundRotation=this.backgroundRotation.toArray(),this.environmentIntensity!==1&&(e.object.environmentIntensity=this.environmentIntensity),e.object.environmentRotation=this.environmentRotation.toArray(),e}};var Ua=new D,Qu=new D,td=new Vt,$e=class{constructor(t=new D(1,0,0),e=0){this.isPlane=!0,this.normal=t,this.constant=e}set(t,e){return this.normal.copy(t),this.constant=e,this}setComponents(t,e,n,s){return this.normal.set(t,e,n),this.constant=s,this}setFromNormalAndCoplanarPoint(t,e){return this.normal.copy(t),this.constant=-e.dot(this.normal),this}setFromCoplanarPoints(t,e,n){let s=Ua.subVectors(n,e).cross(Qu.subVectors(t,e)).normalize();return this.setFromNormalAndCoplanarPoint(s,t),this}copy(t){return this.normal.copy(t.normal),this.constant=t.constant,this}normalize(){let t=1/this.normal.length();return this.normal.multiplyScalar(t),this.constant*=t,this}negate(){return this.constant*=-1,this.normal.negate(),this}distanceToPoint(t){return this.normal.dot(t)+this.constant}distanceToSphere(t){return this.distanceToPoint(t.center)-t.radius}projectPoint(t,e){return e.copy(t).addScaledVector(this.normal,-this.distanceToPoint(t))}intersectLine(t,e){let n=t.delta(Ua),s=this.normal.dot(n);if(s===0)return this.distanceToPoint(t.start)===0?e.copy(t.start):null;let r=-(t.start.dot(this.normal)+this.constant)/s;return r<0||r>1?null:e.copy(t.start).addScaledVector(n,r)}intersectsLine(t){let e=this.distanceToPoint(t.start),n=this.distanceToPoint(t.end);return e<0&&n>0||n<0&&e>0}intersectsBox(t){return t.intersectsPlane(this)}intersectsSphere(t){return t.intersectsPlane(this)}coplanarPoint(t){return t.copy(this.normal).multiplyScalar(-this.constant)}applyMatrix4(t,e){let n=e||td.getNormalMatrix(t),s=this.coplanarPoint(Ua).applyMatrix4(t),r=this.normal.applyMatrix3(n).normalize();return this.constant=-s.dot(r),this}translate(t){return this.constant-=t.dot(this.normal),this}equals(t){return t.normal.equals(this.normal)&&t.constant===this.constant}clone(){return new this.constructor().copy(this)}},ii=new Wi,ed=new at(.5,.5),Ar=new D,Zi=class{constructor(t=new $e,e=new $e,n=new $e,s=new $e,r=new $e,o=new $e){this.planes=[t,e,n,s,r,o]}set(t,e,n,s,r,o){let a=this.planes;return a[0].copy(t),a[1].copy(e),a[2].copy(n),a[3].copy(s),a[4].copy(r),a[5].copy(o),this}copy(t){let e=this.planes;for(let n=0;n<6;n++)e[n].copy(t.planes[n]);return this}setFromProjectionMatrix(t,e=sn,n=!1){let s=this.planes,r=t.elements,o=r[0],a=r[1],l=r[2],c=r[3],h=r[4],u=r[5],f=r[6],p=r[7],g=r[8],y=r[9],m=r[10],d=r[11],w=r[12],E=r[13],v=r[14],C=r[15];if(s[0].setComponents(c-o,p-h,d-g,C-w).normalize(),s[1].setComponents(c+o,p+h,d+g,C+w).normalize(),s[2].setComponents(c+a,p+u,d+y,C+E).normalize(),s[3].setComponents(c-a,p-u,d-y,C-E).normalize(),n)s[4].setComponents(l,f,m,v).normalize(),s[5].setComponents(c-l,p-f,d-m,C-v).normalize();else if(s[4].setComponents(c-l,p-f,d-m,C-v).normalize(),e===sn)s[5].setComponents(c+l,p+f,d+m,C+v).normalize();else if(e===bs)s[5].setComponents(l,f,m,v).normalize();else throw new Error("THREE.Frustum.setFromProjectionMatrix(): Invalid coordinate system: "+e);return this}intersectsObject(t){if(t.boundingSphere!==void 0)t.boundingSphere===null&&t.computeBoundingSphere(),ii.copy(t.boundingSphere).applyMatrix4(t.matrixWorld);else{let e=t.geometry;e.boundingSphere===null&&e.computeBoundingSphere(),ii.copy(e.boundingSphere).applyMatrix4(t.matrixWorld)}return this.intersectsSphere(ii)}intersectsSprite(t){ii.center.set(0,0,0);let e=ed.distanceTo(t.center);return ii.radius=.7071067811865476+e,ii.applyMatrix4(t.matrixWorld),this.intersectsSphere(ii)}intersectsSphere(t){let e=this.planes,n=t.center,s=-t.radius;for(let r=0;r<6;r++)if(e[r].distanceToPoint(n)<s)return!1;return!0}intersectsBox(t){let e=this.planes;for(let n=0;n<6;n++){let s=e[n];if(Ar.x=s.normal.x>0?t.max.x:t.min.x,Ar.y=s.normal.y>0?t.max.y:t.min.y,Ar.z=s.normal.z>0?t.max.z:t.min.z,s.distanceToPoint(Ar)<0)return!1}return!0}containsPoint(t){let e=this.planes;for(let n=0;n<6;n++)if(e[n].distanceToPoint(t)<0)return!1;return!0}clone(){return new this.constructor().copy(this)}};var Ps=class extends We{constructor(t,e,n=$n,s,r,o,a=Ke,l=Ke,c,h=ki,u=1){if(h!==ki&&h!==is)throw new Error("DepthTexture format must be either THREE.DepthFormat or THREE.DepthStencilFormat");let f={width:t,height:e,depth:u};super(f,s,r,o,a,l,h,n,c),this.isDepthTexture=!0,this.flipY=!1,this.generateMipmaps=!1,this.compareFunction=null}copy(t){return super.copy(t),this.source=new Gi(Object.assign({},t.image)),this.compareFunction=t.compareFunction,this}toJSON(t){let e=super.toJSON(t);return this.compareFunction!==null&&(e.compareFunction=this.compareFunction),e}},Ds=class extends We{constructor(t=null){super(),this.sourceTexture=t,this.isExternalTexture=!0}copy(t){return super.copy(t),this.sourceTexture=t.sourceTexture,this}};var Ls=class i extends an{constructor(t=1,e=1,n=1,s=32,r=1,o=!1,a=0,l=Math.PI*2){super(),this.type="CylinderGeometry",this.parameters={radiusTop:t,radiusBottom:e,height:n,radialSegments:s,heightSegments:r,openEnded:o,thetaStart:a,thetaLength:l};let c=this;s=Math.floor(s),r=Math.floor(r);let h=[],u=[],f=[],p=[],g=0,y=[],m=n/2,d=0;w(),o===!1&&(t>0&&E(!0),e>0&&E(!1)),this.setIndex(h),this.setAttribute("position",new Ee(u,3)),this.setAttribute("normal",new Ee(f,3)),this.setAttribute("uv",new Ee(p,2));function w(){let v=new D,C=new D,A=0,I=(e-t)/n;for(let U=0;U<=r;U++){let S=[],M=U/r,R=M*(e-t)+t;for(let O=0;O<=s;O++){let k=O/s,W=k*l+a,q=Math.sin(W),G=Math.cos(W);C.x=R*q,C.y=-M*n+m,C.z=R*G,u.push(C.x,C.y,C.z),v.set(q,I,G).normalize(),f.push(v.x,v.y,v.z),p.push(k,1-M),S.push(g++)}y.push(S)}for(let U=0;U<s;U++)for(let S=0;S<r;S++){let M=y[S][U],R=y[S+1][U],O=y[S+1][U+1],k=y[S][U+1];(t>0||S!==0)&&(h.push(M,R,k),A+=3),(e>0||S!==r-1)&&(h.push(R,O,k),A+=3)}c.addGroup(d,A,0),d+=A}function E(v){let C=g,A=new at,I=new D,U=0,S=v===!0?t:e,M=v===!0?1:-1;for(let O=1;O<=s;O++)u.push(0,m*M,0),f.push(0,M,0),p.push(.5,.5),g++;let R=g;for(let O=0;O<=s;O++){let W=O/s*l+a,q=Math.cos(W),G=Math.sin(W);I.x=S*G,I.y=m*M,I.z=S*q,u.push(I.x,I.y,I.z),f.push(0,M,0),A.x=q*.5+.5,A.y=G*.5*M+.5,p.push(A.x,A.y),g++}for(let O=0;O<s;O++){let k=C+O,W=R+O;v===!0?h.push(W,W+1,k):h.push(W+1,W,k),U+=3}c.addGroup(d,U,v===!0?1:2),d+=U}}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}static fromJSON(t){return new i(t.radiusTop,t.radiusBottom,t.height,t.radialSegments,t.heightSegments,t.openEnded,t.thetaStart,t.thetaLength)}};var Xe=class{constructor(){this.type="Curve",this.arcLengthDivisions=200,this.needsUpdate=!1,this.cacheArcLengths=null}getPoint(){console.warn("THREE.Curve: .getPoint() not implemented.")}getPointAt(t,e){let n=this.getUtoTmapping(t);return this.getPoint(n,e)}getPoints(t=5){let e=[];for(let n=0;n<=t;n++)e.push(this.getPoint(n/t));return e}getSpacedPoints(t=5){let e=[];for(let n=0;n<=t;n++)e.push(this.getPointAt(n/t));return e}getLength(){let t=this.getLengths();return t[t.length-1]}getLengths(t=this.arcLengthDivisions){if(this.cacheArcLengths&&this.cacheArcLengths.length===t+1&&!this.needsUpdate)return this.cacheArcLengths;this.needsUpdate=!1;let e=[],n,s=this.getPoint(0),r=0;e.push(0);for(let o=1;o<=t;o++)n=this.getPoint(o/t),r+=n.distanceTo(s),e.push(r),s=n;return this.cacheArcLengths=e,e}updateArcLengths(){this.needsUpdate=!0,this.getLengths()}getUtoTmapping(t,e=null){let n=this.getLengths(),s=0,r=n.length,o;e?o=e:o=t*n[r-1];let a=0,l=r-1,c;for(;a<=l;)if(s=Math.floor(a+(l-a)/2),c=n[s]-o,c<0)a=s+1;else if(c>0)l=s-1;else{l=s;break}if(s=l,n[s]===o)return s/(r-1);let h=n[s],f=n[s+1]-h,p=(o-h)/f;return(s+p)/(r-1)}getTangent(t,e){let s=t-1e-4,r=t+1e-4;s<0&&(s=0),r>1&&(r=1);let o=this.getPoint(s),a=this.getPoint(r),l=e||(o.isVector2?new at:new D);return l.copy(a).sub(o).normalize(),l}getTangentAt(t,e){let n=this.getUtoTmapping(t);return this.getTangent(n,e)}computeFrenetFrames(t,e=!1){let n=new D,s=[],r=[],o=[],a=new D,l=new fe;for(let p=0;p<=t;p++){let g=p/t;s[p]=this.getTangentAt(g,new D)}r[0]=new D,o[0]=new D;let c=Number.MAX_VALUE,h=Math.abs(s[0].x),u=Math.abs(s[0].y),f=Math.abs(s[0].z);h<=c&&(c=h,n.set(1,0,0)),u<=c&&(c=u,n.set(0,1,0)),f<=c&&n.set(0,0,1),a.crossVectors(s[0],n).normalize(),r[0].crossVectors(s[0],a),o[0].crossVectors(s[0],r[0]);for(let p=1;p<=t;p++){if(r[p]=r[p-1].clone(),o[p]=o[p-1].clone(),a.crossVectors(s[p-1],s[p]),a.length()>Number.EPSILON){a.normalize();let g=Math.acos(Gt(s[p-1].dot(s[p]),-1,1));r[p].applyMatrix4(l.makeRotationAxis(a,g))}o[p].crossVectors(s[p],r[p])}if(e===!0){let p=Math.acos(Gt(r[0].dot(r[t]),-1,1));p/=t,s[0].dot(a.crossVectors(r[0],r[t]))>0&&(p=-p);for(let g=1;g<=t;g++)r[g].applyMatrix4(l.makeRotationAxis(s[g],p*g)),o[g].crossVectors(s[g],r[g])}return{tangents:s,normals:r,binormals:o}}clone(){return new this.constructor().copy(this)}copy(t){return this.arcLengthDivisions=t.arcLengthDivisions,this}toJSON(){let t={metadata:{version:4.7,type:"Curve",generator:"Curve.toJSON"}};return t.arcLengthDivisions=this.arcLengthDivisions,t.type=this.type,t}fromJSON(t){return this.arcLengthDivisions=t.arcLengthDivisions,this}},Ji=class extends Xe{constructor(t=0,e=0,n=1,s=1,r=0,o=Math.PI*2,a=!1,l=0){super(),this.isEllipseCurve=!0,this.type="EllipseCurve",this.aX=t,this.aY=e,this.xRadius=n,this.yRadius=s,this.aStartAngle=r,this.aEndAngle=o,this.aClockwise=a,this.aRotation=l}getPoint(t,e=new at){let n=e,s=Math.PI*2,r=this.aEndAngle-this.aStartAngle,o=Math.abs(r)<Number.EPSILON;for(;r<0;)r+=s;for(;r>s;)r-=s;r<Number.EPSILON&&(o?r=0:r=s),this.aClockwise===!0&&!o&&(r===s?r=-s:r=r-s);let a=this.aStartAngle+t*r,l=this.aX+this.xRadius*Math.cos(a),c=this.aY+this.yRadius*Math.sin(a);if(this.aRotation!==0){let h=Math.cos(this.aRotation),u=Math.sin(this.aRotation),f=l-this.aX,p=c-this.aY;l=f*h-p*u+this.aX,c=f*u+p*h+this.aY}return n.set(l,c)}copy(t){return super.copy(t),this.aX=t.aX,this.aY=t.aY,this.xRadius=t.xRadius,this.yRadius=t.yRadius,this.aStartAngle=t.aStartAngle,this.aEndAngle=t.aEndAngle,this.aClockwise=t.aClockwise,this.aRotation=t.aRotation,this}toJSON(){let t=super.toJSON();return t.aX=this.aX,t.aY=this.aY,t.xRadius=this.xRadius,t.yRadius=this.yRadius,t.aStartAngle=this.aStartAngle,t.aEndAngle=this.aEndAngle,t.aClockwise=this.aClockwise,t.aRotation=this.aRotation,t}fromJSON(t){return super.fromJSON(t),this.aX=t.aX,this.aY=t.aY,this.xRadius=t.xRadius,this.yRadius=t.yRadius,this.aStartAngle=t.aStartAngle,this.aEndAngle=t.aEndAngle,this.aClockwise=t.aClockwise,this.aRotation=t.aRotation,this}},Gr=class extends Ji{constructor(t,e,n,s,r,o){super(t,e,n,n,s,r,o),this.isArcCurve=!0,this.type="ArcCurve"}};function vl(){let i=0,t=0,e=0,n=0;function s(r,o,a,l){i=r,t=a,e=-3*r+3*o-2*a-l,n=2*r-2*o+a+l}return{initCatmullRom:function(r,o,a,l,c){s(o,a,c*(a-r),c*(l-o))},initNonuniformCatmullRom:function(r,o,a,l,c,h,u){let f=(o-r)/c-(a-r)/(c+h)+(a-o)/h,p=(a-o)/h-(l-o)/(h+u)+(l-a)/u;f*=h,p*=h,s(o,a,f,p)},calc:function(r){let o=r*r,a=o*r;return i+t*r+e*o+n*a}}}var Cr=new D,Na=new vl,Fa=new vl,Oa=new vl,Wr=class extends Xe{constructor(t=[],e=!1,n="centripetal",s=.5){super(),this.isCatmullRomCurve3=!0,this.type="CatmullRomCurve3",this.points=t,this.closed=e,this.curveType=n,this.tension=s}getPoint(t,e=new D){let n=e,s=this.points,r=s.length,o=(r-(this.closed?0:1))*t,a=Math.floor(o),l=o-a;this.closed?a+=a>0?0:(Math.floor(Math.abs(a)/r)+1)*r:l===0&&a===r-1&&(a=r-2,l=1);let c,h;this.closed||a>0?c=s[(a-1)%r]:(Cr.subVectors(s[0],s[1]).add(s[0]),c=Cr);let u=s[a%r],f=s[(a+1)%r];if(this.closed||a+2<r?h=s[(a+2)%r]:(Cr.subVectors(s[r-1],s[r-2]).add(s[r-1]),h=Cr),this.curveType==="centripetal"||this.curveType==="chordal"){let p=this.curveType==="chordal"?.5:.25,g=Math.pow(c.distanceToSquared(u),p),y=Math.pow(u.distanceToSquared(f),p),m=Math.pow(f.distanceToSquared(h),p);y<1e-4&&(y=1),g<1e-4&&(g=y),m<1e-4&&(m=y),Na.initNonuniformCatmullRom(c.x,u.x,f.x,h.x,g,y,m),Fa.initNonuniformCatmullRom(c.y,u.y,f.y,h.y,g,y,m),Oa.initNonuniformCatmullRom(c.z,u.z,f.z,h.z,g,y,m)}else this.curveType==="catmullrom"&&(Na.initCatmullRom(c.x,u.x,f.x,h.x,this.tension),Fa.initCatmullRom(c.y,u.y,f.y,h.y,this.tension),Oa.initCatmullRom(c.z,u.z,f.z,h.z,this.tension));return n.set(Na.calc(l),Fa.calc(l),Oa.calc(l)),n}copy(t){super.copy(t),this.points=[];for(let e=0,n=t.points.length;e<n;e++){let s=t.points[e];this.points.push(s.clone())}return this.closed=t.closed,this.curveType=t.curveType,this.tension=t.tension,this}toJSON(){let t=super.toJSON();t.points=[];for(let e=0,n=this.points.length;e<n;e++){let s=this.points[e];t.points.push(s.toArray())}return t.closed=this.closed,t.curveType=this.curveType,t.tension=this.tension,t}fromJSON(t){super.fromJSON(t),this.points=[];for(let e=0,n=t.points.length;e<n;e++){let s=t.points[e];this.points.push(new D().fromArray(s))}return this.closed=t.closed,this.curveType=t.curveType,this.tension=t.tension,this}};function xc(i,t,e,n,s){let r=(n-t)*.5,o=(s-e)*.5,a=i*i,l=i*a;return(2*e-2*n+r+o)*l+(-3*e+3*n-2*r-o)*a+r*i+e}function nd(i,t){let e=1-i;return e*e*t}function id(i,t){return 2*(1-i)*i*t}function sd(i,t){return i*i*t}function ys(i,t,e,n){return nd(i,t)+id(i,e)+sd(i,n)}function rd(i,t){let e=1-i;return e*e*e*t}function od(i,t){let e=1-i;return 3*e*e*i*t}function ad(i,t){return 3*(1-i)*i*i*t}function ld(i,t){return i*i*i*t}function vs(i,t,e,n,s){return rd(i,t)+od(i,e)+ad(i,n)+ld(i,s)}var Us=class extends Xe{constructor(t=new at,e=new at,n=new at,s=new at){super(),this.isCubicBezierCurve=!0,this.type="CubicBezierCurve",this.v0=t,this.v1=e,this.v2=n,this.v3=s}getPoint(t,e=new at){let n=e,s=this.v0,r=this.v1,o=this.v2,a=this.v3;return n.set(vs(t,s.x,r.x,o.x,a.x),vs(t,s.y,r.y,o.y,a.y)),n}copy(t){return super.copy(t),this.v0.copy(t.v0),this.v1.copy(t.v1),this.v2.copy(t.v2),this.v3.copy(t.v3),this}toJSON(){let t=super.toJSON();return t.v0=this.v0.toArray(),t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t.v3=this.v3.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v0.fromArray(t.v0),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this.v3.fromArray(t.v3),this}},Xr=class extends Xe{constructor(t=new D,e=new D,n=new D,s=new D){super(),this.isCubicBezierCurve3=!0,this.type="CubicBezierCurve3",this.v0=t,this.v1=e,this.v2=n,this.v3=s}getPoint(t,e=new D){let n=e,s=this.v0,r=this.v1,o=this.v2,a=this.v3;return n.set(vs(t,s.x,r.x,o.x,a.x),vs(t,s.y,r.y,o.y,a.y),vs(t,s.z,r.z,o.z,a.z)),n}copy(t){return super.copy(t),this.v0.copy(t.v0),this.v1.copy(t.v1),this.v2.copy(t.v2),this.v3.copy(t.v3),this}toJSON(){let t=super.toJSON();return t.v0=this.v0.toArray(),t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t.v3=this.v3.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v0.fromArray(t.v0),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this.v3.fromArray(t.v3),this}},Ns=class extends Xe{constructor(t=new at,e=new at){super(),this.isLineCurve=!0,this.type="LineCurve",this.v1=t,this.v2=e}getPoint(t,e=new at){let n=e;return t===1?n.copy(this.v2):(n.copy(this.v2).sub(this.v1),n.multiplyScalar(t).add(this.v1)),n}getPointAt(t,e){return this.getPoint(t,e)}getTangent(t,e=new at){return e.subVectors(this.v2,this.v1).normalize()}getTangentAt(t,e){return this.getTangent(t,e)}copy(t){return super.copy(t),this.v1.copy(t.v1),this.v2.copy(t.v2),this}toJSON(){let t=super.toJSON();return t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this}},qr=class extends Xe{constructor(t=new D,e=new D){super(),this.isLineCurve3=!0,this.type="LineCurve3",this.v1=t,this.v2=e}getPoint(t,e=new D){let n=e;return t===1?n.copy(this.v2):(n.copy(this.v2).sub(this.v1),n.multiplyScalar(t).add(this.v1)),n}getPointAt(t,e){return this.getPoint(t,e)}getTangent(t,e=new D){return e.subVectors(this.v2,this.v1).normalize()}getTangentAt(t,e){return this.getTangent(t,e)}copy(t){return super.copy(t),this.v1.copy(t.v1),this.v2.copy(t.v2),this}toJSON(){let t=super.toJSON();return t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this}},Fs=class extends Xe{constructor(t=new at,e=new at,n=new at){super(),this.isQuadraticBezierCurve=!0,this.type="QuadraticBezierCurve",this.v0=t,this.v1=e,this.v2=n}getPoint(t,e=new at){let n=e,s=this.v0,r=this.v1,o=this.v2;return n.set(ys(t,s.x,r.x,o.x),ys(t,s.y,r.y,o.y)),n}copy(t){return super.copy(t),this.v0.copy(t.v0),this.v1.copy(t.v1),this.v2.copy(t.v2),this}toJSON(){let t=super.toJSON();return t.v0=this.v0.toArray(),t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v0.fromArray(t.v0),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this}},Yr=class extends Xe{constructor(t=new D,e=new D,n=new D){super(),this.isQuadraticBezierCurve3=!0,this.type="QuadraticBezierCurve3",this.v0=t,this.v1=e,this.v2=n}getPoint(t,e=new D){let n=e,s=this.v0,r=this.v1,o=this.v2;return n.set(ys(t,s.x,r.x,o.x),ys(t,s.y,r.y,o.y),ys(t,s.z,r.z,o.z)),n}copy(t){return super.copy(t),this.v0.copy(t.v0),this.v1.copy(t.v1),this.v2.copy(t.v2),this}toJSON(){let t=super.toJSON();return t.v0=this.v0.toArray(),t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v0.fromArray(t.v0),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this}},Os=class extends Xe{constructor(t=[]){super(),this.isSplineCurve=!0,this.type="SplineCurve",this.points=t}getPoint(t,e=new at){let n=e,s=this.points,r=(s.length-1)*t,o=Math.floor(r),a=r-o,l=s[o===0?o:o-1],c=s[o],h=s[o>s.length-2?s.length-1:o+1],u=s[o>s.length-3?s.length-1:o+2];return n.set(xc(a,l.x,c.x,h.x,u.x),xc(a,l.y,c.y,h.y,u.y)),n}copy(t){super.copy(t),this.points=[];for(let e=0,n=t.points.length;e<n;e++){let s=t.points[e];this.points.push(s.clone())}return this}toJSON(){let t=super.toJSON();t.points=[];for(let e=0,n=this.points.length;e<n;e++){let s=this.points[e];t.points.push(s.toArray())}return t}fromJSON(t){super.fromJSON(t),this.points=[];for(let e=0,n=t.points.length;e<n;e++){let s=t.points[e];this.points.push(new at().fromArray(s))}return this}},Wa=Object.freeze({__proto__:null,ArcCurve:Gr,CatmullRomCurve3:Wr,CubicBezierCurve:Us,CubicBezierCurve3:Xr,EllipseCurve:Ji,LineCurve:Ns,LineCurve3:qr,QuadraticBezierCurve:Fs,QuadraticBezierCurve3:Yr,SplineCurve:Os}),Zr=class extends Xe{constructor(){super(),this.type="CurvePath",this.curves=[],this.autoClose=!1}add(t){this.curves.push(t)}closePath(){let t=this.curves[0].getPoint(0),e=this.curves[this.curves.length-1].getPoint(1);if(!t.equals(e)){let n=t.isVector2===!0?"LineCurve":"LineCurve3";this.curves.push(new Wa[n](e,t))}return this}getPoint(t,e){let n=t*this.getLength(),s=this.getCurveLengths(),r=0;for(;r<s.length;){if(s[r]>=n){let o=s[r]-n,a=this.curves[r],l=a.getLength(),c=l===0?0:1-o/l;return a.getPointAt(c,e)}r++}return null}getLength(){let t=this.getCurveLengths();return t[t.length-1]}updateArcLengths(){this.needsUpdate=!0,this.cacheLengths=null,this.getCurveLengths()}getCurveLengths(){if(this.cacheLengths&&this.cacheLengths.length===this.curves.length)return this.cacheLengths;let t=[],e=0;for(let n=0,s=this.curves.length;n<s;n++)e+=this.curves[n].getLength(),t.push(e);return this.cacheLengths=t,t}getSpacedPoints(t=40){let e=[];for(let n=0;n<=t;n++)e.push(this.getPoint(n/t));return this.autoClose&&e.push(e[0]),e}getPoints(t=12){let e=[],n;for(let s=0,r=this.curves;s<r.length;s++){let o=r[s],a=o.isEllipseCurve?t*2:o.isLineCurve||o.isLineCurve3?1:o.isSplineCurve?t*o.points.length:t,l=o.getPoints(a);for(let c=0;c<l.length;c++){let h=l[c];n&&n.equals(h)||(e.push(h),n=h)}}return this.autoClose&&e.length>1&&!e[e.length-1].equals(e[0])&&e.push(e[0]),e}copy(t){super.copy(t),this.curves=[];for(let e=0,n=t.curves.length;e<n;e++){let s=t.curves[e];this.curves.push(s.clone())}return this.autoClose=t.autoClose,this}toJSON(){let t=super.toJSON();t.autoClose=this.autoClose,t.curves=[];for(let e=0,n=this.curves.length;e<n;e++){let s=this.curves[e];t.curves.push(s.toJSON())}return t}fromJSON(t){super.fromJSON(t),this.autoClose=t.autoClose,this.curves=[];for(let e=0,n=t.curves.length;e<n;e++){let s=t.curves[e];this.curves.push(new Wa[s.type]().fromJSON(s))}return this}},Bs=class extends Zr{constructor(t){super(),this.type="Path",this.currentPoint=new at,t&&this.setFromPoints(t)}setFromPoints(t){this.moveTo(t[0].x,t[0].y);for(let e=1,n=t.length;e<n;e++)this.lineTo(t[e].x,t[e].y);return this}moveTo(t,e){return this.currentPoint.set(t,e),this}lineTo(t,e){let n=new Ns(this.currentPoint.clone(),new at(t,e));return this.curves.push(n),this.currentPoint.set(t,e),this}quadraticCurveTo(t,e,n,s){let r=new Fs(this.currentPoint.clone(),new at(t,e),new at(n,s));return this.curves.push(r),this.currentPoint.set(n,s),this}bezierCurveTo(t,e,n,s,r,o){let a=new Us(this.currentPoint.clone(),new at(t,e),new at(n,s),new at(r,o));return this.curves.push(a),this.currentPoint.set(r,o),this}splineThru(t){let e=[this.currentPoint.clone()].concat(t),n=new Os(e);return this.curves.push(n),this.currentPoint.copy(t[t.length-1]),this}arc(t,e,n,s,r,o){let a=this.currentPoint.x,l=this.currentPoint.y;return this.absarc(t+a,e+l,n,s,r,o),this}absarc(t,e,n,s,r,o){return this.absellipse(t,e,n,n,s,r,o),this}ellipse(t,e,n,s,r,o,a,l){let c=this.currentPoint.x,h=this.currentPoint.y;return this.absellipse(t+c,e+h,n,s,r,o,a,l),this}absellipse(t,e,n,s,r,o,a,l){let c=new Ji(t,e,n,s,r,o,a,l);if(this.curves.length>0){let u=c.getPoint(0);u.equals(this.currentPoint)||this.lineTo(u.x,u.y)}this.curves.push(c);let h=c.getPoint(1);return this.currentPoint.copy(h),this}copy(t){return super.copy(t),this.currentPoint.copy(t.currentPoint),this}toJSON(){let t=super.toJSON();return t.currentPoint=this.currentPoint.toArray(),t}fromJSON(t){return super.fromJSON(t),this.currentPoint.fromArray(t.currentPoint),this}},$i=class extends Bs{constructor(t){super(t),this.uuid=mi(),this.type="Shape",this.holes=[]}getPointsHoles(t){let e=[];for(let n=0,s=this.holes.length;n<s;n++)e[n]=this.holes[n].getPoints(t);return e}extractPoints(t){return{shape:this.getPoints(t),holes:this.getPointsHoles(t)}}copy(t){super.copy(t),this.holes=[];for(let e=0,n=t.holes.length;e<n;e++){let s=t.holes[e];this.holes.push(s.clone())}return this}toJSON(){let t=super.toJSON();t.uuid=this.uuid,t.holes=[];for(let e=0,n=this.holes.length;e<n;e++){let s=this.holes[e];t.holes.push(s.toJSON())}return t}fromJSON(t){super.fromJSON(t),this.uuid=t.uuid,this.holes=[];for(let e=0,n=t.holes.length;e<n;e++){let s=t.holes[e];this.holes.push(new Bs().fromJSON(s))}return this}};function cd(i,t,e=2){let n=t&&t.length,s=n?t[0]*e:i.length,r=mh(i,0,s,e,!0),o=[];if(!r||r.next===r.prev)return o;let a,l,c;if(n&&(r=pd(i,t,r,e)),i.length>80*e){a=1/0,l=1/0;let h=-1/0,u=-1/0;for(let f=e;f<s;f+=e){let p=i[f],g=i[f+1];p<a&&(a=p),g<l&&(l=g),p>h&&(h=p),g>u&&(u=g)}c=Math.max(h-a,u-l),c=c!==0?32767/c:0}return zs(r,o,e,a,l,c,0),o}function mh(i,t,e,n,s){let r;if(s===Td(i,t,e,n)>0)for(let o=t;o<e;o+=n)r=yc(o/n|0,i[o],i[o+1],r);else for(let o=e-n;o>=t;o-=n)r=yc(o/n|0,i[o],i[o+1],r);return r&&Ki(r,r.next)&&(Vs(r),r=r.next),r}function hi(i,t){if(!i)return i;t||(t=i);let e=i,n;do if(n=!1,!e.steiner&&(Ki(e,e.next)||de(e.prev,e,e.next)===0)){if(Vs(e),e=t=e.prev,e===e.next)break;n=!0}else e=e.next;while(n||e!==t);return t}function zs(i,t,e,n,s,r,o){if(!i)return;!o&&r&&yd(i,n,s,r);let a=i;for(;i.prev!==i.next;){let l=i.prev,c=i.next;if(r?ud(i,n,s,r):hd(i)){t.push(l.i,i.i,c.i),Vs(i),i=c.next,a=c.next;continue}if(i=c,i===a){o?o===1?(i=dd(hi(i),t),zs(i,t,e,n,s,r,2)):o===2&&fd(i,t,e,n,s,r):zs(hi(i),t,e,n,s,r,1);break}}}function hd(i){let t=i.prev,e=i,n=i.next;if(de(t,e,n)>=0)return!1;let s=t.x,r=e.x,o=n.x,a=t.y,l=e.y,c=n.y,h=Math.min(s,r,o),u=Math.min(a,l,c),f=Math.max(s,r,o),p=Math.max(a,l,c),g=n.next;for(;g!==t;){if(g.x>=h&&g.x<=f&&g.y>=u&&g.y<=p&&gs(s,a,r,l,o,c,g.x,g.y)&&de(g.prev,g,g.next)>=0)return!1;g=g.next}return!0}function ud(i,t,e,n){let s=i.prev,r=i,o=i.next;if(de(s,r,o)>=0)return!1;let a=s.x,l=r.x,c=o.x,h=s.y,u=r.y,f=o.y,p=Math.min(a,l,c),g=Math.min(h,u,f),y=Math.max(a,l,c),m=Math.max(h,u,f),d=Xa(p,g,t,e,n),w=Xa(y,m,t,e,n),E=i.prevZ,v=i.nextZ;for(;E&&E.z>=d&&v&&v.z<=w;){if(E.x>=p&&E.x<=y&&E.y>=g&&E.y<=m&&E!==s&&E!==o&&gs(a,h,l,u,c,f,E.x,E.y)&&de(E.prev,E,E.next)>=0||(E=E.prevZ,v.x>=p&&v.x<=y&&v.y>=g&&v.y<=m&&v!==s&&v!==o&&gs(a,h,l,u,c,f,v.x,v.y)&&de(v.prev,v,v.next)>=0))return!1;v=v.nextZ}for(;E&&E.z>=d;){if(E.x>=p&&E.x<=y&&E.y>=g&&E.y<=m&&E!==s&&E!==o&&gs(a,h,l,u,c,f,E.x,E.y)&&de(E.prev,E,E.next)>=0)return!1;E=E.prevZ}for(;v&&v.z<=w;){if(v.x>=p&&v.x<=y&&v.y>=g&&v.y<=m&&v!==s&&v!==o&&gs(a,h,l,u,c,f,v.x,v.y)&&de(v.prev,v,v.next)>=0)return!1;v=v.nextZ}return!0}function dd(i,t){let e=i;do{let n=e.prev,s=e.next.next;!Ki(n,s)&&_h(n,e,e.next,s)&&ks(n,s)&&ks(s,n)&&(t.push(n.i,e.i,s.i),Vs(e),Vs(e.next),e=i=s),e=e.next}while(e!==i);return hi(e)}function fd(i,t,e,n,s,r){let o=i;do{let a=o.next.next;for(;a!==o.prev;){if(o.i!==a.i&&Sd(o,a)){let l=xh(o,a);o=hi(o,o.next),l=hi(l,l.next),zs(o,t,e,n,s,r,0),zs(l,t,e,n,s,r,0);return}a=a.next}o=o.next}while(o!==i)}function pd(i,t,e,n){let s=[];for(let r=0,o=t.length;r<o;r++){let a=t[r]*n,l=r<o-1?t[r+1]*n:i.length,c=mh(i,a,l,n,!1);c===c.next&&(c.steiner=!0),s.push(Md(c))}s.sort(md);for(let r=0;r<s.length;r++)e=gd(s[r],e);return e}function md(i,t){let e=i.x-t.x;if(e===0&&(e=i.y-t.y,e===0)){let n=(i.next.y-i.y)/(i.next.x-i.x),s=(t.next.y-t.y)/(t.next.x-t.x);e=n-s}return e}function gd(i,t){let e=_d(i,t);if(!e)return t;let n=xh(e,i);return hi(n,n.next),hi(e,e.next)}function _d(i,t){let e=t,n=i.x,s=i.y,r=-1/0,o;if(Ki(i,e))return e;do{if(Ki(i,e.next))return e.next;if(s<=e.y&&s>=e.next.y&&e.next.y!==e.y){let u=e.x+(s-e.y)*(e.next.x-e.x)/(e.next.y-e.y);if(u<=n&&u>r&&(r=u,o=e.x<e.next.x?e:e.next,u===n))return o}e=e.next}while(e!==t);if(!o)return null;let a=o,l=o.x,c=o.y,h=1/0;e=o;do{if(n>=e.x&&e.x>=l&&n!==e.x&&gh(s<c?n:r,s,l,c,s<c?r:n,s,e.x,e.y)){let u=Math.abs(s-e.y)/(n-e.x);ks(e,i)&&(u<h||u===h&&(e.x>o.x||e.x===o.x&&xd(o,e)))&&(o=e,h=u)}e=e.next}while(e!==a);return o}function xd(i,t){return de(i.prev,i,t.prev)<0&&de(t.next,i,i.next)<0}function yd(i,t,e,n){let s=i;do s.z===0&&(s.z=Xa(s.x,s.y,t,e,n)),s.prevZ=s.prev,s.nextZ=s.next,s=s.next;while(s!==i);s.prevZ.nextZ=null,s.prevZ=null,vd(s)}function vd(i){let t,e=1;do{let n=i,s;i=null;let r=null;for(t=0;n;){t++;let o=n,a=0;for(let c=0;c<e&&(a++,o=o.nextZ,!!o);c++);let l=e;for(;a>0||l>0&&o;)a!==0&&(l===0||!o||n.z<=o.z)?(s=n,n=n.nextZ,a--):(s=o,o=o.nextZ,l--),r?r.nextZ=s:i=s,s.prevZ=r,r=s;n=o}r.nextZ=null,e*=2}while(t>1);return i}function Xa(i,t,e,n,s){return i=(i-e)*s|0,t=(t-n)*s|0,i=(i|i<<8)&16711935,i=(i|i<<4)&252645135,i=(i|i<<2)&858993459,i=(i|i<<1)&1431655765,t=(t|t<<8)&16711935,t=(t|t<<4)&252645135,t=(t|t<<2)&858993459,t=(t|t<<1)&1431655765,i|t<<1}function Md(i){let t=i,e=i;do(t.x<e.x||t.x===e.x&&t.y<e.y)&&(e=t),t=t.next;while(t!==i);return e}function gh(i,t,e,n,s,r,o,a){return(s-o)*(t-a)>=(i-o)*(r-a)&&(i-o)*(n-a)>=(e-o)*(t-a)&&(e-o)*(r-a)>=(s-o)*(n-a)}function gs(i,t,e,n,s,r,o,a){return!(i===o&&t===a)&&gh(i,t,e,n,s,r,o,a)}function Sd(i,t){return i.next.i!==t.i&&i.prev.i!==t.i&&!bd(i,t)&&(ks(i,t)&&ks(t,i)&&Ed(i,t)&&(de(i.prev,i,t.prev)||de(i,t.prev,t))||Ki(i,t)&&de(i.prev,i,i.next)>0&&de(t.prev,t,t.next)>0)}function de(i,t,e){return(t.y-i.y)*(e.x-t.x)-(t.x-i.x)*(e.y-t.y)}function Ki(i,t){return i.x===t.x&&i.y===t.y}function _h(i,t,e,n){let s=Ir(de(i,t,e)),r=Ir(de(i,t,n)),o=Ir(de(e,n,i)),a=Ir(de(e,n,t));return!!(s!==r&&o!==a||s===0&&Rr(i,e,t)||r===0&&Rr(i,n,t)||o===0&&Rr(e,i,n)||a===0&&Rr(e,t,n))}function Rr(i,t,e){return t.x<=Math.max(i.x,e.x)&&t.x>=Math.min(i.x,e.x)&&t.y<=Math.max(i.y,e.y)&&t.y>=Math.min(i.y,e.y)}function Ir(i){return i>0?1:i<0?-1:0}function bd(i,t){let e=i;do{if(e.i!==i.i&&e.next.i!==i.i&&e.i!==t.i&&e.next.i!==t.i&&_h(e,e.next,i,t))return!0;e=e.next}while(e!==i);return!1}function ks(i,t){return de(i.prev,i,i.next)<0?de(i,t,i.next)>=0&&de(i,i.prev,t)>=0:de(i,t,i.prev)<0||de(i,i.next,t)<0}function Ed(i,t){let e=i,n=!1,s=(i.x+t.x)/2,r=(i.y+t.y)/2;do e.y>r!=e.next.y>r&&e.next.y!==e.y&&s<(e.next.x-e.x)*(r-e.y)/(e.next.y-e.y)+e.x&&(n=!n),e=e.next;while(e!==i);return n}function xh(i,t){let e=qa(i.i,i.x,i.y),n=qa(t.i,t.x,t.y),s=i.next,r=t.prev;return i.next=t,t.prev=i,e.next=s,s.prev=e,n.next=e,e.prev=n,r.next=n,n.prev=r,n}function yc(i,t,e,n){let s=qa(i,t,e);return n?(s.next=n.next,s.prev=n,n.next.prev=s,n.next=s):(s.prev=s,s.next=s),s}function Vs(i){i.next.prev=i.prev,i.prev.next=i.next,i.prevZ&&(i.prevZ.nextZ=i.nextZ),i.nextZ&&(i.nextZ.prevZ=i.prevZ)}function qa(i,t,e){return{i,x:t,y:e,prev:null,next:null,z:0,prevZ:null,nextZ:null,steiner:!1}}function Td(i,t,e,n){let s=0;for(let r=t,o=e-n;r<e;r+=n)s+=(i[o]-i[r])*(i[r+1]+i[o+1]),o=r;return s}var Ya=class{static triangulate(t,e,n=2){return cd(t,e,n)}},ri=class i{static area(t){let e=t.length,n=0;for(let s=e-1,r=0;r<e;s=r++)n+=t[s].x*t[r].y-t[r].x*t[s].y;return n*.5}static isClockWise(t){return i.area(t)<0}static triangulateShape(t,e){let n=[],s=[],r=[];vc(t),Mc(n,t);let o=t.length;e.forEach(vc);for(let l=0;l<e.length;l++)s.push(o),o+=e[l].length,Mc(n,e[l]);let a=Ya.triangulate(n,s);for(let l=0;l<a.length;l+=3)r.push(a.slice(l,l+3));return r}};function vc(i){let t=i.length;t>2&&i[t-1].equals(i[0])&&i.pop()}function Mc(i,t){for(let e=0;e<t.length;e++)i.push(t[e].x),i.push(t[e].y)}var Hs=class i extends an{constructor(t=new $i([new at(.5,.5),new at(-.5,.5),new at(-.5,-.5),new at(.5,-.5)]),e={}){super(),this.type="ExtrudeGeometry",this.parameters={shapes:t,options:e},t=Array.isArray(t)?t:[t];let n=this,s=[],r=[];for(let a=0,l=t.length;a<l;a++){let c=t[a];o(c)}this.setAttribute("position",new Ee(s,3)),this.setAttribute("uv",new Ee(r,2)),this.computeVertexNormals();function o(a){let l=[],c=e.curveSegments!==void 0?e.curveSegments:12,h=e.steps!==void 0?e.steps:1,u=e.depth!==void 0?e.depth:1,f=e.bevelEnabled!==void 0?e.bevelEnabled:!0,p=e.bevelThickness!==void 0?e.bevelThickness:.2,g=e.bevelSize!==void 0?e.bevelSize:p-.1,y=e.bevelOffset!==void 0?e.bevelOffset:0,m=e.bevelSegments!==void 0?e.bevelSegments:3,d=e.extrudePath,w=e.UVGenerator!==void 0?e.UVGenerator:wd,E,v=!1,C,A,I,U;d&&(E=d.getSpacedPoints(h),v=!0,f=!1,C=d.computeFrenetFrames(h,!1),A=new D,I=new D,U=new D),f||(m=0,p=0,g=0,y=0);let S=a.extractPoints(c),M=S.shape,R=S.holes;if(!ri.isClockWise(M)){M=M.reverse();for(let Q=0,$=R.length;Q<$;Q++){let J=R[Q];ri.isClockWise(J)&&(R[Q]=J.reverse())}}function k(Q){let J=10000000000000001e-36,Z=Q[0];for(let ct=1;ct<=Q.length;ct++){let nt=ct%Q.length,ht=Q[nt],Bt=ht.x-Z.x,Ot=ht.y-Z.y,b=Bt*Bt+Ot*Ot,_=Math.max(Math.abs(ht.x),Math.abs(ht.y),Math.abs(Z.x),Math.abs(Z.y)),F=J*_*_;if(b<=F){Q.splice(nt,1),ct--;continue}Z=ht}}k(M),R.forEach(k);let W=R.length,q=M;for(let Q=0;Q<W;Q++){let $=R[Q];M=M.concat($)}function G(Q,$,J){return $||console.error("THREE.ExtrudeGeometry: vec does not exist"),Q.clone().addScaledVector($,J)}let et=M.length;function H(Q,$,J){let Z,ct,nt,ht=Q.x-$.x,Bt=Q.y-$.y,Ot=J.x-Q.x,b=J.y-Q.y,_=ht*ht+Bt*Bt,F=ht*b-Bt*Ot;if(Math.abs(F)>Number.EPSILON){let V=Math.sqrt(_),j=Math.sqrt(Ot*Ot+b*b),X=$.x-Bt/V,Rt=$.y+ht/V,lt=J.x-b/j,wt=J.y+Ot/j,At=((lt-X)*b-(wt-Rt)*Ot)/(ht*b-Bt*Ot);Z=X+ht*At-Q.x,ct=Rt+Bt*At-Q.y;let it=Z*Z+ct*ct;if(it<=2)return new at(Z,ct);nt=Math.sqrt(it/2)}else{let V=!1;ht>Number.EPSILON?Ot>Number.EPSILON&&(V=!0):ht<-Number.EPSILON?Ot<-Number.EPSILON&&(V=!0):Math.sign(Bt)===Math.sign(b)&&(V=!0),V?(Z=-Bt,ct=ht,nt=Math.sqrt(_)):(Z=ht,ct=Bt,nt=Math.sqrt(_/2))}return new at(Z/nt,ct/nt)}let ut=[];for(let Q=0,$=q.length,J=$-1,Z=Q+1;Q<$;Q++,J++,Z++)J===$&&(J=0),Z===$&&(Z=0),ut[Q]=H(q[Q],q[J],q[Z]);let xt=[],Mt,kt=ut.concat();for(let Q=0,$=W;Q<$;Q++){let J=R[Q];Mt=[];for(let Z=0,ct=J.length,nt=ct-1,ht=Z+1;Z<ct;Z++,nt++,ht++)nt===ct&&(nt=0),ht===ct&&(ht=0),Mt[Z]=H(J[Z],J[nt],J[ht]);xt.push(Mt),kt=kt.concat(Mt)}let Zt;if(m===0)Zt=ri.triangulateShape(q,R);else{let Q=[],$=[];for(let J=0;J<m;J++){let Z=J/m,ct=p*Math.cos(Z*Math.PI/2),nt=g*Math.sin(Z*Math.PI/2)+y;for(let ht=0,Bt=q.length;ht<Bt;ht++){let Ot=G(q[ht],ut[ht],nt);Pt(Ot.x,Ot.y,-ct),Z===0&&Q.push(Ot)}for(let ht=0,Bt=W;ht<Bt;ht++){let Ot=R[ht];Mt=xt[ht];let b=[];for(let _=0,F=Ot.length;_<F;_++){let V=G(Ot[_],Mt[_],nt);Pt(V.x,V.y,-ct),Z===0&&b.push(V)}Z===0&&$.push(b)}}Zt=ri.triangulateShape(Q,$)}let Qt=Zt.length,Jt=g+y;for(let Q=0;Q<et;Q++){let $=f?G(M[Q],kt[Q],Jt):M[Q];v?(I.copy(C.normals[0]).multiplyScalar($.x),A.copy(C.binormals[0]).multiplyScalar($.y),U.copy(E[0]).add(I).add(A),Pt(U.x,U.y,U.z)):Pt($.x,$.y,0)}for(let Q=1;Q<=h;Q++)for(let $=0;$<et;$++){let J=f?G(M[$],kt[$],Jt):M[$];v?(I.copy(C.normals[Q]).multiplyScalar(J.x),A.copy(C.binormals[Q]).multiplyScalar(J.y),U.copy(E[Q]).add(I).add(A),Pt(U.x,U.y,U.z)):Pt(J.x,J.y,u/h*Q)}for(let Q=m-1;Q>=0;Q--){let $=Q/m,J=p*Math.cos($*Math.PI/2),Z=g*Math.sin($*Math.PI/2)+y;for(let ct=0,nt=q.length;ct<nt;ct++){let ht=G(q[ct],ut[ct],Z);Pt(ht.x,ht.y,u+J)}for(let ct=0,nt=R.length;ct<nt;ct++){let ht=R[ct];Mt=xt[ct];for(let Bt=0,Ot=ht.length;Bt<Ot;Bt++){let b=G(ht[Bt],Mt[Bt],Z);v?Pt(b.x,b.y+E[h-1].y,E[h-1].x+J):Pt(b.x,b.y,u+J)}}}Y(),tt();function Y(){let Q=s.length/3;if(f){let $=0,J=et*$;for(let Z=0;Z<Qt;Z++){let ct=Zt[Z];Tt(ct[2]+J,ct[1]+J,ct[0]+J)}$=h+m*2,J=et*$;for(let Z=0;Z<Qt;Z++){let ct=Zt[Z];Tt(ct[0]+J,ct[1]+J,ct[2]+J)}}else{for(let $=0;$<Qt;$++){let J=Zt[$];Tt(J[2],J[1],J[0])}for(let $=0;$<Qt;$++){let J=Zt[$];Tt(J[0]+et*h,J[1]+et*h,J[2]+et*h)}}n.addGroup(Q,s.length/3-Q,0)}function tt(){let Q=s.length/3,$=0;vt(q,$),$+=q.length;for(let J=0,Z=R.length;J<Z;J++){let ct=R[J];vt(ct,$),$+=ct.length}n.addGroup(Q,s.length/3-Q,1)}function vt(Q,$){let J=Q.length;for(;--J>=0;){let Z=J,ct=J-1;ct<0&&(ct=Q.length-1);for(let nt=0,ht=h+m*2;nt<ht;nt++){let Bt=et*nt,Ot=et*(nt+1),b=$+Z+Bt,_=$+ct+Bt,F=$+ct+Ot,V=$+Z+Ot;Xt(b,_,F,V)}}}function Pt(Q,$,J){l.push(Q),l.push($),l.push(J)}function Tt(Q,$,J){se(Q),se($),se(J);let Z=s.length/3,ct=w.generateTopUV(n,s,Z-3,Z-2,Z-1);T(ct[0]),T(ct[1]),T(ct[2])}function Xt(Q,$,J,Z){se(Q),se($),se(Z),se($),se(J),se(Z);let ct=s.length/3,nt=w.generateSideWallUV(n,s,ct-6,ct-3,ct-2,ct-1);T(nt[0]),T(nt[1]),T(nt[3]),T(nt[1]),T(nt[2]),T(nt[3])}function se(Q){s.push(l[Q*3+0]),s.push(l[Q*3+1]),s.push(l[Q*3+2])}function T(Q){r.push(Q.x),r.push(Q.y)}}}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}toJSON(){let t=super.toJSON(),e=this.parameters.shapes,n=this.parameters.options;return Ad(e,n,t)}static fromJSON(t,e){let n=[];for(let r=0,o=t.shapes.length;r<o;r++){let a=e[t.shapes[r]];n.push(a)}let s=t.options.extrudePath;return s!==void 0&&(t.options.extrudePath=new Wa[s.type]().fromJSON(s)),new i(n,t.options)}},wd={generateTopUV:function(i,t,e,n,s){let r=t[e*3],o=t[e*3+1],a=t[n*3],l=t[n*3+1],c=t[s*3],h=t[s*3+1];return[new at(r,o),new at(a,l),new at(c,h)]},generateSideWallUV:function(i,t,e,n,s,r){let o=t[e*3],a=t[e*3+1],l=t[e*3+2],c=t[n*3],h=t[n*3+1],u=t[n*3+2],f=t[s*3],p=t[s*3+1],g=t[s*3+2],y=t[r*3],m=t[r*3+1],d=t[r*3+2];return Math.abs(a-h)<Math.abs(o-c)?[new at(o,1-l),new at(c,1-u),new at(f,1-g),new at(y,1-d)]:[new at(a,1-l),new at(h,1-u),new at(p,1-g),new at(m,1-d)]}};function Ad(i,t,e){if(e.shapes=[],Array.isArray(i))for(let n=0,s=i.length;n<s;n++){let r=i[n];e.shapes.push(r.uuid)}else e.shapes.push(i.uuid);return e.options=Object.assign({},t),t.extrudePath!==void 0&&(e.options.extrudePath=t.extrudePath.toJSON()),e}var ji=class i extends an{constructor(t=1,e=1,n=1,s=1){super(),this.type="PlaneGeometry",this.parameters={width:t,height:e,widthSegments:n,heightSegments:s};let r=t/2,o=e/2,a=Math.floor(n),l=Math.floor(s),c=a+1,h=l+1,u=t/a,f=e/l,p=[],g=[],y=[],m=[];for(let d=0;d<h;d++){let w=d*f-o;for(let E=0;E<c;E++){let v=E*u-r;g.push(v,-w,0),y.push(0,0,1),m.push(E/a),m.push(1-d/l)}}for(let d=0;d<l;d++)for(let w=0;w<a;w++){let E=w+c*d,v=w+c*(d+1),C=w+1+c*(d+1),A=w+1+c*d;p.push(E,v,A),p.push(v,C,A)}this.setIndex(p),this.setAttribute("position",new Ee(g,3)),this.setAttribute("normal",new Ee(y,3)),this.setAttribute("uv",new Ee(m,2))}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}static fromJSON(t){return new i(t.width,t.height,t.widthSegments,t.heightSegments)}};var Gs=class i extends an{constructor(t=1,e=32,n=16,s=0,r=Math.PI*2,o=0,a=Math.PI){super(),this.type="SphereGeometry",this.parameters={radius:t,widthSegments:e,heightSegments:n,phiStart:s,phiLength:r,thetaStart:o,thetaLength:a},e=Math.max(3,Math.floor(e)),n=Math.max(2,Math.floor(n));let l=Math.min(o+a,Math.PI),c=0,h=[],u=new D,f=new D,p=[],g=[],y=[],m=[];for(let d=0;d<=n;d++){let w=[],E=d/n,v=0;d===0&&o===0?v=.5/e:d===n&&l===Math.PI&&(v=-.5/e);for(let C=0;C<=e;C++){let A=C/e;u.x=-t*Math.cos(s+A*r)*Math.sin(o+E*a),u.y=t*Math.cos(o+E*a),u.z=t*Math.sin(s+A*r)*Math.sin(o+E*a),g.push(u.x,u.y,u.z),f.copy(u).normalize(),y.push(f.x,f.y,f.z),m.push(A+v,1-E),w.push(c++)}h.push(w)}for(let d=0;d<n;d++)for(let w=0;w<e;w++){let E=h[d][w+1],v=h[d][w],C=h[d+1][w],A=h[d+1][w+1];(d!==0||o>0)&&p.push(E,v,A),(d!==n-1||l<Math.PI)&&p.push(v,C,A)}this.setIndex(p),this.setAttribute("position",new Ee(g,3)),this.setAttribute("normal",new Ee(y,3)),this.setAttribute("uv",new Ee(m,2))}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}static fromJSON(t){return new i(t.radius,t.widthSegments,t.heightSegments,t.phiStart,t.phiLength,t.thetaStart,t.thetaLength)}};var Ws=class extends Gn{constructor(t){super(),this.isMeshStandardMaterial=!0,this.type="MeshStandardMaterial",this.defines={STANDARD:""},this.color=new Yt(16777215),this.roughness=1,this.metalness=0,this.map=null,this.lightMap=null,this.lightMapIntensity=1,this.aoMap=null,this.aoMapIntensity=1,this.emissive=new Yt(0),this.emissiveIntensity=1,this.emissiveMap=null,this.bumpMap=null,this.bumpScale=1,this.normalMap=null,this.normalMapType=fl,this.normalScale=new at(1,1),this.displacementMap=null,this.displacementScale=1,this.displacementBias=0,this.roughnessMap=null,this.metalnessMap=null,this.alphaMap=null,this.envMap=null,this.envMapRotation=new on,this.envMapIntensity=1,this.wireframe=!1,this.wireframeLinewidth=1,this.wireframeLinecap="round",this.wireframeLinejoin="round",this.flatShading=!1,this.fog=!0,this.setValues(t)}copy(t){return super.copy(t),this.defines={STANDARD:""},this.color.copy(t.color),this.roughness=t.roughness,this.metalness=t.metalness,this.map=t.map,this.lightMap=t.lightMap,this.lightMapIntensity=t.lightMapIntensity,this.aoMap=t.aoMap,this.aoMapIntensity=t.aoMapIntensity,this.emissive.copy(t.emissive),this.emissiveMap=t.emissiveMap,this.emissiveIntensity=t.emissiveIntensity,this.bumpMap=t.bumpMap,this.bumpScale=t.bumpScale,this.normalMap=t.normalMap,this.normalMapType=t.normalMapType,this.normalScale.copy(t.normalScale),this.displacementMap=t.displacementMap,this.displacementScale=t.displacementScale,this.displacementBias=t.displacementBias,this.roughnessMap=t.roughnessMap,this.metalnessMap=t.metalnessMap,this.alphaMap=t.alphaMap,this.envMap=t.envMap,this.envMapRotation.copy(t.envMapRotation),this.envMapIntensity=t.envMapIntensity,this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this.wireframeLinecap=t.wireframeLinecap,this.wireframeLinejoin=t.wireframeLinejoin,this.flatShading=t.flatShading,this.fog=t.fog,this}};var Jr=class extends Gn{constructor(t){super(),this.isMeshDepthMaterial=!0,this.type="MeshDepthMaterial",this.depthPacking=eh,this.map=null,this.alphaMap=null,this.displacementMap=null,this.displacementScale=1,this.displacementBias=0,this.wireframe=!1,this.wireframeLinewidth=1,this.setValues(t)}copy(t){return super.copy(t),this.depthPacking=t.depthPacking,this.map=t.map,this.alphaMap=t.alphaMap,this.displacementMap=t.displacementMap,this.displacementScale=t.displacementScale,this.displacementBias=t.displacementBias,this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this}},$r=class extends Gn{constructor(t){super(),this.isMeshDistanceMaterial=!0,this.type="MeshDistanceMaterial",this.map=null,this.alphaMap=null,this.displacementMap=null,this.displacementScale=1,this.displacementBias=0,this.setValues(t)}copy(t){return super.copy(t),this.map=t.map,this.alphaMap=t.alphaMap,this.displacementMap=t.displacementMap,this.displacementScale=t.displacementScale,this.displacementBias=t.displacementBias,this}};function Pr(i,t){return!i||i.constructor===t?i:typeof t.BYTES_PER_ELEMENT=="number"?new t(i):Array.prototype.slice.call(i)}function Cd(i){return ArrayBuffer.isView(i)&&!(i instanceof DataView)}var ui=class{constructor(t,e,n,s){this.parameterPositions=t,this._cachedIndex=0,this.resultBuffer=s!==void 0?s:new e.constructor(n),this.sampleValues=e,this.valueSize=n,this.settings=null,this.DefaultSettings_={}}evaluate(t){let e=this.parameterPositions,n=this._cachedIndex,s=e[n],r=e[n-1];n:{t:{let o;e:{i:if(!(t<s)){for(let a=n+2;;){if(s===void 0){if(t<r)break i;return n=e.length,this._cachedIndex=n,this.copySampleValue_(n-1)}if(n===a)break;if(r=s,s=e[++n],t<s)break t}o=e.length;break e}if(!(t>=r)){let a=e[1];t<a&&(n=2,r=a);for(let l=n-2;;){if(r===void 0)return this._cachedIndex=0,this.copySampleValue_(0);if(n===l)break;if(s=r,r=e[--n-1],t>=r)break t}o=n,n=0;break e}break n}for(;n<o;){let a=n+o>>>1;t<e[a]?o=a:n=a+1}if(s=e[n],r=e[n-1],r===void 0)return this._cachedIndex=0,this.copySampleValue_(0);if(s===void 0)return n=e.length,this._cachedIndex=n,this.copySampleValue_(n-1)}this._cachedIndex=n,this.intervalChanged_(n,r,s)}return this.interpolate_(n,r,t,s)}getSettings_(){return this.settings||this.DefaultSettings_}copySampleValue_(t){let e=this.resultBuffer,n=this.sampleValues,s=this.valueSize,r=t*s;for(let o=0;o!==s;++o)e[o]=n[r+o];return e}interpolate_(){throw new Error("call to abstract method")}intervalChanged_(){}},Kr=class extends ui{constructor(t,e,n,s){super(t,e,n,s),this._weightPrev=-0,this._offsetPrev=-0,this._weightNext=-0,this._offsetNext=-0,this.DefaultSettings_={endingStart:za,endingEnd:za}}intervalChanged_(t,e,n){let s=this.parameterPositions,r=t-2,o=t+1,a=s[r],l=s[o];if(a===void 0)switch(this.getSettings_().endingStart){case ka:r=t,a=2*e-n;break;case Va:r=s.length-2,a=e+s[r]-s[r+1];break;default:r=t,a=n}if(l===void 0)switch(this.getSettings_().endingEnd){case ka:o=t,l=2*n-e;break;case Va:o=1,l=n+s[1]-s[0];break;default:o=t-1,l=e}let c=(n-e)*.5,h=this.valueSize;this._weightPrev=c/(e-a),this._weightNext=c/(l-n),this._offsetPrev=r*h,this._offsetNext=o*h}interpolate_(t,e,n,s){let r=this.resultBuffer,o=this.sampleValues,a=this.valueSize,l=t*a,c=l-a,h=this._offsetPrev,u=this._offsetNext,f=this._weightPrev,p=this._weightNext,g=(n-e)/(s-e),y=g*g,m=y*g,d=-f*m+2*f*y-f*g,w=(1+f)*m+(-1.5-2*f)*y+(-.5+f)*g+1,E=(-1-p)*m+(1.5+p)*y+.5*g,v=p*m-p*y;for(let C=0;C!==a;++C)r[C]=d*o[h+C]+w*o[c+C]+E*o[l+C]+v*o[u+C];return r}},jr=class extends ui{constructor(t,e,n,s){super(t,e,n,s)}interpolate_(t,e,n,s){let r=this.resultBuffer,o=this.sampleValues,a=this.valueSize,l=t*a,c=l-a,h=(n-e)/(s-e),u=1-h;for(let f=0;f!==a;++f)r[f]=o[c+f]*u+o[l+f]*h;return r}},Qr=class extends ui{constructor(t,e,n,s){super(t,e,n,s)}interpolate_(t){return this.copySampleValue_(t-1)}},qe=class{constructor(t,e,n,s){if(t===void 0)throw new Error("THREE.KeyframeTrack: track name is undefined");if(e===void 0||e.length===0)throw new Error("THREE.KeyframeTrack: no keyframes in track named "+t);this.name=t,this.times=Pr(e,this.TimeBufferType),this.values=Pr(n,this.ValueBufferType),this.setInterpolation(s||this.DefaultInterpolation)}static toJSON(t){let e=t.constructor,n;if(e.toJSON!==this.toJSON)n=e.toJSON(t);else{n={name:t.name,times:Pr(t.times,Array),values:Pr(t.values,Array)};let s=t.getInterpolation();s!==t.DefaultInterpolation&&(n.interpolation=s)}return n.type=t.ValueTypeName,n}InterpolantFactoryMethodDiscrete(t){return new Qr(this.times,this.values,this.getValueSize(),t)}InterpolantFactoryMethodLinear(t){return new jr(this.times,this.values,this.getValueSize(),t)}InterpolantFactoryMethodSmooth(t){return new Kr(this.times,this.values,this.getValueSize(),t)}setInterpolation(t){let e;switch(t){case Ms:e=this.InterpolantFactoryMethodDiscrete;break;case Or:e=this.InterpolantFactoryMethodLinear;break;case Dr:e=this.InterpolantFactoryMethodSmooth;break}if(e===void 0){let n="unsupported interpolation for "+this.ValueTypeName+" keyframe track named "+this.name;if(this.createInterpolant===void 0)if(t!==this.DefaultInterpolation)this.setInterpolation(this.DefaultInterpolation);else throw new Error(n);return console.warn("THREE.KeyframeTrack:",n),this}return this.createInterpolant=e,this}getInterpolation(){switch(this.createInterpolant){case this.InterpolantFactoryMethodDiscrete:return Ms;case this.InterpolantFactoryMethodLinear:return Or;case this.InterpolantFactoryMethodSmooth:return Dr}}getValueSize(){return this.values.length/this.times.length}shift(t){if(t!==0){let e=this.times;for(let n=0,s=e.length;n!==s;++n)e[n]+=t}return this}scale(t){if(t!==1){let e=this.times;for(let n=0,s=e.length;n!==s;++n)e[n]*=t}return this}trim(t,e){let n=this.times,s=n.length,r=0,o=s-1;for(;r!==s&&n[r]<t;)++r;for(;o!==-1&&n[o]>e;)--o;if(++o,r!==0||o!==s){r>=o&&(o=Math.max(o,1),r=o-1);let a=this.getValueSize();this.times=n.slice(r,o),this.values=this.values.slice(r*a,o*a)}return this}validate(){let t=!0,e=this.getValueSize();e-Math.floor(e)!==0&&(console.error("THREE.KeyframeTrack: Invalid value size in track.",this),t=!1);let n=this.times,s=this.values,r=n.length;r===0&&(console.error("THREE.KeyframeTrack: Track is empty.",this),t=!1);let o=null;for(let a=0;a!==r;a++){let l=n[a];if(typeof l=="number"&&isNaN(l)){console.error("THREE.KeyframeTrack: Time is not a valid number.",this,a,l),t=!1;break}if(o!==null&&o>l){console.error("THREE.KeyframeTrack: Out of order keys.",this,a,l,o),t=!1;break}o=l}if(s!==void 0&&Cd(s))for(let a=0,l=s.length;a!==l;++a){let c=s[a];if(isNaN(c)){console.error("THREE.KeyframeTrack: Value is not a valid number.",this,a,c),t=!1;break}}return t}optimize(){let t=this.times.slice(),e=this.values.slice(),n=this.getValueSize(),s=this.getInterpolation()===Dr,r=t.length-1,o=1;for(let a=1;a<r;++a){let l=!1,c=t[a],h=t[a+1];if(c!==h&&(a!==1||c!==t[0]))if(s)l=!0;else{let u=a*n,f=u-n,p=u+n;for(let g=0;g!==n;++g){let y=e[u+g];if(y!==e[f+g]||y!==e[p+g]){l=!0;break}}}if(l){if(a!==o){t[o]=t[a];let u=a*n,f=o*n;for(let p=0;p!==n;++p)e[f+p]=e[u+p]}++o}}if(r>0){t[o]=t[r];for(let a=r*n,l=o*n,c=0;c!==n;++c)e[l+c]=e[a+c];++o}return o!==t.length?(this.times=t.slice(0,o),this.values=e.slice(0,o*n)):(this.times=t,this.values=e),this}clone(){let t=this.times.slice(),e=this.values.slice(),n=this.constructor,s=new n(this.name,t,e);return s.createInterpolant=this.createInterpolant,s}};qe.prototype.ValueTypeName="";qe.prototype.TimeBufferType=Float32Array;qe.prototype.ValueBufferType=Float32Array;qe.prototype.DefaultInterpolation=Or;var Xn=class extends qe{constructor(t,e,n){super(t,e,n)}};Xn.prototype.ValueTypeName="bool";Xn.prototype.ValueBufferType=Array;Xn.prototype.DefaultInterpolation=Ms;Xn.prototype.InterpolantFactoryMethodLinear=void 0;Xn.prototype.InterpolantFactoryMethodSmooth=void 0;var to=class extends qe{constructor(t,e,n,s){super(t,e,n,s)}};to.prototype.ValueTypeName="color";var eo=class extends qe{constructor(t,e,n,s){super(t,e,n,s)}};eo.prototype.ValueTypeName="number";var no=class extends ui{constructor(t,e,n,s){super(t,e,n,s)}interpolate_(t,e,n,s){let r=this.resultBuffer,o=this.sampleValues,a=this.valueSize,l=(n-e)/(s-e),c=t*a;for(let h=c+a;c!==h;c+=4)je.slerpFlat(r,0,o,c-a,o,c,l);return r}},Xs=class extends qe{constructor(t,e,n,s){super(t,e,n,s)}InterpolantFactoryMethodLinear(t){return new no(this.times,this.values,this.getValueSize(),t)}};Xs.prototype.ValueTypeName="quaternion";Xs.prototype.InterpolantFactoryMethodSmooth=void 0;var qn=class extends qe{constructor(t,e,n){super(t,e,n)}};qn.prototype.ValueTypeName="string";qn.prototype.ValueBufferType=Array;qn.prototype.DefaultInterpolation=Ms;qn.prototype.InterpolantFactoryMethodLinear=void 0;qn.prototype.InterpolantFactoryMethodSmooth=void 0;var io=class extends qe{constructor(t,e,n,s){super(t,e,n,s)}};io.prototype.ValueTypeName="vector";var so=class{constructor(t,e,n){let s=this,r=!1,o=0,a=0,l,c=[];this.onStart=void 0,this.onLoad=t,this.onProgress=e,this.onError=n,this.abortController=new AbortController,this.itemStart=function(h){a++,r===!1&&s.onStart!==void 0&&s.onStart(h,o,a),r=!0},this.itemEnd=function(h){o++,s.onProgress!==void 0&&s.onProgress(h,o,a),o===a&&(r=!1,s.onLoad!==void 0&&s.onLoad())},this.itemError=function(h){s.onError!==void 0&&s.onError(h)},this.resolveURL=function(h){return l?l(h):h},this.setURLModifier=function(h){return l=h,this},this.addHandler=function(h,u){return c.push(h,u),this},this.removeHandler=function(h){let u=c.indexOf(h);return u!==-1&&c.splice(u,2),this},this.getHandler=function(h){for(let u=0,f=c.length;u<f;u+=2){let p=c[u],g=c[u+1];if(p.global&&(p.lastIndex=0),p.test(h))return g}return null},this.abort=function(){return this.abortController.abort(),this.abortController=new AbortController,this}}},yh=new so,ro=class{constructor(t){this.manager=t!==void 0?t:yh,this.crossOrigin="anonymous",this.withCredentials=!1,this.path="",this.resourcePath="",this.requestHeader={}}load(){}loadAsync(t,e){let n=this;return new Promise(function(s,r){n.load(t,s,e,r)})}parse(){}setCrossOrigin(t){return this.crossOrigin=t,this}setWithCredentials(t){return this.withCredentials=t,this}setPath(t){return this.path=t,this}setResourcePath(t){return this.resourcePath=t,this}setRequestHeader(t){return this.requestHeader=t,this}abort(){return this}};ro.DEFAULT_MATERIAL_NAME="__DEFAULT";var qs=class extends Re{constructor(t,e=1){super(),this.isLight=!0,this.type="Light",this.color=new Yt(t),this.intensity=e}dispose(){}copy(t,e){return super.copy(t,e),this.color.copy(t.color),this.intensity=t.intensity,this}toJSON(t){let e=super.toJSON(t);return e.object.color=this.color.getHex(),e.object.intensity=this.intensity,this.groundColor!==void 0&&(e.object.groundColor=this.groundColor.getHex()),this.distance!==void 0&&(e.object.distance=this.distance),this.angle!==void 0&&(e.object.angle=this.angle),this.decay!==void 0&&(e.object.decay=this.decay),this.penumbra!==void 0&&(e.object.penumbra=this.penumbra),this.shadow!==void 0&&(e.object.shadow=this.shadow.toJSON()),this.target!==void 0&&(e.object.target=this.target.uuid),e}},Ys=class extends qs{constructor(t,e,n){super(t,n),this.isHemisphereLight=!0,this.type="HemisphereLight",this.position.copy(Re.DEFAULT_UP),this.updateMatrix(),this.groundColor=new Yt(e)}copy(t,e){return super.copy(t,e),this.groundColor.copy(t.groundColor),this}},Ba=new fe,Sc=new D,bc=new D,Za=class{constructor(t){this.camera=t,this.intensity=1,this.bias=0,this.normalBias=0,this.radius=1,this.blurSamples=8,this.mapSize=new at(512,512),this.mapType=cn,this.map=null,this.mapPass=null,this.matrix=new fe,this.autoUpdate=!0,this.needsUpdate=!1,this._frustum=new Zi,this._frameExtents=new at(1,1),this._viewportCount=1,this._viewports=[new pe(0,0,1,1)]}getViewportCount(){return this._viewportCount}getFrustum(){return this._frustum}updateMatrices(t){let e=this.camera,n=this.matrix;Sc.setFromMatrixPosition(t.matrixWorld),e.position.copy(Sc),bc.setFromMatrixPosition(t.target.matrixWorld),e.lookAt(bc),e.updateMatrixWorld(),Ba.multiplyMatrices(e.projectionMatrix,e.matrixWorldInverse),this._frustum.setFromProjectionMatrix(Ba,e.coordinateSystem,e.reversedDepth),e.reversedDepth?n.set(.5,0,0,.5,0,.5,0,.5,0,0,1,0,0,0,0,1):n.set(.5,0,0,.5,0,.5,0,.5,0,0,.5,.5,0,0,0,1),n.multiply(Ba)}getViewport(t){return this._viewports[t]}getFrameExtents(){return this._frameExtents}dispose(){this.map&&this.map.dispose(),this.mapPass&&this.mapPass.dispose()}copy(t){return this.camera=t.camera.clone(),this.intensity=t.intensity,this.bias=t.bias,this.radius=t.radius,this.autoUpdate=t.autoUpdate,this.needsUpdate=t.needsUpdate,this.normalBias=t.normalBias,this.blurSamples=t.blurSamples,this.mapSize.copy(t.mapSize),this}clone(){return new this.constructor().copy(this)}toJSON(){let t={};return this.intensity!==1&&(t.intensity=this.intensity),this.bias!==0&&(t.bias=this.bias),this.normalBias!==0&&(t.normalBias=this.normalBias),this.radius!==1&&(t.radius=this.radius),(this.mapSize.x!==512||this.mapSize.y!==512)&&(t.mapSize=this.mapSize.toArray()),t.camera=this.camera.toJSON(!1).object,delete t.camera.matrix,t}};var di=class extends Cs{constructor(t=-1,e=1,n=1,s=-1,r=.1,o=2e3){super(),this.isOrthographicCamera=!0,this.type="OrthographicCamera",this.zoom=1,this.view=null,this.left=t,this.right=e,this.top=n,this.bottom=s,this.near=r,this.far=o,this.updateProjectionMatrix()}copy(t,e){return super.copy(t,e),this.left=t.left,this.right=t.right,this.top=t.top,this.bottom=t.bottom,this.near=t.near,this.far=t.far,this.zoom=t.zoom,this.view=t.view===null?null:Object.assign({},t.view),this}setViewOffset(t,e,n,s,r,o){this.view===null&&(this.view={enabled:!0,fullWidth:1,fullHeight:1,offsetX:0,offsetY:0,width:1,height:1}),this.view.enabled=!0,this.view.fullWidth=t,this.view.fullHeight=e,this.view.offsetX=n,this.view.offsetY=s,this.view.width=r,this.view.height=o,this.updateProjectionMatrix()}clearViewOffset(){this.view!==null&&(this.view.enabled=!1),this.updateProjectionMatrix()}updateProjectionMatrix(){let t=(this.right-this.left)/(2*this.zoom),e=(this.top-this.bottom)/(2*this.zoom),n=(this.right+this.left)/2,s=(this.top+this.bottom)/2,r=n-t,o=n+t,a=s+e,l=s-e;if(this.view!==null&&this.view.enabled){let c=(this.right-this.left)/this.view.fullWidth/this.zoom,h=(this.top-this.bottom)/this.view.fullHeight/this.zoom;r+=c*this.view.offsetX,o=r+c*this.view.width,a-=h*this.view.offsetY,l=a-h*this.view.height}this.projectionMatrix.makeOrthographic(r,o,a,l,this.near,this.far,this.coordinateSystem,this.reversedDepth),this.projectionMatrixInverse.copy(this.projectionMatrix).invert()}toJSON(t){let e=super.toJSON(t);return e.object.zoom=this.zoom,e.object.left=this.left,e.object.right=this.right,e.object.top=this.top,e.object.bottom=this.bottom,e.object.near=this.near,e.object.far=this.far,this.view!==null&&(e.object.view=Object.assign({},this.view)),e}},Ja=class extends Za{constructor(){super(new di(-5,5,5,-5,.5,500)),this.isDirectionalLightShadow=!0}},Zs=class extends qs{constructor(t,e){super(t,e),this.isDirectionalLight=!0,this.type="DirectionalLight",this.position.copy(Re.DEFAULT_UP),this.updateMatrix(),this.target=new Re,this.shadow=new Ja}dispose(){this.shadow.dispose()}copy(t){return super.copy(t),this.target=t.target.clone(),this.shadow=t.shadow.clone(),this}};var oo=class extends Oe{constructor(t=[]){super(),this.isArrayCamera=!0,this.isMultiViewCamera=!1,this.cameras=t}};var Ml="\\[\\]\\.:\\/",Rd=new RegExp("["+Ml+"]","g"),Sl="[^"+Ml+"]",Id="[^"+Ml.replace("\\.","")+"]",Pd=/((?:WC+[\/:])*)/.source.replace("WC",Sl),Dd=/(WCOD+)?/.source.replace("WCOD",Id),Ld=/(?:\.(WC+)(?:\[(.+)\])?)?/.source.replace("WC",Sl),Ud=/\.(WC+)(?:\[(.+)\])?/.source.replace("WC",Sl),Nd=new RegExp("^"+Pd+Dd+Ld+Ud+"$"),Fd=["material","materials","bones","map"],$a=class{constructor(t,e,n){let s=n||ae.parseTrackName(e);this._targetGroup=t,this._bindings=t.subscribe_(e,s)}getValue(t,e){this.bind();let n=this._targetGroup.nCachedObjects_,s=this._bindings[n];s!==void 0&&s.getValue(t,e)}setValue(t,e){let n=this._bindings;for(let s=this._targetGroup.nCachedObjects_,r=n.length;s!==r;++s)n[s].setValue(t,e)}bind(){let t=this._bindings;for(let e=this._targetGroup.nCachedObjects_,n=t.length;e!==n;++e)t[e].bind()}unbind(){let t=this._bindings;for(let e=this._targetGroup.nCachedObjects_,n=t.length;e!==n;++e)t[e].unbind()}},ae=class i{constructor(t,e,n){this.path=e,this.parsedPath=n||i.parseTrackName(e),this.node=i.findNode(t,this.parsedPath.nodeName),this.rootNode=t,this.getValue=this._getValue_unbound,this.setValue=this._setValue_unbound}static create(t,e,n){return t&&t.isAnimationObjectGroup?new i.Composite(t,e,n):new i(t,e,n)}static sanitizeNodeName(t){return t.replace(/\s/g,"_").replace(Rd,"")}static parseTrackName(t){let e=Nd.exec(t);if(e===null)throw new Error("PropertyBinding: Cannot parse trackName: "+t);let n={nodeName:e[2],objectName:e[3],objectIndex:e[4],propertyName:e[5],propertyIndex:e[6]},s=n.nodeName&&n.nodeName.lastIndexOf(".");if(s!==void 0&&s!==-1){let r=n.nodeName.substring(s+1);Fd.indexOf(r)!==-1&&(n.nodeName=n.nodeName.substring(0,s),n.objectName=r)}if(n.propertyName===null||n.propertyName.length===0)throw new Error("PropertyBinding: can not parse propertyName from trackName: "+t);return n}static findNode(t,e){if(e===void 0||e===""||e==="."||e===-1||e===t.name||e===t.uuid)return t;if(t.skeleton){let n=t.skeleton.getBoneByName(e);if(n!==void 0)return n}if(t.children){let n=function(r){for(let o=0;o<r.length;o++){let a=r[o];if(a.name===e||a.uuid===e)return a;let l=n(a.children);if(l)return l}return null},s=n(t.children);if(s)return s}return null}_getValue_unavailable(){}_setValue_unavailable(){}_getValue_direct(t,e){t[e]=this.targetObject[this.propertyName]}_getValue_array(t,e){let n=this.resolvedProperty;for(let s=0,r=n.length;s!==r;++s)t[e++]=n[s]}_getValue_arrayElement(t,e){t[e]=this.resolvedProperty[this.propertyIndex]}_getValue_toArray(t,e){this.resolvedProperty.toArray(t,e)}_setValue_direct(t,e){this.targetObject[this.propertyName]=t[e]}_setValue_direct_setNeedsUpdate(t,e){this.targetObject[this.propertyName]=t[e],this.targetObject.needsUpdate=!0}_setValue_direct_setMatrixWorldNeedsUpdate(t,e){this.targetObject[this.propertyName]=t[e],this.targetObject.matrixWorldNeedsUpdate=!0}_setValue_array(t,e){let n=this.resolvedProperty;for(let s=0,r=n.length;s!==r;++s)n[s]=t[e++]}_setValue_array_setNeedsUpdate(t,e){let n=this.resolvedProperty;for(let s=0,r=n.length;s!==r;++s)n[s]=t[e++];this.targetObject.needsUpdate=!0}_setValue_array_setMatrixWorldNeedsUpdate(t,e){let n=this.resolvedProperty;for(let s=0,r=n.length;s!==r;++s)n[s]=t[e++];this.targetObject.matrixWorldNeedsUpdate=!0}_setValue_arrayElement(t,e){this.resolvedProperty[this.propertyIndex]=t[e]}_setValue_arrayElement_setNeedsUpdate(t,e){this.resolvedProperty[this.propertyIndex]=t[e],this.targetObject.needsUpdate=!0}_setValue_arrayElement_setMatrixWorldNeedsUpdate(t,e){this.resolvedProperty[this.propertyIndex]=t[e],this.targetObject.matrixWorldNeedsUpdate=!0}_setValue_fromArray(t,e){this.resolvedProperty.fromArray(t,e)}_setValue_fromArray_setNeedsUpdate(t,e){this.resolvedProperty.fromArray(t,e),this.targetObject.needsUpdate=!0}_setValue_fromArray_setMatrixWorldNeedsUpdate(t,e){this.resolvedProperty.fromArray(t,e),this.targetObject.matrixWorldNeedsUpdate=!0}_getValue_unbound(t,e){this.bind(),this.getValue(t,e)}_setValue_unbound(t,e){this.bind(),this.setValue(t,e)}bind(){let t=this.node,e=this.parsedPath,n=e.objectName,s=e.propertyName,r=e.propertyIndex;if(t||(t=i.findNode(this.rootNode,e.nodeName),this.node=t),this.getValue=this._getValue_unavailable,this.setValue=this._setValue_unavailable,!t){console.warn("THREE.PropertyBinding: No target node found for track: "+this.path+".");return}if(n){let c=e.objectIndex;switch(n){case"materials":if(!t.material){console.error("THREE.PropertyBinding: Can not bind to material as node does not have a material.",this);return}if(!t.material.materials){console.error("THREE.PropertyBinding: Can not bind to material.materials as node.material does not have a materials array.",this);return}t=t.material.materials;break;case"bones":if(!t.skeleton){console.error("THREE.PropertyBinding: Can not bind to bones as node does not have a skeleton.",this);return}t=t.skeleton.bones;for(let h=0;h<t.length;h++)if(t[h].name===c){c=h;break}break;case"map":if("map"in t){t=t.map;break}if(!t.material){console.error("THREE.PropertyBinding: Can not bind to material as node does not have a material.",this);return}if(!t.material.map){console.error("THREE.PropertyBinding: Can not bind to material.map as node.material does not have a map.",this);return}t=t.material.map;break;default:if(t[n]===void 0){console.error("THREE.PropertyBinding: Can not bind to objectName of node undefined.",this);return}t=t[n]}if(c!==void 0){if(t[c]===void 0){console.error("THREE.PropertyBinding: Trying to bind to objectIndex of objectName, but is undefined.",this,t);return}t=t[c]}}let o=t[s];if(o===void 0){let c=e.nodeName;console.error("THREE.PropertyBinding: Trying to update property for track: "+c+"."+s+" but it wasn't found.",t);return}let a=this.Versioning.None;this.targetObject=t,t.isMaterial===!0?a=this.Versioning.NeedsUpdate:t.isObject3D===!0&&(a=this.Versioning.MatrixWorldNeedsUpdate);let l=this.BindingType.Direct;if(r!==void 0){if(s==="morphTargetInfluences"){if(!t.geometry){console.error("THREE.PropertyBinding: Can not bind to morphTargetInfluences because node does not have a geometry.",this);return}if(!t.geometry.morphAttributes){console.error("THREE.PropertyBinding: Can not bind to morphTargetInfluences because node does not have a geometry.morphAttributes.",this);return}t.morphTargetDictionary[r]!==void 0&&(r=t.morphTargetDictionary[r])}l=this.BindingType.ArrayElement,this.resolvedProperty=o,this.propertyIndex=r}else o.fromArray!==void 0&&o.toArray!==void 0?(l=this.BindingType.HasFromToArray,this.resolvedProperty=o):Array.isArray(o)?(l=this.BindingType.EntireArray,this.resolvedProperty=o):this.propertyName=s;this.getValue=this.GetterByBindingType[l],this.setValue=this.SetterByBindingTypeAndVersioning[l][a]}unbind(){this.node=null,this.getValue=this._getValue_unbound,this.setValue=this._setValue_unbound}};ae.Composite=$a;ae.prototype.BindingType={Direct:0,EntireArray:1,ArrayElement:2,HasFromToArray:3};ae.prototype.Versioning={None:0,NeedsUpdate:1,MatrixWorldNeedsUpdate:2};ae.prototype.GetterByBindingType=[ae.prototype._getValue_direct,ae.prototype._getValue_array,ae.prototype._getValue_arrayElement,ae.prototype._getValue_toArray];ae.prototype.SetterByBindingTypeAndVersioning=[[ae.prototype._setValue_direct,ae.prototype._setValue_direct_setNeedsUpdate,ae.prototype._setValue_direct_setMatrixWorldNeedsUpdate],[ae.prototype._setValue_array,ae.prototype._setValue_array_setNeedsUpdate,ae.prototype._setValue_array_setMatrixWorldNeedsUpdate],[ae.prototype._setValue_arrayElement,ae.prototype._setValue_arrayElement_setNeedsUpdate,ae.prototype._setValue_arrayElement_setMatrixWorldNeedsUpdate],[ae.prototype._setValue_fromArray,ae.prototype._setValue_fromArray_setNeedsUpdate,ae.prototype._setValue_fromArray_setMatrixWorldNeedsUpdate]];var N_=new Float32Array(1);var Ec=new fe,Js=class{constructor(t,e,n=0,s=1/0){this.ray=new ci(t,e),this.near=n,this.far=s,this.camera=null,this.layers=new Xi,this.params={Mesh:{},Line:{threshold:1},LOD:{},Points:{threshold:1},Sprite:{}}}set(t,e){this.ray.set(t,e)}setFromCamera(t,e){e.isPerspectiveCamera?(this.ray.origin.setFromMatrixPosition(e.matrixWorld),this.ray.direction.set(t.x,t.y,.5).unproject(e).sub(this.ray.origin).normalize(),this.camera=e):e.isOrthographicCamera?(this.ray.origin.set(t.x,t.y,(e.near+e.far)/(e.near-e.far)).unproject(e),this.ray.direction.set(0,0,-1).transformDirection(e.matrixWorld),this.camera=e):console.error("THREE.Raycaster: Unsupported camera type: "+e.type)}setFromXRController(t){return Ec.identity().extractRotation(t.matrixWorld),this.ray.origin.setFromMatrixPosition(t.matrixWorld),this.ray.direction.set(0,0,-1).applyMatrix4(Ec),this}intersectObject(t,e=!0,n=[]){return Ka(t,this,n,e),n.sort(Tc),n}intersectObjects(t,e=!0,n=[]){for(let s=0,r=t.length;s<r;s++)Ka(t[s],this,n,e);return n.sort(Tc),n}};function Tc(i,t){return i.distance-t.distance}function Ka(i,t,e,n){let s=!0;if(i.layers.test(t.layers)&&i.raycast(t,e)===!1&&(s=!1),s===!0&&n===!0){let r=i.children;for(let o=0,a=r.length;o<a;o++)Ka(r[o],t,e,!0)}}var Qi=class{constructor(t=1,e=0,n=0){this.radius=t,this.phi=e,this.theta=n}set(t,e,n){return this.radius=t,this.phi=e,this.theta=n,this}copy(t){return this.radius=t.radius,this.phi=t.phi,this.theta=t.theta,this}makeSafe(){return this.phi=Gt(this.phi,1e-6,Math.PI-1e-6),this}setFromVector3(t){return this.setFromCartesianCoords(t.x,t.y,t.z)}setFromCartesianCoords(t,e,n){return this.radius=Math.sqrt(t*t+e*e+n*n),this.radius===0?(this.theta=0,this.phi=0):(this.theta=Math.atan2(t,n),this.phi=Math.acos(Gt(e/this.radius,-1,1))),this}clone(){return new this.constructor().copy(this)}};var $s=class extends fn{constructor(t,e=null){super(),this.object=t,this.domElement=e,this.enabled=!0,this.state=-1,this.keys={},this.mouseButtons={LEFT:null,MIDDLE:null,RIGHT:null},this.touches={ONE:null,TWO:null}}connect(t){if(t===void 0){console.warn("THREE.Controls: connect() now requires an element.");return}this.domElement!==null&&this.disconnect(),this.domElement=t}disconnect(){}dispose(){}update(){}};function bl(i,t,e,n){let s=Od(n);switch(e){case cl:return i*t;case ul:return i*t/s.components*s.byteLength;case bo:return i*t/s.components*s.byteLength;case dl:return i*t*2/s.components*s.byteLength;case Eo:return i*t*2/s.components*s.byteLength;case hl:return i*t*3/s.components*s.byteLength;case Qe:return i*t*4/s.components*s.byteLength;case To:return i*t*4/s.components*s.byteLength;case Qs:case tr:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*8;case er:case nr:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*16;case Ao:case Ro:return Math.max(i,16)*Math.max(t,8)/4;case wo:case Co:return Math.max(i,8)*Math.max(t,8)/2;case Io:case Po:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*8;case Do:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*16;case Lo:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*16;case Uo:return Math.floor((i+4)/5)*Math.floor((t+3)/4)*16;case No:return Math.floor((i+4)/5)*Math.floor((t+4)/5)*16;case Fo:return Math.floor((i+5)/6)*Math.floor((t+4)/5)*16;case Oo:return Math.floor((i+5)/6)*Math.floor((t+5)/6)*16;case Bo:return Math.floor((i+7)/8)*Math.floor((t+4)/5)*16;case zo:return Math.floor((i+7)/8)*Math.floor((t+5)/6)*16;case ko:return Math.floor((i+7)/8)*Math.floor((t+7)/8)*16;case Vo:return Math.floor((i+9)/10)*Math.floor((t+4)/5)*16;case Ho:return Math.floor((i+9)/10)*Math.floor((t+5)/6)*16;case Go:return Math.floor((i+9)/10)*Math.floor((t+7)/8)*16;case Wo:return Math.floor((i+9)/10)*Math.floor((t+9)/10)*16;case Xo:return Math.floor((i+11)/12)*Math.floor((t+9)/10)*16;case qo:return Math.floor((i+11)/12)*Math.floor((t+11)/12)*16;case Yo:case Zo:case Jo:return Math.ceil(i/4)*Math.ceil(t/4)*16;case $o:case Ko:return Math.ceil(i/4)*Math.ceil(t/4)*8;case jo:case Qo:return Math.ceil(i/4)*Math.ceil(t/4)*16}throw new Error(`Unable to determine texture byte length for ${e} format.`)}function Od(i){switch(i){case cn:case rl:return{byteLength:1,components:1};case ts:case ol:case es:return{byteLength:2,components:1};case Mo:case So:return{byteLength:2,components:4};case $n:case vo:case _n:return{byteLength:4,components:1};case al:case ll:return{byteLength:4,components:3}}throw new Error(`Unknown texture type ${i}.`)}typeof __THREE_DEVTOOLS__<"u"&&__THREE_DEVTOOLS__.dispatchEvent(new CustomEvent("register",{detail:{revision:"180"}}));typeof window<"u"&&(window.__THREE__?console.warn("WARNING: Multiple instances of Three.js being imported."):window.__THREE__="180");function Gh(){let i=null,t=!1,e=null,n=null;function s(r,o){e(r,o),n=i.requestAnimationFrame(s)}return{start:function(){t!==!0&&e!==null&&(n=i.requestAnimationFrame(s),t=!0)},stop:function(){i.cancelAnimationFrame(n),t=!1},setAnimationLoop:function(r){e=r},setContext:function(r){i=r}}}function kd(i){let t=new WeakMap;function e(a,l){let c=a.array,h=a.usage,u=c.byteLength,f=i.createBuffer();i.bindBuffer(l,f),i.bufferData(l,c,h),a.onUploadCallback();let p;if(c instanceof Float32Array)p=i.FLOAT;else if(typeof Float16Array<"u"&&c instanceof Float16Array)p=i.HALF_FLOAT;else if(c instanceof Uint16Array)a.isFloat16BufferAttribute?p=i.HALF_FLOAT:p=i.UNSIGNED_SHORT;else if(c instanceof Int16Array)p=i.SHORT;else if(c instanceof Uint32Array)p=i.UNSIGNED_INT;else if(c instanceof Int32Array)p=i.INT;else if(c instanceof Int8Array)p=i.BYTE;else if(c instanceof Uint8Array)p=i.UNSIGNED_BYTE;else if(c instanceof Uint8ClampedArray)p=i.UNSIGNED_BYTE;else throw new Error("THREE.WebGLAttributes: Unsupported buffer data format: "+c);return{buffer:f,type:p,bytesPerElement:c.BYTES_PER_ELEMENT,version:a.version,size:u}}function n(a,l,c){let h=l.array,u=l.updateRanges;if(i.bindBuffer(c,a),u.length===0)i.bufferSubData(c,0,h);else{u.sort((p,g)=>p.start-g.start);let f=0;for(let p=1;p<u.length;p++){let g=u[f],y=u[p];y.start<=g.start+g.count+1?g.count=Math.max(g.count,y.start+y.count-g.start):(++f,u[f]=y)}u.length=f+1;for(let p=0,g=u.length;p<g;p++){let y=u[p];i.bufferSubData(c,y.start*h.BYTES_PER_ELEMENT,h,y.start,y.count)}l.clearUpdateRanges()}l.onUploadCallback()}function s(a){return a.isInterleavedBufferAttribute&&(a=a.data),t.get(a)}function r(a){a.isInterleavedBufferAttribute&&(a=a.data);let l=t.get(a);l&&(i.deleteBuffer(l.buffer),t.delete(a))}function o(a,l){if(a.isInterleavedBufferAttribute&&(a=a.data),a.isGLBufferAttribute){let h=t.get(a);(!h||h.version<a.version)&&t.set(a,{buffer:a.buffer,type:a.type,bytesPerElement:a.elementSize,version:a.version});return}let c=t.get(a);if(c===void 0)t.set(a,e(a,l));else if(c.version<a.version){if(c.size!==a.array.byteLength)throw new Error("THREE.WebGLAttributes: The size of the buffer attribute's array buffer does not match the original size. Resizing buffer attributes is not supported.");n(c.buffer,a,l),c.version=a.version}}return{get:s,remove:r,update:o}}var Vd=`#ifdef USE_ALPHAHASH
	if ( diffuseColor.a < getAlphaHashThreshold( vPosition ) ) discard;
#endif`,Hd=`#ifdef USE_ALPHAHASH
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
#endif`,Gd=`#ifdef USE_ALPHAMAP
	diffuseColor.a *= texture2D( alphaMap, vAlphaMapUv ).g;
#endif`,Wd=`#ifdef USE_ALPHAMAP
	uniform sampler2D alphaMap;
#endif`,Xd=`#ifdef USE_ALPHATEST
	#ifdef ALPHA_TO_COVERAGE
	diffuseColor.a = smoothstep( alphaTest, alphaTest + fwidth( diffuseColor.a ), diffuseColor.a );
	if ( diffuseColor.a == 0.0 ) discard;
	#else
	if ( diffuseColor.a < alphaTest ) discard;
	#endif
#endif`,qd=`#ifdef USE_ALPHATEST
	uniform float alphaTest;
#endif`,Yd=`#ifdef USE_AOMAP
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
#endif`,Zd=`#ifdef USE_AOMAP
	uniform sampler2D aoMap;
	uniform float aoMapIntensity;
#endif`,Jd=`#ifdef USE_BATCHING
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
#endif`,$d=`#ifdef USE_BATCHING
	mat4 batchingMatrix = getBatchingMatrix( getIndirectIndex( gl_DrawID ) );
#endif`,Kd=`vec3 transformed = vec3( position );
#ifdef USE_ALPHAHASH
	vPosition = vec3( position );
#endif`,jd=`vec3 objectNormal = vec3( normal );
#ifdef USE_TANGENT
	vec3 objectTangent = vec3( tangent.xyz );
#endif`,Qd=`float G_BlinnPhong_Implicit( ) {
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
} // validated`,tf=`#ifdef USE_IRIDESCENCE
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
#endif`,ef=`#ifdef USE_BUMPMAP
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
#endif`,nf=`#if NUM_CLIPPING_PLANES > 0
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
#endif`,sf=`#if NUM_CLIPPING_PLANES > 0
	varying vec3 vClipPosition;
	uniform vec4 clippingPlanes[ NUM_CLIPPING_PLANES ];
#endif`,rf=`#if NUM_CLIPPING_PLANES > 0
	varying vec3 vClipPosition;
#endif`,of=`#if NUM_CLIPPING_PLANES > 0
	vClipPosition = - mvPosition.xyz;
#endif`,af=`#if defined( USE_COLOR_ALPHA )
	diffuseColor *= vColor;
#elif defined( USE_COLOR )
	diffuseColor.rgb *= vColor;
#endif`,lf=`#if defined( USE_COLOR_ALPHA )
	varying vec4 vColor;
#elif defined( USE_COLOR )
	varying vec3 vColor;
#endif`,cf=`#if defined( USE_COLOR_ALPHA )
	varying vec4 vColor;
#elif defined( USE_COLOR ) || defined( USE_INSTANCING_COLOR ) || defined( USE_BATCHING_COLOR )
	varying vec3 vColor;
#endif`,hf=`#if defined( USE_COLOR_ALPHA )
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
#endif`,uf=`#define PI 3.141592653589793
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
} // validated`,df=`#ifdef ENVMAP_TYPE_CUBE_UV
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
#endif`,ff=`vec3 transformedNormal = objectNormal;
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
#endif`,pf=`#ifdef USE_DISPLACEMENTMAP
	uniform sampler2D displacementMap;
	uniform float displacementScale;
	uniform float displacementBias;
#endif`,mf=`#ifdef USE_DISPLACEMENTMAP
	transformed += normalize( objectNormal ) * ( texture2D( displacementMap, vDisplacementMapUv ).x * displacementScale + displacementBias );
#endif`,gf=`#ifdef USE_EMISSIVEMAP
	vec4 emissiveColor = texture2D( emissiveMap, vEmissiveMapUv );
	#ifdef DECODE_VIDEO_TEXTURE_EMISSIVE
		emissiveColor = sRGBTransferEOTF( emissiveColor );
	#endif
	totalEmissiveRadiance *= emissiveColor.rgb;
#endif`,_f=`#ifdef USE_EMISSIVEMAP
	uniform sampler2D emissiveMap;
#endif`,xf="gl_FragColor = linearToOutputTexel( gl_FragColor );",yf=`vec4 LinearTransferOETF( in vec4 value ) {
	return value;
}
vec4 sRGBTransferEOTF( in vec4 value ) {
	return vec4( mix( pow( value.rgb * 0.9478672986 + vec3( 0.0521327014 ), vec3( 2.4 ) ), value.rgb * 0.0773993808, vec3( lessThanEqual( value.rgb, vec3( 0.04045 ) ) ) ), value.a );
}
vec4 sRGBTransferOETF( in vec4 value ) {
	return vec4( mix( pow( value.rgb, vec3( 0.41666 ) ) * 1.055 - vec3( 0.055 ), value.rgb * 12.92, vec3( lessThanEqual( value.rgb, vec3( 0.0031308 ) ) ) ), value.a );
}`,vf=`#ifdef USE_ENVMAP
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
#endif`,Mf=`#ifdef USE_ENVMAP
	uniform float envMapIntensity;
	uniform float flipEnvMap;
	uniform mat3 envMapRotation;
	#ifdef ENVMAP_TYPE_CUBE
		uniform samplerCube envMap;
	#else
		uniform sampler2D envMap;
	#endif
	
#endif`,Sf=`#ifdef USE_ENVMAP
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
#endif`,bf=`#ifdef USE_ENVMAP
	#if defined( USE_BUMPMAP ) || defined( USE_NORMALMAP ) || defined( PHONG ) || defined( LAMBERT )
		#define ENV_WORLDPOS
	#endif
	#ifdef ENV_WORLDPOS
		
		varying vec3 vWorldPosition;
	#else
		varying vec3 vReflect;
		uniform float refractionRatio;
	#endif
#endif`,Ef=`#ifdef USE_ENVMAP
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
#endif`,Tf=`#ifdef USE_FOG
	vFogDepth = - mvPosition.z;
#endif`,wf=`#ifdef USE_FOG
	varying float vFogDepth;
#endif`,Af=`#ifdef USE_FOG
	#ifdef FOG_EXP2
		float fogFactor = 1.0 - exp( - fogDensity * fogDensity * vFogDepth * vFogDepth );
	#else
		float fogFactor = smoothstep( fogNear, fogFar, vFogDepth );
	#endif
	gl_FragColor.rgb = mix( gl_FragColor.rgb, fogColor, fogFactor );
#endif`,Cf=`#ifdef USE_FOG
	uniform vec3 fogColor;
	varying float vFogDepth;
	#ifdef FOG_EXP2
		uniform float fogDensity;
	#else
		uniform float fogNear;
		uniform float fogFar;
	#endif
#endif`,Rf=`#ifdef USE_GRADIENTMAP
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
}`,If=`#ifdef USE_LIGHTMAP
	uniform sampler2D lightMap;
	uniform float lightMapIntensity;
#endif`,Pf=`LambertMaterial material;
material.diffuseColor = diffuseColor.rgb;
material.specularStrength = specularStrength;`,Df=`varying vec3 vViewPosition;
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
#define RE_IndirectDiffuse		RE_IndirectDiffuse_Lambert`,Lf=`uniform bool receiveShadow;
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
#endif`,Uf=`#ifdef USE_ENVMAP
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
#endif`,Nf=`ToonMaterial material;
material.diffuseColor = diffuseColor.rgb;`,Ff=`varying vec3 vViewPosition;
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
#define RE_IndirectDiffuse		RE_IndirectDiffuse_Toon`,Of=`BlinnPhongMaterial material;
material.diffuseColor = diffuseColor.rgb;
material.specularColor = specular;
material.specularShininess = shininess;
material.specularStrength = specularStrength;`,Bf=`varying vec3 vViewPosition;
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
#define RE_IndirectDiffuse		RE_IndirectDiffuse_BlinnPhong`,zf=`PhysicalMaterial material;
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
#endif`,kf=`struct PhysicalMaterial {
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
}`,Vf=`
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
#endif`,Hf=`#if defined( RE_IndirectDiffuse )
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
#endif`,Gf=`#if defined( RE_IndirectDiffuse )
	RE_IndirectDiffuse( irradiance, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
#endif
#if defined( RE_IndirectSpecular )
	RE_IndirectSpecular( radiance, iblIrradiance, clearcoatRadiance, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
#endif`,Wf=`#if defined( USE_LOGARITHMIC_DEPTH_BUFFER )
	gl_FragDepth = vIsPerspective == 0.0 ? gl_FragCoord.z : log2( vFragDepth ) * logDepthBufFC * 0.5;
#endif`,Xf=`#if defined( USE_LOGARITHMIC_DEPTH_BUFFER )
	uniform float logDepthBufFC;
	varying float vFragDepth;
	varying float vIsPerspective;
#endif`,qf=`#ifdef USE_LOGARITHMIC_DEPTH_BUFFER
	varying float vFragDepth;
	varying float vIsPerspective;
#endif`,Yf=`#ifdef USE_LOGARITHMIC_DEPTH_BUFFER
	vFragDepth = 1.0 + gl_Position.w;
	vIsPerspective = float( isPerspectiveMatrix( projectionMatrix ) );
#endif`,Zf=`#ifdef USE_MAP
	vec4 sampledDiffuseColor = texture2D( map, vMapUv );
	#ifdef DECODE_VIDEO_TEXTURE
		sampledDiffuseColor = sRGBTransferEOTF( sampledDiffuseColor );
	#endif
	diffuseColor *= sampledDiffuseColor;
#endif`,Jf=`#ifdef USE_MAP
	uniform sampler2D map;
#endif`,$f=`#if defined( USE_MAP ) || defined( USE_ALPHAMAP )
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
#endif`,Kf=`#if defined( USE_POINTS_UV )
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
#endif`,jf=`float metalnessFactor = metalness;
#ifdef USE_METALNESSMAP
	vec4 texelMetalness = texture2D( metalnessMap, vMetalnessMapUv );
	metalnessFactor *= texelMetalness.b;
#endif`,Qf=`#ifdef USE_METALNESSMAP
	uniform sampler2D metalnessMap;
#endif`,tp=`#ifdef USE_INSTANCING_MORPH
	float morphTargetInfluences[ MORPHTARGETS_COUNT ];
	float morphTargetBaseInfluence = texelFetch( morphTexture, ivec2( 0, gl_InstanceID ), 0 ).r;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		morphTargetInfluences[i] =  texelFetch( morphTexture, ivec2( i + 1, gl_InstanceID ), 0 ).r;
	}
#endif`,ep=`#if defined( USE_MORPHCOLORS )
	vColor *= morphTargetBaseInfluence;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		#if defined( USE_COLOR_ALPHA )
			if ( morphTargetInfluences[ i ] != 0.0 ) vColor += getMorph( gl_VertexID, i, 2 ) * morphTargetInfluences[ i ];
		#elif defined( USE_COLOR )
			if ( morphTargetInfluences[ i ] != 0.0 ) vColor += getMorph( gl_VertexID, i, 2 ).rgb * morphTargetInfluences[ i ];
		#endif
	}
#endif`,np=`#ifdef USE_MORPHNORMALS
	objectNormal *= morphTargetBaseInfluence;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		if ( morphTargetInfluences[ i ] != 0.0 ) objectNormal += getMorph( gl_VertexID, i, 1 ).xyz * morphTargetInfluences[ i ];
	}
#endif`,ip=`#ifdef USE_MORPHTARGETS
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
#endif`,sp=`#ifdef USE_MORPHTARGETS
	transformed *= morphTargetBaseInfluence;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		if ( morphTargetInfluences[ i ] != 0.0 ) transformed += getMorph( gl_VertexID, i, 0 ).xyz * morphTargetInfluences[ i ];
	}
#endif`,rp=`float faceDirection = gl_FrontFacing ? 1.0 : - 1.0;
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
vec3 nonPerturbedNormal = normal;`,op=`#ifdef USE_NORMALMAP_OBJECTSPACE
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
#endif`,ap=`#ifndef FLAT_SHADED
	varying vec3 vNormal;
	#ifdef USE_TANGENT
		varying vec3 vTangent;
		varying vec3 vBitangent;
	#endif
#endif`,lp=`#ifndef FLAT_SHADED
	varying vec3 vNormal;
	#ifdef USE_TANGENT
		varying vec3 vTangent;
		varying vec3 vBitangent;
	#endif
#endif`,cp=`#ifndef FLAT_SHADED
	vNormal = normalize( transformedNormal );
	#ifdef USE_TANGENT
		vTangent = normalize( transformedTangent );
		vBitangent = normalize( cross( vNormal, vTangent ) * tangent.w );
	#endif
#endif`,hp=`#ifdef USE_NORMALMAP
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
#endif`,up=`#ifdef USE_CLEARCOAT
	vec3 clearcoatNormal = nonPerturbedNormal;
#endif`,dp=`#ifdef USE_CLEARCOAT_NORMALMAP
	vec3 clearcoatMapN = texture2D( clearcoatNormalMap, vClearcoatNormalMapUv ).xyz * 2.0 - 1.0;
	clearcoatMapN.xy *= clearcoatNormalScale;
	clearcoatNormal = normalize( tbn2 * clearcoatMapN );
#endif`,fp=`#ifdef USE_CLEARCOATMAP
	uniform sampler2D clearcoatMap;
#endif
#ifdef USE_CLEARCOAT_NORMALMAP
	uniform sampler2D clearcoatNormalMap;
	uniform vec2 clearcoatNormalScale;
#endif
#ifdef USE_CLEARCOAT_ROUGHNESSMAP
	uniform sampler2D clearcoatRoughnessMap;
#endif`,pp=`#ifdef USE_IRIDESCENCEMAP
	uniform sampler2D iridescenceMap;
#endif
#ifdef USE_IRIDESCENCE_THICKNESSMAP
	uniform sampler2D iridescenceThicknessMap;
#endif`,mp=`#ifdef OPAQUE
diffuseColor.a = 1.0;
#endif
#ifdef USE_TRANSMISSION
diffuseColor.a *= material.transmissionAlpha;
#endif
gl_FragColor = vec4( outgoingLight, diffuseColor.a );`,gp=`vec3 packNormalToRGB( const in vec3 normal ) {
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
}`,_p=`#ifdef PREMULTIPLIED_ALPHA
	gl_FragColor.rgb *= gl_FragColor.a;
#endif`,xp=`vec4 mvPosition = vec4( transformed, 1.0 );
#ifdef USE_BATCHING
	mvPosition = batchingMatrix * mvPosition;
#endif
#ifdef USE_INSTANCING
	mvPosition = instanceMatrix * mvPosition;
#endif
mvPosition = modelViewMatrix * mvPosition;
gl_Position = projectionMatrix * mvPosition;`,yp=`#ifdef DITHERING
	gl_FragColor.rgb = dithering( gl_FragColor.rgb );
#endif`,vp=`#ifdef DITHERING
	vec3 dithering( vec3 color ) {
		float grid_position = rand( gl_FragCoord.xy );
		vec3 dither_shift_RGB = vec3( 0.25 / 255.0, -0.25 / 255.0, 0.25 / 255.0 );
		dither_shift_RGB = mix( 2.0 * dither_shift_RGB, -2.0 * dither_shift_RGB, grid_position );
		return color + dither_shift_RGB;
	}
#endif`,Mp=`float roughnessFactor = roughness;
#ifdef USE_ROUGHNESSMAP
	vec4 texelRoughness = texture2D( roughnessMap, vRoughnessMapUv );
	roughnessFactor *= texelRoughness.g;
#endif`,Sp=`#ifdef USE_ROUGHNESSMAP
	uniform sampler2D roughnessMap;
#endif`,bp=`#if NUM_SPOT_LIGHT_COORDS > 0
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
#endif`,Ep=`#if NUM_SPOT_LIGHT_COORDS > 0
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
#endif`,Tp=`#if ( defined( USE_SHADOWMAP ) && ( NUM_DIR_LIGHT_SHADOWS > 0 || NUM_POINT_LIGHT_SHADOWS > 0 ) ) || ( NUM_SPOT_LIGHT_COORDS > 0 )
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
#endif`,wp=`float getShadowMask() {
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
}`,Ap=`#ifdef USE_SKINNING
	mat4 boneMatX = getBoneMatrix( skinIndex.x );
	mat4 boneMatY = getBoneMatrix( skinIndex.y );
	mat4 boneMatZ = getBoneMatrix( skinIndex.z );
	mat4 boneMatW = getBoneMatrix( skinIndex.w );
#endif`,Cp=`#ifdef USE_SKINNING
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
#endif`,Rp=`#ifdef USE_SKINNING
	vec4 skinVertex = bindMatrix * vec4( transformed, 1.0 );
	vec4 skinned = vec4( 0.0 );
	skinned += boneMatX * skinVertex * skinWeight.x;
	skinned += boneMatY * skinVertex * skinWeight.y;
	skinned += boneMatZ * skinVertex * skinWeight.z;
	skinned += boneMatW * skinVertex * skinWeight.w;
	transformed = ( bindMatrixInverse * skinned ).xyz;
#endif`,Ip=`#ifdef USE_SKINNING
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
#endif`,Pp=`float specularStrength;
#ifdef USE_SPECULARMAP
	vec4 texelSpecular = texture2D( specularMap, vSpecularMapUv );
	specularStrength = texelSpecular.r;
#else
	specularStrength = 1.0;
#endif`,Dp=`#ifdef USE_SPECULARMAP
	uniform sampler2D specularMap;
#endif`,Lp=`#if defined( TONE_MAPPING )
	gl_FragColor.rgb = toneMapping( gl_FragColor.rgb );
#endif`,Up=`#ifndef saturate
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
vec3 CustomToneMapping( vec3 color ) { return color; }`,Np=`#ifdef USE_TRANSMISSION
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
#endif`,Fp=`#ifdef USE_TRANSMISSION
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
#endif`,Op=`#if defined( USE_UV ) || defined( USE_ANISOTROPY )
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
#endif`,Bp=`#if defined( USE_UV ) || defined( USE_ANISOTROPY )
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
#endif`,zp=`#if defined( USE_UV ) || defined( USE_ANISOTROPY )
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
#endif`,kp=`#if defined( USE_ENVMAP ) || defined( DISTANCE ) || defined ( USE_SHADOWMAP ) || defined ( USE_TRANSMISSION ) || NUM_SPOT_LIGHT_COORDS > 0
	vec4 worldPosition = vec4( transformed, 1.0 );
	#ifdef USE_BATCHING
		worldPosition = batchingMatrix * worldPosition;
	#endif
	#ifdef USE_INSTANCING
		worldPosition = instanceMatrix * worldPosition;
	#endif
	worldPosition = modelMatrix * worldPosition;
#endif`,Vp=`varying vec2 vUv;
uniform mat3 uvTransform;
void main() {
	vUv = ( uvTransform * vec3( uv, 1 ) ).xy;
	gl_Position = vec4( position.xy, 1.0, 1.0 );
}`,Hp=`uniform sampler2D t2D;
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
}`,Gp=`varying vec3 vWorldDirection;
#include <common>
void main() {
	vWorldDirection = transformDirection( position, modelMatrix );
	#include <begin_vertex>
	#include <project_vertex>
	gl_Position.z = gl_Position.w;
}`,Wp=`#ifdef ENVMAP_TYPE_CUBE
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
}`,Xp=`varying vec3 vWorldDirection;
#include <common>
void main() {
	vWorldDirection = transformDirection( position, modelMatrix );
	#include <begin_vertex>
	#include <project_vertex>
	gl_Position.z = gl_Position.w;
}`,qp=`uniform samplerCube tCube;
uniform float tFlip;
uniform float opacity;
varying vec3 vWorldDirection;
void main() {
	vec4 texColor = textureCube( tCube, vec3( tFlip * vWorldDirection.x, vWorldDirection.yz ) );
	gl_FragColor = texColor;
	gl_FragColor.a *= opacity;
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
}`,Yp=`#include <common>
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
}`,Zp=`#if DEPTH_PACKING == 3200
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
}`,Jp=`#define DISTANCE
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
}`,$p=`#define DISTANCE
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
}`,Kp=`varying vec3 vWorldDirection;
#include <common>
void main() {
	vWorldDirection = transformDirection( position, modelMatrix );
	#include <begin_vertex>
	#include <project_vertex>
}`,jp=`uniform sampler2D tEquirect;
varying vec3 vWorldDirection;
#include <common>
void main() {
	vec3 direction = normalize( vWorldDirection );
	vec2 sampleUV = equirectUv( direction );
	gl_FragColor = texture2D( tEquirect, sampleUV );
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
}`,Qp=`uniform float scale;
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
}`,tm=`uniform vec3 diffuse;
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
}`,em=`#include <common>
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
}`,nm=`uniform vec3 diffuse;
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
}`,im=`#define LAMBERT
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
}`,sm=`#define LAMBERT
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
}`,rm=`#define MATCAP
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
}`,om=`#define MATCAP
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
}`,am=`#define NORMAL
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
}`,lm=`#define NORMAL
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
}`,cm=`#define PHONG
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
}`,hm=`#define PHONG
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
}`,um=`#define STANDARD
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
}`,dm=`#define STANDARD
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
}`,fm=`#define TOON
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
}`,pm=`#define TOON
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
}`,mm=`uniform float size;
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
}`,gm=`uniform vec3 diffuse;
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
}`,_m=`#include <common>
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
}`,xm=`uniform vec3 color;
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
}`,ym=`uniform float rotation;
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
}`,vm=`uniform vec3 diffuse;
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
}`,Wt={alphahash_fragment:Vd,alphahash_pars_fragment:Hd,alphamap_fragment:Gd,alphamap_pars_fragment:Wd,alphatest_fragment:Xd,alphatest_pars_fragment:qd,aomap_fragment:Yd,aomap_pars_fragment:Zd,batching_pars_vertex:Jd,batching_vertex:$d,begin_vertex:Kd,beginnormal_vertex:jd,bsdfs:Qd,iridescence_fragment:tf,bumpmap_pars_fragment:ef,clipping_planes_fragment:nf,clipping_planes_pars_fragment:sf,clipping_planes_pars_vertex:rf,clipping_planes_vertex:of,color_fragment:af,color_pars_fragment:lf,color_pars_vertex:cf,color_vertex:hf,common:uf,cube_uv_reflection_fragment:df,defaultnormal_vertex:ff,displacementmap_pars_vertex:pf,displacementmap_vertex:mf,emissivemap_fragment:gf,emissivemap_pars_fragment:_f,colorspace_fragment:xf,colorspace_pars_fragment:yf,envmap_fragment:vf,envmap_common_pars_fragment:Mf,envmap_pars_fragment:Sf,envmap_pars_vertex:bf,envmap_physical_pars_fragment:Uf,envmap_vertex:Ef,fog_vertex:Tf,fog_pars_vertex:wf,fog_fragment:Af,fog_pars_fragment:Cf,gradientmap_pars_fragment:Rf,lightmap_pars_fragment:If,lights_lambert_fragment:Pf,lights_lambert_pars_fragment:Df,lights_pars_begin:Lf,lights_toon_fragment:Nf,lights_toon_pars_fragment:Ff,lights_phong_fragment:Of,lights_phong_pars_fragment:Bf,lights_physical_fragment:zf,lights_physical_pars_fragment:kf,lights_fragment_begin:Vf,lights_fragment_maps:Hf,lights_fragment_end:Gf,logdepthbuf_fragment:Wf,logdepthbuf_pars_fragment:Xf,logdepthbuf_pars_vertex:qf,logdepthbuf_vertex:Yf,map_fragment:Zf,map_pars_fragment:Jf,map_particle_fragment:$f,map_particle_pars_fragment:Kf,metalnessmap_fragment:jf,metalnessmap_pars_fragment:Qf,morphinstance_vertex:tp,morphcolor_vertex:ep,morphnormal_vertex:np,morphtarget_pars_vertex:ip,morphtarget_vertex:sp,normal_fragment_begin:rp,normal_fragment_maps:op,normal_pars_fragment:ap,normal_pars_vertex:lp,normal_vertex:cp,normalmap_pars_fragment:hp,clearcoat_normal_fragment_begin:up,clearcoat_normal_fragment_maps:dp,clearcoat_pars_fragment:fp,iridescence_pars_fragment:pp,opaque_fragment:mp,packing:gp,premultiplied_alpha_fragment:_p,project_vertex:xp,dithering_fragment:yp,dithering_pars_fragment:vp,roughnessmap_fragment:Mp,roughnessmap_pars_fragment:Sp,shadowmap_pars_fragment:bp,shadowmap_pars_vertex:Ep,shadowmap_vertex:Tp,shadowmask_pars_fragment:wp,skinbase_vertex:Ap,skinning_pars_vertex:Cp,skinning_vertex:Rp,skinnormal_vertex:Ip,specularmap_fragment:Pp,specularmap_pars_fragment:Dp,tonemapping_fragment:Lp,tonemapping_pars_fragment:Up,transmission_fragment:Np,transmission_pars_fragment:Fp,uv_pars_fragment:Op,uv_pars_vertex:Bp,uv_vertex:zp,worldpos_vertex:kp,background_vert:Vp,background_frag:Hp,backgroundCube_vert:Gp,backgroundCube_frag:Wp,cube_vert:Xp,cube_frag:qp,depth_vert:Yp,depth_frag:Zp,distanceRGBA_vert:Jp,distanceRGBA_frag:$p,equirect_vert:Kp,equirect_frag:jp,linedashed_vert:Qp,linedashed_frag:tm,meshbasic_vert:em,meshbasic_frag:nm,meshlambert_vert:im,meshlambert_frag:sm,meshmatcap_vert:rm,meshmatcap_frag:om,meshnormal_vert:am,meshnormal_frag:lm,meshphong_vert:cm,meshphong_frag:hm,meshphysical_vert:um,meshphysical_frag:dm,meshtoon_vert:fm,meshtoon_frag:pm,points_vert:mm,points_frag:gm,shadow_vert:_m,shadow_frag:xm,sprite_vert:ym,sprite_frag:vm},ft={common:{diffuse:{value:new Yt(16777215)},opacity:{value:1},map:{value:null},mapTransform:{value:new Vt},alphaMap:{value:null},alphaMapTransform:{value:new Vt},alphaTest:{value:0}},specularmap:{specularMap:{value:null},specularMapTransform:{value:new Vt}},envmap:{envMap:{value:null},envMapRotation:{value:new Vt},flipEnvMap:{value:-1},reflectivity:{value:1},ior:{value:1.5},refractionRatio:{value:.98}},aomap:{aoMap:{value:null},aoMapIntensity:{value:1},aoMapTransform:{value:new Vt}},lightmap:{lightMap:{value:null},lightMapIntensity:{value:1},lightMapTransform:{value:new Vt}},bumpmap:{bumpMap:{value:null},bumpMapTransform:{value:new Vt},bumpScale:{value:1}},normalmap:{normalMap:{value:null},normalMapTransform:{value:new Vt},normalScale:{value:new at(1,1)}},displacementmap:{displacementMap:{value:null},displacementMapTransform:{value:new Vt},displacementScale:{value:1},displacementBias:{value:0}},emissivemap:{emissiveMap:{value:null},emissiveMapTransform:{value:new Vt}},metalnessmap:{metalnessMap:{value:null},metalnessMapTransform:{value:new Vt}},roughnessmap:{roughnessMap:{value:null},roughnessMapTransform:{value:new Vt}},gradientmap:{gradientMap:{value:null}},fog:{fogDensity:{value:25e-5},fogNear:{value:1},fogFar:{value:2e3},fogColor:{value:new Yt(16777215)}},lights:{ambientLightColor:{value:[]},lightProbe:{value:[]},directionalLights:{value:[],properties:{direction:{},color:{}}},directionalLightShadows:{value:[],properties:{shadowIntensity:1,shadowBias:{},shadowNormalBias:{},shadowRadius:{},shadowMapSize:{}}},directionalShadowMap:{value:[]},directionalShadowMatrix:{value:[]},spotLights:{value:[],properties:{color:{},position:{},direction:{},distance:{},coneCos:{},penumbraCos:{},decay:{}}},spotLightShadows:{value:[],properties:{shadowIntensity:1,shadowBias:{},shadowNormalBias:{},shadowRadius:{},shadowMapSize:{}}},spotLightMap:{value:[]},spotShadowMap:{value:[]},spotLightMatrix:{value:[]},pointLights:{value:[],properties:{color:{},position:{},decay:{},distance:{}}},pointLightShadows:{value:[],properties:{shadowIntensity:1,shadowBias:{},shadowNormalBias:{},shadowRadius:{},shadowMapSize:{},shadowCameraNear:{},shadowCameraFar:{}}},pointShadowMap:{value:[]},pointShadowMatrix:{value:[]},hemisphereLights:{value:[],properties:{direction:{},skyColor:{},groundColor:{}}},rectAreaLights:{value:[],properties:{color:{},position:{},width:{},height:{}}},ltc_1:{value:null},ltc_2:{value:null}},points:{diffuse:{value:new Yt(16777215)},opacity:{value:1},size:{value:1},scale:{value:1},map:{value:null},alphaMap:{value:null},alphaMapTransform:{value:new Vt},alphaTest:{value:0},uvTransform:{value:new Vt}},sprite:{diffuse:{value:new Yt(16777215)},opacity:{value:1},center:{value:new at(.5,.5)},rotation:{value:0},map:{value:null},mapTransform:{value:new Vt},alphaMap:{value:null},alphaMapTransform:{value:new Vt},alphaTest:{value:0}}},xn={basic:{uniforms:Ie([ft.common,ft.specularmap,ft.envmap,ft.aomap,ft.lightmap,ft.fog]),vertexShader:Wt.meshbasic_vert,fragmentShader:Wt.meshbasic_frag},lambert:{uniforms:Ie([ft.common,ft.specularmap,ft.envmap,ft.aomap,ft.lightmap,ft.emissivemap,ft.bumpmap,ft.normalmap,ft.displacementmap,ft.fog,ft.lights,{emissive:{value:new Yt(0)}}]),vertexShader:Wt.meshlambert_vert,fragmentShader:Wt.meshlambert_frag},phong:{uniforms:Ie([ft.common,ft.specularmap,ft.envmap,ft.aomap,ft.lightmap,ft.emissivemap,ft.bumpmap,ft.normalmap,ft.displacementmap,ft.fog,ft.lights,{emissive:{value:new Yt(0)},specular:{value:new Yt(1118481)},shininess:{value:30}}]),vertexShader:Wt.meshphong_vert,fragmentShader:Wt.meshphong_frag},standard:{uniforms:Ie([ft.common,ft.envmap,ft.aomap,ft.lightmap,ft.emissivemap,ft.bumpmap,ft.normalmap,ft.displacementmap,ft.roughnessmap,ft.metalnessmap,ft.fog,ft.lights,{emissive:{value:new Yt(0)},roughness:{value:1},metalness:{value:0},envMapIntensity:{value:1}}]),vertexShader:Wt.meshphysical_vert,fragmentShader:Wt.meshphysical_frag},toon:{uniforms:Ie([ft.common,ft.aomap,ft.lightmap,ft.emissivemap,ft.bumpmap,ft.normalmap,ft.displacementmap,ft.gradientmap,ft.fog,ft.lights,{emissive:{value:new Yt(0)}}]),vertexShader:Wt.meshtoon_vert,fragmentShader:Wt.meshtoon_frag},matcap:{uniforms:Ie([ft.common,ft.bumpmap,ft.normalmap,ft.displacementmap,ft.fog,{matcap:{value:null}}]),vertexShader:Wt.meshmatcap_vert,fragmentShader:Wt.meshmatcap_frag},points:{uniforms:Ie([ft.points,ft.fog]),vertexShader:Wt.points_vert,fragmentShader:Wt.points_frag},dashed:{uniforms:Ie([ft.common,ft.fog,{scale:{value:1},dashSize:{value:1},totalSize:{value:2}}]),vertexShader:Wt.linedashed_vert,fragmentShader:Wt.linedashed_frag},depth:{uniforms:Ie([ft.common,ft.displacementmap]),vertexShader:Wt.depth_vert,fragmentShader:Wt.depth_frag},normal:{uniforms:Ie([ft.common,ft.bumpmap,ft.normalmap,ft.displacementmap,{opacity:{value:1}}]),vertexShader:Wt.meshnormal_vert,fragmentShader:Wt.meshnormal_frag},sprite:{uniforms:Ie([ft.sprite,ft.fog]),vertexShader:Wt.sprite_vert,fragmentShader:Wt.sprite_frag},background:{uniforms:{uvTransform:{value:new Vt},t2D:{value:null},backgroundIntensity:{value:1}},vertexShader:Wt.background_vert,fragmentShader:Wt.background_frag},backgroundCube:{uniforms:{envMap:{value:null},flipEnvMap:{value:-1},backgroundBlurriness:{value:0},backgroundIntensity:{value:1},backgroundRotation:{value:new Vt}},vertexShader:Wt.backgroundCube_vert,fragmentShader:Wt.backgroundCube_frag},cube:{uniforms:{tCube:{value:null},tFlip:{value:-1},opacity:{value:1}},vertexShader:Wt.cube_vert,fragmentShader:Wt.cube_frag},equirect:{uniforms:{tEquirect:{value:null}},vertexShader:Wt.equirect_vert,fragmentShader:Wt.equirect_frag},distanceRGBA:{uniforms:Ie([ft.common,ft.displacementmap,{referencePosition:{value:new D},nearDistance:{value:1},farDistance:{value:1e3}}]),vertexShader:Wt.distanceRGBA_vert,fragmentShader:Wt.distanceRGBA_frag},shadow:{uniforms:Ie([ft.lights,ft.fog,{color:{value:new Yt(0)},opacity:{value:1}}]),vertexShader:Wt.shadow_vert,fragmentShader:Wt.shadow_frag}};xn.physical={uniforms:Ie([xn.standard.uniforms,{clearcoat:{value:0},clearcoatMap:{value:null},clearcoatMapTransform:{value:new Vt},clearcoatNormalMap:{value:null},clearcoatNormalMapTransform:{value:new Vt},clearcoatNormalScale:{value:new at(1,1)},clearcoatRoughness:{value:0},clearcoatRoughnessMap:{value:null},clearcoatRoughnessMapTransform:{value:new Vt},dispersion:{value:0},iridescence:{value:0},iridescenceMap:{value:null},iridescenceMapTransform:{value:new Vt},iridescenceIOR:{value:1.3},iridescenceThicknessMinimum:{value:100},iridescenceThicknessMaximum:{value:400},iridescenceThicknessMap:{value:null},iridescenceThicknessMapTransform:{value:new Vt},sheen:{value:0},sheenColor:{value:new Yt(0)},sheenColorMap:{value:null},sheenColorMapTransform:{value:new Vt},sheenRoughness:{value:1},sheenRoughnessMap:{value:null},sheenRoughnessMapTransform:{value:new Vt},transmission:{value:0},transmissionMap:{value:null},transmissionMapTransform:{value:new Vt},transmissionSamplerSize:{value:new at},transmissionSamplerMap:{value:null},thickness:{value:0},thicknessMap:{value:null},thicknessMapTransform:{value:new Vt},attenuationDistance:{value:0},attenuationColor:{value:new Yt(0)},specularColor:{value:new Yt(1,1,1)},specularColorMap:{value:null},specularColorMapTransform:{value:new Vt},specularIntensity:{value:1},specularIntensityMap:{value:null},specularIntensityMapTransform:{value:new Vt},anisotropyVector:{value:new at},anisotropyMap:{value:null},anisotropyMapTransform:{value:new Vt}}]),vertexShader:Wt.meshphysical_vert,fragmentShader:Wt.meshphysical_frag};var ta={r:0,b:0,g:0},_i=new on,Mm=new fe;function Sm(i,t,e,n,s,r,o){let a=new Yt(0),l=r===!0?0:1,c,h,u=null,f=0,p=null;function g(E){let v=E.isScene===!0?E.background:null;return v&&v.isTexture&&(v=(E.backgroundBlurriness>0?e:t).get(v)),v}function y(E){let v=!1,C=g(E);C===null?d(a,l):C&&C.isColor&&(d(C,1),v=!0);let A=i.xr.getEnvironmentBlendMode();A==="additive"?n.buffers.color.setClear(0,0,0,1,o):A==="alpha-blend"&&n.buffers.color.setClear(0,0,0,0,o),(i.autoClear||v)&&(n.buffers.depth.setTest(!0),n.buffers.depth.setMask(!0),n.buffers.color.setMask(!0),i.clear(i.autoClearColor,i.autoClearDepth,i.autoClearStencil))}function m(E,v){let C=g(v);C&&(C.isCubeTexture||C.mapping===Ks)?(h===void 0&&(h=new we(new Wn(1,1,1),new ln({name:"BackgroundCubeMaterial",uniforms:gi(xn.backgroundCube.uniforms),vertexShader:xn.backgroundCube.vertexShader,fragmentShader:xn.backgroundCube.fragmentShader,side:Ue,depthTest:!1,depthWrite:!1,fog:!1,allowOverride:!1})),h.geometry.deleteAttribute("normal"),h.geometry.deleteAttribute("uv"),h.onBeforeRender=function(A,I,U){this.matrixWorld.copyPosition(U.matrixWorld)},Object.defineProperty(h.material,"envMap",{get:function(){return this.uniforms.envMap.value}}),s.update(h)),_i.copy(v.backgroundRotation),_i.x*=-1,_i.y*=-1,_i.z*=-1,C.isCubeTexture&&C.isRenderTargetTexture===!1&&(_i.y*=-1,_i.z*=-1),h.material.uniforms.envMap.value=C,h.material.uniforms.flipEnvMap.value=C.isCubeTexture&&C.isRenderTargetTexture===!1?-1:1,h.material.uniforms.backgroundBlurriness.value=v.backgroundBlurriness,h.material.uniforms.backgroundIntensity.value=v.backgroundIntensity,h.material.uniforms.backgroundRotation.value.setFromMatrix4(Mm.makeRotationFromEuler(_i)),h.material.toneMapped=$t.getTransfer(C.colorSpace)!==te,(u!==C||f!==C.version||p!==i.toneMapping)&&(h.material.needsUpdate=!0,u=C,f=C.version,p=i.toneMapping),h.layers.enableAll(),E.unshift(h,h.geometry,h.material,0,0,null)):C&&C.isTexture&&(c===void 0&&(c=new we(new ji(2,2),new ln({name:"BackgroundMaterial",uniforms:gi(xn.background.uniforms),vertexShader:xn.background.vertexShader,fragmentShader:xn.background.fragmentShader,side:An,depthTest:!1,depthWrite:!1,fog:!1,allowOverride:!1})),c.geometry.deleteAttribute("normal"),Object.defineProperty(c.material,"map",{get:function(){return this.uniforms.t2D.value}}),s.update(c)),c.material.uniforms.t2D.value=C,c.material.uniforms.backgroundIntensity.value=v.backgroundIntensity,c.material.toneMapped=$t.getTransfer(C.colorSpace)!==te,C.matrixAutoUpdate===!0&&C.updateMatrix(),c.material.uniforms.uvTransform.value.copy(C.matrix),(u!==C||f!==C.version||p!==i.toneMapping)&&(c.material.needsUpdate=!0,u=C,f=C.version,p=i.toneMapping),c.layers.enableAll(),E.unshift(c,c.geometry,c.material,0,0,null))}function d(E,v){E.getRGB(ta,yl(i)),n.buffers.color.setClear(ta.r,ta.g,ta.b,v,o)}function w(){h!==void 0&&(h.geometry.dispose(),h.material.dispose(),h=void 0),c!==void 0&&(c.geometry.dispose(),c.material.dispose(),c=void 0)}return{getClearColor:function(){return a},setClearColor:function(E,v=1){a.set(E),l=v,d(a,l)},getClearAlpha:function(){return l},setClearAlpha:function(E){l=E,d(a,l)},render:y,addToRenderList:m,dispose:w}}function bm(i,t){let e=i.getParameter(i.MAX_VERTEX_ATTRIBS),n={},s=f(null),r=s,o=!1;function a(M,R,O,k,W){let q=!1,G=u(k,O,R);r!==G&&(r=G,c(r.object)),q=p(M,k,O,W),q&&g(M,k,O,W),W!==null&&t.update(W,i.ELEMENT_ARRAY_BUFFER),(q||o)&&(o=!1,v(M,R,O,k),W!==null&&i.bindBuffer(i.ELEMENT_ARRAY_BUFFER,t.get(W).buffer))}function l(){return i.createVertexArray()}function c(M){return i.bindVertexArray(M)}function h(M){return i.deleteVertexArray(M)}function u(M,R,O){let k=O.wireframe===!0,W=n[M.id];W===void 0&&(W={},n[M.id]=W);let q=W[R.id];q===void 0&&(q={},W[R.id]=q);let G=q[k];return G===void 0&&(G=f(l()),q[k]=G),G}function f(M){let R=[],O=[],k=[];for(let W=0;W<e;W++)R[W]=0,O[W]=0,k[W]=0;return{geometry:null,program:null,wireframe:!1,newAttributes:R,enabledAttributes:O,attributeDivisors:k,object:M,attributes:{},index:null}}function p(M,R,O,k){let W=r.attributes,q=R.attributes,G=0,et=O.getAttributes();for(let H in et)if(et[H].location>=0){let xt=W[H],Mt=q[H];if(Mt===void 0&&(H==="instanceMatrix"&&M.instanceMatrix&&(Mt=M.instanceMatrix),H==="instanceColor"&&M.instanceColor&&(Mt=M.instanceColor)),xt===void 0||xt.attribute!==Mt||Mt&&xt.data!==Mt.data)return!0;G++}return r.attributesNum!==G||r.index!==k}function g(M,R,O,k){let W={},q=R.attributes,G=0,et=O.getAttributes();for(let H in et)if(et[H].location>=0){let xt=q[H];xt===void 0&&(H==="instanceMatrix"&&M.instanceMatrix&&(xt=M.instanceMatrix),H==="instanceColor"&&M.instanceColor&&(xt=M.instanceColor));let Mt={};Mt.attribute=xt,xt&&xt.data&&(Mt.data=xt.data),W[H]=Mt,G++}r.attributes=W,r.attributesNum=G,r.index=k}function y(){let M=r.newAttributes;for(let R=0,O=M.length;R<O;R++)M[R]=0}function m(M){d(M,0)}function d(M,R){let O=r.newAttributes,k=r.enabledAttributes,W=r.attributeDivisors;O[M]=1,k[M]===0&&(i.enableVertexAttribArray(M),k[M]=1),W[M]!==R&&(i.vertexAttribDivisor(M,R),W[M]=R)}function w(){let M=r.newAttributes,R=r.enabledAttributes;for(let O=0,k=R.length;O<k;O++)R[O]!==M[O]&&(i.disableVertexAttribArray(O),R[O]=0)}function E(M,R,O,k,W,q,G){G===!0?i.vertexAttribIPointer(M,R,O,W,q):i.vertexAttribPointer(M,R,O,k,W,q)}function v(M,R,O,k){y();let W=k.attributes,q=O.getAttributes(),G=R.defaultAttributeValues;for(let et in q){let H=q[et];if(H.location>=0){let ut=W[et];if(ut===void 0&&(et==="instanceMatrix"&&M.instanceMatrix&&(ut=M.instanceMatrix),et==="instanceColor"&&M.instanceColor&&(ut=M.instanceColor)),ut!==void 0){let xt=ut.normalized,Mt=ut.itemSize,kt=t.get(ut);if(kt===void 0)continue;let Zt=kt.buffer,Qt=kt.type,Jt=kt.bytesPerElement,Y=Qt===i.INT||Qt===i.UNSIGNED_INT||ut.gpuType===vo;if(ut.isInterleavedBufferAttribute){let tt=ut.data,vt=tt.stride,Pt=ut.offset;if(tt.isInstancedInterleavedBuffer){for(let Tt=0;Tt<H.locationSize;Tt++)d(H.location+Tt,tt.meshPerAttribute);M.isInstancedMesh!==!0&&k._maxInstanceCount===void 0&&(k._maxInstanceCount=tt.meshPerAttribute*tt.count)}else for(let Tt=0;Tt<H.locationSize;Tt++)m(H.location+Tt);i.bindBuffer(i.ARRAY_BUFFER,Zt);for(let Tt=0;Tt<H.locationSize;Tt++)E(H.location+Tt,Mt/H.locationSize,Qt,xt,vt*Jt,(Pt+Mt/H.locationSize*Tt)*Jt,Y)}else{if(ut.isInstancedBufferAttribute){for(let tt=0;tt<H.locationSize;tt++)d(H.location+tt,ut.meshPerAttribute);M.isInstancedMesh!==!0&&k._maxInstanceCount===void 0&&(k._maxInstanceCount=ut.meshPerAttribute*ut.count)}else for(let tt=0;tt<H.locationSize;tt++)m(H.location+tt);i.bindBuffer(i.ARRAY_BUFFER,Zt);for(let tt=0;tt<H.locationSize;tt++)E(H.location+tt,Mt/H.locationSize,Qt,xt,Mt*Jt,Mt/H.locationSize*tt*Jt,Y)}}else if(G!==void 0){let xt=G[et];if(xt!==void 0)switch(xt.length){case 2:i.vertexAttrib2fv(H.location,xt);break;case 3:i.vertexAttrib3fv(H.location,xt);break;case 4:i.vertexAttrib4fv(H.location,xt);break;default:i.vertexAttrib1fv(H.location,xt)}}}}w()}function C(){U();for(let M in n){let R=n[M];for(let O in R){let k=R[O];for(let W in k)h(k[W].object),delete k[W];delete R[O]}delete n[M]}}function A(M){if(n[M.id]===void 0)return;let R=n[M.id];for(let O in R){let k=R[O];for(let W in k)h(k[W].object),delete k[W];delete R[O]}delete n[M.id]}function I(M){for(let R in n){let O=n[R];if(O[M.id]===void 0)continue;let k=O[M.id];for(let W in k)h(k[W].object),delete k[W];delete O[M.id]}}function U(){S(),o=!0,r!==s&&(r=s,c(r.object))}function S(){s.geometry=null,s.program=null,s.wireframe=!1}return{setup:a,reset:U,resetDefaultState:S,dispose:C,releaseStatesOfGeometry:A,releaseStatesOfProgram:I,initAttributes:y,enableAttribute:m,disableUnusedAttributes:w}}function Em(i,t,e){let n;function s(c){n=c}function r(c,h){i.drawArrays(n,c,h),e.update(h,n,1)}function o(c,h,u){u!==0&&(i.drawArraysInstanced(n,c,h,u),e.update(h,n,u))}function a(c,h,u){if(u===0)return;t.get("WEBGL_multi_draw").multiDrawArraysWEBGL(n,c,0,h,0,u);let p=0;for(let g=0;g<u;g++)p+=h[g];e.update(p,n,1)}function l(c,h,u,f){if(u===0)return;let p=t.get("WEBGL_multi_draw");if(p===null)for(let g=0;g<c.length;g++)o(c[g],h[g],f[g]);else{p.multiDrawArraysInstancedWEBGL(n,c,0,h,0,f,0,u);let g=0;for(let y=0;y<u;y++)g+=h[y]*f[y];e.update(g,n,1)}}this.setMode=s,this.render=r,this.renderInstances=o,this.renderMultiDraw=a,this.renderMultiDrawInstances=l}function Tm(i,t,e,n){let s;function r(){if(s!==void 0)return s;if(t.has("EXT_texture_filter_anisotropic")===!0){let I=t.get("EXT_texture_filter_anisotropic");s=i.getParameter(I.MAX_TEXTURE_MAX_ANISOTROPY_EXT)}else s=0;return s}function o(I){return!(I!==Qe&&n.convert(I)!==i.getParameter(i.IMPLEMENTATION_COLOR_READ_FORMAT))}function a(I){let U=I===es&&(t.has("EXT_color_buffer_half_float")||t.has("EXT_color_buffer_float"));return!(I!==cn&&n.convert(I)!==i.getParameter(i.IMPLEMENTATION_COLOR_READ_TYPE)&&I!==_n&&!U)}function l(I){if(I==="highp"){if(i.getShaderPrecisionFormat(i.VERTEX_SHADER,i.HIGH_FLOAT).precision>0&&i.getShaderPrecisionFormat(i.FRAGMENT_SHADER,i.HIGH_FLOAT).precision>0)return"highp";I="mediump"}return I==="mediump"&&i.getShaderPrecisionFormat(i.VERTEX_SHADER,i.MEDIUM_FLOAT).precision>0&&i.getShaderPrecisionFormat(i.FRAGMENT_SHADER,i.MEDIUM_FLOAT).precision>0?"mediump":"lowp"}let c=e.precision!==void 0?e.precision:"highp",h=l(c);h!==c&&(console.warn("THREE.WebGLRenderer:",c,"not supported, using",h,"instead."),c=h);let u=e.logarithmicDepthBuffer===!0,f=e.reversedDepthBuffer===!0&&t.has("EXT_clip_control"),p=i.getParameter(i.MAX_TEXTURE_IMAGE_UNITS),g=i.getParameter(i.MAX_VERTEX_TEXTURE_IMAGE_UNITS),y=i.getParameter(i.MAX_TEXTURE_SIZE),m=i.getParameter(i.MAX_CUBE_MAP_TEXTURE_SIZE),d=i.getParameter(i.MAX_VERTEX_ATTRIBS),w=i.getParameter(i.MAX_VERTEX_UNIFORM_VECTORS),E=i.getParameter(i.MAX_VARYING_VECTORS),v=i.getParameter(i.MAX_FRAGMENT_UNIFORM_VECTORS),C=g>0,A=i.getParameter(i.MAX_SAMPLES);return{isWebGL2:!0,getMaxAnisotropy:r,getMaxPrecision:l,textureFormatReadable:o,textureTypeReadable:a,precision:c,logarithmicDepthBuffer:u,reversedDepthBuffer:f,maxTextures:p,maxVertexTextures:g,maxTextureSize:y,maxCubemapSize:m,maxAttributes:d,maxVertexUniforms:w,maxVaryings:E,maxFragmentUniforms:v,vertexTextures:C,maxSamples:A}}function wm(i){let t=this,e=null,n=0,s=!1,r=!1,o=new $e,a=new Vt,l={value:null,needsUpdate:!1};this.uniform=l,this.numPlanes=0,this.numIntersection=0,this.init=function(u,f){let p=u.length!==0||f||n!==0||s;return s=f,n=u.length,p},this.beginShadows=function(){r=!0,h(null)},this.endShadows=function(){r=!1},this.setGlobalState=function(u,f){e=h(u,f,0)},this.setState=function(u,f,p){let g=u.clippingPlanes,y=u.clipIntersection,m=u.clipShadows,d=i.get(u);if(!s||g===null||g.length===0||r&&!m)r?h(null):c();else{let w=r?0:n,E=w*4,v=d.clippingState||null;l.value=v,v=h(g,f,E,p);for(let C=0;C!==E;++C)v[C]=e[C];d.clippingState=v,this.numIntersection=y?this.numPlanes:0,this.numPlanes+=w}};function c(){l.value!==e&&(l.value=e,l.needsUpdate=n>0),t.numPlanes=n,t.numIntersection=0}function h(u,f,p,g){let y=u!==null?u.length:0,m=null;if(y!==0){if(m=l.value,g!==!0||m===null){let d=p+y*4,w=f.matrixWorldInverse;a.getNormalMatrix(w),(m===null||m.length<d)&&(m=new Float32Array(d));for(let E=0,v=p;E!==y;++E,v+=4)o.copy(u[E]).applyMatrix4(w,a),o.normal.toArray(m,v),m[v+3]=o.constant}l.value=m,l.needsUpdate=!0}return t.numPlanes=y,t.numIntersection=0,m}}function Am(i){let t=new WeakMap;function e(o,a){return a===_o?o.mapping=fi:a===xo&&(o.mapping=pi),o}function n(o){if(o&&o.isTexture){let a=o.mapping;if(a===_o||a===xo)if(t.has(o)){let l=t.get(o).texture;return e(l,o.mapping)}else{let l=o.image;if(l&&l.height>0){let c=new Hr(l.height);return c.fromEquirectangularTexture(i,o),t.set(o,c),o.addEventListener("dispose",s),e(c.texture,o.mapping)}else return null}}return o}function s(o){let a=o.target;a.removeEventListener("dispose",s);let l=t.get(a);l!==void 0&&(t.delete(a),l.dispose())}function r(){t=new WeakMap}return{get:n,dispose:r}}var rs=4,vh=[.125,.215,.35,.446,.526,.582],vi=20,El=new di,Mh=new Yt,Tl=null,wl=0,Al=0,Cl=!1,yi=(1+Math.sqrt(5))/2,ss=1/yi,Sh=[new D(-yi,ss,0),new D(yi,ss,0),new D(-ss,0,yi),new D(ss,0,yi),new D(0,yi,-ss),new D(0,yi,ss),new D(-1,1,-1),new D(1,1,-1),new D(-1,1,1),new D(1,1,1)],Cm=new D,ia=class{constructor(t){this._renderer=t,this._pingPongRenderTarget=null,this._lodMax=0,this._cubeSize=0,this._lodPlanes=[],this._sizeLods=[],this._sigmas=[],this._blurMaterial=null,this._cubemapMaterial=null,this._equirectMaterial=null,this._compileMaterial(this._blurMaterial)}fromScene(t,e=0,n=.1,s=100,r={}){let{size:o=256,position:a=Cm}=r;Tl=this._renderer.getRenderTarget(),wl=this._renderer.getActiveCubeFace(),Al=this._renderer.getActiveMipmapLevel(),Cl=this._renderer.xr.enabled,this._renderer.xr.enabled=!1,this._setSize(o);let l=this._allocateTargets();return l.depthBuffer=!0,this._sceneToCubeUV(t,n,s,l,a),e>0&&this._blur(l,0,0,e),this._applyPMREM(l),this._cleanup(l),l}fromEquirectangular(t,e=null){return this._fromTexture(t,e)}fromCubemap(t,e=null){return this._fromTexture(t,e)}compileCubemapShader(){this._cubemapMaterial===null&&(this._cubemapMaterial=Th(),this._compileMaterial(this._cubemapMaterial))}compileEquirectangularShader(){this._equirectMaterial===null&&(this._equirectMaterial=Eh(),this._compileMaterial(this._equirectMaterial))}dispose(){this._dispose(),this._cubemapMaterial!==null&&this._cubemapMaterial.dispose(),this._equirectMaterial!==null&&this._equirectMaterial.dispose()}_setSize(t){this._lodMax=Math.floor(Math.log2(t)),this._cubeSize=Math.pow(2,this._lodMax)}_dispose(){this._blurMaterial!==null&&this._blurMaterial.dispose(),this._pingPongRenderTarget!==null&&this._pingPongRenderTarget.dispose();for(let t=0;t<this._lodPlanes.length;t++)this._lodPlanes[t].dispose()}_cleanup(t){this._renderer.setRenderTarget(Tl,wl,Al),this._renderer.xr.enabled=Cl,t.scissorTest=!1,ea(t,0,0,t.width,t.height)}_fromTexture(t,e){t.mapping===fi||t.mapping===pi?this._setSize(t.image.length===0?16:t.image[0].width||t.image[0].image.width):this._setSize(t.image.width/4),Tl=this._renderer.getRenderTarget(),wl=this._renderer.getActiveCubeFace(),Al=this._renderer.getActiveMipmapLevel(),Cl=this._renderer.xr.enabled,this._renderer.xr.enabled=!1;let n=e||this._allocateTargets();return this._textureToCubeUV(t,n),this._applyPMREM(n),this._cleanup(n),n}_allocateTargets(){let t=3*Math.max(this._cubeSize,112),e=4*this._cubeSize,n={magFilter:rn,minFilter:rn,generateMipmaps:!1,type:es,format:Qe,colorSpace:li,depthBuffer:!1},s=bh(t,e,n);if(this._pingPongRenderTarget===null||this._pingPongRenderTarget.width!==t||this._pingPongRenderTarget.height!==e){this._pingPongRenderTarget!==null&&this._dispose(),this._pingPongRenderTarget=bh(t,e,n);let{_lodMax:r}=this;({sizeLods:this._sizeLods,lodPlanes:this._lodPlanes,sigmas:this._sigmas}=Rm(r)),this._blurMaterial=Im(r,t,e)}return s}_compileMaterial(t){let e=new we(this._lodPlanes[0],t);this._renderer.compile(e,El)}_sceneToCubeUV(t,e,n,s,r){let l=new Oe(90,1,e,n),c=[1,-1,1,1,1,1],h=[1,1,1,-1,-1,-1],u=this._renderer,f=u.autoClear,p=u.toneMapping;u.getClearColor(Mh),u.toneMapping=Rn,u.autoClear=!1,u.state.buffers.depth.getReversed()&&(u.setRenderTarget(s),u.clearDepth(),u.setRenderTarget(null));let y=new qi({name:"PMREM.Background",side:Ue,depthWrite:!1,depthTest:!1}),m=new we(new Wn,y),d=!1,w=t.background;w?w.isColor&&(y.color.copy(w),t.background=null,d=!0):(y.color.copy(Mh),d=!0);for(let E=0;E<6;E++){let v=E%3;v===0?(l.up.set(0,c[E],0),l.position.set(r.x,r.y,r.z),l.lookAt(r.x+h[E],r.y,r.z)):v===1?(l.up.set(0,0,c[E]),l.position.set(r.x,r.y,r.z),l.lookAt(r.x,r.y+h[E],r.z)):(l.up.set(0,c[E],0),l.position.set(r.x,r.y,r.z),l.lookAt(r.x,r.y,r.z+h[E]));let C=this._cubeSize;ea(s,v*C,E>2?C:0,C,C),u.setRenderTarget(s),d&&u.render(m,l),u.render(t,l)}m.geometry.dispose(),m.material.dispose(),u.toneMapping=p,u.autoClear=f,t.background=w}_textureToCubeUV(t,e){let n=this._renderer,s=t.mapping===fi||t.mapping===pi;s?(this._cubemapMaterial===null&&(this._cubemapMaterial=Th()),this._cubemapMaterial.uniforms.flipEnvMap.value=t.isRenderTargetTexture===!1?-1:1):this._equirectMaterial===null&&(this._equirectMaterial=Eh());let r=s?this._cubemapMaterial:this._equirectMaterial,o=new we(this._lodPlanes[0],r),a=r.uniforms;a.envMap.value=t;let l=this._cubeSize;ea(e,0,0,3*l,2*l),n.setRenderTarget(e),n.render(o,El)}_applyPMREM(t){let e=this._renderer,n=e.autoClear;e.autoClear=!1;let s=this._lodPlanes.length;for(let r=1;r<s;r++){let o=Math.sqrt(this._sigmas[r]*this._sigmas[r]-this._sigmas[r-1]*this._sigmas[r-1]),a=Sh[(s-r-1)%Sh.length];this._blur(t,r-1,r,o,a)}e.autoClear=n}_blur(t,e,n,s,r){let o=this._pingPongRenderTarget;this._halfBlur(t,o,e,n,s,"latitudinal",r),this._halfBlur(o,t,n,n,s,"longitudinal",r)}_halfBlur(t,e,n,s,r,o,a){let l=this._renderer,c=this._blurMaterial;o!=="latitudinal"&&o!=="longitudinal"&&console.error("blur direction must be either latitudinal or longitudinal!");let h=3,u=new we(this._lodPlanes[s],c),f=c.uniforms,p=this._sizeLods[n]-1,g=isFinite(r)?Math.PI/(2*p):2*Math.PI/(2*vi-1),y=r/g,m=isFinite(r)?1+Math.floor(h*y):vi;m>vi&&console.warn(`sigmaRadians, ${r}, is too large and will clip, as it requested ${m} samples when the maximum is set to ${vi}`);let d=[],w=0;for(let I=0;I<vi;++I){let U=I/y,S=Math.exp(-U*U/2);d.push(S),I===0?w+=S:I<m&&(w+=2*S)}for(let I=0;I<d.length;I++)d[I]=d[I]/w;f.envMap.value=t.texture,f.samples.value=m,f.weights.value=d,f.latitudinal.value=o==="latitudinal",a&&(f.poleAxis.value=a);let{_lodMax:E}=this;f.dTheta.value=g,f.mipInt.value=E-n;let v=this._sizeLods[s],C=3*v*(s>E-rs?s-E+rs:0),A=4*(this._cubeSize-v);ea(e,C,A,3*v,2*v),l.setRenderTarget(e),l.render(u,El)}};function Rm(i){let t=[],e=[],n=[],s=i,r=i-rs+1+vh.length;for(let o=0;o<r;o++){let a=Math.pow(2,s);e.push(a);let l=1/a;o>i-rs?l=vh[o-i+rs-1]:o===0&&(l=0),n.push(l);let c=1/(a-2),h=-c,u=1+c,f=[h,h,u,h,u,u,h,h,u,u,h,u],p=6,g=6,y=3,m=2,d=1,w=new Float32Array(y*g*p),E=new Float32Array(m*g*p),v=new Float32Array(d*g*p);for(let A=0;A<p;A++){let I=A%3*2/3-1,U=A>2?0:-1,S=[I,U,0,I+2/3,U,0,I+2/3,U+1,0,I,U,0,I+2/3,U+1,0,I,U+1,0];w.set(S,y*g*A),E.set(f,m*g*A);let M=[A,A,A,A,A,A];v.set(M,d*g*A)}let C=new an;C.setAttribute("position",new Ge(w,y)),C.setAttribute("uv",new Ge(E,m)),C.setAttribute("faceIndex",new Ge(v,d)),t.push(C),s>rs&&s--}return{lodPlanes:t,sizeLods:e,sigmas:n}}function bh(i,t,e){let n=new pn(i,t,e);return n.texture.mapping=Ks,n.texture.name="PMREM.cubeUv",n.scissorTest=!0,n}function ea(i,t,e,n,s){i.viewport.set(t,e,n,s),i.scissor.set(t,e,n,s)}function Im(i,t,e){let n=new Float32Array(vi),s=new D(0,1,0);return new ln({name:"SphericalGaussianBlur",defines:{n:vi,CUBEUV_TEXEL_WIDTH:1/t,CUBEUV_TEXEL_HEIGHT:1/e,CUBEUV_MAX_MIP:`${i}.0`},uniforms:{envMap:{value:null},samples:{value:1},weights:{value:n},latitudinal:{value:!1},dTheta:{value:0},mipInt:{value:0},poleAxis:{value:s}},vertexShader:Bl(),fragmentShader:`

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
		`,blending:Cn,depthTest:!1,depthWrite:!1})}function Eh(){return new ln({name:"EquirectangularToCubeUV",uniforms:{envMap:{value:null}},vertexShader:Bl(),fragmentShader:`

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
		`,blending:Cn,depthTest:!1,depthWrite:!1})}function Th(){return new ln({name:"CubemapToCubeUV",uniforms:{envMap:{value:null},flipEnvMap:{value:-1}},vertexShader:Bl(),fragmentShader:`

			precision mediump float;
			precision mediump int;

			uniform float flipEnvMap;

			varying vec3 vOutputDirection;

			uniform samplerCube envMap;

			void main() {

				gl_FragColor = textureCube( envMap, vec3( flipEnvMap * vOutputDirection.x, vOutputDirection.yz ) );

			}
		`,blending:Cn,depthTest:!1,depthWrite:!1})}function Bl(){return`

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
	`}function Pm(i){let t=new WeakMap,e=null;function n(a){if(a&&a.isTexture){let l=a.mapping,c=l===_o||l===xo,h=l===fi||l===pi;if(c||h){let u=t.get(a),f=u!==void 0?u.texture.pmremVersion:0;if(a.isRenderTargetTexture&&a.pmremVersion!==f)return e===null&&(e=new ia(i)),u=c?e.fromEquirectangular(a,u):e.fromCubemap(a,u),u.texture.pmremVersion=a.pmremVersion,t.set(a,u),u.texture;if(u!==void 0)return u.texture;{let p=a.image;return c&&p&&p.height>0||h&&p&&s(p)?(e===null&&(e=new ia(i)),u=c?e.fromEquirectangular(a):e.fromCubemap(a),u.texture.pmremVersion=a.pmremVersion,t.set(a,u),a.addEventListener("dispose",r),u.texture):null}}}return a}function s(a){let l=0,c=6;for(let h=0;h<c;h++)a[h]!==void 0&&l++;return l===c}function r(a){let l=a.target;l.removeEventListener("dispose",r);let c=t.get(l);c!==void 0&&(t.delete(l),c.dispose())}function o(){t=new WeakMap,e!==null&&(e.dispose(),e=null)}return{get:n,dispose:o}}function Dm(i){let t={};function e(n){if(t[n]!==void 0)return t[n];let s;switch(n){case"WEBGL_depth_texture":s=i.getExtension("WEBGL_depth_texture")||i.getExtension("MOZ_WEBGL_depth_texture")||i.getExtension("WEBKIT_WEBGL_depth_texture");break;case"EXT_texture_filter_anisotropic":s=i.getExtension("EXT_texture_filter_anisotropic")||i.getExtension("MOZ_EXT_texture_filter_anisotropic")||i.getExtension("WEBKIT_EXT_texture_filter_anisotropic");break;case"WEBGL_compressed_texture_s3tc":s=i.getExtension("WEBGL_compressed_texture_s3tc")||i.getExtension("MOZ_WEBGL_compressed_texture_s3tc")||i.getExtension("WEBKIT_WEBGL_compressed_texture_s3tc");break;case"WEBGL_compressed_texture_pvrtc":s=i.getExtension("WEBGL_compressed_texture_pvrtc")||i.getExtension("WEBKIT_WEBGL_compressed_texture_pvrtc");break;default:s=i.getExtension(n)}return t[n]=s,s}return{has:function(n){return e(n)!==null},init:function(){e("EXT_color_buffer_float"),e("WEBGL_clip_cull_distance"),e("OES_texture_float_linear"),e("EXT_color_buffer_half_float"),e("WEBGL_multisampled_render_to_texture"),e("WEBGL_render_shared_exponent")},get:function(n){let s=e(n);return s===null&&Hi("THREE.WebGLRenderer: "+n+" extension not supported."),s}}}function Lm(i,t,e,n){let s={},r=new WeakMap;function o(u){let f=u.target;f.index!==null&&t.remove(f.index);for(let g in f.attributes)t.remove(f.attributes[g]);f.removeEventListener("dispose",o),delete s[f.id];let p=r.get(f);p&&(t.remove(p),r.delete(f)),n.releaseStatesOfGeometry(f),f.isInstancedBufferGeometry===!0&&delete f._maxInstanceCount,e.memory.geometries--}function a(u,f){return s[f.id]===!0||(f.addEventListener("dispose",o),s[f.id]=!0,e.memory.geometries++),f}function l(u){let f=u.attributes;for(let p in f)t.update(f[p],i.ARRAY_BUFFER)}function c(u){let f=[],p=u.index,g=u.attributes.position,y=0;if(p!==null){let w=p.array;y=p.version;for(let E=0,v=w.length;E<v;E+=3){let C=w[E+0],A=w[E+1],I=w[E+2];f.push(C,A,A,I,I,C)}}else if(g!==void 0){let w=g.array;y=g.version;for(let E=0,v=w.length/3-1;E<v;E+=3){let C=E+0,A=E+1,I=E+2;f.push(C,A,A,I,I,C)}}else return;let m=new(xl(f)?As:ws)(f,1);m.version=y;let d=r.get(u);d&&t.remove(d),r.set(u,m)}function h(u){let f=r.get(u);if(f){let p=u.index;p!==null&&f.version<p.version&&c(u)}else c(u);return r.get(u)}return{get:a,update:l,getWireframeAttribute:h}}function Um(i,t,e){let n;function s(f){n=f}let r,o;function a(f){r=f.type,o=f.bytesPerElement}function l(f,p){i.drawElements(n,p,r,f*o),e.update(p,n,1)}function c(f,p,g){g!==0&&(i.drawElementsInstanced(n,p,r,f*o,g),e.update(p,n,g))}function h(f,p,g){if(g===0)return;t.get("WEBGL_multi_draw").multiDrawElementsWEBGL(n,p,0,r,f,0,g);let m=0;for(let d=0;d<g;d++)m+=p[d];e.update(m,n,1)}function u(f,p,g,y){if(g===0)return;let m=t.get("WEBGL_multi_draw");if(m===null)for(let d=0;d<f.length;d++)c(f[d]/o,p[d],y[d]);else{m.multiDrawElementsInstancedWEBGL(n,p,0,r,f,0,y,0,g);let d=0;for(let w=0;w<g;w++)d+=p[w]*y[w];e.update(d,n,1)}}this.setMode=s,this.setIndex=a,this.render=l,this.renderInstances=c,this.renderMultiDraw=h,this.renderMultiDrawInstances=u}function Nm(i){let t={geometries:0,textures:0},e={frame:0,calls:0,triangles:0,points:0,lines:0};function n(r,o,a){switch(e.calls++,o){case i.TRIANGLES:e.triangles+=a*(r/3);break;case i.LINES:e.lines+=a*(r/2);break;case i.LINE_STRIP:e.lines+=a*(r-1);break;case i.LINE_LOOP:e.lines+=a*r;break;case i.POINTS:e.points+=a*r;break;default:console.error("THREE.WebGLInfo: Unknown draw mode:",o);break}}function s(){e.calls=0,e.triangles=0,e.points=0,e.lines=0}return{memory:t,render:e,programs:null,autoReset:!0,reset:s,update:n}}function Fm(i,t,e){let n=new WeakMap,s=new pe;function r(o,a,l){let c=o.morphTargetInfluences,h=a.morphAttributes.position||a.morphAttributes.normal||a.morphAttributes.color,u=h!==void 0?h.length:0,f=n.get(a);if(f===void 0||f.count!==u){let S=function(){I.dispose(),n.delete(a),a.removeEventListener("dispose",S)};f!==void 0&&f.texture.dispose();let p=a.morphAttributes.position!==void 0,g=a.morphAttributes.normal!==void 0,y=a.morphAttributes.color!==void 0,m=a.morphAttributes.position||[],d=a.morphAttributes.normal||[],w=a.morphAttributes.color||[],E=0;p===!0&&(E=1),g===!0&&(E=2),y===!0&&(E=3);let v=a.attributes.position.count*E,C=1;v>t.maxTextureSize&&(C=Math.ceil(v/t.maxTextureSize),v=t.maxTextureSize);let A=new Float32Array(v*C*4*u),I=new Ts(A,v,C,u);I.type=_n,I.needsUpdate=!0;let U=E*4;for(let M=0;M<u;M++){let R=m[M],O=d[M],k=w[M],W=v*C*4*M;for(let q=0;q<R.count;q++){let G=q*U;p===!0&&(s.fromBufferAttribute(R,q),A[W+G+0]=s.x,A[W+G+1]=s.y,A[W+G+2]=s.z,A[W+G+3]=0),g===!0&&(s.fromBufferAttribute(O,q),A[W+G+4]=s.x,A[W+G+5]=s.y,A[W+G+6]=s.z,A[W+G+7]=0),y===!0&&(s.fromBufferAttribute(k,q),A[W+G+8]=s.x,A[W+G+9]=s.y,A[W+G+10]=s.z,A[W+G+11]=k.itemSize===4?s.w:1)}}f={count:u,texture:I,size:new at(v,C)},n.set(a,f),a.addEventListener("dispose",S)}if(o.isInstancedMesh===!0&&o.morphTexture!==null)l.getUniforms().setValue(i,"morphTexture",o.morphTexture,e);else{let p=0;for(let y=0;y<c.length;y++)p+=c[y];let g=a.morphTargetsRelative?1:1-p;l.getUniforms().setValue(i,"morphTargetBaseInfluence",g),l.getUniforms().setValue(i,"morphTargetInfluences",c)}l.getUniforms().setValue(i,"morphTargetsTexture",f.texture,e),l.getUniforms().setValue(i,"morphTargetsTextureSize",f.size)}return{update:r}}function Om(i,t,e,n){let s=new WeakMap;function r(l){let c=n.render.frame,h=l.geometry,u=t.get(l,h);if(s.get(u)!==c&&(t.update(u),s.set(u,c)),l.isInstancedMesh&&(l.hasEventListener("dispose",a)===!1&&l.addEventListener("dispose",a),s.get(l)!==c&&(e.update(l.instanceMatrix,i.ARRAY_BUFFER),l.instanceColor!==null&&e.update(l.instanceColor,i.ARRAY_BUFFER),s.set(l,c))),l.isSkinnedMesh){let f=l.skeleton;s.get(f)!==c&&(f.update(),s.set(f,c))}return u}function o(){s=new WeakMap}function a(l){let c=l.target;c.removeEventListener("dispose",a),e.remove(c.instanceMatrix),c.instanceColor!==null&&e.remove(c.instanceColor)}return{update:r,dispose:o}}var Wh=new We,wh=new Ps(1,1),Xh=new Ts,qh=new kr,Yh=new Rs,Ah=[],Ch=[],Rh=new Float32Array(16),Ih=new Float32Array(9),Ph=new Float32Array(4);function as(i,t,e){let n=i[0];if(n<=0||n>0)return i;let s=t*e,r=Ah[s];if(r===void 0&&(r=new Float32Array(s),Ah[s]=r),t!==0){n.toArray(r,0);for(let o=1,a=0;o!==t;++o)a+=e,i[o].toArray(r,a)}return r}function ye(i,t){if(i.length!==t.length)return!1;for(let e=0,n=i.length;e<n;e++)if(i[e]!==t[e])return!1;return!0}function ve(i,t){for(let e=0,n=t.length;e<n;e++)i[e]=t[e]}function ra(i,t){let e=Ch[t];e===void 0&&(e=new Int32Array(t),Ch[t]=e);for(let n=0;n!==t;++n)e[n]=i.allocateTextureUnit();return e}function Bm(i,t){let e=this.cache;e[0]!==t&&(i.uniform1f(this.addr,t),e[0]=t)}function zm(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y)&&(i.uniform2f(this.addr,t.x,t.y),e[0]=t.x,e[1]=t.y);else{if(ye(e,t))return;i.uniform2fv(this.addr,t),ve(e,t)}}function km(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z)&&(i.uniform3f(this.addr,t.x,t.y,t.z),e[0]=t.x,e[1]=t.y,e[2]=t.z);else if(t.r!==void 0)(e[0]!==t.r||e[1]!==t.g||e[2]!==t.b)&&(i.uniform3f(this.addr,t.r,t.g,t.b),e[0]=t.r,e[1]=t.g,e[2]=t.b);else{if(ye(e,t))return;i.uniform3fv(this.addr,t),ve(e,t)}}function Vm(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z||e[3]!==t.w)&&(i.uniform4f(this.addr,t.x,t.y,t.z,t.w),e[0]=t.x,e[1]=t.y,e[2]=t.z,e[3]=t.w);else{if(ye(e,t))return;i.uniform4fv(this.addr,t),ve(e,t)}}function Hm(i,t){let e=this.cache,n=t.elements;if(n===void 0){if(ye(e,t))return;i.uniformMatrix2fv(this.addr,!1,t),ve(e,t)}else{if(ye(e,n))return;Ph.set(n),i.uniformMatrix2fv(this.addr,!1,Ph),ve(e,n)}}function Gm(i,t){let e=this.cache,n=t.elements;if(n===void 0){if(ye(e,t))return;i.uniformMatrix3fv(this.addr,!1,t),ve(e,t)}else{if(ye(e,n))return;Ih.set(n),i.uniformMatrix3fv(this.addr,!1,Ih),ve(e,n)}}function Wm(i,t){let e=this.cache,n=t.elements;if(n===void 0){if(ye(e,t))return;i.uniformMatrix4fv(this.addr,!1,t),ve(e,t)}else{if(ye(e,n))return;Rh.set(n),i.uniformMatrix4fv(this.addr,!1,Rh),ve(e,n)}}function Xm(i,t){let e=this.cache;e[0]!==t&&(i.uniform1i(this.addr,t),e[0]=t)}function qm(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y)&&(i.uniform2i(this.addr,t.x,t.y),e[0]=t.x,e[1]=t.y);else{if(ye(e,t))return;i.uniform2iv(this.addr,t),ve(e,t)}}function Ym(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z)&&(i.uniform3i(this.addr,t.x,t.y,t.z),e[0]=t.x,e[1]=t.y,e[2]=t.z);else{if(ye(e,t))return;i.uniform3iv(this.addr,t),ve(e,t)}}function Zm(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z||e[3]!==t.w)&&(i.uniform4i(this.addr,t.x,t.y,t.z,t.w),e[0]=t.x,e[1]=t.y,e[2]=t.z,e[3]=t.w);else{if(ye(e,t))return;i.uniform4iv(this.addr,t),ve(e,t)}}function Jm(i,t){let e=this.cache;e[0]!==t&&(i.uniform1ui(this.addr,t),e[0]=t)}function $m(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y)&&(i.uniform2ui(this.addr,t.x,t.y),e[0]=t.x,e[1]=t.y);else{if(ye(e,t))return;i.uniform2uiv(this.addr,t),ve(e,t)}}function Km(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z)&&(i.uniform3ui(this.addr,t.x,t.y,t.z),e[0]=t.x,e[1]=t.y,e[2]=t.z);else{if(ye(e,t))return;i.uniform3uiv(this.addr,t),ve(e,t)}}function jm(i,t){let e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z||e[3]!==t.w)&&(i.uniform4ui(this.addr,t.x,t.y,t.z,t.w),e[0]=t.x,e[1]=t.y,e[2]=t.z,e[3]=t.w);else{if(ye(e,t))return;i.uniform4uiv(this.addr,t),ve(e,t)}}function Qm(i,t,e){let n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s);let r;this.type===i.SAMPLER_2D_SHADOW?(wh.compareFunction=pl,r=wh):r=Wh,e.setTexture2D(t||r,s)}function tg(i,t,e){let n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s),e.setTexture3D(t||qh,s)}function eg(i,t,e){let n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s),e.setTextureCube(t||Yh,s)}function ng(i,t,e){let n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s),e.setTexture2DArray(t||Xh,s)}function ig(i){switch(i){case 5126:return Bm;case 35664:return zm;case 35665:return km;case 35666:return Vm;case 35674:return Hm;case 35675:return Gm;case 35676:return Wm;case 5124:case 35670:return Xm;case 35667:case 35671:return qm;case 35668:case 35672:return Ym;case 35669:case 35673:return Zm;case 5125:return Jm;case 36294:return $m;case 36295:return Km;case 36296:return jm;case 35678:case 36198:case 36298:case 36306:case 35682:return Qm;case 35679:case 36299:case 36307:return tg;case 35680:case 36300:case 36308:case 36293:return eg;case 36289:case 36303:case 36311:case 36292:return ng}}function sg(i,t){i.uniform1fv(this.addr,t)}function rg(i,t){let e=as(t,this.size,2);i.uniform2fv(this.addr,e)}function og(i,t){let e=as(t,this.size,3);i.uniform3fv(this.addr,e)}function ag(i,t){let e=as(t,this.size,4);i.uniform4fv(this.addr,e)}function lg(i,t){let e=as(t,this.size,4);i.uniformMatrix2fv(this.addr,!1,e)}function cg(i,t){let e=as(t,this.size,9);i.uniformMatrix3fv(this.addr,!1,e)}function hg(i,t){let e=as(t,this.size,16);i.uniformMatrix4fv(this.addr,!1,e)}function ug(i,t){i.uniform1iv(this.addr,t)}function dg(i,t){i.uniform2iv(this.addr,t)}function fg(i,t){i.uniform3iv(this.addr,t)}function pg(i,t){i.uniform4iv(this.addr,t)}function mg(i,t){i.uniform1uiv(this.addr,t)}function gg(i,t){i.uniform2uiv(this.addr,t)}function _g(i,t){i.uniform3uiv(this.addr,t)}function xg(i,t){i.uniform4uiv(this.addr,t)}function yg(i,t,e){let n=this.cache,s=t.length,r=ra(e,s);ye(n,r)||(i.uniform1iv(this.addr,r),ve(n,r));for(let o=0;o!==s;++o)e.setTexture2D(t[o]||Wh,r[o])}function vg(i,t,e){let n=this.cache,s=t.length,r=ra(e,s);ye(n,r)||(i.uniform1iv(this.addr,r),ve(n,r));for(let o=0;o!==s;++o)e.setTexture3D(t[o]||qh,r[o])}function Mg(i,t,e){let n=this.cache,s=t.length,r=ra(e,s);ye(n,r)||(i.uniform1iv(this.addr,r),ve(n,r));for(let o=0;o!==s;++o)e.setTextureCube(t[o]||Yh,r[o])}function Sg(i,t,e){let n=this.cache,s=t.length,r=ra(e,s);ye(n,r)||(i.uniform1iv(this.addr,r),ve(n,r));for(let o=0;o!==s;++o)e.setTexture2DArray(t[o]||Xh,r[o])}function bg(i){switch(i){case 5126:return sg;case 35664:return rg;case 35665:return og;case 35666:return ag;case 35674:return lg;case 35675:return cg;case 35676:return hg;case 5124:case 35670:return ug;case 35667:case 35671:return dg;case 35668:case 35672:return fg;case 35669:case 35673:return pg;case 5125:return mg;case 36294:return gg;case 36295:return _g;case 36296:return xg;case 35678:case 36198:case 36298:case 36306:case 35682:return yg;case 35679:case 36299:case 36307:return vg;case 35680:case 36300:case 36308:case 36293:return Mg;case 36289:case 36303:case 36311:case 36292:return Sg}}var Il=class{constructor(t,e,n){this.id=t,this.addr=n,this.cache=[],this.type=e.type,this.setValue=ig(e.type)}},Pl=class{constructor(t,e,n){this.id=t,this.addr=n,this.cache=[],this.type=e.type,this.size=e.size,this.setValue=bg(e.type)}},Dl=class{constructor(t){this.id=t,this.seq=[],this.map={}}setValue(t,e,n){let s=this.seq;for(let r=0,o=s.length;r!==o;++r){let a=s[r];a.setValue(t,e[a.id],n)}}},Rl=/(\w+)(\])?(\[|\.)?/g;function Dh(i,t){i.seq.push(t),i.map[t.id]=t}function Eg(i,t,e){let n=i.name,s=n.length;for(Rl.lastIndex=0;;){let r=Rl.exec(n),o=Rl.lastIndex,a=r[1],l=r[2]==="]",c=r[3];if(l&&(a=a|0),c===void 0||c==="["&&o+2===s){Dh(e,c===void 0?new Il(a,i,t):new Pl(a,i,t));break}else{let u=e.map[a];u===void 0&&(u=new Dl(a),Dh(e,u)),e=u}}}var os=class{constructor(t,e){this.seq=[],this.map={};let n=t.getProgramParameter(e,t.ACTIVE_UNIFORMS);for(let s=0;s<n;++s){let r=t.getActiveUniform(e,s),o=t.getUniformLocation(e,r.name);Eg(r,o,this)}}setValue(t,e,n,s){let r=this.map[e];r!==void 0&&r.setValue(t,n,s)}setOptional(t,e,n){let s=e[n];s!==void 0&&this.setValue(t,n,s)}static upload(t,e,n,s){for(let r=0,o=e.length;r!==o;++r){let a=e[r],l=n[a.id];l.needsUpdate!==!1&&a.setValue(t,l.value,s)}}static seqWithValue(t,e){let n=[];for(let s=0,r=t.length;s!==r;++s){let o=t[s];o.id in e&&n.push(o)}return n}};function Lh(i,t,e){let n=i.createShader(t);return i.shaderSource(n,e),i.compileShader(n),n}var Tg=37297,wg=0;function Ag(i,t){let e=i.split(`
`),n=[],s=Math.max(t-6,0),r=Math.min(t+6,e.length);for(let o=s;o<r;o++){let a=o+1;n.push(`${a===t?">":" "} ${a}: ${e[o]}`)}return n.join(`
`)}var Uh=new Vt;function Cg(i){$t._getMatrix(Uh,$t.workingColorSpace,i);let t=`mat3( ${Uh.elements.map(e=>e.toFixed(4))} )`;switch($t.getTransfer(i)){case Ss:return[t,"LinearTransferOETF"];case te:return[t,"sRGBTransferOETF"];default:return console.warn("THREE.WebGLProgram: Unsupported color space: ",i),[t,"LinearTransferOETF"]}}function Nh(i,t,e){let n=i.getShaderParameter(t,i.COMPILE_STATUS),r=(i.getShaderInfoLog(t)||"").trim();if(n&&r==="")return"";let o=/ERROR: 0:(\d+)/.exec(r);if(o){let a=parseInt(o[1]);return e.toUpperCase()+`

`+r+`

`+Ag(i.getShaderSource(t),a)}else return r}function Rg(i,t){let e=Cg(t);return[`vec4 ${i}( vec4 value ) {`,`	return ${e[1]}( vec4( value.rgb * ${e[0]}, value.a ) );`,"}"].join(`
`)}function Ig(i,t){let e;switch(t){case Zc:e="Linear";break;case Jc:e="Reinhard";break;case $c:e="Cineon";break;case go:e="ACESFilmic";break;case jc:e="AgX";break;case Qc:e="Neutral";break;case Kc:e="Custom";break;default:console.warn("THREE.WebGLProgram: Unsupported toneMapping:",t),e="Linear"}return"vec3 "+i+"( vec3 color ) { return "+e+"ToneMapping( color ); }"}var na=new D;function Pg(){$t.getLuminanceCoefficients(na);let i=na.x.toFixed(4),t=na.y.toFixed(4),e=na.z.toFixed(4);return["float luminance( const in vec3 rgb ) {",`	const vec3 weights = vec3( ${i}, ${t}, ${e} );`,"	return dot( weights, rgb );","}"].join(`
`)}function Dg(i){return[i.extensionClipCullDistance?"#extension GL_ANGLE_clip_cull_distance : require":"",i.extensionMultiDraw?"#extension GL_ANGLE_multi_draw : require":""].filter(ir).join(`
`)}function Lg(i){let t=[];for(let e in i){let n=i[e];n!==!1&&t.push("#define "+e+" "+n)}return t.join(`
`)}function Ug(i,t){let e={},n=i.getProgramParameter(t,i.ACTIVE_ATTRIBUTES);for(let s=0;s<n;s++){let r=i.getActiveAttrib(t,s),o=r.name,a=1;r.type===i.FLOAT_MAT2&&(a=2),r.type===i.FLOAT_MAT3&&(a=3),r.type===i.FLOAT_MAT4&&(a=4),e[o]={type:r.type,location:i.getAttribLocation(t,o),locationSize:a}}return e}function ir(i){return i!==""}function Fh(i,t){let e=t.numSpotLightShadows+t.numSpotLightMaps-t.numSpotLightShadowsWithMaps;return i.replace(/NUM_DIR_LIGHTS/g,t.numDirLights).replace(/NUM_SPOT_LIGHTS/g,t.numSpotLights).replace(/NUM_SPOT_LIGHT_MAPS/g,t.numSpotLightMaps).replace(/NUM_SPOT_LIGHT_COORDS/g,e).replace(/NUM_RECT_AREA_LIGHTS/g,t.numRectAreaLights).replace(/NUM_POINT_LIGHTS/g,t.numPointLights).replace(/NUM_HEMI_LIGHTS/g,t.numHemiLights).replace(/NUM_DIR_LIGHT_SHADOWS/g,t.numDirLightShadows).replace(/NUM_SPOT_LIGHT_SHADOWS_WITH_MAPS/g,t.numSpotLightShadowsWithMaps).replace(/NUM_SPOT_LIGHT_SHADOWS/g,t.numSpotLightShadows).replace(/NUM_POINT_LIGHT_SHADOWS/g,t.numPointLightShadows)}function Oh(i,t){return i.replace(/NUM_CLIPPING_PLANES/g,t.numClippingPlanes).replace(/UNION_CLIPPING_PLANES/g,t.numClippingPlanes-t.numClipIntersection)}var Ng=/^[ \t]*#include +<([\w\d./]+)>/gm;function Ll(i){return i.replace(Ng,Og)}var Fg=new Map;function Og(i,t){let e=Wt[t];if(e===void 0){let n=Fg.get(t);if(n!==void 0)e=Wt[n],console.warn('THREE.WebGLRenderer: Shader chunk "%s" has been deprecated. Use "%s" instead.',t,n);else throw new Error("Can not resolve #include <"+t+">")}return Ll(e)}var Bg=/#pragma unroll_loop_start\s+for\s*\(\s*int\s+i\s*=\s*(\d+)\s*;\s*i\s*<\s*(\d+)\s*;\s*i\s*\+\+\s*\)\s*{([\s\S]+?)}\s+#pragma unroll_loop_end/g;function Bh(i){return i.replace(Bg,zg)}function zg(i,t,e,n){let s="";for(let r=parseInt(t);r<parseInt(e);r++)s+=n.replace(/\[\s*i\s*\]/g,"[ "+r+" ]").replace(/UNROLLED_LOOP_INDEX/g,r);return s}function zh(i){let t=`precision ${i.precision} float;
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
#define LOW_PRECISION`),t}function kg(i){let t="SHADOWMAP_TYPE_BASIC";return i.shadowMapType===Qa?t="SHADOWMAP_TYPE_PCF":i.shadowMapType===ao?t="SHADOWMAP_TYPE_PCF_SOFT":i.shadowMapType===mn&&(t="SHADOWMAP_TYPE_VSM"),t}function Vg(i){let t="ENVMAP_TYPE_CUBE";if(i.envMap)switch(i.envMapMode){case fi:case pi:t="ENVMAP_TYPE_CUBE";break;case Ks:t="ENVMAP_TYPE_CUBE_UV";break}return t}function Hg(i){let t="ENVMAP_MODE_REFLECTION";if(i.envMap)switch(i.envMapMode){case pi:t="ENVMAP_MODE_REFRACTION";break}return t}function Gg(i){let t="ENVMAP_BLENDING_NONE";if(i.envMap)switch(i.combine){case il:t="ENVMAP_BLENDING_MULTIPLY";break;case qc:t="ENVMAP_BLENDING_MIX";break;case Yc:t="ENVMAP_BLENDING_ADD";break}return t}function Wg(i){let t=i.envMapCubeUVHeight;if(t===null)return null;let e=Math.log2(t)-2,n=1/t;return{texelWidth:1/(3*Math.max(Math.pow(2,e),112)),texelHeight:n,maxMip:e}}function Xg(i,t,e,n){let s=i.getContext(),r=e.defines,o=e.vertexShader,a=e.fragmentShader,l=kg(e),c=Vg(e),h=Hg(e),u=Gg(e),f=Wg(e),p=Dg(e),g=Lg(r),y=s.createProgram(),m,d,w=e.glslVersion?"#version "+e.glslVersion+`
`:"";e.isRawShaderMaterial?(m=["#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,g].filter(ir).join(`
`),m.length>0&&(m+=`
`),d=["#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,g].filter(ir).join(`
`),d.length>0&&(d+=`
`)):(m=[zh(e),"#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,g,e.extensionClipCullDistance?"#define USE_CLIP_DISTANCE":"",e.batching?"#define USE_BATCHING":"",e.batchingColor?"#define USE_BATCHING_COLOR":"",e.instancing?"#define USE_INSTANCING":"",e.instancingColor?"#define USE_INSTANCING_COLOR":"",e.instancingMorph?"#define USE_INSTANCING_MORPH":"",e.useFog&&e.fog?"#define USE_FOG":"",e.useFog&&e.fogExp2?"#define FOG_EXP2":"",e.map?"#define USE_MAP":"",e.envMap?"#define USE_ENVMAP":"",e.envMap?"#define "+h:"",e.lightMap?"#define USE_LIGHTMAP":"",e.aoMap?"#define USE_AOMAP":"",e.bumpMap?"#define USE_BUMPMAP":"",e.normalMap?"#define USE_NORMALMAP":"",e.normalMapObjectSpace?"#define USE_NORMALMAP_OBJECTSPACE":"",e.normalMapTangentSpace?"#define USE_NORMALMAP_TANGENTSPACE":"",e.displacementMap?"#define USE_DISPLACEMENTMAP":"",e.emissiveMap?"#define USE_EMISSIVEMAP":"",e.anisotropy?"#define USE_ANISOTROPY":"",e.anisotropyMap?"#define USE_ANISOTROPYMAP":"",e.clearcoatMap?"#define USE_CLEARCOATMAP":"",e.clearcoatRoughnessMap?"#define USE_CLEARCOAT_ROUGHNESSMAP":"",e.clearcoatNormalMap?"#define USE_CLEARCOAT_NORMALMAP":"",e.iridescenceMap?"#define USE_IRIDESCENCEMAP":"",e.iridescenceThicknessMap?"#define USE_IRIDESCENCE_THICKNESSMAP":"",e.specularMap?"#define USE_SPECULARMAP":"",e.specularColorMap?"#define USE_SPECULAR_COLORMAP":"",e.specularIntensityMap?"#define USE_SPECULAR_INTENSITYMAP":"",e.roughnessMap?"#define USE_ROUGHNESSMAP":"",e.metalnessMap?"#define USE_METALNESSMAP":"",e.alphaMap?"#define USE_ALPHAMAP":"",e.alphaHash?"#define USE_ALPHAHASH":"",e.transmission?"#define USE_TRANSMISSION":"",e.transmissionMap?"#define USE_TRANSMISSIONMAP":"",e.thicknessMap?"#define USE_THICKNESSMAP":"",e.sheenColorMap?"#define USE_SHEEN_COLORMAP":"",e.sheenRoughnessMap?"#define USE_SHEEN_ROUGHNESSMAP":"",e.mapUv?"#define MAP_UV "+e.mapUv:"",e.alphaMapUv?"#define ALPHAMAP_UV "+e.alphaMapUv:"",e.lightMapUv?"#define LIGHTMAP_UV "+e.lightMapUv:"",e.aoMapUv?"#define AOMAP_UV "+e.aoMapUv:"",e.emissiveMapUv?"#define EMISSIVEMAP_UV "+e.emissiveMapUv:"",e.bumpMapUv?"#define BUMPMAP_UV "+e.bumpMapUv:"",e.normalMapUv?"#define NORMALMAP_UV "+e.normalMapUv:"",e.displacementMapUv?"#define DISPLACEMENTMAP_UV "+e.displacementMapUv:"",e.metalnessMapUv?"#define METALNESSMAP_UV "+e.metalnessMapUv:"",e.roughnessMapUv?"#define ROUGHNESSMAP_UV "+e.roughnessMapUv:"",e.anisotropyMapUv?"#define ANISOTROPYMAP_UV "+e.anisotropyMapUv:"",e.clearcoatMapUv?"#define CLEARCOATMAP_UV "+e.clearcoatMapUv:"",e.clearcoatNormalMapUv?"#define CLEARCOAT_NORMALMAP_UV "+e.clearcoatNormalMapUv:"",e.clearcoatRoughnessMapUv?"#define CLEARCOAT_ROUGHNESSMAP_UV "+e.clearcoatRoughnessMapUv:"",e.iridescenceMapUv?"#define IRIDESCENCEMAP_UV "+e.iridescenceMapUv:"",e.iridescenceThicknessMapUv?"#define IRIDESCENCE_THICKNESSMAP_UV "+e.iridescenceThicknessMapUv:"",e.sheenColorMapUv?"#define SHEEN_COLORMAP_UV "+e.sheenColorMapUv:"",e.sheenRoughnessMapUv?"#define SHEEN_ROUGHNESSMAP_UV "+e.sheenRoughnessMapUv:"",e.specularMapUv?"#define SPECULARMAP_UV "+e.specularMapUv:"",e.specularColorMapUv?"#define SPECULAR_COLORMAP_UV "+e.specularColorMapUv:"",e.specularIntensityMapUv?"#define SPECULAR_INTENSITYMAP_UV "+e.specularIntensityMapUv:"",e.transmissionMapUv?"#define TRANSMISSIONMAP_UV "+e.transmissionMapUv:"",e.thicknessMapUv?"#define THICKNESSMAP_UV "+e.thicknessMapUv:"",e.vertexTangents&&e.flatShading===!1?"#define USE_TANGENT":"",e.vertexColors?"#define USE_COLOR":"",e.vertexAlphas?"#define USE_COLOR_ALPHA":"",e.vertexUv1s?"#define USE_UV1":"",e.vertexUv2s?"#define USE_UV2":"",e.vertexUv3s?"#define USE_UV3":"",e.pointsUvs?"#define USE_POINTS_UV":"",e.flatShading?"#define FLAT_SHADED":"",e.skinning?"#define USE_SKINNING":"",e.morphTargets?"#define USE_MORPHTARGETS":"",e.morphNormals&&e.flatShading===!1?"#define USE_MORPHNORMALS":"",e.morphColors?"#define USE_MORPHCOLORS":"",e.morphTargetsCount>0?"#define MORPHTARGETS_TEXTURE_STRIDE "+e.morphTextureStride:"",e.morphTargetsCount>0?"#define MORPHTARGETS_COUNT "+e.morphTargetsCount:"",e.doubleSided?"#define DOUBLE_SIDED":"",e.flipSided?"#define FLIP_SIDED":"",e.shadowMapEnabled?"#define USE_SHADOWMAP":"",e.shadowMapEnabled?"#define "+l:"",e.sizeAttenuation?"#define USE_SIZEATTENUATION":"",e.numLightProbes>0?"#define USE_LIGHT_PROBES":"",e.logarithmicDepthBuffer?"#define USE_LOGARITHMIC_DEPTH_BUFFER":"",e.reversedDepthBuffer?"#define USE_REVERSED_DEPTH_BUFFER":"","uniform mat4 modelMatrix;","uniform mat4 modelViewMatrix;","uniform mat4 projectionMatrix;","uniform mat4 viewMatrix;","uniform mat3 normalMatrix;","uniform vec3 cameraPosition;","uniform bool isOrthographic;","#ifdef USE_INSTANCING","	attribute mat4 instanceMatrix;","#endif","#ifdef USE_INSTANCING_COLOR","	attribute vec3 instanceColor;","#endif","#ifdef USE_INSTANCING_MORPH","	uniform sampler2D morphTexture;","#endif","attribute vec3 position;","attribute vec3 normal;","attribute vec2 uv;","#ifdef USE_UV1","	attribute vec2 uv1;","#endif","#ifdef USE_UV2","	attribute vec2 uv2;","#endif","#ifdef USE_UV3","	attribute vec2 uv3;","#endif","#ifdef USE_TANGENT","	attribute vec4 tangent;","#endif","#if defined( USE_COLOR_ALPHA )","	attribute vec4 color;","#elif defined( USE_COLOR )","	attribute vec3 color;","#endif","#ifdef USE_SKINNING","	attribute vec4 skinIndex;","	attribute vec4 skinWeight;","#endif",`
`].filter(ir).join(`
`),d=[zh(e),"#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,g,e.useFog&&e.fog?"#define USE_FOG":"",e.useFog&&e.fogExp2?"#define FOG_EXP2":"",e.alphaToCoverage?"#define ALPHA_TO_COVERAGE":"",e.map?"#define USE_MAP":"",e.matcap?"#define USE_MATCAP":"",e.envMap?"#define USE_ENVMAP":"",e.envMap?"#define "+c:"",e.envMap?"#define "+h:"",e.envMap?"#define "+u:"",f?"#define CUBEUV_TEXEL_WIDTH "+f.texelWidth:"",f?"#define CUBEUV_TEXEL_HEIGHT "+f.texelHeight:"",f?"#define CUBEUV_MAX_MIP "+f.maxMip+".0":"",e.lightMap?"#define USE_LIGHTMAP":"",e.aoMap?"#define USE_AOMAP":"",e.bumpMap?"#define USE_BUMPMAP":"",e.normalMap?"#define USE_NORMALMAP":"",e.normalMapObjectSpace?"#define USE_NORMALMAP_OBJECTSPACE":"",e.normalMapTangentSpace?"#define USE_NORMALMAP_TANGENTSPACE":"",e.emissiveMap?"#define USE_EMISSIVEMAP":"",e.anisotropy?"#define USE_ANISOTROPY":"",e.anisotropyMap?"#define USE_ANISOTROPYMAP":"",e.clearcoat?"#define USE_CLEARCOAT":"",e.clearcoatMap?"#define USE_CLEARCOATMAP":"",e.clearcoatRoughnessMap?"#define USE_CLEARCOAT_ROUGHNESSMAP":"",e.clearcoatNormalMap?"#define USE_CLEARCOAT_NORMALMAP":"",e.dispersion?"#define USE_DISPERSION":"",e.iridescence?"#define USE_IRIDESCENCE":"",e.iridescenceMap?"#define USE_IRIDESCENCEMAP":"",e.iridescenceThicknessMap?"#define USE_IRIDESCENCE_THICKNESSMAP":"",e.specularMap?"#define USE_SPECULARMAP":"",e.specularColorMap?"#define USE_SPECULAR_COLORMAP":"",e.specularIntensityMap?"#define USE_SPECULAR_INTENSITYMAP":"",e.roughnessMap?"#define USE_ROUGHNESSMAP":"",e.metalnessMap?"#define USE_METALNESSMAP":"",e.alphaMap?"#define USE_ALPHAMAP":"",e.alphaTest?"#define USE_ALPHATEST":"",e.alphaHash?"#define USE_ALPHAHASH":"",e.sheen?"#define USE_SHEEN":"",e.sheenColorMap?"#define USE_SHEEN_COLORMAP":"",e.sheenRoughnessMap?"#define USE_SHEEN_ROUGHNESSMAP":"",e.transmission?"#define USE_TRANSMISSION":"",e.transmissionMap?"#define USE_TRANSMISSIONMAP":"",e.thicknessMap?"#define USE_THICKNESSMAP":"",e.vertexTangents&&e.flatShading===!1?"#define USE_TANGENT":"",e.vertexColors||e.instancingColor||e.batchingColor?"#define USE_COLOR":"",e.vertexAlphas?"#define USE_COLOR_ALPHA":"",e.vertexUv1s?"#define USE_UV1":"",e.vertexUv2s?"#define USE_UV2":"",e.vertexUv3s?"#define USE_UV3":"",e.pointsUvs?"#define USE_POINTS_UV":"",e.gradientMap?"#define USE_GRADIENTMAP":"",e.flatShading?"#define FLAT_SHADED":"",e.doubleSided?"#define DOUBLE_SIDED":"",e.flipSided?"#define FLIP_SIDED":"",e.shadowMapEnabled?"#define USE_SHADOWMAP":"",e.shadowMapEnabled?"#define "+l:"",e.premultipliedAlpha?"#define PREMULTIPLIED_ALPHA":"",e.numLightProbes>0?"#define USE_LIGHT_PROBES":"",e.decodeVideoTexture?"#define DECODE_VIDEO_TEXTURE":"",e.decodeVideoTextureEmissive?"#define DECODE_VIDEO_TEXTURE_EMISSIVE":"",e.logarithmicDepthBuffer?"#define USE_LOGARITHMIC_DEPTH_BUFFER":"",e.reversedDepthBuffer?"#define USE_REVERSED_DEPTH_BUFFER":"","uniform mat4 viewMatrix;","uniform vec3 cameraPosition;","uniform bool isOrthographic;",e.toneMapping!==Rn?"#define TONE_MAPPING":"",e.toneMapping!==Rn?Wt.tonemapping_pars_fragment:"",e.toneMapping!==Rn?Ig("toneMapping",e.toneMapping):"",e.dithering?"#define DITHERING":"",e.opaque?"#define OPAQUE":"",Wt.colorspace_pars_fragment,Rg("linearToOutputTexel",e.outputColorSpace),Pg(),e.useDepthPacking?"#define DEPTH_PACKING "+e.depthPacking:"",`
`].filter(ir).join(`
`)),o=Ll(o),o=Fh(o,e),o=Oh(o,e),a=Ll(a),a=Fh(a,e),a=Oh(a,e),o=Bh(o),a=Bh(a),e.isRawShaderMaterial!==!0&&(w=`#version 300 es
`,m=[p,"#define attribute in","#define varying out","#define texture2D texture"].join(`
`)+`
`+m,d=["#define varying in",e.glslVersion===ml?"":"layout(location = 0) out highp vec4 pc_fragColor;",e.glslVersion===ml?"":"#define gl_FragColor pc_fragColor","#define gl_FragDepthEXT gl_FragDepth","#define texture2D texture","#define textureCube texture","#define texture2DProj textureProj","#define texture2DLodEXT textureLod","#define texture2DProjLodEXT textureProjLod","#define textureCubeLodEXT textureLod","#define texture2DGradEXT textureGrad","#define texture2DProjGradEXT textureProjGrad","#define textureCubeGradEXT textureGrad"].join(`
`)+`
`+d);let E=w+m+o,v=w+d+a,C=Lh(s,s.VERTEX_SHADER,E),A=Lh(s,s.FRAGMENT_SHADER,v);s.attachShader(y,C),s.attachShader(y,A),e.index0AttributeName!==void 0?s.bindAttribLocation(y,0,e.index0AttributeName):e.morphTargets===!0&&s.bindAttribLocation(y,0,"position"),s.linkProgram(y);function I(R){if(i.debug.checkShaderErrors){let O=s.getProgramInfoLog(y)||"",k=s.getShaderInfoLog(C)||"",W=s.getShaderInfoLog(A)||"",q=O.trim(),G=k.trim(),et=W.trim(),H=!0,ut=!0;if(s.getProgramParameter(y,s.LINK_STATUS)===!1)if(H=!1,typeof i.debug.onShaderError=="function")i.debug.onShaderError(s,y,C,A);else{let xt=Nh(s,C,"vertex"),Mt=Nh(s,A,"fragment");console.error("THREE.WebGLProgram: Shader Error "+s.getError()+" - VALIDATE_STATUS "+s.getProgramParameter(y,s.VALIDATE_STATUS)+`

Material Name: `+R.name+`
Material Type: `+R.type+`

Program Info Log: `+q+`
`+xt+`
`+Mt)}else q!==""?console.warn("THREE.WebGLProgram: Program Info Log:",q):(G===""||et==="")&&(ut=!1);ut&&(R.diagnostics={runnable:H,programLog:q,vertexShader:{log:G,prefix:m},fragmentShader:{log:et,prefix:d}})}s.deleteShader(C),s.deleteShader(A),U=new os(s,y),S=Ug(s,y)}let U;this.getUniforms=function(){return U===void 0&&I(this),U};let S;this.getAttributes=function(){return S===void 0&&I(this),S};let M=e.rendererExtensionParallelShaderCompile===!1;return this.isReady=function(){return M===!1&&(M=s.getProgramParameter(y,Tg)),M},this.destroy=function(){n.releaseStatesOfProgram(this),s.deleteProgram(y),this.program=void 0},this.type=e.shaderType,this.name=e.shaderName,this.id=wg++,this.cacheKey=t,this.usedTimes=1,this.program=y,this.vertexShader=C,this.fragmentShader=A,this}var qg=0,Ul=class{constructor(){this.shaderCache=new Map,this.materialCache=new Map}update(t){let e=t.vertexShader,n=t.fragmentShader,s=this._getShaderStage(e),r=this._getShaderStage(n),o=this._getShaderCacheForMaterial(t);return o.has(s)===!1&&(o.add(s),s.usedTimes++),o.has(r)===!1&&(o.add(r),r.usedTimes++),this}remove(t){let e=this.materialCache.get(t);for(let n of e)n.usedTimes--,n.usedTimes===0&&this.shaderCache.delete(n.code);return this.materialCache.delete(t),this}getVertexShaderID(t){return this._getShaderStage(t.vertexShader).id}getFragmentShaderID(t){return this._getShaderStage(t.fragmentShader).id}dispose(){this.shaderCache.clear(),this.materialCache.clear()}_getShaderCacheForMaterial(t){let e=this.materialCache,n=e.get(t);return n===void 0&&(n=new Set,e.set(t,n)),n}_getShaderStage(t){let e=this.shaderCache,n=e.get(t);return n===void 0&&(n=new Nl(t),e.set(t,n)),n}},Nl=class{constructor(t){this.id=qg++,this.code=t,this.usedTimes=0}};function Yg(i,t,e,n,s,r,o){let a=new Xi,l=new Ul,c=new Set,h=[],u=s.logarithmicDepthBuffer,f=s.vertexTextures,p=s.precision,g={MeshDepthMaterial:"depth",MeshDistanceMaterial:"distanceRGBA",MeshNormalMaterial:"normal",MeshBasicMaterial:"basic",MeshLambertMaterial:"lambert",MeshPhongMaterial:"phong",MeshToonMaterial:"toon",MeshStandardMaterial:"physical",MeshPhysicalMaterial:"physical",MeshMatcapMaterial:"matcap",LineBasicMaterial:"basic",LineDashedMaterial:"dashed",PointsMaterial:"points",ShadowMaterial:"shadow",SpriteMaterial:"sprite"};function y(S){return c.add(S),S===0?"uv":`uv${S}`}function m(S,M,R,O,k){let W=O.fog,q=k.geometry,G=S.isMeshStandardMaterial?O.environment:null,et=(S.isMeshStandardMaterial?e:t).get(S.envMap||G),H=et&&et.mapping===Ks?et.image.height:null,ut=g[S.type];S.precision!==null&&(p=s.getMaxPrecision(S.precision),p!==S.precision&&console.warn("THREE.WebGLProgram.getParameters:",S.precision,"not supported, using",p,"instead."));let xt=q.morphAttributes.position||q.morphAttributes.normal||q.morphAttributes.color,Mt=xt!==void 0?xt.length:0,kt=0;q.morphAttributes.position!==void 0&&(kt=1),q.morphAttributes.normal!==void 0&&(kt=2),q.morphAttributes.color!==void 0&&(kt=3);let Zt,Qt,Jt,Y;if(ut){let jt=xn[ut];Zt=jt.vertexShader,Qt=jt.fragmentShader}else Zt=S.vertexShader,Qt=S.fragmentShader,l.update(S),Jt=l.getVertexShaderID(S),Y=l.getFragmentShaderID(S);let tt=i.getRenderTarget(),vt=i.state.buffers.depth.getReversed(),Pt=k.isInstancedMesh===!0,Tt=k.isBatchedMesh===!0,Xt=!!S.map,se=!!S.matcap,T=!!et,Q=!!S.aoMap,$=!!S.lightMap,J=!!S.bumpMap,Z=!!S.normalMap,ct=!!S.displacementMap,nt=!!S.emissiveMap,ht=!!S.metalnessMap,Bt=!!S.roughnessMap,Ot=S.anisotropy>0,b=S.clearcoat>0,_=S.dispersion>0,F=S.iridescence>0,V=S.sheen>0,j=S.transmission>0,X=Ot&&!!S.anisotropyMap,Rt=b&&!!S.clearcoatMap,lt=b&&!!S.clearcoatNormalMap,wt=b&&!!S.clearcoatRoughnessMap,At=F&&!!S.iridescenceMap,it=F&&!!S.iridescenceThicknessMap,_t=V&&!!S.sheenColorMap,Nt=V&&!!S.sheenRoughnessMap,It=!!S.specularMap,mt=!!S.specularColorMap,Ht=!!S.specularIntensityMap,P=j&&!!S.transmissionMap,ot=j&&!!S.thicknessMap,dt=!!S.gradientMap,St=!!S.alphaMap,st=S.alphaTest>0,K=!!S.alphaHash,Ct=!!S.extensions,zt=Rn;S.toneMapped&&(tt===null||tt.isXRRenderTarget===!0)&&(zt=i.toneMapping);let re={shaderID:ut,shaderType:S.type,shaderName:S.name,vertexShader:Zt,fragmentShader:Qt,defines:S.defines,customVertexShaderID:Jt,customFragmentShaderID:Y,isRawShaderMaterial:S.isRawShaderMaterial===!0,glslVersion:S.glslVersion,precision:p,batching:Tt,batchingColor:Tt&&k._colorsTexture!==null,instancing:Pt,instancingColor:Pt&&k.instanceColor!==null,instancingMorph:Pt&&k.morphTexture!==null,supportsVertexTextures:f,outputColorSpace:tt===null?i.outputColorSpace:tt.isXRRenderTarget===!0?tt.texture.colorSpace:li,alphaToCoverage:!!S.alphaToCoverage,map:Xt,matcap:se,envMap:T,envMapMode:T&&et.mapping,envMapCubeUVHeight:H,aoMap:Q,lightMap:$,bumpMap:J,normalMap:Z,displacementMap:f&&ct,emissiveMap:nt,normalMapObjectSpace:Z&&S.normalMapType===ih,normalMapTangentSpace:Z&&S.normalMapType===fl,metalnessMap:ht,roughnessMap:Bt,anisotropy:Ot,anisotropyMap:X,clearcoat:b,clearcoatMap:Rt,clearcoatNormalMap:lt,clearcoatRoughnessMap:wt,dispersion:_,iridescence:F,iridescenceMap:At,iridescenceThicknessMap:it,sheen:V,sheenColorMap:_t,sheenRoughnessMap:Nt,specularMap:It,specularColorMap:mt,specularIntensityMap:Ht,transmission:j,transmissionMap:P,thicknessMap:ot,gradientMap:dt,opaque:S.transparent===!1&&S.blending===oi&&S.alphaToCoverage===!1,alphaMap:St,alphaTest:st,alphaHash:K,combine:S.combine,mapUv:Xt&&y(S.map.channel),aoMapUv:Q&&y(S.aoMap.channel),lightMapUv:$&&y(S.lightMap.channel),bumpMapUv:J&&y(S.bumpMap.channel),normalMapUv:Z&&y(S.normalMap.channel),displacementMapUv:ct&&y(S.displacementMap.channel),emissiveMapUv:nt&&y(S.emissiveMap.channel),metalnessMapUv:ht&&y(S.metalnessMap.channel),roughnessMapUv:Bt&&y(S.roughnessMap.channel),anisotropyMapUv:X&&y(S.anisotropyMap.channel),clearcoatMapUv:Rt&&y(S.clearcoatMap.channel),clearcoatNormalMapUv:lt&&y(S.clearcoatNormalMap.channel),clearcoatRoughnessMapUv:wt&&y(S.clearcoatRoughnessMap.channel),iridescenceMapUv:At&&y(S.iridescenceMap.channel),iridescenceThicknessMapUv:it&&y(S.iridescenceThicknessMap.channel),sheenColorMapUv:_t&&y(S.sheenColorMap.channel),sheenRoughnessMapUv:Nt&&y(S.sheenRoughnessMap.channel),specularMapUv:It&&y(S.specularMap.channel),specularColorMapUv:mt&&y(S.specularColorMap.channel),specularIntensityMapUv:Ht&&y(S.specularIntensityMap.channel),transmissionMapUv:P&&y(S.transmissionMap.channel),thicknessMapUv:ot&&y(S.thicknessMap.channel),alphaMapUv:St&&y(S.alphaMap.channel),vertexTangents:!!q.attributes.tangent&&(Z||Ot),vertexColors:S.vertexColors,vertexAlphas:S.vertexColors===!0&&!!q.attributes.color&&q.attributes.color.itemSize===4,pointsUvs:k.isPoints===!0&&!!q.attributes.uv&&(Xt||St),fog:!!W,useFog:S.fog===!0,fogExp2:!!W&&W.isFogExp2,flatShading:S.flatShading===!0&&S.wireframe===!1,sizeAttenuation:S.sizeAttenuation===!0,logarithmicDepthBuffer:u,reversedDepthBuffer:vt,skinning:k.isSkinnedMesh===!0,morphTargets:q.morphAttributes.position!==void 0,morphNormals:q.morphAttributes.normal!==void 0,morphColors:q.morphAttributes.color!==void 0,morphTargetsCount:Mt,morphTextureStride:kt,numDirLights:M.directional.length,numPointLights:M.point.length,numSpotLights:M.spot.length,numSpotLightMaps:M.spotLightMap.length,numRectAreaLights:M.rectArea.length,numHemiLights:M.hemi.length,numDirLightShadows:M.directionalShadowMap.length,numPointLightShadows:M.pointShadowMap.length,numSpotLightShadows:M.spotShadowMap.length,numSpotLightShadowsWithMaps:M.numSpotLightShadowsWithMaps,numLightProbes:M.numLightProbes,numClippingPlanes:o.numPlanes,numClipIntersection:o.numIntersection,dithering:S.dithering,shadowMapEnabled:i.shadowMap.enabled&&R.length>0,shadowMapType:i.shadowMap.type,toneMapping:zt,decodeVideoTexture:Xt&&S.map.isVideoTexture===!0&&$t.getTransfer(S.map.colorSpace)===te,decodeVideoTextureEmissive:nt&&S.emissiveMap.isVideoTexture===!0&&$t.getTransfer(S.emissiveMap.colorSpace)===te,premultipliedAlpha:S.premultipliedAlpha,doubleSided:S.side===gn,flipSided:S.side===Ue,useDepthPacking:S.depthPacking>=0,depthPacking:S.depthPacking||0,index0AttributeName:S.index0AttributeName,extensionClipCullDistance:Ct&&S.extensions.clipCullDistance===!0&&n.has("WEBGL_clip_cull_distance"),extensionMultiDraw:(Ct&&S.extensions.multiDraw===!0||Tt)&&n.has("WEBGL_multi_draw"),rendererExtensionParallelShaderCompile:n.has("KHR_parallel_shader_compile"),customProgramCacheKey:S.customProgramCacheKey()};return re.vertexUv1s=c.has(1),re.vertexUv2s=c.has(2),re.vertexUv3s=c.has(3),c.clear(),re}function d(S){let M=[];if(S.shaderID?M.push(S.shaderID):(M.push(S.customVertexShaderID),M.push(S.customFragmentShaderID)),S.defines!==void 0)for(let R in S.defines)M.push(R),M.push(S.defines[R]);return S.isRawShaderMaterial===!1&&(w(M,S),E(M,S),M.push(i.outputColorSpace)),M.push(S.customProgramCacheKey),M.join()}function w(S,M){S.push(M.precision),S.push(M.outputColorSpace),S.push(M.envMapMode),S.push(M.envMapCubeUVHeight),S.push(M.mapUv),S.push(M.alphaMapUv),S.push(M.lightMapUv),S.push(M.aoMapUv),S.push(M.bumpMapUv),S.push(M.normalMapUv),S.push(M.displacementMapUv),S.push(M.emissiveMapUv),S.push(M.metalnessMapUv),S.push(M.roughnessMapUv),S.push(M.anisotropyMapUv),S.push(M.clearcoatMapUv),S.push(M.clearcoatNormalMapUv),S.push(M.clearcoatRoughnessMapUv),S.push(M.iridescenceMapUv),S.push(M.iridescenceThicknessMapUv),S.push(M.sheenColorMapUv),S.push(M.sheenRoughnessMapUv),S.push(M.specularMapUv),S.push(M.specularColorMapUv),S.push(M.specularIntensityMapUv),S.push(M.transmissionMapUv),S.push(M.thicknessMapUv),S.push(M.combine),S.push(M.fogExp2),S.push(M.sizeAttenuation),S.push(M.morphTargetsCount),S.push(M.morphAttributeCount),S.push(M.numDirLights),S.push(M.numPointLights),S.push(M.numSpotLights),S.push(M.numSpotLightMaps),S.push(M.numHemiLights),S.push(M.numRectAreaLights),S.push(M.numDirLightShadows),S.push(M.numPointLightShadows),S.push(M.numSpotLightShadows),S.push(M.numSpotLightShadowsWithMaps),S.push(M.numLightProbes),S.push(M.shadowMapType),S.push(M.toneMapping),S.push(M.numClippingPlanes),S.push(M.numClipIntersection),S.push(M.depthPacking)}function E(S,M){a.disableAll(),M.supportsVertexTextures&&a.enable(0),M.instancing&&a.enable(1),M.instancingColor&&a.enable(2),M.instancingMorph&&a.enable(3),M.matcap&&a.enable(4),M.envMap&&a.enable(5),M.normalMapObjectSpace&&a.enable(6),M.normalMapTangentSpace&&a.enable(7),M.clearcoat&&a.enable(8),M.iridescence&&a.enable(9),M.alphaTest&&a.enable(10),M.vertexColors&&a.enable(11),M.vertexAlphas&&a.enable(12),M.vertexUv1s&&a.enable(13),M.vertexUv2s&&a.enable(14),M.vertexUv3s&&a.enable(15),M.vertexTangents&&a.enable(16),M.anisotropy&&a.enable(17),M.alphaHash&&a.enable(18),M.batching&&a.enable(19),M.dispersion&&a.enable(20),M.batchingColor&&a.enable(21),M.gradientMap&&a.enable(22),S.push(a.mask),a.disableAll(),M.fog&&a.enable(0),M.useFog&&a.enable(1),M.flatShading&&a.enable(2),M.logarithmicDepthBuffer&&a.enable(3),M.reversedDepthBuffer&&a.enable(4),M.skinning&&a.enable(5),M.morphTargets&&a.enable(6),M.morphNormals&&a.enable(7),M.morphColors&&a.enable(8),M.premultipliedAlpha&&a.enable(9),M.shadowMapEnabled&&a.enable(10),M.doubleSided&&a.enable(11),M.flipSided&&a.enable(12),M.useDepthPacking&&a.enable(13),M.dithering&&a.enable(14),M.transmission&&a.enable(15),M.sheen&&a.enable(16),M.opaque&&a.enable(17),M.pointsUvs&&a.enable(18),M.decodeVideoTexture&&a.enable(19),M.decodeVideoTextureEmissive&&a.enable(20),M.alphaToCoverage&&a.enable(21),S.push(a.mask)}function v(S){let M=g[S.type],R;if(M){let O=xn[M];R=ph.clone(O.uniforms)}else R=S.uniforms;return R}function C(S,M){let R;for(let O=0,k=h.length;O<k;O++){let W=h[O];if(W.cacheKey===M){R=W,++R.usedTimes;break}}return R===void 0&&(R=new Xg(i,M,S,r),h.push(R)),R}function A(S){if(--S.usedTimes===0){let M=h.indexOf(S);h[M]=h[h.length-1],h.pop(),S.destroy()}}function I(S){l.remove(S)}function U(){l.dispose()}return{getParameters:m,getProgramCacheKey:d,getUniforms:v,acquireProgram:C,releaseProgram:A,releaseShaderCache:I,programs:h,dispose:U}}function Zg(){let i=new WeakMap;function t(o){return i.has(o)}function e(o){let a=i.get(o);return a===void 0&&(a={},i.set(o,a)),a}function n(o){i.delete(o)}function s(o,a,l){i.get(o)[a]=l}function r(){i=new WeakMap}return{has:t,get:e,remove:n,update:s,dispose:r}}function Jg(i,t){return i.groupOrder!==t.groupOrder?i.groupOrder-t.groupOrder:i.renderOrder!==t.renderOrder?i.renderOrder-t.renderOrder:i.material.id!==t.material.id?i.material.id-t.material.id:i.z!==t.z?i.z-t.z:i.id-t.id}function kh(i,t){return i.groupOrder!==t.groupOrder?i.groupOrder-t.groupOrder:i.renderOrder!==t.renderOrder?i.renderOrder-t.renderOrder:i.z!==t.z?t.z-i.z:i.id-t.id}function Vh(){let i=[],t=0,e=[],n=[],s=[];function r(){t=0,e.length=0,n.length=0,s.length=0}function o(u,f,p,g,y,m){let d=i[t];return d===void 0?(d={id:u.id,object:u,geometry:f,material:p,groupOrder:g,renderOrder:u.renderOrder,z:y,group:m},i[t]=d):(d.id=u.id,d.object=u,d.geometry=f,d.material=p,d.groupOrder=g,d.renderOrder=u.renderOrder,d.z=y,d.group=m),t++,d}function a(u,f,p,g,y,m){let d=o(u,f,p,g,y,m);p.transmission>0?n.push(d):p.transparent===!0?s.push(d):e.push(d)}function l(u,f,p,g,y,m){let d=o(u,f,p,g,y,m);p.transmission>0?n.unshift(d):p.transparent===!0?s.unshift(d):e.unshift(d)}function c(u,f){e.length>1&&e.sort(u||Jg),n.length>1&&n.sort(f||kh),s.length>1&&s.sort(f||kh)}function h(){for(let u=t,f=i.length;u<f;u++){let p=i[u];if(p.id===null)break;p.id=null,p.object=null,p.geometry=null,p.material=null,p.group=null}}return{opaque:e,transmissive:n,transparent:s,init:r,push:a,unshift:l,finish:h,sort:c}}function $g(){let i=new WeakMap;function t(n,s){let r=i.get(n),o;return r===void 0?(o=new Vh,i.set(n,[o])):s>=r.length?(o=new Vh,r.push(o)):o=r[s],o}function e(){i=new WeakMap}return{get:t,dispose:e}}function Kg(){let i={};return{get:function(t){if(i[t.id]!==void 0)return i[t.id];let e;switch(t.type){case"DirectionalLight":e={direction:new D,color:new Yt};break;case"SpotLight":e={position:new D,direction:new D,color:new Yt,distance:0,coneCos:0,penumbraCos:0,decay:0};break;case"PointLight":e={position:new D,color:new Yt,distance:0,decay:0};break;case"HemisphereLight":e={direction:new D,skyColor:new Yt,groundColor:new Yt};break;case"RectAreaLight":e={color:new Yt,position:new D,halfWidth:new D,halfHeight:new D};break}return i[t.id]=e,e}}}function jg(){let i={};return{get:function(t){if(i[t.id]!==void 0)return i[t.id];let e;switch(t.type){case"DirectionalLight":e={shadowIntensity:1,shadowBias:0,shadowNormalBias:0,shadowRadius:1,shadowMapSize:new at};break;case"SpotLight":e={shadowIntensity:1,shadowBias:0,shadowNormalBias:0,shadowRadius:1,shadowMapSize:new at};break;case"PointLight":e={shadowIntensity:1,shadowBias:0,shadowNormalBias:0,shadowRadius:1,shadowMapSize:new at,shadowCameraNear:1,shadowCameraFar:1e3};break}return i[t.id]=e,e}}}var Qg=0;function t_(i,t){return(t.castShadow?2:0)-(i.castShadow?2:0)+(t.map?1:0)-(i.map?1:0)}function e_(i){let t=new Kg,e=jg(),n={version:0,hash:{directionalLength:-1,pointLength:-1,spotLength:-1,rectAreaLength:-1,hemiLength:-1,numDirectionalShadows:-1,numPointShadows:-1,numSpotShadows:-1,numSpotMaps:-1,numLightProbes:-1},ambient:[0,0,0],probe:[],directional:[],directionalShadow:[],directionalShadowMap:[],directionalShadowMatrix:[],spot:[],spotLightMap:[],spotShadow:[],spotShadowMap:[],spotLightMatrix:[],rectArea:[],rectAreaLTC1:null,rectAreaLTC2:null,point:[],pointShadow:[],pointShadowMap:[],pointShadowMatrix:[],hemi:[],numSpotLightShadowsWithMaps:0,numLightProbes:0};for(let c=0;c<9;c++)n.probe.push(new D);let s=new D,r=new fe,o=new fe;function a(c){let h=0,u=0,f=0;for(let S=0;S<9;S++)n.probe[S].set(0,0,0);let p=0,g=0,y=0,m=0,d=0,w=0,E=0,v=0,C=0,A=0,I=0;c.sort(t_);for(let S=0,M=c.length;S<M;S++){let R=c[S],O=R.color,k=R.intensity,W=R.distance,q=R.shadow&&R.shadow.map?R.shadow.map.texture:null;if(R.isAmbientLight)h+=O.r*k,u+=O.g*k,f+=O.b*k;else if(R.isLightProbe){for(let G=0;G<9;G++)n.probe[G].addScaledVector(R.sh.coefficients[G],k);I++}else if(R.isDirectionalLight){let G=t.get(R);if(G.color.copy(R.color).multiplyScalar(R.intensity),R.castShadow){let et=R.shadow,H=e.get(R);H.shadowIntensity=et.intensity,H.shadowBias=et.bias,H.shadowNormalBias=et.normalBias,H.shadowRadius=et.radius,H.shadowMapSize=et.mapSize,n.directionalShadow[p]=H,n.directionalShadowMap[p]=q,n.directionalShadowMatrix[p]=R.shadow.matrix,w++}n.directional[p]=G,p++}else if(R.isSpotLight){let G=t.get(R);G.position.setFromMatrixPosition(R.matrixWorld),G.color.copy(O).multiplyScalar(k),G.distance=W,G.coneCos=Math.cos(R.angle),G.penumbraCos=Math.cos(R.angle*(1-R.penumbra)),G.decay=R.decay,n.spot[y]=G;let et=R.shadow;if(R.map&&(n.spotLightMap[C]=R.map,C++,et.updateMatrices(R),R.castShadow&&A++),n.spotLightMatrix[y]=et.matrix,R.castShadow){let H=e.get(R);H.shadowIntensity=et.intensity,H.shadowBias=et.bias,H.shadowNormalBias=et.normalBias,H.shadowRadius=et.radius,H.shadowMapSize=et.mapSize,n.spotShadow[y]=H,n.spotShadowMap[y]=q,v++}y++}else if(R.isRectAreaLight){let G=t.get(R);G.color.copy(O).multiplyScalar(k),G.halfWidth.set(R.width*.5,0,0),G.halfHeight.set(0,R.height*.5,0),n.rectArea[m]=G,m++}else if(R.isPointLight){let G=t.get(R);if(G.color.copy(R.color).multiplyScalar(R.intensity),G.distance=R.distance,G.decay=R.decay,R.castShadow){let et=R.shadow,H=e.get(R);H.shadowIntensity=et.intensity,H.shadowBias=et.bias,H.shadowNormalBias=et.normalBias,H.shadowRadius=et.radius,H.shadowMapSize=et.mapSize,H.shadowCameraNear=et.camera.near,H.shadowCameraFar=et.camera.far,n.pointShadow[g]=H,n.pointShadowMap[g]=q,n.pointShadowMatrix[g]=R.shadow.matrix,E++}n.point[g]=G,g++}else if(R.isHemisphereLight){let G=t.get(R);G.skyColor.copy(R.color).multiplyScalar(k),G.groundColor.copy(R.groundColor).multiplyScalar(k),n.hemi[d]=G,d++}}m>0&&(i.has("OES_texture_float_linear")===!0?(n.rectAreaLTC1=ft.LTC_FLOAT_1,n.rectAreaLTC2=ft.LTC_FLOAT_2):(n.rectAreaLTC1=ft.LTC_HALF_1,n.rectAreaLTC2=ft.LTC_HALF_2)),n.ambient[0]=h,n.ambient[1]=u,n.ambient[2]=f;let U=n.hash;(U.directionalLength!==p||U.pointLength!==g||U.spotLength!==y||U.rectAreaLength!==m||U.hemiLength!==d||U.numDirectionalShadows!==w||U.numPointShadows!==E||U.numSpotShadows!==v||U.numSpotMaps!==C||U.numLightProbes!==I)&&(n.directional.length=p,n.spot.length=y,n.rectArea.length=m,n.point.length=g,n.hemi.length=d,n.directionalShadow.length=w,n.directionalShadowMap.length=w,n.pointShadow.length=E,n.pointShadowMap.length=E,n.spotShadow.length=v,n.spotShadowMap.length=v,n.directionalShadowMatrix.length=w,n.pointShadowMatrix.length=E,n.spotLightMatrix.length=v+C-A,n.spotLightMap.length=C,n.numSpotLightShadowsWithMaps=A,n.numLightProbes=I,U.directionalLength=p,U.pointLength=g,U.spotLength=y,U.rectAreaLength=m,U.hemiLength=d,U.numDirectionalShadows=w,U.numPointShadows=E,U.numSpotShadows=v,U.numSpotMaps=C,U.numLightProbes=I,n.version=Qg++)}function l(c,h){let u=0,f=0,p=0,g=0,y=0,m=h.matrixWorldInverse;for(let d=0,w=c.length;d<w;d++){let E=c[d];if(E.isDirectionalLight){let v=n.directional[u];v.direction.setFromMatrixPosition(E.matrixWorld),s.setFromMatrixPosition(E.target.matrixWorld),v.direction.sub(s),v.direction.transformDirection(m),u++}else if(E.isSpotLight){let v=n.spot[p];v.position.setFromMatrixPosition(E.matrixWorld),v.position.applyMatrix4(m),v.direction.setFromMatrixPosition(E.matrixWorld),s.setFromMatrixPosition(E.target.matrixWorld),v.direction.sub(s),v.direction.transformDirection(m),p++}else if(E.isRectAreaLight){let v=n.rectArea[g];v.position.setFromMatrixPosition(E.matrixWorld),v.position.applyMatrix4(m),o.identity(),r.copy(E.matrixWorld),r.premultiply(m),o.extractRotation(r),v.halfWidth.set(E.width*.5,0,0),v.halfHeight.set(0,E.height*.5,0),v.halfWidth.applyMatrix4(o),v.halfHeight.applyMatrix4(o),g++}else if(E.isPointLight){let v=n.point[f];v.position.setFromMatrixPosition(E.matrixWorld),v.position.applyMatrix4(m),f++}else if(E.isHemisphereLight){let v=n.hemi[y];v.direction.setFromMatrixPosition(E.matrixWorld),v.direction.transformDirection(m),y++}}}return{setup:a,setupView:l,state:n}}function Hh(i){let t=new e_(i),e=[],n=[];function s(h){c.camera=h,e.length=0,n.length=0}function r(h){e.push(h)}function o(h){n.push(h)}function a(){t.setup(e)}function l(h){t.setupView(e,h)}let c={lightsArray:e,shadowsArray:n,camera:null,lights:t,transmissionRenderTarget:{}};return{init:s,state:c,setupLights:a,setupLightsView:l,pushLight:r,pushShadow:o}}function n_(i){let t=new WeakMap;function e(s,r=0){let o=t.get(s),a;return o===void 0?(a=new Hh(i),t.set(s,[a])):r>=o.length?(a=new Hh(i),o.push(a)):a=o[r],a}function n(){t=new WeakMap}return{get:e,dispose:n}}var i_=`void main() {
	gl_Position = vec4( position, 1.0 );
}`,s_=`uniform sampler2D shadow_pass;
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
}`;function r_(i,t,e){let n=new Zi,s=new at,r=new at,o=new pe,a=new Jr({depthPacking:nh}),l=new $r,c={},h=e.maxTextureSize,u={[An]:Ue,[Ue]:An,[gn]:gn},f=new ln({defines:{VSM_SAMPLES:8},uniforms:{shadow_pass:{value:null},resolution:{value:new at},radius:{value:4}},vertexShader:i_,fragmentShader:s_}),p=f.clone();p.defines.HORIZONTAL_PASS=1;let g=new an;g.setAttribute("position",new Ge(new Float32Array([-1,-1,.5,3,-1,.5,-1,3,.5]),3));let y=new we(g,f),m=this;this.enabled=!1,this.autoUpdate=!0,this.needsUpdate=!1,this.type=Qa;let d=this.type;this.render=function(A,I,U){if(m.enabled===!1||m.autoUpdate===!1&&m.needsUpdate===!1||A.length===0)return;let S=i.getRenderTarget(),M=i.getActiveCubeFace(),R=i.getActiveMipmapLevel(),O=i.state;O.setBlending(Cn),O.buffers.depth.getReversed()===!0?O.buffers.color.setClear(0,0,0,0):O.buffers.color.setClear(1,1,1,1),O.buffers.depth.setTest(!0),O.setScissorTest(!1);let k=d!==mn&&this.type===mn,W=d===mn&&this.type!==mn;for(let q=0,G=A.length;q<G;q++){let et=A[q],H=et.shadow;if(H===void 0){console.warn("THREE.WebGLShadowMap:",et,"has no shadow.");continue}if(H.autoUpdate===!1&&H.needsUpdate===!1)continue;s.copy(H.mapSize);let ut=H.getFrameExtents();if(s.multiply(ut),r.copy(H.mapSize),(s.x>h||s.y>h)&&(s.x>h&&(r.x=Math.floor(h/ut.x),s.x=r.x*ut.x,H.mapSize.x=r.x),s.y>h&&(r.y=Math.floor(h/ut.y),s.y=r.y*ut.y,H.mapSize.y=r.y)),H.map===null||k===!0||W===!0){let Mt=this.type!==mn?{minFilter:Ke,magFilter:Ke}:{};H.map!==null&&H.map.dispose(),H.map=new pn(s.x,s.y,Mt),H.map.texture.name=et.name+".shadowMap",H.camera.updateProjectionMatrix()}i.setRenderTarget(H.map),i.clear();let xt=H.getViewportCount();for(let Mt=0;Mt<xt;Mt++){let kt=H.getViewport(Mt);o.set(r.x*kt.x,r.y*kt.y,r.x*kt.z,r.y*kt.w),O.viewport(o),H.updateMatrices(et,Mt),n=H.getFrustum(),v(I,U,H.camera,et,this.type)}H.isPointLightShadow!==!0&&this.type===mn&&w(H,U),H.needsUpdate=!1}d=this.type,m.needsUpdate=!1,i.setRenderTarget(S,M,R)};function w(A,I){let U=t.update(y);f.defines.VSM_SAMPLES!==A.blurSamples&&(f.defines.VSM_SAMPLES=A.blurSamples,p.defines.VSM_SAMPLES=A.blurSamples,f.needsUpdate=!0,p.needsUpdate=!0),A.mapPass===null&&(A.mapPass=new pn(s.x,s.y)),f.uniforms.shadow_pass.value=A.map.texture,f.uniforms.resolution.value=A.mapSize,f.uniforms.radius.value=A.radius,i.setRenderTarget(A.mapPass),i.clear(),i.renderBufferDirect(I,null,U,f,y,null),p.uniforms.shadow_pass.value=A.mapPass.texture,p.uniforms.resolution.value=A.mapSize,p.uniforms.radius.value=A.radius,i.setRenderTarget(A.map),i.clear(),i.renderBufferDirect(I,null,U,p,y,null)}function E(A,I,U,S){let M=null,R=U.isPointLight===!0?A.customDistanceMaterial:A.customDepthMaterial;if(R!==void 0)M=R;else if(M=U.isPointLight===!0?l:a,i.localClippingEnabled&&I.clipShadows===!0&&Array.isArray(I.clippingPlanes)&&I.clippingPlanes.length!==0||I.displacementMap&&I.displacementScale!==0||I.alphaMap&&I.alphaTest>0||I.map&&I.alphaTest>0||I.alphaToCoverage===!0){let O=M.uuid,k=I.uuid,W=c[O];W===void 0&&(W={},c[O]=W);let q=W[k];q===void 0&&(q=M.clone(),W[k]=q,I.addEventListener("dispose",C)),M=q}if(M.visible=I.visible,M.wireframe=I.wireframe,S===mn?M.side=I.shadowSide!==null?I.shadowSide:I.side:M.side=I.shadowSide!==null?I.shadowSide:u[I.side],M.alphaMap=I.alphaMap,M.alphaTest=I.alphaToCoverage===!0?.5:I.alphaTest,M.map=I.map,M.clipShadows=I.clipShadows,M.clippingPlanes=I.clippingPlanes,M.clipIntersection=I.clipIntersection,M.displacementMap=I.displacementMap,M.displacementScale=I.displacementScale,M.displacementBias=I.displacementBias,M.wireframeLinewidth=I.wireframeLinewidth,M.linewidth=I.linewidth,U.isPointLight===!0&&M.isMeshDistanceMaterial===!0){let O=i.properties.get(M);O.light=U}return M}function v(A,I,U,S,M){if(A.visible===!1)return;if(A.layers.test(I.layers)&&(A.isMesh||A.isLine||A.isPoints)&&(A.castShadow||A.receiveShadow&&M===mn)&&(!A.frustumCulled||n.intersectsObject(A))){A.modelViewMatrix.multiplyMatrices(U.matrixWorldInverse,A.matrixWorld);let k=t.update(A),W=A.material;if(Array.isArray(W)){let q=k.groups;for(let G=0,et=q.length;G<et;G++){let H=q[G],ut=W[H.materialIndex];if(ut&&ut.visible){let xt=E(A,ut,S,M);A.onBeforeShadow(i,A,I,U,k,xt,H),i.renderBufferDirect(U,null,k,xt,A,H),A.onAfterShadow(i,A,I,U,k,xt,H)}}}else if(W.visible){let q=E(A,W,S,M);A.onBeforeShadow(i,A,I,U,k,q,null),i.renderBufferDirect(U,null,k,q,A,null),A.onAfterShadow(i,A,I,U,k,q,null)}}let O=A.children;for(let k=0,W=O.length;k<W;k++)v(O[k],I,U,S,M)}function C(A){A.target.removeEventListener("dispose",C);for(let U in c){let S=c[U],M=A.target.uuid;M in S&&(S[M].dispose(),delete S[M])}}}var o_={[lo]:co,[ho]:po,[uo]:mo,[ai]:fo,[co]:lo,[po]:ho,[mo]:uo,[fo]:ai};function a_(i,t){function e(){let P=!1,ot=new pe,dt=null,St=new pe(0,0,0,0);return{setMask:function(st){dt!==st&&!P&&(i.colorMask(st,st,st,st),dt=st)},setLocked:function(st){P=st},setClear:function(st,K,Ct,zt,re){re===!0&&(st*=zt,K*=zt,Ct*=zt),ot.set(st,K,Ct,zt),St.equals(ot)===!1&&(i.clearColor(st,K,Ct,zt),St.copy(ot))},reset:function(){P=!1,dt=null,St.set(-1,0,0,0)}}}function n(){let P=!1,ot=!1,dt=null,St=null,st=null;return{setReversed:function(K){if(ot!==K){let Ct=t.get("EXT_clip_control");K?Ct.clipControlEXT(Ct.LOWER_LEFT_EXT,Ct.ZERO_TO_ONE_EXT):Ct.clipControlEXT(Ct.LOWER_LEFT_EXT,Ct.NEGATIVE_ONE_TO_ONE_EXT),ot=K;let zt=st;st=null,this.setClear(zt)}},getReversed:function(){return ot},setTest:function(K){K?tt(i.DEPTH_TEST):vt(i.DEPTH_TEST)},setMask:function(K){dt!==K&&!P&&(i.depthMask(K),dt=K)},setFunc:function(K){if(ot&&(K=o_[K]),St!==K){switch(K){case lo:i.depthFunc(i.NEVER);break;case co:i.depthFunc(i.ALWAYS);break;case ho:i.depthFunc(i.LESS);break;case ai:i.depthFunc(i.LEQUAL);break;case uo:i.depthFunc(i.EQUAL);break;case fo:i.depthFunc(i.GEQUAL);break;case po:i.depthFunc(i.GREATER);break;case mo:i.depthFunc(i.NOTEQUAL);break;default:i.depthFunc(i.LEQUAL)}St=K}},setLocked:function(K){P=K},setClear:function(K){st!==K&&(ot&&(K=1-K),i.clearDepth(K),st=K)},reset:function(){P=!1,dt=null,St=null,st=null,ot=!1}}}function s(){let P=!1,ot=null,dt=null,St=null,st=null,K=null,Ct=null,zt=null,re=null;return{setTest:function(jt){P||(jt?tt(i.STENCIL_TEST):vt(i.STENCIL_TEST))},setMask:function(jt){ot!==jt&&!P&&(i.stencilMask(jt),ot=jt)},setFunc:function(jt,vn,dn){(dt!==jt||St!==vn||st!==dn)&&(i.stencilFunc(jt,vn,dn),dt=jt,St=vn,st=dn)},setOp:function(jt,vn,dn){(K!==jt||Ct!==vn||zt!==dn)&&(i.stencilOp(jt,vn,dn),K=jt,Ct=vn,zt=dn)},setLocked:function(jt){P=jt},setClear:function(jt){re!==jt&&(i.clearStencil(jt),re=jt)},reset:function(){P=!1,ot=null,dt=null,St=null,st=null,K=null,Ct=null,zt=null,re=null}}}let r=new e,o=new n,a=new s,l=new WeakMap,c=new WeakMap,h={},u={},f=new WeakMap,p=[],g=null,y=!1,m=null,d=null,w=null,E=null,v=null,C=null,A=null,I=new Yt(0,0,0),U=0,S=!1,M=null,R=null,O=null,k=null,W=null,q=i.getParameter(i.MAX_COMBINED_TEXTURE_IMAGE_UNITS),G=!1,et=0,H=i.getParameter(i.VERSION);H.indexOf("WebGL")!==-1?(et=parseFloat(/^WebGL (\d)/.exec(H)[1]),G=et>=1):H.indexOf("OpenGL ES")!==-1&&(et=parseFloat(/^OpenGL ES (\d)/.exec(H)[1]),G=et>=2);let ut=null,xt={},Mt=i.getParameter(i.SCISSOR_BOX),kt=i.getParameter(i.VIEWPORT),Zt=new pe().fromArray(Mt),Qt=new pe().fromArray(kt);function Jt(P,ot,dt,St){let st=new Uint8Array(4),K=i.createTexture();i.bindTexture(P,K),i.texParameteri(P,i.TEXTURE_MIN_FILTER,i.NEAREST),i.texParameteri(P,i.TEXTURE_MAG_FILTER,i.NEAREST);for(let Ct=0;Ct<dt;Ct++)P===i.TEXTURE_3D||P===i.TEXTURE_2D_ARRAY?i.texImage3D(ot,0,i.RGBA,1,1,St,0,i.RGBA,i.UNSIGNED_BYTE,st):i.texImage2D(ot+Ct,0,i.RGBA,1,1,0,i.RGBA,i.UNSIGNED_BYTE,st);return K}let Y={};Y[i.TEXTURE_2D]=Jt(i.TEXTURE_2D,i.TEXTURE_2D,1),Y[i.TEXTURE_CUBE_MAP]=Jt(i.TEXTURE_CUBE_MAP,i.TEXTURE_CUBE_MAP_POSITIVE_X,6),Y[i.TEXTURE_2D_ARRAY]=Jt(i.TEXTURE_2D_ARRAY,i.TEXTURE_2D_ARRAY,1,1),Y[i.TEXTURE_3D]=Jt(i.TEXTURE_3D,i.TEXTURE_3D,1,1),r.setClear(0,0,0,1),o.setClear(1),a.setClear(0),tt(i.DEPTH_TEST),o.setFunc(ai),J(!1),Z(ja),tt(i.CULL_FACE),Q(Cn);function tt(P){h[P]!==!0&&(i.enable(P),h[P]=!0)}function vt(P){h[P]!==!1&&(i.disable(P),h[P]=!1)}function Pt(P,ot){return u[P]!==ot?(i.bindFramebuffer(P,ot),u[P]=ot,P===i.DRAW_FRAMEBUFFER&&(u[i.FRAMEBUFFER]=ot),P===i.FRAMEBUFFER&&(u[i.DRAW_FRAMEBUFFER]=ot),!0):!1}function Tt(P,ot){let dt=p,St=!1;if(P){dt=f.get(ot),dt===void 0&&(dt=[],f.set(ot,dt));let st=P.textures;if(dt.length!==st.length||dt[0]!==i.COLOR_ATTACHMENT0){for(let K=0,Ct=st.length;K<Ct;K++)dt[K]=i.COLOR_ATTACHMENT0+K;dt.length=st.length,St=!0}}else dt[0]!==i.BACK&&(dt[0]=i.BACK,St=!0);St&&i.drawBuffers(dt)}function Xt(P){return g!==P?(i.useProgram(P),g=P,!0):!1}let se={[Vn]:i.FUNC_ADD,[Rc]:i.FUNC_SUBTRACT,[Ic]:i.FUNC_REVERSE_SUBTRACT};se[Pc]=i.MIN,se[Dc]=i.MAX;let T={[Lc]:i.ZERO,[Uc]:i.ONE,[Nc]:i.SRC_COLOR,[Lr]:i.SRC_ALPHA,[Vc]:i.SRC_ALPHA_SATURATE,[zc]:i.DST_COLOR,[Oc]:i.DST_ALPHA,[Fc]:i.ONE_MINUS_SRC_COLOR,[Ur]:i.ONE_MINUS_SRC_ALPHA,[kc]:i.ONE_MINUS_DST_COLOR,[Bc]:i.ONE_MINUS_DST_ALPHA,[Hc]:i.CONSTANT_COLOR,[Gc]:i.ONE_MINUS_CONSTANT_COLOR,[Wc]:i.CONSTANT_ALPHA,[Xc]:i.ONE_MINUS_CONSTANT_ALPHA};function Q(P,ot,dt,St,st,K,Ct,zt,re,jt){if(P===Cn){y===!0&&(vt(i.BLEND),y=!1);return}if(y===!1&&(tt(i.BLEND),y=!0),P!==Cc){if(P!==m||jt!==S){if((d!==Vn||v!==Vn)&&(i.blendEquation(i.FUNC_ADD),d=Vn,v=Vn),jt)switch(P){case oi:i.blendFuncSeparate(i.ONE,i.ONE_MINUS_SRC_ALPHA,i.ONE,i.ONE_MINUS_SRC_ALPHA);break;case tl:i.blendFunc(i.ONE,i.ONE);break;case el:i.blendFuncSeparate(i.ZERO,i.ONE_MINUS_SRC_COLOR,i.ZERO,i.ONE);break;case nl:i.blendFuncSeparate(i.DST_COLOR,i.ONE_MINUS_SRC_ALPHA,i.ZERO,i.ONE);break;default:console.error("THREE.WebGLState: Invalid blending: ",P);break}else switch(P){case oi:i.blendFuncSeparate(i.SRC_ALPHA,i.ONE_MINUS_SRC_ALPHA,i.ONE,i.ONE_MINUS_SRC_ALPHA);break;case tl:i.blendFuncSeparate(i.SRC_ALPHA,i.ONE,i.ONE,i.ONE);break;case el:console.error("THREE.WebGLState: SubtractiveBlending requires material.premultipliedAlpha = true");break;case nl:console.error("THREE.WebGLState: MultiplyBlending requires material.premultipliedAlpha = true");break;default:console.error("THREE.WebGLState: Invalid blending: ",P);break}w=null,E=null,C=null,A=null,I.set(0,0,0),U=0,m=P,S=jt}return}st=st||ot,K=K||dt,Ct=Ct||St,(ot!==d||st!==v)&&(i.blendEquationSeparate(se[ot],se[st]),d=ot,v=st),(dt!==w||St!==E||K!==C||Ct!==A)&&(i.blendFuncSeparate(T[dt],T[St],T[K],T[Ct]),w=dt,E=St,C=K,A=Ct),(zt.equals(I)===!1||re!==U)&&(i.blendColor(zt.r,zt.g,zt.b,re),I.copy(zt),U=re),m=P,S=!1}function $(P,ot){P.side===gn?vt(i.CULL_FACE):tt(i.CULL_FACE);let dt=P.side===Ue;ot&&(dt=!dt),J(dt),P.blending===oi&&P.transparent===!1?Q(Cn):Q(P.blending,P.blendEquation,P.blendSrc,P.blendDst,P.blendEquationAlpha,P.blendSrcAlpha,P.blendDstAlpha,P.blendColor,P.blendAlpha,P.premultipliedAlpha),o.setFunc(P.depthFunc),o.setTest(P.depthTest),o.setMask(P.depthWrite),r.setMask(P.colorWrite);let St=P.stencilWrite;a.setTest(St),St&&(a.setMask(P.stencilWriteMask),a.setFunc(P.stencilFunc,P.stencilRef,P.stencilFuncMask),a.setOp(P.stencilFail,P.stencilZFail,P.stencilZPass)),nt(P.polygonOffset,P.polygonOffsetFactor,P.polygonOffsetUnits),P.alphaToCoverage===!0?tt(i.SAMPLE_ALPHA_TO_COVERAGE):vt(i.SAMPLE_ALPHA_TO_COVERAGE)}function J(P){M!==P&&(P?i.frontFace(i.CW):i.frontFace(i.CCW),M=P)}function Z(P){P!==wc?(tt(i.CULL_FACE),P!==R&&(P===ja?i.cullFace(i.BACK):P===Ac?i.cullFace(i.FRONT):i.cullFace(i.FRONT_AND_BACK))):vt(i.CULL_FACE),R=P}function ct(P){P!==O&&(G&&i.lineWidth(P),O=P)}function nt(P,ot,dt){P?(tt(i.POLYGON_OFFSET_FILL),(k!==ot||W!==dt)&&(i.polygonOffset(ot,dt),k=ot,W=dt)):vt(i.POLYGON_OFFSET_FILL)}function ht(P){P?tt(i.SCISSOR_TEST):vt(i.SCISSOR_TEST)}function Bt(P){P===void 0&&(P=i.TEXTURE0+q-1),ut!==P&&(i.activeTexture(P),ut=P)}function Ot(P,ot,dt){dt===void 0&&(ut===null?dt=i.TEXTURE0+q-1:dt=ut);let St=xt[dt];St===void 0&&(St={type:void 0,texture:void 0},xt[dt]=St),(St.type!==P||St.texture!==ot)&&(ut!==dt&&(i.activeTexture(dt),ut=dt),i.bindTexture(P,ot||Y[P]),St.type=P,St.texture=ot)}function b(){let P=xt[ut];P!==void 0&&P.type!==void 0&&(i.bindTexture(P.type,null),P.type=void 0,P.texture=void 0)}function _(){try{i.compressedTexImage2D(...arguments)}catch(P){console.error("THREE.WebGLState:",P)}}function F(){try{i.compressedTexImage3D(...arguments)}catch(P){console.error("THREE.WebGLState:",P)}}function V(){try{i.texSubImage2D(...arguments)}catch(P){console.error("THREE.WebGLState:",P)}}function j(){try{i.texSubImage3D(...arguments)}catch(P){console.error("THREE.WebGLState:",P)}}function X(){try{i.compressedTexSubImage2D(...arguments)}catch(P){console.error("THREE.WebGLState:",P)}}function Rt(){try{i.compressedTexSubImage3D(...arguments)}catch(P){console.error("THREE.WebGLState:",P)}}function lt(){try{i.texStorage2D(...arguments)}catch(P){console.error("THREE.WebGLState:",P)}}function wt(){try{i.texStorage3D(...arguments)}catch(P){console.error("THREE.WebGLState:",P)}}function At(){try{i.texImage2D(...arguments)}catch(P){console.error("THREE.WebGLState:",P)}}function it(){try{i.texImage3D(...arguments)}catch(P){console.error("THREE.WebGLState:",P)}}function _t(P){Zt.equals(P)===!1&&(i.scissor(P.x,P.y,P.z,P.w),Zt.copy(P))}function Nt(P){Qt.equals(P)===!1&&(i.viewport(P.x,P.y,P.z,P.w),Qt.copy(P))}function It(P,ot){let dt=c.get(ot);dt===void 0&&(dt=new WeakMap,c.set(ot,dt));let St=dt.get(P);St===void 0&&(St=i.getUniformBlockIndex(ot,P.name),dt.set(P,St))}function mt(P,ot){let St=c.get(ot).get(P);l.get(ot)!==St&&(i.uniformBlockBinding(ot,St,P.__bindingPointIndex),l.set(ot,St))}function Ht(){i.disable(i.BLEND),i.disable(i.CULL_FACE),i.disable(i.DEPTH_TEST),i.disable(i.POLYGON_OFFSET_FILL),i.disable(i.SCISSOR_TEST),i.disable(i.STENCIL_TEST),i.disable(i.SAMPLE_ALPHA_TO_COVERAGE),i.blendEquation(i.FUNC_ADD),i.blendFunc(i.ONE,i.ZERO),i.blendFuncSeparate(i.ONE,i.ZERO,i.ONE,i.ZERO),i.blendColor(0,0,0,0),i.colorMask(!0,!0,!0,!0),i.clearColor(0,0,0,0),i.depthMask(!0),i.depthFunc(i.LESS),o.setReversed(!1),i.clearDepth(1),i.stencilMask(4294967295),i.stencilFunc(i.ALWAYS,0,4294967295),i.stencilOp(i.KEEP,i.KEEP,i.KEEP),i.clearStencil(0),i.cullFace(i.BACK),i.frontFace(i.CCW),i.polygonOffset(0,0),i.activeTexture(i.TEXTURE0),i.bindFramebuffer(i.FRAMEBUFFER,null),i.bindFramebuffer(i.DRAW_FRAMEBUFFER,null),i.bindFramebuffer(i.READ_FRAMEBUFFER,null),i.useProgram(null),i.lineWidth(1),i.scissor(0,0,i.canvas.width,i.canvas.height),i.viewport(0,0,i.canvas.width,i.canvas.height),h={},ut=null,xt={},u={},f=new WeakMap,p=[],g=null,y=!1,m=null,d=null,w=null,E=null,v=null,C=null,A=null,I=new Yt(0,0,0),U=0,S=!1,M=null,R=null,O=null,k=null,W=null,Zt.set(0,0,i.canvas.width,i.canvas.height),Qt.set(0,0,i.canvas.width,i.canvas.height),r.reset(),o.reset(),a.reset()}return{buffers:{color:r,depth:o,stencil:a},enable:tt,disable:vt,bindFramebuffer:Pt,drawBuffers:Tt,useProgram:Xt,setBlending:Q,setMaterial:$,setFlipSided:J,setCullFace:Z,setLineWidth:ct,setPolygonOffset:nt,setScissorTest:ht,activeTexture:Bt,bindTexture:Ot,unbindTexture:b,compressedTexImage2D:_,compressedTexImage3D:F,texImage2D:At,texImage3D:it,updateUBOMapping:It,uniformBlockBinding:mt,texStorage2D:lt,texStorage3D:wt,texSubImage2D:V,texSubImage3D:j,compressedTexSubImage2D:X,compressedTexSubImage3D:Rt,scissor:_t,viewport:Nt,reset:Ht}}function l_(i,t,e,n,s,r,o){let a=t.has("WEBGL_multisampled_render_to_texture")?t.get("WEBGL_multisampled_render_to_texture"):null,l=typeof navigator>"u"?!1:/OculusBrowser/g.test(navigator.userAgent),c=new at,h=new WeakMap,u,f=new WeakMap,p=!1;try{p=typeof OffscreenCanvas<"u"&&new OffscreenCanvas(1,1).getContext("2d")!==null}catch{}function g(b,_){return p?new OffscreenCanvas(b,_):Es("canvas")}function y(b,_,F){let V=1,j=Ot(b);if((j.width>F||j.height>F)&&(V=F/Math.max(j.width,j.height)),V<1)if(typeof HTMLImageElement<"u"&&b instanceof HTMLImageElement||typeof HTMLCanvasElement<"u"&&b instanceof HTMLCanvasElement||typeof ImageBitmap<"u"&&b instanceof ImageBitmap||typeof VideoFrame<"u"&&b instanceof VideoFrame){let X=Math.floor(V*j.width),Rt=Math.floor(V*j.height);u===void 0&&(u=g(X,Rt));let lt=_?g(X,Rt):u;return lt.width=X,lt.height=Rt,lt.getContext("2d").drawImage(b,0,0,X,Rt),console.warn("THREE.WebGLRenderer: Texture has been resized from ("+j.width+"x"+j.height+") to ("+X+"x"+Rt+")."),lt}else return"data"in b&&console.warn("THREE.WebGLRenderer: Image in DataTexture is too big ("+j.width+"x"+j.height+")."),b;return b}function m(b){return b.generateMipmaps}function d(b){i.generateMipmap(b)}function w(b){return b.isWebGLCubeRenderTarget?i.TEXTURE_CUBE_MAP:b.isWebGL3DRenderTarget?i.TEXTURE_3D:b.isWebGLArrayRenderTarget||b.isCompressedArrayTexture?i.TEXTURE_2D_ARRAY:i.TEXTURE_2D}function E(b,_,F,V,j=!1){if(b!==null){if(i[b]!==void 0)return i[b];console.warn("THREE.WebGLRenderer: Attempt to use non-existing WebGL internal format '"+b+"'")}let X=_;if(_===i.RED&&(F===i.FLOAT&&(X=i.R32F),F===i.HALF_FLOAT&&(X=i.R16F),F===i.UNSIGNED_BYTE&&(X=i.R8)),_===i.RED_INTEGER&&(F===i.UNSIGNED_BYTE&&(X=i.R8UI),F===i.UNSIGNED_SHORT&&(X=i.R16UI),F===i.UNSIGNED_INT&&(X=i.R32UI),F===i.BYTE&&(X=i.R8I),F===i.SHORT&&(X=i.R16I),F===i.INT&&(X=i.R32I)),_===i.RG&&(F===i.FLOAT&&(X=i.RG32F),F===i.HALF_FLOAT&&(X=i.RG16F),F===i.UNSIGNED_BYTE&&(X=i.RG8)),_===i.RG_INTEGER&&(F===i.UNSIGNED_BYTE&&(X=i.RG8UI),F===i.UNSIGNED_SHORT&&(X=i.RG16UI),F===i.UNSIGNED_INT&&(X=i.RG32UI),F===i.BYTE&&(X=i.RG8I),F===i.SHORT&&(X=i.RG16I),F===i.INT&&(X=i.RG32I)),_===i.RGB_INTEGER&&(F===i.UNSIGNED_BYTE&&(X=i.RGB8UI),F===i.UNSIGNED_SHORT&&(X=i.RGB16UI),F===i.UNSIGNED_INT&&(X=i.RGB32UI),F===i.BYTE&&(X=i.RGB8I),F===i.SHORT&&(X=i.RGB16I),F===i.INT&&(X=i.RGB32I)),_===i.RGBA_INTEGER&&(F===i.UNSIGNED_BYTE&&(X=i.RGBA8UI),F===i.UNSIGNED_SHORT&&(X=i.RGBA16UI),F===i.UNSIGNED_INT&&(X=i.RGBA32UI),F===i.BYTE&&(X=i.RGBA8I),F===i.SHORT&&(X=i.RGBA16I),F===i.INT&&(X=i.RGBA32I)),_===i.RGB&&(F===i.UNSIGNED_INT_5_9_9_9_REV&&(X=i.RGB9_E5),F===i.UNSIGNED_INT_10F_11F_11F_REV&&(X=i.R11F_G11F_B10F)),_===i.RGBA){let Rt=j?Ss:$t.getTransfer(V);F===i.FLOAT&&(X=i.RGBA32F),F===i.HALF_FLOAT&&(X=i.RGBA16F),F===i.UNSIGNED_BYTE&&(X=Rt===te?i.SRGB8_ALPHA8:i.RGBA8),F===i.UNSIGNED_SHORT_4_4_4_4&&(X=i.RGBA4),F===i.UNSIGNED_SHORT_5_5_5_1&&(X=i.RGB5_A1)}return(X===i.R16F||X===i.R32F||X===i.RG16F||X===i.RG32F||X===i.RGBA16F||X===i.RGBA32F)&&t.get("EXT_color_buffer_float"),X}function v(b,_){let F;return b?_===null||_===$n||_===ns?F=i.DEPTH24_STENCIL8:_===_n?F=i.DEPTH32F_STENCIL8:_===ts&&(F=i.DEPTH24_STENCIL8,console.warn("DepthTexture: 16 bit depth attachment is not supported with stencil. Using 24-bit attachment.")):_===null||_===$n||_===ns?F=i.DEPTH_COMPONENT24:_===_n?F=i.DEPTH_COMPONENT32F:_===ts&&(F=i.DEPTH_COMPONENT16),F}function C(b,_){return m(b)===!0||b.isFramebufferTexture&&b.minFilter!==Ke&&b.minFilter!==rn?Math.log2(Math.max(_.width,_.height))+1:b.mipmaps!==void 0&&b.mipmaps.length>0?b.mipmaps.length:b.isCompressedTexture&&Array.isArray(b.image)?_.mipmaps.length:1}function A(b){let _=b.target;_.removeEventListener("dispose",A),U(_),_.isVideoTexture&&h.delete(_)}function I(b){let _=b.target;_.removeEventListener("dispose",I),M(_)}function U(b){let _=n.get(b);if(_.__webglInit===void 0)return;let F=b.source,V=f.get(F);if(V){let j=V[_.__cacheKey];j.usedTimes--,j.usedTimes===0&&S(b),Object.keys(V).length===0&&f.delete(F)}n.remove(b)}function S(b){let _=n.get(b);i.deleteTexture(_.__webglTexture);let F=b.source,V=f.get(F);delete V[_.__cacheKey],o.memory.textures--}function M(b){let _=n.get(b);if(b.depthTexture&&(b.depthTexture.dispose(),n.remove(b.depthTexture)),b.isWebGLCubeRenderTarget)for(let V=0;V<6;V++){if(Array.isArray(_.__webglFramebuffer[V]))for(let j=0;j<_.__webglFramebuffer[V].length;j++)i.deleteFramebuffer(_.__webglFramebuffer[V][j]);else i.deleteFramebuffer(_.__webglFramebuffer[V]);_.__webglDepthbuffer&&i.deleteRenderbuffer(_.__webglDepthbuffer[V])}else{if(Array.isArray(_.__webglFramebuffer))for(let V=0;V<_.__webglFramebuffer.length;V++)i.deleteFramebuffer(_.__webglFramebuffer[V]);else i.deleteFramebuffer(_.__webglFramebuffer);if(_.__webglDepthbuffer&&i.deleteRenderbuffer(_.__webglDepthbuffer),_.__webglMultisampledFramebuffer&&i.deleteFramebuffer(_.__webglMultisampledFramebuffer),_.__webglColorRenderbuffer)for(let V=0;V<_.__webglColorRenderbuffer.length;V++)_.__webglColorRenderbuffer[V]&&i.deleteRenderbuffer(_.__webglColorRenderbuffer[V]);_.__webglDepthRenderbuffer&&i.deleteRenderbuffer(_.__webglDepthRenderbuffer)}let F=b.textures;for(let V=0,j=F.length;V<j;V++){let X=n.get(F[V]);X.__webglTexture&&(i.deleteTexture(X.__webglTexture),o.memory.textures--),n.remove(F[V])}n.remove(b)}let R=0;function O(){R=0}function k(){let b=R;return b>=s.maxTextures&&console.warn("THREE.WebGLTextures: Trying to use "+b+" texture units while this GPU supports only "+s.maxTextures),R+=1,b}function W(b){let _=[];return _.push(b.wrapS),_.push(b.wrapT),_.push(b.wrapR||0),_.push(b.magFilter),_.push(b.minFilter),_.push(b.anisotropy),_.push(b.internalFormat),_.push(b.format),_.push(b.type),_.push(b.generateMipmaps),_.push(b.premultiplyAlpha),_.push(b.flipY),_.push(b.unpackAlignment),_.push(b.colorSpace),_.join()}function q(b,_){let F=n.get(b);if(b.isVideoTexture&&ht(b),b.isRenderTargetTexture===!1&&b.isExternalTexture!==!0&&b.version>0&&F.__version!==b.version){let V=b.image;if(V===null)console.warn("THREE.WebGLRenderer: Texture marked for update but no image data found.");else if(V.complete===!1)console.warn("THREE.WebGLRenderer: Texture marked for update but image is incomplete");else{Y(F,b,_);return}}else b.isExternalTexture&&(F.__webglTexture=b.sourceTexture?b.sourceTexture:null);e.bindTexture(i.TEXTURE_2D,F.__webglTexture,i.TEXTURE0+_)}function G(b,_){let F=n.get(b);if(b.isRenderTargetTexture===!1&&b.version>0&&F.__version!==b.version){Y(F,b,_);return}e.bindTexture(i.TEXTURE_2D_ARRAY,F.__webglTexture,i.TEXTURE0+_)}function et(b,_){let F=n.get(b);if(b.isRenderTargetTexture===!1&&b.version>0&&F.__version!==b.version){Y(F,b,_);return}e.bindTexture(i.TEXTURE_3D,F.__webglTexture,i.TEXTURE0+_)}function H(b,_){let F=n.get(b);if(b.version>0&&F.__version!==b.version){tt(F,b,_);return}e.bindTexture(i.TEXTURE_CUBE_MAP,F.__webglTexture,i.TEXTURE0+_)}let ut={[Nr]:i.REPEAT,[kn]:i.CLAMP_TO_EDGE,[Fr]:i.MIRRORED_REPEAT},xt={[Ke]:i.NEAREST,[th]:i.NEAREST_MIPMAP_NEAREST,[js]:i.NEAREST_MIPMAP_LINEAR,[rn]:i.LINEAR,[yo]:i.LINEAR_MIPMAP_NEAREST,[Jn]:i.LINEAR_MIPMAP_LINEAR},Mt={[sh]:i.NEVER,[hh]:i.ALWAYS,[rh]:i.LESS,[pl]:i.LEQUAL,[oh]:i.EQUAL,[ch]:i.GEQUAL,[ah]:i.GREATER,[lh]:i.NOTEQUAL};function kt(b,_){if(_.type===_n&&t.has("OES_texture_float_linear")===!1&&(_.magFilter===rn||_.magFilter===yo||_.magFilter===js||_.magFilter===Jn||_.minFilter===rn||_.minFilter===yo||_.minFilter===js||_.minFilter===Jn)&&console.warn("THREE.WebGLRenderer: Unable to use linear filtering with floating point textures. OES_texture_float_linear not supported on this device."),i.texParameteri(b,i.TEXTURE_WRAP_S,ut[_.wrapS]),i.texParameteri(b,i.TEXTURE_WRAP_T,ut[_.wrapT]),(b===i.TEXTURE_3D||b===i.TEXTURE_2D_ARRAY)&&i.texParameteri(b,i.TEXTURE_WRAP_R,ut[_.wrapR]),i.texParameteri(b,i.TEXTURE_MAG_FILTER,xt[_.magFilter]),i.texParameteri(b,i.TEXTURE_MIN_FILTER,xt[_.minFilter]),_.compareFunction&&(i.texParameteri(b,i.TEXTURE_COMPARE_MODE,i.COMPARE_REF_TO_TEXTURE),i.texParameteri(b,i.TEXTURE_COMPARE_FUNC,Mt[_.compareFunction])),t.has("EXT_texture_filter_anisotropic")===!0){if(_.magFilter===Ke||_.minFilter!==js&&_.minFilter!==Jn||_.type===_n&&t.has("OES_texture_float_linear")===!1)return;if(_.anisotropy>1||n.get(_).__currentAnisotropy){let F=t.get("EXT_texture_filter_anisotropic");i.texParameterf(b,F.TEXTURE_MAX_ANISOTROPY_EXT,Math.min(_.anisotropy,s.getMaxAnisotropy())),n.get(_).__currentAnisotropy=_.anisotropy}}}function Zt(b,_){let F=!1;b.__webglInit===void 0&&(b.__webglInit=!0,_.addEventListener("dispose",A));let V=_.source,j=f.get(V);j===void 0&&(j={},f.set(V,j));let X=W(_);if(X!==b.__cacheKey){j[X]===void 0&&(j[X]={texture:i.createTexture(),usedTimes:0},o.memory.textures++,F=!0),j[X].usedTimes++;let Rt=j[b.__cacheKey];Rt!==void 0&&(j[b.__cacheKey].usedTimes--,Rt.usedTimes===0&&S(_)),b.__cacheKey=X,b.__webglTexture=j[X].texture}return F}function Qt(b,_,F){return Math.floor(Math.floor(b/F)/_)}function Jt(b,_,F,V){let X=b.updateRanges;if(X.length===0)e.texSubImage2D(i.TEXTURE_2D,0,0,0,_.width,_.height,F,V,_.data);else{X.sort((it,_t)=>it.start-_t.start);let Rt=0;for(let it=1;it<X.length;it++){let _t=X[Rt],Nt=X[it],It=_t.start+_t.count,mt=Qt(Nt.start,_.width,4),Ht=Qt(_t.start,_.width,4);Nt.start<=It+1&&mt===Ht&&Qt(Nt.start+Nt.count-1,_.width,4)===mt?_t.count=Math.max(_t.count,Nt.start+Nt.count-_t.start):(++Rt,X[Rt]=Nt)}X.length=Rt+1;let lt=i.getParameter(i.UNPACK_ROW_LENGTH),wt=i.getParameter(i.UNPACK_SKIP_PIXELS),At=i.getParameter(i.UNPACK_SKIP_ROWS);i.pixelStorei(i.UNPACK_ROW_LENGTH,_.width);for(let it=0,_t=X.length;it<_t;it++){let Nt=X[it],It=Math.floor(Nt.start/4),mt=Math.ceil(Nt.count/4),Ht=It%_.width,P=Math.floor(It/_.width),ot=mt,dt=1;i.pixelStorei(i.UNPACK_SKIP_PIXELS,Ht),i.pixelStorei(i.UNPACK_SKIP_ROWS,P),e.texSubImage2D(i.TEXTURE_2D,0,Ht,P,ot,dt,F,V,_.data)}b.clearUpdateRanges(),i.pixelStorei(i.UNPACK_ROW_LENGTH,lt),i.pixelStorei(i.UNPACK_SKIP_PIXELS,wt),i.pixelStorei(i.UNPACK_SKIP_ROWS,At)}}function Y(b,_,F){let V=i.TEXTURE_2D;(_.isDataArrayTexture||_.isCompressedArrayTexture)&&(V=i.TEXTURE_2D_ARRAY),_.isData3DTexture&&(V=i.TEXTURE_3D);let j=Zt(b,_),X=_.source;e.bindTexture(V,b.__webglTexture,i.TEXTURE0+F);let Rt=n.get(X);if(X.version!==Rt.__version||j===!0){e.activeTexture(i.TEXTURE0+F);let lt=$t.getPrimaries($t.workingColorSpace),wt=_.colorSpace===In?null:$t.getPrimaries(_.colorSpace),At=_.colorSpace===In||lt===wt?i.NONE:i.BROWSER_DEFAULT_WEBGL;i.pixelStorei(i.UNPACK_FLIP_Y_WEBGL,_.flipY),i.pixelStorei(i.UNPACK_PREMULTIPLY_ALPHA_WEBGL,_.premultiplyAlpha),i.pixelStorei(i.UNPACK_ALIGNMENT,_.unpackAlignment),i.pixelStorei(i.UNPACK_COLORSPACE_CONVERSION_WEBGL,At);let it=y(_.image,!1,s.maxTextureSize);it=Bt(_,it);let _t=r.convert(_.format,_.colorSpace),Nt=r.convert(_.type),It=E(_.internalFormat,_t,Nt,_.colorSpace,_.isVideoTexture);kt(V,_);let mt,Ht=_.mipmaps,P=_.isVideoTexture!==!0,ot=Rt.__version===void 0||j===!0,dt=X.dataReady,St=C(_,it);if(_.isDepthTexture)It=v(_.format===is,_.type),ot&&(P?e.texStorage2D(i.TEXTURE_2D,1,It,it.width,it.height):e.texImage2D(i.TEXTURE_2D,0,It,it.width,it.height,0,_t,Nt,null));else if(_.isDataTexture)if(Ht.length>0){P&&ot&&e.texStorage2D(i.TEXTURE_2D,St,It,Ht[0].width,Ht[0].height);for(let st=0,K=Ht.length;st<K;st++)mt=Ht[st],P?dt&&e.texSubImage2D(i.TEXTURE_2D,st,0,0,mt.width,mt.height,_t,Nt,mt.data):e.texImage2D(i.TEXTURE_2D,st,It,mt.width,mt.height,0,_t,Nt,mt.data);_.generateMipmaps=!1}else P?(ot&&e.texStorage2D(i.TEXTURE_2D,St,It,it.width,it.height),dt&&Jt(_,it,_t,Nt)):e.texImage2D(i.TEXTURE_2D,0,It,it.width,it.height,0,_t,Nt,it.data);else if(_.isCompressedTexture)if(_.isCompressedArrayTexture){P&&ot&&e.texStorage3D(i.TEXTURE_2D_ARRAY,St,It,Ht[0].width,Ht[0].height,it.depth);for(let st=0,K=Ht.length;st<K;st++)if(mt=Ht[st],_.format!==Qe)if(_t!==null)if(P){if(dt)if(_.layerUpdates.size>0){let Ct=bl(mt.width,mt.height,_.format,_.type);for(let zt of _.layerUpdates){let re=mt.data.subarray(zt*Ct/mt.data.BYTES_PER_ELEMENT,(zt+1)*Ct/mt.data.BYTES_PER_ELEMENT);e.compressedTexSubImage3D(i.TEXTURE_2D_ARRAY,st,0,0,zt,mt.width,mt.height,1,_t,re)}_.clearLayerUpdates()}else e.compressedTexSubImage3D(i.TEXTURE_2D_ARRAY,st,0,0,0,mt.width,mt.height,it.depth,_t,mt.data)}else e.compressedTexImage3D(i.TEXTURE_2D_ARRAY,st,It,mt.width,mt.height,it.depth,0,mt.data,0,0);else console.warn("THREE.WebGLRenderer: Attempt to load unsupported compressed texture format in .uploadTexture()");else P?dt&&e.texSubImage3D(i.TEXTURE_2D_ARRAY,st,0,0,0,mt.width,mt.height,it.depth,_t,Nt,mt.data):e.texImage3D(i.TEXTURE_2D_ARRAY,st,It,mt.width,mt.height,it.depth,0,_t,Nt,mt.data)}else{P&&ot&&e.texStorage2D(i.TEXTURE_2D,St,It,Ht[0].width,Ht[0].height);for(let st=0,K=Ht.length;st<K;st++)mt=Ht[st],_.format!==Qe?_t!==null?P?dt&&e.compressedTexSubImage2D(i.TEXTURE_2D,st,0,0,mt.width,mt.height,_t,mt.data):e.compressedTexImage2D(i.TEXTURE_2D,st,It,mt.width,mt.height,0,mt.data):console.warn("THREE.WebGLRenderer: Attempt to load unsupported compressed texture format in .uploadTexture()"):P?dt&&e.texSubImage2D(i.TEXTURE_2D,st,0,0,mt.width,mt.height,_t,Nt,mt.data):e.texImage2D(i.TEXTURE_2D,st,It,mt.width,mt.height,0,_t,Nt,mt.data)}else if(_.isDataArrayTexture)if(P){if(ot&&e.texStorage3D(i.TEXTURE_2D_ARRAY,St,It,it.width,it.height,it.depth),dt)if(_.layerUpdates.size>0){let st=bl(it.width,it.height,_.format,_.type);for(let K of _.layerUpdates){let Ct=it.data.subarray(K*st/it.data.BYTES_PER_ELEMENT,(K+1)*st/it.data.BYTES_PER_ELEMENT);e.texSubImage3D(i.TEXTURE_2D_ARRAY,0,0,0,K,it.width,it.height,1,_t,Nt,Ct)}_.clearLayerUpdates()}else e.texSubImage3D(i.TEXTURE_2D_ARRAY,0,0,0,0,it.width,it.height,it.depth,_t,Nt,it.data)}else e.texImage3D(i.TEXTURE_2D_ARRAY,0,It,it.width,it.height,it.depth,0,_t,Nt,it.data);else if(_.isData3DTexture)P?(ot&&e.texStorage3D(i.TEXTURE_3D,St,It,it.width,it.height,it.depth),dt&&e.texSubImage3D(i.TEXTURE_3D,0,0,0,0,it.width,it.height,it.depth,_t,Nt,it.data)):e.texImage3D(i.TEXTURE_3D,0,It,it.width,it.height,it.depth,0,_t,Nt,it.data);else if(_.isFramebufferTexture){if(ot)if(P)e.texStorage2D(i.TEXTURE_2D,St,It,it.width,it.height);else{let st=it.width,K=it.height;for(let Ct=0;Ct<St;Ct++)e.texImage2D(i.TEXTURE_2D,Ct,It,st,K,0,_t,Nt,null),st>>=1,K>>=1}}else if(Ht.length>0){if(P&&ot){let st=Ot(Ht[0]);e.texStorage2D(i.TEXTURE_2D,St,It,st.width,st.height)}for(let st=0,K=Ht.length;st<K;st++)mt=Ht[st],P?dt&&e.texSubImage2D(i.TEXTURE_2D,st,0,0,_t,Nt,mt):e.texImage2D(i.TEXTURE_2D,st,It,_t,Nt,mt);_.generateMipmaps=!1}else if(P){if(ot){let st=Ot(it);e.texStorage2D(i.TEXTURE_2D,St,It,st.width,st.height)}dt&&e.texSubImage2D(i.TEXTURE_2D,0,0,0,_t,Nt,it)}else e.texImage2D(i.TEXTURE_2D,0,It,_t,Nt,it);m(_)&&d(V),Rt.__version=X.version,_.onUpdate&&_.onUpdate(_)}b.__version=_.version}function tt(b,_,F){if(_.image.length!==6)return;let V=Zt(b,_),j=_.source;e.bindTexture(i.TEXTURE_CUBE_MAP,b.__webglTexture,i.TEXTURE0+F);let X=n.get(j);if(j.version!==X.__version||V===!0){e.activeTexture(i.TEXTURE0+F);let Rt=$t.getPrimaries($t.workingColorSpace),lt=_.colorSpace===In?null:$t.getPrimaries(_.colorSpace),wt=_.colorSpace===In||Rt===lt?i.NONE:i.BROWSER_DEFAULT_WEBGL;i.pixelStorei(i.UNPACK_FLIP_Y_WEBGL,_.flipY),i.pixelStorei(i.UNPACK_PREMULTIPLY_ALPHA_WEBGL,_.premultiplyAlpha),i.pixelStorei(i.UNPACK_ALIGNMENT,_.unpackAlignment),i.pixelStorei(i.UNPACK_COLORSPACE_CONVERSION_WEBGL,wt);let At=_.isCompressedTexture||_.image[0].isCompressedTexture,it=_.image[0]&&_.image[0].isDataTexture,_t=[];for(let K=0;K<6;K++)!At&&!it?_t[K]=y(_.image[K],!0,s.maxCubemapSize):_t[K]=it?_.image[K].image:_.image[K],_t[K]=Bt(_,_t[K]);let Nt=_t[0],It=r.convert(_.format,_.colorSpace),mt=r.convert(_.type),Ht=E(_.internalFormat,It,mt,_.colorSpace),P=_.isVideoTexture!==!0,ot=X.__version===void 0||V===!0,dt=j.dataReady,St=C(_,Nt);kt(i.TEXTURE_CUBE_MAP,_);let st;if(At){P&&ot&&e.texStorage2D(i.TEXTURE_CUBE_MAP,St,Ht,Nt.width,Nt.height);for(let K=0;K<6;K++){st=_t[K].mipmaps;for(let Ct=0;Ct<st.length;Ct++){let zt=st[Ct];_.format!==Qe?It!==null?P?dt&&e.compressedTexSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,Ct,0,0,zt.width,zt.height,It,zt.data):e.compressedTexImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,Ct,Ht,zt.width,zt.height,0,zt.data):console.warn("THREE.WebGLRenderer: Attempt to load unsupported compressed texture format in .setTextureCube()"):P?dt&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,Ct,0,0,zt.width,zt.height,It,mt,zt.data):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,Ct,Ht,zt.width,zt.height,0,It,mt,zt.data)}}}else{if(st=_.mipmaps,P&&ot){st.length>0&&St++;let K=Ot(_t[0]);e.texStorage2D(i.TEXTURE_CUBE_MAP,St,Ht,K.width,K.height)}for(let K=0;K<6;K++)if(it){P?dt&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,0,0,0,_t[K].width,_t[K].height,It,mt,_t[K].data):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,0,Ht,_t[K].width,_t[K].height,0,It,mt,_t[K].data);for(let Ct=0;Ct<st.length;Ct++){let re=st[Ct].image[K].image;P?dt&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,Ct+1,0,0,re.width,re.height,It,mt,re.data):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,Ct+1,Ht,re.width,re.height,0,It,mt,re.data)}}else{P?dt&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,0,0,0,It,mt,_t[K]):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,0,Ht,It,mt,_t[K]);for(let Ct=0;Ct<st.length;Ct++){let zt=st[Ct];P?dt&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,Ct+1,0,0,It,mt,zt.image[K]):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+K,Ct+1,Ht,It,mt,zt.image[K])}}}m(_)&&d(i.TEXTURE_CUBE_MAP),X.__version=j.version,_.onUpdate&&_.onUpdate(_)}b.__version=_.version}function vt(b,_,F,V,j,X){let Rt=r.convert(F.format,F.colorSpace),lt=r.convert(F.type),wt=E(F.internalFormat,Rt,lt,F.colorSpace),At=n.get(_),it=n.get(F);if(it.__renderTarget=_,!At.__hasExternalTextures){let _t=Math.max(1,_.width>>X),Nt=Math.max(1,_.height>>X);j===i.TEXTURE_3D||j===i.TEXTURE_2D_ARRAY?e.texImage3D(j,X,wt,_t,Nt,_.depth,0,Rt,lt,null):e.texImage2D(j,X,wt,_t,Nt,0,Rt,lt,null)}e.bindFramebuffer(i.FRAMEBUFFER,b),nt(_)?a.framebufferTexture2DMultisampleEXT(i.FRAMEBUFFER,V,j,it.__webglTexture,0,ct(_)):(j===i.TEXTURE_2D||j>=i.TEXTURE_CUBE_MAP_POSITIVE_X&&j<=i.TEXTURE_CUBE_MAP_NEGATIVE_Z)&&i.framebufferTexture2D(i.FRAMEBUFFER,V,j,it.__webglTexture,X),e.bindFramebuffer(i.FRAMEBUFFER,null)}function Pt(b,_,F){if(i.bindRenderbuffer(i.RENDERBUFFER,b),_.depthBuffer){let V=_.depthTexture,j=V&&V.isDepthTexture?V.type:null,X=v(_.stencilBuffer,j),Rt=_.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,lt=ct(_);nt(_)?a.renderbufferStorageMultisampleEXT(i.RENDERBUFFER,lt,X,_.width,_.height):F?i.renderbufferStorageMultisample(i.RENDERBUFFER,lt,X,_.width,_.height):i.renderbufferStorage(i.RENDERBUFFER,X,_.width,_.height),i.framebufferRenderbuffer(i.FRAMEBUFFER,Rt,i.RENDERBUFFER,b)}else{let V=_.textures;for(let j=0;j<V.length;j++){let X=V[j],Rt=r.convert(X.format,X.colorSpace),lt=r.convert(X.type),wt=E(X.internalFormat,Rt,lt,X.colorSpace),At=ct(_);F&&nt(_)===!1?i.renderbufferStorageMultisample(i.RENDERBUFFER,At,wt,_.width,_.height):nt(_)?a.renderbufferStorageMultisampleEXT(i.RENDERBUFFER,At,wt,_.width,_.height):i.renderbufferStorage(i.RENDERBUFFER,wt,_.width,_.height)}}i.bindRenderbuffer(i.RENDERBUFFER,null)}function Tt(b,_){if(_&&_.isWebGLCubeRenderTarget)throw new Error("Depth Texture with cube render targets is not supported");if(e.bindFramebuffer(i.FRAMEBUFFER,b),!(_.depthTexture&&_.depthTexture.isDepthTexture))throw new Error("renderTarget.depthTexture must be an instance of THREE.DepthTexture");let V=n.get(_.depthTexture);V.__renderTarget=_,(!V.__webglTexture||_.depthTexture.image.width!==_.width||_.depthTexture.image.height!==_.height)&&(_.depthTexture.image.width=_.width,_.depthTexture.image.height=_.height,_.depthTexture.needsUpdate=!0),q(_.depthTexture,0);let j=V.__webglTexture,X=ct(_);if(_.depthTexture.format===ki)nt(_)?a.framebufferTexture2DMultisampleEXT(i.FRAMEBUFFER,i.DEPTH_ATTACHMENT,i.TEXTURE_2D,j,0,X):i.framebufferTexture2D(i.FRAMEBUFFER,i.DEPTH_ATTACHMENT,i.TEXTURE_2D,j,0);else if(_.depthTexture.format===is)nt(_)?a.framebufferTexture2DMultisampleEXT(i.FRAMEBUFFER,i.DEPTH_STENCIL_ATTACHMENT,i.TEXTURE_2D,j,0,X):i.framebufferTexture2D(i.FRAMEBUFFER,i.DEPTH_STENCIL_ATTACHMENT,i.TEXTURE_2D,j,0);else throw new Error("Unknown depthTexture format")}function Xt(b){let _=n.get(b),F=b.isWebGLCubeRenderTarget===!0;if(_.__boundDepthTexture!==b.depthTexture){let V=b.depthTexture;if(_.__depthDisposeCallback&&_.__depthDisposeCallback(),V){let j=()=>{delete _.__boundDepthTexture,delete _.__depthDisposeCallback,V.removeEventListener("dispose",j)};V.addEventListener("dispose",j),_.__depthDisposeCallback=j}_.__boundDepthTexture=V}if(b.depthTexture&&!_.__autoAllocateDepthBuffer){if(F)throw new Error("target.depthTexture not supported in Cube render targets");let V=b.texture.mipmaps;V&&V.length>0?Tt(_.__webglFramebuffer[0],b):Tt(_.__webglFramebuffer,b)}else if(F){_.__webglDepthbuffer=[];for(let V=0;V<6;V++)if(e.bindFramebuffer(i.FRAMEBUFFER,_.__webglFramebuffer[V]),_.__webglDepthbuffer[V]===void 0)_.__webglDepthbuffer[V]=i.createRenderbuffer(),Pt(_.__webglDepthbuffer[V],b,!1);else{let j=b.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,X=_.__webglDepthbuffer[V];i.bindRenderbuffer(i.RENDERBUFFER,X),i.framebufferRenderbuffer(i.FRAMEBUFFER,j,i.RENDERBUFFER,X)}}else{let V=b.texture.mipmaps;if(V&&V.length>0?e.bindFramebuffer(i.FRAMEBUFFER,_.__webglFramebuffer[0]):e.bindFramebuffer(i.FRAMEBUFFER,_.__webglFramebuffer),_.__webglDepthbuffer===void 0)_.__webglDepthbuffer=i.createRenderbuffer(),Pt(_.__webglDepthbuffer,b,!1);else{let j=b.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,X=_.__webglDepthbuffer;i.bindRenderbuffer(i.RENDERBUFFER,X),i.framebufferRenderbuffer(i.FRAMEBUFFER,j,i.RENDERBUFFER,X)}}e.bindFramebuffer(i.FRAMEBUFFER,null)}function se(b,_,F){let V=n.get(b);_!==void 0&&vt(V.__webglFramebuffer,b,b.texture,i.COLOR_ATTACHMENT0,i.TEXTURE_2D,0),F!==void 0&&Xt(b)}function T(b){let _=b.texture,F=n.get(b),V=n.get(_);b.addEventListener("dispose",I);let j=b.textures,X=b.isWebGLCubeRenderTarget===!0,Rt=j.length>1;if(Rt||(V.__webglTexture===void 0&&(V.__webglTexture=i.createTexture()),V.__version=_.version,o.memory.textures++),X){F.__webglFramebuffer=[];for(let lt=0;lt<6;lt++)if(_.mipmaps&&_.mipmaps.length>0){F.__webglFramebuffer[lt]=[];for(let wt=0;wt<_.mipmaps.length;wt++)F.__webglFramebuffer[lt][wt]=i.createFramebuffer()}else F.__webglFramebuffer[lt]=i.createFramebuffer()}else{if(_.mipmaps&&_.mipmaps.length>0){F.__webglFramebuffer=[];for(let lt=0;lt<_.mipmaps.length;lt++)F.__webglFramebuffer[lt]=i.createFramebuffer()}else F.__webglFramebuffer=i.createFramebuffer();if(Rt)for(let lt=0,wt=j.length;lt<wt;lt++){let At=n.get(j[lt]);At.__webglTexture===void 0&&(At.__webglTexture=i.createTexture(),o.memory.textures++)}if(b.samples>0&&nt(b)===!1){F.__webglMultisampledFramebuffer=i.createFramebuffer(),F.__webglColorRenderbuffer=[],e.bindFramebuffer(i.FRAMEBUFFER,F.__webglMultisampledFramebuffer);for(let lt=0;lt<j.length;lt++){let wt=j[lt];F.__webglColorRenderbuffer[lt]=i.createRenderbuffer(),i.bindRenderbuffer(i.RENDERBUFFER,F.__webglColorRenderbuffer[lt]);let At=r.convert(wt.format,wt.colorSpace),it=r.convert(wt.type),_t=E(wt.internalFormat,At,it,wt.colorSpace,b.isXRRenderTarget===!0),Nt=ct(b);i.renderbufferStorageMultisample(i.RENDERBUFFER,Nt,_t,b.width,b.height),i.framebufferRenderbuffer(i.FRAMEBUFFER,i.COLOR_ATTACHMENT0+lt,i.RENDERBUFFER,F.__webglColorRenderbuffer[lt])}i.bindRenderbuffer(i.RENDERBUFFER,null),b.depthBuffer&&(F.__webglDepthRenderbuffer=i.createRenderbuffer(),Pt(F.__webglDepthRenderbuffer,b,!0)),e.bindFramebuffer(i.FRAMEBUFFER,null)}}if(X){e.bindTexture(i.TEXTURE_CUBE_MAP,V.__webglTexture),kt(i.TEXTURE_CUBE_MAP,_);for(let lt=0;lt<6;lt++)if(_.mipmaps&&_.mipmaps.length>0)for(let wt=0;wt<_.mipmaps.length;wt++)vt(F.__webglFramebuffer[lt][wt],b,_,i.COLOR_ATTACHMENT0,i.TEXTURE_CUBE_MAP_POSITIVE_X+lt,wt);else vt(F.__webglFramebuffer[lt],b,_,i.COLOR_ATTACHMENT0,i.TEXTURE_CUBE_MAP_POSITIVE_X+lt,0);m(_)&&d(i.TEXTURE_CUBE_MAP),e.unbindTexture()}else if(Rt){for(let lt=0,wt=j.length;lt<wt;lt++){let At=j[lt],it=n.get(At),_t=i.TEXTURE_2D;(b.isWebGL3DRenderTarget||b.isWebGLArrayRenderTarget)&&(_t=b.isWebGL3DRenderTarget?i.TEXTURE_3D:i.TEXTURE_2D_ARRAY),e.bindTexture(_t,it.__webglTexture),kt(_t,At),vt(F.__webglFramebuffer,b,At,i.COLOR_ATTACHMENT0+lt,_t,0),m(At)&&d(_t)}e.unbindTexture()}else{let lt=i.TEXTURE_2D;if((b.isWebGL3DRenderTarget||b.isWebGLArrayRenderTarget)&&(lt=b.isWebGL3DRenderTarget?i.TEXTURE_3D:i.TEXTURE_2D_ARRAY),e.bindTexture(lt,V.__webglTexture),kt(lt,_),_.mipmaps&&_.mipmaps.length>0)for(let wt=0;wt<_.mipmaps.length;wt++)vt(F.__webglFramebuffer[wt],b,_,i.COLOR_ATTACHMENT0,lt,wt);else vt(F.__webglFramebuffer,b,_,i.COLOR_ATTACHMENT0,lt,0);m(_)&&d(lt),e.unbindTexture()}b.depthBuffer&&Xt(b)}function Q(b){let _=b.textures;for(let F=0,V=_.length;F<V;F++){let j=_[F];if(m(j)){let X=w(b),Rt=n.get(j).__webglTexture;e.bindTexture(X,Rt),d(X),e.unbindTexture()}}}let $=[],J=[];function Z(b){if(b.samples>0){if(nt(b)===!1){let _=b.textures,F=b.width,V=b.height,j=i.COLOR_BUFFER_BIT,X=b.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,Rt=n.get(b),lt=_.length>1;if(lt)for(let At=0;At<_.length;At++)e.bindFramebuffer(i.FRAMEBUFFER,Rt.__webglMultisampledFramebuffer),i.framebufferRenderbuffer(i.FRAMEBUFFER,i.COLOR_ATTACHMENT0+At,i.RENDERBUFFER,null),e.bindFramebuffer(i.FRAMEBUFFER,Rt.__webglFramebuffer),i.framebufferTexture2D(i.DRAW_FRAMEBUFFER,i.COLOR_ATTACHMENT0+At,i.TEXTURE_2D,null,0);e.bindFramebuffer(i.READ_FRAMEBUFFER,Rt.__webglMultisampledFramebuffer);let wt=b.texture.mipmaps;wt&&wt.length>0?e.bindFramebuffer(i.DRAW_FRAMEBUFFER,Rt.__webglFramebuffer[0]):e.bindFramebuffer(i.DRAW_FRAMEBUFFER,Rt.__webglFramebuffer);for(let At=0;At<_.length;At++){if(b.resolveDepthBuffer&&(b.depthBuffer&&(j|=i.DEPTH_BUFFER_BIT),b.stencilBuffer&&b.resolveStencilBuffer&&(j|=i.STENCIL_BUFFER_BIT)),lt){i.framebufferRenderbuffer(i.READ_FRAMEBUFFER,i.COLOR_ATTACHMENT0,i.RENDERBUFFER,Rt.__webglColorRenderbuffer[At]);let it=n.get(_[At]).__webglTexture;i.framebufferTexture2D(i.DRAW_FRAMEBUFFER,i.COLOR_ATTACHMENT0,i.TEXTURE_2D,it,0)}i.blitFramebuffer(0,0,F,V,0,0,F,V,j,i.NEAREST),l===!0&&($.length=0,J.length=0,$.push(i.COLOR_ATTACHMENT0+At),b.depthBuffer&&b.resolveDepthBuffer===!1&&($.push(X),J.push(X),i.invalidateFramebuffer(i.DRAW_FRAMEBUFFER,J)),i.invalidateFramebuffer(i.READ_FRAMEBUFFER,$))}if(e.bindFramebuffer(i.READ_FRAMEBUFFER,null),e.bindFramebuffer(i.DRAW_FRAMEBUFFER,null),lt)for(let At=0;At<_.length;At++){e.bindFramebuffer(i.FRAMEBUFFER,Rt.__webglMultisampledFramebuffer),i.framebufferRenderbuffer(i.FRAMEBUFFER,i.COLOR_ATTACHMENT0+At,i.RENDERBUFFER,Rt.__webglColorRenderbuffer[At]);let it=n.get(_[At]).__webglTexture;e.bindFramebuffer(i.FRAMEBUFFER,Rt.__webglFramebuffer),i.framebufferTexture2D(i.DRAW_FRAMEBUFFER,i.COLOR_ATTACHMENT0+At,i.TEXTURE_2D,it,0)}e.bindFramebuffer(i.DRAW_FRAMEBUFFER,Rt.__webglMultisampledFramebuffer)}else if(b.depthBuffer&&b.resolveDepthBuffer===!1&&l){let _=b.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT;i.invalidateFramebuffer(i.DRAW_FRAMEBUFFER,[_])}}}function ct(b){return Math.min(s.maxSamples,b.samples)}function nt(b){let _=n.get(b);return b.samples>0&&t.has("WEBGL_multisampled_render_to_texture")===!0&&_.__useRenderToTexture!==!1}function ht(b){let _=o.render.frame;h.get(b)!==_&&(h.set(b,_),b.update())}function Bt(b,_){let F=b.colorSpace,V=b.format,j=b.type;return b.isCompressedTexture===!0||b.isVideoTexture===!0||F!==li&&F!==In&&($t.getTransfer(F)===te?(V!==Qe||j!==cn)&&console.warn("THREE.WebGLTextures: sRGB encoded textures have to use RGBAFormat and UnsignedByteType."):console.error("THREE.WebGLTextures: Unsupported texture color space:",F)),_}function Ot(b){return typeof HTMLImageElement<"u"&&b instanceof HTMLImageElement?(c.width=b.naturalWidth||b.width,c.height=b.naturalHeight||b.height):typeof VideoFrame<"u"&&b instanceof VideoFrame?(c.width=b.displayWidth,c.height=b.displayHeight):(c.width=b.width,c.height=b.height),c}this.allocateTextureUnit=k,this.resetTextureUnits=O,this.setTexture2D=q,this.setTexture2DArray=G,this.setTexture3D=et,this.setTextureCube=H,this.rebindTextures=se,this.setupRenderTarget=T,this.updateRenderTargetMipmap=Q,this.updateMultisampleRenderTarget=Z,this.setupDepthRenderbuffer=Xt,this.setupFrameBufferTexture=vt,this.useMultisampledRTT=nt}function c_(i,t){function e(n,s=In){let r,o=$t.getTransfer(s);if(n===cn)return i.UNSIGNED_BYTE;if(n===Mo)return i.UNSIGNED_SHORT_4_4_4_4;if(n===So)return i.UNSIGNED_SHORT_5_5_5_1;if(n===al)return i.UNSIGNED_INT_5_9_9_9_REV;if(n===ll)return i.UNSIGNED_INT_10F_11F_11F_REV;if(n===rl)return i.BYTE;if(n===ol)return i.SHORT;if(n===ts)return i.UNSIGNED_SHORT;if(n===vo)return i.INT;if(n===$n)return i.UNSIGNED_INT;if(n===_n)return i.FLOAT;if(n===es)return i.HALF_FLOAT;if(n===cl)return i.ALPHA;if(n===hl)return i.RGB;if(n===Qe)return i.RGBA;if(n===ki)return i.DEPTH_COMPONENT;if(n===is)return i.DEPTH_STENCIL;if(n===ul)return i.RED;if(n===bo)return i.RED_INTEGER;if(n===dl)return i.RG;if(n===Eo)return i.RG_INTEGER;if(n===To)return i.RGBA_INTEGER;if(n===Qs||n===tr||n===er||n===nr)if(o===te)if(r=t.get("WEBGL_compressed_texture_s3tc_srgb"),r!==null){if(n===Qs)return r.COMPRESSED_SRGB_S3TC_DXT1_EXT;if(n===tr)return r.COMPRESSED_SRGB_ALPHA_S3TC_DXT1_EXT;if(n===er)return r.COMPRESSED_SRGB_ALPHA_S3TC_DXT3_EXT;if(n===nr)return r.COMPRESSED_SRGB_ALPHA_S3TC_DXT5_EXT}else return null;else if(r=t.get("WEBGL_compressed_texture_s3tc"),r!==null){if(n===Qs)return r.COMPRESSED_RGB_S3TC_DXT1_EXT;if(n===tr)return r.COMPRESSED_RGBA_S3TC_DXT1_EXT;if(n===er)return r.COMPRESSED_RGBA_S3TC_DXT3_EXT;if(n===nr)return r.COMPRESSED_RGBA_S3TC_DXT5_EXT}else return null;if(n===wo||n===Ao||n===Co||n===Ro)if(r=t.get("WEBGL_compressed_texture_pvrtc"),r!==null){if(n===wo)return r.COMPRESSED_RGB_PVRTC_4BPPV1_IMG;if(n===Ao)return r.COMPRESSED_RGB_PVRTC_2BPPV1_IMG;if(n===Co)return r.COMPRESSED_RGBA_PVRTC_4BPPV1_IMG;if(n===Ro)return r.COMPRESSED_RGBA_PVRTC_2BPPV1_IMG}else return null;if(n===Io||n===Po||n===Do)if(r=t.get("WEBGL_compressed_texture_etc"),r!==null){if(n===Io||n===Po)return o===te?r.COMPRESSED_SRGB8_ETC2:r.COMPRESSED_RGB8_ETC2;if(n===Do)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ETC2_EAC:r.COMPRESSED_RGBA8_ETC2_EAC}else return null;if(n===Lo||n===Uo||n===No||n===Fo||n===Oo||n===Bo||n===zo||n===ko||n===Vo||n===Ho||n===Go||n===Wo||n===Xo||n===qo)if(r=t.get("WEBGL_compressed_texture_astc"),r!==null){if(n===Lo)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_4x4_KHR:r.COMPRESSED_RGBA_ASTC_4x4_KHR;if(n===Uo)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_5x4_KHR:r.COMPRESSED_RGBA_ASTC_5x4_KHR;if(n===No)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_5x5_KHR:r.COMPRESSED_RGBA_ASTC_5x5_KHR;if(n===Fo)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_6x5_KHR:r.COMPRESSED_RGBA_ASTC_6x5_KHR;if(n===Oo)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_6x6_KHR:r.COMPRESSED_RGBA_ASTC_6x6_KHR;if(n===Bo)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_8x5_KHR:r.COMPRESSED_RGBA_ASTC_8x5_KHR;if(n===zo)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_8x6_KHR:r.COMPRESSED_RGBA_ASTC_8x6_KHR;if(n===ko)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_8x8_KHR:r.COMPRESSED_RGBA_ASTC_8x8_KHR;if(n===Vo)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x5_KHR:r.COMPRESSED_RGBA_ASTC_10x5_KHR;if(n===Ho)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x6_KHR:r.COMPRESSED_RGBA_ASTC_10x6_KHR;if(n===Go)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x8_KHR:r.COMPRESSED_RGBA_ASTC_10x8_KHR;if(n===Wo)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x10_KHR:r.COMPRESSED_RGBA_ASTC_10x10_KHR;if(n===Xo)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_12x10_KHR:r.COMPRESSED_RGBA_ASTC_12x10_KHR;if(n===qo)return o===te?r.COMPRESSED_SRGB8_ALPHA8_ASTC_12x12_KHR:r.COMPRESSED_RGBA_ASTC_12x12_KHR}else return null;if(n===Yo||n===Zo||n===Jo)if(r=t.get("EXT_texture_compression_bptc"),r!==null){if(n===Yo)return o===te?r.COMPRESSED_SRGB_ALPHA_BPTC_UNORM_EXT:r.COMPRESSED_RGBA_BPTC_UNORM_EXT;if(n===Zo)return r.COMPRESSED_RGB_BPTC_SIGNED_FLOAT_EXT;if(n===Jo)return r.COMPRESSED_RGB_BPTC_UNSIGNED_FLOAT_EXT}else return null;if(n===$o||n===Ko||n===jo||n===Qo)if(r=t.get("EXT_texture_compression_rgtc"),r!==null){if(n===$o)return r.COMPRESSED_RED_RGTC1_EXT;if(n===Ko)return r.COMPRESSED_SIGNED_RED_RGTC1_EXT;if(n===jo)return r.COMPRESSED_RED_GREEN_RGTC2_EXT;if(n===Qo)return r.COMPRESSED_SIGNED_RED_GREEN_RGTC2_EXT}else return null;return n===ns?i.UNSIGNED_INT_24_8:i[n]!==void 0?i[n]:null}return{convert:e}}var h_=`
void main() {

	gl_Position = vec4( position, 1.0 );

}`,u_=`
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

}`,Fl=class{constructor(){this.texture=null,this.mesh=null,this.depthNear=0,this.depthFar=0}init(t,e){if(this.texture===null){let n=new Ds(t.texture);(t.depthNear!==e.depthNear||t.depthFar!==e.depthFar)&&(this.depthNear=t.depthNear,this.depthFar=t.depthFar),this.texture=n}}getMesh(t){if(this.texture!==null&&this.mesh===null){let e=t.cameras[0].viewport,n=new ln({vertexShader:h_,fragmentShader:u_,uniforms:{depthColor:{value:this.texture},depthWidth:{value:e.z},depthHeight:{value:e.w}}});this.mesh=new we(new ji(20,20),n)}return this.mesh}reset(){this.texture=null,this.mesh=null}getDepthTexture(){return this.texture}},Ol=class extends fn{constructor(t,e){super();let n=this,s=null,r=1,o=null,a="local-floor",l=1,c=null,h=null,u=null,f=null,p=null,g=null,y=typeof XRWebGLBinding<"u",m=new Fl,d={},w=e.getContextAttributes(),E=null,v=null,C=[],A=[],I=new at,U=null,S=new Oe;S.viewport=new pe;let M=new Oe;M.viewport=new pe;let R=[S,M],O=new oo,k=null,W=null;this.cameraAutoUpdate=!0,this.enabled=!1,this.isPresenting=!1,this.getController=function(Y){let tt=C[Y];return tt===void 0&&(tt=new Yi,C[Y]=tt),tt.getTargetRaySpace()},this.getControllerGrip=function(Y){let tt=C[Y];return tt===void 0&&(tt=new Yi,C[Y]=tt),tt.getGripSpace()},this.getHand=function(Y){let tt=C[Y];return tt===void 0&&(tt=new Yi,C[Y]=tt),tt.getHandSpace()};function q(Y){let tt=A.indexOf(Y.inputSource);if(tt===-1)return;let vt=C[tt];vt!==void 0&&(vt.update(Y.inputSource,Y.frame,c||o),vt.dispatchEvent({type:Y.type,data:Y.inputSource}))}function G(){s.removeEventListener("select",q),s.removeEventListener("selectstart",q),s.removeEventListener("selectend",q),s.removeEventListener("squeeze",q),s.removeEventListener("squeezestart",q),s.removeEventListener("squeezeend",q),s.removeEventListener("end",G),s.removeEventListener("inputsourceschange",et);for(let Y=0;Y<C.length;Y++){let tt=A[Y];tt!==null&&(A[Y]=null,C[Y].disconnect(tt))}k=null,W=null,m.reset();for(let Y in d)delete d[Y];t.setRenderTarget(E),p=null,f=null,u=null,s=null,v=null,Jt.stop(),n.isPresenting=!1,t.setPixelRatio(U),t.setSize(I.width,I.height,!1),n.dispatchEvent({type:"sessionend"})}this.setFramebufferScaleFactor=function(Y){r=Y,n.isPresenting===!0&&console.warn("THREE.WebXRManager: Cannot change framebuffer scale while presenting.")},this.setReferenceSpaceType=function(Y){a=Y,n.isPresenting===!0&&console.warn("THREE.WebXRManager: Cannot change reference space type while presenting.")},this.getReferenceSpace=function(){return c||o},this.setReferenceSpace=function(Y){c=Y},this.getBaseLayer=function(){return f!==null?f:p},this.getBinding=function(){return u===null&&y&&(u=new XRWebGLBinding(s,e)),u},this.getFrame=function(){return g},this.getSession=function(){return s},this.setSession=async function(Y){if(s=Y,s!==null){if(E=t.getRenderTarget(),s.addEventListener("select",q),s.addEventListener("selectstart",q),s.addEventListener("selectend",q),s.addEventListener("squeeze",q),s.addEventListener("squeezestart",q),s.addEventListener("squeezeend",q),s.addEventListener("end",G),s.addEventListener("inputsourceschange",et),w.xrCompatible!==!0&&await e.makeXRCompatible(),U=t.getPixelRatio(),t.getSize(I),y&&"createProjectionLayer"in XRWebGLBinding.prototype){let vt=null,Pt=null,Tt=null;w.depth&&(Tt=w.stencil?e.DEPTH24_STENCIL8:e.DEPTH_COMPONENT24,vt=w.stencil?is:ki,Pt=w.stencil?ns:$n);let Xt={colorFormat:e.RGBA8,depthFormat:Tt,scaleFactor:r};u=this.getBinding(),f=u.createProjectionLayer(Xt),s.updateRenderState({layers:[f]}),t.setPixelRatio(1),t.setSize(f.textureWidth,f.textureHeight,!1),v=new pn(f.textureWidth,f.textureHeight,{format:Qe,type:cn,depthTexture:new Ps(f.textureWidth,f.textureHeight,Pt,void 0,void 0,void 0,void 0,void 0,void 0,vt),stencilBuffer:w.stencil,colorSpace:t.outputColorSpace,samples:w.antialias?4:0,resolveDepthBuffer:f.ignoreDepthValues===!1,resolveStencilBuffer:f.ignoreDepthValues===!1})}else{let vt={antialias:w.antialias,alpha:!0,depth:w.depth,stencil:w.stencil,framebufferScaleFactor:r};p=new XRWebGLLayer(s,e,vt),s.updateRenderState({baseLayer:p}),t.setPixelRatio(1),t.setSize(p.framebufferWidth,p.framebufferHeight,!1),v=new pn(p.framebufferWidth,p.framebufferHeight,{format:Qe,type:cn,colorSpace:t.outputColorSpace,stencilBuffer:w.stencil,resolveDepthBuffer:p.ignoreDepthValues===!1,resolveStencilBuffer:p.ignoreDepthValues===!1})}v.isXRRenderTarget=!0,this.setFoveation(l),c=null,o=await s.requestReferenceSpace(a),Jt.setContext(s),Jt.start(),n.isPresenting=!0,n.dispatchEvent({type:"sessionstart"})}},this.getEnvironmentBlendMode=function(){if(s!==null)return s.environmentBlendMode},this.getDepthTexture=function(){return m.getDepthTexture()};function et(Y){for(let tt=0;tt<Y.removed.length;tt++){let vt=Y.removed[tt],Pt=A.indexOf(vt);Pt>=0&&(A[Pt]=null,C[Pt].disconnect(vt))}for(let tt=0;tt<Y.added.length;tt++){let vt=Y.added[tt],Pt=A.indexOf(vt);if(Pt===-1){for(let Xt=0;Xt<C.length;Xt++)if(Xt>=A.length){A.push(vt),Pt=Xt;break}else if(A[Xt]===null){A[Xt]=vt,Pt=Xt;break}if(Pt===-1)break}let Tt=C[Pt];Tt&&Tt.connect(vt)}}let H=new D,ut=new D;function xt(Y,tt,vt){H.setFromMatrixPosition(tt.matrixWorld),ut.setFromMatrixPosition(vt.matrixWorld);let Pt=H.distanceTo(ut),Tt=tt.projectionMatrix.elements,Xt=vt.projectionMatrix.elements,se=Tt[14]/(Tt[10]-1),T=Tt[14]/(Tt[10]+1),Q=(Tt[9]+1)/Tt[5],$=(Tt[9]-1)/Tt[5],J=(Tt[8]-1)/Tt[0],Z=(Xt[8]+1)/Xt[0],ct=se*J,nt=se*Z,ht=Pt/(-J+Z),Bt=ht*-J;if(tt.matrixWorld.decompose(Y.position,Y.quaternion,Y.scale),Y.translateX(Bt),Y.translateZ(ht),Y.matrixWorld.compose(Y.position,Y.quaternion,Y.scale),Y.matrixWorldInverse.copy(Y.matrixWorld).invert(),Tt[10]===-1)Y.projectionMatrix.copy(tt.projectionMatrix),Y.projectionMatrixInverse.copy(tt.projectionMatrixInverse);else{let Ot=se+ht,b=T+ht,_=ct-Bt,F=nt+(Pt-Bt),V=Q*T/b*Ot,j=$*T/b*Ot;Y.projectionMatrix.makePerspective(_,F,V,j,Ot,b),Y.projectionMatrixInverse.copy(Y.projectionMatrix).invert()}}function Mt(Y,tt){tt===null?Y.matrixWorld.copy(Y.matrix):Y.matrixWorld.multiplyMatrices(tt.matrixWorld,Y.matrix),Y.matrixWorldInverse.copy(Y.matrixWorld).invert()}this.updateCamera=function(Y){if(s===null)return;let tt=Y.near,vt=Y.far;m.texture!==null&&(m.depthNear>0&&(tt=m.depthNear),m.depthFar>0&&(vt=m.depthFar)),O.near=M.near=S.near=tt,O.far=M.far=S.far=vt,(k!==O.near||W!==O.far)&&(s.updateRenderState({depthNear:O.near,depthFar:O.far}),k=O.near,W=O.far),O.layers.mask=Y.layers.mask|6,S.layers.mask=O.layers.mask&3,M.layers.mask=O.layers.mask&5;let Pt=Y.parent,Tt=O.cameras;Mt(O,Pt);for(let Xt=0;Xt<Tt.length;Xt++)Mt(Tt[Xt],Pt);Tt.length===2?xt(O,S,M):O.projectionMatrix.copy(S.projectionMatrix),kt(Y,O,Pt)};function kt(Y,tt,vt){vt===null?Y.matrix.copy(tt.matrixWorld):(Y.matrix.copy(vt.matrixWorld),Y.matrix.invert(),Y.matrix.multiply(tt.matrixWorld)),Y.matrix.decompose(Y.position,Y.quaternion,Y.scale),Y.updateMatrixWorld(!0),Y.projectionMatrix.copy(tt.projectionMatrix),Y.projectionMatrixInverse.copy(tt.projectionMatrixInverse),Y.isPerspectiveCamera&&(Y.fov=Vi*2*Math.atan(1/Y.projectionMatrix.elements[5]),Y.zoom=1)}this.getCamera=function(){return O},this.getFoveation=function(){if(!(f===null&&p===null))return l},this.setFoveation=function(Y){l=Y,f!==null&&(f.fixedFoveation=Y),p!==null&&p.fixedFoveation!==void 0&&(p.fixedFoveation=Y)},this.hasDepthSensing=function(){return m.texture!==null},this.getDepthSensingMesh=function(){return m.getMesh(O)},this.getCameraTexture=function(Y){return d[Y]};let Zt=null;function Qt(Y,tt){if(h=tt.getViewerPose(c||o),g=tt,h!==null){let vt=h.views;p!==null&&(t.setRenderTargetFramebuffer(v,p.framebuffer),t.setRenderTarget(v));let Pt=!1;vt.length!==O.cameras.length&&(O.cameras.length=0,Pt=!0);for(let T=0;T<vt.length;T++){let Q=vt[T],$=null;if(p!==null)$=p.getViewport(Q);else{let Z=u.getViewSubImage(f,Q);$=Z.viewport,T===0&&(t.setRenderTargetTextures(v,Z.colorTexture,Z.depthStencilTexture),t.setRenderTarget(v))}let J=R[T];J===void 0&&(J=new Oe,J.layers.enable(T),J.viewport=new pe,R[T]=J),J.matrix.fromArray(Q.transform.matrix),J.matrix.decompose(J.position,J.quaternion,J.scale),J.projectionMatrix.fromArray(Q.projectionMatrix),J.projectionMatrixInverse.copy(J.projectionMatrix).invert(),J.viewport.set($.x,$.y,$.width,$.height),T===0&&(O.matrix.copy(J.matrix),O.matrix.decompose(O.position,O.quaternion,O.scale)),Pt===!0&&O.cameras.push(J)}let Tt=s.enabledFeatures;if(Tt&&Tt.includes("depth-sensing")&&s.depthUsage=="gpu-optimized"&&y){u=n.getBinding();let T=u.getDepthInformation(vt[0]);T&&T.isValid&&T.texture&&m.init(T,s.renderState)}if(Tt&&Tt.includes("camera-access")&&y){t.state.unbindTexture(),u=n.getBinding();for(let T=0;T<vt.length;T++){let Q=vt[T].camera;if(Q){let $=d[Q];$||($=new Ds,d[Q]=$);let J=u.getCameraImage(Q);$.sourceTexture=J}}}}for(let vt=0;vt<C.length;vt++){let Pt=A[vt],Tt=C[vt];Pt!==null&&Tt!==void 0&&Tt.update(Pt,tt,c||o)}Zt&&Zt(Y,tt),tt.detectedPlanes&&n.dispatchEvent({type:"planesdetected",data:tt}),g=null}let Jt=new Gh;Jt.setAnimationLoop(Qt),this.setAnimationLoop=function(Y){Zt=Y},this.dispose=function(){}}},xi=new on,d_=new fe;function f_(i,t){function e(m,d){m.matrixAutoUpdate===!0&&m.updateMatrix(),d.value.copy(m.matrix)}function n(m,d){d.color.getRGB(m.fogColor.value,yl(i)),d.isFog?(m.fogNear.value=d.near,m.fogFar.value=d.far):d.isFogExp2&&(m.fogDensity.value=d.density)}function s(m,d,w,E,v){d.isMeshBasicMaterial||d.isMeshLambertMaterial?r(m,d):d.isMeshToonMaterial?(r(m,d),u(m,d)):d.isMeshPhongMaterial?(r(m,d),h(m,d)):d.isMeshStandardMaterial?(r(m,d),f(m,d),d.isMeshPhysicalMaterial&&p(m,d,v)):d.isMeshMatcapMaterial?(r(m,d),g(m,d)):d.isMeshDepthMaterial?r(m,d):d.isMeshDistanceMaterial?(r(m,d),y(m,d)):d.isMeshNormalMaterial?r(m,d):d.isLineBasicMaterial?(o(m,d),d.isLineDashedMaterial&&a(m,d)):d.isPointsMaterial?l(m,d,w,E):d.isSpriteMaterial?c(m,d):d.isShadowMaterial?(m.color.value.copy(d.color),m.opacity.value=d.opacity):d.isShaderMaterial&&(d.uniformsNeedUpdate=!1)}function r(m,d){m.opacity.value=d.opacity,d.color&&m.diffuse.value.copy(d.color),d.emissive&&m.emissive.value.copy(d.emissive).multiplyScalar(d.emissiveIntensity),d.map&&(m.map.value=d.map,e(d.map,m.mapTransform)),d.alphaMap&&(m.alphaMap.value=d.alphaMap,e(d.alphaMap,m.alphaMapTransform)),d.bumpMap&&(m.bumpMap.value=d.bumpMap,e(d.bumpMap,m.bumpMapTransform),m.bumpScale.value=d.bumpScale,d.side===Ue&&(m.bumpScale.value*=-1)),d.normalMap&&(m.normalMap.value=d.normalMap,e(d.normalMap,m.normalMapTransform),m.normalScale.value.copy(d.normalScale),d.side===Ue&&m.normalScale.value.negate()),d.displacementMap&&(m.displacementMap.value=d.displacementMap,e(d.displacementMap,m.displacementMapTransform),m.displacementScale.value=d.displacementScale,m.displacementBias.value=d.displacementBias),d.emissiveMap&&(m.emissiveMap.value=d.emissiveMap,e(d.emissiveMap,m.emissiveMapTransform)),d.specularMap&&(m.specularMap.value=d.specularMap,e(d.specularMap,m.specularMapTransform)),d.alphaTest>0&&(m.alphaTest.value=d.alphaTest);let w=t.get(d),E=w.envMap,v=w.envMapRotation;E&&(m.envMap.value=E,xi.copy(v),xi.x*=-1,xi.y*=-1,xi.z*=-1,E.isCubeTexture&&E.isRenderTargetTexture===!1&&(xi.y*=-1,xi.z*=-1),m.envMapRotation.value.setFromMatrix4(d_.makeRotationFromEuler(xi)),m.flipEnvMap.value=E.isCubeTexture&&E.isRenderTargetTexture===!1?-1:1,m.reflectivity.value=d.reflectivity,m.ior.value=d.ior,m.refractionRatio.value=d.refractionRatio),d.lightMap&&(m.lightMap.value=d.lightMap,m.lightMapIntensity.value=d.lightMapIntensity,e(d.lightMap,m.lightMapTransform)),d.aoMap&&(m.aoMap.value=d.aoMap,m.aoMapIntensity.value=d.aoMapIntensity,e(d.aoMap,m.aoMapTransform))}function o(m,d){m.diffuse.value.copy(d.color),m.opacity.value=d.opacity,d.map&&(m.map.value=d.map,e(d.map,m.mapTransform))}function a(m,d){m.dashSize.value=d.dashSize,m.totalSize.value=d.dashSize+d.gapSize,m.scale.value=d.scale}function l(m,d,w,E){m.diffuse.value.copy(d.color),m.opacity.value=d.opacity,m.size.value=d.size*w,m.scale.value=E*.5,d.map&&(m.map.value=d.map,e(d.map,m.uvTransform)),d.alphaMap&&(m.alphaMap.value=d.alphaMap,e(d.alphaMap,m.alphaMapTransform)),d.alphaTest>0&&(m.alphaTest.value=d.alphaTest)}function c(m,d){m.diffuse.value.copy(d.color),m.opacity.value=d.opacity,m.rotation.value=d.rotation,d.map&&(m.map.value=d.map,e(d.map,m.mapTransform)),d.alphaMap&&(m.alphaMap.value=d.alphaMap,e(d.alphaMap,m.alphaMapTransform)),d.alphaTest>0&&(m.alphaTest.value=d.alphaTest)}function h(m,d){m.specular.value.copy(d.specular),m.shininess.value=Math.max(d.shininess,1e-4)}function u(m,d){d.gradientMap&&(m.gradientMap.value=d.gradientMap)}function f(m,d){m.metalness.value=d.metalness,d.metalnessMap&&(m.metalnessMap.value=d.metalnessMap,e(d.metalnessMap,m.metalnessMapTransform)),m.roughness.value=d.roughness,d.roughnessMap&&(m.roughnessMap.value=d.roughnessMap,e(d.roughnessMap,m.roughnessMapTransform)),d.envMap&&(m.envMapIntensity.value=d.envMapIntensity)}function p(m,d,w){m.ior.value=d.ior,d.sheen>0&&(m.sheenColor.value.copy(d.sheenColor).multiplyScalar(d.sheen),m.sheenRoughness.value=d.sheenRoughness,d.sheenColorMap&&(m.sheenColorMap.value=d.sheenColorMap,e(d.sheenColorMap,m.sheenColorMapTransform)),d.sheenRoughnessMap&&(m.sheenRoughnessMap.value=d.sheenRoughnessMap,e(d.sheenRoughnessMap,m.sheenRoughnessMapTransform))),d.clearcoat>0&&(m.clearcoat.value=d.clearcoat,m.clearcoatRoughness.value=d.clearcoatRoughness,d.clearcoatMap&&(m.clearcoatMap.value=d.clearcoatMap,e(d.clearcoatMap,m.clearcoatMapTransform)),d.clearcoatRoughnessMap&&(m.clearcoatRoughnessMap.value=d.clearcoatRoughnessMap,e(d.clearcoatRoughnessMap,m.clearcoatRoughnessMapTransform)),d.clearcoatNormalMap&&(m.clearcoatNormalMap.value=d.clearcoatNormalMap,e(d.clearcoatNormalMap,m.clearcoatNormalMapTransform),m.clearcoatNormalScale.value.copy(d.clearcoatNormalScale),d.side===Ue&&m.clearcoatNormalScale.value.negate())),d.dispersion>0&&(m.dispersion.value=d.dispersion),d.iridescence>0&&(m.iridescence.value=d.iridescence,m.iridescenceIOR.value=d.iridescenceIOR,m.iridescenceThicknessMinimum.value=d.iridescenceThicknessRange[0],m.iridescenceThicknessMaximum.value=d.iridescenceThicknessRange[1],d.iridescenceMap&&(m.iridescenceMap.value=d.iridescenceMap,e(d.iridescenceMap,m.iridescenceMapTransform)),d.iridescenceThicknessMap&&(m.iridescenceThicknessMap.value=d.iridescenceThicknessMap,e(d.iridescenceThicknessMap,m.iridescenceThicknessMapTransform))),d.transmission>0&&(m.transmission.value=d.transmission,m.transmissionSamplerMap.value=w.texture,m.transmissionSamplerSize.value.set(w.width,w.height),d.transmissionMap&&(m.transmissionMap.value=d.transmissionMap,e(d.transmissionMap,m.transmissionMapTransform)),m.thickness.value=d.thickness,d.thicknessMap&&(m.thicknessMap.value=d.thicknessMap,e(d.thicknessMap,m.thicknessMapTransform)),m.attenuationDistance.value=d.attenuationDistance,m.attenuationColor.value.copy(d.attenuationColor)),d.anisotropy>0&&(m.anisotropyVector.value.set(d.anisotropy*Math.cos(d.anisotropyRotation),d.anisotropy*Math.sin(d.anisotropyRotation)),d.anisotropyMap&&(m.anisotropyMap.value=d.anisotropyMap,e(d.anisotropyMap,m.anisotropyMapTransform))),m.specularIntensity.value=d.specularIntensity,m.specularColor.value.copy(d.specularColor),d.specularColorMap&&(m.specularColorMap.value=d.specularColorMap,e(d.specularColorMap,m.specularColorMapTransform)),d.specularIntensityMap&&(m.specularIntensityMap.value=d.specularIntensityMap,e(d.specularIntensityMap,m.specularIntensityMapTransform))}function g(m,d){d.matcap&&(m.matcap.value=d.matcap)}function y(m,d){let w=t.get(d).light;m.referencePosition.value.setFromMatrixPosition(w.matrixWorld),m.nearDistance.value=w.shadow.camera.near,m.farDistance.value=w.shadow.camera.far}return{refreshFogUniforms:n,refreshMaterialUniforms:s}}function p_(i,t,e,n){let s={},r={},o=[],a=i.getParameter(i.MAX_UNIFORM_BUFFER_BINDINGS);function l(w,E){let v=E.program;n.uniformBlockBinding(w,v)}function c(w,E){let v=s[w.id];v===void 0&&(g(w),v=h(w),s[w.id]=v,w.addEventListener("dispose",m));let C=E.program;n.updateUBOMapping(w,C);let A=t.render.frame;r[w.id]!==A&&(f(w),r[w.id]=A)}function h(w){let E=u();w.__bindingPointIndex=E;let v=i.createBuffer(),C=w.__size,A=w.usage;return i.bindBuffer(i.UNIFORM_BUFFER,v),i.bufferData(i.UNIFORM_BUFFER,C,A),i.bindBuffer(i.UNIFORM_BUFFER,null),i.bindBufferBase(i.UNIFORM_BUFFER,E,v),v}function u(){for(let w=0;w<a;w++)if(o.indexOf(w)===-1)return o.push(w),w;return console.error("THREE.WebGLRenderer: Maximum number of simultaneously usable uniforms groups reached."),0}function f(w){let E=s[w.id],v=w.uniforms,C=w.__cache;i.bindBuffer(i.UNIFORM_BUFFER,E);for(let A=0,I=v.length;A<I;A++){let U=Array.isArray(v[A])?v[A]:[v[A]];for(let S=0,M=U.length;S<M;S++){let R=U[S];if(p(R,A,S,C)===!0){let O=R.__offset,k=Array.isArray(R.value)?R.value:[R.value],W=0;for(let q=0;q<k.length;q++){let G=k[q],et=y(G);typeof G=="number"||typeof G=="boolean"?(R.__data[0]=G,i.bufferSubData(i.UNIFORM_BUFFER,O+W,R.__data)):G.isMatrix3?(R.__data[0]=G.elements[0],R.__data[1]=G.elements[1],R.__data[2]=G.elements[2],R.__data[3]=0,R.__data[4]=G.elements[3],R.__data[5]=G.elements[4],R.__data[6]=G.elements[5],R.__data[7]=0,R.__data[8]=G.elements[6],R.__data[9]=G.elements[7],R.__data[10]=G.elements[8],R.__data[11]=0):(G.toArray(R.__data,W),W+=et.storage/Float32Array.BYTES_PER_ELEMENT)}i.bufferSubData(i.UNIFORM_BUFFER,O,R.__data)}}}i.bindBuffer(i.UNIFORM_BUFFER,null)}function p(w,E,v,C){let A=w.value,I=E+"_"+v;if(C[I]===void 0)return typeof A=="number"||typeof A=="boolean"?C[I]=A:C[I]=A.clone(),!0;{let U=C[I];if(typeof A=="number"||typeof A=="boolean"){if(U!==A)return C[I]=A,!0}else if(U.equals(A)===!1)return U.copy(A),!0}return!1}function g(w){let E=w.uniforms,v=0,C=16;for(let I=0,U=E.length;I<U;I++){let S=Array.isArray(E[I])?E[I]:[E[I]];for(let M=0,R=S.length;M<R;M++){let O=S[M],k=Array.isArray(O.value)?O.value:[O.value];for(let W=0,q=k.length;W<q;W++){let G=k[W],et=y(G),H=v%C,ut=H%et.boundary,xt=H+ut;v+=ut,xt!==0&&C-xt<et.storage&&(v+=C-xt),O.__data=new Float32Array(et.storage/Float32Array.BYTES_PER_ELEMENT),O.__offset=v,v+=et.storage}}}let A=v%C;return A>0&&(v+=C-A),w.__size=v,w.__cache={},this}function y(w){let E={boundary:0,storage:0};return typeof w=="number"||typeof w=="boolean"?(E.boundary=4,E.storage=4):w.isVector2?(E.boundary=8,E.storage=8):w.isVector3||w.isColor?(E.boundary=16,E.storage=12):w.isVector4?(E.boundary=16,E.storage=16):w.isMatrix3?(E.boundary=48,E.storage=48):w.isMatrix4?(E.boundary=64,E.storage=64):w.isTexture?console.warn("THREE.WebGLRenderer: Texture samplers can not be part of an uniforms group."):console.warn("THREE.WebGLRenderer: Unsupported uniform value type.",w),E}function m(w){let E=w.target;E.removeEventListener("dispose",m);let v=o.indexOf(E.__bindingPointIndex);o.splice(v,1),i.deleteBuffer(s[E.id]),delete s[E.id],delete r[E.id]}function d(){for(let w in s)i.deleteBuffer(s[w]);o=[],s={},r={}}return{bind:l,update:c,dispose:d}}var sa=class{constructor(t={}){let{canvas:e=uh(),context:n=null,depth:s=!0,stencil:r=!1,alpha:o=!1,antialias:a=!1,premultipliedAlpha:l=!0,preserveDrawingBuffer:c=!1,powerPreference:h="default",failIfMajorPerformanceCaveat:u=!1,reversedDepthBuffer:f=!1}=t;this.isWebGLRenderer=!0;let p;if(n!==null){if(typeof WebGLRenderingContext<"u"&&n instanceof WebGLRenderingContext)throw new Error("THREE.WebGLRenderer: WebGL 1 is not supported since r163.");p=n.getContextAttributes().alpha}else p=o;let g=new Uint32Array(4),y=new Int32Array(4),m=null,d=null,w=[],E=[];this.domElement=e,this.debug={checkShaderErrors:!0,onShaderError:null},this.autoClear=!0,this.autoClearColor=!0,this.autoClearDepth=!0,this.autoClearStencil=!0,this.sortObjects=!0,this.clippingPlanes=[],this.localClippingEnabled=!1,this.toneMapping=Rn,this.toneMappingExposure=1,this.transmissionResolutionScale=1;let v=this,C=!1;this._outputColorSpace=Le;let A=0,I=0,U=null,S=-1,M=null,R=new pe,O=new pe,k=null,W=new Yt(0),q=0,G=e.width,et=e.height,H=1,ut=null,xt=null,Mt=new pe(0,0,G,et),kt=new pe(0,0,G,et),Zt=!1,Qt=new Zi,Jt=!1,Y=!1,tt=new fe,vt=new D,Pt=new pe,Tt={background:null,fog:null,environment:null,overrideMaterial:null,isScene:!0},Xt=!1;function se(){return U===null?H:1}let T=n;function Q(x,L){return e.getContext(x,L)}try{let x={alpha:!0,depth:s,stencil:r,antialias:a,premultipliedAlpha:l,preserveDrawingBuffer:c,powerPreference:h,failIfMajorPerformanceCaveat:u};if("setAttribute"in e&&e.setAttribute("data-engine",`three.js r${"180"}`),e.addEventListener("webglcontextlost",dt,!1),e.addEventListener("webglcontextrestored",St,!1),e.addEventListener("webglcontextcreationerror",st,!1),T===null){let L="webgl2";if(T=Q(L,x),T===null)throw Q(L)?new Error("Error creating WebGL context with your selected attributes."):new Error("Error creating WebGL context.")}}catch(x){throw console.error("THREE.WebGLRenderer: "+x.message),x}let $,J,Z,ct,nt,ht,Bt,Ot,b,_,F,V,j,X,Rt,lt,wt,At,it,_t,Nt,It,mt,Ht;function P(){$=new Dm(T),$.init(),It=new c_(T,$),J=new Tm(T,$,t,It),Z=new a_(T,$),J.reversedDepthBuffer&&f&&Z.buffers.depth.setReversed(!0),ct=new Nm(T),nt=new Zg,ht=new l_(T,$,Z,nt,J,It,ct),Bt=new Am(v),Ot=new Pm(v),b=new kd(T),mt=new bm(T,b),_=new Lm(T,b,ct,mt),F=new Om(T,_,b,ct),it=new Fm(T,J,ht),lt=new wm(nt),V=new Yg(v,Bt,Ot,$,J,mt,lt),j=new f_(v,nt),X=new $g,Rt=new n_($),At=new Sm(v,Bt,Ot,Z,F,p,l),wt=new r_(v,F,J),Ht=new p_(T,ct,J,Z),_t=new Em(T,$,ct),Nt=new Um(T,$,ct),ct.programs=V.programs,v.capabilities=J,v.extensions=$,v.properties=nt,v.renderLists=X,v.shadowMap=wt,v.state=Z,v.info=ct}P();let ot=new Ol(v,T);this.xr=ot,this.getContext=function(){return T},this.getContextAttributes=function(){return T.getContextAttributes()},this.forceContextLoss=function(){let x=$.get("WEBGL_lose_context");x&&x.loseContext()},this.forceContextRestore=function(){let x=$.get("WEBGL_lose_context");x&&x.restoreContext()},this.getPixelRatio=function(){return H},this.setPixelRatio=function(x){x!==void 0&&(H=x,this.setSize(G,et,!1))},this.getSize=function(x){return x.set(G,et)},this.setSize=function(x,L,B=!0){if(ot.isPresenting){console.warn("THREE.WebGLRenderer: Can't change size while VR device is presenting.");return}G=x,et=L,e.width=Math.floor(x*H),e.height=Math.floor(L*H),B===!0&&(e.style.width=x+"px",e.style.height=L+"px"),this.setViewport(0,0,x,L)},this.getDrawingBufferSize=function(x){return x.set(G*H,et*H).floor()},this.setDrawingBufferSize=function(x,L,B){G=x,et=L,H=B,e.width=Math.floor(x*B),e.height=Math.floor(L*B),this.setViewport(0,0,x,L)},this.getCurrentViewport=function(x){return x.copy(R)},this.getViewport=function(x){return x.copy(Mt)},this.setViewport=function(x,L,B,z){x.isVector4?Mt.set(x.x,x.y,x.z,x.w):Mt.set(x,L,B,z),Z.viewport(R.copy(Mt).multiplyScalar(H).round())},this.getScissor=function(x){return x.copy(kt)},this.setScissor=function(x,L,B,z){x.isVector4?kt.set(x.x,x.y,x.z,x.w):kt.set(x,L,B,z),Z.scissor(O.copy(kt).multiplyScalar(H).round())},this.getScissorTest=function(){return Zt},this.setScissorTest=function(x){Z.setScissorTest(Zt=x)},this.setOpaqueSort=function(x){ut=x},this.setTransparentSort=function(x){xt=x},this.getClearColor=function(x){return x.copy(At.getClearColor())},this.setClearColor=function(){At.setClearColor(...arguments)},this.getClearAlpha=function(){return At.getClearAlpha()},this.setClearAlpha=function(){At.setClearAlpha(...arguments)},this.clear=function(x=!0,L=!0,B=!0){let z=0;if(x){let N=!1;if(U!==null){let rt=U.texture.format;N=rt===To||rt===Eo||rt===bo}if(N){let rt=U.texture.type,gt=rt===cn||rt===$n||rt===ts||rt===ns||rt===Mo||rt===So,Et=At.getClearColor(),yt=At.getClearAlpha(),Ut=Et.r,Ft=Et.g,Dt=Et.b;gt?(g[0]=Ut,g[1]=Ft,g[2]=Dt,g[3]=yt,T.clearBufferuiv(T.COLOR,0,g)):(y[0]=Ut,y[1]=Ft,y[2]=Dt,y[3]=yt,T.clearBufferiv(T.COLOR,0,y))}else z|=T.COLOR_BUFFER_BIT}L&&(z|=T.DEPTH_BUFFER_BIT),B&&(z|=T.STENCIL_BUFFER_BIT,this.state.buffers.stencil.setMask(4294967295)),T.clear(z)},this.clearColor=function(){this.clear(!0,!1,!1)},this.clearDepth=function(){this.clear(!1,!0,!1)},this.clearStencil=function(){this.clear(!1,!1,!0)},this.dispose=function(){e.removeEventListener("webglcontextlost",dt,!1),e.removeEventListener("webglcontextrestored",St,!1),e.removeEventListener("webglcontextcreationerror",st,!1),At.dispose(),X.dispose(),Rt.dispose(),nt.dispose(),Bt.dispose(),Ot.dispose(),F.dispose(),mt.dispose(),Ht.dispose(),V.dispose(),ot.dispose(),ot.removeEventListener("sessionstart",dn),ot.removeEventListener("sessionend",Zl),jn.stop()};function dt(x){x.preventDefault(),console.log("THREE.WebGLRenderer: Context Lost."),C=!0}function St(){console.log("THREE.WebGLRenderer: Context Restored."),C=!1;let x=ct.autoReset,L=wt.enabled,B=wt.autoUpdate,z=wt.needsUpdate,N=wt.type;P(),ct.autoReset=x,wt.enabled=L,wt.autoUpdate=B,wt.needsUpdate=z,wt.type=N}function st(x){console.error("THREE.WebGLRenderer: A WebGL context could not be created. Reason: ",x.statusMessage)}function K(x){let L=x.target;L.removeEventListener("dispose",K),Ct(L)}function Ct(x){zt(x),nt.remove(x)}function zt(x){let L=nt.get(x).programs;L!==void 0&&(L.forEach(function(B){V.releaseProgram(B)}),x.isShaderMaterial&&V.releaseShaderCache(x))}this.renderBufferDirect=function(x,L,B,z,N,rt){L===null&&(L=Tt);let gt=N.isMesh&&N.matrixWorld.determinant()<0,Et=fu(x,L,B,z,N);Z.setMaterial(z,gt);let yt=B.index,Ut=1;if(z.wireframe===!0){if(yt=_.getWireframeAttribute(B),yt===void 0)return;Ut=2}let Ft=B.drawRange,Dt=B.attributes.position,qt=Ft.start*Ut,ee=(Ft.start+Ft.count)*Ut;rt!==null&&(qt=Math.max(qt,rt.start*Ut),ee=Math.min(ee,(rt.start+rt.count)*Ut)),yt!==null?(qt=Math.max(qt,0),ee=Math.min(ee,yt.count)):Dt!=null&&(qt=Math.max(qt,0),ee=Math.min(ee,Dt.count));let me=ee-qt;if(me<0||me===1/0)return;mt.setup(N,z,Et,B,yt);let oe,ie=_t;if(yt!==null&&(oe=b.get(yt),ie=Nt,ie.setIndex(oe)),N.isMesh)z.wireframe===!0?(Z.setLineWidth(z.wireframeLinewidth*se()),ie.setMode(T.LINES)):ie.setMode(T.TRIANGLES);else if(N.isLine){let Lt=z.linewidth;Lt===void 0&&(Lt=1),Z.setLineWidth(Lt*se()),N.isLineSegments?ie.setMode(T.LINES):N.isLineLoop?ie.setMode(T.LINE_LOOP):ie.setMode(T.LINE_STRIP)}else N.isPoints?ie.setMode(T.POINTS):N.isSprite&&ie.setMode(T.TRIANGLES);if(N.isBatchedMesh)if(N._multiDrawInstances!==null)Hi("THREE.WebGLRenderer: renderMultiDrawInstances has been deprecated and will be removed in r184. Append to renderMultiDraw arguments and use indirection."),ie.renderMultiDrawInstances(N._multiDrawStarts,N._multiDrawCounts,N._multiDrawCount,N._multiDrawInstances);else if($.get("WEBGL_multi_draw"))ie.renderMultiDraw(N._multiDrawStarts,N._multiDrawCounts,N._multiDrawCount);else{let Lt=N._multiDrawStarts,he=N._multiDrawCounts,Kt=N._multiDrawCount,ze=yt?b.get(yt).bytesPerElement:1,Ti=nt.get(z).currentProgram.getUniforms();for(let ke=0;ke<Kt;ke++)Ti.setValue(T,"_gl_DrawID",ke),ie.render(Lt[ke]/ze,he[ke])}else if(N.isInstancedMesh)ie.renderInstances(qt,me,N.count);else if(B.isInstancedBufferGeometry){let Lt=B._maxInstanceCount!==void 0?B._maxInstanceCount:1/0,he=Math.min(B.instanceCount,Lt);ie.renderInstances(qt,me,he)}else ie.render(qt,me)};function re(x,L,B){x.transparent===!0&&x.side===gn&&x.forceSinglePass===!1?(x.side=Ue,x.needsUpdate=!0,hr(x,L,B),x.side=An,x.needsUpdate=!0,hr(x,L,B),x.side=gn):hr(x,L,B)}this.compile=function(x,L,B=null){B===null&&(B=x),d=Rt.get(B),d.init(L),E.push(d),B.traverseVisible(function(N){N.isLight&&N.layers.test(L.layers)&&(d.pushLight(N),N.castShadow&&d.pushShadow(N))}),x!==B&&x.traverseVisible(function(N){N.isLight&&N.layers.test(L.layers)&&(d.pushLight(N),N.castShadow&&d.pushShadow(N))}),d.setupLights();let z=new Set;return x.traverse(function(N){if(!(N.isMesh||N.isPoints||N.isLine||N.isSprite))return;let rt=N.material;if(rt)if(Array.isArray(rt))for(let gt=0;gt<rt.length;gt++){let Et=rt[gt];re(Et,B,N),z.add(Et)}else re(rt,B,N),z.add(rt)}),d=E.pop(),z},this.compileAsync=function(x,L,B=null){let z=this.compile(x,L,B);return new Promise(N=>{function rt(){if(z.forEach(function(gt){nt.get(gt).currentProgram.isReady()&&z.delete(gt)}),z.size===0){N(x);return}setTimeout(rt,10)}$.get("KHR_parallel_shader_compile")!==null?rt():setTimeout(rt,10)})};let jt=null;function vn(x){jt&&jt(x)}function dn(){jn.stop()}function Zl(){jn.start()}let jn=new Gh;jn.setAnimationLoop(vn),typeof self<"u"&&jn.setContext(self),this.setAnimationLoop=function(x){jt=x,ot.setAnimationLoop(x),x===null?jn.stop():jn.start()},ot.addEventListener("sessionstart",dn),ot.addEventListener("sessionend",Zl),this.render=function(x,L){if(L!==void 0&&L.isCamera!==!0){console.error("THREE.WebGLRenderer.render: camera is not an instance of THREE.Camera.");return}if(C===!0)return;if(x.matrixWorldAutoUpdate===!0&&x.updateMatrixWorld(),L.parent===null&&L.matrixWorldAutoUpdate===!0&&L.updateMatrixWorld(),ot.enabled===!0&&ot.isPresenting===!0&&(ot.cameraAutoUpdate===!0&&ot.updateCamera(L),L=ot.getCamera()),x.isScene===!0&&x.onBeforeRender(v,x,L,U),d=Rt.get(x,E.length),d.init(L),E.push(d),tt.multiplyMatrices(L.projectionMatrix,L.matrixWorldInverse),Qt.setFromProjectionMatrix(tt,sn,L.reversedDepth),Y=this.localClippingEnabled,Jt=lt.init(this.clippingPlanes,Y),m=X.get(x,w.length),m.init(),w.push(m),ot.enabled===!0&&ot.isPresenting===!0){let rt=v.xr.getDepthSensingMesh();rt!==null&&da(rt,L,-1/0,v.sortObjects)}da(x,L,0,v.sortObjects),m.finish(),v.sortObjects===!0&&m.sort(ut,xt),Xt=ot.enabled===!1||ot.isPresenting===!1||ot.hasDepthSensing()===!1,Xt&&At.addToRenderList(m,x),this.info.render.frame++,Jt===!0&&lt.beginShadows();let B=d.state.shadowsArray;wt.render(B,x,L),Jt===!0&&lt.endShadows(),this.info.autoReset===!0&&this.info.reset();let z=m.opaque,N=m.transmissive;if(d.setupLights(),L.isArrayCamera){let rt=L.cameras;if(N.length>0)for(let gt=0,Et=rt.length;gt<Et;gt++){let yt=rt[gt];$l(z,N,x,yt)}Xt&&At.render(x);for(let gt=0,Et=rt.length;gt<Et;gt++){let yt=rt[gt];Jl(m,x,yt,yt.viewport)}}else N.length>0&&$l(z,N,x,L),Xt&&At.render(x),Jl(m,x,L);U!==null&&I===0&&(ht.updateMultisampleRenderTarget(U),ht.updateRenderTargetMipmap(U)),x.isScene===!0&&x.onAfterRender(v,x,L),mt.resetDefaultState(),S=-1,M=null,E.pop(),E.length>0?(d=E[E.length-1],Jt===!0&&lt.setGlobalState(v.clippingPlanes,d.state.camera)):d=null,w.pop(),w.length>0?m=w[w.length-1]:m=null};function da(x,L,B,z){if(x.visible===!1)return;if(x.layers.test(L.layers)){if(x.isGroup)B=x.renderOrder;else if(x.isLOD)x.autoUpdate===!0&&x.update(L);else if(x.isLight)d.pushLight(x),x.castShadow&&d.pushShadow(x);else if(x.isSprite){if(!x.frustumCulled||Qt.intersectsSprite(x)){z&&Pt.setFromMatrixPosition(x.matrixWorld).applyMatrix4(tt);let gt=F.update(x),Et=x.material;Et.visible&&m.push(x,gt,Et,B,Pt.z,null)}}else if((x.isMesh||x.isLine||x.isPoints)&&(!x.frustumCulled||Qt.intersectsObject(x))){let gt=F.update(x),Et=x.material;if(z&&(x.boundingSphere!==void 0?(x.boundingSphere===null&&x.computeBoundingSphere(),Pt.copy(x.boundingSphere.center)):(gt.boundingSphere===null&&gt.computeBoundingSphere(),Pt.copy(gt.boundingSphere.center)),Pt.applyMatrix4(x.matrixWorld).applyMatrix4(tt)),Array.isArray(Et)){let yt=gt.groups;for(let Ut=0,Ft=yt.length;Ut<Ft;Ut++){let Dt=yt[Ut],qt=Et[Dt.materialIndex];qt&&qt.visible&&m.push(x,gt,qt,B,Pt.z,Dt)}}else Et.visible&&m.push(x,gt,Et,B,Pt.z,null)}}let rt=x.children;for(let gt=0,Et=rt.length;gt<Et;gt++)da(rt[gt],L,B,z)}function Jl(x,L,B,z){let N=x.opaque,rt=x.transmissive,gt=x.transparent;d.setupLightsView(B),Jt===!0&&lt.setGlobalState(v.clippingPlanes,B),z&&Z.viewport(R.copy(z)),N.length>0&&cr(N,L,B),rt.length>0&&cr(rt,L,B),gt.length>0&&cr(gt,L,B),Z.buffers.depth.setTest(!0),Z.buffers.depth.setMask(!0),Z.buffers.color.setMask(!0),Z.setPolygonOffset(!1)}function $l(x,L,B,z){if((B.isScene===!0?B.overrideMaterial:null)!==null)return;d.state.transmissionRenderTarget[z.id]===void 0&&(d.state.transmissionRenderTarget[z.id]=new pn(1,1,{generateMipmaps:!0,type:$.has("EXT_color_buffer_half_float")||$.has("EXT_color_buffer_float")?es:cn,minFilter:Jn,samples:4,stencilBuffer:r,resolveDepthBuffer:!1,resolveStencilBuffer:!1,colorSpace:$t.workingColorSpace}));let rt=d.state.transmissionRenderTarget[z.id],gt=z.viewport||R;rt.setSize(gt.z*v.transmissionResolutionScale,gt.w*v.transmissionResolutionScale);let Et=v.getRenderTarget(),yt=v.getActiveCubeFace(),Ut=v.getActiveMipmapLevel();v.setRenderTarget(rt),v.getClearColor(W),q=v.getClearAlpha(),q<1&&v.setClearColor(16777215,.5),v.clear(),Xt&&At.render(B);let Ft=v.toneMapping;v.toneMapping=Rn;let Dt=z.viewport;if(z.viewport!==void 0&&(z.viewport=void 0),d.setupLightsView(z),Jt===!0&&lt.setGlobalState(v.clippingPlanes,z),cr(x,B,z),ht.updateMultisampleRenderTarget(rt),ht.updateRenderTargetMipmap(rt),$.has("WEBGL_multisampled_render_to_texture")===!1){let qt=!1;for(let ee=0,me=L.length;ee<me;ee++){let oe=L[ee],ie=oe.object,Lt=oe.geometry,he=oe.material,Kt=oe.group;if(he.side===gn&&ie.layers.test(z.layers)){let ze=he.side;he.side=Ue,he.needsUpdate=!0,Kl(ie,B,z,Lt,he,Kt),he.side=ze,he.needsUpdate=!0,qt=!0}}qt===!0&&(ht.updateMultisampleRenderTarget(rt),ht.updateRenderTargetMipmap(rt))}v.setRenderTarget(Et,yt,Ut),v.setClearColor(W,q),Dt!==void 0&&(z.viewport=Dt),v.toneMapping=Ft}function cr(x,L,B){let z=L.isScene===!0?L.overrideMaterial:null;for(let N=0,rt=x.length;N<rt;N++){let gt=x[N],Et=gt.object,yt=gt.geometry,Ut=gt.group,Ft=gt.material;Ft.allowOverride===!0&&z!==null&&(Ft=z),Et.layers.test(B.layers)&&Kl(Et,L,B,yt,Ft,Ut)}}function Kl(x,L,B,z,N,rt){x.onBeforeRender(v,L,B,z,N,rt),x.modelViewMatrix.multiplyMatrices(B.matrixWorldInverse,x.matrixWorld),x.normalMatrix.getNormalMatrix(x.modelViewMatrix),N.onBeforeRender(v,L,B,z,x,rt),N.transparent===!0&&N.side===gn&&N.forceSinglePass===!1?(N.side=Ue,N.needsUpdate=!0,v.renderBufferDirect(B,L,z,N,x,rt),N.side=An,N.needsUpdate=!0,v.renderBufferDirect(B,L,z,N,x,rt),N.side=gn):v.renderBufferDirect(B,L,z,N,x,rt),x.onAfterRender(v,L,B,z,N,rt)}function hr(x,L,B){L.isScene!==!0&&(L=Tt);let z=nt.get(x),N=d.state.lights,rt=d.state.shadowsArray,gt=N.state.version,Et=V.getParameters(x,N.state,rt,L,B),yt=V.getProgramCacheKey(Et),Ut=z.programs;z.environment=x.isMeshStandardMaterial?L.environment:null,z.fog=L.fog,z.envMap=(x.isMeshStandardMaterial?Ot:Bt).get(x.envMap||z.environment),z.envMapRotation=z.environment!==null&&x.envMap===null?L.environmentRotation:x.envMapRotation,Ut===void 0&&(x.addEventListener("dispose",K),Ut=new Map,z.programs=Ut);let Ft=Ut.get(yt);if(Ft!==void 0){if(z.currentProgram===Ft&&z.lightsStateVersion===gt)return Ql(x,Et),Ft}else Et.uniforms=V.getUniforms(x),x.onBeforeCompile(Et,v),Ft=V.acquireProgram(Et,yt),Ut.set(yt,Ft),z.uniforms=Et.uniforms;let Dt=z.uniforms;return(!x.isShaderMaterial&&!x.isRawShaderMaterial||x.clipping===!0)&&(Dt.clippingPlanes=lt.uniform),Ql(x,Et),z.needsLights=mu(x),z.lightsStateVersion=gt,z.needsLights&&(Dt.ambientLightColor.value=N.state.ambient,Dt.lightProbe.value=N.state.probe,Dt.directionalLights.value=N.state.directional,Dt.directionalLightShadows.value=N.state.directionalShadow,Dt.spotLights.value=N.state.spot,Dt.spotLightShadows.value=N.state.spotShadow,Dt.rectAreaLights.value=N.state.rectArea,Dt.ltc_1.value=N.state.rectAreaLTC1,Dt.ltc_2.value=N.state.rectAreaLTC2,Dt.pointLights.value=N.state.point,Dt.pointLightShadows.value=N.state.pointShadow,Dt.hemisphereLights.value=N.state.hemi,Dt.directionalShadowMap.value=N.state.directionalShadowMap,Dt.directionalShadowMatrix.value=N.state.directionalShadowMatrix,Dt.spotShadowMap.value=N.state.spotShadowMap,Dt.spotLightMatrix.value=N.state.spotLightMatrix,Dt.spotLightMap.value=N.state.spotLightMap,Dt.pointShadowMap.value=N.state.pointShadowMap,Dt.pointShadowMatrix.value=N.state.pointShadowMatrix),z.currentProgram=Ft,z.uniformsList=null,Ft}function jl(x){if(x.uniformsList===null){let L=x.currentProgram.getUniforms();x.uniformsList=os.seqWithValue(L.seq,x.uniforms)}return x.uniformsList}function Ql(x,L){let B=nt.get(x);B.outputColorSpace=L.outputColorSpace,B.batching=L.batching,B.batchingColor=L.batchingColor,B.instancing=L.instancing,B.instancingColor=L.instancingColor,B.instancingMorph=L.instancingMorph,B.skinning=L.skinning,B.morphTargets=L.morphTargets,B.morphNormals=L.morphNormals,B.morphColors=L.morphColors,B.morphTargetsCount=L.morphTargetsCount,B.numClippingPlanes=L.numClippingPlanes,B.numIntersection=L.numClipIntersection,B.vertexAlphas=L.vertexAlphas,B.vertexTangents=L.vertexTangents,B.toneMapping=L.toneMapping}function fu(x,L,B,z,N){L.isScene!==!0&&(L=Tt),ht.resetTextureUnits();let rt=L.fog,gt=z.isMeshStandardMaterial?L.environment:null,Et=U===null?v.outputColorSpace:U.isXRRenderTarget===!0?U.texture.colorSpace:li,yt=(z.isMeshStandardMaterial?Ot:Bt).get(z.envMap||gt),Ut=z.vertexColors===!0&&!!B.attributes.color&&B.attributes.color.itemSize===4,Ft=!!B.attributes.tangent&&(!!z.normalMap||z.anisotropy>0),Dt=!!B.morphAttributes.position,qt=!!B.morphAttributes.normal,ee=!!B.morphAttributes.color,me=Rn;z.toneMapped&&(U===null||U.isXRRenderTarget===!0)&&(me=v.toneMapping);let oe=B.morphAttributes.position||B.morphAttributes.normal||B.morphAttributes.color,ie=oe!==void 0?oe.length:0,Lt=nt.get(z),he=d.state.lights;if(Jt===!0&&(Y===!0||x!==M)){let Pe=x===M&&z.id===S;lt.setState(z,x,Pe)}let Kt=!1;z.version===Lt.__version?(Lt.needsLights&&Lt.lightsStateVersion!==he.state.version||Lt.outputColorSpace!==Et||N.isBatchedMesh&&Lt.batching===!1||!N.isBatchedMesh&&Lt.batching===!0||N.isBatchedMesh&&Lt.batchingColor===!0&&N.colorTexture===null||N.isBatchedMesh&&Lt.batchingColor===!1&&N.colorTexture!==null||N.isInstancedMesh&&Lt.instancing===!1||!N.isInstancedMesh&&Lt.instancing===!0||N.isSkinnedMesh&&Lt.skinning===!1||!N.isSkinnedMesh&&Lt.skinning===!0||N.isInstancedMesh&&Lt.instancingColor===!0&&N.instanceColor===null||N.isInstancedMesh&&Lt.instancingColor===!1&&N.instanceColor!==null||N.isInstancedMesh&&Lt.instancingMorph===!0&&N.morphTexture===null||N.isInstancedMesh&&Lt.instancingMorph===!1&&N.morphTexture!==null||Lt.envMap!==yt||z.fog===!0&&Lt.fog!==rt||Lt.numClippingPlanes!==void 0&&(Lt.numClippingPlanes!==lt.numPlanes||Lt.numIntersection!==lt.numIntersection)||Lt.vertexAlphas!==Ut||Lt.vertexTangents!==Ft||Lt.morphTargets!==Dt||Lt.morphNormals!==qt||Lt.morphColors!==ee||Lt.toneMapping!==me||Lt.morphTargetsCount!==ie)&&(Kt=!0):(Kt=!0,Lt.__version=z.version);let ze=Lt.currentProgram;Kt===!0&&(ze=hr(z,L,N));let Ti=!1,ke=!1,us=!1,ue=ze.getUniforms(),Ye=Lt.uniforms;if(Z.useProgram(ze.program)&&(Ti=!0,ke=!0,us=!0),z.id!==S&&(S=z.id,ke=!0),Ti||M!==x){Z.buffers.depth.getReversed()&&x.reversedDepth!==!0&&(x._reversedDepth=!0,x.updateProjectionMatrix()),ue.setValue(T,"projectionMatrix",x.projectionMatrix),ue.setValue(T,"viewMatrix",x.matrixWorldInverse);let Fe=ue.map.cameraPosition;Fe!==void 0&&Fe.setValue(T,vt.setFromMatrixPosition(x.matrixWorld)),J.logarithmicDepthBuffer&&ue.setValue(T,"logDepthBufFC",2/(Math.log(x.far+1)/Math.LN2)),(z.isMeshPhongMaterial||z.isMeshToonMaterial||z.isMeshLambertMaterial||z.isMeshBasicMaterial||z.isMeshStandardMaterial||z.isShaderMaterial)&&ue.setValue(T,"isOrthographic",x.isOrthographicCamera===!0),M!==x&&(M=x,ke=!0,us=!0)}if(N.isSkinnedMesh){ue.setOptional(T,N,"bindMatrix"),ue.setOptional(T,N,"bindMatrixInverse");let Pe=N.skeleton;Pe&&(Pe.boneTexture===null&&Pe.computeBoneTexture(),ue.setValue(T,"boneTexture",Pe.boneTexture,ht))}N.isBatchedMesh&&(ue.setOptional(T,N,"batchingTexture"),ue.setValue(T,"batchingTexture",N._matricesTexture,ht),ue.setOptional(T,N,"batchingIdTexture"),ue.setValue(T,"batchingIdTexture",N._indirectTexture,ht),ue.setOptional(T,N,"batchingColorTexture"),N._colorsTexture!==null&&ue.setValue(T,"batchingColorTexture",N._colorsTexture,ht));let Ze=B.morphAttributes;if((Ze.position!==void 0||Ze.normal!==void 0||Ze.color!==void 0)&&it.update(N,B,ze),(ke||Lt.receiveShadow!==N.receiveShadow)&&(Lt.receiveShadow=N.receiveShadow,ue.setValue(T,"receiveShadow",N.receiveShadow)),z.isMeshGouraudMaterial&&z.envMap!==null&&(Ye.envMap.value=yt,Ye.flipEnvMap.value=yt.isCubeTexture&&yt.isRenderTargetTexture===!1?-1:1),z.isMeshStandardMaterial&&z.envMap===null&&L.environment!==null&&(Ye.envMapIntensity.value=L.environmentIntensity),ke&&(ue.setValue(T,"toneMappingExposure",v.toneMappingExposure),Lt.needsLights&&pu(Ye,us),rt&&z.fog===!0&&j.refreshFogUniforms(Ye,rt),j.refreshMaterialUniforms(Ye,z,H,et,d.state.transmissionRenderTarget[x.id]),os.upload(T,jl(Lt),Ye,ht)),z.isShaderMaterial&&z.uniformsNeedUpdate===!0&&(os.upload(T,jl(Lt),Ye,ht),z.uniformsNeedUpdate=!1),z.isSpriteMaterial&&ue.setValue(T,"center",N.center),ue.setValue(T,"modelViewMatrix",N.modelViewMatrix),ue.setValue(T,"normalMatrix",N.normalMatrix),ue.setValue(T,"modelMatrix",N.matrixWorld),z.isShaderMaterial||z.isRawShaderMaterial){let Pe=z.uniformsGroups;for(let Fe=0,fa=Pe.length;Fe<fa;Fe++){let Qn=Pe[Fe];Ht.update(Qn,ze),Ht.bind(Qn,ze)}}return ze}function pu(x,L){x.ambientLightColor.needsUpdate=L,x.lightProbe.needsUpdate=L,x.directionalLights.needsUpdate=L,x.directionalLightShadows.needsUpdate=L,x.pointLights.needsUpdate=L,x.pointLightShadows.needsUpdate=L,x.spotLights.needsUpdate=L,x.spotLightShadows.needsUpdate=L,x.rectAreaLights.needsUpdate=L,x.hemisphereLights.needsUpdate=L}function mu(x){return x.isMeshLambertMaterial||x.isMeshToonMaterial||x.isMeshPhongMaterial||x.isMeshStandardMaterial||x.isShadowMaterial||x.isShaderMaterial&&x.lights===!0}this.getActiveCubeFace=function(){return A},this.getActiveMipmapLevel=function(){return I},this.getRenderTarget=function(){return U},this.setRenderTargetTextures=function(x,L,B){let z=nt.get(x);z.__autoAllocateDepthBuffer=x.resolveDepthBuffer===!1,z.__autoAllocateDepthBuffer===!1&&(z.__useRenderToTexture=!1),nt.get(x.texture).__webglTexture=L,nt.get(x.depthTexture).__webglTexture=z.__autoAllocateDepthBuffer?void 0:B,z.__hasExternalTextures=!0},this.setRenderTargetFramebuffer=function(x,L){let B=nt.get(x);B.__webglFramebuffer=L,B.__useDefaultFramebuffer=L===void 0};let gu=T.createFramebuffer();this.setRenderTarget=function(x,L=0,B=0){U=x,A=L,I=B;let z=!0,N=null,rt=!1,gt=!1;if(x){let yt=nt.get(x);if(yt.__useDefaultFramebuffer!==void 0)Z.bindFramebuffer(T.FRAMEBUFFER,null),z=!1;else if(yt.__webglFramebuffer===void 0)ht.setupRenderTarget(x);else if(yt.__hasExternalTextures)ht.rebindTextures(x,nt.get(x.texture).__webglTexture,nt.get(x.depthTexture).__webglTexture);else if(x.depthBuffer){let Dt=x.depthTexture;if(yt.__boundDepthTexture!==Dt){if(Dt!==null&&nt.has(Dt)&&(x.width!==Dt.image.width||x.height!==Dt.image.height))throw new Error("WebGLRenderTarget: Attached DepthTexture is initialized to the incorrect size.");ht.setupDepthRenderbuffer(x)}}let Ut=x.texture;(Ut.isData3DTexture||Ut.isDataArrayTexture||Ut.isCompressedArrayTexture)&&(gt=!0);let Ft=nt.get(x).__webglFramebuffer;x.isWebGLCubeRenderTarget?(Array.isArray(Ft[L])?N=Ft[L][B]:N=Ft[L],rt=!0):x.samples>0&&ht.useMultisampledRTT(x)===!1?N=nt.get(x).__webglMultisampledFramebuffer:Array.isArray(Ft)?N=Ft[B]:N=Ft,R.copy(x.viewport),O.copy(x.scissor),k=x.scissorTest}else R.copy(Mt).multiplyScalar(H).floor(),O.copy(kt).multiplyScalar(H).floor(),k=Zt;if(B!==0&&(N=gu),Z.bindFramebuffer(T.FRAMEBUFFER,N)&&z&&Z.drawBuffers(x,N),Z.viewport(R),Z.scissor(O),Z.setScissorTest(k),rt){let yt=nt.get(x.texture);T.framebufferTexture2D(T.FRAMEBUFFER,T.COLOR_ATTACHMENT0,T.TEXTURE_CUBE_MAP_POSITIVE_X+L,yt.__webglTexture,B)}else if(gt){let yt=L;for(let Ut=0;Ut<x.textures.length;Ut++){let Ft=nt.get(x.textures[Ut]);T.framebufferTextureLayer(T.FRAMEBUFFER,T.COLOR_ATTACHMENT0+Ut,Ft.__webglTexture,B,yt)}}else if(x!==null&&B!==0){let yt=nt.get(x.texture);T.framebufferTexture2D(T.FRAMEBUFFER,T.COLOR_ATTACHMENT0,T.TEXTURE_2D,yt.__webglTexture,B)}S=-1},this.readRenderTargetPixels=function(x,L,B,z,N,rt,gt,Et=0){if(!(x&&x.isWebGLRenderTarget)){console.error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not THREE.WebGLRenderTarget.");return}let yt=nt.get(x).__webglFramebuffer;if(x.isWebGLCubeRenderTarget&&gt!==void 0&&(yt=yt[gt]),yt){Z.bindFramebuffer(T.FRAMEBUFFER,yt);try{let Ut=x.textures[Et],Ft=Ut.format,Dt=Ut.type;if(!J.textureFormatReadable(Ft)){console.error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not in RGBA or implementation defined format.");return}if(!J.textureTypeReadable(Dt)){console.error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not in UnsignedByteType or implementation defined type.");return}L>=0&&L<=x.width-z&&B>=0&&B<=x.height-N&&(x.textures.length>1&&T.readBuffer(T.COLOR_ATTACHMENT0+Et),T.readPixels(L,B,z,N,It.convert(Ft),It.convert(Dt),rt))}finally{let Ut=U!==null?nt.get(U).__webglFramebuffer:null;Z.bindFramebuffer(T.FRAMEBUFFER,Ut)}}},this.readRenderTargetPixelsAsync=async function(x,L,B,z,N,rt,gt,Et=0){if(!(x&&x.isWebGLRenderTarget))throw new Error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not THREE.WebGLRenderTarget.");let yt=nt.get(x).__webglFramebuffer;if(x.isWebGLCubeRenderTarget&&gt!==void 0&&(yt=yt[gt]),yt)if(L>=0&&L<=x.width-z&&B>=0&&B<=x.height-N){Z.bindFramebuffer(T.FRAMEBUFFER,yt);let Ut=x.textures[Et],Ft=Ut.format,Dt=Ut.type;if(!J.textureFormatReadable(Ft))throw new Error("THREE.WebGLRenderer.readRenderTargetPixelsAsync: renderTarget is not in RGBA or implementation defined format.");if(!J.textureTypeReadable(Dt))throw new Error("THREE.WebGLRenderer.readRenderTargetPixelsAsync: renderTarget is not in UnsignedByteType or implementation defined type.");let qt=T.createBuffer();T.bindBuffer(T.PIXEL_PACK_BUFFER,qt),T.bufferData(T.PIXEL_PACK_BUFFER,rt.byteLength,T.STREAM_READ),x.textures.length>1&&T.readBuffer(T.COLOR_ATTACHMENT0+Et),T.readPixels(L,B,z,N,It.convert(Ft),It.convert(Dt),0);let ee=U!==null?nt.get(U).__webglFramebuffer:null;Z.bindFramebuffer(T.FRAMEBUFFER,ee);let me=T.fenceSync(T.SYNC_GPU_COMMANDS_COMPLETE,0);return T.flush(),await dh(T,me,4),T.bindBuffer(T.PIXEL_PACK_BUFFER,qt),T.getBufferSubData(T.PIXEL_PACK_BUFFER,0,rt),T.deleteBuffer(qt),T.deleteSync(me),rt}else throw new Error("THREE.WebGLRenderer.readRenderTargetPixelsAsync: requested read bounds are out of range.")},this.copyFramebufferToTexture=function(x,L=null,B=0){let z=Math.pow(2,-B),N=Math.floor(x.image.width*z),rt=Math.floor(x.image.height*z),gt=L!==null?L.x:0,Et=L!==null?L.y:0;ht.setTexture2D(x,0),T.copyTexSubImage2D(T.TEXTURE_2D,B,0,0,gt,Et,N,rt),Z.unbindTexture()};let _u=T.createFramebuffer(),xu=T.createFramebuffer();this.copyTextureToTexture=function(x,L,B=null,z=null,N=0,rt=null){rt===null&&(N!==0?(Hi("WebGLRenderer: copyTextureToTexture function signature has changed to support src and dst mipmap levels."),rt=N,N=0):rt=0);let gt,Et,yt,Ut,Ft,Dt,qt,ee,me,oe=x.isCompressedTexture?x.mipmaps[rt]:x.image;if(B!==null)gt=B.max.x-B.min.x,Et=B.max.y-B.min.y,yt=B.isBox3?B.max.z-B.min.z:1,Ut=B.min.x,Ft=B.min.y,Dt=B.isBox3?B.min.z:0;else{let Ze=Math.pow(2,-N);gt=Math.floor(oe.width*Ze),Et=Math.floor(oe.height*Ze),x.isDataArrayTexture?yt=oe.depth:x.isData3DTexture?yt=Math.floor(oe.depth*Ze):yt=1,Ut=0,Ft=0,Dt=0}z!==null?(qt=z.x,ee=z.y,me=z.z):(qt=0,ee=0,me=0);let ie=It.convert(L.format),Lt=It.convert(L.type),he;L.isData3DTexture?(ht.setTexture3D(L,0),he=T.TEXTURE_3D):L.isDataArrayTexture||L.isCompressedArrayTexture?(ht.setTexture2DArray(L,0),he=T.TEXTURE_2D_ARRAY):(ht.setTexture2D(L,0),he=T.TEXTURE_2D),T.pixelStorei(T.UNPACK_FLIP_Y_WEBGL,L.flipY),T.pixelStorei(T.UNPACK_PREMULTIPLY_ALPHA_WEBGL,L.premultiplyAlpha),T.pixelStorei(T.UNPACK_ALIGNMENT,L.unpackAlignment);let Kt=T.getParameter(T.UNPACK_ROW_LENGTH),ze=T.getParameter(T.UNPACK_IMAGE_HEIGHT),Ti=T.getParameter(T.UNPACK_SKIP_PIXELS),ke=T.getParameter(T.UNPACK_SKIP_ROWS),us=T.getParameter(T.UNPACK_SKIP_IMAGES);T.pixelStorei(T.UNPACK_ROW_LENGTH,oe.width),T.pixelStorei(T.UNPACK_IMAGE_HEIGHT,oe.height),T.pixelStorei(T.UNPACK_SKIP_PIXELS,Ut),T.pixelStorei(T.UNPACK_SKIP_ROWS,Ft),T.pixelStorei(T.UNPACK_SKIP_IMAGES,Dt);let ue=x.isDataArrayTexture||x.isData3DTexture,Ye=L.isDataArrayTexture||L.isData3DTexture;if(x.isDepthTexture){let Ze=nt.get(x),Pe=nt.get(L),Fe=nt.get(Ze.__renderTarget),fa=nt.get(Pe.__renderTarget);Z.bindFramebuffer(T.READ_FRAMEBUFFER,Fe.__webglFramebuffer),Z.bindFramebuffer(T.DRAW_FRAMEBUFFER,fa.__webglFramebuffer);for(let Qn=0;Qn<yt;Qn++)ue&&(T.framebufferTextureLayer(T.READ_FRAMEBUFFER,T.COLOR_ATTACHMENT0,nt.get(x).__webglTexture,N,Dt+Qn),T.framebufferTextureLayer(T.DRAW_FRAMEBUFFER,T.COLOR_ATTACHMENT0,nt.get(L).__webglTexture,rt,me+Qn)),T.blitFramebuffer(Ut,Ft,gt,Et,qt,ee,gt,Et,T.DEPTH_BUFFER_BIT,T.NEAREST);Z.bindFramebuffer(T.READ_FRAMEBUFFER,null),Z.bindFramebuffer(T.DRAW_FRAMEBUFFER,null)}else if(N!==0||x.isRenderTargetTexture||nt.has(x)){let Ze=nt.get(x),Pe=nt.get(L);Z.bindFramebuffer(T.READ_FRAMEBUFFER,_u),Z.bindFramebuffer(T.DRAW_FRAMEBUFFER,xu);for(let Fe=0;Fe<yt;Fe++)ue?T.framebufferTextureLayer(T.READ_FRAMEBUFFER,T.COLOR_ATTACHMENT0,Ze.__webglTexture,N,Dt+Fe):T.framebufferTexture2D(T.READ_FRAMEBUFFER,T.COLOR_ATTACHMENT0,T.TEXTURE_2D,Ze.__webglTexture,N),Ye?T.framebufferTextureLayer(T.DRAW_FRAMEBUFFER,T.COLOR_ATTACHMENT0,Pe.__webglTexture,rt,me+Fe):T.framebufferTexture2D(T.DRAW_FRAMEBUFFER,T.COLOR_ATTACHMENT0,T.TEXTURE_2D,Pe.__webglTexture,rt),N!==0?T.blitFramebuffer(Ut,Ft,gt,Et,qt,ee,gt,Et,T.COLOR_BUFFER_BIT,T.NEAREST):Ye?T.copyTexSubImage3D(he,rt,qt,ee,me+Fe,Ut,Ft,gt,Et):T.copyTexSubImage2D(he,rt,qt,ee,Ut,Ft,gt,Et);Z.bindFramebuffer(T.READ_FRAMEBUFFER,null),Z.bindFramebuffer(T.DRAW_FRAMEBUFFER,null)}else Ye?x.isDataTexture||x.isData3DTexture?T.texSubImage3D(he,rt,qt,ee,me,gt,Et,yt,ie,Lt,oe.data):L.isCompressedArrayTexture?T.compressedTexSubImage3D(he,rt,qt,ee,me,gt,Et,yt,ie,oe.data):T.texSubImage3D(he,rt,qt,ee,me,gt,Et,yt,ie,Lt,oe):x.isDataTexture?T.texSubImage2D(T.TEXTURE_2D,rt,qt,ee,gt,Et,ie,Lt,oe.data):x.isCompressedTexture?T.compressedTexSubImage2D(T.TEXTURE_2D,rt,qt,ee,oe.width,oe.height,ie,oe.data):T.texSubImage2D(T.TEXTURE_2D,rt,qt,ee,gt,Et,ie,Lt,oe);T.pixelStorei(T.UNPACK_ROW_LENGTH,Kt),T.pixelStorei(T.UNPACK_IMAGE_HEIGHT,ze),T.pixelStorei(T.UNPACK_SKIP_PIXELS,Ti),T.pixelStorei(T.UNPACK_SKIP_ROWS,ke),T.pixelStorei(T.UNPACK_SKIP_IMAGES,us),rt===0&&L.generateMipmaps&&T.generateMipmap(he),Z.unbindTexture()},this.initRenderTarget=function(x){nt.get(x).__webglFramebuffer===void 0&&ht.setupRenderTarget(x)},this.initTexture=function(x){x.isCubeTexture?ht.setTextureCube(x,0):x.isData3DTexture?ht.setTexture3D(x,0):x.isDataArrayTexture||x.isCompressedArrayTexture?ht.setTexture2DArray(x,0):ht.setTexture2D(x,0),Z.unbindTexture()},this.resetState=function(){A=0,I=0,U=null,Z.reset(),mt.reset()},typeof __THREE_DEVTOOLS__<"u"&&__THREE_DEVTOOLS__.dispatchEvent(new CustomEvent("observe",{detail:this}))}get coordinateSystem(){return sn}get outputColorSpace(){return this._outputColorSpace}set outputColorSpace(t){this._outputColorSpace=t;let e=this.getContext();e.drawingBufferColorSpace=$t._getDrawingBufferColorSpace(t),e.unpackColorSpace=$t._getUnpackColorSpace()}};var Zh={type:"change"},kl={type:"start"},$h={type:"end"},oa=new ci,Jh=new $e,g_=Math.cos(70*_l.DEG2RAD),Me=new D,Be=2*Math.PI,ne={NONE:-1,ROTATE:0,DOLLY:1,PAN:2,TOUCH_ROTATE:3,TOUCH_PAN:4,TOUCH_DOLLY_PAN:5,TOUCH_DOLLY_ROTATE:6},zl=1e-6,aa=class extends $s{constructor(t,e=null){super(t,e),this.state=ne.NONE,this.target=new D,this.cursor=new D,this.minDistance=0,this.maxDistance=1/0,this.minZoom=0,this.maxZoom=1/0,this.minTargetRadius=0,this.maxTargetRadius=1/0,this.minPolarAngle=0,this.maxPolarAngle=Math.PI,this.minAzimuthAngle=-1/0,this.maxAzimuthAngle=1/0,this.enableDamping=!1,this.dampingFactor=.05,this.enableZoom=!0,this.zoomSpeed=1,this.enableRotate=!0,this.rotateSpeed=1,this.keyRotateSpeed=1,this.enablePan=!0,this.panSpeed=1,this.screenSpacePanning=!0,this.keyPanSpeed=7,this.zoomToCursor=!1,this.autoRotate=!1,this.autoRotateSpeed=2,this.keys={LEFT:"ArrowLeft",UP:"ArrowUp",RIGHT:"ArrowRight",BOTTOM:"ArrowDown"},this.mouseButtons={LEFT:Yn.ROTATE,MIDDLE:Yn.DOLLY,RIGHT:Yn.PAN},this.touches={ONE:Zn.ROTATE,TWO:Zn.DOLLY_PAN},this.target0=this.target.clone(),this.position0=this.object.position.clone(),this.zoom0=this.object.zoom,this._domElementKeyEvents=null,this._lastPosition=new D,this._lastQuaternion=new je,this._lastTargetPosition=new D,this._quat=new je().setFromUnitVectors(t.up,new D(0,1,0)),this._quatInverse=this._quat.clone().invert(),this._spherical=new Qi,this._sphericalDelta=new Qi,this._scale=1,this._panOffset=new D,this._rotateStart=new at,this._rotateEnd=new at,this._rotateDelta=new at,this._panStart=new at,this._panEnd=new at,this._panDelta=new at,this._dollyStart=new at,this._dollyEnd=new at,this._dollyDelta=new at,this._dollyDirection=new D,this._mouse=new at,this._performCursorZoom=!1,this._pointers=[],this._pointerPositions={},this._controlActive=!1,this._onPointerMove=x_.bind(this),this._onPointerDown=__.bind(this),this._onPointerUp=y_.bind(this),this._onContextMenu=w_.bind(this),this._onMouseWheel=S_.bind(this),this._onKeyDown=b_.bind(this),this._onTouchStart=E_.bind(this),this._onTouchMove=T_.bind(this),this._onMouseDown=v_.bind(this),this._onMouseMove=M_.bind(this),this._interceptControlDown=A_.bind(this),this._interceptControlUp=C_.bind(this),this.domElement!==null&&this.connect(this.domElement),this.update()}connect(t){super.connect(t),this.domElement.addEventListener("pointerdown",this._onPointerDown),this.domElement.addEventListener("pointercancel",this._onPointerUp),this.domElement.addEventListener("contextmenu",this._onContextMenu),this.domElement.addEventListener("wheel",this._onMouseWheel,{passive:!1}),this.domElement.getRootNode().addEventListener("keydown",this._interceptControlDown,{passive:!0,capture:!0}),this.domElement.style.touchAction="none"}disconnect(){this.domElement.removeEventListener("pointerdown",this._onPointerDown),this.domElement.removeEventListener("pointermove",this._onPointerMove),this.domElement.removeEventListener("pointerup",this._onPointerUp),this.domElement.removeEventListener("pointercancel",this._onPointerUp),this.domElement.removeEventListener("wheel",this._onMouseWheel),this.domElement.removeEventListener("contextmenu",this._onContextMenu),this.stopListenToKeyEvents(),this.domElement.getRootNode().removeEventListener("keydown",this._interceptControlDown,{capture:!0}),this.domElement.style.touchAction="auto"}dispose(){this.disconnect()}getPolarAngle(){return this._spherical.phi}getAzimuthalAngle(){return this._spherical.theta}getDistance(){return this.object.position.distanceTo(this.target)}listenToKeyEvents(t){t.addEventListener("keydown",this._onKeyDown),this._domElementKeyEvents=t}stopListenToKeyEvents(){this._domElementKeyEvents!==null&&(this._domElementKeyEvents.removeEventListener("keydown",this._onKeyDown),this._domElementKeyEvents=null)}saveState(){this.target0.copy(this.target),this.position0.copy(this.object.position),this.zoom0=this.object.zoom}reset(){this.target.copy(this.target0),this.object.position.copy(this.position0),this.object.zoom=this.zoom0,this.object.updateProjectionMatrix(),this.dispatchEvent(Zh),this.update(),this.state=ne.NONE}update(t=null){let e=this.object.position;Me.copy(e).sub(this.target),Me.applyQuaternion(this._quat),this._spherical.setFromVector3(Me),this.autoRotate&&this.state===ne.NONE&&this._rotateLeft(this._getAutoRotationAngle(t)),this.enableDamping?(this._spherical.theta+=this._sphericalDelta.theta*this.dampingFactor,this._spherical.phi+=this._sphericalDelta.phi*this.dampingFactor):(this._spherical.theta+=this._sphericalDelta.theta,this._spherical.phi+=this._sphericalDelta.phi);let n=this.minAzimuthAngle,s=this.maxAzimuthAngle;isFinite(n)&&isFinite(s)&&(n<-Math.PI?n+=Be:n>Math.PI&&(n-=Be),s<-Math.PI?s+=Be:s>Math.PI&&(s-=Be),n<=s?this._spherical.theta=Math.max(n,Math.min(s,this._spherical.theta)):this._spherical.theta=this._spherical.theta>(n+s)/2?Math.max(n,this._spherical.theta):Math.min(s,this._spherical.theta)),this._spherical.phi=Math.max(this.minPolarAngle,Math.min(this.maxPolarAngle,this._spherical.phi)),this._spherical.makeSafe(),this.enableDamping===!0?this.target.addScaledVector(this._panOffset,this.dampingFactor):this.target.add(this._panOffset),this.target.sub(this.cursor),this.target.clampLength(this.minTargetRadius,this.maxTargetRadius),this.target.add(this.cursor);let r=!1;if(this.zoomToCursor&&this._performCursorZoom||this.object.isOrthographicCamera)this._spherical.radius=this._clampDistance(this._spherical.radius);else{let o=this._spherical.radius;this._spherical.radius=this._clampDistance(this._spherical.radius*this._scale),r=o!=this._spherical.radius}if(Me.setFromSpherical(this._spherical),Me.applyQuaternion(this._quatInverse),e.copy(this.target).add(Me),this.object.lookAt(this.target),this.enableDamping===!0?(this._sphericalDelta.theta*=1-this.dampingFactor,this._sphericalDelta.phi*=1-this.dampingFactor,this._panOffset.multiplyScalar(1-this.dampingFactor)):(this._sphericalDelta.set(0,0,0),this._panOffset.set(0,0,0)),this.zoomToCursor&&this._performCursorZoom){let o=null;if(this.object.isPerspectiveCamera){let a=Me.length();o=this._clampDistance(a*this._scale);let l=a-o;this.object.position.addScaledVector(this._dollyDirection,l),this.object.updateMatrixWorld(),r=!!l}else if(this.object.isOrthographicCamera){let a=new D(this._mouse.x,this._mouse.y,0);a.unproject(this.object);let l=this.object.zoom;this.object.zoom=Math.max(this.minZoom,Math.min(this.maxZoom,this.object.zoom/this._scale)),this.object.updateProjectionMatrix(),r=l!==this.object.zoom;let c=new D(this._mouse.x,this._mouse.y,0);c.unproject(this.object),this.object.position.sub(c).add(a),this.object.updateMatrixWorld(),o=Me.length()}else console.warn("WARNING: OrbitControls.js encountered an unknown camera type - zoom to cursor disabled."),this.zoomToCursor=!1;o!==null&&(this.screenSpacePanning?this.target.set(0,0,-1).transformDirection(this.object.matrix).multiplyScalar(o).add(this.object.position):(oa.origin.copy(this.object.position),oa.direction.set(0,0,-1).transformDirection(this.object.matrix),Math.abs(this.object.up.dot(oa.direction))<g_?this.object.lookAt(this.target):(Jh.setFromNormalAndCoplanarPoint(this.object.up,this.target),oa.intersectPlane(Jh,this.target))))}else if(this.object.isOrthographicCamera){let o=this.object.zoom;this.object.zoom=Math.max(this.minZoom,Math.min(this.maxZoom,this.object.zoom/this._scale)),o!==this.object.zoom&&(this.object.updateProjectionMatrix(),r=!0)}return this._scale=1,this._performCursorZoom=!1,r||this._lastPosition.distanceToSquared(this.object.position)>zl||8*(1-this._lastQuaternion.dot(this.object.quaternion))>zl||this._lastTargetPosition.distanceToSquared(this.target)>zl?(this.dispatchEvent(Zh),this._lastPosition.copy(this.object.position),this._lastQuaternion.copy(this.object.quaternion),this._lastTargetPosition.copy(this.target),!0):!1}_getAutoRotationAngle(t){return t!==null?Be/60*this.autoRotateSpeed*t:Be/60/60*this.autoRotateSpeed}_getZoomScale(t){let e=Math.abs(t*.01);return Math.pow(.95,this.zoomSpeed*e)}_rotateLeft(t){this._sphericalDelta.theta-=t}_rotateUp(t){this._sphericalDelta.phi-=t}_panLeft(t,e){Me.setFromMatrixColumn(e,0),Me.multiplyScalar(-t),this._panOffset.add(Me)}_panUp(t,e){this.screenSpacePanning===!0?Me.setFromMatrixColumn(e,1):(Me.setFromMatrixColumn(e,0),Me.crossVectors(this.object.up,Me)),Me.multiplyScalar(t),this._panOffset.add(Me)}_pan(t,e){let n=this.domElement;if(this.object.isPerspectiveCamera){let s=this.object.position;Me.copy(s).sub(this.target);let r=Me.length();r*=Math.tan(this.object.fov/2*Math.PI/180),this._panLeft(2*t*r/n.clientHeight,this.object.matrix),this._panUp(2*e*r/n.clientHeight,this.object.matrix)}else this.object.isOrthographicCamera?(this._panLeft(t*(this.object.right-this.object.left)/this.object.zoom/n.clientWidth,this.object.matrix),this._panUp(e*(this.object.top-this.object.bottom)/this.object.zoom/n.clientHeight,this.object.matrix)):(console.warn("WARNING: OrbitControls.js encountered an unknown camera type - pan disabled."),this.enablePan=!1)}_dollyOut(t){this.object.isPerspectiveCamera||this.object.isOrthographicCamera?this._scale/=t:(console.warn("WARNING: OrbitControls.js encountered an unknown camera type - dolly/zoom disabled."),this.enableZoom=!1)}_dollyIn(t){this.object.isPerspectiveCamera||this.object.isOrthographicCamera?this._scale*=t:(console.warn("WARNING: OrbitControls.js encountered an unknown camera type - dolly/zoom disabled."),this.enableZoom=!1)}_updateZoomParameters(t,e){if(!this.zoomToCursor)return;this._performCursorZoom=!0;let n=this.domElement.getBoundingClientRect(),s=t-n.left,r=e-n.top,o=n.width,a=n.height;this._mouse.x=s/o*2-1,this._mouse.y=-(r/a)*2+1,this._dollyDirection.set(this._mouse.x,this._mouse.y,1).unproject(this.object).sub(this.object.position).normalize()}_clampDistance(t){return Math.max(this.minDistance,Math.min(this.maxDistance,t))}_handleMouseDownRotate(t){this._rotateStart.set(t.clientX,t.clientY)}_handleMouseDownDolly(t){this._updateZoomParameters(t.clientX,t.clientX),this._dollyStart.set(t.clientX,t.clientY)}_handleMouseDownPan(t){this._panStart.set(t.clientX,t.clientY)}_handleMouseMoveRotate(t){this._rotateEnd.set(t.clientX,t.clientY),this._rotateDelta.subVectors(this._rotateEnd,this._rotateStart).multiplyScalar(this.rotateSpeed);let e=this.domElement;this._rotateLeft(Be*this._rotateDelta.x/e.clientHeight),this._rotateUp(Be*this._rotateDelta.y/e.clientHeight),this._rotateStart.copy(this._rotateEnd),this.update()}_handleMouseMoveDolly(t){this._dollyEnd.set(t.clientX,t.clientY),this._dollyDelta.subVectors(this._dollyEnd,this._dollyStart),this._dollyDelta.y>0?this._dollyOut(this._getZoomScale(this._dollyDelta.y)):this._dollyDelta.y<0&&this._dollyIn(this._getZoomScale(this._dollyDelta.y)),this._dollyStart.copy(this._dollyEnd),this.update()}_handleMouseMovePan(t){this._panEnd.set(t.clientX,t.clientY),this._panDelta.subVectors(this._panEnd,this._panStart).multiplyScalar(this.panSpeed),this._pan(this._panDelta.x,this._panDelta.y),this._panStart.copy(this._panEnd),this.update()}_handleMouseWheel(t){this._updateZoomParameters(t.clientX,t.clientY),t.deltaY<0?this._dollyIn(this._getZoomScale(t.deltaY)):t.deltaY>0&&this._dollyOut(this._getZoomScale(t.deltaY)),this.update()}_handleKeyDown(t){let e=!1;switch(t.code){case this.keys.UP:t.ctrlKey||t.metaKey||t.shiftKey?this.enableRotate&&this._rotateUp(Be*this.keyRotateSpeed/this.domElement.clientHeight):this.enablePan&&this._pan(0,this.keyPanSpeed),e=!0;break;case this.keys.BOTTOM:t.ctrlKey||t.metaKey||t.shiftKey?this.enableRotate&&this._rotateUp(-Be*this.keyRotateSpeed/this.domElement.clientHeight):this.enablePan&&this._pan(0,-this.keyPanSpeed),e=!0;break;case this.keys.LEFT:t.ctrlKey||t.metaKey||t.shiftKey?this.enableRotate&&this._rotateLeft(Be*this.keyRotateSpeed/this.domElement.clientHeight):this.enablePan&&this._pan(this.keyPanSpeed,0),e=!0;break;case this.keys.RIGHT:t.ctrlKey||t.metaKey||t.shiftKey?this.enableRotate&&this._rotateLeft(-Be*this.keyRotateSpeed/this.domElement.clientHeight):this.enablePan&&this._pan(-this.keyPanSpeed,0),e=!0;break}e&&(t.preventDefault(),this.update())}_handleTouchStartRotate(t){if(this._pointers.length===1)this._rotateStart.set(t.pageX,t.pageY);else{let e=this._getSecondPointerPosition(t),n=.5*(t.pageX+e.x),s=.5*(t.pageY+e.y);this._rotateStart.set(n,s)}}_handleTouchStartPan(t){if(this._pointers.length===1)this._panStart.set(t.pageX,t.pageY);else{let e=this._getSecondPointerPosition(t),n=.5*(t.pageX+e.x),s=.5*(t.pageY+e.y);this._panStart.set(n,s)}}_handleTouchStartDolly(t){let e=this._getSecondPointerPosition(t),n=t.pageX-e.x,s=t.pageY-e.y,r=Math.sqrt(n*n+s*s);this._dollyStart.set(0,r)}_handleTouchStartDollyPan(t){this.enableZoom&&this._handleTouchStartDolly(t),this.enablePan&&this._handleTouchStartPan(t)}_handleTouchStartDollyRotate(t){this.enableZoom&&this._handleTouchStartDolly(t),this.enableRotate&&this._handleTouchStartRotate(t)}_handleTouchMoveRotate(t){if(this._pointers.length==1)this._rotateEnd.set(t.pageX,t.pageY);else{let n=this._getSecondPointerPosition(t),s=.5*(t.pageX+n.x),r=.5*(t.pageY+n.y);this._rotateEnd.set(s,r)}this._rotateDelta.subVectors(this._rotateEnd,this._rotateStart).multiplyScalar(this.rotateSpeed);let e=this.domElement;this._rotateLeft(Be*this._rotateDelta.x/e.clientHeight),this._rotateUp(Be*this._rotateDelta.y/e.clientHeight),this._rotateStart.copy(this._rotateEnd)}_handleTouchMovePan(t){if(this._pointers.length===1)this._panEnd.set(t.pageX,t.pageY);else{let e=this._getSecondPointerPosition(t),n=.5*(t.pageX+e.x),s=.5*(t.pageY+e.y);this._panEnd.set(n,s)}this._panDelta.subVectors(this._panEnd,this._panStart).multiplyScalar(this.panSpeed),this._pan(this._panDelta.x,this._panDelta.y),this._panStart.copy(this._panEnd)}_handleTouchMoveDolly(t){let e=this._getSecondPointerPosition(t),n=t.pageX-e.x,s=t.pageY-e.y,r=Math.sqrt(n*n+s*s);this._dollyEnd.set(0,r),this._dollyDelta.set(0,Math.pow(this._dollyEnd.y/this._dollyStart.y,this.zoomSpeed)),this._dollyOut(this._dollyDelta.y),this._dollyStart.copy(this._dollyEnd);let o=(t.pageX+e.x)*.5,a=(t.pageY+e.y)*.5;this._updateZoomParameters(o,a)}_handleTouchMoveDollyPan(t){this.enableZoom&&this._handleTouchMoveDolly(t),this.enablePan&&this._handleTouchMovePan(t)}_handleTouchMoveDollyRotate(t){this.enableZoom&&this._handleTouchMoveDolly(t),this.enableRotate&&this._handleTouchMoveRotate(t)}_addPointer(t){this._pointers.push(t.pointerId)}_removePointer(t){delete this._pointerPositions[t.pointerId];for(let e=0;e<this._pointers.length;e++)if(this._pointers[e]==t.pointerId){this._pointers.splice(e,1);return}}_isTrackingPointer(t){for(let e=0;e<this._pointers.length;e++)if(this._pointers[e]==t.pointerId)return!0;return!1}_trackPointer(t){let e=this._pointerPositions[t.pointerId];e===void 0&&(e=new at,this._pointerPositions[t.pointerId]=e),e.set(t.pageX,t.pageY)}_getSecondPointerPosition(t){let e=t.pointerId===this._pointers[0]?this._pointers[1]:this._pointers[0];return this._pointerPositions[e]}_customWheelEvent(t){let e=t.deltaMode,n={clientX:t.clientX,clientY:t.clientY,deltaY:t.deltaY};switch(e){case 1:n.deltaY*=16;break;case 2:n.deltaY*=100;break}return t.ctrlKey&&!this._controlActive&&(n.deltaY*=10),n}};function __(i){this.enabled!==!1&&(this._pointers.length===0&&(this.domElement.setPointerCapture(i.pointerId),this.domElement.addEventListener("pointermove",this._onPointerMove),this.domElement.addEventListener("pointerup",this._onPointerUp)),!this._isTrackingPointer(i)&&(this._addPointer(i),i.pointerType==="touch"?this._onTouchStart(i):this._onMouseDown(i)))}function x_(i){this.enabled!==!1&&(i.pointerType==="touch"?this._onTouchMove(i):this._onMouseMove(i))}function y_(i){switch(this._removePointer(i),this._pointers.length){case 0:this.domElement.releasePointerCapture(i.pointerId),this.domElement.removeEventListener("pointermove",this._onPointerMove),this.domElement.removeEventListener("pointerup",this._onPointerUp),this.dispatchEvent($h),this.state=ne.NONE;break;case 1:let t=this._pointers[0],e=this._pointerPositions[t];this._onTouchStart({pointerId:t,pageX:e.x,pageY:e.y});break}}function v_(i){let t;switch(i.button){case 0:t=this.mouseButtons.LEFT;break;case 1:t=this.mouseButtons.MIDDLE;break;case 2:t=this.mouseButtons.RIGHT;break;default:t=-1}switch(t){case Yn.DOLLY:if(this.enableZoom===!1)return;this._handleMouseDownDolly(i),this.state=ne.DOLLY;break;case Yn.ROTATE:if(i.ctrlKey||i.metaKey||i.shiftKey){if(this.enablePan===!1)return;this._handleMouseDownPan(i),this.state=ne.PAN}else{if(this.enableRotate===!1)return;this._handleMouseDownRotate(i),this.state=ne.ROTATE}break;case Yn.PAN:if(i.ctrlKey||i.metaKey||i.shiftKey){if(this.enableRotate===!1)return;this._handleMouseDownRotate(i),this.state=ne.ROTATE}else{if(this.enablePan===!1)return;this._handleMouseDownPan(i),this.state=ne.PAN}break;default:this.state=ne.NONE}this.state!==ne.NONE&&this.dispatchEvent(kl)}function M_(i){switch(this.state){case ne.ROTATE:if(this.enableRotate===!1)return;this._handleMouseMoveRotate(i);break;case ne.DOLLY:if(this.enableZoom===!1)return;this._handleMouseMoveDolly(i);break;case ne.PAN:if(this.enablePan===!1)return;this._handleMouseMovePan(i);break}}function S_(i){this.enabled===!1||this.enableZoom===!1||this.state!==ne.NONE||(i.preventDefault(),this.dispatchEvent(kl),this._handleMouseWheel(this._customWheelEvent(i)),this.dispatchEvent($h))}function b_(i){this.enabled!==!1&&this._handleKeyDown(i)}function E_(i){switch(this._trackPointer(i),this._pointers.length){case 1:switch(this.touches.ONE){case Zn.ROTATE:if(this.enableRotate===!1)return;this._handleTouchStartRotate(i),this.state=ne.TOUCH_ROTATE;break;case Zn.PAN:if(this.enablePan===!1)return;this._handleTouchStartPan(i),this.state=ne.TOUCH_PAN;break;default:this.state=ne.NONE}break;case 2:switch(this.touches.TWO){case Zn.DOLLY_PAN:if(this.enableZoom===!1&&this.enablePan===!1)return;this._handleTouchStartDollyPan(i),this.state=ne.TOUCH_DOLLY_PAN;break;case Zn.DOLLY_ROTATE:if(this.enableZoom===!1&&this.enableRotate===!1)return;this._handleTouchStartDollyRotate(i),this.state=ne.TOUCH_DOLLY_ROTATE;break;default:this.state=ne.NONE}break;default:this.state=ne.NONE}this.state!==ne.NONE&&this.dispatchEvent(kl)}function T_(i){switch(this._trackPointer(i),this.state){case ne.TOUCH_ROTATE:if(this.enableRotate===!1)return;this._handleTouchMoveRotate(i),this.update();break;case ne.TOUCH_PAN:if(this.enablePan===!1)return;this._handleTouchMovePan(i),this.update();break;case ne.TOUCH_DOLLY_PAN:if(this.enableZoom===!1&&this.enablePan===!1)return;this._handleTouchMoveDollyPan(i),this.update();break;case ne.TOUCH_DOLLY_ROTATE:if(this.enableZoom===!1&&this.enableRotate===!1)return;this._handleTouchMoveDollyRotate(i),this.update();break;default:this.state=ne.NONE}}function w_(i){this.enabled!==!1&&i.preventDefault()}function A_(i){i.key==="Control"&&(this._controlActive=!0,this.domElement.getRootNode().addEventListener("keyup",this._interceptControlUp,{passive:!0,capture:!0}))}function C_(i){i.key==="Control"&&(this._controlActive=!1,this.domElement.getRootNode().removeEventListener("keyup",this._interceptControlUp,{passive:!0,capture:!0}))}var un=document.querySelector("#codesparrow-office-map"),eu=un.querySelector(".om-canvas"),R_=un.querySelector("#officeMap"),yn=document.createElement("div");yn.className="om-three";eu.prepend(yn);var or=document.createElement("div");or.className="om-three-labels";yn.append(or);var Se;try{Se=new sa({antialias:!0,alpha:!0})}catch(i){throw yn.remove(),un.querySelector(".om-hint span:last-child").textContent="3D unavailable on this browser \xB7 Top view",console.warn("3D renderer unavailable",i),i}Se.setPixelRatio(Math.min(devicePixelRatio,2));Se.shadowMap.enabled=!0;Se.shadowMap.type=ao;Se.outputColorSpace=Le;Se.toneMapping=go;Se.toneMappingExposure=1;Se.setClearColor(16054521,0);yn.prepend(Se.domElement);R_.style.visibility="hidden";var Gl=document.createElement("div");Gl.className="om-3d-legend";Gl.innerHTML='<span><i style="background:#14805d"></i>Punched</span><span><i style="background:#c94e62"></i>No punch</span><span><i style="background:#758c98"></i>Available</span>';eu.append(Gl);var bt=new Is,ge=new di(-20,20,14,-14,.1,150);ge.position.set(29,31,34);var Ne=new aa(ge,Se.domElement);Ne.target.set(0,0,0);Ne.enableDamping=!0;Ne.dampingFactor=.09;Ne.minPolarAngle=.12;Ne.maxPolarAngle=Math.PI/2.3;Ne.minZoom=.55;Ne.maxZoom=2.6;Ne.maxDistance=90;Ne.update();bt.add(new Ys(16777215,10268600,1.8));var bi=new Zs(16774889,2.5);bi.position.set(-16,28,12);bi.castShadow=!0;bi.shadow.mapSize.set(2048,2048);Object.assign(bi.shadow.camera,{left:-23,right:23,top:23,bottom:-23,near:.1,far:85});bi.shadow.normalBias=.025;bi.shadow.bias=-3e-4;bt.add(bi);var le=(i,t={})=>new Ws({color:i,roughness:.72,...t}),hs=le("#d7ba91"),xe=le("#f6f5ef"),Dn=le("#e3e9e9"),ce=le("#59696c"),Kn=le("#3c4a50"),ar=le("#278a88"),Vl=le("#d4a47e"),nu=le("#343434"),iu=le("#b6dbe0",{transparent:!0,opacity:.19,roughness:.15,metalness:.1,depthWrite:!1});function pt(i,t,e,n,s,r,o,a){let l=new we(new Wn(t,e,n),a);return l.position.set(s,r,o),l.castShadow=!0,l.receiveShadow=!0,i.add(l),l}function Pn(i,t,e,n,s,r,o,a){let l=new we(new Ls(t,e,n,16),a);return l.position.set(s,r,o),l.castShadow=!0,l.receiveShadow=!0,i.add(l),l}function Mi(i,t,e,n,s,r,o=[1,1,1]){let a=new we(new Gs(t,14,10),r);return a.position.set(e,n,s),a.scale.set(...o),a.castShadow=!0,i.add(a),a}var su=[[-16,-10],[6,-10],[6,-3],[16,-3],[16,10],[-16,10]];function ru(i,t,e){let n=new $i;su.forEach(([r,o],a)=>a?n.lineTo(r,-o):n.moveTo(r,-o)),n.closePath();let s=new we(new Hs(n,{depth:t,bevelEnabled:!1}),e);s.rotation.x=-Math.PI/2,s.position.y=i,s.receiveShadow=!0,s.castShadow=!0,bt.add(s)}ru(-.42,.42,le("#8caaae"));ru(0,.055,le("#ecebe4"));pt(bt,150,.1,150,0,-.56,0,le("#f7fafb",{toneMapped:!1}));var ou=le("#d5dbd7");for(let i=-14;i<16;i+=2){let t=i>6?-3:-10;pt(bt,.012,.005,10-t,i,.061,(10+t)/2,ou)}for(let i=-8;i<10;i+=2){let t=i<-3?6:16;pt(bt,t+16,.005,.012,(t-16)/2,.061,i,ou)}pt(bt,22,3.4,.2,-5,1.7,-10,Dn);pt(bt,.2,3.4,20,-16,1.7,0,Dn);pt(bt,10,3.4,.2,11,1.7,-3,Dn);pt(bt,22,.12,.28,-5,3.46,-10,xe);pt(bt,.28,.12,20,-16,3.46,0,xe);pt(bt,10,.12,.28,11,3.46,-3,xe);pt(bt,.2,3.4,1.8,6,1.7,-9.1,Dn);pt(bt,.2,3.4,1,6,1.7,-3.5,Dn);pt(bt,32,.16,.16,0,.14,10,xe);pt(bt,.16,.16,13,16,.14,3.5,xe);function Wl(i,t,e){pt(bt,e,1.9,.06,i,2,t,le("#e1eff1",{roughness:.25}));for(let n of[-e/2,0,e/2])pt(bt,.055,2,.09,i+n,2,t+.06,ce);pt(bt,e,.065,.09,i,1,t+.06,ce),pt(bt,e,.065,.09,i,3,t+.06,ce)}for(let i of[-12,-7,-2,3])Wl(i,-9.86,3.7);Wl(8.8,-2.86,3.2);Wl(13.3,-2.86,3.2);pt(bt,.75,.035,3.7,5.7,.09,-6.1,le("#d2e1df"));pt(bt,1.25,.025,2.5,4.8,.095,-6.1,ar);var Ei=new Te;Ei.position.set(6,0,-7.8);Ei.rotation.y=-.62;bt.add(Ei);pt(Ei,.045,2.8,3.3,0,1.4,1.65,iu);pt(Ei,.07,.06,3.3,0,2.83,1.65,ce);pt(Ei,.07,2.85,.06,0,1.42,3.3,ce);pt(Ei,.12,.42,.06,-.12,1.3,2.9,ce);function ca(i,t,e,n="x"){let s=new Te;s.position.set(i,0,t),n==="z"&&(s.rotation.y=Math.PI/2),bt.add(s),pt(s,e,2.6,.045,0,1.35,0,iu),pt(s,e,.055,.07,0,2.66,0,ce),pt(s,e,.06,.07,0,.07,0,ce);for(let r=-e/2;r<=e/2+.01;r+=e/Math.ceil(e/2.8))pt(s,.04,2.65,.07,r,1.35,0,ce);return s}ca(-11,-3,10);ca(-6,-7.7,4.6,"z");ca(-6,7.2,5.6,"z");ca(6,4.5,11,"z");pt(bt,.16,1.75,4,0,.9,8,Dn);pt(bt,4.2,1.75,.16,2.1,.9,6,Dn);pt(bt,6,.3,.16,3,.2,10,Dn);pt(bt,.16,1.75,4,6,.9,8,Dn);pt(bt,1.8,.05,.13,5.1,2.35,6,xe);pt(bt,.1,2.3,.1,4.25,1.2,6,xe);pt(bt,.1,2.3,.1,5.95,1.2,6,xe);function I_(i,t,e=1){let n=new Te;bt.add(n),n.position.set(i,0,t),n.scale.setScalar(e),Pn(n,.32,.23,.55,0,.33,0,xe),Pn(n,.28,.28,.035,0,.61,0,le("#716149"));for(let s=0;s<9;s++){let r=s*2.4,o=.18+s%3*.13,a=Mi(n,.28,Math.cos(r)*o,1+s%4*.14,Math.sin(r)*o,le(s%2?"#799665":"#4d7858"),[.6,1.8,.5]);a.rotation.z=Math.cos(r)*.55}return n}for(let[i,t,e]of[[-14.8,-8.6,1],[-5,-9,1],[4.8,-3.4,.85],[-14.8,9,1],[14.8,8.8,1],[14.8,-1.9,.85]])I_(i,t,e);function ha(i,t,e,n=0){let s=new Te;s.position.set(t,0,e),s.rotation.y=n,i.add(s),Pn(s,.055,.055,.65,0,.37,0,ce);for(let r=0;r<5;r++){let o=r*Math.PI*2/5,a=pt(s,.06,.05,.6,Math.sin(o)*.25,.15,Math.cos(o)*.25,ce);a.rotation.y=o,Mi(s,.065,Math.sin(o)*.51,.09,Math.cos(o)*.51,Kn)}pt(s,.76,.14,.67,0,.78,0,Kn),pt(s,.73,.78,.13,0,1.2,.31,Kn);for(let r of[-.4,.4])pt(s,.055,.37,.055,r,.95,0,ce),pt(s,.11,.065,.49,r,1.14,0,Kn);return s}var cs=new Te;bt.add(cs);var Xl=[],Kh=[],la=[],Hl=[[-13.3,-.8],[-9.2,-.8],[-13.3,2.1],[-9.2,2.1],[-13.3,5],[-9.2,5],[-13.3,7.9],[-9.2,7.9],[8.8,-.2],[12.9,-.2],[8.8,3.4],[12.9,3.4],[8.8,7],[12.9,7],[1,3.7],[4.1,3.7]];function au(i,t,e,n=!1){if(pt(i,.12,.4,.12,t,1.64,e,ce),pt(i,.58,.04,.3,t,1.43,e,ce),pt(i,1.1,.73,.1,t,2,e,Kn),pt(i,.99,.61,.012,t,2,e+.06,le(n?"#5b8994":"#293c43",{emissive:n?"#315561":"#000000",emissiveIntensity:.3})),n)for(let s=0;s<4;s++)pt(i,.48+s%2*.27,.019,.016,t-.08,2.18-s*.1,e+.074,le("#b7d8d2"))}function lu(i,t=2.8){pt(i,t,.12,1.35,0,1.35,0,hs);for(let e of[-t/2+.12,t/2-.12])for(let n of[-.52,.52])pt(i,.065,1.3,.065,e,.65,n,ce);pt(i,t-.2,.12,.08,0,.75,-.5,ce)}function P_(i,gender){let t=new Te,f=gender==="female",shirt=f?le("#8b658d"):ar;i.add(t),t.position.set(0,0,1.06),pt(t,f?.54:.6,.7,.35,0,1.23,0,shirt),pt(t,.49,.16,.52,0,.84,-.16,Kn),f&&Mi(t,.235,0,1.78,.17,nu,[1,1.5,1]),Mi(t,.235,0,1.88,-.06,Vl,[1,1.15,1]),Mi(t,.24,0,1.98,-.1,nu,[1,.72,1]);if(f){for(let side of[-.2,.2])Mi(t,.09,side,1.68,.02,nu,[.8,1.85,1]);Mi(t,.12,.18,1.84,.25,nu,[1,1.35,1])}let e=[];for(let n of[-.37,.37]){let s=pt(t,.17,.16,.65,n,1.32,-.36,shirt);s.rotation.x=-.2,e.push(s),Mi(t,.1,n,1.36,-.74,Vl)}Xl.push({p:t,arms:e,seed:Math.random()*6})}function D_(i){i.traverse(t=>{t.geometry?.dispose(),t.material&&![hs,xe,ce,Kn,ar,Vl,nu].includes(t.material)&&t.material.dispose()})}function ql(){for(;cs.children.length;){let i=cs.children[0];D_(i),cs.remove(i)}or.replaceChildren(),Xl=[],Kh=[],la=[],window.OfficeMap.getData().forEach((i,t)=>{let e=new Te;e.position.set(Hl[t][0],0,Hl[t][1]),e.userData.deskId=i.id,cs.add(e),lu(e),au(e,0,-.35,i.status==="present"),pt(e,.75,.045,.27,0,1.45,.34,le("#d2d8d6")),Mi(e,.09,.65,1.46,.35,xe,[.7,.35,1]),Pn(e,.09,.08,.18,-1,1.49,.25,xe),ha(e,0,1.06);if(i.status!=="present"){let c=i.status==="absent"?"#c94e62":"#8595a2";Mi(e,1.6,0,.071,.45,le(c,{transparent:!0,opacity:.08,depthWrite:!1}),[1,.008,.9]).castShadow=!1;Mi(e,1.15,0,.078,.45,le(c,{transparent:!0,opacity:.15,depthWrite:!1}),[1,.009,1]).castShadow=!1}i.status==="present"&&P_(e,i.gender);let n=pt(e,2.95,.02,2.8,0,.086,.45,le("#4cb9be",{transparent:!0,opacity:0}));e.userData.highlight=n,Kh.push(e);let s=document.createElement("button");s.className="om-world-label "+i.status;let r=document.createElement("i"),o=document.createElement("span");o.textContent=i.name?i.name.split(" ")[0]:"Available";let badge=document.createElement("small");badge.className="om-seat-id";badge.textContent=i.id;s.append(r,o,badge),s.title=i.id+" \xB7 "+{present:"Punched today",absent:"No punch",free:"Not allocated"}[i.status],s.setAttribute("aria-label",s.title+" \xB7 "+(i.name||"Available")),s.onclick=()=>cu(i.id),or.append(s),la.push({el:s,position:new D(e.position.x,2.8,e.position.z),g:e})});for(let[i,t,e]of[["OWNER CABIN",-11,-9.5],["SOFA / LIVING",-.8,-10],["MAIN GATE",6.7,-6.2],["IT \xB7 8 DESKS",-11.5,-2.8],["SEO \xB7 6 DESKS",11,-2.6],["KITCHEN",-3.5,5],["CALLING \xB7 2 DESKS",2.55,2.1],["WASHROOM",3,6.7]]){let n=document.createElement("span");n.className="om-room-label",n.textContent=i,or.append(n),la.push({el:n,position:new D(t,/DESKS/.test(i)?3.1:.6,e)})}}function cu(i){un.querySelector(`#seats .seat[data-id="${i}"]`)?.dispatchEvent(new MouseEvent("click",{bubbles:!0}))}var lr=new Te;lr.position.set(-11,0,-7);bt.add(lr);lu(lr,3.8);au(lr,0,-.35,!0);ha(lr,0,1.1);ha(bt,-12,-4.5,Math.PI);ha(bt,-10,-4.5,Math.PI);pt(bt,6,1.05,.65,-11,.58,-9.35,hs);pt(bt,6.1,.08,.7,-11,1.15,-9.35,xe);var Yl=le("#839c99"),jh=le("#a8bcba"),Si=new Te;Si.position.set(-.8,0,-8.6);bt.add(Si);pt(Si,5.3,.35,1.25,0,.38,0,Yl);pt(Si,5.3,1.1,.23,0,.97,-.53,Yl);for(let i of[-2.5,2.5])pt(Si,.26,.7,1.4,i,.72,0,Yl);for(let i of[-1.6,0,1.6])pt(Si,1.47,.2,1.1,i,.65,.05,jh),pt(Si,1.47,.55,.2,i,1.03,-.36,jh);pt(bt,5.5,.025,3.5,-.8,.08,-6.8,le("#d8e2df"));pt(bt,2.5,.12,1.25,-.8,.68,-6.3,hs);for(let i of[-1.8,.2])for(let t of[-6.75,-5.85])pt(bt,.06,.6,.06,i,.35,t,ce);Pn(bt,.16,.16,.03,-.4,.765,-6.3,xe);pt(bt,.6,.035,.42,-1.25,.765,-6.3,ar);pt(bt,4.2,1.05,.9,-3.5,.58,9.1,hs);pt(bt,4.4,.12,1,-3.5,1.17,9.1,xe);pt(bt,.9,.04,.6,-3.6,1.25,9.1,ce);Pn(bt,.025,.025,.4,-3.6,1.45,9.3,ce);pt(bt,.26,.05,.05,-3.5,1.66,9.3,ce);pt(bt,.5,.5,.45,-1.9,1.48,9.1,Kn);pt(bt,1.05,2,.9,-5.15,1.07,6.3,xe);pt(bt,.05,.45,.07,-4.75,1.5,6.8,ce);pt(bt,.9,.75,.25,1.3,.72,9.5,xe);Mi(bt,.48,1.3,.46,9,xe,[.85,.7,1.25]);Pn(bt,.3,.2,.48,1.3,.3,9,xe);var L_=Pn(bt,.37,.37,.08,1.3,.7,9,le("#d7e2e2"));L_.scale.z=1.25;pt(bt,1.5,.15,.7,4.5,.95,9.25,xe);pt(bt,1.2,.65,.6,4.5,.55,9.25,hs);pt(bt,.8,.05,.4,4.5,1.05,9.25,ce);Pn(bt,.024,.024,.28,4.5,1.18,9.5,ce);var hn=!1,hu=!0,ls=null,rr=null,Qh=new Js,tu=new at;function uu(i){let t=Se.domElement.getBoundingClientRect();tu.set((i.clientX-t.left)/t.width*2-1,-(i.clientY-t.top)/t.height*2+1),Qh.setFromCamera(tu,ge);let e=Qh.intersectObjects(cs.children,!0);if(!e.length)return null;let n=e[0].object;for(;n&&!n.userData.deskId;)n=n.parent;return n}Se.domElement.addEventListener("pointerdown",i=>{rr=[i.clientX,i.clientY]});Se.domElement.addEventListener("pointerup",i=>{if(rr&&Math.hypot(i.clientX-rr[0],i.clientY-rr[1])<5){let t=uu(i);t&&cu(t.userData.deskId)}rr=null});Se.domElement.addEventListener("pointermove",i=>{ls&&(ls.userData.highlight.material.opacity=0),ls=uu(i),ls&&(ls.userData.highlight.material.opacity=.12),Se.domElement.style.cursor=ls?"pointer":"grab"});function du(){let i=yn.clientWidth,t=yn.clientHeight;Se.setSize(i,t);let e=i/t,n=Math.max(15,19/e);ge.left=-n*e,ge.right=n*e,ge.top=n,ge.bottom=-n,ge.updateProjectionMatrix()}new ResizeObserver(du).observe(yn);function ua(){Ne.target.set(0,0,0),ge.position.set(...hn?[0,48,.001]:[26,34,34]),ge.zoom=1,ge.updateProjectionMatrix(),Ne.update()}for(let[i,t]of[["zoomIn",()=>{ge.zoom=Math.min(2.6,ge.zoom*1.15),ge.updateProjectionMatrix()}],["zoomOut",()=>{ge.zoom=Math.max(.55,ge.zoom/1.15),ge.updateProjectionMatrix()}],["fitBtn",ua]])un.querySelector("#"+i).addEventListener("click",e=>{hu&&(e.stopImmediatePropagation(),t())},!0);var sr=un.querySelector("#viewToggle");sr.addEventListener("click",i=>{i.stopImmediatePropagation(),hn=!hn,sr.textContent=hn?"2D":"3D",sr.setAttribute("aria-pressed",String(!hn)),sr.setAttribute("aria-label",hn?"Switch to 3D view":"Switch to top view"),sr.title=hn?"Switch to 3D view":"Switch to top view",Ne.enableRotate=!hn,Ne.minPolarAngle=hn?0:.12,ua(),un.querySelector(".om-hint span:last-child").textContent=hn?"Top view \xB7 Drag to pan \xB7 Scroll to zoom":"Drag to rotate \xB7 Scroll to zoom \xB7 Click a desk"},!0);var U_=new MutationObserver(ql);U_.observe(un.querySelector("#seats"),{childList:!0});ql();du();ua();un.querySelector(".om-hint span:last-child").textContent="Drag to rotate \xB7 Scroll to zoom \xB7 Click a desk";Se.setAnimationLoop(i=>{if(!hu||document.hidden)return;if(Ne.update(),!matchMedia("(prefers-reduced-motion: reduce)").matches&&un.querySelector("#motionToggle").getAttribute("aria-pressed")==="false")for(let{p:s,arms:r,seed:o}of Xl)s.rotation.y=Math.sin(i*.0015+o)*.035,r.forEach((a,l)=>a.rotation.x=-.2+Math.sin(i*.011+o+l*2)*.085);Se.render(bt,ge);let e=yn.clientWidth,n=yn.clientHeight;for(let{el:s,position:r}of la){let o=r.clone().project(ge);s.style.transform=`translate(-50%,-50%) translate(${(o.x*.5+.5)*e}px,${(-o.y*.5+.5)*n}px)`,s.hidden=Math.abs(o.x)>1||Math.abs(o.y)>1}un.querySelector("#zoomLabel").textContent=Math.round(ge.zoom*100)+"%"});window.Office3D={renderer:Se,scene:bt,camera:ge,controls:Ne,fit:ua,sync:ql,layout:{outline:su,locations:Hl},get topView(){return hn}};})();
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
